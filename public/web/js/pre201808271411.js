$(document).ready(function(){
var setlocalStorage=function(name, val){ 
    if(arguments.length>1){//判断接受的参数值是不是两个
        try{
            localStorage.setItem(name, val);
        }catch(e){
            setCookie(name,val,'d365');//抛出异常使用cookie存储
        }
    }else{
        var dataStr='';
        try{
            localStorage.setItem(name, 'test');//判断是否支持存储
            dataStr =localStorage.getItem(name);
        }catch(e){
            dataStr = getCookie(name)//同样抛出异常我们使用cookie去取值
        }
        if(dataStr=='test'){
        	 return "支持localStorage setItem getItem";
        }else{
        	 return "不支持localStorage";
        }
    }
}
var getlocalStorage=function(name){ 
	if(typeof localStorage === 'object'){
	    try {
	      return  window.localStorage.getItem(name);
	    }catch(e){
	       return getCookie(name);
	    }
	}
}
var getCookie=function(name)//取cookies值
{
    var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
    if(arr=document.cookie.match(reg)){
        if(!arr[2]){
             return null ;
        }else if(arr[2] !='null'){
             return unescape(arr[2]) ;
        }else{
             return null ;
        };
    }else{
        return null;
    }
}
//存储Cookie
var setCookie=function(name, value, time){
    var strsec = getsec(time);
    var exp = new Date();
    exp.setTime(exp.getTime() + strsec * 1);
    document.cookie = name + "=" + escape(value) + ";expires=" + exp.toGMTString()+";path=/";
}
var  getsec=function(str) {
    var str1 = str.substring(1, str.length) * 1;
    var str2 = str.substring(0, 1);
    if (str2 == "s") {
        return str1 * 1000;
    } else if (str2 == "h") {
        return str1 * 60 * 60 * 1000;
    } else if (str2 == "d") {
        return str1 * 24 * 60 * 60 * 1000;
    }
}
var clearStorage=function(name){    // 清除存储
    if(!name) { return false;}
    try{
        localStorage.setItem('cookieTest', 'test');//正常清除
        localStorage.removeItem(name);
    }catch(e){
        document.cookie = name + "=" + null + ";expires=" + 0+";path=/";//抛出异常，存储到了cookie，因此清除cookie。
    }
}

var times=0;//倒计时
var phone=getlocalStorage("phone");
var ajaxurl="http://tianyangweilan.shoufangpai.com";
var strUrl=window.location.href;
var arrUrl=strUrl.split("?");
var strPage1=arrUrl[0];
var arrUrl=strPage1.split("/");
var strPage=arrUrl[arrUrl.length-1];
if(phone==null||phone=="null"||phone==undefined||phone=="undefined"||phone==""){//判断登录
	if(strPage!="pre.html"){
		window.location.href="pre.html";
		return;
	}
}
if(strPage=="pre.html"){//初始化页面
	$("#usercode").val("");
	$("#userphone").val("");
	$(".getcodebtn").addClass('postcodebg')
}else{
	$(".weui-check").prop('checked',false);	
}
pageinit()
function pageinit(){//入口文件
//获取登录页的数据缓存
	var registration_notes=getlocalStorage("registration_notes");
	if(strPage=="pre1.html"){
		$(".pre1 .content").html(registration_notes);
	}
	var frozen=getlocalStorage("frozen");
	if(strPage=="pre2.html"){
		$(".pre2 .content").html(frozen);
	}
	var notice=getlocalStorage("notice");
	if(strPage=="pre3.html"){
		$(".pre3 .content").html(notice);
	}		

//获取登录页的数据缓存结束
	var posturl=ajaxurl;
	var data1={
		"phone":phone
	}
	if(strPage=="pre.html"){//登录页无phone
		data1={}
	}
	$.ajax({
			url:posturl+"/api/config",
			type:"post",
			async:false,
			data:data1,
			success:function(obj){
				console.log(obj)
				if(obj.code==200){
					setlocalStorage("registration_notes",obj.data.registration_notes);
					setlocalStorage("frozen",obj.data.frozen);
					setlocalStorage("notice",obj.data.notice);
					if(strPage=="pre.html"){
						$(".pagepreicon").attr("src",obj.data.img);
						$('title').html(obj.data.project_name+'线上登记')
					}
					if(strPage=="pre1.html"){
						$(".pre1 .content").html(obj.data.registration_notes)
					}
					if(strPage=="pre2.html"){
						$(".pre2 .content").html(obj.data.frozen)
					}
					if(strPage=="pre3.html"){
						$(".pre3 .content").html(obj.data.notice)
						$(".pre3").attr("status",obj.data.status);
					}
				}else{
					 $.alert(obj.msg,function(){
						if(strPage!="pre.html"&&obj.msg=='登录失效,请重新登录'){
							var v=Math.random();
						    window.location.href="pre.html?v="+v;
					     }
					})
				}
			},
			error:function(){
				$(".pagepre .btn").addClass("btnok");
	            $.alert("请检查您的网络，稍后再试！","提示",function(){
	            	console.log('掉接口失败')
	            })
			}
	});	
}
$('#userphone').bind('input propertychange', function() {//手机号码输入
	    var phone = $('#userphone').val();
		if(phone){
			phone = phone.replace(/\s/g, "");
			$(".pagepre .btn").removeClass("btnok");
		}
		if(phone.length != 11) {
			$(".getcodebtn").addClass('postcodebg')
			$(".pagepre .btn").removeClass("btnok");
			return
		}
		if(!(/^1[3|4|5|7|8|6|9][0-9]\d{4,8}$/.test(phone))) {
			$(".pagepre .btn").removeClass("btnok");
			$(".getcodebtn").addClass('postcodebg')
			return
		}
		if(times==0){
			$(".getcodebtn").removeClass('postcodebg');
		}
});
$('#usercode').bind('input propertychange', function(){//验证码输入
	    var phone = $('#userphone').val();
		if(phone) {
			phone = phone.replace(/\s/g, "");
			$(".pagepre .btn").removeClass("btnok");
		}
		if(phone.length != 11) {
			$(".pagepre .btn").removeClass("btnok");
			return
		}
		if(!(/^1[3|4|5|7|8|6|9][0-9]\d{4,8}$/.test(phone))) {
			$(".pagepre .btn").removeClass("btnok");
			return
		}
	    var phone = $('#usercode').val();
		if(phone=="") {
			$(".pagepre .btn").removeClass("btnok");
		}else{
			phone = phone.replace(/\s/g, "");
		}
		if(phone.length!= 4) {
			$(".pagepre .btn").removeClass("btnok");
			return
		}
		$(".pagepre .btn").addClass("btnok");
});

$(".getcodebtn").click(function(){//点击验证码
		if(times!=0){
			return;
		}
	    var phone = $('#userphone').val();
	    console.log(phone);
		if(phone==""){
			$.alert("请输入有效手机号码");
			$(".pagepre .btn").removeClass("btnok");
			return;
		}else{
			phone = phone.replace(/\s/g, "");
		}
		console.log(phone);
		if(phone.length != 11) {
			$.alert("请输入11位有效手机号码");
			$(".pagepre .btn").removeClass("btnok");
			return
		}
		console.log(phone);
		if(!(/^1[3|4|5|7|8|6|9][0-9]\d{4,8}$/.test(phone))) {
			$.alert("请输入有效手机号码");
			$(".pagepre .btn").removeClass("btnok");
			return
		}
	var posturl=ajaxurl;
	$.ajax({
		url:posturl+"/api/send",
		type:"post",
		async:false,
		data:{
			"phone":phone
		},
		success:function(obj){
			if(obj.code==200){
				times=60;
				time60();
				$(".getcodebtn").addClass("postcodebg");
				$('.getcodebtn').html(times + '秒后获取')
				$.toast("发送成功", 1200);
			}else{
				$.alert(obj.msg)
			}
		},
		error:function(){
            $.alert("请检查您的网络，稍后再试！","提示",function(){
            	
            })
		}
	});	
})
function time60() {//60秒倒计时
	setTimeout(function() {
		times=times-1;
		if(times >0) {
			time60();
			$(".getcodebtn").addClass("postcodebg");
			$('.getcodebtn').html(times + '秒后获取')
		}else{
			times = 0;
			console.log(223)
			$(".getcodebtn").removeClass("postcodebg");
			$('.getcodebtn').html('发送验证码')
		}
	}, 1000)
}
$(".pagepre").on('click', ".btnok", function(){//点击提交
        var phone = $('#userphone').val();
		if(phone){
			phone = phone.replace(/\s/g, "");
			$(".pagepre .btn").removeClass("btnok");
		}
		if(phone.length != 11) {
			$(".pagepre .btn").removeClass("btnok");
			return
		}
		if(!(/^1[3|4|5|7|8|6|9][0-9]\d{4,8}$/.test(phone))) {
			
			$(".pagepre .btn").removeClass("btnok");
			return
		}
	    var code = $('#usercode').val();
		if(code=="") {
			$(".pagepre .btn").removeClass("btnok");
		}else{
			code = code.replace(/\s/g, "");
		}
		if(code.length!= 4) {
			$.alert("请输入4位验证码");
			$(".pagepre .btn").removeClass("btnok");
			return
		}
    var posturl=ajaxurl;
    $(".pagepre .btn").removeClass("btnok");
    var sign=md5(phone+code);
    console.log(sign)
    setlocalStorage("phone",sign)
	$.ajax({
		url:posturl+"/api/check",
		type:"post",
		async:false,
		data:{
			"phone":phone,
			"code":code,
			"sign":sign
		},
		success:function(obj){
			console.log(obj)
			if(obj.code==200){
				console.log(obj)
				$.toast("登录成功", 1200,function(){
					var v=Math.random();
					if(obj.status=='不跳'){
						window.location.replace("pre1.html?v="+v);
					}else{
						window.location.replace("showdata.html?v="+v);
					}
				});
			}else{
				 $.alert(obj.msg,"提示",function(){})
			}
		},
		error:function(){
			$(".pagepre .btn").addClass("btnok");
            $.alert("请检查您的网络，稍后再试！","提示",function(){
            	
            })
		}
	});	
})		
})
