$(document).ready(function(){
	
	var posturl="http://tianyangweilan.shoufangpai.com";
	
	$.ajax({
		url:posturl+"/api/config",
		type:"post",
		async:false,
		success:function(obj){
			console.log(obj)
			if(obj.code==200){
				
				$('body').attr('end_msg',obj.data.end_msg);
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