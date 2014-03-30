<?php

$this->startSetup();
//Add column to grid table
$this->getConnection()->addColumn(
    $this->getTable('sales/order_grid'),
    'ppmd_activate',
    "int(5) null default 0"
);
// Add key to table for this field,
// it will improve the speed of searching & sorting by the field
$this->getConnection()->addKey(
    $this->getTable('sales/order_grid'),
    'ppmd_activate',
    'ppmd_activate'
);


$this->endSetup();