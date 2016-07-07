<?php
$region_code = $this->session->userdata('uregion');
?>
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
            <div class="panel-body">
                &nbsp;<?php echo $form_message; ?>
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


                        ?>
                        <tr>
                            <td><?php echo $fundsData->funds_id ?></td>
                            <td><?php echo $fundsData->fund_source ?></td>
                        <td><?php echo $fundsData->region_name; ?></td>
                            <td><a data-toggle="tooltip" data-placement="top" data-original-title="View Funds History" href="<?php echo base_url('fundsallocation/fundshistory/' . $fundsData->fundsource_id . '/' . $fundsData->region_code . '') ?>"><?php echo '₱ '. number_format($fundsallocate,2); ?></a></td>
                            <td><a data-toggle="tooltip" data-placement="top" data-original-title="View Funds Obligated History"href="<?php echo base_url('fundsallocation/obligatedhistory/' . $fundsData->fundsource_id .'/' . $fundsData->region_code . '') ?>"><?php echo '₱ '. number_format($fundsobligated,2); ?></a></td>
                            <td><a data-toggle="tooltip" data-placement="top" data-original-title="View Funds Utilized History"href="<?php echo base_url('fundsallocation/utilizedhistory/' . $fundsData->fundsource_id . '') ?>"><?php echo '₱ '. number_format($fundsutilize,2); ?></a></td>
                            <td><a data-toggle="tooltip" data-placement="top" data-original-title="View Other Funds History" href="<?php echo base_url('fundsallocation/otherfundshistory/' . $fundsData->fundsource_id . '/' . $fundsData->region_code . '') ?>"><?php echo '₱ '. number_format($otherfunds,2); ?></a></td>
                            <td><?php echo '₱ '. number_format($fundsbudget,2); ?></td>
                            <td>
                                <div class="btn-group">
                                    <?php if($region_code == "19000000"){ ?>
                                        <a class="btn btn-dark btn-outline"  href="<?php echo base_url('saa/index/'.$fundsData->region_code.'') ?>" data-toggle="tooltip"
                                           data-placement="top" data-original-title="View SAA List"><i class="icon wb-search" aria-hidden="true" ></i> </a>
                                        <a class="btn btn-primary btn-outline"  href="<?php echo base_url('withdraw/index/' . $fundsData->fundsource_id . '/' . $fundsData->region_code . '') ?>" data-toggle="tooltip"
                                           data-placement="top" data-original-title="Withdraw/Transfer Funds"><i class="icon fa-exchange" aria-hidden="true" ></i> </a>
                                    <?php }else { ?>
                                        <a class="btn btn-dark btn-outline"  href="<?php echo base_url('saa/index/'.$fundsData->region_code.'') ?>" data-toggle="tooltip"
                                           data-placement="top" data-original-title="View SAA List"><i class="icon wb-search" aria-hidden="true" ></i> </a>
                                    <?php }?>

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