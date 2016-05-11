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

    public function updateCashforwork($cashforwork_id)
    {
        $cashforwork_model = new cashforwork_model();

        $this->validateAddForm();


        if ($this->form_validation->run() == FALSE) {
            $this->assistance_session();
            $this->init_rpmb_session();
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
            $cashforwork_id = $this->input->post('cashforwork_id');
            $project_title = $this->input->post('project_title');
            $regionlist = $this->input->post('region_pass');
            $provlist = $this->input->post('provlist');
            $natureofworklist = $this->input->post('natureofworklist');
            $daily_payment = $this->input->post('daily_payment');

            $number_days = $this->input->post('number_days');

            $updateResult = $cashforwork_model->updateCashforwork($cashforwork_id,$myid,$project_title,$regionlist,$provlist
                ,$natureofworklist,$number_days,$daily_payment);
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
    public function updateCashforwork_muni($cashforwork_muni_id)
    {
        $cashforwork_model = new cashforwork_model();

        $this->validateAddmuniForm();


        if ($this->form_validation->run() == FALSE) {
            $this->assistance_session();
            $this->init_rpmb_session();

            $getList['proj_prov'] = $cashforwork_model->get_project_prov_muni($cashforwork_muni_id);
            if(isset($_SESSION['muni']) or isset($_SESSION['province'])) {
                $getList['munilist'] = $cashforwork_model->get_muni($_SESSION['province']);
            }
            if(isset($_SESSION['brgy']) or isset($_SESSION['muni'])) {
                $getList['brgylist'] = $cashforwork_model->get_brgy($_SESSION['muni']);
            }
            $this->load->view('header');
            $this->load->view('navbar');
            $this->load->view('sidebar');

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
            if ($updateResult) {

                $getList['proj_prov'] = $cashforwork_model->get_project_province($cashforwork_id);
                $getList['title'] = $cashforwork_model->get_project_title($cashforwork_id);
                $getList['cashmuni_list'] = $cashforwork_model->get_cashmuni_list($cashforwork_id);
                $getList['cashforworkinfo'] = $cashforwork_model->get_cashforworkDetails($cashforwork_id);
                $this->load->view('header');
                $this->load->view('navbar');
                $this->load->view('sidebar');
                $this->load->view('cashforwork_muni_list', $getList);
                $this->load->view('footer');
            }

            $this->redirectIndexviewCash_muni($cashforwork_id);
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
    public function addCashforwork()
    {
        $cashforwork_model = new cashforwork_model();

        $this->validateAddForm();

        if ($this->form_validation->run() == FALSE) {
            $this->assistance_session();
            $this->init_rpmb_session();
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
            $regionlist = $this->input->post('region_pass');
            $provlist = $this->input->post('provlist');
            $natureofworklist = $this->input->post('natureofworklist');
            $daily_payment = $this->input->post('daily_payment');
//
            $number_days = $this->input->post('number_days');
//            $costofassistance = $this->input->post('cost_of_assistance');

            $addResult = $cashforwork_model->insertProject($myid,$project_title,$regionlist,$provlist
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

    public function viewCash_brgy($cashforwork_muni_id)
    {
        $cashforwork_model = new cashforwork_model();

        $getList['cashforworkpassmuni_id'] = $cashforwork_muni_id;
//            $getList['provlist'] = $cashforwork_model->get_provinces($region_code);
        $getList['proj_prov'] = $cashforwork_model->get_project_prov_muni($cashforwork_muni_id);
        $getList['cashbrgy_list'] = $cashforwork_model->get_cashbrgy_list($cashforwork_muni_id);
//        $getList['cashforworkinfo'] = $cashforwork_model->get_cashforworkDetails($cashforwork_muni_id);
        $this->load->view('header');
        $this->load->view('navbar');
        $this->load->view('sidebar');

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
//            $getList['cashbrgy_list'] = $cashforwork_model->get_cashbrgy_list($cashforwork_muni_id);

            if(isset($_SESSION['brgy']) or isset($_SESSION['muni'])) {
                $getList['brgylist'] = $cashforwork_model->get_brgy($_SESSION['muni']);
            }

            $this->load->view('header');
            $this->load->view('navbar');
            $this->load->view('sidebar');

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

    public function addCash_brgy($cashforwork_muni_id)
    {
        $cashforwork_model = new cashforwork_model();

        $this->validateAddbrgyForm();

        if ($this->form_validation->run() == FALSE) {
            $this->init_rpmb_session();
//            $getList['cashforworkpass_id'] = $cashforwork_id;
            $getList['cashforworkpassmuni_id'] = $cashforwork_muni_id;
//            $getList['provlist'] = $cashforwork_model->get_provinces($region_code);
            $getList['proj_prov'] = $cashforwork_model->get_project_prov_muni($cashforwork_muni_id);
            $getList['cashbrgy_list'] = $cashforwork_model->get_cashbrgy_list($cashforwork_muni_id);

            if(isset($_SESSION['brgy']) or isset($_SESSION['muni'])) {
                $getList['brgylist'] = $cashforwork_model->get_brgy($_SESSION['muni']);
            }

            $this->load->view('header');
            $this->load->view('navbar');
            $this->load->view('sidebar');

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


    public function cash_addbene($cashforwork_id)
    {

        $cashforwork_model = new cashforwork_model();
        $this->validateAddTypeAssistanceForm();

        if (!$this->form_validation->run()){
            $this->load->view('header');
            $this->load->view('navbar');
            $this->load->view('sidebar');
            $this->load->view('cashforwork_beneAdd',array(
                'cash_benelist' => $cashforwork_model->get_bene_list($cashforwork_id),
                'title' => $cashforwork_model->get_project_title($cashforwork_id)
                /*'form_message'=>$form_message*/));
            $this->load->view('footer');


        } else {
            $assistance_name = $this->input->post('assistance_name');


            $assistance_model = new assistance_model();
            $assistanceResult = $assistance_model->InsertAssistance($assistance_name);
            if ($assistanceResult == 1){
                $form_message = '<div class="alert alert-alt alert-success alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close" onClick="window.location.href=window.location.href">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <i class="icon wb-check" aria-hidden="true"></i><a class="alert-link" href="javascript:window.location.href=window.location.href">
                  Success!</a>
                </div>';
                $this->load->view('header');
                $this->load->view('navbar');
                $this->load->view('sidebar');
                $this->load->view('assistance',array(
                    'assistancedetails' => $assistance_model->get_assistance_type(),'form_message'=>$form_message));
                $this->load->view('footer');
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
                    'cash_benelist' => $assistance_model->get_assistance_type(),'form_message'=>$form_message));
                $this->load->view('footer');
            }
        }

    }

    protected function validateAddTypeAssistanceForm()
    {
        $config = array(

            array(
                'field'   => 'bene_fullname',
                'label'   => 'Beneficiary Full name',
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

    public function populate_muni() {
        if($_POST['prov_code'] > 0 and isset($_POST) and isset($_POST['prov_code'])) {
            $prov_code = $_POST['prov_code'];
            $munilist = $this->cashforwork_model->get_muni($prov_code);

            $muni_list[''] = "Choose Municipality";
            foreach($munilist as $tempmuni) {
                $muni_list[$tempmuni->city_code] = $tempmuni->city_name;
            }

            $munilist_prop = 'required="required" required  id="munilist" name="munilist" onchange="get_brgy();" class="form-control" autofocus';
            echo form_dropdown('munilist', $muni_list,'',$munilist_prop);
        }
    }
    public function populate_brgy() {
        if($_POST['city_code'] > 0 and isset($_POST) and isset($_POST['city_code'])) {
            $city_code = $_POST['city_code'];
            $brgylist = $this->cashforwork_model->get_brgy($city_code);

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
}