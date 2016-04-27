
<?php
$alloc = '';
$util = '';
$remaining = '';
$region = '';
$status = '';
foreach($getAllocUtil as $key=>$value){
    $alloc .= "".$value['funds_allocated'].",";
    $util .= "".$value['funds_utilized'].",";
    $remaining .= "".$value['RemainingBudget'].",";
    $region .= "'".$value['region_name']."',";
    $status .= "".$value['Status'].",";
}


$region_format =  substr($region,0,-1);
$status_format =  substr($status,0,-1);
$alloc_format =  substr($alloc,0,-1);
$util_format =  substr($util,0,-1);
$remaining_format =  substr($remaining,0,-1);

?>
?>
<!--<pre>-->
<!--        --><?php //print_r($alloc_format)?><!--<br>-->
<!--        --><?php //print_r($region_format)?><!--<br>-->
<!--        --><?php //print_r($util_format)?><!--<br>-->
<!--        --><?php //print_r($remaining_format)?><!--<br>-->
<!--</pre>-->

<div class="page">

    <div class="page-header page-header-bordered">

        <h1 class="page-title">Dashboard</h1>
        <ol class="breadcrumb">
            <li><a href="../index.html">Dashboard</a></li>
           <!-- <li><a href="javascript:void(0)">Layouts</a></li> -->
        </ol>
    </div>

    <style type="text/css">
        ${demo.css}
    </style>
    <script type="text/javascript">

        $(function () {
            Highcharts.setOptions({
                global: {
                    useUTC: false,

                },
                lang: {
                    decimalPoint: '.',
                    thousandsSep: ','
                }
            });
            $('#container').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'FUND MONITORING'
                },
                subtitle: {
                    text: 'Allocated , Utilized and Remaining Balance'
                },

                xAxis: {
                    categories: [<?php echo $region_format;?>],
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Funds'
                    }
                },
                tooltip: {

                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>₱ {point.y:,.1f} </b>({point.percentage:.0f}%)</td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true

                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0,

                    }
                },
                series: [{
                    name: 'Allocated',
                    data: [<?php echo $alloc_format;?>]

                }, {
                    name: 'Utilized',
                    data: [<?php echo $util_format;?>]

                }, {
                    name: 'Remaining Balance',
                    data: [<?php echo $remaining_format;?>]

                }]
            });
        });
    </script>
    <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
    <div id="container1" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

    <script type="text/javascript">
        $(function () {
            $('#container1').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'FUND MONITORING'
                },
                subtitle: {
                    text: 'Allocated , Utilized and Remaining Balance'
                },
                xAxis: {
                    categories: [<?php echo $region_format;?>],
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Funds'
                    },
                    stackLabels: {
                        enabled: true,
                        style: {
                            fontWeight: 'bold',
                            color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                        }
                    }
                },
                legend: {
                    align: 'right',
                    x: -30,
                    verticalAlign: 'top',
                    y: 25,
                    floating: true,
                    backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
                    borderColor: '#CCC',
                    borderWidth: 1,
                    shadow: false
                },
                tooltip: {
                    headerFormat: '<b>{point.x}</b><br/>',
                    pointFormat: '{series.name}:₱ {point.y:,.1f}({point.percentage:.0f}%)<br/>Total: ₱ {point.stackTotal:,.0f}'
                },
                plotOptions: {
                    column: {
                        stacking: 'normal',
                        dataLabels: {
                            enabled: true,
                            color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
                            style: {
                                textShadow: '0 0 3px black'
                            }
                        }
                    }
                },
                series: [ {
                    name: 'Utilized',
                    data: [<?php echo $util_format;?>]

                }, {
                    name: 'Remaining Balance',
                    data: [<?php echo $remaining_format;?>]

                }]
            });
        });
</script>
</div>