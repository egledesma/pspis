<?php error_reporting(0); ?>
<div class="page ">

    <div class="page-header page-header-bordered">

        <h1 class="page-title">Assistance to Communities</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboardc/dashboard') ?>">Dashboard</a></li>
            <li><a href="<?php echo base_url('communities/index') ?>">Communities</a></li>
            <li class="active">View Project</li>
        </ol>
    </div>

    <div class="page-content">
        <div class="col-lg-12">
            <!-- Example Panel With All -->
            <div class="panel panel-bordered">
                <div class="panel-heading">
                    <h1 class="panel-title"><mark class="bg-dark">&nbsp;&nbsp;&nbsp; <?php echo $projectdata->project_title ?> &nbsp;&nbsp;&nbsp;</mark>&nbsp;&nbsp;&nbsp;
                        <?php $status = $projectdata->status_name;
                        if($status == "Completed"){ ?>
                        <mark class="bg-success">&nbsp;&nbsp;&nbsp; <?php echo $projectdata->status_name ?> &nbsp;&nbsp;&nbsp;</mark></h1>
                        <?php } else if($status == "On-Going"){ ?>
                        <mark class="bg-primary">&nbsp;&nbsp;&nbsp; <?php echo $projectdata->status_name ?> &nbsp;&nbsp;&nbsp;</mark></h1>
                        <?php } else if($status == "Extended"){ ?>
                        <mark class="bg-warning">&nbsp;&nbsp;&nbsp; <?php echo $projectdata->status_name ?> &nbsp;&nbsp;&nbsp;</mark></h1>
                        <?php } else {}
                        ?>
                    <div class="panel-actions">
                        <a class= "btn btn-outline btn-primary "  data-toggle="tooltip" data-placement="top" data-original-title="Edit Project" href="<?php echo base_url('communities/updateCommunities/'.$projectdata->project_id.'') ?>"><i class="icon wb-edit" aria-hidden="true"></i> Edit</a>
                    </div>
                </div>

                <div class="panel-body">
                    <div>

                    <ul class="list-group list-group-dividered list-group-full col-lg-3">
                        <h5><i class="icon wb-globe" aria-hidden="true"></i><b>Project Location:</b></h5>
                        <li class="list-group-item"> Region:  <b><?php echo $projectdata->region_name ?></b></li>
                        <li class="list-group-item"> Province:  <b><?php echo $projectdata->prov_name ?></b></li>
                        <li class="list-group-item"> City/Municipality:  <b><?php echo $projectdata->city_name ?></b></li>
                        <li class="list-group-item"> Barangay:  <b><?php echo $projectdata->brgy_name ?></b></li>
                    </ul>
                    </div>
                    <div>
                        <ul class="list-group list-group-dividered list-group-full col-lg-3">
                        <h5><i class="icon wb-pencil" aria-hidden="true"></i><b>Project Information:</b></h5>
                            <li class="list-group-item"> Type of Assistance: <b><?php echo $projectdata->assistance_name ?></b></li>
                            <li class="list-group-item"> Nature of Work: <b><?php echo $projectdata->work_nature ?></b></li>
                            <li class="list-group-item"> Number of Beneficiaries: <b><?php echo $projectdata->no_of_bene ?></b></li>
                            <li class="list-group-item"> Implementing Agency: <b><?php echo $projectdata->agency_name ?></b></li>
                            <!--<li class="list-group-item"> Barangay: <b><?php //echo $projectdata->region_name ?></b></li> -->
                        </ul>
                    </div>
                    <div>
                        <ul class="list-group list-group-dividered list-group-full col-lg-3">
                            <h5><i class="icon fa-money" aria-hidden="true"></i><b>Project Cost:</b></h5>
                            <li class="list-group-item"> SAro Number: <b><?php echo $projectdata->saro_number ?></b></li>
                            <li class="list-group-item"> Funds Source: <b><?php echo $projectdata->fund_source ?></b></li>
                            <li class="list-group-item"> Amount Requested: <b><?php echo '₱ '. number_format($projectdata->project_amount,2);  ?></b></li>
                            <li class="list-group-item"> LGU Amount/s: <b><?php echo '₱ '. number_format($projectdata->lgu_amount,2);  ?></b></li>
                            <li class="list-group-item"> Project Cost: <b><?php echo  '₱ '. number_format($projectdata->project_cost,2);  ?></b></li>
                            <!--<li class="list-group-item"> Barangay: <b><?php //echo $projectdata->region_name ?></b></li> -->
                        </ul>
                    </div>
                    <div>
                        <ul class="list-group list-group-dividered list-group-full col-lg-3">
                            <h5><i class="icon fa-calendar" aria-hidden="true"></i><b>Project Timeline:</b></h5>
                            <li class="list-group-item"> Start Date: <b><?php echo $projectdata->start_date ?></b></li>
                            <li class="list-group-item"> Target Date: <b><?php echo $projectdata->target_date ?></b></li>
                            <li class="list-group-item"> Status: <b><?php echo $projectdata->project_status ?></b></li>
                            <!--<li class="list-group-item"> Barangay: <b><?php //echo $projectdata->region_name ?></b></li> -->
                        </ul>
                    </div>
                </div>
            </div>
            <!-- End Example Panel With All -->
        </div>

       <!-- <div class="col-lg-4">
            <!-- Example Panel With All
            <div class="panel panel-bordered">
                <div class="panel-heading">
                    <h1 class="panel-title">Implementation</h1>

                    <div class="panel-actions">
                        <?php// if($implementationdata->implementation_id == '') { ?>
                        <a class="btn btn-outline btn-danger" data-toggle="tooltip" data-placement="top" data-original-title="Add" href="<?php echo base_url('implementation/addImplementation/'.$projectdata->project_id.'') ?>"><i class="icon wb-plus" aria-hidden="true" ></i> Add</a>
                    </div>
                </div>
                <div class="panel-body">
                </div>
                        <?php //} else { ?>
                        <a class="btn btn-outline btn-primary" data-toggle="tooltip" data-placement="top" data-original-title="Edit" href="<?php echo base_url('implementation/editImplementation/'.$implementationdata->implementation_id.'') ?>"><i class="icon wb-edit" aria-hidden="true" ></i> Edit</a>

                    </div>
                </div>
                <div class="panel-body">
                    <ul class="list-group list-group-dividered list-group-full">
                        <h5><i class="icon wb-time" aria-hidden="true"></i><b>Project Timeline:</b></h5>
                        <li class="list-group-item"> Start Date:  <b><?php// echo $implementationdata->start_date ?></b></li>
                        <li class="list-group-item"> End Date:  <b><?php// echo $implementationdata->target_date ?></b></li>
                        <li class="list-group-item"> Status:  <b><?php //echo $implementationdata->project_status ?></b></li>
                    </ul>
                </div>
                <?php// } ?>
            </div>
            <!-- End Example Panel With All
        </div>-->

        <div class="col-lg-12">
            <!-- Example Panel With All -->
            <div class="panel panel-bordered">
                <div class="panel-heading">
                    <h1 class="panel-title">Project Budget</h1>

                </div>



                <div class="panel-body">
                    <div class="col-lg-6">
                        <h5><i class="icon fa-money" aria-hidden="true"></i><b>Fund Transfer:</b></h5>
                        <table class="table table-striped margin-bottom-10">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Remarks</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>1st Tranche:</td>
                                <td><b><?php echo '₱ '. number_format($budgetdata->first_tranche,2); ?></td>
                                <td><b><?php echo  date('m/d/Y', strtotime(str_replace('-','-',$budgetdata->first_tranche_date ))); ?></td>
                                <td><b><?php echo $budgetdata->first_tranche_remarks; ?></td>
                                <td><button type="button" class="btn btn-pure btn-lg btn-success icon wb-check-circle" data-target="#examplePositionCenter" data-toggle="modal" data-original-title="Transfer Funds"></button></td>
                            </tr>
                            <div class="modal fade" id="examplePositionCenter" aria-hidden="true" aria-labelledby="examplePositionCenter"
                                 role="dialog" tabindex="-1">
                                <div class="modal-dialog modal-center">
                                    <?php
                                    $attributes = array("class" => "modal-content", "id" => "tranche1_add", "name" => "tranche1_add");
                                    //input here the next location when click insert1
                                    echo form_open("communities/addFirstTranche/".$implementationdata->project_id, $attributes);?>
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                            <h4 class="modal-title">Transfer Funds</h4>
                                        </div>
                                        <div class="modal-body">

                                            <div class="form-group row">
                                            <div id="start_date" class="col-sm-8">
                                                <label for="start_date" class="control-label">Start Date:</label>
                                                <div class="input-group">
                                            <span class="input-group-addon">
                                              <i class="icon wb-calendar" aria-hidden="true"></i>
                                            </span>
                                                    <input id="start_date" name="start_date" placeholder="Start Date" type="text"  class="form-control"  value="" data-plugin="datepicker" required/><span class="text-danger"><?php echo form_error('start_date'); ?></span>
                                                </div>
                                            </div>
                                            </div>
                                            <div class="form-group row">
                                                <div id="project_title" class="col-sm-10">
                                                    <label for="remarks" class="control-label">Remarks:</label>
                                                    <input id="remarks" name="remarks" placeholder="Remarks" type="text"  class="form-control"  value="<?php echo set_value('remarks'); ?>" required/>
                                                    <input id="budget_id" name="budget_id" placeholder="budget_id" type="hidden"  class="form-control"  value="<?php echo $budgetdata->budget_id; ?>" required/>
                                                    <input class="form-control"  type="hidden" name="myid" value="<?php echo $this->session->userdata('uid')?>">
                                                    <input class="form-control"  type="hidden" name="project_idpass" value="<?php echo $implementationdata->project_id?>">
                                                    <span class="text-danger"><?php echo form_error('remarks'); ?></span>
                                                </div>

                                            </div>


                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                        <?php echo form_close(); ?>
                                        <?php echo $this->session->flashdata('msg'); ?>
                                    </div>
                                </div>
                            </div>
                            <tr>
                                <?php if($budgetdata->first_liquidate_status == 1) {?>
                                <td>2nd Tranche</td>
                                <td><b><?php echo '₱ '. number_format($budgetdata->second_tranche ,2); ?></td>
                                <td><b><?php echo  date('m/d/Y', strtotime(str_replace('-','-',$budgetdata->second_tranche_date ))); ?></td>
                                <td><b>90%</td>
                                <td><button type="button" class="btn btn-pure btn-lg btn-success icon wb-check-circle" data-toggle="tooltip" data-original-title="Transfer Funds"></button></td>
                                <?php }?>
                            </tr>
                            <tr>
                                <?php if($budgetdata->second_liquidate_status == 1) {?>
                                <td>3rd Tranche</td>
                                <td><b><?php echo '₱ '. number_format($budgetdata->third_tranche,2); ?></td>
                                <td><b><?php echo  date('m/d/Y', strtotime(str_replace('-','-',$budgetdata->third_tranche_date ))); ?></td>
                                <td><b>90%</td>
                                <td><button type="button" class="btn btn-pure btn-lg btn-success icon wb-check-circle" data-toggle="tooltip" data-original-title="Transfer Funds"></button></td>
                                <?php }?>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-lg-6">
                        <h5><i class="icon wb-clipboard" aria-hidden="true"></i><b>Liquidation Report:</b></h5>
                        <table class="table table-striped margin-bottom-10">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Remarks</th>
                            </tr>
                            </thead><b>
                            <tbody>
                            <tr>
                                <?php if($budgetdata->first_tranche_status == 1) {?>
                                <td>1st Tranche</td>
                                <td><b><?php echo  '₱ '. number_format($first_tranche,2); ?></td>
                                <td><b><?php echo  date('m/d/Y', strtotime(str_replace('-','-',$budgetdata->first_liquidate_date ))); ?></td>
                                <td><b>90%</td>
                                <td><button type="button" class="btn btn-pure btn-lg btn-success icon wb-check-circle" data-toggle="tooltip" data-original-title="Liquidate"></button></td>
                                <?php }?>
                            </tr>
                            <tr>
                                <?php if($budgetdata->second_tranche_status == 1) {?>
                                <td>2nd Tranche</td>
                                <td><b><?php echo  '₱ '. number_format($second_tranche,2); ?></td>
                                <td><b><?php echo  date('m/d/Y', strtotime(str_replace('-','-',$budgetdata->second_liquidate_date ))); ?></td>
                                <td><b>90%</td>
                                <td><button type="button" class="btn btn-pure btn-lg btn-success icon wb-check-circle" data-toggle="tooltip" data-original-title="Liquidate"></button></td>
                                <?php }?>
                            </tr>
                            <tr>
                                <?php if($budgetdata->third_tranche_status == 1) {?>
                                <td>3rd Tranche</td>
                                <td><b><?php echo  '₱ '. number_format($third_tranche,2); ?></td>
                                <td><b><?php echo  date('m/d/Y', strtotime(str_replace('-','-',$budgetdata->third_liquidate_date ))); ?></td>
                                <td><b>90%</td>
                                <td><button type="button" class="btn btn-pure btn-lg btn-success icon wb-check-circle" data-toggle="tooltip" data-original-title="Liquidate"></button></td>
                                <?php }?>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- End Example Panel With All -->
        </div>

</div>