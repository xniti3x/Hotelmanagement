<?php
$cv = $this->controller->view_data["custom_values"];
?>


<script>
    $(function() {

        $('.item-task-id').each(function() {
            // Disable client chaning if at least one item already has a task id assigned
            if ($(this).val().length > 0) {
                $('#invoice_change_client').hide();
                return false;
            }
        });

        $('.btn_add_product').click(function() {
            $('#modal-placeholder').load(
                "<?php echo site_url('products/ajax/modal_product_lookups'); ?>/" + Math.floor(Math.random() * 1000)
            );

        });

        $('#delete_confirm_btn').click(function() {
            console.log("#delete_confirm_btn");
            $.confirm({
                title: '',
                content:'',
                buttons: {
                    Ja: {
                        btnClass: 'btn btn-success btn-flat',
                        action:function () {
                            $.post("<?php echo site_url('invoices/delete/' . $invoice->invoice_id); ?>", {
                                _ip_csrf: Cookies.get('ip_csrf_cookie')
                            },
                            function(data) {
                                console.log('hallo');
                            });
                        }
                    },
                    nein: {
                        btnClass: 'btn btn-danger btn-flat',
                        action:function () {
                        //
                        }
                    },
                    
                    
                }
            });

        });
        
        $('.btn_add_task').click(function() {
            $('#modal-placeholder').load(
                "<?php echo site_url('tasks/ajax/modal_task_lookups/' . $invoice_id); ?>/" +
                Math.floor(Math.random() * 1000)
            );
        });

        $('.btn_add_row').click(function() {
            $('#new_row').clone().appendTo('#item_table').removeAttr('id').addClass('item').show();
        });

        $('.btn_copy_row').click(function() {
            $('#item_table tbody:last').clone().appendTo('#item_table');
        });

        <?php if (!$items) { ?>
            $('#new_row').clone().appendTo('#item_table').removeAttr('id').addClass('item').show();
        <?php } ?>

        $('#btn_create_recurring').click(function() {
            $('#modal-placeholder').load(
                "<?php echo site_url('invoices/ajax/modal_create_recurring'); ?>", {
                    invoice_id: <?php echo $invoice_id; ?>
                }
            );
        });

        $('#invoice_change_client').click(function() {
            $('#modal-placeholder').load("<?php echo site_url('invoices/ajax/modal_change_client'); ?>", {
                invoice_id: <?php echo $invoice_id; ?>,
                client_id: "<?php echo $this->db->escape_str($invoice->client_id); ?>",
            });
        });

        $('#invoice_add_client').click(function() {
            var modal = new DayPilot.Modal();
            modal.autoStretch = true;
            modal.width = $(window).width();
            modal.height = $(window).height() - 50;
            modal.theme = "modal_min";
            modal.showUrl("<?php echo site_url('clients/form'); ?>");
        });

        $('#btn_save_invoice').click(function() {
            var items = [];
            var item_order = 1;
            var same = null; //variable for same item_id
            var temp = null; // temp variable for storing item_id
            $('table tbody.item').each(function() {
                var row = {};
                $(this).find('input,select,textarea').each(function() {
                    if ($(this).is(':checkbox')) {
                        row[$(this).attr('name')] = $(this).is(':checked');
                    } else {
                        row[$(this).attr('name')] = $(this).val();
                    }
                });
                row['item_order'] = item_order;
                item_order++;
                temp = row['item_id'];
                if (row['item_id'] == same) {
                    row['item_id'] = null;
                }
                same = temp;
                items.push(row);
                console.log(row);
            });
            console.log("serialze", $('input[name^=custom],select[name^=custom]').serializeArray());
            $.post("<?php echo site_url('invoices/ajax/save'); ?>", {
                    invoice_id: <?php echo $invoice_id; ?>,
                    invoice_number: $('#invoice_number').val(),
                    invoice_date_created: $('#invoice_date_created').val(),
                    invoice_date_due: $('#invoice_date_due').val(),
                    invoice_status_id: $('#invoice_status_id').val(),
                    invoice_password: $('#invoice_password').val(),
                    items: JSON.stringify(items),
                    invoice_discount_amount: $('#invoice_discount_amount').val(),
                    invoice_discount_percent: $('#invoice_discount_percent').val(),
                    invoice_terms: $('#invoice_terms').val(),
                    custom: $('input[name^=custom],select[name^=custom]').serializeArray(),
                    payment_method: $('#payment_method').val(),
                },
                function(data) {
                    <?php echo (IP_DEBUG ? 'console.log(data);' : ''); ?>
                    var response = JSON.parse(data);
                    if (response.success === 1) {
                        window.location = "<?php echo site_url('invoices/view'); ?>/" + <?php echo $invoice_id; ?>;
                    } else {
                        $('#fullpage-loader').hide();
                        $('.control-group').removeClass('has-error');
                        $('div.alert[class*="alert-"]').remove();
                        var resp_errors = response.validation_errors,
                            all_resp_errors = '';
                        for (var key in resp_errors) {
                            $('#' + key).parent().addClass('has-error');
                            all_resp_errors += resp_errors[key];
                        }
                        $('#invoice_form').prepend('<div class="alert alert-danger">' + all_resp_errors + '</div>');
                    }
                });
        });

        $('#btn_generate_pdf').click(function() {
            window.open('<?php echo site_url('invoices/generate_pdf/' . $invoice_id); ?>', '_blank');
        });

        $(document).on('click', '.btn_delete_item', function() {
            var btn = $(this);
            var item_id = btn.data('item-id');

            // Just remove the row if no item ID is set (new row)
            if (typeof item_id === 'undefined') {
                $(this).parents('.item').remove();
            }

            $.post("<?php echo site_url('invoices/ajax/delete_item/' . $invoice->invoice_id); ?>", {
                    'item_id': item_id,
                },
                function(data) {
                    <?php echo (IP_DEBUG ? 'console.log(data);' : ''); ?>
                    var response = JSON.parse(data);

                    if (response.success === 1) {
                        btn.parents('.item').remove();
                    } else {
                        btn.removeClass('btn-link').addClass('btn-danger').prop('disabled', true);
                    }
                });
        });

        <?php if ($invoice->is_read_only != 1) : ?>
            var fixHelper = function(e, tr) {
                var $originals = tr.children();
                var $helper = tr.clone();
                $helper.children().each(function(index) {
                    $(this).width($originals.eq(index).width());
                });
                return $helper;
            };

            $('#item_table').sortable({
                items: 'tbody',
                helper: fixHelper,
            });

            <?php if ($invoice->invoice_group_id != 5) : ?>
                if ($('#invoice_discount_percent').val().length > 0) {
                    $('#invoice_discount_amount').prop('disabled', true);
                }

                if ($('#invoice_discount_amount').val().length > 0) {
                    $('#invoice_discount_percent').prop('disabled', true);
                }

                $('#invoice_discount_amount').keyup(function() {
                    if (this.value.length > 0) {
                        $('#invoice_discount_percent').prop('disabled', true);
                    } else {
                        $('#invoice_discount_percent').prop('disabled', false);
                    }
                });
                $('#invoice_discount_percent').keyup(function() {
                    if (this.value.length > 0) {
                        $('#invoice_discount_amount').prop('disabled', true);
                    } else {
                        $('#invoice_discount_amount').prop('disabled', false);
                    }
                });
            <?php endif; ?>
        <?php endif; ?>

        <?php if ($invoice->invoice_is_recurring) : ?>
            $(document).on('click', '.js-item-recurrence-toggler', function() {
                var itemRecurrenceState = $(this).next('input').val();
                if (itemRecurrenceState === ('1')) {
                    $(this).next('input').val('0');
                    $(this).removeClass('fa-calendar-check-o text-success');
                    $(this).addClass('fa-calendar-o text-muted');
                } else {
                    $(this).next('input').val('1');
                    $(this).removeClass('fa-calendar-o text-muted');
                    $(this).addClass('fa-calendar-check-o text-success');
                }
            });
        <?php endif; ?>

    });
