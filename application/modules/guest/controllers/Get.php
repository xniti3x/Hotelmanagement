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
        $url = 'http://xdroid.net/api/message';
        date_default_timezone_set('Europe/Berlin');
        $date_start=date("Y-m-d");
        $items=$this->mdl_items->getAllItemsWithStartDate($date_start);
        foreach($items as $item){
            $data=array(
                "k" => "k-2fdf689e017d",
                "t" => "14:00Uhr - ".substr($item->client_name, 0, 30),
                "c" => $date_start." - ".$item->item_date_end." | ".$item->item_price,
                "u" => site_url("invoices/status/gant")
            );
            
            $this->httpPost($url,$data);
        }
        
    }
    
    private function httpPost($url, $data)
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

}
