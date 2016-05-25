<?php
/**
 * Created by PhpStorm.
 * User: mblejano
 * Date: 4/5/2016
 * Time: 2:42 PM
 */


class foodforwork_model extends CI_Model
{
    public function finalize($foodforwork_id)
    {

        $sql = 'select saro_id,cost_of_assistance
                from tbl_foodforwork
                where deleted = 0 and foodforwork_id = "'.$foodforwork_id.'"';
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;

    }
    public function finalize_update($total_cost,$saro_id,$regionsaro)
    {
        $this->db->trans_begin();

        $this->db->query('UPDATE tbl_saro SET
                              saro_funds_downloaded ="'.$total_cost.'" + saro_funds_downloaded,
                              saro_funds_utilized = "'.$total_cost.'" + saro_funds_utilized
                              WHERE
                              saro_id = "'.$saro_id.'"
                              ');
        $this->db->query('UPDATE tbl_funds_allocated SET
                              funds_downloaded ="'.$total_cost.'" + funds_downloaded,
                              funds_utilized ="'.$total_cost.'" + funds_utilized
                              WHERE
                              region_code = "'.$regionsaro.'"
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

    public function get_project($region_code)
    {
        $sql = 'SELECT d.saro_number,a.foodforwork_id,a.project_title,b.region_name,c.work_nature,a.no_of_bene,a.no_of_days,a.cost_of_assistance
FROM `tbl_foodforwork` a
INNER JOIN lib_region b
on a.region_code = b.region_code
INNER JOIN lib_work_nature c
on a.nature_id = c.nature_id
inner join tbl_saro d
on d.saro_id = a.saro_id
where a.deleted = 0 and a.region_code = "'.$region_code.'"
               ';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;

    }
    public function get_bene_list($foodforwork_id)
    {
        $sql = 'select a.bene_id,a.bene_fullname from tbl_cash_bene_list a
        where a.deleted = 0 and a.foodforwork_id = "'.$foodforwork_id.'"';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;

    }
    public function get_project_title($foodforwork_id)
    {
        $sql = 'select project_title from tbl_foodforwork
                where foodforwork_id = "'.$foodforwork_id.'" ';
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;

    }
    public function get_project_byid($foodforwork_id = 0)
    {
        $query = $this->db->get_where('tbl_foodforwork',array('foodforwork_id'=>$foodforwork_id));
        if ($query->num_rows() > 0){
            return $query->row();
        } else {
            return FALSE;
        }
        $this->db->close();
    }
    public function insertProject($sarolist,$myid,$project_title,$regionlist,$provlist
        ,$munilist,$brgylist,$natureofworklist,$number_bene,$number_days,$costofassistance)
    {

        $this->db->trans_begin();
        $this->db->query('insert into tbl_foodforwork(assistance_id,saro_id,
                          project_title,region_code,prov_code,city_code,brgy_code,nature_id,no_of_bene,no_of_days,cost_of_assistance,date_created,created_by,deleted)
                          values
                          ("2","'.$sarolist.'","'.$project_title.'","'.$regionlist.'",
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
    public function deletefoodforwork($foodforwork_id = 0)
    {
        $this->db->trans_begin();

        $this->db->query('UPDATE tbl_foodforwork SET
                              deleted ="1"
                              WHERE
                              foodforwork_id = "'.$foodforwork_id.'"
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

    public function updatefoodforwork($sarolist,$foodforwork_id,$myid,$project_title,$regionlist,$provlist
        ,$munilist,$brgylist,$natureofworklist,$number_bene,$number_days,$costofassistance){

        $this->db->trans_begin();

        $this->db->query('UPDATE tbl_foodforwork
                        SET
                        saro_id = "'.$sarolist.'",
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
                        foodforwork_id = "'.$foodforwork_id.'"');

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

    public function get_saro($region)
    {
        $get_saro = "
        SELECT
          saro_id,
          saro_number
        FROM
          tbl_saro
        WHERE
          saro_id <> '0'
          and deleted = 0
          and region_code = '".$region."'
        GROUP BY
         saro_id
        ORDER BY
          saro_id
        ";

        return $this->db->query($get_saro)->result();

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
          assistance_id = 1
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