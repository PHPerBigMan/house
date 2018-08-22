$(document).ready(function(){
	$(".navbox>div").click(function(){
		var v=$(this).attr("v");
		$(".navbox>div").removeClass("active");
		$(this).addClass("active");
		$(".change1").hide();$(".change2").hide();
		$(".change"+v).show();
	})
	
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
var posturl="http://tianyangweilan.shoufangpai.com";
var phone=getlocalStorage("phone")
get1();
function get1(){
$.ajax({
		url:posturl+"/api/get",
		type:"post",
		async:false,
		data:{
			"phone":phone,
			"type":1
		},
		success:function(obj){
			console.log(obj)
			if(obj.code==200){
				
				$(".marriage").html(obj.data.marriage);
				if(obj.data.otherHouse!=null){
					$(".nothzHouse").html(obj.data.otherHouse);	
				}else{
					$(".nothzHousebox").hide();	
				}
				if(obj.data.marriage=="离异单身(含带未成年子女)"){
					$(".divorce").html(obj.data.divorce)
				}else{
					$(".divorcebox").hide();
				}
				get2();
			}else{
				if(obj.msg){
					 $.alert(obj.msg,"提示",function(){})
				}else{
					$.alert("系统错误");
					console.log(obj)
				}
				
			}
		},
		error:function(){
			$(".pagepre .btn").addClass("btnok");
            $.alert("请检查您的网络，稍后再试！","提示",function(){
            	
            })
		}
	});	
}

function get2(){
	

	
$.ajax({
		url:posturl+"/api/get",
		type:"post",
		async:false,
		data:{
			"phone":phone,
			"type":2
		},
		success:function(obj){
			console.log(obj)
			if(obj.code==200){
			$(".buyername").html(obj.data.name)	;
			$(".cardType").html(obj.data.cardType)	;
			$(".idCard").html(obj.data.idCard);
			$(".haveHouse").html(obj.data.haveHouse);	
			$(".nothzHouse").html(obj.data.nothzHouse);		
			$(".loan").html(obj.data.loan);	
			$(".down").html(obj.data.down);	
			$(".sale").html(obj.data.sale);
			$(".pay").html(obj.data.pay);		
			$("body").attr("other",obj.data.other.length);
			if(obj.data.child.length==0&&obj.data.other.length==0){
				$(".others").hide()
			}else{
				
				var str="";
				for (var i = 0; i < obj.data.child.length; i++) {
					str=str+'<p class="otherszoop">未成年子女信息</p><div class="otherszoobox"><div class="otherszooboxheader">未成年子女'+(i+1)+'</div>';
					str=str+'<div class="otherslinebox"><div class="otherslineboxleft">姓名</div><div class="otherslineboxright ">'+obj.data.child[i].name;
					str=str+'</div></div><div class="otherslinebox"><div class="otherslineboxleft">身份证号</div><div class="otherslineboxright ">'+obj.data.child[i].idCard+'</div></div></div>';
				}
				
				if(obj.data.child.length>0&&obj.data.other.length>0){
					str=str+'<hr class="hr" style="color: #efeff4;" />';
				}
				
				for (var i = 0; i < obj.data.other.length; i++) {
					if(i==0){
						var marriage=$(".marriage").text();
						if(marriage=="已婚"){
							str=str+'<p class="otherszoop">其他购房人信息</p><div class="otherszoobox"><div class="otherszooboxheader">其他购房人（配偶）</div>';
						}else{
							str=str+'<p class="otherszoop">其他购房人信息</p><div class="otherszoobox"><div class="otherszooboxheader">其他购房人'+(i+1)+'</div>';
						}
						
					}else{
						str=str+'<p class="otherszoop">其他购房人信息</p><div class="otherszoobox"><div class="otherszooboxheader">其他购房人'+(i+1)+'</div>';
					}
					
					str=str+'<div class="otherslinebox"><div class="otherslineboxleft">姓名</div><div class="otherslineboxright ">'+obj.data.other[i].name;
					str=str+'</div></div><div class="otherslinebox"><div class="otherslineboxleft">证件类型</div><div class="otherslineboxright ">'+obj.data.other[i].cardType+'</div></div>';
				    str=str+'<div class="otherslinebox"><div class="otherslineboxleft">身份证号</div><div class="otherslineboxright ">'+obj.data.other[i].idCard+'</div></div>'
				     str=str+'<div class="otherslinebox"><div class="otherslineboxleft">手机号码</div><div class="otherslineboxright ">'+obj.data.other[i].phone+'</div></div></div>'
				}
				
				
				$(".otherszoo").html(str);
				
				
			}
			if(obj.data.file.length==0){
				$(".houses").hide();
			}else{
				var str="";
				for (var i = 0; i < obj.data.file.length; i++) {
					str=str+'<div class="linebox"><div class="lineboxleft">查档编号'+(1+i)+'</div>';
					str=str+'<div class="lineboxright">'+obj.data.file[i]+'</div></div>'
				}
				$(".houseszoo").html(str);
			}
			
			
			
					
		get3(obj);
				
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
}	
function get3(ele){
	

$.ajax({
		url:posturl+"/api/get",
		type:"post",
		async:false,
		data:{
			"phone":phone,
			"type":3
		},
		success:function(obj){
			console.log(obj)
			if(obj.code==200){
				if(obj.data==null){
					return;
				}
				
				
				
				$(".accountBook img").attr("src",obj.data.accountBook)
				$(".accountBookpersonal img").attr("src",obj.data.accountBookpersonal)
				$(".idCardfront img").attr("src",obj.data.idCardfront);
				$(".accountBookmain img").attr("src",obj.data.accountBookmain);
				$(".idCardback img").attr("src",obj.data.idCardback)
				if(obj.data.marry==null||obj.data.marry=="null"){
					$(".change2 .marry").hide();
				}else{
					$(".change2 .marry").show();
					$(".marry img").attr("src",obj.data.marry)
				}
				
				if(obj.data.death==null||obj.data.death=="null"){
					$(".change2 .death").hide();
				}else{
					$(".change2 .death").show();
					$(".death img").attr("src",obj.data.death)
				}
				if(obj.data.divorce_img==null||obj.data.divorce_img=="null"||obj.data.divorce_img.length==0){
					$(".change2 .divorce_img").hide();
				}else{
					$(".change2 .divorce_img").show();
					var str="";
					for (var i = 0; i < obj.data.divorce_img.length; i++) {
						str=str+'<img src="'+obj.data.divorce_img[i]+'" />';
					}
					$(".change2 .divorce_img").find(".imgbox").append(str);
				}
				var other=$("body").attr("other");
				
				if(obj.data.other_img==null||obj.data.other_img=="null"||obj.data.other_img.length==0||other==0){
					$(".change2 .othersimg").hide();
				}else{
					$(".change2 .othersimg").show();
					var str="";
					for (var i = 0; i < obj.data.other_img.length; i++) {
						str=str+'<div class="otherslist otherslist'+i+'" v="'+ele.data.other[i].name+'" at="'+i+'"> <div  class="pimgbox"><p class="otherszoop idCardfront">'+ele.data.other[i].name+'身份证正面</p><div class="imgbox"><img src="'+obj.data.other_img[i].idCardfront+'" /></div></div>';
						str=str+'<div class="pimgbox"><p class="otherszoop idCardback">'+ele.data.other[i].name+'身份证背面</p><div class="imgbox"><img src="'+obj.data.other_img[i].idCardback+'" /></div></div>';
						str=str+'<div class="pimgbox"><p class="otherszoop accountBook">'+ele.data.other[i].name+'户口本首页</p><div class="imgbox"><img src="'+obj.data.other_img[i].accountBook+'" /></div></div>';
						str=str+'<div class="pimgbox"><p class="otherszoop accountBookmain">'+ele.data.other[i].name+'户口本主页</p><div class="imgbox"><img src="'+obj.data.other_img[i].accountBookmain+'" /></div></div>';
						str=str+'<div class="pimgbox"><p class="otherszoop accountBookpersonal">'+ele.data.other[i].name+'户口本个人页</p><div class="imgbox"><img src="'+obj.data.other_img[i].accountBookpersonal+'" /></div></div></div>';
					}
					$(" .othersimgzoo").append(str);
				}
				    var str="";
					for (var i = 0; i < obj.data.housing_situation.length; i++) {
						if(obj.data.housing_situation.length==1){
							str=str+'<div class="pimgbox"><p class="otherszoop housing_situation">杭州住房证明</p><div class="imgbox"><img  src="'+obj.data.housing_situation[i]+'"/></div></div>';
						}else{
							str=str+'<div class="pimgbox"><p class="otherszoop housing_situation">杭州住房证明'+(i+1)+'</p><div class="imgbox"><img src="'+obj.data.housing_situation[i]+'"/></div></div>';
					    }
					}
					
					
					
					
					$(" .othersimginfomore").append(str);
					
					
					
					
					if(obj.data.other_housing_situation==null||obj.data.other_housing_situation=="null"||obj.data.other_housing_situation.length==0){
					
					}else{
						 var str="";
						for (var i = 0; i < obj.data.other_housing_situation.length; i++) {
							if(obj.data.other_housing_situation.length==1){
								str=str+'<div class="pimgbox"><p class="otherszoop other_housing_situation">杭州四县住房证明</p><div class="imgbox"><img src="'+obj.data.other_housing_situation[i]+'"/></div></div>';
							}else{
								str=str+'<div class="pimgbox"><p class="otherszoop other_housing_situation">杭州四县住房证明'+(i+1)+'</p><div class="imgbox"><img src="'+obj.data.other_housing_situation[i]+'"/></div></div>';
						    }
						}
						$(" .othersimginfomore").append(str);
					}
					
					if(obj.data.personal_credit==null||obj.data.personal_credit=="null"||obj.data.personal_credit.length==0){
					
					}else{
						 var str="";
						for (var i = 0; i < obj.data.personal_credit.length; i++) {
							if(obj.data.personal_credit.length==1){
								str=str+'<div class="pimgbox"><p class="otherszoop personal_credit">征信证明</p><div class="imgbox"><img src="'+obj.data.personal_credit[i]+'"/></div></div>';
							}else{
								str=str+'<div class="pimgbox"><p class="otherszoop personal_credit">征信证明'+(i+1)+'</p><div class="imgbox"><img src="'+obj.data.personal_credit[i]+'"/></div></div>';
						    }
						}
						$(" .othersimginfomore").append(str);
					}
					
					
					if(obj.data.fund_freezing==null||obj.data.fund_freezing=="null"||obj.data.fund_freezing.length==0){
					
					}else{
						 var str="";
						for (var i = 0; i < obj.data.fund_freezing.length; i++) {
							if(obj.data.fund_freezing.length==1){
								str=str+'<div class="pimgbox"><p class="otherszoop fund_freezing">银行存款证明</p><div class="imgbox"><img src="'+obj.data.fund_freezing[i]+'"/></div></div>';
							}else{
								str=str+'<div class="pimgbox"><p class="otherszoop fund_freezing">银行存款证明'+(i+1)+'</p><div class="imgbox"><img src="'+obj.data.fund_freezing[i]+'"/></div></div>';
						    }
						}
						$(" .othersimginfomore").append(str);
					}
					
					
					if(obj.data.security_img==null||obj.data.security_img=="null"||obj.data.security_img.length==0){
					
					}else{
						 var str="";
						for (var i = 0; i < obj.data.security_img.length; i++) {
							if(obj.data.security_img.length==1){
								str=str+'<div class="pimgbox"><p class="otherszoop security_img">社保证明或个税缴交证明</p><div class="imgbox"><img src="'+obj.data.security_img[i]+'"/></div></div>';
							}else{
								str=str+'<div class="pimgbox"><p class="otherszoop security_img">社保证明或个税缴交证明'+(i+1)+'</p><div class="imgbox"><img src="'+obj.data.security_img[i]+'"/></div></div>';
						    }
						}
						$(" .othersimginfomore").append(str);
					}
                   $(".headbox span").html(obj.data.status);
                   if(obj.data.status=="审核通过"){
                    	$(".seedataimg").show();
                   }
				if(obj.data.status=="审核不通过"){
					$(".reset").show();
                    $(".weui-icon_msg.iconcolor").removeClass("weui-icon-info");
                    $(".weui-icon_msg.iconcolor").addClass("weui-icon-warn");
					if(obj.data.error==null){
//						return;
					}else{
						for (var i = 0; i < obj.data.error.length; i++) {
							var pnode=$(".changebox2buyer .pimgbox ."+obj.data.error[i].key).parent(".pimgbox").find("p").text();
							var ptext=pnode+"(审核不通过原因:"+obj.data.error[i].reason+")";
							$(".changebox2buyer .pimgbox ."+obj.data.error[i].key).parent(".pimgbox").find("p").text(ptext);
							$(".changebox2buyer .pimgbox ."+obj.data.error[i].key).parent(".pimgbox").find("p").addClass("errorp");
							$(".changebox2buyer .pimgbox ."+obj.data.error[i].key).parent(".pimgbox").find("img").addClass("redborder")
						}
					}
					
					console.log(obj.data.othererror)
					if(obj.data.othererror!=null&&obj.data.othererror!="null"){
						console.log($(".otherslist").eq(k).attr("v"))
							if(obj.data.othererror.length>0){
								for (var i = 0; i < obj.data.othererror.length; i++) {
									console.log($(".otherslist").eq(k).attr("v"))
									for (var k = 0; k< $(".otherslist").length; k++) {
										console.log($(".otherslist").eq(k).attr("v"))
										if($(".otherslist").eq(k).attr("v")==obj.data.othererror[i].name){
											var at=$(".otherslist").eq(k).attr("at");
											console.log(at)
										var ptext=$(".otherslist"+at).find("."+obj.data.othererror[i].key).text();
										$(".otherslist"+at).find("."+obj.data.othererror[i].key).text(ptext+"(审核不通过原因:"+obj.data.othererror[i].reason+")");
										$(".otherslist"+at).find("."+obj.data.othererror[i].key).addClass("errorp");
										$(".otherslist"+at).find("."+obj.data.othererror[i].key).parent(".pimgbox").find("img").addClass("redborder");
											
										}
									}
								}
							}
						}
					
					
					
					
				}
                   
                   
				
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
	
	
}	

$(".reset").click(function(){
var posturl="http://tianyangweilan.shoufangpai.com";
var phone=getlocalStorage("phone")
	$.ajax({
		url:posturl+"/api/sendAgain",
		type:"post",
		async:false,
		data:{
			"phone":phone
		},
		success:function(obj){
			console.log(obj)
			if(obj.code==200){
				window.location.replace("index.html");
			}else{
			   $.alert(obj.msg,"提示",function(){})
			}
		},
		error:function(){
            $.alert("请检查您的网络，稍后再试！","提示",function(){
            	
            })
		}
	});	
})

$(".change2").on("click",".imgbox img",function(){
	var src=$(this).attr("src");
	$(".zzc img").attr("src",src);
	$(".zzc").show();
})
$(".zzc").click(function(){
	$(this).hide();
})




})