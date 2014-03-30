<?php


$data = $api->data($idg, '', 'ga:visits,ga:pageviews,ga:newVisits,ga:visitors', false, $curMonthGa, $dateGa, 1000000, 1, $filters);
$visitorCount = $data['ga:visitors'];

$tv = $visitorCount;

$phone = getCalls($curMonth,$currentMonth);
	
$sales = makeReport($curMonth,$currentMonth);
	
$ref = getRefunds($curMonth,$currentMonth);
	
	$query = 'select count(*) as sales,
			a.order_type,
			b.method,
			SUM(a.total_paid) as total,
			AVG(a.total_paid) as average
		FROM 
			sales_flat_order as a 
			join sales_flat_order_payment as b on b.parent_id = a.entity_id 
		WHERE 
			a.product_line >= 2 
			and a.status = "complete" 
			and a.created_at > "'.$curMonth.'";';  
			
	//echo $query; echo "<br>";           
     	    
    $sth = $db->prepare($query);
	$sth->setFetchMode(Zend_Db::FETCH_ASSOC);
    $sth->execute();
	$scripts = new Varien_Object();
	$scripts->setData($sth->fetch());
	
$query = 'select SUM(a.lab_revenue) as total 
		FROM 
			sales_flat_order as a join sales_flat_invoice as b on b.order_id = a.entity_id 
		WHERE 
			a.ppmd_provider != 1  
			and b.updated_at > "'.$curMonth.'";';           
			
	//echo $query; echo "<br>"; 
     	    
    $sth = $db->prepare($query);
	$sth->setFetchMode(Zend_Db::FETCH_ASSOC);
    $sth->execute();
	$nnr = new Varien_Object();
	$nnr->setData($sth->fetch());
	
		
?>


