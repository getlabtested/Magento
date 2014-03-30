<?php

$installer = $this;

$installer->startSetup();

$installer->run("

DELETE from core_resource where code = 'results_setup';

");

$installer->endSetup(); 