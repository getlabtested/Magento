<?php

$installer = $this;

$installer->startSetup();

$installer->run("

ALTER TABLE {$this->getTable('prescriptions')} ADD scripts varchar(255) NOT NULL default '';

    ");

$installer->endSetup(); 
