<?php
/**
 * Created by PhpStorm.
 * User: ljesaclayan
 * Date: 2/11/2016
 * Time: 3:26 PM
 */


class sourcefund extends CI_Controller
{

    public function index($function = 0){

        $sourcefund_model = new sourcefund_model();
        if($function == 0){
            $form_message = '';
        } elseif($function == 1){
            $form_message = '<div class="alert alert-alt alert-success alert-dismissible" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close" onClick="window.location.href=assistance/index">
                        <span aria-hidden="true">&times;</span>
                      </button>
                      <i class="icon wb-check" aria-hidden="true"></i><a class="alert-link" href="javascript:window.location.href=assistance/index">
                      Add Success!</a>
                    </div>';
        } elseif($function == 2){
            $form_message = '<div class="alert alert-alt alert-success alert-dismissible" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close" onClick="window.location.href=assistance/index">
                        <span aria-hidden="true">&times;</span>
                      </button>
                      <i class="icon wb-check" aria-hidden="true"></i><a class="alert-link" href="javascript:window.location.href=assistance/index">
                      Update Success!</a>
                    </div>';
        }elseif($function == 3){
            $form_message = '<div class="alert alert-alt alert-success alert-dismissible" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close" onClick="window.location.href=assistance/index">
                        <span aria-hidden="true">&times;</span>
                      </button>
                      <i class="icon wb-check" aria-hidden="true"></i><a class="alert-link" href="javascript:window.location.href=assistance/index">
                      Delete Success!</a>
                    </div>';
        }

        $this->validateAddForm();

        if (!$this->form_validation->run()){
            $this->load->view('header');
            $this->load->view('navbar');
            $this->load->view('sidebar');
            $this->load->view('fundsource',array(
				'sourceDetails' => $sourcefund_model->get_fundsource(),'form_message'=>$form_message));
            $this->load->view('footer');


        } else {
            $fund_source = $this->input->post('fund_source');
            $myid = $this->input->post('myid');


            $sourcefund_model = new sourcefund_model();
            $sourcefundResult = $sourcefund_model->InsertSourcefund($fund_source,$myid);
            if ($sourcefundResult == 1){
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
                $this->load->view('fundsource',array(
                    'sourceDetails' => $sourcefund_model->get_fundsource(),'form_message'=>$form_message, $this->redirectIndex(1)));
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
                $this->load->view('fundsource',array(
                    'sourceDetails' => $sourcefund_model->get_fundsource(),'form_message'=>$form_message));
                $this->load->view('footer');
            }
        }
    }

    public function edit($sid = ""){
        if ($sid != ""){
            $sourcefund_model = new sourcefund_model();

            $this->validateEditForm();

            if (!$this->form_validation->run()){
                $form_message = '';
                $this->load->view('fundsource_edit',array(
                    'fundsource_details'=>$sourcefund_model->getfundsourceid($sid)));
            } else {
                $fund_source = $this->input->post('fund_source');
                $myid = $this->input->post('myid');
                $sid = $this->input->post('sid');

                $updateResult = $sourcefund_model->updateFundsource($eid, $fund_source, $myid);
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
                    $this->load->view('fundsource',array(
                        'sourceDetails' => $sourcefund_model->get_fundsource(),'form_message'=>$form_message, $this->redirectIndex(2)));
                    $this->load->view('footer');
                }
            }
        } else {
            $sourcefund_model = new sourcefund_model();

            $this->validateEditForm();

            if (!$this->form_validation->run()){
                $form_message = '';
                $this->load->view('fundsource_edit',array(
                    'fundsource_details'=>$sourcefund_model->getfundsourceid($sid)));
            } else {
                $fund_source = $this->input->post('fund_source');
                $myid = $this->input->post('myid');
                $sid = $this->input->post('sid');

                $updateResult = $sourcefund_model->updateFundsource($eid, $fund_source, $myid);
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
                    $this->load->view('fundsource',array(
                        'sourceDetails' => $sourcefund_model->get_fundsource(),'form_message'=>$form_message, $this->redirectIndex(2)));
                    $this->load->view('footer');
                }
            }
        }
    }

    public function delete($sid = 0)
    {
        $sourcefund_model = new sourcefund_model();
        if ($sid > 0){
            $deleteResult = $sourcefund_model->deleteFundsource($sid);
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
                $this->load->view('fundsource',array(
                    'sourceDetails' => $sourcefund_model->get_fundsource(),'form_message'=>$form_message));
                $this->load->view('footer');
            }
        }
    }

    protected function validateAddForm()
    {
        $config = array(

            array(
                'field'   => 'fund_source',
                'label'   => 'Source of Fund',
                'rules'   => 'required'
            )
        );

        return $this->form_validation->set_rules($config);
    }

    protected function validateEditForm()
    {
        $config = array(
            array(
                'field'   => 'fund_source',
                'label'   => 'Source of Fund',
                'rules'   => 'required'
            )

        );
        return $this->form_validation->set_rules($config);
    }

    public function redirectIndex($function)
    {
        $page = base_url('sourcefund/index/'.$function);
//        $sec = "1";
        header("Location: $page");
    }




}