<?php
/**
 * Created by PhpStorm.
 * User: ljesaclayan
 * Date: 2/11/2016
 * Time: 3:26 PM
 z*/


class communities extends CI_Controller
{

    public function index(){

       $communities_model = new communities_model();
        $this->load->view('header');
        $this->load->view('navbar');
        $this->load->view('sidebar');
        $region_code = $this->session->userdata('uregion');
        $this->load->view('communities_list',array(
            'project' => $communities_model->get_project($region_code)
        ));
        $this->load->view('footer');
    }
    public function addFirstTranche($project_id)
    {
        $communities_model = new communities_model();
        $implementation_model = new implementation_model();
        $budget_model = new budget_model();

        $this->validateAddTrancheForm();

        if (!$this->form_validation->run()){
            $getList['assistancelist'] = $communities_model->get_lib_assistance();
            $getList['fundsourcelist'] = $communities_model->get_fund_source();
            $getList['lgucounterpartlist'] = $communities_model->get_lgu_counterpart();
            $getList['projectdata'] = $communities_model->view_projectbyid($project_id);
            $getList['implementationdata'] = $implementation_model->view_implementationbyproject($project_id);
            $getList['budgetdata'] = $budget_model->view_budgetbyproject($project_id);
            $getList['regionlist'] = $communities_model->get_regions();
            $this->load->view('header');
            $this->load->view('navbar');
            $this->load->view('sidebar');
            $this->load->view('view_project', $getList);
            $this->load->view('footer');

        } else {
            $remarks = $this->input->post('remarks');
            $budget_id = $this->input->post('budget_id');
            $start_date = date('Y/m/d', strtotime(str_replace('-','-', $this->input->post('start_date'))));
            $myid = $this->input->post('myid');
            $project_idpass = $this->input->post('project_idpass');

            $firsttrancheupdate = $communities_model->updateFirstTranche($myid,$remarks,$budget_id,$start_date);

            $getList['assistancelist'] = $communities_model->get_lib_assistance();
            $getList['fundsourcelist'] = $communities_model->get_fund_source();
            $getList['lgucounterpartlist'] = $communities_model->get_lgu_counterpart();
            $getList['projectdata'] = $communities_model->view_projectbyid($project_id);
            $getList['implementationdata'] = $implementation_model->view_implementationbyproject($project_id);
            $getList['budgetdata'] = $budget_model->view_budgetbyproject($project_id);
            $getList['regionlist'] = $communities_model->get_regions();
            $this->load->view('header');
            $this->load->view('navbar');
            $this->load->view('sidebar');
            $this->load->view('view_project', $getList);
            $this->load->view('footer');

        }
        $this->redirectview($project_idpass);

    }
    public function addFirstLiquidate($project_id)
    {
        $communities_model = new communities_model();
        $implementation_model = new implementation_model();
        $budget_model = new budget_model();

        $this->validateAddTrancheForm();

        if (!$this->form_validation->run()){
            $getList['assistancelist'] = $communities_model->get_lib_assistance();
            $getList['fundsourcelist'] = $communities_model->get_fund_source();
            $getList['lgucounterpartlist'] = $communities_model->get_lgu_counterpart();
            $getList['projectdata'] = $communities_model->view_projectbyid($project_id);
            $getList['implementationdata'] = $implementation_model->view_implementationbyproject($project_id);
            $getList['budgetdata'] = $budget_model->view_budgetbyproject($project_id);
            $getList['regionlist'] = $communities_model->get_regions();
            $this->load->view('header');
            $this->load->view('navbar');
            $this->load->view('sidebar');
            $this->load->view('view_project', $getList);
            $this->load->view('footer');

        } else {
            $remarks = $this->input->post('remarks');
            $saro_number =$this->input->post('saro_number');
            $first_liquidate = $this->input->post('first_liquidate');
            $budget_id = $this->input->post('budget_id');
            $start_date = date('Y/m/d', strtotime(str_replace('-','-', $this->input->post('liqui_date'))));
            $myid = $this->input->post('myid');
            $project_idpass = $this->input->post('project_idpass');

            $firstliquidateupdate = $communities_model->updateLiquidateTranche($first_liquidate,$saro_number,$myid,$remarks,$budget_id,$start_date);

            $getList['assistancelist'] = $communities_model->get_lib_assistance();
            $getList['fundsourcelist'] = $communities_model->get_fund_source();
            $getList['lgucounterpartlist'] = $communities_model->get_lgu_counterpart();
            $getList['projectdata'] = $communities_model->view_projectbyid($project_id);
            $getList['implementationdata'] = $implementation_model->view_implementationbyproject($project_id);
            $getList['budgetdata'] = $budget_model->view_budgetbyproject($project_id);
            $getList['regionlist'] = $communities_model->get_regions();
            $this->load->view('header');
            $this->load->view('navbar');
            $this->load->view('sidebar');
            $this->load->view('view_project', $getList);
            $this->load->view('footer');

        }
        $this->redirectview($project_idpass);

    }

