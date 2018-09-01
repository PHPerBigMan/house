$(document).ready(function(){
if (top.location.hostname != window.location.hostname) {  
　　top.location.href = window.location.href;  
} 
		var deheight=$(window).height();
		$("body").height(deheight);
		$(".homezzc").height(deheight+60);
pageinit();		
function pageinit(){
	var posturl="http://tianyangweilan.shoufangpai.com";
	$.ajax({
		url:posturl+"/api/IndexConfig",
		type:"post",
		async:false,
		success:function(obj){
			console.log(obj)
			if(obj.code==200){
				var v=Math.random();
				$(".abtn1").attr('obj','floor');
				$(".abtn2").attr('obj','sell');
				$(".abtn3").attr('obj','add');
				$(".abtn4").attr('obj','result');
				if(obj.floor.open==1){
//					$(".abtn1").attr('href','info0827.html?v='+v);
					$(".abtn1").attr('ope',obj.floor.open);
				}else{
					$(".abtn1").attr('msg',obj.floor.msg);
					$(".abtn1").attr('ope',obj.floor.open);
				}
				if(obj.sell.open==1){
//					$(".abtn2").attr('href','publicity0827.html?v='+v);
					$(".abtn2").attr('ope',obj.sell.open);
				}else{
					$(".abtn2").attr('msg',obj.sell.msg);
					$(".abtn2").attr('ope',obj.sell.open);
				}
				if(obj.add.open==1){
//					$(".abtn3").attr('href','pre.html?v='+v);
					$(".abtn3").attr('ope',obj.add.open);
				}else{
					$(".abtn3").attr('msg',obj.add.msg);
					$(".abtn3").attr('ope',obj.add.open);
				}
				if(obj.result.open==1){
//					$(".abtn4").attr('href','shaking.html?v='+v);
					$(".abtn4").attr('ope',obj.result.open);
				}else{
					$(".abtn4").attr('msg',obj.result.msg);
					$(".abtn4").attr('ope',obj.result.open);
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
		
$(".abtn").click(function(){
	var thismsg=$(this).attr('msg');
	var thisopen=$(this).attr('ope');
	var thisobj=$(this).attr('obj');
//	if(thisopen=='0'){
	var posturl="http://tianyangweilan.shoufangpai.com";
	$.ajax({
		url:posturl+"/api/IndexConfig",
		type:"post",
		async:false,
		success:function(obj){
			console.log(obj)
			if(obj.code==200){
				var v=Math.random();
				if(thisobj=='floor'){
					if(obj.floor.open==1){
						window.location.href='info0827.html?v='+v
					}else{
						$.alert(obj.floor.msg,"售房派")
					}
				}else if(thisobj=='sell'){
					if(obj.sell.open==1){
						window.location.href='publicity0827.html?v='+v
					}else{
						$.alert(obj.sell.msg,"售房派")
					}
				}else if(thisobj=='add'){
					if(obj.add.open==1){
						window.location.href='pre.html?v='+v
					}else{
						$.alert(obj.add.msg,"售房派")
					}
				}else if(thisobj=='result'){
					if(obj.result.open==1){
						window.location.href='shaking.html?v='+v
					}else{
						$.alert(obj.result.msg,"售房派")
					}
				}
			}else{
				 $.alert(obj.msg,"提示",function(){})
			}
		}
	});
//	}
})

})
