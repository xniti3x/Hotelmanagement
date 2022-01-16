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
class Mdl_Rooms extends Response_Model
{
    public $table = 'ip_rooms';
    public $primary_key = 'ip_rooms.id';

    public function getAllRooms(){
        return $this->db->query("select * from ip_rooms where ip_rooms.active=1")->result();
    }
}
