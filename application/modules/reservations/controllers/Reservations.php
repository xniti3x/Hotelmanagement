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
        $this->load->model("settings/mdl_settings");
    }

    /**
     * @param int $page
     */
    public function index(){
       
        $this->layout->buffer('content', 'reservations/index');
        $this->layout->render('layout_no_navbar');
    }
}
