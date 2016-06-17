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
        if(city_code > 0) {
            $.ajax({
                url: "<?php echo base_url('cashforwork/populate_brgy/'.$proj_prov->cashforwork_id.''); ?>",
                async: false,
                type: "POST",
                data: "city_code="+city_code,
                dataType: "html",
                success: function(data) {
                    $('#brgyID').html(data);
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


<!--<div class="page ">-->

<!--    <div class="page-header page-header-bordered">-->
<!---->
<!--        <h1 class="page-title">Add </h1>-->
<!--        <ol class="breadcrumb">-->
<!--            <li><a href="--><?php //echo base_url('dashboardc/dashboard') ?><!--">Dashboard</a></li>-->
<!--            <li><a href="--><?php //echo base_url('cashforwork/viewCash_brgy/'.$proj_prov->cash_muni_id.'') ?><!--">Barangay</a></li>-->
<!--            <li class="active">Add Barangay</li>-->
<!--        </ol>-->
<!--    </div>-->

<!--    <div class="page-content">-->
<!--        <div class="panel">-->

                <div class="panel-heading">
                    <table class = "table">
                        <h3 class="panel-title">
                        <tr>
                            <td>
                                Municipality: <?php echo $proj_prov->city_name;?>
                            </td>
                            <td>
                                <button type="submit" onclick = "javascript: window.parent.closeIframe();" id="btn_exit" name="btn_exit" class="btn btn-outline btn-danger " data-toggle="tooltip"
                                        data-placement="top" data-original-title="Exit">Exit</button>
                            </td>
                        </tr>
                        </h3>
                    </table>
                </div>


                <?php
                $attributes = array("class" => "form-horizontal", "id" => "cashbrgyformadd", "name" => "cashbrgyformadd");
                //input here the next location when click insert

                echo form_open("cashforwork/addCash_brgy", $attributes);?>

                <table class ="table">
                    <tr>
                        <th>Barangay:</th>
                        <th>Number of Beneficiaries in Barangay:</th>
                        <th>Cost of Assistance:</th>
                    </tr>
                    <tr>
                        <td>
                                <div class="col-lg-8" id="brgyID">
                                    <select  id="brgylist" name="brgylist" class="form-control" required required="required" autofocus>
                                        <?php if(isset($_SESSION['brgy']) or isset($_SESSION['muni'])) {
                                            ?>
                                            <option value="">Choose Barangay</option>
                                            <?php
                                            foreach ($brgylist as $brgyselect) { ?>
                                                <option value="<?php echo $brgyselect->brgy_code; ?>"
                                                    <?php
                                                    if (isset($_SESSION['brgy']) and $brgyselect->brgy_code== $_SESSION['brgy']) {
                                                        echo " selected";
                                                    } ?>
                                                >
                                                    <?php echo $brgyselect->brgy_name; ?></option>
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <option value="">Select Municipality First</option>
                                            <?php
                                        } ?>
                                    </select>
                                </div>
                        </td>
                        <td>
                            <div class="col-lg-3">
                                <input id="number_bene" name="number_bene" placeholder="Number of Beneficiaries"  style="width: 7em" type="number" min="0" max="<?php echo $proj_prov->no_of_bene_muni - $countBene->totalbene?>" class="form-control"  value="<?php echo set_value('number_bene'); ?>" required autofocus onchange = "recalculateMultiply();"/>
                                <span class="text-danger"><?php echo form_error('number_bene'); ?></span>
                            </div>
                        </td>
                        <td>
                            <div class="col-lg-6">
                                <input readonly id="cost_of_assistance" name="cost_of_assistance" placeholder="Cost of Assistance" type="number"  class="form-control"   required autofocus/>
                                <span class="text-danger"><?php echo form_error('cost_of_assistance'); ?></span>
                                <label>(number of days x number of beneficiaries x daily payment)</label>
                            </div>
                        </td>
                    </tr>

                </table>

                <input class="form-control"  type="hidden" name="myid" value="<?php echo $this->session->userdata('uid')?>">
                <input class="form-control" id = "muni_pass" name ="muni_pass" type = "hidden" value = "<?php echo $proj_prov->city_code;?>">
                <input class="form-control" id = "cashforwork_id_pass" name ="cashforwork_id_pass" type = "hidden" value = "<?php echo $proj_prov->cashforwork_id;?>">
                <input class="form-control" id = "cash_muni_id_pass" name ="cash_muni_id_pass" type = "hidden" value = "<?php echo $proj_prov->cash_muni_id;?>">

                <div class="form-group row">
                        <input id="daily_payment" name="daily_payment" placeholder="Daily Payment Amount" type="hidden"  class="form-control"  value="<?php echo $proj_prov->daily_payment; ?>"required onblur = "recalculateMultiply();"disabled/>
                        <span class="text-danger"><?php echo form_error('daily_payment'); ?></span>
<!--                        <label for="number_days" class="control-label">Number of Days:</label>-->
                        <input id="number_days_hidden" name="number_days_hidden" placeholder="Number of Days" type="hidden" min="0"  class="form-control"  value="<?php echo $proj_prov->no_of_days; ?>" />
                        <input id="daily_payment" name="daily_payment" placeholder="daily payment" type="hidden" min="0"  class="form-control"  value="<?php echo $proj_prov->daily_payment; ?>" />
<!--                        <input id="number_days" name="number_days" placeholder="Number of Days" type="number" min="0"  class="form-control"  value="--><?php //echo $proj_prov->no_of_days; ?><!--" disabled/>-->
<!--                        <span class="text-danger">--><?php //echo form_error('number_days'); ?><!--</span>-->
                </div>
                <div class="site-action">
                    <button type="submit" onclick = "return checkValidate();" id="btn_add" name="btn_add" class="btn btn-floating btn-success btn-lg btn-outline" data-toggle="tooltip"
                             data-placement="top" data-original-title="Save">
                        <i class="front-icon fa-save animation-scale-up" aria-hidden="true"></i>
                    </button>
                </div>
<!--                <a href="javascript: window.parent.closeIframe()">Test Hide</a> javascript: window.parent.closeIframe()-->
                <?php echo form_close(); ?>
