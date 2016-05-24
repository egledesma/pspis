<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

?>

<div class="page ">

    <div class="page-header page-header-bordered">

        <h1 class="page-title">User Information</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboardc/dashboard') ?>">Dashboard</a></li>
            <li><a href="<?php echo base_url('user/index') ?>">Users</a></li>
            <li class="active">Edit</li>
        </ol>
    </div>

    <div class="page-content">
        <div class="panel">
            <header class="panel-heading">
                <div class="panel-heading">
                    <h3 class="panel-title">Edit User</h3>
                </div>
            </header>
            <div class="panel-body">



                <?php
                $attributes = array("class" => "form-horizontal", "id" => "userformedit", "name" => "userformedit");
                 echo form_open("user/edit", $attributes);?>


                <div class="form-group row">
                <input type = "hidden" name = 'user_id' id = 'user_id' value = "<?php echo $userdetails->uid;?>">
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label for="full_name" class="control-label">Full Name:</label>
                        <input id="full_name" name="full_name" placeholder="Full Name" type="text" class="form-control"  value="<?php echo $userdetails->full_name; ?>" required autofocus />
                        <span class="text-danger"><?php echo form_error('full_name'); ?></span>
                    </div>
                </div>

                <div class="form-group row">
                        <div class="col-sm-6">
                            <label for="username" class="control-label">Username:</label>
                            <input id="username" name="username" placeholder="Username" type="text" class="form-control"  value="<?php echo $userdetails->username; ?>" required  />
                            <span class="text-danger"><?php echo form_error('username'); ?></span>
                        </div>
                </div>

                <div class="form-group row">
                        <div class="col-sm-6">
                            <label for="email" class="control-label">Email Address:</label>
                            <input id="email" name="email" placeholder="Email Address" type="email" class="form-control"  value="<?php echo $userdetails->email; ?>" required  />
                            <span class="text-danger"><?php echo form_error('email'); ?></span>
                        </div>
                </div>

                <div class="form-group row">
                        <div class="col-sm-5">
                            <label for="regionlist" class="control-label">Region :</label>
                            <select  name="regionlist" id="regionlist" class="form-control"">
                                <option value="">Choose Region</option>
                                <?php foreach($regionlist as $regionselect): ?>
                                    <option value="<?php echo $regionselect->region_code; ?>"
                                        <?php if(isset($userdetails->region_code)) {
                                            if($regionselect->region_code == $userdetails->region_code) {
                                                echo " selected";
                                            }
                                        } ?>
                                    >
                                        <?php echo $regionselect->region_name; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>


                        <div class="col-sm-5">
                            <label for="accesslevel" class="control-label">Access Level :</label>
                            <select  name="accesslevel" id="accesslevel" class="form-control"">
                            <option value="">Choose Access Level</option>
                            <?php foreach($accesslevellist as $accesslevelselect): ?>
                                <option value="<?php echo $accesslevelselect->userlevelid; ?>"
                                    <?php if(isset($userdetails->access_level)) {
                                        if($accesslevelselect->userlevelid == $userdetails->access_level) {
                                            echo " selected";
                                        }
                                    } ?>
                                >
                                    <?php echo $accesslevelselect->userlevelname; ?>
                                </option>
                            <?php endforeach; ?>
                            </select>
                        </div>
                </div>

                    <div class="form-group row">
                        <div class="col-sm-5">
                            <label for="status" class="control-label">Activated :</label>
                            <select name="status" id="status" class="form-control"">
                            <option value="<?php echo $userdetails->activated; ?>"
                            ><?php echo ($userdetails->activated ? 'Yes' : 'No') ; ?>
                            </option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                            </select>
                        </div>


                        <div class="col-sm-5">
                            <label for="lockedstatus" class="control-label">Is Locked? :</label>
                            <select name="lockedstatus" id="lockedstatus" class="form-control"">
                            <option value="<?php echo $userdetails->locked_status; ?>"
                            ><?php echo $userdetails->locked_status ; ?>
                            </option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                            </select>
                        </div>
                    </div>

                </div>


                <div class="site-action">
                    <button  type="submit"  id="btn_add" name="btn_add" class="btn btn-floating btn-success btn-lg btn-outline" data-toggle="tooltip"
                             data-placement="top" data-original-title="Update">
                        <i class="front-icon wb-pencil animation-scale-up" aria-hidden="true"></i>
                    </button>

                </div>


                <?php echo form_close(); ?>

            </div>
        </div>
    </div>

</div>



