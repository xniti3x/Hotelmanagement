<style>.draft{color:#999}.sent{color:#3A87AD}.viewed{color:#F89406}.paid,.approved{color:#468847}.rejected,.overdue{color:#B94A48}.canceled{color:#333}</style>

<script>
    $(function() {

    });
</script>
<!-- daypilot libraries -->
<script src="<?php echo base_url(); ?>/custom_assets/styles/js/daypilot-all.min.js" type="text/javascript"></script>
<div id="headerbar">
    
   

</div>
<?php $this->load->view('invoices/partial_table_card_header'); ?>                

<?php if ($status == 'gant') : ?>
    <?php $this->load->view('reservations/index'); ?>
<?php else : ?>
    <div id="content" class="table-content">
        <div id="filter_results">
            <?php if ($status == 'reservation') : ?>
                <?php $this->layout->load_view('invoices/partial_reservation_table', array('invoices' => $invoices)); ?>
            <?php else : ?>
                <?php $this->layout->load_view('invoices/partial_invoice_table', array('reservations' => $reservations)); ?>
            <?php endif; ?>
        </div>
    </div>
        
<?php endif; ?>

<!-- loads datatable js files -->
<?php $this->load->view("layout/admin_lte/datatablelib");