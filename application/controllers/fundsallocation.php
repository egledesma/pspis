<?php
/**
 * Created by PhpStorm.
 * User: ljesaclayan
 * Date: 2/11/2016
 * Time: 3:26 PM
 */


class fundsallocation extends CI_Controller
{

    public function index(){

        $fundsallocation_model = new fundsallocation_model();

            $this->load->view('header');
            $this->load->view('navbar');
            $this->load->view('sidebar');
            $this->load->view('fundsallocation_list',array(
                'fundsdetails' => $fundsallocation_model->get_funds()/*'form_message'=>$form_message*/));
            $this->load->view('footer');

    }

    public function download($fundsource_id){
        $fundsallocation_model = new fundsallocation_model();

        $this->validateAddForm();

        if ($this->form_validation->run() == FALSE) {
            $getList['regionlist'] = $fundsallocation_model->get_regions();
            $getList['fundsourcelist'] = $fundsallocation_model->get_fundsource_byid($fundsource_id);

            $this->load->view('header');
            $this->load->view('navbar');
            $this->load->view('sidebar');

            $this->load->view('fundsallocation_download', $getList);
            $this->load->view('footer');
        }
        else
        {

            $regionlist = $this->input->post('regionlist');
            $fund_source = $this->input->post('fs');
            $saa = $this->input->post('saa');
            $funds_allocated = $this->input->post('funds_allocated');
            $funds_allocated2 = preg_replace('/\D/', '', $funds_allocated);
            $status = $this->input->post('status');
            $funds_identifier = $fund_source.$regionlist;
            $myid = $this->input->post('myid');
            $addResult = $fundsallocation_model->insertFunds($fund_source,$regionlist,$saa,$funds_allocated2,$myid,$status,$funds_identifier);
            if ($addResult){
                $this->load->view('header');
                $this->load->view('navbar');
                $this->load->view('sidebar');

                $this->load->view('fundsallocation_list',array(
                    'fundsdetails' => $fundsallocation_model->get_funds()
                ));
                $this->load->view('footer');
            }
            $this->redirectIndex();
        }
    }

    public function add(){
        $fundsallocation_model = new fundsallocation_model();


        $this->validateAddForm();

        if ($this->form_validation->run() == FALSE) {
            $getList['regionlist'] = $fundsallocation_model->get_regions();
            $getList['fundsourcelist'] = $fundsallocation_model->get_fund_source();

            $this->load->view('header');
            $this->load->view('navbar');
            $this->load->view('sidebar');

            $this->load->view('fundsallocation_add', $getList);
            $this->load->view('footer');
        }
        else
        {

            $regionlist = $this->input->post('regionlist');
            $fund_source = $this->input->post('fundsourcelist');
            $saa = $this->input->post('saa');
            $funds_allocated = $this->input->post('funds_allocated');
            $funds_allocated2 = preg_replace('/\D/', '', $funds_allocated);
            $status = $this->input->post('status');
            $funds_identifier = $fund_source.$regionlist;
            $myid = $this->input->post('myid');
            $addResult = $fundsallocation_model->insertFunds($fund_source,$regionlist,$saa,$funds_allocated2,$myid,$status,$funds_identifier);
            if ($addResult){
                $this->load->view('header');
                $this->load->view('navbar');
                $this->load->view('sidebar');

                $this->load->view('fundsallocation_list',array(
                    'fundsdetails' => $fundsallocation_model->get_funds()
                ));
                $this->load->view('footer');
            }
            $this->redirectIndex();
        }
    }

    public function fundshistory($fund_source,$region_code){

        $fundsallocation_model = new fundsallocation_model();
        $getList['fundsallocation'] = $fundsallocation_model->view_fundsallocationbyid($fund_source);
        $getList['region'] = $fundsallocation_model->view_regionbyid($region_code);
        $getList['allocationdetails'] = $fundsallocation_model->get_fundsallocation_history($fund_source,$region_code);
        $this->load->view('header');
        $this->load->view('navbar');
        $this->load->view('sidebar');
        $this->load->view('fundsallocation_history', $getList);
        $this->load->view('footer');

    }

    public function downloadedhistory($fund_source){

        $cofunds_model = new cofunds_model();
        $getList['consofunds'] = $cofunds_model->view_consofundsbyid($fund_source);
        $getList['fundsdetails'] = $cofunds_model->get_consodownloaded_history($fund_source);
        $this->load->view('header');
        $this->load->view('navbar');
        $this->load->view('sidebar');
        $this->load->view('downloadedfunds_history', $getList);
        $this->load->view('footer');

    }