    public function addSecondTranche($project_id)
    {
        $communities_model = new communities_model();
        $implementation_model = new implementation_model();
        $budget_model = new budget_model();

        $this->validateAddTrancheForm();

        if (!$this->form_validation->run()){
            $getList['assistancelist'] = $communities_model->get_lib_assistance();
            $getList['fundsourcelist'] = $communities_model->get_fund_source();
            $getList['lgucounterpartlist'] = $communities_model->get_lgu_counterpart();
            $getList['projectdata'] = $communities_model->view_projectbyid($project_id);
            $getList['implementationdata'] = $implementation_model->view_implementationbyproject($project_id);
            $getList['budgetdata'] = $budget_model->view_budgetbyproject($project_id);
            $getList['regionlist'] = $communities_model->get_regions();
            $this->load->view('header');
            $this->load->view('navbar');
            $this->load->view('sidebar');
            $this->load->view('view_project', $getList);
            $this->load->view('footer');

        } else {
            $remarks = $this->input->post('remarks');
            $budget_id = $this->input->post('budget_id');
            $start_date = date('Y/m/d', strtotime(str_replace('-','-', $this->input->post('start_date'))));
            $myid = $this->input->post('myid');
            $project_idpass = $this->input->post('project_idpass');

            $firsttrancheupdate = $communities_model->updateSecondTranche($myid,$remarks,$budget_id,$start_date);

            $getList['assistancelist'] = $communities_model->get_lib_assistance();
            $getList['fundsourcelist'] = $communities_model->get_fund_source();
            $getList['lgucounterpartlist'] = $communities_model->get_lgu_counterpart();
            $getList['projectdata'] = $communities_model->view_projectbyid($project_id);
            $getList['implementationdata'] = $implementation_model->view_implementationbyproject($project_id);
            $getList['budgetdata'] = $budget_model->view_budgetbyproject($project_id);
            $getList['regionlist'] = $communities_model->get_regions();
            $this->load->view('header');
            $this->load->view('navbar');
            $this->load->view('sidebar');
            $this->load->view('view_project', $getList);
            $this->load->view('footer');

        }
        $this->redirectview($project_idpass);

    }
    public function addSecondLiquidate($project_id)
    {
        $communities_model = new communities_model();
        $implementation_model = new implementation_model();
        $budget_model = new budget_model();

        $this->validateAddTrancheForm();

        if (!$this->form_validation->run()){
            $getList['assistancelist'] = $communities_model->get_lib_assistance();
            $getList['fundsourcelist'] = $communities_model->get_fund_source();
            $getList['lgucounterpartlist'] = $communities_model->get_lgu_counterpart();
            $getList['projectdata'] = $communities_model->view_projectbyid($project_id);
            $getList['implementationdata'] = $implementation_model->view_implementationbyproject($project_id);
            $getList['budgetdata'] = $budget_model->view_budgetbyproject($project_id);
            $getList['regionlist'] = $communities_model->get_regions();
            $this->load->view('header');
            $this->load->view('navbar');
            $this->load->view('sidebar');
            $this->load->view('view_project', $getList);
            $this->load->view('footer');

        } else {
            $remarks = $this->input->post('remarks');
            $saro_number =$this->input->post('saro_number');
            $second_liquidate = $this->input->post('second_liquidate');
            $budget_id = $this->input->post('budget_id');
            $start_date = date('Y/m/d', strtotime(str_replace('-','-', $this->input->post('liqui_date'))));
            $myid = $this->input->post('myid');
            $project_idpass = $this->input->post('project_idpass');

            $secondliquidateupdate = $communities_model->updateSecondLiquidateTranche($second_liquidate,$saro_number,$myid,$remarks,$budget_id,$start_date);

            $getList['assistancelist'] = $communities_model->get_lib_assistance();
            $getList['fundsourcelist'] = $communities_model->get_fund_source();
            $getList['lgucounterpartlist'] = $communities_model->get_lgu_counterpart();
            $getList['projectdata'] = $communities_model->view_projectbyid($project_id);
            $getList['implementationdata'] = $implementation_model->view_implementationbyproject($project_id);
            $getList['budgetdata'] = $budget_model->view_budgetbyproject($project_id);
            $getList['regionlist'] = $communities_model->get_regions();
            $this->load->view('header');
            $this->load->view('navbar');
            $this->load->view('sidebar');
            $this->load->view('view_project', $getList);
            $this->load->view('footer');

        }
        $this->redirectview($project_idpass);

    }

