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
                <col width="80">
                <col width="120">
            </colgroup>
            <thead>
            <tbody>
            @foreach($data->other as $k=>$v)
                <tr>
                    <td>姓名</td>
                    <td>{{ $v['name'] }}</td>
                    <td>手机号</td>
                    <td>{{ $v['phone'] }}</td>
                    <td>证件类型</td>
                    <td>{{ $v['cardType'] }}</td>
                    <td>证件号</td>
                    <td>{{ $v['idCard'] }}</td>
                </tr>
                @endforeach
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
            <button class="layui-btn layui-btn-green" style="margin-bottom: 10px;float: right;width: 100px" id="disagreement" title="other-idCardfront-{{ $data->other[0]['name'] }}" onclick="disagreement({{ $data->id }},1)">不合规</button>
        @endif
    @endif
    <div class="swiper-wrapper">

        {{--<div class="swiper-slide  ">--}}
            {{--<img src="{{ $data->img->idCardfront }}" alt="身份证正面"  title="idCardfront">--}}
        {{--</div>--}}
        @if($data->img->other_img)
            @foreach($data->img->other_img as $k=>$v)
                <div class="swiper-slide  " style="margin-top: 20%" data-hash="idCardfront-{{ $data->other[$k]['idCard'] }}">

                    <img src="{{ $v['idCardfront'] }}" alt="身份证正面" title="other-idCardfront-{{ $data->other[$k]['name'] }}">
                </div>
                <div class="swiper-slide  " style="margin-top: 20%" data-hash="idCardback-{{ $data->other[$k]['idCard'] }}">

                    <img src="{{ $v['idCardback'] }}" alt="身份证背面" title="other-idCardback-{{ $data->other[$k]['name'] }}">
                </div>
                <div class="swiper-slide  " style="margin-top: 20%" data-hash="accountBook-{{ $data->other[$k]['idCard'] }}">

                    <img src="{{ $v['accountBook'] }}" alt="户口本首页" title="other-accountBook-{{ $data->other[$k]['name'] }}">
                </div>
                <div class="swiper-slide  " style="margin-top: 20%" data-hash="accountBookmain-{{ $data->other[$k]['idCard'] }}">

                    <img src="{{ $v['accountBookmain'] }}" alt="户口本主页" title="other-accountBookmain-{{ $data->other[$k]['name'] }}">
                </div>
                <div class="swiper-slide  " style="margin-top: 20%" data-hash="accountBookpersonal-{{ $data->other[$k]['idCard'] }}">

                    <img src="{{ $v['accountBookpersonal'] }}" alt="户口本个人页" title="other-accountBookpersonal-{{ $data->other[$k]['name'] }}">
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