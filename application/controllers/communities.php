<?php
/**
 * Created by PhpStorm.
 * User: ljesaclayan
 * Date: 2/11/2016
 * Time: 3:26 PM
 */


class communities extends CI_Controller
{

    public function index(){

        // $dashboard_model = new dashboard_model();
        $this->load->view('header');
        $this->load->view('navbar');
        $this->load->view('sidebar');

        /** $this->load->view('dashboard',array('getIndiv'=> $dashboard_model->getDashboardIndividual($user_region),
        'getDisaster'=> $dashboard_model->getDashboardDisaster($user_region),
        'getEco'=> $dashboard_model->getDashboardEconomic($user_region),
        'getSocial'=> $dashboard_model->getDashboardSocial($user_region),
        'getAll'=> $dashboard_model->getDashboardALL($user_region))
        ); */
        $this->load->view('communities');
        $this->load->view('footer');
    }




}