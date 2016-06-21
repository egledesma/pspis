<?php
/**
 * Created by PhpStorm.
 * User: ljesaclayan
 * Date: 2/11/2016
 * Time: 3:26 PM
z*/


class cashforwork extends CI_Controller
{

    public function index(){
        $cashforwork_model = new cashforwork_model();
        $this->load->view('header');
        $this->load->view('navbar');
        $this->load->view('sidebar');
        $region_code = $this->session->userdata('uregion');
        $this->load->view('cashforwork_list',array(
            'project' => $cashforwork_model->get_project($region_code)));
        $this->load->view('footer');
    }
    public function finalize_saro($cashforwork_id)
    {
        $cashforwork_model = new cashforwork_model();
        if ($cashforwork_id > 0){
            $getResult = $cashforwork_model->finalize($cashforwork_id);
            $total_cost = $getResult->total_cost;
            $saro = $getResult->saro_id;
            $regionsaro = $this->session->userdata('uregion');
            $deleteResult = $cashforwork_model->finalize_update($total_cost,$saro,$regionsaro);

            if ($deleteResult){
                $this->load->view('header');
                $this->load->view('navbar');
                $this->load->view('sidebar');
                $region_code = $this->session->userdata('uregion');
                $this->load->view('cashforwork_list',array(
                    'project' => $cashforwork_model->get_project($region_code)
                ));

                $this->load->view('footer');
            }
            $this->redirectIndex();

        }
    }
    public function masterviewcashforwork($cashforwork_id)
    {
        $cashforwork_model = new cashforwork_model();
        $this->load->view('header');
        $this->load->view('navbar');
        $this->load->view('sidebar');
//        $region_code = $this->session->userdata('uregion');
        $this->load->view('cashforwork_view',array(
            'project' => $cashforwork_model->viewcashforwork($cashforwork_id),
            'call_muni' => $cashforwork_model->viewcashforwork_callmuni($cashforwork_id),
            'call_brgy' => $cashforwork_model->viewcashforwork_callbrgy($cashforwork_id)
        ));
        $this->load->view('footer');
    }
    public function cashforworkBenelist($cashforwork_id)
    {
        $cashforwork_model = new cashforwork_model();
        $this->load->view('header');
        $this->load->view('navbar');
        $this->load->view('sidebar');
//        $region_code = $this->session->userdata('uregion');
        $this->load->view('cashforwork_viewbenelist',array(
            'project' => $cashforwork_model->viewcashforwork($cashforwork_id),
            'call_muni' => $cashforwork_model->viewcashforwork_callmuni($cashforwork_id),
            'call_brgy' => $cashforwork_model->viewcashforwork_callbrgy($cashforwork_id),
            'call_bene' => $cashforwork_model->viewcashforwork_callbenelist($cashforwork_id)
        ));
        $this->load->view('footer');
    }
    public function updateCashforwork($cashforwork_id)
    {
        $cashforwork_model = new cashforwork_model();

        $this->validateAddForm();


        if ($this->form_validation->run() == FALSE) {
            $this->assistance_session();
            $this->init_rpmb_session();
            $regionsaro = $this->session->userdata('uregion');
            $getList['sarolist'] = $cashforwork_model->get_saro($regionsaro);
            $getList['natureofworklist'] = $cashforwork_model->get_work_nature();
            $getList['regionlist'] = $cashforwork_model->get_regions();
            $getList['cashforworkdata'] = $cashforwork_model->get_project_byid($cashforwork_id);

            $this->load->view('header');
            $this->load->view('navbar');
            $this->load->view('sidebar');

            $this->load->view('cashforwork_edit', $getList);
            $this->load->view('footer');
        }
        else
        {

            $myid = $this->input->post('myid');
            $cashforwork_id1 = $this->input->post('cashforwork_id');
            $project_title = $this->input->post('project_title');
            $sarolist = $this->input->post('sarolist');
            $regionlist = $this->input->post('region_pass');
            $provlist = $this->input->post('provlist');
            $natureofworklist = $this->input->post('natureofworklist');
            $daily_payment = $this->input->post('daily_payment');
            $number_of_bene = $this->input->post('number_of_bene');
            $cost_of_assistance = $this->input->post('cost_of_assistance');
            $number_days = $this->input->post('number_days');
            $updateResult = $cashforwork_model->updateCashforwork($sarolist,$cashforwork_id1,$myid,$project_title,$regionlist,$provlist
                ,$natureofworklist,$number_days,$daily_payment,$number_of_bene,$cost_of_assistance);
            if ($updateResult) {

                $this->load->view('header');
                $this->load->view('navbar');
                $this->load->view('sidebar');
                $region_code = $this->session->userdata('uregion');
                $this->load->view('cashforwork_list',array(
                    'project' => $cashforwork_model->get_project($region_code)
                ));
                $this->load->view('footer');
            }

            $this->redirectIndex();
        }
    }

