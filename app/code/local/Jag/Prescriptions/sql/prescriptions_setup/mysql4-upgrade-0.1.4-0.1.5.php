<?php

$installer = $this;

$installer->startSetup();

$installer->run("


ALTER TABLE {$this->getTable('prescriptions')} add called_in varchar(50) not null default '';
ALTER TABLE {$this->getTable('prescriptions')} add dob varchar(50) not null default '';


    ");


$installer->endSetup(); 
