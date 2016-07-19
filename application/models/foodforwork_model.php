<?php
/**
 * Created by PhpStorm.
 * User: mblejano
 * Date: 4/5/2016
 * Time: 2:42 PM
 */


class foodforwork_model extends CI_Model
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
    public function viewfoodforwork($foodforwork_id)
    {

        $sql = 'SELECT a.foodforwork_id,d.saa_number,a.project_title,b.region_name,c.prov_name,e.work_nature,a.no_of_days,a.daily_payment,a.cost_of_assistance as total_cost,a.number_of_bene as total_bene
FROM `tbl_foodforwork` a
inner join lib_region b
on a.region_code = b.region_code
inner join lib_provinces c
on a.prov_code = c.prov_code
inner join tbl_saa d
on a.saa_id = d.saa_id
inner join lib_work_nature e
on a.nature_id = e.nature_id
where a.deleted = 0 and a.foodforwork_id = "'.$foodforwork_id.'"
GROUP BY a.foodforwork_id';
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;

    }
    public function viewfoodforwork_callmuni($foodforwork_id)
    {

        $sql = 'SELECT a.food_muni_id,c.city_name,a.city_code,a.cost_of_assistance_muni,a.no_of_bene_muni
FROM `tbl_food_muni` a
inner join lib_municipality c
on a.city_code = c.city_code
where a.deleted = 0 and a.foodforwork_id= "'.$foodforwork_id.'"';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;

    }
    public function viewfoodforwork_callbrgy($foodforwork_id)
    {

        $sql = 'SELECT a.city_code,b.brgy_name,a.food_brgy_id
FROM `tbl_food_brgy` a
inner join lib_brgy b
on a.brgy_code = b.brgy_code
where a.deleted = 0 and a.foodforwork_id = "'.$foodforwork_id.'"';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;

    }
    public function viewfoodforwork_callbenelist($foodforwork_id)
    {

        $sql = 'SELECT concat(a.first_name,\' \',a.middle_name,\' \',a.last_name,\' \',a.ext_name) as bene_fullname,a.foodforwork_brgy_id,a.foodforwork_id,a.foodforwork_muni_id
from tbl_food_bene_list a
where a.deleted = 0 and a.foodforwork_id = "'.$foodforwork_id.'"';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;

    }
    public function get_saa($fundsource_id,$region_code)
    {

        $sql = 'SELECT saa_id,saa_number,saa_balance
FROM `tbl_saa`
where deleted = 0 and fundsource_id = "'.$fundsource_id.'" and region_code = "'.$region_code.'"' ;
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;

    }