    public function deleteCashforwork($cashforwork_id)
    {
        $cashforwork_model = new cashforwork_model();
        if ($cashforwork_id > 0){
            $deleteResult = $cashforwork_model->deleteCashforwork($cashforwork_id);

            if ($deleteResult){
                $this->load->view('header');
                $this->load->view('navbar');
                $this->load->view('sidebar');
                $region_code = $this->session->userdata('uregion');
                $this->load->view('cashforwork_list',array(
                    'project' => $cashforwork_model->get_project($region_code)
                ));

                $this->load->view('footer');
            }
            $this->redirectIndex();
        }
    }
    public function deleteCashforwork_muni($cashforwork_muni_id)
    {
        $cashforwork_model = new cashforwork_model();
        if ($cashforwork_muni_id > 0){
            $getList = $cashforwork_model->get_project_prov_muni($cashforwork_muni_id);
            $cash_id = $getList->cashforwork_id;
            $deleteResult = $cashforwork_model->deleteCash_muni_and_brgy($cashforwork_muni_id);
            }
            $this->redirectIndexviewCash_muni($cash_id);
        }
    public function deleteCashforwork_brgy($cashforwork_brgy_id)
    {
        $cashforwork_model = new cashforwork_model();
        if ($cashforwork_brgy_id > 0){
            $getList = $cashforwork_model->get_project_muni_brgy($cashforwork_brgy_id);
            $cashforwork_muni_id = $getList->cashforwork_muni_id;
            $deleteResult = $cashforwork_model->deleteCash_brgy($cashforwork_brgy_id);
        }
        $this->redirectIndexviewBrgy_muni($cashforwork_muni_id);
    }

    public function addCashforwork()
    {
        $cashforwork_model = new cashforwork_model();

        $this->validateAddForm();

        if ($this->form_validation->run() == FALSE) {
            $this->assistance_session();
            $this->init_rpmb_session();
            $regionsaro = $this->session->userdata('uregion');
            $getList['sarolist'] = $cashforwork_model->get_saro($regionsaro);
            $getList['natureofworklist'] = $cashforwork_model->get_work_nature();
            $getList['regionlist'] = $cashforwork_model->get_regions();

            if(isset($_SESSION['province']) or isset($_SESSION['region'])) {
                $getList['provlist'] = $cashforwork_model->get_provinces($_SESSION['region']);
            }
            if(isset($_SESSION['muni']) or isset($_SESSION['province'])) {
                $getList['munilist'] = $cashforwork_model->get_muni($_SESSION['province']);
            }
            if(isset($_SESSION['brgy']) or isset($_SESSION['muni'])) {
                $getList['brgylist'] = $cashforwork_model->get_brgy($_SESSION['muni']);
            }

            $this->load->view('header');
            $this->load->view('navbar');
            $this->load->view('sidebar');

            $this->load->view('cashforwork_add', $getList);
            $this->load->view('footer');
        }
        else
        {
            $myid = $this->input->post('myid');
            $project_title = $this->input->post('project_title');
            $saro = $this->input->post('sarolist');
            $regionlist = $this->input->post('region_pass');
            $provlist = $this->input->post('provlist');
            $natureofworklist = $this->input->post('natureofworklist');
            $daily_payment = $this->input->post('daily_payment');
            $number_of_bene = $this->input->post('number_of_bene');
            $cost_of_assistance = $this->input->post('cost_of_assistance');
            $number_days = $this->input->post('number_days');

            $addResult = $cashforwork_model->insertProject($number_of_bene,$cost_of_assistance,$saro,$myid,$project_title,$regionlist,$provlist
                ,$natureofworklist,$daily_payment,$number_days);
            if ($addResult){
                $this->load->view('header');
                $this->load->view('navbar');
                $this->load->view('sidebar');
                $region_code = $this->session->userdata('uregion');
                $this->load->view('cashforwork_list',array(
                    'project' => $cashforwork_model->get_project($region_code)
                ));
                $this->load->view('footer');
            }
            $this->redirectIndexviewCash_muni($addResult,$region_code);
        }
    }

