<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_Employee extends Response_Model
{

    public function getAllTimesheets($user_id){
        return $this->db->query('Select * from ip_timesheet where user_id='.$user_id)->result();
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
        $this->db->delete('ip_timesheet', array('id' => $id)); 
    }
}
