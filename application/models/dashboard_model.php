<?php
/**
 * Created by PhpStorm.
 * User: Mblejano
 * Date: 4/26/2016
 * Time: 2:57 PM
 */


class dashboard_model extends CI_Model
{

    public function fundsAllocUtil(){

        $sql = 'select b.region_name,a.funds_allocated,a.funds_obligated,(a.funds_obligated/a.funds_allocated)*100 as Status,(a.funds_allocated - a.funds_obligated) as RemainingBudget
                from tbl_funds_allocated a
                inner join lib_region b
                on b.region_code = a.region_code
                where a.deleted  = 0
                GROUP BY a.region_code;
        ';
        $query = $this->db->query($sql);
        return  $query->result_array();
    }
    public function grandTotal(){

        $sql = 'select sum(funds_allocated) as saro,sum(funds_utilized) as utilized ,sum(remaining_budget) as balance
from tbl_funds_allocated
where deleted  = 0;';
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
}