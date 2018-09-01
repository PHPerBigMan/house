@extends('Back.layout.head')
@section('content')
    <div class="wrapper wrapper-content">
        <button class="layui-btn layui-btn-normal" onclick="adminAdd(0)"><i class="layui-icon "></i>新建账号</button>
        <table class="layui-table">
            <colgroup>
                <col width="150">
                <col>
                <col width="350">
            </colgroup>
            <thead>
            <tr>
                <th>账号</th>
                <th>使用人</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $v)
                <tr>
                    <td>{{ $v->account }}</td>
                    <td>{{ $v->user }}</td>
                    <td>
                        <button class="layui-btn layui-btn-normal layui-btn-sm" onclick="adminAdd({{ $v->id }})"><i class="layui-icon"></i></button>
                        <button class="layui-btn layui-btn-normal layui-btn-sm" onclick="adminDel({{ $v->id }})"><i class="layui-icon"></i></button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $data->links() }}
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
    </div>
    </body>


    <!-- Mirrored from www.zi-han.net/theme/hplus/index_v5.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 20 Jan 2016 14:18:52 GMT -->
    </html>
@endsection