<?php
/**
 * Created by PhpStorm.
 * User: mblejano
 * Date: 5/5/2016
 * Time: 9:28 AM
 */


?>

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

        <h1 class="page-title">Cash for work (<?php echo $title->project_title;?>)</h1>
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
                    <?php foreach ($cashforworkinfo as $cashforworkdata): ?>
                    <div class="form-group row">
                        <div id="project_title" class="col-sm-6">
                            <label for="project_title" class="control-label">Project Title:</label>
                            <input id="project_title" name="project_title" placeholder="Project Title" type="text"  class="form-control"   value="<?php echo $cashforworkdata->project_title ?>" readonly/>
                            <span class="text-danger"><?php echo form_error('project_title'); ?></span>
                        </div>
                    </div>

                    <input class="form-control"  type="hidden" name="myid" value="<?php echo $this->session->userdata('uid')?>">
                    <label  class="control-label">Project Location:</label>
                    <input id = "region_pass" name ="region_pass" type = "hidden" value = "<?php echo $region_code;?>">
                    <div class="form-group row">
                        <div id="regionlist" class="col-sm-4">
                            <label for="regionlist" class="control-label">Region:</label>
                            <input id="regionlist" name="regionlist" placeholder="Region" type="text"  class="form-control"   value="<?php echo $cashforworkdata->region_name ?>" readonly/>
                            <span class="text-danger"><?php echo form_error('regionlist'); ?></span>
                        </div>

                            <div id="provlist" class="col-sm-4">
                                <label for="provlist" class="control-label">Province:</label>
                                <input id="provlist" name="provlist" placeholder="Province" type="text"  class="form-control"   value="<?php echo $proj_prov->prov_name ?>" readonly/>
                                <span class="text-danger"><?php echo form_error('provlist'); ?></span>
                            </div>
                    </div>

                    <div class="form-group row">
                        <div >
                            <div id="natureofworklist" class="col-sm-4">
                                <label for="natureofworklist" class="control-label">Nature of Work:</label>
                                <input id="natureofworklist" name="natureofworklist" placeholder="Nature of Work" type="text"  class="form-control"   value="<?php echo $cashforworkdata->work_nature ?>" readonly/>
                                <span class="text-danger"><?php echo form_error('natureofworklist'); ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-4">
                            <label for="number_days" class="control-label">Number of Days:</label>
                            <input id="number_days" name="number_days" placeholder="Number of Days" type="number" min="0"  class="form-control"   value="<?php echo $cashforworkdata->no_of_days ?>" readonly>
                            <span class="text-danger"><?php echo form_error('number_days'); ?></span>
                        </div>
                        <div class="col-sm-4">
                            <label for="daily_payment" class="control-label">Daily Payment Amount:</label>
                            <input id="daily_payment" name="daily_payment" placeholder="Daily Payment Amount" type="number"  class="form-control"  value="<?php echo $cashforworkdata->daily_payment ?>" readonly/>
                            <span class="text-danger"><?php echo form_error('daily_payment'); ?></span>
                        </div>
                    </div>

                    <?php endforeach ?>

                </div>

                <div class="panel-body">
                    <div id="exampleTableAddToolbar" >
                        <a class= "btn btn-outline btn-primary"   href="<?php echo base_url('cashforwork/addCash_muni/'.$cashforworkpass_id.'') ?>"><i class="icon wb-plus" aria-hidden="true"></i> Add City/Municipality</a>
                    </div><br>
                    <table class="table table-hover table-bordered dataTable table-striped width-full" id="exampleTableSearch">
                        <thead><h2> <?php echo $proj_prov->prov_name;?></h2>
                        <tr>
                            <th>Action</th>
                            <th>City/Municipality</th>
                            <th>Daily Payment</th>
                            <th>Number of Beneficiaries</th>
                            <th>Daily Payment</th>
                            <th>Number of Days</th>
                            <th>Cost of Assistance</th>
                            <!-- <th>Status</th> -->
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Action</th>
                            <th>City/Municipality</th>
                            <th>Daily Payment</th>
                            <th>Number of Beneficiaries</th>
                            <th>Daily Payment</th>
                            <th>Number of Days</th>
                            <th>Cost of Assistance</th>

                        </tr>
                        </tfoot>
                        <tbody  data-plugin="scrollable" data-direction="horizontal">

                        <?php foreach($cashmuni_list as $cashmuni_listData): ?>
                            <tr>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a class="btn btn-dark btn-outline" id="confirm"
                                           href="<?php echo base_url('cashforwork/view/'.$cashmuni_listData->cash_muni_id.'') ?>" data-toggle="tooltip"
                                           data-placement="top" data-original-title="View Project"><i class="icon wb-search" aria-hidden="true"></i></a>
                                        <a class="btn btn-info btn-outline" id="confirm"
                                           href="<?php echo base_url('cashforwork/updateCashforwork_muni/'.$cashmuni_listData->cash_muni_id.'') ?>" data-toggle="tooltip"
                                           data-placement="top" data-original-title="Edit Project"><i class="icon wb-edit" aria-hidden="true"></i> </a>
                                        <a class="confirmation btn btn-danger btn-outline" id="confirm"
                                           href="<?php echo base_url('cashforwork/deleteCashforwork/'.$cashmuni_listData->cash_muni_id.'') ?>" data-toggle="tooltip"
                                           data-placement="top" data-original-title="Delete Project"><i class="icon wb-close" aria-hidden="true"></i> </a>
                                        <a class="confirmation btn btn-success btn-outline" id="confirm"
                                           href="<?php echo base_url('cashforwork/viewCash_brgy/'.$cashmuni_listData->cash_muni_id.'') ?>" data-toggle="tooltip"
                                           data-placement="top" data-original-title="Add Brgy"><i class="icon wb-user-add" aria-hidden="true"></i> </a>
                                    </div>

                                </td>
                                <td><?php echo $cashmuni_listData->city_name; ?></td>
                                <td><?php echo '₱ '. number_format($cashmuni_listData->daily_payment,2); ?></td>
                                <td><?php echo  $cashmuni_listData->no_of_bene_muni; ?></td>
                                <td><?php echo $title->daily_payment; ?></td>
                                <td><?php echo $title->no_of_days; ?></td>
                                <td><?php echo '₱ '. number_format($cashmuni_listData->cost_of_assistance_muni,2); ?></td>

                                <!-- <td><?php // echo $projectData->status; ?></td> -->

                            </tr>
                        <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>