<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$region_code = $this->session->userdata('uregion');

?>
<script type="text/javascript">

    document.onreadystatechange=function(){
        get_muni();
        recalculateMultiply();
    }


    function get_muni() {
        var prov_code = $('#prov_pass').val();
        $('#brgylist option:gt(0)').remove().end();
        if(prov_code > 0) {
            $.ajax({
                url: "<?php echo base_url('cashforwork/populate_muni'); ?>",
                async: false,
                type: "POST",
                data: "prov_code="+prov_code,
                dataType: "html",
                success: function(data) {
                    $('#muniID').html(data);
                }
            });
        } else {
            $('#munilist option:gt(0)').remove().end();
        }
    }

    function recalculateMultiply()
    {
        var num1 = parseInt(document.getElementById("number_bene").value);
        var num2 = parseInt(document.getElementById("number_days_hidden").value);
        var num3 = parseInt(document.getElementById("daily_payment").value);
        document.getElementById("cost_of_assistance").value = num1 * num2 * num3 ;

    }
</script>


<div class="page ">

    <div class="page-header page-header-bordered">

        <h1 class="page-title">Add </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboardc/dashboard') ?>">Dashboard</a></li>
            <li><a href="<?php echo base_url('cashforwork/view') ?>">Add City/Municipality</a></li>
            <li class="active">Add</li>
        </ol>
    </div>

    <div class="page-content">
        <div class="panel">
            <header class="panel-heading">
                <div class="panel-heading">
                    <h3 class="panel-title">Add City/Municipality</h3>
                </div>
            </header>
            <div class="panel-body">

                <?php
                $attributes = array("class" => "form-horizontal", "id" => "cashmuniformadd", "name" => "cashmuniformadd");
                //input here the next location when click insert

                echo form_open("cashforwork/addCash_muni", $attributes);?>
                <!--<pre>-->
                <?php //print_r($natureofworklist)?>
                <!--</pre>-->

                <input class="form-control"  type="hidden" name="myid" value="<?php echo $this->session->userdata('uid')?>">


                <input class="form-control" id = "prov_pass" name ="prov_pass" type = "hidden" value = "<?php echo $proj_prov->prov_code;?>" >
<!--                <input class="form-control" id = "saro_id" name ="saro_id" type = "hidden" value = "--><?php //echo $title->saro_id;?><!--" >-->
                <input class="form-control" id = "cashforworkpass_id" name ="cashforworkpass_id" type = "hidden" value = "<?php echo $cashforworkpass_id;?>" >
<!--                <input class="form-control" id = "region_pass" name ="region_pass" type = "hidden" value = "--><?php //echo $region_pass;?><!--" >-->
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="provlist" class="control-label">Province :</label>
                        <input class="form-control" id = "proj_prov_name" name ="proj_prov_name" type = "text" value = "<?php echo $proj_prov->prov_name;?>" disabled>
                    </div>

                    <div class="col-sm-3">
                        <label for="munilist" class="control-label">Municipality :</label>
                        <div id="muniID">
                            <select  id="munilist" name="munilist" class="form-control" required required="required" autofocus>
                                <?php if(isset($_SESSION['muni']) or isset($_SESSION['province'])) {
                                    ?>
                                    <option value="">Choose Municipality</option>
                                    <?php
                                    foreach ($munilist as $muniselect) { ?>
                                        <option value="<?php echo $muniselect->city_code; ?>"
                                            <?php
                                            if (isset($_SESSION['muni']) and $muniselect->city_code== $_SESSION['muni']) {
                                                echo " selected";
                                            } ?>
                                        >
                                            <?php echo $muniselect->city_name; ?></option>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <option value="">Select Province First</option>
                                    <?php
                                } ?>
                            </select>
                        </div>
                    </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-4">
                            <label for="number_bene" class="control-label">Number of Beneficiaries in City/Municipality:</label>
                            <input id="number_bene" name="number_bene" placeholder="Number of Beneficiaries" type="number" min="0"  class="form-control"  value="<?php echo set_value('number_bene'); ?>" required autofocus onchange = "recalculateMultiply();"/>
                            <span class="text-danger"><?php echo form_error('number_bene'); ?></span>
                        </div>
                        <div class="col-sm-4">
                            <label for="daily_payment" class="control-label">Daily Payment Amount:</label>
                            <input id="daily_payment" name="daily_payment" placeholder="Daily Payment Amount" type="number"  class="form-control"  value="<?php echo $title->daily_payment; ?>"required onblur = "recalculateMultiply();"disabled/>
                            <span class="text-danger"><?php echo form_error('daily_payment'); ?></span>
                        </div>
                        <div class="col-sm-4">
                            <label for="number_days" class="control-label">Number of Days:</label>
                            <input id="number_days_hidden" name="number_days_hidden" placeholder="Number of Days" type="hidden" min="0"  class="form-control"  value="<?php echo $title->no_of_days; ?>" />
                            <input id="daily_payment" name="daily_payment" placeholder="daily payment" type="hidden" min="0"  class="form-control"  value="<?php echo $title->daily_payment; ?>" />
                            <input id="number_days" name="number_days" placeholder="Number of Days" type="number" min="0"  class="form-control"  value="<?php echo $title->no_of_days; ?>" disabled/>
                            <span class="text-danger"><?php echo form_error('number_days'); ?></span>
                        </div>
                        <div class="col-sm-4">
                            <label for="cost_of_assistance" class="control-label">Cost of Assistance:</label>
                            <input readonly id="cost_of_assistance" name="cost_of_assistance" placeholder="Cost of Assistance" type="text"  class="form-control"   required autofocus/>
                            <span class="text-danger"><?php echo form_error('cost_of_assistance'); ?></span>
                            <label>(number of days x number of beneficiaries x daily payment)</label>
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