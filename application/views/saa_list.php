<div class="page ">

    <div class="page-header page-header-bordered">

        <h1 class="page-title">SAA List</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboardc/dashboard') ?>">Dashboard</a></li>
            <li><a href="<?php echo base_url('fundsallocation/index/0') ?>">Funds Allocation</a></li>
            <li class="active">SAA List</li>
        </ol>
    </div>

    <div class="page-content">
    <div class="panel">
        <div class="panel">
            <header class="panel-heading">
                &nbsp;<?php //echo $form_message; ?>
            </header>
            <div class="panel-body">
                <div id="exampleTableAddToolbar">
                    <a class= "btn btn-outline btn-primary"   href="<?php echo base_url('fundsallocation/add') ?>"><i class="icon wb-plus" aria-hidden="true"></i> Add Record</a>
                </div><br>
                <table class="table table-hover table-bordered dataTable table-striped width-full" id="exampleTableSearch">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>SAA Number</th>
                        <th>Funds Amount</th>
                        <th>Funds Downloaded</th>
                        <th>Funds Utilized</th>
                        <th>Remaining Balance</th>

                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>SAA Number</th>
                        <th>Funds Amount</th>
                        <th>Funds Downloaded</th>
                        <th>Funds Utilized</th>
                        <th>Remaining Balance</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php foreach($saadetails as $saaData):

                        ?>  <!--pagination buttons -->
                        <tr>
                            <td><?php echo $saaData->saa_id ?></td>
                            <td><?php echo $saaData->saa_number; ?></td>
                            <td><a data-toggle="tooltip" data-placement="top" data-original-title="View Funds History" href="<?php echo base_url('saa/allocationhistory/' . $saaData->saa_id . '/' . $saaData->region_code . '') ?>"><?php echo '₱ '. number_format($saaData->saa_funds,2); ?></a></td>
                            <td><a data-toggle="tooltip" data-placement="top" data-original-title="View Funds History" href="<?php echo base_url('saa/downloadedhistory/' . $saaData->saa_id . '/' . $saaData->region_code . '') ?>"><?php echo '₱ '. number_format($saaData->saa_funds_downloaded,2); ?></a></td>
                            <td><a data-toggle="tooltip" data-placement="top" data-original-title="View Funds History" href="<?php echo base_url('saa/utilizedhistory/' . $saaData->saa_id . '/' . $saaData->region_code . '') ?>"><?php echo '₱ '. number_format($saaData->saa_funds_utilized,2); ?></a></td>
                            <td><?php echo '₱ '. number_format($saaData->saa_balance,2); ?></td>
                        </tr>
                    <?php endforeach ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
    </div>

</div>