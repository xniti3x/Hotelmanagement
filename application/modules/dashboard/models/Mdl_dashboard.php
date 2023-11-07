<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_Dashboard extends Response_Model
{
    
    public function getMonthVisitors($start,$end){
        $query="SELECT count(`item_id`) as Visitors, sum(item_quantity) as Nights FROM `ip_invoice_items` WHERE item_date_start BETWEEN '".$start."' AND '".$end."';";
        return $this->db->query($query)->result();
    }

    public function getClientStatistic($start,$end){
        $query = $this->db->query("        SELECT ip_c.client_name, sum(ip_i_a.invoice_total) as invoice_total 
        FROM ip_invoices ip_i, ip_clients ip_c, ip_invoice_amounts ip_i_a
        WHERE ip_i.client_id=ip_c.client_id 
        AND ip_i.invoice_id=ip_i_a.invoice_id  
        AND ip_i.invoice_id=ip_i_a.invoice_id  
        AND ip_i.invoice_status_id=4 
        AND DATE(ip_i.invoice_date_created) between '".$start."' and '".$end."'
        group by ip_i.client_id
        ORDER by invoice_total desc limit 15");
        return $query->result();
    }

    public function getRoomStatistic($start,$end){
        $query = $this->db->query("
        SELECT item_room,sum(item_quantity*item_price) AS summe,sum(item_quantity) as nights  FROM `ip_invoice_items` 
        WHERE item_date_start >= '".$start."' and item_date_end <= '".$end."' GROUP by item_room order by summe desc;");
        return $query->result();
    }

    public function getExpenditure($start,$end){
        $query = $this->db->query("SELECT bookingDate,sum(transactionAmount) as 'transactionAmount',title
        FROM `ip_transactions`
        where transactionAmount < 0 and bookingDate >= '".$start."' and bookingDate <= '".$end."'
        group by iban order by transactionAmount limit 15");
        return $query->result();
    }
}