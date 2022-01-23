<div id="headerbar">
    <div class="headerbar-item pull-left">
        <button type="button" class="btn btn-default btn-sm submenu-toggle hidden-lg"
                data-toggle="collapse" data-target="#ip-submenu-collapse">
            <i class="fa fa-bars"></i> <?php _trans('submenu'); ?>
        </button>
        <a class="<?php echo $status == 'reservation' ? 'create-reservation':'create-invoice'; ?> btn btn-sm btn-primary" href="#">
            <i class="fa fa-plus"></i> <?php ($status=='reservation' || $status=='gant')?_trans('reservation'):_trans('invoice'); ?>
        </a>
    </div>
    <?php if($status!='gant'): ?>
    <div class="headerbar-item pull-right visible-lg">
        <?php echo pager(site_url('invoices/status/' . $this->uri->segment(3)), 'mdl_invoices'); ?>
    </div>
    <?php endif; ?>
    <div class="headerbar-item pull-right visible-lg">
        <div class="btn-group btn-group-sm index-options">
            <a href="<?php echo site_url('invoices/status/gant'); ?>"
               class="btn  <?php echo $status == 'gant' ? 'btn-primary' : 'btn-default' ?>">
                <?php _trans('Diagram'); ?>
            </a>
            <a href="<?php echo site_url('invoices/status/reservation'); ?>"
               class="btn  <?php echo $status == 'reservation' ? 'btn-primary' : 'btn-default' ?>">
                <?php _trans('reservations'); ?>
            </a>
            <a href="<?php echo site_url('invoices/status/all'); ?>"
               class="btn <?php echo $status == 'all' ? 'btn-primary' : 'btn-default' ?>">
                <?php _trans('all'); echo(" ");_trans('invoices'); ?>
            </a>
            <a href="<?php echo site_url('invoices/status/draft'); ?>"
               class="btn  <?php echo $status == 'draft' ? 'btn-primary' : 'btn-default' ?>">
                <?php _trans('draft'); ?>
            </a>
            <a href="<?php echo site_url('invoices/status/sent'); ?>"
               class="btn  <?php echo $status == 'sent' ? 'btn-primary' : 'btn-default' ?>">
                <?php _trans('sent'); ?>
            </a>
            <a href="<?php echo site_url('invoices/status/viewed'); ?>"
               class="btn  <?php echo $status == 'viewed' ? 'btn-primary' : 'btn-default' ?>">
                <?php _trans('viewed'); ?>
            </a>
            <a href="<?php echo site_url('invoices/status/paid'); ?>"
               class="btn  <?php echo $status == 'paid' ? 'btn-primary' : 'btn-default' ?>">
                <?php _trans('paid'); ?>
            </a>
            <a href="<?php echo site_url('invoices/status/overdue'); ?>"
               class="btn  <?php echo $status == 'overdue' ? 'btn-primary' : 'btn-default' ?>">
                <?php _trans('overdue'); ?>
            </a>
        </div>
    </div>

</div>

<div id="submenu">
    <div class="collapse clearfix" id="ip-submenu-collapse">
    <?php if($status!='gant'): ?>
        <div class="submenu-row">
            <?php echo pager(site_url('invoices/status/' . $this->uri->segment(3)), 'mdl_invoices'); ?>
        </div>
    <?php endif; ?>
        <div class="submenu-row">
            <div class="btn-group btn-group-sm index-options">
                <a href="<?php echo site_url('invoices/status/gant'); ?>"
                class="btn  <?php echo $status == 'gant' ? 'btn-primary' : 'btn-default' ?>">
                    <?php _trans('Diagram'); ?>
                </a>
                <a href="<?php echo site_url('invoices/status/reservation'); ?>"
                   class="btn  <?php echo $status == 'reservation' ? 'btn-primary' : 'btn-default' ?>">
                    <?php _trans('reservations'); ?>
                </a>
                <a href="<?php echo site_url('invoices/status/all'); ?>"
                   class="btn <?php echo $status == 'all' ? 'btn-primary' : 'btn-default' ?>">
                    <?php _trans('all'); ?>
                </a>
                <a href="<?php echo site_url('invoices/status/draft'); ?>"
                   class="btn  <?php echo $status == 'draft' ? 'btn-primary' : 'btn-default' ?>">
                    <?php _trans('draft'); ?>
                </a>
                <a href="<?php echo site_url('invoices/status/sent'); ?>"
                   class="btn  <?php echo $status == 'sent' ? 'btn-primary' : 'btn-default' ?>">
                    <?php _trans('sent'); ?>
                </a>
                <a href="<?php echo site_url('invoices/status/viewed'); ?>"
                   class="btn  <?php echo $status == 'viewed' ? 'btn-primary' : 'btn-default' ?>">
                    <?php _trans('viewed'); ?>
                </a>
                <a href="<?php echo site_url('invoices/status/paid'); ?>"
                   class="btn  <?php echo $status == 'paid' ? 'btn-primary' : 'btn-default' ?>">
                    <?php _trans('paid'); ?>
                </a>
                <a href="<?php echo site_url('invoices/status/overdue'); ?>"
                   class="btn  <?php echo $status == 'overdue' ? 'btn-primary' : 'btn-default' ?>">
                    <?php _trans('overdue'); ?>
                </a>
            </div>
        </div>

    </div>
</div>
<?php if($status=='gant'): ?>
    
<iframe src="<?php echo site_url('reservations/index'); ?>"></iframe>
    
<?php else: ?>
<div id="content" class="table-content">
    <div id="filter_results">
        <?php $this->layout->load_view('invoices/partial_invoice_table', array('invoices' => $invoices)); ?>
    </div>
</div>
<?php endif; ?>