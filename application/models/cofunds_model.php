<?php
/**
 * Created by PhpStorm.
 * User: mblejano
 * Date: 4/5/2016
 * Time: 2:42 PM
 */


class cofunds_model extends CI_Model
{


    public function get_cofunds()
    {
        $sql = 'select a.*, b.fund_source from tbl_co_funds a inner join lib_fund_source b on a.fundsource_id = b.fundsource_id
                where a.deleted ="0"
               ';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function get_consofunds_history($fund_source) {
        $get_consohistory = '
        SELECT
          *
        FROM
          tbl_consofunds_history
        WHERE
          fundsource_id ="'.$fund_source.'"
          and identifier = "1"
        ORDER BY
        consolidated_id DESC
        ';

        return $this->db->query($get_consohistory)->result();
    }

    public function get_consodownloaded_history($fund_source) {
        $get_consohistory = '
        SELECT
          *
        FROM
          tbl_consofunds_history
        WHERE
          fundsource_id ="'.$fund_source.'"
          and identifier = "2"
        ORDER BY
        consolidated_id DESC
        ';

        return $this->db->query($get_consohistory)->result();
    }

    public function get_consoutilized_history($fund_source) {
        $get_consohistory = '
        SELECT
          *
        FROM
          tbl_consofunds_history
        WHERE
          fundsource_id ="'.$fund_source.'"
          and identifier = "3"
        ORDER BY
        consolidated_id DESC
        ';

        return $this->db->query($get_consohistory)->result();
    }

    public function insertFunds($fundsourcelist,$funds_amount2,$myid, $status, $funds_identifier)
    {

        $this->db->trans_begin();

        $result = $this->db->query('SELECT * FROM tbl_co_funds WHERE fundsource_id ="'.$fundsourcelist.'" ');

        if($result->num_rows() > 0) {
            $from_value = $this->db->query('SELECT * FROM tbl_consofunds_history WHERE fundsource_id ="'.$fundsourcelist.'" ORDER BY fundsource_id DESC limit 1 ');
            $from_value1 = $from_value->row();
            $conso_old_value = $from_value1->consolidated_new_value;
            $conso_new_value = $from_value1->consolidated_new_value + $funds_amount2 ;


            $this->db->query('insert into tbl_consofunds_history(
                          fundsource_id,consolidated_old_value,amount,consolidated_new_value,description,created_by,date_created,identifier)
                          values
                          ("'.$fundsourcelist.'","'.$conso_old_value.'","'.$funds_amount2.'","'.$conso_new_value.'","UPDATE FUNDS","'.$myid.'",now(),"1")');

            $this->db->query('Update tbl_co_funds set
                  co_funds = co_funds + "'.$funds_amount2.'",
                  co_funds_remaining = co_funds_remaining + "'.$funds_amount2.'",
                  date_modified = now(),
                  modified_by = "'.$myid.'"
                  WHERE fundsource_id = "'.$fundsourcelist.'" ');
        }
        else
        {
            $this->db->query('insert into tbl_co_funds(
                          fundsource_id,co_funds,co_funds_remaining,date_created,created_by,status,funds_identifier)
                          values
                          ("'.$fundsourcelist.'","'.$funds_amount2.'","'.$funds_amount2.'",now(),"'.$myid.'","'.$status.'",
                          "'.$funds_identifier.'")');

            $this->db->query('insert into tbl_consofunds_history(
                          fundsource_id,consolidated_old_value,amount,consolidated_new_value,description,created_by,date_created,identifier)
                          values
                          ("'.$fundsourcelist.'","0","'.$funds_amount2.'","'.$funds_amount2.'","ADD NEW FUNDS","'.$myid.'",now(),"1")');
        }

            $this->db->query('Update lib_fund_source set
                  identifier = 1,
                  date_modified = now(),
                  modified_by = "'.$myid.'"
                  WHERE fundsource_id = "'.$fundsourcelist.'" ');


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

    public function get_fund_source()
    {
        $sql = 'select fundsource_id,fund_source
                from lib_fund_source
                where deleted = 0
                and status = 0';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
        $this->db->close();

    }

    public function updateCofunds($cfid, $co_funds)
    {
        $this->db->trans_begin();
        $this->db->query('UPDATE tbl_co_funds SET
                              co_funds="'.$co_funds.'",
							  date_modified=now(),
							  modified_by="'.$this->session->userdata('uid').'"

                              WHERE
                              co_funds_id = "'.$cfid.'"
                              ');

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

    public function getcofundsid($aid = 0)
    {
        $query = $this->db->get_where('tbl_co_funds',array('co_funds_id'=>$aid));
        if ($query->num_rows() > 0)
        {
            return $query->row();
        }
        else
        {
            return FALSE;
        }
        $this->db->close();
    }

    public function view_consofundsbyid($fund_source = 0)
    {
        $sql = 'select fund_source from lib_fund_source
                where fundsource_id ="'.$fund_source.'"
               ';
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
        $this->db->close();
    }

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

}