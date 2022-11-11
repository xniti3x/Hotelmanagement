<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_Bank_Api extends Response_Model
{
    /**
     * access, access_expires, refresh, refresh_expires, institution_id, account_id,secret_id, secret_key, reference
     */
    public function getValue($key){
        return $this->db->query("select value from bank_api_setup where bank_api_setup.key='".$key."'")->row()->value;
    }
    
    public function setValue($key,$value){
        $this->db->set('value', $value);
        $this->db->where('key', $key);
        $this->db->update('bank_api_setup');
    }

    public function getLastTransaction(){
        $query = $this->db->query("SELECT * FROM ip_transactions ORDER BY id DESC LIMIT 1");
        $result = $query->row();
        return $result;
    }

    public function saveTransaction($array){
        $title="";
        $iban="";
        if(isset($array["creditorName"])){
            $title=$array["creditorName"];
            $iban=$array["creditorAccount"]["iban"];
        }

        if(isset($array["debtorName"])){
            $title=$array["debtorName"];
            $iban=$array["debtorAccount"]["iban"];
        }

    $this->db->set(array(
        "transactionId"=>$array["transactionId"],
        "bookingDate"=>$array["bookingDate"],
        "valueDate"=>$array["valueDate"],
        "transactionAmount"=>$array["transactionAmount"]["amount"],
        "title"=>$title,
        "iban"=>$iban,
        "remittanceInformationStructured"=>isset($array["remittanceInformationStructured"])?$array["remittanceInformationStructured"]:"",	
        "additionalInformation"=>$array["additionalInformation"]
    ));
        return $this->db->insert('ip_transactions');        
    }
    
    public function saveTransactionFile($array){
        $this->db->set(array(
        "file_name" =>$array["file_name"],
        "file_type	"=>$array["file_type"],
        "file_path	"=>$array["file_path"],
        "full_path	"=>$array["full_path"],
        "raw_name	"=>$array["raw_name"],
        "file_ext	"=>$array["file_ext"],
        "file_size	"=>$array["file_size"],	
        "transactionId"=>$array["transactionId"]
        ));
        return $this->db->insert('ip_transaction_files');
    }
    public function saveTransactionFilter($array){
        $this->db->set(array(
            "transactionId"=>$array["transactionId"],
            "bookingDate"=>$array["bookingDate"],
            "valueDate"=>$array["valueDate"],
            "transactionAmount"=>$array["transactionAmount"],
            "title"=>$array["title"],
            "iban"=>$array["iban"],
            "remittanceInformationStructured"=>$array["remittanceInformationStructured"],	
            "additionalInformation"=>$array["additionalInformation"]
        ));
        
        return $this->db->insert('ip_transactions_filter');
    }
    private $query_filter="iban NOT IN (SELECT iban FROM ip_transactions_filter)";
    public function getAllTransactionFiles($id){
        return $this->db->query("select * from ip_transaction_files where ip_transaction_files.transactionId='".$id."'")->result();
    }

    public function getAllTransactions(){
        return $this->db->query("select * from ip_transactions where ".$this->query_filter." order by bookingDate desc")->result_array();
    }

    public function getAllTransactionsNoFiles(){
        return $this->db->query("
        SELECT * 
        FROM ip_transactions 
        WHERE transactionAmount<0 
        AND transactionId 
        NOT IN (SELECT transactionId FROM ip_transaction_files) and ".$this->query_filter)->result_array();
    }

    public function getAllTransactionsWithFiles(){
        return $this->db->query("
        SELECT * 
        FROM ip_transactions 
        WHERE transactionId 
        IN (SELECT transactionId FROM ip_transaction_files) and ".$this->query_filter)->result_array();
    }

    public function getAllFiltredTransactions(){
        return $this->db->query("SELECT * FROM ip_transactions_filter")->result_array();
    }
    public function getAllClientsWithRule(){
        return $this->db->query("
        SELECT *
        FROM `ip_clients`
        WHERE client_rule AND client_amount is NOT NULL")->result_array();
    }

    public function getTransactionBy($transactionId){
        return $this->db->query("select * from ip_transactions where transactionId='".$transactionId."'")->row_array();
    }
    public function deleteTransactionFile($dbId){
        $this->db->where('id', $dbId);
        $this->db->delete('ip_transaction_files');
    }
    
}
