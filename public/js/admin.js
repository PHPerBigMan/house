function showMore(id,name,type) {
    layer.open({
        type: 2,
        skin: 'layui-layer-rim', //加上边框
        area: ['90%', '100%'], //宽高
        content: '/admin/buy/read/'+id+'/'+type,
        title: "信息审核",
        cancel:function () {
            location.reload()
        }
    });
}

function showMoreRandom(status) {
    // 根据不同的状态获取数据
    layer.open({
        type: 2,
        skin: 'layui-layer-rim', //加上边框
        area: ['90%', '100%'], //宽高
        content: '/admin/buy/readRandom/'+status,
        title:"信息审核",

    });
}

function imgShow() {
    alert(123213)
}
/*主购房人详细信息*/
$('.img-div-center').click(function () {
    var _this       = $(this);
    var imgTitle    = _this.parent().next().text();
    var id          = $('#data-id').val();
    var src         = _this.attr('src');
    var type        = $('#type').val();
    layer.open({
        type: 2,
        skin: 'layui-layer-rim', //加上边框
        area: ['70%', '100%'], //宽高
        content: '/admin/buy/img/'+id+'/'+type,
        title:"主购房人信息",
        cancel:function () {
            /*先判断一下数据的状态*/
            $.get('/admin/buy/latestStatus',{id:id},function (obj) {
                var status = obj.data;
                // 审核不通过
                location.href = '/admin/buy/read/'+id+'/1'
            })
        }

    });
});
/*审核不通过*/
function disagreement(id) {
    var title = $('#disagreement').attr('title');
    layer.prompt({title: '输入不通过理由', formType: 3}, function(reason, index){
        layer.close(index);
        $.get('/admin/buy/disagreement',{reason:reason,key:title,buyId:id},function (obj) {
            layer.msg("修改成功")
        })
    });
}

function pass(type,id) {
    /*type 1:初审通过 2:复审通过*/
    var msg     = "是否通过初审";
    var status  = 2;
    if(type == 2){
        msg     = "是否通过复审";
        status  = 5;
    }
    layer.confirm(msg, {
        btn: ['确定','取消'] //按钮
    }, function(){
        $.get('/admin/buy/status',{id:id,status:status},function () {
            layer.msg("操作成功")
        })
    });
}

function adminAdd(id) {
    layer.open({
        type: 2,
        skin: 'layui-layer-rim', //加上边框
        area: ['1020px', '220px'], //宽高
        content: '/admin/read/'+id,
        cancel:function () {
            location.reload()
        }
    });
}

function adminSave() {
    $.get('/admin/save',$('#admin-from').serialize(),function () {
        layer.msg('操作成功');
        setTimeout(function () {
            location.reload()
        },1000)
    })
}

function adminDel(id) {
    layer.confirm('确定删除？', {
        btn: ['确定','取消'] //按钮
    }, function(){
        $.get('/admin/del',{id:id},function () {
            layer.msg('操作成功');
            setTimeout(function () {
                location.reload()
            },1000)
        })
    });

}

function configSave() {
    $.get('/admin/config/save',$('#form').serialize(),function () {
        
    })
}

function Userlist(id) {
    layer.open({
        type: 2,
        skin: 'layui-layer-rim', //加上边框
        area: ['1020px', '100%'], //宽高
        content: '/admin/user/list/'+id,
        title:'操作记录'
    });
}

$('.read-user').click(function () {
    var title = $(this).text();
    console.log(title)
    if(title == "编辑"){
        var data = $(this).attr('data-name');
        var id = $(this).attr('data-id');

        var append = '<td> <input type="text" name="name" id="edit-name" class="edit-text" value="'+data+'">&nbsp;<span class="read-user" onclick="editSave('+id+')">保存</span></td>';
        // console.log(append)
        $(this).parent().prev().after(append);
        $(this).parent().remove();

    }
});
/**
 * 修改用户名字
 * @param id
 */

function editSave(id) {
    var newName = $('.edit-text').val();
    $.get('/admin/back/edit',{id:id,name:newName},function () {
        layer.msg("修改成功");
        setTimeout(function () {
            location.reload()
        },500)
    });
}


$('.file-user').click(function () {
    var title = $(this).text();
    console.log(title)
    if(title == "编辑"){
        var data = $(this).attr('data-name');
        var id = $(this).attr('data-id');
        var list = $(this).attr('data-list');

        var append = '<td> <input type="text" name="name" id="file-edit-'+list+'" class="file-edit-text" value="'+data+'">&nbsp;<span class="read-user" onclick="fileSave('+id+','+list+')">保存</span></td>';
        // console.log(append)
        $(this).parent().prev().after(append);
        $(this).parent().remove();

    }
});
/**
 * 修改档案编号
 * @param id
 * @param list
 */
function fileSave(id,list) {
    var newdata = $('#file-edit-'+list).val();
    $.get('/admin/back/file',{id:id,value:newdata,list:list},function () {
        layer.msg("修改成功");
        setTimeout(function () {
            location.reload()
        },500)
    });
}

/*发送短信通知*/
function sendMessage() {
    var arr = new Array();
    var number = '';
    $('input:checkbox[name=send]:checked').each(function(k){
        if(k == 0){
            number = $(this).val();
        }else{
            number += ','+$(this).val();
        }
    });
    if(number){
        layer.confirm('确定给以下手机号发送短信通知？<br>'+number, {
            btn: ['确定','取消'] //按钮
        }, function(){
            $.get('/admin/send',{phone:number},function () {
                
            });
        }, function(){
            layer.msg("取消成功")
        });
    }

}