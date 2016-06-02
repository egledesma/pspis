<?php
/**
 * Created by PhpStorm.
 * User: ljesaclayan
 * Date: 2/11/2016
 * Time: 3:26 PM
z*/


class foodforwork extends CI_Controller
{

    public function food_benelist($foodforwork_id)
    {
        $foodforwork = new foodforwork_model();
        $this->load->view('header');
        $this->load->view('navbar');
        $this->load->view('sidebar');
        $this->load->view('foodforwork_beneAdd',array(
            'food_benelist' => $foodforwork->get_bene_list($foodforwork_id),
            'foodforwork_idpass' => $foodforwork_id));
        $this->load->view('footer');
    }
    public function deleteBene($food_bene_id,$foodforwork_id)
    {

        $foodforwork = new foodforwork_model();
        if ($food_bene_id > 0){
            $deleteResult = $foodforwork->deleteFoodBene($food_bene_id);

            $this->redirectIndexbene($foodforwork_id);
        }
    }
    public function foodbene_edit($cashbene_id)
    {
        if ($cashbene_id != ""){
            $foodforwork = new foodforwork_model();

            $this->validateBeneAddForm();

            if (!$this->form_validation->run()){
                $form_message = '';
                $this->load->view('foodforwork_beneEdit',array(
                    'bene_details'=>$foodforwork->getbenebyid($cashbene_id)));
            } else {
//                $assistance_name = $this->input->post('assistance_name');
                $myid = $this->input->post('myid');
                $fullname = $this->input->post('bene_fullname');
                $bene_idpass = $this->input->post('bene_idpass');
                $foodforwork_idpass = $this->input->post('foodforwork_idpass');


                $updateResult = $foodforwork->updateCashbene($bene_idpass, $fullname, $myid);
                if ($updateResult){
                    $form_message = '<div class="alert alert-alt alert-success alert-dismissible" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close" onClick="window.location.href=assistance/index">
                        <span aria-hidden="true">&times;</span>
                      </button>
                      <i class="icon wb-check" aria-hidden="true"></i><a class="alert-link" href="javascript:window.location.href=assistance/index">
                      Success!</a>
                    </div>';

                    $this->redirectIndexbene($foodforwork_idpass);
                }
            }
        }
    }
    public function food_addbene($foodforwork_id)
    {

        $foodforwork = new foodforwork_model();
        $this->validateBeneAddForm();

        if (!$this->form_validation->run()){
            $this->load->view('header');
            $this->load->view('navbar');
            $this->load->view('sidebar');
            $this->load->view('foodforwork_beneAdd',array(
                'food_benelist' => $foodforwork->get_bene_list($foodforwork_id),
                'foodforwork_idpass' => $foodforwork_id));
            $this->load->view('footer');


        } else {
            $bene_fullname = $this->input->post('bene_fullname');
            $myid = $this->session->userdata('uid');
            $foodforwork_idpass = $this->input->post('foodforwork_idpass');



            $foodbeneResult = $foodforwork->insertBene($foodforwork_idpass,$bene_fullname,$myid);
            if ($foodbeneResult == 1){
                $form_message = '<div class="alert alert-alt alert-success alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close" onClick="window.location.href=window.location.href">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <i class="icon wb-check" aria-hidden="true"></i><a class="alert-link" href="javascript:window.location.href=window.location.href">
                  Success!</a>
                </div>';
              $this->redirectIndexbene($foodforwork_idpass);
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
                    'food_benelist' => $foodforwork->get_bene_list($foodforwork_id),
                    'foodforwork_idpass' => $foodforwork_id));
                $this->load->view('footer');
            }
        }

    }
    protected function validateBeneAddForm()
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
    public function view()
    {
        $foodforwork_model = new foodforwork_model();
        $this->load->view('header');
        $this->load->view('navbar');
        $this->load->view('sidebar');
        $region_code = $this->session->userdata('uregion');
        $this->load->view('foodforwork_view',array(
            'project' => $foodforwork_model->get_project_view($region_code)));
        $this->load->view('footer');
    }
    public function finalize_saro($foodforwork_id)
    {
        $foodforwork_model = new foodforwork_model();
        if ($foodforwork_id > 0){
            $getResult = $foodforwork_model->finalize($foodforwork_id);
            $total_cost = $getResult->cost_of_assistance;
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
            $foodforwork_id = $this->input->post('foodforwork_id');
            $project_title = $this->input->post('project_title');
            $regionlist = $this->input->post('region_pass');
            $provlist = $this->input->post('provlist');
            $munilist = $this->input->post('munilist');
            $sarolist = $this->input->post('sarolist');
            $brgylist = $this->input->post('brgylist');
            $natureofworklist = $this->input->post('natureofworklist');
            $number_bene = $this->input->post('number_bene');

            $number_days = $this->input->post('number_days');
            $costofassistance = $this->input->post('cost_of_assistance');

            $updateResult = $foodforwork_model->updatefoodforwork($sarolist,$foodforwork_id,$myid,$project_title,$regionlist,$provlist
                ,$munilist,$brgylist,$natureofworklist,$number_bene,$number_days,$costofassistance);
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
    public function addfoodforwork()
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

            if(isset($_SESSION['province']) or isset($_SESSION['region'])) {
                $getList['provlist'] = $foodforwork_model->get_provinces($_SESSION['region']);
            }
            if(isset($_SESSION['muni']) or isset($_SESSION['province'])) {
                $getList['munilist'] = $foodforwork_model->get_muni($_SESSION['province']);
            }
            if(isset($_SESSION['brgy']) or isset($_SESSION['muni'])) {
                $getList['brgylist'] = $foodforwork_model->get_brgy($_SESSION['muni']);
            }

//            if (isset($_SESSION['natureofwork']) or isset($_SESSION['assistance'])) {
//                $rpmb['natureofworklist'] = $foodforwork_model->get_work_nature($_SESSION['assistance']);
//            }
            $this->load->view('header');
            $this->load->view('navbar');
            $this->load->view('sidebar');

            $this->load->view('foodforwork_add', $getList);
            $this->load->view('footer');
        }
        else
        {

//            $assistancelist = 2;
            $myid = $this->input->post('myid');
            $project_title = $this->input->post('project_title');
            $sarolist = $this->input->post('sarolist');
            $regionlist = $this->input->post('region_pass');
            $provlist = $this->input->post('provlist');
            $munilist = $this->input->post('munilist');
            $brgylist = $this->input->post('brgylist');
            $natureofworklist = $this->input->post('natureofworklist');
            $number_bene = $this->input->post('number_bene');

            $number_days = $this->input->post('number_days');
            $costofassistance = $this->input->post('cost_of_assistance');

            $addResult = $foodforwork_model->insertProject($sarolist,$myid,$project_title,$regionlist,$provlist
                ,$munilist,$brgylist,$natureofworklist,$number_bene,$number_days,$costofassistance);
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
            $this->redirectIndex();
        }
    }


