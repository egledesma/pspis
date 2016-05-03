<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$region_code = $this->session->userdata('uregion');
?>
<script type="text/javascript">
    document.onreadystatechange=function(){
        get_prov();
        recalculateSum();

    }
    $(document).ready(function() {
        //this calculates values automatically
        sum();
        $("#lgu_amount_prov, #amount_requested").on("keydown keyup", function() {
            sum();
        });
    });


    function sum() {
        var txt1 = document.getElementById('lgu_amount_prov').value;
        var txt2 = document.getElementById('amount_requested').value;
        var txt3 = document.getElementById('lgu_amount_muni').value;
        var txt4 = document.getElementById('lgu_amount_brgy').value;
        var result = parseInt(txt1) + parseInt(txt2);
        if (!isNaN(result)) {
            document.getElementById('project_cost').value = result;
        }
    }

    function get_maxmin() {
        var nature_id1 = $('#natureofworklist').val();
        if(nature_id1 > 0) {
            $.ajax({
                url: "<?php echo base_url('communities/populate_naturemaxmin'); ?>",
                async: false,
                type: "POST",
                data: "nature_id="+nature_id1,
                dataType: "html",
                success: function(data,data1) {
                    $('#nature_maxmin').html(data);
                    $('#amount_requested').html(data1);
                                   }
            });
        }
    }
    function get_brgy_name() {
        var brgy_code =  $('#brgylist').val();
        if(brgy_code > 0) {
            $.ajax({
                url: "<?php echo base_url('communities/populate_brgy_name'); ?>",
                async: false,
                type: "POST",
                data: "brgy_code="+brgy_code,
                dataType: "html",
                success: function(data1) {
                    $('#brgyID').html(data1);
                    var brgy_name = $('#lgucounterpart_brgy_name').val();
                    $('#lgucounterpart_brgy_code').val(brgy_code);
                    $('#lgucounterpart_brgy').val(brgy_name);
                }
            });
        }
    }


    function get_natureofwork() {
        var assistance_id = $('#assistancelist').val();

        if(assistance_id > 0) {
            $.ajax({
                url: "<?php echo base_url('communities/populate_natureofwork'); ?>",
                async: false,
                type: "POST",
                data: "assistance_id="+assistance_id,
                dataType: "html",
                success: function(data) {
                    $('#natureofworkID').html(data);
                }
            });
        } else {
            $('#natureofworklist option:gt(0)').remove().end();
        }
    }
    function get_prov() {
        var region_code = $('#regionlist').val();

        $('#munilist option:gt(0)').remove().end();
        $('#brgylist option:gt(0)').remove().end();
        if(region_code > 0) {
            $.ajax({
                url: "<?php echo base_url('communities/populate_prov'); ?>",
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
                url: "<?php echo base_url('communities/populate_muni'); ?>",
                async: false,
                type: "POST",
                data: "prov_code="+prov_code,
                dataType: "html",
                success: function(data) {
                    $('#muniID').html(data);
                    var prov_name = $('#lgucounterpart_prov_name').val();
                    $('#lgucounterpart_prov_code').val(prov_code);
                    $('#lgucounterpart_prov').val(prov_name);

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
                url: "<?php echo base_url('communities/populate_brgy'); ?>",
                async: false,
                type: "POST",
                data: "city_code="+city_code,
                dataType: "html",
                success: function(data) {
                    $('#brgyID').html(data);
                    var city_name = $('#lgucounterpart_muni_name').val();
                    $('#lgucounterpart_muni_code').val(city_code);
                    $('#lgucounterpart_muni').val(city_name);
                }
            });
        } else {
            $('#brgylist option:gt(0)').remove().end();
        }
    }

    $(document).ready(function() {
        //this calculates values automatically
        sum();
        $("#amount_requested, #maxmin_nature").on("keydown keyup", function() {
            sum();
        });
    });

    function sum() {
        var amount_requested = document.getElementById('amount_requested').value;
        var maxmin_nature = document.getElementById('maxmin_nature').value;
        var result = parseInt(amount_requested) + parseInt(maxmin_nature);
        if (!isNaN(result)) {
            document.getElementById('total_amount').value = result;
        }
    }

    function recalculateSum()
    {
        var num1 = parseInt(document.getElementById("amount_requested").value);
        var num2 = parseInt(document.getElementById("lgu_amount_prov").value);
        var num3 = parseInt(document.getElementById("lgu_amount_muni").value);
        var num4 = parseInt(document.getElementById("lgu_amount_brgy").value);
        document.getElementById("project_cost").value = num1 + num2 + num3 + num4;

    }

</script>


<div class="page ">

    <div class="page-header page-header-bordered">

        <h1 class="page-title">Add </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboardc/dashboard/'.$region_code.'') ?>">Dashboard</a></li>
            <li><a href="<?php echo base_url('communities/index/'.$region_code.'') ?>">Communities</a></li>
            <li class="active">Add</li>
        </ol>
    </div>

    <div class="page-content">
        <div class="panel">
            <header class="panel-heading">
                <div class="panel-heading">
                    <h3 class="panel-title">Add New Project</h3>
                </div>
            </header>
            <div class="panel-body">

                <?php
                $attributes = array("class" => "form-horizontal", "id" => "projectformadd", "name" => "projectformadd");
                //input here the next location when click insert

                echo form_open("communities/addCommunities", $attributes);?>
                <input class="form-control"  type="hidden" name="myid" value="<?php echo $this->session->userdata('uid')?>">
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label class="control-label" for="assistancelist">Type of Assistance:</label>
                        <select name="assistancelist" id="assistancelist" class="form-control" onChange="get_natureofwork();" required="required" autofocus>
                            <option value="">Choose Assistance</option>
                            <?php foreach($assistancelist as $assistanceselect): ?>
                                <option value="<?php echo $assistanceselect->assistance_id; ?>"
                                    <?php if(isset($_SESSION['assistance'])) {
                                        if($assistanceselect->assistance_id == $_SESSION['assistance']) {
                                            echo " selected";
                                        }
                                    } ?>
                                >
                                    <?php echo $assistanceselect->assistance_name; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                </div>

                <div class="form-group row">
                    <div id="project_title" class="col-sm-6">
                    <label for="project_title" class="control-label">Project Title:</label>
                    <input id="project_title" name="project_title" placeholder="Project Title" type="text"  class="form-control"  value="<?php echo set_value('project_title'); ?>" required/>
                    <span class="text-danger"><?php echo form_error('project_title'); ?></span>
                    </div>

                </div>

                <label  class="control-label">Project Location:</label>
                <input id = "region_pass" name ="region_pass" type = "hidden" value = "<?php echo $region_code;?>">
                <div class="form-group row">
                    <div id="regionID" class="col-sm-3">
                        <label for="regionlist" class="control-label">Region :</label>
                        <select  name="regionlist" id="regionlist" class="form-control" onChange="get_prov();"  disabled >
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
                        <label for="brgylist" class="control-label">Barangay :</label>
                        <div id="brgyID">
                            <select required id="brgylist" name="brgylist" class="form-control" onChange="get_brgy_name();" required>
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
                        <label for="number_bene" class="control-label">Number of Beneficiaries:</label>
                        <input id="number_bene" name="number_bene" placeholder="Number of Beneficiaries" type="number" min="0"  class="form-control"  value="<?php echo set_value('number_bene'); ?>" required autofocus/>
                        <span class="text-danger"><?php echo form_error('number_bene'); ?></span>
                    </div>

                </div>

                <div class="form-group row">
                    <div class="col-sm-4">
                        <label class="control-label" for="natureofworklist">Nature of Work:</label>
                        <div id="natureofworkID">
                            <select required id="natureofworklist" name="natureofworklist" class="form-control" onChange="get_maxmin();" required="required">
                                <?php if(isset($_SESSION['natureofwork']) or isset($_SESSION['assistance'])) {
                                    ?>
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
                                } else {
                                    ?>
                                    <option value="">Select Assistance First</option>
                                    <?php
                                } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-4">

                        <div id = "nature_maxmin">
                            <div id = "amount_requested">
                                <label for="amount_requested" class="control-label">Amount Requested:</label>
                                <input type = "number" id="amount_requested"  name ="amount_requested" class = "form-control" onchange="recalculateSum();" value = "0">
                            </div>

                            </div>
                    </div>

                    <div class="col-sm-4">
                        <label for="fundsourcelist" class="control-label">Fund Source:</label>
                        <select name="fundsourcelist" id="fundsourcelist" class="form-control">
                            <option value="">Choose Fund Source</option>
                            <?php foreach($fundsourcelist as $fundsourceselect): ?>
                                <option value="<?php echo $fundsourceselect->fundsource_id; ?>">
                                    <?php echo $fundsourceselect->fund_source; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>


                </div>

                <label  class="control-label">LGU counterparts:</label>
                <div class="form-group row">

                    <div name = "counter_prov" id = "counter_prov" class="col-sm-4">
                        <label for="lgucounterpart_prov" class="control-label">Province:</label>
                        <input id="lgucounterpart_prov_code" name="lgucounterpart_prov_code" placeholder="LGU counterpart Province" type="hidden"  class="form-control"  value="<?php echo set_value('lgucounterpart_prov_code'); ?>" required autofocus/>
                        <input id="lgucounterpart_prov" name="lgucounterpart_prov" placeholder="LGU counterpart Province" type="text"  class="form-control"  value="<?php echo set_value('lgucounterpart_prov'); ?>" disabled/>
                        <span class="text-danger"><?php echo form_error('lgucounterpart_prov'); ?></span>
                    </div>

                    <div class="col-sm-4">
                        <label for="lgu_amount_prov" class="control-label">LGU amount province:</label>
                        <input onblur="recalculateSum();" id="lgu_amount_prov" name="lgu_amount_prov"  placeholder="LGU amount province" type="number"  class="form-control"  value="0" required autofocus/>
                        <span class="text-danger"><?php echo form_error('lgu_amount_prov'); ?></span>
                    </div>

                    <div class="col-sm-4">
                        <label for="lgu_fundsource" class="control-label">LGU fundsource:</label>
                        <input id="lgu_fundsource" name="lgu_fundsource" placeholder="LGU fund source" type="text"  class="form-control"  value="<?php echo set_value('lgu_fundsource'); ?>" required autofocus/>
                        <span class="text-danger"><?php echo form_error('lgu_fundsource'); ?></span>
                    </div>

                </div>
                <div class="form-group row">

                    <div name = "counter_muni" id = "counter_muni" class="col-sm-4">
                        <label for="lgucounterpart_muni" class="control-label">City/Municipality:</label>
                        <input id="lgucounterpart_muni_code" name="lgucounterpart_muni_code" placeholder="LGU counterpart City/Municipality" type="hidden"  class="form-control"  value="<?php echo set_value('lgucounterpart_muni_code'); ?>" required autofocus/>
                        <input id="lgucounterpart_muni" name="lgucounterpart_muni" placeholder="LGU counterpart City/Municipality" type="text"  class="form-control"  value="<?php echo set_value('lgucounterpart_muni'); ?>" disabled/>
                        <span class="text-danger"><?php echo form_error('lgucounterpart_muni'); ?></span>
                    </div>

                    <div class="col-sm-4">
                        <label for="lgu_amount_muni" class="control-label">LGU amount City/Municipality:</label>
                        <input onblur="recalculateSum();" id="lgu_amount_muni" name="lgu_amount_muni"  placeholder="LGU amount City/Municipality:" type="number"  class="form-control"  value="0" required autofocus/>
                        <span class="text-danger"><?php echo form_error('lgu_amount_muni'); ?></span>
                    </div>

                </div>

                <div class="form-group row">

                    <div name = "counter_brgy" id = "counter_brgy" class="col-sm-4">

                        <label for="lgucounterpart_brgy" class="control-label">Barangay:</label>
                        <input id="lgucounterpart_brgy_code" name="lgucounterpart_brgy_code" placeholder="LGU counterpart Barangay" type="hidden"  class="form-control"  value="<?php echo set_value('lgucounterpart_brgy_code'); ?>" required autofocus/>
                        <input id="lgucounterpart_brgy" name="lgucounterpart_brgy" placeholder="LGU counterpart Barangay" type="text"  class="form-control"  value="<?php echo set_value('lgucounterpart_brgy'); ?>" disabled/>
                        <span class="text-danger"><?php echo form_error('lgucounterpart_brgy'); ?></span>

                    </div>

                    <div class="col-sm-4">
                        <label for="lgu_amount_brgy" class="control-label">LGU amount Barangay:</label>
                        <input onblur="recalculateSum();" id="lgu_amount_brgy" name="lgu_amount_brgy"  placeholder="LGU amount Barangay:" type="number"  class="form-control"  value="0" required autofocus/>
                        <span class="text-danger"><?php echo form_error('lgu_amount_brgy'); ?></span>
                    </div>



                </div>

                <div class="form-group row">
                    <div class="col-sm-4">
                        <label for="project_cost" class="control-label">Project Cost:</label>
                        <input id="project_cost" name="project_cost" placeholder="Project Cost" type="number"  class="form-control"  value="<?php echo set_value('project_cost'); ?>" required autofocus/>
                        <span class="text-danger"><?php echo form_error('project_cost'); ?></span>
                    </div>

                    <div class="col-sm-4">
                        <label for="implementing_agency" class="control-label">Implementing Agency:</label>
                        <select name="implementing_agency" id="implementing_agency" class="form-control">
                            <option value="">Choose Implementing Agency</option>
                            <?php foreach($fundsourcelist as $fundsourceselect): ?>
                                <option value="<?php echo $fundsourceselect->fundsource_id; ?>">
                                    <?php echo $fundsourceselect->fund_source; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-sm-4">
                        <label for="status" class="control-label">Status:</label>
                        <input id="status" name="status" placeholder="Status" type="text"  class="form-control"  value="<?php echo set_value('status'); ?>" required autofocus/>
                        <span class="text-danger"><?php echo form_error('status'); ?></span>
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