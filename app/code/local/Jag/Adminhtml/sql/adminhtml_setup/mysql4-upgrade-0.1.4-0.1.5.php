<?php

$this->startSetup(); 
// Add column to grid table
$this->getConnection()->addColumn(
    $this->getTable('sales/order_grid'),
    'ppmd_provider',
    "int(5) null default 0"
);
// Add key to table for this field,
// it will improve the speed of searching & sorting by the field
$this->getConnection()->addKey(
    $this->getTable('sales/order_grid'),
    'ppmd_provider',
    'ppmd_provider'
);

$this->getConnection()->addColumn(
    $this->getTable('sales/order_grid'),
    'ppmd_cust_id',
    "varchar(50) null default NULL"
);
// Add key to table for this field,
// it will improve the speed of searching & sorting by the field
$this->getConnection()->addKey(
    $this->getTable('sales/order_grid'),
    'ppmd_cust_id',
    'ppmd_cust_id'
);

$this->getConnection()->addColumn(
    $this->getTable('sales/order_grid'),
    'ppmd_cust_acct',
    "varchar(50) null default NULL"
);
// Add key to table for this field,
// it will improve the speed of searching & sorting by the field
$this->getConnection()->addKey(
    $this->getTable('sales/order_grid'),
    'ppmd_cust_acct',
    'ppmd_cust_acct'
);

$this->getConnection()->addColumn(
    $this->getTable('sales/order_grid'),
    'ppmd_cust_conf',
    "varchar(50) null default NULL"
);
// Add key to table for this field,
// it will improve the speed of searching & sorting by the field
$this->getConnection()->addKey(
    $this->getTable('sales/order_grid'),
    'ppmd_cust_conf',
    'ppmd_cust_conf'
);

$this->getConnection()->addColumn(
    $this->getTable('sales/order_grid'),
    'ppmd_status',
    "int(5) null default 0"
);
// Add key to table for this field,
// it will improve the speed of searching & sorting by the field
$this->getConnection()->addKey(
    $this->getTable('sales/order_grid'),
    'ppmd_status',
    'ppmd_status'
);






$this->endSetup();