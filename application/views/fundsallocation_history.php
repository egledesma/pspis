<div class="page ">

    <div class="page-header page-header-bordered">

        <h1 class="page-title">Funds Allocation History</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboardc/dashboard') ?>">Dashboard</a></li>
            <li><a href="<?php echo base_url('fundsallocation/index') ?>">Funds Allocation</a></li>
            <li class="active">History</li>
        </ol>
    </div>

    <div class="page-content">
    <div class="panel">
        <div class="panel">
            <header class="panel-heading">
                <h1 class="panel-title"><mark class="bg-dark">&nbsp;&nbsp;&nbsp; <?php echo $fundsallocation->fund_source ?> - Funds History&nbsp;&nbsp;&nbsp;</mark>&nbsp;&nbsp;&nbsp;<mark class="bg-info">&nbsp;&nbsp;&nbsp; <?php echo $region->region_name ?>&nbsp;&nbsp;&nbsp;</mark></h1>
            </header>
            <div class="panel-body"><br>
                <table class="table table-hover table-bordered dataTable table-striped width-full" id="exampleTableSearch">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Old Value</th>
                        <th>Amount Transfer/Withdraw</th>
                        <th>New Value</th>
                        <th>Description</th>
                        <th>Created By</th>
                        <th>Date Created</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Old Value</th>
                        <th>Amount Transfer/Withdraw</th>
                        <th>New Value</th>
                        <th>Description</th>
                        <th>Created By</th>
                        <th>Date Created</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php foreach($allocationdetails as $fundsData):


                        ?>  <!--pagination buttons -->

                        <tr>
                            <td><?php echo $fundsData->allocation_history_id ?></td>
                            <td><?php echo '₱ '. number_format($fundsData->allocated_old_value,2); ?></td>
                            <td><?php echo '₱ '. number_format($fundsData->allocated_amount,2); ?></td>
                            <td><?php echo '₱ '. number_format($fundsData->allocated_new_value,2); ?></td>
                            <td><?php echo $fundsData->description ?></td>
                            <td><?php echo $fundsData->created_by ?></td>
                            <td><?php echo $fundsData->date_created ?></td>
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