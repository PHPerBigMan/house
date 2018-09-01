$(document).ready(function(){
	$(".nav").click(function(){
		var navv=$(this).attr("v");
		$(".nav").removeClass("navactive");
		$(this).addClass("navactive");
		console.log(navv);
		$(".infopage").hide();
		$(".infopage"+navv).show();
	})
})
