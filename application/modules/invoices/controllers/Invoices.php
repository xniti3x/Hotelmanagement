<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/*
 * InvoicePlane
 *
 * @author		InvoicePlane Developers & Contributors
 * @copyright	Copyright (c) 2012 - 2018 InvoicePlane.com
 * @license		https://invoiceplane.com/license.txt
 * @link		https://invoiceplane.com
 */

/**
 * Class Invoices
 */
class Invoices extends Admin_Controller
{

    /**
     * Invoices constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_invoices');
    }

    public function index()
    {
        // Display all invoices by default
        redirect('invoices/status/gant');
    }

    /**
     * @param string $status
     * @param int $page
     */
    public function status($status = 'all', $page = 0)
    {
        // Determine which group of invoices to load
        switch ($status) {
            case 'draft':
                $this->mdl_invoices->is_draft();
                break;
            case 'sent':
                $this->mdl_invoices->is_sent();
                break;
            case 'viewed':
                $this->mdl_invoices->is_viewed();
                break;
            case 'paid':
                $this->mdl_invoices->is_paid();
                break;
            case 'overdue':
                $this->mdl_invoices->is_overdue();
                break;
            case 'reservation':
                $this->mdl_invoices->is_reservation();
                break;
            case 'all':
                $this->mdl_invoices->is_allNoReservation();
                break;
        }
        
        $this->mdl_invoices->paginate(site_url('invoices/status/' . $status), $page);
        $invoices = $this->mdl_invoices->result();
        $db_reservations=$this->mdl_invoices->where("ip_invoices.invoice_group_id =",5)->get()->result();
        $this->load->model('mdl_items');
        $reservations=array();
        foreach($db_reservations as $invoice){
            $invoice_products = $this->mdl_items->where('invoice_id', $invoice->invoice_id)->get()->result_array();
            $invoice->{'product_items'}=$invoice_products;
            $reservations[]=$invoice;
        }
        $this->layout->set(
            [
                'invoices' => $invoices,
                'reservations' =>$reservations,
                'status' => $status,
                'filter_display' => true,
                'filter_placeholder' => ($status=='reservation')?trans('filter_invoices'):trans('filter_invoices'),
                'filter_method' => 'filter_invoices',
                'invoice_statuses' => $this->mdl_invoices->statuses(),
            ]
        );

        $this->layout->buffer('content', 'invoices/index');
        $this->layout->render();
    }

    public function archive()
    {
        $invoice_array = [];

        if (isset($_POST['invoice_number'])) {
            $invoiceNumber = $_POST['invoice_number'];
            $invoice_array = glob(UPLOADS_ARCHIVE_FOLDER . '*' . '_' . $invoiceNumber . '.pdf');
            $this->layout->set(
                [
                    'invoices_archive' => $invoice_array,
                ]);
            $this->layout->buffer('content', 'invoices/archive');
            $this->layout->render();

        } else {
            foreach (glob(UPLOADS_ARCHIVE_FOLDER . '*.pdf') as $file) {
                array_push($invoice_array, $file);
            }

            rsort($invoice_array);
            $this->layout->set(
                [
                    'invoices_archive' => $invoice_array,
                ]);
            $this->layout->buffer('content', 'invoices/archive');
            $this->layout->render();
        }
    }

    /**
     * @param $invoice
     */
    public function download($invoice)
    {
        header('Content-type: application/pdf');
        header('Content-Disposition: attachment; filename="' . urldecode($invoice) . '"');
        readfile(UPLOADS_ARCHIVE_FOLDER . urldecode($invoice));
    }

