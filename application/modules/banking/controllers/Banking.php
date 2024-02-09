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
 * Class Clients
 */
class Banking extends Admin_Controller
{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->library('api');
        $this->load->model('mdl_bank_api');
        $this->load->helper(array('form', 'url'));
    }

    public function login(){    
        $api = new Api();
        $response=$api->requstNewToken($this->mdl_bank_api->getValue("secret_id"),$this->mdl_bank_api->getValue("secret_key"));

        if($response["code"]==200){            
            $this->mdl_bank_api->setValue("access",$response['result']['access']);
            $this->mdl_bank_api->setValue("access_expires",$response['result']['access_expires']);
            $this->mdl_bank_api->setValue("refresh",$response['result']['refresh']);
            $this->mdl_bank_api->setValue("refresh_expires",$response['result']['refresh_expires']);
            echo "token update erfolgreich";
        }
    }

    public function showBankInstitution($c='DE'){
        $api = new Api();
        $response=$api->requestAllInstituts($this->mdl_bank_api->getValue("access"),$c);
        echo "<pre>";print_r($response);

    }
    
    public function contactInstitution(){
        $api = new Api();
        $response=$api->requestInstitut($this->mdl_bank_api->getValue("access"),$this->mdl_bank_api->getValue("institution_id"),"http://www.google.de");
        $this->mdl_bank_api->setValue("reference",$response['result']['reference']);
        echo "<pre>";print_r($response);
    }
    
    public function listAcc(){
        $api = new Api();
        $response=$api->listAccounts($this->mdl_bank_api->getValue("access"),$this->mdl_bank_api->getValue("reference"));
        $this->mdl_bank_api->setValue("account_id",$response['result']['accounts'][0]);
        echo "<pre>";print_r($response);
    }

    public function transactions($ui=true){
        $api = new Api();
        $transactions=$api->getAllTransactions($this->mdl_bank_api->getValue('access'),$this->mdl_bank_api->getValue('account_id'));
        if($transactions["code"]==200){
            $transactions=($transactions["result"]["transactions"]["booked"]);
            $last_transactions=$this->mdl_bank_api->getAllTransactions();
            $update=true;
            foreach($transactions as $item){
                $insert=true;
                foreach($last_transactions as $db_item){
                    if(strcmp($item["transactionId"],$db_item["transactionId"])==0){
                        $insert=false;
                        break;
                    }
                }
                if($insert && $ui) {
                    $update=false;
                    echo "<pre>";
                    print_r($item);
                    $this->mdl_bank_api->saveTransaction($item);
                }
            }
            if($update) {
                $this->session->set_flashdata('alert_success', trans('record_successfully_updated'));
            }
            echo $ui?"<a href='".site_url("banking/index")."'>index</a>":"";
        }else if($transactions["code"]==401){
            $this->login();
            $this->transactions();
        }else{
            print_r($transactions);
            echo "vermutlich ist ihr kontozugriff abgelaufen führen sie den registrierungsprozess erneut aus.";
        }
    }

    public function save($transactionId){
        $item=$this->mdl_bank_api->getTransactionBy($transactionId);
        $this->mdl_bank_api->saveTransactionFilter($item);
        
        $this->session->set_flashdata('alert_success', trans('record_successfully_updated'));
        header("Location:".site_url("banking/view/".$transactionId));
    }
    public function refresh(){
        $api = new Api();
        $response=$api->refreshToken($this->mdl_bank_api->getValue("refresh"));
        if($response["code"]==200){            
            $this->mdl_bank_api->setValue("access",$response['result']['access']);
            $this->mdl_bank_api->setValue("access_expires",$response['result']['access_expires']);
            echo "token refresh erfolgreich";
        }
    }

    public function index($status = 'all'){
        $this->transactions(false);
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
            case 'filter':
                $transactions=$this->mdl_bank_api->getAllFiltredTransactions();
                break;
            }

        $this->layout->set("status",$status);
        $this->layout->set("transactions",$transactions);
        
        $this->layout->buffer('content', 'banking/index');
        $this->layout->render();
    }

    public function view($id){
        
        $transaction = $this->mdl_bank_api->getTransactionBy($id);
        $ip_document_correspondent=$this->mdl_bank_api->getCorrespondentByIban($transaction["iban"]);

        if(isset($_POST['correspondent_id']) && count($_POST) > 0){ //form submit onchange select option  

            $data = array(
                'correspondent_id' => $this->input->post("correspondent_id"),
                'iban' => $transaction["iban"]
            );
            $DB2 = $this->load->database('paperless', TRUE);
            
            if(empty($ip_document_correspondent)){
                $DB2->insert('documents_bank_correspondent', $data);
            }else{
                $DB2->where('id', $ip_document_correspondent['id']);
                $DB2->update('documents_bank_correspondent', $data);
            }         
        }

        $ip_document_correspondent=$this->mdl_bank_api->getCorrespondentByIban($transaction["iban"]);
        $correspondent=$this->mdl_bank_api->getCorrespondentByIban($transaction['iban']);
        $correspondents=$this->mdl_bank_api->getAllCorrespondents();
        $documentsNoTransaction=[];
        $documentsWithFile=[];
        
        if(!empty($correspondent)){
            $documentsNoTransaction=$this->mdl_bank_api->getAllDocumentsNoTransactionBy($correspondent['correspondent_id']);
            $documentsWithFile=$this->mdl_bank_api->getAllDocumentsWithTransactionBy($transaction['transactionId']);
        }

        $found_documents=[];

        if(isset($_POST['search']) && count($_POST) > 0){ //form submit search query
            foreach($documentsNoTransaction as $doc){
                
                $foundKomaPrice=strpos(strtolower($doc->content), str_replace(".",",",substr($transaction["transactionAmount"],1)));
                $foundDotPrice = strpos(strtolower($doc->content), substr($transaction["transactionAmount"],1));
                $foundSearchQuery=strpos(strtolower($doc->content), $_POST['search']);
                
                if(($foundKomaPrice || $foundDotPrice) && $foundSearchQuery ){
                        array_push($found_documents,$doc);
                }
            }         
        }else{
            foreach($documentsNoTransaction as $doc){                
              
                $foundKomaPrice=strpos(strtolower($doc->content), str_replace(".",",",substr($transaction["transactionAmount"],1)));
                $foundDotPrice = strpos(strtolower($doc->content), substr($transaction["transactionAmount"],1));
                
                if(($foundKomaPrice || $foundDotPrice) ){
                        array_push($found_documents,$doc);
                }
            }   
        }

        $this->layout->set("correspondent",$correspondent);
        $this->layout->set("correspondents",$correspondents);
        $this->layout->set("transaction",$transaction);
        $this->layout->set("documentsNoTransaction",$documentsNoTransaction);
        $this->layout->set("documentsWithFile",$documentsWithFile);
        $this->layout->set("transfiles",$this->mdl_bank_api->getAllTransactionFiles($id));
        $this->layout->set("selected_correspondent",$ip_document_correspondent);
        $this->layout->set("found_documents",$found_documents);
        $this->layout->set("id",$id);

        $this->layout->buffer('content', 'banking/view');
        $this->layout->render();
    }

    public function addDocument($document_id,$transaction_id){
        $DB2 = $this->load->database('paperless', TRUE);
        $document=$DB2->query("select * from documents_document where id=".$document_id)->row_array();

        $this->mdl_bank_api->saveTransactionFile(array(
            "file_name" =>$document["filename"],
            "file_type"=>$document["document_type_id"],
            "file_path"=>$document["archive_filename"],
            "full_path"=>$document["original_filename"],
            "raw_name"=>$document["title"],
            "file_ext"=>$document["mime_type"],
            "file_size"=>0,	
            "transactionId"=>$transaction_id
        ));
        header("Location:".site_url("banking/view/".$transaction_id));
    }

    public function remove($id,$transactionId){
        $this->mdl_bank_api->deleteDocumentRelation($id);
        header("Location:".site_url("banking/view/".$transactionId));
    }

    public function delete($id,$transactionId){
        $this->mdl_bank_api->deleteTransactionFile($id);
        header("Location:".site_url("banking/view/".$transactionId));
    }

    public function do_upload($id){
        $config['upload_path']          = './uploads/';
        $config['allowed_types']        = 'gif|jpg|png|pdf';
        $config['max_size']             = 10024;
        $config['max_width']            = 0;
        $config['max_height']           = 0;

        $this->load->library('upload', $config);
       if ( ! $this->upload->do_upload('userfile'))
        {
            $this->session->set_flashdata('alert_error',$this->upload->display_errors());
            header("Location:".site_url("banking/view/".$id));
        }
        else
        {// Array ( [upload_data] => Array ( [file_name] => 2020-mu2ff7in12.pdf [file_type] => application/pdf [file_path] => /root/workspace/Hotelmanagement/uploads/ [full_path] => /root/workspace/Hotelmanagement/uploads/2020-mu2ff7in12.pdf [raw_name] => 2020-mu2ff7in12 [orig_name] => 2020-mu2ff7in.pdf [client_name] => 2020-mu2ff7in.pdf [file_ext] => .pdf [file_size] => 53.1 [is_image] => [image_width] => [image_height] => [image_type] => [image_size_str] => ) )
             
            $data = $this->upload->data();
            $data['transactionId']=$id;
            $this->mdl_bank_api->saveTransactionFile($data);
            $this->session->set_flashdata('alert_success', trans('record_successfully_updated'));
            header("Location:".site_url("banking/index/all"));
        }       
    }

}
