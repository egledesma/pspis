<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

?>
<script type="text/javascript">
    function get_region_code() {
        var region_code = $('#regionlist').val();
        var date = $('#year').val();
        $('#funds_identifier').val(date+region_code);
    }
</script>

<div class="page ">

    <div class="page-header page-header-bordered">

        <h1 class="page-title">Funds Allocation</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboardc/dashboard') ?>">Dashboard</a></li>
            <li><a href="<?php echo base_url('fundsallocation/index') ?>">Funds Allocation</a></li>
            <li class="active">Add</li>
        </ol>
    </div>

    <div class="page-content">
        <div class="panel">
            <header class="panel-heading">
                <div class="panel-heading">
                    <h3 class="panel-title">Add New</h3>
                </div>
            </header>
            <div class="panel-body">

                <?php
                $attributes = array("class" => "form-horizontal", "id" => "fundsformadd", "name" => "fundsformadd");
                //input here the next location when click insert

                echo form_open("fundsallocation/add", $attributes);?>


                <div class="form-group row">
                    <div id="for_year" class="col-sm-2">
                        <label for="for_year" class="control-label">For Year:</label>
                        <input id="year" name="year" placeholder="For Year" type="text" value="<?php echo date('Y');?>" disabled class="form-control"/>
                        <input id="year" name="year"  type="hidden" value="<?php echo date('Y');?>"  class="form-control"/>
                    </div>

                </div>

                <div class="form-group row">
                    <div id="regionID" class="col-sm-4">
                        <label for="regionlist" class="control-label">Region :</label>
                        <select  name="regionlist" id="regionlist" class="form-control" onchange="get_region_code()">
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


                <div class="form-group row">
                        <div id="funds_allocated" class="col-sm-4">
                            <label for="funds_allocated" class="control-label">Funds Allocated:</label>
                            <input id="funds_allocated" name="funds_allocated" placeholder="Funds Allocated" data-plugin="formatter"
                                   data-pattern="₱[[999]],[[999]],[[999]].[[99]]" type="number" min="0" value="<?php echo set_value('funds_allocated'); ?>"  class="form-control" required/>
                        </div>
                </div>

                <div class="form-group row">

                    <div id="funds_utilized" class="col-sm-4">

                        <label for="funds_utilized" class="control-label">Funds Utilized:</label>

                        <input id="funds_utilized" name="funds_utilized" placeholder="Funds Utilized" type="number" pattern="(d{3})([.])(d{2})" min="0" value="<?php echo set_value('funds_utilized'); ?>"  class="form-control" required/>
                        <input id="status" name="status" placeholder="Status" type="text"  value="<?php echo set_value('status'); ?>"  class="form-control" required/>
                    </div>


                </div>

                <input id="funds_identifier" name="funds_identifier"  type="hidden" class="form-control"/>
                <input class="form-control"  type="hidden" name="myid" value="<?php echo $this->session->userdata('uid')?>">
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