    public function addThirdTranche($project_id)
    {
        $communities_model = new communities_model();
        $implementation_model = new implementation_model();
        $budget_model = new budget_model();

        $this->validateAddTrancheForm();

        if (!$this->form_validation->run()){
            $getList['assistancelist'] = $communities_model->get_lib_assistance();
            $getList['fundsourcelist'] = $communities_model->get_fund_source();
            $getList['lgucounterpartlist'] = $communities_model->get_lgu_counterpart();
            $getList['projectdata'] = $communities_model->view_projectbyid($project_id);
            $getList['implementationdata'] = $implementation_model->view_implementationbyproject($project_id);
            $getList['budgetdata'] = $budget_model->view_budgetbyproject($project_id);
            $getList['regionlist'] = $communities_model->get_regions();
            $this->load->view('header');
            $this->load->view('navbar');
            $this->load->view('sidebar');
            $this->load->view('view_project', $getList);
            $this->load->view('footer');

        } else {
            $remarks = $this->input->post('remarks');
            $budget_id = $this->input->post('budget_id');
            $start_date = date('Y/m/d', strtotime(str_replace('-','-', $this->input->post('start_date'))));
            $myid = $this->input->post('myid');
            $project_idpass = $this->input->post('project_idpass');

            $thirdtrancheupdate = $communities_model->updateThirdTranche($myid,$remarks,$budget_id,$start_date);

            $getList['assistancelist'] = $communities_model->get_lib_assistance();
            $getList['fundsourcelist'] = $communities_model->get_fund_source();
            $getList['lgucounterpartlist'] = $communities_model->get_lgu_counterpart();
            $getList['projectdata'] = $communities_model->view_projectbyid($project_id);
            $getList['implementationdata'] = $implementation_model->view_implementationbyproject($project_id);
            $getList['budgetdata'] = $budget_model->view_budgetbyproject($project_id);
            $getList['regionlist'] = $communities_model->get_regions();
            $this->load->view('header');
            $this->load->view('navbar');
            $this->load->view('sidebar');
            $this->load->view('view_project', $getList);
            $this->load->view('footer');

        }
        $this->redirectview($project_idpass);

    }
    public function addThirdLiquidate($project_id)
    {
        $communities_model = new communities_model();
        $implementation_model = new implementation_model();
        $budget_model = new budget_model();

        $this->validateAddTrancheForm();

        if (!$this->form_validation->run()){
            $getList['assistancelist'] = $communities_model->get_lib_assistance();
            $getList['fundsourcelist'] = $communities_model->get_fund_source();
            $getList['lgucounterpartlist'] = $communities_model->get_lgu_counterpart();
            $getList['projectdata'] = $communities_model->view_projectbyid($project_id);
            $getList['implementationdata'] = $implementation_model->view_implementationbyproject($project_id);
            $getList['budgetdata'] = $budget_model->view_budgetbyproject($project_id);
            $getList['regionlist'] = $communities_model->get_regions();
            $this->load->view('header');
            $this->load->view('navbar');
            $this->load->view('sidebar');
            $this->load->view('view_project', $getList);
            $this->load->view('footer');

        } else {
            $remarks = $this->input->post('remarks');
            $saro_number =$this->input->post('saro_number');
            $third_liquidate = $this->input->post('third_liquidate');
            $budget_id = $this->input->post('budget_id');
            $start_date = date('Y/m/d', strtotime(str_replace('-','-', $this->input->post('liqui_date'))));
            $myid = $this->input->post('myid');
            $project_idpass = $this->input->post('project_idpass');

            $thirdliquidateupdate = $communities_model->updateThirdLiquidateTranche($third_liquidate,$saro_number,$myid,$remarks,$budget_id,$start_date,$project_idpass);

            $getList['assistancelist'] = $communities_model->get_lib_assistance();
            $getList['fundsourcelist'] = $communities_model->get_fund_source();
            $getList['lgucounterpartlist'] = $communities_model->get_lgu_counterpart();
            $getList['projectdata'] = $communities_model->view_projectbyid($project_id);
            $getList['implementationdata'] = $implementation_model->view_implementationbyproject($project_id);
            $getList['budgetdata'] = $budget_model->view_budgetbyproject($project_id);
            $getList['regionlist'] = $communities_model->get_regions();
            $this->load->view('header');
            $this->load->view('navbar');
            $this->load->view('sidebar');
            $this->load->view('view_project', $getList);
            $this->load->view('footer');

        }
        $this->redirectview($project_idpass);

    }

