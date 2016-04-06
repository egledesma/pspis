<?php
/**
 * Created by PhpStorm.
 * User: ljesaclayan
 * Date: 2/11/2016
 * Time: 3:26 PM
 z*/


class communities extends CI_Controller
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
    public function addCommunities(){
        $communities_model = new communities_model();

        $this->validateAddForm();

        if ($this->form_validation->run() == FALSE) {
            $this->assistance_session();
            $getList['assistancelist'] = $communities_model->get_lib_assistance();
            $getList['fundsourcelist'] = $communities_model->get_fund_source();
            $getList['lgucounterpartlist'] = $communities_model->get_lgu_counterpart();

            if (isset($_SESSION['natureofwork']) or isset($_SESSION['assistance'])) {
                $rpmb['natureofworklist'] = $communities_model->get_work_nature($_SESSION['assistance']);
            }
            $this->load->view('header');
            $this->load->view('navbar');
            $this->load->view('sidebar');

            $this->load->view('communities_add', $getList);
            $this->load->view('footer');
        }
        else
        {
            $assistancelist = $this->input->post('assistancelist');
            $project_title = $this->input->post('project_title');
            $natureofworklist = $this->input->post('natureofworklist');
            $fundsourcelist = $this->input->post('fundsourcelist');
            $project_amount = $this->input->post('project_amount');
            $lgucounterpartlist = $this->input->post('lgucounterpartlist');
            $lgu_amount = $this->input->post('lgu_amount');
            $lgu_fundsource = $this->input->post('lgu_fundsource');
            $project_cost = $this->input->post('project_cost');
            $implementing_agency = $this->input->post('implementing_agency');
            $status = $this->input->post('status');
            $addResult = $communities_model->insertProject($project_title,$assistancelist,$natureofworklist,$fundsourcelist,$lgucounterpartlist,$lgu_fundsource,$lgu_amount,$project_cost,$project_amount,$implementing_agency,$status);
            if ($addResult){
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
    public function updateCommunities($project_id)
    {
        $communities_model = new communities_model();


        $this->assistance_session();
        $getList['assistancelist'] = $communities_model->get_lib_assistance();
        $getList['fundsourcelist'] = $communities_model->get_fund_source();
        $getList['lgucounterpartlist'] = $communities_model->get_lgu_counterpart();
        $getList['projectdata'] = $communities_model->get_project_byid($project_id);

        if (isset($_SESSION['natureofwork']) or isset($_SESSION['assistance'])) {
            $rpmb['natureofworklist'] = $communities_model->get_work_nature($_SESSION['assistance']);
        }
        $this->load->view('header');
        $this->load->view('navbar');
        $this->load->view('sidebar');
        $this->load->view('communities_edit',$getList);
        $this->load->view('footer');
    }
    public function populate_natureofwork() {
        if($_POST['assistance_id'] > 0 and isset($_POST) and isset($_POST['assistance_id'])) {

            $assistance_id = $_POST['assistance_id'];
            $natureofworklist = $this->communities_model->get_work_nature($assistance_id);

            $natureofwork_list[] = "Choose Nature of work";
            foreach($natureofworklist as $tempnatureofworklist) {
                $natureofwork_list[$tempnatureofworklist->nature_id] = $tempnatureofworklist->work_nature;
            }

            $natureofworklist_prop = 'id="natureofworklist" name="natureofworklist" class="form-control"';
            echo form_dropdown('natureofworklist', $natureofwork_list,'',$natureofworklist_prop);
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
        $page = base_url('communities/index');

        header("LOCATION: $page");
    }

}