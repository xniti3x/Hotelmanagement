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
 * Class Products
 */
class Emails extends Admin_Controller
{
    /**
     * Products constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('banking/mdl_bank_api');
    }

    /**
     * @param int $page
     */
    public function index(){
        $this->layout->set("iframe_url",$this->db->query("Select * from ip_settings where setting_key='email_iframe_url';")->row());
        $this->layout->buffer('content', 'emails/index');
        $this->layout->render('layout');
    }

    public function auto_map(){
        $email_array=array(
            array(
                "email"=>"nicht.antworten@kundenservice.vodafone.com",
                "iban"=>"DE02590100660125799660",
                "regex" => "/[0-9]{11}/",
                "imap_folder" => "INBOX.unitymedia"
            ),
            array(
                "email"=>"rechnung@unitymedia.de",
                "iban"=>"DE02590100660125799660",
                "regex" => "/[0-9]{11}/",
                "imap_folder" => "INBOX.unitymedia"
            ),
            array(
                "email"=>"no-reply@rea-service.de",
                "iban"=>"DE86508501500000669547",
                "regex" => "/[0-9]{7}/",
                "imap_folder" => "INBOX.rea-card"
            ),
            array(
                "email"=>"noreply@alba.info",
                "iban"=>"DE50100400000190106500",
                "regex" => "/[0-9]{7}/",
                "imap_folder" => "INBOX.alba"
            )         
        );
        

        foreach($email_array as $email){        
        //download all the files (attachments) for every email
        $this->downloadAttachment($email);
    
            //after the files are downloaded, map the files to its transaction
            $files=$this->getAllFilenamesFromFolder($email["email"]);
            foreach($files as $filename){
                preg_match($email["regex"], $filename, $invoice_number);
                
                if(empty($invoice_number[0])){

                    $invoice_number[0]="-0-";
                } else{ echo $invoice_number[0]." - ".$email['email']."<br>";}
                $transaction=$this->mdl_bank_api->getTransactionByInvoiceDesc($email["iban"],$invoice_number[0]);
                
                if(isset($transaction["transactionId"])){
                    $transactionId=$transaction["transactionId"];
                 
                $array=array(
                    "file_type" =>"application/pdf",
                    "file_name" =>$filename,
                    "file_path" =>"/uploads/email_attachments/".$this->emailToFoldername($email["email"]),
                    "full_path" =>"/root/workspace/Hotelmanagement/uploads/email_attachments/".$this->emailToFoldername($email["email"])."/".$filename,
                    "raw_name" =>$filename,
                    "file_ext" =>".pdf",
                    "file_size" =>"0",	
                    "transactionId"=>$transactionId
                );
                    $this->mdl_bank_api->saveTransactionFile($array);
                }
            }
        }
    }