    /**
     * @param $invoice_id
     */
    public function view($invoice_id,$layout='layout')
    {
        $this->load->model(
            [
                'mdl_items',
                'tax_rates/mdl_tax_rates',
                'payment_methods/mdl_payment_methods',
                'mdl_invoice_tax_rates',
                'custom_fields/mdl_custom_fields',
            ]
        );

        $this->load->helper("custom_values");
        $this->load->helper("client");
        $this->load->model('units/mdl_units');
        $this->load->module('payments');

        $this->load->model('custom_values/mdl_custom_values');
        $this->load->model('custom_fields/mdl_invoice_custom');

        $this->db->reset_query();

        /*$invoice_custom = $this->mdl_invoice_custom->where('invoice_id', $invoice_id)->get();

        if ($invoice_custom->num_rows()) {
            $invoice_custom = $invoice_custom->row();

            unset($invoice_custom->invoice_id, $invoice_custom->invoice_custom_id);

            foreach ($invoice_custom as $key => $val) {
                $this->mdl_invoices->set_form_value('custom[' . $key . ']', $val);
            }
        }*/

        $fields = $this->mdl_invoice_custom->by_id($invoice_id)->get()->result();
        $invoice = $this->mdl_invoices->get_by_id($invoice_id);

        if (!$invoice) {
            show_404();
        }

        $custom_fields = $this->mdl_custom_fields->by_table('ip_invoice_custom')->get()->result();
        $custom_values = [];
        foreach ($custom_fields as $custom_field) {
            if (in_array($custom_field->custom_field_type, $this->mdl_custom_values->custom_value_fields())) {
                $values = $this->mdl_custom_values->get_by_fid($custom_field->custom_field_id)->result();
                $custom_values[$custom_field->custom_field_id] = $values;
            }
        }

        foreach ($custom_fields as $cfield) {
            foreach ($fields as $fvalue) {
                if ($fvalue->invoice_custom_fieldid == $cfield->custom_field_id) {
                    // TODO: Hackish, may need a better optimization
                    $this->mdl_invoices->set_form_value(
                        'custom[' . $cfield->custom_field_id . ']',
                        $fvalue->invoice_custom_fieldvalue
                    );
                    break;
                }
            }
        }

        // Check whether there are payment custom fields
        $payment_cf = $this->mdl_custom_fields->by_table('ip_payment_custom')->get();
        $payment_cf_exist = ($payment_cf->num_rows() > 0) ? "yes" : "no";

        $this->layout->set(
            [
                'invoice' => $invoice,
                'items' => $this->mdl_items->where('invoice_id', $invoice_id)->get()->result(),
                'invoice_id' => $invoice_id,
                'tax_rates' => $this->mdl_tax_rates->get()->result(),
                'invoice_tax_rates' => $this->mdl_invoice_tax_rates->where('invoice_id', $invoice_id)->get()->result(),
                'units' => $this->mdl_units->get()->result(),
                'payment_methods' => $this->mdl_payment_methods->get()->result(),
                'custom_fields' => $custom_fields,
                'custom_values' => $custom_values,
                'custom_js_vars' => [
                    'currency_symbol' => get_setting('currency_symbol'),
                    'currency_symbol_placement' => get_setting('currency_symbol_placement'),
                    'decimal_point' => get_setting('decimal_point'),
                ],
                'invoice_statuses' => $this->mdl_invoices->statuses(),
                'payment_cf_exist' => $payment_cf_exist,
            ]
        );

        if ($invoice->sumex_id != null) {
            $this->layout->buffer(
                [
                    ['modal_delete_invoice', 'invoices/modal_delete_invoice'],
                    ['modal_add_invoice_tax', 'invoices/modal_add_invoice_tax'],
                    ['modal_add_payment', 'payments/modal_add_payment'],
                    ['content', 'invoices/view_sumex'],
                ]
            );
        } else {
            $this->layout->buffer(
                [
                    ['modal_delete_invoice', 'invoices/modal_delete_invoice'],
                    ['modal_add_invoice_tax', 'invoices/modal_add_invoice_tax'],
                    ['modal_add_payment', 'payments/modal_add_payment'],
                    ['content', 'invoices/view'],
                ]
            );
        }

        $this->layout->render($layout);
    }


    public function create_invoice_view($client_id=null)
    {
        $this->load->module('layout');
        $this->load->model('invoice_groups/mdl_invoice_groups');
        $this->load->model('tax_rates/mdl_tax_rates');
        $this->load->model('clients/mdl_clients');

        $this->layout->set([
            'invoice_groups' => $this->mdl_invoice_groups->get()->result(),
            'tax_rates' => $this->mdl_tax_rates->get()->result(),
            'client' => $this->mdl_clients->get_by_id($client_id),
            'clients' => $this->mdl_clients->get_latest(),
        ]);
        $this->layout->buffer('content', 'invoices/modal_create_reservation');
        $this->layout->render('layout');

    }
    /**
     * @param $invoice_id
     */
    public function delete($invoice_id)
    {
        // Get the status of the invoice
        $invoice = $this->mdl_invoices->get_by_id($invoice_id);
        $invoice_status = $invoice->invoice_status_id;

        if ($invoice_status == 1 || $this->config->item('enable_invoice_deletion') === true) {
            // If invoice refers to tasks, mark those tasks back to 'Complete'
            $this->load->model('tasks/mdl_tasks');
            $tasks = $this->mdl_tasks->update_on_invoice_delete($invoice_id);

            // Delete the invoice
            $this->mdl_invoices->delete($invoice_id);
        } else {
            // Add alert that invoices can't be deleted
            $this->session->set_flashdata('alert_error', trans('invoice_deletion_forbidden'));
        }

        // Redirect to invoice index
        redirect('invoices/index');
    }