    public function viewCash_muni($cashforwork_id)
    {
        $cashforwork_model = new cashforwork_model();

        $getList['cashforworkpass_id'] = $cashforwork_id;
//            $getList['provlist'] = $cashforwork_model->get_provinces($region_code);
        $getList['proj_prov'] = $cashforwork_model->get_project_province($cashforwork_id);
        $getList['title'] = $cashforwork_model->get_project_title($cashforwork_id);
        $getList['cashmuni_list'] = $cashforwork_model->get_cashmuni_list($cashforwork_id);
        $getList['cashforworkinfo'] = $cashforwork_model->get_cashforworkDetails($cashforwork_id);

        $getList['countBene'] = $cashforwork_model->get_countbene_muni($cashforwork_id);
        $this->load->view('header');
        $this->load->view('navbar');
        $this->load->view('sidebar');

        $this->load->view('cashforwork_muni_list', $getList);
        $this->load->view('footer');

    }
    public function addCash_muni($cashforwork_id)
    {
        $cashforwork_model = new cashforwork_model();

        $this->validateAddmuniForm();

        if ($this->form_validation->run() == FALSE) {
            $this->init_rpmb_session();
            $getList['cashforworkpass_id'] = $cashforwork_id;
//            $getList['region_pass'] = $region_code;
//            $getList['provlist'] = $cashforwork_model->get_provinces($region_code);
            $getList['proj_prov'] = $cashforwork_model->get_project_province($cashforwork_id);
            $getList['title'] = $cashforwork_model->get_project_title($cashforwork_id);
            if(isset($_SESSION['muni']) or isset($_SESSION['province'])) {
                $getList['munilist'] = $cashforwork_model->get_muni($_SESSION['province']);
            }
            if(isset($_SESSION['brgy']) or isset($_SESSION['muni'])) {
                $getList['brgylist'] = $cashforwork_model->get_brgy($_SESSION['muni']);
            }

            $this->load->view('header');
            $this->load->view('navbar');
            $this->load->view('sidebar');

            $this->load->view('cashforwork_muni_add', $getList);
            $this->load->view('footer');
        }
        else
        {
            $region_code = $this->session->userdata('uregion');
//            $assistancelist = 2;
            $myid = $this->input->post('myid');
            $provlist = $this->input->post('prov_pass');
//            $saro_id = $this->input->post('saro_id');
            $cashforworkpass_id = $this->input->post('cashforworkpass_id');
            $munilist = $this->input->post('munilist');
            $daily_payment = $this->input->post('daily_payment');
            $number_bene = $this->input->post('number_bene');
            $cost_of_assistance = $this->input->post('cost_of_assistance');
            $addResult = $cashforwork_model->insertCashmuni($myid,$cashforworkpass_id,$provlist,$munilist
                ,$daily_payment,$number_bene,$cost_of_assistance);
            if ($addResult){
                $getList['cashforworkpass_id'] = $cashforwork_id;
                $getList['provlist'] = $cashforwork_model->get_provinces($region_code);
                $getList['proj_prov'] = $cashforwork_model->get_project_province($cashforwork_id);
                $getList['title'] = $cashforwork_model->get_project_title($cashforwork_id);
                $getList['cashmuni_list'] = $cashforwork_model->get_cashmuni_list($cashforwork_id);
                $this->load->view('header');
                $this->load->view('navbar');
                $this->load->view('sidebar');

                $this->load->view('cashforwork_muni_list', $getList);
                $this->load->view('footer');

            }
            $this->redirectIndexviewCash_muni($cashforworkpass_id);
        }
    }
    public function updateCashforwork_muni($cashforwork_muni_id)
    {
        $cashforwork_model = new cashforwork_model();
        $this->validateAddmuniForm();
        if ($this->form_validation->run() == FALSE) {
            $this->assistance_session();
            $this->init_rpmb_session();

            $getList['proj_prov'] = $cashforwork_model->get_project_prov_muni($cashforwork_muni_id);
            $proj_prov = $cashforwork_model->get_project_prov_muni($cashforwork_muni_id);
            $cashforwork_id = $proj_prov->cashforwork_id;

            $getList['title'] = $cashforwork_model->get_project_title($cashforwork_id);
            $getList['countBene'] = $cashforwork_model->get_countbene_muni($cashforwork_id);
            if(isset($_SESSION['muni']) or isset($_SESSION['province'])) {
                $getList['munilist'] = $cashforwork_model->get_muni($_SESSION['province']);
            }
            if(isset($_SESSION['brgy']) or isset($_SESSION['muni'])) {
                $getList['brgylist'] = $cashforwork_model->get_brgy($_SESSION['muni']);
            }
            $this->load->view('header');
//            $this->load->view('navbar');
//            $this->load->view('sidebar');
            $this->load->view('cashforwork_muni_edit', $getList);
            $this->load->view('footer');
        }
        else
        {
            $myid = $this->input->post('myid');
            $cash_muni_id = $this->input->post('cash_muni_id');
            $cashforwork_id = $this->input->post('cashforwork_id');
            $munilist = $this->input->post('munilist');
            $number_of_bene = $this->input->post('number_bene');
            $cost_of_assistance_muni = $this->input->post('cost_of_assistance');
            $updateResult = $cashforwork_model->updateCashforwork_muni($myid,$cash_muni_id,$munilist,$number_of_bene
                ,$cost_of_assistance_muni);
//            if ($updateResult) {
//
//                $getList['proj_prov'] = $cashforwork_model->get_project_province($cashforwork_id);
//                $getList['title'] = $cashforwork_model->get_project_title($cashforwork_id);
//                $getList['cashmuni_list'] = $cashforwork_model->get_cashmuni_list($cashforwork_id);
//                $getList['cashforworkinfo'] = $cashforwork_model->get_cashforworkDetails($cashforwork_id);
//                $this->load->view('header');
//                $this->load->view('navbar');
//                $this->load->view('sidebar');
//                $this->load->view('cashforwork_muni_list', $getList);
//                $this->load->view('footer');
//            }

            $this->redirectIndexviewCash_muni($cashforwork_id);
        }
    }
    public function viewCash_brgy($cashforwork_muni_id)
    {
        $cashforwork_model = new cashforwork_model();

        $getList['cashforworkpassmuni_id'] = $cashforwork_muni_id;
//            $getList['provlist'] = $cashforwork_model->get_provinces($region_code);
        $getList['proj_prov'] = $cashforwork_model->get_project_prov_muni($cashforwork_muni_id);
        $getList['cashbrgy_list'] = $cashforwork_model->get_cashbrgy_list($cashforwork_muni_id);
//        $getList['cashforworkinfo'] = $cashforwork_model->get_cashforworkDetails($cashforwork_muni_id);
        $this->load->view('header');
//        $this->load->view('navbar');
//        $this->load->view('sidebar');

        $this->load->view('cashforwork_brgy_list', $getList);
        $this->load->view('footer');

    }
    public function updateCashforwork_brgy($cashforwork_brgy_id)
    {
        $cashforwork_model = new cashforwork_model();

        $this->validateAddbrgyForm();


        if ($this->form_validation->run() == FALSE) {
            $this->assistance_session();
            $this->init_rpmb_session();

//            $getList['cashforworkpassmuni_id'] = $cashforwork_muni_id;
//            $getList['provlist'] = $cashforwork_model->get_provinces($region_code);
            $getList['proj_brgy'] = $cashforwork_model->get_project_muni_brgy($cashforwork_brgy_id);
            $proj_brgy = $cashforwork_model->get_project_muni_brgy($cashforwork_brgy_id);
            $cashforwork_muni_id = $proj_brgy->cashforwork_muni_id;
            $getList['countBene'] = $cashforwork_model->get_countbene_brgy($cashforwork_muni_id);
            $getList['proj_prov'] = $cashforwork_model->get_project_prov_muni($cashforwork_muni_id);
            if(isset($_SESSION['brgy']) or isset($_SESSION['muni'])) {
                $getList['brgylist'] = $cashforwork_model->get_brgy($_SESSION['muni']);
            }
            $this->load->view('header');
//            $this->load->view('navbar');
//            $this->load->view('sidebar');
            $this->load->view('cashforwork_brgy_edit', $getList);
            $this->load->view('footer');
        }
        else
        {
            $myid = $this->input->post('myid');
            $cash_muni_id_pass = $this->input->post('cash_muni_id_pass');
//            $cashforwork_id = $this->input->post('cashforwork_id');
            $brgylist = $this->input->post('brgylist');
            $cash_brgy_id_pass = $this->input->post('cash_brgy_id_pass');
            $number_of_bene = $this->input->post('number_bene');
            $cost_of_assistance_brgy = $this->input->post('cost_of_assistance');

            $updateResult = $cashforwork_model->updateCashforwork_brgy($cash_brgy_id_pass,$myid,$brgylist,$number_of_bene
                ,$cost_of_assistance_brgy);
            if ($updateResult) {
                $getList['proj_prov'] = $cashforwork_model->get_project_prov_muni($cash_muni_id_pass);
                $getList['cashbrgy_list'] = $cashforwork_model->get_cashbrgy_list($cash_muni_id_pass);

                $this->load->view('header');
                $this->load->view('navbar');
                $this->load->view('sidebar');

                $this->load->view('cashforwork_brgy_list', $getList);
                $this->load->view('footer');
            }

            $this->redirectIndexviewBrgy_muni($cash_muni_id_pass);
        }
    }
//    function view_list()
//    {
//        $this->load->view('cashforwork_brgy_add');
//    }
    public function addCash_brgy($cashforwork_muni_id)
    {
        $cashforwork_model = new cashforwork_model();

        $this->validateAddbrgyForm();

        if ($this->form_validation->run() == FALSE) {
            $this->init_rpmb_session();
//            $getList['cashforworkpass_id'] = $cashforwork_id;
            $getList['cashforworkpassmuni_id'] = $cashforwork_muni_id;
//            $getList['provlist'] = $cashforwork_model->get_provinces($region_code);

            $getList['countBene'] = $cashforwork_model->get_countbene_brgy($cashforwork_muni_id);
            $getList['proj_prov'] = $cashforwork_model->get_project_prov_muni($cashforwork_muni_id);
            $getList['cashbrgy_list'] = $cashforwork_model->get_cashbrgy_list($cashforwork_muni_id);

            if(isset($_SESSION['brgy']) or isset($_SESSION['muni'])) {
                $getList['brgylist'] = $cashforwork_model->get_brgy($_SESSION['muni']);
            }

            $this->load->view('header');
//            $this->load->view('navbar');
//            $this->load->view('sidebar');

            $this->load->view('cashforwork_brgy_add', $getList);
            $this->load->view('footer');
        }
        else
        {

            $myid = $this->input->post('myid');
            $cashforworkpass_id = $this->input->post('cashforwork_id_pass');
            $cash_muni_id_pass = $this->input->post('cash_muni_id_pass');
            $munilist = $this->input->post('muni_pass');
            $brgylist = $this->input->post('brgylist');
            $number_bene = $this->input->post('number_bene');
            $cost_of_assistance_brgy = $this->input->post('cost_of_assistance');
            $addResult = $cashforwork_model->insertCashbrgy($myid,$cashforworkpass_id,$cash_muni_id_pass,$munilist ,$brgylist,$number_bene,$cost_of_assistance_brgy);
            if ($addResult){

//                $getList['cashforworkpassmuni_id'] = $cashforwork_muni_id;
                $getList['proj_prov'] = $cashforwork_model->get_project_prov_muni($cashforwork_muni_id);
                $getList['cashbrgy_list'] = $cashforwork_model->get_cashbrgy_list($cashforwork_muni_id);

                $this->load->view('header');
                $this->load->view('navbar');
                $this->load->view('sidebar');

                $this->load->view('cashforwork_brgy_list', $getList);
                $this->load->view('footer');

            }
            $this->redirectIndexviewBrgy_muni($cash_muni_id_pass);
        }
    }

