<?php
/**
 * Created by PhpStorm.
 * User: ljesaclayan
 * Date: 2/11/2016
 * Time: 3:17 PM
 */

class implementation_model extends CI_Model
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

    public function insertImplementation($project_id, $start_date, $target_date, $project_status)
    {
        $this->db->trans_begin();
        $this->db->query('INSERT INTO tbl_project_implementation(project_id,start_date,target_date,project_status,date_created,created_by, deleted)
                          VALUES
                          (
                          "'.$project_id.'",
                          "'.$start_date.'",
                          "'.$target_date.'",
                          "'.$project_status.'",
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

    public function view_implementationbyproject($project_id = 0)
    {
        $sql = 'select * from tbl_project_implementation
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
    public function updateImplementation($implementation_id,$start_date, $target_date, $project_status)
    {
        $this->db->trans_begin();
        $this->db->query('update tbl_project_implementation
                          set
                          start_date ="'.$start_date.'",
                          target_date = "'.$target_date.'", project_status = "'.$project_status.'",date_modefied = NOW()
                          where implementation_id = "'.$implementation_id.'";');

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