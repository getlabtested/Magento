<?php

$installer = $this;

$installer->startSetup();

$installer->run("


ALTER TABLE {$this->getTable('prescriptions')} add drugs text not null default '' after cur_otc_meds;


    ");

$installer->endSetup(); 
