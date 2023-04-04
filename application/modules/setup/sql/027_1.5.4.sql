# Fix the recurring invoices frequency
ALTER TABLE `ip_invoices_recurring`
  CHANGE `recur_frequency` `recur_frequency` VARCHAR(255)
CHARACTER SET utf8
COLLATE utf8_general_ci NOT NULL;

# ALTER TABLE `ip_invoice_items` ADD `item_date_start` DATE NULL AFTER `item_price`;
# ALTER TABLE `ip_invoice_items` ADD `item_date_end` DATE NULL AFTER `item_date_start`;
# ALTER TABLE `ip_invoice_items` ADD `item_room` TINYINT(4) NULL AFTER `item_date_end`;
