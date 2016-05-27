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