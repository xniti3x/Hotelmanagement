<script>

</script>


<br>
<?php echo $this->layout->load_view('layout/alerts'); ?>

<div class="row">
    <div class="col-xs-12 col-md-6">
        <div id="panel-invoice-overview" class="card">
            <div class="card-header">
                <div class="card-tools">
                    <span class="pull-right text-muted"><?php echo lang($invoice_status_period); ?></span>
                </div>
                <span class="oi oi-spreadsheet"></span>
                <b><i class="fa fa-table fa-margin"></i> <?php _trans('invoice_overview'); ?></b>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped table-hover text-nowrap">
                    <?php foreach ($invoice_status_totals as $total) { ?>
                        <tr>
                            <td>
                                <a href="<?php echo site_url($total['href']); ?>">
                                    <?php echo $total['label']; ?>
                                </a>
                            </td>
                            <td>
                                <span class="<?php echo $total['class']; ?>">
                                    <?php echo format_currency($total['sum_total']); ?>
                                </span>
                            </td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <?php if (empty($overdue_invoices)) { ?>
                            <td colspan="2">
                                <span class="text-muted"><?php _trans('no_overdue_invoices'); ?></span>
                            </td>
                        <?php } else {
                            $overdue_invoices_total = 0;
                            foreach ($overdue_invoices as $invoice) {
                                $overdue_invoices_total += $invoice->invoice_balance;
                            }
                        ?>
                            <td>
                                <?php echo anchor('invoices/status/overdue', '<i class="fa fa-arrow-left"></i> ' . trans('overdue'), 'class="text-danger"'); ?>

                            </td>
                            <td>
                                <span class="pull-right text-danger">
                                    <?php echo format_currency($overdue_invoices_total); ?>
                                </span>
                            </td>
                        <?php } ?>

                    </tr>
                </table>
            </div>
        </div>



    </div>

    <div class="col-xs-12 col-md-6">
        <div id="panel-recent-invoices" class="card">

            <div class="card-header">
                <b><i class="fa fa-history fa-margin"></i> <?php _trans('recent_invoices'); ?></b>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th><?php _trans('status'); ?></th>
                            <th style="min-width: 15%;"><?php _trans('due_date'); ?></th>
                            <th style="min-width: 15%;"><?php _trans('invoice'); ?></th>
                            <th style="min-width: 35%;"><?php _trans('client'); ?></th>
                            <th style="text-align: right;"><?php _trans('balance'); ?></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php foreach ($invoices as $invoice) {
                            if ($this->config->item('disable_read_only') == true) {
                                $invoice->is_read_only = 0;
                            } ?>
                            <tr>
                                <td>
                                    <span class="label <?php echo $invoice_statuses[$invoice->invoice_status_id]['class']; ?>">
                                        <?php echo $invoice_statuses[$invoice->invoice_status_id]['label'];
                                        if ($invoice->invoice_sign == '-1') { ?>
                                            &nbsp;<i class="fa fa-credit-invoice" title="<?php _trans('credit_invoice') ?>"></i>
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
                                    <span class="<?php if ($invoice->is_overdue) { ?>font-overdue<?php } ?>">
                                        <?php echo date_from_mysql($invoice->invoice_date_due); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php echo anchor('invoices/view/' . $invoice->invoice_id, ($invoice->invoice_number ? $invoice->invoice_number : $invoice->invoice_id)); ?>
                                </td>
                                <td>
                                    <?php echo anchor('clients/view/' . $invoice->client_id, htmlsc(format_client($invoice))); ?>
                                </td>
                                <td class="amount">
                                    <?php echo format_currency($invoice->invoice_balance * $invoice->invoice_sign); ?>
                                </td>
                                <td style="text-align: center;">
                                    <?php if ($invoice->sumex_id != null) : ?>
                                        <a href="<?php echo site_url('invoices/generate_sumex_pdf/' . $invoice->invoice_id); ?>" title="<?php _trans('download_pdf'); ?>">
                                            <i class="fa fa-file-pdf-o"></i>
                                        </a>
                                    <?php else : ?>
                                        <a href="<?php echo site_url('invoices/generate_pdf/' . $invoice->invoice_id); ?>" title="<?php _trans('download_pdf'); ?>">
                                            <i class="fa fa-file-pdf-o"></i>
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td colspan="6" class="text-right small">
                                <?php echo anchor('invoices/status/all', trans('view_all')); ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-md-6">
        <div id="panel-recent-invoices" class="card">

            <div class="card-header">
                <b><i class="fa fa-history fa-margin"></i> <?php _trans('recent_reservations'); ?></b>
            </div>

            <div class="card-body table-responsive">
                <table class="table table-hover table-striped table-condensed no-margin">
                    <thead>
                        <tr>
                            <th><?php _trans('status'); ?></th>
                            <th style="min-width: 15%;"><?php _trans('reservation'); ?></th>
                            <th style="min-width: 35%;"><?php _trans('client'); ?></th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php foreach ($reservations as $invoice) {
                            if ($this->config->item('disable_read_only') == true) {
                                $invoice->is_read_only = 0;
                            } ?>
                            <tr>
                                <td>
                                    <span class="label <?php echo $invoice_statuses[$invoice->invoice_status_id]['class']; ?>">
                                        <?php echo $invoice_statuses[$invoice->invoice_status_id]['label'];
                                        if ($invoice->invoice_sign == '-1') { ?>
                                            &nbsp;<i class="fa fa-credit-invoice" title="<?php _trans('credit_invoice') ?>"></i>
                                        <?php } ?>
                                        <?php if ($invoice->invoice_is_recurring) { ?>
                                            &nbsp;<i class="fa fa-refresh" title="<?php echo trans('recurring') ?>"></i>
                                        <?php } ?>
                                    </span>
                                </td>
                                <td>
                                    <?php echo anchor('invoices/view/' . $invoice->invoice_id, ($invoice->invoice_number ? $invoice->invoice_number : $invoice->invoice_id)); ?>
                                </td>
                                <td>
                                    <?php echo anchor('clients/view/' . $invoice->client_id, htmlsc(format_client($invoice))); ?>
                                </td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td colspan="6" class="text-right small">
                                <?php echo anchor('invoices/status/reservation', trans('view_all')); ?>
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-md-12">
        <div id="panel-invoice-overview" class="card">
            <div class="card-header">
                <div class="card-tools">
                    <form method="post" action="<?php echo site_url("dashboard/index"); ?>">
                        <input id="start" name="start" value="<?php echo $dateStart; ?>" placeholder="YYYY-MM-DD" type="date">
                        <input id="end" name="end" value="<?php echo $dateEnd; ?>" placeholder="YYYY-MM-DD" type="date">
                        <input type="submit" name="submit" id="visitorMonth" class="btn btn-primary" value="senden" />
                    </form>
                </div>
                <b></b><i class="fa fa-bar-chart fa-margin"></i> <?php _trans('Statistic'); ?></b>
                <span class="pull-right text-muted"></span>
            </div>

            <div class="row card-body">
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa fa-user"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Besucher</span>
                            <span class="info-box-number">
                                <?php echo ($monthVisitors[0]->Visitors); ?>
                            </span>
                        </div>

                    </div>

                </div>

                <div class="col-12 col-sm-6 col-md-4">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-bed"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Nights</span>
                            <span class="info-box-number"><?php echo ($monthVisitors[0]->Nights); ?></span>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-md-6">
        <div id="panel-recent-invoices" class="card">
            <div class="card-header">
                <b><i class="fa fa-bar-chart fa-margin"></i> <?php _trans('room_salery'); ?></b>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-hover table-striped table-condensed no-margin">
                    <thead>
                        <tr>
                            <th><?php _trans('room'); ?></th>
                            <th><?php _trans('total'); ?></th>
                            <th><?php _trans('pro Monat'); ?></th>
                            <th><?php _trans('pro Nacht'); ?></th>
                            <th><?php _trans('besetzte Nächte von X'); ?></th>
                            <th><?php _trans('besetzte in %'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $vtotal = 0;
                        foreach ($roomStatistic as $item) { ?>
                            <tr>
                                <td>
                                    <?php echo $item->item_room; ?>
                                </td>
                                <td>
                                    <?php echo format_currency($item->summe); ?>
                                </td>
                                <td>
                                    <?php echo format_currency($item->summe / ($dateDiff["m"])); ?>
                                </td>
                                <td>
                                    <?php echo format_currency($item->summe / $diff = $dateDiff["y"] * 365 + $dateDiff["m"] * 30 + $dateDiff["d"]); ?>
                                </td>
                                <td>
                                    <?php echo ($item->nights . "/" . ($diff)); ?>
                                </td>
                                <td><?php echo number_format($item->nights * 100 / ($diff), 2) . "%"; ?></td>
                            </tr>
                        <?php  } ?>

                    </tbody>
                </table>

            </div>

        </div>
    </div>
    <div class="col-xs-12 col-md-6">
        <div id="panel-recent-invoices" class="card">
            <div class="card-header">
                <b><i class="fa fa-bar-chart fa-margin"></i> <?php _trans('client_salery'); ?></b>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-hover table-striped table-condensed">
                    <thead>
                        <tr>
                            <th><?php _trans('client_name'); ?></th>
                            <th><?php _trans('total'); ?></th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php $vtotal = 0;
                        foreach ($clientStatistic as $item) {
                            $vtotal += $item->invoice_total; ?>
                            <tr>
                                <td>
                                    <?php echo $item->client_name; ?>
                                </td>
                                <td>
                                    <?php echo ($item->invoice_total . " €"); ?>
                                </td>
                            </tr>
                        <?php  } ?>
                        <tr>
                            <td colspan="6" class="text-right small">
                                <?php echo format_currency($vtotal); ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>