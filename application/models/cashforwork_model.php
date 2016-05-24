<?php
/**
 * Created by PhpStorm.
 * User: mblejano
 * Date: 4/5/2016
 * Time: 2:42 PM
 */


class cashforwork_model extends CI_Model
{

    public function viewcashforwork($cashforwork_id)
    {

        $sql = 'SELECT a.cashforwork_id,d.saro_number,a.project_title,b.region_name,c.prov_name,e.work_nature,a.no_of_days,a.daily_payment,sum(f.cost_of_assistance_muni) as total_cost,sum(f.no_of_bene_muni) as total_bene
FROM `tbl_cashforwork` a
inner join lib_region b
on a.region_code = b.region_code
inner join lib_provinces c
on a.prov_code = c.prov_code
inner join tbl_saro d
on a.saro_id = d.saro_id
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

        $sql = 'SELECT a.city_code,b.brgy_name
FROM `tbl_cash_brgy` a
inner join lib_brgy b
on a.brgy_code = b.brgy_code
where a.deleted = 0 and a.cashforwork_id = "'.$cashforwork_id.'"';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;

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

    public function finalize($cashforwork_id)
    {

        $sql = 'select a.saro_id,sum(b.cost_of_assistance_muni) total_cost
                                    from tbl_cashforwork a
                                    inner join tbl_cash_muni b
                                    on a.cashforwork_id = b.cashforwork_id
                                    where a.deleted = 0 and a.cashforwork_id = "'.$cashforwork_id.'"';
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;

    }
    public function finalize_update($total_cost,$saro_id,$regionsaro)
    {
        $this->db->trans_begin();

        $this->db->query('UPDATE tbl_saro SET
                              saro_funds_downloaded ="'.$total_cost.'" + saro_funds_downloaded
                              saro_funds_utilized = "'.$total_cost.'" + saro_funds_utilized
                              WHERE
                              saro_id = "'.$saro_id.'"
                              ');
        $this->db->query('UPDATE tbl_funds_allocated SET
                              funds_downloaded ="'.$total_cost.'" + funds_downloaded
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
        $sql = 'SELECT g.saro_number,a.cashforwork_id,a.project_title,a.region_code,b.region_name,c.work_nature,a.no_of_days,sum(d.no_of_bene_muni) as total_bene, sum(d.cost_of_assistance_muni) as total_cost
                FROM `tbl_cashforwork` a
                INNER JOIN lib_region b
                on a.region_code = b.region_code
                INNER JOIN lib_work_nature c
                on a.nature_id = c.nature_id
                inner join tbl_cash_muni d
                on d.cashforwork_id = a.cashforwork_id
                inner join tbl_saro g
                on a.saro_id = g.saro_id
                where a.deleted = 0 and d.deleted = 0 and a.region_code = '.$region_code.'
                GROUP BY a.cashforwork_id
               ';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;

    }

    public function get_cashforworkDetails($cashforwork_id)
    {
        $sql = 'SELECT a.project_title, b.region_name,c.work_nature,a.no_of_days,a.daily_payment
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
        $sql = 'select a.cashforwork_brgy_id,a.bene_id,a.bene_fullname,a.cashforwork_id from tbl_cash_bene_list a
        where a.deleted = 0 and a.cashforwork_brgy_id = "'.$cashforwork_id.'"';
        $query = $this->db->query($sql);
        $result = $query->result();
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
        $sql = 'select a.no_of_days,a.project_title,a.daily_payment,a.saro_id from tbl_cashforwork a
                where a.cashforwork_id = "'.$cashforwork_id.'" and a.deleted = 0';
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;

    }

    public function get_cashbrgy_list($cashforwork_id)
    {
        $sql = 'SELECT a.file_location,a.cash_brgy_id,a.no_of_bene_brgy,a.cost_of_assistance_brgy,b.brgy_name FROM `tbl_cash_brgy` a
                inner join lib_brgy b
                on a.brgy_code = b.brgy_code
                where a.cashforwork_muni_id = "'.$cashforwork_id.'" and a.deleted = 0';
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
    public function get_brgy_cashforwork_id($cashforworkbrgy_id)
    {
        $sql = 'SELECT cashforwork_id,cashforwork_muni_id FROM `tbl_cash_brgy`
            where cash_brgy_id = "'.$cashforworkbrgy_id.'" and deleted = 0';
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

    public function get_project_muni_brgy($cashforwork_brgy_id)
    {
        $sql = 'select c.city_name,b.daily_payment,b.no_of_days,a.cash_brgy_id,a.city_code,a.cashforwork_muni_id,a.brgy_code,a.no_of_bene_brgy
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
    public function get_upload_filename($cashforwork_brgy)
    {
        $sql = 'select file_location from tbl_cash_brgy where cash_brgy_id = "'.$cashforwork_brgy.'" and deleted = 0' ;// for verification
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
    public function insertProject($saro,$myid,$project_title,$regionlist,$provlist
        ,$natureofworklist,$daily_payment,$number_days)
    {

        $this->db->trans_begin();
        $this->db->query('insert into tbl_cashforwork(assistance_id,saro_id,
                          project_title,region_code,prov_code,nature_id,daily_payment,no_of_days,date_created,created_by,deleted)
                          values
                          ("2","'.$saro.'","'.$project_title.'","'.$regionlist.'",
                          "'.$provlist.'","'.$natureofworklist.'",
                          "'.$daily_payment.'",
                          "'.$number_days.'",now(),"'.$myid.'","0")');

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
    public function insertBene($cashforwork_idpass,$bene_fullname,$myid,$cashforwork_brgyidpass)
    {

        $this->db->trans_begin();
        $this->db->query('insert into tbl_cash_bene_list(bene_fullname,cashforwork_id,cashforwork_brgy_id,date_created,created_by,deleted)
                          values
                          ("'.$bene_fullname.'","'.$cashforwork_idpass.'","'.$cashforwork_brgyidpass.'",now(),"'.$myid.'","0")');

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
        ,$natureofworklist,$number_days,$daily_payment){

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
    public function uploadBenefile($myid,$file_name,$cashforwork_brgy_id){

        $this->db->trans_begin();

        $this->db->query('UPDATE tbl_cash_brgy
                        SET
                        file_location = "'.$file_name.'",
                        modified_by = "'.$myid.'",
                        date_modified = now()
                        WHERE
                        cash_brgy_id = "'.$cashforwork_brgy_id.'"');

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
    public function updateCashbene($bene_idpass, $fullname, $myid)
    {
        $this->db->trans_begin();
        $this->db->query('UPDATE tbl_cash_bene_list SET
                              bene_fullname ="'.$fullname.'",
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