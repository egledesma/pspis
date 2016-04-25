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

    public function InsertAssistance($assistance_name)
    {
        $this->db->trans_begin();
        $this->db->query('INSERT INTO lib_assistance_type(assistance_name,date_created,date_modified)
                          VALUES
                          (
                          "'.$assistance_name.'",
						  now(),
						  now()
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

    public function view_implementationbyproject($project_id = 0)
    {
        $query = $this->db->get_where('tbl_projectimplementation',array('project_id'=>$project_id));
        if ($query->num_rows() > 0){
            return $query->row();
        } else {
            return FALSE;
        }
        $this->db->close();
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