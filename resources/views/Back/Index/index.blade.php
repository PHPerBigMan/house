@extends('Back.layout.head')
@section('content')
    <style>
        .sign{
            margin: 10px;}
        .sign>span{
            color: gray;
        }
    </style>
        <div class="wrapper wrapper-content">
            <div class="container" style="width: 100%!important;">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <span class="label label-success pull-right" style="background-color: #1e9fff!important;">截至目前</span>
                                <h5>登录人数</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins">
                                    <?php echo \App\Model\Buy::count();?>
                                </h1>

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <span class="label label-success pull-right" style="background-color: #1e9fff!important;">截至目前</span>
                                <h5>提交人数</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins">
                                    <?php echo \App\Model\Buy::whereIn('status',[0,1,2,3,4,5,7])->count();?>
                                </h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <span class="label label-success pull-right" style="background-color: #1e9fff!important;">截至目前</span>
                                <h5>通过人数</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins">
                                    <?php echo \App\Model\Buy::whereIn('status',[5])->count();?>
                                </h1>

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <span class="label label-success pull-right" style="background-color: #1e9fff!important;">截至目前</span>
                                <h5>通过中无房人数</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins">
                                    <?php echo \App\Model\Buy::whereIn('status',[5])
                                        ->where('haveHouse',"是")->count();?>
                                </h1>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="sign">
                    <span>提示：登记期间极少数情况下，用户可能会因其自身网络或手机软硬件问题出现卡顿或图片上传问题。请销售顾问建议用户调整上网环境（使用Wifi）、尝试刷新或更换手机进行登记。</span>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="ibox">
                            <div class="ibox-title">
                                <h5>查询</h5>
                            </div>
                            <div class="ibox-content">
                                <form class="layui-form" action="">
                                    <div class="layui-form-item">
                                        <div class="layui-inline" >
                                            <label class="layui-form-label">手机号</label>
                                            <div class="layui-input-inline">
                                                <input type="tel" name="phone" autocomplete="off" class="layui-input" value="<?php if(isset($keyword['phone']))echo $keyword['phone']?>">
                                            </div>
                                        </div>
                                        <div class="layui-inline">
                                            <label class="layui-form-label">购房人</label>
                                            <div class="layui-input-inline">
                                                <input type="text" name="name" autocomplete="off" class="layui-input">
                                            </div>
                                        </div>
                                        <input type="hidden" name="status" value="6">
                                        <button class="layui-btn index-button" lay-submit="" lay-filter="demo1">搜索</button>
                                    </div>
                                    {{--<div class="layui-form-item">--}}
                                        {{--<div class="layui-input-block">--}}
                                          {{----}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                </form>
                            </div>
                            <?php
                            $admin = \App\Model\Admin::where('id',session('admin'))->value('user');
                            $adminName = \App\Model\Admin::where('id',session('admin'))->value('account');
                            $type = \App\Model\Admin::where('id',session('admin'))->first();
                            ?>
                            <div class="" style="margin-top: 2%" >
                                @if(in_array($admin,["admin"]))
                                <div  class="layui-nav-button">

                                    <a class="layui-btn layui-btn-lg layui-btn-normal" href="/admin/buy/excel/2">导出公司用表</a>
                                    <button type="button" class="layui-btn layui-btn-lg layui-btn-normal" id="test3"><i class="layui-icon"></i>导入中签结果</button>

                                </div>
                                @endif
                                <ul class="layui-nav ul-border" style="background-color: white">
                                    <li class="layui-nav-item <?php if($keyword['status'] == 0)echo 'layui-this'?>"><a href="/admin/index?status=0" class="index-font-weight <?php if($keyword['status'] == 0){echo 'index-active';}else{echo 'index-font-color';}?>">待初审(<?php echo \App\Model\Buy::where('status',0)->count();?> 人)</a></li>
                                    <li class="layui-nav-item <?php if($keyword['status'] == 1)echo 'layui-this'?>"><a href="/admin/index?status=1" class="index-font-weight <?php if($keyword['status'] == 1){echo 'index-active';}else{echo 'index-font-color';}?>">初审中 (<?php echo \App\Model\Buy::where('status',1)->count();?> 人)</a></li>
                                    <li class="layui-nav-item <?php if($keyword['status'] == 2)echo 'layui-this'?>"><a href="/admin/index?status=2" class="index-font-weight <?php if($keyword['status'] == 2){echo 'index-active';}else{echo 'index-font-color';}?>">初审通过(<?php echo \App\Model\Buy::where('status',2)->count();?> 人)</a></li>
                                    <li class="layui-nav-item <?php if($keyword['status'] == 4)echo 'layui-this'?>"><a href="/admin/index?status=4" class="index-font-weight <?php if($keyword['status'] == 4){echo 'index-active';}else{echo 'index-font-color';}?>">初审不通过 (<?php echo \App\Model\Buy::where('status',4)->count();?> 人)</a></li>
                                    <li class="layui-nav-item <?php if($keyword['status'] == 3)echo 'layui-this'?>"><a href="/admin/index?status=3" class="index-font-weight <?php if($keyword['status'] == 3){echo 'index-active';}else{echo 'index-font-color';}?>">复审中 (<?php echo \App\Model\Buy::where('status',3)->count();?> 人)</a></li>
                                    <li class="layui-nav-item <?php if($keyword['status'] == 7)echo 'layui-this'?>"><a href="/admin/index?status=7" class="index-font-weight <?php if($keyword['status'] == 7){echo 'index-active';}else{echo 'index-font-color';}?>">复审不通过(<?php echo \App\Model\Buy::where('status',7)->count();?> 人)</a></li>
                                    <li class="layui-nav-item <?php if($keyword['status'] == 5)echo 'layui-this'?>"><a href="/admin/index?status=5" class="index-font-weight <?php if($keyword['status'] == 5){echo 'index-active';}else{echo 'index-font-color';}?>">复审通过 &nbsp(<?php
                                            echo \App\Model\Buy::where('status',5)->count();
                                            ?> 人)</a></li>
                                </ul>
                                <div  class="layui-nav-button">
                                    @if(in_array($keyword['status'],[0,1,2,3]))
                                        {{--审核通过显示【导出房管局用表】--}}
                                        @if(($keyword['status'] == 0 || $keyword['status'] == 1) && $type->type== 1)
                                            <button class="layui-btn layui-btn-green layui-btn-lg" onclick="showMoreRandom({{ $keyword['status'] }})">开始审核</button>
                                        @elseif(($keyword['status'] == 2 || $keyword['status'] == 3) && $type->type==0)
                                            <button class="layui-btn layui-btn-green layui-btn-lg" onclick="showMoreRandom({{ $keyword['status'] }})">开始审核</button>
                                        @endif
                                    @endif
                                @if(in_array($admin,["admin"]))

                                    @if($keyword['status'] == 5 || $keyword['status'] == 6)
                                        {{--审核通过显示【导出房管局用表】--}}
                                        <a class="layui-btn layui-btn-lg layui-btn-normal" href="/admin/buy/excel/1">导出房管局用表</a>
                                    @endif



                                        @if($keyword['status']== 5)
                                            <a class="layui-btn layui-btn-lg layui-btn-normal" href="/admin/buy/excel/3">导出公示表</a>
                                        @endif
                                @endif
                                    @if(in_array($keyword['status'],[4,7,5]))
                                        @if($type->type == 0)
                                            <button class="layui-btn layui-btn-lg layui-btn-normal" onclick="sendMessage()">发送通知/回执单</button>
                                        @endif
                                    @endif
                                </div>

                                <div class="layui-form">
                                    @if(isset($filable))
                                        {{ $data->appends(["phone"=>$phone,'name'=>$name,'status'=>6])->links() }}
                                    @else
                                        {{ $data->appends(['status'=>$keyword['status']])->links() }}
                                    @endif
                                    <table class="layui-table index-table">
                                        <colgroup>
                                            <col width="50">
                                            <col width="110">
                                            <col width="110">
                                            <col width="100">
                                            <col width="100">
                                            <col width="110">
                                            <col width="110">
                                            <col>
                                        </colgroup>
                                        <thead>
                                        <tr>
                                            <th><input type="checkbox" name="" lay-skin="primary" lay-filter="allChoose"></th>

                                            <th>购房登记号</th>
                                            <th>购房者姓名</th>
                                            @if($admin == 'admin')
                                                <th>手机号</th>
                                            @endif
                                            <th>无房家庭</th>
                                            <th>杭州户口</th>
                                            <th>婚姻状况</th>
                                            <th>首付比例</th>
                                            <th>付款方式</th>
                                            <th>最新提交时间</th>
                                            <th>审核状态</th>
                                            <th>通知状态</th>
                                            <th>销售顾问</th>
                                            <th>初审核人</th>
                                            <th>复审核人</th>
                                            <th>操作</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                            @foreach($data as $k=>$v)

                                                <tr>
                                                    <td><input type="checkbox" name="send" lay-skin="primary" value="{{ $v->phone }}" data-send="{{ $v->is_send }}" lay-filter="oneChoose"></td>

                                                    <td>{{ $v->registration }}</td>
                                                    <td>{{ $v->name }}</td>
                                                    @if($admin == 'admin')
                                                    <td width="50px">{{ $v->phone }}</td>
                                                    @endif
                                                    <td>{{ $v->haveHouse }}</td>
                                                    <td>{{ $v->household }}</td>
                                                    <td>{{ $v->marriage }}</td>
                                                    <td>{{ $v->down }}</td>
                                                    <td>{{ $v->pay }}</td>
                                                    <td>{{ $v->updated_at }}</td>
                                                    <td>
                                                        @if($v->status == 0)
                                                            <span class="label label-default">待初审
                                                        @elseif($v->status == 1)
                                                           <span class="label label-default">初审中
                                                        @elseif($v->status == 2)
                                                           <span class="label label-default">初审通过
                                                        @elseif($v->status == 3)
                                                           <span class="label label-default">复审中
                                                        @elseif($v->status == 4)
                                                            <span class="label label-danger">初审不通过
                                                        @elseif($v->status == 5)
                                                            <span class="label label-primary layui-btn-green">复审通过
                                                        @elseif($v->status == 7)
                                                             <span class="label label-danger">复审不通过
                                                        @endif
                                                    </td>
                                                    <td data-send="{{ $v->is_send }}">
                                                        @if($v->is_send == 0)
                                                            <span class="label label-default">未通知
                                                            @else
                                                            <span class="label label-primary layui-btn-green">已通知
                                                        @endif
                                                    </td>
                                                    <td>{{ $v->sale }}</td>
                                                    <td>
                                                        @if(isset($v->adminFirst->account))
                                                            {{ $v->adminFirst->user }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if(isset($v->adminFinal->account))
                                                            {{ $v->adminFinal->user }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($v->firstTrial == session('admin') || $v->finalTrial == session('admin'))
                                                            @if(in_array($v->status,[1,2,3]))
                                                                @if($v->status == 2)
                                                                    {{--初审通过--}}
                                                                    @if($v->firstTrial != session('admin'))
                                                                        <a href="/admin/buy/read/{{ $v->id }}/1/{{ $v->status }}" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> 审核 </a>
                                                                        @endif
                                                                    @endif
                                                            {{--<button onclick="showMore({{ $v->id }},'{{ $v->name }}',1,{{ $v->status }})" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> 审核 </button>--}}

                                                            @endif
                                                        @endif
                                                            {{--<button onclick="showMore({{ $v->id }},'{{ $v->name }}',2,{{ $v->status }})" class="btn btn-white btn-sm"><i class="fa fa-folder"></i> 查看 </button>--}}
                                                            <a href="/admin/buy/read/{{ $v->id }}/2/{{ $v->status }}" class="btn btn-white btn-sm"><i class="fa fa-folder"></i> 查看 </a>
                                                            <button class="btn btn-white btn-sm" onclick="Userlist({{ $v->id }})"><i class="fa fa-tag"></i> 操作记录</button>
                                                        @if(in_array($v->status,[4,7]))
                                                                <button class="btn btn-white btn-sm" onclick="disagreementList({{ $v->id }})"><i class="fa fa-tag"></i> 查看未通过原因</button>
                                                            @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>

                                    </table>
                                    @if(isset($filable))
                                        {{ $data->appends(["phone"=>$phone,'name'=>$name,'status'=>6])->links() }}
                                    @else
                                        {{ $data->appends(['status'=>$keyword['status']])->links() }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
            </div>

        </div>

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
<script src="/layui/layui.js"></script>
<script src="/js/admin.js"></script>
    <script>
        @if ($errors->any())
        @foreach ($errors->all() as $error)
        layer.msg("{{ $error }}");
        @break
        @endforeach
        @endif
        layui.use('table', function(){
            var table = layui.table
                ,form = layui.form;

            //监听锁定操作
            form.on('checkbox(allChoose)', function(data){
                var child = $(data.elem).parents('table').find('tbody input[type="checkbox"]');
                child.each(function(index, item){
                    /*如果已经发送过通知的话全选的时候就不要选上了*/
                    if($(this).attr('data-send') == 0){
                        item.checked = data.elem.checked;
                    }
                });

                form.render('checkbox');
            });


        });

        $(function(){
            layui.use('layer', function(){
                var layer = layui.layer
                    ,$ = layui.jquery;
                @if(session('noUser'))
                layer.msg("{{session('noUser')}}");
                @endif
            });

        });

        layui.use('upload', function(){
            var $ = layui.jquery
                ,upload = layui.upload;
            upload.render({ //允许上传的文件后缀
                elem: '#test3'
                ,url: '/admin/result/excel'
                ,accept: 'file' //普通文件
                ,exts: 'xls|xlsx|csv' //只允许上传压缩文件
                ,done: function(res){
                    if(res == 200){
                        layer.msg("导入结果成功")
                    }
                }
            });

        });

    </script>
</div>
</body>


<!-- Mirrored from www.zi-han.net/theme/hplus/index_v5.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 20 Jan 2016 14:18:52 GMT -->
</html>
@endsection