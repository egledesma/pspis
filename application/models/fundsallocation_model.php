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
        $sql = 'select a.*, b.region_name, c.fund_source, c.fundsource_id from tbl_funds_allocated a
                INNER JOIN lib_region b on a.region_code = b.region_code
                INNER JOIN lib_fund_source c on a.fundsource_id = c.fundsource_id
                where a.deleted ="0"
               ';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
        $this->db->close();
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
        $this->db->close();

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
        $this->db->close();

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
        $this->db->close();
    }

    public function get_fund_source()
    {
        $sql = 'select fundsource_id,fund_source
                from lib_fund_source
                where deleted = 0';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
        $this->db->close();

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

    public function get_lgu_counterpart()

    {
        $sql = 'select lgucounterpart_id,lgu_counterpart
                from lib_lgu_counterpart
                where deleted = 0';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
        $this->db->close();
    }
    public function insertFunds($fund_source,$regionlist,$saa,$funds_allocated2,$myid,$funds_identifier)
    {

//        $this->db->trans_begin();
//        $this->db->query('insert into tbl_saro(
//                          for_year,saro_number,region_code,saro_funds,saro_balance,date_created,created_by,status,funds_identifier)
//                          values
//                          ("'.$year.'","'.$saro.'","'.$regionlist.'","'.$funds_allocated.'","'.$funds_allocated.'",now(),"'.$myid.'","'.$status.'",
//                          "'.$funds_identifier.'")');


        $result = $this->db->query('SELECT * FROM tbl_funds_allocated WHERE region_code ="'.$regionlist.'" ');

        if($result->num_rows() > 0) {
            $this->db->query('Update tbl_funds_allocated set
                  funds_allocated = "'.$funds_allocated2.'" + funds_allocated,
                  remaining_budget = "'.$funds_allocated2.'" + remaining_budget,
                  date_modified = now(),
                  modified_by = "'.$myid.'"
                  WHERE region_code = "'.$regionlist.'" ');
        }
        else
        {
            $this->db->query('insert into tbl_funds_allocated(
                          fundsource_id,region_code,funds_allocated,remaining_budget,date_created,created_by,funds_identifier)
                          values
                          ("'.$fund_source.'","'.$regionlist.'","'.$funds_allocated2.'","'.$funds_allocated2.'",
                          now(),"'.$myid.'","'.$funds_identifier.'")');
        }

        $this->db->query('Update tbl_co_funds set
                  co_funds_downloaded = co_funds_downloaded + "'.$funds_allocated2.'",
                  date_modified = now(),
                  modified_by = "'.$myid.'"
                  where fundsource_id = "'.$fund_source.'"');

        $result1 = $this->db->query('SELECT * FROM tbl_consofunds_history WHERE fundsource_id ="'.$fund_source.'" and identifier ="2" ');

        if($result1->num_rows() > 0) {
            $from_value = $this->db->query('SELECT * FROM tbl_consofunds_history WHERE fundsource_id ="'.$fund_source.'" and identifier = "2" ORDER BY fundsource_id DESC limit 1 ');
            $from_value1 = $from_value->row();
            $conso_old_value = $from_value1->consolidated_new_value;
            $conso_new_value = $from_value1->consolidated_new_value + $funds_allocated2 ;

            $this->db->query('insert into tbl_consofunds_history(
                          fundsource_id,consolidated_old_value,amount,consolidated_new_value,description,created_by,date_created,identifier)
                          values
                          ("'.$fund_source.'","'.$conso_old_value.'","'.$funds_allocated2.'","'.$conso_new_value.'","DOWNLOAD FUNDS - SAA: '.$saa.'","'.$myid.'",now(),"2")');
        }
        else
        {
            $this->db->query('insert into tbl_consofunds_history(
                          fundsource_id,consolidated_old_value,amount,consolidated_new_value,description,date_created,created_by,identifier)
                          values
                          ("'.$fund_source.'","0","'.$funds_allocated2.'","'.$funds_allocated2.'","DOWNLOAD FUNDS - SAA: '.$saa.'",
                          now(),"'.$myid.'","2")');
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
        $this->db->close();
    }


}