    public function view($project_id){
        $communities_model = new communities_model();
        $implementation_model = new implementation_model();
        $budget_model = new budget_model();
        $getList['assistancelist'] = $communities_model->get_lib_assistance();
        $getList['fundsourcelist'] = $communities_model->get_fund_source();
        $getList['lgucounterpartlist'] = $communities_model->get_lgu_counterpart();
        $getList['projectdata'] = $communities_model->view_projectbyid($project_id);
        $getList['implementationdata'] = $implementation_model->view_implementationbyproject($project_id);
        $getList['budgetdata'] = $budget_model->view_budgetbyproject($project_id);
        $getList['regionlist'] = $communities_model->get_regions();
        $this->load->view('header');
        $this->load->view('navbar');
        $this->load->view('sidebar');
        $this->load->view('view_project', $getList);
        $this->load->view('footer');
    }

    public function addCommunities(){

        $communities_model = new communities_model();

        $this->validateAddForm();

        if ($this->form_validation->run() == FALSE) {
            $this->assistance_session();
            $this->init_rpmb_session();
            $regionsaa = $this->session->userdata('uregion');
            $getList['assistancelist'] = $communities_model->get_lib_assistance();
            $getList['fundlist'] = $communities_model->get_fund_sourcelist($regionsaa);
            $getList['saalist'] = $communities_model->get_saa($regionsaa);
            $getList['projectstatuslist'] = $communities_model->get_project_status();
            $getList['implementingagency'] = $communities_model->get_implementing_agency();
            $getList['regionlist'] = $communities_model->get_regions();

            if(isset($_SESSION['province']) or isset($_SESSION['region'])) {
                $getList['provlist'] = $communities_model->get_provinces($_SESSION['region']);
            }
            if(isset($_SESSION['muni']) or isset($_SESSION['province'])) {
                $getList['munilist'] = $communities_model->get_muni($_SESSION['province']);
            }
            if(isset($_SESSION['brgy']) or isset($_SESSION['muni'])) {
                $getList['brgylist'] = $communities_model->get_brgy($_SESSION['muni']);
            }

            if (isset($_SESSION['natureofwork']) or isset($_SESSION['assistance'])) {
                $getList['natureofworklist'] = $communities_model->get_work_nature($_SESSION['assistance']);
            }
            $this->load->view('header');
            $this->load->view('navbar');
            $this->load->view('sidebar');

            $this->load->view('communities_add', $getList);
            $this->load->view('footer');
        }
        else
        {
            $myid = $this->input->post('myid');
            $saa_number = $this->input->post('saalist');
            $assistancelist = $this->input->post('assistancelist');
            $project_title = $this->input->post('project_title');
            $regionlist = $this->input->post('region_pass');
            $provlist = $this->input->post('provlist');
            $munilist = $this->input->post('munilist');
            $brgylist = $this->input->post('brgylist');
            $number_bene = $this->input->post('number_bene');
            $natureofworklist = $this->input->post('natureofworklist');
            $fundsourcelist = $this->input->post('fundsource');
            $project_amount = $this->input->post('amount_requested');
            $first_tranche = ($project_amount * 0.50);
            $second_tranche = ($project_amount* 0.40);
            $third_tranche = ($project_amount * 0.10);
            $lgucounterpart_prov = $this->input->post('lgucounterpart_prov_code');
            $lgucounterpart_muni = $this->input->post('lgucounterpart_muni_code');
            $lgucounterpart_brgy = $this->input->post('brgylist');
            $lgu_amount_prov = $this->input->post('lgu_amount_prov');
            $lgu_amount_muni= $this->input->post('lgu_amount_muni');
            $lgu_amount_brgy = $this->input->post('lgu_amount_brgy');
            $lgu_remarks_prov = $this->input->post('remarks_prov');
            $lgu_remarks_muni = $this->input->post('remarks_muni');
            $lgu_remarks_brgy = $this->input->post('remarks_brgy');
            $project_cost = $this->input->post('project_cost');
            $implementing_agency = $this->input->post('implementing_agency');
            $start_date = date('Y/m/d', strtotime(str_replace('-','-', $this->input->post('start_date'))));
            $target_date = date('Y/m/d', strtotime(str_replace('-','-', $this->input->post('target_date'))));
            $status = $this->input->post('projectstatuslist');

               $addResult = $communities_model->insertProject($myid, $saa_number, $project_title, $regionlist, $provlist, $munilist, $brgylist, $number_bene,
                   $assistancelist, $natureofworklist, $fundsourcelist, $project_amount, $lgucounterpart_prov, $lgu_amount_prov, $lgu_remarks_prov, $lgucounterpart_muni, $lgu_amount_muni, $lgu_remarks_muni,
                   $lgucounterpart_brgy, $lgu_amount_brgy, $lgu_remarks_brgy,
                   $project_cost, $project_amount, $implementing_agency, $start_date, $target_date,
                   $status, $first_tranche, $second_tranche, $third_tranche);
               if ($addResult) {
                   $this->load->view('header');
                   $this->load->view('navbar');
                   $this->load->view('sidebar');
                   $region_code = $this->session->userdata('uregion');
                   $this->load->view('communities_list', array(
                       'project' => $communities_model->get_project($region_code)
                   ));
                   $this->load->view('footer');
               }
               $this->redirectIndex();


        }
    }

