

function showMore(id,name,type,fromPage) {
    layer.open({
        type: 2,
        skin: 'layui-layer-rim', //加上边框
        area: ['90%', '100%'], //宽高
        content: '/admin/buy/read/'+id+'/'+type+'/'+fromPage,
        title: "信息审核",
        cancel:function () {
            location.reload()
        }
    });
}

function showMoreRandom(status) {
    // 根据不同的状态获取数据
    $.get('/admin/ifhave/'+status,function (obj) {
        if(obj.code==200){
            location.href = '/admin/buy/read/'+obj.data+'/1/'+status;
        }else{
            layer.msg('没有更多可以审核的用户');
            setTimeout(function () {
                location.href = '/admin/index?status='+status;
            },1000);
        }
    })
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
    var fromPage    = $('#fromPage').val();
    var hash        = _this.attr('data-hash');
    layer.open({
        type: 2,
        skin: 'layui-layer-rim', //加上边框
        area: ['70%', '100%'], //宽高
        content: '/admin/buy/img/'+id+'/'+type+"#"+hash,
        title:"主购房人信息",
        cancel:function () {
            /*先判断一下数据的状态*/
            $.get('/admin/buy/latestStatus',{id:id},function (obj) {
                var status = obj.data;
                var type = $('#type').val();

                // 审核不通过
                location.href = '/admin/buy/read/'+id+'/'+type+'/'+fromPage
            })
        }

    });
});

/*其他人图片材料*/
$('.img-div-center-other').click(function () {
    var _this       = $(this);
    var imgTitle    = _this.parent().next().text();
    var id          = $('#data-id').val();
    var src         = _this.attr('src');
    var type        = $('#type').val();
    var fromPage    = $('#fromPage').val();
    var hash        = _this.attr('data-hash');
    layer.open({
        type: 2,
        skin: 'layui-layer-rim', //加上边框
        area: ['70%', '100%'], //宽高
        content: '/admin/buy/imgOther/'+id+'/'+type+'#'+hash,
        title:"关联人信息",
        cancel:function () {
            /*先判断一下数据的状态*/
            $.get('/admin/buy/latestStatus',{id:id},function (obj) {
                var status = obj.data;
                var type = $('#type').val();

                // 审核不通过
                location.href = '/admin/buy/read/'+id+'/'+type+'/'+fromPage
            })
        }

    });
});
/*审核不通过*/
function disagreement(id,type=0) {
    var title = $('#disagreement').attr('title');
    layer.prompt({title: '输入不通过理由', formType: 3}, function(reason, index){
        layer.close(index);
        $.get('/admin/buy/disagreement',{reason:reason,key:title,buyId:id,type:type},function (obj) {
            layer.msg("修改成功")
        })
    });
}

function pass(type,id) {
    /*type 1:初审通过 2:复审通过*/
    var msg     = "是否通过初审";
    var status  = 2;
    var fromPage = $('#fromPage').val();
    if(type == 2){
        msg     = "是否通过复审";
        status  = 5;
    }
    layer.confirm(msg, {
        btn: ['确定','取消'] //按钮
    }, function(){
        $.get('/admin/buy/status',{id:id,status:status},function () {
            layer.confirm("操作成功,是否继续审核",{
                btn: ['继续审核','审核结束']
            },function () {

                showMoreRandom(fromPage)
            },function () {
                location.href = '/admin/index?status='+fromPage;
            });
        });

    });
}


function showMoreRandomV1(status) {
    layer.open({
        type: 2,
        skin: 'layui-layer-rim', //加上边框
        area: ['100%', '100%'], //宽高
        // content: '/admin/buy/readRandom/'+status,
        title:"信息审核",

    });
}

function adminAdd(id) {
    layer.open({
        type: 2,
        skin: 'layui-layer-rim', //加上边框
        area: ['1350px', '270px'], //宽高
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
/*操作记录*/
function Userlist(id) {
    layer.open({
        type: 2,
        skin: 'layui-layer-rim', //加上边框
        area: ['1020px', '100%'], //宽高
        content: '/admin/user/list/'+id,
        title:'操作记录'
    });
}


function disagreementList(id) {
    layer.open({
        type: 2,
        skin: 'layui-layer-rim', //加上边框
        area: ['1020px', '100%'], //宽高
        content: '/admin/buy/disagreement/'+id,
        title:'未通过原因'
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
    var flag = 1;
    $('input:checkbox[name=send]:checked').each(function(k){
        var is_send = $(this).parent().siblings().eq(9).attr('data-send');
        if(is_send == 1){
            layer.msg($(this).val()+"已送达通知,请重新选择",{icon:2});
            flag = 0;
            return false;
        }else{
            flag = 1;
        }
        if(k == 0){
            number = $(this).val();
        }else{
            number += ','+$(this).val();
        }
    });
    if(flag){
        if(number){
            layer.confirm('确定给以下手机号发送短信通知？<br>'+number, {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.get('/admin/send',{phone:number},function () {
                    $('input:checkbox[name=send]:checked').each(function(k){
                        $(this).parent().siblings().eq(9).html('<span class="label label-primary layui-btn-green">已通知')
                    });
                    layer.msg("发送通知成功");
                });
            }, function(){
                layer.msg("取消成功")
            });
        }else{
            layer.msg("请选择要发送的用户数据")
        }
    }
}



function nopass(id) {
    var fromPage = $('#fromPage').val();
    layer.confirm("修改为不通过？", {
        btn: ['确定','取消'] //按钮
    }, function(){
        $.get('/admin/buy/nopass',{id:id},function (obj) {
            layer.confirm("操作成功,是否继续审核",{
                btn: ['继续审核','审核结束']
            },function () {
                showMoreRandom(fromPage)
            },function () {
                location.href = '/admin/index?status='+fromPage;
            });
        })
    });
}


new Swiper('.swiper-container', {
    hashNavigation: true,
    // hashnav:true,
    // width: 800,
    width: '100%',
    //设置宽度为全屏
    width: window.innerWidth,
    // autoHeight:true,
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
    loopedSlides :3,
    on:{
        slideChangeTransitionStart: function(){
            var title        = this.slides.eq(this.activeIndex).find('img').attr('alt');
            var filedTitle   = this.slides.eq(this.activeIndex).find('img').attr('title');
            console.log(title);
            $('#img-title').text(title);
            $('#disagreement').attr('title',filedTitle);
        },
    },
});
