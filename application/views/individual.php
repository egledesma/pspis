<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

?>
<script type="text/javascript">
    function get_natureofwork() {
        var assistance_id = $('#assistancelist').val();

        if(assistance_id > 0) {
            $.ajax({
                url: "<?php echo base_url('individual/populate_natureofwork'); ?>",
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
                url: "<?php echo base_url('individual/populate_prov'); ?>",
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
                url: "<?php echo base_url('individual/populate_muni'); ?>",
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
                url: "<?php echo base_url('individual/populate_brgy'); ?>",
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
</script>


<div class="page ">

    <div class="page-header page-header-bordered">

        <h1 class="page-title">Add</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboardc/dashboard') ?>">Dashboard</a></li>
            <li class="active">Communities</li>
        </ol>
    </div>

    <div class="page-content"><?php //print_r($regionlist)?>
        <div class="panel">
            <header class="panel-heading">
            </header>
            <div class="panel-body">
            <div class="col-md-12">
                <!-- Panel Wizard Form Container -->
                <div class="panel" id="exampleWizardFormContainer">
                    <div class="panel-heading">
                        <marquee><h3 class="panel-title">Add New Project</h3></marquee>
                    </div>
                    <div class="panel-body">
                        <!-- Steps -->
                        <div class="pearls row">
                            <div class="pearl current col-xs-4">
                                <div class="pearl-icon"><i class="icon wb-user" aria-hidden="true"></i></div>
                                <span class="pearl-title">Project Profile</span>
                            </div>
                            <div class="pearl col-xs-4">
                                <div class="pearl-icon"><i class="icon wb-payment" aria-hidden="true"></i></div>
                                <span class="pearl-title">Source of Fund</span>
                            </div>
                            <div class="pearl col-xs-4">
                                <div class="pearl-icon"><i class="icon wb-check" aria-hidden="true"></i></div>
                                <span class="pearl-title">Confirmation</span>
                            </div>
                        </div>
                        <!-- End Steps -->

                        <!-- Wizard Content -->
                        <form class="wizard-content" id="exampleFormContainer">
                            <div class="wizard-pane active" role="tabpanel">

                                <div class="form-group col-md-12">
                                    <div class="col-md-6">
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
                                    <div class="form-group col-md-12">
                                    <div class="col-md-4">
                                        <div id="natureofworkID">
                                        <label class="control-label" for="natureofworklist">Nature of Work:</label>
                                        <select required id="natureofworklist" name="natureofworklist" class="form-control" required="required">
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
                                </div>

                                <div class="form-group col-md-12">
                                    <div class="col-md-6">
                                        <label class="control-label" for="projecttitle">Project Title:</label>
                                        <input type="text" class="form-control" id="projecttitle" name="projecttitle" required="required">
                                    </div>
                                </div>

                                <div class="form-group col-md-12">

                                    <div class="col-md-6">
                                        <label class="control-label" for="regionlist">Project Location:</label>
                                        <div id="regionID">
                                            <select  name="regionlist" id="regionlist" class="form-control" onChange="get_prov();" required="required">
                                                <option value="">Choose Region</option>
                                                <?php foreach($regionlist as $regionselect): ?>
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
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="col-md-6">
                                        <div id="provinceID">
                                            <select id="provlist" name="provlist" class="form-control" onChange="get_muni();" required="required" required>
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
                                <div class="form-group col-md-12">
                                    <div class="col-md-6">
                                        <div id="muniID">
                                            <select required id="munilist" name="munilist" onchange="get_brgy();" class="form-control" required="required">
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
                                <div class="form-group col-md-12">
                                    <div class="col-md-6">
                                        <div id="brgyID">
                                            <select required id="brgylist" name="brgylist" class="form-control" required="required">
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
                                <div class="form-group col-md-12">
                                    <div class="col-md-6">
                                        <label class="control-label" for="projecttitle">No of Beneficiaries:</label>
                                        <input type="number" class="form-control" id="projecttitle" name="projecttitle">
                                    </div>
                                </div>
                            </div>


                            <div class="wizard-pane" id="exampleBillingOne" role="tabpanel">
                                <div class="form-group">
                                    <label class="control-label" for="inputCardNumberOne">Card Number</label>
                                    <input type="text" class="form-control" id="inputCardNumberOne" name="number" placeholder="Card number">
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="inputCVVOne">CVV</label>
                                    <input type="text" class="form-control" id="inputCVVOne" name="cvv" placeholder="CVV">
                                </div>
                            </div>
                            <div class="wizard-pane" id="exampleGettingOne" role="tabpanel">
                                <div class="text-center margin-vertical-20">
                                    <h4>Please confrim your order.</h4>
                                    <div class="table-responsive">
                                        <table class="table table-hover text-right">
                                            <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th>Description</th>
                                                <th class="text-right">Quantity</th>
                                                <th class="text-right">Unit Cost</th>
                                                <th class="text-right">Total</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td class="text-center">1</td>
                                                <td class="text-left">Server hardware purchase</td>
                                                <td>32</td>
                                                <td>$75</td>
                                                <td>$2152</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">2</td>
                                                <td class="text-left">Office furniture purchase</td>
                                                <td>15</td>
                                                <td>$169</td>
                                                <td>$4169</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">3</td>
                                                <td class="text-left">Company Anual Dinner Catering</td>
                                                <td>69</td>
                                                <td>$49</td>
                                                <td>$1260</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- Wizard Content -->
                    </div>
                </div>
                <!-- End Panel Wizard Form Container -->
            </div>
