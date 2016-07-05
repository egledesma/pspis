<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$region_code = $this->session->userdata('uregion');
if($region_code != "190000000"){
    redirect('/fundsallocation/index/0','location');

}
//saa
?>
<div class="page ">

    <div class="page-header page-header-bordered">

        <h1 class="page-title">Consolidated Funds History</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboardc/dashboard') ?>">Dashboard</a></li>
            <li><a href="<?php echo base_url('cofunds/index/0') ?>">Consolidated Funds</a></li>
            <li class="active">History</li>
        </ol>
    </div>

    <div class="page-content">
    <div class="panel">
        <div class="panel">
            <header class="panel-heading">
                <h1 class="panel-title"><mark class="bg-dark">&nbsp;&nbsp;&nbsp; <?php echo $consofunds->fund_source ?> - Funds History&nbsp;&nbsp;&nbsp;</mark>&nbsp;&nbsp;&nbsp;</h1>
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
                    <?php foreach($fundsdetails as $cofundsData):


                        ?>  <!--pagination buttons -->

                        <tr>
                            <td><?php echo $cofundsData->consolidated_id ?></td>
                            <td><?php echo '₱ '. number_format($cofundsData->consolidated_old_value,2); ?></td>
                            <td><?php echo '₱ '. number_format($cofundsData->amount,2); ?></td>
                            <td><?php echo '₱ '. number_format($cofundsData->consolidated_new_value,2); ?></td>
                            <td><?php echo $cofundsData->description ?></td>
                            <td><?php echo $cofundsData->created_by ?></td>
                            <td><?php echo $cofundsData->date_created ?></td>
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