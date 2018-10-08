<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>摇号结果查询</title>
    <link rel="shortcut icon" href="favicon.ico"> <link href="/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
    <link href="/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
    <link href="/css/animate.min.css" rel="stylesheet">
    <link href="/css/style.min862f.css?v=4.1.0" rel="stylesheet">
    <link href="/layui/css/layui.css" rel="stylesheet">
    <link href="/css/index.css?_v127" rel="stylesheet">
    <!--[if lt IE 9]>

    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
    <script src="/layui/layui.all.js"></script>
    <style type="text/css">
        *{font-family: "微软雅黑";}
        .titleresult{color: #FFFFFF;font-size:48px;text-align: center;}
        .titlep2{color: #FFFFFF;font-size:30px;text-align: center;margin-top: 160px;}
        .buttondiv{color: #1E9FFF;font-size: 30px;width: 400px;height: 80px;background:#FFFFFF;
            border-radius: 10px;line-height: 80px;font-weight: 500;margin: 0 auto;margin-top:90px ;cursor: pointer;text-align: center;
        }
        .buttondiv-1{color: #1E9FFF;font-size: 30px;width: 400px;height: 80px;background:#FFFFFF;
            border-radius: 10px;line-height: 80px;font-weight: 500;margin: 0 auto;margin-top:30px ;cursor: pointer;text-align: center;
        }
        .buttondiv-2{height:70px;border:0px}
        ::-webkit-input-placeholder { /* WebKit, Blink, Edge */
            color:    #1E9FFF;    font-size: 30px;text-align: center;
        }
        :-moz-placeholder { /* Mozilla Firefox 4 to 18 */
            color:   #1E9FFF;    font-size: 30px;text-align: center;
        }
        ::-moz-placeholder { /* Mozilla Firefox 19+ */
            color:    #1E9FFF;    font-size: 30px;text-align: center;
        }
        :-ms-input-placeholder { /* Internet Explorer 10-11 */
            color:   #1E9FFF;    font-size: 30px;text-align: center;
        }
        .buttondiv1{
            color: #1E9FFF;
            font-size: 30px;
            width: 400px;
            height: 80px;
            background: #FFFFFF;
            border-radius: 10px;
            line-height: 80px;
            font-weight: 500;
            margin: 0 auto;
            margin-top: 50px;
            cursor: pointer;
            text-align: center;
        }
    </style>
    <script type="text/javascript">

        // 添加回车事件,身份证查询
        $(document).keyup(function(event){
            if(event.keyCode ==13){
                var idCrad = $("#getIdcardByQrcode").val();
                if(!idCrad){
                    // layer.msg('<span style="font-size: 20px;line-height: 90px">请扫码查询</span>',{
                    //     area: ['15%','120px'],
                    // });
                    // return;
                    readCert();
                }
                $.get("/admin/result/search",{idCard:idCrad},function (obj) {

                    if(obj.code == 200){
                        location.href= "/admin/result/read/"+obj.id+'/2/1';
                    }else{
                        layer.msg('<span style="font-size: 20px;line-height: 90px">暂无结果</span>',{
                            area: ['15%','120px'],
                        })
                    }
                    $("#getIdcardByQrcode").val("");
                });
            }
        });

        function searchId() {
            layer.prompt({title: '输入身份证号,并确认', formType: 3}, function(idCard, index){
                layer.close(index);
                $.get("/admin/result/search",{idCard:idCard},function (obj) {

                    if(obj.code == 200){
                        location.href= "/admin/result/read/"+obj.id+'/2/1';
                    }else{
                        layer.msg('<span style="font-size: 20px;line-height: 90px">暂无结果</span>',{
                            area: ['15%','120px'],
                        })
                    }
                });
            });
        }
        $(function () {
            $("#getIdcardByQrcode").focus();
            clearForm();

            var CertCtl = document.getElementById("CertCtl");
            try {
                var result = CertCtl.connect();
                document.getElementById("result").value = result;
            } catch (e)
            {
            }
        });


        function getVerSion()
        {
            clearForm();

            var CertCtl = document.getElementById("CertCtl");
            try
            {
                var result = CertCtl.getVersion();
                document.getElementById("result").value = result;
            } catch (e)
            {
            }
        }
        function getSamId()
        {
            clearForm();

            var CertCtl = document.getElementById("CertCtl");
            try
            {
                var result = CertCtl.getSAMID();
                document.getElementById("result").value = result;
            } catch (e)
            {
            }
        }
        function toJson(str)
        {
            //var obj = JSON.parse(str);
            //return obj;
            return eval('('+str+')');
        }
        function clearForm()
        {
            // document.getElementById("timeElapsed").value = "";
            document.getElementById("partyName").value = "";
            // document.getElementById("gender").value = "";
            // document.getElementById("nation").value = "";
            // document.getElementById("bornDay").value = "";
            // document.getElementById("certAddress").value = "";
            document.getElementById("certNumber").value = "";
            // document.getElementById("certOrg").value = "";
            // document.getElementById("effDate").value = "";
            // document.getElementById("expDate").value = "";
            // document.getElementById("result").value = "";
        }

        function disconnect()
        {
            clearForm();

            var CertCtl = document.getElementById("CertCtl");
            try
            {
                var result = CertCtl.disconnect();
                // document.getElementById("result").value = result;
            } catch (e)
            {
            }
        }
        function getStatus()
        {
            clearForm();

            var CertCtl = document.getElementById("CertCtl");
            try {
                var result = CertCtl.getStatus();
                // document.getElementById("result").value = result;
            } catch(e) {
            }
        }
        function readCert()
        {


            clearForm();

            var CertCtl = document.getElementById("CertCtl");

            try {
                var startDt = new Date();
                var result = CertCtl.readCert();
                var endDt = new Date();

                // document.getElementById("timeElapsed").value = (endDt.getTime() - startDt.getTime()) + "毫秒";
                // document.getElementById("result").value = result;

                var resultObj = toJson(result);
                // if(!resultObj.resultContent.certNumber){
                //     layer.msg('<span style="font-size: 20px;line-height: 90px">请放置身份证进行查询</span>',{
                //         area: ['15%','120px'],
                //     });
                //     return false;
                // }
                if(resultObj.resultContent.certNumber){
                    $.get("/admin/result/search",{idCard:resultObj.resultContent.certNumber},function (obj) {
                        if (resultObj.resultFlag == 0) {
                            document.getElementById("partyName").value = resultObj.resultContent.partyName;
                            // document.getElementById("gender").value = resultObj.resultContent.gender;
                            // document.getElementById("nation").value = resultObj.resultContent.nation;
                            // document.getElementById("bornDay").value = resultObj.resultContent.bornDay;
                            // document.getElementById("certAddress").value = resultObj.resultContent.certAddress;
                            document.getElementById("certNumber").value = resultObj.resultContent.certNumber;
                            // document.getElementById("certOrg").value = resultObj.resultContent.certOrg;
                            // document.getElementById("effDate").value = resultObj.resultContent.effDate;
                            // document.getElementById("expDate").value = resultObj.resultContent.expDate;
                            document.getElementById("PhotoStr").src = "data:image/jpeg;base64,"+ resultObj.resultContent.identityPic;
                        }
                        if(obj.code == 200){
                            location.href= "/admin/result/read/"+obj.id+'/2/1';
                        }else{
                            layer.msg('<span style="font-size: 20px;line-height: 90px">暂无结果</span>',{
                                area: ['15%','120px'],
                            })
                        }
                    });
                }


            } catch(e)
            {
                alert(e);
            }
        }
        function conv2base64()
        {
            var CertCtl = document.getElementById("CertCtl");
            try
            {
                var jpgPath = document.getElementById("inputJpgPath").value;
                var result;
                result = CertCtl.ConvJpgToBase64File(jpgPath);
                document.getElementById("outputBase64File").value = result;
            } catch (e)
            {
            }
        }

        function convBase64ToJpg()
        {
            var CertCtl = document.getElementById("CertCtl");
            try
            {
                var jpgPath = document.getElementById("decodeJpgPath").value;
                var base64Data = document.getElementById("base64Input").value;
                var result;
                result = CertCtl.ConvBase64ToJpg(base64Data, jpgPath);
                alert(result);
            } catch (e) {
            }
        }

    </script>
    <script>
        function fullScreen(){
            $("#container").css({"width":window.screen.width*0.1});
            $("#list-ul").css({"margin-left":window.screen.width*0.035});
        }
        $(function () {
            fullScreen();
        })
    </script>

</head>
<body>
<div class="row border-bottom white-bg" style="height: 50px;">
    <nav class="navbar navbar-static-top" role="navigation">
        <div class="navbar-header">
            <button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
                <i class="fa fa-reorder"></i>
            </button>
            <a href="/admin/index" class="navbar-brand head-background head-background-padding">
                <img src="/img/logo.png" alt="">
            </a>
        </div>
        <div class="navbar-collapse collapse head-background " id="navbar">
            <?php
            $admin = \App\Model\Admin::where('id',session('admin'))->first();
            ?>
            <ul class="navl navbar-nav head-ul " id="list-ul">
                <li class=<?php if($title == 'house') echo "high-color"?>>
                    <a aria-expanded="false" href="/admin/index" class="blocka"><i class="fa fa-home fa-fw"></i> 购房者管理</a>
                    {{--购房者管理--}}
                </li>
                @if($admin->group == 0)
                    <li class=<?php if($title == 'account') echo "high-color"?>>
                        <a aria-expanded="false" role="button" href="/admin/list" class="blocka"><i class="fa fa-user"></i> 账号管理</a>
                    </li>

                    <li class=<?php if($title == 'config') echo "high-color"?>>

                        <a aria-expanded="false" role="button" href="/admin/config" class="blocka"> <i class="fa fa-gear"></i> 项目配置</a>
                    </li>
                @endif
                <li class=<?php if($title == 'resultPage') echo "high-color"?>>

                    <a aria-expanded="false" role="button" href="/admin/resultPage" class="blocka"> <i class="fa fa-share-alt-square"></i> 结果查询</a>
                </li>
            </ul>
            <ul class="navl navbar-top-links navbar-right head-ul" style="padding-right:60px!important; ">
                <li>
                    <a href="/loginout" style="padding: 15px 10px" class="blocka">

                        <span>{{ $admin->user }}</span>
                        退出
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</div>
<div class="top-content" style="margin-top: 120px;">
    <p class="titleresult">摇号结果查询</p>
    <p class="titlep2">将身份证放至阅读器后点击立即查询</p>
    <div   class="buttondiv" onclick="readCert()">立即查询</div>
    {{--<div   class="buttondiv-1" onclick="searchId()">输入身份证号</div>--}}


    <div    class="buttondiv-1" >
    <input type="text" id="getIdcardByQrcode" class="buttondiv-2" placeholder="请输入身份证">
    </div>
    <input type="hidden" id="partyName">
    <input type="hidden" id="certNumber">
    <input type="hidden" id="PhotoStr">
    <object id="CertCtl" type="application/cert-reader" width="0" height="0">
        <p style="color:#FF0000;text-align: center;margin-top: 20px;font-size: 20px">控件不可用，可能未正确安装控件及驱动，或者控件未启用。</p>
    </object>
</div>


<div class="backstretch" style="width: 100%; left: 0px; top: 0px; overflow: hidden; margin: 0px; padding: 0px; z-index: -999999; position: fixed;"><img src="/img/bj3.jpg" style=" min-height: 100%; position: absolute; margin: 0px; padding: 0px; border: none; width: 100%; max-height: none; max-width: none; z-index: -999999; left: 0px; top: 0px;"></div>
</body>
</html>

<script src="/js/jquery-2.1.4.min.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    var deheight=$(window).height();
    $(".backstretch").height(deheight);
</script>