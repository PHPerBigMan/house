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
<div class="wrapper wrapper-content">
    @if($data->status == 1)
        {{--初审中--}}
        <button class="layui-btn layui-btn-normal layui-btn-radius ">初审中</button>
        @elseif($data->status == 2)
        {{--待复审--}}
        <button class="layui-btn layui-btn-normal layui-btn-radius">待复审</button>
        @elseif($data->status == 3)
        {{--复审中--}}
        <button class="layui-btn layui-btn-normal layui-btn-radius">复审中</button>
        @elseif($data->status == 4)
        {{--审核不通过--}}
        <button class="layui-btn layui-btn-danger layui-btn-radius">审核不通过</button>
        @elseif($data->status == 5)
        {{--审核通过--}}
        <button class="layui-btn layui-btn-normal layui-btn-radius">审核通过</button>
        @endif
    <div class="row">
        <div class="col-sm-3">
            <div class="ibox float-e-margins">
                <div class="ibox-content mailbox-content">
                    <div class="file-manager">
                        <table class="layui-table" style="width: 180%!important;">
                            <colgroup>
                                <col width="300">
                                <col width="500">
                            </colgroup>
                            <tbody>
                            <tr>
                                <td>购房登记号</td>
                                <td>{{ $data->registration }}</td>
                            </tr>
                            <tr>
                                <td>姓名</td>
                                <td>
                                    {{ $data->name }}
                                    &nbsp;
                                    @if($type == 1)
                                    <span class="read-user" data-id="{{ $data->id }}" data-name="{{ $data->name }}">编辑</span>
                                        @endif
                                </td>
                            </tr>
                            <tr>
                                <td>手机号</td>
                                <td>{{ $data->phone }}</td>
                            </tr>
                            <tr>
                                <td>证件类型</td>
                                <td>{{ $data->cardType }}</td>
                            </tr>
                            <tr>
                                <td>证件号</td>
                                <td>{{ $data->idCard }}</td>
                            </tr>
                            <tr>
                                <td>无房家庭</td>
                                <td>{{ $data->haveHouse }}</td>
                            </tr>
                            <tr>
                                <td>户籍</td>
                                <td>{{ $data->household }}</td>
                            </tr>
                            <tr>
                                <td>婚姻状况</td>
                                <td>{{ $data->marriage }}</td>
                            </tr>
                            @if($data->marriage == '离异单身(含带未成年子女)')
                                <tr>
                                    <td>离异时间</td>
                                    <td>汉族</td>
                                </tr>
                            @endif
                            <tr>
                                <td>在杭州市（12区）房产数量</td>
                                <td>{{ $data->hzHouse }}</td>
                            </tr>
                            <tr>
                                <td>外地房产数量</td>
                                <td>{{ $data->otherHouse }}</td>
                            </tr>
                            <tr>
                                <td>
                                    <p>自购房之日起3年内在杭州市</p>
                                    <p>连续缴纳2年及以上社保或者个税（补缴不算）</p>
                                </td>
                                <td>{{ $data->security }}</td>
                            </tr>
                            <tr>
                                <td>首付比例</td>
                                <td>{{ $data->down }}</td>
                            </tr>
                            <tr>
                                <td>付款方式</td>
                                <td>{{ $data->pay }}</td>
                            </tr>
                            <tr>
                                <td>贷款记录</td>
                                <td>{{ $data->loan }}</td>
                            </tr>
                            <tr>
                                <td>面积段</td>
                                <td>{{ $data->area }}</td>
                            </tr>
                            <tr>
                                <td>最新提交时间</td>
                                <td>{{ $data->updated_at }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-7 animated fadeInRight" style="margin-left: 16%;margin-top: 20px">
            <div class="mail-box-header">
                <h2>
                    主购人资料
                </h2>
                <div class="mail-tools tooltip-demo m-t-md">
                </div>
            </div>
            <div class="mail-box">
                @if($data->img)
                    <div class="mail-body">
                        <div class="file-box">
                            <div class="file img-div-p">
                                <span class="corner"></span>

                                <div class="image">
                                    <img alt="image" class="img-responsive  img-div-center" src="{{ $data->img->idCardfront }}">
                                </div>
                                <div class="file-name" onclick="a()">
                                    身份证正面
                                </div>
                            </div>
                        </div>
                        <div class="file-box">
                            <div class="file img-div-p">
                                <span class="corner"></span>

                                <div class="image">
                                    <img alt="image" class="img-responsive  img-div-center" src="{{ $data->img->idCardback }}">
                                </div>
                                <div class="file-name">
                                    身份证反面
                                </div>
                            </div>
                        </div>
                        <div class="file-box">
                            <div class="file img-div-p">
                                <span class="corner"></span>

                                <div class="image">
                                    <img alt="image" class="img-responsive  img-div-center" src="{{ $data->img->accountBook }}">
                                </div>
                                <div class="file-name">
                                    户口本首页
                                </div>
                            </div>
                        </div>
                        <div class="file-box">
                            <div class="file img-div-p">
                                <span class="corner"></span>

                                <div class="image">
                                    <img alt="image" class="img-responsive  img-div-center" src="{{ $data->img->accountBookpersonal }}">
                                </div>
                                <div class="file-name">
                                    户口本个人页
                                </div>
                            </div>
                        </div>
                        @if($data->img->death)
                            <div class="file-box">
                                <div class="file img-div-p">
                                    <span class="corner"></span>

                                    <div class="image">
                                        <img alt="image" class="img-responsive  img-div-center" src="{{ $data->img->death }}">
                                    </div>
                                    <div class="file-name">
                                        死亡证明
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if($data->img->marry)
                            <div class="file-box">
                                <div class="file img-div-p">
                                    <span class="corner"></span>

                                    <div class="image">
                                        <img alt="image" class="img-responsive  img-div-center" src="{{ $data->img->marry }}">
                                    </div>
                                    <div class="file-name">
                                        结婚证
                                    </div>
                                </div>
                            </div>
                        @endif
                        @foreach($data->img->housing_situation as $v)
                            <div class="file-box">
                                <div class="file img-div-p">
                                    <span class="corner"></span>

                                    <div class="image">
                                        <img alt="image" class="img-responsive  img-div-center" src="{{ $v }}">
                                    </div>
                                    <div class="file-name">
                                        杭州住房证明
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @foreach($data->img->personal_credit as $v)
                            <div class="file-box">
                                <div class="file img-div-p">
                                    <span class="corner"></span>

                                    <div class="image">
                                        <img alt="image" class="img-responsive  img-div-center" src="{{ $v }}">
                                    </div>
                                    <div class="file-name">
                                        个人征信证明
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @foreach($data->img->fund_freezing as $v)
                            <div class="file-box">
                                <div class="file img-div-p">
                                    <span class="corner"></span>

                                    <div class="image">
                                        <img alt="image" class="img-responsive  img-div-center" src="{{ $v }}">
                                    </div>
                                    <div class="file-name">
                                        银行存款证明
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @if($data->img->divorce_img)
                            @foreach($data->img->divorce_img as $v)
                                <div class="file-box">
                                    <div class="file img-div-p">
                                        <span class="corner"></span>

                                        <div class="image">
                                            <img alt="image" class="img-responsive  img-div-center" src="{{ $v }}">
                                        </div>
                                        <div class="file-name">
                                            离婚材料
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    @endif
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="col-sm-12 animated" style="margin-top: 20px">
            <div class="mail-box-header">
                <h2>
                    关联人信息
                </h2>
                <div class="mail-tools tooltip-demo m-t-md">
                </div>
            </div>
            <div class="mail-box">
                <div class="file-box" style="width: 80%!important;margin-left: 5%">
                    @if($data->child)
                        <p>未成年子女信息:</p>
                        <table class="layui-table">
                            <colgroup>
                                <col width="150">
                                <col width="150">
                            </colgroup>
                            <thead>
                            <tr>
                                <th>名字</th>
                                <th>身份证号码</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data->child as $v)
                                <tr>
                                    <td>{{ $v['name'] }}</td>
                                    <td>{{ $v['idCard'] }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
                <div class="file-box" style="width: 80%!important;margin-left: 5%">
                    @if($data->other)
                        <p>其他人购房人信息:</p>
                        <table class="layui-table">
                            <colgroup>
                                <col width="150">
                                <col width="150">
                                <col width="150">
                                <col width="150">
                            </colgroup>
                            <thead>
                            <tr>
                                <th>名字</th>
                                <th>证件类型</th>
                                <th>证件号码</th>
                                <th>手机号码</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data->other as $v)
                                <tr>
                                    <td>{{ $v['name'] }}</td>
                                    <td>{{ $v['cardType'] }}</td>
                                    <td>{{ $v['idCard'] }}</td>
                                    <td>{{ $v['phone'] }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @foreach($data->img->other_img as $value)
                            <div class="file-box">
                                <div class="file img-div-p" >
                                    <span class="corner"></span>

                                    <div class="image" >
                                        <img alt="image" class="img-responsive  img-div-center-other" src="{{ $value['idCardfront'] }}">
                                    </div>
                                    <div class="file-name">
                                        身份证正面
                                    </div>
                                </div>
                            </div>
                            <div class="file-box">
                                <div class="file img-div-p">
                                    <span class="corner"></span>

                                    <div class="image">
                                        <img alt="image" class="img-responsive  img-div-center-other" src="{{ $value['idCardback'] }}">
                                    </div>
                                    <div class="file-name">
                                        身份证背面
                                    </div>
                                </div>
                            </div>
                            <div class="file-box">
                                <div class="file img-div-p">
                                    <span class="corner"></span>

                                    <div class="image">
                                        <img alt="image" class="img-responsive  img-div-center-other" src="{{ $value['accountBook'] }}">
                                    </div>
                                    <div class="file-name">
                                        户口本首页
                                    </div>
                                </div>
                            </div>
                            <div class="file-box">
                                <div class="file img-div-p">
                                    <span class="corner"></span>

                                    <div class="image">
                                        <img alt="image" class="img-responsive  img-div-center-other" src="{{ $value['accountBookmain'] }}">
                                    </div>
                                    <div class="file-name">
                                        户口本个主页
                                    </div>
                                </div>
                            </div>
                            <div class="file-box">
                                <div class="file img-div-p">
                                    <span class="corner"></span>

                                    <div class="image">
                                        <img alt="image" class="img-responsive  img-div-center-other" src="{{ $value['accountBookpersonal'] }}">
                                    </div>
                                    <div class="file-name">
                                        户口本个人页
                                    </div>
                                </div>
                            </div>

                        @endforeach
                    @endif
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="col-sm-12 animated" style="margin-top: 20px">
            <div class="mail-box-header">
                <h2>
                    住房情况查询证明
                </h2>
                <div class="mail-tools tooltip-demo m-t-md">
                </div>
            </div>
            <div class="mail-box">
                <div class="file-box" style="width: 80%!important;margin-left: 5%">
                    @if($data->child)
                        <table class="layui-table">
                            <colgroup>
                                <col width="150">
                                <col width="150">
                            </colgroup>
                            <tbody>
                            @foreach($data->file as $k=>$v)
                                <tr>
                                    <td>查档编号{{ $k+1 }}</td>
                                    <td>{{ $v }}
                                        &nbsp;
                                        @if($type == 1)
                                        <span class="file-user" data-id="{{ $data->id }}" data-name="{{ $v }}" data-list="{{ $k }}">编辑</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
                <div class="clearfix"></div>
            </div>
            <input type="hidden" id="type" value="{{ $type }}">
            @if($type == 1 || isset($from))
                <div style="width: 100%">
                    @if(in_array($data->status,[0,1]) && $data->firstTrial == session('admin'))
                        <button class="layui-btn layui-btn-green layui-btn-lg" style="margin-left: 45%" onclick="pass(1,{{ $data->id }})">初审通过</button>
                    @elseif($data->status== 3 && $data->finalTrial == session('admin'))
                        <button class="layui-btn layui-btn-green layui-btn-lg" style="margin-left: 45%" onclick="pass(2,{{ $data->id }})">复审通过</button>
                    @elseif($data->status == 5)
                        <button class="layui-btn layui-btn-green layui-btn-lg" style="margin-left: 45%">已通过复审</button>
                    @endif
                </div>
                @endif
            <input type="hidden" id="data-id" value="{{ $data->id }}">
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
<script src="/js/admin.js"></script>

<script>

</script>
<script type="text/javascript" src="http://tajs.qq.com/stats?sId=9051096" charset="UTF-8"></script>

</body>


<!-- Mirrored from www.zi-han.net/theme/hplus/index_v5.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 20 Jan 2016 14:18:52 GMT -->
</html>