    public function cash_benelist($cashforworkbrgy_id)
    {
        $cashforwork_model = new cashforwork_model();
        $this->load->view('header');
//        $this->load->view('navbar');
//        $this->load->view('sidebar');

        $this->load->view('cashforwork_beneAdd',array(
            'cash_benelist' => $cashforwork_model->get_bene_list($cashforworkbrgy_id),
            'countBene' => $cashforwork_model->get_countbene_benelist($cashforworkbrgy_id),
            'cashforwork_brgyidpass' => $cashforworkbrgy_id,
            'cashforwork_idpass' => $cashforwork_model->get_brgy_cashforwork_id($cashforworkbrgy_id)));
        $this->load->view('footer');
    }
    public function cash_addbene($cashforworkbrgy_id)
    {

        $cashforwork_model = new cashforwork_model();
        $this->validateBeneAddForm();

        if (!$this->form_validation->run()){
            $this->load->view('header');
//            $this->load->view('navbar');
//            $this->load->view('sidebar');

            $this->load->view('cashforwork_beneAdd',array(
                'cash_benelist' => $cashforwork_model->get_bene_list($cashforworkbrgy_id),
                'countBene' => $cashforwork_model->get_countbene_benelist($cashforworkbrgy_id),
                'cashforwork_brgyidpass' => $cashforworkbrgy_id,
                'cashforwork_idpass' => $cashforwork_model->get_brgy_cashforwork_id($cashforworkbrgy_id)));
            $this->load->view('footer');


        } else {
           $bene_firstname = $this->input->post('bene_firstname');
           $bene_middlename = $this->input->post('bene_middlename');
           $bene_lastname = $this->input->post('bene_lastname');
           $bene_extname = $this->input->post('bene_extname');
            $myid = $this->session->userdata('uid');
            $cashforwork_idpass = $this->input->post('cashforwork_idpass');
            $cashforwork_brgyidpass = $this->input->post('cashforwork_brgyidpass');
            $cashforwork_muni_idpass = $this->input->post('cashforwork_muniidpass');


            $cashbeneResult = $cashforwork_model->insertBene($cashforwork_muni_idpass,$cashforwork_idpass,$bene_firstname,$bene_middlename,$bene_lastname,$bene_extname,$myid,$cashforwork_brgyidpass);
            if ($cashbeneResult == 1){
                $form_message = '<div class="alert alert-alt alert-success alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close" onClick="window.location.href=window.location.href">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <i class="icon wb-check" aria-hidden="true"></i><a class="alert-link" href="javascript:window.location.href=window.location.href">
                  Success!</a>
                </div>';

                $this->redirectIndexbene($cashforwork_brgyidpass);
            } else {
                $form_message = '<div class="alert alert-danger alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <i class="icon wb-close" aria-hidden="true"></i>
                  Fail!
                </div>';
                $this->load->view('header');
                $this->load->view('navbar');
                $this->load->view('sidebar');
                $this->load->view('cashforwork_beneAdd',array(
                    'cash_benelist' => $cashforwork_model->get_bene_list($cashforworkbrgy_id),
                    'cashforwork_brgyidpass' => $cashforworkbrgy_id,
                    'cashforwork_idpass' => $cashforwork_model->get_brgy_cashforwork_id($cashforworkbrgy_id)));
                $this->load->view('footer');
            }
        }

    }
    function upload_bene($cashforwork_id)
    {
        $this->load->view('header');
        $this->load->view('navbar');
        $this->load->view('sidebar');
        $cashforwork_idpass['cashforwork_id'] = $cashforwork_id;
        $this->load->view('upload_bene',$cashforwork_idpass);
        $this->load->view('footer');
    }
    function download_bene($cashforwork_id)
    {
        $cashforwork_model = new cashforwork_model();
        $this->load->view('header');
        $this->load->view('navbar');
        $this->load->view('sidebar');

        $cashforworkdata = $cashforwork_model->get_upload_filename($cashforwork_id);
        $name = $cashforworkdata->file_location;
        $data = file_get_contents("./uploads/cashforwork/".$name); // Read the file's contents


        force_download($name, $data);
        $this->load->view('footer');
    }
    function do_upload($cashforwork_id)
    {
        $config['upload_path'] = './uploads/cashforwork';
        $config['allowed_types'] = 'pdf|jpg|doc|docx';
        $config['max_size']	= '25000';
        $config['max_width']  = '1024';
        $config['max_height']  = '1024';
        $cashforwork_model = new cashforwork_model();
      $this->upload->initialize($config);

        if ( ! $this->upload->do_upload())
        {
            $error = array('error' => $this->upload->display_errors());
//            $cashforwork_muni_idpass = $cashforwork_model->get_brgy_cashforwork_id($cashforwork_id);
//
//            $cashforworkmuni_id = $cashforwork_muni_idpass->cashforwork_muni_id;
            $this->load->view('header');
            $this->load->view('navbar');
            $this->load->view('sidebar');
            $this->load->view('upload_bene', $error);
            $this->load->view('footer');
            $this->redirectIndex($cashforwork_id);
        }
        else
        {

            $data['upload_data'] = $this->upload->data();
            $myid = $this->session->userdata('uid');
//            $data['userfile'] =  $this->input->post('userfile');
            $file_name =  $this->upload->data()['file_name'];
            $updateUpload = $cashforwork_model->uploadBenefile($myid,$file_name,$cashforwork_id);
//            $cashforwork_muni_idpass = $cashforwork_model->get_brgy_cashforwork_id($cashforwork_id);
//            $cashforworkmuni_id = $cashforwork_muni_idpass->cashforwork_muni_id;
            $this->load->view('upload_success', $data);
            $this->redirectIndex($cashforwork_id);
        }
    }

