<?php
/**
 * Created by PhpStorm.
 * User: ljesaclayan
 * Date: 2/11/2016
 * Time: 3:26 PM
 */


class user extends CI_Controller
{

    public function index(){

        $user_model = new user_model();
            $this->load->view('header');
            $this->load->view('navbar');
            $this->load->view('sidebar');
            $this->load->view('user_list',array(
                'userdetails' => $user_model->get_user()/*'form_message'=>$form_message*/));
            $this->load->view('footer');

    }


    public function edit($uid)
    {
            $user_model = new user_model();

            $this->validateEditForm();

            if ($this->form_validation->run() == FALSE) {
                $getList['regionlist'] = $user_model->get_regions();
                $getList['accesslevellist'] = $user_model->get_access_level();
                $getList['userdetails'] = $user_model->get_user_byid($uid);
                $this->load->view('header');
                $this->load->view('navbar');
                $this->load->view('sidebar');

                $this->load->view('user_edit', $getList);
                $this->load->view('footer');
            } else {
                $user_id = $this->input->post('user_id');
                $full_name = $this->input->post('full_name');
                $username = $this->input->post('username');
                $email = $this->input->post('email');
                $regionlist = $this->input->post('regionlist');
                $status = $this->input->post('status');
                $accesslevellist = $this->input->post('accesslevellist');
                $lockedstatus = $this->input->post('lockedstatus');

                $updateResult = $user_model->updateUser($user_id, $full_name, $username, $email,$regionlist,$status,$accesslevellist,$lockedstatus);
                if ($updateResult){
                    $form_message = '<div class="alert alert-alt alert-success alert-dismissible" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close" onClick="window.location.href=assistance/index">
                        <span aria-hidden="true">&times;</span>
                      </button>
                      <i class="icon wb-check" aria-hidden="true"></i><a class="alert-link" href="javascript:window.location.href=assistance/index">
                      Success!</a>
                    </div>';

                    $getList['regionlist'] = $user_model->get_regions();
                    $getList['accesslevellist'] = $user_model->get_access_level();
                    $getList['userdetails'] = $user_model->get_user_byid($uid);
                    $this->load->view('header');
                    $this->load->view('navbar');
                    $this->load->view('sidebar');

                    $this->load->view('user_edit', $getList);
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

    public function deactivate($uid)
    {
        $user_model = new user_model();
        if ($uid > 0){
            $deactivateResult = $user_model->deactivateUser($uid);

            if ($deactivateResult){
                $this->load->view('header');
                $this->load->view('navbar');
                $this->load->view('sidebar');
                $this->load->view('user_list',array(
                    'userdetails' => $user_model->get_user()
                ));

                $this->load->view('footer');
            }
            $this->redirectIndex();
        }
    }

    public function activate($uid)
    {
        $user_model = new user_model();
        if ($uid > 0){
            $deactivateResult = $user_model->activateUser($uid);

            if ($deactivateResult){
                $this->load->view('header');
                $this->load->view('navbar');
                $this->load->view('sidebar');
                $this->load->view('user_list',array(
                    'userdetails' => $user_model->get_user()
                ));

                $this->load->view('footer');
            }
            $this->redirectIndex();
        }
    }

    public function lock($uid)
    {
        $user_model = new user_model();
        if ($uid > 0){
            $deactivateResult = $user_model->lockUser($uid);

            if ($deactivateResult){
                $this->load->view('header');
                $this->load->view('navbar');
                $this->load->view('sidebar');
                $this->load->view('user_list',array(
                    'userdetails' => $user_model->get_user()
                ));

                $this->load->view('footer');
            }
            $this->redirectIndex();
        }
    }

    public function unlock($uid)
    {
        $user_model = new user_model();
        if ($uid > 0){
            $deactivateResult = $user_model->unlockUser($uid);

            if ($deactivateResult){
                $this->load->view('header');
                $this->load->view('navbar');
                $this->load->view('sidebar');
                $this->load->view('user_list',array(
                    'userdetails' => $user_model->get_user()
                ));

                $this->load->view('footer');
            }
            $this->redirectIndex();
        }
    }

    protected function validateEditForm()
    {
        $config = array(
            array(
                'field' => 'full_name',
                'label' => 'username',
                'rules' => 'required'
            )
        );
        return $this->form_validation->set_rules($config);

    }

    public function redirectIndex()
    {
        $page = base_url('user/index');

        header("LOCATION: $page");
    }




}