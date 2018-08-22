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
var ajaxurl="http://tianyangweilan.shoufangpai.com";;
if(phone==null||phone=="null"||phone==undefined||phone=="undefined"){
	window.location.href="home.html";
}
getdata1();
function getdata1(){
var phone=getlocalStorage("phone");
var ajaxurl="http://tianyangweilan.shoufangpai.com";
$.ajax({//获取补充信息
    url: ajaxurl+'/api/get',
    data: {
    	"phone":phone,
    	"type":1
    },
    type: 'POST',
    success: function (obj) {
        if(obj.code == 200){
            console.log(obj)
          if(obj.data==null){
          	showsetlocalStorage();
          	 $.hideLoading();
          	return;
          }
          $("body").attr("status",obj.data.status);
           if(obj.data.household!=null&&obj.data.household!="null"&&obj.data.household!="undefined"&&obj.data.household!=undefined){
             	$(".mustline1").find(".mustspan").addClass("color333");
           		$(".mustline1").find(".mustspan").html(obj.data.household)
           	    $("#homepage").val(obj.data.household);
           	    $(".mustline1").attr("v",obj.data.household);
           }
          
          if(obj.data.marriage!=null&&obj.data.marriage!="null"&&obj.data.marriage!="undefined"&&obj.data.marriage!=undefined){
             	$(".mustline2").find(".mustspan").addClass("color333");
           		$(".mustline2").find(".mustspan").html(obj.data.marriage)
           	    $("#marriage").val(obj.data.marriage);
           	    $(".mustline2").attr("v",obj.data.marriage);
           }
          
          if(obj.data.hzHouse!=null&&obj.data.hzHouse!="null"&&obj.data.hzHouse!="undefined"&&obj.data.hzHouse!=undefined){
             	$(".mustline4").find(".mustspan").addClass("color333");
           		$(".mustline4").find(".mustspan").html(obj.data.hzHouse)
           	    $("#hashouse").val(obj.data.hzHouse);
           	    $(".mustline4").attr("v",obj.data.hzHouse);
           }
           if(obj.data.divorce!=null&&obj.data.divorce!="null"&&obj.data.divorce!="undefined"&&obj.data.divorce!=undefined){
             	$(".mustline3").find(".mustspan").addClass("color333");
           		$(".mustline3").find(".mustspan").html(obj.data.divorce)
           	    $("#marriagetime").val(obj.data.divorce);
           	    $(".mustline3").attr("v",obj.data.divorce);
           }
          if(obj.data.security!=null&&obj.data.security!="null"&&obj.data.security!="undefined"&&obj.data.security!=undefined){
             	$(".mustline5").find(".mustspan").addClass("color333");
           		$(".mustline5").find(".mustspan").html(obj.data.security)
           	    $("#socialsecurity").val(obj.data.security);
           	    $(".mustline5").attr("v",obj.data.security);
           }
          if(obj.data.otherHouse!=null&&obj.data.otherHouse!="null"&&obj.data.otherHouse!="undefined"&&obj.data.otherHouse!=undefined){
             	$(".mustline6").find(".mustspan").addClass("color333");
           		$(".mustline6").find(".mustspan").html(obj.data.otherHouse)
           	    $("#linanbox").val(obj.data.otherHouse);
           	    $(".mustline6").attr("v",obj.data.otherHouse);
          }
          $.hideLoading();
          hidebg();
        }else if(obj.code == 403){
        	$.hideLoading();
            $.alert(obj.msg);
            window.location.href='home.html'
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
function showsetlocalStorage(){
	var mustline1=getlocalStorage("mustline1");
	if(mustline1!=null&&mustline1!="null"){
		$("#homepage").val(mustline1);
		$(".mustline1").attr("v",mustline1);
		$(".homepage").html(mustline1);
		$(".homepage").addClass("color333");
	}
	var mustline2=getlocalStorage("mustline2");
	if(mustline2!=null&&mustline2!="null"){
		$("#marriage").val(mustline2);
		$(".mustline2").attr("v",mustline2);
		$(".marriage").html(mustline2);
		$(".marriage").addClass("color333");
		if(mustline2=="离异单身(含带未成年子女)"){
			$(".mustline3").show();
			var mustline3=getlocalStorage("mustline3");
			if(mustline3!=null||mustline3!="null"){
				$("#marriagetime").val(mustline3);
				$(".mustline3").attr("v",mustline3);
				$(".marriagetime").html(mustline3);
				$(".marriagetime").addClass("color333");
			}
		}	
	}
};
$(".page1 #homepage").picker({
    title: "请选择",
    cols: [
      {
        textAlign: 'center',
         values: ['杭州市户籍（12区）', '落户满2年的临安、桐庐、建德、淳安户籍', '落户未满2年的临安、桐庐、建德、淳安户籍', '非杭州户籍']
      }
    ],
    onChange: function(p, v, dv) {
      $(".homepage").attr("val",dv[0]);
      $(".homepage").parents(".linebox").attr("v",dv[0]);
      console.log(dv[0]);
    },
    onClose: function(p, v, d) {
    	console.log("mustline1");
    	var val=$(".homepage").attr("val");
    	$(".homepage").html(val);
    	setlocalStorage("mustline1",val);
        $('.mustline1').find(".mustspan").addClass("color333");
    	hidebg();
    }
});





$(".page1 #linanbox").picker({
    title: "请选择",
    cols: [
      {
        textAlign: 'center',
         values: ['0套', '1套', '2套及以上']
      }
    ],
    onChange: function(p, v, dv) {
      console.log(p, v, dv);
      $(".spanlinanbox").attr("val",dv[0]);
      $(".spanlinanbox ").parents(".linebox").attr("v",dv[0]);

    },
    onClose: function(p, v, d) {
    	console.log("mustline6");
    	    var val=$(".spanlinanbox").attr("val");
    	    $(".spanlinanbox").html(val);
    	    setlocalStorage("mustline6",val);
    		$('.mustline6').find(".mustspan").addClass("color333");
    		hidebg();
    }
});





$(".page1 #marriage").picker({
	title: "请选择",
	cols: [
	  {
	    textAlign: 'center',
	     values: ['未婚单身','离异单身(含带未成年子女)','已婚','丧偶']
	  }
	],
	onChange: function(p, v, dv) {
	  $(".marriage").attr("val",dv[0]);
	  $(".marriage").parents(".linebox").attr("v",dv[0]);
	},
	onClose: function(p, v, d) {
		console.log("mustline2");
		var val=$(".marriage").attr("val");
    	$(".marriage").html(val);
    	setlocalStorage("mustline2",val);
	    $('.mustline2').find(".mustspan").addClass("color333");
        hidebg();
	 }
});
$(".page1 #marriagetime").picker({
	title: "请选择",
	cols: [
	  {
	    textAlign: 'center',
	     values: ['2018年4月4日前(含)','2018年4月4日后']
	  }
	],
	onChange: function(p, v, dv) {
	  $(".marriagetime").attr("val",dv[0]);
	  $(".marriagetime").parents(".linebox").attr("v",dv[0]);
	
	},
	onClose: function(p, v, d) {
		console.log("mustline3");
		var val=$(".marriagetime").attr("val");
    	$(".marriagetime").html(val);
		setlocalStorage("mustline3",val);
        $('.mustline3').find(".mustspan").addClass("color333");
        hidebg();
	}
});
$(".page1 #hashouse").picker({
	title: "请选择",
	cols: [
	  {
	    textAlign: 'center',
	     values: ['0套','1套','2套及以上']
	  }
	],
	onChange: function(p, v, dv) {
		 $(".hashouse").attr("val",dv[0]);
	     $(".hashouse").parents(".linebox").attr("v",dv[0]);
	},
	onClose: function(p, v, d) {
		console.log("mustline4");
			var val=$(".hashouse").attr("val");
    	    $(".hashouse").html(val);
    	    setlocalStorage("mustline4",val);
    		$('.mustline4').find(".mustspan").addClass("color333");
	        hidebg();
	}
});	 
$(".page1 #socialsecurity").picker({
	title: "请选择",
	cols: [
	  {
	    textAlign: 'center',
	     values: ['是','否']
	  }
	],
	onChange: function(p, v, dv) {
	  $(".socialsecurity").attr("val",dv[0]);
	  $(".socialsecurity").parents(".linebox").attr("v",dv[0]);
	  console.log(dv[0]);
	},
	onClose: function(p, v, d) {
		console.log("mustline5");
		var val=$(".socialsecurity").attr("val");
    	$(".socialsecurity").html(val);
    	setlocalStorage("mustline5",val);
	    $('.mustline5').find(".mustspan").addClass("color333");
        hidebg();
	}
});		 
var mustline1="";//户籍
var mustline2="";//婚姻情况
var mustline3="";//离异时间
var mustline4="";//在杭州有住房
var mustline5="";//2年
var mustline6="";	 //临安
function hidebg(){
  	mustline1=$(".mustline1").attr('v');
  	mustline2=$(".mustline2").attr('v');
  	mustline3=$(".mustline3").attr('v');
  	mustline4=$(".mustline4").attr('v');
  	mustline5=$(".mustline5").attr('v');
  	mustline6=$(".mustline6").attr('v');
  	
    if(mustline2=="离异单身(含带未成年子女)"){
    	$(".mustline3").show();//离异时间
    	if(mustline1=="请选择"||mustline2=="请选择"||mustline3=="请选择"||mustline4=="请选择"||mustline5=="请选择"||mustline6=="请选择"){
    		$(".btn").removeClass("btnok");
    	}else{
    		$(".btn").addClass("btnok");
    	}
    }else{
    	$(".mustline3").hide();//离异时间
    	if(mustline1=="请选择"||mustline2=="请选择"||mustline4=="请选择"||mustline5=="请选择"||mustline6=="请选择"){
    		$(".btn").removeClass("btnok");
    	}else{
    		$(".btn").addClass("btnok");
    	}
    }
}
	 
	 
	 
	 
function alertnow(){
	console.log(606)
	$.alert("您暂无购房资格","提示",function(){
				  				
	})
}

$(".page1").on('click', ".btnok", function(){

    console.log(mustline1);
	console.log(mustline2);
	console.log(mustline3);
	console.log(mustline4);
	console.log(mustline5);
	console.log(mustline6);
var v=Math.random();
var status=$("body").attr("status");
if(status=="审核中"){
	$.alert("您的资料正在审核中,不可修改!","提示",function(){
		window.location.replace("showdata.html?v="+v);
	})
	return;
}
if(status=="审核通过"){
	$.alert("您提交过资料，审核通过，不能修改！","提示");
	window.location.replace("showdata.html?v="+v);
	return;
}
	var posturl="http://tianyangweilan.shoufangpai.com";;
	var phone=getlocalStorage("phone")
	$.ajax({
		type:"post",
		url:posturl+'/api/add',
		data:{
			"phone":phone,
			"household":mustline1,
			"marriage":mustline2,
			"divorce":mustline3,
			"hzHouse":mustline4,
			"otherHouse":mustline6,
			"security":mustline5
		},
		async:false,
		success:function(obj){
			var v=Math.random();
			if(obj.code==200){
				$.toast("保存成功", 200,function(){
					window.location.href="index2.html?v="+v;
				});
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
})