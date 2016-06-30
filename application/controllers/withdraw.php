<?php
/**
 * Created by PhpStorm.
 * User: ljesaclayan
 * Date: 2/11/2016
 * Time: 3:26 PM
 */


class withdraw extends CI_Controller
{

    public function index($funds_id, $region_code){

        $saa_model = new saa_model();
        $withdraw_model = new withdraw_model();

        $this->validateAddForm();

        if ($this->form_validation->run() == FALSE) {


            $getList['saalist'] = $saa_model->get_saa_byregion($funds_id, $region_code);
            $getList['from_region'] = $withdraw_model->get_from_region($region_code);
            $getList['funds'] = $withdraw_model->get_fundsource_byid($funds_id);
            $getList['to_region'] = $saa_model->get_to_region($region_code);
            $getList['region_list'] = $withdraw_model->get_regions();
            $this->load->view('header');
            $this->load->view('navbar');
            $this->load->view('sidebar');
            $this->load->view('withdraw_funds', $getList);
            $this->load->view('footer');

        } else
        {
            $withdraw_date = date('Y/m/d', strtotime(str_replace('-','-', $this->input->post('withdraw_date'))));
            $year = $this->input->post('year');
            $saalist = $this->input->post('saa_number');
            $fund_source = $this->input->post('fund_source');
            $new_saa = $this->input->post('new_saa');
            $from_region = $this->input->post('from_region');
            $to_region = $this->input->post('to_region');
            $remarks = $this->input->post('remarks');
            $saa_id = $this->input->post('saa_id');
            $funds_identifier = $year.$to_region;
            $saa_amount = $this->input->post('saa_amount');
            $addResult = $withdraw_model->withdrawFunds($fund_source,$saa_id,$withdraw_date,$saalist,$new_saa,$from_region,$to_region,$saa_amount,$remarks,$funds_identifier,$year);
            if ($addResult){
                $getList['saalist'] = $saa_model->get_saa_byregion($region_code);
                $getList['from_region'] = $withdraw_model->get_from_region($region_code);
                $getList['funds'] = $withdraw_model->get_fundsource_byid($funds_id);
                $getList['to_region'] = $saa_model->get_to_region($region_code);
                $getList['region_list'] = $withdraw_model->get_regions();
                $this->load->view('header');
                $this->load->view('navbar');
                $this->load->view('sidebar');
                $this->load->view('withdraw_funds', $getList);
                $this->load->view('footer');
            }
            $this->redirectIndex(2);
        }

    }



    protected function validateAddForm()
    {
        $config = array(

            array(
                'field'   => 'saalist',
                'label'   => 'saalist',
                'rules'   => 'required'
            ),
        );

        return $this->form_validation->set_rules($config);
    }

    public function redirectIndex($function)
    {
        $page = base_url('fundsallocation/index/'.$function);
//        $sec = "1";
        header("Location: $page");
    }


    public function populate_saa_amount()
    {

        if($_POST['saa_id'] > 0 and isset($_POST) and isset($_POST['saa_id']))
        {
            $saa_id = $_POST['saa_id'];
            $saadata = $this->withdraw_model->get_saa_amount($saa_id);
            $label = array(
            'for'          => 'saa_amount',
            'class'        => 'control-label'
                );
            echo form_label('Saa Amount:', '', $label);

            $data1 = array(
                'type'        => 'number',
                'id'          => 'saa_amount',
                'name'       =>  'saa_amount',
                'max'   => $saadata->saa_balance,
                'min'   => '0',
                'value'   =>  $saadata->saa_balance,
                'class'        => 'form-control'
            );

            echo form_input($data1);

            $data2 = array(
                'type'        => 'hidden',
                'id'          => 'saa_id',
                'name'       =>  'saa_id',
                'max'   => $saadata->saa_id,
                'min'   => '0',
                'value'   =>  $saadata->saa_id,
                'class'        => 'form-control'
            );

            echo form_input($data2);
            $data3 = array(
                'type'        => 'hidden',
                'id'          => 'saa_number',
                'name'       =>  'saa_number',
                'max'   => $saadata->saa_number,
                'min'   => '0',
                'value'   =>  $saadata->saa_number,
                'class'        => 'form-control'
            );

            echo form_input($data3);

        }
    }

}