<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tbody>
	<thead>
	<tr class="headings" >
		<td></td>
		<th class="no-link" colspan="3">Visitor Count</td>
		<th class="no-link" colspan="11">Sales</td>
		<th class="no-link" onmouseover="this.T_SHADOWWIDTH=2;this.T_WIDTH=200;return escape('Todays conv rates based off a 59.20% pay later conversion')" colspan="3">* Conv Rates</td>
		<th class="no-link" colspan="10">Revenue</td>
		<th class="no-link" colspan="3">Avg. Sale Price</td>
	</tr>
	</thead>
	<tr>
		<td></td>
		
		<td style="">Phone</td>
		<td>Online</td>
		<td style="background-color:#F6F6F6;">Total</td>
		
		<td align="center" style="" colspan="4">Phone</td>
		<td align="center" style="" colspan="3">Online</td>
		<td align="center" style="" colspan="4">Total</td>
		
		<td>Phone</td>
		<td>Online</td>
		<td style="background-color:#F6F6F6;">Total</td>
		
		<td>Phone</td>
		<td>Online</td>
		<td>Script</td>
		<td>PL</td>
		<td>PC</td>
		<td>Ref</td>
		<td>NNR</td>
		<td style="background-color:#F6F6F6;">Sales</td>
		<td style="background-color:#F6F6F6;">Paid</td>
		<td style="background-color:#F6F6F6;">Cash</td>
		
		<td>Phone</td>
		<td>Online</td>
		<td style="background-color:#F6F6F6;">Total</td>
	</tr>
	<tr>
		<td style="">&nbsp;</td>
		
		<td style="">&nbsp;</td>
		<td style="">&nbsp;</td>
		<td style="background-color:#F6F6F6;">&nbsp;</td>
		
		<td style="">PN</td>
		<td style="">PL</td>
		<td style="">PC</td>
		<td style="background-color:#F6F6F6;">T</td>
		
		<td style="">PN</td>
		<td style="">PC</td>
		<td style="background-color:#F6F6F6;">T</td>
		
		<td style="">PN</td>
		<td style="">PL</td>
		<td style="">PC</td>
		<td style="background-color:#F6F6F6;">T</td>
		
		<td style="">&nbsp;</td>
		<td style="">&nbsp;</td>
		<td style="background-color:#F6F6F6;">&nbsp;</td>
		
		<td style="">&nbsp;</td>
		<td style="">&nbsp;</td>
		<td style="">&nbsp;</td>
		<td style="">&nbsp;</td>
		<td style="">&nbsp;</td>
		<td style="">&nbsp;</td>
		<td style="">&nbsp;</td>
		<td style="background-color:#F6F6F6;">&nbsp;</td>
		<td style="background-color:#F6F6F6;">&nbsp;</td>
		<td style="background-color:#F6F6F6;">&nbsp;</td>
		
		<td style="">&nbsp;</td>
		<td style="">&nbsp;</td>
		<td style="background-color:#F6F6F6;">&nbsp;</td>
	</tr>
    <tr bgcolor="white">
    	<td style="">gst</td>      
      	
      	<td style=""><?php echo $phone->getCalls();?></td>
      	<td><?php echo $tv; ?></td>
      	<td style="background-color:#F6F6F6;"><?php echo $phone->getCalls()+$tv;?></td>
      	
      	<td><?php echo $sales['phone']['authorizenet']->getSales();?></td>
      	<td><?php echo $sales['phone']['paylater']->getSales();?></td>
      	<td><?php echo $sales['phone']['paynearme']->getSales();?></td>
      	<?php
      	
      	$pt = $sales['phone']['authorizenet']->getSales()+$sales['phone']['paylater']->getSales()+$sales['phone']['paynearme']->getSales();
      	
      	?>
      	<td style="background-color:#F6F6F6;"><?php echo $pt; ?></td>
      	      	
      	<td><?php echo $sales['online']['authorizenet']->getSales();?></td>
      	<td><?php echo $sales['online']['paynearme']->getSales();?></td>
      	<?php
      	
      	$ot =  $sales['online']['authorizenet']->getSales()+$sales['online']['paylater']->getSales()+$sales['online']['paynearme']->getSales();
      	
      	?>
      	<td style="background-color:#F6F6F6;"><?php echo $ot;?></td>
      	      	
      	<td><?php echo $sales['phone']['authorizenet']->getSales()+$sales['online']['authorizenet']->getSales();?></td>
      	<td><?php echo $sales['phone']['paylater']->getSales()+$sales['online']['paylater']->getSales();?></td>
      	<td><?php echo $sales['phone']['paynearme']->getSales()+$sales['online']['paynearme']->getSales();?></td>
      	<td style="background-color:#F6F6F6;"><?php echo $pt+$ot;?></td>
      	
      	
      	<?php $at = $pt; 
      	
      		$rate = ($at/$phone->getCalls())*100;
      	
      	?>
      	
      	<td><?php echo round($rate,2);?>%</td>
      	
      	<?php 
      	
      		$to = $sales['online']['paynearme']->getSales();
      		
      		$tor = round($to/1.8);
      		      		
      		$at = $ot - $tor; 
      	
      		$rate = ($at/$tv)*100;
      	
      	?>
      	
      	<td><?php echo round($rate,2);?>%</td>
      	
      	<?php 
      	      	
      	      	
      	    $vt = $tv + $phone->getCalls();
      	      	
      		$totalOrders = $at + $pt;
      		      		      		
      		$at = $totalOrders;
      	
      		$rate = ($at/$vt)*100;
      		      		
      		
      	
      	?>
      	
      	
      	<td style="background-color:#F6F6F6;"><?php echo round($rate,2);?>%</td>
 <?php 
 
 		/*
print_r($sales['phone_totals']);
 
 		print_r($sales['online_totals']);
*/

		$gpt = $sales['phone_totals']['authorizenet']->getTotal()+$sales['phone_totals']['paynearme']->getTotal()+$sales['phone_totals']['paylater']->getTotal();
		
		$got =  $sales['online_totals']['authorizenet']->getTotal()+$sales['online_totals']['paynearme']->getTotal();

 
  ?>
       	
      	<td>$<?php echo round($sales['phone']['authorizenet']->getPaid());?></td>
      	<td>$<?php echo round($sales['online']['authorizenet']->getPaid());?></td>
      	
      	<td>$<?php echo round($scripts->getTotal());?></td>
      	
      	<td>$<?php echo round($sales['phone_totals']['paylater']->getTotal()+$sales['online_totals']['paylater']->getTotal()-$sales['online']['paylater']->getPaid());?></td>
      	<td>$<?php echo round($sales['phone_totals']['paynearme']->getTotal()+$sales['online_totals']['paynearme']->getTotal());?></td>      	
      	
      	<?php
      	
      	$gross = $sales['phone']['authorizenet']->getGross()+$sales['phone']['paylater']->getGross()+$sales['phone']['paynearme']->getGross()+$sales['online']['authorizenet']->getGross()+$sales['online']['paynearme']->getGross();
      	
      	
      	$tr = $sales['phone_totals']['authorizenet']->getRefunded()+$sales['phone_totals']['paylater']->getRefunded()+$sales['phone_totals']['paynearme']->getRefunded()+$sales['online_totals']['authorizenet']->getRefunded()+$sales['online_totals']['paylater']->getRefunded()+$sales['online_totals']['paynearme']->getRefunded();
      	
      	
      	?>
      	
      	<td>$<?php echo round($ref,2);?></td>
      	<td>$<?php echo round($nnr->getTotal());?></td>
      	<td style="background-color:#F6F6F6;">$<?php echo round($gross); ?></td>
      	<td style="background-color:#F6F6F6;">$<?php echo round($gpt+$got); ?></td>
      	<td style="background-color:#F6F6F6;">$<?php echo round((($gpt+$got)-$ref)); ?></td>
      	
      	<?php
      	
      	$pAvg = ($sales['phone']['authorizenet']->getGross()+$sales['phone']['paynearme']->getGross()+$sales['phone']['paylater']->getGross())/$pt;
      	$oAvg = ($sales['online']['authorizenet']->getGross()+$sales['online']['paynearme']->getGross())/$ot;
      	
      	$tAvg = ($gross - $scripts->getTotal())/($pt+$ot - $scripts->getSales());
      	
      	?>
      	
      	<td>$<?php echo round($pAvg);?></td>
      	<td>$<?php echo round($oAvg);?></td>
      	<td style="background-color:#F6F6F6;">$<?php echo round($tAvg);?></td>
    </tr>
    
       
    <tr style="">
   		<td>TOTAL</td>
   		
   		<td style=""><?php echo $phone->getCalls();?></td>
      	<td><?php echo $tv; ?></td>
      	<td style="background-color:#F6F6F6;"><?php echo $phone->getCalls()+$tv;?></td>
      	
      	<td><?php echo $sales['phone']['authorizenet']->getSales();?></td>
      	<td><?php echo $sales['phone']['paylater']->getSales();?></td>
      	<td><?php echo $sales['phone']['paynearme']->getSales();?></td>
      	<?php
      	
      	$pt = $sales['phone']['authorizenet']->getSales()+$sales['phone']['paylater']->getSales()+$sales['phone']['paynearme']->getSales();
      	
      	?>
      	<td style="background-color:#F6F6F6;"><?php echo $pt; ?></td>
      	      	
      	<td><?php echo $sales['online']['authorizenet']->getSales();?></td>
      	<td><?php echo $sales['online']['paynearme']->getSales();?></td>
      	<?php
      	
      	$ot =  $sales['online']['authorizenet']->getSales()+$sales['online']['paylater']->getSales()+$sales['online']['paynearme']->getSales();
      	
      	?>
      	<td style="background-color:#F6F6F6;"><?php echo $ot;?></td>
      	      	
      	<td><?php echo $sales['phone']['authorizenet']->getSales()+$sales['online']['authorizenet']->getSales();?></td>
      	<td><?php echo $sales['phone']['paylater']->getSales()+$sales['online']['paylater']->getSales();?></td>
      	<td><?php echo $sales['phone']['paynearme']->getSales()+$sales['online']['paynearme']->getSales();?></td>
      	<td style="background-color:#F6F6F6;"><?php echo $pt+$ot;?></td>
      	
      	
      	<?php $at = $pt; 
      	
      		$rate = ($at/$phone->getCalls())*100;
      	
      	?>
      	
      	<td><?php echo round($rate,2);?>%</td>
      	
      	<?php 
      	
      		$to = $sales['online']['paynearme']->getSales();
      		
      		$tor = round($to/1.8);
      		      		
      		$at = $ot - $tor; 
      	
      		$rate = ($at/$tv)*100;
      	
      	?>
      	
      	<td><?php echo round($rate,2);?>%</td>
      	
      	<?php 
      	      	
      	      	
      	    $vt = $tv + $phone->getCalls();
      	      	
      		$totalOrders = $at + $pt;
      		      		      		
      		$at = $totalOrders;
      	
      		$rate = ($at/$vt)*100;
      		      		
      		
      	
      	?>
      	
      	
      	<td style="background-color:#F6F6F6;"><?php echo round($rate,2);?>%</td>
 <?php 
 
 		/*
print_r($sales['phone_totals']);
 
 		print_r($sales['online_totals']);
*/

		$gpt = $sales['phone_totals']['authorizenet']->getTotal()+$sales['phone_totals']['paynearme']->getTotal()+$sales['phone_totals']['paylater']->getTotal();
		
		$got =  $sales['online_totals']['authorizenet']->getTotal()+$sales['online_totals']['paynearme']->getTotal();

 
  ?>
       	
      	<td>$<?php echo round($sales['phone']['authorizenet']->getPaid());?></td>
      	<td>$<?php echo round($sales['online']['authorizenet']->getPaid());?></td>
      	
      	<td>$<?php echo round($scripts->getTotal());?></td>
      	
      	<td>$<?php echo round($sales['phone_totals']['paylater']->getTotal()+$sales['online_totals']['paylater']->getTotal()-$sales['online']['paylater']->getPaid());?></td>
      	<td>$<?php echo round($sales['phone_totals']['paynearme']->getTotal()+$sales['online_totals']['paynearme']->getTotal());?></td>      	
      	
      	<?php
      	
      	$gross = $sales['phone']['authorizenet']->getGross()+$sales['phone']['paylater']->getGross()+$sales['phone']['paynearme']->getGross()+$sales['online']['authorizenet']->getGross()+$sales['online']['paynearme']->getGross();
      	
      	
      	$tr = $sales['phone_totals']['authorizenet']->getRefunded()+$sales['phone_totals']['paylater']->getRefunded()+$sales['phone_totals']['paynearme']->getRefunded()+$sales['online_totals']['authorizenet']->getRefunded()+$sales['online_totals']['paylater']->getRefunded()+$sales['online_totals']['paynearme']->getRefunded();
      	
      	
      	?>
      	
      	<td>$<?php echo round($ref,2);?></td>
      	<td>$<?php echo round($nnr->getTotal());?></td>
      	<td style="background-color:#F6F6F6;">$<?php echo round($gross); ?></td>
      	<td style="background-color:#F6F6F6;">$<?php echo round($gpt+$got); ?></td>
      	<td style="background-color:#F6F6F6;">$<?php echo round((($gpt+$got)-$ref)); ?></td>
      	
      	<?php
      	
      	$pAvg = ($sales['phone']['authorizenet']->getGross()+$sales['phone']['paynearme']->getGross()+$sales['phone']['paylater']->getGross())/$pt;
      	$oAvg = ($sales['online']['authorizenet']->getGross()+$sales['online']['paynearme']->getGross())/$ot;
      	
      	$tAvg = ($gross - $scripts->getTotal())/($pt+$ot - $scripts->getSales());
      	
      	?>
      	
      	<td>$<?php echo round($pAvg);?></td>
      	<td>$<?php echo round($oAvg);?></td>
      	<td style="background-color:#F6F6F6;">$<?php echo round($tAvg);?></td>
    </tr>
</tbody>
</table>