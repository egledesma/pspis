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
        document.getElementById("divFrame").style.display = "none";
        document.getElementById("AddMuniForm").style.display = "block";
        document.getElementById("cancelButton").style.display = "block";
//        document.getElementById("AddBrgyForm").style.display = "none";
    }
    function callmuniEditForm()
    {
        document.getElementById("divFrame").style.display = "block";
        document.getElementById("AddMuniForm").style.display = "none";
    }
    function callviewBrgy()
    {
        document.getElementById("divFrame").style.display = "block";
        document.getElementById("AddMuniForm").style.display = "none";
        document.getElementById("cancelButton").style.display = "none";
//        document.getElementById("addCityMuni").style.display = "none";
//        document.getElementById("AddBrgyForm").style.display = "none";
//        document.getElementById("viewfoodbrgyForm").style.display = "block";
//        document.getElementById("actionButton").style.display = "none";
    }
    function callAddBrgyForm()
    {
        document.getElementById("divFrame").style.display = "block";
        document.getElementById("AddMuniForm").style.display = "none";
        document.getElementById("cancelButton").style.display = "none";
//        document.getElementById("addCityMuni").style.display = "none";
//        document.getElementById("AddMuniForm").style.display = "none";
//        document.getElementById("cancelButton").style.display = "none";
//        document.getElementById("AddBrgyForm").style.display = "block";
//        document.getElementById("viewfoodbrgyForm").style.display = "none";
    }
    function callCancel()
    {
        document.getElementById("AddMuniForm").style.display = "none";
        document.getElementById("cancelButton").style.display = "none";
//        document.getElementById("addCityMuni").style.display = "none";
//        document.getElementById("AddMuniForm").style.display = "none";
//        document.getElementById("cancelButton").style.display = "none";
//        document.getElementById("AddBrgyForm").style.display = "block";
//        document.getElementById("viewfoodbrgyForm").style.display = "none";
    }
    function closeIframe() {
//        document.getElementById('AddBrgyForm').style.display = 'none';
        document.getElementById("divFrame").style.display = "none";
    }
    function successIframe()
    {
        document.getElementById("divFrame").style.display = "none";
        document.getElementById("iframeSuccess").style.display = "block";
        location.reload(true);

    }
</script>
<style>
    .fluidMedia {
        position: relative;
        padding-bottom: 22%; /* proportion value to aspect ratio 16:9 (9 / 16 = 0.5625 or 56.25%) */
        padding-top: 30px;
        height: 0;
        overflow: hidden;

    }

    .fluidMedia iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow-y: hidden;
    }
</style>
    <div class="page ">

    <div class="page-header page-header-bordered">

        <h1 class="page-title">Food for work (<?php echo $title->project_title;?>)</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboardc/dashboard') ?>">Dashboard</a></li>
            <li><a href="<?php echo base_url('foodforwork/index/0') ?>">Food for work</a></li>
            <li class="active">City/Municipality</li>
        </ol>
    </div>

    <div class="page-content">
        <div class="panel">
            <?php foreach ($foodforworkinfo as $foodforworkdata): ?>

                <div class="panel-heading">
                    <div  style = "display:none" id = "iframeSuccess"class="alert alert-alt alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close" onClick="window.location.href=assistance/index">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <i class="icon wb-check" aria-hidden="true"></i><a class="alert-link" href="javascript:window.location.href=assistance/index">
                            Update Successfully!</a>
                        <script>
