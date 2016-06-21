<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$region_code = $this->session->userdata('uregion');
?>
<script type="text/javascript">
    document.onreadystatechange=function(){
        get_prov();
    }
    function checkValidate(){
        var saroBal = parseInt($('#saro_amount').val());
        var amountReq = parseInt($('#cost_of_assistance').val());
        if(saroBal < amountReq){
            alert('Insufficient Funds')
            return false;
        }
    }
    function get_saro_balance()
    {

        var saro_id = $('#sarolist').val();

        if(saro_id > 0){
//            alert(saro_id);
            $.ajax({
                url: "<?php echo base_url('cashforwork/populate_saro_amount'); ?>",
                async: false,
                type: "POST",
                data: "saro_id="+saro_id,
                dataType: "html",
                success: function(data) {
                    $('#saronumber').html(data);
                }
            });
        }
    }

    function get_saro_list()
    {
        var fundsource_id = $('#fundsource').val();

        if(fundsource_id > 0){
            alert(fundsource_id);
            $.ajax({
                url: "<?php echo base_url('cashforwork/populate_saa_list'); ?>",
                async: false,
                type: "POST",
                data: "fundsource_id="+fundsource_id,
                dataType: "html",
                success: function(data) {
                    $('#saa_name').html(data);
                }
            });
        }
    }
    function get_prov() {
        var region_code = $('#regionlist').val();

        $('#munilist option:gt(0)').remove().end();
        $('#brgylist option:gt(0)').remove().end();
        if(region_code > 0) {
            $.ajax({
                url: "<?php echo base_url('cashforwork/populate_prov'); ?>",
                async: false,
                type: "POST",
                data: "region_code="+region_code,
                dataType: "html",
                success: function(data) {
                    $('#provinceID').html(data);
                }
            });
        } else {
            $('#provlist option:gt(0)').remove().end();
        }
    }
    function get_muni() {
        var prov_code = $('#provlist').val();
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
    function get_brgy() {
        var city_code = $('#munilist').val();
        if(city_code > 0) {
            $.ajax({
                url: "<?php echo base_url('cashforwork/populate_brgy'); ?>",
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
        var num1 = parseInt(document.getElementById("number_of_bene").value);
        var num2 = parseInt(document.getElementById("number_days").value);
        var num3 = parseInt(document.getElementById("daily_payment").value);
        document.getElementById("cost_of_assistance").value = num1 * num2 * num3 ;

    }

</script>


 <div class="page ">

    <div class="page-header page-header-bordered">

        <h1 class="page-title">Add </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboardc/dashboard') ?>">Dashboard</a></li>
            <li><a href="<?php echo base_url('cashforwork/index/') ?>">Cash for work</a></li>
            <li class="active">Add</li>
        </ol>
    </div>

    <div class="page-content">
        <div class="panel">
            <header class="panel-heading">
                <div class="panel-heading">
                    <h3 class="panel-title">Add New Project(Cash for work)</h3>
                </div>
            </header>
            <div class="panel-body">

                <?php
                $attributes = array("class" => "form-horizontal", "id" => "projectformadd", "name" => "projectformadd");
                //input here the next location when click insert

                echo form_open("cashforwork/addCashforwork", $attributes);?>
<!--<pre>-->
<?php //print_r($fundlist)?>
<!--</pre>-->
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label class="control-label" for="fundsource">Fund Source:</label>
                        <select name="fundsource" id="fundsource" class="form-control"  onchange = "get_saro_list();"required="required"  autofocus>
                            <option value="">Choose Fund Source</option>
                            <?php foreach($fundlist as $fundselect): ?>
                                <option value="<?php echo $fundselect->fundsource_id; ?>"
                                >
                                    <?php echo $fundselect->fund_source; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                <div id = "saa_name" name = "saa_name"class="col-sm-6">
                    <label for="sarolist" class="control-label">SAA Number:</label>
                    <select id="sarolist" name="sarolist" class="form-control"  required>
                        <?php if(isset($_SESSION['province']) or isset($user_region)) {
                            ?>
                            <option value="">Choose Province</option>
                            <?php
                            foreach ($sarolist as $saroselect) { ?>
                                <option value="<?php echo $saroselect->saro_id; ?>"
                                    <?php
                                    if ($saroselect->saro_id) {
                                        echo " selected";
                                    } ?>
                                >
                                    <?php echo $saroselect->saro_number; ?></option>
                                <?php
                            }
                        } else {
                            ?>
                            <option value="">Select Fund Source First</option>
                            <?php
                        } ?>
                    </select>
                </div>
                </div>

<!--                <div class="form-group row">-->
<!--                    <div class="col-sm-6">-->
<!--                        <label class="control-label" for="sarolist">SAA Number:</label>-->
<!--                        <select name="sarolist" id="sarolist" class="form-control"  required="required" onchange="get_saro_balance();" autofocus>-->
<!--                            <option value="">Choose SAA Number</option>-->
<!--                            --><?php //foreach($sarolist as $saroselect): ?>
<!--                                <option value="--><?php //echo $saroselect->saro_id; ?><!--"-->
<!--                                    --><?php //if(isset($saro_id)) {
//                                        if($saroselect->saro_id == $saro_id) {
//                                            echo " selected";
//                                        }
//                                    } ?>
<!--                                >-->
<!--                                    --><?php //echo $saroselect->saro_number."  (₱  ".number_format($saroselect->saro_balance).")"; ?>
<!--                                </option>-->
<!--                            --><?php //endforeach; ?>
<!--                        </select>-->
<!--                    </div>-->
<!--                </div>-->
                <div name = "saronumber" id = "saronumber">

                </div>
                <div class="form-group row">
                    <div id="project_title" class="col-sm-6">
                        <label for="project_title" class="control-label">Project Title:</label>
                        <input pattern="[A-Za-z0-9 \\s ]*" title="Please input alphabet characters only!" id="project_title" name="project_title" placeholder="Project Title" type="text"  class="form-control"  value="<?php echo set_value('project_title'); ?>" required/>
                        <span class="text-danger"><?php echo form_error('project_title'); ?></span>
                    </div>
                </div>

                <input class="form-control"  type="hidden" name="myid" value="<?php echo $this->session->userdata('uid')?>">
                <label  class="control-label">Project Location:</label>
                <input id = "region_pass" name ="region_pass" type = "hidden" value = "<?php echo $region_code;?>">
                <div class="form-group row">
                    <div id="regionID" class="col-sm-3">
                        <label for="regionlist" class="control-label">Region :</label>
                        <select  name="regionlist" id="regionlist" class="form-control" onChange="get_prov();" disabled>
                            <option value="">Choose Region</option>
                            <?php foreach($regionlist as $regionselect): ?>
                                <option value="<?php echo $regionselect->region_code; ?>"
                                    <?php if(isset($region_code)) {
                                        if($regionselect->region_code == $region_code) {
                                            echo " selected";
                                        }
                                    } ?>
                                >
                                    <?php echo $regionselect->region_name; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-sm-3">
                        <label for="provlist" class="control-label">Province :</label>
                        <div id="provinceID">
                            <select id="provlist" name="provlist" class="form-control"  required>
                                <?php if(isset($_SESSION['province']) or isset($user_region)) {
                                    ?>
                                    <option value="">Choose Province</option>
                                    <?php
                                    foreach ($provlist as $provselect) { ?>
                                        <option value="<?php echo $provselect->prov_code; ?>"
                                            <?php
                                            if (isset($_SESSION['province']) and $provselect->prov_code== $_SESSION['province']) {
                                                echo " selected";
                                            } ?>
                                        >
                                            <?php echo $provselect->prov_name; ?></option>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <option value="">Select Region First</option>
                                    <?php
                                } ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-4">
                        <label class="control-label" for="natureofworklist">Nature of Work:</label>
                        <div id="natureofworkID">
                            <select required id="natureofworklist" name="natureofworklist" class="form-control">
                                    <option value="">Choose Nature of work</option>
                                    <?php
                                    foreach ($natureofworklist as $natureofworkselect) { ?>
                                        <option value="<?php echo $natureofworkselect->nature_id; ?>"
                                            <?php
                                            if (isset($_SESSION['natureofwork']) and $natureofworkselect->nature_id== $_SESSION['natureofwork']) {
                                                echo " selected";
                                            } ?>
                                        >
                                            <?php echo $natureofworkselect->work_nature; ?></option>
                                        <?php
                                    }
                                    ?>
                            </select>
                        </div>
                    </div>
                </div>

                    <div class="form-group row">
                        <div class="col-sm-4">
                            <label for="number_days" class="control-label">Number of Days:</label>
                            <input id="number_days" name="number_days" pattern = "[0-9]+" title="Please input number characters only!" placeholder="Number of Days" type="number" min="0"  class="form-control"  value="<?php echo set_value('number_days'); ?>" onblur="recalculateMultiply()" required autofocus/>
                            <span class="text-danger"><?php echo form_error('number_days'); ?></span>
                        </div>
                        <div class="col-sm-4">
                            <label for="daily_payment" class="control-label">Daily Payment Amount:</label>
                            <input id="daily_payment" name="daily_payment" placeholder="Daily Payment Amount" type="number"  min="0"  class="form-control"  value="<?php echo set_value('number_days'); ?>"  onblur = "recalculateMultiply();" required autofocus/>
                            <span class="text-danger"><?php echo form_error('daily_payment'); ?></span>
                        </div>
                        <div class="col-sm-4">
                            <label for="number_of_bene" class="control-label">Number of Beneficiaries:</label>
                            <input id="number_of_bene" name="number_of_bene" placeholder="Number of Beneficiaries" type="number"  min="0"  class="form-control"  value="<?php echo set_value('number_of_bene'); ?>"  onblur = "recalculateMultiply();" required autofocus/>
                            <span class="text-danger"><?php echo form_error('number_of_bene'); ?></span>
                        </div>
                        <div class="col-sm-4">
                            <label for="cost_of_assistance" class="control-label">Cost of Assistance:</label>
                            <input readonly id="cost_of_assistance" name="cost_of_assistance" placeholder="Cost of Assistance" type="text"  class="form-control"   required autofocus/>
                            <span class="text-danger"><?php echo form_error('cost_of_assistance'); ?></span>
                            <label>(number of days x number of beneficiaries x daily payment)</label>
                        </div>
                    </div>
                <div class="site-action">
                    <button  type="submit"  onclick = "return checkValidate();" id="btn_add" name="btn_add" class="btn btn-floating btn-danger btn-lg btn-outline" data-toggle="tooltip"
                             data-placement="top" data-original-title="Save">
                        <i class="front-icon fa-save animation-scale-up" aria-hidden="true"></i>
                    </button>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
        <div class="page-content">
            <div class="panel">
                <header class="panel-heading">
                    <div class="panel-heading">
                        <h3 class="panel-title">Add City/Municipality</h3>
                    </div>
                </header>
                <div class="panel-body">
            <div id="exampleTableAddToolbar" >
                <a class= "btn btn-outline btn-danger" ><i class="icon wb-plus" aria-hidden="true"></i> Add City/Municipality</a>
            </div><br>
            <table class="table table-hover table-bordered dataTable table-striped width-full" id="exampleTableSearch">
                <thead>
                <tr>
                    <th>Action</th>
                    <th>City/Municipality</th>
                    <th>Daily Payment</th>
                    <th>Number of Beneficiaries</th>
                    <th>Number of Days</th>
                    <th>Cost of Assistance</th>
                    <!-- <th>Status</th> -->
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Action</th>
                    <th>City/Municipality</th>
                    <th>Daily Payment</th>
                    <th>Number of Beneficiaries</th>
                    <th>Number of Days</th>
                    <th>Cost of Assistance</th>
                </tr>
                </tfoot>
                <tbody  data-plugin="scrollable" data-direction="horizontal">
                </tbody>
            </table>
        </div>
    </div>
</div>
