function del(id,object,url) {
    layer.confirm('确定要删除吗？', {
        btn: ['确定','取消'] //按钮
    }, function(){
        $.post(url,{id:id},function (obj) {
            if(obj.code == 200){
                $('#'+id).remove();
                layer.msg("删除成功")
            }else{
                layer.msg("删除失败")
            }
        })
    });
}

/**
 * @param key   数据库key
 * @param url   修改的地址
 * @param title 标题
 */
function config_m(key,url,title,flag) {
    var value = $('#'+flag).text();
    layer.prompt({title: title, formType: 3,value:value}, function(money, index){
        layer.close(index);
        $.post(url,{key:key,value:money},function (obj) {
            if(obj.code == 200){
                $("#"+flag).text(money);
            }
            layer.msg(obj.msg);
        });
    });
}