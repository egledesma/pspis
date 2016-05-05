<div class="page ">

    <div class="page-header page-header-bordered">

        <h1 class="page-title">Central Office Funds</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboardc/dashboard') ?>">Dashboard</a></li>
            <li class="active">Central Office Funds</li>
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
                    <a class= "btn btn-outline btn-primary"   href="<?php echo base_url('cofunds/add') ?>"><i class="icon wb-plus" aria-hidden="true"></i> Add Record</a>
                </div><br>
                <table class="table table-hover table-bordered dataTable table-striped width-full" id="exampleTableSearch">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Year</th>
                        <th>Funds</th>
                        <th>Funds Downloaded</th>
                        <th>Funds Utilized</th>
                        <th>Remaining Budget</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Year</th>
                        <th>Funds</th>
                        <th>Funds Downloaded</th>
                        <th>Funds Utilized</th>
                        <th>Remaining Budget</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php foreach($cofundsdetails as $cofundsData):
                       $fundsallocate = $cofundsData->co_funds;
                       $fundsdownload = $cofundsData->co_funds_downloaded;
                       $fundsutilize = $cofundsData->co_funds_utilized;
                       $budget =($fundsallocate - $fundsdownload);
                        if ($fundsdownload != 0){$percent = ($fundsutilize / $fundsdownload);

                            $status = number_format( $percent * 100, 2 ) . '%';
                        } else {
                            $status = "0.00%";
                        }


                        ?>  <!--pagination buttons -->

                        <tr>
                            <td><?php echo $cofundsData->funds_id ?></td>
                            <td><?php echo $cofundsData->for_year; ?></td>
                            <td><?php echo '₱ '. number_format($fundsallocate,2); ?></td>
                            <td><?php echo '₱ '. number_format($fundsdownload,2); ?></td>
                            <td><?php echo '₱ '. number_format($fundsutilize,2); ?></td>
                            <td><?php echo '₱ '. number_format($budget,2); ?></td>
                            <td><?php echo $status; ?></td>
                            <td>
                                <div class="btn-group">
                                    <a class="btn btn-info btn-outline"  href="<?php echo base_url('cofunds/edit/') ?>" data-toggle="tooltip"
                                       data-placement="top" data-original-title="Edit"><i class="icon wb-edit" aria-hidden="true" ></i> </a>
                                    <a class="confirmation btn btn-danger btn-outline" id="confirm"
                                       href="<?php echo base_url('cofunds/delete/') ?>" data-toggle="tooltip"
                                       data-placement="top" data-original-title="Delete"><i class="icon wb-close" aria-hidden="true"></i> </a>
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