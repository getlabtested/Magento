<?php

$installer = $this;

$installer->startSetup();

$installer->run("

ALTER TABLE {$this->getTable('prescriptions')} drop column med_history;

ALTER TABLE {$this->getTable('prescriptions')} add med_history text not null default '' after cur_otc_meds;


    ");

$installer->endSetup(); 
