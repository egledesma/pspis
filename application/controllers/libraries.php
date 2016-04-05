<?php
/**
 * Created by PhpStorm.
 * User: ljesaclayan
 * Date: 2/11/2016
 * Time: 3:26 PM
 */


class libraries extends CI_Controller
{

    public function assistance(){

        $assistance_model = new assistance_model();
        $this->validateAddTypeAssistanceForm();

        if (!$this->form_validation->run()){
            $this->load->view('header');
            $this->load->view('navbar');
            $this->load->view('sidebar');
            $this->load->view('assistance',array(
				'assistancedetails' => $assistance_model->get_assistance_type()/*'form_message'=>$form_message*/));
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
                $this->load->view('assistance',array(
                    'assistancedetails' => $assistance_model->get_assistance_type(),'form_message'=>$form_message));
                $this->load->view('footer');
            }
        }
    }

    public function editAssistance($aid = "")
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
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close" onClick="window.location.href=libraries/assistance">
                        <span aria-hidden="true">&times;</span>
                      </button>
                      <i class="icon wb-check" aria-hidden="true"></i><a class="alert-link" href="javascript:window.location.href=libraries/assistance">
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
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close" onClick="window.location.href=libraries/assistance">
                         <span aria-hidden="true">&times;</span>
                       </button>
                       <i class="icon wb-check" aria-hidden="true"></i><a class="alert-link" href="javascript:window.location.href=libraries/assistance">
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

    public function deleteAssistance($aid = 0)
    {
        $assistance_model = new assistance_model();
        if ($aid > 0){
            $deleteResult = $assistance_model->deleteAssistance($aid);
            if ($deleteResult){
                $form_message = '<div class="alert alert-alt alert-danger alert-dismissible" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close" onClick="window.location.href=libraries/assistance">
                         <span aria-hidden="true">&times;</span>
                       </button>
                       <i class="icon wb-check" aria-hidden="true"></i><a class="alert-link" href="javascript:window.location.href=libraries/assistance">
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

    protected function validateAddTypeAssistanceForm()
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




}