
<div class="card">
<div class="card-body table-responsive">
    <table id="example1" class="table table-hover text-nowrap" style="text-align:left;">

        <thead>
            <tr>
                <th><?php _trans('Anzahl'); ?></th>
                <th><?php _trans('Zeitraum'); ?></th>
                <th><?php _trans('reservation'); ?></th>
                <th><?php _trans('created'); ?></th>
                <th><?php _trans('client_name'); ?></th>
                <th><?php _trans('options'); ?></th>
            </tr>
        </thead>

        <tbody>
            <?php
            $count = 1;
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
                        <?php echo $count;
                        $count++;  ?>
                    </td>
                    <td>
                        <?php echo (date_from_mysql($invoice->item_date_start) . " - " . date_from_mysql($invoice->item_date_end)); ?>
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
                        <a href="<?php echo site_url('clients/view/' . $invoice->client_id); ?>" title="<?php _trans('view_client'); ?>">
                            <?php _htmlsc(format_client($invoice)); ?>
                        </a>
                    </td>

                    <td>
                        <div class="btn-group">
                            <div class="btn btn-info"><i class="fa fa-cog"></i></div>
                            <button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu" role="menu" style="">
                                <a class="dropdown-item" href="<?php echo site_url('invoices/view/' . $invoice->invoice_id); ?>"><i class="fa fa-edit fa-margin"></i> <?php _trans('edit'); ?></a>
                                <a class="dropdown-item" href="<?php echo site_url('invoices/convertToInvoice/' . $invoice->invoice_id); ?>"><i class="fa fa-edit fa-margin"></i> <?php _trans('create_invoice'); ?></a>
                                <div class="dropdown-divider"></div>
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
