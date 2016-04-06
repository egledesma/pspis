<?php
/**
 * Created by PhpStorm.
 * User: mblejano
 * Date: 4/5/2016
 * Time: 2:42 PM
 */


class communities_model extends CI_Model
{


    public function get_project()
    {
        $sql = 'select a.project_title, b.assistance_name,
                c.work_nature, d.fund_source,e.lgu_counterpart,
                a.lgu_fundsource,a.lgu_amount, a.project_cost,a.project_amount,f.fund_source as "implementing_agency", a.status,a.region_code
                from tbl_projects a
                INNER JOIN lib_assistance_type b
                on a.assistance_id = b.assistance_id
                INNER JOIN lib_work_nature c
                on a.nature_id = c.nature_id
                INNER JOIN lib_fund_source d
                on a.fundsource_id = d.fundsource_id
								INNER JOIN lib_fund_source f
								on a.implementing_agency = f.fundsource_id
                INNER JOIN lib_lgu_counterpart e
                on a.lgucounterpart_id = e.lgucounterpart_id

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
            work_nature
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
    public function insertProject($project_title,$assistancelist,$natureofworklist,$fundsourcelist,$lgucounterpartlist,$lgu_fundsource,$lgu_amount,$project_cost,$project_amount,$implementing_agency,$status)
    {

        $this->db->trans_begin();
        $this->db->query('insert into tbl_projects(assistance_id,
                          project_title,nature_id,fundsource_id,project_amount,lgucounterpart_id,lgu_amount
                          ,lgu_fundsource,project_cost,implementing_agency,status,deleted)
                          values
                          ("'.$assistancelist.'","'.$project_title.'","'.$natureofworklist.'","'.$fundsourcelist.'",
                          "'.$project_amount.'","'.$lgucounterpartlist.'","'.$lgu_amount.'",
                          "'.$lgu_fundsource.'","'.$project_cost.'","'.$implementing_agency.'","'.$status.'","0")');
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
}