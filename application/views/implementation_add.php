<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

?>

<div class="page ">

    <div class="page-header page-header-bordered">

        <h1 class="page-title">Project Implementation</h1>
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
                    <h3 class="panel-title">Add Project Implementation</h3>
                </div>
            </header>
            <div class="panel-body">



                <?php
                $attributes = array("class" => "form-horizontal", "id" => "addimplementation", "name" => "addimplementation");
                 echo form_open("implementation/addImplementation", $attributes);?>


                <div class="form-group row">

                <div class="example">
                    <input type="hidden" name="project_id" id="project_id" value="<?php echo $projectdata->project_id; ?>">
                    <div id="start_date" class="col-sm-4">
                        <label for="start_date" class="control-label">Start Date:</label>
                    <div class="input-group">
                    <span class="input-group-addon">
                      <i class="icon wb-calendar" aria-hidden="true"></i>
                    </span>
                        <input id="start_date" name="start_date" placeholder="Start Date" type="text"  class="form-control"  value="" data-plugin="datepicker" required/><span class="text-danger"><?php echo form_error('start_date'); ?></span>
                    </div>
                    </div>

                    <div id="start_date" class="col-sm-4">
                        <label for="target_date" class="control-label">Target Date:</label>
                        <div class="input-group">
                    <span class="input-group-addon">
                      <i class="icon wb-calendar" aria-hidden="true"></i>
                    </span>
                            <input id="target_date" name="target_date" placeholder="Target Date" type="text"  class="form-control"  value="" data-plugin="datepicker" required/><span class="text-danger"><?php echo form_error('target_date'); ?></span>
                        </div>
                    </div>
                </div>

                </div>

                <div class="form-group row">

                    <div class="example">
                        <div id="project_status" class="col-sm-4">
                            <label for="project_status" class="control-label">Project Status:</label>
                            <select name="project_status" id="project_status" data-plugin="selectpicker" required>
                                <option data-icon="wb-heart" value="">Please Select</option>
                                <option data-icon="wb-heart" value="Completed">Completed</option>
                                <option data-icon="wb-briefcase" value="On-Going">On-Going</option>

                                <option data-icon="wb-video" value="Extended">Extended</option>
                            </select>
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