    public function updateCommunities($project_id)
    {
        $communities_model = new communities_model();

        $this->validateAddForm();

        if ($this->form_validation->run() == FALSE) {
            $this->init_rpmb_session();
            $this->assistance_session();
            $getList['assistancelist'] = $communities_model->get_lib_assistance();
            $getList['fundsourcelist'] = $communities_model->get_fund_source();
            $getList['lgucounterpartlist'] = $communities_model->get_lgu_counterpart();
            $getList['projectdata'] = $communities_model->get_project_byid($project_id);
            $getList['regionlist'] = $communities_model->get_regions();

//            if(isset($_SESSION['province']) or isset($_SESSION['region'])) {
//                $getList['provlist'] = $communities_model->get_provinces($_SESSION['region']);
//            }
//            if(isset($_SESSION['muni']) or isset($_SESSION['province'])) {
//                $getList['munilist'] = $communities_model->get_muni($_SESSION['province']);
//            }
//            if(isset($_SESSION['brgy']) or isset($_SESSION['muni'])) {
//                $getList['brgylist'] = $communities_model->get_brgy($_SESSION['muni']);
//            }
//
//            if (isset($_SESSION['natureofwork']) or isset($_SESSION['assistance'])) {
//                $rpmb['natureofworklist'] = $communities_model->get_work_nature($_SESSION['assistance']);
//            }
            $this->load->view('header');
            $this->load->view('navbar');
            $this->load->view('sidebar');
            $this->load->view('communities_edit', $getList);
            $this->load->view('footer');
        }
        else
        {

            $project_id = $this->input->post('project_id');
            $assistancelist = $this->input->post('assistancelist');
            $project_title = $this->input->post('project_title');
            $regionlist = $this->input->post('regionlist');
            $provlist = $this->input->post('provlist');
            $munilist = $this->input->post('munilist');
            $brgylist = $this->input->post('brgylist');
            $number_bene = $this->input->post('number_bene');
            $natureofworklist = $this->input->post('natureofworklist');
            $fundsourcelist = $this->input->post('fundsourcelist');
            $project_amount = $this->input->post('project_amount');
            $lgucounterpartlist = $this->input->post('lgucounterpartlist');
            $lgu_amount = $this->input->post('lgu_amount');
            $lgu_fundsource = $this->input->post('lgu_fundsource');
            $project_cost = $this->input->post('project_cost');
            $implementing_agency = $this->input->post('implementing_agency');
            $status = $this->input->post('status');

            $updateResult = $communities_model->updateProject($project_id,$project_title,$regionlist,$provlist,$munilist,$brgylist,$number_bene,$assistancelist,$natureofworklist,$fundsourcelist
                ,$lgucounterpartlist,$lgu_fundsource,$lgu_amount,$project_cost,$project_amount,$implementing_agency,$status);
            if ($updateResult) {

                    $this->load->view('header');
                    $this->load->view('navbar');
                    $this->load->view('sidebar');
                    $region_code = $this->session->userdata('uregion');

                    $this->load->view('communities_list',array(
                        'project' => $communities_model->get_project($region_code)
                    ));
                    $this->load->view('footer');
            }

            $this->redirectIndex();
        }
    }

