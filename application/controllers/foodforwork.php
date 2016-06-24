<?php
/**
 * Created by PhpStorm.
 * User: ljesaclayan
 * Date: 2/11/2016
 * Time: 3:26 PM
z*/


class foodforwork extends CI_Controller
{

    public function index(){
        $foodforwork_model = new foodforwork_model();
        $this->load->view('header');
        $this->load->view('navbar');
        $this->load->view('sidebar');
        $region_code = $this->session->userdata('uregion');
        $this->load->view('foodforwork_list',array(
            'project' => $foodforwork_model->get_project($region_code)));
        $this->load->view('footer');
    }
    public function finalize_saro($foodforwork_id)
    {
        $foodforwork_model = new foodforwork_model();
        if ($foodforwork_id > 0){
            $getResult = $foodforwork_model->finalize($foodforwork_id);
            $total_cost = $getResult->total_cost;
            $saro = $getResult->saro_id;
            $regionsaro = $this->session->userdata('uregion');
            $deleteResult = $foodforwork_model->finalize_update($total_cost,$saro,$regionsaro);

            if ($deleteResult){
                $this->load->view('header');
                $this->load->view('navbar');
                $this->load->view('sidebar');
                $region_code = $this->session->userdata('uregion');
                $this->load->view('foodforwork_list',array(
                    'project' => $foodforwork_model->get_project($region_code)
                ));

                $this->load->view('footer');
            }
            $this->redirectIndex();

        }
    }
    public function masterviewfoodforwork($foodforwork_id)
    {
        $foodforwork_model = new foodforwork_model();
        $this->load->view('header');
        $this->load->view('navbar');
        $this->load->view('sidebar');
//        $region_code = $this->session->userdata('uregion');
        $this->load->view('foodforwork_view',array(
            'project' => $foodforwork_model->viewfoodforwork($foodforwork_id),
            'call_muni' => $foodforwork_model->viewfoodforwork_callmuni($foodforwork_id),
            'call_brgy' => $foodforwork_model->viewfoodforwork_callbrgy($foodforwork_id)
        ));
        $this->load->view('footer');
    }
    public function foodforworkBenelist($foodforwork_id)
    {
        $foodforwork_model = new foodforwork_model();
        $this->load->view('header');
        $this->load->view('navbar');
        $this->load->view('sidebar');
//        $region_code = $this->session->userdata('uregion');
        $this->load->view('foodforwork_viewbenelist',array(
            'project' => $foodforwork_model->viewfoodforwork($foodforwork_id),
            'call_muni' => $foodforwork_model->viewfoodforwork_callmuni($foodforwork_id),
            'call_brgy' => $foodforwork_model->viewfoodforwork_callbrgy($foodforwork_id),
            'call_bene' => $foodforwork_model->viewfoodforwork_callbenelist($foodforwork_id)
        ));
        $this->load->view('footer');
    }
    public function updatefoodforwork($foodforwork_id)
    {
        $foodforwork_model = new foodforwork_model();

        $this->validateAddForm();


        if ($this->form_validation->run() == FALSE) {
            $this->assistance_session();
            $this->init_rpmb_session();
            $regionsaro = $this->session->userdata('uregion');
            $getList['sarolist'] = $foodforwork_model->get_saro($regionsaro);
            $getList['natureofworklist'] = $foodforwork_model->get_work_nature();
            $getList['regionlist'] = $foodforwork_model->get_regions();
            $getList['foodforworkdata'] = $foodforwork_model->get_project_byid($foodforwork_id);

            $this->load->view('header');
            $this->load->view('navbar');
            $this->load->view('sidebar');

            $this->load->view('foodforwork_edit', $getList);
            $this->load->view('footer');
        }
        else
        {

            $myid = $this->input->post('myid');
            $foodforwork_id1 = $this->input->post('foodforwork_id');
            $project_title = $this->input->post('project_title');
            $sarolist = $this->input->post('sarolist');
            $regionlist = $this->input->post('region_pass');
            $provlist = $this->input->post('provlist');
            $natureofworklist = $this->input->post('natureofworklist');
            $daily_payment = $this->input->post('daily_payment');
            $number_of_bene = $this->input->post('number_of_bene');
            $cost_of_assistance = $this->input->post('cost_of_assistance');
            $number_days = $this->input->post('number_days');
            $updateResult = $foodforwork_model->updatefoodforwork($sarolist,$foodforwork_id1,$myid,$project_title,$regionlist,$provlist
                ,$natureofworklist,$number_days,$daily_payment,$number_of_bene,$cost_of_assistance);
            if ($updateResult) {

                $this->load->view('header');
                $this->load->view('navbar');
                $this->load->view('sidebar');
                $region_code = $this->session->userdata('uregion');
                $this->load->view('foodforwork_list',array(
                    'project' => $foodforwork_model->get_project($region_code)
                ));
                $this->load->view('footer');
            }

            $this->redirectIndex();
        }
    }

