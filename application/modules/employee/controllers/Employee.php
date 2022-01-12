<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Employee extends Employee_Controller
{
    /**
     * Employee constructor.
     */
    public function __construct(){
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
        //change when dashboard exists
        redirect('employee/timesheet');
        $this->layout->buffer('content', 'employee/dashboard');
        $this->layout->render('layout_employee');
    }
    public function timesheet(){
        $this->layout->buffer('content', 'employee/timesheet');
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
        
        }else {$http_response->status=400; $http_response->message="ihr startdatum darf nicht leer sein und muss kleiner als das enddatum sein.";}
        echo json_encode($http_response);       
    }
    public function requestViewAdd($start){
        $this->layout->load_view('employee/add_modal',array("start"=>$start));
    }
    public function requestViewEdit($id){
        $this->layout->load_view('employee/edit_modal',array("timesheet"=>$this->mdl_employee->getTimesheetById($id)));
    }
    public function requestViewReport(){
        $this->layout->load_view('employee/report_modal');
    }
    public function deleteTimesheet($id){
        $http_response=(object)array();
        if($this->mdl_employee->deleteTimesheetById($id)){ $http_response->status=200; $http_response->message="Erfolgreich gelöscht.";}
        else {$http_response->status=400; $http_response->message="fehler beim löschen in der Datenbank.";}
        echo json_encode($http_response);
    }
    public function requestGenerate_pdf(){
        $http_response=(object)array();
        $dteStart = DateTime::createFromFormat("Y-m-d",$this->input->post("start"));
        $dteEnd = DateTime::createFromFormat("Y-m-d",$this->input->post("end"));
        if($dteStart==null || $dteEnd==null) {
            $http_response->status=400;
            $http_response->message="ihr startdatum darf nicht leer sein und muss kleiner als das enddatum sein.";
        }else if($dteStart<$dteEnd){
            $http_response->status=200;
            $http_response->message="Erfolgreich.";
        }else{
            $http_response->status=400;
            $http_response->message="ihr startdatum darf nicht leer sein und muss kleiner als das enddatum sein.";
        }
        echo json_encode($http_response);   
    }
    public function generate_pdf($start,$end){

        $user=($this->mdl_employee->getUserBy($this->session->userdata("user_id")));
        $employee=($this->mdl_employee->getAllTimesheetsBetweenDate($this->session->userdata("user_id"),$start,$end));
        $arr=array();
        foreach($employee as $e){
            array_push($arr,$e->duration);
        }
        $data=array("employee"=>$employee,
        "total"=>$this->calculateTime($arr),
        "start"=>$start,"end"=>$end,
        "tage" =>array("So", "Mo", "Di", "Mi", "Do", "Fr", "Sa"),
        "user" => $user
    );
    $html=$this->load->view('employee/timesheet_template', $data, true);
    $html;
    
    $mpdf = new \Mpdf\Mpdf([
        'mode' => 'utf-8',
        'format' => 'A4',
        'orientation' => '',
        'margin_left' => 0,
        'margin_right' => 0,
        ]);
    $mpdf->SetDisplayMode('fullpage');
        $header = array (
            'odd' => array (
                'L' => array (
                    'content' => 'Mitarbeiter: '.$user[0]->user_name,
                    'font-size' => 10,
                    'font-style' => 'B',
                    'font-family' => 'serif',
                    'color'=>'#000000'
                ),
                'C' => array (
                    'content' => 'Zeiterfassung: '.date('d-m-Y', strtotime($start))." bis ".date('d-m-Y', strtotime($end)),
                    'font-size' => 10,
                    'font-style' => 'B',
                    'font-family' => 'serif',
                    'color'=>'#000000'
                ),
                'R' => array (
                    'content' => 'Firma: '.$user[0]->user_company,
                    'font-size' => 10,
                    'font-style' => 'B',
                    'font-family' => 'serif',
                    'color'=>'#000000'
                ),
                'line' => 1,
            ),
            'even' => array ()
        );
        $footer = array (
            'odd' => array (
                'L' => array (
                    'content' => 'Unterschrift',
                    'font-size' => 12,
                    'font-style' => 'B',
                    'font-family' => 'serif',
                    'color'=>'#000000'
                ),
                'line' => 1,
            ),
            'even' => array ()
        );
        $mpdf->SetHeader($header);
        $mpdf->SetFooter($footer);
        
        $mpdf->WriteHTML($html);
        $mpdf->Output('TS_'.$user[0]->user_name."_".date('d', strtotime($start))."-".date('d-m-Y', strtotime($end)).".pdf", 'I');
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
    private function calculateTime($time) { 
        $sum = strtotime('00:00:00');
        $totaltime = 0;
        foreach( $time as $element ) {
            // Converting the time into seconds
            $timeinsec = strtotime($element) - $sum;
            // Sum the time with previous value
            $totaltime = $totaltime + $timeinsec;
        }
        // Totaltime is the summation of all
        // time in seconds 
        // Hours is obtained by dividing
        // totaltime with 3600
        $h = intval($totaltime / 3600);
        $totaltime = $totaltime - ($h * 3600);
        // Minutes is obtained by dividing
        // remaining total time with 60
        $m = intval($totaltime / 60);
        // Remaining value is seconds
        $s = $totaltime - ($m * 60);
        // return the result
        return (($h<10?"0".$h:$h).":".($m<10?"0".$m:$m).":".($s<10?"0".$s:$s));
    }
}