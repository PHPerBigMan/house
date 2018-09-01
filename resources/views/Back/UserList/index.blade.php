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
    <link href="/css/index.css" rel="stylesheet">

</head>

<body class="gray-bg">
    <body class="gray-bg">
    <div class="layui-canvs"></div>
    <div class="wrapper-content">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>操作记录</h5>
                </div>
                <div class="ibox-content" id="eg">
                    <ul class="layui-timeline">
                        @if(isset($data->list_use[0]))
                            <li class="layui-timeline-item">
                                <i class="layui-icon layui-timeline-axis"></i>
                                <div class="layui-timeline-content layui-text">
                                    <h3 class="layui-timeline-title">{{ $data->list_use[0]['value'] }}</h3>
                                    <ul>
                                        <li>用户上传资料</li>
                                    </ul>
                                </div>
                            </li>
                            @endif
                            @if(isset($data->list_use[1]))
                                <li class="layui-timeline-item">
                                    <i class="layui-icon layui-timeline-axis"></i>
                                    <div class="layui-timeline-content layui-text">
                                        <h3 class="layui-timeline-title">{{ $data->list_use[1]['value'] }}</h3>
                                        <ul>
                                            <li>用户完善资料</li>
                                        </ul>
                                    </div>
                                </li>
                            @endif
                            @if(isset($data->list_use[2]))
                                <li class="layui-timeline-item">
                                    <i class="layui-icon layui-timeline-axis"></i>
                                    <div class="layui-timeline-content layui-text">
                                        <h3 class="layui-timeline-title">{{ $data->list_use[2]['value'] }}</h3>
                                        <ul>
                                            <li>用户完善资料</li>
                                        </ul>
                                    </div>
                                </li>
                            @endif
                            @if(isset($data->list_use[3]))
                                <li class="layui-timeline-item">
                                    <i class="layui-icon layui-timeline-axis"></i>
                                    <div class="layui-timeline-content layui-text">
                                        <h3 class="layui-timeline-title">{{ $data->list_use[3]['value'] }}</h3>
                                        <ul>
                                            <li>用户注册</li>
                                        </ul>
                                    </div>
                                </li>
                            @endif
                    </ul>
                </div>
            </div>
        </div>
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
    <script src="/layui/layui.all.js"></script>
    <script src="/js/admin.all.js"></script>


    </body>


<!-- Mirrored from www.zi-han.net/theme/hplus/index_v5.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 20 Jan 2016 14:18:52 GMT -->
</html>
