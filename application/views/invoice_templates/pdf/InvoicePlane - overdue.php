<!DOCTYPE html>
<html lang="<?php _trans('cldr'); ?>">
<head>
    <meta charset="utf-8">
    <title><?php _trans('invoice'); ?></title>
    <link rel="stylesheet"
          href="<?php echo base_url(); ?>assets/<?php echo get_setting('system_theme', 'invoiceplane'); ?>/css/templates.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/core/css/custom-pdf.css">
</head>
<body>
<header class="clearfix">
    <div id="logo">
        <?php echo invoice_logo_pdf(); ?>
    </div>
<br> <br><br>
    <div id="client">
        <div>
            <div style="font-size:9; text-decoration:underline;">
            <?php echo _htmlsc($invoice->user_name." | ".$invoice->user_address_1." | ".$invoice->user_zip." | ".$invoice->user_city); ?>
          </div>
            <b><?php _htmlsc(format_client($invoice)); ?></b>
        </div>
        <?php 
        if ($invoice->client_address_1) {
            echo '<div>' . htmlsc($invoice->client_address_1) . '</div>';
        }
        if ($invoice->client_address_2) {
            echo '<div>' . htmlsc($invoice->client_address_2) . '</div>';
        }
        if ($invoice->client_city || $invoice->client_state || $invoice->client_zip) {
            echo '<div>';
            if ($invoice->client_zip) {
                echo htmlsc($invoice->client_zip). ' ';
            }
            if ($invoice->client_city) {
                echo htmlsc($invoice->client_city) . ' ';
            }
            if ($invoice->client_state) {
                echo htmlsc($invoice->client_state) . ' ';
            }
            echo '</div>';
        }
        if ($invoice->client_country) {
            echo '<div>' . get_country_name(trans('cldr'), $invoice->client_country) . '</div>';
        }
        echo '<br/>';
        if ($invoice->client_phone) {
            echo '<div>' . trans('phone_abbr') . ': ' . htmlsc($invoice->client_phone) . '</div>';
        } 
        
        if ($invoice->client_vat_id) {
            echo '<div>' . trans('vat_id_short') . ': ' . $invoice->client_vat_id . '</div>';
        }
        if ($invoice->client_tax_code) {
            echo '<div>' . trans('tax_code_short') . ': ' . $invoice->client_tax_code . '</div>';
        }
        ?>
    </div>
    <div id="company">
        <div><b><?php _htmlsc($invoice->user_name); ?></b></div>
        <?php
        if ($invoice->user_address_1) {
            echo '<div>' . htmlsc($invoice->user_address_1) . '</div>';
        }
        if ($invoice->user_address_2) {
            echo '<div>' . htmlsc($invoice->user_address_2) . '</div>';
        }
        if ($invoice->user_city || $invoice->user_state || $invoice->user_zip) {
            echo '<div>';
            if ($invoice->user_zip) {
                  echo htmlsc($invoice->user_zip).' ';
            }
            if ($invoice->user_city) {
                echo htmlsc($invoice->user_city);
            }    
            echo '</div>';
        }
        if ($invoice->user_country) {
            echo '<div>' . get_country_name(trans('cldr'), $invoice->user_country) . '</div>';
        }
        echo '<br/>';
        if ($invoice->user_phone) {
            echo '<div>' . trans('phone_abbr') . ': ' . htmlsc($invoice->user_phone) . '</div>';
        }
        if ($invoice->user_fax) {
            echo '<div>' . trans('fax_abbr') . ': ' . htmlsc($invoice->user_fax) . '</div>';
        }
        ?>
    </div>
</header>
<main>
    <div class="invoice-details clearfix">
        <table>
            <tr>
                <td><?php echo trans('invoice_date') . ':'; ?></td>
                <td style="color:red;"><?php echo date_from_mysql($invoice->invoice_date_created, true); ?></td>
            </tr>        
            <?php if ($payment_method): ?>
                <tr>
                    <td><?php echo trans('payment_method') . ': '; ?></td>
                    <td><?php _htmlsc($payment_method->payment_method_name); ?></td>
                </tr>
            <?php endif; ?>
        </table>
    </div>
    <h1 class="invoice-title" style="color:red;"><?php echo _trans("Mahnung"); ?></h1>
