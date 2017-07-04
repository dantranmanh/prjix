DELETE FROM core_config_data WHERE `path` LIKE '%fooman_surcharge%';
DELETE FROM admin_rule WHERE `resource_id` LIKE '%surcharge%';
ALTER TABLE sales_flat_quote DROP COLUMN `base_fooman_surcharge_amount`;
ALTER TABLE sales_flat_quote DROP COLUMN `fooman_surcharge_amount`;
ALTER TABLE sales_flat_quote DROP COLUMN `fooman_surcharge_description`;
ALTER TABLE sales_flat_quote_address DROP COLUMN `base_fooman_surcharge_amount`;
ALTER TABLE sales_flat_quote_address DROP COLUMN `fooman_surcharge_amount`;
ALTER TABLE sales_flat_quote_address DROP COLUMN `base_fooman_surcharge_tax_amount`;
ALTER TABLE sales_flat_quote_address DROP COLUMN `fooman_surcharge_tax_amount`;
ALTER TABLE sales_flat_quote_address DROP COLUMN `fooman_surcharge_description`;
DELETE FROM `eav_attribute` WHERE attribute_code ='fooman_surcharge_amount'
OR attribute_code ='base_fooman_surcharge_amount'
OR attribute_code ='fooman_surcharge_description'
OR attribute_code ='fooman_surcharge_tax_amount'
OR attribute_code ='base_fooman_surcharge_tax_amount'
OR attribute_code = 'fooman_product_surcharge'
OR attribute_code = 'fooman_surcharge_exclude_prod'
OR attribute_code = 'fooman_order_no_surcharge';
DELETE FROM `core_resource` WHERE code ='surcharge_setup';
ALTER TABLE sales_flat_order DROP COLUMN `fooman_surcharge_amount`;
ALTER TABLE sales_flat_order DROP COLUMN `base_fooman_surcharge_amount`;
ALTER TABLE sales_flat_order DROP COLUMN `fooman_surcharge_description`;
ALTER TABLE sales_flat_order DROP COLUMN `fooman_surcharge_tax_amount`;
ALTER TABLE sales_flat_order DROP COLUMN `base_fooman_surcharge_tax_amount`;
ALTER TABLE sales_flat_order DROP COLUMN `fooman_surcharge_amount_invoiced`;
ALTER TABLE sales_flat_order DROP COLUMN `base_fooman_surcharge_amount_invoiced`;
ALTER TABLE sales_flat_order DROP COLUMN `fooman_surcharge_amount_refunded`;
ALTER TABLE sales_flat_order DROP COLUMN `base_fooman_surcharge_amount_refunded`;
ALTER TABLE sales_flat_order DROP COLUMN `fooman_surcharge_tax_amount_invoiced`;
ALTER TABLE sales_flat_order DROP COLUMN `base_fooman_surcharge_tax_amount_invoiced`;
ALTER TABLE sales_flat_order DROP COLUMN `fooman_surcharge_tax_amount_refunded`;
ALTER TABLE sales_flat_order DROP COLUMN `base_fooman_surcharge_tax_amount_refunded`;
ALTER TABLE sales_flat_invoice DROP COLUMN `fooman_surcharge_amount`;
ALTER TABLE sales_flat_invoice DROP COLUMN `base_fooman_surcharge_amount`;
ALTER TABLE sales_flat_invoice DROP COLUMN `fooman_surcharge_tax_amount`;
ALTER TABLE sales_flat_invoice DROP COLUMN `base_fooman_surcharge_tax_amount`;
ALTER TABLE sales_flat_creditmemo DROP COLUMN `fooman_surcharge_amount`;
ALTER TABLE sales_flat_creditmemo DROP COLUMN `base_fooman_surcharge_amount`;
ALTER TABLE sales_flat_creditmemo DROP COLUMN `fooman_surcharge_tax_amount`;
ALTER TABLE sales_flat_creditmemo DROP COLUMN `base_fooman_surcharge_tax_amount`;