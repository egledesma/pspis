<?php
/**
 * Created by PhpStorm.
 * User: mblejano
 * Date: 4/5/2016
 * Time: 2:42 PM
 */


class withdraw_model extends CI_Model
{
    public function get_saa_amount($saa_id)
    {
        $sql = 'select saa_funds,saa_id,saa_number,saa_balance from tbl_saa
where saa_id = "'.$saa_id.'" and deleted = 0';
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;

        $this->db->close();
    }

    public function withdrawFunds($fund_source,$saa_id,$withdraw_date,$saalist,$new_saa,$from_region,$to_region,$saa_amount,$remarks,$funds_identifier)
    {

        $this->db->trans_begin();
        $this->db->query('insert into tbl_withdraw(
                          fundsource_id,saa_id,date,old_saa_number,saa_number,from_office,to_office,amount,remarks,created_by,date_created)
                          values
                          ("'.$fund_source.'","'.$saa_id.'","'.$withdraw_date.'","'.$saalist.'","'.$new_saa.'","'.$from_region.'","'.$to_region.'","'.$saa_amount.'","'.$remarks.'","'.$this->session->userdata('uid').'",now())');


        //from region
        $from_value = $this->db->query('SELECT funds_allocated,other_funds,remaining_budget FROM tbl_funds_allocated WHERE region_code ="'.$from_region.'" and fundsource_id = "'.$fund_source.'"');
        $from_value1 = $from_value->row();
        $other_funds = $from_value1->other_funds + $saa_amount;
        $remain_balance = $from_value1->remaining_budget - $saa_amount;

        $this->db->query('update tbl_funds_allocated
        set other_funds = "'.$other_funds.'",
        remaining_budget = "'.$remain_balance.'",
        date_modified = now(),
        modified_by = "'.$this->session->userdata('uid').'" WHERE region_code ="'.$from_region.'" and fundsource_id = "'.$fund_source.'"');

        //to region
        $result = $this->db->query('SELECT * FROM tbl_funds_allocated WHERE region_code ="'.$to_region.'" and fundsource_id = "'.$fund_source.'" ');
        if($result->num_rows() > 0) {

            $this->db->query('Update tbl_funds_allocated set
                  funds_allocated = funds_allocated + "'.$saa_amount.'",
                  funds_allocated = funds_allocated + "'.$saa_amount.'",
                  date_modified = now(),
                  modified_by = "'.$this->session->userdata('uid').'"
                  WHERE region_code ="' . $to_region . '" and fundsource_id = "' . $fund_source . '" ');

        } else {

            $this->db->query('insert into tbl_funds_allocated(
                          fundsource_id,region_code,funds_allocated,remaining_budget,date_created,created_by,status,funds_identifier)
                          values
                          ("'.$fund_source.'","'.$to_region.'","'.$saa_amount.'","'.$saa_amount.'",
                          now(),"'.$this->session->userdata('uid').'",0,
                          "'.$funds_identifier.'")');

        }

        $result9 = $this->db->query('SELECT * FROM tbl_fallocation_history WHERE region_code ="'.$to_region.'" and fundsource_id = "'.$fund_source.'" and identifier ="1" ');
        if($result9->num_rows() > 0) {
            $from_value9= $this->db->query('SELECT * FROM tbl_fallocation_history WHERE region_code ="'.$to_region.'" and fundsource_id = "'.$fund_source.'" and identifier ="1"  ORDER BY allocation_history_id DESC limit 1 ');
            $from_value10 = $from_value9->row();
            $allocated_old_value = $from_value10->allocated_new_value;
            $allocated_new_value = $from_value10->allocated_new_value + $saa_amount ;

            $this->db->query('insert into tbl_fallocation_history1(
                          fundsource_id,region_code,allocated_old_value,allocated_amount,allocated_new_value,description,created_by,date_created,identifier)
                          values
                          ("'.$fund_source.'","'.$to_region.'","'.$allocated_old_value.'","'.$saa_amount.'","'.$allocated_new_value.'","DOWNLOAD FUNDS - SAA: '.$saalist.'","'.$this->session->userdata('uid').'",now(),"2")');

        } else {

            $this->db->query('insert into tbl_fallocation_history(
                          fundsource_id,region_code,allocated_old_value,allocated_amount,allocated_new_value,description,created_by,date_created,identifier)
                          values
                          ("'.$fund_source.'","'.$to_region.'","0","'.$saa_amount.'","'.$saa_amount.'","DOWNLOAD FUNDS - SAA: '.$saalist.'",
                          "'.$this->session->userdata('uid').'",now(),
                          "2")');

        }

        //insert_tbl_saa
        $this->db->query('insert into tbl_saa(
                          fundsource_id,saa_number,region_code,saa_funds,saa_balance,remarks,date_created,created_by,status,funds_identifier)
                          values
                          ("'.$fund_source.'","'.$new_saa.'","'.$to_region.'","'.$saa_amount.'","'.$saa_amount.'","Transferred",now(),"'.$this->session->userdata('uid').'","0",
                          "'.$funds_identifier.'")');


        //update tbl_saa
        $bal = $this->db->query('SELECT saa_balance FROM tbl_saa WHERE saa_id ="'.$saa_id.'"');
        $saabal = $bal->row();
        $saa_balance = $saabal->saa_balance;

        if($saa_balance == $saa_amount ) {
            $this->db->query('update tbl_saa set
                          remarks = "Transferred",
                          date_modified = now(),
                          modified_by = "' . $this->session->userdata('uid') . '",
                          status = 1
                          where saa_id ="' . $saa_id . '"');
        } else {
            $this->db->query('update tbl_saa set
                          saa_balance = saa_balance - "'.$saa_amount .'",
                          remarks = "Transferred",
                          date_modified = now(),
                          modified_by = "' . $this->session->userdata('uid') . '",
                          status = 0
                          where saa_id ="' . $saa_id . '"');
        }

        //tbl_cofunds
        $result1 = $this->db->query('SELECT * FROM tbl_consofunds_history WHERE fundsource_id ="'.$fund_source.'" and identifier ="2" ');

        if($result1->num_rows() > 0) {
            $from_value = $this->db->query('SELECT * FROM tbl_consofunds_history WHERE fundsource_id ="'.$fund_source.'" and identifier = "2" ORDER BY consolidated_id DESC limit 1 ');
            $from_value1 = $from_value->row();
            $conso_old_value = $from_value1->consolidated_new_value;
            $conso_new_value = $from_value1->consolidated_new_value - $saa_amount ;

            $this->db->query('insert into tbl_consofunds_history(
                          fundsource_id,consolidated_old_value,amount,consolidated_new_value,description,created_by,date_created,identifier)
                          values
                          ("'.$fund_source.'","'.$conso_old_value.'","'.$saa_amount.'","'.$conso_new_value.'","WITHDRAW FUNDS - SAA: '.$saalist.'","'.$this->session->userdata('uid').'",now(),"2")');

            $from_value2 = $this->db->query('SELECT * FROM tbl_consofunds_history WHERE fundsource_id ="'.$fund_source.'" and identifier = "2" ORDER BY consolidated_id DESC limit 1 ');
            $from_value3 = $from_value2->row();
            $conso_old_value = $from_value3->consolidated_new_value;
            $conso_new_value = $from_value3->consolidated_new_value + $saa_amount ;
            $this->db->query('insert into tbl_consofunds_history(
                          fundsource_id,consolidated_old_value,amount,consolidated_new_value,description,created_by,date_created,identifier)
                          values
                          ("'.$fund_source.'","'.$conso_old_value.'","'.$saa_amount.'","'.$conso_new_value.'","DOWNLOAD FUNDS - SAA: '.$new_saa.'","'.$this->session->userdata('uid').'",now(),"2")');
        }
        else
        {
            $this->db->query('insert into tbl_consofunds_history(
                          fundsource_id,consolidated_old_value,amount,consolidated_new_value,description,date_created,created_by,identifier)
                          values
                          ("'.$fund_source.'","0","'.$saa_amount.'","'.$saa_amount.'","DOWNLOAD FUNDS - SAA: '.$saalist.'",
                          now(),"'.$myid.'","2")');
        }

        //tbl_fallocation_history
        $result2 = $this->db->query('SELECT * FROM tbl_fallocation_history WHERE fundsource_id ="'.$fund_source.'" and region_code = "'.$to_region.'" and identifier ="2" ');

        if($result2->num_rows() > 0) {
            $from_value2 = $this->db->query('SELECT * FROM tbl_fallocation_history WHERE fundsource_id ="'.$fund_source.'" and region_code = "'.$to_region.'" and identifier = "2" ORDER BY fundsource_id DESC limit 1 ');
            $from_value3 = $from_value2->row();
            $allocate_old_value = $from_value3->allocated_new_value;
            $allocate_new_value = $from_value3->allocated_new_value + $saa_amount ;

            $this->db->query('insert into tbl_fallocation_history(
                fundsource_id,region_code,allocated_old_value,allocated_amount,allocated_new_value,description,created_by,date_created,identifier)
                          values
                          ("'.$fund_source.'","'.$to_region.'","'.$allocate_old_value.'","'.$saa_amount.'","'.$allocate_new_value.'","DOWNLOAD FUNDS - SAA: '.$new_saa.'","'.$this->session->userdata('uid').'",now(),"12")');
        }
        else
        {
            $this->db->query('insert into tbl_fallocation_history(
                          fundsource_id,region_code,allocated_old_value,allocated_amount,allocated_new_value,description,created_by,date_created,identifier)
                          values
                          ("'.$fund_source.'","'.$to_region.'","0","'.$saa_amount.'","'.$saa_amount.'","DOWNLOAD FUNDS - SAA: '.$new_saa.'",
                          "'.$this->session->userdata('uid').'",now(),"12")');
        }

//        $result3 = $this->db->query('SELECT * FROM tbl_fallocation_history WHERE fundsource_id ="'.$fund_source.'" and region_code = "'.$to_region.'" and identifier ="4" ');

//        if($result3->num_rows() > 0) {
//            $from_value4 = $this->db->query('SELECT * FROM tbl_fallocation_history WHERE fundsource_id ="'.$fund_source.'" and region_code = "'.$to_region.'" and identifier = "4" ORDER BY fundsource_id DESC limit 1 ');
//            $from_value5 = $from_value4->row();
//            $allocate_old_value = $from_value5->allocated_new_value;
//            $allocate_new_value = $from_value5->allocated_new_value + $saa_amount ;
//
//            $this->db->query('insert into tbl_fallocation_history(
//                fundsource_id,region_code,allocated_old_value,allocated_amount,allocated_new_value,description,created_by,date_created,identifier)
//                          values
//                          ("'.$fund_source.'","'.$to_region.'","'.$allocate_old_value.'","'.$saa_amount.'","'.$allocate_new_value.'","WITHDRAW FUNDS - SAA: '.$saalist.'","'.$this->session->userdata('uid').'",now(),"4")');
//        }
//        else
//        {
//            $this->db->query('insert into tbl_fallocation_history(
//                          fundsource_id,region_code,allocated_old_value,allocated_amount,allocated_new_value,description,created_by,date_created,identifier)
//                          values
//                          ("'.$fund_source.'","'.$to_region.'","0","'.$saa_amount.'","'.$saa_amount.'","WITHDRAW FUNDS - SAA: '.$saalist.'",
//                          "'.$this->session->userdata('uid').'",now(),"4")');
//        }



        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return FALSE;
        }
        else
        {
            $this->db->trans_commit();
            return TRUE;
        }
        $this->db->close();

    }


//    public function withdrawFunds1($year,$regionlist,$saro,$funds_allocated,$myid,$status,$funds_identifier)
//    {
//
//        $this->db->trans_begin();
//        $this->db->query('insert into tbl_saro(
//                          for_year,saro_number,region_code,saro_funds,saro_balance,date_created,created_by,status,funds_identifier)
//                          values
//                          ("'.$year.'","'.$saro.'","'.$regionlist.'","'.$funds_allocated.'","'.$funds_allocated.'",now(),"'.$myid.'","'.$status.'",
//                          "'.$funds_identifier.'")');
//
//
//        $result = $this->db->query('SELECT * FROM tbl_funds_allocated WHERE region_code ="'.$regionlist.'" ');
//
//        if($result->num_rows() > 0) {
//            $this->db->query('Update tbl_funds_allocated set
//                  funds_allocated = "'.$funds_allocated.'" + funds_allocated,
//                  date_modified = now(),
//                  modified_by = "'.$myid.'"
//                  WHERE region_code = "'.$regionlist.'" ');
//        }
//        else
//        {
//            $this->db->query('insert into tbl_funds_allocated(
//                          for_year,region_code,funds_allocated,date_created,created_by,status,funds_identifier)
//                          values
//                          ("'.$year.'","'.$regionlist.'","'.$funds_allocated.'",
//                          now(),"'.$myid.'","'.$status.'",
//                          "'.$funds_identifier.'")');
//        }
//
//        if ($this->db->trans_status() === FALSE)
//        {
//            $this->db->trans_rollback();
//            return FALSE;
//        }
//        else
//        {
//            $this->db->trans_commit();
//            return TRUE;
//        }
//        $this->db->close();
//
//    }

    public function get_regions() {
        $get_regions = "
        SELECT
          region_code,
          region_name
        FROM
          lib_region
        WHERE
          region_code <> '000000000'
        ORDER BY
          region_code
        ";

        return $this->db->query($get_regions)->result();
    }

    public function get_from_region($region_code) {
        $get_regions1 = '
        SELECT
          region_code,
          region_name
        FROM
          lib_region
        WHERE
          region_code ="'.$region_code.'"
        ';

        return $this->db->query($get_regions1)->row();
    }

    public function get_provinces($region_code) {
        $get_prov = "
        SELECT
            prov_code,
            prov_name
        FROM
          lib_provinces
       WHERE
          region_code = ?
        ORDER BY
          prov_name
        ";

        return $this->db->query($get_prov,$region_code)->result();
    }

    public function get_muni($prov_code) {
        $get_cities = "
        SELECT
            city_code,
            city_name
        FROM
          lib_municipality
        WHERE
          prov_code = ?
        ORDER BY
          city_name
        ";

        return $this->db->query($get_cities,$prov_code)->result();
    }

    public function get_brgy($city_code) {
        $get_brgy = "
        SELECT
            brgy_code,
            brgy_name
        FROM
          lib_brgy
        WHERE
          city_code = ?
        ORDER BY
          brgy_name
        ";

        return $this->db->query($get_brgy,$city_code)->result();
    }

    public function get_fundsource_byid($fundsource_id = 0)
    {
        $sql = 'select fundsource_id,fund_source from lib_fund_source
                where fundsource_id ="'.$fundsource_id.'"
               ';
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
        $this->db->close();
    }

}