    public function deletefoodforwork($foodforwork_id)
    {
        $foodforwork_model = new foodforwork_model();
        if ($foodforwork_id > 0){
            $deleteResult = $foodforwork_model->deletefoodforwork($foodforwork_id);

            if ($deleteResult){
                $this->load->view('header');
                $this->load->view('navbar');
                $this->load->view('sidebar');
                $region_code = $this->session->userdata('uregion');
                $this->load->view('foodforwork_list',array(
                    'project' => $foodforwork_model->get_project($region_code)
                ));

                $this->load->view('footer');
            }
            $this->redirectIndex();
        }
    }
    public function deletefoodforwork_muni($foodforwork_muni_id)
    {
        $foodforwork_model = new foodforwork_model();
        if ($foodforwork_muni_id > 0){
            $getList = $foodforwork_model->get_project_prov_muni($foodforwork_muni_id);
            $food_id = $getList->foodforwork_id;
            $deleteResult = $foodforwork_model->deletefood_muni_and_brgy($foodforwork_muni_id);
            }
            $this->redirectIndexviewfood_muni($food_id);
        }
    public function deletefoodforwork_brgy($foodforwork_brgy_id)
    {
        $foodforwork_model = new foodforwork_model();
        if ($foodforwork_brgy_id > 0){
            $getList = $foodforwork_model->get_project_muni_brgy($foodforwork_brgy_id);
            $foodforwork_muni_id = $getList->foodforwork_muni_id;
            $deleteResult = $foodforwork_model->deletefood_brgy($foodforwork_brgy_id);
        }
        $this->redirectIndexviewBrgy_muni($foodforwork_muni_id);
    }

    public function addfoodforwork()
    {
        $foodforwork_model = new foodforwork_model();

        $this->validateAddForm();

        if ($this->form_validation->run() == FALSE) {
            $this->assistance_session();
            $this->init_rpmb_session();
            $regionsaro = $this->session->userdata('uregion');
            $getList['fundlist'] = $foodforwork_model->get_fund_source();
            $getList['sarolist'] = $foodforwork_model->get_saro($regionsaro);
            $getList['natureofworklist'] = $foodforwork_model->get_work_nature();
            $getList['regionlist'] = $foodforwork_model->get_regions();

            if(isset($_SESSION['province']) or isset($_SESSION['region'])) {
                $getList['provlist'] = $foodforwork_model->get_provinces($_SESSION['region']);
            }
            if(isset($_SESSION['muni']) or isset($_SESSION['province'])) {
                $getList['munilist'] = $foodforwork_model->get_muni($_SESSION['province']);
            }
            if(isset($_SESSION['brgy']) or isset($_SESSION['muni'])) {
                $getList['brgylist'] = $foodforwork_model->get_brgy($_SESSION['muni']);
            }

            $this->load->view('header');
            $this->load->view('navbar');
            $this->load->view('sidebar');

            $this->load->view('foodforwork_add', $getList);
            $this->load->view('footer');
        }
        else
        {
            $myid = $this->input->post('myid');
            $project_title = $this->input->post('project_title');
            $saro = $this->input->post('sarolist');
            $fundsource = $this->input->post('fundsource');
            $regionlist = $this->input->post('region_pass');
            $provlist = $this->input->post('provlist');
            $natureofworklist = $this->input->post('natureofworklist');
            $daily_payment = $this->input->post('daily_payment');
            $number_of_bene = $this->input->post('number_of_bene');
            $cost_of_assistance = $this->input->post('cost_of_assistance');
            $number_days = $this->input->post('number_days');

            $addResult = $foodforwork_model->insertProject($fundsource,$number_of_bene,$cost_of_assistance,$saro,$myid,$project_title,$regionlist,$provlist
                ,$natureofworklist,$daily_payment,$number_days);
            if ($addResult){
                $this->load->view('header');
                $this->load->view('navbar');
                $this->load->view('sidebar');
                $region_code = $this->session->userdata('uregion');
                $this->load->view('foodforwork_list',array(
                    'project' => $foodforwork_model->get_project($region_code)
                ));
                $this->load->view('footer');
            }
            $this->redirectIndexviewfood_muni($addResult,$region_code);
        }
    }

