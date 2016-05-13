<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

?>
<script type="text/javascript">

    document.onreadystatechange=function(){
        get_prov();
        get_muni();
        get_brgy();

    }

    function get_natureofwork() {
        var assistance_id = $('#assistancelist').val();
        var natureofwork_id = <?php echo $foodforworkdata->nature_id; ?>

        if(assistance_id > 0) {
            $.ajax({
                url: "<?php echo base_url('foodforwork/populate_natureofwork'); ?>",
                async: false,
                type: "POST",
                data: "assistance_id="+assistance_id,
                dataType: "html",
                success: function(data) {
                    $('#natureofworkID').html(data);
                    $('#natureofworklist').val(natureofwork_id);
                }
            });
        } else {
            $('#natureofworklist option:gt(0)').remove().end();
        }
    }
    function get_prov() {
        var region_code = $('#regionlist').val();
        var provCode =  $('#prov_pass').val();
        $('#munilist option:gt(0)').remove().end();
        $('#brgylist option:gt(0)').remove().end();
        if(region_code > 0) {
            $.ajax({
                url: "<?php echo base_url('foodforwork/populate_prov'); ?>",
                async: false,
                type: "POST",
                data: "region_code="+region_code,
                dataType: "html",
                success: function(data) {
                    $('#provinceID').html(data);
                    $('#provlist').val(provCode);
                }
            });
        } else {
            $('#provlist option:gt(0)').remove().end();
        }
    }
    function get_muni() {
        var prov_code = $('#provlist').val();
        var cityCode = $('#city_pass').val();
        $('#brgylist option:gt(0)').remove().end();
        if(prov_code > 0) {
            $.ajax({
                url: "<?php echo base_url('foodforwork/populate_muni'); ?>",
                async: false,
                type: "POST",
                data: "prov_code="+prov_code,
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
    function get_brgy() {
        var city_code = $('#munilist').val();
        var brgy = $('#brgy_pass').val();
        if(city_code > 0) {
            $.ajax({
                url: "<?php echo base_url('foodforwork/populate_brgy'); ?>",
                async: false,
                type: "POST",
                data: "city_code="+city_code,
                dataType: "html",
                success: function(data) {
                    $('#brgyID').html(data);
                    $('#brgylist').val(brgy);
                }
            });
        } else {
            $('#brgylist option:gt(0)').remove().end();
        }
    }

</script>


<div class="page ">

    <div class="page-header page-header-bordered">

        <h1 class="page-title">Edit </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboardc/dashboard') ?>">Dashboard</a></li>
            <li><a href="<?php echo base_url('foodforwork/index') ?>">Food for work</a></li>
            <li class="active">Edit</li>
        </ol>
    </div>

    <div class="page-content">
        <div class="panel">
            <header class="panel-heading">
                <div class="panel-heading">
                    <h3 class="panel-title">Edit Project(Food for work)</h3>
                </div>
            </header>
            <div class="panel-body">

                <?php
                $attributes = array("class" => "form-horizontal", "id" => "projectformedit", "name" => "projectformedit");
                //input here the next location when click insert

                echo form_open("foodforwork/updatefoodforwork", $attributes);?>
                <!--<pre>-->
                <?php //print_r($natureofworklist)?>
                <!--</pre>-->
                <input class="form-control" type="hidden" id = "prov_pass" name="prov_pass" value ="<?php echo $foodforworkdata->prov_code ?>" >
                <input class="form-control" type="hidden" id = "city_pass" name="city_pass" value ="<?php echo $foodforworkdata->city_code ?>" >
                <input class="form-control" type="hidden" id = "brgy_pass" name="prov_pass" value ="<?php echo $foodforworkdata->brgy_code ?>" >
                <input type="hidden" id = "foodforwork_id" name = "foodforwork_id" value = "<?php echo $foodforworkdata->foodforwork_id ?>">
                <input class="form-control"  type="hidden" name="region_pass" value="<?php echo $foodforworkdata->region_code?>">
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label class="control-label" for="sarolist">Saro Number:</label>
                        <select name="sarolist" id="sarolist" class="form-control"  required="required" autofocus>
                            <option value="">Choose Saro Number</option>
                            <?php foreach($sarolist as $saroselect): ?>
                                <option value="<?php echo $saroselect->saro_id; ?>"
                                    <?php if(isset($foodforworkdata->saro_id)) {
                                        if($saroselect->saro_id == $foodforworkdata->saro_id) {
                                            echo " selected";
                                        }
                                    } ?>
                                >
                                    <?php echo $saroselect->saro_number; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div id="project_title" class="col-sm-6">
                        <label for="project_title" class="control-label">Project Title:</label>
                        <input id="project_title" name="project_title" placeholder="Project Title" type="text"  class="form-control"  value="<?php echo $foodforworkdata->project_title ?>" required/>
                        <span class="text-danger"><?php echo form_error('project_title'); ?></span>
                    </div>
                </div>
                <input class="form-control"  type="hidden" name="myid" value="<?php echo $this->session->userdata('uid')?>">
                <label  class="control-label">Project Location:</label>
                <div class="form-group row">
                    <div id="regionID" class="col-sm-3">
                        <label for="regionlist" class="control-label">Region :</label>
                        <select  name="regionlist" id="regionlist" class="form-control" onChange="get_prov();" disabled>
                            <option value="">Choose Region</option>
                            <?php foreach($regionlist as $regionselect): ?>
                                <option value="<?php echo $regionselect->region_code; ?>"
                                    <?php if(isset($foodforworkdata->region_code )) {
                                        if($regionselect->region_code == $foodforworkdata->region_code) {
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
                            <select required id="provlist" name="provlist" class="form-control" onChange="get_muni();" required>
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

                    <div class="col-sm-3">
                        <label for="munilist" class="control-label">Municipality :</label>
                        <div id="muniID">
                            <select required id="munilist" name="munilist" onchange="get_brgy();" class="form-control" required>
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

                    <div class="col-sm-3">
                        <label for="provlist" class="control-label">Barangay :</label>
                        <div id="brgyID">
                            <select required id="brgylist" name="brgylist" class="form-control" required>
                                <?php if(isset($_SESSION['brgy']) or isset($_SESSION['muni'])) {
                                    ?>
                                    <option value="">Choose Barangay</option>
                                    <?php
                                    foreach ($brgylist as $brgyselect) { ?>
                                        <option value="<?php echo $brgyselect->brgy_code; ?>"
                                            <?php
                                            if (isset($_SESSION['brgy']) and $brgyselect->brgy_code == $_SESSION['brgy']) {
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
                    </div>
                </div>


                <div class="form-group row">
                    <div class="col-sm-4">
                        <label class="control-label" for="natureofworklist">Nature of Work:</label>
                        <div id="natureofworkID">
                            <select required id="natureofworklist" name="natureofworklist" class="form-control" required="required">
                                <option value="">Choose Nature of work</option>
                                <?php
                                foreach ($natureofworklist as $natureofworkselect) { ?>
                                    <option value="<?php echo $natureofworkselect->nature_id; ?>"
                                        <?php
                                        if ($natureofworkselect->nature_id == $foodforworkdata->nature_id) {
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

                    <div class="form-group row">
                        <div class="col-sm-4">
                            <label for="number_bene" class="control-label">Number of Beneficiaries:</label>
                            <input id="number_bene" name="number_bene" placeholder="Number of Beneficiaries" type="number" min="0"  class="form-control"  value="<?php echo $foodforworkdata->no_of_bene ?>" required autofocus/>
                            <span class="text-danger"><?php echo form_error('number_bene'); ?></span>
                        </div>

                        <div class="col-sm-4">
                            <label for="number_days" class="control-label">Number of Days:</label>
                            <input id="number_days" name="number_days" placeholder="Number of Days" type="number" min="0"  class="form-control"  value="<?php echo $foodforworkdata->no_of_days ?>" required autofocus/>
                            <span class="text-danger"><?php echo form_error('number_days'); ?></span>
                        </div>
                        <div class="col-sm-4">
                            <label for="cost_of_assistance" class="control-label">Cost of Assistance:</label>
                            <input id="cost_of_assistance" name="cost_of_assistance" placeholder="Cost of Assistance" type="text"  class="form-control"  value="<?php echo $foodforworkdata->cost_of_assistance ?>" required autofocus/>
                            <span class="text-danger"><?php echo form_error('cost_of_assistance'); ?></span>
                        </div>

                    </div>



                    <div class="site-action">
                        <button  type="submit"  id="btn_add" name="btn_add" class="btn btn-floating btn-success btn-lg btn-outline" data-toggle="tooltip"
                                 data-placement="top" data-original-title="Update">
                            <i class="front-icon wb-pencil animation-scale-up" aria-hidden="true"></i>
                        </button>

                    </div>

                    <?php echo form_close(); ?>

                </div>
            </div>
        </div>
    </div>