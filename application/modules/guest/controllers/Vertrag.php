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

class Vertrag extends Base_Controller
{
    public function __construct() {
        parent::__construct();
    }
    
    public function vertrag() {
        $data['vermieter'] = $this->input->post('vermieter');
        $data['mieter'] = $this->input->post('mieter');
        $data['wohnfleche'] = $this->input->post('wohnfleche');
        $data['wohnzweck'] = $this->input->post('wohnzweck');
        $data['adresse'] = $this->input->post('adresse');
        $data['raumlichkeiten'] = $this->input->post('raumlichkeiten');
        $data['kaltmiete'] = $this->input->post('kaltmiete');
        $data['nebenkosten'] = $this->input->post('nebenkosten');
        $data['iban'] = $this->input->post('iban');
        $data['kaution'] = $this->input->post('kaution');
        $data['kautionart'] = $this->input->post('kautionart');
        $data['begin'] = $this->input->post('begin');
        $data['ende'] = $this->input->post('ende');
        $data['selbstbeteiligung'] = $this->input->post('selbstbeteiligung');
   
        $this->load->view("guest/vertrag",$data);
    }

    public function index(){
        $data = $this->db->get('ip_vertrag')->row();
        $this->load->view("guest/vertrag_form",$data);
    }

 
    
}