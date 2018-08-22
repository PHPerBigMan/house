$(document).ready(function(){
function getUrlParms(name){//获取url信息
   var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
   var r = window.location.search.substr(1).match(reg);
   if(r!=null)
   return unescape(r[2]);
   return null;
}


var name=getUrlParms("name");
var result=getUrlParms("result");
if(name==null||name=="null"||name==undefined||name=="undefined"||result==null||result=="null"||result==undefined||result=="undefined"){
$.alert("非法进入",'售房派',function(){
	window.location.href="home.html";
})
}
var msg=""; 
var imgsrc='';
console.log(result)
if(result=='未中签'){
	msg=unescape(name)+',很遗憾!您未摇到号';
	imgsrc='img/fail.png';
	$(".pfont").addClass("pfont2")
}else{
	imgsrc='img/ok.png';
	msg=unescape(name)+',恭喜您!您已成功摇到号,请尽快联系销售顾问';
	$(".pfont").addClass("pfont1")
}
$(".okimg").attr('src',imgsrc)
$(".pfont").html(msg)

})
