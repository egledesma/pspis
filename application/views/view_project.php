
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
                    <ul class="list-group list-group-dividered list-group-full">
                        <h5><i class="icon wb-time" aria-hidden="true"></i><b>Project Timeline:</b></h5>
                    </ul>
                </div>
                        <?php } else { ?>
                        <a class="btn btn-outline btn-primary" data-toggle="tooltip" data-placement="top" data-original-title="Edit" href="<?php echo base_url('communities/addCommunities') ?>"><i class="icon wb-plus" aria-hidden="true" ></i> Edit</a>

                    </div>
                </div>
                <div class="panel-body">
                    <ul class="list-group list-group-dividered list-group-full">
                        <h5><i class="icon wb-time" aria-hidden="true"></i><b>Project Timeline:</b></h5>
                        <li class="list-group-item"> Start Date:  <b><?php echo $implementationdata->start_date ?></b></li>
                        <li class="list-group-item"> End Date:  <b><?php echo $implementationdata->end_date ?></b></li>
                        <li class="list-group-item"> Status:  <b><?php echo $implementationdata->project_status ?></b></li>
                    </ul>
                </div>
                <?php } ?>
            </div>
            <!-- End Example Panel With All -->
        </div>

        <div class="col-lg-4">
            <!-- Example Panel With All -->
            <div class="panel panel-bordered">
                <div class="panel-heading">
                    <h1 class="panel-title">Budget</h1>

                    <div class="panel-actions">
                        <a class= "btn btn-outline btn-danger" data-toggle="tooltip" data-placement="top" data-original-title="Add" href="<?php echo base_url('communities/addCommunities') ?>"><i class="icon wb-plus" aria-hidden="true"></i> Add</a>
                    </div>
                </div>
                <div class="panel-body">
                    <p></P>
                </div>
            </div>
            <!-- End Example Panel With All -->
        </div>
</div>