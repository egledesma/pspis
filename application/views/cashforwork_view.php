<?php
/**
 * Created by PhpStorm.
 * User: mblejano
 * Date: 5/12/2016
 * Time: 8:18 AM
 */
?>
<div class="page ">

    <div class="page-header page-header-bordered">

        <h1 class="page-title">Food for work</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboardc/dashboard') ?>">Dashboard</a></li>
            <li class="active">Food for work</li>
        </ol>
    </div>

    <div class="page-content">
        <div class="panel">
            <div class="panel">
                <header class="panel-heading">
                    &nbsp;<?php //echo $form_message; ?>
                </header>
                <div class="panel panel-bordered">
                    <div class="panel-heading">
                        <h1 class="panel-title"><mark class="bg-dark">&nbsp;&nbsp;&nbsp; <?php echo $project->project_title ?> &nbsp;&nbsp;&nbsp;</mark>&nbsp;&nbsp;&nbsp;</h1>

                    </div>
                                                <div class="panel-body">
                                                    <div>

                                                        <ul class="list-group list-group-dividered list-group-full col-lg-3">
                                                            <h5><i class="icon wb-globe" aria-hidden="true"></i><b>Project Location:</b></h5>
                                                            <li class="list-group-item"> Region:  <b><?php echo $project->region_name ?></b></li>
                                                            <li class="list-group-item"> Province:  <b><?php echo $project->prov_name ?></b></li>
                                                        </ul>
                                                    </div>
                                                    <div>
                                                        <ul class="list-group list-group-dividered list-group-full col-lg-3">
                                                            <h5><i class="icon wb-pencil" aria-hidden="true"></i><b>Project Information:</b></h5>
                                                            <li class="list-group-item"> Nature of Work: <b><?php echo $project->work_nature ?></b></li>
                                                            <li class="list-group-item"> Number of Beneficiaries: <b><?php echo $project->total_bene ?></b></li>
                                                            <li class="list-group-item"> Number of Days: <b><?php echo $project->no_of_days ?></b></li>
                                                        </ul>
                                                    </div>
                                                    <div>
                                                        <ul class="list-group list-group-dividered list-group-full col-lg-3">
                                                            <h5><i class="icon fa-money" aria-hidden="true"></i><b>Project Cost:</b></h5>
                                                            <li class="list-group-item"> Daily payment amount: <b><?php echo '₱ '. number_format($project->daily_payment,2);  ?></b></li>
                                                            <li class="list-group-item"> Cost of Assistance: <b><?php echo '₱ '. number_format($project->total_cost,2);  ?></b></li>
                                                        </ul>
                                                    </div>
                                                    </div>

                </div>
                <div class="examle-wrap">
<!--                    <pre>-->
<!--                    --><?php //print_r($call_brgy)?>
<!--                    </pre>-->
<!--                    <h4 class="example-title">--><?php //echo $project->project_title ?><!--</h4>-->
                    <div class="example">
                        <div class="panel-heading">
                            <h5>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="icon wb-globe" aria-hidden="true"></i><b>City/Municipality:</b></h5>
                        </div>
                        <?php foreach($call_muni as $muni_data):?>
                        <div class="panel-group" id="exampleAccordionDefault" aria-multiselectable="false"
                             role="tablist">

                            <div class="panel">
                                <div class="panel-heading" id="<?php echo 'heading'.$muni_data->city_code?>" role="tab">
                                    <a class="panel-title" data-toggle="collapse" href="#<?php echo 'collapse'.$muni_data->city_code?>"
                                       data-parent="#exampleAccordionDefault" aria-expanded="false"
                                       aria-controls="<?php echo 'collapse'.$muni_data->city_code?>">
<!--                                        --><?php //echo $muni_data->city_name?>
                                        <ul class="list-group list-group-dividered list-group-full col-lg-12">
                                            <li class="list-group-item">   <b><?php echo $muni_data->city_name?></b></li>
                                        </ul>
                                    </a>
                                </div>
                                <div class="panel-collapse collapse" id="<?php echo 'collapse'.$muni_data->city_code?>" aria-labelledby="<?php echo 'heading'.$muni_data->city_code?>"
                                     role="tabpanel">
                                    <div class="panel-body"><br>
                                            <h5><i class="icon wb-globe" aria-hidden="true"></i><b>Barangays:</b></h5>
                                        <?php foreach($call_brgy as $brgy_data):?>
                                            <?php if( $muni_data->city_code  == $brgy_data->city_code) {?>
                                            <ul class="list-group list-group-dividered list-group-full col-lg-6">
                                                <li class="list-group-item"><b><?php echo $brgy_data->brgy_name?></b></li>
                                            </ul>
                                            <?php }?>
                                        <?php endforeach;?>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <?php endforeach;?>

