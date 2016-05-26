<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!$this->session->userdata('user_data')){
    redirect('/users/login','location');

}
$user_region = $this->session->userdata('uregion');
error_reporting(0);
?>
<div class="page ">

    <div class="page-header page-header-bordered">

        <h1 class="page-title">LGU Counterpart</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboardc/dashboard') ?>">Dashboard</a></li>
            <li><a href="<?php echo base_url('libraries/index') ?>">Libraries</a></li>
            <li class="active">LGU Counterpart</li>
        </ol>
    </div>

    <div class="page-content"
        <div class="panel">
            <div class="panel">
            <header class="panel-heading">
                &nbsp;<?php echo $form_message; ?>
            </header>
            <div class="panel-body">
                <div id="exampleTableAddToolbar">
                    <button id="exampleTableAddBtn" class="btn btn-outline btn-primary"  data-target="#exampleFormModal" data-toggle="modal">
                        <i class="icon wb-plus" aria-hidden="true"></i> Add Record
                    </button>
                </div><br>
                <table class="table table-hover table-bordered dataTable table-striped width-full" id="exampleTableSearch">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>LGU</th>
                        <th>Date Created</th>
                        <th>Date Modified</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>LGU</th>
                        <th>Date Created</th>
                        <th>Date Modified</th>
                        <th>Action</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php foreach($lguDetails as $lguData): ?>  <!--pagination buttons -->
                        <tr>
                            <td><?php echo $lguData->lgucounterpart_id ?></td>
                            <td><?php echo $lguData->lgu_counterpart; ?></td>
                            <td><?php echo $lguData->date_created; ?></td>
                            <td><?php echo $lguData->date_modified; ?></td>
                            <td>
                                <div class="btn-group">
                                    <a class="btn btn-info btn-outline" data-target="#exampleFormModal1" data-toggle="modal"  href="<?php echo base_url('lgu/edit/' . $lguData->lgucounterpart_id . '') ?>"><i class="icon wb-edit" aria-hidden="true" data-toggle="tooltip"
                                        data-placement="top" data-original-title="Edit"></i> </a>
                                    <a class="confirmation btn btn-danger btn-outline" id="confirm"
                                       href="<?php echo base_url('lgu/delete/' . $lguData->lgucounterpart_id . '') ?>" data-toggle="tooltip"
                                       data-placement="top" data-original-title="Delete"><i class="icon wb-close" aria-hidden="true"></i> </a>
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
<div class="modal fade" id="exampleFormModal1" aria-hidden="false" aria-labelledby="exampleFormModalLabel1"
     role="dialog" tabindex="-1">
    <div class="modal-dialog modal-center">
        <?php
        $attributes = array("class" => "modal-content", "id" => "sourceoffund_edit", "name" => "sourceoffund_edit");
        //input here the next location when click insert1
        echo form_open("sourcefund/edit", $attributes);?>

        <?php echo form_close(); ?>
        <?php echo $this->session->flashdata('msg'); ?>
    </div>
</div>


    <div class="modal fade" id="exampleFormModal" aria-hidden="false" aria-labelledby="exampleFormModalLabel"
         role="dialog" tabindex="-1">
        <div class="modal-dialog modal-center">
            <?php
            $attributes = array("class" => "modal-content", "id" => "sourceoffund_add", "name" => "sourceoffund_add");
            //input here the next location when click insert1
            echo form_open("sourcefund/index", $attributes);?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h3 class="modal-title" id="exampleFormModalLabel"><i class="icon wb-plus"></i>Add New</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 form-group">
                            <input class="form-control"  type="hidden" name="myid" value="<?php echo $this->session->userdata('uid')?>">
                            <input type="text" class="form-control" name="fund_source" placeholder="Source of Fund" required>
                        </div>
                        <div class="col-sm-12 pull-right">
                            <button class="btn btn-success btn-outline" type="submit" name="btn_add"><i class="icon wb-check" aria-hidden="true"></i>Save</button>
                            <button class="btn btn-danger btn-outline" data-dismiss="modal" type="button"><i class="icon wb-close"></i>Cancel</button>
                        </div>
                    </div>
                </div>
            <?php echo form_close(); ?>
            <?php echo $this->session->flashdata('msg'); ?>
        </div>
    </div>
    <div class="site-action" data-toggle="tooltip"
         data-placement="top" data-original-title="Add Record">
        <button type="button" data-target="#exampleFormModal" data-toggle="modal"
                class="btn btn-floating btn-danger" >
            <i class="front-icon wb-plus animation-scale-up" aria-hidden="true"></i>
            <i class="back-icon wb-close animation-scale-up" aria-hidden="true"></i>
        </button>
        <div class="site-action-buttons">
            <button type="button" class="btn-raised btn btn-success btn-floating animation-slide-bottom animation-delay-100">
                <i class="icon wb-trash" aria-hidden="true"></i>
            </button>
            <button type="button" class="btn-raised btn btn-success btn-floating animation-slide-bottom">
                <i class="icon wb-inbox" aria-hidden="true"></i>
            </button>
        </div>
    </div>
</div>

<script type="text/javascript">
    var elems = document.getElementsByClassName('confirmation');
    var confirmIt = function (e) {
        if (!confirm('Are you sure?')) e.preventDefault();
    };
    for (var i = 0, l = elems.length; i < l; i++) {
        elems[i].addEventListener('click', confirmIt, false);
    }
</script>