    public function deleteCommunities($project_id)
    {
        $communities_model = new communities_model();
        if ($project_id > 0){
            $deleteResult = $communities_model->deleteProject($project_id);
            if ($deleteResult){
                $this->load->view('header');
                $this->load->view('navbar');
                $this->load->view('sidebar');$region_code = $this->session->userdata('uregion');
                $this->load->view('communities_list',array(
                    'project' => $communities_model->get_project($region_code)
                ));

                $this->load->view('footer');
            }
            $this->redirectIndex();
        }
    }
    public function populate_natureofwork() {
        if($_POST['assistance_id'] > 0 and isset($_POST) and isset($_POST['assistance_id'])) {

            $assistance_id = $_POST['assistance_id'];
            $natureofworklist = $this->communities_model->get_work_nature($assistance_id);

            $natureofwork_list[''] = "Choose Nature of work";
            foreach($natureofworklist as $tempnatureofworklist) {
                $natureofwork_list[$tempnatureofworklist->nature_id] = $tempnatureofworklist->work_nature;
            }

            $natureofworklist_prop = 'required="required" required id="natureofworklist" name="natureofworklist" class="form-control" onChange="get_maxmin();recalculateSum();" ';
            echo form_dropdown('natureofworklist', $natureofwork_list,'',$natureofworklist_prop);



        }
    }

