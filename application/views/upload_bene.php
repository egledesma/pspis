<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!$this->session->userdata('user_data')){
    redirect('/users/login','location');

}
$user_region = $this->session->userdata('uregion');
error_reporting(0);
?>
<div class="page ">

    <div class="page-header page-header-bordered">

        <h1 class="page-title">Upload Beneficiaries</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboardc/dashboard') ?>">Dashboard</a></li>
            <li class="active">Upload Beneficiaries</li>
        </ol>
    </div>

    <div class="page-content"
    <div class="panel">
        <div class="panel">


            <?php //echo $name;?>
            <?php //echo $file_name->file_location; ?>
            <?php echo form_open_multipart('cashforwork/do_upload/'.$cashforwork_brgy_id);?>

            <input type="file" name="userfile" id = "userfile" size="20" />

            <br /><br />

            <input type="submit" value="upload" />

            </form>



         </div>
     </div>
    </div>
</div>



