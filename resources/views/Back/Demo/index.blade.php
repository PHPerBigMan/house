
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <style type="text/css">
        #div1 {
            width: 800px;
            height: 600px;
            background-color: #ff0;
            position: relative;
        }
        .imgRotate {
            width: 600px;
            height: 600px;
            position: absolute;
            top: 50%;
            left: 50%;
            margin: -300px 0 0 -300px;
        }
    </style>
</head>
<body>
<div id="div1">
    <img id="img1" class="imgRotate" onclick="rotateImg('img1')" src="https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1488937366&di=903514b8925aa1333c5ba0bdd4e8d86b&imgtype=jpg&er=1&src=http%3A%2F%2Fp2.qhimg.com%2Ft01b2f396836f5ac5be.png" />
    <img id="img12" class="imgRotate"  onclick="rotateImg('img12')" src="https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1488937366&di=903514b8925aa1333c5ba0bdd4e8d86b&imgtype=jpg&er=1&src=http%3A%2F%2Fp2.qhimg.com%2Ft01b2f396836f5ac5be.png" />
    <input id="input2" type="button" value="点击旋转90度"></input>
</div>
</body>
<script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src="http://www.jq22.com/demo/jqueryrotate201705160103/js/jQueryRotate.js"></script>
<script type="text/javascript">

    var num = 0;
    // $("#img12").click(function(){
    //     num ++;
    //     $("#img12").rotate(90*num);
    // });


    function rotateImg(id) {
        num ++;
        $("#"+id).rotate(90*num);
    }
</script>
</html>