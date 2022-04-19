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
class Emails extends Admin_Controller
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
    public function index(){
        $this->layout->set("iframe_url",$this->db->query("Select * from ip_settings where setting_key='email_iframe_url';")->row());
        $this->layout->buffer('content', 'emails/index');
        $this->layout->render('layout');
    }

}
