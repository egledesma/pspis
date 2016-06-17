<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$region_code = $this->session->userdata('uregion');

?>
<script type="text/javascript">

    document.onreadystatechange=function(){
        get_brgy();
        recalculateMultiply();
    }

    function checkValidate(){

        var numBene = parseInt($('#number_bene').val());
        if(numBene == 0){
            alert('No Beneficiaries')
            return false;
        }

    }

    function get_brgy() {
        var city_code = $('#muni_pass').val();
        var brgy_code = $('#brgy_pass').val();
        if(city_code > 0) {
            $.ajax({
                url: "<?php echo base_url('cashforwork/populate_brgy_edit/'.$proj_brgy->cashforwork_id.'/'.$proj_brgy->brgy_code.''); ?>",
                async: false,
                type: "POST",
                data: "city_code="+city_code,
                dataType: "html",
                success: function(data) {
                    $('#brgyID').html(data);
                    $('#brgylist').val(brgy_code);
                }
            });
        } else {
            $('#brgylist option:gt(0)').remove().end();
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



<!--    <div class="page-content">-->
<!--        <div class="panel">-->
            <header class="panel-heading">
                <div class="panel-heading">
                    <h3 class="panel-title">Edit Barangay</h3>
                </div>
            </header>
<!--            <div class="panel-body">-->
<!--<pre>-->
<!--    --><?php //print_r($proj_brgy)?>
<!--</pre>-->
                <?php
                $attributes = array("class" => "form-horizontal", "id" => "cashbrgyformedit", "name" => "cashbrgyformedit");
                //input here the next location when click insert

                echo form_open("cashforwork/updateCashforwork_brgy", $attributes);?>

                <table class = "table">
                    <tr>
                        <th>Barangay:</th>
                        <th>Number of Beneficiaries in Barangay:</th>
                        <th>Cost of Assistance:</th>
                    </tr>
                    <tr>
                        <td>
                            <div class="col-lg-8">
                                <div id="brgyID">
                                    <select  id="brgylist" name="brgylist" class="form-control" required required="required" autofocus>
                                        <?php if(isset($proj_brgy->brgy_code)) {
                                            ?>
                                            <option value="">Choose Barangay</option>
                                            <?php
                                            foreach ($brgylist as $brgyselect) { ?>
                                                <option value="<?php echo $brgyselect->brgy_code; ?>"
                                                    <?php
                                                    if ($brgyselect->city_code == $proj_brgy->brgy_code) {
                                                        echo " selected";
                                                    } ?>
                                                >
                                                    <?php echo $brgyselect->city_name; ?></option>
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <option value="">Select Municipality First</option>
                                            <?php
                                        } ?>
                                    </select>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="col-lg-6">
                                <input id="number_bene" name="number_bene" placeholder="Number of Beneficiaries" type="number" min="0"  class="form-control" max="<?php echo $proj_prov->no_of_bene_muni - $countBene->totalbene + $proj_brgy->no_of_bene_brgy?>"  value="<?php echo $proj_brgy->no_of_bene_brgy; ?>"required autofocus onchange = "recalculateMultiply();"/>
                                <span class="text-danger"><?php echo form_error('number_bene'); ?></span>
                            </div>
                        </td>
                        <td>
                            <div class="col-lg-6">
                                <input readonly id="cost_of_assistance" name="cost_of_assistance" placeholder="Cost of Assistance" type="text"  class="form-control"   required autofocus/>
                                <span class="text-danger"><?php echo form_error('cost_of_assistance'); ?></span>
                                <label>(number of days x number of beneficiaries x daily payment)</label>
                            </div>
                        </td>
                    </tr>
                </table>
                <input class="form-control"  type="hidden" name="myid" value="<?php echo $this->session->userdata('uid')?>">
                <input class="form-control" id = "muni_pass" name ="muni_pass" type = "hidden" value = "<?php echo $proj_brgy->city_code;?>">
                <input class="form-control" id = "brgy_pass" name ="brgy_pass" type = "hidden" value = "<?php echo $proj_brgy->brgy_code;?>">
<!--                <input class="form-control" id = "cashforwork" name ="cashforwork" type = "text" value = "--><?php //echo $proj_brgy->cashforwork_id;?><!--">-->
<!--                <input class="form-control" id = "cashforwork_id_pass" name ="cashforwork_id_pass" type = "text" value = "--><?php //echo $proj_brgy->cashforwork_id;?><!--">-->
                <input class="form-control" id = "cash_muni_id_pass" name ="cash_muni_id_pass" type = "hidden" value = "<?php echo $proj_brgy->cashforwork_muni_id;?>">
                <input class="form-control" id = "cash_brgy_id_pass" name ="cash_brgy_id_pass" type = "hidden" value = "<?php echo $proj_brgy->cash_brgy_id;?>">

                <div class="form-group row">
                    <div class="col-sm-4">
                        <input id="daily_payment" name="daily_payment" placeholder="Daily Payment Amount" type="hidden"  class="form-control"  value="<?php echo $proj_brgy->daily_payment; ?>"required onblur = "recalculateMultiply();"disabled/>
                    </div>
                    <div class="col-sm-4">
                        <input id="number_days_hidden" name="number_days_hidden" placeholder="Number of Days" type="hidden" min="0"  class="form-control"  value="<?php echo $proj_brgy->no_of_days; ?>" />
                        <input id="daily_payment" name="daily_payment" placeholder="daily payment" type="hidden" min="0"  class="form-control"  value="<?php echo $proj_brgy->daily_payment; ?>" />
                    </div>

                </div>


                <div class="site-action">
                    <button onclick = "return checkValidate();"  type="submit"  id="btn_add" name="btn_add" class="btn btn-floating btn-success btn-lg btn-outline" data-toggle="tooltip"
                             data-placement="top" data-original-title="Save">
                        <i class="front-icon fa-save animation-scale-up" aria-hidden="true"></i>
                    </button>

                </div>
                <?php echo form_close(); ?>