    public function cashbene_edit($cashbene_id)
    {
        if ($cashbene_id != ""){
            $cashforwork_model = new cashforwork_model();

            $this->validateBeneAddForm();

            if (!$this->form_validation->run()){
                $form_message = '';
                $this->load->view('cashforwork_beneEdit',array(
                    'bene_details'=>$cashforwork_model->getbenebyid($cashbene_id)));
            } else {
//                $assistance_name = $this->input->post('assistance_name');
                $myid = $this->input->post('myid');
               $bene_firstname = $this->input->post('bene_firstname');
               $bene_middlename = $this->input->post('bene_middlename');
               $bene_lastname = $this->input->post('bene_lastname');
               $bene_extname = $this->input->post('bene_extname');
                $bene_idpass = $this->input->post('bene_idpass');
                $cashforwork_idpass = $this->input->post('cashforwork_idpass');


                $updateResult = $cashforwork_model->updateCashbene($bene_idpass, $bene_firstname, $bene_middlename, $bene_lastname, $bene_extname, $myid);
                if ($updateResult){
//                    $form_message = '<div class="alert alert-alt alert-success alert-dismissible" role="alert">
//                      <button type="button" class="close" data-dismiss="alert" aria-label="Close" onClick="window.location.href=assistance/index">
//                        <span aria-hidden="true">&times;</span>
//                      </button>
//                      <i class="icon wb-check" aria-hidden="true"></i><a class="alert-link" href="javascript:window.location.href=assistance/index">
//                      Success!</a>
//                    </div>';

                    $this->redirectIndexviewCash_bene($cashforwork_idpass);
                }
            }
        }
    }

