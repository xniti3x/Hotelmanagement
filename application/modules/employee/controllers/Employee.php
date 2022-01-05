<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Employee extends Employee_Controller
{
    public function index(){
        $this->load->model('mdl_employee');
        $timesheet=$this->mdl_employee->getAllTimesheets();
        $this->layout->set(
            array(
                'timesheets' => $timesheet,
            )
        );
        
        $this->layout->buffer('content', 'employee/dashboard');
        $this->layout->render('layout_employee');
    }
    public function timesheet(){
        $this->load->model('mdl_employee');
        $timesheet=$this->mdl_employee->getAllTimesheets();
        $this->layout->set(
            array(
                'timesheets' => $timesheet,
            )
        );
        $this->layout->buffer('content', 'employee/timesheet');
        $this->layout->render('layout_employee');
    }
    public function timesheetEdit(){
        $this->layout->buffer('content', 'employee/add_modal');
        $this->layout->render('layout_employee');
    }
    public function loadTimesheetEvents(){
        $this->load->model('mdl_employee');
        $timesheet=$this->mdl_employee->getAllTimesheets();
        $array=[];
        foreach($timesheet as $time){//2019-09-05T09:00:00
            $array[]=array("id"=>$time->id,"title"=>$time->notes,"start"=>$time->day."T".$time->start,"end"=>$time->day."T".$time->end);
        }
        echo json_encode($array);
    }
    public function addTimesheet(){
        $this->load->model('mdl_employee');
        $dteStart = new DateTime($this->input->post("start"));
        $dteEnd   = new DateTime($this->input->post("end"));
        $duration=$dteStart->diff($dteEnd)->format("%H:%I:%S");
        $db_array=array(
            "day"=>$this->input->post("day"),
            "start"=>$this->input->post("start"),
            "end"=>$this->input->post("end"),
            "duration"=>$duration,
            "notes"=>$this->input->post("notes"),
            "user_id"=>$this->session->userdata('user_id'),
        );
        if($this->mdl_employee->saveTimesheet($db_array)) echo "200";
        else echo "404";
    }
    public function editTimesheet($id){
        $this->load->model('mdl_employee');
        $dteStart = new DateTime($this->input->post("start"));
        $dteEnd   = new DateTime($this->input->post("end"));
        $duration=$dteStart->diff($dteEnd)->format("%H:%I:%S");
        $db_array=array(
            "day"=>$this->input->post("day"),
            "start"=>$this->input->post("start"),
            "end"=>$this->input->post("end"),
            "duration"=>$duration,
            "notes"=>$this->input->post("notes"),
        );

        if($this->mdl_employee->updateTimesheet($db_array,$id)) echo "200"; 
        else echo "404";        
    }
    public function requestViewAdd($start){
        $this->layout->load_view('employee/add_modal',array("start"=>$start));
    }
    public function requestViewEdit($id){
        $this->load->model('mdl_employee');
        $this->layout->load_view('employee/edit_modal',array("timesheet"=>$this->mdl_employee->getTimesheetById($id)));
    }
    public function deleteTimesheet($id){
        $this->load->model('mdl_employee');
        if($this->mdl_employee->deleteTimesheetById($id)) echo "200";
    }
}