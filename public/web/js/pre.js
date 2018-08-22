$(document).ready(function(){
$("#usercode").val("");
$(".weui-check").prop('checked',false);
var phone=getlocalStorage("phone");
var ajaxurl="http://tianyangweilan.shoufangpai.com";
var strUrl=window.location.href;
var arrUrl=strUrl.split("?");
var strPage1=arrUrl[0];
var arrUrl=strPage1.split("/");
var strPage=arrUrl[arrUrl.length-1];
if(phone==null||phone=="null"||phone==undefined||phone=="undefined"){
	if(strPage!="pre.html"){
		window.location.href="home.html";
	}
}
$('#userphone').bind('input propertychange', function() {
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
});
$('#usercode').bind('input propertychange', function() {
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


var times=0;
$(".getcodebtn").click(function(){
	    
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
	var posturl="http://tianyangweilan.shoufangpai.com";;
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
	function time60() {
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
$(".pagepre").on('click', ".btnok", function(){
//	alert(130)
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
    var posturl="http://tianyangweilan.shoufangpai.com";
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
					if(obj.status=='不跳'){
						window.location.replace("pre1.html");
					}else{
						window.location.replace("showdata.html");
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

var strUrl=window.location.href;
var arrUrl=strUrl.split("?");
var strPage1=arrUrl[0];
var arrUrl=strPage1.split("/");
var strPage=arrUrl[arrUrl.length-1];

var posturl="http://tianyangweilan.shoufangpai.com";
var phone=getlocalStorage("phone");
var data1={
	"phone":phone
}
if(strPage=="pre.html"){
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
				$(".pre1 .content").html(obj.data.registration_notes)
				$(".pre2 .content").html(obj.data.frozen)
				$(".pre3 .content").html(obj.data.notice)
				if(strPage!="pre.html"){
					$(".pre3").attr("status",obj.data.status);
				}
				$(".pagepreicon").attr("src",obj.data.img);
				
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
function getlocalStorage(name){ 
if(typeof localStorage === 'object'){
    try {
      return  window.localStorage.getItem(name);
    }catch(e){
       return getCookie(name);
    }
}
}
function getCookie(name)//取cookies值
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
	
})
