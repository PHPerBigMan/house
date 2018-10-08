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
    <style type="text/css">
        .transform90{
            transform: rotate(90deg);
            -webkit-transform: rotate(90deg);
            -moz-transform: rotate(90deg);
            -o-transform: rotate(90deg);
            -ms-transform: rotate(90deg);
            margin-top: 12%;

        }
        .transform180{
            transform: rotate(180deg);
            -webkit-transform: rotate(180deg);
            -moz-transform: rotate(180deg);
            -o-transform: rotate(180deg);
            -ms-transform: rotate(180deg);
        }
        .transform270{
            transform: rotate(270deg);
            -webkit-transform: rotate(270deg);
            -moz-transform: rotate(270deg);
            -o-transform: rotate(270deg);
            -ms-transform: rotate(270deg);
        }
        .transform360{
            transform: rotate(360deg);
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
        }
        /*.buttonzoo button{*/
        /*!*width: 60px;*!*/
        /*!*height: 28px;*!*/
        /*margin-left: 20px;*/
        /*line-height: 28px;*/
        /*margin-top: 4px;*/
        /*}*/
        .buttonzoo{
            position: fixed;
            background: #fff;
            width: 100%;
            z-index: 90;
            /*top: 10px;*/
            margin-top: 4px;
            top: -10px;padding: 10px;
        }

        .kong{width: 100%;height: 60px;}

        .swiper-slide.swiper-slide-active{text-align: center !important;}
    </style>
</head>
<body>
<div class="buttonzoo">

    <button class="layui-btn layui-btn-green" value="90">旋转90度</button>
    {{--<button class="layui-btn layui-btn-green" value="90">旋转90</button>--}}
    <button class="layui-btn layui-btn-green" value="180">旋转180</button>
    <button class="layui-btn layui-btn-green" value="270">旋转270</button>
    <button class="layui-btn layui-btn-green" value="360">旋转360</button>
    <button class="layui-btn layui-btn-green" value="big">放大</button>
    <button class="layui-btn layui-btn-green" value="small">缩小</button>
</div>
<div class="kong"></div>
<div>
    <div>
        @if($data->other)
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
                <tr>
                    <td colspan="8" style="text-align: center"><h3>其他购房者</h3></td>
                </tr>
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
        @endif
        @if($data->child)
            <table class="layui-table" style="width: 90%;margin-left: 5%">
                <colgroup>
                    <col width="80">
                    <col width="120">
                    <col width="80">
                    <col width="120">
                </colgroup>
                <thead>
                <tbody>
                    <tr>
                        <td colspan="4" style="text-align: center"><h3>子女信息</h3></td>
                    </tr>
                    @foreach($data->child as $k=>$v)
                        <tr>
                            <td>姓名</td>
                            <td>{{ $v['name'] }}</td>
                            <td>证件号</td>
                            <td>{{ $v['idCard'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
<div class="swiper-container" style="width: 90%;height: 100%">
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
                <div class="swiper-slide  " data-hash="idCardfront-{{ $data->other[$k]['idCard'] }}">

                    <img src="{{ $v['idCardfront'] }}" alt="身份证正面" title="other-idCardfront-{{ $data->other[$k]['name'] }}">
                </div>
                <div class="swiper-slide  "  data-hash="idCardback-{{ $data->other[$k]['idCard'] }}">

                    <img src="{{ $v['idCardback'] }}" alt="身份证背面" title="other-idCardback-{{ $data->other[$k]['name'] }}">
                </div>
                <div class="swiper-slide  " style="" data-hash="accountBook-{{ $data->other[$k]['idCard'] }}">

                    <img src="{{ $v['accountBook'] }}" alt="户口本首页" title="other-accountBook-{{ $data->other[$k]['name'] }}">
                </div>
                <div class="swiper-slide  " style="" data-hash="accountBookmain-{{ $data->other[$k]['idCard'] }}">

                    <img src="{{ $v['accountBookmain'] }}" alt="户口本主页" title="other-accountBookmain-{{ $data->other[$k]['name'] }}">
                </div>
                <div class="swiper-slide  "  data-hash="accountBookpersonal-{{ $data->other[$k]['idCard'] }}">

                    <img src="{{ $v['accountBookpersonal'] }}" alt="户口本个人页" title="other-accountBookpersonal-{{ $data->other[$k]['name'] }}">
                </div>
            @endforeach
        @endif

        @if($data->child)
            @if($data->img->child_img)
                @foreach($data->img->child_img as $k=>$v)
                    <div class="swiper-slide  "  data-hash="child-img-{{ $k+1 }}">

                        <img src="{{ $v['accountBookpersonal']  }}" alt="未成年人户口本个人页" title="child-img-{{ $data->child[$k]['name'] }}">
                    </div>
                @endforeach
            @endif
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
    $(".buttonzoo button").click(function(){

        var thisv=$(this).attr('value');
        if(thisv=='90'){
            $(".swiper-slide.swiper-slide-active img").removeClass('transform90')
            $(".swiper-slide.swiper-slide-active img").removeClass('transform270')
            $(".swiper-slide.swiper-slide-active img").removeClass('transform180')
            $(".swiper-slide.swiper-slide-active img").removeClass('transform360')
            $(".swiper-slide.swiper-slide-active img").addClass('transform90')
        }else if(thisv=='270'){
            $(".swiper-slide.swiper-slide-active img").removeClass('transform90')
            $(".swiper-slide.swiper-slide-active img").removeClass('transform270')
            $(".swiper-slide.swiper-slide-active img").removeClass('transform180')
            $(".swiper-slide.swiper-slide-active img").removeClass('transform360')
            $(".swiper-slide.swiper-slide-active  img").addClass('transform270')
        }else if(thisv=='180'){
            $(".swiper-slide.swiper-slide-active img").removeClass('transform90')
            $(".swiper-slide.swiper-slide-active img").removeClass('transform270')
            $(".swiper-slide.swiper-slide-active img").removeClass('transform180')
            $(".swiper-slide.swiper-slide-active img").removeClass('transform360')
            $(".swiper-slide.swiper-slide-active  img").addClass('transform180')
        }else if(thisv=='360'){
            $(".swiper-slide.swiper-slide-active img").removeClass('transform90')
            $(".swiper-slide.swiper-slide-active img").removeClass('transform270')
            $(".swiper-slide.swiper-slide-active img").removeClass('transform180')
            $(".swiper-slide.swiper-slide-active img").removeClass('transform360')
            $(".swiper-slide.swiper-slide-active  img").addClass('transform360')
        }
        var img=$(".swiper-slide.swiper-slide-active").find('img')[0];
        var naturalW = img.naturalWidth;
        var naturalH = img.naturalHeight;
        if(thisv=='small'){
            var attrwidth=$(".swiper-slide.swiper-slide-active").find('img').attr('width');
            if(attrwidth!=null){
                naturalW=attrwidth;
            }
            $(".swiper-slide.swiper-slide-active").find('img').attr('width',naturalW*0.7);
            $(".swiper-slide.swiper-slide-active").find('img').css('width',naturalW*0.7)
        }
        if(thisv=='big'){
            var attrwidth=$(".swiper-slide.swiper-slide-active").find('img').attr('width');
            if(attrwidth!=null){
                naturalW=attrwidth;
            }
            $(".swiper-slide.swiper-slide-active").find('img').attr('width',naturalW*1.2);
            $(".swiper-slide.swiper-slide-active").find('img').css('width',naturalW*1.2)
        }

        console.log(naturalW);
    })
</script>
</html>