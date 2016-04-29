<?php
/**
 * Created by PhpStorm.
 * User: mblejano
 * Date: 4/5/2016
 * Time: 2:42 PM
 */


class cashforwork_model extends CI_Model
{


    public function get_project()
    {
        $sql = 'SELECT a.cashforwork_id,a.project_title,b.region_name,c.work_nature,a.no_of_bene,a.no_of_days,a.cost_of_assistance FROM `tbl_cashforwork` a
INNER JOIN lib_region b
on a.region_code = b.region_code
INNER JOIN lib_work_nature c
on a.nature_id = c.nature_id
where a.deleted = 0
               ';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;

    }
    public function get_bene_list($cashforwork_id)
    {
        $sql = 'select a.bene_id,a.bene_fullname from tbl_cash_bene_list a
        where a.deleted = 0 and a.cashforwork_id = "'.$cashforwork_id.'"';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;

    }
    public function get_project_title($cashforwork_id)
    {
        $sql = 'select project_title from tbl_cashforwork
                where cashforwork_id = "'.$cashforwork_id.'" ';
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;

    }
    public function get_project_byid($cashforwork_id = 0)
    {
        $query = $this->db->get_where('tbl_cashforwork',array('cashforwork_id'=>$cashforwork_id));
        if ($query->num_rows() > 0){
            return $query->row();
        } else {
            return FALSE;
        }
        $this->db->close();
    }
    public function insertProject($myid,$project_title,$regionlist,$provlist
        ,$munilist,$brgylist,$natureofworklist,$number_bene,$number_days,$costofassistance)
    {

        $this->db->trans_begin();
        $this->db->query('insert into tbl_cashforwork(assistance_id,
                          project_title,region_code,prov_code,city_code,brgy_code,nature_id,no_of_bene,no_of_days,cost_of_assistance,date_created,created_by,deleted)
                          values
                          ("2","'.$project_title.'","'.$regionlist.'",
                          "'.$provlist.'","'.$munilist.'","'.$brgylist.'","'.$natureofworklist.'",
                          "'.$number_bene.'","'.$number_days.'",
                          "'.$costofassistance.'",now(),"'.$myid.'","0")');

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
    public function deleteCashforwork($cashforwork_id = 0)
    {
        $this->db->trans_begin();

        $this->db->query('UPDATE tbl_cashforwork SET
                              deleted ="1"
                              WHERE
                              cashforwork_id = "'.$cashforwork_id.'"
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

    public function updateCashforwork($cashforwork_id,$myid,$project_title,$regionlist,$provlist
        ,$munilist,$brgylist,$natureofworklist,$number_bene,$number_days,$costofassistance){

        $this->db->trans_begin();

        $this->db->query('UPDATE tbl_cashforwork
                        SET
                        project_title = "'.$project_title.'",
                        region_code = "'.$regionlist.'",
                        prov_code = "'.$provlist.'",
                        city_code = "'.$munilist.'",
                        brgy_code = "'.$brgylist.'",
                        no_of_bene = "'.$number_bene.'",
                        no_of_days = "'.$number_days.'",
                        nature_id = "'.$natureofworklist.'",
                        cost_of_assistance = "'.$costofassistance.'",
                        modified_by = "'.$myid.'",
                        date_modified = now()
                        WHERE
                        cashforwork_id = "'.$cashforwork_id.'"');

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
    public function get_work_nature()
    {

        $get_work_nature = "
        SELECT
            nature_id,
            work_nature
        FROM
          lib_work_nature
        WHERE
          assistance_id = 2
        and deleted = 0
        ORDER BY
          work_nature
        ";

        return $this->db->query($get_work_nature)->result();

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