    public function deleteBene($cashforwork_id,$cashbene_id)
    {

        $cashforwork_model = new cashforwork_model();
        if ($cashbene_id > 0){
            $deleteResult = $cashforwork_model->deleteCashBene($cashforwork_id,$cashbene_id);

            $this->redirectIndexviewCash_bene($cashforwork_id);
        }
    }
    public function populate_saro_amount()
    {

        if($_POST['saro_id'] > 0 and isset($_POST) and isset($_POST['saro_id']))
        {
            $saro_id = $_POST['saro_id'];
            $sarodata = $this->cashforwork_model->get_saro_balance($saro_id);

            $data1 = array(
                'type'        => 'hidden',
                'id'          => 'saro_amount',
                'name'       =>  'saro_amount',
                'max'   =>  $sarodata->saro_balance,
                'min'   => '0',
                'value'   =>  $sarodata->saro_balance,
                'class'        => 'form-control'
            );

            echo form_input($data1);

        }
    }
    protected function validateBeneAddForm()
    {
        $config = array(

            array(
                'field'   => 'bene_firstname',
                'label'   => 'Beneficiary First name',
                'rules'   => 'required'
            )
        );

        return $this->form_validation->set_rules($config);
    }
    public function assistance_session() {

        if(isset($_POST['natureofworklist']) and $_POST['natureofworklist'] > 0) {
            $_SESSION['natureofwork'] = $_POST['natureofworklist'];
        }
    }
    public function populate_prov() {
        if($_POST['region_code'] > 0 and isset($_POST) and isset($_POST['region_code'])) {

            $region_code = $_POST['region_code'];
            $provlist = $this->cashforwork_model->get_provinces($region_code);

            $province_list[''] = "Choose Province";
            foreach($provlist as $tempprov) {
                $province_list[$tempprov->prov_code] = $tempprov->prov_name;
            }

            $provlist_prop = 'id="provlist" required name="provlist" class="form-control" onChange="get_muni();" autofocus';

            echo form_dropdown('provlist', $province_list, '', $provlist_prop);
        }
    }