    public function viewfood_muni($foodforwork_id)
    {
        $foodforwork_model = new foodforwork_model();

        $getList['foodforworkpass_id'] = $foodforwork_id;
//            $getList['provlist'] = $foodforwork_model->get_provinces($region_code);
        $getList['proj_prov'] = $foodforwork_model->get_project_province($foodforwork_id);
        $getList['title'] = $foodforwork_model->get_project_title($foodforwork_id);
        $getList['foodmuni_list'] = $foodforwork_model->get_foodmuni_list($foodforwork_id);
        $getList['foodforworkinfo'] = $foodforwork_model->get_foodforworkDetails($foodforwork_id);

        $getList['countBene'] = $foodforwork_model->get_countbene_muni($foodforwork_id);
        $this->load->view('header');
        $this->load->view('navbar');
        $this->load->view('sidebar');

        $this->load->view('foodforwork_muni_list', $getList);
        $this->load->view('footer');

    }
    public function addfood_muni($foodforwork_id)
    {
        $foodforwork_model = new foodforwork_model();

        $this->validateAddmuniForm();

        if ($this->form_validation->run() == FALSE) {
            $this->init_rpmb_session();
            $getList['foodforworkpass_id'] = $foodforwork_id;
//            $getList['region_pass'] = $region_code;
//            $getList['provlist'] = $foodforwork_model->get_provinces($region_code);
            $getList['proj_prov'] = $foodforwork_model->get_project_province($foodforwork_id);
            $getList['title'] = $foodforwork_model->get_project_title($foodforwork_id);
            if(isset($_SESSION['muni']) or isset($_SESSION['province'])) {
                $getList['munilist'] = $foodforwork_model->get_muni($_SESSION['province']);
            }
            if(isset($_SESSION['brgy']) or isset($_SESSION['muni'])) {
                $getList['brgylist'] = $foodforwork_model->get_brgy($_SESSION['muni']);
            }

            $this->load->view('header');
            $this->load->view('navbar');
            $this->load->view('sidebar');

            $this->load->view('foodforwork_muni_add', $getList);
            $this->load->view('footer');
        }
        else
        {
            $region_code = $this->session->userdata('uregion');
//            $assistancelist = 2;
            $myid = $this->input->post('myid');
            $provlist = $this->input->post('prov_pass');
//            $saro_id = $this->input->post('saro_id');
            $foodforworkpass_id = $this->input->post('foodforworkpass_id');
            $munilist = $this->input->post('munilist');
            $daily_payment = $this->input->post('daily_payment');
            $number_bene = $this->input->post('number_bene');
            $cost_of_assistance = $this->input->post('cost_of_assistance');
            $addResult = $foodforwork_model->insertfoodmuni($myid,$foodforworkpass_id,$provlist,$munilist
                ,$daily_payment,$number_bene,$cost_of_assistance);
            if ($addResult){
                $getList['foodforworkpass_id'] = $foodforwork_id;
                $getList['provlist'] = $foodforwork_model->get_provinces($region_code);
                $getList['proj_prov'] = $foodforwork_model->get_project_province($foodforwork_id);
                $getList['title'] = $foodforwork_model->get_project_title($foodforwork_id);
                $getList['foodmuni_list'] = $foodforwork_model->get_foodmuni_list($foodforwork_id);
                $this->load->view('header');
                $this->load->view('navbar');
                $this->load->view('sidebar');

                $this->load->view('foodforwork_muni_list', $getList);
                $this->load->view('footer');

            }
            $this->redirectIndexviewfood_muni($foodforworkpass_id);
        }
    }
    public function updatefoodforwork_muni($foodforwork_muni_id)
    {
        $foodforwork_model = new foodforwork_model();
        $this->validateAddmuniForm();
        if ($this->form_validation->run() == FALSE) {
            $this->assistance_session();
            $this->init_rpmb_session();

            $getList['proj_prov'] = $foodforwork_model->get_project_prov_muni($foodforwork_muni_id);
            $proj_prov = $foodforwork_model->get_project_prov_muni($foodforwork_muni_id);
            $foodforwork_id = $proj_prov->foodforwork_id;

            $getList['title'] = $foodforwork_model->get_project_title($foodforwork_id);
            $getList['countBene'] = $foodforwork_model->get_countbene_muni($foodforwork_id);
            if(isset($_SESSION['muni']) or isset($_SESSION['province'])) {
                $getList['munilist'] = $foodforwork_model->get_muni($_SESSION['province']);
            }
            if(isset($_SESSION['brgy']) or isset($_SESSION['muni'])) {
                $getList['brgylist'] = $foodforwork_model->get_brgy($_SESSION['muni']);
            }
            $this->load->view('header');
//            $this->load->view('navbar');
//            $this->load->view('sidebar');
            $this->load->view('foodforwork_muni_edit', $getList);
            $this->load->view('footer');
        }
        else
        {
            $myid = $this->input->post('myid');
            $food_muni_id = $this->input->post('food_muni_id');
            $foodforwork_id = $this->input->post('foodforwork_id');
            $munilist = $this->input->post('munilist');
            $number_of_bene = $this->input->post('number_bene');
            $cost_of_assistance_muni = $this->input->post('cost_of_assistance');
            $updateResult = $foodforwork_model->updatefoodforwork_muni($myid,$food_muni_id,$munilist,$number_of_bene
                ,$cost_of_assistance_muni);
//            if ($updateResult) {
//
//                $getList['proj_prov'] = $foodforwork_model->get_project_province($foodforwork_id);
//                $getList['title'] = $foodforwork_model->get_project_title($foodforwork_id);
//                $getList['foodmuni_list'] = $foodforwork_model->get_foodmuni_list($foodforwork_id);
//                $getList['foodforworkinfo'] = $foodforwork_model->get_foodforworkDetails($foodforwork_id);
//                $this->load->view('header');
//                $this->load->view('navbar');
//                $this->load->view('sidebar');
//                $this->load->view('foodforwork_muni_list', $getList);
//                $this->load->view('footer');
//            }

            $this->redirectIndexviewfood_muni($foodforwork_id);
        }
    }
    public function viewfood_brgy($foodforwork_muni_id)
    {
        $foodforwork_model = new foodforwork_model();

        $getList['foodforworkpassmuni_id'] = $foodforwork_muni_id;
//            $getList['provlist'] = $foodforwork_model->get_provinces($region_code);
        $getList['proj_prov'] = $foodforwork_model->get_project_prov_muni($foodforwork_muni_id);
        $getList['foodbrgy_list'] = $foodforwork_model->get_foodbrgy_list($foodforwork_muni_id);
//        $getList['foodforworkinfo'] = $foodforwork_model->get_foodforworkDetails($foodforwork_muni_id);
        $this->load->view('header');
//        $this->load->view('navbar');
//        $this->load->view('sidebar');

        $this->load->view('foodforwork_brgy_list', $getList);
        $this->load->view('footer');

    }
    public function updatefoodforwork_brgy($foodforwork_brgy_id)
    {
        $foodforwork_model = new foodforwork_model();

        $this->validateAddbrgyForm();


        if ($this->form_validation->run() == FALSE) {
            $this->assistance_session();
            $this->init_rpmb_session();

//            $getList['foodforworkpassmuni_id'] = $foodforwork_muni_id;
//            $getList['provlist'] = $foodforwork_model->get_provinces($region_code);
            $getList['proj_brgy'] = $foodforwork_model->get_project_muni_brgy($foodforwork_brgy_id);
            $proj_brgy = $foodforwork_model->get_project_muni_brgy($foodforwork_brgy_id);
            $foodforwork_muni_id = $proj_brgy->foodforwork_muni_id;
            $getList['countBene'] = $foodforwork_model->get_countbene_brgy($foodforwork_muni_id);
            $getList['proj_prov'] = $foodforwork_model->get_project_prov_muni($foodforwork_muni_id);
            if(isset($_SESSION['brgy']) or isset($_SESSION['muni'])) {
                $getList['brgylist'] = $foodforwork_model->get_brgy($_SESSION['muni']);
            }
            $this->load->view('header');
//            $this->load->view('navbar');
//            $this->load->view('sidebar');
            $this->load->view('foodforwork_brgy_edit', $getList);
            $this->load->view('footer');
        }
        else
        {
            $myid = $this->input->post('myid');
            $food_muni_id_pass = $this->input->post('food_muni_id_pass');
//            $foodforwork_id = $this->input->post('foodforwork_id');
            $brgylist = $this->input->post('brgylist');
            $food_brgy_id_pass = $this->input->post('food_brgy_id_pass');
            $number_of_bene = $this->input->post('number_bene');
            $cost_of_assistance_brgy = $this->input->post('cost_of_assistance');

            $updateResult = $foodforwork_model->updatefoodforwork_brgy($food_brgy_id_pass,$myid,$brgylist,$number_of_bene
                ,$cost_of_assistance_brgy);
            if ($updateResult) {
                $getList['proj_prov'] = $foodforwork_model->get_project_prov_muni($food_muni_id_pass);
                $getList['foodbrgy_list'] = $foodforwork_model->get_foodbrgy_list($food_muni_id_pass);

                $this->load->view('header');
                $this->load->view('navbar');
                $this->load->view('sidebar');

                $this->load->view('foodforwork_brgy_list', $getList);
                $this->load->view('footer');
            }

            $this->redirectIndexviewBrgy_muni($food_muni_id_pass);
        }
    }
//    function view_list()
//    {
//        $this->load->view('foodforwork_brgy_add');
//    }
    public function addfood_brgy($foodforwork_muni_id)
    {
        $foodforwork_model = new foodforwork_model();

        $this->validateAddbrgyForm();

        if ($this->form_validation->run() == FALSE) {
            $this->init_rpmb_session();
//            $getList['foodforworkpass_id'] = $foodforwork_id;
            $getList['foodforworkpassmuni_id'] = $foodforwork_muni_id;
//            $getList['provlist'] = $foodforwork_model->get_provinces($region_code);

            $getList['countBene'] = $foodforwork_model->get_countbene_brgy($foodforwork_muni_id);
            $getList['proj_prov'] = $foodforwork_model->get_project_prov_muni($foodforwork_muni_id);
            $getList['foodbrgy_list'] = $foodforwork_model->get_foodbrgy_list($foodforwork_muni_id);

            if(isset($_SESSION['brgy']) or isset($_SESSION['muni'])) {
                $getList['brgylist'] = $foodforwork_model->get_brgy($_SESSION['muni']);
            }

            $this->load->view('header');
//            $this->load->view('navbar');
//            $this->load->view('sidebar');

            $this->load->view('foodforwork_brgy_add', $getList);
            $this->load->view('footer');
        }
        else
        {

            $myid = $this->input->post('myid');
            $foodforworkpass_id = $this->input->post('foodforwork_id_pass');
            $food_muni_id_pass = $this->input->post('food_muni_id_pass');
            $munilist = $this->input->post('muni_pass');
            $brgylist = $this->input->post('brgylist');
            $number_bene = $this->input->post('number_bene');
            $cost_of_assistance_brgy = $this->input->post('cost_of_assistance');
            $addResult = $foodforwork_model->insertfoodbrgy($myid,$foodforworkpass_id,$food_muni_id_pass,$munilist ,$brgylist,$number_bene,$cost_of_assistance_brgy);
            if ($addResult){

//                $getList['foodforworkpassmuni_id'] = $foodforwork_muni_id;
                $getList['proj_prov'] = $foodforwork_model->get_project_prov_muni($foodforwork_muni_id);
                $getList['foodbrgy_list'] = $foodforwork_model->get_foodbrgy_list($foodforwork_muni_id);

                $this->load->view('header');
                $this->load->view('navbar');
                $this->load->view('sidebar');

                $this->load->view('foodforwork_brgy_list', $getList);
                $this->load->view('footer');

            }
            $this->redirectIndexviewBrgy_muni($food_muni_id_pass);
        }
    }

