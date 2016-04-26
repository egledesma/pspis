
<?php
$alloc = '';
$util = '';
$remaining = '';
$region = '';
foreach($getAllocUtil as $key=>$value){
    $alloc .= "".$value['funds_allocated'].",";
    $util .= "".$value['funds_utilized'].",";
    $remaining .= "".$value['RemainingBudget'].",";
    $region .= "'".$value['region_name']."',";
}
$region_format =  substr($region,0,-1);
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
                    '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
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


</div>