<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!$this->session->userdata('user_data')){
    redirect('/users/login','location');

}
$user_region = $this->session->userdata('uregion');
error_reporting(0);
?>
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
                    &nbsp;    <pre>
                <?php     $attributes = array("class" => "form-horizontal", "id" => "AICSformadd", "name" => "AICSformadd");
                //input here the next location when click insert

                echo form_open("individual/addIndividual", $attributes);?>
                </pre>

                </header>
                <div class="panel-body">
                    <div class="col-sm-6">
                        <div>
                            <label class="control-label" for="sarolist">Saro Number:</label>
                            <select name="sarolist" id="sarolist" class="form-control"  required="required" autofocus>
                                <option value="">Choose Saro Number</option>
                                <?php foreach($sarolist as $saroselect): ?>
                                    <option value="<?php echo $saroselect->saro_id; ?>"
                                        <?php if(isset($saro_id)) {
                                            if($saroselect->saro_id == $saro_id) {
                                                echo " selected";
                                            }
                                        } ?>
                                    >
                                        <?php echo $saroselect->saro_number; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group row">

                            <div class="col-sm-12">
                                <label for="region_name" class="control-label">Region:</label>
                                <input id="region_name" name="region_name" placeholder="Region" type="text"  class="form-control"  value= "<?php echo $crims->region_name; ?>" required autofocus/>
                                <input id="region_name" name="region_code" placeholder="region_code" type="hidden"  class="form-control"  value= "<?php echo $crims->RegionAssist; ?>" required autofocus/>
                                <span class="text-danger"><?php echo form_error('region_name'); ?></span>
                            </div>
                            <div class="col-sm-12">
                                <label for="Utilize" class="control-label">Utilize:</label>
                                <input id="Utilize" name="Utilize" placeholder="Utilize" type="number" max = "<?php echo $crims->Utilize; ?>" class="form-control"  value="<?php echo $crims->Utilize; ?>" required autofocus/>
                                <span class="text-danger"><?php echo form_error('Utilize'); ?></span>
                            </div>

                            <div class="col-sm-12">
                                <label for="date_utilize" class="control-label">Date Utilize:</label>
                                <input id="date_utilize" name="date_utilize" placeholder="date_utilize" type="date"  class="form-control"  value="<?php echo $crims->Utilize; ?>" required autofocus/>
                                <span class="text-danger"><?php echo form_error('Utilize'); ?></span>
                            </div>
                        </div>
                        <div class="site-action">
                            <button  type="submit"  id="btn_add" name="btn_add" class="btn btn-floating btn-danger btn-lg btn-outline" data-toggle="tooltip"
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


