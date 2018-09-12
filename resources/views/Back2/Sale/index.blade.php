@extends('Back2.layout.head')
@section('content')

    <div class="wrapper wrapper-content">
        <div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
            <ul class="layui-tab-title">
                <li class="<?php if($pageFrom == 1)echo 'layui-this';?>">推广人员</li>
                <li class="<?php if($pageFrom == 2)echo 'layui-this';?>">销售推广码</li>
                <li class="<?php if($pageFrom == 3)echo 'layui-this';?>">中介推广码</li>
            </ul>
            <div class="layui-tab-content" style="height: 100px;">
                <div class="layui-tab-item <?php if($pageFrom == 1)echo 'layui-show';?>">
                    {{ $data->appends(['pageFrom'=>1])->links() }}
                    <table class="layui-table">
                        <colgroup>
                            <col width="150">
                            <col>
                            <col>
                            <col width="350">
                        </colgroup>
                        <thead>
                        <tr>
                            <th>推广人类型</th>
                            <th>姓名</th>
                            <th>手机</th>
                            <th>微信号</th>
                            <th>身份识别码</th>
                            <th>奖励金</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $v)
                            <tr>
                                <td>
                                    @if($v->sale_code)
                                        {{ $v->sale_code > 10000 && $v->sale_code < 20000 ? "销售人员" : "中介" }}
                                    @else
                                        无识别码
                                    @endif
                                </td>
                                <td>{{ $v->sale_name }}</td>
                                <td>{{ $v->sale_phone }}</td>
                                <td>{{ $v->sale_wechat }}</td>
                                <td>{{ $v->sale_code }}</td>
                                <td>{{ $v->balance }}</td>
                                <td>
                                    <button class="layui-btn layui-btn-sm layui-btn-normal" onclick="saleData({{ $v->user_id }})">查看推广数据</button>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="layui-tab-item <?php if($pageFrom == 2)echo 'layui-show';?>">

                    {{ $saleCodesale->appends(['pageFrom'=>2])->links() }}
                    <table class="layui-table">
                        <colgroup>
                            <col width="150">
                            <col>
                            <col>
                            <col width="350">
                        </colgroup>
                        <thead>
                        <tr>
                            <th>推广码</th>
                            <th>是否使用</th>
                            <th>是否已分配</th>
                            <th>使用人</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($saleCodesale as $v)
                            <tr>
                                <td>
                                 {{ $v->code }}
                                </td>
                                <td>{!! $v->is_use == 0 ?'<span class="label label-default">未使用</span>' : ' <span class="label label-primary layui-btn-green">已使用</span>' !!}</td>
                                <td>{!! $v->is_send == 0 ? '<span class="label label-default">未分配</span>' :'<span class="label label-primary layui-btn-green">已分配</span>' !!}</td>
                                <td>{{ $v->is_use == 0 ? "暂无" : \App\Model\Sale::where('sale_code',$v->code)->value('sale_name') }}</td>
                                <td>
                                    <button class="layui-btn layui-btn-sm layui-btn-normal" >修改为已分配</button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="layui-tab-item <?php if($pageFrom == 3)echo 'layui-show';?>">
                    {{ $midCodesale->appends(['pageFrom'=>3])->links() }}
                    <table class="layui-table">
                        <colgroup>
                            <col width="150">
                            <col>
                            <col>
                            <col width="350">
                        </colgroup>
                        <thead>
                        <tr>
                            <th>推广码</th>
                            <th>是否使用</th>
                            <th>是否已分配</th>
                            <th>使用人</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($midCodesale as $v)
                            <tr>
                                <td>
                                    {{ $v->code }}
                                </td>
                                <td>{!! $v->is_use == 0 ?'<span class="label label-default">未使用</span>' : ' <span class="label label-primary layui-btn-green">已使用</span>' !!}</td>
                                <td>{!! $v->is_send == 0 ? '<span class="label label-default">未分配</span>' :'<span class="label label-primary layui-btn-green">已分配</span>' !!}</td>
                                <td>{{ $v->is_use == 0 ? "暂无" : \App\Model\Sale::where('sale_code',$v->code)->value('sale_name') }}</td>
                                <td>
                                    <button class="layui-btn layui-btn-sm layui-btn-normal" >修改为已分配</button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{--<button class="layui-btn layui-btn-normal" onclick="adminAdd(0)"><i class="layui-icon "></i>新建账号</button>--}}

    </div>
    </div>


    </div>
    </body>


    <!-- Mirrored from www.zi-han.net/theme/hplus/index_v5.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 20 Jan 2016 14:18:52 GMT -->
    </html>
@endsection