    public function food_benelist($foodforworkbrgy_id)
    {
        $foodforwork_model = new foodforwork_model();
        $this->load->view('header');
//        $this->load->view('navbar');
//        $this->load->view('sidebar');
//        $foodforwork_muni_id_qry = $foodforwork_model->get_brgy_foodforwork_id($foodforworkbrgy_id);
//        $foodforwork_muni_id = $foodforwork_muni_id_qry->foodforwork_muni_id;
        $this->load->view('foodforwork_beneAdd',array(
            'food_benelist' => $foodforwork_model->get_bene_list($foodforworkbrgy_id),
            'countBene' => $foodforwork_model->get_countbene_benelist($foodforworkbrgy_id),
            'foodforwork_brgyidpass' => $foodforworkbrgy_id,
            'foodforwork_idpass' => $foodforwork_model->get_brgy_foodforwork_id($foodforworkbrgy_id)));
        $this->load->view('footer');
    }
    public function food_addbene($foodforworkbrgy_id)
    {

        $foodforwork_model = new foodforwork_model();
        $this->validateBeneAddForm();

        if (!$this->form_validation->run()){
            $this->load->view('header');
//            $this->load->view('navbar');
//            $this->load->view('sidebar');
//            $foodforwork_muni_id_qry = $foodforwork_model->get_brgy_foodforwork_id($foodforworkbrgy_id);
//            $foodforwork_muni_id = $foodforwork_muni_id_qry->foodforwork_muni_id;
            $this->load->view('foodforwork_beneAdd',array(
                'food_benelist' => $foodforwork_model->get_bene_list($foodforworkbrgy_id),
                'countBene' => $foodforwork_model->get_countbene_benelist($foodforworkbrgy_id),
                'foodforwork_brgyidpass' => $foodforworkbrgy_id,
                'foodforwork_idpass' => $foodforwork_model->get_brgy_foodforwork_id($foodforworkbrgy_id)));
            $this->load->view('footer');


        } else {
           $bene_firstname = $this->input->post('bene_firstname');
           $bene_middlename = $this->input->post('bene_middlename');
           $bene_lastname = $this->input->post('bene_lastname');
           $bene_extname = $this->input->post('bene_extname');
            $myid = $this->session->userdata('uid');
            $foodforwork_idpass = $this->input->post('foodforwork_idpass');
            $foodforwork_brgyidpass = $this->input->post('foodforwork_brgyidpass');
            $foodforwork_muni_idpass = $this->input->post('foodforwork_muniidpass');


            $foodbeneResult = $foodforwork_model->insertBene($foodforwork_muni_idpass,$foodforwork_idpass,$bene_firstname,$bene_middlename,$bene_lastname,$bene_extname,$myid,$foodforwork_brgyidpass);
            if ($foodbeneResult == 1){
                $form_message = '<div class="alert alert-alt alert-success alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close" onClick="window.location.href=window.location.href">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <i class="icon wb-check" aria-hidden="true"></i><a class="alert-link" href="javascript:window.location.href=window.location.href">
                  Success!</a>
                </div>';

                $this->redirectIndexbene($foodforwork_brgyidpass);
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
                $this->load->view('foodforwork_beneAdd',array(
                    'food_benelist' => $foodforwork_model->get_bene_list($foodforworkbrgy_id),
                    'foodforwork_brgyidpass' => $foodforworkbrgy_id,
                    'foodforwork_idpass' => $foodforwork_model->get_brgy_foodforwork_id($foodforworkbrgy_id)));
                $this->load->view('footer');
            }
        }

    }
    function upload_bene($foodforwork_id)
    {
        $this->load->view('header');
        $this->load->view('navbar');
        $this->load->view('sidebar');
        $foodforwork_idpass['foodforwork_id'] = $foodforwork_id;
        $this->load->view('upload_bene',$foodforwork_idpass);
        $this->load->view('footer');
    }
    function download_bene($foodforwork_id)
    {
        $foodforwork_model = new foodforwork_model();
        $this->load->view('header');
        $this->load->view('navbar');
        $this->load->view('sidebar');

        $foodforworkdata = $foodforwork_model->get_upload_filename($foodforwork_id);
        $name = $foodforworkdata->file_location;
        $data = file_get_contents("./uploads/foodforwork/".$name); // Read the file's contents


        force_download($name, $data);
        $this->load->view('footer');
    }
    function do_upload($foodforwork_id)
    {
        $config['upload_path'] = './uploads/foodforwork';
        $config['allowed_types'] = 'pdf|jpg|doc|docx';
        $config['max_size']	= '25000';
        $config['max_width']  = '1024';
        $config['max_height']  = '1024';
        $foodforwork_model = new foodforwork_model();
      $this->upload->initialize($config);

        if ( ! $this->upload->do_upload())
        {
            $error = array('error' => $this->upload->display_errors());
//            $foodforwork_muni_idpass = $foodforwork_model->get_brgy_foodforwork_id($foodforwork_id);
//
//            $foodforworkmuni_id = $foodforwork_muni_idpass->foodforwork_muni_id;
            $this->load->view('header');
            $this->load->view('navbar');
            $this->load->view('sidebar');
            $this->load->view('upload_bene', $error);
            $this->load->view('footer');
            $this->redirectIndex($foodforwork_id);
        }
        else
        {

            $data['upload_data'] = $this->upload->data();
            $myid = $this->session->userdata('uid');
//            $data['userfile'] =  $this->input->post('userfile');
            $file_name =  $this->upload->data()['file_name'];
            $updateUpload = $foodforwork_model->uploadBenefile($myid,$file_name,$foodforwork_id);
//            $foodforwork_muni_idpass = $foodforwork_model->get_brgy_foodforwork_id($foodforwork_id);
//            $foodforworkmuni_id = $foodforwork_muni_idpass->foodforwork_muni_id;
            $this->load->view('upload_success', $data);
            $this->redirectIndex($foodforwork_id);
        }
    }

