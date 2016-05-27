
<?php
$alloc = '';
$util = '';
$remaining = '';
$region = '';
$status = '';
?>
<!--<pre>-->
<!--    --><?php
//    print_r($getAllocUtil);
//?>
<!--    </pre>-->
<?php

foreach($getAllocUtil as $key=>$value){
    $alloc .= "".$value['funds_allocated'].",";
    $remaining .= "".$value['RemainingBudget'].",";
    $util .= "".$value['funds_utilized'].",";
    $region .= "'".$value['region_name']."',";
    $status .= "".$value['Status'].",";
}


$region_format =  substr($region,0,-1);
$status_format =  substr($status,0,-1);
$alloc_format =  substr($alloc,0,-1);
$util_format =  substr($util,0,-1);
$remaining_format =  substr($remaining,0,-1);


?>
<?php
$grandUtil = '';
$grandBalance = '';
$grandSARO = '';
foreach($getGrand as $key=>$value){
    $grandBalance .= "".$value['balance']."";
    $grandSARO .= "".$value['saro']."";
    $grandUtil .= "".$value['utilized']."";

}

?>

<!--<pre>-->
<!--        --><?php //echo $grandSaro?><!--<br>-->
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

    <script type="text/javascript">
        $(function () {
            $('#container2').highcharts({
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: 'Nationwide'
                },
                subtitle: {
                    text: 'Utilization of SARO  ₱ <?php echo $grandSARO; ?>'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: ₱ {point.y:,.2f} ({point.percentage:.1f} %)',
                            style: {
                                color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                            }
                        }
                    }
                },
                series: [{
                    name: 'Brands',
                    colorByPoint: true,
                    data: [{
                        name: 'Remaining Funds',
                        y: <?php echo $grandBalance;?>
                    }, {
                        name: 'Utilized',
                        y:  <?php echo $grandUtil;?>,
                        sliced: true,
                        selected: true
                    }]
                }]
            });
        });
    </script>



    <div id="container1" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
    <hr />
    <div id="container2" style="min-width: 310px; height: 400px; margin: 0 auto"></div>



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
                    text: 'Sub-Allotment Release Order (SARO) , Downloaded, Utilized and Remaining Balance'
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
                    name: 'Remaining Balance',
                    data: [<?php echo $remaining_format;?>]

                }, {
                    name: 'Utilized',
                    data: [<?php echo $util_format;?>]

                }]
            });
        });
</script>
</div>