<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>摇号系统登录</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <!-- load css -->
    <link rel="stylesheet" type="text/css" href="http://www.heiyu.net.cn/layui/css/layui.css" media="all">
    <link rel="stylesheet" type="text/css" href="http://www.heiyu.net.cn/geekclouds/css/login.css" media="all">
</head>
<body>
<div class="layui-canvs"></div>
<div class="layui-layout layui-layout-login">
    <h1>
        <strong>后台登陆</strong>
    </h1>
    <form role="form" action="{{URL::asset('loginCheck')}}" method="post" class="registration-form">
        <fieldset>
            {{ csrf_field() }}
                <div class="layui-user-icon larry-login">
                    <input name="account" type="text" placeholder="账号" class="login_txtbx"/>
                </div>
                <div class="layui-pwd-icon larry-login">
                    <input name="password" type="password" placeholder="密码" class="login_txtbx"/>
                </div>
                <div class="layui-submit larry-login">
                    <input type="submit" value="立即登陆" class="submit_btn"/>
                </div>
        </fieldset>
    </form>
</div>
<script src="http://www.heiyu.net.cn/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="http://www.heiyu.net.cn/layui/layui.js"></script>
<script type="text/javascript" src="http://www.heiyu.net.cn/geekclouds/js/login.js"></script>
<script type="text/javascript" src="http://www.heiyu.net.cn/geekclouds/jsplug/jparticle.jquery.js"></script>

<script type="text/javascript">
    $(function(){
        layui.use('layer', function(){
            var layer = layui.layer
                ,$ = layui.jquery;
            @if ($errors->any())
            @foreach ($errors->all() as $error)
            layer.msg("{{ $error }}");
            @break
            @endforeach
            @endif

            @if(session('error'))
            layer.msg("{{session('error')}}");
            @endif
            @if(session('success'))
            layer.msg("{{session('success')}}");
            @endif
        });
        $(".layui-canvs").jParticle({
            background: "#141414",
            color: "#E6E6E6"
        });
    });
</script>
</body>
</html>