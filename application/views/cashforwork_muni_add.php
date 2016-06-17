<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$region_code = $this->session->userdata('uregion');

?>
<script type="text/javascript">

    document.onreadystatechange=function(){
        get_muni();
        recalculateMultiply();
    }

    function checkValidate(){

        var numBene = parseInt($('#number_bene').val());
        if(numBene == 0){
            alert('No Beneficiaries')
            return false;
        }

    }
    function get_muni() {

        var prov_code = $('#prov_pass').val();
        $('#brgylist option:gt(0)').remove().end();
        if(prov_code > 0) {
            $.ajax({
                url: "<?php echo base_url('cashforwork/populate_muni/'."$cashforworkpass_id".''); ?>",
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


<!--<div class="page ">-->
<!---->
<!--    <div class="page-header page-header-bordered">-->
<!---->
<!--        <h1 class="page-title">Add </h1>-->
<!--        <ol class="breadcrumb">-->
<!--            <li><a href="--><?php //echo base_url('dashboardc/dashboard') ?><!--">Dashboard</a></li>-->
<!--            <li><a href="--><?php //echo base_url('cashforwork/viewCash_muni/'.$cashforworkpass_id.'') ?><!--">City/Municipality</a></li>-->
<!--            <li class="active">Add Municipality</li>-->
<!--        </ol>-->
<!--    </div>-->

<!--    <div class="page-content">-->
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

                <table class ="table">
                    <tr>
                        <th>Municipality:</th>
                        <th>Number of Beneficiaries in City/Municipality:</th>
                        <th>Cost of Assistance:</th>
                    </tr>
                    <tr>
                        <td>
                                <div id="muniID" class="col-lg-8">
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

                        </td>
                        <td>
                            <div class="col-lg-6">
                                <input id="number_bene" name="number_bene" placeholder="Number of Beneficiaries"  style="width: 7em" type="number" min="0" max = "<?php echo $title->number_of_bene - $countBene->totalbene;?>"  class="form-control"  value="<?php echo set_value('number_bene'); ?>" required autofocus onchange = "recalculateMultiply();"/>
                                <span class="text-danger"><?php echo form_error('number_bene'); ?></span>
                            </div>
                        </td>
                        <td>
                            <div class="col-lg-6">
                                <input readonly id="cost_of_assistance" name="cost_of_assistance"  placeholder="Cost of Assistance" type="number"  class="form-control" required autofocus/>
                                <span class="text-danger"><?php echo form_error('cost_of_assistance'); ?></span>
                                <label>(number of days x number of beneficiaries x daily payment)</label>
                            </div>
                        </td>
                    </tr>
<!--                        will check if needed-->
<!--                        <div class="col-sm-4">-->
<!--                            <label for="daily_payment" class="control-label">Daily Payment Amount:</label>-->
<!--                            <input id="daily_payment"` name="daily_payment" placeholder="Daily Payment Amount" type="hidden"  class="form-control"  value="--><?php //echo $title->daily_payment; ?><!--"required onblur = "recalculateMultiply();"disabled/>-->
<!--                            <span class="text-danger">--><?php //echo form_error('daily_payment'); ?><!--</span>-->
<!--                        </div>-->
<!--                        <div class="col-sm-4">-->
<!--                            <label for="number_days" class="control-label">Number of Days:</label>-->
                            <input id="number_days_hidden" name="number_days_hidden" placeholder="Number of Days" type="hidden" min="0"  class="form-control"  value="<?php echo $title->no_of_days; ?>" />
                            <input id="daily_payment" name="daily_payment" placeholder="daily payment" type="hidden" min="0"  class="form-control"  value="<?php echo $title->daily_payment; ?>" />
<!--                            <input id="number_days" name="number_days" placeholder="Number of Days" type="number" min="0"  class="form-control"  value="--><?php //echo $title->no_of_days; ?><!--" disabled/>-->
<!--                            <span class="text-danger">--><?php //echo form_error('number_days'); ?><!--</span>-->
<!--                        </div>-->

                </table>
                    <div class="site-action">
                        <button onclick = "return checkValidate();"  type="submit"  id="btn_add" name="btn_add" class="btn btn-floating btn-success btn-lg btn-outline" data-toggle="tooltip"
                                 data-placement="top" data-original-title="Save">
                            <i class="front-icon fa-save animation-scale-up" aria-hidden="true"></i>
                        </button>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
<!--        </div>-->
<!--    </div>-->