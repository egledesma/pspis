<?php
$user_region = $this->session->userdata('uregion');
$user_access = $this->session->userdata('access');
if ($user_region != "190000000"){
    if ($user_access != "-1") {
    redirect('/dashboardc/dashboard', 'location');
    }
    redirect('/dashboardc/dashboard', 'location');
}

?><div class="page ">

    <div class="page-header page-header-bordered">

        <h1 class="page-title">Consolidated Funds</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboardc/dashboard') ?>">Dashboard</a></li>
            <li class="active">Consolidated Funds</li>
        </ol>
    </div>

    <div class="page-content">
    <div class="panel">
        <div class="panel">
            <div class="panel-body">
                &nbsp;<?php echo $form_message; ?>
                <div id="exampleTableAddToolbar">
                    <a class= "btn btn-outline btn-primary"   href="<?php echo base_url('cofunds/add') ?>"><i class="icon wb-plus" aria-hidden="true"></i> Add Record</a>
                </div><br>
                <table class="table table-hover table-bordered dataTable table-striped width-full" id="exampleTableSearch">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Funds Source</th>
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
                        <th>Funds Source</th>
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
                        if ($fundsdownload != 0) {
                            $percent = ($fundsutilize / $fundsallocate);
                            $status = number_format( $percent * 100, 2 ) . '%';
                        } else {
                            $status = "0.00%";
                        }


                        ?>  <!--pagination buttons -->

                        <tr>
                            <td><?php echo $cofundsData->co_funds_id ?></td>
                            <td><?php echo $cofundsData->fund_source ?></td>
                            <td><a data-toggle="tooltip" data-placement="top" data-original-title="View Funds History" href="<?php echo base_url('cofunds/fundshistory/' . $cofundsData->fundsource_id . '') ?>"><?php echo '₱ '. number_format($fundsallocate,2); ?></a></td>
                            <td><a data-toggle="tooltip" data-placement="top" data-original-title="View Funds Downloaded History"href="<?php echo base_url('cofunds/downloadedhistory/' . $cofundsData->fundsource_id . '') ?>"><?php echo '₱ '. number_format($fundsdownload,2); ?></a></td>
                            <td><a data-toggle="tooltip" data-placement="top" data-original-title="View Funds Utilized History"href="<?php echo base_url('cofunds/utilizedhistory/' . $cofundsData->fundsource_id . '') ?>"><?php echo '₱ '. number_format($fundsutilize,2); ?></a></td>
                            <td><?php echo '₱ '. number_format($budget,2); ?></td>
                            <td><?php echo $status; ?></td>
                            <td>
                                <div class="btn-group">
                                    <a class="btn btn-danger btn-outline"  href="<?php echo base_url('fundsallocation/download/' . $cofundsData->fundsource_id . '') ?>" data-toggle="tooltip"
                                       data-placement="top" data-original-title="Download funds to FO"><i class="icon wb-download" aria-hidden="true" ></i> </a>
<!--                                    <a class="btn btn-dark btn-outline"  href="--><?php //echo base_url('cofunds/history/' . $cofundsData->fundsource_id . '') ?><!--" data-toggle="tooltip"-->
<!--                                       data-placement="top" data-toggle="tooltip" data-original-title="View History"><i class="icon wb-search" aria-hidden="true" ></i> </a>-->
<!--                                    <a class="confirmation btn btn-danger btn-outline" id="confirm"-->
<!--                                       href="--><?php //echo base_url('cofunds/delete/') ?><!--" data-toggle="tooltip"-->
<!--                                       data-placement="top" data-original-title="Delete"><i class="icon wb-close" aria-hidden="true"></i> </a>-->
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