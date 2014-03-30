<?php

$installer = $this;

$installer->startSetup();

$installer->run("


ALTER TABLE {$this->getTable('prescriptions')} add prescription_name varchar(200) null default '';


    ");


$installer->endSetup(); 
