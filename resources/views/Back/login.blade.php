<!DOCTYPE html>

<html lang="en">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>购房意向电子登记管理系统</title>
		<link rel="bookmark" href="/favicon.ico" type="image/x-icon"　/>
		<!-- CSS -->
		<link rel="stylesheet" href="/login_files/css">
		<link rel="stylesheet" href="/login_files/bootstrap.min.css">
		<link rel="stylesheet" href="/login_files/font-awesome.min.css">
		<link rel="stylesheet" href="/login_files/form-elements.css">
		<link rel="stylesheet" href="/login_files/style.css">
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
	   <style type="text/css">
		   .form-bottom{background: #fff;box-shadow:0px 19px 48px rgba(3,70,113,0.5);}
		   input[type="text"], input[type="password"], textarea, textarea.form-control{ border: 1px solid #ccc;background:#fff;}
		   input[type="text"]:focus, input[type="password"]:focus, textarea:focus, textarea.form-control:focus {
			   outline: 0;
			   background: #fff;
			   border: 1px solid #1e9fff;
			   -moz-box-shadow: none;
			   -webkit-box-shadow: none;
			   box-shadow: none;
		   }
		   .footer-copyright{position: absolute;bottom: 5px;text-align: center;margin: 0 auto;width: 100%;color: #fff;font-size: 16px;}
		   .logoimg{display: block;margin: 0 auto;margin-bottom:25px;margin-top: 10px;}
		   *{font-family: "微软雅黑";}
		   .imgheader{text-align: center;font-size: 30px;margin-bottom: 40px;color: #333;font-weight: normal;}
		   .form-bottom{background: rgba(255,255,255,0.94);border-radius: 4px;}
	  </style>
	</head>
	<body>
		<div class="top-content" style="margin-top: 120px;">

			<div class="inner-bg">
				<div class="container">

					<div class="row">
						<div class="col-sm-6 col-sm-offset-3 form-box">

							<!--<form role="form" action="http://demo.cssmoban.com/cssthemes4/azds_multi-step-registration/index.html" method="post" class="registration-form">-->

								<fieldset style="display: block;">
									<form  action="{{URL::asset('/loginCheck')}}" method="post">
										{{ csrf_field() }}
										<div class="form-bottom" style="overflow: hidden;">
											<img class="logoimg" src="/login_files/logo.png"/>
											<h1 class="imgheader" ><?php echo SIGNNAME;?>购房意向电子登记管理系统</h1>
											<div class="form-group">
												<label class="sr-only" for="form-first-name">账户</label>
												<input type="text" name="account" placeholder="账户" class="form-first-name form-control" id="form-first-name">
											</div>
											<div class="form-group">
												<label class="sr-only" for="form-last-name">密码</label>
												<input type="password" name="password" placeholder="密码" class="form-last-name form-control" id="form-last-name">
											</div>

											<button style="opacity: 1; margin:0 auto;background: #1e9fff; display: block;width: 50%" type="submit" class="btn btn-next">登录</button>
										</div>
									</form>

								</fieldset>
						</div>
					</div>
				</div>
			</div>

		</div>

		<div class="footer-copyright" >
			<p style="margin: 0px;"> Copyright 2018, shoufangpai.com. All rights reserved. </p>
			<p style="font-size: 14px;">© 杭州链芯科技有限公司 | <a href="http://www.miitbeian.gov.cn/" style="font-size: 14px;color: white">浙ICP备18008358号-3</a></p>
		</div>
		<div class="backstretch" style="width: 100%; left: 0px; top: 0px; overflow: hidden; margin: 0px; padding: 0px; z-index: -999999; position: fixed;"><img src="/login_files/bg.jpg" style=" min-height: 100%; position: absolute; margin: 0px; padding: 0px; border: none; width: 100%; max-height: none; max-width: none; z-index: -999999; left: 0px; top: 0px;"></div>
	</body>

</html>
<script src="/js/jquery-2.1.4.min.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="http://www.heiyu.net.cn/layui/layui.js"></script>
<script type="text/javascript" src="http://www.heiyu.net.cn/geekclouds/js/login.js"></script>
<script type="text/javascript" src="http://www.heiyu.net.cn/geekclouds/jsplug/jparticle.jquery.js"></script>
<script type="text/javascript">
	var deheight=$(window).height();
	$(".backstretch").height(deheight);
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