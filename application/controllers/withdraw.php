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
            $getList['from_region'] = $withdraw_model->get_from_region($region_code);
            $getList['to_region'] = $saro_model->get_to_region($region_code);
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
            $sarolist = $this->input->post('saro_number');
            $new_saro = $this->input->post('new_saro');
            $from_region = $this->input->post('from_region');
            $to_region = $this->input->post('to_region');
            $remarks = $this->input->post('remarks');
            $saro_id = $this->input->post('saro_id');
            $funds_identifier = $year.$to_region;
            $saro_amount = $this->input->post('saro_amount');
            $addResult = $withdraw_model->withdrawFunds($saro_id,$withdraw_date,$sarolist,$new_saro,$from_region,$to_region,$saro_amount,$remarks,$funds_identifier,$year);
            if ($addResult){
                $getList['sarolist'] = $saro_model->get_saro_region1($region_code);
                $getList['from_region'] = $saro_model->get_from_region($region_code);
                $getList['to_region'] = $saro_model->get_to_region($region_code);
                $this->load->view('header');
                $this->load->view('navbar');
                $this->load->view('sidebar');
                $this->load->view('withdraw_funds', $getList);
                $this->load->view('footer');
            }
            $this->redirectIndex();
        }

    }



    protected function validateAddForm()
    {
        $config = array(

            array(
                'field'   => 'sarolist',
                'label'   => 'sarolist',
                'rules'   => 'required'
            ),
        );

        return $this->form_validation->set_rules($config);
    }

    public function redirectIndex()
    {
        $page = base_url('fundsallocation/index');

        header("LOCATION: $page");
    }


    public function populate_saro_amount()
    {

        if($_POST['saro_id'] > 0 and isset($_POST) and isset($_POST['saro_id']))
        {
            $saro_id = $_POST['saro_id'];
            $sarodata = $this->withdraw_model->get_saro_amount($saro_id);
            $label = array(
            'for'          => 'saro_amount',
            'class'        => 'control-label'
                );
            echo form_label('Saro Amount', '', $label);

            $data1 = array(
                'type'        => 'number',
                'id'          => 'saro_amount',
                'name'       =>  'saro_amount',
                'max'   => $sarodata->saro_funds,
                'min'   => '0',
                'value'   =>  $sarodata->saro_funds,
                'class'        => 'form-control'
            );

            echo form_input($data1);

            $data2 = array(
                'type'        => 'hidden',
                'id'          => 'saro_id',
                'name'       =>  'saro_id',
                'max'   => $sarodata->saro_id,
                'min'   => '0',
                'value'   =>  $sarodata->saro_id,
                'class'        => 'form-control'
            );

            echo form_input($data2);
            $data3 = array(
                'type'        => 'hidden',
                'id'          => 'saro_number',
                'name'       =>  'saro_number',
                'max'   => $sarodata->saro_number,
                'min'   => '0',
                'value'   =>  $sarodata->saro_number,
                'class'        => 'form-control'
            );

            echo form_input($data3);

        }
    }

}