<?php
/**
 * Created by PhpStorm.
 * User: mblejano
 * Date: 4/5/2016
 * Time: 2:42 PM
 */


class withdraw_model extends CI_Model
{
    public function get_saro_amount($saro_id)
    {
        $sql = 'select saro_funds,saro_id,saro_number from tbl_saro
where saro_id = "'.$saro_id.'" and deleted = 0';
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;

        $this->db->close();
    }

    public function withdrawFunds($saro_id,$withdraw_date,$sarolist,$new_saro,$from_region,$to_region,$saro_amount,$remarks,$funds_identifier,$year)
    {

        $this->db->trans_begin();
        $this->db->query('insert into tbl_withdraw(
                          saro_id,date,old_saro_number,saro_number,from_office,to_office,amount,remarks,created_by,date_created)
                          values
                          ("'.$saro_id.'","'.$withdraw_date.'","'.$sarolist.'","'.$new_saro.'","'.$from_region.'","'.$to_region.'","'.$saro_amount.'","'.$remarks.'","'.$this->session->userdata('uid').'",now())');

        $from_value = $this->db->query('SELECT * FROM tbl_funds_allocated WHERE region_code ="'.$from_region.'" ');
        $from_value1 = $from_value->row();
        $from_old_value = $from_value1->funds_allocated;
        $from_new_value = $from_value1->funds_allocated - $saro_amount;

        $to_value = $this->db->query('SELECT * FROM tbl_funds_allocated WHERE region_code ="'.$to_region.'" ');
        $to_value1 = $to_value->row();
        $to_old_value = $to_value1->funds_allocated;
        $to_new_value = $to_value1->funds_allocated + $saro_amount;

        //insert_tbl_saro
        $this->db->query('insert into tbl_saro(
                          for_year,saro_number,region_code,saro_funds,saro_balance,remarks,date_created,created_by,status,funds_identifier)
                          values
                          ("'.$year.'","'.$new_saro.'","'.$to_region.'","'.$saro_amount.'","'.$saro_amount.'","Transferred",now(),"'.$this->session->userdata('uid').'","0",
                          "'.$funds_identifier.'")');

        //update tbl_Saro
        $this->db->query('update tbl_saro set
                          remarks = "Transferred",
                          date_modified = now(),
                          modified_by = "'.$this->session->userdata('uid').'",
                          status = 1
                          where saro_number ="'.$sarolist.'"');

        //select
        $result = $this->db->query('SELECT * FROM tbl_funds_allocated WHERE region_code ="'.$to_region.'" ');

        //tbl_funds_allocated
        if($result->num_rows() > 0) {
            $this->db->query('Update tbl_funds_allocated set
                  funds_allocated = "'.$saro_amount.'" + funds_allocated,
                  date_modified = now(),
                  modified_by = "'.$this->session->userdata('uid').'"
                  WHERE region_code = "'.$to_region.'" ');
        }
        else
        {
            $this->db->query('insert into tbl_funds_allocated(
                          for_year,region_code,funds_allocated,date_created,created_by,status,funds_identifier)
                          values
                          ("'.$year.'","'.$to_region.'","'.$saro_amount.'",
                          now(),"'.$this->session->userdata('uid').'",0,
                          "'.$funds_identifier.'")');
        }




        $this->db->query('Update tbl_funds_allocated set
                  funds_allocated = "'.$saro_amount.'" - funds_allocated,
                  date_modified = now(),
                  modified_by = "'.$this->session->userdata('uid').'"
                  WHERE region_code = "'.$from_region.'" ');






        //tbl history
        $this->db->query('insert into tbl_funds_history(
                          saro_id,from_region,to_region,transfer_amount,from_old_value,from_new_value,to_old_value,to_new_value,created_by,date_created)
                          values
                          ("'.$saro_id.'","'.$from_region.'","'.$to_region.'","'.$saro_amount.'","'.$from_old_value.'","'.$from_new_value.'","'.$to_old_value.'","'.$to_new_value.'","'.$this->session->userdata('uid').'",now()
                          )');


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


    public function withdrawFunds1($year,$regionlist,$saro,$funds_allocated,$myid,$status,$funds_identifier)
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