<script>
    $(function () {
        // Display the create invoice modal
        $('#create-invoice').modal('show');

        // Enable select2 for all selects
        $('.simple-select').select2();

        <?php $this->layout->load_view('clients/script_select2_client_id.js'); ?>

        // Toggle on/off permissive search on clients names
        $('#toggle_permissive_search_clients').click(function () {
            if ($('input#input_permissive_search_clients').val() == ('1')) {
                $.get("<?php echo site_url('clients/ajax/save_preference_permissive_search_clients'); ?>", {
                    permissive_search_clients: '0'
                });
                $('input#input_permissive_search_clients').val('0');
                $('span#toggle_permissive_search_clients i').removeClass('fa-toggle-on');
                $('span#toggle_permissive_search_clients i').addClass('fa-toggle-off');
            } else {
                $.get("<?php echo site_url('clients/ajax/save_preference_permissive_search_clients'); ?>", {
                    permissive_search_clients: '1'
                });
                $('input#input_permissive_search_clients').val('1');
                $('span#toggle_permissive_search_clients i').removeClass('fa-toggle-off');
                $('span#toggle_permissive_search_clients i').addClass('fa-toggle-on');
            }
        });

        // Creates the invoice
        $('#invoice_create_confirm').click(function () {
            // Posts the data to validate and create the invoice;
            // will create the new client if necessar
            $.post("<?php echo site_url('invoices/ajax/create'); ?>", {
                    client_id: $('#create_invoice_client_id').val(),
                    invoice_date_created: '<?php echo date("d-m-Y"); ?>',
                    invoice_group_id: $('#invoice_group_id').val(),
                    invoice_time_created: '<?php echo date('H:i:s') ?>',
                    invoice_password: "",
                    user_id: '<?php echo $this->session->userdata('user_id'); ?>',
                    payment_method: ""
                },
                function (data) {
                    <?php echo(IP_DEBUG ? 'console.log(data);' : ''); ?>
                    var response = JSON.parse(data);
                    if (response.success === 1) {
                        // The validation was successful and invoice was created
                        //window.location = "<?php echo site_url('invoices/view'); ?>/" + response.invoice_id;
                        save_item(response.invoice_id);
                    } else {
                        // The validation was not successful
                        $('.control-group').removeClass('has-error');
                        for (var key in response.validation_errors) {
                            $('#' + key).parent().parent().addClass('has-error');
                        }
                    }
                });
        });

        
        function save_item(created_invoice_id) {
            $.post("<?php echo site_url('invoices/ajax/save_item'); ?>", {
                    invoice_id: created_invoice_id,
                    item_date_end: $('#item_date_end').val(),
                    item_date_start: $('#item_date_start').val(),
                    item_room: $('#item_room').val()
                },
                function(data) {
                    console.log(data);
                    window.location = "<?php echo site_url('invoices/view'); ?>/" + created_invoice_id;
                    //modal.showUrl("<?php echo site_url('invoices/view'); ?>/" + created_invoice_id);
                });
        }

        // Create Client
        $('#invoice_create_client').click(function() {
            // Posts the data to validate and create the invoice;
            // will create the new client if necessar

            $.post("<?php echo site_url('clients/form'); ?>", {
                    is_update: "1",
                    client_name: $('#client_name').val(),
                    client_address_1: $('#client_address_1').val(),
                    client_zip: $('#client_zip').val(),
                    client_city: $('#client_city').val(),
                    client_active: 1
                },
                function(data) {
                    alert($('#client_name').val() + ' erfolgreich hinzugefügt.');
                    $('#client_name').val("");
                    $('#client_address_1').val("");
                    $('#client_zip').val("");
                    $('#client_city').val("");

                });
        });
    });
</script>

