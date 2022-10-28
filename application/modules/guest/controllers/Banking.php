<?php
if (!defined('BASEPATH')) exit('No direct script access allowed'); 

class Banking extends Base_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->model('banking/mdl_bank_api');
        $this->load->helper(array('form', 'url'));
    }
    public function index($ckey=null){if(strcmp($ckey,$this->mdl_bank_api->getValue('ckey'))!=0) exit('No access allowed');
        $transactions=$this->mdl_bank_api->getAllTransactions();
        
        $this->layout->set("transactions",$transactions);
        $this->layout->buffer('content', 'guest/transcation_index');
        $this->layout->render('layout_no_navbar');
    }

    public function view($ckey,$id){if(strcmp($ckey,$this->mdl_bank_api->getValue('ckey'))!=0) exit('No access allowed');
        $transaction=$this->mdl_bank_api->getTransactionBy($id);
        $transfiles=$this->mdl_bank_api->getAllTransactionFiles($id);

        $this->layout->set("transaction",$transaction);
        $this->layout->set("transfiles",$transfiles);
        $this->layout->set("id",$id);
        $this->layout->buffer('content', 'guest/transaction_view');
        $this->layout->render('layout_no_navbar');
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
            header("Location:".site_url("guest/banking/view/".$id));
        }
        else
        {// Array ( [upload_data] => Array ( [file_name] => 2020-mu2ff7in12.pdf [file_type] => application/pdf [file_path] => /root/workspace/Hotelmanagement/uploads/ [full_path] => /root/workspace/Hotelmanagement/uploads/2020-mu2ff7in12.pdf [raw_name] => 2020-mu2ff7in12 [orig_name] => 2020-mu2ff7in.pdf [client_name] => 2020-mu2ff7in.pdf [file_ext] => .pdf [file_size] => 53.1 [is_image] => [image_width] => [image_height] => [image_type] => [image_size_str] => ) )
             
            $data = $this->upload->data();
            $data['transactionId']=$id;
            $this->mdl_bank_api->saveTransactionFile($data);
            $this->session->set_flashdata('alert_success', trans('record_successfully_updated'));
            header("Location:".site_url("guest/banking/index"));
        }       
    }
}