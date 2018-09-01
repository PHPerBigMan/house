	//下面用于图片上传预览功能
function setImagePreview(file,view,list) {
	console.log(file);
	console.log(view)
	var docObj=document.getElementById(file);
	var imgObjPreview=document.getElementById(view);
	var imgsr="";
	if(docObj.files &&docObj.files[0]){
			imgObjPreview.src = window.URL.createObjectURL(docObj.files[0]);
			updateimg(docObj.files[0],view);
	}else{
		//IE下，使用滤镜
		docObj.select();
		var imgSrc = document.selection.createRange().text;
		var localImagId = document.getElementById(view);
		//图片异常的捕捉，防止用户修改后缀来伪造图片
		try{
			localImagId.style.filter="progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale)";
				localImagId.filters.item("DXImageTransform.Microsoft.AlphaImageLoader").src = imgSrc;
				updateimg(imgSrc,view);
//			imgsr=imgSrc;
		}catch(e){
			$.alert("您上传的图片格式不正确，请重新选择!");
			return false;
		}
		imgObjPreview.style.display = 'none';
		document.selection.empty();
	}
	
	if(list=="list"){
		var inputcon=$("#"+file).parents(".imglist").find(".inputcon");
		var v=$("#"+file).parents(".imglist").attr("v");
		var str='<div class="imgfilecontair inputcon"> <img class="imgfileboxcancel inlistimg" src="img/closenum.png"/>';
		str=str+'<label for="imgfiles1s'+v+(inputcon.length+1)+'"  class="">'
		str=str+'<img id="imgfilesimg1s'+v+(inputcon.length+1)+'" class="show_img" alt="img/addimgicon.png"  src="img/addimgicon.png"/></label>'
		str=str+'<input type="file"  multiple="multiple"   id="imgfiles1s'+v+(inputcon.length+1)+'" class="inuputfile" accept="image/*" onchange="javascript:setImagePreview('+"'imgfiles1s"+v+(inputcon.length+1)+"','imgfilesimg1s"+v+(inputcon.length+1)+"','list'";
		str=str+'); " value='+'"" /></div>';
		$("#"+file).parents(".imglist").append(str);			
	}
	
	
}
function updateimg(obj,node){
            var file = obj;//获取到文件列表
            console.log(file);
		    var fd =  new FormData()
		    fd.append('file', file)
            var ajaxurl="http://tianyangweilan.shoufangpai.com";
            $.ajax({
                url: ajaxurl+'/api/qiniuImg',
                data: fd,
                processData: false,
                contentType: false,
                type: 'POST',
                success: function (obj) {
                    if(obj.code == 200){
		                console.log(obj)
		                console.log(node)
		               $("#"+node).attr("src",obj.data);
		               console.log( $("#"+node).parents(".inputcon").find(".imgfileboxcancel"))
		               $("#"+node).parents(".inputcon").find(".imgfileboxcancel").show();
		               $("#"+node).parents("label").removeClass("bordererror");
		               hidebg()
		            }else{
		                $.alert(obj.msg)
		            }
                },
                error:function(msg){
                	console.log(msg)
                }
            });           
}