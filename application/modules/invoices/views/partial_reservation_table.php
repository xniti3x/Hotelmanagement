<div class="table-responsive">
    <table class="table table-hover table-striped">

        <thead>
        <tr>
            <th><?php _trans('status'); ?></th>
            <th><?php _trans('reservation'); ?></th>
            <th><?php _trans('created'); ?></th>
            <th><?php _trans('client_name'); ?></th>
            <th><?php _trans('days'); ?></th>
            <th style="text-align: right;"><?php _trans('amount'); ?></th>
            <th><?php _trans('options'); ?></th>
        </tr>
        </thead>

        <tbody>
        <?php
        $invoice_idx = 1;
        $invoice_count = count($reservations);
        $invoice_list_split = $invoice_count > 3 ? $invoice_count / 2 : 9999;
        foreach ($reservations as $invoice) {
            // Disable read-only if not applicable
            if ($this->config->item('disable_read_only') == true) {
                $invoice->is_read_only = 0;
            }
            // Convert the dropdown menu to a dropup if invoice is after the invoice split
            $dropup = $invoice_idx > $invoice_list_split ? true : false;
            ?>
            <tr>
                <td>
                    <span class="label <?php echo $invoice_statuses[$invoice->invoice_status_id]['class']; ?>">
                        <?php echo $invoice_statuses[$invoice->invoice_status_id]['label'];
                        if ($invoice->invoice_sign == '-1') { ?>
                            &nbsp;<i class="fa fa-credit-invoice" title="<?php echo trans('credit_invoice') ?>"></i>
                        <?php } ?>
                        <?php if ($invoice->is_read_only) { ?>
                            &nbsp;<i class="fa fa-read-only" title="<?php _trans('read_only') ?>"></i>
                        <?php } ?>
                        <?php if ($invoice->invoice_is_recurring) { ?>
                            &nbsp;<i class="fa fa-refresh" title="<?php echo trans('recurring') ?>"></i>
                        <?php } ?>
                    </span>
                </td>

                <td>
                    <a href="<?php echo site_url('invoices/view/' . $invoice->invoice_id); ?>"
                       title="<?php _trans('edit'); ?>">
                        <?php echo($invoice->invoice_number ? $invoice->invoice_number : $invoice->invoice_id); ?>
                    </a>
                </td>

                <td>
                    <?php echo date_from_mysql($invoice->invoice_date_created); ?>
                </td>
                <td>
                    <a href="<?php echo site_url('clients/view/' . $invoice->client_id); ?>"
                       title="<?php _trans('view_client'); ?>">
                        <?php _htmlsc(format_client($invoice)); ?>
                    </a>
                </td>
                <td>
                <?php
                $days = (strtotime($invoice->product_items[0]['item_date_start'])-strtotime('now')) / (60 * 60 * 24);
                echo (int)$days;
                ?></td>
                <td class="amount <?php if ($invoice->invoice_sign == '-1') {
                    echo 'text-danger';
                }; ?>">
                    <?php echo format_currency($invoice->invoice_total); ?>
                </td>
                <td>
                    <div class="options btn-group<?php echo $dropup ? ' dropup' : ''; ?>">
                        <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-cog"></i> <?php _trans('options'); ?>
                        </a>
                        <ul class="dropdown-menu">
                            <?php if ($invoice->is_read_only != 1) { ?>
                                <li>
                                    <a href="<?php echo site_url('invoices/view/' . $invoice->invoice_id); ?>">
                                        <i class="fa fa-edit fa-margin"></i> <?php _trans('edit'); ?>
                                    </a>
                                </li>
                            <?php } ?>
                                <li>
                                    <a href="<?php echo site_url('invoices/convertToInvoice/' . $invoice->invoice_id); ?>">
                                        <i class="fa fa-edit fa-margin"></i> <?php _trans('create_invoice'); ?>
                                    </a>
                                </li>  
                                <li>
                                    <form action="<?php echo site_url('invoices/delete/' . $invoice->invoice_id); ?>"
                                          method="POST">
                                        <?php _csrf_field(); ?>
                                        <button type="submit" class="dropdown-button"
                                                onclick="return confirm('<?php _trans('delete_invoice_warning'); ?>');">
                                            <i class="fa fa-trash-o fa-margin"></i> <?php _trans('delete'); ?>
                                        </button>
                                    </form>
                                </li>
                        </ul>
                    </div>
                </td>
            </tr>
            <?php
            $invoice_idx++;
        } ?>
        </tbody>

    </table>
</div>
