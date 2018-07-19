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

<body class="gray-bg top-navigation">

<div id="">
    <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom white-bg">
            <nav class="navbar navbar-static-top" role="navigation">
                <div class="navbar-header">
                    <button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
                        <i class="fa fa-reorder"></i>
                    </button>
                    <a href="#" class="navbar-brand head-background head-background-padding">
                        <img src="/img/logo.png" alt="">
                    </a>
                </div>
                <div class="navbar-collapse collapse head-background " id="navbar">
                    <?php
                    $admin = \App\Model\Admin::where('id',session('admin'))->value('account');
                    ?>
                    <ul class="navl navbar-nav head-ul ">
                        <li class=<?php if($title == 'house') echo "high-color"?>>
                            <a aria-expanded="false" href="/admin/index"><i class="fa fa-home fa-fw"></i> 购房者管理</a>
                            {{--购房者管理--}}
                        </li>
                        @if($admin == 'admin')
                            <li class=<?php if($title == 'account') echo "high-color"?>>
                                <a aria-expanded="false" role="button" href="/admin/list"><i class="fa fa-user"></i> 账号管理</a>
                            </li>
                            @endif
                        <li class=<?php if($title == 'config') echo "high-color"?>>

                            <a aria-expanded="false" role="button" href="/admin/config"> <i class="fa fa-gear"></i> 项目配置</a>
                        </li>
                    </ul>
                    <ul class="navl navbar-top-links navbar-right head-ul" style="padding-right:60px!important; ">
                        <li>
                            <a href="/loginout" style="padding: 15px 10px">

                                <span>{{ $admin }}</span>
                                退出
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>

@yield("content")
