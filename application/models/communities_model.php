<?php
/**
 * Created by PhpStorm.
 * User: mblejano
 * Date: 4/5/2016
 * Time: 2:42 PM
 */


class communities_model extends CI_Model
{


    public function get_project($region_code)
    {
        $sql = 'select a.project_id,a.project_title, b.assistance_name,
                c.work_nature, d.fund_source,a.lgucounterpart_prov,
                a.lgu_fundsource,a.lgu_amount_prov, a.project_cost,a.project_amount,f.fund_source as "implementing_agency", a.status, g.region_name
                from tbl_projects a
                INNER JOIN lib_assistance_type b
                on a.assistance_id = b.assistance_id
                INNER JOIN lib_work_nature c
                on a.nature_id = c.nature_id
                INNER JOIN lib_fund_source d
                on a.fundsource_id = d.fundsource_id
				INNER JOIN lib_fund_source f
				on a.implementing_agency = f.fundsource_id

                INNER JOIN lib_region g
                on a.region_code = g.region_code

                where a.deleted ="0" and a.region_code = "'.$region_code.'"
               ';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
        $this->db->close();
    } //updated


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

    public function view_projectbyid($project_id = 0)
    {
        $sql = 'select a.project_id,a.saa_number,a.project_title, a.region_code, b.assistance_name,
                c.work_nature, d.fund_source,a.lgucounterpart_prov, h.prov_name, i.city_name, j.brgy_name, k.status_name, l.agency_name, a.no_of_bene,
                a.lgu_fundsource, sum(a.lgu_amount_prov + a.lgu_amount_muni + a.lgu_amount_brgy) as lgu_amount, a.project_cost,a.project_amount, f.fund_source as "implementing_agency", a.status, g.region_name, m.*
                from tbl_projects a
                INNER JOIN lib_assistance_type b
                on a.assistance_id = b.assistance_id
                INNER JOIN lib_work_nature c
                on a.nature_id = c.nature_id
                INNER JOIN lib_fund_source d
                on a.fundsource_id = d.fundsource_id
				INNER JOIN lib_fund_source f
				on a.implementing_agency = f.fundsource_id
                INNER JOIN lib_region g
                on a.region_code = g.region_code
                INNER JOIN lib_provinces h
                on a.prov_code = h.prov_code
                INNER JOIN lib_municipality i
                on a.city_code = i.city_code
                INNER JOIN lib_brgy j
                on a.brgy_code = j.brgy_code
                INNER JOIN lib_status k
                on a.status = k.status_id
                INNER JOIN lib_implementing_agency l
                on a.implementing_agency = l.agency_id
                INNER JOIN tbl_project_implementation m
                on a.project_id = m.project_id
                where a.deleted ="0"
                and a.project_id ="'.$project_id.'"
               ';
        $query = $this->db->query($sql);
        $result = $query->row();
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
          assistance_id in (3,4)
          and deleted = 0
        ORDER BY
          assistance_id
        ";

        return $this->db->query($get_lib_assistance)->result();
        $this->db->close();

    }

    public function get_project_status()
    {
        $get_project_status = "
        SELECT
          status_id,
          status_name
        FROM
          lib_status
        WHERE
          status_id <> '0'
          and deleted = 0
        ORDER BY
          status_id
        ";

        return $this->db->query($get_project_status)->result();
        $this->db->close();

    }

