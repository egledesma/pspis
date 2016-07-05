<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$region_code = $this->session->userdata('uregion');
if($region_code != "190000000"){
    redirect('/fundsallocation/index/0','location');

}
//saa
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

        <h1 class="page-title">Add Funds</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboardc/dashboard') ?>">Dashboard</a></li>
            <li><a href="<?php echo base_url('cofunds/index') ?>">Central Office Funds</a></li>
            <li class="active">Add Funds</li>
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
                $attributes = array("class" => "form-horizontal", "id" => "cofundsformadd", "name" => "cofundsformadd");
                //input here the next location when click insert

                echo form_open("cofunds/add", $attributes);?>


                <div class="form-group row">
                    <div class="col-sm-4">
                        <label for="fundsourcelist" class="control-label">Fund Source:</label>
                        <select name="fundsourcelist" id="fundsourcelist" class="form-control" requried autofocus>
                            <option value="">Choose Fund Source</option>
                            <?php foreach($fundsourcelist as $fundsourceselect): ?>
                                <option value="<?php echo $fundsourceselect->fundsource_id; ?>">
                                    <?php echo $fundsourceselect->fund_source; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <div id="funds_allocated" class="col-sm-4">
                        <label for="funds_amount" class="control-label">Funds Amount:</label>
                        <input type="text" class="form-control" name="funds_amount" id="inputCurrency" data-plugin="formatter"
                               data-pattern="₱ [[9]],[[999]],[[999]],[[999]]" />
                        <p class="help-block">₱ 9,999,999,999</p>
                    </div>
                </div>

<!--                <div class="form-group row">-->
<!--                        <div id="funds_allocated" class="col-sm-4">-->
<!--                            <label for="funds_amount" class="control-label">Funds Amount:</label>-->
<!--                            <input id="funds_amount" name="funds_amount" placeholder="Funds Amount"  type="number" min="0" value="--><?php //echo set_value('funds_amount'); ?><!--"  class="form-control" required/>-->
<!--                        </div>-->
<!--                </div>-->

                <div class="form-group row">

                    <div id="funds_utilized" class="col-sm-4">

                        <input id="status" name="status" placeholder="Status" type="hidden"  value="new"  class="form-control" required/>
                    </div>


                </div>
                <input id="funds_identifier" name="funds_identifier"  type="hidden" value="0" class="form-control"/>
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