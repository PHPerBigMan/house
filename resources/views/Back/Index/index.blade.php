@extends('Back.layout.head')
@section('content')
        <div class="wrapper wrapper-content">
            <div class="container" style="width: 100%!important;">
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
                            <div class="" style="margin-top: 5%" >

                                <ul class="layui-nav ul-border" style="background-color: white">
                                    <li class="layui-nav-item <?php if($keyword['status'] == 0)echo 'layui-this'?>"><a href="/admin/index?status=0" class="index-font-weight <?php if($keyword['status'] == 0){echo 'index-active';}else{echo 'index-font-color';}?>">待审核</a></li>
                                    <li class="layui-nav-item <?php if($keyword['status'] == 1)echo 'layui-this'?>"><a href="/admin/index?status=1" class="index-font-weight <?php if($keyword['status'] == 1){echo 'index-active';}else{echo 'index-font-color';}?>">初审中</a></li>
                                    <li class="layui-nav-item <?php if($keyword['status'] == 2)echo 'layui-this'?>"><a href="/admin/index?status=2" class="index-font-weight <?php if($keyword['status'] == 2){echo 'index-active';}else{echo 'index-font-color';}?>">待复审</a></li>
                                    <li class="layui-nav-item <?php if($keyword['status'] == 3)echo 'layui-this'?>"><a href="/admin/index?status=3" class="index-font-weight <?php if($keyword['status'] == 3){echo 'index-active';}else{echo 'index-font-color';}?>">复审中</a></li>
                                    <li class="layui-nav-item <?php if($keyword['status'] == 4)echo 'layui-this'?>"><a href="/admin/index?status=4" class="index-font-weight <?php if($keyword['status'] == 4){echo 'index-active';}else{echo 'index-font-color';}?>">审核不通过</a></li>
                                    <li class="layui-nav-item <?php if($keyword['status'] == 5)echo 'layui-this'?>"><a href="/admin/index?status=5" class="index-font-weight <?php if($keyword['status'] == 5){echo 'index-active';}else{echo 'index-font-color';}?>">审核通过</a></li>
                                </ul>
                                <div  class="layui-nav-button">

                                    @if($keyword['status'] == 5 || $keyword['status'] == 6)
                                        {{--审核通过显示【导出房管局用表】--}}
                                        <a class="layui-btn layui-btn-lg layui-btn-normal" href="/admin/buy/excel/1">导出房管局用表</a>
                                    @endif

                                        @if(in_array($keyword['status'],[0,1,2,3]))
                                            {{--审核通过显示【导出房管局用表】--}}
                                            <button class="layui-btn layui-btn-green layui-btn-lg" onclick="showMoreRandom({{ $keyword['status'] }})">开始审核</button>
                                        @endif
                                        <a class="layui-btn layui-btn-lg layui-btn-normal" href="/admin/buy/excel/2">导出公司用表</a>
                                    @if($keyword['status'] != 4)
                                            <a class="layui-btn layui-btn-lg layui-btn-normal" href="/admin/buy/excel/3">导出公示表</a>
                                            <button class="layui-btn layui-btn-lg layui-btn-normal" onclick="sendMessage()">发送通知/回执单</button>
                                        @endif
                                </div>
                                <div class="layui-form">
                                    <table class="layui-table index-table">
                                        <colgroup>
                                            <col width="50">
                                            <col width="110">
                                            <col width="50">
                                            <col>
                                        </colgroup>
                                        <thead>
                                        <tr>
                                            <th><input type="checkbox" name="" lay-skin="primary" lay-filter="allChoose"></th>
                                            <th>购房者姓名</th>
                                            <th>手机号</th>
                                            <th>无房家庭</th>
                                            <th>杭州户口</th>
                                            <th>婚姻状况</th>
                                            <th>首付比例</th>
                                            <th>付款方式</th>
                                            <th>最新提交时间</th>
                                            <th>审核状态</th>
                                            <th>通知状态</th>
                                            <th>初审核人</th>
                                            <th>复审核人</th>
                                            <th>操作</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                            @foreach($data as $k=>$v)

                                                <tr>
                                                    <td><input type="checkbox" name="send" lay-skin="primary" value="{{ $v->phone }}" data-send="{{ $v->is_send }}"></td>
                                                    <td>{{ $v->name }}</td>
                                                    <td width="50px">{{ $v->phone }}</td>
                                                    <td>{{ $v->haveHouse }}</td>
                                                    <td>{{ $v->household }}</td>
                                                    <td>{{ $v->marriage }}</td>
                                                    <td>{{ $v->down }}</td>
                                                    <td>{{ $v->pay }}</td>
                                                    <td>{{ $v->updated_at }}</td>
                                                    <td>
                                                        @if($v->status == 0)
                                                            <span class="label label-default">待审核
                                                        @elseif($v->status == 1)
                                                           <span class="label label-default">初审中
                                                        @elseif($v->status == 2)
                                                           <span class="label label-default">待复审
                                                        @elseif($v->status == 3)
                                                           <span class="label label-default">复审中
                                                        @elseif($v->status == 4)
                                                            <span class="label label-danger">审核不通过
                                                        @else
                                                            <span class="label label-primary layui-btn-green">审核通过
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($v->is_send == 0)
                                                            <span class="label label-default">未通知
                                                            @else
                                                            <span class="label label-primary layui-btn-green">已通知
                                                        @endif
                                                    </td>
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
                                                            <button onclick="showMore({{ $v->id }},'{{ $v->name }}',1)" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> 审核 </button>
                                                        @endif
                                                            <button onclick="showMore({{ $v->id }},'{{ $v->name }}',2)" class="btn btn-white btn-sm"><i class="fa fa-folder"></i> 查看 </button>
                                                            <button class="btn btn-white btn-sm" onclick="Userlist({{ $v->id }})"><i class="fa fa-tag"></i> 操作记录</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{ $data->links() }}
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
                    item.checked = data.elem.checked;
                });

                form.render('checkbox');
            });

        });
    </script>
</div>
</body>


<!-- Mirrored from www.zi-han.net/theme/hplus/index_v5.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 20 Jan 2016 14:18:52 GMT -->
</html>
@endsection