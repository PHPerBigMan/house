<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.0.2/css/swiper.min.css">
    <link rel="shortcut icon" href="favicon.ico"> <link href="/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
    <link href="/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
    <link href="/css/animate.min.css" rel="stylesheet">
    <link href="/css/style.min862f.css?v=4.1.0" rel="stylesheet">
    <link href="/layui/css/layui.css" rel="stylesheet">
    <link href="/css/index.css" rel="stylesheet">
    <title>审核</title>
</head>
<body>
<div>
    <div>
        <table class="layui-table" style="width: 90%;margin-left: 5%">
            <colgroup>
                <col width="80">
                <col width="120">
                <col width="80">
                <col width="120">
                <col width="80">
                <col width="120">
            </colgroup>
            <thead>
            <tbody>
            <tr>
                <td>姓名</td>
                <td>{{ $data->name }}</td>
                <td>手机号</td>
                <td>{{ $data->phone }}</td>
                <td>证件类型</td>
                <td>{{ $data->cardType }}</td>
            </tr>
            <tr>
                <td>证件号</td>
                <td>{{ $data->idCard }}</td>
                <td>无房家庭</td>
                <td>{{ $data->haveHouse }}</td>
                <td>户籍</td>
                <td>{{ $data->household }}</td>
            </tr>
            <tr>
                <td>婚姻状况</td>
                <td>{{ $data->marriage }}</td>
                <td>在杭州市(12区)房产数量</td>
                <td>{{ $data->hzHouse }}</td>
                <td>外地房产数量</td>
                <td>{{ $data->otherHouse }}</td>
            </tr>
            <tr>
                <td>3年内有连续缴满2年社保/个税</td>
                <td>{{ $data->security }}</td>
                <td>首付比例</td>
                <td>{{ $data->down }}</td>
                <td>付款方式</td>
                <td>{{ $data->pay }}</td>
            </tr>
            <tr>
                <td>贷款记录</td>
                <td>{{ $data->loan }}</td>
                <td>查档编号</td>
                <td>
                    @if($data->file)
                        @foreach($data->file as $v)
                            {{ $v }}
                            @endforeach
                        @endif
                </td>
                <td>面积段</td>
                <td>{{ $data->area }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="swiper-container" style="width: 90%">
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
        <legend id="img-title">身份证正面</legend>
    </fieldset>
    {{--<span style="text-align: left;font-family: '微软雅黑 Light';line-height: 30px;color: #0d8ddb;font-size: 20px;margin-left: 5%" id="img-title">身份证正面</span>--}}
@if($data->firstTrial == session('admin') || $data->finalTrial == session('admin'))
    @if(in_array($data->status,[1,2,3]))
            <button class="layui-btn layui-btn-green" style="margin-bottom: 10px;float: right;width: 100px" id="disagreement" title="idCardfront" onclick="disagreement({{ $data->id }})">不合规</button>
        @endif
    @endif
    <div class="swiper-wrapper">

        <div class="swiper-slide  " data-hash="idCardfront">
            <img src="{{ $data->img->idCardfront }}" alt="身份证正面"  title="idCardfront">
        </div>
        <div class="swiper-slide  " data-hash="idCardback">
            <img alt="身份证背面" src="{{ $data->img->idCardback }}" title="idCardback" >
        </div>
        <div class="swiper-slide  " data-hash="accountBook">
            <img src="{{ $data->img->accountBook }}" alt="户口本首页" title="accountBook">
        </div>
        <div class="swiper-slide" data-hash="accountBookmain">
            <img src="{{ $data->img->accountBookmain }}" alt="户口本主页" title="accountBookmain">
        </div>
        <div class="swiper-slide  " data-hash="accountBookpersonal">
            <img src="{{ $data->img->accountBookpersonal }}" alt="户口本个人页" title="accountBookpersonal">
        </div>
        @if($data->img->death)
            <div class="swiper-slide  " data-hash="death">
                <img src="{{ $data->img->death }}" alt="死亡证明" title="death">
            </div>
            @endif
        @if($data->img->marry)
            <div class="swiper-slide  " data-hash="marry">
                <img src="{{ $data->img->marry }}" alt="结婚证" title="marry">
            </div>
        @endif
        @if($data->img->other_housing_situation)
            @foreach($data->img->other_housing_situation as $v)
                <div class="swiper-slide" data-hash="other_housing_situation">
                    <img src="{{ $v }}" alt="其他地区房产证明" title="other_housing_situation">
                </div>
                @endforeach
        @endif
        @if($data->img->housing_situation)
            @foreach($data->img->housing_situation as $v)
                <div class="swiper-slide  " data-hash="housing_situation">
                    <img src="{{ $v }}" alt="杭州住房证明" title="housing_situation">
                </div>
            @endforeach
        @endif
        @if($data->img->security_img)
            @foreach($data->img->security_img as $v)
                <div class="swiper-slide  " data-hash="security_img">
                    <img src="{{ $v }}" alt="社保证明" title="security_img">
                </div>
            @endforeach
        @endif
        @if($data->img->personal_credit)
            @foreach($data->img->personal_credit as $v)
                <div class="swiper-slide" data-hash="personal_credit">
                    <img src="{{ $v }}" alt="个人征信" title="personal_credit">
                </div>
            @endforeach
        @endif
        @if($data->img->fund_freezing)
            @foreach($data->img->fund_freezing as $v)
                <div class="swiper-slide  " data-hash="fund_freezing">
                    <img src="{{ $v }}" alt="资产证明" title="fund_freezing">
                </div>
            @endforeach
        @endif
        @if($data->img->divorce_img)
            @foreach($data->img->divorce_img as $v)
                <div class="swiper-slide  " data-hash="divorce_img">
                    <img src="{{ $v }}" alt="离婚材料" title="divorce_img">
                </div>
            @endforeach
        @endif
    </div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
</div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.3.3/js/swiper.min.js"></script>
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
</html>