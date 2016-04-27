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
        <div class="col-lg-8">
            <!-- Example Panel With All -->
            <div class="panel panel-bordered">
                <div class="panel-heading">
                    <h1 class="panel-title"><mark class="bg-dark">&nbsp;&nbsp;&nbsp; <?php echo $projectdata->project_title ?> &nbsp;&nbsp;&nbsp;</mark></h1>
                    <div class="panel-actions">
                        <a class= "btn btn-outline btn-primary "  data-toggle="tooltip" data-placement="top" data-original-title="Edit Project" href="<?php echo base_url('communities/updateCommunities/'.$projectdata->project_id.'') ?>"><i class="icon wb-edit" aria-hidden="true"></i> Edit</a>
                    </div>
                </div>

                <div class="panel-body">
                    <div>

                    <ul class="list-group list-group-dividered list-group-full col-lg-6">
                        <h5><i class="icon wb-globe" aria-hidden="true"></i><b>Project Location:</b></h5>
                        <li class="list-group-item"> Region:  <b><?php echo $projectdata->region_name ?></b></li>
                        <li class="list-group-item"> Province:  <b><?php echo $projectdata->prov_name ?></b></li>
                        <li class="list-group-item"> City/Municipality:  <b><?php echo $projectdata->city_name ?></b></li>
                        <li class="list-group-item"> Barangay:  <b><?php echo $projectdata->brgy_name ?></b></li>
                    </ul>
                    </div>
                    <div>
                        <ul class="list-group list-group-dividered list-group-full col-lg-6">
                        <h5><i class="icon wb-pencil" aria-hidden="true"></i><b>Project Information:</b></h5>
                            <li class="list-group-item"> Type of Assistance: <b><?php echo $projectdata->assistance_name ?></b></li>
                            <li class="list-group-item"> Nature of Work: <b><?php echo $projectdata->work_nature ?></b></li>
                            <li class="list-group-item"> Number of Beneficiaries: <b><?php echo $projectdata->no_of_bene ?></b></li>
                            <!--<li class="list-group-item"> Barangay: <b><?php //echo $projectdata->region_name ?></b></li> -->
                        </ul>
                    </div>
                </div>
            </div>
            <!-- End Example Panel With All -->
        </div>

        <div class="col-lg-4">
            <!-- Example Panel With All -->
            <div class="panel panel-bordered">
                <div class="panel-heading">
                    <h1 class="panel-title">Implementation</h1>

                    <div class="panel-actions">
                        <?php if($implementationdata->implementation_id == '') { ?>
                        <a class="btn btn-outline btn-danger" data-toggle="tooltip" data-placement="top" data-original-title="Add" href="<?php echo base_url('communities/addCommunities') ?>"><i class="icon wb-plus" aria-hidden="true" ></i> Add</a>
                    </div>
                </div>
                <div class="panel-body">
                </div>
                        <?php } else { ?>
                        <a class="btn btn-outline btn-primary" data-toggle="tooltip" data-placement="top" data-original-title="Edit" href="<?php echo base_url('implementation/editImplementation/'.$implementationdata->implementation_id.'') ?>"><i class="icon wb-edit" aria-hidden="true" ></i> Edit</a>

                    </div>
                </div>
                <div class="panel-body">
                    <ul class="list-group list-group-dividered list-group-full">
                        <h5><i class="icon wb-time" aria-hidden="true"></i><b>Project Timeline:</b></h5>
                        <li class="list-group-item"> Start Date:  <b><?php echo $implementationdata->start_date ?></b></li>
                        <li class="list-group-item"> End Date:  <b><?php echo $implementationdata->target_date ?></b></li>
                        <li class="list-group-item"> Status:  <b><?php echo $implementationdata->project_status ?></b></li>
                    </ul>
                </div>
                <?php } ?>
            </div>
            <!-- End Example Panel With All -->
        </div>

        <div class="col-lg-12">
            <!-- Example Panel With All -->
            <div class="panel panel-bordered">
                <div class="panel-heading">
                    <h1 class="panel-title">Project Budget</h1>

                    <div class="panel-actions">
                        <a class= "btn btn-outline btn-primary "  data-toggle="tooltip" data-placement="top" data-original-title="Edit Project" href="<?php echo base_url('communities/updateCommunities/'.$projectdata->project_id.'') ?>"><i class="icon wb-edit" aria-hidden="true"></i> Edit</a>
                    </div>
                </div>

                <div class="panel-body">
                    <div class="col-lg-6">
                        <h5><i class="icon fa-money" aria-hidden="true"></i><b>Fund Transfer:</b> <a data-toggle="tooltip" data-placement="top" data-original-title="Transfer Funds"  class= "btn btn-outline btn-danger pull-right btn-sm"><i class="icon wb-plus"></i></a></h5>
                        <table class="table table-striped margin-bottom-10">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>1st Tranche:</td>
                                <td><?php echo '₱ '. number_format($budgetdata->first_tranche,2); ?></td>
                                <td>4/27/2016</td>
                                <td>90%</td>
                            </tr>
                            <tr>
                                <td>2nd Tranche</td>
                                <td>121,228</td>
                                <td>4/27/2016</td>
                                <td>90%</td>
                            </tr>
                            <tr>
                                <td>3rd Tranche</td>
                                <td>10,685</td>
                                <td>4/27/2016</td>
                                <td>90%</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-1"></div>

                    <div class="col-lg-5">
                        <h5><i class="icon wb-clipboard" aria-hidden="true"></i><b>Liquidation Report:</b><a data-toggle="tooltip" data-placement="top" data-original-title="Liquidate Funds"  class= "btn btn-outline btn-danger pull-right  btn-sm"><i class="icon wb-plus"></i></a></h5>
                        <table class="table table-striped margin-bottom-10">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>1st Tranche</td>
                                <td><?php echo  '₱ '. number_format($budgetdata->first_liquidate,2); ?></td>
                                <td>4/27/2016</td>
                                <td>90%</td>
                            </tr>
                            <tr>
                                <td>2nd Tranche</td>
                                <td>121,228</td>
                                <td>4/27/2016</td>
                                <td>90%</td>
                            </tr>
                            <tr>
                                <td>3rd Tranche</td>
                                <td>10,685</td>
                                <td>4/27/2016</td>
                                <td>90%</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- End Example Panel With All -->
        </div>
</div>