<?php

$installer = $this;

$installer->startSetup();

$connection_config = $installer->getConnection()->getConfig();
$db_table = $connection_config['dbname'];

$installer->run("
DELETE FROM $db_table.`core_resource` WHERE `core_resource`.`code` = 'enterprise_admingws_setup' LIMIT 1;
DELETE FROM $db_table.`core_resource` WHERE `core_resource`.`code` = 'enterprise_banner_setup' LIMIT 1;
DELETE FROM $db_table.`core_resource` WHERE `core_resource`.`code` = 'enterprise_catalogevent_setup' LIMIT 1;
DELETE FROM $db_table.`core_resource` WHERE `core_resource`.`code` = 'enterprise_catalogpermissions_setup' LIMIT 1;
DELETE FROM $db_table.`core_resource` WHERE `core_resource`.`code` = 'enterprise_cms_setup' LIMIT 1;
DELETE FROM $db_table.`core_resource` WHERE `core_resource`.`code` = 'enterprise_customerbalance_setup' LIMIT 1;
DELETE FROM $db_table.`core_resource` WHERE `core_resource`.`code` = 'enterprise_customersegment_setup' LIMIT 1;
DELETE FROM $db_table.`core_resource` WHERE `core_resource`.`code` = 'enterprise_customer_setup' LIMIT 1;
DELETE FROM $db_table.`core_resource` WHERE `core_resource`.`code` = 'enterprise_enterprise_setup' LIMIT 1;
DELETE FROM $db_table.`core_resource` WHERE `core_resource`.`code` = 'enterprise_giftcardaccount_setup' LIMIT 1;
DELETE FROM $db_table.`core_resource` WHERE `core_resource`.`code` = 'enterprise_giftcard_setup' LIMIT 1;
DELETE FROM $db_table.`core_resource` WHERE `core_resource`.`code` = 'enterprise_giftregistry_setup' LIMIT 1;
DELETE FROM $db_table.`core_resource` WHERE `core_resource`.`code` = 'enterprise_giftwrapping_setup' LIMIT 1;
DELETE FROM $db_table.`core_resource` WHERE `core_resource`.`code` = 'enterprise_invitation_setup' LIMIT 1;
DELETE FROM $db_table.`core_resource` WHERE `core_resource`.`code` = 'enterprise_logging_setup' LIMIT 1;
DELETE FROM $db_table.`core_resource` WHERE `core_resource`.`code` = 'enterprise_pagecache_setup' LIMIT 1;
DELETE FROM $db_table.`core_resource` WHERE `core_resource`.`code` = 'enterprise_pci_setup' LIMIT 1;
DELETE FROM $db_table.`core_resource` WHERE `core_resource`.`code` = 'enterprise_reminder_setup' LIMIT 1;
DELETE FROM $db_table.`core_resource` WHERE `core_resource`.`code` = 'enterprise_reward_setup' LIMIT 1;
DELETE FROM $db_table.`core_resource` WHERE `core_resource`.`code` = 'enterprise_salesarchive_setup' LIMIT 1;
DELETE FROM $db_table.`core_resource` WHERE `core_resource`.`code` = 'enterprise_search_setup' LIMIT 1;
DELETE FROM $db_table.`core_resource` WHERE `core_resource`.`code` = 'enterprise_staging_setup' LIMIT 1;
DELETE FROM $db_table.`core_resource` WHERE `core_resource`.`code` = 'enterprise_targetrule_setup' LIMIT 1;
DELETE FROM $db_table.`core_resource` WHERE `core_resource`.`code` = 'enterprise_websiterestriction_setup' LIMIT 1;
DELETE FROM $db_table.`eav_attribute` WHERE `eav_attribute`.`attribute_id` = 121 LIMIT 1;
DELETE FROM $db_table.`eav_attribute` WHERE `eav_attribute`.`attribute_id` = 138 LIMIT 1;
DELETE FROM $db_table.`eav_attribute` WHERE `eav_attribute`.`attribute_id` = 139 LIMIT 1;
DELETE FROM $db_table.`eav_attribute` WHERE `eav_attribute`.`attribute_id` = 140 LIMIT 1;
DELETE FROM $db_table.`eav_attribute` WHERE `eav_attribute`.`attribute_id` = 141 LIMIT 1;
");

$installer->endSetup();