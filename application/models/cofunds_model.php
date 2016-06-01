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
        $sql = 'select * from tbl_co_funds
                where deleted ="0"
               ';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function insertFunds($year,$funds_amount,$myid, $status, $funds_identifier)
    {

        $this->db->trans_begin();
        $this->db->query('insert into tbl_co_funds(
                          for_year,co_funds,date_created,created_by,status,funds_identifier)
                          values
                          ("'.$year.'","'.$funds_amount.'",now(),"'.$myid.'","'.$status.'",
                          "'.$funds_identifier.'")');
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