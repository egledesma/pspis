<?php
/**
 * Created by PhpStorm.
 * User: ljesaclayan
 * Date: 2/11/2016
 * Time: 3:26 PM
 z*/


class budget extends CI_Controller
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

    public function addBudget($project_id){
        $communities_model = new communities_model();
        $budget_model = new budget_model();
        $getList['projectdata'] = $communities_model->view_projectbyid($project_id);

        $this->validateAddForm();

        if ($this->form_validation->run() == FALSE) {

            $this->load->view('header');
            $this->load->view('navbar');
            $this->load->view('sidebar');

            $this->load->view('budget_add', $getList);
            $this->load->view('footer');
        }
        else
        {
            $region_code = $this->input->post('region_code');
            $project_id = $this->input->post('project_id');
            $first_tranche = $this->input->post('first_tranche');
            $first_tranche_date = date('Y/m/d', strtotime(str_replace('-','-', $this->input->post('first_tranche_date'))));
            $addResult = $budget_model->insertBudget($project_id,$region_code,$first_tranche,$first_tranche_date);
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

    public function addLiquidate($project_id){
        $communities_model = new communities_model();
        $budget_model = new budget_model();
        $getList['projectdata'] = $communities_model->view_projectbyid($project_id);

        $this->validateAddForm();

        if ($this->form_validation->run() == FALSE) {

            $this->load->view('header');
            $this->load->view('navbar');
            $this->load->view('sidebar');

            $this->load->view('liquidate_add', $getList);
            $this->load->view('footer');
        }
        else
        {
            $region_code = $this->input->post('region_code');
            $project_id = $this->input->post('project_id');
            $first_tranche = $this->input->post('first_tranche');
            $first_tranche_date = date('Y/m/d', strtotime(str_replace('-','-', $this->input->post('first_tranche_date'))));
            $addResult = $budget_model->insertLiquidate($project_id,$region_code,$first_tranche,$first_tranche_date);
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

    protected function validateAddForm()
    {
        $config = array(
            array(
                'field' => 'first_tranche',
                'label' => 'Amount',
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