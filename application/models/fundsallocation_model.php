<?php
/**
 * Created by PhpStorm.
 * User: mblejano
 * Date: 4/5/2016
 * Time: 2:42 PM
 */


class fundsallocation_model extends CI_Model
{


    public function get_funds()
    {
        $sql = 'select a.*, b.region_name from tbl_funds_allocated a
                INNER JOIN lib_region b
                on a.region_code = b.region_code
                where a.deleted ="0"
               ';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function get_lib_assistance()
    {
        $get_lib_assistance = "
        SELECT
          assistance_id,
          assistance_name
        FROM
          lib_assistance_type
        WHERE
          assistance_id <> '0'
          and deleted = 0
        ORDER BY
          assistance_id
        ";

        return $this->db->query($get_lib_assistance)->result();

    }
    public function get_work_nature($assistance_id)
    {

        $get_work_nature = "
        SELECT
            nature_id,
            work_nature,
            maximum_amount,
            minimum_amount

        FROM
          lib_work_nature
        WHERE
          assistance_id = ?
        and deleted = 0
        ORDER BY
          work_nature
        ";

        return $this->db->query($get_work_nature,$assistance_id)->result();

    }
    public function get_naturemaxmin($nature_id) {
        $get_work_naturemaxmin = "
        SELECT
            maximum_amount,
            minimum_amount
        FROM
          lib_work_nature
        WHERE
          nature_id = ?
        and deleted = 0
        ORDER BY
          work_nature
        ";

        return $this->db->query($get_work_naturemaxmin,$nature_id)->row();
    }
    public function get_fund_source()
    {
        $sql = 'select fundsource_id,fund_source
                from lib_fund_source
                where deleted = 0';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;

    } public function get_lgu_counterpart()
    {
        $sql = 'select lgucounterpart_id,lgu_counterpart
                from lib_lgu_counterpart
                where deleted = 0';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;

    }
    public function insertFunds($year,$regionlist,$saro,$funds_allocated,$myid,$status,$funds_identifier)
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
        $this->db->query('Update tbl_co_funds set
                  co_funds_downloaded = "'.$funds_allocated.'",
                  date_modified = now(),
                  modified_by = "'.$myid.'" ');




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
    public function updateProject($project_id,$project_title,$regionlist,$provlist,$munilist,$brgylist,$number_bene,$assistancelist,$natureofworklist,$fundsourcelist
        ,$lgucounterpartlist,$lgu_fundsource,$lgu_amount,$project_cost,$project_amount,$implementing_agency,$status){

        $this->db->trans_begin();

        $this->db->query('UPDATE tbl_projects
                        SET
                        project_title = "'.$project_title.'",
                        region_code = "'.$regionlist.'",
                        prov_code = "'.$provlist.'",
                        city_code = "'.$munilist.'",
                        brgy_code = "'.$brgylist.'",
                        no_of_bene = "'.$number_bene.'",
                        assistance_id = "'.$assistancelist.'",
                        nature_id = "'.$natureofworklist.'",
                        fundsource_id = "'.$fundsourcelist.'",
                        lgucounterpart_id = "'.$lgucounterpartlist.'",
                        lgu_fundsource = "'.$lgu_fundsource.'",
                        lgu_amount = "'.$lgu_amount.'",
                        project_cost = "'.$project_cost.'",
                        project_amount = "'.$project_amount.'",
                        implementing_agency = "'.$implementing_agency.'",
                        `status` = "'.$status.'"
                        WHERE
                        project_id = "'.$project_id.'"');

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