//    public function get_saro($region)
//    {
//        $get_saro = "
//        SELECT
//          saro_id,
//          saro_number,
//          saro_balance
//        FROM
//          tbl_saro
//        WHERE
//          saro_id <> '0'
//          and deleted = 0
//          and region_code = '".$region."'
//        GROUP BY
//         saro_id
//        ORDER BY
//          saro_id
//        ";
//
//        return $this->db->query($get_saro)->result();
//
//    }
//  Auto Compute
//    public function finalize($foodforwork_id)
//    {
//
//        $sql = 'select a.saro_id,sum(b.cost_of_assistance_muni) total_cost
//                                    from tbl_foodforwork a
//                                    inner join tbl_food_muni b
//                                    on a.foodforwork_id = b.foodforwork_id
//                                    where a.deleted = 0 and a.foodforwork_id = "'.$foodforwork_id.'"';
//        $query = $this->db->query($sql);
//        $result = $query->row();
//        return $result;
//
//    }
// Manual Input of Total Cost
    public function finalize($foodforwork_id)
    {

        $sql = 'select a.saa_id,a.cost_of_assistance total_cost,a.fundsource_id,a.project_title
                                    from tbl_foodforwork a
                                    where a.deleted = 0 and a.foodforwork_id = "'.$foodforwork_id.'"';
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;

    }
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
                          ("'.$saa_id.'","'.$funds_new_saa.'","'.$total_cost.'","'.$funds_new_saavalue.'","ALLOCATED TO PROJECT FOOD FOR WORK: '.$project_title.'",
                          now(),"'.$this->session->userdata('uid').'",0,
                          "2")');

        }
        else
        {
            $this->db->query('insert into tbl_saa_history(
                          saa_id,saa_old_amount,saa_amount,saa_new_amount,description,date_created,created_by,deleted,identifier)
                          values
                          ("'.$saa_id.'","0","'.$total_cost.'","'.$total_cost.'","ALLOCATED TO PROJECT FOOD FOR WORK: '.$project_title.'",
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
                          ("'.$fundsource_id.'","'.$regioncode.'","'.$funds_new_allocated.'","'.$total_cost.'","'.$funds_new_value.'","ALLOCATED TO PROJECT FOOD FOR WORK: '.$project_title.'",
                          now(),"'.$this->session->userdata('uid').'",0,
                          "4")');

        }
        else
        {
            $this->db->query('insert into tbl_fallocation_history(
                          fundsource_id,region_code,allocated_old_value,allocated_amount,allocated_new_value,description,date_created,created_by,deleted,identifier)
                          values
                          ("'.$fundsource_id.'","'.$regioncode.'","0","'.$total_cost.'","'.$total_cost.'","ALLOCATED TO PROJECT FOOD FOR WORK:  '.$project_title.'",
                          now(),"'.$this->session->userdata('uid').'",0,
                          "4")');
        }

        $this->db->query('UPDATE tbl_co_funds SET
                              co_funds_utilized = "'.$total_cost.'" + co_funds_utilized,
                              modified_by = "'.$this->session->userdata('uid').'"
                              WHERE
                              fundsource_id = "'.$fundsource_id.'"
                              ');

        $resultconso = $this->db->query('SELECT * FROM tbl_consofunds_history WHERE fundsource_id = "'.$fundsource_id.'" and identifier = "2" and deleted = "0" order by consolidated_id desc limit 1');
        $resultconso_value = $resultconso->row();
        $funds_new_consofund = $resultconso_value->consolidated_new_value;
        $funds_new_consovalue = $funds_new_consofund + $total_cost;

        if($resultconso->num_rows() > 0) {

            $this->db->query('insert into tbl_consofunds_history(
                          fundsource_id,consolidated_old_value,amount,consolidated_new_value,description,date_created,created_by,deleted,identifier)
                          values
                          ("'.$fundsource_id.'","'.$funds_new_consofund.'","'.$total_cost.'","'.$funds_new_consovalue.'","ALLOCATED TO PROJECT FOOD FOR WORK: '.$project_title.'",
                          now(),"'.$this->session->userdata('uid').'",0,
                          "2")');

        }
        else
        {
            $this->db->query('insert into tbl_consofunds_history(
                          fundsource_id,consolidated_old_value,amount,consolidated_new_value,description,date_created,created_by,deleted,identifier)
                          values
                          ("'.$fundsource_id.'","0","'.$total_cost.'","'.$total_cost.'","ALLOCATED TO PROJECT FOOD FOR WORK: '.$project_title.'",
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
        $sql = 'SELECT g.saa_number,a.foodforwork_id,a.project_title,a.region_code,b.region_name,c.work_nature,a.no_of_days,number_of_bene as total_bene, cost_of_assistance as total_cost,a.file_location
                FROM `tbl_foodforwork` a
                INNER JOIN lib_region b
                on a.region_code = b.region_code
                INNER JOIN lib_work_nature c
                on a.nature_id = c.nature_id
                inner join tbl_saa g
                on a.saa_id = g.saa_id
                where a.deleted = 0 and a.region_code = '.$region_code.'
                GROUP BY a.foodforwork_id
               ';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;

    }
// Auto Compute
//    public function get_project($region_code)
//    {
//        $sql = 'SELECT g.saro_number,a.foodforwork_id,a.project_title,a.region_code,b.region_name,c.work_nature,a.no_of_days,sum(d.no_of_bene_muni) as total_bene, sum(d.cost_of_assistance_muni) as total_cost
//                FROM `tbl_foodforwork` a
//                INNER JOIN lib_region b
//                on a.region_code = b.region_code
//                INNER JOIN lib_work_nature c
//                on a.nature_id = c.nature_id
//                inner join tbl_food_muni d
//                on d.foodforwork_id = a.foodforwork_id
//                inner join tbl_saro g
//                on a.saro_id = g.saro_id
//                where a.deleted = 0 and d.deleted = 0 and a.region_code = '.$region_code.'
//                GROUP BY a.foodforwork_id
//               ';
//        $query = $this->db->query($sql);
//        $result = $query->result();
//        return $result;
//
//    }

    public function get_foodforworkDetails($foodforwork_id)
    {
        $sql = 'SELECT a.project_title, b.region_name,c.work_nature,a.no_of_days,a.daily_payment,a.number_of_bene,a.cost_of_assistance
                FROM `tbl_foodforwork`a
                inner join lib_region b
                on a.region_code = b.region_code
                inner join lib_work_nature c
                on a.nature_id = c.nature_id
                where a.foodforwork_id = "'.$foodforwork_id.'" and a.deleted = 0
               ';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;

    }
    public function get_bene_list($foodforwork_id)
    {
        $sql = 'select a.foodforwork_brgy_id,a.bene_id,concat(a.first_name,\' \',a.middle_name,\' \',a.last_name,\' \',a.ext_name) as bene_fullname,a.foodforwork_id,a.foodforwork_muni_id from tbl_food_bene_list a
        where a.deleted = 0 and a.foodforwork_brgy_id = "'.$foodforwork_id.'"';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;

    }

    public function get_countbene_muni($foodforwork_id)
    {
        $sql = 'select sum(no_of_bene_muni) as totalbene from tbl_food_muni where deleted = 0 and foodforwork_id = '.$foodforwork_id.'';
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
    public function get_countbene_brgy($foodforwork_muni_id)
    {
        $sql = 'select sum(no_of_bene_brgy) as totalbene from tbl_food_brgy where deleted = 0 and foodforwork_muni_id = '.$foodforwork_muni_id.'';
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
    public function get_foodmuni_list($foodforwork_id)
    {
        $sql = 'SELECT a.cost_of_assistance_muni,a.no_of_bene_muni,a.food_muni_id,a.foodforwork_id,b.city_name,a.daily_payment
                FROM `tbl_food_muni` a
                INNER JOIN lib_municipality b
                on a.city_code = b.city_code
                where a.deleted = 0 and a.foodforwork_id = "'.$foodforwork_id.'"';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;

    }
    public function get_project_title($foodforwork_id)
    {
        $sql = 'select a.no_of_days,a.project_title,a.daily_payment,a.saa_id,a.number_of_bene from tbl_foodforwork a
                where a.foodforwork_id = "'.$foodforwork_id.'" and a.deleted = 0';
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;

    }

    public function get_foodbrgy_list($foodforwork_muni_id)
    {
        $sql = 'SELECT a.foodforwork_muni_id,a.file_location,a.food_brgy_id,a.no_of_bene_brgy,a.cost_of_assistance_brgy,b.brgy_name FROM `tbl_food_brgy` a
                inner join lib_brgy b
                on a.brgy_code = b.brgy_code
                where a.foodforwork_muni_id = "'.$foodforwork_muni_id.'" and a.deleted = 0';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;

    }

    public function get_project_province($foodforwork_id)
    {
        $sql = 'select a.prov_code,b.prov_name from tbl_foodforwork a
                inner join lib_provinces b
                on a.prov_code = b.prov_code
                where a.foodforwork_id = "'.$foodforwork_id.'" and a.deleted = 0';
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;

    }
    public function get_brgy_foodforwork_id($foodforworkbrgy_id)
    {
        $sql = 'SELECT foodforwork_id,foodforwork_muni_id,no_of_bene_brgy FROM `tbl_food_brgy`
            where food_brgy_id = "'.$foodforworkbrgy_id.'" and deleted = 0';
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
    public function get_countbene_benelist($foodforworkbrgy_id)
    {
        $sql = 'SELECT count(bene_id) as countBene FROM `tbl_food_bene_list` where deleted = 0 and foodforwork_brgy_id = "'.$foodforworkbrgy_id.'";';
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
    public function get_project_prov_muni($foodforwork_muni_id)
    {
        $sql = 'select a.no_of_bene_muni,f.work_nature,e.region_name,a.foodforwork_id,a.food_muni_id,d.project_title,d.no_of_days,d.daily_payment,a.prov_code,b.prov_name,c.city_name,c.city_code
                from tbl_food_muni a
                inner join lib_provinces b
                on a.prov_code = b.prov_code
                inner join lib_municipality C
                on a.city_code = c.city_code
				inner join tbl_foodforwork d
				on a.foodforwork_id = d.foodforwork_id
                inner join lib_region e
                on d.region_code = e.region_code
                INNER JOIN lib_work_nature f
                ON d.nature_id = f.nature_id
                where a.food_muni_id = "'.$foodforwork_muni_id.'" and a.deleted = 0';
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
    public function get_project_muni_brgy($foodforwork_brgy_id)
    {
        $sql = 'select c.city_name,b.daily_payment,b.no_of_days,a.food_brgy_id,a.city_code,a.foodforwork_muni_id,a.brgy_code,a.no_of_bene_brgy,a.foodforwork_id
                from tbl_food_brgy a
                inner join tbl_foodforwork b
                on a.foodforwork_id = b.foodforwork_id
                inner join lib_municipality c
                on a.city_code = c.city_code
                where a.food_brgy_id = "'.$foodforwork_brgy_id.'" and a.deleted = 0 and b.deleted = 0';// for verification
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
    public function get_foodmuni_byid($foodforwork_muni_id = 0)
    {
        $query = $this->db->get_where('tbl_food_muni',array('food_muni_id'=>$foodforwork_muni_id));
        if ($query->num_rows() > 0){
            return $query->row();
        } else {
            return FALSE;
        }
        $this->db->close();
    }
    public function get_upload_filename($foodforwork_id)
    {
        $sql = 'select file_location from tbl_foodforwork where foodforwork_id = "'.$foodforwork_id.'" and deleted = 0' ;// for verification
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
//        $this->db->query('insert into tbl_foodforwork(assistance_id,saro_id,
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
        $this->db->query('insert into tbl_foodforwork(assistance_id,saa_id,fundsource_id,
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

    public function insertfoodmuni($myid,$foodforworkpass_id,$provlist,$munilist
        ,$daily_payment,$number_bene,$cost_of_assistance)
    {

        $this->db->trans_begin();
        $this->db->query('insert into tbl_food_muni(foodforwork_id,
                          prov_code,city_code,daily_payment,no_of_bene_muni,cost_of_assistance_muni,date_created,created_by,deleted)
                          values
                          ("'.$foodforworkpass_id.'","'.$provlist.'","'.$munilist.'",
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

    public function insertfoodbrgy($myid,$foodforworkpass_id,$food_muni_id_pass,$munilist ,$brgylist,$number_bene,$cost_of_assistance_brgy)
    {

        $this->db->trans_begin();
        $this->db->query('insert into tbl_food_brgy(foodforwork_muni_id,
                          foodforwork_id,city_code,brgy_code,no_of_bene_brgy,cost_of_assistance_brgy,date_created,created_by,deleted)
                          values
                          ("'.$food_muni_id_pass.'","'.$foodforworkpass_id.'","'.$munilist.'","'.$brgylist.'",
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
    public function insertBene($foodforwork_muni_idpass,$foodforwork_idpass,$bene_firstname,$bene_middlename,$bene_lastname,$bene_extname,$myid,$foodforwork_brgyidpass)
    {

        $this->db->trans_begin();
        $this->db->query('insert into tbl_food_bene_list(first_name,middle_name,last_name,ext_name,foodforwork_id,foodforwork_brgy_id,foodforwork_muni_id,date_created,created_by,deleted)
                          values
                          ("'.$bene_firstname.'","'.$bene_middlename.'","'.$bene_lastname.'","'.$bene_extname.'","'.$foodforwork_idpass.'","'.$foodforwork_brgyidpass.'","'.$foodforwork_muni_idpass.'",now(),"'.$myid.'","0")');

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
        $this->db->query('UPDATE tbl_food_muni SET
                              deleted ="1"
                              WHERE
                              foodforwork_id = "'.$foodforwork_id.'"
                              ');
        $this->db->query('UPDATE tbl_food_brgy SET
                              deleted ="1"
                              WHERE
                              foodforwork_id = "'.$foodforwork_id.'"
                              ');
        $this->db->query('UPDATE tbl_food_bene_list SET
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

    public function deletefood_muni_and_brgy($food_muni_id = 0)
    {
        $this->db->trans_begin();

        $this->db->query('UPDATE tbl_food_muni SET
                              deleted ="1"
                              WHERE
                              food_muni_id = "'.$food_muni_id.'"
                              ');
        $this->db->query('UPDATE tbl_food_brgy SET
                              deleted ="1"
                              WHERE
                              foodforwork_muni_id = "'.$food_muni_id.'"
                              ');
        $this->db->query('UPDATE tbl_food_bene_list SET
                              deleted ="1"
                              WHERE
                              foodforwork_muni_id = "'.$food_muni_id.'"
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
    public function deletefood_brgy($food_brgy_id = 0)
    {
        $this->db->trans_begin();

        $this->db->query('UPDATE tbl_food_brgy SET
                              deleted ="1"
                              WHERE
                              food_brgy_id = "'.$food_brgy_id.'"
                              ');
        $this->db->query('UPDATE tbl_food_bene_list SET
                              deleted ="1"
                              WHERE
                              foodforwork_brgy_id = "'.$food_brgy_id.'"
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

    public function updatefoodforwork($sarolist,$foodforwork_id1,$myid,$project_title,$regionlist,$provlist
        ,$natureofworklist,$number_days,$daily_payment,$number_of_bene,$cost_of_assistance){

        $this->db->trans_begin();

        $this->db->query('UPDATE tbl_foodforwork
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
                        foodforwork_id = "'.$foodforwork_id1.'"');
        $day_daily = $daily_payment * $number_days;
        $this->db->query('UPDATE tbl_food_muni
                        SET
                        cost_of_assistance_muni = no_of_bene_muni * "'.$day_daily.'",
                        modified_by = "'.$myid.'",
                        date_modified = now()
                        WHERE
                        foodforwork_id = "'.$foodforwork_id1.'"');
        $this->db->query('UPDATE tbl_food_brgy
                        SET
                        cost_of_assistance_brgy = no_of_bene_brgy * "'.$day_daily.'",
                        modified_by = "'.$myid.'",
                        date_modified = now()
                        WHERE
                        foodforwork_id = "'.$foodforwork_id1.'"');
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
    public function updatefoodforwork_muni($myid,$food_muni_id,$munilist,$number_of_bene
        ,$cost_of_assistance_muni){

        $this->db->trans_begin();

        $this->db->query('UPDATE tbl_food_muni
                        SET
                        city_code = "'.$munilist.'",
                        no_of_bene_muni = "'.$number_of_bene.'",
                        cost_of_assistance_muni = "'.$cost_of_assistance_muni.'",
                        modified_by = "'.$myid.'",
                        date_modified = now()
                        WHERE
                        food_muni_id = "'.$food_muni_id.'"');

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
    public function updatefoodforwork_brgy($food_brgy_id_pass,$myid,$brgylist,$number_of_bene
        ,$cost_of_assistance_brgy){

        $this->db->trans_begin();

        $this->db->query('UPDATE tbl_food_brgy
                        SET
                        brgy_code = "'.$brgylist.'",
                        no_of_bene_brgy = "'.$number_of_bene.'",
                        cost_of_assistance_brgy = "'.$cost_of_assistance_brgy.'",
                        modified_by = "'.$myid.'",
                        date_modified = now()
                        WHERE
                        food_brgy_id = "'.$food_brgy_id_pass.'"');

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
    public function uploadBenefile($myid,$file_name,$foodforwork_id){

        $this->db->trans_begin();

        $this->db->query('UPDATE tbl_foodforwork
                        SET
                        file_location = "'.$file_name.'",
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

    public function get_muni($prov_code,$foodforwork_id) {
        $city_qry = $this->db->query('SELECT city_code FROM `tbl_food_muni` where prov_code = "'.$prov_code.'" and foodforwork_id = "'.$foodforwork_id.'" and deleted = 0;');
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
    public function get_muni_edit($prov_code,$foodforwork_id,$city_code) {
        $city_qry = $this->db->query('SELECT city_code FROM `tbl_food_muni` where prov_code = "'.$prov_code.'" and foodforwork_id = "'.$foodforwork_id.'" and deleted = 0 and city_code != "'.$city_code.'";');
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

    public function get_brgy($city_code,$foodforwork_id) {
        $brgy_qry = $this->db->query('SELECT brgy_code FROM `tbl_food_brgy` where city_code = "'.$city_code.'" and foodforwork_id = "'.$foodforwork_id.'" and deleted = 0; ');
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

    public function get_brgy_edit($city_code,$foodforwork_id,$brgy_code) {
        $brgy_qry = $this->db->query('SELECT brgy_code FROM `tbl_food_brgy` where city_code = "'.$city_code.'" and foodforwork_id = "'.$foodforwork_id.'" and deleted = 0 and brgy_code != "'.$brgy_code.'";');
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
    public function getbenebyid($foodbene_id)
    {
        $query = $this->db->get_where('tbl_food_bene_list',array('bene_id'=>$foodbene_id));
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
    public function updatefoodbene($bene_idpass, $bene_firstname, $bene_middlename, $bene_lastname, $bene_extname, $myid)
    {
        $this->db->trans_begin();
        $this->db->query('UPDATE tbl_food_bene_list SET
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
    public function deletefoodBene($foodforwork_id,$foodbene_id)
    {
        $this->db->trans_begin();

        $this->db->query('UPDATE tbl_food_bene_list SET
                              deleted="1"
                              WHERE
                              bene_id = "'.$foodbene_id.'"
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