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

    public function getAllActiveRooms(){
        return $this->db->query("select * from ip_rooms where ip_rooms.active=1")->result();
    }
        
    /*
     * Get ip_room by id
     */
    function get_ip_room($id)
    {
        return $this->db->get_where('ip_rooms',array('id'=>$id))->row_array();
    }
        
    /*
     * function to add new ip_room
     */
    function add_ip_room($params)
    {
        $this->db->insert('ip_rooms',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update ip_room
     */
    function update_ip_room($id,$params)
    {
        $this->db->where('id',$id);
        return $this->db->update('ip_rooms',$params);
    }
    
    /*
     * function to delete ip_room
     */
    function delete_ip_room($id)
    {
        return $this->db->delete('ip_rooms',array('id'=>$id));
    }
    /*
     * Get all ip_rooms
     */
    function get_all_ip_rooms()
    {
        $this->db->order_by('id', 'Asc');
        return $this->db->get('ip_rooms')->result_array();
    }
}