    public function foodbene_edit($foodbene_id)
    {
        if ($foodbene_id != ""){
            $foodforwork_model = new foodforwork_model();

            $this->validateBeneAddForm();

            if (!$this->form_validation->run()){
                $form_message = '';
                $this->load->view('foodforwork_beneEdit',array(
                    'bene_details'=>$foodforwork_model->getbenebyid($foodbene_id)));
            } else {
//                $assistance_name = $this->input->post('assistance_name');
                $myid = $this->input->post('myid');
               $bene_firstname = $this->input->post('bene_firstname');
               $bene_middlename = $this->input->post('bene_middlename');
               $bene_lastname = $this->input->post('bene_lastname');
               $bene_extname = $this->input->post('bene_extname');
                $bene_idpass = $this->input->post('bene_idpass');
                $foodforwork_idpass = $this->input->post('foodforwork_idpass');


                $updateResult = $foodforwork_model->updatefoodbene($bene_idpass, $bene_firstname, $bene_middlename, $bene_lastname, $bene_extname, $myid);
                if ($updateResult){
//                    $form_message = '<div class="alert alert-alt alert-success alert-dismissible" role="alert">
//                      <button type="button" class="close" data-dismiss="alert" aria-label="Close" onClick="window.location.href=assistance/index">
//                        <span aria-hidden="true">&times;</span>
//                      </button>
//                      <i class="icon wb-check" aria-hidden="true"></i><a class="alert-link" href="javascript:window.location.href=assistance/index">
//                      Success!</a>
//                    </div>';

                    $this->redirectIndexviewfood_bene($foodforwork_idpass);
                }
            }
        }
    }

