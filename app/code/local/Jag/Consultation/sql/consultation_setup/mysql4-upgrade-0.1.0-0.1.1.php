<?php

$installer = $this;

$installer->startSetup();

$installer->run("

ALTER TABLE {$this->getTable('consultation')} DROP COLUMN title;
ALTER TABLE {$this->getTable('consultation')} DROP COLUMN filename;

ALTER TABLE {$this->getTable('consultation')} ADD customer_id int(11) unsigned NOT NULL after consultation_id;
ALTER TABLE {$this->getTable('consultation')} ADD phone varchar(50) NOT NULL default '' after customer_id;

    ");

$installer->endSetup(); 