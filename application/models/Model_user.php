<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by JOSEF FRIEDRICH S. BALDO
 * Date Time: 10/17/15 10:27 PM
 */

class Model_user extends CI_Model {

    private $username;
    private $password;
    private $email;
    private $fullname;
    private $regionlist;

    protected function getUsername()
    {
        return $this->username;
    }

    protected function getFullname()
    {
        return $this->fullname;
    }

    protected function getEmail()
    {
        return $this->email;
    }

    protected function getRegion()
    {
        return $this->regionlist;
    }

    protected function getPassword()
    {
        return $this->password;
    }

    public function __construct($username = NULL,$password = NULL, $fullname = NULL, $email = NULL, $regionlist = NULL)
    {
        $this->username = $username;
        $this->password = $password;
        $this->fullname = $fullname;
        $this->email = $email;
        $this->regionlist = $regionlist;


    }

    public function registerUser()
    {

        $this->db->trans_begin();

        $this->db->query('INSERT INTO users(full_name,username,email,passwd,region_code) VALUES("'.$this->getFullname().'","'.$this->getUsername().'","'.$this->getEmail().'","'.$this->getPassword().'","'.$this->getRegion().'")');

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $queryResult = 0;
        }
        else
        {
            $this->db->trans_commit();
            $queryResult = 1;
        }
        return $queryResult;
    }

    public function changePassword($id,$password)
    {
        $this->db->trans_begin();

        $this->db->query('UPDATE users SET
                          passwd="'.$password.'"
                          WHERE
                          uid = "'.$id.'"
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

    public function ifUserExist()
    {
        $query = $this->db->get_where('users', array('username' => $this->getUsername(),'passwd' => $this->getPassword(), 'activated' => 1));
        return $query->num_rows();
    }

    public function retrieveUserData()
    {
        $query = $this->db->get_where('users', array('username' => $this->getUsername(),'passwd' => $this->getPassword()));
        return $query->row();
    }


}