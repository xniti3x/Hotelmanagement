<?php $this->load->helper('country'); ?>
        <div class="card">
            <table class="table table-borderless table-responsive">
                <tr>
                    <td><a href="<?php echo site_url('clients/view/' . $client->client_id); ?>">
                            <?php _htmlsc(format_client($client)) ?>
                        </a></td>
                </tr>
                <tr>    <?php echo ($client->client_address_1 ? "<td>" . htmlsc($client->client_address_1) . '</td>' : ''); ?>
                    <?php echo ($client->client_address_2 ? "<td>" . htmlsc($client->client_address_2) . '</td>' : ''); ?>
                    <?php echo ($client->client_zip ? "<td>" . htmlsc($client->client_zip) . '</td>' : ''); ?>
                    <?php echo ($client->client_city ? "<td>" . htmlsc($client->client_city) . "</td>" : ''); ?>
                    <?php echo ($client->client_country ? "<td>" . htmlsc($client->client_country) . "</td>" : ''); ?>
                    <?php echo ($client->client_phone ? "<td>" . htmlsc($client->client_phone) . '</td>' : ''); ?>
                    <?php echo ($client->client_email ? "<td>" . htmlsc($client->client_email) . "</td>" : ''); ?>
                    <td style="min-width: 100px;">

                        <button id="invoice_change_client" class="btn btn-default btn-flat btn-sm" data-toggle="tooltip" data-placement="bottom" title="<?php _trans('change_client'); ?>"><i class="fa fa-edit"></i></button>
                        <button id="invoice_add_client" class="btn btn-default btn-flat btn-sm" data-toggle="tooltip" title="<?php _trans('add_client'); ?>"><i class="fa fa-plus"></i></button>

                    </td>
                

            </table>
        </div>
