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

        <h1 class="page-title">Cash for work</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboardc/dashboard') ?>">Dashboard</a></li>
            <li><a href="<?php echo base_url('cashforwork/index/0') ?>">Cash for work</a></li>
            <li class="active">Beneficiaries List</li>
        </ol>
    </div>

    <div class="page-content">
        <div class="panel">
            <div class="panel">
                <header class="panel-heading">
                    &nbsp;<?php //echo $form_message; ?>
                </header>

                <!--<pre>-->
                <?php //print_r($call_bene)?>
                <!--</pre>-->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="example-wrap">

                            <div class="example">
                                <div class="panel-heading">
                                    <h5>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="icon wb-globe" aria-hidden="true"></i><b>City/Municipality:</b></h5>
                                </div>
                                <table width = "100%">
                                    <?php foreach($call_muni as $muni_data):?>
                                        <tr>
                                            <td>
                                                <div class="panel-group" id="exampleAccordionDefault" aria-multiselectable="true"
                                                     role="tablist">
                                                    <div class="panel">
                                                        <div class="panel-heading" id="<?php echo 'heading'.$muni_data->city_code?>" role="tab">
                                                            <a class="panel-title" data-toggle="collapse" href="#<?php echo 'collapse'.$muni_data->city_code?>"
                                                               data-parent="#exampleAccordionDefault" aria-expanded="true"
                                                               aria-controls="<?php echo 'collapse'.$muni_data->city_code?>">

                                                                <ul class="list-group list-group-dividered list-group-full col-lg-12">
                                                                    <li class="list-group-item"><b><?php echo $muni_data->city_name?></b>    </li>
                                                                    <li class="list-group-item">Number of Beneficiaries: <b><?php echo $muni_data->no_of_bene_muni?></b>  </li>
                                                                </ul>
                                                            </a>
                                                        </div>
                                                        <div class="panel-collapse collapse" id="<?php echo 'collapse'.$muni_data->city_code?>" aria-labelledby="<?php echo 'heading'.$muni_data->city_code?>"
                                                             role="tabpanel">
                                                            <div class="panel-body">
                                                                <h5><i class="icon wb-globe" aria-hidden="true"></i><b>Barangays:</b></h5>
                                                                <ul class="list-group list-group-dividered list-group-full col-lg-6">
                                                                    <?php foreach($call_brgy as $brgy_data):?>
                                                                        <?php if( $muni_data->city_code  == $brgy_data->city_code) {?>

                                                                            <li class="list-group-item"><b><?php echo $brgy_data->brgy_name?></b></li>
                                                                            <ul class="list-group list-group-dividered list-group-full col-lg-12">

                                                                                <?php foreach($call_bene as $bene_data):?>
                                                                                    <?php if($brgy_data->cash_brgy_id == $bene_data->cashforwork_brgy_id){?>
                                                                                        <li class="list-group-item"><b><?php echo $bene_data->bene_fullname;}?></b></li>
                                                                                <?php endforeach;?>
                                                                            </ul>
                                                                        <?php }?>
                                                                    <?php endforeach;?>
                                                                </ul>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach;?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
</div>

