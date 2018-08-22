$(document).ready(function(){
var urldata=getUrlParms("id");
console.log("id");
console.log(urldata);
var str = toUtf8(window.location.href);
$("#imgcode").qrcode({
	width: 360,
	height:360,
	text: str
});
function toUtf8(str) {   
    var out, i, len, c;   
    out = "";   
    len = str.length;   
    for(i = 0; i < len; i++) {   
    	c = str.charCodeAt(i);   
    	if ((c >= 0x0001) && (c <= 0x007F)) {   
        	out += str.charAt(i);   
    	} else if (c > 0x07FF) {   
        	out += String.fromCharCode(0xE0 | ((c >> 12) & 0x0F));   
        	out += String.fromCharCode(0x80 | ((c >>  6) & 0x3F));   
        	out += String.fromCharCode(0x80 | ((c >>  0) & 0x3F));   
    	} else {   
        	out += String.fromCharCode(0xC0 | ((c >>  6) & 0x1F));   
        	out += String.fromCharCode(0x80 | ((c >>  0) & 0x3F));   
    	}   
    }   
    return out;   
} 

function getUrlParms(name){
   var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
   var r = window.location.search.substr(1).match(reg);
   if(r!=null)
   return unescape(r[2]);
   return null;
}    


   $.ajax({
			type:"post",
			url:"https://tokengreat.com:8383/api/one",
			data:{
				"id":urldata
			},
			success:function(obj){
				console.log(obj)
				if(obj.code=="200"){
			
					$(".name").html(obj.data.name);
					$(".short").html(obj.data.short);
					$(".demical").html(obj.data.demical);
					$(".totalSupply").html(obj.data.totalSupply);
					$(".data").html(obj.data.data);
					$(".tokenAddress").html(obj.data.from);
					$(".fee").html(obj.data.fee);
					$(".aEtherScan").attr("href","https://etherscan.io/token/"+obj.data.tokenAddress);
					$("title").html('TokenGreat-'+obj.data.short+' Token证书');
					$(".header").html(obj.data.short+' Token证书<img  onclick="javascript:window.location.href='+"'tokenlist.html'"+'"  src="img/backarrow.png"/>')
					pageLoad(obj.data.created_at,obj.data.name,obj.data.short,obj.data.totalSupply,obj.data.demical,obj.data.tokenAddress);
					console.log(obj.data.tokenAddress)
				}else{
					mui.alert(obj.msg);
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				mui.alert("请检查您的网络，稍后再试！")
			}
		});
		
		
	
		
    function pageLoad(time1,name,short,totalSupply,demical,tokenAddress){
       
//      cans.width = 10000;
//		cans.height = 1000;

//      var img1=convertCanvasToImage(cans);  
//      console.log(cans)

     var ewm = $("#imgcode").find("canvas")[0];
	 var w=ewm.toDataURL("image/jpg");
	 $("#imgcode").hide();
	 var imgw = document.createElement("img");
	 imgw.src=w;
	 imgw.onload=function(){
			 	
			 
//           console.log(w);
             var img1 = document.createElement("img");
	         img1.src='img/kuang.png';
	         img1.onload =function () { //图片下载完毕时异步调用callback函数。 
	            

					var can = document.getElementById("can");
                    var cans = can.getContext('2d');
					// 将 img1 加入画布
					cans.drawImage(img1,0,0,750,1086);
//					console.log(time1);
					cans.drawImage(imgw,540,880,140,140); 
					cans.fillStyle='#fff';
					        cans.font="30px Arial";
					        cans.strokeStyle = '#333';
                            cans.fillText(time1,410,260);
                            cans.textAlign="left";
                            var cname=name;
                            var a=cans.measureText(cname);
                            var width=a.width;
                            if(width>380){
                            	cname=cname.substring(0, 20);
                            	cname=cname+'...';
                            	 a=cans.measureText(cname);
                                 width=a.width;
//                          	console.log(cname);
                            }
                            cans.fillText(cname,685-width,360);
                            
                            var cname=short;
                            var a=cans.measureText(cname);
                            var width=a.width;
                            if(width>380){
                            	cname=cname.substring(0, 20);
                            	cname=cname+'...';
                            	 a=cans.measureText(cname);
                                 width=a.width;
//                          	console.log(cname);
                            }
                            cans.fillText(cname,685-width,460);
                            var cname=totalSupply;
                            var a=cans.measureText(cname);
                            var width=a.width;
                            if(width>380){
                            	cname=cname.substring(0, 20);
                            	cname=cname+'...';
                            	 a=cans.measureText(cname);
                                 width=a.width;
                            	console.log(cname);
                            }
                            cans.fillText(totalSupply,685-width,560);
                            cans.fillText(demical,650,660,400);
                            if(tokenAddress==null){
                            	 tokenAddress="0xb6e270A1B8e5D1F0Eaaa98C92815B893f9128D51";
                            }else{
                            	tokenAddress=tokenAddress;
                            }
                           
                            tokenAddress1=tokenAddress.substring(0, 22);
                            tokenAddress2=tokenAddress.substring(22, 42);
                            cans.fillText(tokenAddress1,300,763);
                            cans.fillText(tokenAddress2,300,813);
                            cans.font="bold 26px Arial";
					        cans.strokeStyle = '#333';
					        var a=cans.measureText("Token: ");
                            var width=a.width;
                            console.log(width)
                           
//                           创设时间
//                          Token总量
                            cans.font="bolder 50px Arial";
					        cans.strokeStyle = '#333';
					        
					        var a=cans.measureText(short);
                            var width1=a.width;
                            
                            cans.font="bold 26px Arial";
					        cans.strokeStyle = '#333';
                             cans.fillText("Token: ",(750-width1-width)/2,160);
                            
                            cans.font="bolder 50px Arial";
					        cans.strokeStyle = '#333';
                            cans.fillText(short,(750-width1-width)/2+width,160);
                            
							$("#can").hide();
							var c = document.getElementById('can');
					        var d=c.toDataURL("image/jpg");
					        $("#canimg").attr("src",d);
	         
	         }
       }
    }		

$(".navlink").click(function(){
	var at=$(this).attr("at");
	window.location.href=at;
})


	//从 canvas 提取图片 image  
function convertCanvasToImage(canvas) {  
    //新Image对象，可以理解为DOM  
    var image = new Image();  
    // canvas.toDataURL 返回的是一串Base64编码的URL
    // 指定格式 PNG  
    image.src = canvas.toDataURL("image/png");  
    return image;  
} 	
		
		
})
