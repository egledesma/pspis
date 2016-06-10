<?php
/**
 * Created by PhpStorm.
 * User: mblejano
 * Date: 4/29/2016
 * Time: 9:41 AM
 */$region_code = $this->session->userdata('uregion');
?>
<script type = "text/javascript">
    function callAddform()
    {
        document.getElementById("AddMuniForm").style.display = "block";
    }
//    function callAddbrgyform()
//    {
//        document.getElementById("AddBrgyForm").style.display = "block";
//    }
</script>
    <div class="page ">

    <div class="page-header page-header-bordered">

        <h1 class="page-title">Cash for work (<?php echo $title->project_title;?>)</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboardc/dashboard') ?>">Dashboard</a></li>
            <li><a href="<?php echo base_url('cashforwork/index') ?>">Cash for work</a></li>
            <li class="active">City/Municipality</li>
        </ol>
    </div>

    <div class="page-content">
        <div class="panel">
            <?php foreach ($cashforworkinfo as $cashforworkdata): ?>

                <div class="panel-heading">
                    <h1 class="panel-title"><mark class="bg-dark">&nbsp;&nbsp;&nbsp; <?php echo $cashforworkdata->project_title ?> &nbsp;&nbsp;&nbsp;</mark>&nbsp;&nbsp;&nbsp;</h1>

                </div>
                <div class="panel-body">
                    <table  class="table">
                        <tr>
                            <td>
                                <div>
                                    <ul class="list-group list-group-dividered list-group-full col-lg-6">
                                        <h5><i class="icon wb-globe" aria-hidden="true"></i><b>Project Location:</b></h5>
                                        <li class="list-group-item"> Region:  <b><?php echo $cashforworkdata->region_name ?></b></li>
                                        <li class="list-group-item"> Province:  <b><?php echo $proj_prov->prov_name ?></b></li>
                                    </ul>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <ul class="list-group list-group-dividered list-group-full col-lg-6">
                                        <h5><i class="icon wb-pencil" aria-hidden="true"></i><b>Project Information:</b></h5>
                                        <li class="list-group-item"> Nature of Work: <b><?php echo $cashforworkdata->work_nature ?></b></li>
                                        <li class="list-group-item"> Number of Beneficiaries: <b><?php echo $cashforworkdata->number_of_bene ?></b></li>
                                        <li class="list-group-item"> Number of Days: <b><?php echo $cashforworkdata->no_of_days ?></b></li>
                                    </ul>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <ul class="list-group list-group-dividered list-group-full col-lg-6">
                                        <h5><i class="icon fa-money" aria-hidden="true"></i><b>Project Cost:</b></h5>
                                        <li class="list-group-item"> Daily payment amount: <b><?php echo '₱ '. number_format($cashforworkdata->daily_payment,2);  ?></b></li>
                                        <li class="list-group-item"> Cost of Assistance: <b><?php echo '₱ '. number_format($cashforworkdata->cost_of_assistance,2);  ?></b></li>
                                    </ul>
                                </div>
                            </td>
                        <tr>
                    </table>
                    <input class="form-control"  type="hidden" name="myid" value="<?php echo $this->session->userdata('uid')?>">
                    <input id = "region_pass" name ="region_pass" type = "hidden" value = "<?php echo $region_code;?>">
                </div>
                    <?php endforeach ?>
                <div class="panel-body">
                    <div id="exampleTableAddToolbar" >
                        <a class= "btn btn-outline btn-primary" onclick = "callAddform();" ><i class="icon wb-plus" aria-hidden="true"></i> Add City/Municipality</a>
                    </div>
                    <br>
                        <div id = "AddMuniForm" style = "display:none">
                            <?php $this->view('cashforwork_muni_add'); ?>
                            <a class= "btn btn-outline btn-danger" href="<?php echo base_url('cashforwork/viewCash_muni/'.$cashforworkpass_id.'') ?>"><i class="icon wb-close" aria-hidden="true"></i> Cancel</a>

                        </div>
<!---->
<!--                    <div id = "EditMuniForm" style = "display:none">-->
<!--                        --><?php //$this->view('cashforwork_muni_add'); ?>
<!--                        <a class= "btn btn-outline btn-danger" href="--><?php //echo base_url('cashforwork/viewCash_muni/'.$cashforworkpass_id.'') ?><!--"><i class="icon wb-close" aria-hidden="true"></i> Cancel</a>-->
<!---->
<!--                    </div>-->

                    <table class="table table-hover table-bordered dataTable table-striped width-full" id="exampleTableSearch">
                        <thead><h2> <?php echo $proj_prov->prov_name;?></h2>
                        <tr>
                            <th>Action</th>
                            <th>City/Municipality</th>
                            <th>Number of Beneficiaries</th>
                            <th>Cost of Assistance</th>
                            <!-- <th>Status</th> -->
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Action</th>
                            <th>City/Municipality</th>
                            <th>Number of Beneficiaries</th>
                            <th>Cost of Assistance</th>

                        </tr>
                        </tfoot>
                        <tbody  data-plugin="scrollable" data-direction="horizontal">
                        <?php foreach($cashmuni_list as $cashmuni_listData): ?>
                            <tr>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a class="btn btn-info btn-outline" id="edit_cashforworkmuni"
                                           href="<?php echo base_url('cashforwork/updateCashforwork_muni/'.$cashmuni_listData->cash_muni_id.'') ?>"
                                           data-toggle="tooltip"
                                           data-placement="top" data-original-title="Edit Project"><i class="icon wb-edit" aria-hidden="true"></i> </a>
                                        <a class="confirmation btn btn-danger btn-outline" id="delete_cashforworkmuni"
                                           href="<?php echo base_url('cashforwork/deleteCashforwork_muni/'.$cashmuni_listData->cash_muni_id.'') ?>" data-toggle="tooltip"
                                           data-placement="top" data-original-title="Delete Project"><i class="icon wb-close" aria-hidden="true"></i> </a>
<!--                                        <iframe width="700" height="200" src="--><?php //echo site_url('cashforwork/addCash_brgy/'.$cashmuni_listData->cash_muni_id.'');?><!--">>    </iframe>-->
                                        <a class="confirmation btn btn-success btn-outline" id="add_cashforworkbrgy"
                                           href="<?php echo base_url('cashforwork/addCash_brgy/'.$cashmuni_listData->cash_muni_id.'') ?>" target ="addbrgy" data-toggle="tooltip"
                                           data-placement="top" data-original-title="Add Brgy"><i class="icon wb-user-add" aria-hidden="true"></i> </a>
                                    </div>

                                </td>
                                <td><?php echo $cashmuni_listData->city_name; ?></td>
                                <td><?php echo  $cashmuni_listData->no_of_bene_muni; ?></td>
                                <td><?php echo '₱ '. number_format($cashmuni_listData->cost_of_assistance_muni,2); ?></td>

                                <!-- <td><?php // echo $projectData->status; ?></td> -->

                            </tr>
                        <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
<!--                <div id = "AddBrgyForm">-->
<!----> <iframe width="1000" height="200" name="addbrgy">    </iframe>
<!--                </div>-->
            </div>

    </div>