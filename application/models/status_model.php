<?php
/**
 * Created by PhpStorm.
 * User: ljesaclayan
 * Date: 2/11/2016
 * Time: 3:17 PM
 */

class status_model extends CI_Model
{
    public function record_count() { //pagination query1
        return $this->db->count_all("users");
    }


    public function get_status()
    {
        $sql = 'select * from lib_status where deleted ="0"';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;

    }

    public function InsertSourcefund($fund_source,$myid)
    {
        $this->db->trans_begin();
        $this->db->query('INSERT INTO lib_fund_source(fund_source,date_created,created_by,date_modified,modified_by)
                          VALUES
                          (
                          "'.$fund_source.'",
						  now(),
						  "'.$myid.'",
						  now(),
						  "'.$myid.'"
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

    public function getfundsourceid($sid = 0)
    {
        $query = $this->db->get_where('lib_fund_source',array('fundsource_id'=>$sid));
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

    public function updateAssistance($sid, $fund_source, $myid)
    {
        $this->db->trans_begin();
        $this->db->query('UPDATE lib_fund_source SET
                              fund_source="'.$fund_source.'",
							  date_modified=now(),
							  modified_by="'.$myid.'"

                              WHERE
                              fundsource_id = "'.$sid.'"
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




    public function deleteFundsource($sid = 0)
    {
        $this->db->trans_begin();

        $this->db->query('UPDATE lib_fund_source SET
                              deleted="1"
                              WHERE
                              fundsource_id = "'.$sid.'"
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