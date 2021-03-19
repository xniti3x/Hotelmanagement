<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * InvoicePlane
 *
 * @author		InvoicePlane Developers & Contributors
 * @copyright	Copyright (c) 2012 - 2018 InvoicePlane.com
 * @license		https://invoiceplane.com/license.txt
 * @link		https://invoiceplane.com
 */

/**
 * Class Mdl_Reservations
 */
class Mdl_Reservations extends Response_Model
{
    public $table = 'ip_reservations';
    public $primary_key = 'ip_reservations.id';


    public function getAll(){
        return $this->db->query("select id,title as name,start,end,room_id as resource,description as text from ip_reservations")->result();
    }
    public function getAllRooms(){
        return $this->db->get("ip_rooms")->result();
    }
}
