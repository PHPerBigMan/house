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
var phone=getlocalStorage("phone");
var ajaxurl="http://tianyangweilan.shoufangpai.com";
if(phone==null||phone=="null"||phone==undefined||phone=="undefined"||phone==''){
	window.location.href="pre.html";
}
var isuploading=false;
//下面用于图片上传预览功能
function setImagePreview(file,view,list,v) {
	if(isuploading==true){
		return;
	}
	isuploading=true;
	gbase64="";
	var imgsrc=$("#"+view).attr("src");
	event.stopPropagation();//不会打印1，但是页面会跳转；
	$.showLoading("读取图片...");  
    var docObj=document.getElementById(file);
    imageProcess(docObj,$("#"+view),callbackfun,view,v,imgsrc,file,list);
}
//async(newImage.src,view,v,imgsrc,file,list);
function callbackfun(gbase64,view,v,imgsrc,file,list){
	$.hideLoading();
	$.showLoading("开始上传..."); 
	if(list=="list"){
		var v=$("#"+file).parents(".imglist").attr("v");
		var show_img=$("#"+file).parents(".imglist").find(".show_img").length;
		setlocalStorage(v+"length",show_img);
	}
	if($("#"+view).hasClass("inputconkong")){
			if(list=="list"){
				var inputcon=$("#"+file).parents(".imglist").find(".inputcon");
				$("#"+file).parents(".imglist").find(".show_img").removeClass("inputconkong");
				var v=$("#"+file).parents(".imglist").attr("v");
				var str='<div class="imgfilecontair inputcon "> <img class="imgfileboxcancel inlistimg" src="img/closenum.png"/>';
				str=str+'<label for="imgfiles1s'+v+(inputcon.length+1)+'"  class="">'
				str=str+'<img id="imgfilesimg1s'+v+(inputcon.length+1)+'" class="show_img inputconkong" alt="img/addimgicon.png"  src="img/addimgicon.png"/></label>'
				str=str+'<input type="file"    accept="image/*"   id="imgfiles1s'+v+(inputcon.length+1)+'"  class="inuputfile"  onchange="javascript:setImagePreview('+"'imgfiles1s"+v+(inputcon.length+1)+"','imgfilesimg1s"+v+(inputcon.length+1)+"','list','"+v+"'";
				str=str+'); " value='+'"" /></div>';
				$("#"+file).parents(".imglist").append(str);			
			}
	}
	 updateimg(gbase64,view,v,imgsrc);//去上传
}


