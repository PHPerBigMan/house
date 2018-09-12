<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>推广数据</title>
    <link rel="shortcut icon" href="favicon.ico"> <link href="/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
    <link href="/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
    <link href="/css/animate.min.css" rel="stylesheet">
    <link href="/css/style.min862f.css?v=4.1.0" rel="stylesheet">
    <link href="/layui/css/layui.css" rel="stylesheet">
    <link href="/css/index.css?_v128" rel="stylesheet">
    <style>
        body{
            background-color: lightgray;
        }
    </style>
</head>
<body>

<div class="wrapper wrapper-content">
    @if($data)
    <div class="row">
        <div class="col-sm-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-success pull-right" style="background-color: #1e9fff!important;">次</span>
                    <h5>浏览量</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">
                        {{ $data['visitCount'] }}
                    </h1>

                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-success pull-right" style="background-color: #1e9fff!important;">人次</span>
                    <h5>预约量</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">
                        {{ $data['appointmentCount'] }}
                    </h1>

                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-success pull-right" style="background-color: #1e9fff!important;">人次</span>
                    <h5>到访量</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">
                        {{ $data['comeCount'] }}
                    </h1>

                </div>
            </div>
        </div>

        @if(isset($data['balance']))
            <div class="col-sm-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <span class="label label-success pull-right" style="background-color: #1e9fff!important;">元</span>
                        <h5>奖励金</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">
                            {{ $data['balance'] }}
                        </h1>

                    </div>
                </div>
            </div>
        @endif
    </div>
        @else
        <h1>暂无数据</h1>
    @endif
</div>
</body>
</html>