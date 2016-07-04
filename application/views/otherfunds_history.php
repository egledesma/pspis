<div class="page ">

    <div class="page-header page-header-bordered">

        <h1 class="page-title">Other Funds History</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboardc/dashboard') ?>">Dashboard</a></li>
            <li><a href="<?php echo base_url('fundsallocation/index/0') ?>">Funds Allocation</a></li>
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
                        <th>Date</th>
                        <th>Amount Transfer</th>
                        <th>From Region</th>
                        <th>Old Saa Number</th>
                        <th>To Region</th>
                        <th>New Saa Number</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Amount Transfer</th>
                        <th>From Region</th>
                        <th>Old Saa Number</th>
                        <th>To Region</th>
                        <th>New Saa Number</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php foreach($allocationdetails as $fundsData):


                        ?>  <!--pagination buttons -->

                        <tr>
                            <td><?php echo $fundsData->withdraw_id ?></td>
                            <td><?php echo $fundsData->date ?></td>
                            <td><?php echo '₱ '. number_format($fundsData->amount,2); ?></td>
                            <td><?php echo $fundsData->from_office ?></td>
                            <td><?php echo $fundsData->old_saa_number ?></td>
                            <td><?php echo $fundsData->to_office ?></td>
                            <td><?php echo $fundsData->saa_number ?></td>
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