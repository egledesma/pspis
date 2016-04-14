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
                        <th>Year</th>
                        <th>Region</th>
                        <th>Funds Allocated</th>
                        <th>Funds Utilized</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Year</th>
                        <th>Region</th>
                        <th>Funds Allocated</th>
                        <th>Funds Utilized</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php foreach($fundsdetails as $fundsData): ?>  <!--pagination buttons -->
                        <tr>
                            <td><?php echo $fundsData->funds_id ?></td>
                            <td><?php echo $fundsData->for_year; ?></td>
                            <td><?php echo $fundsData->region_name; ?></td>
                            <td><?php echo '₱ '.$fundsData->funds_allocated; ?></td>
                            <td><?php echo '₱ '.$fundsData->funds_utilized ?></td>
                            <td><?php echo $fundsData->status; ?></td>
                            <td>
                                <div class="btn-group">
                                    <a class="btn btn-info btn-outline" data-target="#exampleFormModal1" data-toggle="modal"  href="<?php echo base_url('fundsallocation/edit/') ?>" data-toggle="tooltip"
                                       data-placement="top" data-original-title="Edit"><i class="icon wb-edit" aria-hidden="true" ></i> </a>
                                    <a class="confirmation btn btn-danger btn-outline" id="confirm"
                                       href="<?php echo base_url('fundsallocation/delete/') ?>" data-toggle="tooltip"
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