<!DOCTYPE html>
<html lang="<?php echo trans('cldr'); ?>">
<head>
    <title><?php echo trans('sales_by_client'); ?></title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/<?php echo get_setting('system_theme', 'invoiceplane'); ?>/css/reports.css" type="text/css">
</head>
<body>

<h3 class="report_title">
    <?php echo trans('sales_by_client'); ?><br/>
    <small><?php echo _trans("Timerange").": ".$from_date . ' - ' . $to_date ?></small>
</h3>
<!-- <pre><?php print_r($results); ?></pre> -->
  
<table>
    <tr>
        <th class="amount"  style="text-align:center;"><?php echo trans('RNR.'); ?></th>
        <th class="amount"  style="text-align:center;"><?php echo trans('Datum'); ?></th>
        <th class="amount"  style="text-align:center;"><?php echo trans('Name'); ?></th>
        <th class="amount" style="text-align:center;"><?php echo ('subtotal'); ?></th>
        <th class="amount" style="text-align:center;"><?php echo ('tax_subtotal'); ?></th>
        <th class="amount" style="text-align:center;"><?php echo ('total'); ?></th>
      
    </tr>
    <?php
      $subtotal=0;
      $tax_total=0;
      $total=0;
  
    foreach ($results as $result) { 
      $subtotal+=$result->invoice_item_subtotal;
      $tax_total+=$result->invoice_item_tax_total;
      $total+= $result->invoice_total;
  ?>
        <tr>
            <td class="amount" style="text-align:center;"><?php echo $result->invoice_number; ?></td>
            <td class="amount" style="text-align:center;"><?php echo $result->invoice_date_created; ?></td>
            <td class="amount" style="text-align:center;"><?php echo $result->client_name; ?></td>
            <td class="amount" style="text-align:center;"><?php echo format_currency($result->invoice_item_subtotal); ?></td>
            <td class="amount" style="text-align:center;"><?php echo format_currency($result->invoice_item_tax_total); ?></td>
            <td class="amount" style="text-align:center;"><?php echo format_currency($result->invoice_total); ?></td>
            
        </tr>
    <?php } ?>
   <tr style="background:#eee;">
     <td class="amount" style="text-align:center;"> </td>
            <td class="amount" style="text-align:center;"> </td>
            <td class="amount" style="text-align:center;"> </td>
            <td class="amount" style="text-align:center;"><?php echo format_currency($subtotal); ?></td>
            <td class="amount" style="text-align:center;"><?php echo format_currency($tax_total); ?></td>
            <td class="amount" style="text-align:center;"><?php echo format_currency($total); ?></td>
     </tr>
</table>

</body>
</html>
