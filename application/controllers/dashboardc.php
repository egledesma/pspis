<?php
/**
 * Created by PhpStorm.
 * User: ljesaclayan
 * Date: 2/11/2016
 * Time: 3:26 PM
 */


class dashboardc extends CI_Controller
{

    public function dashboard(){

        $dashboard_model = new dashboard_model();
        $this->load->view('header');
        $this->load->view('navbar');
        $this->load->view('sidebar');

        $this->load->view('dashboard',array('getAllocUtil'=>$dashboard_model->fundsAllocUtil(),
            'getGrand'=>$dashboard_model->grandTotal()
        ));
        $this->load->view('footer');
    }




}