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

        <h1 class="page-title">Food for work</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboardc/dashboard') ?>">Dashboard</a></li>
            <li class="active">Food for work</li>
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
                        <a class= "btn btn-outline btn-primary"   href="<?php echo base_url('foodforwork/addfoodforwork') ?>"><i class="icon wb-plus" aria-hidden="true"></i> Add Record</a>
                    </div><br>
                    <table class="table table-hover table-bordered dataTable table-striped width-full" id="exampleTableSearch">
                        <thead>
                        <tr>
                            <th>Action</th>
                            <th>Project Title</th>
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
                                        <a class="btn btn-dark btn-outline" id="confirm"
                                           href="<?php echo base_url('foodforwork/view/'.$projectData->foodforwork_id.'') ?>" data-toggle="tooltip"
                                           data-placement="top" data-original-title="View Project"><i class="icon wb-search" aria-hidden="true"></i></a>
                                        <a class="btn btn-info btn-outline" id="confirm"
                                           href="<?php echo base_url('foodforwork/updatefoodforwork/'.$projectData->foodforwork_id.'') ?>" data-toggle="tooltip"
                                           data-placement="top" data-original-title="Edit Project"><i class="icon wb-edit" aria-hidden="true"></i> </a>
                                        <a class="confirmation btn btn-danger btn-outline" id="confirm"
                                           href="<?php echo base_url('foodforwork/deletefoodforwork/'.$projectData->foodforwork_id.'') ?>" data-toggle="tooltip"
                                           data-placement="top" data-original-title="Delete Project"><i class="icon wb-close" aria-hidden="true"></i> </a>
                                        <a class="confirmation btn btn-success btn-outline" id="confirm"
                                           href="<?php echo base_url('foodforwork/cash_addbene/'.$projectData->foodforwork_id.'') ?>" data-toggle="tooltip"
                                           data-placement="top" data-original-title="Add beneficiaries"><i class="icon wb-user-add" aria-hidden="true"></i> </a>
                                    </div>

                                </td>
                                <td><?php echo $projectData->project_title; ?></td>
                                <td><?php echo $projectData->region_name; ?></td>
                                <td><?php echo $projectData->work_nature; ?></td>
                                <td><?php echo $projectData->no_of_bene; ?></td>
                                <td><?php echo $projectData->no_of_days; ?></td>
                                <td><?php echo '₱ '. number_format($projectData->cost_of_assistance,2); ?></td>

                                <!-- <td><?php // echo $projectData->status; ?></td> -->

                            </tr>
                        <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>