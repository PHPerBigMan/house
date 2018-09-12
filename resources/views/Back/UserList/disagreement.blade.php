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
                    <h5>
                        @if($status->status == 4)
                            初审不通过
                            @else
                            复审不通过
                            @endif
                    </h5>
                </div>
                <div class="ibox-content" id="eg">
                    <ul class="layui-timeline">
                     @foreach($data as $v)
                            <li class="layui-timeline-item">
                                <i class="layui-icon layui-timeline-axis"></i>
                                <div class="layui-timeline-content layui-text">
                                    <h3 class="layui-timeline-title">

                                        @if(is_numeric(strpos($v->key,'her')))
                                            <?php $list = explode('_',$v->key);?>
                                            四县住房证明<?php echo $list[3]?>
                                            @elseif($v->key == 'idCardfront')
                                            身份证正面
                                            @elseif($v->key == 'idCardback')
                                            身份证背面
                                            @elseif($v->key == 'accountBook')
                                            户口本首页
                                            @elseif($v->key == 'accountBookmain')
                                            户口本主页
                                            @elseif($v->key == 'accountBookpersonal')
                                            户口本个人页
                                            @elseif($v->key == 'death')
                                            死亡证明
                                            @elseif($v->key == 'marry')
                                            结婚证
                                            @elseif(!strpos($v->key,'her') && strpos($v->key,'situation'))
                                            <?php $list = explode('_',$v->key);?>
                                                杭州住房证明<?php echo $list[2]?>

                                            @elseif(strpos($v->key,'urity'))
                                            <?php $list = explode('_',$v->key);?>
                                                社保证明<?php echo $list[2]?>

                                            @elseif(strpos($v->key,'credit'))
                                            <?php $list = explode('_',$v->key);?>
                                                个人征信<?php echo $list[2]?>
                                            @elseif(strpos($v->key,'Come'))
                                            <?php $list = explode('_',$v->key);?>
                                                收入证明<?php echo $list[1]?>
                                            @elseif(strpos($v->key,'freez'))
                                            <?php $list = explode('_',$v->key);?>
                                                资产证明<?php echo $list[2]?>
                                            @elseif(strpos($v->key,'vorce'))
                                            <?php $list = explode('_',$v->key);?>
                                            离婚材料<?php echo $list[2]?>
                                            @elseif($v->type == 1)
                                           <?php
                                                $name = explode('-',$v->key);

                                            ?>
                                            {{ $name[2] }}的
                                            @if($name[1] == 'idCardfront')
                                                身份证正面
                                                @else
                                                   身份证背面
                                                @endif
                                        @endif
                                    </h3>
                                    <ul>
                                        <li>
                                            <span class="disagreementfont">{{ $v->reason }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                         @endforeach
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