function updateimg(obj,node,v,imgsrc){
//          console.log(obj);
            console.log(node);
            console.log(v);
            console.log(imgsrc);
            $("body").append(file)
            var file = obj;//获取到文件列表
		    var fd =  new FormData()
		    fd.append('file', file)
            $.ajax({
                url: ajaxurl+'/api/qiniuImg',
                data: fd,
                processData: false,
                contentType: false,
                type: 'POST',
                success: function (obj) {
                if(obj.code == 200){
		                console.log(obj.data)
		                if(v!=null){//是否存数组
		                	 console.log("是储存数组");
			                 var getv=getlocalStorage(v);
			                console.log("获取到的数组"+getv);
			                 if(getv!=null){//不是首次
			                 	var imgthissrc=$("#"+node).attr("src");
			                 	var imgthisurl=$("#"+node).attr("urlsrc");
			                 	var imgthisalt=$("#"+node).attr("alt");
			                 	console.log(imgsrc+'11111111111111111111111')
			                 	if(imgsrc!="img/addimgicon.png"){//不是上传土拍的地方点击、剔除覆盖的图片
			                 		console.log("覆盖图片")
									    var vstorage=getlocalStorage(v);
										if(vstorage!=null&&vstorage!="null"){
											var vlength=getlocalStorage(v+"length");
											console.log("获取到"+v+"length,等于"+vlength)
											setlocalStorage(v+"length",(vlength*1-1));
											console.log("设置"+v+"length,等于"+(vlength*1-1))
											vstorage=JSON.parse(vstorage);
											var imglength=0;
											for (var i = 0; i < vstorage.length; i++) {
												if(imgthisurl==vstorage[i]&&imglength==0){
													console.log(imgthisurl+"----------src")
													imglength=1;
													vstorage.splice(i,1);
												}
											}
											vstorage=JSON.stringify(vstorage)
											console.log("设置数组"+v+"等于"+vstorage)
											setlocalStorage(v,vstorage);
										}
			                 		
			                 	}
			                 	
			                 	getv=getlocalStorage(v);
			                 	console.log("获取到的数组"+v+"等于"+getv);
			                 	var vlength=getlocalStorage(v+"length");
//								setlocalStorage(v+"length",vlength*1+1);
			                    getvarr=JSON.parse(getv);
			                 	console.log(getvarr)
			                 	getvarr[getvarr.length]=obj.data;
			                 	getvarr=JSON.stringify(getvarr)
			                 	setlocalStorage(v,getvarr);
			                 }else{//首次
			                 	console.log("设置新的数据组");
			                 	var strpre=[];
			                 	strpre[0]=obj.data;
			                 	var str=JSON.stringify(strpre);
			                 	setlocalStorage(v,str);
			                 }
		                }else{
		                	 setlocalStorage(node,obj.data);
		                }
		               $("#"+node).parents(".inputcon").find(".imgfileboxcancel").show();
		               $("#"+node).parents("label").removeClass("bordererror");
		               $("#"+node).parents("label").removeClass("imgcolor");
		               $("#"+node).attr("urlsrc",obj.data);
		               $("#"+node).attr("src",obj.data);
		               hidebg()
		               $.hideLoading();
	                   $.toast("上传成功!",500);
	                   isuploading=false;
		            }else{
		            	$.hideLoading();
	                    $.toast("上传失败", "cancel");
		                $("#"+node).attr("src",$("#"+node).attr("alt"));
		                isuploading=false;
		            }
                },
                error:function(msg){
                	console.log(msg);
                	isuploading=false;
                	 $.alert("服务器忙,请稍后重试!","提示",function(){})
                }
            });           
}
function showlastdata(){
//	$(".security").show();
	var getarr=["buyerfaceimg","buyerbackimg","imgfile3img","imgfile4img","imgfile5img"];
	for (var i = 0; i < getarr.length; i++) {
		if(getlocalStorage(getarr[i])!=null&&getlocalStorage(getarr[i])!="null"){
			$("#"+getarr[i]).attr("src",getlocalStorage(getarr[i]));
			$("#"+getarr[i]).parents(".inputcon").find(".imgfileboxcancel").show();
			$("#"+getarr[i]).attr("urlsrc",getlocalStorage(getarr[i]));
		}
	}
	
	if($(".buyerbox").find("#imgfilemarryimg").length>0){//结婚
		if(getlocalStorage("imgfilemarryimg")!=null&&getlocalStorage("imgfilemarryimg")!="null"&&getlocalStorage("imgfilemarryimg")!=undefined&&getlocalStorage("imgfilemarryimg")!="undefined"){
			$("#imgfilemarryimg").attr("src",getlocalStorage("imgfilemarryimg"));
			$("#imgfilemarryimg").attr("urlsrc",getlocalStorage("imgfilemarryimg"));
			$("#imgfilemarryimg").parents(".inputcon").find(".imgfileboxcancel").show();
		}
	}
//console.log($(".buyerbox").find("#imgfiledieimg").length)
	if($(".buyerbox").find("#imgfiledieimg").length>0){//死亡
		if(getlocalStorage("imgfiledieimg")!=null&&getlocalStorage("imgfiledieimg")!="null"&&getlocalStorage("imgfiledieimg")!=undefined&&getlocalStorage("imgfiledieimg")!="undefined"){
			$("#imgfiledieimg").attr("src",getlocalStorage("imgfiledieimg"));
			$("#imgfiledieimg").attr("urlsrc",getlocalStorage("imgfiledieimg"));
			$("#imgfiledieimg").parents(".inputcon").find(".imgfileboxcancel").show();
		}
	}
	var wlength=getlocalStorage("wlength");//杭州住房
	if(getlocalStorage("wlength")!=null&&getlocalStorage("wlength")!="null"&&getlocalStorage("wlength")!=0){
		var w=getlocalStorage("w");
		var jsonw=JSON.parse(w)
		if(w!=null&&w!="null"&&jsonw.length!=0){
		 var str="";
		 for (var i = 1; i < jsonw.length*1+1; i++) {
		 		if(i==1){
		 				$("#imgfilesimg1sw1").attr("src",jsonw[0]);
						$("#imgfilesimg1sw1").parents(".inputcon").find(".imgfileboxcancel").show();
						$("#imgfilesimg1sw1").attr("urlsrc",jsonw[0]);
						$("#imgfilesimg1sw1").removeClass("inputconkong");
		 		}else{ 
                    //从第二个图片开始
		 			var length=$("#imgfilesimg1sw1").parents(".imglist").find(".inputcon").length;
		 			str=str+'<div class="imgfilecontair inputcon "><img style="display: inline;" class="imgfileboxcancel inlistimg" src="img/closenum.png">';
		 			str=str+'<label for="imgfiles1sw'+i+'" class=""><img id="imgfilesimg1sw'+i+'" class="show_img" alt="img/addimgicon.png" urlsrc="'+jsonw[(i-1)]+'" src="'+jsonw[(i-1)]+'"></label><input type="file" id="imgfiles1sw';
		 			str=str+i+'" class="inuputfile" onchange="'+"javascript:setImagePreview('imgfiles1sw"+i+"','imgfilesimg1sw"+i+"','list','w'"+'); "  accept="image/*" ></div>';
		 		}
		 }
			 str=str+'<div class="imgfilecontair inputcon "> <img class="imgfileboxcancel inlistimg" src="img/closenum.png">';
		 	 str=str+'<label for="imgfiles1sw'+(jsonw.length*1+1)+'" class=""><img id="imgfilesimg1sw'+(jsonw.length*1+1)+'" class="show_img inputconkong" alt="img/addimgicon.png" src="img/addimgicon.png"></label><input type="file" id="imgfiles1sw'+
		 	 (jsonw.length*1+1)+'" class="inuputfile" onchange="javascript:setImagePreview('+"'imgfiles1sw"+(jsonw.length*1+1)+"','imgfilesimg1sw"+(jsonw.length*1+1)+"','list','w')"+'; "  accept="image/*" ></div>';
             $(".hzhousebox .imglist").append(str);
			
		}	
}
	

	var peopellength=getlocalStorage("peopellength");//个人征信
	if(getlocalStorage("peopel")!=null&&getlocalStorage("peopel")!="null"&&getlocalStorage("peopellength")!=0){
		var w=getlocalStorage("peopel");
		var jsonw=JSON.parse(w)
		if(w!=null&&w!="null"&&jsonw.length!=0){
		 var str="";
		 for (var i = 1; i < jsonw.length*1+1; i++) {
		 		if(i==1){
		 				$("#imgfilesimg1speopel1").attr("src",jsonw[0]);
						$("#imgfilesimg1speopel1").parents(".inputcon").find(".imgfileboxcancel").show();
						$("#imgfilesimg1speopel1").attr("urlsrc",jsonw[0]);
						$("#imgfilesimg1speopel1").removeClass("inputconkong");
		 		}else{ 
                    //从第二个图片开始
		 			var length=$("#imgfilesimg1speopel1").parents(".imglist").find(".inputcon").length;
		 			str=str+'<div class="imgfilecontair inputcon "><img style="display: inline;" class="imgfileboxcancel inlistimg" src="img/closenum.png">';
		 			str=str+'<label for="imgfiles1speopel'+i+'" class=""><img id="imgfilesimg1speopel'+i+'" class="show_img" alt="img/addimgicon.png" urlsrc="'+jsonw[(i-1)]+'" src="'+jsonw[(i-1)]+'"></label><input type="file" id="imgfiles1speopel';
		 			str=str+i+'" class="inuputfile" onchange="'+"javascript:setImagePreview('imgfiles1speopel"+i+"','imgfilesimg1speopel"+i+"','list','peopel'"+'); "  accept="image/*" ></div>';
		 		}
		 }
			 str=str+'<div class="imgfilecontair inputcon "> <img class="imgfileboxcancel inlistimg" src="img/closenum.png">';
		 	 str=str+'<label for="imgfiles1speopel'+(jsonw.length*1+1)+'" class=""><img id="imgfilesimg1speopel'+(jsonw.length*1+1)+'" class="show_img inputconkong" alt="img/addimgicon.png" src="img/addimgicon.png"></label><input type="file" id="imgfiles1speopel'+
		 	 (jsonw.length*1+1)+'" class="inuputfile" onchange="javascript:setImagePreview('+"'imgfiles1speopel"+(jsonw.length*1+1)+"','imgfilesimg1speopel"+(jsonw.length*1+1)+"','list','peopel')"+'; "  accept="image/*" ></div>';
             $(".trustpeople .imglist").append(str);
			
		}	
}
	
	
var zijinlength=getlocalStorage("zijinlength");//银行存款
if(getlocalStorage("zijin")!=null&&getlocalStorage("zijin")!="null"&&getlocalStorage("zijinlength")!=0){
		var w=getlocalStorage("zijin");
		var jsonw=JSON.parse(w)
		if(w!=null&&w!="null"&&jsonw.length!=0){
		 var str="";
		 for (var i = 1; i < jsonw.length*1+1; i++) {
		 		if(i==1){
		 				$("#imgfilesimg1szijin1").attr("src",jsonw[0]);
						$("#imgfilesimg1szijin1").parents(".inputcon").find(".imgfileboxcancel").show();
						$("#imgfilesimg1szijin1").attr("urlsrc",jsonw[0]);
						$("#imgfilesimg1szijin1").removeClass("inputconkong");
		 		}else{ 
                    //从第二个图片开始
		 			var length=$("#imgfilesimg1szijin1").parents(".imglist").find(".inputcon").length;
		 			str=str+'<div class="imgfilecontair inputcon "><img style="display: inline;" class="imgfileboxcancel inlistimg" src="img/closenum.png">';
		 			str=str+'<label for="imgfiles1szijin'+i+'" class=""><img id="imgfilesimg1szijin'+i+'" class="show_img" alt="img/addimgicon.png" urlsrc="'+jsonw[(i-1)]+'" src="'+jsonw[(i-1)]+'"></label><input type="file" id="imgfiles1szijin';
		 			str=str+i+'" class="inuputfile" onchange="'+"javascript:setImagePreview('imgfiles1szijin"+i+"','imgfilesimg1szijin"+i+"','list','zijin'"+'); "  accept="image/*" ></div>';
		 		}
		 }
			 str=str+'<div class="imgfilecontair inputcon "> <img class="imgfileboxcancel inlistimg" src="img/closenum.png">';
		 	 str=str+'<label for="imgfiles1szijin'+(jsonw.length*1+1)+'" class=""><img id="imgfilesimg1szijin'+(jsonw.length*1+1)+'" class="show_img inputconkong" alt="img/addimgicon.png" src="img/addimgicon.png"></label><input type="file" id="imgfiles1szijin'+
		 	 (jsonw.length*1+1)+'" class="inuputfile" onchange="javascript:setImagePreview('+"'imgfiles1szijin"+(jsonw.length*1+1)+"','imgfilesimg1szijin"+(jsonw.length*1+1)+"','list','zijin')"+'; "  accept="image/*" ></div>';
             $(".zijinbox .imglist").append(str);
			
		}	
}	
	
if($(".buyerbox").find(".lihunbox").length>0){//有离婚组件
var lihunlength=getlocalStorage("lihunlength");
if(getlocalStorage("lihun")!=null&&getlocalStorage("lihun")!="null"&&getlocalStorage("lihunlength")!=0){
		var w=getlocalStorage("lihun");
		var jsonw=JSON.parse(w)
		if(w!=null&&w!="null"&&jsonw.length!=0){
		 var str="";
		 for (var i = 1; i < jsonw.length*1+1; i++) {
		 		if(i==1){
		 				$("#imgfiledivorceimg").attr("src",jsonw[0]);
						$("#imgfiledivorceimg").parents(".inputcon").find(".imgfileboxcancel").show();
						$("#imgfiledivorceimg").attr("urlsrc",jsonw[0]);
						$("#imgfiledivorceimg").removeClass("inputconkong");
		 		}else{ 
                    //从第二个图片开始
		 			var length=$("#imgfiledivorceimg").parents(".imglist").find(".inputcon").length;
		 			str=str+'<div class="imgfilecontair inputcon "><img style="display: inline;" class="imgfileboxcancel inlistimg" src="img/closenum.png">';
		 			str=str+'<label for="imgfiles1slihun'+i+'" class=""><img id="imgfilesimg1slihun'+i+'" class="show_img" alt="img/addimgicon.png" urlsrc="'+jsonw[(i-1)]+'" src="'+jsonw[(i-1)]+'"></label><input type="file" id="imgfiles1slihun';
		 			str=str+i+'" class="inuputfile" onchange="'+"javascript:setImagePreview('imgfiles1slihun"+i+"','imgfilesimg1slihun"+i+"','list','lihun'"+'); "  accept="image/*" ></div>';
		 		}
		 }
			 str=str+'<div class="imgfilecontair inputcon "> <img class="imgfileboxcancel inlistimg" src="img/closenum.png">';
		 	 str=str+'<label for="imgfiles1slihun'+(jsonw.length*1+1)+'" class=""><img id="imgfilesimg1slihun'+(jsonw.length*1+1)+'" class="show_img inputconkong" alt="img/addimgicon.png" src="img/addimgicon.png"></label><input type="file" id="imgfiles1slihun'+
		 	 (jsonw.length*1+1)+'" class="inuputfile" onchange="javascript:setImagePreview('+"'imgfiles1slihun"+(jsonw.length*1+1)+"','imgfilesimg1slihun"+(jsonw.length*1+1)+"','list','lihun')"+'; "  accept="image/*"></div>';
             $(".lihunbox .imglist").append(str);
			
		}	
}	


}


if($(".lastinfo").find(".linanbox").length>0){//有临安组件
var linanlength=getlocalStorage("linanlength");
if(getlocalStorage("linan")!=null&&getlocalStorage("linan")!="null"&&getlocalStorage("linanlength")!=0){
		var w=getlocalStorage("linan");
		var jsonw=JSON.parse(w)
		if(w!=null&&w!="null"&&jsonw.length!=0){
		 var str="";
		 for (var i = 1; i < jsonw.length*1+1; i++) {
		 		if(i==1){
		 				$("#imgfilesimg2").attr("src",jsonw[0]);
						$("#imgfilesimg2").parents(".inputcon").find(".imgfileboxcancel").show();
						$("#imgfilesimg2").attr("urlsrc",jsonw[0]);
						$("#imgfilesimg2").removeClass("inputconkong");
		 		}else{ 
                    //从第二个图片开始
		 			var length=$("#imgfilesimg2").parents(".imglist").find(".inputcon").length;
		 			str=str+'<div class="imgfilecontair inputcon "><img style="display: inline;" class="imgfileboxcancel inlistimg" src="img/closenum.png">';
		 			str=str+'<label for="imgfiles1slinan'+i+'" class=""><img id="imgfilesimg1slinan'+i+'" class="show_img" alt="img/addimgicon.png" urlsrc="'+jsonw[(i-1)]+'" src="'+jsonw[(i-1)]+'"></label><input type="file" id="imgfiles1slinan';
		 			str=str+i+'" class="inuputfile" onchange="'+"javascript:setImagePreview('imgfiles1slinan"+i+"','imgfilesimg1slinan"+i+"','list','linan'"+'); "  accept="image/*"></div>';
		 		}
		 }
			 str=str+'<div class="imgfilecontair inputcon "> <img class="imgfileboxcancel inlistimg" src="img/closenum.png">';
		 	 str=str+'<label for="imgfiles1slinan'+(jsonw.length*1+1)+'" class=""><img id="imgfilesimg1slinan'+(jsonw.length*1+1)+'" class="show_img inputconkong" alt="img/addimgicon.png" src="img/addimgicon.png"></label><input type="file" id="imgfiles1slinan'+
		 	 (jsonw.length*1+1)+'" class="inuputfile" onchange="javascript:setImagePreview('+"'imgfiles1slinan"+(jsonw.length*1+1)+"','imgfilesimg1slinan"+(jsonw.length*1+1)+"','list','linan')"+'; "  accept="image/*"></div>';
             $(".linanbox .imglist").append(str);
			
		}	
}	
}
	
	
	


if($(".lastinfo").find(".security").length>0){//有临安组件
var shebaolength=getlocalStorage("shebaolength");
if(getlocalStorage("shebao")!=null&&getlocalStorage("shebao")!="null"&&getlocalStorage("shebaolength")!=0){
		var w=getlocalStorage("shebao");
		var jsonw=JSON.parse(w)
		if(w!=null&&w!="null"&&jsonw.length!=0){
		 var str="";
		 for (var i = 1; i < jsonw.length*1+1; i++) {
		 		if(i==1){
		 				$("#imgfilesimg5").attr("src",jsonw[0]);
						$("#imgfilesimg5").parents(".inputcon").find(".imgfileboxcancel").show();
						$("#imgfilesimg5").attr("urlsrc",jsonw[0]);
						$("#imgfilesimg5").removeClass("inputconkong");
		 		}else{ 
                    //从第二个图片开始
		 			var length=$("#imgfilesimg5").parents(".imglist").find(".inputcon").length;
		 			str=str+'<div class="imgfilecontair inputcon "><img style="display: inline;" class="imgfileboxcancel inlistimg" src="img/closenum.png">';
		 			str=str+'<label for="imgfiles1sshebao'+i+'" class=""><img id="imgfilesimg1sshebao'+i+'" class="show_img" alt="img/addimgicon.png" urlsrc="'+jsonw[(i-1)]+'" src="'+jsonw[(i-1)]+'"></label><input type="file" id="imgfiles1sshebao';
		 			str=str+i+'" class="inuputfile" onchange="'+"javascript:setImagePreview('imgfiles1sshebao"+i+"','imgfilesimg1sshebao"+i+"','list','shebao'"+'); " accept="image/*"></div>';
		 		}
		 }
			 str=str+'<div class="imgfilecontair inputcon "> <img class="imgfileboxcancel inlistimg" src="img/closenum.png">';
		 	 str=str+'<label for="imgfiles1sshebao'+(jsonw.length*1+1)+'" class=""><img id="imgfilesimg1sshebao'+(jsonw.length*1+1)+'" class="show_img inputconkong" alt="img/addimgicon.png" src="img/addimgicon.png"></label><input type="file" id="imgfiles1sshebao'+
		 	 (jsonw.length*1+1)+'" class="inuputfile" onchange="javascript:setImagePreview('+"'imgfiles1sshebao"+(jsonw.length*1+1)+"','imgfilesimg1sshebao"+(jsonw.length*1+1)+"','list','shebao')"+'; "  accept="image/*"></div>';
             $(".security .imglist").append(str);
			
		}	
}	
}
hidebg();
}
function hidebg(){
	for (var i = 0; i < 5; i++) {
			var alt=$(".buyerbox").find(".buyimg"+(1+i)).attr("alt");
	        var src=$(".buyerbox").find(".buyimg"+(1+i)).attr("urlsrc");
	        if(alt==src||src==undefined){
	        	  console.log(430);
				$(".btn").removeClass("btnok");return;
			}else{
				$(".buyerbox .buyimg"+(1+i)).parent("label").removeClass("imgcolor");
			}
	}
	//结婚
	if($(".buyerbox").find(".boxmarry").length>0){
		    var alt=$(".buyerbox").find("#imgfilemarryimg").attr("alt");
	        var src=$(".buyerbox").find("#imgfilemarryimg").attr("urlsrc");
	        if(alt==src||src==undefined){
				$(".btn").removeClass("btnok");return;
			}else{
				$("#imgfilemarryimg").parent("label").removeClass("imgcolor");
			}
	}
	//diebox,死亡
	if($(".buyerbox").find(".diebox").length>0){
		    var alt=$(".buyerbox").find("#imgfiledieimg").attr("alt");
	        var src=$(".buyerbox").find("#imgfiledieimg").attr("urlsrc");
	        if(alt==src||src==undefined){
				$(".btn").removeClass("btnok");return;
			}else{
				$("#imgfiledieimg").parent("label").removeClass("imgcolor");
			}
	}
	//离异
	if($(".buyerbox").find(".lihunbox").length>0){
				var lihunbox=$(".lihunbox").find(".show_img");
			    if(lihunbox.length<2){
						$(".btn").removeClass("btnok");
						return;
				}
				for (var i = 0; i < lihunbox.length; i++) {
					if(!$(".lihunbox").find(".show_img").eq(i).hasClass("inputconkong")){
						var alt=$(".lihunbox").find(".show_img").eq(i).attr("alt");
						var src=$(".lihunbox").find(".show_img").eq(i).attr("urlsrc");
						console.log(alt)
						if(alt==src||src==undefined){
									$(".btn").removeClass("btnok");
									return;
						}else{
							$(".lihunbox").find(".show_img").eq(i).parent("label").removeClass("imgcolor");
						}
					}
				}	
	}
	if($(".page3").find(".buyothers").length>0){
		var buyothersbox=$(".buyothers").find(".buyothersbox");
		for (var i = 0; i < buyothersbox.length; i++) {
			var name=$(".buyothers").find(".buyothersbox").attr("name");
			for (var k = 0; k < 5; k++) {
					var alt=$(".buyothers").find(".buyothersbox").eq(i).find(".buyimg"+(1+k)).attr("alt");
			        var src=$(".buyothers").find(".buyothersbox").eq(i).find(".buyimg"+(1+k)).attr("urlsrc");
			        if(alt==src||src==undefined){
						$(".btn").removeClass("btnok");
						return;
					}else{
						$(".buyothers").find(".buyothersbox").eq(i).find(".buyimg"+(1+k)).parent("label").removeClass("imgcolor");
					}
			}	
		}
	}
var havehouse=$("body").attr('havehouse');
if(havehouse=='是'){
	var hzhousebox=$(".hzhousebox").find(".show_img");
    if(hzhousebox.length<2){
			$(".btn").removeClass("btnok");
			return;
	}
	for (var i = 0; i < hzhousebox.length; i++) {
		if(!$(".hzhousebox").find(".show_img").eq(i).hasClass("inputconkong")){
			var alt=$(".hzhousebox").find(".show_img").eq(i).attr("alt");
			var src=$(".hzhousebox").find(".show_img").eq(i).attr("urlsrc");
			if(alt==src||src==undefined){
					   	$(".btn").removeClass("btnok");
						return;
			}else{
				$(".hzhousebox").find(".show_img").eq(i).parent("label").removeClass("imgcolor");
			}
		}
	}
}
	var trustpeople=$(".trustpeople").find(".show_img");
	if(trustpeople.length<2){
			$(".btn").removeClass("btnok");
			return;
	}
	for (var i = 0; i < trustpeople.length; i++) {
		if(!$(".trustpeople").find(".show_img").eq(i).hasClass("inputconkong")){
			var alt=$(".trustpeople").find(".show_img").eq(i).attr("alt");
			var src=$(".trustpeople").find(".show_img").eq(i).attr("urlsrc");
			if(alt==src||src==undefined){
						$(".btn").removeClass("btnok");
						return;
			}else{
				$(".trustpeople").find(".show_img").eq(i).parent("label").removeClass("imgcolor");
			}
		}
	}
	if($(".lastinfo").find(".linanbox").length>0){
		var linanbox=$(".linanbox").find(".show_img");
		if(linanbox.length<2){
				$(".btn").removeClass("btnok");
				return;
		}
		for (var i = 0; i < linanbox.length; i++) {
			if(!$(".linanbox").find(".show_img").eq(i).hasClass("inputconkong")){
				var alt=$(".linanbox").find(".show_img").eq(i).attr("alt");
				var src=$(".linanbox").find(".show_img").eq(i).attr("urlsrc");
				if(alt==src||src==undefined){
							$(".btn").removeClass("btnok");
							return;
				}else{
					$(".linanbox").find(".show_img").eq(i).parent("label").removeClass("imgcolor");
				}
			}
		}
	}
	var zijinbox=$(".zijinbox").find(".show_img");
	if(zijinbox.length<2){
				$(".btn").removeClass("btnok");
				return;
	}
	for (var i = 0; i < zijinbox.length; i++) {
		if(!$(".zijinbox").find(".show_img").eq(i).hasClass("inputconkong")){
			var alt=$(".zijinbox").find(".show_img").eq(i).attr("alt");
			var src=$(".zijinbox").find(".show_img").eq(i).attr("urlsrc");
			if(alt==src||src==undefined){
						$(".btn").removeClass("btnok");
						return;
			}else{
				$(".zijinbox").find(".show_img").eq(i).parent("label").removeClass("imgcolor");
			}
		}
	}
	if($(".lastinfo").find(".security").length>0){
		var security=$(".security").find(".show_img");
		if(security.length<2){
				$(".btn").removeClass("btnok");
	 			return;
	   }
		for (var i = 0; i < security.length; i++) {
			if(!$(".security").find(".show_img").eq(i).hasClass("inputconkong")){
				var alt=$(".security").find(".show_img").eq(i).attr("alt");
				var src=$(".security").find(".show_img").eq(i).attr("urlsrc");
				if(alt==src||src==undefined){
							$(".btn").removeClass("btnok");
							return;
				}else{
					$(".security").find(".show_img").eq(i).parent("label").removeClass("imgcolor");
				}
			}
		}
	}
	$(".btn").addClass("btnok");
}
$(document).ready(function(){
$.showLoading();
var ajaxurl="http://tianyangweilan.shoufangpai.com";
var phone=getlocalStorage("phone");
if(phone==null||phone=="null"||phone==undefined||phone=="undefined"||phone==''){//判断是否登陆
	window.location.href="pre.html";
	return;
}
console.log('登录有效')
getdata1();
function getdata1(){
var phone=getlocalStorage("phone");
 $.ajax({//获取补充信息
                url: ajaxurl+'/api/get',
                data: {
                	"phone":phone,
                	"type":1
                },
                type: 'POST',
                success: function (obj) {
                	console.log(obj)
                	 $.hideLoading();
                    if(obj.code == 200){
		                if(obj.data.divorce == null && obj.data.household == null && obj.data.hzHouse == null && obj.data.marriage == null && obj.data.otherHouse == null){
				          console.log('没有填写第一步的资料');
				           var v=Math.random();
	                       window.location.href='index.html?v='+v;
	                       return;
		                }
						console.log("即使有社保也不手机社保信息")	
						//if(obj.data.household=='落户满2年的临安、桐庐、建德、淳安户籍'||obj.data.household=='落户未满2年的临安、桐庐、建德、淳安户籍'){
						// 	$(".lastinfo .linan").show();
						// }else{
						// 	$(".lastinfo .linan").remove();
						// }
						// if(obj.data.security=="是"){
						// 	$(".lastinfo .security").show();
						// }else{
						// 	$(".lastinfo .security").remove();
						// }
		                $("body").attr("marry",obj.data.marriage);
		                 if(obj.data.marriage=="已婚"){
		                 	$(".boxmarry").show();
		                 	$(".lihunbox").remove();
		                 	$(".diebox").remove();
		                 }else if(obj.data.marriage=="未婚单身"){
		                    $(".boxmarry").remove();
		                 	$(".lihunbox").remove();
		                 	$(".diebox").remove();
		                 }else if(obj.data.marriage=="离异单身(含带未成年子女)"){
		                    $(".lihunbox").show();
		                     $(".boxmarry").remove();
		                 	$(".diebox").remove();
		                 }else if(obj.data.marriage=="丧偶"){
		                     $(".diebox").show();
		                     $(".boxmarry").remove();
		                 	$(".lihunbox").remove();
		                 }
		                  getdata2();
		            }else{
		                $.alert(obj.msg,function(){
							var v=Math.random();
							if(obj.msg=='登录失效,请重新登录'){
								window.location.href="pre.html?v="+v;
							}
						})
		            }
                },
                error:function(msg){
                	 $.hideLoading();
                	 $.alert('服务器忙,请检查您的网络稍后重试!')
                }
});
}
function getdata2(){
var phone=getlocalStorage("phone");
$.ajax({//获取补充信息
    url: ajaxurl+'/api/get',
    data: {
    	"phone":phone,
    	"type":2
    },
    type: 'POST',
    success: function (obj) {
    	console.log(obj)
        if(obj.code == 200){
        	 $(".buyerbox .username").html(obj.data.name);
			 if(obj.data.name==null){
			 	console.log('没有填写第二部分的资料');
			 	window.location.href="index2.html";
			 	return;
			 }
			 $("body").attr('haveHouse',obj.data.haveHouse);
			 if(obj.data.haveHouse=='是'){
			 	$(".hzhousebox").show();
			 	
			 }else{
			 	$(".hzhousebox").hide();
			 }
			 if(obj.data.other.length>0){
			 	$(".buyothers").show();
			 	var str="";
			 	for (var i = 0; i < obj.data.other.length; i++) {
			 		 str=str+'<div idCard='+obj.data.other[i].idCard+' class="buyothersbox" at="'+i+'" name="'+obj.data.other[i].name+'"><div class="page3-header"><span class="username">'+obj.data.other[i].name+'</span>身份证/军官证/护照<span class="page3-header-tips">(需上传清晰、完整、工整的照片)</span>'
			 	     str=str+'</div><div class="imgfilebox"><div class="imgfileboxleft inputcon "><img class="imgfileboxcancel" src="img/closenum.png"/>'
			 	     str=str+'<label for="buyerface'+i+'" class="">';
			 	     str=str+'<img id="buyerfaceimg'+i+'" class="show_img buyimg1"  alt="img/zhengmian.png"   src="img/zhengmian.png"/></label>'
			 	     str=str+'<input type="file"     id="buyerface'+i+'"  class="inuputfile"  onchange="javascript:setImagePreview('+"'buyerface"+i+"','buyerfaceimg"+i+"'"+');"  accept="image/*" />'
			 	     str=str+'</div><div class="imgfileboxright inputcon"><img class="imgfileboxcancel" src="img/closenum.png"/>';
			 	     str=str+'<label for="buyerback'+i+'"><img id="buyerbackimg'+i+'"  class="show_img buyimg2"  alt="img/fanmian.png"  alt="img/fanmian.png"  src="img/fanmian.png"/>';
			 	     str=str+'</label><input type="file"     id="buyerback'+i+'" class="inuputfile" onchange="javascript:setImagePreview('+"'buyerback"+i+"','buyerbackimg"+i+"'"+');" accept="image/*" value="" />'
			 	     str=str+'</div></div><div class="clearboth"></div><div class="page3-header padding30">'
			 	     str=str+'<span class="username">'+obj.data.other[i].name+'</span>户口本首页<span class="page3-header-tips">(需上传清晰、完整、工整的照片)</span></div>';
			 	     str=str+'<div class="imgfilecontair  inputcon"><img class="imgfileboxcancel" src="img/closenum.png"/>';
			 	      str=str+'<label for="imgfile3'+i+'"  class=""><img id="imgfile3img'+i+'" class="show_img buyimg3" alt="img/addimgicon.png" src="img/addimgicon.png"/></label>';
			 	     str=str+'<input type="file"     id="imgfile3'+i+'"  class="inuputfile"  onchange="javascript:setImagePreview('+"'imgfile3"+i+"','imgfile3img"+i+"'); "+'"   accept="image/*" /></div>';
			 	     str=str+'<div class="page3-header padding30"><span class="username">'+obj.data.other[i].name+'</span>户口本个人页<span class="page3-header-tips">(需上传清晰、完整、工整的照片)</span></div>';
			 	     str=str+'<div class="imgfilecontair inputcon"><img class="imgfileboxcancel" src="img/closenum.png"/>';
			 	     str=str+'<label for="imgfile4'+i+'"  class=""><img id="imgfile4img'+i+'" class="show_img buyimg4" alt="img/addimgicon.png"  src="img/addimgicon.png"/></label>';
			 	     str=str+'<input type="file"     id="imgfile4'+i+'"  class="inuputfile"  onchange="javascript:setImagePreview('+"'imgfile4"+i+"','imgfile4img"+i+"');"+'"  accept="image/*" /></div>';
			 	     str=str+'<div class="page3-header padding30"><span class="username">'+obj.data.other[i].name+'</span>户口本户主页<span class="page3-header-tips">(需上传清晰、完整、工整的照片)</span></div>'
			 	     str=str+'<div class="imgfilecontair inputcon"><img class="imgfileboxcancel" src="img/closenum.png"/>'
			 	     str=str+'<label for="imgfile5'+i+'"  class=""><img id="imgfile5img'+i+'" class="show_img buyimg5" alt="img/addimgicon.png"  src="img/addimgicon.png"/></label>'
			 	     str=str+'<input type="file"     id="imgfile5'+i+'"  class="inuputfile"  onchange="javascript:setImagePreview('+"'imgfile5"+i+"','imgfile5img"+i+"');"+'"  accept="image/*" /></div><div class="height40div"></div></div>';
			 	}
			// 	console.log(str)
			 	$(".buyotherszoo").html(str);
			 }else{
			 	$(".buyothers").remove();
			 }
             getdata3();
        }else{
            $.alert(obj.msg,function(){
				var v=Math.random();
				if(obj.msg=='登录失效,请重新登录'){
					window.location.href="pre.html?v="+v;
				}
			})
        }
    },
    error:function(msg){
    	$.alert('服务器忙,请检查您的网络稍后重试!')
    }
});   
}


function getdata3(){
var phone=getlocalStorage("phone");
 $.ajax({//获取补充信息
        url: ajaxurl+'/api/get',
        data: {
        	"phone":phone,
        	"type":3
        },
        type: 'POST',
        success: function (obj) {
        if(obj.code == 200){
                console.log(obj);
                if(obj.data==null){
                	 $.hideLoading();
                	 showlastdata();
                	 return;
                }else{
                	 showdata3(obj);
                }
               
            }else{
                $.alert(obj.msg,function(){
					var v=Math.random();
					if(obj.msg=='登录失效,请重新登录'){
						window.location.href="pre.html?v="+v;
					}
				})
            }
        },
        error:function(msg){
        	$.alert('服务器忙,请检查您的网络稍后重试!')
        }
});
}
function showdata3(obj){
//	 $.hideLoading();
//	return;
	$(".buyerbox").find(".buyimg1").attr("src",obj.data.idCardfront);//身份证正面	
	$(".buyerbox").find(".buyimg1").attr("urlsrc",obj.data.idCardfront);//身份证正面	
	$(".buyerbox").find(".buyimg1").parents(".inputcon").find(".imgfileboxcancel").show();
	$(".buyerbox").find(".buyimg2").attr("src",obj.data.idCardback);//	身份证背面	
	$(".buyerbox").find(".buyimg2").attr("urlsrc",obj.data.idCardback);//	身份证背面	
	$(".buyerbox").find(".buyimg2").parents(".inputcon").find(".imgfileboxcancel").show();
	$(".buyerbox").find(".buyimg3").attr("src",obj.data.accountBook);//	户口本首页
	$(".buyerbox").find(".buyimg3").attr("urlsrc",obj.data.accountBook);//	户口本首页
	$(".buyerbox").find(".buyimg3").parents(".inputcon").find(".imgfileboxcancel").show();
	$(".buyerbox").find(".buyimg4").attr("src",obj.data.accountBookpersonal);//	户口本个人页	
	$(".buyerbox").find(".buyimg4").attr("urlsrc",obj.data.accountBookpersonal);//	户口本个人页	
	$(".buyerbox").find(".buyimg4").parents(".inputcon").find(".imgfileboxcancel").show();
	$(".buyerbox").find(".buyimg5").attr("src",obj.data.accountBookmain);//	户口本主页		
	$(".buyerbox").find(".buyimg5").attr("urlsrc",obj.data.accountBookmain);//	户口本主页	
	$(".buyerbox").find(".buyimg5").parents(".inputcon").find(".imgfileboxcancel").show();
    if(obj.data.death!=null&&obj.data.death!="null"&&obj.data.death!=""&&obj.data.death!="undefined"&&obj.data.death!=undefined){
    	$("#imgfiledieimg").attr("src",obj.data.death);
    	$("#imgfiledieimg").attr("urlsrc",obj.data.death);
    	$("#imgfiledieimg").parents(".inputcon").find(".imgfileboxcancel").show();
    }
    if(obj.data.marry!=null&&obj.data.marry!="null"&&obj.data.marry!=""&&obj.data.marry!=undefined&&obj.data.marry!="undefined"){
    	$("#imgfilemarryimg").attr("src",obj.data.marry);
    	$("#imgfilemarryimg").attr("urlsrc",obj.data.marry);
    	$("#imgfilemarryimg").parents(".inputcon").find(".imgfileboxcancel").show();
    }
    if(obj.data.divorce_img.length>0){
    	for (var i = 0; i < obj.data.divorce_img.length; i++) {
    		if(i==0){
    			$("#imgfiledivorceimg").attr("src",obj.data.divorce_img[0]);
    			$("#imgfiledivorceimg").attr("urlsrc",obj.data.divorce_img[0]);
    			$("#imgfiledivorceimg").parents(".inputcon").find(".imgfileboxcancel").show();
    		}else{
		    	var inputcon=$(".lihunbox").find(".inputcon");
				$(".lihunbox").find(".show_img").removeClass("inputconkong");
				var v=$(".lihunbox").find(".imglist").attr("v");
				var str='<div class="imgfilecontair inputcon "> <img style="display:inline;" class="imgfileboxcancel inlistimg" src="img/closenum.png"/>';
				str=str+'<label for="imgfiles1s'+v+(inputcon.length+1)+'"  class="">'
				str=str+'<img id="imgfilesimg1s'+v+(inputcon.length+1)+'" class="show_img" alt="img/addimgicon.png"  src="'+obj.data.divorce_img[i]+'" urlsrc="'+obj.data.divorce_img[i]+'" /></label>'
				str=str+'<input type="file"     id="imgfiles1s'+v+(inputcon.length+1)+'"  class="inuputfile"  onchange="javascript:setImagePreview('+"'imgfiles1s"+v+(inputcon.length+1)+"','imgfilesimg1s"+v+(inputcon.length+1)+"','list'";
				str=str+'); "  accept="image/*" value='+'"" /></div>';
				$(".lihunbox").find(".imglist").append(str);	
    		}
    	}
    	  var inputcon=$(".lihunbox").find(".inputcon");
				$(".lihunbox").find(".show_img").removeClass("inputconkong");
				var v=$(".lihunbox").find(".imglist").attr("v");
				var str='<div class="imgfilecontair inputcon "> <img class="imgfileboxcancel inlistimg" src="img/closenum.png"/>';
				str=str+'<label for="imgfiles1s'+v+(inputcon.length+1)+'"  class="">'
				str=str+'<img id="imgfilesimg1s'+v+(inputcon.length+1)+'" class="show_img inputconkong" alt="img/addimgicon.png"  src="img/addimgicon.png"/></label>'
				str=str+'<input type="file"     id="imgfiles1s'+v+(inputcon.length+1)+'"  class="inuputfile"  onchange="javascript:setImagePreview('+"'imgfiles1s"+v+(inputcon.length+1)+"','imgfilesimg1s"+v+(inputcon.length+1)+"','list'";
				str=str+'); "  accept="image/*" value='+'"" /></div>';
				$(".lihunbox").find(".imglist").append(str);	
    			
    }
    if(obj.data.fund_freezing.length>0){
		    	for (var i = 0; i < obj.data.fund_freezing.length; i++) {
		    		if(i==0){
		    			$("#imgfilesimg1szijin1").attr("src",obj.data.fund_freezing[0]);
		    			$("#imgfilesimg1szijin1").attr("urlsrc",obj.data.fund_freezing[0]);
		    			$("#imgfilesimg1szijin1").parents(".inputcon").find(".imgfileboxcancel").show();
		    		}else{
				    	var inputcon=$(".zijinbox").find(".inputcon");
						$(".zijinbox").find(".show_img").removeClass("inputconkong");
						var v=$(".zijinbox").find(".imglist").attr("v");
						var str='<div class="imgfilecontair inputcon "> <img style="display:inline;" class="imgfileboxcancel inlistimg" src="img/closenum.png"/>';
						str=str+'<label for="imgfiles1s'+v+(inputcon.length+1)+'"  class="">'
						str=str+'<img id="imgfilesimg1s'+v+(inputcon.length+1)+'" class="show_img" alt="img/addimgicon.png"  src="'+obj.data.fund_freezing[i]+'"  urlsrc="'+obj.data.fund_freezing[i]+'"/></label>'
						str=str+'<input type="file"     id="imgfiles1s'+v+(inputcon.length+1)+'"  class="inuputfile"  onchange="javascript:setImagePreview('+"'imgfiles1s"+v+(inputcon.length+1)+"','imgfilesimg1s"+v+(inputcon.length+1)+"','list'";
						str=str+'); "  accept="image/*" value='+'"" /></div>';
						$(".zijinbox").find(".imglist").append(str);	
		    		}
		    	}
    	        var inputcon=$(".zijinbox").find(".inputcon");
				$(".zijinbox").find(".show_img").removeClass("inputconkong");
				var v=$(".zijinbox").find(".imglist").attr("v");
				var str='<div class="imgfilecontair inputcon "> <img class="imgfileboxcancel inlistimg" src="img/closenum.png"/>';
				str=str+'<label for="imgfiles1s'+v+(inputcon.length+1)+'"  class="">'
				str=str+'<img id="imgfilesimg1s'+v+(inputcon.length+1)+'" class="show_img inputconkong" alt="img/addimgicon.png"  src="img/addimgicon.png"/></label>'
				str=str+'<input type="file"     id="imgfiles1s'+v+(inputcon.length+1)+'"  class="inuputfile"  onchange="javascript:setImagePreview('+"'imgfiles1s"+v+(inputcon.length+1)+"','imgfilesimg1s"+v+(inputcon.length+1)+"','list'";
				str=str+'); "  accept="image/*" value='+'"" /></div>';
				$(".zijinbox").find(".imglist").append(str);	
    			
    }
    if(obj.data.personal_credit.length>0){
		    	for (var i = 0; i < obj.data.personal_credit.length; i++) {
		    		if(i==0){
		    			$("#imgfilesimg1speopel1").attr("src",obj.data.personal_credit[0]);
		    			$("#imgfilesimg1speopel1").attr("urlsrc",obj.data.personal_credit[0]);
		    			$("#imgfilesimg1speopel1").parents(".inputcon").find(".imgfileboxcancel").show();
		    		}else{
				    	var inputcon=$(".trustpeople").find(".inputcon");
						$(".trustpeople").find(".show_img").removeClass("inputconkong");
						var v=$(".trustpeople").find(".imglist").attr("v");
						var str='<div class="imgfilecontair inputcon "> <img style="display:inline;" class="imgfileboxcancel inlistimg" src="img/closenum.png"/>';
						str=str+'<label for="imgfiles1s'+v+(inputcon.length+1)+'"  class="">'
						str=str+'<img id="imgfilesimg1s'+v+(inputcon.length+1)+'" class="show_img" alt="img/addimgicon.png"  src="'+obj.data.personal_credit[i]+'" urlsrc="'+obj.data.personal_credit[i]+'"/></label>'
						str=str+'<input type="file"     id="imgfiles1s'+v+(inputcon.length+1)+'"  class="inuputfile"  onchange="javascript:setImagePreview('+"'imgfiles1s"+v+(inputcon.length+1)+"','imgfilesimg1s"+v+(inputcon.length+1)+"','list'";
						str=str+'); "  accept="image/*" value='+'"" /></div>';
						$(".trustpeople").find(".imglist").append(str);	
		    		}
		    	}
    	        var inputcon=$(".trustpeople").find(".inputcon");
				$(".trustpeople").find(".show_img").removeClass("inputconkong");
				var v=$(".trustpeople").find(".imglist").attr("v");
				var str='<div class="imgfilecontair inputcon "> <img class="imgfileboxcancel inlistimg" src="img/closenum.png"/>';
				str=str+'<label for="imgfiles1s'+v+(inputcon.length+1)+'"  class="">'
				str=str+'<img id="imgfilesimg1s'+v+(inputcon.length+1)+'" class="show_img inputconkong" alt="img/addimgicon.png"  src="img/addimgicon.png"/></label>'
				str=str+'<input type="file"   accept="image/*"   id="imgfiles1s'+v+(inputcon.length+1)+'"  class="inuputfile"  onchange="javascript:setImagePreview('+"'imgfiles1s"+v+(inputcon.length+1)+"','imgfilesimg1s"+v+(inputcon.length+1)+"','list'";
				str=str+'); " value='+'"" /></div>';
				$(".trustpeople").find(".imglist").append(str);	
    			
    }
    
    if(obj.data.housing_situation.length>0){
		    	for (var i = 0; i < obj.data.housing_situation.length; i++) {
		    		if(i==0){
		    			$("#imgfilesimg1sw1").attr("src",obj.data.housing_situation[0]);
		    			$("#imgfilesimg1sw1").attr("urlsrc",obj.data.housing_situation[0]);
		    			$("#imgfilesimg1sw1").parents(".inputcon").find(".imgfileboxcancel").show();
		    		}else{
				    	var inputcon=$(".hzhousebox").find(".inputcon");
						$(".hzhousebox").find(".show_img").removeClass("inputconkong");
						var v=$(".hzhousebox").find(".imglist").attr("v");
						var str='<div class="imgfilecontair inputcon "> <img style="display:inline;" class="imgfileboxcancel inlistimg" src="img/closenum.png"/>';
						str=str+'<label for="imgfiles1s'+v+(inputcon.length+1)+'"  class="">'
						str=str+'<img id="imgfilesimg1s'+v+(inputcon.length+1)+'" class="show_img" alt="img/addimgicon.png"  src="'+obj.data.housing_situation[i]+'"  urlsrc="'+obj.data.housing_situation[i]+'"/></label>'
						str=str+'<input type="file"     id="imgfiles1s'+v+(inputcon.length+1)+'"  class="inuputfile"  onchange="javascript:setImagePreview('+"'imgfiles1s"+v+(inputcon.length+1)+"','imgfilesimg1s"+v+(inputcon.length+1)+"','list'";
						str=str+'); "  accept="image/*" value='+'"" /></div>';
						$(".hzhousebox").find(".imglist").append(str);	
		    		}
		    	}
    	  var inputcon=$(".hzhousebox").find(".inputcon");
				$(".hzhousebox").find(".show_img").removeClass("inputconkong");
				var v=$(".hzhousebox").find(".imglist").attr("v");
				var str='<div class="imgfilecontair inputcon "> <img class="imgfileboxcancel inlistimg" src="img/closenum.png"/>';
				str=str+'<label for="imgfiles1s'+v+(inputcon.length+1)+'"  class="">'
				str=str+'<img id="imgfilesimg1s'+v+(inputcon.length+1)+'" class="show_img inputconkong" alt="img/addimgicon.png"  src="img/addimgicon.png"/></label>'
				str=str+'<input type="file"    accept="image/*"  id="imgfiles1s'+v+(inputcon.length+1)+'"  class="inuputfile"  onchange="javascript:setImagePreview('+"'imgfiles1s"+v+(inputcon.length+1)+"','imgfilesimg1s"+v+(inputcon.length+1)+"','list'";
				str=str+'); " value='+'"" /></div>';
				$(".hzhousebox").find(".imglist").append(str);	
    			
    }
    
    
        if(obj.data.other_housing_situation.length>0){
		    	for (var i = 0; i < obj.data.other_housing_situation.length; i++) {
		    		if(i==0){
		    			$("#imgfilesimg2").attr("src",obj.data.other_housing_situation[0]);
		    			$("#imgfilesimg2").attr("urlsrc",obj.data.other_housing_situation[0]);
		    			$("#imgfilesimg2").parents(".inputcon").find(".imgfileboxcancel").show();
		    		}else{
				    var inputcon=$(".linanbox").find(".inputcon");
						$(".linanbox").find(".show_img").removeClass("inputconkong");
						var v=$(".linanbox").find(".imglist").attr("v");
						var str='<div class="imgfilecontair inputcon "> <img style="display:inline;" class="imgfileboxcancel inlistimg" src="img/closenum.png"/>';
						str=str+'<label for="imgfiles1s'+v+(inputcon.length+1)+'"  class="">'
						str=str+'<img id="imgfilesimg1s'+v+(inputcon.length+1)+'" class="show_img" alt="img/addimgicon.png"  src="'+obj.data.other_housing_situation[i]+'"  urlsrc="'+obj.data.other_housing_situation[i]+'"/></label>'
						str=str+'<input type="file"  accept="image/*"    id="imgfiles1s'+v+(inputcon.length+1)+'"  class="inuputfile"  onchange="javascript:setImagePreview('+"'imgfiles1s"+v+(inputcon.length+1)+"','imgfilesimg1s"+v+(inputcon.length+1)+"','list'";
						str=str+'); " value='+'"" /></div>';
						$(".linanbox").find(".imglist").append(str);	
		    		}
		    	}
    	  var inputcon=$(".linanbox").find(".inputcon");
				$(".linanbox").find(".show_img").removeClass("inputconkong");
				var v=$(".linanbox").find(".imglist").attr("v");
				var str='<div class="imgfilecontair inputcon "> <img class="imgfileboxcancel inlistimg" src="img/closenum.png"/>';
				str=str+'<label for="imgfiles1s'+v+(inputcon.length+1)+'"  class="">'
				str=str+'<img id="imgfilesimg1s'+v+(inputcon.length+1)+'" class="show_img inputconkong" alt="img/addimgicon.png"  src="img/addimgicon.png"/></label>'
				str=str+'<input type="file"   accept="image/*"   id="imgfiles1s'+v+(inputcon.length+1)+'"  class="inuputfile"  onchange="javascript:setImagePreview('+"'imgfiles1s"+v+(inputcon.length+1)+"','imgfilesimg1s"+v+(inputcon.length+1)+"','list'";
				str=str+'); " value='+'"" /></div>';
				$(".linanbox").find(".imglist").append(str);	
    			
    }
    
            if(obj.data.security_img.length>0){
		    	for (var i = 0; i < obj.data.security_img.length; i++) {
		    		if(i==0){
		    			$("#imgfilesimg5").attr("src",obj.data.security_img[0]);
		    			$("#imgfilesimg5").attr("urlsrc",obj.data.security_img[0]);
		    			$("#imgfilesimg5").parents(".inputcon").find(".imgfileboxcancel").show();
		    		}else{
				    	var inputcon=$(".security").find(".inputcon");
						$(".security").find(".show_img").removeClass("inputconkong");
						var v=$(".security").find(".imglist").attr("v");
						var str='<div class="imgfilecontair inputcon "> <img style="display:inline;" class="imgfileboxcancel inlistimg" src="img/closenum.png"/>';
						str=str+'<label for="imgfiles1s'+v+(inputcon.length+1)+'"  class="">'
						str=str+'<img id="imgfilesimg1s'+v+(inputcon.length+1)+'" class="show_img" alt="img/addimgicon.png"  src="'+obj.data.security_img[i]+'"  urlsrc="'+obj.data.security_img[i]+'"/></label>'
						str=str+'<input type="file"   accept="image/*"   id="imgfiles1s'+v+(inputcon.length+1)+'"  class="inuputfile"  onchange="javascript:setImagePreview('+"'imgfiles1s"+v+(inputcon.length+1)+"','imgfilesimg1s"+v+(inputcon.length+1)+"','list'";
						str=str+'); " value='+'"" /></div>';
						$(".security").find(".imglist").append(str);	
		    		}
		    	}
    	  var inputcon=$(".security").find(".inputcon");
				$(".security").find(".show_img").removeClass("inputconkong");
				var v=$(".security").find(".imglist").attr("v");
				var str='<div class="imgfilecontair inputcon "> <img class="imgfileboxcancel inlistimg" src="img/closenum.png"/>';
				str=str+'<label for="imgfiles1s'+v+(inputcon.length+1)+'"  class="">'
				str=str+'<img id="imgfilesimg1s'+v+(inputcon.length+1)+'" class="show_img inputconkong" alt="img/addimgicon.png"  src="img/addimgicon.png"/></label>'
				str=str+'<input type="file"   accept="image/*"   id="imgfiles1s'+v+(inputcon.length+1)+'"  class="inuputfile"  onchange="javascript:setImagePreview('+"'imgfiles1s"+v+(inputcon.length+1)+"','imgfilesimg1s"+v+(inputcon.length+1)+"','list'";
				str=str+'); " value='+'"" /></div>';
				$(".security").find(".imglist").append(str);	
    			
    }
    
    
    if(obj.data.other_img.length>0){
    	for (var i = 0; i < obj.data.other_img.length; i++) {
    		$(".buyotherszoo").find(".buyothersbox").eq(i).find(".buyimg1").attr("src",obj.data.other_img[i].idCardfront);
    		$(".buyotherszoo").find(".buyothersbox").eq(i).find(".buyimg1").attr("urlsrc",obj.data.other_img[i].idCardfront);
    		$(".buyotherszoo").find(".buyothersbox").eq(i).find(".buyimg1").parents(".inputcon").find(".imgfileboxcancel").show();
    		
    		$(".buyotherszoo").find(".buyothersbox").eq(i).find(".buyimg2").attr("src",obj.data.other_img[i].idCardback);
    		$(".buyotherszoo").find(".buyothersbox").eq(i).find(".buyimg2").attr("urlsrc",obj.data.other_img[i].idCardback);
    		$(".buyotherszoo").find(".buyothersbox").eq(i).find(".buyimg2").parents(".inputcon").find(".imgfileboxcancel").show();
    		
    		$(".buyotherszoo").find(".buyothersbox").eq(i).find(".buyimg3").attr("src",obj.data.other_img[i].accountBook);
    		$(".buyotherszoo").find(".buyothersbox").eq(i).find(".buyimg3").attr("urlsrc",obj.data.other_img[i].accountBook);
    		$(".buyotherszoo").find(".buyothersbox").eq(i).find(".buyimg3").parents(".inputcon").find(".imgfileboxcancel").show();
    		
    		$(".buyotherszoo").find(".buyothersbox").eq(i).find(".buyimg4").attr("src",obj.data.other_img[i].accountBookpersonal);
    		$(".buyotherszoo").find(".buyothersbox").eq(i).find(".buyimg4").attr("urlsrc",obj.data.other_img[i].accountBookpersonal);
    		$(".buyotherszoo").find(".buyothersbox").eq(i).find(".buyimg4").parents(".inputcon").find(".imgfileboxcancel").show();
    		
    		
    		$(".buyotherszoo").find(".buyothersbox").eq(i).find(".buyimg5").attr("src",obj.data.other_img[i].accountBookmain);
    		$(".buyotherszoo").find(".buyothersbox").eq(i).find(".buyimg5").attr("urlsrc",obj.data.other_img[i].accountBookmain);
    		$(".buyotherszoo").find(".buyothersbox").eq(i).find(".buyimg5").parents(".inputcon").find(".imgfileboxcancel").show();
    		
    	}
    }
    
    $("body").attr("status",obj.data.status);
    $.hideLoading();
    hidebg();
}


$(".btn").click(function(){
	for (var i = 0; i < 5; i++) {
			var alt=$(".buyerbox").find(".buyimg"+(1+i)).attr("alt");
	        var src=$(".buyerbox").find(".buyimg"+(1+i)).attr("urlsrc");
	        if(alt==src||src==undefined){
				$(".buyerbox .buyimg"+(1+i)).parent("label").addClass("imgcolor");
				$(".btn").removeClass("btnok");
				$.alert("主购房人材料不完整！")
				return;
			}
	}
	//结婚
	if($(".buyerbox").find(".boxmarry").length>0){
		    var alt=$(".buyerbox").find("#imgfilemarryimg").attr("alt");
	        var src=$(".buyerbox").find("#imgfilemarryimg").attr("urlsrc");
	        if(alt==src||src==undefined){
				$(".btn").removeClass("btnok");
				$.alert("结婚证明未上传！")
				return;
			}else{
				$("#imgfilemarryimg").parent("label").removeClass("imgcolor");
			}
	}
	//diebox,死亡
	if($(".buyerbox").find(".diebox").length>0){
		    var alt=$(".buyerbox").find("#imgfiledieimg").attr("alt");
	        var src=$(".buyerbox").find("#imgfiledieimg").attr("urlsrc");
	        if(alt==src||src==undefined){
				$(".btn").removeClass("btnok");
				$.alert("死亡证明未上传！")
				return;
			}else{
				$("#imgfiledieimg").parent("label").removeClass("imgcolor");
			}
	}
	//离异
	if($(".buyerbox").find(".lihunbox").length>0){
//		    var alt=$(".buyerbox").find("#imgfiledivorceimg").attr("alt");
//	        var src=$(".buyerbox").find("#imgfiledivorceimg").attr("src");
//	        if(alt==src){
//				$(".btn").removeClass("btnok");
//				$.alert("离异证明未上传！")
//				return;
//			}else{
//				$("#imgfiledivorceimg").parent("label").removeClass("imgcolor");
//			}
//			
			
				var lihunbox=$(".lihunbox").find(".show_img");
				if(lihunbox.length<2){
					$(".lihunbox").find(".show_img").eq(0).parent("label").addClass("imgcolor");
					$.alert("离异证明不完整！");
					$(".btn").removeClass("btnok");
					return;
				}
				for (var i = 0; i < lihunbox.length; i++) {
					if(!$(".lihunbox").find(".show_img").eq(i).hasClass("inputconkong")){
						var alt=$(".lihunbox").find(".show_img").eq(i).attr("alt");
						var src=$(".lihunbox").find(".show_img").eq(i).attr("urlsrc");
						if(alt==src||src==undefined){
									$(".lihunbox").find(".show_img").eq(i).parent("label").addClass("imgcolor");
									$(".btn").removeClass("btnok");
									$.alert("离异证明不完整！");
									return;
						}else{
							$(".lihunbox").find(".show_img").eq(i).parent("label").removeClass("imgcolor");
						}
					}
				}
	}
	if($(".page3").find(".buyothers").length>0){
		var buyothersbox=$(".buyothers").find(".buyothersbox");
		for (var i = 0; i < buyothersbox.length; i++) {
			var name=$(".buyothers").find(".buyothersbox").eq(i).attr("name");
			for (var k = 0; k < 5; k++) {
					var alt=$(".buyothers").find(".buyothersbox").eq(i).find(".buyimg"+(1+k)).attr("alt");
			        var src=$(".buyothers").find(".buyothersbox").eq(i).find(".buyimg"+(1+k)).attr("urlsrc");
			        if(alt==src||src==undefined){
						$(".buyothers").find(".buyothersbox").eq(i).find(".buyimg"+(1+k)).parent("label").addClass("imgcolor");
						$(".btn").removeClass("btnok");
						$.alert("其他购房人("+name+")的材料不完整！");
						return;
					}
			}	
		}
	}
var havehouse=$("body").attr('havehouse');
if(havehouse=='是'){
	var hzhousebox=$(".hzhousebox").find(".show_img");
	if(hzhousebox.length<2){
			$(".hzhousebox").find(".show_img").eq(0).parent("label").addClass("imgcolor");
			$(".btn").removeClass("btnok");
			$.alert("杭州住房情况查询证明不完整！");
			return;
	}
	for (var i = 0; i < hzhousebox.length; i++) {
		console.log($(".hzhousebox").find(".show_img").eq(i).hasClass("inputconkong"))
		if(!$(".hzhousebox").find(".show_img").eq(i).hasClass("inputconkong")){
			var alt=$(".hzhousebox").find(".show_img").eq(i).attr("alt");
			var src=$(".hzhousebox").find(".show_img").eq(i).attr("urlsrc");
			if(alt==src||src==undefined){
						$(".hzhousebox").find(".show_img").eq(i).parent("label").addClass("imgcolor");
						$(".btn").removeClass("btnok");
						$.alert("杭州住房情况查询证明不完整！");
						return;
			}else{
				$(".hzhousebox").find(".show_img").eq(i).parent("label").removeClass("imgcolor");
			}
		}
	}
}
	var trustpeople=$(".trustpeople").find(".show_img");
	if(trustpeople.length<2){
			$(".trustpeople").find(".show_img").eq(0).parent("label").addClass("imgcolor");
			$(".btn").removeClass("btnok");
			$.alert("个人征信证明不完整！");
			return;
	}
	for (var i = 0; i < trustpeople.length; i++) {
		if(!$(".trustpeople").find(".show_img").eq(i).hasClass("inputconkong")){
			var alt=$(".trustpeople").find(".show_img").eq(i).attr("alt");
			var src=$(".trustpeople").find(".show_img").eq(i).attr("urlsrc");
			if(alt==src||src==undefined){
						$(".trustpeople").find(".show_img").eq(i).parent("label").addClass("imgcolor");
						$(".btn").removeClass("btnok");
						$.alert("个人征信证明不完整！");
						return;
			}else{
				$(".trustpeople").find(".show_img").eq(i).parent("label").removeClass("imgcolor");
			}
		}
	}
	if($(".lastinfo").find(".linanbox").length>0){
		var linanbox=$(".linanbox").find(".show_img");
		if(linanbox.length<2){
			$(".linanbox").find(".show_img").eq(0).parent("label").addClass("imgcolor");
		    $.alert("临安、桐庐、建德、淳安住房情况查询证明不完整！");
		    $(".btn").removeClass("btnok");
			return;
		}
		for (var i = 0; i < linanbox.length; i++) {
			if(!$(".linanbox").find(".show_img").eq(i).hasClass("inputconkong")){
				var alt=$(".linanbox").find(".show_img").eq(i).attr("alt");
				var src=$(".linanbox").find(".show_img").eq(i).attr("urlsrc");
				if(alt==src||src==undefined){
							$(".linanbox").find(".show_img").eq(i).parent("label").addClass("imgcolor");
							$(".btn").removeClass("btnok");
							$.alert("临安、桐庐、建德、淳安住房情况查询证明不完整！");
							return;
				}else{
					$(".linanbox").find(".show_img").eq(i).parent("label").removeClass("imgcolor");
				}
			}
		}
	}
	var zijinbox=$(".zijinbox").find(".show_img");
	if(zijinbox.length<2){
		$(".zijinbox").find(".show_img").eq(0).parent("label").addClass("imgcolor");
		$.alert("资金冻结证明不完整！");
		$(".btn").removeClass("btnok");
		return;
	}
	for (var i = 0; i < zijinbox.length; i++) {
		if(!$(".zijinbox").find(".show_img").eq(i).hasClass("inputconkong")){
			var alt=$(".zijinbox").find(".show_img").eq(i).attr("alt");
			var src=$(".zijinbox").find(".show_img").eq(i).attr("urlsrc");
			if(alt==src||src==undefined){
						$(".zijinbox").find(".show_img").eq(i).parent("label").addClass("imgcolor");
						$(".btn").removeClass("btnok");
						$.alert("资金冻结证明不完整！");
						return;
			}else{
				$(".zijinbox").find(".show_img").eq(i).parent("label").removeClass("imgcolor");
			}
		}
	}
	if($(".lastinfo").find(".security").length>0){
		var security=$(".security").find(".show_img");
		if(security.length<2){
			$(".security").find(".show_img").eq(0).parent("label").addClass("imgcolor");
			$.alert("社保证明或个税缴交证明不完整！");
			$(".btn").removeClass("btnok");
			return;
		}
		for (var i = 0; i < security.length; i++) {
			if(!$(".security").find(".show_img").eq(i).hasClass("inputconkong")){
				var alt=$(".security").find(".show_img").eq(i).attr("alt");
				var src=$(".security").find(".show_img").eq(i).attr("urlsrc");
				if(alt==src||src==undefined){
							$(".security").find(".show_img").eq(i).parent("label").addClass("imgcolor");
							$(".btn").removeClass("btnok");
							$.alert("社保证明或个税缴交证明不完整！");
							return;
				}else{
					$(".security").find(".show_img").eq(i).parent("label").removeClass("imgcolor");
				}
			}
		}
	}
$(".btn").addClass("btnok");
var phone=getlocalStorage("phone");
var idCardfront=$(".buyerbox").find(".buyimg1").attr("urlsrc");//身份证正面	
var idCardback=$(".buyerbox").find(".buyimg2").attr("urlsrc");//	身份证背面	
var accountBook=$(".buyerbox").find(".buyimg3").attr("urlsrc");//	户口本首页			
var accountBookpersonal=$(".buyerbox").find(".buyimg4").attr("urlsrc");//	户口本个人页				
var accountBookmain=$(".buyerbox").find(".buyimg5").attr("urlsrc");//	户口本主页		
//var marry=$(".buyerbox").find("#imgfilemarryimg").attr("src");//	结婚			
//var divorce_img=$(".buyerbox").find("#imgfiledivorceimg").attr("src");//	离婚	
//var death=$(".buyerbox").find("#imgfiledieimg").attr("src");//	死亡	
var marriage=$("body").attr("marry");
if(marriage=="已婚"){
	var marry=$(".buyerbox").find("#imgfilemarryimg").attr("urlsrc");//	结婚			
	var divorce_img="";//	离婚	
	var death="";//	死亡	
}else if(marriage=="未婚单身"){
	var marry="";//	结婚			
	var divorce_img="";//	离婚	
	var death="";//	死亡	
}else if(marriage=="离异单身(含带未成年子女)"){
	var marry="";//	结婚			
    var divorce_img=[];//	离婚;
for (var i = 0; i < $(".zijinbox").find(".show_img").length; i++) {
	if(!$(".lihunbox").find(".show_img").eq(i).hasClass("inputconkong")){
		var src=$(".lihunbox").find(".show_img").eq(i).attr("urlsrc");
		divorce_img[divorce_img.length]=src;
	}
}
var death="";//	死亡	
}else if(marriage=="丧偶"){
	var marry="";//	结婚			
	var divorce_img="";//	离婚	
    var death=$(".buyerbox").find("#imgfiledieimg").attr("urlsrc");//	死亡	
}
var other_img=[];
for (var i = 0; i < $(".buyotherszoo").find(".buyothersbox").length; i++) {
	var idCardfront1=$(".buyotherszoo").find(".buyothersbox").eq(i).find(".buyimg1").attr("urlsrc");//身份证正面
	var idCardback1=$(".buyotherszoo").find(".buyothersbox").eq(i).find(".buyimg2").attr("urlsrc");//	身份证背面	
    var accountBook1=$(".buyotherszoo").find(".buyothersbox").eq(i).find(".buyimg3").attr("urlsrc");//	户口本首页			
    var accountBookpersonal1=$(".buyotherszoo").find(".buyothersbox").eq(i).find(".buyimg4").attr("urlsrc");//	户口本个人页				
    var accountBookmain1=$(".buyotherszoo").find(".buyothersbox").eq(i).find(".buyimg5").attr("urlsrc");//	户口本主页	
    var idcard=$(".buyotherszoo").find(".buyothersbox").eq(i).attr('idcard');
	var data={};
	data.idCardfront=idCardfront1;
	data.idCardback=idCardback1;
	data.accountBook=accountBook1;
	data.accountBookpersonal=accountBookpersonal1;
	data.accountBookmain=accountBookmain1;
	data.idCard=idcard;
	other_img.push(data);
}
var housing_situation=[];
var havehouse=$("body").attr('havehouse');
if(havehouse=='是'){
	for (var i = 0; i < $(".hzhousebox").find(".show_img").length; i++) {
		if(!$(".hzhousebox").find(".show_img").eq(i).hasClass("inputconkong")){
			var src=$(".hzhousebox").find(".show_img").eq(i).attr("urlsrc");
			housing_situation[housing_situation.length]=src;
		}
	}
}else{
	housing_situation='';
}
var personal_credit=[];
for (var i = 0; i < $(".trustpeople").find(".show_img").length; i++) {
	if(!$(".trustpeople").find(".show_img").eq(i).hasClass("inputconkong")){
		var src=$(".trustpeople").find(".show_img").eq(i).attr("urlsrc");
		personal_credit[personal_credit.length]=src;
	}
}
var fund_freezing=[];
for (var i = 0; i < $(".zijinbox").find(".show_img").length; i++) {
	if(!$(".zijinbox").find(".show_img").eq(i).hasClass("inputconkong")){
		var src=$(".zijinbox").find(".show_img").eq(i).attr("urlsrc");
		fund_freezing[fund_freezing.length]=src;
	}
}
var other_housing_situation=[];
if($(".lastinfo").find(".linanbox").length>0){
	for (var i = 0; i < $(".linanbox").find(".show_img").length; i++) {
		if(!$(".linanbox").find(".show_img").eq(i).hasClass("inputconkong")){
			var src=$(".linanbox").find(".show_img").eq(i).attr("urlsrc");
			other_housing_situation[other_housing_situation.length]=src;
		}
	}
}
var security_img=[];
if($(".lastinfo").find(".security").length>0){
	for (var i = 0; i < $(".security").find(".show_img").length; i++) {
		if(!$(".security").find(".show_img").eq(i).hasClass("inputconkong")){
			var src=$(".security").find(".show_img").eq(i).attr("urlsrc");
			security_img[security_img.length]=src;
		}
	}
}

var status=$("body").attr("status");
if(status=="审核中"){
	$.alert("您的资料正在审核中,不可修改!","提示",function(){
		window.location.replace("showdata.html");
	})
	return;
}
if(status=="审核通过"){
	$.alert("您提交过资料，审核通过，不能修改！","提示");
	window.location.replace("showdata.html");
	return;
}
console.log(other_img)
$.ajax({//获取补充信息
    url: ajaxurl+'/api/add',
    data: {
    	"phone":phone,
    	"idCardfront":idCardfront,
    	"idCardback":idCardback,
    	"accountBook":accountBook,
    	"accountBookmain":accountBookmain,
    	"accountBookpersonal":accountBookpersonal,
    	"other_housing_situation":other_housing_situation,
    	"housing_situation":housing_situation,
    	"security_img":security_img,
    	"divorce_img":divorce_img,
    	"personal_credit":personal_credit,
    	"fund_freezing":fund_freezing,
    	"other_img":other_img,
    	"death":death,
    	"marry":marry
    },
    type: 'POST',
    success: function (obj) {
        if(obj.code == 200){
        	console.log(obj);
        	var v=Math.random();
        	$.toast("保存成功", 200,function(){
					window.location.replace("showdata.html?v="+v)
			});
        }else{
           if(obj.msg=='登录失效,请重新登录'){
				var v=Math.random();
			    window.location.href="pre.html?v="+v;
			}
        }
    },
    error:function(msg){
    	console.log(msg)
    }
}); 
})
$(".page3").on("click",".imgfileboxcancel",function(){
var gettionid=$(this).parent(".inputcon").find(".show_img").attr("id");
setlocalStorage(gettionid,null);
//var v=$(this).parents(".imglist").attr("v");
//var vlength=getlocalStorage(v+"length");
//setlocalStorage(v+"length",vlength-1);
//console.log(vlength);
//console.log(gettionid);
	if($(this).hasClass("inlistimg")){
		console.log("这是数组");
		var v=$(this).parents(".imglist").attr("v");
		var gettionsrc=$(this).parent(".inputcon").find(".show_img").attr("urlsrc");
		console.log(gettionsrc+"----------src")
		var vstorage=getlocalStorage(v);
		if(vstorage!=null&&vstorage!="null"){
			var vlength=getlocalStorage(v+"length");
			setlocalStorage(v+"length",vlength-1);
			vstorage=JSON.parse(vstorage);
			var imglength=0;
			for (var i = 0; i < vstorage.length; i++) {
				if(gettionsrc==vstorage[i]&&imglength==0){
					console.log(gettionsrc+"----------src")
					imglength=1;
					vstorage.splice(i,1);
				}
			}
			console.log(vstorage)
			vstorage=JSON.stringify(vstorage)
			setlocalStorage(v,vstorage);
		}
		
		
		
		$(this).parents(".imglist").addClass("thatimglist");
		$(this).parent(".inputcon").remove();
		var inputcon=$(".thatimglist").find(".inputcon");
		for (var i = 0; i < inputcon.length; i++) {
			console.log(i)
			$(".thatimglist").find(".inputcon").eq(i).find("label").attr("for","imgfiles1s"+v+(i));
			$(".thatimglist").find(".inputcon").eq(i).find("label").find("img").attr("id","imgfilesimg1s"+v+(i));
			$(".thatimglist").find(".inputcon").eq(i).find("input").attr("id","imgfiles1s"+v+(i));
			$(".thatimglist").find(".inputcon").eq(i).find("input").attr("onchange",'javascript:setImagePreview('+"'imgfiles1s"+v+(i)+"','imgfilesimg1s"+v+(i)+"','list','"+v+"');");
		}
		$(".imglist").removeClass("thatimglist");
		hidebg();
		return;
	}else{
		console.log("这是单张图片")
		var showimg=$(this).parent(".inputcon").find(".show_img").attr("alt");
		$(this).parent(".inputcon").find(".show_img").attr("src",showimg);
		$(this).parent(".inputcon").find("input").val("");
		$(this).hide();
		hidebg();
	}
})


$(".bigimgshow").click(function(){
	var thisv=$(this).attr("v");
	$(".zzc").show();
	$(".zzc img").hide();
	$(".example"+thisv).show();
})
	
$(".zzcclose").click(function(){
	$(".zzc").hide();
})	
	$(".imgback").click(function(){
		$(".zzc").hide();
	});	
	
	
})