//    public function cash_addbene($foodforwork_id)
//    {
//
//        $foodforwork_model = new foodforwork_model();
//        $this->validateAddTypeAssistanceForm();
//
//        if (!$this->form_validation->run()){
//            $this->load->view('header');
//            $this->load->view('navbar');
//            $this->load->view('sidebar');
//            $this->load->view('foodforwork_beneAdd',array(
//                'cash_benelist' => $foodforwork_model->get_bene_list($foodforwork_id),
//                'title' => $foodforwork_model->get_project_title($foodforwork_id)
//                /*'form_message'=>$form_message*/));
//            $this->load->view('footer');
//
//
//        } else {
//            $assistance_name = $this->input->post('assistance_name');
//
//
//            $assistance_model = new assistance_model();
//            $assistanceResult = $assistance_model->InsertAssistance($assistance_name);
//            if ($assistanceResult == 1){
//                $form_message = '<div class="alert alert-alt alert-success alert-dismissible" role="alert">
//                  <button type="button" class="close" data-dismiss="alert" aria-label="Close" onClick="window.location.href=window.location.href">
//                    <span aria-hidden="true">&times;</span>
//                  </button>
//                  <i class="icon wb-check" aria-hidden="true"></i><a class="alert-link" href="javascript:window.location.href=window.location.href">
//                  Success!</a>
//                </div>';
//                $this->load->view('header');
//                $this->load->view('navbar');
//                $this->load->view('sidebar');
//                $this->load->view('assistance',array(
//                    'assistancedetails' => $assistance_model->get_assistance_type(),'form_message'=>$form_message));
//                $this->load->view('footer');
//            } else {
//                $form_message = '<div class="alert alert-danger alert-dismissible" role="alert">
//                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
//                    <span aria-hidden="true">&times;</span>
//                  </button>
//                  <i class="icon wb-close" aria-hidden="true"></i>
//                  Fail!
//                </div>';
//                $this->load->view('header');
//                $this->load->view('navbar');
//                $this->load->view('sidebar');
//                $this->load->view('foodforwork_beneAdd',array(
//                    'cash_benelist' => $assistance_model->get_assistance_type(),'form_message'=>$form_message));
//                $this->load->view('footer');
//            }
//        }
//
//    }

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
            $provlist = $this->foodforwork_model->get_provinces($region_code);

            $province_list[] = "Choose Province";
            foreach($provlist as $tempprov) {
                $province_list[$tempprov->prov_code] = $tempprov->prov_name;
            }

            $provlist_prop = 'required="required" required id="provlist" name="provlist" class="form-control" onChange="get_muni();"';

            echo form_dropdown('provlist', $province_list, '', $provlist_prop);
        }
    }

    public function populate_muni() {
        if($_POST['prov_code'] > 0 and isset($_POST) and isset($_POST['prov_code'])) {
            $prov_code = $_POST['prov_code'];
            $munilist = $this->foodforwork_model->get_muni($prov_code);

            $muni_list[] = "Choose Municipality";
            foreach($munilist as $tempmuni) {
                $muni_list[$tempmuni->city_code] = $tempmuni->city_name;
            }

            $munilist_prop = 'required="required" required  id="munilist" name="munilist" onchange="get_brgy();" class="form-control"';
            echo form_dropdown('munilist', $muni_list,'',$munilist_prop);
        }
    }
    public function populate_brgy() {
        if($_POST['city_code'] > 0 and isset($_POST) and isset($_POST['city_code'])) {
            $city_code = $_POST['city_code'];
            $brgylist = $this->foodforwork_model->get_brgy($city_code);

            $brgy_list[] = "Choose Barangay";
            foreach($brgylist as $tempbrgy) {
                $brgy_list[$tempbrgy->brgy_code] = $tempbrgy->brgy_name;
            }

            $brgylist_prop = 'required="required" required id="brgylist" name="brgylist" class="form-control"';
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
                'field' => 'project_title',
                'label' => 'Project Title',
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
    public function redirectIndexbene($foodforwork_id)
    {
        $page = base_url('foodforwork/food_benelist/'.$foodforwork_id.'');

        header("LOCATION: $page");
    }
}