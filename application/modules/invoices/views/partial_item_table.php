<div class="table-responsive">
    <table id="item_table" class="items table table-condensed">
        <thead style="">
        <tr>
            <th></th>
            <th><?php _trans('price'); ?></th>
            <th><?php _trans('Daterange'); ?></th>
            <th><?php _trans('room'); ?></th>
            <th><?php _trans('quantity'); ?></th>
            <th><?php _trans('item'); ?></th>
            <th><?php _trans('description'); ?></th>
             <th><?php _trans('tax_rate'); ?></th>
            <th></th>
        </tr>
        </thead>

        <tbody id="new_row" style="display: none;">
        <tr>
            <td rowspan="2" class="td-icon">
                <i class="fa fa-arrows cursor-move"></i>
                <?php if ($invoice->invoice_is_recurring) : ?>
                    <br/>
                    <i title="<?php echo trans('recurring') ?>"
                       class="js-item-recurrence-toggler cursor-pointer fa fa-calendar-o text-muted"></i>
                    <input type="hidden" name="item_is_recurring" value=""/>
                <?php endif; ?>
            </td>
            <td class="td-amount">
                <div class="input-group">
                    <span id="btn_price" class="btn btn-primary input-group-addon"><i class="fa fa-money"></i></span> 
                    <input type="number" name="item_price" class="input-sm form-control amount" value="50">
                </div>
            </td>
            <td class="td-amount">
            <div class="input-group input-daterange">
                <input type="text" name="item_date_start" autocomplete="off" class="input-sm form-control datepickerItem" value="<? echo date("d-m-Y"); ?>">
                <div class="input-group-addon">-</div>
                <input type="text" name="item_date_end" autocomplete="off" class="input-sm form-control datepickerItem" value="<? echo date("d-m-Y",strtotime("+1 day")); ?>">
            </div>
            </td>
            <td class="td-amount">
                <div class="input-group">
                    <span id="btn_room" class="btn btn-primary input-group-addon"><i class="fa fa-cube"></i></span> 
                    <input type="number" name="item_room" min="1" class="input-sm form-control number" value="1">
                </div> 
                
            </td>
            <td class="td-amount">
                <div class="input-group">
                    <input type="number" name="item_quantity" autoco class="input-sm form-control amount" value="1">
                </div>
            </td>
            <td class="td-text">
                <input type="hidden" name="invoice_id" value="<?php echo $invoice_id; ?>">
                <input type="hidden" name="item_id" value="">
                <input type="hidden" name="item_product_id" value="1">
                <input type="hidden" name="item_task_id" class="item-task-id" value="">
                
                <div class="input-group">
                    <input type="text" name="item_name" class="input-sm form-control" value="Übernachtung ohne Frühstück">
                </div>
            </td>
            <td class="td-textarea">
                <div class="input-group">
                    <textarea name="item_description" class="input-sm form-control"></textarea>
                </div>
            </td>
            
            <td class="td-amount">
                <div class="input-group">
                    <select name="item_tax_rate_id" class="form-control input-sm">
                        <option value="0"><?php _trans('none'); ?></option>
                        <?php foreach ($tax_rates as $tax_rate) { ?>
                            <option value="<?php echo $tax_rate->tax_rate_id; ?>"
                                <?php check_select(get_setting('default_item_tax_rate'), $tax_rate->tax_rate_id); ?>>
                                <?php echo format_amount($tax_rate->tax_rate_percent) . '% - ' . $tax_rate->tax_rate_name; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </td>
            <td class="td-icon text-right td-vert-middle">
                <button type="button" class="btn_delete_item btn btn-link btn-sm" title="<?php _trans('delete'); ?>">
                    <i class="fa fa-trash-o text-danger"></i>
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
                        <br/>
                        <i title="<?php echo trans('recurring') ?>"
                           class="js-item-recurrence-toggler cursor-pointer fa <?php echo $item_recurrence_class ?>"></i>
                        <input type="hidden" name="item_is_recurring" value="<?php echo $item_recurrence_state ?>"/>
                    <?php endif; ?>
                </td>

                <td style="min-width: 90px; max-width: 90px;">
                    <div class="input-group">
                        <span id="btn_price" class="btn btn-primary input-group-addon"><i class="fa fa-money"></i></span>
                        <input type="number"  min="1" name="item_price" class="input-sm form-control amount"
                        value="<?php echo format_amount($item->item_price); ?>"
                        <?php if ($invoice->is_read_only == 1) {
                            echo 'disabled="disabled"';
                        } ?>>
                    </div>
                </td>
                <td style="min-width: 200px; max-width: 200px;">
                <div class="input-group input-daterange">
                <input name="item_date_start" autocomplete="off" class="input-sm form-control datepicker datepickerItem"
                        value="<?php if (property_exists($item, 'item_date_start')) echo format_date($item->item_date_start); ?>"
                        
                        <?php if ($invoice->is_read_only == 1) {
                            echo 'disabled="disabled"';
                        } ?>>
                        <div class="input-group-addon">-</div>
                    <input type="text" name="item_date_end" autocomplete="off" class="input-sm form-control datepicker datepickerItem"
                        value="<?php if (property_exists($item, 'item_date_end')) echo format_date($item->item_date_end); ?>"
                        
                        <?php if ($invoice->is_read_only == 1) {
                            echo 'disabled="disabled"';
                        } ?>>
                </div>
                </td>
                <td style="min-width: 70px; max-width: 70px;">
                    <div class="input-group">
                        <span id="btn_room" class="btn btn-primary input-group-addon"><i class="fa fa-cube"></i></span> 
                        <input type="number" style="max-width: 70px;" name="item_room" min="1" class="input-sm form-control number"  value="<?php echo ($item->item_room); ?>">
                    </div> 
                    
                </td>
                <td style="min-width: 70px; max-width: 70px;">
                    <div class="input-group">
                        <input type="number" style="max-width: 70px;" min="1" name="item_quantity" class="input-sm form-control amount"
                        value="<?php echo format_amount($item->item_quantity); ?>"
                        <?php if ($invoice->is_read_only == 1) {
                            echo 'disabled="disabled"';
                        } ?>>
                    </div>
                </td>
                <td style="min-width: 200px; max-width: 200px;">
                    <input type="hidden" name="invoice_id" value="<?php echo $invoice_id; ?>">
                    <input type="hidden" name="item_id" value="<?php echo $item->item_id; ?>"
                        <?php if ($invoice->is_read_only == 1) {
                            echo 'disabled="disabled"';
                        } ?>>
                    <input type="hidden" name="item_task_id" class="item-task-id"
                           value="<?php if ($item->item_task_id) {
                               echo $item->item_task_id;
                           } ?>">
                    <input type="hidden" name="item_product_id" value="<?php echo $item->item_product_id; ?>">
                    
                    <div class="input-group">
                        <input type="text" name="item_name" class="input-sm form-control"
                        value="<?php _htmlsc($item->item_name); ?>"
                        <?php if ($invoice->is_read_only == 1) {
                            echo 'disabled="disabled"';
                        } ?>>
                    </div>
                </td>
                <td style="min-width: 150px; max-width: 150px;">
                    <div class="input-group">
                        <textarea name="item_description"
                        class="input-sm form-control"
                        <?php if ($invoice->is_read_only == 1) {
                            echo 'disabled="disabled"';
                        } ?>><?php echo htmlsc($item->item_description); ?></textarea>
                </div>
                </td>
                <td style="min-width: 100px; max-width: 100px;">
                    <div class="input-group">
                        <select name="item_tax_rate_id" class="form-control input-sm"
                            <?php if ($invoice->is_read_only == 1) {
                                echo 'disabled="disabled"';
                            } ?>>
                            <option value="0"><?php _trans('none'); ?></option>
                            <?php foreach ($tax_rates as $tax_rate) { ?>
                                <option value="<?php echo $tax_rate->tax_rate_id; ?>"
                                    <?php check_select($item->item_tax_rate_id, $tax_rate->tax_rate_id); ?>>
                                    <?php echo format_amount($tax_rate->tax_rate_percent) . '% - ' . $tax_rate->tax_rate_name; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </td>
                <td class="td-icon text-right td-vert-middle">
                    <?php if ($invoice->is_read_only != 1): ?>
                        <button type="button" class="btn_delete_item btn btn-link btn-sm" title="<?php _trans('delete'); ?>"
                            data-item-id="<?php echo $item->item_id; ?>">
                            <i class="fa fa-trash-o text-danger"></i>
                        </button>
                        <?php endif; ?>
                </td>
            </tr>
            </tbody>
        <?php } ?>

    </table>
