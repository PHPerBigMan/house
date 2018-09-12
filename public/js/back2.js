
/*查看推广数据*/
function saleData(id) {
    layer.open({
        type: 2,
        skin: 'layui-layer-rim', //加上边框
        area: ['1000px', '640px'], //宽高
        content: '/admin/saleData/'+id,
        title:"推广数据"
    });
}