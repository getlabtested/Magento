<?php

$installer = $this;

$installer->startSetup();

$installer->run("

ALTER TABLE {$this->getTable('prescriptions')} ADD notes text NULL default '';

    ");

$installer->endSetup(); 