    /**
     * @param $invoice_id
     * @param bool $stream
     * @param null $invoice_template
     */
    public function generate_pdf($invoice_id, $stream = true, $invoice_template = null)
    {
        $this->load->helper('pdf');

        if (get_setting('mark_invoices_sent_pdf') == 1) {
            $this->mdl_invoices->generate_invoice_number_if_applicable($invoice_id);
            $this->mdl_invoices->mark_sent($invoice_id);
        }

        generate_invoice_pdf($invoice_id, $stream, $invoice_template, null);
    }

    /**
     * @param $invoice_id
     */
    public function generate_zugferd_xml($invoice_id)
    {
        $this->load->model('invoices/mdl_items');
        $this->load->library('ZugferdXml', [
            'invoice' => $this->mdl_invoices->get_by_id($invoice_id),
            'items' => $this->mdl_items->where('invoice_id', $invoice_id)->get()->result(),
        ]);

        $this->output->set_content_type('text/xml');
        $this->output->set_output($this->zugferdxml->xml());
    }

    public function generate_sumex_pdf($invoice_id)
    {
        $this->load->helper('pdf');

        generate_invoice_sumex($invoice_id);
    }

    public function generate_sumex_copy($invoice_id)
    {


        $this->load->model('invoices/mdl_items');
        $this->load->library('Sumex', [
            'invoice' => $this->mdl_invoices->get_by_id($invoice_id),
            'items' => $this->mdl_items->where('invoice_id', $invoice_id)->get()->result(),
            'options' => [
                'copy' => "1",
                'storno' => "0",
            ],
        ]);

        $this->output->set_content_type('application/pdf');
        $this->output->set_output($this->sumex->pdf());
    }

    /**
     * @param $invoice_id
     * @param $invoice_tax_rate_id
     */
    public function delete_invoice_tax($invoice_id, $invoice_tax_rate_id)
    {
        $this->load->model('mdl_invoice_tax_rates');
        $this->mdl_invoice_tax_rates->delete($invoice_tax_rate_id);

        $this->load->model('mdl_invoice_amounts');
        $this->mdl_invoice_amounts->calculate($invoice_id);

        redirect('invoices/view/' . $invoice_id);
    }

    public function recalculate_all_invoices()
    {
        $this->db->select('invoice_id');
        $invoice_ids = $this->db->get('ip_invoices')->result();

        $this->load->model('mdl_invoice_amounts');

        foreach ($invoice_ids as $invoice_id) {
            $this->mdl_invoice_amounts->calculate($invoice_id->invoice_id);
        }
    }

    public function getBackendReservationsAsItem(){
        
        $this->load->model("mdl_items");
        foreach($this->mdl_items->getAllInvoiceItems($this->input->post('start')) as $res){
          
            $event=array(
                "text"=>$res->client_name,
                "id"=>$res->item_id, //ip_invoices.invoice_id
                "start"=>$res->item_date_start."T14:00:00",
                "end"=>$res->item_date_end."T12:00:00",
                "resource"=>$res->item_room,
                "invoice_id"=>$res->invoice_id,
                
            );
            
            $result[]=$event;
        }
        header('Content-Type: application/json');
        echo json_encode($result);
    }

    public function convertToInvoice($invoice_id){
        $invoice_group_id = $this->mdl_invoices->get_invoice_group_id($invoice_id);
        $inv = $this->db->query('select ip_invoices.invoice_number from ip_invoices where ip_invoices.invoice_id='.$invoice_id)->row();
        //check if invoice_group_id is 5 and invoice_number starts with RES, than convert Reservation to Invoice
        if($invoice_group_id==5 && $this->substr_startswith($inv->invoice_number,'RES')){
            $invoice_number = $this->mdl_invoices->get_invoice_number(3);
            $this->db->where('invoice_id', $invoice_id);
            $this->db->set('invoice_group_id', 3);
            $this->db->set('invoice_number', $invoice_number);
            $this->db->update('ip_invoices');
            if($this->db->trans_status() === FALSE){
                $this->session->set_flashdata('alert_error', trans('convert_to_invoice_error'));
            }else{
                $this->session->set_flashdata('alert_success', trans('convert_to_invoice_sucsess'));
            }
        }
        redirect('invoices/view/'.$invoice_id, 'location');
    }

    private function substr_startswith($haystack, $needle) {
        return substr($haystack, 0, strlen($needle)) === $needle;
    }
}
