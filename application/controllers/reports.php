<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class reports extends CI_Controller {



    public function index()
    {
        $this->init_rpmb_session();
//        $rpmb['regionlist'] = $this->reports_model->get_regions();
//
//        if(isset($_SESSION['province']) or isset($_SESSION['region'])) {
//            $rpmb['provlist'] = $this->reports_model->get_provinces($_SESSION['region']);
//        }
//        if(isset($_SESSION['muni']) or isset($_SESSION['province'])) {
//            $rpmb['munilist'] = $this->reports_model->get_muni($_SESSION['province']);
//        }
//        if(isset($_SESSION['brgy']) or isset($_SESSION['muni'])) {
//            $rpmb['brgylist'] = $this->reports_model->get_brgy($_SESSION['muni']);
//        }
        $reports_model = new reports_model();
        $crims['crims'] = $reports_model->get_crims();

        $form_message = '';
        $this->load->view('header');
        $this->load->view('navbar');
        $this->load->view('sidebar');
        $this->load->view('reports_view',$crims);//,$rpmb
        $this->load->view('footer');

    }

    public function crimstesting ()
    {

        $this->load->view('header');
        $this->load->view('navbar');
        $this->load->view('sidebar');
        $this->load->view('reports_view');//,$rpmb
        $this->load->view('footer');
    }
    public function get_funds()
    {
        $funds_details = $this->reports_model->get_funds();

// Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

// Add some data

        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Funds Monitoring');
        //autosize column

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setRGB('FF0000');
//        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);a
        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
        $objPHPExcel->getActiveSheet()->mergeCells('A1:E2');

        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $col = 'A';
//        $row = 5;
        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Region');
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('B3', 'Fund Monitoring Report');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:A5');
        $objPHPExcel->getActiveSheet()->mergeCells('B3:E3');
        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $objPHPExcel->getActiveSheet()->mergeCells('B6:E6');
        $objPHPExcel->getActiveSheet()->freezePane('B6');
        //Header
        $colheader = 'B';
        for($headercount = 1;$headercount < 2; $headercount++)
        {
            $objPHPExcel->getActiveSheet()->setCellValue($colheader.'4', 'Funds Allocated');$colheader++;
            $objPHPExcel->getActiveSheet()->setCellValue($colheader.'4', 'Funds Downloaded');$colheader++;
            $objPHPExcel->getActiveSheet()->setCellValue($colheader.'4', 'Funds Utilized');$colheader++;
            $objPHPExcel->getActiveSheet()->setCellValue($colheader.'4', '% Utilized');$colheader++;
        }



        $row2 = 7;
        $col2 = 'A';
        foreach ($funds_details as $fundsdata):

            $region_name = $fundsdata->region_name;

            $funds_allocated  = $fundsdata->funds_allocated;
            $funds_downloaded  = $fundsdata->funds_downloaded;

            $funds_utilized  = $fundsdata->funds_utilized;
            $percent_util = ($funds_utilized /$funds_allocated );

            $objPHPExcel->getActiveSheet()->setCellValue($col2. $row2 . '', $region_name);$col2++;
            $objPHPExcel->getActiveSheet()->getColumnDimension($col2)->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getStyle($col2. $row2)->getNumberFormat()->setFormatCode('#,##0.00');
            $objPHPExcel->getActiveSheet()->setCellValue($col2. $row2 . '', $funds_allocated);$col2++;
            $objPHPExcel->getActiveSheet()->getColumnDimension($col2)->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getStyle($col2. $row2)->getNumberFormat()->setFormatCode('#,##0.00');
            $objPHPExcel->getActiveSheet()->setCellValue($col2. $row2 . '', $funds_downloaded);$col2++;
            $objPHPExcel->getActiveSheet()->getColumnDimension($col2)->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getStyle($col2. $row2)->getNumberFormat()->setFormatCode('#,##0.00');
            $objPHPExcel->getActiveSheet()->setCellValue($col2. $row2 . '', $funds_utilized);$col2++;
            $objPHPExcel->getActiveSheet()->getColumnDimension($col2)->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getStyle($col2. $row2)->getNumberFormat()->setFormatCode('#,##0.00');
            $objPHPExcel->getActiveSheet()->setCellValue($col2. $row2 . '', $percent_util);
            $objPHPExcel->getActiveSheet()->getColumnDimension($col2)->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getStyle($col2.$row2)
                ->getNumberFormat()->applyFromArray(
                    array(
                        'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
                    )
                );
            if($col2 == 'E'){$col2 = 'A';}
            $row2++;
        endforeach;




        //border
        $objPHPExcel->getActiveSheet()->getStyle(
            'A1:' .
            $objPHPExcel->getActiveSheet()->getHighestColumn() .
            $objPHPExcel->getActiveSheet()->getHighestRow()
        )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
// Rename worksheet (worksheet, not filename)
        $objPHPExcel->getActiveSheet()->setTitle('FundsMonitoring');

// Set active sheet index to the first sheet, so Excel opens this as the first asheet
        $objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel2007)
//clean the output buffer
        ob_end_clean();

//this is the header given from PHPExcel examples. but the output seems somewhat corrupted in some cases.
//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//so, we use this header instead.
//        $regionName = $this->reports_model->getRegionName($region);
        $filename = 'Fund-Monitoring.xlsx';
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }

    //------------------------------------------------------------------------PSGC------------------------------------------------------------------------------------
    public function populate_prov() {
        if($_POST['region_code'] > 0 and isset($_POST) and isset($_POST['region_code'])) {

            $region_code = $_POST['region_code'];
            $provlist = $this->familyinfo_model->get_provinces($region_code);

            $province_list[] = "Choose Province";
            foreach($provlist as $tempprov) {
                $province_list[$tempprov->id_province] = $tempprov->prov_name;
            }

            $provlist_prop = 'id="provlist" name="provlist" class="form-control" onChange="get_muni();"';

            echo form_dropdown('provlist', $province_list, '', $provlist_prop);
        }
    }
    public function populate_muni() {
        if($_POST['prov_code'] > 0 and isset($_POST) and isset($_POST['prov_code'])) {
            $prov_code = $_POST['prov_code'];
            $munilist = $this->familyinfo_model->get_muni($prov_code);

            $muni_list[] = "Choose Municipality";
            foreach($munilist as $tempmuni) {
                $muni_list[$tempmuni->id_municipality] = $tempmuni->city_name;
            }

            $munilist_prop = 'id="munilist" name="munilist" onchange="get_brgy();" class="form-control"';
            echo form_dropdown('munilist', $muni_list,'',$munilist_prop);
        }
    }
    public function populate_brgy() {
        if($_POST['city_code'] > 0 and isset($_POST) and isset($_POST['city_code'])) {
            $city_code = $_POST['city_code'];
            $brgylist = $this->familyinfo_model->get_brgy($city_code);

            $brgy_list[] = "Choose Barangay";
            foreach($brgylist as $tempbrgy) {
                $brgy_list[$tempbrgy->id_barangay] = $tempbrgy->brgy_name;
            }

            $brgylist_prop = 'id="brgylist" name="brgylist" class="form-control"';
            echo form_dropdown('brgylist', $brgy_list,'',$brgylist_prop);
        }
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
    public function viewTable(){
        $reports_model = new reports_model();
//        $data = array(
//            'regionlist' => $this->input->post('regionlist'),
//            'provlist' => $this->input->post('provlist'),
//            'munilist' => $this->input->post('munilist'),
//            'brgylist' => $this->input->post('brgylist'),
//            'risks' => $this->input->post('risks'),
//            'getYears' => $this->input->post('getYears'),
//            'submit' => $this->input->post('submit'),
//            'getRiskAll' => $reports_model->get_risk_all($this->input->post('regionlist'),$this->input->post('provlist'),$this->input->post('munilist'),$this->input->post('brgylist'))
//    );
        $this->init_rpmb_session();

        $regionlist = $this->input->post('regionhide1');
        $provlist = $this->input->post('provlist');
        $munilist = $this->input->post('munilist');
        $brgylist = $this->input->post('brgylist');
        $risks = $this->input->post('risks');

        $getYears = $this->input->post('getYears');
        $getRange = $this->input->post('getRange');
        $submit = $this->input->post('submit');

        $this->load->view('header');
        $this->load->view('nav');
        $this->load->view('sidebar');
        $this->load->view("report_listview",array(
            'getRiskAll' => $reports_model->get_risk_all($regionlist,$provlist,$munilist,$brgylist),
            'getRiskAllAbove40' => $reports_model->get_risk_all_above40($regionlist,$provlist,$munilist,$brgylist),
            'getRiskAllBelow40' => $reports_model->get_risk_all_below40($regionlist,$provlist,$munilist,$brgylist),
            'getRiskBoth' => $reports_model->get_risk_both($regionlist,$provlist,$munilist,$brgylist),
            'getRiskBothAbove40' => $reports_model->get_risk_both_above40($regionlist,$provlist,$munilist,$brgylist),
            'getRiskBothBelow40' => $reports_model->get_risk_both_below40($regionlist,$provlist,$munilist,$brgylist),
            'getIndivBoth' => $reports_model->get_indivrisk_both($regionlist,$provlist,$munilist,$brgylist),
            'getEcoBoth' => $reports_model->get_ecorisk_both($regionlist,$provlist,$munilist,$brgylist),
            'getDisBoth' => $reports_model->get_disasterrisk_both($regionlist,$provlist,$munilist,$brgylist),
            'getSocBoth' => $reports_model->get_socialrisk_both($regionlist,$provlist,$munilist,$brgylist),
            'getRisk2to5' => $reports_model->get_risk_all2to5yrs($regionlist,$provlist,$munilist,$brgylist),
            'getIndiv2to5' => $reports_model->get_risk_indiv2to5yrs($regionlist,$provlist,$munilist,$brgylist),
            'getEco2to5' => $reports_model->get_risk_eco2to5yrs($regionlist,$provlist,$munilist,$brgylist),
            'getDis2to5' => $reports_model->get_risk_disaster2to5yrs($regionlist,$provlist,$munilist,$brgylist),
            'getSoc2to5' => $reports_model->get_risk_social2to5yrs($regionlist,$provlist,$munilist,$brgylist),
            'getRiskWithin' => $reports_model->get_risk_allwithin($regionlist,$provlist,$munilist,$brgylist),
            'getIndivWithin' => $reports_model->get_risk_indivwithin($regionlist,$provlist,$munilist,$brgylist),
            'getEcoWithin' => $reports_model->get_risk_ecowithin($regionlist,$provlist,$munilist,$brgylist),
            'getDisWithin' => $reports_model->get_risk_disasterwithin($regionlist,$provlist,$munilist,$brgylist),
            'getSocWithin' => $reports_model->get_risk_socialwithin($regionlist,$provlist,$munilist,$brgylist),
            'regionlist2' => $regionlist,
            'provlist2' => $provlist,
            'munilist2' => $munilist,
            'brgylist2' => $brgylist,
            'risks' => $risks,
            'getYears' => $getYears,
            'getRange' => $getRange,
            'submit' => $submit,
            'regionlist1' => $reports_model->get_regions(),
        ));
        $this->load->view('footer');
    }
}