    public function populate_saa_list()
    {


        $label = array(
            'for'          => 'saalist',
            'class'        => 'control-label'
        );
        echo form_label('SAA Number:', '', $label);
        if($_POST['fundsource_id'] > 0 and isset($_POST) and isset($_POST['fundsource_id']))
        {
            $fundsource_id = $_POST['fundsource_id'];
            $regionsaa = $this->session->userdata('uregion');
            $saa_data = $this->communities_model->get_saa_region($fundsource_id,$regionsaa);
//            print_r($saa_data);
            $saalist[''] = "Choose Saa Number";
            foreach($saa_data as $saa_select) {
                $saalist[$saa_select->saa_number] = $saa_select->saa_number.' - (₱'. number_format($saa_select->saa_balance,2).')';
            }

            $saalist_prop = 'name="saalist" id="saalist" class="form-control"  required="required" onchange="get_saa_balance();" autofocus';

            echo form_dropdown('saalist', $saalist, '', $saalist_prop);
        }

    }

    public function populate_naturemaxmin()
    {
        $label = array(
            'for'          => 'saalist',
            'class'        => 'control-label'
        );
        echo form_label('Amount Requested:', '', $label);
        if($_POST['nature_id'] > 0 and isset($_POST) and isset($_POST['nature_id']))
        {
        $nature_id = $_POST['nature_id'];
        $natureofworklist = $this->communities_model->get_naturemaxmin($nature_id);

            $data1 = array(
                'type'        => 'number',
                'id'          => 'amount_requested',
                'name'       => 'amount_requested',
                'max'   => $natureofworklist->maximum_amount,
                'min'   => '0',
                'value'   =>  $natureofworklist->maximum_amount,
                'class'        => 'form-control',
                 'onblur'=> "recalculateSum();"
            );

            echo form_input($data1);
            echo form_label('Maximum Amount: ₱ '.number_format($natureofworklist->maximum_amount,2), '','₱ '.$natureofworklist->maximum_amount);

        }
    }



    public function assistance_session() {
        if(isset($_POST['assistancelist']) and $_POST['assistancelist'] > 0) {
            $_SESSION['assistance'] = $_POST['assistancelist'];
        }
        if(isset($_POST['natureofworklist']) and $_POST['natureofworklist'] > 0) {
            $_SESSION['natureofwork'] = $_POST['natureofworklist'];
        }
    }

    public function populate_prov() {
        if($_POST['region_code'] > 0 and isset($_POST) and isset($_POST['region_code'])) {

            $region_code = $_POST['region_code'];
            $provlist = $this->communities_model->get_provinces($region_code);

            $province_list[] = "Choose Province";
            foreach($provlist as $tempprov) {
                $province_list[$tempprov->prov_code] = $tempprov->prov_name;
            }

            $provlist_prop = 'required="required" required id="provlist" name="provlist" class="form-control" onChange="get_muni();"';

            echo form_dropdown('provlist', $province_list, '', $provlist_prop);
        }
    }

