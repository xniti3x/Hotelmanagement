    <div class="card">
        <div class="card-body table-responsive">
            <table id="example1" class="table table-hover text-nowrap">

                <thead>
                    <tr>
                        <th><?php _trans('status'); ?></th>
                        <th><?php _trans('invoice'); ?></th>
                        <th><?php _trans('created'); ?></th>
                        <th><?php _trans('due_date'); ?></th>
                        <th><?php _trans('client_name'); ?></th>
                        <th><?php _trans('amount'); ?></th>
                        <th><?php _trans('balance'); ?></th>
                        <th><?php _trans('options'); ?></th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $invoice_idx = 1;
                    $invoice_count = count($invoices);
                    $invoice_list_split = $invoice_count > 3 ? $invoice_count / 2 : 9999;
                    foreach ($invoices as $invoice) {
                        // Disable read-only if not applicable
                        if ($this->config->item('disable_read_only') == true) {
                            $invoice->is_read_only = 0;
                        }
                        // Convert the dropdown menu to a dropup if invoice is after the invoice split
                        $dropup = $invoice_idx > $invoice_list_split ? true : false;
                    ?>
                        <tr>
                            <td>
                                <span class="badge <?php echo $invoice_statuses[$invoice->invoice_status_id]['class']; ?>">
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
                                <a href="<?php echo site_url('invoices/view/' . $invoice->invoice_id); ?>" title="<?php _trans('edit'); ?>">
                                    <?php echo ($invoice->invoice_number ? $invoice->invoice_number : $invoice->invoice_id); ?>
                                </a>
                            </td>

                            <td>
                                <?php echo date_from_mysql($invoice->invoice_date_created); ?>
                            </td>

                            <td>
                                <span class="<?php if ($invoice->is_overdue) { ?>font-overdue<?php } ?>">
                                    <?php echo date_from_mysql($invoice->invoice_date_due); ?>
                                </span>
                            </td>

                            <td>
                                <a href="<?php echo site_url('clients/view/' . $invoice->client_id); ?>" title="<?php _trans('view_client'); ?>">
                                    <?php _htmlsc(format_client($invoice)); ?>
                                </a>
                            </td>

                            <td <?php if ($invoice->invoice_sign == '-1') {
                                    echo 'text-danger';
                                }; ?>">
                                <?php echo format_currency($invoice->invoice_total); ?>
                            </td>

                            <td>
                                <?php echo format_currency($invoice->invoice_balance); ?>
                            </td>

                            <td>
                                <div class="btn-group">
                                    <div class="btn btn-info"><i class="fa fa-cog"></i></div>
                                    <button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu" role="menu" style="">
                                        <a class="dropdown-item" href="<?php echo site_url('invoices/view/' . $invoice->invoice_id); ?>"><i class="fa fa-edit fa-margin"></i> <?php _trans('edit'); ?></a>
                                        <a class="dropdown-item" href="<?php echo site_url('invoices/generate_pdf/' . $invoice->invoice_id); ?>" target="_blank">
                                            <i class="fa fa-print fa-margin"></i> <?php _trans('download_pdf'); ?>
                                        </a>
                                        <a class="dropdown-item" href="<?php echo site_url('mailer/invoice/' . $invoice->invoice_id); ?>">
                                            <i class="fa fa-send"></i> <?php _trans('send_email'); ?>
                                        </a>
                                        <a href="#" class="invoice-add-payment dropdown-item" data-invoice-id="<?php echo $invoice->invoice_id; ?>" data-invoice-balance="<?php echo $invoice->invoice_balance; ?>" data-invoice-payment-method="<?php echo $invoice->payment_method; ?>">
                                            <i class="fa fa-money fa-margin"></i><?php _trans('enter_payment'); ?>
                                        </a>
                                        <form action="<?php echo site_url('invoices/delete/' . $invoice->invoice_id); ?>" method="POST">
                                            <?php _csrf_field(); ?>
                                            <button type="submit" class="dropdown-item" onclick="return confirm('<?php _trans('delete_invoice_warning'); ?>');">
                                                <i class="fa fa-trash"></i> <?php _trans('delete'); ?>
                                            </button>
                                        </form>
                                    </div>
                                </div>



                            </td>
                        </tr>
                    <?php
                        $invoice_idx++;
                    } ?>
                </tbody>

            </table>
        </div>
    </div>