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

}
