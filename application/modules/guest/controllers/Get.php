<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * InvoicePlane
 *
 * @author      InvoicePlane Developers & Contributors
 * @copyright   Copyright (c) 2012 - 2018 InvoicePlane.com
 * @license     https://invoiceplane.com/license.txt
 * @link        https://invoiceplane.com
 */

/**
 * Class Guest
 */
class Get extends Base_Controller
{
    public function attachment($filename)
    {
        $path = UPLOADS_CFILES_FOLDER;
        $filePath = $path . $filename;

        if (strpos(realpath($filePath), $path) !== 0) {
            header("Status: 403 Forbidden");
            echo '<h1>Forbidden</h1>';
            exit;
        }

        $filePath = realpath($filePath);

        if (file_exists($filePath)) {
            $pathParts = pathinfo($filePath);
            $fileExt = $pathParts['extension'];
            $fileSize = filesize($filePath);

            header("Expires: -1");
            header("Cache-Control: public, must-revalidate, post-check=0, pre-check=0");
            header("Content-Disposition: attachment; filename=\"$filename\"");
            header("Content-Type: application/octet-stream");
            header("Content-Length: " . $fileSize);

            echo file_get_contents($filePath);
            exit;
        }

        show_404();
        exit;
    }

    public function fireNotification($cron_key)
    {
        $this->load->model('invoices/mdl_items');
        $this->load->model('settings/mdl_settings');
        
       if (strcmp($cron_key, $this->mdl_settings->get('cron_key')) !== 0) { exit;} 
        $url = $this->mdl_settings->get('ntfy_url');
        date_default_timezone_set('Europe/Berlin');
        $date_start=date("Y-m-d");
        $items=$this->mdl_items->getAllItemsWithStartDate($date_start);
        foreach($items as $item){
            $header=array(
                "Title:Reservierung - ".substr($item->client_name, 0, 20)."..",
                "Priority:3",
                "Tags:memo",
                "Actions:view, Anzeigen, ".site_url("invoices/status/gant"),
                "Authorization: ".$this->mdl_settings->get('ntfy_basic_auth'),
                "Content-Type: text/plain"
            );
            $body="Zimmer:".$item->item_room." - Von:".$item->item_date_start." - Bis:".$item->item_date_end." - Preis:".$item->item_price;
            $this->httpPost($url,$body,$header);
        }
        
    }


    public function no_beds_update($cron_key){ 
       if (strcmp($cron_key, $this->mdl_settings->get('cron_key')) !== 0) { exit;}

        $this->loadLibrary();
        $obj = $this->getReservationsFromChanelManager();
        
        $lastInsertedReservationOrderId=$this->mdl_settings->get('order_reservation_id');

        $product=$this->db->query("select * from ip_products where product_id=1")->row();
        
        $reverse_bookings=array_reverse($obj);
        //echo "<pre>";print_r($reverse_bookings);
        
        foreach($reverse_bookings as $event){
            if($event->status=="New"){
                if($event->order_id==$lastInsertedReservationOrderId) break;
                $this->createReservation($event);
            }elseif($event->status=="Cancelled"){
                //when cancelled, find by orderid -> delete 
            }
        }
        
        //check for free roms now and mark as free on chanelmanager
        //get all invoiceids , check if new than foreach invoice->item_datestart and end fire postrequst 
        //$items=array_reverse($this->getItemsFrom(date("Y-m-d")));
        //$lastInsertedOrderItemId = $this->mdl_settings->get('order_item_id'); //order_item_id from ip_
        //foreach($items as $item){
        //    if($item->item_id==$lastInsertedOrderItemId) break;
        //    echo $item->item_id." - ".$item->item_room." - ".$item->item_date_start." - ".$item->item_date_end."<br>";
        //}
        //$this->mdl_settings->save('order_reservation_id', $reverse_bookings[0]->order_id);
        //$this->mdl_settings->save('order_item_id', $items[0]->item_id);
    }

    private function getReservationsFromChanelManager(){
        $URL_API=$this->mdl_settings->get('chanel_manager_url');
        return json_decode($this->httpGet($URL_API));
    }

    private function createReservation($event){
        
        $client=array(
            'client_name'=> $event->referral. "-". $event->name
        );
        $id=$this->mdl_clients->save(null,$client);

        $invoice=array(
                'client_id'=> $id,
                'invoice_date_created' => date("Y-m-d"),
                'invoice_group_id' => 5,
                'invoice_time_created' => date('H:i:s'),
                'invoice_password' => "",
                'user_id' => 1,
                'payment_method' => "",
                'invoice_number' => $this->mdl_invoices->get_invoice_number(5),
                'invoice_url_key' =>$this->mdl_invoices->get_url_key()
        );

        $invoiceId=$this->mdl_invoices->create($invoice);

        $item=array(
            'invoice_id'=> $invoiceId,
            'item_date_end'=> $event->checkout,
            'item_date_start'=> $event->checkin,
            'item_description'=> $event->name.' - bookingid:'.$event->order_id,
            'item_id'=> "",
            'item_name'=> $product->product_name,
            'item_order'=> 1,
            'item_price'=> $event->price,
            'item_product_id'=> $product->product_id,
            'item_quantity'=> $event->nights,
            'item_room'=> 5,
            'item_task_id'=> "",
            'item_tax_rate_id'=> $product->tax_rate_id
        );

        $this->mdl_items->save(null,$item);
        
        echo $event->name." - ".$event->order_id."<br>";

    }
    private function getItemsFrom($date){
        return $this->db->query("select * from ip_invoice_items 
        where   (ip_invoice_items.item_room=5 or ip_invoice_items.item_room=6 or ip_invoice_items.item_room=14) 
        and     item_date_added ='".$date."'")->result();
    }

    private function httpPost($url, $data,$header)
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    private function httpGet($url)
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, 0);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    private function loadLibrary(){
        $this->load->model('invoices/mdl_invoices');
        $this->load->model('invoices/mdl_items');
        $this->load->model('settings/mdl_settings');
        $this->load->model('clients/mdl_clients');
    }
}
