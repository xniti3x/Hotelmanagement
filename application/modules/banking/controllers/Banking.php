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

    public function transactions(){
        $api = new Api();
        $transactions=$api->getAllTransactions($this->mdl_bank_api->getValue('access'),$this->mdl_bank_api->getValue('account_id'));
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
            if($insert) {
                $update=false;
                echo "<pre>";print_r($item);
                $this->mdl_bank_api->saveTransaction($item);
            }
        }
        if($update) echo "no updates";
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
        $this->layout->set("transaction",$this->mdl_bank_api->getTransactionBy($id));
        $this->layout->set("transfiles",$this->mdl_bank_api->getAllTransactionFiles($id));
        $this->layout->set("id",$id);
        $this->layout->buffer('content', 'banking/view');
        $this->layout->render();
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