    public function populate_muni($cashforwork_id) {

        if($_POST['prov_code'] > 0 and isset($_POST) and isset($_POST['prov_code'])) {
            $prov_code = $_POST['prov_code'];
            $munilist = $this->cashforwork_model->get_muni($prov_code,$cashforwork_id);

            $muni_list[''] = "Choose Municipality";
            foreach($munilist as $tempmuni) {
                $muni_list[$tempmuni->city_code] = $tempmuni->city_name;
            }

            $munilist_prop = 'required="required" required  id="munilist" name="munilist" onchange="get_brgy();" class="form-control" autofocus';
            echo form_dropdown('munilist', $muni_list,'',$munilist_prop);

        }
    }
    public function populate_muni_edit($cashforwork_id,$city_code) {

        if($_POST['prov_code'] > 0 and isset($_POST) and isset($_POST['prov_code'])) {
            $prov_code = $_POST['prov_code'];
            $munilist = $this->cashforwork_model->get_muni_edit($prov_code,$cashforwork_id,$city_code);

            $muni_list[''] = "Choose Municipality";
            foreach($munilist as $tempmuni) {
                $muni_list[$tempmuni->city_code] = $tempmuni->city_name;
            }

            $munilist_prop = 'required="required" required  id="munilist" name="munilist" onchange="get_brgy();" class="form-control" autofocus';
            echo form_dropdown('munilist', $muni_list,'',$munilist_prop);

        }
    }
    public function populate_brgy($cashforwork_id) {
        if($_POST['city_code'] > 0 and isset($_POST) and isset($_POST['city_code'])) {
            $city_code = $_POST['city_code'];
            $brgylist = $this->cashforwork_model->get_brgy($city_code,$cashforwork_id);

            $brgy_list[''] = "Choose Barangay";
            foreach($brgylist as $tempbrgy) {
                $brgy_list[$tempbrgy->brgy_code] = $tempbrgy->brgy_name;
            }

            $brgylist_prop = 'required="required" required id="brgylist" name="brgylist" class="form-control" autofocus';
            echo form_dropdown('brgylist', $brgy_list,'',$brgylist_prop);
        }
    }
    public function populate_brgy_edit($cashforwork_id,$brgy_code) {

        if($_POST['city_code'] > 0 and isset($_POST) and isset($_POST['city_code'])) {
            $city_code = $_POST['city_code'];
            $brgylist = $this->cashforwork_model->get_brgy_edit($city_code,$cashforwork_id,$brgy_code);

            $brgy_list[''] = "Choose Barangay";
            foreach($brgylist as $tempbrgy) {
                $brgy_list[$tempbrgy->brgy_code] = $tempbrgy->brgy_name;
            }

            $brgylist_prop = 'required="required" required id="brgylist" name="brgylist" class="form-control" autofocus';
            echo form_dropdown('brgylist', $brgy_list,'',$brgylist_prop);
        }
    }
    public function init_rpmb_session() {
        if(isset($_POST['regionlist']) and $_POST['regionlist'] > 0) {
            $_SESSION['region'] = $_POST['regionlist'];
        }
        if(isset($_POST['provlist']) and $_POST['provlist'] > 0) {
            $_SESSION['province'] = $_POST['provlist'];
        }
        if(isset($_POST['munilist']) and $_POST['munilist'] > 0) {
            $_SESSION['muni'] = $_POST['munilist'];
        }
        if(isset($_POST['brgylist']) and $_POST['brgylist'] > 0) {
            $_SESSION['brgy'] = $_POST['brgylist'];
        }
    }