    public function get_saa($region)
    {
        $get_saa = "
        SELECT
          saa_id,
          saa_number,
          saa_balance
        FROM
          tbl_saa
        WHERE
          saa_id <> '0'
          and deleted = 0
          and saa_balance != '0'
          and region_code = '".$region."'
          and status = 0
        GROUP BY
         saa_id
        ORDER BY
          saa_id
        ";

        return $this->db->query($get_saa)->result();
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

    public function get_saa_list($fundsource_id, $regionsaa)
    {

        $get_saa_list= "
        SELECT
            saa_id,
            saa_number,
            saa_balance,
            saa_funds

        FROM
          tbl_saa
        WHERE
          fundsource_id = ?
        and region_code = ?
        and deleted = 0
        ORDER BY
          work_nature
        ";

        return $this->db->query($get_saa_list,$fundsource_id,$regionsaa)->result();
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

    public function get_fund_sourcelist($regionsaa)
    {
        $sql = 'select t1.fundsource_id,t1.fund_source
                from lib_fund_source t1 inner join tbl_saa t2 on t1.fundsource_id = t2.fundsource_id
                where t1.deleted = 0
                and t2.region_code = "'.$regionsaa.'"
                and t1.status = 0
                and t1.identifier = 1
                group by t1.fundsource_id';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
        $this->db->close();

    }

    public function get_implementing_agency()
    {
        $sql = 'select agency_id,agency_name
                from lib_implementing_agency
                where deleted = 0';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
        $this->db->close();

    }

    public function get_saa_region($fundsource_id,$regionsaa)
    {
        $sql = 'SELECT saa_id,saa_number,saa_balance
FROM `tbl_saa`
where deleted = 0 and saa_balance != "0" and fundsource_id = "'.$fundsource_id.'"
        and region_code ="'.$regionsaa.'"';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;

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

    public function get_balance($saro_number)
    {
        $sql = 'select saro_id, saro_balance
                from tbl_saro
                where saro_number = "'.$saro_number.'"';
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
        $this->db->close();

    }

    public function insertProject($myid,$saa_number,$project_title,$regionlist,$provlist,$munilist,$brgylist,$number_bene,$assistancelist,$natureofworklist,$fundsourcelist,$project_amount,
                                  $lgucounterpart_prov,$lgu_amount_prov,$lgu_remarks_prov,$lgucounterpart_muni,$lgu_amount_muni,$lgu_remarks_muni,$lgucounterpart_brgy,
                                  $lgu_amount_brgy,$lgu_remarks_brgy,$project_cost,$project_amount,$implementing_agency,$start_date,$target_date,$status,$first_tranche,$second_tranche,$third_tranche)
    {

        $this->db->trans_begin();
        $this->db->query('insert into tbl_projects(saa_number,assistance_id,project_title,region_code,prov_code,city_code,brgy_code
                          ,no_of_bene,nature_id,fundsource_id
                          ,project_amount,lgucounterpart_prov,lgu_amount_prov,lgu_remarks_prov
                          ,lgucounterpart_muni,lgu_amount_muni,lgu_remarks_muni,lgucounterpart_brgy,lgu_amount_brgy,lgu_remarks_brgy
                          ,project_cost,implementing_agency,created_by,date_created,status,deleted)
                          values
                          ("'.$saa_number.'","'.$assistancelist.'","'.$project_title.'","'.$regionlist.'","'.$provlist.'","'.$munilist.'","'.$brgylist.'",
                          "'.$number_bene.'","'.$natureofworklist.'","'.$fundsourcelist.'",
                          "'.$project_amount.'","'.$lgucounterpart_prov.'","'.$lgu_amount_prov.'","'.$lgu_remarks_prov.'",
                          "'.$lgucounterpart_muni.'","'.$lgu_amount_muni.'","'.$lgu_remarks_muni.'","'.$lgucounterpart_brgy.'","'.$lgu_amount_brgy.'","'.$lgu_remarks_brgy.'",
                          "'.$project_cost.'","'.$implementing_agency.'","'.$myid.'",now(),"'.$status.'","0")');


        //TBL_IMPLEMENTATION
        $insert_id = $this->db->insert_id();
        $this->db->query('INSERT INTO tbl_project_implementation(project_id,start_date,target_date,project_status,date_created,created_by, deleted)
                          VALUES
                          (
                          "'.$insert_id.'",
                          "'.$start_date.'",
                          "'.$target_date.'",
                          "'.$status.'",
						  now(),
						  "'.$this->session->userdata('uid').'",
						  0
                          )');

        //TBL_PROJECT_BUDGET
        $this->db->query('INSERT INTO tbl_project_budget(project_id,region_code,saa_number,first_tranche,first_tranche_status,second_tranche,third_tranche,date_created,created_by, deleted)
                          VALUES
                          (
                          "'.$insert_id.'",
                          "'.$regionlist.'",
                          "'.$saa_number.'",
                          "'.$first_tranche.'",
                          0,
                          "'.$second_tranche.'",
                          "'.$third_tranche.'",
						  now(),
						  "'.$this->session->userdata('uid').'",
						  0
                          )');

        //TBL_SAA
        $this->db->query('UPDATE tbl_saa set saa_funds_downloaded = saa_funds_downloaded + "'.$project_amount.'", saa_balance = saa_balance - "'.$project_amount.'", date_modified = now(), modified_by = "'.$myid.'"
        where saa_number ="'.$saa_number.'"');

        //TBL_SAA_HISTORY
        $saa_id_query = $this->db->query('SELECT saa_id FROM tbl_saa where saa_number ="'.$saa_number.'"');
        $saa_id = $saa_id_query->row();
        $saa_id_number = $saa_id->saa_id;
        $result = $this->db->query('SELECT * FROM tbl_saa_history WHERE saa_id ="'.$saa_id_number.'" and identifier ="2" ');

        if($result->num_rows() > 0) {
            $from_value = $this->db->query('SELECT * FROM tbl_saa_history WHERE saa_id ="'.$saa_id_number.'" and identifier ="2" order by saa_history_id desc limit 1');
            $from_value1 = $from_value->row();
            $saa_old_value = $from_value1->saa_new_amount;
            $saa_new_value = $from_value1->saa_new_amount + $project_amount;

            $this->db->query('insert into tbl_saa_history(
                saa_id,saa_old_amount,saa_amount,saa_new_amount,description,created_by,date_created,identifier)
                          values
                          ("'.$saa_id_number.'","'.$saa_old_value.'","'.$project_amount.'","'.$saa_new_value.'","FUNDED PROJECT : '.$project_title.'","'.$this->session->userdata('uid').'",now(),"2")');
        }
        else
        {
            $this->db->query('insert into tbl_saa_history(
                          saa_id,saa_old_amount,saa_amount,saa_new_amount,description,created_by,date_created,identifier)
                          values
                          ("'.$saa_id_number.'","0","'.$project_amount.'","'.$project_amount.'","FUNDED PROJECT : '.$project_title.'",
                          "'.$this->session->userdata('uid').'",now(),"2")');
        }

        //TBL_FUNDS_ALLOCATION
        $this->db->query('UPDATE tbl_funds_allocated set funds_obligated = funds_obligated + "'.$project_amount.'", remaining_budget = remaining_budget - "'.$project_amount.'", date_modified = now(), modified_by = "'.$myid.'"
        where region_code ="'.$regionlist.'" and fundsource_id = "'.$fundsourcelist.'"');

        //TBL_ALLOCATION_HISTORY
        $result = $this->db->query('SELECT * FROM tbl_fallocation_history WHERE fundsource_id ="'.$fundsourcelist.'" and region_code = "'.$regionlist.'" and identifier ="4" ');

        if($result->num_rows() > 0) {
            $from_value2 = $this->db->query('SELECT * FROM tbl_fallocation_history WHERE fundsource_id ="'.$fundsourcelist.'" and region_code = "'.$regionlist.'" and identifier ="4" order by allocation_history_id desc limit 1');
            $from_value3 = $from_value2->row();
            $fallocation_old_value = $from_value3->allocated_new_value;
            $fallocation_new_value = $from_value3->allocated_new_value + $project_amount;

            $this->db->query('insert into tbl_fallocation_history(
                fundsource_id,region_code,allocated_old_value,allocated_amount,allocated_new_value,description,created_by,date_created,identifier)
                          values
                          ("'.$fundsourcelist.'","'.$regionlist.'","'.$fallocation_old_value.'","'.$project_amount.'","'.$fallocation_new_value.'","FUNDED PROJECT : '.$project_title.'","'.$this->session->userdata('uid').'",now(),"4")');
        }
        else
        {
            $this->db->query('insert into tbl_fallocation_history(
                          fundsource_id,region_code,allocated_old_value,allocated_amount,allocated_new_value,description,created_by,date_created,identifier)
                          values
                          ("'.$fundsourcelist.'","'.$regionlist.'","0","'.$project_amount.'","'.$project_amount.'","FUNDED PROJECT : '.$project_title.'",
                          "'.$this->session->userdata('uid').'",now(),"4")');
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


    public function get_province_name($province_code) {
        $get_prov_name = "
        SELECT
            prov_code,
            prov_name
        FROM
          lib_provinces
       WHERE
          prov_code = ?
        ";

        return $this->db->query($get_prov_name,$province_code)->row();
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
    public function get_muni_name($city_code) {
        $get_cities_name = "
        SELECT
            city_code,
            city_name
        FROM
          lib_municipality
        WHERE
          city_code = ?
        ";

        return $this->db->query($get_cities_name,$city_code)->row();
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
    public function get_brgy_name($brgy_code) {
        $get_brgy_name = "
        SELECT
            brgy_code,
            brgy_name
        FROM
          lib_brgy
        WHERE
          brgy_code = ?
        ";

        return $this->db->query($get_brgy_name,$brgy_code)->row();
    }

//    public function get_saa_balance($saa_id) {
//        $get_saa_balance = "
//        SELECT
//            saa_funds,
//            saa_id,
//            saa_number,
//            saa_balance
//        FROM
//          tbl_saa1
//        WHERE
//          saa_id = ?
//          and deleted = 0
//        ";
//
//        return $this->db->query($get_saa_balance,$saa_id)->row();
//    }
    public function get_saa_balance($saa_id)
    {
//        echo "test";
        $sql = 'select saa_funds,saa_id,saa_number,saa_balance from tbl_saa
where saa_number = "'.$saa_id.'" and deleted = 0';
        $query = $this->db->query($sql);
        $result = $query->row();
        $this->db->close();
        return $result;


    }

    public function updateFirstTranche($myid,$remarks,$budget_id,$start_date)
    {
        $this->db->trans_begin();
        $this->db->query('UPDATE tbl_project_budget SET
                              first_tranche_remarks ="'.$remarks.'",
                              first_tranche_date ="'.$start_date.'",
                              first_tranche_status= 1,
							  date_modified=now(),
							  modified_by="'.$myid.'"
                              WHERE
                              budget_id = "'.$budget_id.'"
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
    public function updateLiquidateTranche($project_title,$region_code,$first_liquidate,$fund_source,$saa_number,$myid,$remarks,$budget_id,$start_date)
    {
        $date = date('Y');
        $this->db->trans_begin();
        $this->db->query('UPDATE tbl_project_budget SET
                              first_liquidate ="'.$first_liquidate.'",
                              first_liquidate_remarks ="'.$remarks.'",
                              first_liquidate_date ="'.$start_date.'",
                              first_liquidate_status= 1,
							  date_modified=now(),
							  modified_by="'.$myid.'"
                              WHERE
                              budget_id = "'.$budget_id.'"
                              ');
        $this->db->query('UPDATE tbl_saa SET
                              saa_funds_utilized = saa_funds_utilized + "'.$first_liquidate.'",
							  date_modified=now(),
							  modified_by="'.$myid.'"
                              WHERE
                              saa_number = "'.$saa_number.'"');
        //TBL_SAA_HISTORY
        $saa_id_query = $this->db->query('SELECT saa_id FROM tbl_saa where saa_number ="'.$saa_number.'"');
        $saa_id = $saa_id_query->row();
        $saa_id_number = $saa_id->saa_id;
        $result = $this->db->query('SELECT * FROM tbl_saa_history WHERE saa_id ="'.$saa_id_number.'" and identifier ="3" ');

        if($result->num_rows() > 0) {
            $from_value = $this->db->query('SELECT * FROM tbl_saa_history1 WHERE saa_id ="'.$saa_id_number.'" and identifier ="3" ORDER BY saa_history_id DESC limit 1  ');
            $from_value1 = $from_value->row();
            $saa_old_value = $from_value1->saa_new_amount;
            $saa_new_value = $from_value1->saa_new_amount + $first_liquidate;

            $this->db->query('insert into tbl_saa_history(
                saa_id,saa_old_amount,saa_amount,saa_new_amount,description,date_created,created_by,identifier)
                          values
                          ("'.$saa_id_number.'","'.$saa_old_value.'","'.$first_liquidate.'","'.$saa_new_value.'","LIQUIDATE FIRST TRANCHE, PROJECT : '.$project_title.'",now(),"'.$this->session->userdata('uid').'","3")');
        }
        else
        {
            $this->db->query('insert into tbl_saa_history(
                          saa_id,saa_old_amount,saa_amount,saa_new_amount,description,date_created,created_by,identifier)
                          values
                          ("'.$saa_id_number.'","0","'.$first_liquidate.'","'.$first_liquidate.'","LIQUIDATE FIRST TRANCHE, PROJECT : '.$project_title.'",
                          "'.$this->session->userdata('uid').'",now(),"3")');
        }
        $fundsource_id_query = $this->db->query('SELECT fundsource_id FROM lib_fund_source where fund_source ="'.$fund_source.'"');
        $fundsource_id = $fundsource_id_query->row();
        $fund_source_id = $fundsource_id->fundsource_id;
        $this->db->query('UPDATE tbl_co_funds SET
                              co_funds_utilized = co_funds_utilized + "'.$first_liquidate.'",
							  date_modified=now(),
							  modified_by="'.$myid.'"
                              WHERE
                              fundsource_id ="'.$fund_source_id.'"
                              ');
        $result = $this->db->query('SELECT * FROM tbl_consofunds_history WHERE fundsource_id ="'.$fund_source_id.'" and identifier ="3" ');

        if($result->num_rows() > 0) {
            $from_value2 = $this->db->query('SELECT * FROM tbl_consofunds_history WHERE fundsource_id ="'.$fund_source_id.'" and identifier ="3" ORDER BY consolidated_id DESC limit 1 ');
            $from_value3 = $from_value2->row();
            $conso_old_value = $from_value3->consolidated_new_value;
            $conso_new_value = $from_value3->consolidated_new_value + $first_liquidate;

            $this->db->query('insert into tbl_consofunds_history(
                fundsource_id,consolidated_old_value,amount,consolidated_new_value,description,created_by,date_created,identifier)
                          values
                          ("'.$fund_source_id.'","'.$conso_old_value.'","'.$first_liquidate.'","'.$conso_new_value.'","LIQUIDATE FIRST TRANCHE, PROJECT : '.$project_title.'","'.$this->session->userdata('uid').'",now(),"3")');
        }
        else
        {
            $this->db->query('insert into tbl_consofunds_history(
                          fundsource_id,consolidated_old_value,amount,consolidated_new_value,description,created_by,date_created,identifier)
                          values
                          ("'.$fund_source_id.'","0","'.$first_liquidate.'","'.$first_liquidate.'","LIQUIDATE FIRST TRANCHE, PROJECT  '.$project_title.'",
                          "'.$this->session->userdata('uid').'",now(),"3")');
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
    public function updateSecondTranche($myid,$remarks,$budget_id,$start_date)
    {
        $this->db->trans_begin();
        $this->db->query('UPDATE tbl_project_budget SET
                              second_tranche_remarks ="'.$remarks.'",
                              second_tranche_date ="'.$start_date.'",
                              second_tranche_status= 1,
							  date_modified=now(),
							  modified_by="'.$myid.'"
                              WHERE
                              budget_id = "'.$budget_id.'"
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
    public function updateThirdTranche($myid,$remarks,$budget_id,$start_date)
    {
        $this->db->trans_begin();
        $this->db->query('UPDATE tbl_project_budget SET
                              third_tranche_remarks ="'.$remarks.'",
                              third_tranche_date ="'.$start_date.'",
                              third_tranche_status= 1,
							  date_modified=now(),
							  modified_by="'.$myid.'"
                              WHERE
                              budget_id = "'.$budget_id.'"
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
    public function updateSecondLiquidateTranche($project_title,$region_code,$second_liquidate,$fund_source,$saa_number,$myid,$remarks,$budget_id,$start_date)
    {
        $date = date('Y');
        $this->db->trans_begin();
        $this->db->query('UPDATE tbl_project_budget SET
                              second_liquidate ="'.$second_liquidate.'",
                              second_liquidate_remarks ="'.$remarks.'",
                              second_liquidate_date ="'.$start_date.'",
                              second_liquidate_status= 1,
							  date_modified=now(),
							  modified_by="'.$myid.'"
                              WHERE
                              budget_id = "'.$budget_id.'"
                              ');
        $this->db->query('UPDATE tbl_saa SET
                              saa_funds_utilized = saa_funds_utilized + "'.$second_liquidate.'",
							  date_modified=now(),
							  modified_by="'.$myid.'"
                              WHERE
                              saa_number = "'.$saa_number.'"');
        //TBL_SAA_HISTORY
        $saa_id_query = $this->db->query('SELECT saa_id FROM tbl_saa where saa_number ="'.$saa_number.'"');
        $saa_id = $saa_id_query->row();
        $saa_id_number = $saa_id->saa_id;
        $from_value = $this->db->query('SELECT * FROM tbl_saa_history WHERE saa_id ="'.$saa_id_number.'" and identifier ="3" ORDER BY saa_history_id DESC limit 1 ');
        $from_value1 = $from_value->row();
        $saa_old_value = $from_value1->saa_new_amount;
        $saa_new_value = $from_value1->saa_new_amount + $second_liquidate;
        $this->db->query('insert into tbl_saa_history(
                saa_id,saa_old_amount,saa_amount,saa_new_amount,description,date_created,created_by,identifier)
                          values
                          ("'.$saa_id_number.'","'.$saa_old_value.'","'.$second_liquidate.'","'.$saa_new_value.'","LIQUIDATE SECOND TRANCHE, PROJECT : '.$project_title.'",now(),"'.$this->session->userdata('uid').'","3")');

        $fundsource_id_query = $this->db->query('SELECT fundsource_id FROM lib_fund_source where fund_source ="'.$fund_source.'"');
        $fundsource_id = $fundsource_id_query->row();
        $fund_source_id = $fundsource_id->fundsource_id;
        $this->db->query('UPDATE tbl_co_funds SET
                              co_funds_utilized = co_funds_utilized + "'.$second_liquidate.'",
							  date_modified=now(),
							  modified_by="'.$myid.'"
                              WHERE
                              fundsource_id ="'.$fund_source_id.'"
                              ');
        $from_value2 = $this->db->query('SELECT * FROM tbl_consofunds_history WHERE fundsource_id ="'.$fund_source_id.'" and identifier ="3" ORDER BY consolidated_id DESC limit 1  ');
        $from_value3 = $from_value2->row();
        $conso_old_value = $from_value3->consolidated_new_value;
        $conso_new_value = $from_value3->consolidated_new_value + $second_liquidate;

            $this->db->query('insert into tbl_consofunds_history(
                fundsource_id,consolidated_old_value,amount,consolidated_new_value,description,created_by,date_created,identifier)
                          values
                          ("'.$fund_source_id.'","'.$conso_old_value.'","'.$second_liquidate.'","'.$conso_new_value.'","LIQUIDATE SECOND TRANCHE, PROJECT : '.$project_title.'","'.$this->session->userdata('uid').'",now(),"3")');


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
    public function updateThirdLiquidateTranche($third_liquidate,$project_title,$region_code,$fund_source,$saa_number,$myid,$remarks,$budget_id,$start_date,$project_idpass)
    {
        $this->db->trans_begin();
        $date = date('Y');
        $this->db->query('UPDATE tbl_project_budget SET
                              third_liquidate ="'.$third_liquidate.'",
                              third_liquidate_remarks ="'.$remarks.'",
                              third_liquidate_date ="'.$start_date.'",
                              third_liquidate_status= 1,
							  date_modified=now(),
							  modified_by="'.$myid.'"
                              WHERE
                              budget_id = "'.$budget_id.'"
                              ');
        $this->db->query('UPDATE tbl_saa SET
                              saa_funds_utilized = saa_funds_utilized + "'.$third_liquidate.'",
							  date_modified=now(),
							  modified_by="'.$myid.'"
                              WHERE
                              saa_number = "'.$saa_number.'"
                              ');
        //TBL_SAA_HISTORY
        $saa_id_query = $this->db->query('SELECT saa_id FROM tbl_saa where saa_number ="'.$saa_number.'"');
        $saa_id = $saa_id_query->row();
        $saa_id_number = $saa_id->saa_id;

        $from_value = $this->db->query('SELECT * FROM tbl_saa_history WHERE saa_id ="'.$saa_id_number.'" and identifier ="3" ORDER BY saa_history_id DESC limit 1 ');
        $from_value1 = $from_value->row();
        $saa_old_value = $from_value1->saa_new_amount;
        $saa_new_value = $from_value1->saa_new_amount + $third_liquidate;
        $this->db->query('insert into tbl_saa_history(
                saa_id,saa_old_amount,saa_amount,saa_new_amount,description,date_created,created_by,identifier)
                          values
                          ("'.$saa_id_number.'","'.$saa_old_value.'","'.$third_liquidate.'","'.$saa_new_value.'","LIQUIDATE THIRD TRANCHE, PROJECT : '.$project_title.'",now(),"'.$this->session->userdata('uid').'","3")');

        $fundsource_id_query = $this->db->query('SELECT fundsource_id FROM lib_fund_source where fund_source ="'.$fund_source.'"');
        $fundsource_id = $fundsource_id_query->row();
        $fund_source_id = $fundsource_id->fundsource_id;
        $this->db->query('UPDATE tbl_co_funds SET
                              co_funds_utilized = co_funds_utilized + "'.$third_liquidate.'",
							  date_modified=now(),
							  modified_by="'.$myid.'"
                              WHERE
                              fundsource_id ="'.$fund_source_id.'"
                              ');
        $from_value2 = $this->db->query('SELECT * FROM tbl_consofunds_history WHERE fundsource_id ="'.$fund_source_id.'" and identifier ="3" ORDER BY consolidated_id DESC limit 1 ');
        $from_value3 = $from_value2->row();
        $conso_old_value = $from_value3->consolidated_new_value;
        $conso_new_value = $from_value3->consolidated_new_value + $third_liquidate;

        $this->db->query('insert into tbl_consofunds_history(
                fundsource_id,consolidated_old_value,amount,consolidated_new_value,description,created_by,date_created,identifier)
                          values
                          ("'.$fund_source_id.'","'.$conso_old_value.'","'.$third_liquidate.'","'.$conso_new_value.'","LIQUIDATE THIRD TRANCHE, PROJECT : '.$project_title.'","'.$this->session->userdata('uid').'",now(),"3")');

        $this->db->query('UPDATE tbl_projects SET
                              status = 1
                              WHERE
                              project_id = "'.$project_idpass.'"
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



}