    private function downloadAttachment($email){
        $this->load->model("mdl_Settings");
        $srv = $this->mdl_Settings->get("imap_url").$email["imap_folder"];
        $usr = $this->mdl_Settings->get("imap_user");
        $pw = $this->mdl_Settings->get("imap_password");
        $inbox = imap_open($srv, $usr, $pw) or die('Cannot connect to Mailserver: ' . imap_last_error());//$boxes = imap_list($inbox, $srv, '*');
        $this->downloadAttachments($inbox,$email);
        imap_close($inbox);
    }
    private function downloadAttachments($inbox,$email){
        $emails = imap_search($inbox, 'FROM "'.$email["email"].'"');
        /* if any emails found, iterate through each email */
        if($emails) {

            /* put the newest emails on top */
            rsort($emails);

            /* for every email... */
            foreach($emails as $email_number) 
            { 
                //$message = imap_fetchbody($inbox,$email_number,2);

                /* get mail structure */
                $structure = imap_fetchstructure($inbox, $email_number);

                $attachments = array();

                /* if any attachments found... */
                if(isset($structure->parts) && count($structure->parts)) 
                {
                    for($i = 0; $i < count($structure->parts); $i++) 
                    {
                        $attachments[$i] = array(
                            'is_attachment' => false,
                            'filename' => '',
                            'name' => '',
                            'attachment' => ''
                        );

                        if($structure->parts[$i]->ifdparameters) 
                        {
                            foreach($structure->parts[$i]->dparameters as $object) 
                            {
                                if(strtolower($object->attribute) == 'filename') 
                                {
                                    $attachments[$i]['is_attachment'] = true;
                                    $attachments[$i]['filename'] = $object->value;
                                }
                            }
                        }

                        if($structure->parts[$i]->ifparameters) 
                        {
                            foreach($structure->parts[$i]->parameters as $object) 
                            {
                                if(strtolower($object->attribute) == 'name') 
                                {
                                    $attachments[$i]['is_attachment'] = true;
                                    $attachments[$i]['name'] = $object->value;
                                }
                            }
                        }

                        if($attachments[$i]['is_attachment']) 
                        {
                            $attachments[$i]['attachment'] = imap_fetchbody($inbox, $email_number, $i+1);

                            /* 3 = BASE64 encoding */
                            if($structure->parts[$i]->encoding == 3) 
                            { 
                                $attachments[$i]['attachment'] = base64_decode($attachments[$i]['attachment']);
                            }
                            /* 4 = QUOTED-PRINTABLE encoding */
                            elseif($structure->parts[$i]->encoding == 4) 
                            { 
                                $attachments[$i]['attachment'] = quoted_printable_decode($attachments[$i]['attachment']);
                            }
                        }
                    }
                }
                /* iterate through each attachment and save it */
                foreach($attachments as $attachment){
                    
                    if($attachment['is_attachment'] == 1){
                        $filename = $attachment['name'];
                        if(empty($filename)) $filename = $attachment['filename'];

                        if(empty($filename)) $filename = time() . ".dat";
                        if(!is_dir("./uploads/email_attachments"))
                        {
                            mkdir("./uploads/email_attachments");
                        }
                        $folder = $this->emailToFoldername($email["email"]);
                        if(!is_dir("./uploads/email_attachments/".$folder))
                        {
                            mkdir("./uploads/email_attachments/".$folder);
                            echo $folder;
                        }
                        $overview = imap_fetch_overview($inbox,$email_number,0);
                        $modFilename=$this->modifyFileNameBeforSave($email_number,$email,$filename,$overview);
                        $fp = fopen(str_replace(' ', '-', $modFilename), "w+");
                        fwrite($fp, $attachment['attachment']);
                        fclose($fp); 
                    }
                    log_message('info', 'Fetched files from email - '.$email["email"]);               
                }
            }
        } 
        redirect("banking/index");
    }
    private function modifyFileNameBeforSave($email_number,$email,$filename,$overview){
        $folder=$this->emailToFoldername($email["email"]);
        $str=$overview[0]->subject; //subject of the email
        if(strcmp($email["email"],"nicht.antworten@kundenservice.vodafone.com")==0){    
            preg_match($email["regex"], $str, $invoice_number);
            //return type will be diffrent on each
            return "./uploads/email_attachments/". $folder ."/". $email_number . "-". $invoice_number[0] ."-" . $filename;
        }else if(strcmp($email["email"],"noreplay@alba.info")==0){    
            preg_match($email["regex"], $str, $invoice_number);
            return "./uploads/email_attachments/". $folder ."/". $email_number . "-". $invoice_number[0] ."-" . $filename;
        }
        else{
            return "./uploads/email_attachments/". $folder ."/". $email_number . "-" . $filename;
        }
    }
    private function getAllFilenamesFromFolder($email){
        //print_r($email);
        $directory = './uploads/email_attachments/'.$this->emailToFoldername($email);
        $scanned_directory = array_diff(scandir($directory), array('..', '.'));
        return $scanned_directory;
    }
    private function emailToFoldername($email){
        return str_replace(array(".","@"),"-",$email);
    }

}
