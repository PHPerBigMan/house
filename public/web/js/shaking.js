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
console.log('未登录');
}

$(".btn").click(function(){
	    var username=$("#username").val();
	    if(username==''){
	    	$.alert("请输入您的报名序号",'售房派');
			return
	    }
	    if(username.length<3){
	    	$.alert("您的报名序号过短",'售房派');
			return
	    }
        var phone = $('#userphone').val();
		if(phone==''){
			phone = phone.replace(/\s/g, "");
			$.alert("请输入手机号码",'售房派');
			return
		}
		if(phone.length!= 11) {
		    $.alert("手机号码不是11位",'售房派');
			return
		}
		if(!(/^1[3|4|5|7|8|6|9][0-9]\d{4,8}$/.test(phone))) {
			 $.alert("手机号码无效",'售房派');
			return
		}
    var posturl="http://tianyangweilan.shoufangpai.com";;
	$.ajax({
		url:posturl+"/api/result",
		type:"post",
		async:false,
		data:{
			"phone":phone,
			"registration":username
		},
		success:function(obj){
			if(obj.code==200){
					window.location.replace("shakresult.html?name="+escape(obj.name)+'&result='+escape(obj.result));
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
$.ajax({
		url:posturl+"/api/config",
		type:"post",
		async:false,
		data:{},
		success:function(obj){
			console.log(obj)
			if(obj.code==200){
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


function setlocalStorage(name, val){ 
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
function setCookie(name, value, time){
    var strsec = getsec(time);
    var exp = new Date();
    exp.setTime(exp.getTime() + strsec * 1);
    document.cookie = name + "=" + escape(value) + ";expires=" + exp.toGMTString()+";path=/";
}
function getsec(str) {
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
function clearStorage(name){    // 清除存储
    if(!name) { return false;}
    try{
        localStorage.setItem('cookieTest', 'test');//正常清除
        localStorage.removeItem(name);
    }catch(e){
        document.cookie = name + "=" + null + ";expires=" + 0+";path=/";//抛出异常，存储到了cookie，因此清除cookie。
    }

}
	
})
