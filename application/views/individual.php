<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

?>


<div class="page ">

    <div class="page-header page-header-bordered">

        <h1 class="page-title">Assistance to Individuals in Crisis Situations</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboardc/dashboard') ?>">Dashboard</a></li>
            <li class="active"></li>
        </ol>
    </div>

    <div class="page-content">
        <div class="panel">
            <header class="panel-heading">
            </header>
            <div class="panel-body">
            <div class="col-md-12">
                <pre>
<!--                --><?php //print_r($crims); ?>
                </pre>
                <table class="table table-hover table-bordered dataTable table-striped width-full" id="exampleTableSearch">
                    <thead>
                    <tr>
                        <th>Action</th>
                        <th>Saro</th>
                        <th>Region</th>
                        <th>Utilize</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Action</th>
                        <th>Saro</th>
                        <th>Region</th>
                        <th>Utilize</th>
                    </tr>
                    </tfoot>
                    <tbody  data-plugin="scrollable" data-direction="horizontal">

                    <?php foreach($crims as $crimsData): ?>
                        <tr>
<!--                            <td>-->
<!--                                <div class="btn-group btn-group-sm" role="group">-->
<!--                                    <a class="btn btn-dark btn-outline" id="confirm"-->
<!--                                       href="--><?php //echo base_url('foodforwork/view/'.$projectData->foodforwork_id.'') ?><!--" data-toggle="tooltip"-->
<!--                                       data-placement="top" data-original-title="View Project"><i class="icon wb-search" aria-hidden="true"></i></a>-->
<!--                                    <a class="btn btn-info btn-outline" id="confirm"-->
<!--                                       href="--><?php //echo base_url('foodforwork/updatefoodforwork/'.$projectData->foodforwork_id.'') ?><!--" data-toggle="tooltip"-->
<!--                                       data-placement="top" data-original-title="Edit Project"><i class="icon wb-edit" aria-hidden="true"></i> </a>-->
<!--                                    <a class="confirmation btn btn-danger btn-outline" id="confirm"-->
<!--                                       href="--><?php //echo base_url('foodforwork/deletefoodforwork/'.$projectData->foodforwork_id.'') ?><!--" data-toggle="tooltip"-->
<!--                                       data-placement="top" data-original-title="Delete Project"><i class="icon wb-close" aria-hidden="true"></i> </a>-->
<!--                                    <a class="confirmation btn btn-success btn-outline" id="confirm"-->
<!--                                       href="--><?php //echo base_url('foodforwork/cash_addbene/'.$projectData->foodforwork_id.'') ?><!--" data-toggle="tooltip"-->
<!--                                       data-placement="top" data-original-title="Add beneficiaries"><i class="icon wb-user-add" aria-hidden="true"></i> </a>-->
<!--                                    <a class="btn btn-info btn-outline" id="confirm"-->
<!--                                       href="--><?php //echo base_url('foodforwork/finalize_saro/'.$projectData->foodforwork_id.'') ?><!--" data-toggle="tooltip"-->
<!--                                       data-placement="top" data-original-title="Finalize"><i class="icon fa-check-square-o" aria-hidden="true"></i></a>-->
<!--                                </div>-->

<!--                            </td>-->
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a class="btn btn-dark btn-outline" id="confirm"
                                       href="<?php echo base_url('individual/addIndividual/'.$crimsData->RegionAssist.'') ?>" data-toggle="tooltip"
                                       data-placement="top" data-original-title="View Project"><i class="icon wb-add" aria-hidden="true"></i></a>
                                    <a class="btn btn-info btn-outline" id="confirm"
                                       href="<?php echo base_url('individual/updatefoodforwork/'.$crimsData->RegionAssist.'') ?>" data-toggle="tooltip"
                                       data-placement="top" data-original-title="Edit Project"><i class="icon wb-edit" aria-hidden="true"></i> </a>
                                </div>
                            </td>
                            <td>Test</td>
                            <td><?php echo $crimsData->region_name; ?></td>
                            <td><?php echo '₱ '. number_format($crimsData->Utilize,2); ?></td>


                        </tr>
                    <?php endforeach ?>
                    </tbody>
                </table>

            </div>
            </div>
        </div>
    </div>