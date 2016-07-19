<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$region_code = $this->session->userdata('uregion');
if($region_code != "190000000"){
    redirect('/fundsallocation/index/0','location');

}

?>
<script type="text/javascript">

    function checkValidate(){

        var fundsbal = parseInt($('#conso_balance').val());
        var amountReq = $('#inputCurrency').val();
        var lstReplace = amountReq.replace(/\D/g,'');
        alert(fundsbal);
        alert(lstReplace);
        if(fundsbal < lstReplace){

            alert("Insufficient Funds, Please select other Fund Source.");
            return false;
        }
    }


    function get_region_code() {
        var region_code = $('#regionlist').val();
        var date = $('#year').val();
        $('#funds_identifier').val(date+region_code);
    }

    function get_consolidated_balance()
    {
        var fundsource_id = $('#fundsourcelist').val();

        if(fundsource_id > 0){
            alert(fundsource_id);
            $.ajax({
                url: "<?php echo base_url('fundsallocation/populate_conso_balance'); ?>",
                async: false,
                type: "POST",
                data: "fundsource_id="+fundsource_id,
                dataType: "html",
                success: function(data) {
                    $('#fundsource').html(data);
                }
            });
        }
//        }
    }


</script>

<div class="page ">

    <div class="page-header page-header-bordered">

        <h1 class="page-title">Funds Allocation</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboardc/dashboard') ?>">Dashboard</a></li>
            <li><a href="<?php echo base_url('fundsallocation/index/0') ?>">Funds Allocation</a></li>
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
                    <div class="col-sm-4">
                        <label for="fundsourcelist" class="control-label">Fund Source:</label>
                        <select name="fundsourcelist" id="fundsourcelist" class="form-control" onchange ="get_consolidated_balance();" requried autofocus>
                            <option value="">Choose Fund Source</option>
                            <?php foreach($fundsourcelist as $fundsourceselect): ?>
                                <option value="<?php echo $fundsourceselect->fundsource_id; ?>">
                                    <?php echo $fundsourceselect->fund_source; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div name="fundsource" id ="fundsource">

                </div>

                <div class="form-group row">
                    <div id="saa" class="col-sm-4">
                        <label for="saa" class="control-label">SAA Number:</label>
                        <input id="saa" name="saa" placeholder="SAA ############" type="text"  value="<?php echo set_value('saa'); ?>"  class="form-control" required autofocus/>
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
                        <label for="funds_allocated" class="control-label">Funds Amount:</label>
                        <input type="text" class="form-control" name="funds_allocated" id="inputCurrency" data-plugin="formatter"
                               data-pattern="₱ [[9]],[[999]],[[999]],[[999]]" />
                        <p class="help-block">₱ 9,999,999,999</p>
                    </div>
                </div>


                <input id="funds_identifier" name="funds_identifier"  type="hidden" class="form-control"/>
                <input class="form-control"  type="hidden" name="status" value="0">
                <input class="form-control"  type="hidden" name="myid" value="<?php echo $this->session->userdata('uid')?>">
                <div class="site-action">
                    <button  type="submit" onclick = "return checkValidate();" id="btn_add" name="btn_add" class="btn btn-floating btn-danger btn-lg btn-outline" data-toggle="tooltip"
                             data-placement="top" data-original-title="Save">
                        <i class="front-icon fa-save animation-scale-up" aria-hidden="true"></i>
                    </button>

                </div>
                <?php echo form_close(); ?>

            </div>
        </div>
    </div>
</div>