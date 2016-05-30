<?php
/**
 * Created by PhpStorm.
 * User: ljesaclayan
 * Date: 2/11/2016
 * Time: 3:26 PM
 */


class withdraw extends CI_Controller
{

    public function index($region_code){

        $saro_model = new saro_model();
        $withdraw_model = new withdraw_model();

        $this->validateAddForm();

        if ($this->form_validation->run() == FALSE) {


            $getList['sarolist'] = $saro_model->get_saro_region1($region_code);
            $getList['from_region'] = $saro_model->get_from_region($region_code);
            $getList['to_region'] = $saro_model->get_to_region($region_code);
            $this->load->view('header');
            $this->load->view('navbar');
            $this->load->view('sidebar');
            $this->load->view('withdraw_funds', $getList);
            $this->load->view('footer');

        } else
        {
            $withdraw_date = $this->input->post('withdraw_date');
            $sarolist = $this->input->post('sarolist');
            $new_saro = $this->input->post('new_saro');
            $from_region = $this->input->post('from_region');
            $to_region = $this->input->post('to_region');
            $remarks = $this->input->post('remarks');
            $addResult = $withdraw_model->withdrawFunds($withdraw_date,$sarolist,$new_saro,$from_region,$to_region,$remarks);
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