<br>
  <?php _trans('invoice_table_Header'); ?>:
  <br><br><br>
    <table class="item-table">
        <thead>
        <tr>
            <th class="item-name"><?php _trans('Zimmer'); ?></th>
            <th class="item-name"><?php _trans('description'); ?></th>
            <th class="item-name"><?php _trans('Zeitraum'); ?></th>
            <th class="item-amount text-right"><?php _trans('Anzahl'); ?></th>
            <th class="item-price text-right"><?php _trans('price'); ?></th>
          
            <?php if ($show_item_discounts) : ?>
                <th class="item-discount text-right"><?php _trans('discount'); ?></th>
            <?php endif; ?>
            <th class="item-total text-right"><?php _trans('total'); ?></th>
        </tr>
        </thead>
        <tbody>

        <?php //print_r($invoice);
        //every prozent sum need to be added for every diffrent prozent
          $tax_rate_totalfp=0; //sum of 5%
          $tax_rate_totalsp=0; //sum of 7%
          $tax_rate_totalntp=0; //sum of 19%
        foreach ($items as $item) {  
                if($item->item_tax_rate_percent==19){  
                  $tax_rate_totalntp+=$item->item_tax_total; 
                 } 
                if($item->item_tax_rate_percent==7){  
                  $tax_rate_totalsp+=$item->item_tax_total; 
                 } 
                if($item->item_tax_rate_percent==5){  
                  $tax_rate_totalfp+=$item->item_tax_total; 
                 }
        ?><tr>
            <td><?php echo $item->item_room; ?></td>
                <td><b><?php _htmlsc($item->item_name); ?></b> 
                  <br><div style="font-size:8pt;">
                  <?php echo nl2br(htmlsc($item->item_description)); 
                  ?></div></td>
                  <td><?php echo (!empty($item->item_date_start)?$item->item_date_start:null)."|".(!empty($item->item_date_end)?$item->item_date_end:null); ?></td>
                <td class="text-right">
                    <?php echo format_amount($item->item_quantity); ?>
                    <?php if ($item->item_product_unit) : ?>
                    <?php endif; ?>
                </td>
                <td class="text-right">
                    <?php echo format_currency($item->item_price); ?>
                </td>
                <td class="text-right">
                    <?php echo format_currency($item->item_total); ?>
                </td>
            </tr>
        <?php } ?>

        </tbody>
        <tbody class="invoice-sums">
        <tr>
            <td colspan="5" class="text-right">
                <?php _trans('subtotal'); ?>
            </td>
            <td class="text-right"><?php echo format_currency($invoice->invoice_item_subtotal); ?></td>
        </tr>

        <?php if ($tax_rate_totalsp > 0) { ?>
            <tr>
                <td colspan="5" class="text-right">
                    <?php _trans('MWST. 7 %'); ?>
                </td>
                <td class="text-right">
                    <?php echo format_currency($tax_rate_totalsp); ?>
                </td>
            </tr>
        <?php } ?>
        <?php if ($tax_rate_totalntp > 0) { ?>
            <tr>
                <td colspan="5" class="text-right">
                    <?php _trans('MWST. 19%'); ?>
                </td>
                <td class="text-right">
                    <?php echo format_currency($tax_rate_totalntp); ?>
                </td>
            </tr>
        <?php } ?>

        <?php foreach ($invoice_tax_rates as $invoice_tax_rate) : ?>
            <tr>
                <td colspan="5" class="text-right">
                    <?php echo htmlsc($invoice_tax_rate->invoice_tax_rate_name) . ' (' . format_amount($invoice_tax_rate->invoice_tax_rate_percent) . '%)'; ?>
                </td>
                <td class="text-right">
                    <?php echo format_currency($invoice_tax_rate->invoice_tax_rate_amount); ?>
                </td>
            </tr>
        <?php endforeach ?>

        <?php if ($invoice->invoice_discount_percent != '0.00') : ?>
            <tr>
                <td colspan="5" class="text-right">
                    <?php _trans('discount'); ?>
                </td>
                <td class="text-right">
                    <?php echo format_amount($invoice->invoice_discount_percent); ?>%
                </td>
            </tr>
        <?php endif; ?>
        <?php if ($invoice->invoice_discount_amount != '0.00') : ?>
            <tr>
                <td colspan="5" class="text-right">
                    <?php _trans('discount'); ?>
                </td>
                <td class="text-right">
                    <?php echo format_currency($invoice->invoice_discount_amount); ?>
                </td>
            </tr>
        <?php endif; ?>

        <tr>
            <td colspan="5" class="text-right">
                <b><?php _trans('total'); ?></b>
            </td>
            <td style="color:red;" class="text-right">
                <b><?php echo format_currency($invoice->invoice_total); ?></b>
            </td>
        </tr>
    </tbody>
</table>    
</main>
<footer>
    <?php if ($invoice->invoice_terms) : ?>
        <div class="notes">
            <b><?php _trans('terms'); ?></b><br/>
            <?php echo nl2br(htmlsc($invoice->invoice_terms)); ?>
        </div>
    <?php endif; ?>
</footer>
<!--
    <table width="100%">
    <tr>
        <td><?php echo ($invoice->user_iban); ?></td>
        <td><?php echo ($invoice->user_tax_code); ?></td>
        <td><?php echo ($invoice->user_vat_id); ?></td>
        <td><?php echo ($invoice->user_vat_id); ?></td> 
    </tr>
    <tr>
        <td><?php echo ($invoice->user_phone); ?></td>
        <td><?php echo ($invoice->user_web); ?></td>
        <td><?php echo ($invoice->user_email); ?></td>
        <td><?php echo ($invoice->user_vat_id); ?></td> 
    </tr>
</table>
    -->

</body>
</html>
