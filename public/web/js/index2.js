$(document).ready(function(){
$.showLoading();  
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
if(phone==null||phone=="null"||phone==undefined||phone=="undefined"||phone==""){//判断登录
	window.location.href="pre.html";
	return;
}
pageInit();
function pageInit(){
	var phone=getlocalStorage("phone")
	var posturl=ajaxurl;
	$.ajax({
		url:posturl+"/api/get",
		type:"post",
		async:false,
		data:{
			"phone":phone,
			"type":1
		},
		success:function(obj){
			console.log(obj);
			if(obj.code==200){
			  if(obj.data.divorce == null && obj.data.household == null && obj.data.hzHouse == null && obj.data.marriage == null && obj.data.otherHouse == null){
	                console.log('没有填写第一步的资料');
	                var v=Math.random();
	                window.location.href='index.html?v='+v;
			  }else{
					$("body").attr("marriage",obj.data.marriage);
					$("body").attr("divorce",obj.data.divorce);
					$("body").attr("hzHouse",obj.data.hzHouse);
					$("body").attr("otherHouse",obj.data.otherHouse);
					$("body").attr("household",obj.data.household);
					if(obj.data.household=="非杭州户籍"){
						$(".nohzpeople").show();
					}
					if(obj.data.marriage=="未婚单身"){
						$(".marriage").hide();
						$(".addzoomarriage").hide();
					}else if(obj.data.marriage=="离异单身(含带未成年子女)"){
						$(".marriage").hide();
						$(".addzoomarriageshow").show();
					}else if(obj.data.marriage=="已婚"){
						$(".marriage").hide();
						$(".addzoomarriageshow").show();
						$(".buyinfobtn").hide();
						$(".buyinfozoo").show()
						$(".buyinfozoo1").find(".reduceicon").hide();
					    $(".buyinfozoo1").find(".addzoochildheadspan").html("(配偶)");
					}else if(obj.data.marriage=="丧偶"){
						console.log(680)
						$(".marriage").hide();
						$(".addzoomarriageshow").show();
					}
					 getdata2();
			  }
			}else{
				$.alert(obj.msg,function(){
	            	if(obj.msg=='登录失效,请重新登录'){
						var v=Math.random();
					    window.location.href="pre.html?v="+v;
				    }
	            });
			}
		},
		error:function(){
            $.alert("请检查您的网络，稍后再试！","提示",function(){
            	var v=Math.random();
				window.location.href="pre.html?v="+v;
            })
		}
	});	
}

function getdata2(){
var phone=getlocalStorage("phone")
var posturl=ajaxurl;
$.ajax({//获取补充信息
    url: posturl+'/api/get',
    data: {
    	"phone":phone,
    	"type":2
    },
    type: 'POST',
    success: function (obj) {
        if(obj.code == 200){
            console.log(obj)
            if(obj.data.name==null){
            	console.log('没有填写第二步的资料');
            	showgetlocalStorage();
				return;
			}
            if(obj.data.name!=null&&obj.data.name!="null"){
            	$("#buyer1").val(obj.data.name);
            }
             if(obj.data.idCard!=null&&obj.data.idCard!="null"){
            	$("#buyer3").val(obj.data.idCard);
            }
            if(obj.data.sale!=null&&obj.data.sale!="null"){
            	$("#buyer9").val(obj.data.sale);
            }
            if(obj.data.cardType!=null&&obj.data.cardType!="null"){
            	$(".buyer2 .mustspan").html(obj.data.cardType);
            	$(".buyer2 .mustspan").addClass("color333");
            	$("#buyer2").val(obj.data.cardType)
            }
            checksfz();
            if(obj.data.haveHouse!=null&&obj.data.haveHouse!="null"){
            	$(".buyer4 .mustspan").html(obj.data.haveHouse);
            	$(".buyer4 .mustspan").addClass("color333");
            	$("#buyer4").val(obj.data.haveHouse)
            }
            if(obj.data.nothzHouse!=null&&obj.data.nothzHouse!="null"){
            	$(".buyer5 .mustspan").html(obj.data.nothzHouse);
            	$(".buyer5 .mustspan").addClass("color333");
            	$("#buyer5").val(obj.data.nothzHouse)
            }
            if(obj.data.loan!=null&&obj.data.loan!="null"){
            	$(".buyer6 .mustspan").html(obj.data.loan);
            	$(".buyer6 .mustspan").addClass("color333");
            	$("#buyer6").val(obj.data.loan)
            }
            if(obj.data.pay!=null&&obj.data.pay!="null"){
            	$(".buyer7 .mustspan").html(obj.data.pay);
            	$(".buyer7 .mustspan").addClass("color333");
            	$("#buyer7").val(obj.data.pay)
            }
            if(obj.data.down!=null&&obj.data.down!="null"){
            	$(".buyer8 .mustspan").html(obj.data.down);
            	$(".buyer8 .mustspan").addClass("color333");
            	$("#buyer8").val(obj.data.down)
            }
            if(obj.data.parking!=null&&obj.data.parking!="null"){
            	$(".buyer12 .mustspan").html(obj.data.parking);
            	$(".buyer12 .mustspan").addClass("color333");
            	$("#buyer12").val(obj.data.parking)
            }
            
            if(obj.data.generation!=null&&obj.data.generation!="null"){
            	$(".buyer10 .mustspan").html(obj.data.generation);
            	$(".buyer10 .mustspan").addClass("color333");
            	$("#buyer10").val(obj.data.generation)
            }
            
            if(obj.data.area!=null&&obj.data.area!="null"){
            	$(".buyer11 .mustspan").html(obj.data.area);
            	$(".buyer11 .mustspan").addClass("color333");
            	$("#buyer11").val(obj.data.area)
            }
            if(obj.data.file!=null&&obj.data.file!="null"){
            	if(obj.data.file.length>1){
            		var str="";
            		for (var i = 0; i < obj.data.file.length; i++) {
            			if(i==0){
            				$(".danumberinput").val(obj.data.file[0]);
            			}else{
            				str= str+'<div class="danumber"><div class="boxfff1left">查档编号'+(i+1)+'</div><div class="boxfff1right"><div class="removedanum"><img class="removedanumicon" src="img/reduce.png"></div><input type="text" name="" class="danumberinput" value="'+obj.data.file[i]+'" placeholder="请输入编号"></div></div>	'
            			}
	            	}
            		$(".bhzoo").append(str);
            	}else{
            		$(".danumberinput").val(obj.data.file[0]);
            	}
            }
            
            var marriage=$("body").attr("marriage");
            if(marriage=="未婚单身"){
            	$(".addzoomarriageshow").hide();
            	$(".addzoomarriage").hide();
            }else{
	            if(obj.data.child!=null&&obj.data.child!="null"&&obj.data.child.length>0){
	            	$(".addzoomarriageshow").hide();
	            	$(".addzoomarriage").show();
	            	if(obj.data.child.length>1){
	            		var str="";
	            		var addzoochild1=$(".addzoomarriage").find(".addzoochild");
	            		for (var i = 0; i <obj.data.child.length; i++) {
	            			if(i==0){
	            				$(".childname1").val(obj.data.child[0].name);
	            		        $(".childcard1").val(obj.data.child[0].idCard)
	            			}else{
	            					
								str=str+'<div class="addzoochild marginbottom marbottom40">';
								str=str+'<div class="addzoochildhead">未成年子女<span class="addzoochildheadspan">'+(1+addzoochild1.length)+'</span>';
								str=str+'<img class="reduceicon" src="img/reduce.png"/></div><div class="addzoochildbox">';
								str=str+'<div class="addzoochildboxleft">子女姓名</div><div class="addzoochildboxright">';
								str=str+'<input type="text"  class="childname childname'+(1+addzoochild1.length)+'" name="" id="" value="'+obj.data.child[i].name+'" placeholder="请输入子女姓名" />'
								str=str+'</div></div><div class="addzoochildbox borderbottomnone"><div class="addzoochildboxleft">身份证号</div>';			
								str=str+'<div class="addzoochildboxright"><input type="text" v="'+(1+addzoochild1.length)+'" class="childcard childcard'+(1+addzoochild1.length)+'" name="" id="" value="'+obj.data.child[i].idCard+'" placeholder="请输入证件号码" /></div></div></div>';											
								$(".jsadd").append(str)	;
	            			}
	            		}
	            	}else{
	            		$(".childname1").val(obj.data.child[0].name);
	            		$(".childcard1").val(obj.data.child[0].idCard)
	            	}
	            }
            }
            if(obj.data.other!=null&&obj.data.other!="null"&&obj.data.other.length>0){
            	$(".buyinfozoo").show();
            	$(".buyinfobtn").hide();
            	if(obj.data.other.length>1){
            		
            		var addzoochild=$(".buyinfozoo").find(".addzoochild");
            		var str="";
            		
            		for (var i = 0; i < obj.data.other.length; i++) {
            			if(i==0){
            				$(".buyothersname1").val(obj.data.other[0].name);
		            		$(".buyothersnum1").val(obj.data.other[0].idCard);
		            		$(".buyothersphone1").val(obj.data.other[0].phone);
		            		$(".addid1 .mustspan").html(obj.data.other[0].cardType);
		            		$("#addid1").val(obj.data.other[0].cardType);
            			}else{
							str=str+'<div class="addzoochild"><div class="addzoochildhead">其他购房人<span class="addzoochildheadspan">'+(1+addzoochild.length)+'</span><img class="reduceicon" src="img/reduce.png"/>';
							str=str+'</div><div class="addzoochildbox"><div class="addzoochildboxleft">姓名</div><div class="addzoochildboxright">';
							str=str+'<input type="text" class="buyothersname buyothersname'+(1+addzoochild.length)+'" name="" id="" value="'+obj.data.other[i].name+'" placeholder="请输入姓名" />'
						    str=str+'</div></div><div class="addzoochildbox"><div class="addzoochildboxleft">证件类型</div>';
						    str=str+'<input class="weui-input" id="addid'+(1+addzoochild.length)+'" class="" type="text" value="'+obj.data.other[i].cardType+'" readonly="">'
						    str=str+'<div class="addzoochildboxright"><label class="lineboxright alinkaddid alink addid'+(1+addzoochild.length)+'" for="addid'+(1+addzoochild.length)+'">';
						    str=str+'<span class="color333 mustspan">'+obj.data.other[i].cardType+'</span> <img class="imggo alink" src="img/go.png"/></label></div></div>';
						    str=str+'<div class="addzoochildbox"><div class="addzoochildboxleft">证件号码</div>';
						    str=str+'<div class="addzoochildboxright"><input type="text" name="" v="'+(1+addzoochild.length)+'" class="buyothersnum buyothersnum'+(1+addzoochild.length)+'" id="" value="'+obj.data.other[i].idCard+'" placeholder="请输入证件号码" /></div></div>'
						    str=str+'<div class="addzoochildbox border-bottom-none"><div class="addzoochildboxleft">手机号码</div>';
						    str=str+'<div class="addzoochildboxright"><input type="text" class="buyothersphone buyothersphone'+(1+addzoochild.length)+'" name="" id="" value="'+obj.data.other[i].phone+'" placeholder="请输入手机号码" /></div></div></div>';
							$(".jsbuyothers").append(str);
            			}
            		}
            	}else{
            		$(".buyothersname1").val(obj.data.other[0].name);
            		$(".buyothersnum1").val(obj.data.other[0].idCard);
            		$(".buyothersphone1").val(obj.data.other[0].phone);
            		$(".addid1 .mustspan").html(obj.data.other[0].cardType);
            		$("#addid1").val(obj.data.other[0].cardType);
            	}
            }
            $.hideLoading();
        }else if(obj.code == 403){
        	$.hideLoading();
            $.alert(obj.msg,function(){
            	if(obj.msg=='登录失效,请重新登录'){
					var v=Math.random();
				    window.location.href="pre.html?v="+v;
			    }
            });
        }else{
        	$.hideLoading();
            $.alert(obj.msg)
        }
    },
    error:function(msg){
    	$.hideLoading();
    	console.log(msg)
    }
});  
}
function showgetlocalStorage(){
	console.log(693)
	var buyer1=getlocalStorage("buyer1");
	if(buyer1!=null&&buyer1!="null"){
		$("#buyer1").val(buyer1);
	}
	var buyer2=getlocalStorage("buyer2");
	if(buyer2!=null&&buyer2!="null"){
		$("#buyer2").val(buyer2);
		$(".buyer2 .mustspan").html(buyer2);
		$(".buyer2 .mustspan").addClass("color333");
	}
	var buyer3=getlocalStorage("buyer3");
	if(buyer3!=null&&buyer3!="null"){
		$("#buyer3").val(buyer3);
	}
	var buyer4=getlocalStorage("buyer4");
	if(buyer4!=null&&buyer4!="null"){
		$("#buyer4").val(buyer4);
		$(".buyer4 .mustspan").html(buyer4);
		$(".buyer4 .mustspan").addClass("color333");
	}
	var buyer9=getlocalStorage("buyer9");
	if(buyer9!=null&&buyer9!="null"){
		$("#buyer9").val(buyer9);
		$(".buyer9 .mustspan").html(buyer9);
		$(".buyer9 .mustspan").addClass("color333");
	}
	var buyer10=getlocalStorage("buyer10");
	if(buyer10!=null&&buyer10!="null"){
		$("#buyer10").val(buyer10);
		$(".buyer10 .mustspan").html(buyer10);
		$(".buyer10 .mustspan").addClass("color333");
	}
	var buyer11=getlocalStorage("buyer11");
	if(buyer11!=null&&buyer10!="null"){
		$("#buyer11").val(buyer11);
		$(".buyer11 .mustspan").html(buyer11);
		$(".buyer11 .mustspan").addClass("color333");
	}
    var buyer12=getlocalStorage("buyer12");
	if(buyer12!=null&&buyer12!="null"){
		$("#buyer12").val(buyer12);
		$(".buyer12 .mustspan").html(buyer12);
		$(".buyer12 .mustspan").addClass("color333");
	}
}


$(".imgback").click(function(){
	$(".zzc").hide();
});
$(".zzcclose").click(function(){
	$(".zzc").hide();
});
$(".howtoget").click(function(){
	$(".zzc").show();
	$(".example2").show();
	$(".example1").hide();
})
$(".bigimgbtn").click(function(){
	$(".zzc").show();
	$(".example1").show();
	$(".example2").hide();
})
	
$(".addzooaddmoreda").click(function(){
	var bhbigzoo=$(".bhbigzoo").find(".danumber");
	
	var str='<div class="danumber"><div class="boxfff1left">查档编号'+(bhbigzoo.length+1)+'</div><div class="boxfff1right"><div class="removedanum"><img class="removedanumicon" src="img/reduce.png"/></div>';
	str=str+'<input type="text" name="" class="danumberinput" value="" placeholder="请输入编号" /></div></div>';
	$(".bhzoo").append(str);
})
function ifbhzoo(){
	    var bhbigzoo=$(".bhbigzoo").find(".danumber");
		console.log(bhbigzoo.length);
		var arr=[];
		for(var i = 0; i < bhbigzoo.length; i++) {
			var thisfor=$(".bhbigzoo").find(".danumber").eq(i).find(".danumberinput").val();
			if(thisfor==""){
				return false;
			}else{
				arr[arr.length]=thisfor;
			}
		}
		return arr;
}	
$(".bhzoo").on("click",".removedanumicon",function(){
	$(this).parents(".danumber").remove();
	var bhbigzoo=$(".bhbigzoo").find(".danumber");
	console.log(bhbigzoo.length);
	for(var i = 0; i < bhbigzoo.length; i++) {
		$(".bhzoo").find(".danumber").eq(i).find(".boxfff1left").html("查档编号"+(i+2))
	}
})
$("body").on("input propertychange","#buyer1",function(){
	var buyer1=$("#buyer1").val();
	if(!checkname(buyer1)){
	   $("#buyer1").parent(".linebox").addClass("errcolor");
	}else{
		setlocalStorage("buyer1",buyer1);
	   	$("#buyer1").parent(".linebox").removeClass("errcolor")
	}
}) 
$("body").on("input propertychange","#buyer3",function(){
   checksfz();
}) 
function checksfz(){
	var buyer3=$("#buyer3").val();
   if(buyer3==""){
// 		$(".buyer3").addClass("errcolor");
   }else{
   	    var buyer2=$("#buyer2").val();
   	     console.log(checkID(buyer3))
   	    if(buyer2=='身份证'){
   	    	if(checkID(buyer3)==true){
	   	    	setlocalStorage("buyer3",buyer3);
	   	    	for (var i = 0; i < $(".buyothersnum").length; i++) {
	   	    	   if($(".buyothersnum").eq(i).val().replace(/\s/g,"")==buyer3){
	   	    	   	console.log($(".buyothersnum").eq(i).val())
	   	    	   	$.toast("主购房人身份信息不能与其他购房人相同", "cancel");
	   	    	   	return;
	   	    	   }
	   	    	}
	   	    	
	   	    	for (var i = 0; i < $(".childcard").length; i++) {
	   	    	   if($(".childcard").eq(i).val().replace(/\s/g,"")==buyer3){
	   	    	   	console.log($(".buyothersnum").eq(i).val())
	   	    	   	$.toast("主购房人身份信息不能与子女信息相同", "cancel");
	   	    	   	return;
	   	    	   }
	   	    	}
	   	    	
	     	    $(".buyer3").removeClass("errcolor")
	     	    $("#buyer3").removeClass("errcolor")
	   	    }else{
	   	    	$(".buyer3").addClass("errcolor");
	   	    	$("#buyer3").addClass("errcolor");
	   	    }
   	    }else{
   	    	for (var i = 0; i < $(".buyothersnum").length; i++) {
	   	    	   if($(".buyothersnum").eq(i).val()==buyer3){
	   	    	   	$.toast("主购房人身份信息不能与其他购房人相同", "cancel");
	   	    	   	return;
	   	    	   }
	   	    }
   	    	
   	    	$(".buyer3").removeClass("errcolor")
	     	$("#buyer3").removeClass("errcolor")
   	    }
   }
}
//$("body").on("input propertychange","#buyer9",function(){
// var buyer9=$("#buyer9").val();
// if(buyer9=="请选择"){
// 	   	$(".buyer9").addClass("errcolor");
// 	   	return;
// }else{
// 	    setlocalStorage("buyer9",buyer9);
// 		$(".buyer9").removeClass("errcolor")
// }
//}) 
$(".btn.top122").click(function(){//点击提交
		var buyer1=$("#buyer1").val().replace(/\s/g,"");
	   if(!checkname(buyer1)){
		   $.alert("请填写主购房人姓名");
		   $("#buyer1").parent(".linebox").addClass("errcolor");
		   return;
	   }else{
	   		$("#buyer1").parent(".linebox").removeClass("errcolor")
	   }
	   var buyer2=$("#buyer2").val();
	   if(buyer2=="请选择"){
	   	   	$(".buyer2").addClass("errcolor");
	   		$.alert("请选择主购房人证件类型");return;
	   }else{
	   		$(".buyer2").removeClass("errcolor")
	   }
		
	
   var buyer3=$("#buyer3").val().replace(/\s/g,"");;
   if(buyer3==""){
   		$(".buyer3").addClass("errcolor");
	   	$.alert("请输入主购房人证件号码");return;
   }else{
   	    var buyer2=$("#buyer2").val();
   	     console.log(checkID(buyer3))
   	     for (var i = 0; i < $(".buyothersnum").length; i++) {
    	   if($(".buyothersnum").eq(i).val().replace(/\s/g,"")==buyer3){
    	   	$.alert("主购房人身份信息不能与其他购房人"+(i+1)+"相同");
    	   	return;
    	   }
	   	 }
   	    if(buyer2=='身份证'){
   	    	if(checkID(buyer3)==true){
	     	     $(".buyer3").removeClass("errcolor")
	     	     $("#buyer3").removeClass("errcolor")
	   	    }else{
	   	    	$(".buyer3").addClass("errcolor");
	   	    	$("#buyer3").addClass("errcolor");
	   	    	$.alert("请输入有效主购房人证件号码");return;
	   	    }
   	    }
   }
	   var buyer4=$("#buyer4").val();
	   if(buyer4==""){
	   	   	$(".buyer4").addClass("errcolor");
	   		$.alert("请选择主购房人无房家庭");return;
	   }else{
	   		$(".buyer4").removeClass("errcolor")
	   }
	   
	   var household=$("body").attr("household");
	   if(household=="非杭州户籍"){
	   	 var buyer5=$("#buyer5").val();
	   	 if(buyer5=="请选择"){
	   	 	$.alert("请选择主购房人非杭州市（含四县市）住房");
	   	 	$(".nohzpeople").addClass("errcolor");
	   	 	return;
	   	 }else{
	   	 	$(".nohzpeople").removeClass("errcolor")
	   	 }
	   }
	   
	
	   
	   var buyer6=$("#buyer6").val();
	   if(buyer6==""){
	   	   	$(".buyer6").addClass("errcolor");
	   		$.alert("请选择主购房人全国住房贷款记录");return;
	   }else{
	   		$(".buyer6").removeClass("errcolor")
	   }
	   var buyer7=$("#buyer7").val();
	   if(buyer7==""){
	   	   	$(".buyer7").addClass("errcolor");
	   		$.alert("请选择主购房人付款方式");return;
	   }else{
	   		$(".buyer7").removeClass("errcolor")
	   }
	   
	   var buyer8=$("#buyer8").val();
	   if(buyer8==""){
	   	   	$(".buyer8").addClass("errcolor");
	   		$.alert("请选择主购房人首付比例");return;
	   }else{
	   		$(".buyer8").removeClass("errcolor")
	   }
	   var buyer9=$("#buyer9").val();
	   if(buyer9==""){
	   	 $(".buyer9").addClass("errcolor");
	   	 $.alert("请输入销售顾问姓名");return;
	   }else{ 
//		   if(!checkname(buyer9)){
//		   	 $(".buyer9").addClass("errcolor");
//		   	 $.alert("请输入完整销售顾问姓名");return;
//		   }else{
//		   	$(".buyer9").removeClass("errcolor")
//		   }
$(".buyer9").removeClass("errcolor")
	   	
	   }
	   
	 
	var arr=[];
	var ifbhzoo=arr;
	var buyer10=$("#buyer10").val();//年龄段
	var buyer11=$("#buyer11").val();//需求面积
	var buyer12=$("#buyer12").val();//是否购买车位
	var buyer10=$("#buyer10").val();//年龄段
   if(buyer10==""){
   	   	$(".buyer10").addClass("errcolor");
   		$.alert("请选择主购房人年龄段");return;
   }else{
   		$(".buyer10").removeClass("errcolor")
   }
	var buyer11=$("#buyer11").val();//年龄段
	if(buyer11==""){
	   	   	$(".buyer11").addClass("errcolor");
	   		$.alert("请选择需求面积");return;
	}else{
	   		$(".buyer11").removeClass("errcolor")
	}
	var buyer12=$("#buyer12").val();//年龄段
	if(buyer12==""){
	   	   	$(".buyer12").addClass("errcolor");
	   		$.alert("请选择是否购买车位");return;
	}else{
	   		$(".buyer12").removeClass("errcolor")
	}
	

	
	
	var child=new Array();  
	if($(".addzoomarriageshow").is(':hidden')){
	   var marriage=$("body").attr("marriage");
	if(marriage!="未婚单身"){//检查zinv
		var addchild=$(".addzoomarriage").find(".addzoochild").length;
		for(var i = 0; i < $(".addzoomarriage").find(".addzoochild").length; i++){
			var childname=$(".addzoomarriage").find(".addzoochild").eq(i).find(".childname").val();
			if(!checkname(childname)){
				$(".addzoomarriage").find(".addzoochild").eq(i).find(".childname").parents("addzoochildbox").css({"color":"red"});
				$.alert("未成年子女姓名无效！");
				return;
			}
			var childcard=$(".addzoomarriage").find(".addzoochild").eq(i).find(".childcard").val();
			if(checkID(childcard)!=true){
				$(".addzoomarriage").find(".addzoochild").eq(i).find(".childcard").parents("addzoochildbox").css({"color":"red"});
				$.alert("未成年子女身份证号无效！");
				return;
			}
			for (var c = 0; c < child.length; c++) {
				if(child[c].childcard==childcard){
					$.alert("未成年子女"+(i+1)+"与未成年子女"+(c+1)+"身份证号不能相同！");
				    return;
				}
			}
			var childobj={
				"name":childname,
				"idCard":childcard
			}
			child[child.length]=childobj;
		}
	}
	}
	var other=new Array();
	if(!$(".buyinfobtn").is(':hidden')){　　//如果node是隐藏的则显示node元素，否则隐藏
	}else{
		var addzoochild=$(".buyinfozoo").find(".addzoochild");
		for (var i = 0; i < addzoochild.length; i++) {
			var buyothersname=$(".buyinfozoo").find(".addzoochild").eq(i).find(".buyothersname").val().replace(/\s/g,"");
			if(!checkname(buyothersname)){
				$(".buyinfozoo").find(".addzoochild").eq(i).find(".buyothersname").parents(".addzoochildbox").css({"color":"red"});
				$.alert("其他购房人"+(i+1)+"姓名不能为空");
				return;
			}
			var cardType1=$(".buyinfozoo").find(".addzoochild").eq(i).find(".alinkaddid").attr("for");
			console.log(cardType1)
			var cardType=$("#"+cardType1).val();
			var buyothersnum=$(".buyinfozoo").find(".addzoochild").eq(i).find(".buyothersnum").val();
			buyothersnum=buyothersnum.replace(/\s/g,"");
			if(buyothersnum==""){
				$(".buyinfozoo").find(".addzoochild").eq(i).find(".buyothersnum").parents(".addzoochildbox").css({"color":"red"});
				$.alert("其他购房人"+(i+1)+"证件号码不能为空");
				return;
			}
			if(cardType=='身份证'){
				if(checkID(buyothersnum)==true){
					
				}else{
					$.alert("其他购房人"+(i+1)+"身份证号无效");
					return;
				}
			}
			var buyer3=$("#buyer3").val();
			if(buyothersnum==buyer3){
				$.alert("其他购房人"+(i+1)+"证件号码不能与主购房人相同");
				return;
			}
			for (var o= 0; o < other.length; o++) {
				if(other[o].buyothersnum==buyothersnum){
					$.alert("其他购房人"+(i+1)+"证件号码不能与其他购房人"+(o+1)+"相同");
				    return;
				}
			}
			var buyothersphone=$(".buyinfozoo").find(".addzoochild").eq(i).find(".buyothersphone").val();
			buyothersphone=buyothersphone.replace(/\s/g,"");
			if(!checkPhone(buyothersphone)){
				$(".buyinfozoo").find(".addzoochild").eq(i).find(".buyothersphone").parents(".addzoochildbox").css({"color":"red"});
				$.alert("其他购房人"+(i+1)+"手机号码无效");
				return;
			}
			var otherobj={
				"name":buyothersname,
				"idCard":buyothersnum,
				"phone":buyothersphone,
				"cardType":cardType
			}
			other[other.length]=otherobj;
		}
	   
	}
	
	
	var bhbigzoo=$(".bhbigzoo").find(".danumber");
	console.log(bhbigzoo.length);
	for(var i = 0; i < bhbigzoo.length; i++) {
		var thisfor=$(".bhbigzoo").find(".danumber").eq(i).find(".danumberinput").val();
		if(thisfor==""){
			$.alert("查档编号不能为空!");
			return;
		}else{
			arr[arr.length]=thisfor;
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
	console.log(child)
	var phone=getlocalStorage("phone")
	var posturl=ajaxurl;
	$.ajax({
		type:"post",
		url:posturl+"/api/add",
	//	Content-Type: 'application/json;charset=utf-8',
	//	traditional: true,
		data:{
			"phone":phone,
			"name":buyer1,//姓名
			"cardType":buyer2,//证件类型	
			"idCard":buyer3,//证件号码	
			"haveHouse":buyer4,//无房家庭	
			"loan":buyer6,//全国住房贷款记录	
			"pay":buyer7,//付款方式	
			"generation":buyer10,
			"area":buyer11,
			"parking":buyer12,
			"file":ifbhzoo,//档案编号	
			"child":child,
			"other":other,
			"sale":buyer9,
			"down":buyer8,
			"nothzHouse":buyer5
		},
		success:function(obj){
			if(obj.code==200){
				var v=Math.random();
				$.toast("保存成功", 200,function(){
						window.location.href="index3.html?v="+v;
				});
			}else{
				$.alert(obj.msg,function(){
					var v=Math.random();
					if(obj.msg=='登录失效,请重新登录'){
						window.location.href="pre.html?v="+v;
					}
				})
			}
			console.log(obj)
		},
		error:function(msg){
			
		}
	});
	

})


$(".page2").on("input propertychange" ,".buyothersnum",function(){
	var buyer3=$("#buyer3").val();//主购房人证件号
	var thisv=$(this).val();//其他购房人证件号
	var v=$(this).attr("v");//下标
	var addid=$("#addid"+v).val();
	if(addid=='身份证'){
		if(checkID(thisv)==true){
     	    $(this).removeClass("errcolor")
   	    }else{
   	    	$(this).addClass("errcolor");
   	    	return
   	    }
	}else{
		 $(this).removeClass("errcolor")
	}
	if(buyer3==thisv){
		$(this).addClass("errcolor");
		$(this).addClass("colorredno");
		$.toast("其他购房人身份信息不能与主购房人相同", "cancel");
	}else{
		var c=1;
		for (var i = 0; i < $(".buyothersnum").length; i++) {
			if(v!=(i+1)){
				if($(".buyothersnum").eq(i).val()==thisv){
					c=2;
					$(this).addClass("errcolor");
					$(this).addClass("colorredno");
					$.toast("其他购房人身份信息不能重复", "cancel");
				}
			}
		}
		if(c==1){
			$(this).removeClass("errcolor")
		    $(this).removeClass("colorredno");
		    $.hideLoading();
		}
	}
})

$(".page2").on("input propertychange" ,".childcard",function(){
	var buyer3=$("#buyer3").val();
	var thisv=$(this).val();
	var v=$(this).attr("v");
		if(checkID(thisv)==true){
     	    $(this).removeClass("errcolor")
   	    }else{
   	    	$(this).addClass("errcolor");
   	    	return
   	    }
	if(buyer3==thisv){
		$(this).addClass("errcolor");
		$(this).addClass("colorredno");
		$.toast("子女身份信息不能与主购房人相同", "cancel");
	}else{
		var d=1;
		for (var i = 0; i < $(".childcard").length; i++) {
			if(v!=(i+1)){
				if($(".childcard").eq(i).val()==thisv){
					d=2;
					$(this).addClass("errcolor");
					$(this).addClass("colorredno");
					$.toast("子女信息不能重复", "cancel");
				}
			}
		}
		if(d==1){
			$(this).removeClass("errcolor")
		    $(this).removeClass("colorredno");
		     $.hideLoading();
		}
	}
})
  


$(".buyinfobtn").click(function(){
	var marriage=$("body").attr("marriage");
	if(marriage=="未婚单身"){
		$(".buyinfozoo1").find(".reduceicon").show();
		$(".buyinfozoo1").find(".addzoochildheadspan").html("1");
	}else if(marriage=="离异单身(含带未成年子女)"){
		$(".buyinfozoo1").find(".reduceicon").show();
		$(".buyinfozoo1").find(".addzoochildheadspan").html("1");
	}else if(marriage=="已婚"){
		$(".buyinfozoo1").find(".reduceicon").hide();
		$(".buyinfozoo1").find(".addzoochildheadspan").html("(配偶)");
	}else if(marriage=="丧偶"){
		$(".buyinfozoo1").find(".reduceicon").show();
		$(".buyinfozoo1").find(".addzoochildheadspan").html("1");
	}
	$(".buyinfozoo").show();
	$(".buyinfobtn").hide();
})












$(".buyothermore").click(function(){
	var addzoochild=$(".buyinfozoo").find(".addzoochild");
	console.log(addzoochild.length)
	var str='<div class="addzoochild"><div class="addzoochildhead">其他购房人<span class="addzoochildheadspan">'+(1+addzoochild.length)+'</span><img class="reduceicon" src="img/reduce.png"/>';
	str=str+'</div><div class="addzoochildbox"><div class="addzoochildboxleft">姓名</div><div class="addzoochildboxright">';
	str=str+'<input type="text" class="buyothersname buyothersname'+(1+addzoochild.length)+'" name="" id="" value="" placeholder="请输入姓名" />'
    str=str+'</div></div><div class="addzoochildbox"><div class="addzoochildboxleft">证件类型</div>';
    str=str+'<input class="weui-input" id="addid'+(1+addzoochild.length)+'" class="" type="text" value="身份证" readonly="">'
    str=str+'<div class="addzoochildboxright"><label class="lineboxright alinkaddid alink addid'+(1+addzoochild.length)+'" for="addid'+(1+addzoochild.length)+'">';
    str=str+'<span class="color333 mustspan">身份证</span> <img class="imggo alink" src="img/go.png"/></label></div></div>';
    str=str+'<div class="addzoochildbox"><div class="addzoochildboxleft">证件号码</div>';
    str=str+'<div class="addzoochildboxright"><input type="text" name="" v="'+(1+addzoochild.length)+'" class="buyothersnum buyothersnum'+(1+addzoochild.length)+'" id="" value="" placeholder="请输入证件号码" /></div></div>'
    str=str+'<div class="addzoochildbox border-bottom-none"><div class="addzoochildboxleft">手机号码</div>';
    str=str+'<div class="addzoochildboxright"><input type="text" v="'+(1+addzoochild.length)+'" class="buyothersphone buyothersphone'+(1+addzoochild.length)+'" name="" id="" value="" placeholder="请输入手机号码" /></div></div></div>';
	$(".jsbuyothers").append(str);
	
$(".page2 #addid"+(1+addzoochild.length)).picker({
    title: "请选择",
    cols: [
      {
        textAlign: 'center',
         values: ['身份证', '军官证','护照']
      }
    ],
    onChange: function(p, v, dv) {
      $("#addid"+(1+addzoochild.length)).val(dv[0]);
      console.log(dv[0]);
    },
    onClose: function(p, v, d) {
    	var buyer2=$("#addid"+(1+addzoochild.length)).val();
    	$(".addid"+(1+addzoochild.length)).find(".mustspan").html(buyer2);
        $('.addid'+(1+addzoochild.length)).find(".mustspan").addClass("color333");
        var cardnum=$(".buyothersnum"+(1+addzoochild.length)).val();
        if(buyer2=='身份证'){
			if(checkID(cardnum)==true){
	     	    $(".buyothersnum"+(1+addzoochild.length)).removeClass("errcolor")
	   	    }else{
	   	    	$(".buyothersnum"+(1+addzoochild.length)).addClass("errcolor");
	   	    	return
	   	    }
		}else{
			 $(".buyothersnum"+(1+addzoochild.length)).removeClass("errcolor")
		}
        
        
    }
});
	
})


$(".page2 #addid1").picker({
    title: "请选择",
    cols: [
      {
        textAlign: 'center',
         values: ['身份证', '军官证','护照']
      }
    ],
    onChange: function(p, v, dv) {
      $("#addid1").val(dv[0]);
      console.log(dv[0]);
    },
    onClose: function(p, v, d) {
    	var buyer2=$("#addid1").val();
    	$(".addid1").find(".mustspan").html(buyer2);
        $('.addid1').find(".mustspan").addClass("color333");
        var cardnum=$(".buyothersnum1").val();
        if(buyer2=='身份证'){
			if(checkID(cardnum)==true){
	     	    $(".buyothersnum1").removeClass("errcolor")
	   	    }else{
	   	    	$(".buyothersnum1").addClass("errcolor");
	   	    	return
	   	    }
		}else{
			 $(".buyothersnum1").removeClass("errcolor")
		}
        
    }
});



								
							
									
								
								
										
							
							
								
							
							
								





















$(".buyinfozoo").on("click",".reduceicon",function(){//其他购房者信息减少
	var addzoochild=$(".buyinfozoo").find(".addzoochild");
	if(addzoochild.length==1){
		$(".buyinfozoo").hide();
		$(".buyinfobtn").show();
		for (var i = 0; i <$(".buyinfozoo").find(".addzoochild").length; i++) {
			$(".buyinfozoo").find(".addzoochild").eq(i).find(".buyothersname").val('');
			$(".buyinfozoo").find(".addzoochild").eq(i).find(".buyothersnum").val('')
			$(".buyinfozoo").find(".addzoochild").eq(i).find(".buyothersphone").val('')
		}
	}else{
		$(this).parents(".addzoochild").remove();
		console.log(142)
		for (var i = 0; i <$(".buyinfozoo").find(".addzoochild").length; i++) {
			console.log($(".buyinfozoo").find(".addzoochild").eq(i).find(".addzoochildheadspan"))
			var addzoochildheadspan=$(".buyinfozoo").find(".addzoochild").eq(i).find(".addzoochildheadspan").text();
			$(".buyinfozoo").find(".addzoochild").eq(i).find(".buyothersname").removeClass("buyothersname"+addzoochildheadspan*1);
			$(".buyinfozoo").find(".addzoochild").eq(i).find(".buyothersname").addClass("buyothersname"+(1+i));
			$(".buyinfozoo").find(".addzoochild").eq(i).find(".buyothersnum").removeClass("buyothersnum"+addzoochildheadspan*1);
			$(".buyinfozoo").find(".addzoochild").eq(i).find(".buyothersnum").addClass("buyothersnum"+(1+i));
			$(".buyinfozoo").find(".addzoochild").eq(i).find(".buyothersphone").removeClass("buyothersphone"+addzoochildheadspan*1);
			$(".buyinfozoo").find(".addzoochild").eq(i).find(".buyothersphone").addClass("buyothersphone"+(1+i));
			$(".buyinfozoo").find(".addzoochild").eq(i).find(".addzoochildheadspan").html(i+1)
		}
	}
})







$(".buyinfozoo").on("input propertychange",".buyothersphone",function(){
	var thisv=$(this).val();
	if(checkPhone(thisv)!=true){
		$(this).parents(".addzoochildbox").css({"color":"red"})
	}else{
		console.log(thisv+'-');
		$(this).parents(".addzoochildbox").removeAttr("style");
	}
	console.log(thisv);
}) 
$(".buyinfozoo").on("input propertychange",".buyothersname",function(){
	var thisv=$(this).val();
	if(checkname(thisv)!=true){
		$(this).parents(".addzoochildbox").css({"color":"red"})
	}else{
		console.log(thisv+'-');
		$(this).parents(".addzoochildbox").removeAttr("style");
	}
	console.log(thisv);
})
function checkPhone(phone){ 
    if(!(/^1[3|4|5|6|7|8|9]\d{9}$/.test(phone))){ 
//      alert("手机号码有误，请重填");  
        return false; 
    }else{
    	return true;
    }
}





$(".addzoomarriage").on("click",".reduceicon",function(){//子女信息减少
	var addzoochild=$(".addzoomarriage").find(".addzoochild");
	if(addzoochild.length==1){
		$(".addzoomarriage").hide();
		$(".addzoomarriageshow").show();
	}else{
		$(this).parents(".addzoochild").remove();
		console.log(142)
		for (var i = 0; i <$(".addzoomarriage").find(".addzoochild").length; i++) {
			console.log(i)
			console.log($(".addzoomarriage").find(".addzoochild").eq(i).find(".addzoochildheadspan"))
			var addzoochildheadspan=$(".addzoomarriage").find(".addzoochild").eq(i).find(".addzoochildheadspan").text();
			$(".addzoomarriage").find(".addzoochild").eq(i).find(".childname").removeClass("childname"+addzoochildheadspan*1);
			$(".addzoomarriage").find(".addzoochild").eq(i).find(".childname").addClass("childname"+(1+i));
			$(".addzoomarriage").find(".addzoochild").eq(i).find(".childcard").removeClass("childcard"+addzoochildheadspan*1);
			$(".addzoomarriage").find(".addzoochild").eq(i).find(".childcard").addClass("childcard"+(1+i));
			$(".addzoomarriage").find(".addzoochild").eq(i).find(".addzoochildheadspan").html(i+1)
		}
	}
})
$(".addzoomarriageshow").click(function(){//添加子女信息
	$(".addzoomarriageshow").hide();
	$(".addzoomarriage").show();
})
$(".marriagemore").click(function(){
	var addzoochild1=$(".addzoomarriage").find(".addzoochild");
	var str='<div class="addzoochild marginbottom marbottom40">';
	str=str+'<div class="addzoochildhead">未成年子女<span class="addzoochildheadspan">'+(1+addzoochild1.length)+'</span>';
	str=str+'<img class="reduceicon" src="img/reduce.png"/></div><div class="addzoochildbox">';
	str=str+'<div class="addzoochildboxleft">子女姓名</div><div class="addzoochildboxright">';
	str=str+'<input type="text"  class="childname childname'+(1+addzoochild1.length)+'" name="" id="" value="" placeholder="请输入子女姓名" />'
	str=str+'</div></div><div class="addzoochildbox borderbottomnone"><div class="addzoochildboxleft">身份证号</div>';			
	str=str+'<div class="addzoochildboxright"><input type="text" v="'+(1+addzoochild1.length)+'" class="childcard childcard'+(1+addzoochild1.length)+'" name="" id="" value="" placeholder="请输入证件号码" /></div></div></div>';											
	$(".jsadd").append(str)	;				
})

$(".addzoomarriage").on("input propertychange",".childcard",function(){
	var thisv=$(this).val();
	if(checkID(thisv)!=true){
		$(this).parents(".addzoochildbox").css({"color":"red"})
	}else{
		console.log(thisv+'-');
		$(this).parents(".addzoochildbox").removeAttr("style");
	}
	console.log(thisv);
})
$(".addzoomarriage").on("input propertychange",".childname",function(){
	var thisv=$(this).val();
	if(checkname(thisv)!=true){
		$(this).parents(".addzoochildbox").css({"color":"red"})
	}else{
		console.log(thisv+'-');
		$(this).parents(".addzoochildbox").removeAttr("style");
	}
	console.log(thisv);
})

function checkname(name){
	console.log(name)
	if(name==""||name=="undefined"||name==undefined||name==null||name=="null"){
		return false;
	}else{
		if(name.length<=1){
			return false;
		}else{
			if(!isNaN(name)){
				return false;
			}else{
				return true;
			}
		}
	}
}
function checkID(ID) {
    if(typeof ID !== 'string') return '非法字符串';
    var city = {11:"北京",12:"天津",13:"河北",14:"山西",15:"内蒙古",21:"辽宁",22:"吉林",23:"黑龙江 ",31:"上海",32:"江苏",33:"浙江",34:"安徽",35:"福建",36:"江西",37:"山东",41:"河南",42:"湖北 ",43:"湖南",44:"广东",45:"广西",46:"海南",50:"重庆",51:"四川",52:"贵州",53:"云南",54:"西藏 ",61:"陕西",62:"甘肃",63:"青海",64:"宁夏",65:"新疆",71:"台湾",81:"香港",82:"澳门",91:"国外"};
    var birthday = ID.substr(6, 4) + '/' + Number(ID.substr(10, 2)) + '/' + Number(ID.substr(12, 2));
    var d = new Date(birthday);
    var newBirthday = d.getFullYear() + '/' + Number(d.getMonth() + 1) + '/' + Number(d.getDate());
    var currentTime = new Date().getTime();
    var time = d.getTime();
    var arrInt = [7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2];
    var arrCh = ['1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2'];
    var sum = 0, i, residue;
    if(!/^\d{17}(\d|x)$/i.test(ID)) return '非法身份证';
    if(city[ID.substr(0,2)] === undefined) return "非法地区";
    if(time >= currentTime || birthday !== newBirthday) return '非法生日';
    for(i=0; i<17; i++) {
      sum += ID.substr(i, 1) * arrInt[i];
    }
    residue = arrCh[sum % 11];
    if (residue !== ID.substr(17, 1)) return '非法身份证哦';
    return true;
//  city[ID.substr(0,2)]+","+birthday+","+(ID.substr(16,1)%2?" 男":"女")
}
$(".page2 #buyer5").picker({
			    title: "请选择",
			    cols: [
			      {
			        textAlign: 'center',
			         values: ['0套', '1套','2套及以上']
			      }
			    ],
			    onChange: function(p, v, dv) {
			      $("#buyer5").val(dv[0]);
			      console.log(dv[0]);
			    },
			    onClose: function(p, v, d) {
			    	var buyer2=$("#buyer5").val();
			    	$(".buyer5").find(".mustspan").html(buyer2);
//			    	if(buyer2=="2套及以上"){
//			    		buyer8arr=['全款'];
//			    	}else if(buyer2=="2套及以上"){
//			    		
//			    	}
			    	$(".nohzpeople").removeClass("errcolor")
			        $('.buyer5').find(".mustspan").addClass("color333");
			    }
});


$(".page2 #buyer2").picker({
    title: "请选择",
    cols: [
      {
        textAlign: 'center',
         values: ['身份证', '军官证','护照']
      }
    ],
    onChange: function(p, v, dv) {
      $("#buyer2").val(dv[0]);
      console.log(dv[0]);
    },
    onClose: function(p, v, d) {
    	var buyer2=$("#buyer2").val();
    	$(".buyer2").find(".mustspan").html(buyer2);
    	setlocalStorage("buyer2",buyer2);
        $('.buyer2').find(".mustspan").addClass("color333");
        $(".buyer2").removeClass("errcolor");
        checksfz();
    }
});

$(".page2 #buyer4").picker({
    title: "请选择",
    cols: [
      {
        textAlign: 'center',
         values: ['是', '否']
      }
    ],
    onChange: function(p, v, dv) {
      $("#buyer4").val(dv[0]);
      var marriage=$("body").attr("marriage");
      if(marriage=="未婚单身"){
      	 if(dv[0]=="是"){
	    	$("#buyer4").picker("setValue", ["否"]);
	      }
      }else if(marriage=="离异单身(含带未成年子女)"){
      	 var divorce=$("body").attr("divorce");
      	 if(divorce=="2018年4月4日后"){
      	 	 if(dv[0]=="是"){
		    	$("#buyer4").picker("setValue", ["否"]);
		      }
      	 }
      }
       var hzhouse=$("body").attr("hzhouse");
       if(hzhouse){
	      if(hzhouse!="0套"){
	      	 if(dv[0]=="是"){
		    	$("#buyer4").picker("setValue", ["否"]);
		      }
	      }
       }
      var otherHouse=$("body").attr("otherHouse");
       if(otherHouse){
	      if(otherHouse!="0套"){
	      	 if(dv[0]=="是"){
		    	$("#buyer4").picker("setValue", ["否"]);
		      }
	      }
       }
      
      
      
      console.log(dv[0]);
    },
    onClose: function(p, v, d) {
    	var buyer4=$("#buyer4").val();
    	$(".buyer4").find(".mustspan").html(buyer4);
    	setlocalStorage("buyer4",buyer4);
        $('.buyer4').find(".mustspan").addClass("color333");
        $(".buyer4").removeClass("errcolor")
    }
});

$(".page2 #buyer6").picker({
    title: "请选择",
    cols: [
      {
        textAlign: 'center',
         values: ['无', '已结清','在贷']
      }
    ],
    onChange: function(p, v, dv) {
      $("#buyer6").val(dv[0]);
      console.log(dv[0]);
    },
    onClose: function(p, v, d) {
    	var buyer2=$("#buyer6").val();
    	$(".buyer6").find(".mustspan").html(buyer2);
        $('.buyer6').find(".mustspan").addClass("color333");
        $(".buyer6").removeClass("errcolor")
        
        var household=$("body").attr("household");
        if(household!="非杭州户籍"){
        	if(buyer2=="已结清"||buyer2=="在贷"){
        		buyer8arr=2;
        		$("#buyer8").val("全款");
	    		$(".buyer8").find(".mustspan").html("全款");
	    		$(".buyer8").find(".mustspan").addClass("color333")
        	}else{
        		var buyer7=$("#buyer7").val();
        		if(buyer7=="一次性付款"){
        			buyer8arr=1;
        			$("#buyer8").val("全款");
		    		$(".buyer8").find(".mustspan").html("全款");
		    		$(".buyer8").find(".mustspan").addClass("color333")
        		}else{
        			buyer8arr=0;
        			$("#buyer8").val("全款");
		    		$(".buyer8").find(".mustspan").html("全款");
		    		$(".buyer8").find(".mustspan").addClass("color333")
        		}
        	}
        }else{
        	var buyer5=$("#buyer5").val();
        	if(buyer5=="2套及以上"){
        		if(buyer2=="在贷"){
        			buyer8arr=1;
        			$("#buyer8").val("全款");
		    		$(".buyer8").find(".mustspan").html("全款");
		    		$(".buyer8").find(".mustspan").addClass("color333")
        		}else{
        			var buyer7=$("#buyer7").val();
	        		if(buyer7=="一次性付款"){
	        			buyer8arr=1;
	        			$("#buyer8").val("全款");
			    		$(".buyer8").find(".mustspan").html("全款");
			    		$(".buyer8").find(".mustspan").addClass("color333")
	        		}else{
	        			buyer8arr=0;
	        			$("#buyer8").val("全款");
			    		$(".buyer8").find(".mustspan").html("全款");
			    		$(".buyer8").find(".mustspan").addClass("color333")
	        		}
        		}
        	}else{
        		var buyer7=$("#buyer7").val();
        		if(buyer7=="一次性付款"){
        			buyer8arr=1;
        		}else{
        			buyer8arr=0;
        		}
        		$("#buyer8").val("全款");
	    		$(".buyer8").find(".mustspan").html("全款");
	    		$(".buyer8").find(".mustspan").addClass("color333")
        	}	
        }
        
        
//1,判断3种(非杭州除外){
//	在贷或已结清
//	不能选3成
//	
//}
//2套以上



//非杭州{
//	,在贷,只能全款
//}
        
        
        
        
    }
});

var buyer8arr=0;
$(".page2 #buyer7").picker({
    title: "请选择",
    cols: [
      {
        textAlign: 'center',
         values: ['商业贷款', '公积金贷款','组合贷款','一次性付款']
      }
    ],
    onChange: function(p, v, dv) {
      $("#buyer7").val(dv[0]);
      console.log(dv[0]);
    },
    onClose: function(p, v, d) {
    	var buyer2=$("#buyer7").val();
    	$(".buyer7").find(".mustspan").html(buyer2);
    	if(buyer2=="一次性付款"){
    		buyer8arr=1;
    		$("#buyer8").val("全款");
    		$(".buyer8").find(".mustspan").html("全款");
    		$(".buyer8").find(".mustspan").addClass("color333")
    	}else{
    		buyer8arr=0;
    	}
        $('.buyer7').find(".mustspan").addClass("color333");
        $(".buyer7").removeClass("errcolor")
    }
});


$(".page2 #buyer8").picker({
    title: "请选择",
    cols: [
      {
        textAlign: 'center',
         values: ['3成', '4成', '4成以上','全款']
      }
    ],
    onChange: function(p, v, dv) {
    	var choseDate = $(".picker-items-col-wrapper").eq(0).find('.picker-selected').attr("data-picker-value");
    	console.log(choseDate);
    	console.log(dv[0]);
    	$("#buyer8").val(dv[0]);
    	
    	if(buyer8arr==1){
    		$("#buyer8").picker("setValue", ["全款"]);
    		$("#buyer8").val(dv[0]);
        }

    },
    onClose: function(p, v, d) {
    	var buyer2=$("#buyer8").val();
    	$(".buyer8").find(".mustspan").html(buyer2);
    	$('.buyer8').find(".mustspan").addClass("color333");
    	if(buyer8arr==1){
    		if(buyer2!="全款"){
    			   $("#buyer8").val("全款");
    		       $(".buyer8").find(".mustspan").html("全款");
    		       $(".buyer8").find(".mustspan").addClass("color333");
    		}
    	}
    	$(".buyer8").removeClass("errcolor")
    }
});	




$(".page2 #buyer10").picker({
    title: "请选择",
    cols: [
      {
        textAlign: 'center',
         values: ['30岁及以下', '31-40岁','41-50岁','51-60岁','61岁及以上']
      }
    ],
    onChange: function(p, v, dv) {
      $("#buyer10").val(dv[0]);
      console.log(dv[0]);
    },
    onClose: function(p, v, d) {
    	var buyer10=$("#buyer10").val();
    	$(".buyer10").find(".mustspan").html(buyer10);
    	setlocalStorage("buyer10",buyer10);
        $('.buyer10').find(".mustspan").addClass("color333");
    }
});

$(".page2 #buyer11").picker({
    title: "请选择",
    cols: [
      {
        textAlign: 'center',
         values: ['96方', '100方']
      }
    ],
    onChange: function(p, v, dv) {
      $("#buyer11").val(dv[0]);
      console.log(dv[0]);
    },
    onClose: function(p, v, d) {
    	var buyer11=$("#buyer11").val();
    	$(".buyer11").find(".mustspan").html(buyer11);
    	setlocalStorage("buyer11",buyer11);
        $('.buyer11').find(".mustspan").addClass("color333");
    }
});
$(".page2 #buyer12").picker({
    title: "请选择",
    cols: [
      {
        textAlign: 'center',
        values: ['是', '否']
      }
    ],
    onChange: function(p, v, dv) {
      $("#buyer12").val(dv[0]);
      console.log(dv[0]);
    },
    onClose: function(p, v, d) {
    	var buyer12=$("#buyer12").val();
    	$(".buyer12").find(".mustspan").html(buyer12);
    	setlocalStorage("buyer12",buyer12);
        $('.buyer12').find(".mustspan").addClass("color333");
    }
});
})
//非杭州  2套房 只能全款
//在贷 6成以及上