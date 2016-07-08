<?php
//a
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class individual_model extends CI_Model
{
    public function get_fund_source($regionsaro)
    {
        $get_fund_source = "
        SELECT
          a.fundsource_id,
          a.fund_source,
          b.remaining_budget
        FROM
          lib_fund_source a
        inner JOIN tbl_funds_allocated b
        on a.fundsource_id = b.fundsource_id
        WHERE
        a.deleted = 0 and b.deleted = 0 and b.region_code = ?

        ";

        return $this->db->query($get_fund_source,$regionsaro)->result();

    }
    public function get_crims($regionsaro)
    {
        $admin_db= $this->load->database('ADMINDB', TRUE);
        if($regionsaro == 190000000 )
        {
            $region_code = 0;
        }
        else
        {
            $region_code = $regionsaro;
        }

        $sql = 'SELECT sum(a.AmountOfFinanceAssist) as Utilize,b.region_name,a.RegionAssist
FROM `crimsmonitoringreports` a
inner join lib_regions b
on a.RegionAssist = b.region_code
where a.RegionAssist = "'.$region_code.'"
GROUP BY a.RegionAssist';
        $query = $admin_db->query($sql);
        $result = $query->row();
        $admin_db->close();
        return $result;

    }
    public function get_aics_details($regionsaro)
    {
        $sql = 'SELECT  a.aics_id,b.fund_source,a.amount,a.region_code,a.date_utilized
FROM `tbl_aics_history` a
inner join lib_fund_source b
on a.fundsource_id = b.fundsource_id
where a.deleted = 0 and a.region_code = "'.$regionsaro.'" and b.status = 0
order by a.aics_id asc';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
        $this->db->close();

    }

    public function get_last_utilized($regionsaro)
    {
        $sql = 'SELECT amount FROM `tbl_aics_history` where region_code = "'.$regionsaro.'" order by aics_id desc limit 1';
        $query = $this->db->query($sql);
        if($query->num_rows() > 0) {

            $result = $query->row();
            return $result;
        }
        else
        {
            $result = 0;
            return $result;

        }

        $this->db->close();

    }
    public function get_saro_balance($saro_id)
    {
        $sql = 'select saro_funds,saro_id,saro_number,saro_balance from tbl_saro
where saro_id = "'.$saro_id.'" and deleted = 0';
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;

        $this->db->close();
    }
    public function insertAics($fundlist,$regionlist,$utilize,$utilizeddifference,$date_utilized,$myid)
    {

        $this->db->trans_begin();
        $this->db->query('insert into tbl_aics_history(fundsource_id,region_code,amount,date_utilized,date_created,created_by,deleted)
                          values
                          ("'.$fundlist.'","'.$regionlist.'","'.$utilize.'","'.$date_utilized.'",now(),"'.$myid.'","0")');

        $this->db->query('UPDATE tbl_funds_allocated SET
                              funds_utilized = "'.$utilizeddifference.'" + funds_utilized,
                              remaining_budget = remaining_budget - "'.$utilizeddifference.'",
                              modified_by = "'.$this->session->userdata('uid').'"
                              WHERE
                              fundsource_id  = "'.$fundlist.'" and
                              region_code = "'.$regionlist.'"
                              ');

        //for tbl_fallocation_history
        //check if existing
        //yes
        //get new _value where identifier = 3;description ;insert the get new_value to old_value then input new_value
        //no old_value = 0

        $resultfunds = $this->db->query('SELECT * FROM tbl_fallocation_history WHERE region_code ="'.$regionlist.'" and fundsource_id = "'.$fundlist.'" and identifier = "3" and deleted = "0"  Order by allocation_history_id DESC limit 1');
        $resultfunds_value = $resultfunds->row();
        $funds_new_allocated = $resultfunds_value->allocated_new_value;
        $funds_new_value = $funds_new_allocated + $utilizeddifference;

        if($resultfunds->num_rows() > 0) {

            $this->db->query('insert into tbl_fallocation_history(
                          fundsource_id,region_code,allocated_old_value,allocated_amount,allocated_new_value,description,date_created,created_by,deleted,identifier)
                          values
                          ("'.$fundlist.'","'.$regionlist.'","'.$funds_new_allocated.'","'.$utilizeddifference.'","'.$funds_new_value.'","UTILIZED AICS",
                          now(),"'.$this->session->userdata('uid').'",0,
                          "3")');

        }
        else
        {
            $this->db->query('insert into tbl_fallocation_history(
                          fundsource_id,region_code,allocated_old_value,allocated_amount,allocated_new_value,description,date_created,created_by,deleted,identifier)
                          values
                          ("'.$fundlist.'","'.$regionlist.'","0","'.$utilizeddifference.'","'.$utilizeddifference.'","UTILIZED AICS",
                          now(),"'.$this->session->userdata('uid').'",0,
                          "3")');
        }

        $this->db->query('UPDATE tbl_co_funds SET
                              co_funds_utilized = "'.$utilizeddifference.'" + co_funds_utilized,
                              modified_by = "'.$this->session->userdata('uid').'"
                              WHERE
                              fundsource_id = "'.$fundlist.'"
                              ');

        $resultconso = $this->db->query('SELECT * FROM tbl_consofunds_history WHERE fundsource_id = "'.$fundlist.'" and identifier = "3"  and deleted = "0" order by consolidated_id desc limit 1');
        $resultconso_value = $resultconso->row();
        $funds_new_consofund = $resultconso_value->consolidated_new_value;
        $funds_new_consovalue = $funds_new_consofund + $utilizeddifference;

        if($resultconso->num_rows() > 0) {

            $this->db->query('insert into tbl_consofunds_history(
                          fundsource_id,consolidated_old_value,amount,consolidated_new_value,description,date_created,created_by,deleted,identifier)
                          values
                          ("'.$fundlist.'","'.$funds_new_consofund.'","'.$utilizeddifference.'","'.$funds_new_consovalue.'","UTILIZED AICS",
                          now(),"'.$this->session->userdata('uid').'",0,
                          "2")');

        }
        else
        {
            $this->db->query('insert into tbl_consofunds_history(
                          fundsource_id,consolidated_old_value,amount,consolidated_new_value,description,date_created,created_by,deleted,identifier)
                          values
                          ("'.$fundlist.'","0","'.$utilizeddifference.'","'.$utilizeddifference.'","UTILIZED AICS",
                          now(),"'.$this->session->userdata('uid').'",0,
                          "2")');
        }


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
//    public function get_saro($region)
//    {
//        $get_saro = "
//        SELECT
//          saro_id,
//          saro_number,
//          saro_balance
//        FROM
//          tbl_saro
//        WHERE
//          saro_id <> '0'
//          and deleted = 0
//          and region_code = '".$region."'
//        GROUP BY
//         saro_id
//        ORDER BY
//          saro_id
//        ";
//
//        return $this->db->query($get_saro)->result();
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
    public function get_provinces($region_code) {
        $get_prov = "
        SELECT
            id_province,
            prov_name
        FROM
          lib_province
        WHERE
          region_code = ?
        ORDER BY
          prov_name
        ";

        return $this->db->query($get_prov,$region_code)->result();
    }
    public function get_muni($id_province) {
        $get_muni = "
        SELECT
            id_municipality,
            city_name
        FROM
          lib_municipality
        WHERE
          prov_code = ?
        ORDER BY
          city_name
        ";

        return $this->db->query($get_muni,$id_province)->result();
    }
    public function get_brgy($id_municipality) {
        $get_brgy = "
        SELECT
            id_barangay,
            brgy_name
        FROM
          lib_barangay
        WHERE
          city_code = ?
        ORDER BY
          brgy_name
        ";

        return $this->db->query($get_brgy,$id_municipality)->result();
    }


}
?>