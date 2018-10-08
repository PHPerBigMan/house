@extends('Back.layout.head')

@section('content')
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-sm-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-success pull-right">全年</span>
                    <h5>累计充值</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{ $data['transactionCount'] }}元</h1>
                    <div class="stat-percent font-bold text-success">
                    </div>
                    <small></small>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-info pull-right">全年</span>
                    <h5>累计提现</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{ $data['putForward'] }}元</h1>
                    <div class="stat-percent font-bold text-info">
                    </div>
                    <small></small>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-primary pull-right">全年</span>
                    <h5>成交订单</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{ $data['orderCount'] }}</h1>
                    <div class="stat-percent font-bold text-navy">
                    </div>
                    <small></small>
                </div>
            </div>
        </div>
        {{--<div class="col-sm-3">--}}
            {{--<div class="ibox float-e-margins">--}}
                {{--<div class="ibox-title">--}}
                    {{--<span class="label label-danger pull-right">全年</span>--}}
                    {{--<h5>累计行权订单</h5>--}}
                {{--</div>--}}
                {{--<div class="ibox-content">--}}
                    {{--<h1 class="no-margins">{{ $data['overCount'] }}</h1>--}}
                    {{--<div class="stat-percent font-bold text-danger">--}}
                    {{--</div>--}}
                    {{--<small></small>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}

        <div class="col-sm-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-danger pull-right">全年</span>
                        <h5>累计权利金</h5>
                            </div>
                                <div class="ibox-content">
                                    <h1 class="no-margins">{{ $data['rights'] }}</h1>
                                <div class="stat-percent font-bold text-danger">
                            </div>
                    <small></small>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-success pull-right">累计</span>
                    <h5>用户总数</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{ $data['userCount'] }}</h1>
                    <div class="stat-percent font-bold text-danger">
                    </div>
                    <small></small>
                </div>
            </div>
        </div>

        <div class="col-sm-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-primary pull-right">全年</span>
                    <h5>累计分成</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{ $data['count'] }}元</h1>
                    <div class="stat-percent font-bold text-navy">
                    </div>
                    <small></small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
@endsection