/**
 * Created by ROOT on 2016/12/14.
 */

/**
 * @param source    图片源的表单
 * @param show      要展示图片的div
 * @param async     图片处理完成后要进行的操作，如ajax上传。等信息
 */
function imageProcess(source,show,async,view,v,imgsrc,file,list) {
    //监听图片源表单的改变事件
//  source.change(function () {
	$.hideLoading();
	$.showLoading("处理图片");
    	var _this=source
        var files = _this.files;
        if(files[0]==undefined||files[0]==null||files[0]=="null"||files[0]=='undefined'){
				$.hideLoading();
				$.toast("请选择一张图片", "cancel");
				isuploading=false;
				return;
		}
        if(files.length>1){
        	$.toast("请只选择一张图片", "cancel");
        	isuploading=false;
        	return;
        }
        if(files.length){
            var isImage = checkFile(_this.files);
            if(!isImage){
                $.toast("文件类型有误!", "cancel");
                isuploading=false;
        	    return;
            }else{
	           console.log("处理图片");
	           console.log(isImage);
                var reader = new FileReader();
                reader.onload = function(e){
                    var imageSize = e.total;//图片大小
                    var image = new Image();
                    image.src = e.target.result;
                    image.onload = function () {
                        // 旋转图片
                        var newImage = rotateImage(image)
                        show.attr('src',newImage.src);
                        newImage = judgeCompress(newImage,imageSize);
                        
//                      var newImage = judgeCompress(image,imageSize);
//                      $.hideLoading();
//                      $('body').append(newImage);
//						 alert(1693)
//						return;
//                         console.log(newImage.src)
//                      show.attr('src',newImage.src);
                        //压缩图片
                        
                        newImage.setAttribute('width','100%');
                        async(newImage.src,view,v,imgsrc,file,list);
                    }
                }
                reader.readAsDataURL(isImage);
            }
        }
//  })
}

