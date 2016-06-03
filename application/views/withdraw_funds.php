<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$region_code = $this->session->userdata('uregion');
?>
<script type="text/javascript">

function get_saro_amount()
{

    var saro_id = $('#sarolist').val();

    if(saro_id > 0){

        $.ajax({
            url: "<?php echo base_url('withdraw/populate_saro_amount'); ?>",
            async: false,
            type: "POST",
            data: "saro_id="+saro_id,
            dataType: "html",
            success: function(data,data1,data2) {

                $('#saro_number_amount').html(data);
                $('#saro_number_id').html(data1);
                $('#saro_number').html(data2);
            }
        });
    }
    }
</script>
<div class="page ">

    <div class="page-header page-header-bordered">

        <h1 class="page-title">Add </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboardc/dashboard') ?>">Dashboard</a></li>
            <li><a href="<?php echo base_url('fundsallocation/index') ?>">Funds Allocation</a></li>
            <li class="active">Add</li>
        </ol>
    </div>

    <div class="page-content">
        <div class="panel">
            <header class="panel-heading">
                <div class="panel-heading">
                    <h3 class="panel-title">Withdraw/Transfer Funds</h3>
                </div>
            </header>
            <div class="panel-body">

                <?php
                $attributes = array("class" => "form-horizontal", "id" => "projectformadd", "name" => "projectformadd");
                //input here the next location when click insert

                echo form_open("", $attributes);?>
                <input class="form-control"  type="hidden" name="myid" value="<?php echo $this->session->userdata('uid')?>">

                <div class="form-group row">
                    <div id="liqui_date" class="col-sm-6">
                        <label for="liqui_date" class="control-label">Date:</label>
                        <div class="input-group">
                                            <span class="input-group-addon">
                                              <i class="icon wb-calendar" aria-hidden="true"></i>
                                            </span>
                            <input id="withdraw_date" name="withdraw_date" placeholder="Date" type="text"  class="form-control"  value="" data-plugin="datepicker" required/><span class="text-danger"><?php echo form_error('liqui_date'); ?></span>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-6">
                        <label class="control-label" for="sarolist">Saro Number:</label>
                        <select name="sarolist" id="sarolist" class="form-control"  required="required" onchange="get_saro_amount();" autofocus>
                            <option value="">Choose Saro Number</option>
                            <?php foreach($sarolist as $saroselect): ?>
                                <option value="<?php echo $saroselect->saro_id; ?>"
                                    <?php if(isset($saro_id)) {
                                        if($saroselect->saro_id == $saro_id) {
                                            echo " selected";
                                        }
                                    } ?>
                                >
                                    <?php echo $saroselect->saro_number."  (₱  ".number_format($saroselect->saro_balance).")"; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-sm-6">


                        <div id = "saro_number_amount" name = "saro_number_amount">
                            <!--                            <label for="saro_amount" class="control-label">Amount Requested:</label>-->
<!--                                                        <input type = "number" id="saro_amount"  name ="saro_amount" value="0" class = "form-control">-->
                        </div>

                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-6">
                        <label class="control-label" for="new_saro">New Saro Number:</label>
                        <input id="new_saro" name="new_saro" placeholder="New Saro Number" type="text"  class="form-control"  required/>
                        <span class="text-danger"><?php echo form_error('new_saro'); ?></span>
                    </div>
                </div>
                <input id="year" name="year"  type="hidden" value="<?php echo date('Y');?>"  class="form-control"/>


                <div class="form-group row">

                    <div id="regionID" class="col-sm-5">
                        <label class="sr-only" for="region">Region</label>
                        <label for="regionlist" class="control-label">From Region :</label>
                        <select name="regionlist" id="regionlist" class="form-control" disabled>
                            <option value="">Choose Region</option>
                            <?php foreach($region_list as $regionselect): ?>
                                <option value="<?php echo $regionselect->region_code;  ?>"
                                    <?php if(isset($from_region->region_code)) {
                                        if($regionselect->region_code == $from_region->region_code) {
                                            echo " selected";
                                        }
                                    } ?>
                                >
                                    <?php echo $regionselect->region_name; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <input value="<?php echo $from_region->region_code;?>" type="hidden" name="from_region" id="from_region" />
                    </div>

                    <div id="regionID" class="col-sm-5">
                    <label class="sr-only" for="region">Region</label>
                        <label for="to_region" class="control-label">To Region :</label>
                    <select name="to_region" id="to_region" class="form-control" required>
                        <option value="">Choose Region</option>
                        <?php foreach($to_region as $regionselect): ?>
                            <option value="<?php echo $regionselect->region_code; ?>"
                                <?php if(isset($_SESSION['region'])) {
                                    if($regionselect->region_code == $_SESSION['region']) {
                                        echo " selected";
                                    }
                                } ?>
                            >
                                <?php echo $regionselect->region_name; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-6">
                        <label class="control-label" for="remarks">Remarks:</label>
                        <input id="remarks" name="remarks" placeholder="Remarks" type="text"  class="form-control"  required/>
                        <span class="text-danger"><?php echo form_error('remarks'); ?></span>
                    </div>
                </div>


                <div class="site-action">
                   <button  type="submit"  id="btn_add" name="btn_add" class="btn btn-floating btn-danger btn-lg btn-outline" data-toggle="tooltip"
                            data-placement="top" data-original-title="Save">
                        <i class="front-icon fa-save animation-scale-up" aria-hidden="true"></i>
                    </button>

                </div>
                <?php echo form_close(); ?>

            </div>
        </div>
    </div>
</div>