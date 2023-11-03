<div class="card">
    <div class="card-body table-responsive">
    <table id="example1" class="table table-hover table-striped">

        <thead>
        <tr>
            <th><?php _trans('payment_date'); ?></th>
            <th><?php _trans('invoice_date'); ?></th>
            <th><?php _trans('invoice'); ?></th>
            <th><?php _trans('client'); ?></th>
            <th><?php _trans('amount'); ?></th>
            <th><?php _trans('payment_method'); ?></th>
            <th><?php _trans('note'); ?></th>
            <th><?php _trans('options'); ?></th>
        </tr>
        </thead>

        <tbody>
        <?php foreach ($payments as $payment) { ?>
            <tr>
                <td><?php echo date_from_mysql($payment->payment_date); ?></td>
                <td><?php echo date_from_mysql($payment->invoice_date_created); ?></td>
                <td><?php echo anchor('invoices/view/' . $payment->invoice_id, $payment->invoice_number); ?></td>
                <td>
                    <a href="<?php echo site_url('clients/view/' . $payment->client_id); ?>"
                       title="<?php _trans('view_client'); ?>">
                        <?php _htmlsc(format_client($payment)); ?>
                    </a>
                </td>
                <td class="amount"><?php echo format_currency($payment->payment_amount); ?></td>
                <td><?php _htmlsc($payment->payment_method_name); ?></td>
                <td><?php _htmlsc($payment->payment_note); ?></td>
                <td>
                    <div class="btn-group">
                        <div class="btn btn-info"><i class="fa fa-cog"></i></div>
                        <button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu" role="menu" style="">
                            <a class="dropdown-item" href="<?php echo site_url('payments/form/' . $payment->payment_id); ?>"><i class="fa fa-edit fa-margin"></i> <?php _trans('edit'); ?></a>
                            <div class="dropdown-divider"></div>
                            <form action="<?php echo site_url('payments/delete/' . $payment->payment_id); ?>" method="POST">
                                <?php _csrf_field(); ?>
                                <button type="submit" class="dropdown-item" onclick="return confirm('<?php _trans('delete_invoice_warning'); ?>');">
                                    <i class="fa fa-trash"></i> <?php _trans('delete'); ?>
                                </button>
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
        <?php } ?>
        </tbody>

    </table>
    </div>
    </div>

