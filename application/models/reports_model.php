<?php
//a
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class reports_model extends CI_Model
{
    public function get_funds()
    {
        $sql = 'SELECT a.for_year,b.region_name,b.region_nick,
a.funds_allocated,a.funds_downloaded,a.funds_utilized
FROM `tbl_funds_allocated` a
INNER JOIN lib_region b
on a.region_code = b.region_code
WHERE a.deleted = 0;';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;

    }
//-----------------------------------------------------------------------------------------------
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