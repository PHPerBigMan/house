<!DOCTYPE html>
<html>


<!-- Mirrored from www.zi-han.net/theme/hplus/index_v5.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 20 Jan 2016 14:18:51 GMT -->
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>管理系统</title>

    <link rel="shortcut icon" href="favicon.ico"> <link href="/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
    <link href="/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
    <link href="/css/animate.min.css" rel="stylesheet">
    <link href="/css/style.min862f.css?v=4.1.0" rel="stylesheet">
    <link href="/layui/css/layui.css" rel="stylesheet">

</head>

<body class="gray-bg top-navigation">

<div id="wrapper">
    <from action="/api/qiniuImg" method="post" >

    </from>
</div>

    <script src="/js/jquery.min.js?v=2.1.4"></script>
    <script src="/js/bootstrap.min.js?v=3.3.6"></script>
    {{--<script src="/js/content.min.js?v=1.0.0"></script>--}}
    <script src="/js/plugins/flot/jquery.flot.js"></script>
    <script src="/js/plugins/flot/jquery.flot.tooltip.min.js"></script>
    <script src="/js/plugins/flot/jquery.flot.resize.js"></script>
    <script src="/js/plugins/chartJs/Chart.min.js"></script>
    <script src="/js/plugins/peity/jquery.peity.min.js"></script>
    <script src="/js/demo/peity-demo.min.js"></script>
    <script src="/layui/layui.js"></script>
<script>
    function test() {
        $.post('http://localhost:8686/api/get',{phone:13858126468,type:3},function (obj) {
            console.log(obj)
        })
    }
</script>
</body>


<!-- Mirrored from www.zi-han.net/theme/hplus/index_v5.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 20 Jan 2016 14:18:52 GMT -->
</html>
