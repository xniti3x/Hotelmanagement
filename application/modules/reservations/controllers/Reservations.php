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
class Reservations extends Admin_Controller
{
    /**
     * Products constructor.
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model("rooms/mdl_rooms");
    }

    /**
     * @param int $page
     */
    public function index(){
       
        $this->layout->buffer('content', 'reservations/index');
        $this->layout->render('layout_no_navbar');
    }

    public function create_from_api(){
        
        $this->load->model("clients/mdl_clients");
        $company=array(
            "client_name" => "myname",
            "client_address_1" => "myadress",
            "client_city" => "mycity",
            "client_zip" => "72712",
            "client_phone" => "12345678",
            "client_email" => "niti@gmx.de"
        );
        
        $client_id = $this->mdl_clients->client_lookOrSave($company);

        $this->load->model('invoices/mdl_invoices');
        ini_set('date.timezone', 'Europe/Berlin');
        $dbarray=array(    
            "client_id" => $client_id, 
            "invoice_date_created"=>date("Y-m-d"),
            "invoice_date_due"=>date("Y-m-d"),
            "invoice_group_id" => "5",
            "invoice_time_created" => date("H:i:s"),
            "invoice_password" => "",
            "user_id" => "2",
            "payment_method" => "1",
            "creditinvoice_parent_id"=>0);
        
            $invoice_id = $this->mdl_invoices->createfromRESTAPI($dbarray);
            $this->load->model('invoices/mdl_items');
            $db_item=array(
                "invoice_id"=>$invoice_id,
                "item_tax_rate_id" => 1,
                "item_product_id" =>1,
                "item_date_added" => date("Y-m-d"),
                "item_name" => "Übernachtung ohne Frühstück",
                "item_quantity" => 1, //nights
                "item_price" => 60,
                "item_date_start" => "2022-04-15",
                "item_date_end" => "2022-04-17",
                "item_room" => "2",
                "item_order"=> "1"
                
            );
            $this->mdl_items->save(null,$db_item);
            $response=[
                'success' => 1,
                'invoice_id' => $invoice_id,
                "array"=> $db_item
            ];
       
        
        echo json_encode($response);
    }
}
