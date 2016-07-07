<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!$this->session->userdata('user_data')){
    redirect('/users/login','location');

}
$user_region = $this->session->userdata('uregion');
error_reporting(0);
?>
<script type="text/javascript">
    function checkValidate(){

        var prevUtil = parseInt($('#Prev_Utilize').val());
        var util = parseInt($('#Utilize').val());
        var saroBal = parseInt($('#saro_amount').val());
        var amountReq = util - prevUtil;
        alert(amountReq);
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
                url: "<?php echo base_url('individual/populate_saro_amount'); ?>",
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
</script>
<div class="page ">

    <div class="page-header page-header-bordered">

        <h1 class="page-title">Assistance to Individuals in Crisis Situations</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboardc/dashboard') ?>">Dashboard</a></li>
            <li class="active">Assistance to Individuals in Crisis Situations</li>
        </ol>
    </div>

    <div class="page-content">
        <div class="panel">
            <div class="panel">
                <header class="panel-heading">
                    &nbsp;
                <?php     $attributes = array("class" => "form-horizontal", "id" => "AICSformadd", "name" => "AICSformadd");
                //input here the next location when click insert

                echo form_open("individual/addIndividual", $attributes);?>
<!---->
<?php //echo $prev_util;?>
<?php //print_r($prev_util);?>
                </header>
                <div class="panel-body">

                    <div class="col-sm-6">
                        <div>
                            <label class="control-label" for="fundsource">Fund Source:</label>
                            <select name="fundsource" id="fundsource" class="form-control" required="required"  autofocus>
                                <option value="">Choose Fund Source</option>
                                <?php foreach($fundlist as $fundselect): ?>
                                    <option value="<?php echo $fundselect->fundsource_id; ?>"
                                        >
                                        <?php echo $fundselect->fund_source .' - (₱'. number_format($fundselect->remaining_budget,2).')'; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div name = "saronumber" id = "saronumber">

                        </div>
                        <div class="form-group row">

                            <div class="col-sm-12">
                                <label for="region_name" class="control-label">Region:</label>
                                <input id="region_name" name="region_name" placeholder="Region" type="text"  class="form-control"  value= "<?php echo $crims->region_name; ?>" required autofocus/>
                                <input id="region_name" name="region_code" placeholder="region_code" type="hidden"  class="form-control"  value= "<?php echo $crims->RegionAssist; ?>" required autofocus/>
                                <span class="text-danger"><?php echo form_error('region_name'); ?></span>
                            </div>
                            <div class="col-sm-12">
                                <label for="Prev_Utilize" class="control-label">Previous Utilized:</label>
                                <input id="Prev_Utilize" name="Prev_Utilize" placeholder="Previous Utilized" type="number" class="form-control"  value="<?php if($prev_util == 0) {echo $prev_util;} else{ echo $prev_util->amount;} ; ?>" required readonly/>
                                <span class="text-danger"><?php echo form_error('Prev_Utilize'); ?></span>
                            </div>
                            <div class="col-sm-12">
                                <label for="Utilize" class="control-label">Utilized:</label>
                                <input id="Utilize" name="Utilize" placeholder="Utilize" type="number" class="form-control"  value="<?php echo $crims->Utilize; ?>" required autofocus/>
                                <span class="text-danger"><?php echo form_error('Utilize'); ?></span>
                            </div>

                                <div id="date_utilize" class="col-sm-12">
                                    <label for="date_utilize" class="control-label">Date:</label>
                                    <div class="input-group">
                                            <span class="input-group-addon">
                                              <i class="icon wb-calendar" aria-hidden="true"></i>
                                            </span>
                                        <input id="date_utilize" name="date_utilize" placeholder="Date" type="text"  class="form-control"  value="" data-plugin="datepicker" required/><span class="text-danger"><?php echo form_error('date_utilize'); ?></span>
                                    </div>
                                </div>
                        </div>
                        <div class="site-action">
                            <button  type="submit" onclick = "return checkValidate();"  id="btn_add" name="btn_add" class="btn btn-floating btn-danger btn-lg btn-outline" data-toggle="tooltip"
                                     data-placement="top" data-original-title="Save">
                                <i class="front-icon fa-save animation-scale-up" aria-hidden="true"></i>
                            </button>

                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>




</div>


