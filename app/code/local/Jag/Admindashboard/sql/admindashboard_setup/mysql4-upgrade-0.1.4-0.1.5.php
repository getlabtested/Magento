<?php

$installer = $this;
return $this;
$installer->startSetup();

$installer->run("
 
  CREATE INDEX IDX_PPMDREP_CREATED_AT ON sales_flat_quote (ppmd_rep, created_at);
  CREATE INDEX IDX_PPMDREP_PPMDAFFILIATE_CREATED_AT ON sales_flat_quote (ppmd_rep, ppmd_affiliate, created_at);
  CREATE INDEX IDX_PPMDREP_CREATED_AT ON sales_flat_order (ppmd_rep, created_at);
  CREATE INDEX IDX_PPMDREP_PPMDAFFILIATE_CREATED_AT ON sales_flat_order (ppmd_rep, ppmd_affiliate, created_at);
  CREATE INDEX IDX_PPMDREP_PRODUCTLINE_CREATEDAT ON sales_flat_order (ppmd_rep, product_line, created_at);
  CREATE INDEX IDX_PPMDREP_PPMDAFFILIATE_PRODUCTLINE_CREATEDAT ON sales_flat_order (ppmd_rep, ppmd_affiliate, product_line, created_at);
  CREATE INDEX IDX_PRODUCTLINE_CREATEDAT ON sales_flat_order (product_line, created_at);
  CREATE INDEX IDX_PRODUCTLINE_STATUS_CREATEDAT ON sales_flat_order (product_line, status, created_at);
  CREATE INDEX IDX_METHOD ON sales_flat_order_payment (method);
  CREATE INDEX IDX_UPDATEDAT ON sales_flat_invoice (updated_at);

  
 ");


$installer->endSetup(); 
