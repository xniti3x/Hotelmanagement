<!DOCTYPE html>
<html lang="<?php echo trans('cldr'); ?>">
<head>
    <title><?php echo trans('expenditure_history'); ?></title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/<?php echo get_setting('system_theme', 'invoiceplane'); ?>/css/reports.css" type="text/css">
</head>
<body>

<h3 class="report_title">
    <?php echo trans('expenditure_history'); ?><br/>
    <small><?php echo $from_date . ' - ' . $to_date ?></small>
</h3>

<table>
    <tr>
        <th><?php echo trans('date'); ?></th>
        <th><?php echo trans('client'); ?></th>
        <th><?php echo trans('Bemerkung'); ?></th>
        <th class="amount"><?php echo trans('amount'); ?></th>
    </tr>
    <?php
    $sum = 0;

    foreach ($results as $result) {
        ?>
        <tr>
            <td><?php echo date_from_mysql($result->bookingDate, true); ?></td>
            <td><?php echo ($result->title); ?></td>
            <td><?php echo nl2br(htmlsc($result->remittanceInformationStructured)); ?></td>
            <td class="amount"><?php echo format_currency($result->transactionAmount);
                $sum = $sum + $result->transactionAmount; ?></td>
        </tr>
        <?php
    }

    if (!empty($results)) {
        ?>
        <tr>
            <td colspan="3"><?php echo trans('total'); ?></td>
            <td class="amount"><?php echo format_currency($sum); ?></td>
        </tr>
    <?php } ?>
</table>

</body>
</html>
