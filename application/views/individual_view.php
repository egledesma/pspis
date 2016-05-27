<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!$this->session->userdata('user_data')){
    redirect('/users/login','location');

}
$user_region = $this->session->userdata('uregion');
error_reporting(0);
?>
<div class="page ">

    <div class="page-header page-header-bordered">

        <h1 class="page-title">Utilization History AICS</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboardc/dashboard') ?>">Dashboard</a></li>
            <li class="active">Aics</li>
        </ol>
    </div>

    <div class="page-content">
        <div class="panel">
            <div class="panel">
                <header class="panel-heading">
                    &nbsp;
                    <div class = "panel-body">
                    <table class="table table-hover table-bordered dataTable table-striped width-full" id="exampleTableSearch">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Saro Number</th>
                            <th>Amount</th>
                            <th>Amount added</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Saro Number</th>
                            <th>Amount</th>
                            <th>Amount added</th>
                            <th>Date</th>
                        </tr>
                        </tfoot>
                        <tbody  data-plugin="scrollable" data-direction="horizontal">

                        <?php foreach($crims as $crimsData): ?>
                        <tr>

                            <td><?php echo $crimsData->aics_id; ?></td>
                            <td><?php echo $crimsData->saro_number; ?></td>
                            <td><?php echo '₱ '. number_format($crimsData->amount,2); ?></td>
                            <?php $tempData1 = $crimsData->amount - $tempData;?>
                            <td><?php echo '₱ '. number_format($tempData1,2); ?></td>
                            <?php $tempData = $crimsData->amount?>
                            <td><?php echo $crimsData->date_utilized; ?></td>

                        </tr>
                        <?php endforeach ?>
                        </tbody>
                    </table>
                    </div>
            </div>
        </div>
    </div>

</div>