</script>



<div id="content">

    <?php echo $this->layout->load_view('layout/alerts'); ?>

    <div id="invoice_form">
        <div class="invoice">

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="client-address">
                        <?php $this->layout->load_view('clients/partial_client_address', ['client' => $invoice]); ?>
                    </div>
                </div>
            </div>
                
                <div class="<?php echo $invoice->invoice_group_id == 5 ? "hidden" : ""; ?> col-xs-12 col-sm-5 col-sm-offset-1 col-md-6 col-md-offset-1">
                    <div class="details-box panel panel-default panel-body">
                        <div class="row">

                            <?php if ($invoice->invoice_sign == -1) { ?>
                                <div class="col-xs-12">
                                    <div class="alert alert-warning small">
                                        <i class="fa fa-credit-invoice"></i>&nbsp;
                                        <?php
                                        echo trans('credit_invoice_for_invoice') . ' ';
                                        $parent_invoice_number = $this->mdl_invoices->get_parent_invoice_number($invoice->creditinvoice_parent_id);
                                        echo anchor('/invoices/view/' . $invoice->creditinvoice_parent_id, $parent_invoice_number);
                                        ?>
                                    </div>
                                </div>
                            <?php } ?>

                            <div class="col-xs-12 col-md-6">







                                <!-- Custom fields -->
                                <?php foreach ($custom_fields as $custom_field) : ?>
                                    <?php if ($custom_field->custom_field_location != 1) {
                                        continue;
                                    } ?>
                                    <?php print_field($this->mdl_invoices, $custom_field, $cv); ?>
                                <?php endforeach; ?>

                            </div>

                            <div class="col-xs-12 col-md-6">





                                <div hidden class="hidden invoice-properties">
                                    <label><?php _trans('invoice_password'); ?></label>
                                    <input type="text" id="invoice_password" class="form-control input-sm" value="<?php _htmlsc($invoice->invoice_password); ?>" <?php if ($invoice->is_read_only == 1) {
                                                                                                                                                                        echo 'disabled="disabled"';
                                                                                                                                                                    } ?>>
                                </div>
                            </div>

                            <!-- <?php if ($invoice->invoice_status_id != 1) { ?>
                                <div class="col-xs-12 col-md-6">
                                    <div class="form-group">
                                        <label for="invoice-guest-url"><?php _trans('guest_url'); ?></label>
                                        <div class="input-group">
                                            <input type="text" id="invoice-guest-url" readonly class="form-control" value="<?php echo site_url('guest/view/invoice/' . $invoice->invoice_url_key) ?>">
                                            <span class="input-group-addon to-clipboard cursor-pointer" data-clipboard-target="#invoice-guest-url">
                                                <i class="fa fa-clipboard fa-fw"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?> -->

                        </div>
                    </div>
                </div>

            </div>

            <?php $this->layout->load_view('invoices/partial_item_table'); ?>

            <?php if ($invoice->invoice_group_id != 5) : ?>
                <hr />
                <div class="row">
                    <div class="col-xs-12 col-md-6">

                        <div class="card">
                            <div class="card-header">
                                <?php _trans('invoice_terms'); ?>
                            </div>
                            <div class="card-body">
                                <textarea id="invoice_terms" name="invoice_terms" class="form-control" rows="3" <?php if ($invoice->is_read_only == 1) {
                                                                                                                    echo 'disabled="disabled"';
                                                                                                                } ?>><?php _htmlsc($invoice->invoice_terms); ?></textarea>
                            </div>
                        </div>

                    </div>
                    <div class="col-xs-12 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <?php $this->layout->load_view('upload/dropzone-invoice-html'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($custom_fields) : ?>
                <div class="row">
                    <div class="col-xs-12">

                        <hr>

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <?php _trans('custom_fields'); ?>
                            </div>
                            <div class="panel-body">
                                <div class="row">

                                    <div class="col-xs-12 col-md-6">
                                        <?php $i = 0; ?>
                                        <?php foreach ($custom_fields as $custom_field) : ?>
                                            <?php if ($custom_field->custom_field_location != 0) {
                                                continue;
                                            } ?>
                                            <?php $i++; ?>
                                            <?php if ($i % 2 != 0) : ?>
                                                <?php print_field($this->mdl_invoices, $custom_field, $cv); ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="col-xs-12 col-md-6">
                                        <?php $i = 0; ?>
                                        <?php foreach ($custom_fields as $custom_field) : ?>
                                            <?php if ($custom_field->custom_field_location != 0) {
                                                continue;
                                            } ?>
                                            <?php $i++; ?>
                                            <?php if ($i % 2 == 0) : ?>
                                                <?php print_field($this->mdl_invoices, $custom_field, $cv); ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            <?php endif; ?>

        </div>

    </div>
</div>

<?php if ($invoice->invoice_group_id != 5) {
    $this->layout->load_view('upload/dropzone-invoice-scripts');
} ?>

<?php
echo $modal_delete_invoice;
echo $modal_add_invoice_tax;
if ($this->config->item('disable_read_only') == true) {
    $invoice->is_read_only = 0;
}
?>
