<div class="page ">

    <div class="page-header page-header-bordered">

        <h1 class="page-title">SAA List</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboardc/dashboard') ?>">Dashboard</a></li>
            <li><a href="<?php echo base_url('fundsallocation/index') ?>">Funds Allocation</a></li>
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

                        <th>Action</th>
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
                        <th>Action</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php foreach($saadetails as $saaData):

                        ?>  <!--pagination buttons -->
                        <tr>
                            <td><?php echo $saaData->saa_id ?></td>
                            <td><?php echo $saaData->saa_number; ?></td>
                            <td><?php echo '₱ '. number_format($saaData->saa_funds,2); ?></td>
                            <td><?php echo '₱ '. number_format($saaData->saa_funds_downloaded,2); ?></td>
                            <td><?php echo '₱ '. number_format($saaData->saa_funds_utilized,2); ?></td>
                            <td><?php echo '₱ '. number_format($saaData->saa_balance,2); ?></td>
                            <td>
                                <div class="btn-group">
                                    <a class="btn btn-dark btn-outline"  href="<?php echo base_url('saa/history/'.$saaData->saa_id.'') ?>" data-toggle="tooltip"
                                       data-placement="top" data-original-title="View History"><i class="icon wb-search" aria-hidden="true" ></i> </a>
                                    <a class="btn btn-info btn-outline"  href="<?php echo base_url('fundsallocation/edit/') ?>" data-toggle="tooltip"
                                       data-placement="top" data-original-title="Edit"><i class="icon wb-edit" aria-hidden="true" ></i> </a>
                                 <!--   <a class="confirmation btn btn-danger btn-outline" id="confirm"
                                       href="<?php //echo base_url('fundsallocation/delete/') ?>" data-toggle="tooltip"
                                       data-placement="top" data-original-title="Delete"><i class="icon wb-close" aria-hidden="true"></i> </a> -->
                                </div>
                            </td>
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