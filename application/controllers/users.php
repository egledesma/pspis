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

    public function superKey()
    {
        return $this->config->item('encryption_key');

        $this->load->library('encrypt');
    }


    public function register()
    {
        $this->load->model('Model_user');
        $this->customvalidateRegForm();
        $this->init_rpmb_session();
        $rpmb['regionlist'] = $this->Model_form->get_regions();
        $userkey = $this->superKey();

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
            $superkey = $this->encrypt->sha1($userkey.$password);


            $Model_user = new Model_user($username,$superkey,$fullname,$email,$regionlist);
            $regResult = $Model_user->registerUser();
            if ($regResult == 1){
                $registerSendResult = $this->registration_sendmail($email,$username,$fullname,$regionlist,$password);
                $form_message = '<div class="alert alert-alt alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button><a class="alert-link" href="javascript:void(0)">'.$registerSendResult.'.</a>
                </div>';
                $this->load->view('header');
                $this->load->view('register',array($rpmb,'form_message'=>$form_message));
                $this->load->view('footer');
            } else {
                $form_message = '<div class="alert alert-alt alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button><a class="alert-link" href="javascript:void(0)">Fail!.</a>
                </div>';
                $this->load->view('header');
                $this->load->view('register',array($rpmb,'form_message'=>$form_message));
                $this->load->view('footer');
            }
        }
    }



    public function login()
    {
        $this->load->model('Model_user');
        $this->validateLoginForm();
        $userkey = $this->superKey();

        if (!$this->form_validation->run()){
            $this->load->view('header');
            $this->load->view('login');
            $this->load->view('footer');
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $newkey = $this->encrypt->sha1($userkey . $password);
            $Model_user = new Model_user($username,$newkey);
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
                $resultSend = $this->forgotpassword_sendmail($email,$password);
                $form_message = ' <div class="kode-alert kode-alert kode-alert-icon kode-alert-click alert3"><i class="fa fa-lock"></i>'.$resultSend.'<a href="#" class="closed">&times;</a></div>';
				$this->load->view('header');
			$this->load->view('nav');
			$this->load->view('sidebar');
			$this->load->view('change_password',array('form_message'=>$form_message));
			$this->load->view('sidepanel');
			$this->load->view('footer');
            } else {
                $form_message = ' <div class="kode-alert kode-alert kode-alert-icon kode-alert-click alert3"><i class="fa fa-lock"></i>'.$resultSend.'<a href="#" class="closed">&times;</a></div>';
				$this->load->view('header');
			$this->load->view('nav');
			$this->load->view('sidebar');
			$this->load->view('change_password',array('form_message'=>$form_message));
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

    public function forgot_password()
    {
        $Model_user = new Model_user();
        $this->customvalidateForgotForm();

        $userkey = $this->superKey();

        if (!$this->form_validation->run()){
            $this->load->view('header');
            $this->load->view('forgot_password');
            $this->load->view('footer');


        } else {
            $email = $this->input->post('email');
            $password = random_string('alnum', 16);
            $superkey = $this->encrypt->sha1($userkey.$password);
            $ifUserActivated = $Model_user->userActivated($email);
            if($ifUserActivated > 0){
                $regResult = $Model_user->forgotPassword($email, $superkey);
                if ($regResult == 1){
                    $resultSend = $this->forgotpassword_sendmail($email,$password);
                    $form_message = ' <div class="kode-alert kode-alert kode-alert-icon kode-alert-click alert3"><i class="fa fa-lock"></i>'.$resultSend.'<a href="#" class="closed">&times;</a></div>';
                    $this->load->view('header');
                    $this->load->view('forgot_password',array('form_message'=>$form_message));
                    $this->load->view('footer');
                } else {
                    $form_message = '<div class="kode-alert kode-alert kode-alert-icon kode-alert-click alert6"><i class="fa fa-lock"></i>Fail!<a href="#" class="closed">&times;</a></div>';
                    $this->load->view('header');
                    $this->load->view('forgot_password', array('form_message' => $form_message));
                    $this->load->view('footer');
                }
            } else {
                $form_message = '<div class="kode-alert kode-alert kode-alert-icon kode-alert-click alert6"><i class="fa fa-lock"></i>Invalid Account/The account is not yet activated.!<a href="#" class="closed">&times;</a></div>';
                $this->load->view('header');
                $this->load->view('forgot_password', array('form_message' => $form_message));
                $this->load->view('footer');
            }
        }

    }

    public function oldpassword_check($oldpassword){
        $Model_user = new Model_user();
        $userkey = $this->superKey();
        $myid = $this->session->userdata('uid');
        $old_password_hash = sha1($userkey.$oldpassword);
        $old_password_db_hash = $Model_user->getuserpass($myid);
        $error = '<div class="kode-alert kode-alert kode-alert-icon kode-alert-click alert6"><i class="fa fa-lock"></i>Old password not match!<a href="#" class="closed">&times;</a></div>';
        if($old_password_hash != $old_password_db_hash->passwd)
        {
            $this->form_validation->set_message('oldpassword_check', ''.$error.'');
            return FALSE;
        }
        return TRUE;
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
                'rules'   => 'required|is_unique[users.username]'
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
                'rules'   => 'required|is_unique[users.email]'
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

    public function registration_sendmail($email,$username,$fullname,$regionlist) {
        $this->load->library('My_PHPMailer');
        $mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'ssl://smtp.gmail.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = '';                 // SMTP username
        $mail->Password = '';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 465;                                    // TCP port to connect to

        $mail->setFrom('pspis-noreply@dswd.gov.ph', 'pspis-noreply@dswd.gov.ph');
        $mail->addAddress($email);     // Add a recipient
        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = 'Registration Information';
        $mail->Body    = 'Dear Sir/Madam, <br><br>
                          Thank you for registering with us. Your registration details with us is as follow: <br><br>
                          Full Name: '.$fullname.'<br>
                          Email Address: '.$email.'<br>
                          Username: '.$username.'<br>
                          Region: '.$regionlist.'<br><br>
                          Please feel free to contact us in case of further queries.
                          <br>
                          Best Regards,
                          Support';
        $mail->AltBody = 'Registration';
        if(!$mail->send()) {
            $sendMessage = 'Error Sending Email, but the Registration is complete';
        } else {
            $sendMessage = 'Registration succeeded. An email has been sent to your email address.!';
        }

    }



    public function forgotpassword_sendmail($email,$password) {
        $this->load->library('My_PHPMailer');
        $mail = new PHPMailer;

        //$mail->SMTPDebug = 3;                               // Enable verbose debug output

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'ssl://smtp.gmail.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = '';                 // SMTP username
        $mail->Password = '';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 465;                                    // TCP port to connect to

        $mail->setFrom('pspis-noreply@dswd.gov.ph', 'pspis-noreply@dswd.gov.ph');
        $mail->addAddress($email);     // Add a recipient
        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = 'Password Reset';
        $mail->Body    = 'Dear Sir/Madam, <br><br>
                           Please see below for the requested information: <br><br>
                           Email Address: '.$email.'<br>
                           Password: '.$password.'<br><br>
                           Please feel free to contact us in case of further queries.
                           <br>
                           Best Regards,
                           Support';
        $mail->AltBody = 'Forgot Password';

        if(!$mail->send()) {
            $sendMessage = 'Error Sending Email, but the Registration is complete';
        } else {
            $sendMessage = 'Registration succeeded. An email has been sent to your email address.!';
        }
    }
}