<?php
/**
 * Created by PhpStorm.
 * User: ljesaclayan
 * Date: 2/11/2016
 * Time: 3:17 PM
 */

class budget_model extends CI_Model
{
    public function record_count() { //pagination query1
        return $this->db->count_all("users");
    }


    public function get_assistance_type()
    {
        $sql = 'select * from lib_assistance_type where deleted ="0"';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;

    }

    public function insertBudget($project_id, $region_code, $first_tranche, $first_tranche_date)
    {
        $this->db->trans_begin();
        $this->db->query('INSERT INTO tbl_project_budget(project_id,region_code,first_tranche,first_tranche_date,first_tranche_status,date_created,created_by)
                          VALUES
                          (
                          "'.$project_id.'",
                          "'.$region_code.'",
                          "'.$first_tranche.'",
                          "'.$first_tranche_date.'",
                          0,
						  now(),
						  "'.$this->session->userdata('uid').'"
                          )');
        $this->db->query('UPDATE tbl_funds_allocated SET
                              funds_downloaded= funds_downloaded + "'.$first_tranche.'",
							  date_modified=now(),
							  modified_by="'.$this->session->userdata('uid').'"
                              WHERE
                              region_code = "'.$region_code.'"
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

    public function insertLiquidate($project_id, $region_code, $first_tranche, $first_tranche_date)
    {
        $this->db->trans_begin();
        $this->db->query('UPDATE tbl_project_budget SET
                              first_liquidate = "'.$first_tranche.'",
                              first_liquidate_date = "'.$first_tranche_date.'",
							  date_modified = now(),
							  modified_by="'.$this->session->userdata('uid').'"
                              WHERE
                              project_id = "'.$project_id.'"
                              ');
        $this->db->query('UPDATE tbl_funds_allocated SET
                              funds_utilized = funds_utilized + "'.$first_tranche.'",
							  date_modified=now(),
							  modified_by="'.$this->session->userdata('uid').'"
                              WHERE
                              region_code = "'.$region_code.'"
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

    public function get_implementation($implementation_id = 0)
    {
        $query = $this->db->get_where('tbl_project_implementation',array('implementation_id'=>$implementation_id));
        if ($query->num_rows() > 0){
            return $query->row();
        } else {
            return FALSE;
        }
        $this->db->close();
    }

    public function view_budgetbyproject($project_id = 0)
    {
        $sql = 'select * from tbl_project_budget
                where project_id ="'.$project_id.'"
               ';
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;

    }

    public function updateAssistance($aid, $assistance_name, $myid)
    {
        $this->db->trans_begin();
        $this->db->query('UPDATE lib_assistance_type SET
                              assistance_name="'.$assistance_name.'",
							  date_modified=now(),
							  modified_by="'.$myid.'"

                              WHERE
                              assistance_id = "'.$aid.'"
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




    public function deleteAssistance($aid = 0)
    {
        $this->db->trans_begin();

        $this->db->query('UPDATE lib_assistance_type SET
                              deleted="1"
                              WHERE
                              assistance_id = "'.$aid.'"
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