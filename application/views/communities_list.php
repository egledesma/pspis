<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$region_code = $this->session->userdata('uregion');
?>
<div class="page ">

    <div class="page-header page-header-bordered">

        <h1 class="page-title">Assistance to Communities</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboardc/dashboard') ?>">Dashboard</a></li>
            <li class="active">Communities</li>
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
                        <a class= "btn btn-outline btn-primary"   href="<?php echo base_url('communities/addCommunities') ?>"><i class="icon wb-plus" aria-hidden="true"></i> Add Record</a>
                    </div><br>
                    <table class="table table-hover table-bordered dataTable table-striped width-full" id="exampleTableSearch">
                <thead>
                <tr>
                    <th>Action</th>
                    <th>Project Title</th>
                    <th>Region</th>
                    <th>Type of Assistance</th>
                    <th>Nature of work</th>
                    <th>Fund Source</th>
                    <th>Project Cost</th>
                    <th>Implementing Agency</th>
                    <!-- <th>Status</th> -->
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Action</th>
                    <th>Project Title</th>
                    <th>Region</th>
                    <th>Type of Assistance</th>
                    <th>Nature of work</th>
                    <th>Fund Source</th>
                    <th>Project Cost</th>
                    <th>Implementing Agency</th>
                   <!-- <th>Status</th> -->
                </tr>
                </tfoot>
                <tbody  data-plugin="scrollable" data-direction="horizontal">
                <?php foreach($project as $projectData): ?>
                <tr>
                    <td>
                        <div class="btn-group btn-group-sm" role="group">
                            <a class="btn btn-dark btn-outline" id="confirm"
                               href="<?php echo base_url('communities/view/'.$projectData->project_id.'') ?>" data-toggle="tooltip"
                               data-placement="top" data-original-title="View Project"><i class="icon wb-search" aria-hidden="true"></i></a>
                            <a class="btn btn-info btn-outline" id="confirm"
                               href="<?php echo base_url('communities/updateCommunities/'.$projectData->project_id.'') ?>" data-toggle="tooltip"
                               data-placement="top" data-original-title="Edit Project"><i class="icon wb-edit" aria-hidden="true"></i> </a>
                            <a class="confirmation btn btn-danger btn-outline" id="confirm"
                               href="<?php echo base_url('communities/deleteCommunities/'.$projectData->project_id.'') ?>" data-toggle="tooltip"
                               data-placement="top" data-original-title="Delete Project"><i class="icon wb-close" aria-hidden="true"></i> </a>
                        </div>

                    </td>
                    <td><?php echo $projectData->project_title; ?></td>
                    <td><?php echo $projectData->region_name; ?></td>
                    <td><?php echo $projectData->assistance_name; ?></td>
                    <td><?php echo $projectData->work_nature; ?></td>
                    <td><?php echo $projectData->fund_source; ?></td>
                    <td><?php echo '₱ '. number_format($projectData->project_cost,2); ?></td>
                    <td><?php echo $projectData->implementing_agency; ?></td>
                   <!-- <td><?php // echo $projectData->status; ?></td> -->

                </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
    </div>

</div>