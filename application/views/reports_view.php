

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!$this->session->userdata('user_data')){
    redirect('/users/login','location');

}
$user_region = $this->session->userdata('uregion');
error_reporting(0);
?>
<div class="page ">

    <div class="page-header page-header-bordered">

        <h1 class="page-title">Reports</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboardc/dashboard') ?>">Dashboard</a></li>
            <li class="active">Reports</li>
        </ol>
    </div>

    <div class="page-content"
    <div class="panel">
        <div class="panel">
            <header class="panel-heading">
                &nbsp;

            </header>
            <div class="panel-body">
                <a class="btn btn-warning btn-rounded" href="<?php echo base_url('reports/get_funds') ?>">Funds Reporting Download Excel</a>
<!--                <a class="btn btn-warning btn-rounded" href="--><?php //echo base_url('reports/crimstesting') ?><!--">testing</a>-->
<!--                <a class="btn btn-warning btn-rounded" href="--><?php //echo base_url('reports/get_funds') ?><!--">Funds Reporting Download Excel</a>-->

            </div>

        </div>
    </div>
</div>




</div>


