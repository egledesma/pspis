<?php
/**
 * Created by PhpStorm.
 * User: ljesaclayan
 * Date: 2/11/2016
 * Time: 3:26 PM
 */


class fundsallocation extends CI_Controller
{

    public function index($function = 0){

        $fundsallocation_model = new fundsallocation_model();
        if($function == 0){
            $form_message = '';
        } elseif($function == 1){
            $form_message = '<div class="alert alert-alt alert-success alert-dismissible" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close" onClick="window.location.href=assistance/index">
                        <span aria-hidden="true">&times;</span>
                      </button>
                      <i class="icon wb-check" aria-hidden="true"></i><a class="alert-link" href="javascript:window.location.href=assistance/index">
                      Downloaded Funds Successfully!</a>
                    </div>';
        } elseif($function == 2){
            $form_message = '<div class="alert alert-alt alert-success alert-dismissible" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close" onClick="window.location.href=assistance/index">
                        <span aria-hidden="true">&times;</span>
                      </button>
                      <i class="icon wb-check" aria-hidden="true"></i><a class="alert-link" href="javascript:window.location.href=assistance/index">
                      Transferred Funds Successfully!</a>
                    </div>';
        }

            $this->load->view('header');
            $this->load->view('navbar');
            $this->load->view('sidebar');
            $this->load->view('fundsallocation_list',array(
                'fundsdetails' => $fundsallocation_model->get_funds(),'form_message'=>$form_message));
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
            $this->redirectIndex(1);
        }
    }

    public function add(){
        $fundsallocation_model = new fundsallocation_model();


        $this->validateAddForm();

        if ($this->form_validation->run() == FALSE) {
            $getList['regionlist'] = $fundsallocation_model->get_regions();
            $getList['fundsourcelist'] = $fundsallocation_model->get_fund_sourcelist();

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
            $this->redirectIndex(1);
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

    public function obligatedhistory($fund_source,$region_code){

        $fundsallocation_model = new fundsallocation_model();
        $getList['fundsallocation'] = $fundsallocation_model->view_fundsallocationbyid($fund_source);
        $getList['region'] = $fundsallocation_model->view_regionbyid($region_code);
        $getList['allocationdetails'] = $fundsallocation_model->get_obligated_history($fund_source,$region_code);
        $this->load->view('header');
        $this->load->view('navbar');
        $this->load->view('sidebar');
        $this->load->view('fundsobligated_history', $getList);
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

    public function fundsutilizedhistory($fund_source,$region_code){

        $fundsallocation_model = new fundsallocation_model();
        $getList['fundsallocation'] = $fundsallocation_model->view_fundsallocationbyid($fund_source);
        $getList['region'] = $fundsallocation_model->view_regionbyid($region_code);
        $getList['allocationdetails'] = $fundsallocation_model->get_fudsutilized_history($fund_source,$region_code);
        $this->load->view('header');
        $this->load->view('navbar');
        $this->load->view('sidebar');
        $this->load->view('fundsutilized_history', $getList);
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

    public function populate_conso_balance()
    {
      echo "test";

//        if($_POST['saa_number'] > 0 and isset($_POST) and isset($_POST['saa_number']))
//        {
        $fund_source = $_POST['fund_source'];
        $fundsourcedata = $this->fundsallocation_model->get_conso_balance($fund_source);

        $data1 = array(
            'type'        => 'text',
            'id'          => 'conso_balance',
            'name'       =>  'conso_balance',
            'value'   =>  $fundsourcedata->co_funds_remaining,
            'class'        => 'form-control'
        );

        echo form_input($data1);

//        }
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

    public function redirectIndex($function)
    {
        $page = base_url('fundsallocation/index/'.$function);
//        $sec = "1";
        header("Location: $page");
    }




}