@extends('Back.layout.head')
@section('content')
<body class="gray-bg">
<div class="layui-canvs"></div>
<div class="wrapper-content">
    <div class="col-sm-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>项目信息</h5>
            </div>
            <div class="ibox-content" id="eg">
                <form class="layui-form" method="get" action="/admin/config/save">
                    <div class="layui-form-item">
                        <label class="layui-form-label">项目名称</label>
                        <div class="layui-input-block">
                            <input type="text" name="project_name" autocomplete="off"  class="layui-input" value="{{ $data->project_name }}">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">项目推广名</label>
                        <div class="layui-input-block">
                            <input type="text" name="project_extension" class="layui-input" value="{{ $data->project_extension }}">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">登记时间</label>
                        <div class="layui-input-block">
                            <div class="layui-inline">
                                <div class="layui-input-inline">
                                    <input type="text" class="layui-input" id="test10" placeholder=" ~ " style="width: 160%!important;" name="time" value="{{ $data->time }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">登记修改截止时间</label>
                        <div class="layui-input-block">
                            <div class="layui-inline">
                                <div class="layui-inline">
                                    <div class="layui-input-inline">
                                        <input type="text" class="layui-input" id="test5" placeholder="yyyy-MM-dd HH:mm:ss" name="updated_end" value="{{ $data->updated_end }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">项目图片</label>
                        <div class="layui-input-block">
                            <button type="button" class="layui-btn-green layui-btn" id="test3"><i class="layui-icon"></i>上传文件</button>

                            <div>
                                <img src="{{ $data->img }}" alt="" id="show" style="width: 30%;margin-top: 1%">
                                <input type="hidden" name="img" value="{{ $data->img }}" id="img">
                            </div>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">登记须知</label>
                        <div class="layui-input-block">
                            <textarea id="note" style="display: none;" name="registration_notes">{{ $data->registration_notes }}</textarea>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">资金冻结须知</label>
                        <div class="layui-input-block">
                            <textarea id="frozen" style="display: none;" name="frozen">{{ $data->frozen}}</textarea>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">注意事项</label>
                        <div class="layui-input-block">
                            <textarea id="notice" style="display: none;" name="notice">{{ $data->notice }}</textarea>
                        </div>
                    </div>
                    <input type="submit" class="layui-btn layui-btn-green layui-btn-lg" style="margin-left: 45%;width: 100px!important;" onclick="configSave()">
                </form>
                <div style="width: 100%">
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
<script src="/layui/layui.all.js"></script>
<script src="/js/admin.all.js"></script>

<script>
    layui.use('layer', function(){

        @if(session('success'))
        layer.msg("保存成功");
        @endif
    });

    $(document).ready(function(){$(".i-checks").iCheck({checkboxClass:"icheckbox_square-green",radioClass:"iradio_square-green",})});
    layui.use('layedit', function(){
        var layedit = layui.layedit;

        layedit.build('note',{
            tool: [
                'strong'
                ,'italic'
                ,'underline'
                ,'del'
                ,'|'
                ,'left'
                ,'center'
                ,'right'
                ,'link'
            ]
        }); //建立编辑器
        layedit.build('frozen',{
            tool: [
                'strong'
                ,'italic'
                ,'underline'
                ,'del'
                ,'|'
                ,'left'
                ,'center'
                ,'right'
                ,'link'
            ]
        }); //建立编辑器
        layedit.build('notice',{
            tool: [
                'strong'
                ,'italic'
                ,'underline'
                ,'del'
                ,'|'
                ,'left'
                ,'center'
                ,'right'
                ,'link'
            ]
        }); //建立编辑器

    });
    layui.use('laydate', function(){
        var laydate = layui.laydate;
        //日期时间范围
        laydate.render({
            elem: '#test10'
            ,type: 'datetime'
            ,range: '~'
        });
        //日期时间选择器
        laydate.render({
            elem: '#test5'
            ,type: 'datetime'
        });
    });

    layui.use('upload', function(){
        var $ = layui.jquery
            ,upload = layui.upload;


        // 指定允许上传的文件类型
        upload.render({
            elem: '#test3'
            ,url: '/api/qiniuImg'
            ,accept: 'file' //普通文件
            ,done: function(res){
                layer.load(2, {time: 2*1000});
                $('#img').val(res.data);
                $('#show').attr('src',res.data)
            }
        });

    });


</script>
<script type="text/javascript" src="http://tajs.qq.com/stats?sId=9051096" charset="UTF-8"></script>

</body>
@endsection


<!-- Mirrored from www.zi-han.net/theme/hplus/index_v5.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 20 Jan 2016 14:18:52 GMT -->
</html>