    public function otherfundshistory($fund_source,$region_code){

        $fundsallocation_model = new fundsallocation_model();
        $getList['fundsallocation'] = $fundsallocation_model->view_fundsallocationbyid($fund_source);
        $getList['region'] = $fundsallocation_model->view_regionbyid($region_code);
        $getList['allocationdetails'] = $fundsallocation_model->get_otherfunds_history($fund_source,$region_code);
        $this->load->view('header');
        $this->load->view('navbar');
        $this->load->view('sidebar');
        $this->load->view('otherfunds_history', $getList);
        $this->load->view('footer');

    }

    public function edit($aid = "")
    {
        if ($aid != ""){
            $assistance_model = new assistance_model();

            $this->validateEditForm();

            if (!$this->form_validation->run()){
                $form_message = '';
                $this->load->view('assistance_edit',array(
                    'assistance_details'=>$assistance_model->getassistanceid($aid)));
            } else {
                $assistance_name = $this->input->post('assistance_name');
                $myid = $this->input->post('myid');
                $aid = $this->input->post('aid');

                $updateResult = $assistance_model->updateAssistance($aid, $assistance_name, $myid);
                if ($updateResult){
                    $form_message = '<div class="alert alert-alt alert-success alert-dismissible" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close" onClick="window.location.href=assistance/index">
                        <span aria-hidden="true">&times;</span>
                      </button>
                      <i class="icon wb-check" aria-hidden="true"></i><a class="alert-link" href="javascript:window.location.href=assistance/index">
                      Success!</a>
                    </div>';

                    $this->load->view('header');
                    $this->load->view('navbar');
                    $this->load->view('sidebar');
                    $this->load->view('assistance',array(
                        'assistancedetails' => $assistance_model->get_assistance_type(),'form_message'=>$form_message));
                    $this->load->view('footer');
                }
            }
        } else {
            $assistance_model = new assistance_model();

            $this->validateEditForm();

            if (!$this->form_validation->run()){
                $form_message = '';
                $this->load->view('header');
                $this->load->view('assistance_edit',array(
                    'assistance_details'=>$assistance_model->getassistanceid($aid)));
                $this->load->view('footer');
            } else {
                $assistance_name = $this->input->post('assistance_name');
                $myid = $this->input->post('myid');
                $aid = $this->input->post('aid');

                $updateResult = $assistance_model->updateAssistance($aid, $assistance_name, $myid);
                if ($updateResult){
                    $form_message = '<div class="alert alert-alt alert-success alert-dismissible" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close" onClick="window.location.href=assistance/index">
                         <span aria-hidden="true">&times;</span>
                       </button>
                       <i class="icon wb-check" aria-hidden="true"></i><a class="alert-link" href="javascript:window.location.href=assistance/index">
                       Success!</a>
                     </div>';
                    $this->load->view('header');
                    $this->load->view('navbar');
                    $this->load->view('sidebar');
                    $this->load->view('assistance',array(
                        'assistancedetails' => $assistance_model->get_assistance_type(),'form_message'=>$form_message));
                    $this->load->view('footer');
                }
            }
        }

    }

    public function delete($aid = 0)
    {
        $assistance_model = new assistance_model();
        if ($aid > 0){
            $deleteResult = $assistance_model->deleteAssistance($aid);
            if ($deleteResult){
                $form_message = '<div class="alert alert-alt alert-danger alert-dismissible" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close" onClick="window.location.href=assistance/index">
                         <span aria-hidden="true">&times;</span>
                       </button>
                       <i class="icon wb-check" aria-hidden="true"></i><a class="alert-link" href="javascript:window.location.href=assistance/index">
                       Deleted!</a>
                     </div>';
                $this->load->view('header');
                $this->load->view('navbar');
                $this->load->view('sidebar');
                $this->load->view('assistance',array(
                    'assistancedetails' => $assistance_model->get_assistance_type(),'form_message'=>$form_message));
                $this->load->view('footer');
            }
        }
    }

    protected function validateAddForm()
    {
        $config = array(

            array(
                'field'   => 'funds_allocated',
                'label'   => 'Funds Allocated',
                'rules'   => 'required'
            ),
        );

        return $this->form_validation->set_rules($config);
    }

    protected function validateEditForm()
    {
        $config = array(
            array(
                'field'   => 'assistance_name',
                'label'   => 'Type of Assistance',
                'rules'   => 'required'
            )

        );
        return $this->form_validation->set_rules($config);
    }

    public function redirectIndex()
    {
        $page = base_url('fundsallocation/index');

        header("LOCATION: $page");
    }




}