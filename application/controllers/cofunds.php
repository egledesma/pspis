<?php
/**
 * Created by PhpStorm.
 * User: ljesaclayan
 * Date: 2/11/2016
 * Time: 3:26 PM
 */


class cofunds extends CI_Controller
{

    public function index(){

        $cofunds_model = new cofunds_model();
            $this->load->view('header');
            $this->load->view('navbar');
            $this->load->view('sidebar');
            $this->load->view('cofunds_list',array(
                'cofundsdetails' => $cofunds_model->get_cofunds()/*'form_message'=>$form_message*/));
            $this->load->view('footer');

    }

    public function add(){
        $cofunds_model = new cofunds_model();

        $this->validateAddForm();

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('header');
            $this->load->view('navbar');
            $this->load->view('sidebar');
            $this->load->view('cofunds_add');
            $this->load->view('footer');
        }
        else
        {

            $year = $this->input->post('year');
            $funds_amount = $this->input->post('funds_amount');
            $status = $this->input->post('status');
            $regionlist = 190000000;
            $funds_identifier = $year.$regionlist;
            $myid = $this->input->post('myid');
            $addResult = $cofunds_model->insertFunds($year,$funds_amount,$myid, $status, $funds_identifier);
            if ($addResult){
                $this->load->view('header');
                $this->load->view('navbar');
                $this->load->view('sidebar');

                $this->load->view('cofunds_list',array(
                    'cofundsdetails' => $cofunds_model->get_cofunds()/*'form_message'=>$form_message*/));
                $this->load->view('footer');
            }
        }
    }

    public function edit($aid)
    {

            $cofunds_model = new cofunds_model();

            $this->validateEditForm();

            if ($this->form_validation->run() == FALSE){

                $this->load->view('cofunds_edit',array(
                    'cofunds_details'=>$cofunds_model->getcofundsid($aid)));
            } else {
                $co_funds = $this->input->post('co_funds');
                $cfid = $this->input->post('cfid');

                $updateResult = $cofunds_model->updateCofunds($cfid, $co_funds);
                if ($updateResult){
                   // $form_message = '<div class="alert alert-alt alert-success alert-dismissible" role="alert">
                   //   <button type="button" class="close" data-dismiss="alert" aria-label="Close" onClick="window.location.href=assistance/index">
                   //     <span aria-hidden="true">&times;</span>
                   //   </button>
                   //   <i class="icon wb-check" aria-hidden="true"></i><a class="alert-link" href="javascript:window.location.href=assistance/index">
                   //   Success!</a>
                   // </div>';

                    $this->load->view('header');
                    $this->load->view('navbar');
                    $this->load->view('sidebar');
                    $this->load->view('cofunds_list',array(
                        'cofundsdetails' => $cofunds_model->get_cofunds()/*'form_message'=>$form_message*/));
                    $this->load->view('footer');
                    $this->redirectIndex();
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
                'field'   => 'funds_amount',
                'label'   => 'funds_amount',
                'rules'   => 'required'
            ),
            array(
                'field'   => 'funds_identifier',
                'label'   => 'funds_identifier',
                'rules'   => 'is_unique[tbl_co_funds.funds_identifier]'
            )
        );

        return $this->form_validation->set_rules($config);
    }

    protected function validateEditForm()
    {
        $config = array(
            array(
                'field'   => 'co_funds',
                'label'   => 'co_funds',
                'rules'   => 'required'
            )

        );
        return $this->form_validation->set_rules($config);
    }
    public function redirectIndex()
    {
        $page = base_url('cofunds/index');

        header("LOCATION: $page");
    }




}