//                            location.reload(true);
                        </script>

                    </div>
                    <?php echo $form_message ?>
                    <h1 class="panel-title"><mark class="bg-dark">&nbsp;&nbsp;&nbsp; <?php echo $foodforworkdata->project_title ?> &nbsp;&nbsp;&nbsp;</mark>&nbsp;&nbsp;&nbsp;</h1>

                </div>
                <div class="panel-body">
                    <table  class="table  table-striped width-full">
                        <tr>
                            <td>
                                <div>
                                    <ul class="list-group list-group-dividered list-group-full col-lg-6">
                                        <h5><i class="icon wb-globe" aria-hidden="true"></i><b>Project Location:</b></h5>
                                        <li class="list-group-item"> Region:  <b><?php echo $foodforworkdata->region_name ?></b></li>
                                        <li class="list-group-item"> Province:  <b><?php echo $proj_prov->prov_name ?></b></li>
                                    </ul>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <ul class="list-group list-group-dividered list-group-full col-lg-6">
                                        <h5><i class="icon wb-pencil" aria-hidden="true"></i><b>Project Information:</b></h5>
                                        <li class="list-group-item"> Nature of Work: <b><?php echo $foodforworkdata->work_nature ?></b></li>
                                        <li class="list-group-item"> Number of Beneficiaries: <b><?php echo $foodforworkdata->number_of_bene ?></b></li>
                                        <li class="list-group-item"> Number of Days: <b><?php echo $foodforworkdata->no_of_days ?></b></li>
                                    </ul>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <ul class="list-group list-group-dividered list-group-full col-lg-6">
                                        <h5><i class="icon fa-money" aria-hidden="true"></i><b>Project Cost:</b></h5>
                                        <li class="list-group-item"> Daily payment amount: <b><?php echo '₱ '. number_format($foodforworkdata->daily_payment,2);  ?></b></li>
                                        <li class="list-group-item"> Cost of Assistance: <b><?php echo '₱ '. number_format($foodforworkdata->cost_of_assistance,2);  ?></b></li>
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

                    <div id = "divFrame"  style = "display:none" class="fluidMedia" >
                        <iframe name="idisplayForm" frameborder="0"></iframe>
                    </div>
                    <div class = "form-group row">
                        <table class="table">
                        <tr>
                            <td>
                            <div id="addCityMuni"  style = "display:block" >
                                <a class= "btn btn-outline btn-primary" onclick = "callAddform();" ><i class="icon wb-plus" aria-hidden="true"></i> Add City/Municipality</a>
                            </div>
                            </td>
                            <td>
                            <div id = "cancelButton" style = "display:none">
                                <a class= "btn btn-outline btn-danger" onclick = "callCancel();"><i class="icon wb-close" aria-hidden="true"></i> Cancel</a>
                            </div>
                            </td>
                        </tr>
                    </table>

                    </div>
                    <div id = "AddMuniForm" style = "display:none">
                        <?php $this->view('foodforwork_muni_add'); ?>
                    </div>


                    <table class="table table-hover table-bordered dataTable table-striped width-full" id="CityMuniTable">
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
                        <?php foreach($foodmuni_list as $foodmuni_listData): ?>
                            <tr>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group" id = "actionButton" style = "display:block">
                                        <a class="btn btn-info btn-outline" id="edit_foodforworkmuni"
                                           href="<?php echo base_url('foodforwork/updatefoodforwork_muni/'.$foodmuni_listData->food_muni_id.'/2') ?>" onclick = "callmuniEditForm();"; target ="idisplayForm"
                                           data-toggle="tooltip"
                                           data-placement="top" data-original-title="Edit Project"><i class="icon wb-edit" aria-hidden="true"></i> </a>
                                        <a class="confirmation btn btn-danger btn-outline" id="delete_foodforworkmuni"
                                           href="<?php echo base_url('foodforwork/deletefoodforwork_muni/'.$foodmuni_listData->food_muni_id.'/3') ?>" data-toggle="tooltip"
                                           data-placement="top" data-original-title="Delete Project"><i class="icon wb-close" aria-hidden="true"></i> </a>
                                        <a class="confirmation btn btn-success btn-outline" id="add_foodforworkbrgy"
                                           href="<?php echo base_url('foodforwork/addfood_brgy/'.$foodmuni_listData->food_muni_id.'/0') ?>" onclick = "callAddBrgyForm();"; target ="idisplayForm" data-toggle="tooltip"
                                           data-placement="top" data-original-title="Add Brgy"><i class="icon wb-user-add" aria-hidden="true"></i> </a>
                                    </div>

                                </td>
                                <td><a id="viewfoodbrgy" href="<?php echo base_url('foodforwork/viewfood_brgy/'.$foodmuni_listData->food_muni_id.'/0') ?>" onclick = "callviewBrgy();"; target ="idisplayForm"><?php echo $foodmuni_listData->city_name; ?>
                                </td>
                                <td><?php echo  $foodmuni_listData->no_of_bene_muni; ?></td>
                                <td><?php echo '₱ '. number_format($foodmuni_listData->cost_of_assistance_muni,2); ?></td>

                                <!-- <td><?php // echo $projectData->status; ?></td> -->

                            </tr>
                        <?php endforeach ?>
                        </tbody>
                    </table>




            </div>


         </div>
    </div>
    </div>
    </div>
