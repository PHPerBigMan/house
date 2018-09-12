<!DOCTYPE>
<html>


<!-- Mirrored from www.zi-han.net/theme/hplus/index_v5.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 20 Jan 2016 14:18:51 GMT -->
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta http-equiv="Content-Language" content="zh-cn">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name=”renderer” content=”webkit|ie-comp|ie-stand”>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理系统</title>

    <link rel="shortcut icon" href="favicon.ico"> <link href="/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
    <link href="/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
    <link href="/css/animate.min.css" rel="stylesheet">
    <link href="/css/style.min862f.css?v=4.1.0" rel="stylesheet">
    <link href="/layui/css/layui.css" rel="stylesheet">
    <link href="/css/index.css?_v128" rel="stylesheet">
    <style>
        .footer-copyright{position: absolute;bottom: 5px;
            text-align: center;margin: 0 auto;width: 100%;color: black;
            font-size: 16px;position: fixed;bottom: 0;line-height: 30px;background-color: #f5f8f9}
    </style>
</head>

<body class="gray-bg top-navigation">

<div id="">
    <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom white-bg">
            <nav class="navbar navbar-static-top" role="navigation">
                <div class="navbar-header">
                    <button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
                        <i class="fa fa-reorder"></i>
                    </button>
                    <a href="/admin/index" class="navbar-brand head-background head-background-padding" style="background-color: rgba(255,255,255,0)!important;">
                        <img src="/img/logo.png" alt="">
                    </a>
                </div>
                <div class="navbar-collapse collapse head-background " id="navbar">
                    <?php
                    $admin = \App\Model\Admin::where('id',session('admin'))->value('group');
                    $adminName = \App\Model\Admin::where('id',session('admin'))->value('account');
                    ?>
                    <ul class="navl navbar-nav head-ul " id="list-ul">
                        <li class=<?php if($title == 'house') echo "high-color"?>>
                            <a aria-expanded="false" href="/admin/index" class="blocka"><i class="fa fa-home fa-fw"></i> 购房者管理</a>
                            {{--购房者管理--}}
                        </li>
                        @if($admin == 0)
                            <li class=<?php if($title == 'account') echo "high-color"?>>
                                <a aria-expanded="false" role="button" href="/admin/list" class="blocka"><i class="fa fa-user"></i> 账号管理</a>
                            </li>

                            <li class=<?php if($title == 'config') echo "high-color"?>>

                                <a aria-expanded="false" role="button" href="/admin/config" class="blocka"> <i class="fa fa-gear"></i> 项目配置</a>
                            </li>
                            <li class=<?php if($title == 'sale') echo "high-color"?>>

                                <a aria-expanded="false" role="button" href="/admin/sale" class="blocka"> <i class="fa fa-user"></i> 推广人员</a>
                            </li>
                        @endif
                        <li class=<?php if($title == 'resultPage') echo "high-color"?>>

                            <a aria-expanded="false" role="button" href="/admin/resultPage" class="blocka"> <i class="fa fa-share-alt-square"></i> 结果查询</a>
                        </li>
                    </ul>
                    <ul class="navl navbar-top-links navbar-right head-ul" style="padding-right:60px!important; ">
                        <li>
                            <a href="/loginout" style="padding: 16px 10px" class="blocka">

                                <span>{{ $adminName }}</span>
                                退出
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>

@yield("content")
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
        <script src="/js/admin.js"></script>
        <script src="/js/back2.js"></script>
        {{--<div class="footer" style="position: fixed;bottom: 0;width: 100%">--}}
            {{--<div class="pull-right" style="position: absolute;margin-left: 45%">&copy;  <a href="" target="_blank">杭州链芯科技有限公司</a>--}}
            {{--</div>--}}
        {{--</div>--}}
        <div class="footer-copyright" >
            <p style="margin: 0px;"> Copyright 2018, shoufangpai.com. All rights reserved. </p>
            <p style="font-size: 14px;">© 杭州链芯科技有限公司 | <a href="http://www.miitbeian.gov.cn/" style="font-size: 14px">浙ICP备18008358号-3</a></p>

        </div>
        <script>
            function fullScreen(){
                $("#container").css({"width":window.screen.width*0.1});
                $("#list-ul").css({"margin-left":window.screen.width*0.035});
            }
            $(function () {
                fullScreen();
            })
        </script>
