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
 * Class Dashboard
 */
class Dashboard extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mdl_dashboard');
    }
    
    public function index()
    {
        $this->load->model('invoices/mdl_invoice_amounts');
        $this->load->model('quotes/mdl_quote_amounts');
        $this->load->model('invoices/mdl_invoices');
        $this->load->model('quotes/mdl_quotes');
        $this->load->model('projects/mdl_projects');
        $this->load->model('tasks/mdl_tasks');
        $this->load->model('invoices/mdl_items');

        $quote_overview_period = get_setting('quote_overview_period');
        $invoice_overview_period = get_setting('invoice_overview_period');

        $to=new DateTime();
        $from = new DateTime();
        $from->sub(new DateInterval('P3M'));
        
        $this->layout->set(
            array(
                'invoice_status_totals' => $this->mdl_invoice_amounts->get_status_totals($invoice_overview_period),
                'quote_status_totals' => $this->mdl_quote_amounts->get_status_totals($quote_overview_period),
                'invoice_status_period' => str_replace('-', '_', $invoice_overview_period),
                'quote_status_period' => str_replace('-', '_', $quote_overview_period),
                'invoices' => $this->mdl_invoices->where('ip_invoices.invoice_group_id !=',5)->limit(10)->get()->result(),
                'reservations' => $this->mdl_invoices->where('ip_invoices.invoice_group_id =',5)->limit(10)->get()->result(),
                'quotes' => $this->mdl_quotes->limit(10)->get()->result(),
                'invoice_statuses' => $this->mdl_invoices->statuses(),
                'quote_statuses' => $this->mdl_quotes->statuses(),
                'overdue_invoices' => $this->mdl_invoices->is_overdue()->get()->result(),
                'projects' => $this->mdl_projects->get_latest()->get()->result(),
                'tasks' => $this->mdl_tasks->get_latest()->get()->result(),
                'task_statuses' => $this->mdl_tasks->statuses(),
                'clientStatistic' => $this->mdl_dashboard->getClientStatistic(),
                'roomStatistic' => $this->mdl_dashboard->getRoomStatistic(),
                'monthVisitors' => $this->mdl_dashboard->getMonthVisitors($from->format('Y-m-d'),$to->format('Y-m-d'))
            )
        );

        $this->layout->buffer('content', 'dashboard/index');
        $this->layout->render();
    }
    public function getMonthVisitors(){
        
        echo json_encode($this->mdl_dashboard->getMonthVisitors($this->input->post("start"),$this->input->post("end")));
    }

}
