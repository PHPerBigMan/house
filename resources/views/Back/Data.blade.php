<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8"><link rel="icon" href="https://static.jianshukeji.com/highcharts/images/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        /* css 代码  */
    </style>

    <script src="https://img.hcharts.cn/highcharts/highcharts.js"></script>
    <script src="https://img.hcharts.cn/highcharts/modules/exporting.js"></script>
    <script src="https://img.hcharts.cn/highcharts-plugins/highcharts-zh_CN.js"></script>


</head>
<body>
<div id="container" style="min-width:400px;height:400px"></div>
<script>
    var chart = Highcharts.chart('container',{
        chart: {
            type: 'column'
        },
        title: {
            text: "天阳蔚蓝数据统计"
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            categories: [
                '全部总量','第三步未保存','第二步未保存','通过审核'
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: '数据统计'
            }
        },
        tooltip: {
            // head + 每个 point + footer 拼接成完整的 table
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f} 人数</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                borderWidth: 0
            }
        },
        series: [{
            name: '数据统计',
            data:  {{ $data }}
        }]
    });
</script>
</body>
</html>