<div class="page ">

    <div class="page-header page-header-bordered">

        <h1 class="page-title">User List</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboardc/dashboard') ?>">Dashboard</a></li>
            <li class="active">Users</li>
        </ol>
    </div>

    <div class="page-content">
    <div class="panel">
        <div class="panel">
            <header class="panel-heading">
                &nbsp;<?php //echo $form_message; ?>
            </header>
            <div class="panel-body">
                <div id="exampleTableAddToolbar">
                    <a class= "btn btn-outline btn-primary"   href="<?php echo base_url('user/add') ?>"><i class="icon wb-plus" aria-hidden="true"></i> Add Record</a>
                </div><br>
                <table class="table table-hover table-bordered dataTable table-striped width-full" id="exampleTableSearch">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Region</th>
                        <th>Access Level</th>
                        <th>Activated</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Region</th>
                        <th>Access Level</th>
                        <th>Activated</th>
                        <th>Action</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php foreach($userdetails as $userData):


                        ?>  <!--pagination buttons -->

                        <tr>
                            <td><?php echo $userData->uid ?></td>
                            <td><?php echo $userData->full_name; ?></td>
                            <td><?php echo $userData->username; ?></td>
                            <td><?php echo $userData->email; ?></td>
                            <td><?php echo $userData->region_name; ?></td>
                            <td><?php echo $userData->userlevelname; ?></td>
                            <td><?php echo $userData->activated ? 'Yes' : 'No'; ?></td>
                            <td>
                                <div class="btn-group">
                                    <a class="btn btn-info btn-outline"  href="<?php echo base_url('user/edit/'.$userData->uid.'') ?>" data-toggle="tooltip"
                                       data-placement="top" data-original-title="Edit"><i class="icon wb-edit" aria-hidden="true" ></i> </a>

                                    <?php if($userData->activated == "0"){ ?>
                                    <a class="btn btn-success btn-outline" id="confirm"  href="<?php echo base_url('user/activate/'.$userData->uid.'') ?>" data-toggle="tooltip"
                                       data-placement="top" data-original-title="Activate User"><i class="icon wb-check" aria-hidden="true" ></i> </a>
                                    <?php }else { ?>
                                    <a class="btn btn-danger btn-outline" id="confirm" href="<?php echo base_url('user/deactivate/'.$userData->uid.'') ?>" data-toggle="tooltip"
                                       data-placement="top" data-original-title="Deactivate User"><i class="icon wb-close" aria-hidden="true" ></i> </a>
                                    <?php } ?>

                                    <?php if($userData->locked_status == "Yes"){ ?>
                                        <a class="confirmation btn btn-success btn-outline" id="confirm"
                                           href="<?php echo base_url('user/unlock/'.$userData->uid.'') ?>" data-toggle="tooltip"
                                           data-placement="top" data-original-title="Unlock User"><i class="icon wb-unlock" aria-hidden="true"></i> </a>
                                    <?php }else { ?>
                                        <a class="confirmation btn btn-danger btn-outline" id="confirm" href="<?php echo base_url('user/lock/'.$userData->uid.'') ?>" data-toggle="tooltip"
                                           data-placement="top" data-original-title="Lock User"><i class="icon wb-lock" aria-hidden="true" ></i> </a>
                                    <?php } ?>

                                </div>
                            </td>
                        </tr>
                    <?php endforeach ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
    </div>

</div>