/**
 * 检查文件是否为图像类型
 * @param files         FileList
 * @returns file        File
 */
function checkFile(files){
    
    var file = files[0];
    console.log(file.type)
//  alert(file.type)
    //使用正则表达式匹配判断
    if(!/image\/\w+/.test(file.type)){
        return false;
    }
    return file;
}

/**
 * 判断图片是否需要压缩
 * @param image          HTMLImageElement
 * @param imageSize      int
 * @returns {*}          HTMLImageElement
 */
function judgeCompress(image,imageSize) {
    //判断图片是否大于300000 bit
    var threshold = 300000;//阈值,可根据实际情况调整
    console.log('imageSize:'+imageSize/1024/1024+'M')
    if(imageSize>threshold){
    	$.hideLoading();
	    $.showLoading("压缩图片"); 
	    console.log('压缩图片')
	    var canvas = document.createElement('canvas')
	    var ctx = canvas.getContext('2d');
	    var imageLength = image.src.length;
	    var width = image.width;
	    var height = image.height;
	    canvas.width = width;
	    canvas.height = height;
	    ctx.drawImage(image, 0, 0, width, height);
    	var quality = 0.7;//图片质量  范围：0<quality<=1 根据实际需求调正
        var imageData = canvas.toDataURL("image/jpeg", quality);
        var newImage = new Image()
        newImage.src = imageData
        console.log('imageSize:'+imageData.length/1024/1024+'M')
        return newImage;
    }else {
    	console.log('不压缩图片')
        return image;
    }
}



