<?php
/**
 * Created by PhpStorm.
 * User: ljesaclayan
 * Date: 2/11/2016
 * Time: 3:26 PM
z*/


class individual extends CI_Controller
{

    public function index(){
        $individual = new individual_model();
        $regionsaro = $this->session->userdata('uregion');
        $crims['crims'] = $individual->get_crims($regionsaro);
        $this->load->view('header');
        $this->load->view('navbar');
        $this->load->view('sidebar');


        $this->load->view('individual',$crims);
        $this->load->view('footer');
    }

    public function view(){
        $individual = new individual_model();
        $regionsaro = $this->session->userdata('uregion');
        $crims['crims'] = $individual->get_aics_details($regionsaro);
        $this->load->view('header');
        $this->load->view('navbar');
        $this->load->view('sidebar');


        $this->load->view('individual_view',$crims);
        $this->load->view('footer');
    }

    public function addIndividual(){
        $individual = new individual_model();
        $this->validateAddForm();

        if ($this->form_validation->run() == FALSE) {

            $regionsaro = $this->session->userdata('uregion');
            $getList['sarolist'] = $individual->get_saro($regionsaro);
            $getList['crims'] = $individual->get_crims($regionsaro);
            $this->init_rpmb_session();


            $this->load->view('header');
            $this->load->view('navbar');
            $this->load->view('sidebar');

            $this->load->view('individual_add', $getList);
            $this->load->view('footer');

        }
        else
        {

            $sarolist = $this->input->post('sarolist');
            $regionlist = $this->input->post('region_code');
            $utilize = $this->input->post('Utilize');
            $date_utilized = $this->input->post('date_utilize');
            $myid = $this->session->userdata('uid');
            $addResult = $individual->insertAics($sarolist,$regionlist,$utilize,$date_utilized,$myid);
            if ($addResult){
                $regionsaro = $this->session->userdata('uregion');
                $crims['crims'] = $individual->get_crims($regionsaro);
                $this->load->view('header');
                $this->load->view('navbar');
                $this->load->view('sidebar');
                $this->load->view('individual',$crims);
                $this->load->view('footer');
            }
            $this->redirectIndex();
        }
    }
    public function updateCommunities($project_id)
    {
        $communities_model = new communities_model();

        $this->validateAddForm();

        if ($this->form_validation->run() == FALSE) {
            $this->init_rpmb_session();
            $this->assistance_session();
            $getList['assistancelist'] = $communities_model->get_lib_assistance();
            $getList['fundsourcelist'] = $communities_model->get_fund_source();
            $getList['lgucounterpartlist'] = $communities_model->get_lgu_counterpart();
            $getList['projectdata'] = $communities_model->get_project_byid($project_id);
            $getList['regionlist'] = $communities_model->get_regions();

//            if(isset($_SESSION['province']) or isset($_SESSION['region'])) {
//                $getList['provlist'] = $communities_model->get_provinces($_SESSION['region']);
//            }
//            if(isset($_SESSION['muni']) or isset($_SESSION['province'])) {
//                $getList['munilist'] = $communities_model->get_muni($_SESSION['province']);
//            }
//            if(isset($_SESSION['brgy']) or isset($_SESSION['muni'])) {
//                $getList['brgylist'] = $communities_model->get_brgy($_SESSION['muni']);
//            }
//
//            if (isset($_SESSION['natureofwork']) or isset($_SESSION['assistance'])) {
//                $rpmb['natureofworklist'] = $communities_model->get_work_nature($_SESSION['assistance']);
//            }
            $this->load->view('header');
            $this->load->view('navbar');
            $this->load->view('sidebar');
            $this->load->view('communities_edit', $getList);
            $this->load->view('footer');
        }
        else
        {

            $project_id = $this->input->post('project_id');
            $assistancelist = $this->input->post('assistancelist');
            $project_title = $this->input->post('project_title');
            $regionlist = $this->input->post('regionlist');
            $provlist = $this->input->post('provlist');
            $munilist = $this->input->post('munilist');
            $brgylist = $this->input->post('brgylist');
            $natureofworklist = $this->input->post('natureofworklist');
            $fundsourcelist = $this->input->post('fundsourcelist');
            $project_amount = $this->input->post('project_amount');
            $lgucounterpartlist = $this->input->post('lgucounterpartlist');
            $lgu_amount = $this->input->post('lgu_amount');
            $lgu_fundsource = $this->input->post('lgu_fundsource');
            $project_cost = $this->input->post('project_cost');
            $implementing_agency = $this->input->post('implementing_agency');
            $status = $this->input->post('status');

            $updateResult = $communities_model->updateProject($project_id,$project_title,$regionlist,$provlist,$munilist,$brgylist,$assistancelist,$natureofworklist,$fundsourcelist
                ,$lgucounterpartlist,$lgu_fundsource,$lgu_amount,$project_cost,$project_amount,$implementing_agency,$status);
            if ($updateResult) {

                $this->load->view('header');
                $this->load->view('navbar');
                $this->load->view('sidebar');

                $this->load->view('communities_list',array(
                    'project' => $communities_model->get_project()
                ));
                $this->load->view('footer');
            }

            $this->redirectIndex();
        }
    }
    public function deleteCommunities($project_id)
    {
        $communities_model = new communities_model();
        if ($project_id > 0){
            $deleteResult = $communities_model->deleteProject($project_id);
            if ($deleteResult){
                $this->load->view('header');
                $this->load->view('navbar');
                $this->load->view('sidebar');
                $this->load->view('communities_list',array(
                    'project' => $communities_model->get_project()
                ));

                $this->load->view('footer');
            }
            $this->redirectIndex();
        }
    }
    public function populate_natureofwork() {
        if($_POST['assistance_id'] > 0 and isset($_POST) and isset($_POST['assistance_id'])) {

            $assistance_id = $_POST['assistance_id'];
            $natureofworklist = $this->communities_model->get_work_nature($assistance_id);

            $natureofwork_list[] = "Choose Nature of work";
            foreach($natureofworklist as $tempnatureofworklist) {
                $natureofwork_list[$tempnatureofworklist->nature_id] = $tempnatureofworklist->work_nature;
            }

            $natureofworklist_prop = 'required="required"  id="natureofworklist" name="natureofworklist" class="form-control" required';
            $natureofworklist_label = 'for="natureofworklist" class="control-label"';
            $natureofworklist_id = 'id="natureofworklist"';
            echo form_label('Nature of Work:', $natureofworklist_id,  $natureofworklist_label);
            echo form_dropdown('natureofworklist', $natureofwork_list,'', $natureofworklist_prop);
        }
    }

