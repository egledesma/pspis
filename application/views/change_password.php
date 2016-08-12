<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$form_validation = '<div class="alert alert-alt alert-danger alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button><a class="alert-link" href="javascript:void(0)">
                </button>' . validation_errors() . '</a></div>';
$uid = $this->session->userdata('uid');
error_reporting(0);
?>

<div class="page ">

    <div class="page-header page-header-bordered">

        <h1 class="page-title">Change Password</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboardc/dashboard') ?>">Dashboard</a></li>
            <li class="active">Change Password</li>
        </ol>
    </div>

    <div class="page-content">
        <div class="panel">
            <header class="panel-heading">
                <div class="panel-heading">
                    <h3 class="panel-title">Change Password</h3>
                </div>
            </header>
            <div class="panel-body">



                <?php
                $attributes = array("class" => "form-horizontal", "id" => "userformedit", "name" => "userformedit");
                 echo form_open("users/change_password/$uid", $attributes);?>


                <div class="form-group row">
                <input type = "hidden" name = 'user_id' id = 'user_id' value = "<?php echo $passworddetails->uid;?>">
                   <?php echo $form_message; ?><?php if(validation_errors() != false) { echo $form_validation; } else {} ?>
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label for="o_password" class="control-label">Old Password:</label>
                        <input id="o_password" name="o_password" placeholder="Old Password" type="text" class="form-control"  value="" required autofocus />
                    </div>
                </div>

                <div class="form-group row">
                        <div class="col-sm-6">
                            <label for="n_password" class="control-label">New Password:</label>
                            <input id="n_password" name="n_password" placeholder="New Password" type="password" class="form-control" required  />
                        </div>
                </div>

                <div class="form-group row">
                        <div class="col-sm-6">
                            <label for="password" class="control-label">Confirm New Password:</label>
                            <input id="c_password" name="c_password" placeholder="Confirm New Password" type="password" class="form-control" required  />

                        </div>
                </div>




                <div class="site-action">
                    <button  type="submit"  id="btn_add" name="btn_add" class="btn btn-floating btn-success btn-lg btn-outline" data-toggle="tooltip"
                             data-placement="top" data-original-title="Change Password">
                        <i class="front-icon wb-edit animation-scale-up" aria-hidden="true"></i>
                    </button>

                </div>


                <?php echo form_close(); ?>

            </div>
        </div>
    </div>

</div>