    protected function validateAddForm()
    {
        $config = array(
            array(
                'field' => 'provlist',
                'label' => 'provlist',
                'rules' => 'required'
            )
        );
        return $this->form_validation->set_rules($config);

    }


    protected function validateAddmuniForm()
    {
        $config = array(
            array(
                'field' => 'daily_payment',
                'label' => 'daily_payment',
                'rules' => 'required'
            ),
            array(
                'field' => 'munilist',
                'label' => 'munilist',
                'rules' => 'required'
            )
        );
        return $this->form_validation->set_rules($config);

    }
    protected function validateAddbrgyForm()
    {
        $config = array(
            array(
                'field' => 'number_bene',
                'label' => 'number_bene',
                'rules' => 'required'
            )
        );
        return $this->form_validation->set_rules($config);

    }
    public function redirectIndex()
    {
        $page = base_url('cashforwork/index');

        header("LOCATION: $page");
    }
    public function redirectIndexbene($cashforwork_brgyidpass)
    {
        $page = base_url('cashforwork/cash_benelist/'.$cashforwork_brgyidpass.'');

        header("LOCATION: $page");
    }
    public function redirectIndexviewCash_muni($cashforwork_id)
    {
        $page = base_url('cashforwork/viewCash_muni/'.$cashforwork_id.'');

        header("LOCATION: $page");
    }
    public function redirectIndexviewBrgy_muni($cashforwork_muni_id)
    {
        $page = base_url('cashforwork/viewCash_brgy/'.$cashforwork_muni_id.'');

        header("LOCATION: $page");
    }
    public function redirectIndexviewCash_bene($cashforwork_id)
    {
        $page = base_url('cashforwork/cash_addbene/'.$cashforwork_id.'');

        header("LOCATION: $page");
    }
}