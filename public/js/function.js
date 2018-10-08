/*为订单添加机构信息*/
function upperAdd(id) {
    layer.open({
        type: 2,
        area:['500px','200px'],
        content:'/backClient/upperAdd/'+id,
        title:'修改'
    })
}

/*修改机构数据*/
function upperNameEdit(id,name,type) {
    var title = "修改机构简称";

    if(type ==1){
        title = "修改机构名称";
    }
    layer.prompt({title: title, formType: 3,value:name}, function(name, index){
        layer.close(index);
        $.post('/backClient/upperEdit',{type:type,data:name,id:id},function (obj) {
            layer.msg("修改成功");
            if(type == 1){
                $('#'+id).text(name);
            }else{
                $('.'+id).text(name);
            }
        });
    });
}

/*删除机构*/
function  upperDel(id) {
    layer.confirm('确定删除？', {
        btn: ['确定','取消'] //按钮
    }, function(){
        $.get('/backClient/upperDel/'+id,function (obj) {
            layer.msg("删除成功");
            setTimeout(function () {
                location.reload();
            },1000);
        })
    });
}

/*新增机构信息*/
function upperNew() {
    layer.prompt({title: '机构名称', formType: 3}, function(name, index){
        layer.close(index);
        layer.prompt({title: '机构简称', formType: 3}, function(abbreviation, index){
            layer.close(index);
            $.post("/backClient/upperNew",{name:name,abbreviation:abbreviation},function (obj) {
                layer.msg("新增成功");
                setTimeout(function () {
                    location.reload();
                },1000);
            });
        });
    });
}

/*删除角色*/
function role_del(id) {
    layer.confirm('确定删除？', {
        btn: ['确定','取消'] //按钮
    }, function(){

        $.get('/backClient/roleDel/'+id,function (obj) {
            if(obj == 200){
                layer.msg("角色删除成功");
                setTimeout(function () {
                    location.reload()
                },1000);
            }else{
                layer.msg("改角色已被使用不能直接删除",{icon:2})
            }
        })
    });

}

/**
 * 提现
 * @param type
 * @param id
 */
function putForward(type,id) {
    var  msg = "确定修改为提现失败?";
    var  status = '<span class="layui-badge">提现失败</span>';
    if(type == 30){
        msg = "确定修改为提现成功?";
        status = '<span class="layui-badge layui-bg-green">提现成功</span>';
    }
    layer.confirm(msg, {
        btn: ['确定','取消'] //按钮
    }, function(){
        $.get('/backClient/putForward/edit/'+id+'/'+type,function (obj) {
            if(obj.code == 200){
                layer.msg("修改成功");
                $('#'+id+'-status').html(status);
                return false;
            }else if(obj.code == 404){
                layer.msg("已充值无法修改状态");
                return false;
            }
            layer.msg("修改失败")
        })
    });
}

/**
 * 充值
 * @param type
 * @param id
 * @constructor
 */
function Transaction(type,id,amountGet) {
    var  amountAdd;
    // var amountGet = $('#amount').text();

    var  msg = "确定修改为充值失败?";
    var  status = '  <span class="layui-badge">充值失败</span>';
    if(type == 30){
        msg = "确定修改为充值成功,确认后用户余额将自动增加?";
        status = ' <span class="layui-badge layui-bg-green">充值成功</span>';
        layer.prompt({title: '输入充值金额，并确认', formType: 3}, function(amount, index){
            if(amountGet - amount != 0){
                layer.msg("输入金额和用户申请金额不一致");
                return false;
            }

            layer.close(index);
            amountAdd = amount;
            makeTransaction(type,id,amountAdd,msg,status);
        });
        return false;
    }
    makeTransaction(type,id,0,msg,status);
}

