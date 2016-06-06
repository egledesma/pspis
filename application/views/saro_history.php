<div class="page ">

    <div class="page-header page-header-bordered">

        <h1 class="page-title">Saro History</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboardc/dashboard') ?>">Dashboard</a></li>
            <li><a href="<?php echo base_url('saro/index') ?>">Dashboard</a></li>
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
                <table class="table table-hover table-bordered dataTable table-striped width-full" id="exampleTableSearch">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Transfer Amount</th>
                        <th>From Region</th>
                        <th>From Region Old Value</th>
                        <th>From Region New Value</th>
                        <th>To Region</th>
                        <th>To Region Old Value</th>
                        <th>To Region New Value</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Transfer Amount</th>
                        <th>From Region</th>
                        <th>From Region Old Value</th>
                        <th>From Region New Value</th>
                        <th>To Region</th>
                        <th>To Region Old Value</th>
                        <th>To Region New Value</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php foreach($sarodetails as $saroData):

                        ?>  <!--pagination buttons -->
                        <tr>
                            <td><?php echo $saroData->saro_id ?></td>
                            <td><?php echo '₱ '. number_format($saroData->transfer_amount,2); ?></td>
                            <td class="warning"><?php echo '₱ '. number_format($saroData->from_old_value,2); ?></td>
                            <td class="warning"><?php echo '₱ '. number_format($saroData->from_new_value,2); ?></td>
                            <td class="warning"><?php echo $saroData->from_region; ?></td>
                            <td class="success"><?php echo $saroData->to_region; ?></td>
                            <td class="success"><?php echo '₱ '. number_format($saroData->to_old_value,2); ?></td>
                            <td class="success"><?php echo '₱ '. number_format($saroData->to_new_value,2); ?></td>
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