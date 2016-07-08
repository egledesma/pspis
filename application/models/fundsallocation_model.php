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

    public function get_fund_sourcelist()
    {
        $sql = 'select fundsource_id,fund_source
                from lib_fund_source
                where deleted = 0
                and status = 0
                and identifier = 1';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
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
    public function insertFunds($fund_source,$regionlist,$saa,$funds_allocated2,$myid,$status,$funds_identifier)
    {
        $this->db->trans_begin();
        $this->db->query('insert into tbl_saa(
                          fundsource_id,saa_number,region_code,saa_funds,saa_balance,date_created,created_by,status,funds_identifier)
                          values
                          ("'.$fund_source.'","'.$saa.'","'.$regionlist.'","'.$funds_allocated2.'","'.$funds_allocated2.'",now(),"'.$myid.'","'.$status.'",
                          "'.$funds_identifier.'")');
        $saa_insert_id = $this->db->insert_id();


        $result = $this->db->query('SELECT * FROM tbl_funds_allocated WHERE region_code ="'.$regionlist.'" and fundsource_id ="'.$fund_source.'"');

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
//
//            $this->db->query('insert into tbl_fallocation_history(
//                          fundsource_id,region_code,allocated_old_value,allocated_amount,allocated_consolidated_new_value,description,date_created,created_by,identifier)
//                          values
//                          ("'.$fund_source.'","'.$regionlist.'","0","'.$funds_allocated2.'","'.$funds_allocated2.'","DOWNLOAD FUNDS - SAA: '.$saa.'",
//                          now(),"'.$myid.'","2")');
        }

        $result2 = $this->db->query('SELECT * FROM tbl_fallocation_history WHERE fundsource_id ="'.$fund_source.'" and region_code = "'.$regionlist.'" and identifier ="2" ');

        if($result2->num_rows() > 0) {
            $from_value2 = $this->db->query('SELECT * FROM tbl_fallocation_history WHERE fundsource_id ="'.$fund_source.'" and region_code = "'.$regionlist.'" and identifier = "2" ORDER BY fundsource_id DESC limit 1 ');
            $from_value3 = $from_value2->row();
            $allocate_old_value = $from_value3->allocated_new_value;
            $allocate_new_value = $from_value3->allocated_new_value + $funds_allocated2 ;

            $this->db->query('insert into tbl_fallocation_history(
                fundsource_id,region_code,allocated_old_value,allocated_amount,allocated_new_value,description,created_by,date_created,identifier)
                          values
                          ("'.$fund_source.'","'.$regionlist.'","'.$allocate_old_value.'","'.$funds_allocated2.'","'.$allocate_new_value.'","DOWNLOAD FUNDS - SAA: '.$saa.'","'.$myid.'",now(),"2")');

        }
        else
        {
            $this->db->query('insert into tbl_fallocation_history(
                          fundsource_id,region_code,allocated_old_value,allocated_amount,allocated_new_value,description,created_by,date_created,identifier)
                          values
                          ("'.$fund_source.'","'.$regionlist.'","0","'.$funds_allocated2.'","'.$funds_allocated2.'","DOWNLOAD FUNDS - SAA: '.$saa.'",
                          "'.$myid.'",now(),"2")');
        }

        $result3 = $this->db->query('SELECT * FROM tbl_saa_history WHERE saa_id ="'.$saa_insert_id.'" and identifier ="1"');

        if($result3->num_rows() > 0) {
            $from_value4 = $this->db->query('SELECT * FROM tbl_saa_history WHERE saa_id ="'.$saa_insert_id.'" and identifier = "1" ORDER BY saa_history_id DESC limit 1 ');
            $from_value5 = $from_value4->row();
            $saa_old_value = $from_value5->saa_new_amount;
            $saa_new_value = $from_value5->saa_new_amount + $funds_allocated2 ;

            $this->db->query('insert into tbl_saa_history(1
                saa_id,saa_old_amount,saa_amount,saa_new_amount,description,created_by,date_created,identifier)
                          values
                          ("'.$saa_insert_id.'","'.$saa_old_value.'","'.$funds_allocated2.'","'.$saa_new_value.'","DOWNLOAD FUNDS - SAA: '.$saa.'","'.$myid.'",now(),"1")');

        }
        else
        {
            $this->db->query('insert into tbl_saa_history(
                           saa_id,saa_old_amount,saa_amount,saa_new_amount,description,created_by,date_created,identifier)
                          values
                          ("'.$saa_insert_id.'","0","'.$funds_allocated2.'","'.$funds_allocated2.'","DOWNLOAD FUNDS - SAA: '.$saa.'",
                          "'.$myid.'",now(),"1")');
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

    public function get_fundsallocation_history($fund_source,$region_code) {
        $get_fundsallocationhistory = '
        SELECT
          *
        FROM
          tbl_fallocation_history
        WHERE
          fundsource_id ="'.$fund_source.'"
          and region_code = "'.$region_code.'"
          and identifier = "2"
        ORDER BY
        allocation_history_id DESC
        ';

        return $this->db->query($get_fundsallocationhistory)->result();
        $this->db->close();
    }

    public function get_fudsutilized_history($fund_source,$region_code) {
        $get_fundsallocationhistory = '
        SELECT
          *
        FROM
          tbl_fallocation_history
        WHERE
          fundsource_id ="'.$fund_source.'"
          and region_code = "'.$region_code.'"
          and identifier = "3"
        ORDER BY
        allocation_history_id DESC
        ';

        return $this->db->query($get_fundsallocationhistory)->result();
        $this->db->close();
    }

    public function get_obligated_history($fund_source,$region_code) {
        $get_obligated_history = '
        SELECT
          *
        FROM
          tbl_fallocation_history
        WHERE
          fundsource_id ="'.$fund_source.'"
          and region_code = "'.$region_code.'"
          and identifier = "4"
        ORDER BY
        allocation_history_id DESC
        ';

        return $this->db->query($get_obligated_history)->result();
        $this->db->close();
    }

    public function get_otherfunds_history($fund_source,$region_code) {
        $get_otherfundshistory = '
        SELECT
          a.*, b.region_name as from_office, c.region_name as to_office
        FROM
          tbl_withdraw a
          inner join lib_region b on a.from_office = b.region_code
          inner join lib_region c on a.to_office = c.region_code
        WHERE
          a.fundsource_id ="'.$fund_source.'"
          and a.from_office = "'.$region_code.'"
        ORDER BY
        withdraw_id DESC
        ';

        return $this->db->query($get_otherfundshistory)->result();
        $this->db->close();
    }

    public function view_fundsallocationbyid($fund_source)
    {
        $sql = 'select fund_source from lib_fund_source
                where fundsource_id ="'.$fund_source.'"
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