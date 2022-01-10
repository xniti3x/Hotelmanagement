<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Employee extends Employee_Controller
{
    /**
     * Employee constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mdl_employee');
    }

    public function index(){
        $timesheet=$this->mdl_employee->getAllTimesheets($this->session->userdata("user_id"));
        $this->layout->set(
            array(
                'timesheets' => $timesheet,
            )
        );
        
        $this->layout->buffer('content', 'employee/dashboard');
        $this->layout->render('layout_employee');
    }
    public function timesheet(){
        $this->layout->buffer('content', 'employee/timesheet');
        $this->layout->render('layout_employee');
    }
    public function timesheetEdit(){
        $this->layout->buffer('content', 'employee/add_modal');
        $this->layout->render('layout_employee');
    }
    public function loadTimesheetEvents(){
        $timesheet=$this->mdl_employee->getAllTimesheets($this->session->userdata('user_id'));
        $array=[];
        foreach($timesheet as $time){//2019-09-05T09:00:00
            $array[]=array("id"=>$time->id,"title"=>$time->notes,"start"=>$time->day."T".$time->start,"end"=>$time->day."T".$time->end);
        }
        echo json_encode($array);
    }
    public function addTimesheet(){
        
        $http_response=(object)array();

        $dteStart = DateTime::createFromFormat("H:i",$this->customTimeFormat($this->input->post("start")));
        $dteEnd   = DateTime::createFromFormat("H:i",$this->customTimeFormat($this->input->post("end")));
        if($dteStart < $dteEnd){ 
        $db_array=array(
            "day"=>$this->input->post("day"),
            "start"=>$this->input->post("start"),
            "end"=>$this->input->post("end"),
            "duration"=>$dteStart->diff($dteEnd)->format("%H:%I"),
            "notes"=>$this->input->post("notes"),
            "user_id"=>$this->session->userdata('user_id'),
        );
            if($this->mdl_employee->saveTimesheet($db_array)){ $http_response->status=200; $http_response->message="Erfolgreich.";} 
            else {$http_response->status=400; $http_response->message="fehler beim schpeichern in der Datenbank.";}
        
        }else {$http_response->status=400; $http_response->message="ihr startdatum darf nicht leer sein und muss kleiner als das enddatum sein.";}
        echo json_encode($http_response);
    }
    public function editTimesheet($id){
        $http_response=(object)array();
        $dteStart = DateTime::createFromFormat("H:i",$this->customTimeFormat($this->input->post("start")));
        $dteEnd   = DateTime::createFromFormat("H:i",$this->customTimeFormat($this->input->post("end")));
        if($dteStart < $dteEnd ){ 
        $db_array=array(
            "day"=>$this->input->post("day"),
            "start"=>$this->input->post("start"),
            "end"=>$this->input->post("end"),
            "duration"=>$dteStart->diff($dteEnd)->format("%H:%I"),
            "notes"=>$this->input->post("notes"),
            "user_id"=>$this->session->userdata('user_id'),
        );
            if($this->mdl_employee->updateTimesheet($db_array,$id)) {$http_response->status=200; $http_response->message="Erfolgreich geändert.";} 
            else {$http_response->status=400; $http_response->message="fehler beim schpeichern in der Datenbank.";} 
        
        }else {$http_response->status=400; $http_response->message="ihr startdatum darf nicht leer sein und muss kleiner als das enddatum sein. ";}
        echo json_encode($http_response);       
    }
    public function requestViewAdd($start){
        $this->layout->load_view('employee/add_modal',array("start"=>$start));
    }
    public function requestViewEdit($id){
        $this->layout->load_view('employee/edit_modal',array("timesheet"=>$this->mdl_employee->getTimesheetById($id)));
    }
    public function deleteTimesheet($id){
        $http_response=(object)array();
        if($this->mdl_employee->deleteTimesheetById($id)==true){ $http_response->status=200; $http_response->message="Erfolgreich gelöscht.";}
        else {$http_response->status=400; $http_response->message="fehler beim löschen in der Datenbank.";}
        echo json_encode($http_response);
    }

    public function generate_pdf(){
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->Bookmark('Start of the document');
        $data=array("start"=>"hallo");
        $html=$this->load->view('employee/timesheet_template', $data, true);
        
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }

    /**
     *  custom time format h:i, cuting seconds.
     */
    private function customTimeFormat($strTime){
        $strLength=strlen($strTime);
        if($strLength>5) {
           return substr($strTime,0, -($strLength-5));
        }else if($strLength<5) {
            return null;
        }else {return $strTime;} 

    }
}