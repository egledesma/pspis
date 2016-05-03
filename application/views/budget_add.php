<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

?>

<div class="page ">

    <div class="page-header page-header-bordered">

        <h1 class="page-title">Project Budget</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboardc/dashboard') ?>">Dashboard</a></li>
            <li><a href="<?php echo base_url('communities/index') ?>">Communities</a></li>
            <li><a href="<?php echo base_url('communities/view/'.$projectdata->project_id.'') ?>">View Project</a></li>
            <li class="active">Add</li>
        </ol>
    </div>

    <div class="page-content">
        <div class="panel">
            <header class="panel-heading">
                <div class="panel-heading">
                    <h3 class="panel-title">First Tranche</h3>
                </div>
            </header>
            <div class="panel-body">



                <?php
                $attributes = array("class" => "form-horizontal", "id" => "addbudget", "name" => "addbudget");
                 echo form_open("budget/addBudget", $attributes);?>


                <div class="form-group row">

                    <div class="example">
                        <div id="project_status" class="col-sm-4">
                            <label for="first_tranche" class="control-label">Amount:</label>
                            <input type="number" min="0" maxlength="10" name="first_tranche" id="first_tranche" >
                        </div>
                    </div>

                </div>

                <div class="form-group row">

                <div class="example">
                    <input type="hidden" name="project_id" id="project_id" value="<?php echo $projectdata->project_id; ?>">
                    <input type="hidden" name="region_code" id="region_code" value="<?php echo $projectdata->region_code; ?>">


                    <div id="start_date" class="col-sm-4">
                        <label for="first_tranche_date" class="control-label">Date:</label>
                    <div class="input-group">
                    <span class="input-group-addon">
                      <i class="icon wb-calendar" aria-hidden="true"></i>
                    </span>
                        <input id="first_tranche_date" name="first_tranche_date" placeholder="First Tranche Date" type="text"  class="form-control"  value="" data-plugin="datepicker" required/><span class="text-danger"><?php echo form_error('first_tranche_date'); ?></span>
                    </div>
                    </div>

                </div>

                </div>




                <div class="site-action">
                    <button  type="submit"  id="btn_add" name="btn_add" class="btn btn-floating btn-danger btn-lg btn-outline" data-toggle="tooltip"
                             data-placement="top" data-original-title="Add">
                        <i class="front-icon wb-pencil animation-scale-up" aria-hidden="true"></i>
                    </button>

                </div>


                <?php echo form_close(); ?>

            </div>
        </div>
    </div>

</div>



