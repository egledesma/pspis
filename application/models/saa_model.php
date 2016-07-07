<?php
/**
 * Created by PhpStorm.
 * User: mblejano
 * Date: 4/5/2016
 * Time: 2:42 PM
 */


class saa_model extends CI_Model
{


    public function get_saa_region($region_code)
    {
        $sql = 'select * from tbl_saa
                where region_code ="'.$region_code.'"
               ';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
        $this->db->close();
    }

    public function get_saa_byregion($fund_source, $region_code)
    {
        $sql = 'select * from tbl_saa
                where region_code ="'.$region_code.'" and fundsource_id ="'.$fund_source.'"
                and status = 0
               ';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
        $this->db->close();
    }

    public function view_saaallocationbyid($saa_id)
    {
        $sql = 'select saa_id, saa_number from tbl_saa
                where saa_id ="'.$saa_id.'"
               ';
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
        $this->db->close();
    }

    public function view_regionbyid($region_code)
    {
        $sql = 'select region_name from lib_region
                where region_code ="'.$region_code.'"
               ';
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
        $this->db->close();
    }

    public function get_saaallocation_history($saa_id) {
        $get_saaallocationhistory = '
        SELECT
          *
        FROM
          tbl_saa_history
        WHERE
          saa_id ="'.$saa_id.'"
          and identifier = "1"
        ORDER BY
        saa_history_id DESC
        ';

        return $this->db->query($get_saaallocationhistory)->result();
        $this->db->close();
    }

    public function get_saadownloaded_history($saa_id) {
        $get_saadownloaded_history = '
        SELECT
          *
        FROM
          tbl_saa_history
        WHERE
          saa_id ="'.$saa_id.'"
          and identifier = "2"
        ORDER BY
        saa_history_id DESC
        ';

        return $this->db->query($get_saadownloaded_history)->result();
        $this->db->close();
    }

    public function get_saautilized_history($saa_id) {
        $get_saautilizedshistory = '
        SELECT
          *
        FROM
          tbl_saa_history
        WHERE
          saa_id ="'.$saa_id.'"
          and identifier = "3"
        ORDER BY
        saa_history_id DESC
        ';

        return $this->db->query($get_saautilizedshistory)->result();
        $this->db->close();
    }

    public function get_saro_history($saro_id) {
        $get_sarohistory = '
        SELECT
          *
        FROM
          tbl_funds_history
        WHERE
          saro_id ="'.$saro_id.'"
        ';

        return $this->db->query($get_sarohistory)->result();
        $this->db->close();
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

        return $this->db->query($get_regions1)->result();
        $this->db->close();
    }

    public function get_to_region($region_code) {
        $get_regions1 = '
        SELECT
          region_code,
          region_name
        FROM
          lib_region
        WHERE
          region_code !="'.$region_code.'"
        ';

        return $this->db->query($get_regions1)->result();
        $this->db->close();
    }


    public function insertFunds1($year,$regionlist,$saro,$funds_allocated,$myid,$status,$funds_identifier)
    {

        $this->db->trans_begin();
        $this->db->query('insert into tbl_saro(
                          for_year,saro_number,region_code,saro_funds,saro_balance,date_created,created_by,status,funds_identifier)
                          values
                          ("'.$year.'","'.$saro.'","'.$regionlist.'","'.$funds_allocated.'","'.$funds_allocated.'",now(),"'.$myid.'","'.$status.'",
                          "'.$funds_identifier.'")');


        $result = $this->db->query('SELECT * FROM tbl_funds_allocated WHERE region_code ="'.$regionlist.'" ');

        if($result->num_rows() > 0) {
            $this->db->query('Update tbl_funds_allocated set
                  funds_allocated = "'.$funds_allocated.'" + funds_allocated,
                  date_modified = now(),
                  modified_by = "'.$myid.'"
                  WHERE region_code = "'.$regionlist.'" ');
        }
        else
        {
            $this->db->query('insert into tbl_funds_allocated(
                          for_year,region_code,funds_allocated,date_created,created_by,status,funds_identifier)
                          values
                          ("'.$year.'","'.$regionlist.'","'.$funds_allocated.'",
                          now(),"'.$myid.'","'.$status.'",
                          "'.$funds_identifier.'")');
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
    public function deleteProject($project_id = 0)
    {
        $this->db->trans_begin();

        $this->db->query('UPDATE tbl_projects SET
                              deleted ="1"
                              WHERE
                              project_id = "'.$project_id.'"
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
    public function get_project_byid($project_id = 0)
    {
        $query = $this->db->get_where('tbl_projects',array('project_id'=>$project_id));
        if ($query->num_rows() > 0){
            return $query->row();
        } else {
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