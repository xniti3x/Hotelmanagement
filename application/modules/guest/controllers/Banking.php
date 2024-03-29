<?php
if (!defined('BASEPATH')) exit('No direct script access allowed'); 

class Banking extends Guest_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->model('banking/mdl_bank_api');
        $this->load->helper(array('form', 'url'));
        $this->load->library('api');
    }
    public function index($status='done',$ckey=null){//if(strcmp($ckey,$this->mdl_bank_api->getValue('ckey'))!=0) exit('No access allowed');
                
        switch ($status) {
            case 'all':
                $status="all";
                $transactions=$this->mdl_bank_api->getAllTransactions();
                break;
            case 'notdone':
                $transactions=$this->mdl_bank_api->getAllTransactionsNoFiles();
                break;
            case 'done':
                $transactions=$this->mdl_bank_api->getAllTransactionsWithFiles();
                break;
        }

        $this->layout->set("status",$status);
        $this->layout->set("transactions",$transactions);
        $this->layout->buffer('content', 'guest/transcation_index');
        $this->layout->render("layout_guest");
    }

    public function refreshTransactions($ckey){
        if(strcmp($ckey,$this->mdl_bank_api->getValue('ckey'))!=0) exit('No access allowed');
        $api = new Api();
        $transactions=$api->getAllTransactions($this->mdl_bank_api->getValue('access'),$this->mdl_bank_api->getValue('account_id'));
        if($transactions['code']==200) echo "update erfolgreich";
    }
    public function view($ckey,$id){if(strcmp($ckey,$this->mdl_bank_api->getValue('ckey'))!=0) exit('No access allowed');
        $transaction=$this->mdl_bank_api->getTransactionBy($id);
        $transfiles=$this->mdl_bank_api->getAllTransactionFiles($id);

        $this->layout->set("transaction",$transaction);
        $this->layout->set("transfiles",$transfiles);
        $this->layout->set("id",$id);
        $this->layout->buffer('content', 'guest/transaction_view');
        $this->layout->render('layout_guest');
    }
    public function do_api_upload($ckey,$id){if(strcmp($ckey,$this->mdl_bank_api->getValue('ckey'))!=0) exit('No access allowed');
        $config['upload_path']          = './uploads/';
        $config['allowed_types']        = '*';
        $config['max_size']             = 10024;
        $config['max_width']            = 0;
        $config['max_height']           = 0;
        $this->load->library('upload', $config);
       if ( ! $this->upload->do_upload('userfile'))
        {
            echo "upload failed";
        }
        else
        {    
            $data = $this->upload->data();
            $data['transactionId']=$id;
            $this->mdl_bank_api->saveTransactionFile($data);
            echo "upload successfull.";
        }       
    }
    public function do_upload($ckey,$id){if(strcmp($ckey,$this->mdl_bank_api->getValue('ckey'))!=0) exit('No access allowed');
        $config['upload_path']          = './uploads/';
        $config['allowed_types']        = 'gif|jpg|png|pdf';
        $config['max_size']             = 10024;
        $config['max_width']            = 0;
        $config['max_height']           = 0;

        $this->load->library('upload', $config);
       if ( ! $this->upload->do_upload('userfile'))
        {
            $this->session->set_flashdata('alert_error',$this->upload->display_errors());
            header("Location:".site_url("guest/banking/view/".$this->mdl_bank_api->getValue('ckey')."/".$id));
        }
        else
        {    
            $data = $this->upload->data();
            $data['transactionId']=$id;
            $this->mdl_bank_api->saveTransactionFile($data);
            $this->session->set_flashdata('alert_success', trans('record_successfully_updated'));
            header("Location:".site_url("guest/banking/index/".$this->mdl_bank_api->getValue('ckey')));
        }       
    }

    public function getAllMinusTransactions($ckey){
        if(strcmp($ckey,$this->mdl_bank_api->getValue('ckey'))!=0) exit('No direct script access allowed');
        header('Content-Type: application/json');        
        $data = $this->mdl_bank_api->getAllTransactionsNoFiles();
        echo json_encode($data);
    }

    public function do_weekly($ckey){
        if(strcmp($ckey,$this->mdl_bank_api->getValue('ckey'))!=0) exit('No direct script access allowed');
        $transactions=$this->mdl_bank_api->getAllTransactionsNoFiles();
        $body="";
        $sum=0;
        foreach($transactions as $transaction){
            
            
            if($transaction['transactionAmount']<0){ 
                $sum=$sum+$transaction['transactionAmount'];
                $color="red";
            $title=$transaction['title']."<b style='color:".$color.";'>".$transaction['transactionAmount']."€</b>";
            $body=$body.$title." <a class='btn btn-default btn-xs' href='".site_url('guest/banking/view/'.$this->mdl_bank_api->getValue('ckey').'/'.$transaction['transactionId'])."'> upload</a><br>";
            }
        }
        $body=$body."<br> summe: ".$sum." €";
        echo $body;
        $sub='=?UTF-8?B?' . base64_encode('Quittung hochladen Errinerung') . '?=';
        $this->sendEmail($this->mdl_bank_api->getValue('notificationEmails'),$sub,base64_encode($body));
        
    }

    private function sendEmail($to,$subject,$body){
        $this->load->model("mdl_Settings");
        $myEmail = $this->mdl_Settings->get("smtp_mail_from");
         $header = 
        'From: '.$myEmail . "\r\n" .
        'Reply-To: '.$myEmail . "\r\n" .
        'MIME-Version: 1.0' . "\r\n".
        'Content-Type: text/html; charset=utf-8'. "\r\n".
		'Content-Transfer-Encoding: base64' . "\r\n";
  
        return mail($to, $subject, $body, $header);
    }
}