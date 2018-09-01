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
    <link href="/css/index.css?_v127" rel="stylesheet">
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
                    <a href="/admin/index" class="navbar-brand head-background head-background-padding">
                        <img src="/img/logo.png" alt="">
                    </a>
                </div>
                <div class="navbar-collapse collapse head-background " id="navbar">
                    <?php
                    $admin = \App\Model\Admin::where('id',session('admin'))->value('account');
                    ?>
                    <ul class="navl navbar-nav head-ul " id="list-ul">
                        <li class=<?php if($title == 'house') echo "high-color"?>>
                            <a aria-expanded="false" href="/admin/index" class="blocka"><i class="fa fa-home fa-fw"></i> 购房者管理</a>
                            {{--购房者管理--}}
                        </li>
                        @if($admin == 'admin')
                            <li class=<?php if($title == 'account') echo "high-color"?>>
                                <a aria-expanded="false" role="button" href="/admin/list" class="blocka"><i class="fa fa-user"></i> 账号管理</a>
                            </li>
                        @endif
                        <li class=<?php if($title == 'config') echo "high-color"?>>

                            <a aria-expanded="false" role="button" href="/admin/config" class="blocka"> <i class="fa fa-gear"></i> 项目配置</a>
                        </li>
                        <li class=<?php if($title == 'resultPage') echo "high-color"?>>

                            <a aria-expanded="false" role="button" href="/admin/resultPage" class="blocka"> <i class="fa fa-gear"></i> 结果查询</a>
                        </li>
                    </ul>
                    <ul class="navl navbar-top-links navbar-right head-ul" style="padding-right:60px!important; ">
                        <li>
                            <a href="/loginout" style="padding: 15px 10px" class="blocka">

                                <span>{{ $admin }}</span>
                                退出
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>

        <script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js">

        </script>
        <script src="/layui/layui.all.js"></script>
        <script type="text/javascript">
            $(function () {
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
                    $.post("/admin/result/search",{idCard:resultObj.resultContent.certNumber},function (obj) {
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
                            // location.href= "/admin/buy/read/"+obj.id+'/2/1';
                        }else{
                            layer.msg("暂未查询到结果")
                        }
                    });

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
        </head>
        <body bgcolor="#D2F0FF"  >

        <br/>
        <table border="0" width="100%" cellpadding="0" cellspacing="10">


            <tr>
                <td align="right">姓名：</td>
                <td><input type="text" id="partyName" size="49" style="width:400px;" readonly="readonly">(要求中间，两头都没有空格)</td>
                <td><img id="PhotoStr" src="" alt="Base64 image" /></td>
            </tr>

            <tr>
                <td align="right">身份证号：</td>
                <td><input type="text" id="certNumber" size="49" style="color:#FF0000;width:400px;" readonly="readonly">(居民身份号码，长度18位)</td>
            </tr>
        </table>
        <table border="0" width="50%" cellpadding="0" cellspacing="0" style="padding-left:100px;">
            <tr>
                <td><input type="button" value="读卡" onclick="readCert()"></td>
            </tr>
        </table>
        <object id="CertCtl" type="application/cert-reader" width="0" height="0">
            <p style="color:#FF0000;">控件不可用，可能未正确安装控件及驱动，或者控件未启用。</p>
        </object>

        </body>
        {{--<div class="footer" style="position: fixed;bottom: 0;width: 100%">--}}
        {{--<div class="pull-right" style="position: absolute;margin-left: 45%">&copy;  <a href="" target="_blank">杭州链芯科技有限公司</a>--}}
        {{--</div>--}}
        {{--</div>--}}
        <div class="footer-copyright" >
            <p style="margin: 0px;">?Copyright2018,?shoufangpai.net. All rights reserved.?</p>
            <p style="font-size: 14px;">? 杭州链芯科技有限公司 | <a href="http://www.miitbeian.gov.cn/" style="font-size: 14px">浙ICP备18008358号-3</a></p>

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
