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
        $sql = 'select a.project_id,a.saro_number,a.project_title, a.region_code, b.assistance_name,
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
          and saro_balance != '0.00'
          and region_code = '".$region."'
        GROUP BY
         saro_id
        ORDER BY
          saro_id
        ";

        return $this->db->query($get_saro)->result();

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

    }
    public function get_implementing_agency()
    {
        $sql = 'select agency_id,agency_name
                from lib_implementing_agency
                where deleted = 0';
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

    }
    public function insertProject($myid,$saro_number,$project_title,$regionlist,$provlist,$munilist,$brgylist,$number_bene,$assistancelist,$natureofworklist,$fundsourcelist,$project_amount,
                                  $lgucounterpart_prov,$lgu_amount_prov,$lgu_remarks_prov,$lgucounterpart_muni,$lgu_amount_muni,$lgu_remarks_muni,$lgucounterpart_brgy,
                                  $lgu_amount_brgy,$lgu_remarks_brgy,$project_cost,$project_amount,$implementing_agency,$start_date,$target_date,$status,$first_tranche,$second_tranche,$third_tranche)
    {

        $this->db->trans_begin();
        $this->db->query('insert into tbl_projects(saro_number,assistance_id,project_title,region_code,prov_code,city_code,brgy_code
                          ,no_of_bene,nature_id,fundsource_id
                          ,project_amount,lgucounterpart_prov,lgu_amount_prov,lgu_remarks_prov
                          ,lgucounterpart_muni,lgu_amount_muni,lgu_remarks_muni,lgucounterpart_brgy,lgu_amount_brgy,lgu_remarks_brgy
                          ,project_cost,implementing_agency,created_by,date_created,status,deleted)
                          values
                          ("'.$saro_number.'","'.$assistancelist.'","'.$project_title.'","'.$regionlist.'","'.$provlist.'","'.$munilist.'","'.$brgylist.'",
                          "'.$number_bene.'","'.$natureofworklist.'","'.$fundsourcelist.'",
                          "'.$project_amount.'","'.$lgucounterpart_prov.'","'.$lgu_amount_prov.'","'.$lgu_remarks_prov.'",
                          "'.$lgucounterpart_muni.'","'.$lgu_amount_muni.'","'.$lgu_remarks_muni.'","'.$lgucounterpart_brgy.'","'.$lgu_amount_brgy.'","'.$lgu_remarks_brgy.'",
                          "'.$project_cost.'","'.$implementing_agency.'","'.$myid.'",now(),"'.$status.'","0")');

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
        $this->db->query('UPDATE tbl_saro set saro_funds_downloaded = "'.$project_amount.'", saro_balance = saro_balance - "'.$project_amount.'"
        where saro_number ="'.$saro_number.'"');
        $this->db->query('UPDATE tbl_funds_allocated set funds_downloaded = "'.$project_amount.'"
        where region_code ="'.$regionlist.'"');

        $this->db->query('INSERT INTO tbl_project_budget(project_id,region_code,first_tranche,first_tranche_status,second_tranche,third_tranche,date_created,created_by, deleted)
                          VALUES
                          (
                          "'.$insert_id.'",
                          "'.$regionlist.'",
                          "'.$first_tranche.'",
                          0,
                          "'.$second_tranche.'",
                          "'.$third_tranche.'",
						  now(),
						  "'.$this->session->userdata('uid').'",
						  0
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
    public function updateLiquidateTranche($first_liquidate,$myid,$remarks,$budget_id,$start_date)
    {
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
    public function updateSecondLiquidateTranche($second_liquidate,$myid,$remarks,$budget_id,$start_date)
    {
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
    public function updateThirdLiquidateTranche($third_liquidate,$myid,$remarks,$budget_id,$start_date)
    {
        $this->db->trans_begin();
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