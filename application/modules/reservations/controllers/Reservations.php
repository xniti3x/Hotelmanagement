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
    }

    /**
     * @param int $page
     */
    public function index($page = 0)
    {
        $this->load->view("reservations/index");
    }

    public function new(){
        $this->layout->load_view("reservations/new");
    }
    public function edit(){
        $this->layout->load_view("reservations/edit");
    }


}