    public function populate_muni() {
        if($_POST['prov_code'] > 0 and isset($_POST) and isset($_POST['prov_code'])) {
            $prov_code = $_POST['prov_code'];
            $munilist = $this->communities_model->get_muni($prov_code);
            $prov_name = $this->communities_model->get_province_name($prov_code);
            $data1 = array(
                'type'        => 'hidden',
                'id'          => 'lgucounterpart_prov_name',
                'name'       => 'lgucounterpart_prov_name',
                'value'   =>  $prov_name->prov_name,
                'class'        => 'form-control',
                'disabled' => true
            );

            echo form_input($data1);

            $muni_list[] = "Choose Municipality";
            foreach($munilist as $tempmuni) {
                $muni_list[$tempmuni->city_code] = $tempmuni->city_name;
            }

            $munilist_prop = 'required="required" required  id="munilist" name="munilist" onchange="get_brgy();" class="form-control"';
            echo form_dropdown('munilist', $muni_list,'',$munilist_prop);
        }
    }
    public function populate_brgy() {
        if($_POST['city_code'] > 0 and isset($_POST) and isset($_POST['city_code'])) {
            $city_code = $_POST['city_code'];
            $brgylist = $this->communities_model->get_brgy($city_code);
            $city_name = $this->communities_model->get_muni_name($city_code);

            $data1 = array(
                'type'        => 'hidden',
                'id'          => 'lgucounterpart_muni_name',
                'name'       => 'lgucounterpart_muni_name',
                'value'   =>  $city_name->city_name,
                'class'        => 'form-control',
                'disabled' => true
            );

            echo form_input($data1);

            $brgy_list[] = "Choose Barangay";
            foreach($brgylist as $tempbrgy) {
                $brgy_list[$tempbrgy->brgy_code] = $tempbrgy->brgy_name;
            }

            $brgylist_prop = 'required="required" required id="brgylist" name="brgylist" onChange="get_brgy_name();" class="form-control"';
            echo form_dropdown('brgylist', $brgy_list,'',$brgylist_prop);
        }
    }
    public function populate_brgy_name() {
        if($_POST['brgy_code'] > 0 and isset($_POST) and isset($_POST['brgy_code'])) {
            $brgy_code = $_POST['brgy_code'];
            $brgy_name = $this->communities_model->get_brgy_name($brgy_code);
            echo form_label('Barangay:','');

            $data1 = array(
                'type'        => 'text',
                'id'          => 'lgucounterpart_brgy_name',
                'name'       => 'lgucounterpart_brgy_name',
                'value'   =>  $brgy_name->brgy_name,
                'class'        => 'form-control',
                'disabled' => true
            );
            echo form_input($data1);

        }

    }
    public function populate_saa_amount()
    {

//        if($_POST['saro_id'] > 0 and isset($_POST) and isset($_POST['saro_id']))
//        {
            $saa_id = $_POST['saa_id'];
            $saadata = $this->communities_model->get_saa_balance($saa_id);
            $saa_bal = "$saadata->saa_balance";
            $data1 = array(
                'type'        => 'hidden',
                'id'          => 'saa_amount',
                'name'       =>  'saa_amount',
                'max'   =>  $saa_bal,
                'min'   => '0',
                'value'   =>  $saa_bal,
                'class'        => 'form-control'
            );

            echo form_input($data1);

//        }
    }
    public function init_rpmb_session() {
        if(isset($_POST['regionlist']) and $_POST['regionlist'] > 0) {
            $_SESSION['region'] = $_POST['regionlist'];
        }
        if(isset($_POST['provlist']) and $_POST['provlist'] > 0) {
            $_SESSION['province'] = $_POST['provlist'];
        }
        if(isset($_POST['munilist']) and $_POST['munilist'] > 0) {
            $_SESSION['muni'] = $_POST['munilist'];
        }
        if(isset($_POST['brgylist']) and $_POST['brgylist'] > 0) {
            $_SESSION['brgy'] = $_POST['brgylist'];
        }
    }

    protected function validateAddForm()
    {
        $config = array(
            array(
                'field' => 'project_title',
                'label' => 'Project Title',
                'rules' => 'required'
            )
        );
        return $this->form_validation->set_rules($config);

    }
    protected function validateAddTrancheForm()
    {
        $config = array(
            array(
                'field' => 'remarks',
                'label' => 'remarks remarks',
                'rules' => 'required'
            )
        );
        return $this->form_validation->set_rules($config);

    }
    public function redirectIndex()
    {
        $page = base_url('communities/index');

        header("LOCATION: $page");
    }
    public function redirectAdd()
    {
        $page = base_url('communities/addCommunities');

        header("LOCATION: $page");
    }
    public function redirectview($project_idpass)
    {
        $page = base_url('communities/view/'.$project_idpass);

        header("LOCATION: $page");
    }
}