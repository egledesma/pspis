<?php
/**
 * Created by PhpStorm.
 * User: mblejano
 * Date: 4/29/2016
 * Time: 9:41 AM
 */$region_code = $this->session->userdata('uregion');
?>

<div class="page ">

    <div class="page-header page-header-bordered">

        <h1 class="page-title">Cash for work</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboardc/dashboard') ?>">Dashboard</a></li>
            <li class="active">Cash for work</li>
        </ol>
    </div>

    <div class="page-content">
        <div class="panel">
            <div class="panel">
                <header class="panel-heading">
                    &nbsp;<?php //echo $form_message; ?>
</header>
<div class="panel-body">
    <div id="exampleTableAddToolbar" >
        <a class= "btn btn-outline btn-primary"   href="<?php echo base_url('cashforwork/addCashforwork') ?>"><i class="icon wb-plus" aria-hidden="true"></i> Add Project</a>
    </div><br>
    <table class="table table-hover table-bordered dataTable table-striped width-full" id="exampleTableSearch">
        <thead>
        <tr>
            <th>Action</th>
            <th>Project Title</th>
            <th>Saa Number</th>
            <th>Region</th>
            <th>Nature of work</th>
            <th>Number of Beneficiaries</th>
            <th>Number of Days</th>
            <th>Cost of Assistance</th>
            <!-- <th>Status</th> -->
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th>Action</th>
            <th>Project Title</th>
            <th>Saa Number</th>
            <th>Region</th>
            <th>Nature of work</th>
            <th>Number of Beneficiaries</th>
            <th>Number of Days</th>
            <th>Cost of Assistance</th>
        </tr>
        </tfoot>
        <tbody  data-plugin="scrollable" data-direction="horizontal">

        <?php foreach($project as $projectData): ?>
            <tr>
                <td>
                    <div class="btn-group btn-group-sm" role="group">
<!--                        <a class="btn btn-dark btn-outline" id="confirm"-->
<!--                           href="--><?php //echo base_url('cashforwork/masterviewcashforwork/'.$projectData->cashforwork_id.'') ?><!--" data-toggle="tooltip"-->
<!--                           data-placement="top" data-original-title="View Project"><i class="icon wb-search" aria-hidden="true"></i></a>-->

                        <a class="btn btn-info btn-outline" id="confirm"
                           href="<?php echo base_url('cashforwork/updateCashforwork/'.$projectData->cashforwork_id.'') ?>" data-toggle="tooltip"
                           data-placement="top" data-original-title="Edit Project"><i class="icon wb-edit" aria-hidden="true"></i> </a>
                        <a class="confirmation btn btn-danger btn-outline" id="confirm"
                           href="<?php echo base_url('cashforwork/deleteCashforwork/'.$projectData->cashforwork_id.'') ?>" data-toggle="tooltip"
                           data-placement="top" data-original-title="Delete Project"><i class="icon wb-close" aria-hidden="true"></i> </a>

<!--                        <a class="confirmation btn btn-success btn-outline" id="confirm"-->
<!--                           href="--><?php //echo base_url('cashforwork/viewCash_muni/'.$projectData->cashforwork_id.'') ?><!--" data-toggle="tooltip"-->
<!--                           data-placement="top" data-original-title="Add City/Municipality"><i class="icon wb-user-add" aria-hidden="true"></i> </a>-->

                        <a class="btn btn-info btn-outline" id="confirm"
                           href="<?php echo base_url('cashforwork/finalize_saro/'.$projectData->cashforwork_id.'') ?>" data-toggle="tooltip"
                           data-placement="top" data-original-title="Finalize"><i class="icon fa-check-square-o" aria-hidden="true"></i></a>
                        <?php if($projectData->file_location == '') {?>
                            <a class="btn btn-info btn-outline" id="confirm"
                               href="<?php echo base_url('cashforwork/upload_bene/'.$projectData->cashforwork_id.'') ?>" data-toggle="tooltip"
                               data-placement="top" data-original-title="Attach file"><i class="icon wb-upload" aria-hidden="true"></i></a>
                        <?php } else {?>
                            <a class="btn btn-info btn-outline" id="confirm" target = "_blank"
                               href="<?php echo base_url('cashforwork/download_bene/'.$projectData->cashforwork_id.'') ?>" data-toggle="tooltip"
                               data-placement="top" data-original-title="Download file"><i class="icon wb-download" aria-hidden="true"></i></a>
                        <?php }?>
                    </div>

                </td>
                <td><a id="viewProject" href="<?php echo base_url('cashforwork/masterviewcashforwork/'.$projectData->cashforwork_id.'') ?>"data-toggle="tooltip"
                       data-placement="top" data-original-title="View Project"><?php echo $projectData->project_title; ?></a></td>
                <td><?php echo $projectData->saro_number; ?></td>
                <td> <a id="addCityMuni"
                        href="<?php echo base_url('cashforwork/viewcash_muni/'.$projectData->cashforwork_id.'') ?>" data-toggle="tooltip"
                        data-placement="top" data-original-title="Add City/Municipality"><?php echo $projectData->region_name; ?></a></td>
                <td><?php echo $projectData->work_nature; ?></td>
                <td><a id="total_bene" href="<?php echo base_url('cashforwork/cashforworkBenelist/'.$projectData->cashforwork_id.'') ?>" data-toggle="tooltip"
                       data-placement="top" data-original-title="Beneficiaries list"><?php echo $projectData->total_bene; ?></a></td>
                <td><?php echo $projectData->no_of_days; ?></td>
                <td><?php echo '₱ '. number_format($projectData->total_cost,2); ?></td>

                <!-- <td><?php // echo $projectData->status; ?></td> -->

            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
</div>
</div>
</div>

</div>