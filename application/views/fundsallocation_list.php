<div class="page ">

    <div class="page-header page-header-bordered">

        <h1 class="page-title">Funds Allocation to Regions</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboardc/dashboard') ?>">Dashboard</a></li>
            <li class="active">Funds Allocation</li>
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
                        <th>Fund Source</th>
                        <th>Region</th>
                        <th>Funds Allocated</th>
                        <th>Funds Obligated</th>
                        <th>Funds Utilized</th>
                        <th>Other Funds</th>
                        <th>Remaining Budget</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Fund Source</th>
                        <th>Region</th>
                        <th>Funds Allocated</th>
                        <th>Funds Obligated</th>
                        <th>Funds Utilized</th>
                        <th>Other Funds</th>
                        <th>Remaining Budget</th>
                        <th>Action</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php foreach($fundsdetails as $fundsData):
                       $fundsallocate = $fundsData->funds_allocated;
                       $fundsobligated = $fundsData->funds_obligated;
                       $fundsutilize = $fundsData->funds_utilized;
                       $otherfunds = $fundsData->other_funds;
                       $fundsbudget = $fundsData->remaining_budget;


                        ?>  <!--pagination buttons -->
                        <?php if($fundsbudget == '0' && $fundsobligated != '0'){
                        $td = '<td class="success">'; } else {
                        $td = '<td>'; } ?>
                         <tr>
                            <?php echo $td.$fundsData->funds_id ?></td>
                            <?php echo $td.$fundsData->fund_source; ?></td>
                            <?php echo $td.$fundsData->region_name; ?></td>
                            <?php echo $td."₱ ". number_format($fundsallocate,2); ?></td>
                            <?php echo $td."₱ ". number_format($fundsobligated,2); ?></td>
                            <?php echo $td."₱ ". number_format($fundsutilize,2); ?></td>
                            <?php echo $td."₱ ". number_format($otherfunds,2); ?></td>
                            <?php echo $td."₱ ". number_format($fundsData->remaining_budget,2); ?></td>
                            <td>
                                <div class="btn-group">
                                    <?php if($fundsbudget == '0'){?>
                                        <a class="btn btn-dark btn-outline"  href="<?php echo base_url('saro/index/'.$fundsData->region_code.'') ?>" data-toggle="tooltip"
                                           data-placement="top" data-original-title="View SARO"><i class="icon wb-search" aria-hidden="true" ></i> </a>
                                    <?php }else { ?>
                                        <a class="btn btn-dark btn-outline"  href="<?php echo base_url('saro/index/'.$fundsData->region_code.'') ?>" data-toggle="tooltip"
                                           data-placement="top" data-original-title="View SARO"><i class="icon wb-search" aria-hidden="true" ></i> </a>
                                        <a class="btn btn-primary btn-outline"  href="<?php echo base_url('withdraw/index/'.$fundsData->region_code.'') ?>" data-toggle="tooltip"
                                           data-placement="top" data-original-title="Withdraw/Transfer Funds"><i class="icon fa-exchange" aria-hidden="true" ></i> </a>

                                    <?php } ?>

                                    <!--  <a class="btn btn-primary btn-outline"  href="<?php// echo base_url('fundsallocation/edit/') ?>" data-toggle="tooltip"
                                       data-placement="top" data-original-title="Edit"><i class="icon wb-edit" aria-hidden="true" ></i> </a>
                                  <a class="confirmation btn btn-danger btn-outline" id="confirm"
                                       href="<?php // echo base_url('fundsallocation/delete/') ?>" data-toggle="tooltip"
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