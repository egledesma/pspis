<?php
/**
 * Created by PhpStorm.
 * User: mblejano
 * Date: 4/5/2016
 * Time: 2:42 PM
 */


class user_model extends CI_Model
{


    public function get_user()
    {
        $sql = 'select a.*, b.region_name, c.userlevelname from users a
                inner join lib_region b on a.region_code = b.region_code
                inner join userlevels c on a.access_level = c.userlevelid
               ';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function get_user_byid($uid = 0)
    {
        $sql = 'select a.*, b.region_name, c.userlevelname from users a
                inner join lib_region b on a.region_code = b.region_code
                inner join userlevels c on a.access_level = c.userlevelid
                where a.uid ="'.$uid.'"
               ';
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
        $this->db->close();
    }

    public function updateUser($user_id, $full_name, $username, $email,$regionlist,$status, $accesslevellist,$lockedstatus){

        $this->db->trans_begin();

        $this->db->query('UPDATE users
                        SET
                        full_name = "'.$full_name.'",
                        username = "'.$username.'",
                        email = "'.$email.'",
                        region_code = "'.$regionlist.'",
                        activated = "'.$status.'",
                        access_level = "'.$accesslevellist.'",
                        last_modified = now(),
                        last_modified_by = "'.$this->session->userdata('uid').'",
                        locked_status = "'.$lockedstatus.'"
                        WHERE
                        uid = "'.$user_id.'"');

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

    public function deactivateUser($uid = 0)
    {
        $this->db->trans_begin();

        $this->db->query('UPDATE users SET
                              activated ="0"
                              WHERE
                              uid = "'.$uid.'"
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

    public function activateUser($uid = 0)
    {
        $this->db->trans_begin();

        $this->db->query('UPDATE users SET
                              activated ="1"
                              WHERE
                              uid = "'.$uid.'"
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

    public function lockUser($uid = 0)
    {
        $this->db->trans_begin();

        $this->db->query('UPDATE users SET
                              locked_status ="Yes"
                              WHERE
                              uid = "'.$uid.'"
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

    public function unlockUser($uid = 0)
    {
        $this->db->trans_begin();

        $this->db->query('UPDATE users SET
                              locked_status ="No"
                              WHERE
                              uid = "'.$uid.'"
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

    public function get_access_level() {
        $get_access_level = "
        SELECT
          userlevelid,
          userlevelname
        FROM
          userlevels
        ";

        return $this->db->query($get_access_level)->result();
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

}