<?php
/**
 * Created by PhpStorm.
 * User: ljesaclayan
 * Date: 2/11/2016
 * Time: 3:26 PM
 z*/


class implementation extends CI_Controller
{

    public function index(){
        $communities_model = new communities_model();
        $this->load->view('header');
        $this->load->view('navbar');
        $this->load->view('sidebar');

        $this->load->view('communities_list',array(
            'project' => $communities_model->get_project()
        ));
        $this->load->view('footer');
    }

    public function view($project_id){
        $communities_model = new communities_model();
        $implementation_model = new implementation_model();
        $getList['assistancelist'] = $communities_model->get_lib_assistance();
        $getList['fundsourcelist'] = $communities_model->get_fund_source();
        $getList['lgucounterpartlist'] = $communities_model->get_lgu_counterpart();
        $getList['projectdata'] = $communities_model->view_projectbyid($project_id);
        $getList['implementationdata'] = $implementation_model->view_implementationbyproject($project_id);
        $getList['regionlist'] = $communities_model->get_regions();
        $this->load->view('header');
        $this->load->view('navbar');
        $this->load->view('sidebar');
        $this->load->view('view_project', $getList);
        $this->load->view('footer');
    }

    public function addImplementation($project_id){
        $communities_model = new communities_model();
        $implementation_model = new implementation_model();
        $getList['projectdata'] = $communities_model->view_projectbyid($project_id);

        $this->validateAddForm();

        if ($this->form_validation->run() == FALSE) {

            $this->load->view('header');
            $this->load->view('navbar');
            $this->load->view('sidebar');

            $this->load->view('implementation_add', $getList);
            $this->load->view('footer');
        }
        else
        {
            $project_id = $this->input->post('project_id');
            $start_date = date('Y/m/d', strtotime(str_replace('-','-', $this->input->post('start_date'))));
            $target_date = date('Y/m/d', strtotime(str_replace('-','-', $this->input->post('target_date'))));
            $project_status = $this->input->post('project_status');
            $addResult = $implementation_model->insertImplementation($project_id,$start_date,$target_date,$project_status);
            if ($addResult){
            $this->load->view('header');
            $this->load->view('navbar');
            $this->load->view('sidebar');

                $this->load->view('communities_list',array(
                    'project' => $communities_model->get_project()
                ));
            $this->load->view('footer');
            }
            $this->redirectIndex($project_id);
        }
    }

    public function editImplementation($implementation_id)
    {
        $implementation_model = new implementation_model();

        $this->validateAddForm();

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('header');
            $this->load->view('navbar');
            $this->load->view('sidebar');
            $this->load->view('implementation_edit',array(
                'implementationdetails' => $implementation_model->get_implementation($implementation_id)
            ));
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
            $number_bene = $this->input->post('number_bene');
            $natureofworklist = $this->input->post('natureofworklist');
            $fundsourcelist = $this->input->post('fundsourcelist');
            $project_amount = $this->input->post('project_amount');
            $lgucounterpartlist = $this->input->post('lgucounterpartlist');
            $lgu_amount = $this->input->post('lgu_amount');
            $lgu_fundsource = $this->input->post('lgu_fundsource');
            $project_cost = $this->input->post('project_cost');
            $implementing_agency = $this->input->post('implementing_agency');
            $status = $this->input->post('status');

            $updateResult = $communities_model->updateProject($project_id,$project_title,$regionlist,$provlist,$munilist,$brgylist,$number_bene,$assistancelist,$natureofworklist,$fundsourcelist
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

            $natureofwork_list[''] = "Choose Nature of work";
            foreach($natureofworklist as $tempnatureofworklist) {
                $natureofwork_list[$tempnatureofworklist->nature_id] = $tempnatureofworklist->work_nature;
            }

            $natureofworklist_prop = 'required="required" required id="natureofworklist" name="natureofworklist" class="form-control" onChange="get_maxmin();"';
            echo form_dropdown('natureofworklist', $natureofwork_list,'',$natureofworklist_prop);



        }
    }
    public function populate_naturemaxmin()
    {
        if($_POST['nature_id'] > 0 and isset($_POST) and isset($_POST['nature_id']))
        {
        $nature_id = $_POST['nature_id'];
        $natureofworklist = $this->communities_model->get_naturemaxmin($nature_id);

            $data = array(
                'type'        => 'text',
                'id'          => 'nature_label',
                'name'       => 'nature_label',
                'value'   =>  '₱ '.$natureofworklist->minimum_amount.' - ₱ '.$natureofworklist->maximum_amount,
                'class'        => 'form-control',
                'disabled' => true
            );

            echo form_input($data);

            $label = array(
                'for'          => 'amount_requested',
                'class'        => 'control-label'
            );
            echo form_label('Amount Requested:', '', $label);

            $data1 = array(
                'type'        => 'number',
                'id'          => 'amount_requested',
                'name'       => 'amount_requested',
                'max'   => $natureofworklist->maximum_amount,
                'min'   => $natureofworklist->minimum_amount,
                'value'   =>  $natureofworklist->minimum_amount,
                'class'        => 'form-control'
            );

            echo form_input($data1);



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
            $munilist = $this->communities_model->get_muni($prov_code);

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
            $brgylist = $this->communities_model->get_brgy($city_code);

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
                'field' => 'start_date',
                'label' => 'Start Date',
                'rules' => 'required'
            )
        );
        return $this->form_validation->set_rules($config);

    }
    public function redirectIndex($project_id)
    {
        $page = base_url('communities/view/'.$project_id.'');

        header("LOCATION: $page");
    }

}