    public function deleteBene($foodforwork_id,$foodbene_id)
    {

        $foodforwork_model = new foodforwork_model();
        if ($foodbene_id > 0){
            $deleteResult = $foodforwork_model->deletefoodBene($foodforwork_id,$foodbene_id);

            $this->redirectIndexviewfood_bene($foodforwork_id);
        }
    }
    public function populate_saro_amount()
    {

        if($_POST['saro_id'] > 0 and isset($_POST) and isset($_POST['saro_id']))
        {
            $saro_id = $_POST['saro_id'];
            $sarodata = $this->foodforwork_model->get_saro_balance($saro_id);

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
    public function populate_saa_list()
    {

//        $saadata = $this->cashforwork_model->get_saa($fundsource_id);
        $label = array(
            'for'          => 'sarolist',
            'class'        => 'control-label'
        );
        echo form_label('SAA Number:', '', $label);
        if($_POST['fundsource_id'] > 0 and isset($_POST) and isset($_POST['fundsource_id']))
        {
            $fundsource_id = $_POST['fundsource_id'];
            $saa_data = $this->foodforwork_model->get_saa($fundsource_id);
//            print_r($saa_data);
            $saalist[''] = "Choose Saa Number";
            foreach($saa_data as $saa_select) {
                $saalist[$saa_select->saa_id] = $saa_select->saa_number.' - (₱'. $saa_select->saa_balance.')';
            }

            $saalist_prop = 'name="sarolist" id="sarolist" class="form-control"  required="required" onchange="get_saro_balance();" autofocus';

            echo form_dropdown('sarolist', $saalist, '', $saalist_prop);
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
            $provlist = $this->foodforwork_model->get_provinces($region_code);

            $province_list[''] = "Choose Province";
            foreach($provlist as $tempprov) {
                $province_list[$tempprov->prov_code] = $tempprov->prov_name;
            }

            $provlist_prop = 'id="provlist" required name="provlist" class="form-control" onChange="get_muni();" autofocus';

            echo form_dropdown('provlist', $province_list, '', $provlist_prop);
        }
    }

    public function populate_muni($foodforwork_id) {

        if($_POST['prov_code'] > 0 and isset($_POST) and isset($_POST['prov_code'])) {
            $prov_code = $_POST['prov_code'];
            $munilist = $this->foodforwork_model->get_muni($prov_code,$foodforwork_id);

            $muni_list[''] = "Choose Municipality";
            foreach($munilist as $tempmuni) {
                $muni_list[$tempmuni->city_code] = $tempmuni->city_name;
            }

            $munilist_prop = 'required="required" required  id="munilist" name="munilist" onchange="get_brgy();" class="form-control" autofocus';
            echo form_dropdown('munilist', $muni_list,'',$munilist_prop);

        }
    }
    public function populate_muni_edit($foodforwork_id,$city_code) {

        if($_POST['prov_code'] > 0 and isset($_POST) and isset($_POST['prov_code'])) {
            $prov_code = $_POST['prov_code'];
            $munilist = $this->foodforwork_model->get_muni_edit($prov_code,$foodforwork_id,$city_code);

            $muni_list[''] = "Choose Municipality";
            foreach($munilist as $tempmuni) {
                $muni_list[$tempmuni->city_code] = $tempmuni->city_name;
            }

            $munilist_prop = 'required="required" required  id="munilist" name="munilist" onchange="get_brgy();" class="form-control" autofocus';
            echo form_dropdown('munilist', $muni_list,'',$munilist_prop);

        }
    }
    public function populate_brgy($foodforwork_id) {
        if($_POST['city_code'] > 0 and isset($_POST) and isset($_POST['city_code'])) {
            $city_code = $_POST['city_code'];
            $brgylist = $this->foodforwork_model->get_brgy($city_code,$foodforwork_id);

            $brgy_list[''] = "Choose Barangay";
            foreach($brgylist as $tempbrgy) {
                $brgy_list[$tempbrgy->brgy_code] = $tempbrgy->brgy_name;
            }

            $brgylist_prop = 'required="required" required id="brgylist" name="brgylist" class="form-control" autofocus';
            echo form_dropdown('brgylist', $brgy_list,'',$brgylist_prop);
        }
    }
    public function populate_brgy_edit($foodforwork_id,$brgy_code) {

        if($_POST['city_code'] > 0 and isset($_POST) and isset($_POST['city_code'])) {
            $city_code = $_POST['city_code'];
            $brgylist = $this->foodforwork_model->get_brgy_edit($city_code,$foodforwork_id,$brgy_code);

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
        $page = base_url('foodforwork/index');

        header("LOCATION: $page");
    }
    public function redirectIndexbene($foodforwork_brgyidpass)
    {
        $page = base_url('foodforwork/food_benelist/'.$foodforwork_brgyidpass.'');

        header("LOCATION: $page");
    }
    public function redirectIndexviewfood_muni($foodforwork_id)
    {
        $page = base_url('foodforwork/viewfood_muni/'.$foodforwork_id.'');

        header("LOCATION: $page");
    }
    public function redirectIndexviewBrgy_muni($foodforwork_muni_id)
    {
        $page = base_url('foodforwork/viewfood_brgy/'.$foodforwork_muni_id.'');

        header("LOCATION: $page");
    }
    public function redirectIndexviewfood_bene($foodforwork_id)
    {
        $page = base_url('foodforwork/food_addbene/'.$foodforwork_id.'');

        header("LOCATION: $page");
    }
}