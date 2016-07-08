<?php
/**
 * Created by PhpStorm.
 * User: mblejano
 * Date: 4/5/2016
 * Time: 2:42 PM
 */


class cashforwork_model extends CI_Model
{
    public function get_fund_source()
    {
        $get_fund_source = "
        SELECT
          fundsource_id,
          fund_source
        FROM
          lib_fund_source
        WHERE
        deleted = 0
        ";

        return $this->db->query($get_fund_source)->result();

    }
    public function viewcashforwork($cashforwork_id)
    {

        $sql = 'SELECT a.cashforwork_id,d.saa_number,a.project_title,b.region_name,c.prov_name,e.work_nature,a.no_of_days,a.daily_payment,sum(f.cost_of_assistance_muni) as total_cost,sum(f.no_of_bene_muni) as total_bene
FROM `tbl_cashforwork` a
inner join lib_region b
on a.region_code = b.region_code
inner join lib_provinces c
on a.prov_code = c.prov_code
inner join tbl_saa d
on a.saa_id = d.saa_id
inner join lib_work_nature e
on a.nature_id = e.nature_id
inner join tbl_cash_muni f
on a.cashforwork_id = f.cashforwork_id
where a.deleted = 0 and a.cashforwork_id = "'.$cashforwork_id.'"
GROUP BY f.cashforwork_id';
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;

    }
    public function viewcashforwork_callmuni($cashforwork_id)
    {

        $sql = 'SELECT a.cash_muni_id,c.city_name,a.city_code,a.cost_of_assistance_muni,a.no_of_bene_muni
FROM `tbl_cash_muni` a
inner join lib_municipality c
on a.city_code = c.city_code
where a.deleted = 0 and a.cashforwork_id= "'.$cashforwork_id.'"';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;

    }
    public function viewcashforwork_callbrgy($cashforwork_id)
    {

        $sql = 'SELECT a.city_code,b.brgy_name,a.cash_brgy_id
FROM `tbl_cash_brgy` a
inner join lib_brgy b
on a.brgy_code = b.brgy_code
where a.deleted = 0 and a.cashforwork_id = "'.$cashforwork_id.'"';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;

    }
    public function get_saa($fundsource_id)
    {

        $sql = 'SELECT saa_id,saa_number,saa_balance
FROM `tbl_saa`
where deleted = 0 and fundsource_id = "'.$fundsource_id.'"';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;

    }
    public function get_saro($region)
    {
        $get_saro = "
        SELECT
          saro_id,
          saro_number,
          saro_balance
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
//  Auto Compute
//    public function finalize($cashforwork_id)
//    {
//
//        $sql = 'select a.saro_id,sum(b.cost_of_assistance_muni) total_cost
//                                    from tbl_cashforwork a
//                                    inner join tbl_cash_muni b
//                                    on a.cashforwork_id = b.cashforwork_id
//                                    where a.deleted = 0 and a.cashforwork_id = "'.$cashforwork_id.'"';
//        $query = $this->db->query($sql);
//        $result = $query->row();
//        return $result;
//
//    }
// Manual Input of Total Cost
    public function finalize($cashforwork_id)
    {

        $sql = 'select a.saa_id,a.cost_of_assistance total_cost,a.fundsource_id,a.project_title
                                    from tbl_cashforwork a
                                    where a.deleted = 0 and a.cashforwork_id = "'.$cashforwork_id.'"';
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;

    }
//    public function finalize_update($total_cost,$saro_id,$regionsaro)
//    {
//        $this->db->trans_begin();
//
//        $this->db->query('UPDATE tbl_saro SET
//                              saro_funds_downloaded ="'.$total_cost.'" + saro_funds_downloaded,
//                              saro_funds_utilized = "'.$total_cost.'" + saro_funds_utilized,
//                              saro_balance = saro_balance - "'.$total_cost.'",
//                              modified_by = "'.$this->session->userdata('uid').'"
//                              WHERE
//                              saro_id = "'.$saro_id.'"
//                              ');
//        $this->db->query('UPDATE tbl_funds_allocated SET
//                              funds_downloaded ="'.$total_cost.'" + funds_downloaded,
//                              funds_utilized ="'.$total_cost.'" + funds_utilized,
//                              remaining_budget  = remaining_budget - "'.$total_cost.'",
//                              modified_by = "'.$this->session->userdata('uid').'"
//                              WHERE
//                              region_code = "'.$regionsaro.'"
//                              ');
//        $date = date('Y');
//        $this->db->query('UPDATE tbl_co_funds SET
//                              co_funds_utilized = "'.$total_cost.'" + co_funds_utilized,
//                              co_funds_remaining = co_funds_remaining - "'.$total_cost.'",
//                              modified_by = "'.$this->session->userdata('uid').'"
//                              WHERE
//                              for_year = "'.$date.'"
//                              ');
//
//
//        if ($this->db->trans_status() === FALSE)
//        {
//            $this->db->trans_rollback();
//            return FALSE;
//        }
//        else
//        {
//            $this->db->trans_commit();
//            return TRUE;
//        }
//        $this->db->close();
//
//    }
    public function finalize_update($fundsource_id,$total_cost,$saa_id,$regioncode,$project_title)
    {
        $this->db->trans_begin();

        $this->db->query('UPDATE tbl_saa SET
                              saa_funds_downloaded ="'.$total_cost.'" + saa_funds_downloaded,
                              saa_funds_utilized = "'.$total_cost.'" + saa_funds_utilized,
                              saa_balance = saa_balance - "'.$total_cost.'",
                              modified_by = "'.$this->session->userdata('uid').'"
                              WHERE
                              saa_id = "'.$saa_id.'"
                              ');
        $resultsaa = $this->db->query('SELECT * FROM tbl_saa_history WHERE saa_id = "'.$saa_id.'" and identifier = "2" and deleted = "0" order by saa_history_id desc limit 1');
        $resultsaa_value = $resultsaa->row();
        $funds_new_saa = $resultsaa_value->saa_new_amount;
        $funds_new_saavalue = $funds_new_saa + $total_cost;

        if($resultsaa->num_rows() > 0) {

            $this->db->query('insert into tbl_saa_history(
                          saa_id,saa_old_amount,saa_amount,saa_new_amount,description,date_created,created_by,deleted,identifier)
                          values
                          ("'.$saa_id.'","'.$funds_new_saa.'","'.$total_cost.'","'.$funds_new_saavalue.'","ALLOCATED TO PROJECT CASH FOR WORK: '.$project_title.'",
                          now(),"'.$this->session->userdata('uid').'",0,
                          "2")');

        }
        else
        {
            $this->db->query('insert into tbl_saa_history(
                          saa_id,saa_old_amount,saa_amount,saa_new_amount,description,date_created,created_by,deleted,identifier)
                          values
                          ("'.$saa_id.'","0","'.$total_cost.'","'.$total_cost.'","ALLOCATED TO PROJECT CASH FOR WORK: '.$project_title.'",
                          now(),"'.$this->session->userdata('uid').'",0,
                          "2")');
        }
        //for tbl_saa_historyY
        $this->db->query('UPDATE tbl_funds_allocated SET
                              funds_obligated ="'.$total_cost.'" + funds_obligated,
                              remaining_budget = remaining_budget - "'.$total_cost.'",
                              modified_by = "'.$this->session->userdata('uid').'"
                              WHERE
                              fundsource_id  = "'.$fundsource_id.'" and
                              region_code = "'.$regioncode.'"
                              ');

        //for tbl_fallocation_history
        //check if existing
        //yes
        //get new _value where identifier = 3;description ;insert the get new_value to old_value then input new_value
        //no old_value = 0

        $resultfunds = $this->db->query('SELECT * FROM tbl_fallocation_history WHERE region_code ="'.$regioncode.'" and fundsource_id = "'.$fundsource_id.'" and identifier = "4" and deleted = "0" order by allocation_history_id desc limit 1');
        $resultfunds_value = $resultfunds->row();
        $funds_new_allocated = $resultfunds_value->allocated_new_value;
        $funds_new_value = $funds_new_allocated + $total_cost;

        if($resultfunds->num_rows() > 0) {

            $this->db->query('insert into tbl_fallocation_history(
                          fundsource_id,region_code,allocated_old_value,allocated_amount,allocated_new_value,description,date_created,created_by,deleted,identifier)
                          values
                          ("'.$fundsource_id.'","'.$regioncode.'","'.$funds_new_allocated.'","'.$total_cost.'","'.$funds_new_value.'","ALLOCATED TO PROJECT CASH FOR WORK: '.$project_title.'",
                          now(),"'.$this->session->userdata('uid').'",0,
                          "4")');

        }
        else
        {
            $this->db->query('insert into tbl_fallocation_history(
                          fundsource_id,region_code,allocated_old_value,allocated_amount,allocated_new_value,description,date_created,created_by,deleted,identifier)
                          values
                          ("'.$fundsource_id.'","'.$regioncode.'","0","'.$total_cost.'","'.$total_cost.'","ALLOCATED TO PROJECT CASH FOR WORK:  '.$project_title.'",
                          now(),"'.$this->session->userdata('uid').'",0,
                          "4")');
        }

        $this->db->query('UPDATE tbl_co_funds SET
                              co_funds_utilized = "'.$total_cost.'" + co_funds_utilized,
                              modified_by = "'.$this->session->userdata('uid').'"
                              WHERE
                              fundsource_id = "'.$fundsource_id.'"
                              ');

        $resultconso = $this->db->query('SELECT * FROM tbl_consofunds_history WHERE fundsource_id = "'.$fundsource_id.'" and identifier = "2"  and deleted = "0" order by consolidated_id desc limit 1 ');
        $resultconso_value = $resultconso->row();
        $funds_new_consofund = $resultconso_value->consolidated_new_value;
        $funds_new_consovalue = $funds_new_consofund + $total_cost;

        if($resultconso->num_rows() > 0) {

            $this->db->query('insert into tbl_consofunds_history(
                          fundsource_id,consolidated_old_value,amount,consolidated_new_value,description,date_created,created_by,deleted,identifier)
                          values
                          ("'.$fundsource_id.'","'.$funds_new_consofund.'","'.$total_cost.'","'.$funds_new_consovalue.'","ALLOCATED TO PROJECT CASH FOR WORK: '.$project_title.'",
                          now(),"'.$this->session->userdata('uid').'",0,
                          "2")');

        }
        else
        {
            $this->db->query('insert into tbl_consofunds_history(
                          fundsource_id,consolidated_old_value,amount,consolidated_new_value,description,date_created,created_by,deleted,identifier)
                          values
                          ("'.$fundsource_id.'","0","'.$total_cost.'","'.$total_cost.'","ALLOCATED TO PROJECT CASH FOR WORK: '.$project_title.'",
                          now(),"'.$this->session->userdata('uid').'",0,
                          "2")');
        }


        //for tbl_consofund_history
        //check if existing
        //yes
        //get new _value where identifier = 3;description ;insert the get new_value to old_value then input new_value
        //no old_value = 0
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
    // Manual Input of COst of assistance
    public function get_project($region_code)
    {
        $sql = 'SELECT g.saa_number,a.cashforwork_id,a.project_title,a.region_code,b.region_name,c.work_nature,a.no_of_days,number_of_bene as total_bene, cost_of_assistance as total_cost,a.file_location
                FROM `tbl_cashforwork` a
                INNER JOIN lib_region b
                on a.region_code = b.region_code
                INNER JOIN lib_work_nature c
                on a.nature_id = c.nature_id
                inner join tbl_saa g
                on a.saa_id = g.saa_id
                where a.deleted = 0 and a.region_code = '.$region_code.'
                GROUP BY a.cashforwork_id
               ';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;

    }
// Auto Compute
//    public function get_project($region_code)
//    {
//        $sql = 'SELECT g.saro_number,a.cashforwork_id,a.project_title,a.region_code,b.region_name,c.work_nature,a.no_of_days,sum(d.no_of_bene_muni) as total_bene, sum(d.cost_of_assistance_muni) as total_cost
//                FROM `tbl_cashforwork` a
//                INNER JOIN lib_region b
//                on a.region_code = b.region_code
//                INNER JOIN lib_work_nature c
//                on a.nature_id = c.nature_id
//                inner join tbl_cash_muni d
//                on d.cashforwork_id = a.cashforwork_id
//                inner join tbl_saro g
//                on a.saro_id = g.saro_id
//                where a.deleted = 0 and d.deleted = 0 and a.region_code = '.$region_code.'
//                GROUP BY a.cashforwork_id
//               ';
//        $query = $this->db->query($sql);
//        $result = $query->result();
//        return $result;
//
//    }

    public function get_cashforworkDetails($cashforwork_id)
    {
        $sql = 'SELECT a.project_title, b.region_name,c.work_nature,a.no_of_days,a.daily_payment,a.number_of_bene,a.cost_of_assistance
                FROM `tbl_cashforwork`a
                inner join lib_region b
                on a.region_code = b.region_code
                inner join lib_work_nature c
                on a.nature_id = c.nature_id
                where a.cashforwork_id = "'.$cashforwork_id.'" and a.deleted = 0
               ';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;

    }
    public function get_bene_list($cashforwork_id)
    {
        $sql = 'select a.cashforwork_brgy_id,a.bene_id,concat(a.first_name,\' \',a.middle_name,\' \',a.last_name,\' \',a.ext_name) as bene_fullname,a.cashforwork_id,a.cashforwork_muni_id from tbl_cash_bene_list a
        where a.deleted = 0 and a.cashforwork_brgy_id = "'.$cashforwork_id.'"';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;

    }

    public function get_countbene_muni($cashforwork_id)
    {
        $sql = 'select sum(no_of_bene_muni) as totalbene from tbl_cash_muni where deleted = 0 and cashforwork_id = '.$cashforwork_id.'';
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
    public function get_countbene_brgy($cashforwork_muni_id)
    {
        $sql = 'select sum(no_of_bene_brgy) as totalbene from tbl_cash_brgy where deleted = 0 and cashforwork_muni_id = '.$cashforwork_muni_id.'';
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
    public function get_cashmuni_list($cashforwork_id)
    {
        $sql = 'SELECT a.cost_of_assistance_muni,a.no_of_bene_muni,a.cash_muni_id,a.cashforwork_id,b.city_name,a.daily_payment
                FROM `tbl_cash_muni` a
                INNER JOIN lib_municipality b
                on a.city_code = b.city_code
                where a.deleted = 0 and a.cashforwork_id = "'.$cashforwork_id.'"';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;

    }
    public function get_project_title($cashforwork_id)
    {
        $sql = 'select a.no_of_days,a.project_title,a.daily_payment,a.saa_id,a.number_of_bene from tbl_cashforwork a
                where a.cashforwork_id = "'.$cashforwork_id.'" and a.deleted = 0';
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;

    }

    public function get_cashbrgy_list($cashforwork_muni_id)
    {
        $sql = 'SELECT a.cashforwork_muni_id,a.file_location,a.cash_brgy_id,a.no_of_bene_brgy,a.cost_of_assistance_brgy,b.brgy_name FROM `tbl_cash_brgy` a
                inner join lib_brgy b
                on a.brgy_code = b.brgy_code
                where a.cashforwork_muni_id = "'.$cashforwork_muni_id.'" and a.deleted = 0';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;

    }

    public function get_project_province($cashforwork_id)
    {
        $sql = 'select a.prov_code,b.prov_name from tbl_cashforwork a
                inner join lib_provinces b
                on a.prov_code = b.prov_code
                where a.cashforwork_id = "'.$cashforwork_id.'" and a.deleted = 0';
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;

    }
    public function viewcashforwork_callbenelist($cashforwork_id)
    {

        $sql = 'SELECT concat(a.first_name,\' \',a.middle_name,\' \',a.last_name,\' \',a.ext_name) as bene_fullname,a.cashforwork_brgy_id,a.cashforwork_id,a.cashforwork_muni_id
from tbl_cash_bene_list a
where a.deleted = 0 and a.cashforwork_id = "'.$cashforwork_id.'"';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;

    }
    public function get_brgy_cashforwork_id($cashforworkbrgy_id)
    {
        $sql = 'SELECT cashforwork_id,cashforwork_muni_id,no_of_bene_brgy FROM `tbl_cash_brgy`
            where cash_brgy_id = "'.$cashforworkbrgy_id.'" and deleted = 0';
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
    public function get_countbene_benelist($cashforworkbrgy_id)
    {
        $sql = 'SELECT count(bene_id) as countBene FROM `tbl_cash_bene_list` where deleted = 0 and cashforwork_brgy_id = "'.$cashforworkbrgy_id.'";';
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
    public function get_project_prov_muni($cashforwork_muni_id)
    {
        $sql = 'select a.no_of_bene_muni,f.work_nature,e.region_name,a.cashforwork_id,a.cash_muni_id,d.project_title,d.no_of_days,d.daily_payment,a.prov_code,b.prov_name,c.city_name,c.city_code
                from tbl_cash_muni a
                inner join lib_provinces b
                on a.prov_code = b.prov_code
                inner join lib_municipality C
                on a.city_code = c.city_code
				inner join tbl_cashforwork d
				on a.cashforwork_id = d.cashforwork_id
                inner join lib_region e
                on d.region_code = e.region_code
                INNER JOIN lib_work_nature f
                ON d.nature_id = f.nature_id
                where a.cash_muni_id = "'.$cashforwork_muni_id.'" and a.deleted = 0';
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
    public function get_saa_balance($saa_id)
    {
        $sql = 'select saa_funds,saa_id,saa_number,saa_balance from tbl_saa
where saa_id = "'.$saa_id.'" and deleted = 0';
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;

        $this->db->close();
    }
    public function get_project_muni_brgy($cashforwork_brgy_id)
    {
        $sql = 'select c.city_name,b.daily_payment,b.no_of_days,a.cash_brgy_id,a.city_code,a.cashforwork_muni_id,a.brgy_code,a.no_of_bene_brgy,a.cashforwork_id
                from tbl_cash_brgy a
                inner join tbl_cashforwork b
                on a.cashforwork_id = b.cashforwork_id
                inner join lib_municipality c
                on a.city_code = c.city_code
                where a.cash_brgy_id = "'.$cashforwork_brgy_id.'" and a.deleted = 0 and b.deleted = 0';// for verification
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
    public function get_cashmuni_byid($cashforwork_muni_id = 0)
    {
        $query = $this->db->get_where('tbl_cash_muni',array('cash_muni_id'=>$cashforwork_muni_id));
        if ($query->num_rows() > 0){
            return $query->row();
        } else {
            return FALSE;
        }
        $this->db->close();
    }
    public function get_upload_filename($cashforwork_id)
    {
        $sql = 'select file_location from tbl_cashforwork where cashforwork_id = "'.$cashforwork_id.'" and deleted = 0' ;// for verification
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
// auto compute
//    public function insertProject($saro,$myid,$project_title,$regionlist,$provlist
//        ,$natureofworklist,$daily_payment,$number_days)
//    {
//
//        $this->db->trans_begin();
//        $this->db->query('insert into tbl_cashforwork(assistance_id,saro_id,
//                          project_title,region_code,prov_code,nature_id,daily_payment,no_of_days,date_created,created_by,deleted)
//                          values
//                          ("2","'.$saro.'","'.$project_title.'","'.$regionlist.'",
//                          "'.$provlist.'","'.$natureofworklist.'",
//                          "'.$daily_payment.'",
//                          "'.$number_days.'",now(),"'.$myid.'","0")');
//
//        if ($this->db->trans_status() === FALSE)
//        {
//            $this->db->trans_rollback();
//            return FALSE;
//        }
//        else
//
//        {   $insert_id = $this->db->insert_id();
//            $this->db->trans_commit();
//
//            //return TRUE;
//            return $insert_id;
//        }
//        $this->db->close();
//
//    }
// manual input
    public function insertProject($fundsource,$number_of_bene,$cost_of_assistance,$saa,$myid,$project_title,$regionlist,$provlist
        ,$natureofworklist,$daily_payment,$number_days)
    {

        $this->db->trans_begin();
        $this->db->query('insert into tbl_cashforwork(assistance_id,saa_id,fundsource_id,
                          project_title,region_code,prov_code,nature_id,daily_payment,no_of_days,number_of_bene,cost_of_assistance,date_created,created_by,deleted)
                          values
                          ("2","'.$saa.'","'.$fundsource.'","'.$project_title.'","'.$regionlist.'",
                          "'.$provlist.'","'.$natureofworklist.'",
                          "'.$daily_payment.'",
                          "'.$number_days.'",
                          "'.$number_of_bene.'",
                          "'.$cost_of_assistance.'",now(),"'.$myid.'","0")');

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return FALSE;
        }
        else

            {   $insert_id = $this->db->insert_id();
                $this->db->trans_commit();

                //return TRUE;
                return $insert_id;
            }
            $this->db->close();

    }

    public function insertCashmuni($myid,$cashforworkpass_id,$provlist,$munilist
        ,$daily_payment,$number_bene,$cost_of_assistance)
    {

        $this->db->trans_begin();
        $this->db->query('insert into tbl_cash_muni(cashforwork_id,
                          prov_code,city_code,daily_payment,no_of_bene_muni,cost_of_assistance_muni,date_created,created_by,deleted)
                          values
                          ("'.$cashforworkpass_id.'","'.$provlist.'","'.$munilist.'",
                          "'.$daily_payment.'","'.$number_bene.'","'.$cost_of_assistance.'",now(),"'.$myid.'","0")');

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

    public function insertCashbrgy($myid,$cashforworkpass_id,$cash_muni_id_pass,$munilist ,$brgylist,$number_bene,$cost_of_assistance_brgy)
    {

        $this->db->trans_begin();
        $this->db->query('insert into tbl_cash_brgy(cashforwork_muni_id,
                          cashforwork_id,city_code,brgy_code,no_of_bene_brgy,cost_of_assistance_brgy,date_created,created_by,deleted)
                          values
                          ("'.$cash_muni_id_pass.'","'.$cashforworkpass_id.'","'.$munilist.'","'.$brgylist.'",
                          "'.$number_bene.'","'.$cost_of_assistance_brgy.'",now(),"'.$myid.'","0")');

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
    public function insertBene($cashforwork_muni_idpass,$cashforwork_idpass,$bene_firstname,$bene_middlename,$bene_lastname,$bene_extname,$myid,$cashforwork_brgyidpass)
    {

        $this->db->trans_begin();
        $this->db->query('insert into tbl_cash_bene_list(first_name,middle_name,last_name,ext_name,cashforwork_id,cashforwork_brgy_id,cashforwork_muni_id,date_created,created_by,deleted)
                          values
                          ("'.$bene_firstname.'","'.$bene_middlename.'","'.$bene_lastname.'","'.$bene_extname.'","'.$cashforwork_idpass.'","'.$cashforwork_brgyidpass.'","'.$cashforwork_muni_idpass.'",now(),"'.$myid.'","0")');

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
        $this->db->query('UPDATE tbl_cash_muni SET
                              deleted ="1"
                              WHERE
                              cashforwork_id = "'.$cashforwork_id.'"
                              ');
        $this->db->query('UPDATE tbl_cash_brgy SET
                              deleted ="1"
                              WHERE
                              cashforwork_id = "'.$cashforwork_id.'"
                              ');
        $this->db->query('UPDATE tbl_cash_benelist SET
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

    public function deleteCash_muni_and_brgy($cash_muni_id = 0)
    {
        $this->db->trans_begin();

        $this->db->query('UPDATE tbl_cash_muni SET
                              deleted ="1"
                              WHERE
                              cash_muni_id = "'.$cash_muni_id.'"
                              ');
        $this->db->query('UPDATE tbl_cash_brgy SET
                              deleted ="1"
                              WHERE
                              cashforwork_muni_id = "'.$cash_muni_id.'"
                              ');
        $this->db->query('UPDATE tbl_cash_benelist SET
                              deleted ="1"
                              WHERE
                              cashforwork_muni_id = "'.$cash_muni_id.'"
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
    public function deleteCash_brgy($cash_brgy_id = 0)
    {
        $this->db->trans_begin();

        $this->db->query('UPDATE tbl_cash_brgy SET
                              deleted ="1"
                              WHERE
                              cash_brgy_id = "'.$cash_brgy_id.'"
                              ');
        $this->db->query('UPDATE tbl_cash_benelist SET
                              deleted ="1"
                              WHERE
                              cash_brgy_id = "'.$cash_brgy_id.'"
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

    public function updateCashforwork($sarolist,$cashforwork_id1,$myid,$project_title,$regionlist,$provlist
        ,$natureofworklist,$number_days,$daily_payment,$number_of_bene,$cost_of_assistance){

        $this->db->trans_begin();

        $this->db->query('UPDATE tbl_cashforwork
                        SET
                        saro_id = "'.$sarolist.'",
                        project_title = "'.$project_title.'",
                        region_code = "'.$regionlist.'",
                        prov_code = "'.$provlist.'",
                        no_of_days = "'.$number_days.'",
                        nature_id = "'.$natureofworklist.'",
                        daily_payment = "'.$daily_payment.'",
                        number_of_bene = "'.$number_of_bene.'",
                        cost_of_assistance = "'.$cost_of_assistance.'",
                        modified_by = "'.$myid.'",
                        date_modified = now()
                        WHERE
                        cashforwork_id = "'.$cashforwork_id1.'"');
        $day_daily = $daily_payment * $number_days;
        $this->db->query('UPDATE tbl_cash_muni
                        SET
                        cost_of_assistance_muni = no_of_bene_muni * "'.$day_daily.'",
                        modified_by = "'.$myid.'",
                        date_modified = now()
                        WHERE
                        cashforwork_id = "'.$cashforwork_id1.'"');
        $this->db->query('UPDATE tbl_cash_brgy
                        SET
                        cost_of_assistance_brgy = no_of_bene_brgy * "'.$day_daily.'",
                        modified_by = "'.$myid.'",
                        date_modified = now()
                        WHERE
                        cashforwork_id = "'.$cashforwork_id1.'"');
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
    public function updateCashforwork_muni($myid,$cash_muni_id,$munilist,$number_of_bene
        ,$cost_of_assistance_muni){

        $this->db->trans_begin();

        $this->db->query('UPDATE tbl_cash_muni
                        SET
                        city_code = "'.$munilist.'",
                        no_of_bene_muni = "'.$number_of_bene.'",
                        cost_of_assistance_muni = "'.$cost_of_assistance_muni.'",
                        modified_by = "'.$myid.'",
                        date_modified = now()
                        WHERE
                        cash_muni_id = "'.$cash_muni_id.'"');

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
    public function updateCashforwork_brgy($cash_brgy_id_pass,$myid,$brgylist,$number_of_bene
        ,$cost_of_assistance_brgy){

        $this->db->trans_begin();

        $this->db->query('UPDATE tbl_cash_brgy
                        SET
                        brgy_code = "'.$brgylist.'",
                        no_of_bene_brgy = "'.$number_of_bene.'",
                        cost_of_assistance_brgy = "'.$cost_of_assistance_brgy.'",
                        modified_by = "'.$myid.'",
                        date_modified = now()
                        WHERE
                        cash_brgy_id = "'.$cash_brgy_id_pass.'"');

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
    public function uploadBenefile($myid,$file_name,$cashforwork_id){

        $this->db->trans_begin();

        $this->db->query('UPDATE tbl_cashforwork
                        SET
                        file_location = "'.$file_name.'",
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

    public function get_muni($prov_code,$cashforwork_id) {
        $city_qry = $this->db->query('SELECT city_code FROM `tbl_cash_muni` where prov_code = "'.$prov_code.'" and cashforwork_id = "'.$cashforwork_id.'" and deleted = 0;');
        $city_codes =  $city_qry->result_array();
        $unformat = "";
        foreach($city_codes as $i=>$row)
        {
            $unformat .= "'".$row['city_code']."',";
        }
        $format = substr($unformat,0,-1);
        if($city_qry->num_rows() > 0) {
            $where  = "AND city_code not in (".$format.")";
        }
        else
        {
            $where  = "";
        }

        $get_cities = "
        SELECT
            city_code,
            city_name
        FROM
          lib_municipality
        WHERE
          prov_code = ? ".$where."
        ORDER BY
          city_name
        ";

        return $this->db->query($get_cities,$prov_code)->result();
    }
    public function get_muni_edit($prov_code,$cashforwork_id,$city_code) {
        $city_qry = $this->db->query('SELECT city_code FROM `tbl_cash_muni` where prov_code = "'.$prov_code.'" and cashforwork_id = "'.$cashforwork_id.'" and deleted = 0 and city_code != "'.$city_code.'";');
        $city_codes =  $city_qry->result_array();
        $unformat = "";
        foreach($city_codes as $i=>$row)
        {
            $unformat .= "'".$row['city_code']."',";
        }
        $format = substr($unformat,0,-1);
        if($city_qry->num_rows() > 0) {
            $where  = "AND city_code not in (".$format.")";
        }
        else
        {
            $where  = "";
        }

        $get_cities = "
        SELECT
            city_code,
            city_name
        FROM
          lib_municipality
        WHERE
          prov_code = ? ".$where."
        ORDER BY
          city_name
        ";

        return $this->db->query($get_cities,$prov_code)->result();
    }

    public function get_brgy($city_code,$cashforwork_id) {
        $brgy_qry = $this->db->query('SELECT brgy_code FROM `tbl_cash_brgy` where city_code = "'.$city_code.'" and cashforwork_id = "'.$cashforwork_id.'" and deleted = 0; ');
        $brgy_codes =  $brgy_qry->result_array();
        $unformat = "";
        foreach($brgy_codes as $i=>$row)
        {
            $unformat .= "'".$row['brgy_code']."',";
        }
        $format = substr($unformat,0,-1);
        if($brgy_qry->num_rows() > 0) {
            $where  = "AND brgy_code not in (".$format.")";
        }
        else
        {
            $where  = "";
        }
        $get_brgy = "
        SELECT
            brgy_code,
            brgy_name
        FROM
          lib_brgy
        WHERE
          city_code = ? ".$where."
        ORDER BY
          brgy_name
        ";

        return $this->db->query($get_brgy,$city_code)->result();
    }

    public function get_brgy_edit($city_code,$cashforwork_id,$brgy_code) {
        $brgy_qry = $this->db->query('SELECT brgy_code FROM `tbl_cash_brgy` where city_code = "'.$city_code.'" and cashforwork_id = "'.$cashforwork_id.'" and deleted = 0 and brgy_code != "'.$brgy_code.'";');
        $brgy_codes =  $brgy_qry->result_array();
        $unformat = "";
        foreach($brgy_codes as $i=>$row)
        {
            $unformat .= "'".$row['brgy_code']."',";
        }
        $format = substr($unformat,0,-1);
        if($brgy_qry->num_rows() > 0) {
            $where  = "AND brgy_code not in (".$format.")";
        }
        else
        {
            $where  = "";
        }
        $get_brgy = "
        SELECT
            brgy_code,
            brgy_name
        FROM
          lib_brgy
        WHERE
          city_code = ? ".$where."
        ORDER BY
          brgy_name
        ";

        return $this->db->query($get_brgy,$city_code)->result();
    }
    public function getbenebyid($cashbene_id)
    {
        $query = $this->db->get_where('tbl_cash_bene_list',array('bene_id'=>$cashbene_id));
        if ($query->num_rows() > 0)
        {
            return $query->row();
        }
        else
        {
            return FALSE;
        }
        $this->db->close();
    }
    public function updateCashbene($bene_idpass, $bene_firstname, $bene_middlename, $bene_lastname, $bene_extname, $myid)
    {
        $this->db->trans_begin();
        $this->db->query('UPDATE tbl_cash_bene_list SET
                              first_name ="'.$bene_firstname.'",
                              middle_name ="'.$bene_middlename.'",
                              last_name ="'.$bene_lastname.'",
                              ext_name ="'.$bene_extname.'",
							  date_modified=now(),
							  modified_by="'.$myid.'"

                              WHERE
                              bene_id = "'.$bene_idpass.'"
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
    public function deleteCashBene($cashforwork_id,$cashbene_id)
    {
        $this->db->trans_begin();

        $this->db->query('UPDATE tbl_cash_bene_list SET
                              deleted="1"
                              WHERE
                              bene_id = "'.$cashbene_id.'"
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