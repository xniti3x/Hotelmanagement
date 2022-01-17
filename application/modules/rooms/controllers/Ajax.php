<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * InvoicePlane
 *
 * @author		InvoicePlane Developers & Contributors
 * @copyright	Copyright (c) 2012 - 2018 InvoicePlane.com
 * @license		https://invoiceplane.com/license.txt
 * @link		https://invoiceplane.com
 * Class Ajax
 */
class Ajax extends Admin_Controller
{
    public $ajax_controller = true;
    public function backend_rooms(){
        $this->load->model("mdl_rooms");
        foreach($this->mdl_rooms->getAllActiveRooms() as $room){
            $result[]=$room;
        }
        header('Content-Type: application/json');
        echo json_encode($result);
    }
}
