<script>
    $(function() {
        var clicked_item_temp = null;

        $('body').on('focus', '#btn_modal_room', function() {
            clicked_item_temp = $(this).parent().parent().find("[name=item_room]");
            $('.modal_numbers').modal({
                show: true
            });
        });

        $(document).on('click', '.room_btn', function() {
            $(clicked_item_temp).val($(this).text());
        });

        $('body').on('click', '#btn_modal_price', function() {
            clicked_item_temp = $(this).parent().parent().find("[name=item_price]");
            $('.modal_price_select').modal({
                show: true
            });
        });

        $(document).on('click', '.price_btn', function() {
            $(clicked_item_temp).val($(this).text());
        });
    });
</script>

<div class="card card-primary">
    <div class="card-body table-responsive p-0">
        <table id="item_table" class="table table-hover text-nowrap">
            <thead class="bg-info color-palette" style="">
                <tr>
                    <th></th>
                    <th><?php _trans('price'); ?></th>
                    <th><?php _trans('Zeitraum von-bis'); ?></th>
                    <th><?php _trans('Zimmer'); ?></th>
                    <th><?php _trans('quantity'); ?></th>
                    <th><?php _trans('posten'); ?></th>
                    <th><?php _trans('description'); ?></th>
                    <th><?php _trans('tax'); ?></th>
                    <th></th>
                </tr>
            </thead>

            <tbody id="new_row" style="display: none;">
                <tr>
                    <td rowspan="2" class="td-icon">
                        <i class="fa fa-arrows cursor-move"></i>
                        <?php if ($invoice->invoice_is_recurring) : ?>
                            <br />
                            <i title="<?php echo trans('recurring') ?>" class="js-item-recurrence-toggler cursor-pointer fa fa-calendar-o text-muted"></i>
                            <input type="hidden" name="item_is_recurring" value="" />
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="input-group mb-3" style="min-width: 110px;">
                            <div class="input-group-prepend">
                                <button type="button" id="btn_modal_price" class="btn btn-info"><i class="fa-solid fa fa-circle"></i></button>
                            </div>
                            <input style="min-width: 60px;" type="number" min="5" name="item_price" step="5" class="form-control form-control-border" value="50">
                        </div>
                    </td>
                    <td>
                        <div class="input-group input-daterange">
                            <input type="text" name="item_date_start" autocomplete="off" class=" form-control datepickerItem" value="<?php echo format_date(date("Y-m-d")); ?>">
                            <input type="text" name="item_date_end" autocomplete="off" class=" form-control datepickerItem" value="<?php echo format_date(date('Y-m-d', strtotime("+1 day"))); ?>">
                        </div>
                    </td>
                    <td>

                    <div class="input-group mb-3" style="min-width: 80px;">
                        <div class="input-group-prepend">
                            <button type="button" id="btn_modal_room" class="btn btn-info"><i class="fa-solid fa fa-square"></i></button>
                        </div>
                        <input type="number" style="min-width: 40px;" name="item_room" min="1" class=" form-control number" value="1">
                    </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <input type="number" name="item_quantity" autoco class=" form-control amount" value="1">
                        </div>
                    </td>
                    <td class="td-text">
                        <input type="hidden" name="invoice_id" value="<?php echo $invoice_id; ?>">
                        <input type="hidden" name="item_id" value="">
                        <input type="hidden" name="item_product_id" value="">
                        <input type="hidden" name="item_task_id" class="item-task-id" value="">

                        <div class="input-group">
                            <input type="text" name="item_name" class=" form-control" value="Übernachtung ohne Frühstück">
                        </div>
                    </td>
                    <td class="td-textarea">
                        <div class="input-group">
                            <textarea name="item_description" class=" form-control"></textarea>
                        </div>
                    </td>

                    <td>
                        <div class="input-group">
                            <select name="item_tax_rate_id" class="form-control ">
                                <option value="0"><?php _trans('none'); ?></option>
                                <?php foreach ($tax_rates as $tax_rate) { ?>
                                    <option <?php echo $tax_rate->tax_rate_id==1?"selected":""; ?> value="<?php echo $tax_rate->tax_rate_id; ?>" <?php check_select(get_setting('default_item_tax_rate'), $tax_rate->tax_rate_id); ?>>
                                        <?php echo format_amount($tax_rate->tax_rate_percent) . '% - ' . $tax_rate->tax_rate_name; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </td>
                    <td>
                        <button type="button" class="btn_delete_item btn btn-danger btn-flat" title="<?php _trans('delete'); ?>">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>

            </tbody>

            <?php foreach ($items as $item) { ?>
                <tbody class="item">
                    <tr>
                        <td rowspan="2" class="td-icon">
                            <i class="fa fa-arrows cursor-move"></i>
                            <?php
                            if ($invoice->invoice_is_recurring) :
                                if ($item->item_is_recurring == 1 || is_null($item->item_is_recurring)) {
                                    $item_recurrence_state = '1';
                                    $item_recurrence_class = 'fa-calendar-check-o text-success';
                                } else {
                                    $item_recurrence_state = '0';
                                    $item_recurrence_class = 'fa-calendar-o text-muted';
                                }
                            ?>
                                <br />
                                <i title="<?php echo trans('recurring') ?>" class="js-item-recurrence-toggler cursor-pointer fa <?php echo $item_recurrence_class ?>"></i>
                                <input type="hidden" name="item_is_recurring" value="<?php echo $item_recurrence_state ?>" />
                            <?php endif; ?>
                        </td>

                        <td>
                            <div class="input-group mb-3" style="min-width: 110px;">
                                <div class="input-group-prepend">
                                    <button type="button" id="btn_modal_price" class="btn btn-info"><i class="fa-solid fa fa-circle"></i></button>
                                </div>
                                <input style="min-width: 60px;" type="number" min="5" name="item_price" step="5" class="form-control form-control-border" value="<?php echo format_amount($item->item_price); ?>" <?php if ($invoice->is_read_only == 1) {
                                                                                                                                                                                                                        echo 'disabled="disabled"';
                                                                                                                                                                                                                    } ?>>
                            </div>
                        </td>
                        <td>
                            <div class="input-group input-daterange" style="min-width: 190px;">
                                <input style="min-width: 90px;" name="item_date_start" autocomplete="off" class=" form-control datepicker datepickerItem" value="<?php if (property_exists($item, 'item_date_start')) echo format_date($item->item_date_start); ?>" <?php if ($invoice->is_read_only == 1) {
                                                                                                                                                                                                                                                                        echo 'disabled="disabled"';
                                                                                                                                                                                                                                                                    } ?>>
                                <input style="min-width: 90px;" type="text" name="item_date_end" autocomplete="off" class=" form-control datepicker datepickerItem" value="<?php if (property_exists($item, 'item_date_end')) echo format_date($item->item_date_end); ?>" <?php if ($invoice->is_read_only == 1) {
                                                                                                                                                                                                                                                                                echo 'disabled="disabled"';
                                                                                                                                                                                                                                                                            } ?>>
                            </div>
                        </td>
                        <td>
                            <div class="input-group mb-3" style="min-width: 80px;">
                                <div class="input-group-prepend">
                                    <button type="button" id="btn_modal_room" class="btn btn-info"><i class="fa-solid fa fa-square"></i></button>
                                </div>
                                <input type="number" style="min-width: 40px;" name="item_room" min="1" class=" form-control number" value="<?php echo ($item->item_room); ?>">
                            </div>

                        </td>
                        <td class="td-amount td-quantity">
                            <div class="input-group">
                                <input type="number" style="min-width: 60px;" min="1" name="item_quantity" class=" form-control" value="<?php echo format_amount($item->item_quantity); ?>" <?php if ($invoice->is_read_only == 1) {
                                                                                                                                                                                                echo 'disabled="disabled"';
                                                                                                                                                                                            } ?>>
                            </div>
                        </td>
                        <td class="td-text">
                            <input type="hidden" name="invoice_id" value="<?php echo $invoice_id; ?>">
                            <input type="hidden" name="item_id" value="<?php echo $item->item_id; ?>" <?php if ($invoice->is_read_only == 1) {
                                                                                                            echo 'disabled="disabled"';
                                                                                                        } ?>>
                            <input type="hidden" name="item_task_id" class="item-task-id" value="<?php if ($item->item_task_id) {
                                                                                                        echo $item->item_task_id;
                                                                                                    } ?>">
                            <input type="hidden" name="item_product_id" value="<?php echo $item->item_product_id; ?>">

                            <div class="input-group">
                                <input type="text" style="min-width: 150px;" name="item_name" class=" form-control" value="<?php _htmlsc($item->item_name); ?>" <?php if ($invoice->is_read_only == 1) {
                                                                                                                                                                    echo 'disabled="disabled"';
                                                                                                                                                                } ?>>
                            </div>
                        </td>
                        <td class="td-textarea">
                            <div class="input-group">
                                <textarea name="item_description" style="min-width: 150px;" class=" form-control" <?php if ($invoice->is_read_only == 1) {
                                                                                                                        echo 'disabled="disabled"';
                                                                                                                    } ?>><?php echo htmlsc($item->item_description); ?></textarea>
                            </div>
                        </td>
                        <td>
                            <div class="input-group">
                                <select name="item_tax_rate_id" style="min-width: 80px;" class="form-control " <?php if ($invoice->is_read_only == 1) {
                                                                                                                    echo 'disabled="disabled"';
                                                                                                                } ?>>
                                    <option value="0"><?php _trans('none'); ?></option>
                                    <?php foreach ($tax_rates as $tax_rate) { ?>
                                        <option value="<?php echo $tax_rate->tax_rate_id; ?>" <?php check_select($item->item_tax_rate_id, $tax_rate->tax_rate_id); ?>>
                                            <?php echo format_amount($tax_rate->tax_rate_percent) . '% - ' . $tax_rate->tax_rate_name; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </td>
                        <td>
                            <?php if ($invoice->is_read_only != 1) : ?>
                                <button type="button" class="btn_delete_item btn btn-danger btn-flat" title="<?php _trans('delete'); ?>" data-item-id="<?php echo $item->item_id; ?>">
                                    <i class="fa fa-trash"></i>
                                </button>
                            <?php endif; ?>
                        </td>
                    </tr>
                </tbody>
            <?php } ?>

        </table>
    </div>
</div>

<br>

<div class="row">
    <div class="col-xs-12 col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="btn-group">
                    <?php if ($invoice->is_read_only != 1) { ?>
                        <a href="#" class="btn_add_row btn btn-info btn-flat">
                            <i class="fa fa-plus"></i> <?php _trans('add_new_row'); ?>
                        </a>
                        <a href="#" class="btn_add_product btn btn-info btn-flat">
                            <i class="fa fa-plus"></i>
                            <?php _trans('product'); ?>
                        </a>
                        <a href="#" class="btn_copy_row btn btn-info btn-flat">
                            <i class="fa fa-copy"></i> <?php _trans('Letzte Zeile'); ?>
                        </a>
                    <?php } ?>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td>Rechnung</td>
                        <td><input type="text" id="invoice_number" class="form-control input-sm" <?php if ($invoice->invoice_number) : ?> value="<?php echo $invoice->invoice_number; ?>" <?php else : ?> placeholder="<?php _trans('not_set'); ?>" <?php endif; ?> <?php if ($invoice->is_read_only == 1) {
                                                                                                                                                                                                                                                                        echo 'disabled="disabled"';
                                                                                                                                                                                                                                                                    } ?>></td>
                    </tr>
                    <tr>
                        <td>Datum erstellt</td>
                        <td><input name="invoice_date_created" id="invoice_date_created" class="form-control datepicker" value="<?php echo date_from_mysql($invoice->invoice_date_created); ?>" <?php if ($invoice->is_read_only == 1) {
                                                                                                                                                                                                    echo 'disabled="disabled"';
                                                                                                                                                                                                } ?>></td>
                    </tr>
                    <tr>
                        <td>Datum Fälling</td>
                        <td><input name="invoice_date_due" id="invoice_date_due" class="form-control datepicker" value="<?php echo date_from_mysql($invoice->invoice_date_due); ?>" <?php if ($invoice->is_read_only == 1) {
                                                                                                                                                                                        echo 'disabled="disabled"';
                                                                                                                                                                                    } ?>> </td>
                    </tr>
                    <tr>
                        <td>Zahlungsmethode</td>
                        <td><select name="payment_method" id="payment_method" class="form-control input-sm simple-select" <?php if ($invoice->is_read_only == 1 && $invoice->invoice_status_id == 4) {
                                                                                                                                echo 'disabled="disabled"';
                                                                                                                            } ?>>
                                <option value="0"><?php _trans('select_payment_method'); ?></option>
                                <?php foreach ($payment_methods as $payment_method) { ?>
                                    <option <?php check_select(
                                                $invoice->payment_method,
                                                $payment_method->payment_method_id
                                            ) ?> value="<?php echo $payment_method->payment_method_id; ?>">
                                        <?php echo $payment_method->payment_method_name; ?>
                                    </option>
                                <?php } ?>
                            </select></td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td><select name="invoice_status_id" id="invoice_status_id" class="form-control input-sm simple-select" data-minimum-results-for-search="Infinity" <?php if ($invoice->is_read_only == 1 && $invoice->invoice_status_id == 4) {
                                                                                                                                                                                echo 'disabled="disabled"';
                                                                                                                                                                            } ?>>
                                <?php foreach ($invoice_statuses as $key => $status) { ?>
                                    <option value="<?php echo $key; ?>" <?php if ($key == $invoice->invoice_status_id) { ?>selected="selected" <?php } ?>>
                                        <?php echo $status['label']; ?>
                                    </option>
                                <?php } ?>
                            </select></td>
                    </tr>
                </table>

            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-6">

        <div class="card">
            <div class="card-body table-responsive">
                <table class="table-hover table">
                    <tr>
                        <td><?php _trans('subtotal'); ?></td>
                        <td><?php echo format_currency($invoice->invoice_item_subtotal); ?></td>
                    </tr>
                    <tr>
                        <td><?php _trans('item_tax'); ?></td>
                        <td class="amount"><?php echo format_currency($invoice->invoice_item_tax_total); ?></td>
                    </tr>
                    <tr>
                        <td><?php _trans('invoice_tax'); ?></td>
                        <td>
                            <?php if ($invoice_tax_rates) {
                                foreach ($invoice_tax_rates as $invoice_tax_rate) { ?>
                                    <form method="post" action="<?php echo site_url('invoices/delete_invoice_tax/' . $invoice->invoice_id . '/' . $invoice_tax_rate->invoice_tax_rate_id) ?>">
                                        <?php _csrf_field(); ?>
                                        <button type="submit" class="btn btn-xs btn-link" onclick="return confirm('<?php _trans('delete_tax_warning'); ?>');">
                                            <i class="fa fa-trash-o"></i>
                                        </button>
                                        <span class="text-muted">
                                            <?php echo htmlsc($invoice_tax_rate->invoice_tax_rate_name) . ' ' . format_amount($invoice_tax_rate->invoice_tax_rate_percent) . '%' ?>
                                        </span>
                                        <span class="amount">
                                            <?php echo format_currency($invoice_tax_rate->invoice_tax_rate_amount); ?>
                                        </span>
                                    </form>
                            <?php }
                            } else {
                                echo format_currency('0');
                            } ?>
                        </td>
                    </tr>
                    <tr hidden class="hidden">
                        <td class="td-vert-middle"><?php _trans('discount'); ?></td>
                        <td class="clearfix">
                            <div class="discount-field">
                                <div class="input-group input-group-sm">
                                    <input id="invoice_discount_amount" name="invoice_discount_amount" class="discount-option form-control  amount" value="<?php echo format_amount($invoice->invoice_discount_amount != 0 ? $invoice->invoice_discount_amount : ''); ?>" <?php if ($invoice->is_read_only == 1) {
                                                                                                                                                                                                                                                                                echo 'disabled="disabled"';
                                                                                                                                                                                                                                                                            } ?>>
                                    <div class="input-group-addon"><?php echo get_setting('currency_symbol'); ?></div>
                                </div>
                            </div>
                            <div class="discount-field">
                                <div class="input-group input-group-sm">
                                    <input id="invoice_discount_percent" name="invoice_discount_percent" value="<?php echo format_amount($invoice->invoice_discount_percent != 0 ? $invoice->invoice_discount_percent : ''); ?>" class="discount-option form-control  amount" <?php if ($invoice->is_read_only == 1) {
                                                                                                                                                                                                                                                                                    echo 'disabled="disabled"';
                                                                                                                                                                                                                                                                                } ?>>
                                    <div class="input-group-addon">&percnt;</div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><?php _trans('total'); ?></td>
                        <td class="amount"><b><?php echo format_currency($invoice->invoice_total); ?></b></td>
                    </tr>
                    <tr>
                        <td><?php _trans('paid'); ?></td>
                        <td class="amount"><b><?php echo format_currency($invoice->invoice_paid); ?></b></td>
                    </tr>
                    <tr>
                        <td><b><?php _trans('balance'); ?></b></td>
                        <td class="amount"><b><?php echo format_currency($invoice->invoice_balance); ?></b></td>
                    </tr>
                </table>
            </div>
        </div>

    </div>
</div>


<div id="card">
    <div class="card-header">
        <div class="card-tools">
            <div class="headerbar-item pull-right <?php if ($invoice->is_read_only != 1 || $invoice->invoice_status_id != 4) { ?>btn-group<?php } ?>">

                <div class="btn-group ">
                    <button type="button" class="btn btn-info btn-flat dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <button type="button" class="btn btn-info btn-flat"><?php _trans('options'); ?></button>
                    <div class="dropdown-menu" role="menu" style="">
                        <?php if ($invoice->invoice_group_id != 5) : ?>
                            <?php if ($invoice->is_read_only != 1) { ?>
                                <a class="dropdown-item" href="#" id="btn_generate_pdf" data-invoice-id="<?php echo $invoice_id; ?>">
                                    <i class="fa fa-print fa-margin"></i>
                                    <?php _trans('download_pdf'); ?>
                                </a>

                                <a class="dropdown-item" href="<?php echo site_url('mailer/invoice/' . $invoice->invoice_id); ?>">
                                    <i class="fa fa-send"></i>
                                    <?php _trans('send_email'); ?>
                                </a>


                                <a href="#" id="btn_copy_invoice" class="dropdown-item" data-invoice-id="<?php echo $invoice_id; ?>">
                                    <i class="fa fa-copy fa-margin"></i>
                                    <?php _trans('copy_invoice'); ?>
                                </a>
                                <?php if ($invoice->invoice_balance != 0) : ?>

                                    <a href="#" class="invoice-add-payment dropdown-item" data-invoice-id="<?php echo $invoice_id; ?>" data-invoice-balance="<?php echo $invoice->invoice_balance; ?>" data-invoice-payment-method="<?php echo $invoice->payment_method; ?>" data-payment-cf-exist="<?php echo $payment_cf_exist; ?>">
                                        <i class="fa fa-credit-card fa-margin"></i>
                                        <?php _trans('enter_payment'); ?>
                                    </a>

                                <?php endif; ?>
                                <a href="#add-invoice-tax" class="dropdown-item" data-toggle="modal">
                                    <i class="fa fa-plus fa-margin"></i> <?php _trans('add_invoice_tax'); ?>
                                </a>

                            <?php } ?>

                            <a href="#" class="dropdown-item" id="btn_create_credit" data-invoice-id="<?php echo $invoice_id; ?>">
                                <i class="fa fa-minus fa-margin"></i> <?php _trans('create_credit_invoice'); ?>
                            </a>


                        <?php endif; ?>
                        <?php if ($invoice->invoice_group_id == 5) : ?>

                            <a class="dropdown-item" href="<?php echo site_url('invoices/convertToInvoice/' . $invoice->invoice_id); ?>">
                                <i class="fa fa-send fa-margin"></i>
                                <?php _trans('Rechnung erstellen'); ?>
                            </a>

                            <a class="dropdown-item" href="#" id="btn_create_recurring" data-invoice-id="<?php echo $invoice_id; ?>">
                                <i class="fa fa-refresh fa-margin"></i>
                                <?php _trans('create_recurring'); ?>
                            </a>

                        <?php endif; ?>
                        <div class="dropdown-divider"></div>
                        <?php if ($invoice->invoice_status_id == 1 || ($this->config->item('enable_invoice_deletion') === true && $invoice->is_read_only != 1)) { ?>

                            <form action="<?php echo site_url('invoices/delete/' . $invoice->invoice_id); ?>" method="POST">
                                <?php _csrf_field(); ?>

                                <button type="submit" class="dropdown-item btn-danger bg-danger">
                                    <i class="fa fa-trash"></i> <?php echo trans('delete') ?>
                                </button>

                            </form>

                        <?php } ?>
                    </div>
                </div>

                <?php if ($invoice->is_read_only != 1 || $invoice->invoice_status_id != 4) { ?>
                    <a href="#" class="btn btn-success btn-flat btn-success ajax-loader" id="btn_save_invoice">
                        <i class="fa fa-check"></i> <?php _trans('save'); ?>
                    </a>
                <?php } ?>
            </div>

            <div class="headerbar-item invoice-labels pull-right">
                <?php if ($invoice->invoice_is_recurring) { ?>
                    <span class="label label-info">
                        <i class="fa fa-refresh"></i>
                        <?php _trans('recurring'); ?>
                    </span>
                <?php } ?>
                <?php if ($invoice->is_read_only == 1) { ?>
                    <span class="label label-danger">
                        <i class="fa fa-read-only"></i> <?php _trans('read_only'); ?>
                    </span>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<div class="modal modal_numbers" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                Zimmer Auswahl
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <?php for ($i = 1; $i < 22; $i++) { ?>
                        <button class="room_btn btn btn-outline-info btn-lg" data-dismiss="modal"><?php echo $i; ?></button>
                    <?php } ?>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal modal_price_select" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                Preis Auswahl
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <?php for ($i = 10; $i < 155; $i += 5) { ?>
                        <button class="price_btn btn btn-outline-info btn-lg" data-dismiss="modal"><?php echo $i; ?></button>
                    <?php } ?>
                </div>
            </div>

        </div>
    </div>
</div>