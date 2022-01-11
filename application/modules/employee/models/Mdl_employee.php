<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_Employee extends Response_Model
{

    public function getAllTimesheets($user_id){
        return $this->db->query('Select * from ip_timesheet where user_id='.$user_id)->result();
    }
    public function getAllTimesheetsBetweenDate($user_id,$start,$end){
        return $this->db->query('Select * from ip_timesheet where user_id='.$user_id.' AND day BETWEEN "'.$start.'" AND "'.$end.'" order by day')->result();
    }
    public function saveTimesheet($db_array){
        return $this->db->insert('ip_timesheet', $db_array);
    }
    public function updateTimesheet($db_array,$id){
        $this->db->set($db_array);
        $this->db->where("id", $id);
        return $this->db->update('ip_timesheet');
    }
    public function getTimesheetById($id){
        return $this->db->query('Select * from ip_timesheet where id='.$id)->result();
    }
    public function deleteTimesheetById($id){
        return $this->db->delete('ip_timesheet', array('id' => $id)); 
    }
    
    public function getUserBy($id){
        return $this->db->query('select * from ip_users where user_id='.$id)->result(); 
    } 
}
