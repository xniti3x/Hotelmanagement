<div class="card-header">
    <div class="btn-group">
        <button type="button" class="btn btn-info btn-flat dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
            <span class="sr-only">Toggle Dropdown</span>
        </button>
        <div class="dropdown-menu" role="menu" style="">
            <a class="dropdown-item" href="<?php echo site_url('invoices/status/gant'); ?>"><?php _trans('Diagram'); ?></a>
            <a class="dropdown-item" href="<?php echo site_url('invoices/status/reservation'); ?>"><?php _trans('reservations'); ?></a>
            <a class="dropdown-item" href="<?php echo site_url('invoices/status/all'); ?>"><?php _trans('all');
                                                                                            echo (" ");
                                                                                            _trans('invoices'); ?></a>
            <a class="dropdown-item" href="<?php echo site_url('invoices/status/draft'); ?>"><?php _trans('draft'); ?></a>
            <a class="dropdown-item" href="<?php echo site_url('invoices/status/sent'); ?>"><?php _trans('sent'); ?></a>
            <a class="dropdown-item" href="<?php echo site_url('invoices/status/viewed'); ?>"><?php _trans('viewed'); ?></a>
            <a class="dropdown-item" href="<?php echo site_url('invoices/status/paid'); ?>"><?php _trans('paid'); ?></a>
            <a class="dropdown-item" href="<?php echo site_url('invoices/status/overdue'); ?>"><?php _trans('overdue'); ?></a>
        </div>
        <button type="button" class="btn btn-info btn-flat"><?php _trans($status); ?></button>

    </div>
    <div class="card-tools">
    <?php if ($status != 'gant') : ?>
            <div class="">
            <?php echo pager(site_url('invoices/status/' . $this->uri->segment(3)), 'mdl_invoices'); ?>
            </div>
        <?php endif; ?>

    </div>
</div>