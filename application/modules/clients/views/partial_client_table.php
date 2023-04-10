<div class="card">
    <div class="card-header">
        <div class="card-title">

        </div>
        <div class="btn-group">
            <button type="button" class="btn btn-info btn-flat dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                <span class="sr-only">Toggle Dropdown</span>
            </button>
            <div class="dropdown-menu" role="menu" style="">
                <a class="dropdown-item" href="<?php echo site_url('clients/status/active'); ?>"><?php _trans('active'); ?></a>
                <a class="dropdown-item" href="<?php echo site_url('clients/status/inactive'); ?>"><?php _trans('inactive'); ?></a>
                <a class="dropdown-item" href="<?php echo site_url('clients/status/all'); ?>"><?php _trans('all'); ?></a>
            </div>

            <button type="button" class="btn btn-info btn-flat"><?php _trans($status); ?></button>
            <a class="btn btn-info btn-flat" href="<?php echo site_url('clients/form'); ?>"><i class="fa fa-plus"></i> </a>

        </div>
        <div class="card-tools">
            <?php echo pager(site_url('clients/status/' . $this->uri->segment(3)), 'mdl_clients'); ?>
        </div>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th><?php _trans('active'); ?></th>
                    <th><?php _trans('client_name'); ?></th>
                    <th><?php _trans('email_address'); ?></th>
                    <th><?php _trans('phone_number'); ?></th>
                    <th class="amount"><?php _trans('balance'); ?></th>
                    <th><?php _trans('options'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($records as $client) : ?>
                    <tr>
                        <td>
                            <?php echo ($client->client_active) ? '<span class="label active">' . trans('yes') . '</span>' : '<span class="label inactive">' . trans('no') . '</span>'; ?>
                        </td>
                        <td><?php echo anchor('clients/view/' . $client->client_id, htmlsc(format_client($client))); ?></td>
                        <td><?php _htmlsc($client->client_email); ?></td>
                        <td><?php _htmlsc($client->client_phone ? $client->client_phone : ($client->client_mobile ? $client->client_mobile : '')); ?></td>
                        <td class="amount"><?php echo format_currency($client->client_invoice_balance); ?></td>
                        <td>

                            <div class="btn-group">
                                <button type="button" class="btn btn-info btn-flat"><i class="fa fa-cog"> </i> <?php _trans('options'); ?></button>
                                <button type="button" class="btn btn-info btn-flat dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu" role="menu">
                                    <a class="dropdown-item" href="<?php echo site_url('clients/view/' . $client->client_id); ?>"><i class="fa fa-eye fa-margin"></i> <?php _trans('view'); ?></a>
                                    <a class="dropdown-item" href="<?php echo site_url('clients/form/' . $client->client_id); ?>"><i class="fa fa-edit fa-margin"></i> <?php _trans('edit'); ?></a>
                                    <a href="#" class="dropdown-item client-create-invoice" data-client-id="<?php echo $client->client_id; ?>">
                                        <i class="fa fa-file-text fa-margin"></i> <?php _trans('create_invoice'); ?>
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <form action="<?php echo site_url('clients/delete/' . $client->client_id); ?>" method="POST">
                                            <?php _csrf_field(); ?>
                                            <button type="submit" class="dropdown-item" onclick="return confirm('<?php _trans('delete_client_warning'); ?>');">
                                                <i class="fa fa-trash"></i> <?php _trans('delete'); ?>
                                            </button>
                                        </form>
                                </div>
                            </div>

                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>