</div>

<br>

<div class="row">
    <div class="col-xs-12 col-md-4">
        <div class="btn-group">
            <?php if ($invoice->is_read_only != 1) { ?>
                <a href="#" class="btn_add_row btn btn-sm btn-default">
                    <i class="fa fa-plus"></i> <?php _trans('Zeile'); ?>
                </a>
                <a href="#" class="btn_add_product btn btn-sm btn-default">
                    <i class="fa fa-plus"></i>
                    <?php _trans('product'); ?>
                </a>
                <a href="#" class="btn_copy_row btn btn-sm btn-default">
                    <i class="fa fa-copy"></i> <?php _trans('Letzte Zeile'); ?>
                </a> 
            <?php } ?>
        </div>
    </div>
    
    <div class="col-xs-12 visible-xs visible-sm"><br></div>

    <div class="col-xs-12 col-md-6 col-md-offset-2 col-lg-4 col-lg-offset-4">
        <table class="table table-bordered text-right">
            <tr>
                <td style="width: 40%;"><?php _trans('subtotal'); ?></td>
                <td style="width: 60%;"
                    class="amount"><?php echo format_currency($invoice->invoice_item_subtotal); ?></td>
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
                            <form method="post"
                                action="<?php echo site_url('invoices/delete_invoice_tax/' . $invoice->invoice_id . '/' . $invoice_tax_rate->invoice_tax_rate_id) ?>">
                                <?php _csrf_field(); ?>
                                <button type="submit" class="btn btn-xs btn-link"
                                        onclick="return confirm('<?php _trans('delete_tax_warning'); ?>');">
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
            <tr class="hidden">
                <td class="td-vert-middle"><?php _trans('discount'); ?></td>
                <td class="clearfix">
                    <div class="discount-field">
                        <div class="input-group input-group-sm">
                            <input id="invoice_discount_amount" name="invoice_discount_amount"
                                   class="discount-option form-control input-sm amount"
                                   value="<?php echo format_amount($invoice->invoice_discount_amount != 0 ? $invoice->invoice_discount_amount : ''); ?>"
                                <?php if ($invoice->is_read_only == 1) {
                                    echo 'disabled="disabled"';
                                } ?>>
                            <div class="input-group-addon"><?php echo get_setting('currency_symbol'); ?></div>
                        </div>
                    </div>
                    <div class="discount-field">
                        <div class="input-group input-group-sm">
                            <input id="invoice_discount_percent"  name="invoice_discount_percent"
                                   value="<?php echo format_amount($invoice->invoice_discount_percent != 0 ? $invoice->invoice_discount_percent : ''); ?>"
                                   class="discount-option form-control input-sm amount"
                                <?php if ($invoice->is_read_only == 1) {
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
                <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                    <?php for ($i = 1; $i < 22; $i++) { ?>
                        <button class="room_btn btn" style="width:50px;" data-dismiss="modal"><?php echo $i; ?></button>
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
                <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                    <?php for ($i = 10; $i < 155; $i += 5) { ?>
                        <button style="width:50px;" class="price_btn btn" data-dismiss="modal"><?php echo $i; ?></button>
                    <?php } ?>
                </div>
            </div>

        </div>
    </div>
</div>