    public function assistance_session() {
        if(isset($_POST['assistancelist']) and $_POST['assistancelist'] > 0) {
            $_SESSION['assistance'] = $_POST['assistancelist'];
        }
        if(isset($_POST['natureofworklist']) and $_POST['natureofworklist'] > 0) {
            $_SESSION['natureofwork'] = $_POST['natureofworklist'];
        }
    }
    public function populate_prov() {
        if($_POST['region_code'] > 0 and isset($_POST) and isset($_POST['region_code'])) {

            $region_code = $_POST['region_code'];
            $provlist = $this->communities_model->get_provinces($region_code);

            $province_list[''] = "Choose Province";
            foreach($provlist as $tempprov) {
                $province_list[$tempprov->prov_code] = $tempprov->prov_name;
            }

            $provlist_prop = 'required="required" required id="provlist" name="provlist" class="form-control" onChange="get_muni();"';
            $prov_id = 'id="provlist"';
            $provlist_label = 'for="provlist" class="control-label" required';
            echo form_label('Province:', $prov_id,  $provlist_label);
            echo form_dropdown('provlist', $province_list, '', $provlist_prop);
        }
    }

    public function populate_muni() {
        if($_POST['prov_code'] > 0 and isset($_POST) and isset($_POST['prov_code'])) {
            $prov_code = $_POST['prov_code'];
            $munilist = $this->communities_model->get_muni($prov_code);

            $muni_list[''] = "Choose Municipality";
            foreach($munilist as $tempmuni) {
                $muni_list[$tempmuni->city_code] = $tempmuni->city_name;
            }

            $munilist_prop = 'required="required" id="munilist" name="munilist" onchange="get_brgy();" class="form-control" required';
            $muni_id = 'id="munilist"';
            $munilist_label = 'for="munilist" class="control-label" required';
            echo form_label('Municipality/City:', $muni_id,  $munilist_label);
            echo form_dropdown('munilist', $muni_list,'',$munilist_prop);
        }
    }
    public function populate_brgy() {
        if($_POST['city_code'] > 0 and isset($_POST) and isset($_POST['city_code'])) {
            $city_code = $_POST['city_code'];
            $brgylist = $this->communities_model->get_brgy($city_code);

            $brgy_list[''] = "Choose Barangay";
            foreach($brgylist as $tempbrgy) {
                $brgy_list[$tempbrgy->brgy_code] = $tempbrgy->brgy_name;
            }

            $brgylist_prop = 'required="required" id="brgylist" name="brgylist" class="form-control" required';
            $brgy_id = 'id="brgylist"';
            $brgylist_label = 'for="brgylist" class="control-label" required';
            echo form_label('Barangay:', $brgy_id,  $brgylist_label);
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
                'field' => 'sarolist',
                'label' => 'sarolist',
                'rules' => 'required'
            )
        );
        return $this->form_validation->set_rules($config);

    }
    public function redirectIndex()
    {
        $page = base_url('individual/index');

        header("LOCATION: $page");
    }

}