<div id="create-invoice" class="modal modal-lg" role="dialog" aria-labelledby="modal_create_invoice" aria-hidden="true">
    <div class="modal-content">
        <div class="modal-header">
            <ul class="nav nav-tabs">
                <li role="presentation" class="active">
                    <a href="#one" aria-controls="one" role="tab" data-toggle="tab">Reservierung erstellen</a>
                </li>
                <li role="presentation">
                    <a href="#two" aria-controls="two" role="tab" data-toggle="tab">Kunde Hinzufügen</a>
                </li>
            </ul>
        </div>
        <div class="modal-body panel panel-default no-margin">

            <div class="panel-body tab-content">

                <div role="tabpanel" class="tab-pane fade in active" id="one">
                    <form>
                       
                        <input class="hidden" id="input_permissive_search_clients" value="<?php echo get_setting('enable_permissive_search_clients'); ?>">

                        <div class="form-group has-feedback">
                            <label for="create_invoice_client_id"><?php _trans('client'); ?></label>
                            <div class="input-group">
                                <select name="client_id" id="create_invoice_client_id" class="client-id-select form-control" autofocus="autofocus">
                                    <?php if (!empty($client)) : ?>
                                        <option value="<?php echo $client->client_id; ?>"><?php _htmlsc(format_client($client)); ?></option>
                                    <?php endif; ?>
                                </select>
                                <span id="toggle_permissive_search_clients" class="input-group-addon" title="<?php _trans('enable_permissive_search_clients'); ?>" style="cursor:pointer;">
                                    <i class="fa fa-toggle-<?php echo get_setting('enable_permissive_search_clients') ? 'on' : 'off' ?> fa-fw"></i>
                                </span>
                            </div>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="item_date_start"><?php _trans('start'); ?></label>
                            <div class="input-group">
                                <input name="item_date_start" id="item_date_start" class="form-control datepicker" value="<?php echo $start; ?>">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar fa-fw"></i>
                                </span>
                            </div>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="item_date_end"><?php _trans('end'); ?></label>
                            <div class="input-group">
                                <input name="item_date_end" id="item_date_end" class="form-control datepicker" value="<?php echo $end; ?>">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar fa-fw"></i>
                                </span>
                            </div>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="item_room"><?php _trans('room'); ?></label>

                            <div class="input-group">
                                <input type="number" name="item_room" id="item_room" class="form-control" value="<?php echo $room; ?>">
                                <span class="input-group-addon">
                                    <i class="fa fa-cube"></i>
                                </span>
                            </div>
                        </div>

                        <div class="form-group hidden">
                            <label for="invoice_group_id"><?php _trans('invoice_group'); ?></label>
                            <select name="invoice_group_id" id="invoice_group_id" class="form-control simple-select" data-minimum-results-for-search="Infinity">
                                <?php foreach ($invoice_groups as $invoice_group) { ?>
                                    <option value="<?php echo $invoice_group->invoice_group_id; ?>" <?php if (get_setting('default_reservation_group') == $invoice_group->invoice_group_id) { ?>selected="selected" <?php } ?>>
                                        <?php _htmlsc($invoice_group->invoice_group_name); ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="modal-footer">

                            <div class="btn-group">
                                <button class="btn btn-success ajax-loader" id="invoice_create_confirm" type="button">
                                    <i class="fa fa-check"></i> <?php _trans('submit'); ?>
                                </button>
                                <button class="btn btn-danger" type="button" data-dismiss="modal">
                                    <i class="fa fa-times"></i> <?php _trans('cancel'); ?>
                                </button>
                            </div>

                        </div>
                    </form>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="two">
                    <form>
                        <?php $this->layout->load_view('layout/alerts'); ?>

                        <div class="form-group">
                            <label for="client_surname">
                                <?php _trans('client_name'); ?>
                            </label>
                            <input id="client_name" name="client_name" type="text" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="client_address_1"><?php _trans('street_address'); ?></label>

                            <div class="controls">
                                <input type="text" name="client_address_1" id="client_address_1" class="form-control" value="<?php echo $this->mdl_clients->form_value('client_address_1', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="client_city"><?php _trans('city'); ?></label>
                            <div class="controls">
                                <input type="text" name="client_city" id="client_city" class="form-control" value="<?php echo $this->mdl_clients->form_value('client_city', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="client_zip"><?php _trans('zip_code'); ?></label>
                            <div class="controls">
                                <input type="text" name="client_zip" id="client_zip" class="form-control" value="<?php echo $this->mdl_clients->form_value('client_zip', true); ?>">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="btn-group">
                                <button class="btn btn-success" id="invoice_create_client" type="button">
                                    <i class="fa fa-check"></i> <?php _trans('submit'); ?>
                                </button>
                                <button class="btn btn-danger" type="button" data-dismiss="modal">
                                    <i class="fa fa-times"></i> <?php _trans('cancel'); ?>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>


        </div>



    </div>

</div>