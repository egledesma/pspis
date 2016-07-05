<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$region_code = $this->session->userdata('uregion');
if($region_code != "190000000"){
    redirect('/fundsallocation/index/0','location');

}
//saa
?>
<script type="text/javascript">

function get_saa_amount()
{

    var saa_id = $('#saalist').val();

    if(saa_id > 0){

        $.ajax({
            url: "<?php echo base_url('withdraw/populate_saa_amount'); ?>",
            async: false,
            type: "POST",
            data: "saa_id="+saa_id,
            dataType: "html",
            success: function(data,data1,data2) {

                $('#saa_number_amount').html(data);
                $('#saa_number_id').html(data1);
                $('#saa_number').html(data2);
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
            <li><a href="<?php echo base_url('fundsallocation/index/0') ?>">Funds Allocation</a></li>
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
                <input class="form-control"  type="hidden" name="fund_source" value="<?php echo $funds->fundsource_id?>">

                <div class="form-group row">
                    <div id="liqui_date" class="col-sm-6">
                        <label for="liqui_date" class="control-label">Date:</label>
                        <div class="input-group">
                                            <span class="input-group-addon">
                                              <i class="icon wb-calendar" aria-hidden="true"></i>
                                            </span>
                            <input id="withdraw_date" name="withdraw_date" placeholder="Date" type="text"  class="form-control"  value="" data-plugin="datepicker" required/><span class="text-danger"><?php echo form_error('withdraw_date'); ?></span>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-6">
                        <label class="control-label" for="saalist">Saa Number:</label>
                        <select name="saalist" id="saalist" class="form-control"  required="required" onchange="get_saa_amount();" autofocus>
                            <option value="">Choose Saa Number</option>
                            <?php foreach($saalist as $saaselect): ?>
                                <option value="<?php echo $saaselect->saa_id; ?>"
                                    <?php if(isset($saao_id)) {
                                        if($saaselect->saa_id == $saa_id) {
                                            echo " selected";
                                        }
                                    } ?>
                                >
                                    <?php echo $saaselect->saa_number."  (₱  ".number_format($saaselect->saa_balance).")"; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-sm-6">


                        <div id = "saa_number_amount" name = "saa_number_amount">
                            <!--                            <label for="saa_amount" class="control-label">Amount Requested:</label>-->
<!--                                                        <input type = "number" id="saa_amount"  name ="saa_amount" value="0" class = "form-control">-->
                        </div>

                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-6">
                        <label class="control-label" for="new_saa">New Saa Number:</label>
                        <input id="new_saa" name="new_saa" placeholder="New Saa Number" type="text"  class="form-control"  required/>
                        <span class="text-danger"><?php echo form_error('new_saa'); ?></span>
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