/**
 * 旋转图片
 * @param image         HTMLImageElement
 * @returns newImage    HTMLImageElement
 */
function rotateImage(image) {
    console.log('rotateImage');

    var width = image.width;
    var height = image.height;

         //以下改变一下图片大小
//       var maxSide = Math.max(width, height);
//       if (maxSide > 1024) {
//           var minSide = Math.min(width, height);
//           minSide = minSide / maxSide * 1024;
//           maxSide = 1024;
//           if (width > height) {
//               width = maxSide;
//               height = minSide;
//           } else {
//               width = minSide;
//               height = maxSide;
//           }
//     }
//alert(width)
    var canvas = document.createElement("canvas")
    var ctx = canvas.getContext('2d');
    var newImage = new Image();
    newImage.src=image.src;
	$.hideLoading();
	$.showLoading("旋转图片");  
    //旋转图片操作
    EXIF.getData(image,function () {
            var orientation = EXIF.getTag(this,'Orientation');
            // orientation = 6;//测试数据
            console.log('orientation:'+orientation);
//        alert(orientation)
          switch(orientation){
                        case 6:     // 旋转90度
//                          console.log('旋转90°');
		                    canvas.height = width;
		                    canvas.width = height;
		                    ctx.rotate(Math.PI/2);
		                    ctx.translate(0,-height);
		                    ctx.drawImage(image,0,0)
		                    imageDate = canvas.toDataURL('Image/jpeg',1)
		                    newImage.src = imageDate;
		                    break;
		                    //旋转180°
                        case 3:     // 旋转180度
                            ctx.rotate(Math.PI);    
                            ctx.drawImage(image, -imgWidth, -imgHeight);
                            imageDate = canvas.toDataURL('Image/jpeg',1)
                            newImage.src = imageDate;
                            break;
                        case 8:     // 旋转-90度
                            canvas.width = imgHeight;    
                            canvas.height = imgWidth;    
                            ctx.rotate(3 * Math.PI / 2);    
                            ctx.drawImage(image, -imgWidth, 0);
                            imageDate = canvas.toDataURL('Image/jpeg',1)
                            newImage.src = imageDate;
                            break;
                        case undefined:
		                    console.log('undefined  不旋转');
		                    newImage = image;
		                    break;
                   }
                   return newImage;
      });
    return newImage;
}