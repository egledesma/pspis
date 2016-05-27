<?php
//a
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class individual_model extends CI_Model
{

    public function get_crims($regionsaro)
    {
        $admin_db= $this->load->database('ADMINDB', TRUE);
        $sql = 'SELECT sum(a.AmountOfFinanceAssist) as Utilize,b.region_name,a.RegionAssist
FROM `crimsmonitoringreports` a
inner join lib_regions b
on a.RegionAssist = b.region_code
where a.RegionAssist >= 0 and a.RegionAssist = "'.$regionsaro.'"
GROUP BY a.RegionAssist';
        $query = $admin_db->query($sql);
        $result = $query->row();
        $admin_db->close();
        return $result;

    }
    public function get_aics_details($regionsaro)
    {
        $sql = 'SELECT b.saro_number,a.amount,a.region_code,a.date_utilized
FROM `tbl_aics_history` a
inner join tbl_saro b
on a.saro_number = b.saro_id
where a.deleted = 0 and a.region_code = "'.$regionsaro.'" and b.status = 0
order by a.aics_id asc';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
        $this->db->close();

    }

    public function get_last_utilized($regionsaro)
    {
        $sql = 'SELECT * FROM `tbl_aics_history` where region_code = "'.$regionsaro.'" order by aics_id desc limit 1';
        $query = $this->db->query($sql);
        if($query->num_rows() > 0) {

            $result = $query->row();
            return $result;
        }
        else
        {
            $result = 0;
            return $result;

        }

        $this->db->close();

    }
    public function insertAics($sarolist,$regionlist,$utilize,$utilizeddifference,$date_utilized,$myid)
    {

        $this->db->trans_begin();
        $this->db->query('insert into tbl_aics_history(saro_number,region_code,amount,date_utilized,date_created,created_by,deleted)
                          values
                          ("'.$sarolist.'","'.$regionlist.'","'.$utilize.'","'.$date_utilized.'",now(),"'.$myid.'","0")');

        $this->db->query('UPDATE tbl_saro SET
                              saro_funds_downloaded = "'.$utilizeddifference.'" + saro_funds_downloaded,
                              saro_funds_utilized = "'.$utilizeddifference.'" + saro_funds_utilized
                              WHERE
                              saro_id = "'.$sarolist.'"
                              ');
        $this->db->query('UPDATE tbl_funds_allocated SET
                              funds_downloaded ="'.$utilizeddifference.'" + funds_downloaded,
                              funds_utilized ="'.$utilizeddifference.'" + funds_utilized
                              WHERE
                              region_code = "'.$regionlist.'"
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
            id_province,
            prov_name
        FROM
          lib_province
        WHERE
          region_code = ?
        ORDER BY
          prov_name
        ";

        return $this->db->query($get_prov,$region_code)->result();
    }
    public function get_muni($id_province) {
        $get_muni = "
        SELECT
            id_municipality,
            city_name
        FROM
          lib_municipality
        WHERE
          prov_code = ?
        ORDER BY
          city_name
        ";

        return $this->db->query($get_muni,$id_province)->result();
    }
    public function get_brgy($id_municipality) {
        $get_brgy = "
        SELECT
            id_barangay,
            brgy_name
        FROM
          lib_barangay
        WHERE
          city_code = ?
        ORDER BY
          brgy_name
        ";

        return $this->db->query($get_brgy,$id_municipality)->result();
    }


}
?>