$(document).ready(function(){
$.showLoading('数据加载中');
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
$(".imgback").click(function(){
	window.history.go(-1);
})
var phone=getlocalStorage("phone");
var ajaxurl="http://tianyangweilan.shoufangpai.com";
if(phone==null||phone=="null"||phone==undefined||phone=="undefined"||phone==''){
	window.location.href="pre.html";
}
pageinit();
function pageinit(){
   var phone=getlocalStorage("phone");
   $.ajax({
			type:"post",
		url:ajaxurl+"/api/getImg",
		data:{
			"phone":phone
		},
		success:function(obj){
			console.log(obj)
			if(obj.code=="200"){
				makeimg(obj);
			}else{
				$.alert(obj.msg,function(){
					if(obj.msg=='登录失效,请重新登录'){
						window.history.go(-1);
					}else{
						window.location.href='index.html';
					}
				});
			}
		},
		error: function(jqXHR, textStatus, errorThrown) {
			$.hideLoading();
			$.alert("请检查您的网络，稍后再试！")
		}
	});
}		
function makeimg(obj){
	
	 var imgw = document.createElement("img");
	 imgw.src='img/imgbg.png';	
	 imgw.onload=function(){
	 	var can = document.getElementById("can");
        var cans = can.getContext('2d');
		// 将 img1 加入画布
		cans.drawImage(imgw,0,0,750,1234);
		var cname=obj.data.name;
		cans.fillStyle='#333';
        cans.font="22px Arial";
        cans.fillText(cname,274,339);
        
        var idCard=obj.data.idCard;
		cans.fillStyle='#333';
        cans.font="22px Arial";
        cans.fillText(idCard,274,376);
        
        var registration=obj.data.registration;
		cans.fillStyle='#333';
        cans.font="22px Arial";
        cans.fillText(registration,288,410);
        
		$("#can").hide();
		var c = document.getElementById('can');
        var d=c.toDataURL("image/jpg");
        $("#canimg").attr("src",d);
        $.hideLoading();
	 }
}		
})
