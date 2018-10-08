<!doctype html>
<html lang="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="favicon.ico"> <link href="/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
    <link href="/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
    <link href="/css/animate.min.css" rel="stylesheet">
    <link href="/css/style.min862f.css?v=4.1.0" rel="stylesheet">
    <link href="/layui/css/layui.css" rel="stylesheet">
    <link href="/css/index.css" rel="stylesheet">
    <title>Document</title>
</head>
<body>
<div class="wrapper wrapper-content">
    <form id="admin-from" class="layui-form">
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">账号</label>
                <div class="layui-input-inline">
                    <input type="text" name="account" autocomplete="off" class="layui-input" value="{{ $data->account }}">
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">密码</label>
                <div class="layui-input-inline">
                    <input type="text" name="password"autocomplete="off" class="layui-input" value="*****">
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">使用人</label>
                <div class="layui-input-inline">
                    <input type="text" name="user" autocomplete="off" class="layui-input" value="{{ $data->user }}">
                </div>
            </div>
            <div class="layui-inline">
                <div class="layui-form-item">
                    <label class="layui-form-label" style="width: 100px">账号类型 </label>
                    <div class="layui-input-inline">
                        <select name="type">
                            <option value="0" <?php if($data->type == 0)echo "selected"?>>销售</option>
                            <option value="1"  <?php if($data->type == 1)echo "selected"?>>银行</option>
                        </select>
                    </div>
                </div>
            </div>
            <input type="hidden" value="{{ $data->id }}" name="id">
        </div>
    </form>
    <div style="width: 100%">
        <button class="layui-btn layui-btn-lg layui-btn-normal" style="margin-left: 45%" onclick="adminSave()">保存</button>
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

</body>

</body>
</html>