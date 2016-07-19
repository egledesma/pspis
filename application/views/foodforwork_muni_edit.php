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
        var numBenechecker = parseInt($('#number_bene_checker').val());
        if(numBene == 0){
            alert('No Beneficiaries')
            return false;
        }
        else if (numBene > numBenechecker)
        {
            alert("The number of bene allowable is only "+numBenechecker)
            return false;
        }
        else
        {
            window.parent.successIframe();
        }

    }
    function get_muni() {
        var prov_code = $('#prov_pass').val();
        var cityCode = $('#city_pass').val();
        $('#brgylist option:gt(0)').remove().end();
        if(prov_code > 0) {
            $.ajax({
                url: "<?php echo base_url('foodforwork/populate_muni_edit/'.$proj_prov->foodforwork_id.'/'.$proj_prov->city_code.''); ?>",
                async: false,
                type: "POST",
                data:"prov_code="+prov_code,
                dataType: "html",
                success: function(data) {
                    $('#muniID').html(data);
                    $('#munilist').val(cityCode);
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

<!--    <div class="page-content">-->
<!--        <div class="panel">-->
            <header class="panel-heading">
                <div class="panel-heading">
                    <table class = "table">
                        <h3 class="panel-title">
                            <tr>
                                <td>
                                    Edit City/Municipality
                                </td>
                                <td>
                                    <button type="submit" onclick = "javascript: window.parent.closeIframe();" id="btn_exit" name="btn_exit" class="btn btn-outline btn-danger " data-toggle="tooltip"
                                            data-placement="top" data-original-title="Exit">Exit</button>
                                </td>
                            </tr>
                        </h3>
                    </table>
                </div>
            </header>
<!--            <div class="panel-body">-->

                <?php
                $attributes = array("class" => "form-horizontal", "id" => "foodmuniformedit", "name" => "foodmuniformedit");
                //input here the next location when click insert

                echo form_open("foodforwork/updatefoodforwork_muni", $attributes);?>

                <input class="form-control"  type="hidden" name="myid" value="<?php echo $this->session->userdata('uid')?>">

                <input class="form-control" id = "prov_pass" name ="prov_pass" type = "hidden" value = "<?php echo $proj_prov->prov_code;?>" >
                <input class="form-control" id = "food_muni_id" name ="food_muni_id" type = "hidden" value = "<?php echo $proj_prov->food_muni_id;?>" >
                <input class="form-control" id = "foodforwork_id" name ="foodforwork_id" type = "hidden" value = "<?php echo $proj_prov->foodforwork_id;?>" >
                <input class="form-control" type="hidden" id = "city_pass" name="city_pass" value ="<?php echo $proj_prov->city_code ?>" >
<!--                <input class="form-control" id = "foodforworkpass_id" name ="foodforworkpass_id" type = "hidden" value = "--><?php //echo $foodforworkpass_id;?><!--" >-->
                <!--                <input class="form-control" id = "region_pass" name ="region_pass" type = "hidden" value = "--><?php //echo $region_pass;?><!--" >-->

                <table class = "table">
                    <tr>
                        <th>Municipality:</th>
                        <th>Number of Beneficiaries in City/Municipality:</th>
                        <th>Cost of Assistance:</th>
                    </tr>
                    <tr>
                        <td>
                            <div class="col-lg-8">
                                <div id="muniID">
                                    <select  id="munilist" name="munilist" class="form-control" required required="required" autofocus>
                                        <?php if(isset($proj_prov->city_code)) {
                                            ?>
                                            <option value="">Choose Municipality</option>
                                            <?php
                                            foreach ($munilist as $muniselect) { ?>
                                                <option value="<?php echo $muniselect->city_code; ?>"
                                                    <?php
                                                    if ($muniselect->city_code == $proj_prov->city_code) {
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

                        </td>
                        <td>
                            <div class="col-lg-6">
                                <input id="number_bene" name="number_bene" placeholder="Number of Beneficiaries" type="number" min="0"  class="form-control" max = "<?php echo $title->number_of_bene - $countBene->totalbene + $proj_prov->no_of_bene_muni ;?>"  value="<?php echo $proj_prov->no_of_bene_muni; ?>" required autofocus onchange = "recalculateMultiply();"/>
                                <span class="text-danger"><?php echo form_error('number_bene'); ?></span>
                                <input id ="number_bene_checker" type = "hidden" value = "<?php echo $title->number_of_bene - $countBene->totalbene + $proj_prov->no_of_bene_muni; ?>">
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
                <div class="form-group row">

                <div class="form-group row">
                    <div class="col-sm-4">
                        <input id="daily_payment" name="daily_payment" placeholder="Daily Payment Amount" type="hidden"  class="form-control"  value="<?php echo $proj_prov->daily_payment; ?>"required onblur = "recalculateMultiply();"disabled/>

                    </div>
                    <div class="col-sm-4">
                        <input id="number_days_hidden" name="number_days_hidden" placeholder="Number of Days" type="hidden" min="0"  class="form-control"  value="<?php echo $proj_prov->no_of_days; ?>" />
                        <input id="daily_payment" name="daily_payment" placeholder="daily payment" type="hidden" min="0"  class="form-control"  value="<?php echo $proj_prov->daily_payment; ?>" />
                    </div>

                </div>


                <div class="site-action">
                    <button  onclick = "return checkValidate();"  type="submit"  id="btn_edit" name="btn_edit" class="btn btn-floating btn-success btn-lg btn-outline" data-toggle="tooltip"
                             data-placement="top" data-original-title="Save">
                        <i class="front-icon fa-save animation-scale-up" aria-hidden="true"></i>
                    </button>

                </div>
                <?php echo form_close(); ?>
<!---->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->