function makeTransaction(type,id,amountAdd,msg,status) {

    var  url;
    layer.confirm(msg, {
        btn: ['确定','取消'] //按钮
    }, function(){
        if(type == 30){
            url = '/backClient/transaction/edit/'+id+'/'+type+'/'+amountAdd
        }else{
            url = '/backClient/transaction/edit/'+id+'/'+type;
        }
        $.get(url,function (obj) {
            if(obj.code == 200){
                layer.msg("修改成功");
                $('#'+id+'-status').html(status);
                return false;
            }else if(obj.code == 404){
                layer.msg("已充值无法修改状态");
                return false;
            }
            layer.msg("修改失败")
        })
    });
}

layui.use('laydate', function(){
    var laydate = layui.laydate;

    //常规用法
    laydate.render({
        elem: '#time'
    });
    //常规用法
    laydate.render({
        elem: '#time1'
    });
});

/*修改配置信息*/
function config() {
    $.post('/backClient/config/save',$('#config').serialize(),function (obj) {
        layer.msg("修改成功");
    });
}

/*添加后台用户*/
function admin_add() {
    if(!$('#admin_name').val()){
        layer.msg("请填写用户名称");
        return false;
    }

    if(!$('#admin_password').val()){
        layer.msg("请填写用户名称");
        return false;
    }

    if(!$("input[name='group']:checked").val()){
        layer.msg("请选择角色");
        return false;
    }
    $.post('/backClient/adminAddpermission',$('#form').serialize(),function (obj) {
        layer.msg("修改成功,请重新登录");
        setTimeout(function () {
            location.href = '/backClient/index';
        },1000)
    })
}

/*修改邀请码*/
function editExten(object,id,extension_code) {
    layer.prompt({title: '输入邀请码', formType: 3,value:extension_code}, function(newEx, index){
        layer.close(index);
        layer.confirm('确定将邀请码修改为'+newEx+'？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            $.get('/backClient/editExten/'+id+'/'+newEx,function (obj) {
                layer.msg(obj.msg);
                if(obj.code == 200){
                    $(object).text(newEx);
                }

            })
        });
    });
}

function userMore(id) {
    layer.open({
        type: 2,
        title: '用户数据',
        shadeClose: true,
        shade: 0.8,
        area: ['80%', '90%'],
        content: '/backClient/userMore/'+id //iframe的url
    });
}

/*保存资讯数据*/
function articleSave() {
    $.post('/backClient/article/save',$("#articleEdit").serialize(),function (obj) {
        if(obj.code == 200){
            layer.msg("保存成功");
            setTimeout(function () {
                location.href = "/backClient/articleList";
            },1000);
            return false;
        }
        layer.msg("保存异常");
    })
}

/*删除资讯*/
function articleDel(object,id) {
    layer.confirm('确定删除该资讯?', {
        btn: ['确定','取消'] //按钮
    }, function(){
        $.get('/backClient/article/del/'+id,function (obj) {
           layer.msg("删除成功");
           setTimeout(function () {
               location.reload()
           },1000)
        })
    });
}

/**
 *  设置订单是否在首页显示
 * @param object
 * @param id
 * @param show
 */
function show(object,id,show) {
    var _this = object;
    var className = $(_this).attr('class');
    if(className == "layui-btn layui-btn-primary layui-btn-sm"){
        $.post("/backClient/order/show",{id:id,is_show:1},function () {
            $(_this).attr('class','layui-btn layui-btn-warm layui-btn-sm');
            $(_this).css({"color":'black'});
            $(_this).text("首页显示");

        });

    }else{
        $.post("/backClient/order/show",{id:id,is_show:0},function () {
            $(_this).attr('class','layui-btn layui-btn-primary layui-btn-sm');
            $(_this).css({"color":'grey'});
            $(_this).text("首页未显示")
        });

    }
    layer.msg("操作成功");
}

function tell1() {
    var tell = $('#tell').attr('istell');
    if(tell == "0"){
        layer.msg("0代表不强制更新 1:代表强制更新");
        $('#tell').attr('istell',1);
    }
}


function iostell1() {
    var tell = $('#iostell').attr('istell');
    if(tell == "0"){
        layer.msg("0代表不强制更新 1:代表强制更新");
        $('#iostell').attr('istell',1);
    }
}