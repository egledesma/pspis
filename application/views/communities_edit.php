<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

?>
<script type="text/javascript">
    document.onreadystatechange=function(){
        get_prov();
        get_muni();
        get_brgy();
        get_natureofwork();
        get_maxmin();

    }
    function get_maxmin() {
        var nature_id = $('#natureofworklist').val();
        if(nature_id > 0) {
            $.ajax({
                url: "<?php echo base_url('communities/populate_naturemaxmin'); ?>",
                async: false,
                type: "POST",
                data: "nature_id="+nature_id,
                dataType: "html",
                success: function(data) {
                    $('#nature_maxmin').html(data);
                }
            });
        }
    }
    function get_natureofwork() {
        var assistance_id = $('#assistancelist').val();
        var natureofwork_id = <?php echo $projectdata->nature_id; ?>

        if(assistance_id > 0) {
            $.ajax({
                url: "<?php echo base_url('communities/populate_natureofwork'); ?>",
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
                url: "<?php echo base_url('communities/populate_prov'); ?>",
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
                url: "<?php echo base_url('communities/populate_muni'); ?>",
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
                url: "<?php echo base_url('communities/populate_brgy'); ?>",
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

        <h1 class="page-title">Assistance to Communities</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboardc/dashboard') ?>">Dashboard</a></li>
            <li class="active">Communities</li>
        </ol>
    </div>

    <div class="page-content">
        <div class="panel">
            <header class="panel-heading">
                <div class="panel-heading">
                    <h3 class="panel-title">Edit Project</h3>
                </div>
            </header>
            <div class="panel-body">



                <?php
                $attributes = array("class" => "form-horizontal", "id" => "projectformedit", "name" => "projectformedit");
                 echo form_open("communities/updateCommunities", $attributes);?>

                <div class="form-group row">
                    <div class="col-sm-6">
                        <label class="control-label" for="assistancelist">Type of Assistance:</label>
                        <select name="assistancelist" id="assistancelist" class="form-control" onChange="get_natureofwork();">
                            <option value="">Choose Assistance</option>
                            <?php foreach($assistancelist as $assistanceselect): ?>
                                <option value="<?php echo $assistanceselect->assistance_id; ?>"
                                    <?php if($projectdata->assistance_id) {
                                        if($assistanceselect->assistance_id == $projectdata->assistance_id) {
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
                        <input id="project_title" name="project_title" placeholder="Project Title" type="text"  class="form-control"  value="<?php echo $projectdata->project_title ?>" required />
                        <span class="text-danger"><?php echo form_error('project_title'); ?></span>
                    </div>

                </div>

                <label  class="control-label">Project Location:</label>
                <div class="form-group row">
                    <div id="regionID" class="col-sm-3">
                        <input class="form-control" type="hidden" id = "prov_pass" name="prov_pass" value ="<?php echo $projectdata->prov_code ?>" >
                        <input class="form-control" type="hidden" id = "city_pass" name="city_pass" value ="<?php echo $projectdata->city_code ?>" >
                        <input class="form-control" type="hidden" id = "brgy_pass" name="prov_pass" value ="<?php echo $projectdata->brgy_code ?>" >
                        <input type="hidden" id = "project_id" name = "project_id" value = "<?php echo $projectdata->project_id ?>">
                        <label for="regionlist" class="control-label">Region :</label>
                            <select  name="regionlist" id="regionlist" class="form-control" onChange="get_prov();">
                                <option value="">Choose Region</option>
                                <?php foreach($regionlist as $regionselect): ?>
                                    <option value="<?php echo $regionselect->region_code; ?>"
                                        <?php if(isset($projectdata->region_code)) {
                                            if($regionselect->region_code == $projectdata->region_code) {
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
                                <?php if(isset($projectdata->prov_code) or isset($projectdata->region_code)) {
                                    ?>
                                    <option value="">Choose Province</option>
                                    <?php
                                    foreach ($provlist as $provselect) { ?>
                                        <option value="<?php echo $provselect->prov_code; ?>"
                                            <?php
                                            if ($provselect->prov_code == $projectdata->prov_code) {
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
                                <?php if(isset($projectdata->city_code) or isset($projectdata->prov_code)) {
                                    ?>
                                    <option value="">Choose Municipality</option>
                                    <?php
                                    foreach ($munilist as $muniselect) { ?>
                                        <option value="<?php echo $muniselect->city_code; ?>"
                                            <?php
                                            if ($muniselect->city_code == $projectdata->city_code) {
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
                                <?php if(isset($projectdata->brgy_code) or isset($projectdata->city_code)) {
                                    ?>
                                    <option value="">Choose Barangay</option>
                                    <?php
                                    foreach ($brgylist as $brgyselect) { ?>
                                        <option value="<?php echo $brgyselect->brgy_code; ?>"
                                            <?php
                                            if ($brgyselect->brgy_code == $projectdata->brgy_code) {
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
                        <input id="number_bene" name="number_bene" placeholder="Number of Beneficiaries" type="number" min="0"  class="form-control"  value="" required autofocus/>
                        <span class="text-danger"><?php echo form_error('number_bene'); ?></span>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-4">
                        <label class="control-label" for="natureofworklist">Nature of Work:</label>
                        <div id="natureofworkID">
                            <select required id="natureofworklist" name="natureofworklist" class="form-control" required>
                                <?php if(isset($projectdata->nature_id) or isset($projectdata->assistance_id)) {
                                    ?>
                                    <option value="">Choose Nature of work</option>
                                    <?php
                                    foreach ($natureofworklist as $natureofworkselect) { ?>
                                        <option value="<?php echo $natureofworkselect->nature_id; ?>"
                                            <?php
                                            if (isset($projectdata->nature_id) and $natureofworkselect->nature_id== $projectdata->nature_id) {
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
                        <label for="natureofworklist" class="control-label">Minimum - Maximum Amount :</label>
                        <div id = "nature_maxmin">
                            <div>
                                <input type = "text" id="maxmin_nature" name ="maxmin_nature" class = "form-control" disabled>
                            </div>
                            <div id = "amount_requested">
                                <label for="amount_requested" class="control-label">Amount Requested:</label>

                                <input type = "number" id="amount_requested" name ="amount_requested" class = "form-control" >
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <label for="fundsourcelist" class="control-label">Fund Source:</label>
                        <select name="fundsourcelist" id="fundsourcelist" class="form-control">
                            <option value="">Choose Fund Source</option>
                            <?php foreach($fundsourcelist as $fundsourceselect): ?>
                                <option value="<?php echo $fundsourceselect->fundsource_id; ?>"
                                    <?php
                                    if (isset($projectdata->fundsource_id) and $fundsourceselect->fundsource_id== $projectdata->fundsource_id) {
                                        echo " selected";
                                    } ?>
                                >

                                    <?php echo $fundsourceselect->fund_source; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                        <div class="col-sm-4">
                            <label for="lgucounterpartlist" class="control-label">LGU counterpart:</label>
                            <select name="lgucounterpartlist" id="lgucounterpartlist" class="form-control">
                                <option value="">Choose LGU counterpart</option>
                                <?php foreach($lgucounterpartlist as $lgucounterpartselect): ?>
                                    <option value="<?php echo $lgucounterpartselect->lgucounterpart_id; ?>"
                                        <?php
                                        if (isset($projectdata->lgucounterpart_id) and $lgucounterpartselect->lgucounterpart_id == $projectdata->lgucounterpart_id) {
                                            echo " selected";
                                        } ?>
                                    >
                                        <?php echo $lgucounterpartselect->lgu_counterpart; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-sm-4">
                            <label for="lgu_amount" class="control-label">LGU amount:</label>
                            <input id="lgu_amount" name="lgu_amount" placeholder="LGU amount" type="text"  class="form-control"  value="<?php echo $projectdata->lgu_amount ?>"required />
                            <span class="text-danger"><?php echo form_error('lgu_amount'); ?></span>
                        </div>

                        <div class="col-sm-4">
                            <label for="lgu_fundsource" class="control-label">LGU fundsource:</label>
                            <input id="lgu_fundsource" name="lgu_fundsource" placeholder="LGU fund source" type="text"  class="form-control"  value="<?php echo $projectdata->lgu_fundsource ?>" required />
                            <span class="text-danger"><?php echo form_error('lgu_fundsource'); ?></span>
                        </div>

                </div>

                <div class="form-group row">
                    <div class="col-sm-4">
                        <label for="project_cost" class="control-label">Project Cost:</label>
                        <input id="project_cost" name="project_cost" placeholder="Project Cost" type="text"  class="form-control"  value="<?php echo $projectdata->project_cost ?>" required />
                        <span class="text-danger"><?php echo form_error('project_cost'); ?></span>
                    </div>

                    <div class="col-sm-4">
                        <label for="implementing_agency" class="control-label">Implementing Agency:</label>
                        <select name="implementing_agency" id="implementing_agency" class="form-control">
                            <?php foreach($fundsourcelist as $fundsourceselect): ?>
                                <option value="<?php echo $fundsourceselect->fundsource_id; ?>"
                                    <?php
                                    if (isset($projectdata->fundsource_id) and $fundsourceselect->fundsource_id== $projectdata->fundsource_id) {
                                        echo " selected";
                                    } ?>
                                >
                                    <?php echo $fundsourceselect->fund_source; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-sm-4">
                        <label for="project_amount" class="control-label">Status:</label>
                        <input id="status" name="status" placeholder="Status" type="text"  class="form-control"  value="<?php echo $projectdata->status ?>" required />
                        <span class="text-danger"><?php echo form_error('status'); ?></span>
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



