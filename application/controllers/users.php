<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by JOSEF FRIEDRICH S. BALDO
 * Date Time: 10/17/15 10:57 PM
 */
class users extends CI_Controller {

    public function index()
    {
        redirect('/users/login','location');
    }

    public function register()
    {
        $this->load->model('Model_user');
        $this->customvalidateRegForm();
		$this->init_rpmb_session();
        $rpmb['regionlist'] = $this->Model_form->get_regions();

        if (!$this->form_validation->run()){
			$this->load->view('header');
            $this->load->view('register',$rpmb);
			$this->load->view('footer');
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
			$fullname = $this->input->post('fullname');
			$email = $this->input->post('email');
			$regionlist = $this->input->post('regionlist');
            $Model_user = new Model_user($username,$password,$fullname,$email,$regionlist);
            $regResult = $Model_user->registerUser();
            if ($regResult == 1){
                $this->load->view('registration_success');
                $this->redirectIndex();
            } else {
                $this->load->view('registration_fail');
            }
        }
    }



    public function login()
    {
        $this->load->model('Model_user');
        $this->validateLoginForm();

        if (!$this->form_validation->run()){
            $this->load->view('header');
            $this->load->view('login');
            $this->load->view('footer');
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $Model_user = new Model_user($username,$password);
            $ifUserExist = $Model_user->ifUserExist();
            if ($ifUserExist > 0){
                $this->session->set_userdata('user_data',$Model_user->retrieveUserData()->full_name);
				$this->session->set_userdata('uid',$Model_user->retrieveUserData()->uid);
                $this->session->set_userdata('access',$Model_user->retrieveUserData()->access_level);
                $this->session->set_userdata('uregion',$Model_user->retrieveUserData()->region_code);
                $this->load->view('header');
				$this->load->view('navbar');
                $this->load->view('login');
                $this->load->view('footer');
            } else {

                $this->load->view('error_login',array('redirectIndex'=>$this->redirectIndex()));
            }
        }
    }
	
	public function change_password($uid =0)
    {
		if ($uid > 0)
                {
          $Model_user = new Model_user();
		  $this->validateChangePassword();

        if (!$this->form_validation->run()){
			$this->load->view('header');
			$this->load->view('nav');
			$this->load->view('sidebar');
			$this->load->view('change_password');
			$this->load->view('sidepanel');
			$this->load->view('footer');
        } else {
			$id = $this->input->post('id');
            $password = $this->input->post('password');
            $updateResult = $Model_user->changePassword($id, $password);
            if ($updateResult){
                $form_message = 'Update Success';
				$this->load->view('header');
			$this->load->view('nav');
			$this->load->view('sidebar');
			$this->load->view('change_password');
			$this->load->view('sidepanel');
			$this->load->view('footer');
            } else {
                $form_message = 'Sad';
				$this->load->view('header');
			$this->load->view('nav');
			$this->load->view('sidebar');
			$this->load->view('change_password');
			$this->load->view('sidepanel');
			$this->load->view('footer');
            }
        }
        } else {
            echo "1234";
        }
    }
	
	 protected function validateChangePassword()
    {
        $config = array(
            array(
                'field'   => 'id',
                'label'   => 'id',
                'rules'   => 'required'
            ),
            array(
                'field'   => 'password2',
                'label'   => 'Confirm Password',
                'rules'   => 'trim|required|matches[password]'
            ),
            array(
                'field'   => 'password',
                'label'   => 'Password',
                'rules'   => 'trim|required'
            )
        );

        return $this->form_validation->set_rules($config);
    }


    public function logout()
    {
        $this->session->sess_destroy();
        $this->load->view('logout');
    }


    // custom classes / behavior
    protected function customvalidateRegForm()
    {
        $config = array(
            array(
                'field'   => 'username',
                'label'   => 'username',
                'rules'   => 'required'
            ),
            array(
                'field'   => 'password2',
                'label'   => 'Confirm Password',
                'rules'   => 'trim|required|matches[password]'
            ),
            array(
                'field'   => 'password',
                'label'   => 'Password',
                'rules'   => 'trim|required'
            ),
            array(
                'field'   => 'fullname',
                'label'   => 'fullname',
                'rules'   => 'required'
            ),
            array(
                'field'   => 'email',
                'label'   => 'email',
                'rules'   => 'required'
            ),
            array(
                'field'   => 'regionlist',
                'label'   => 'regionlist',
                'rules'   => 'required'
            )
        );

        return $this->form_validation->set_rules($config);
    }

    protected function validateLoginForm()
    {
        $config = array(
            array(
                'field'   => 'username',
                'label'   => 'username',
                'rules'   => 'required'
            ),
            array(
                'field'   => 'password',
                'label'   => 'password',
                'rules'   => 'required'
            )
        );

        return $this->form_validation->set_rules($config);
    }

    public function redirectIndex()
    {
        $page = base_url();
        $sec = "1";
        header("Refresh: $sec; url=$page");
    }
	
	public function init_rpmb_session() {
        if(isset($_POST['regionlist']) and $_POST['regionlist'] > 0) {
            $_SESSION['region'] = $_POST['regionlist'];
        }
    }
}