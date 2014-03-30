<?php

	function makeTable($res,$header,$superheader = null,$span = null,$dte = 0,$type=1,$pn = null,$t = null,$visits = null,$site = null){
	
		$sumCount = 0;
				
		echo '<table width="100%" cellspacing="0" cellpadding="0" border="0">';

		echo "<tr>";
		
			echo '<th colspan="'.($span).'" class="super">'.$superheader.'</th>';
		
		echo "</tr>";
		
		$alpha = array_slice($res, 0, 1);
				
		$beta = key($alpha);
		
		$k = array_keys($res[$beta]);
		
		$count = count($k);
		
		echo "<tr class='headings'>";
				
			if ($dte) {
			
				if ($site) {
				
					echo "<th>Site</th>";
					
				} else {
				
					echo "<th>Date</th>";
				
				}
			
			}
		
		foreach ($k as $h=>$v) {
		
			echo "<th>$v</th>";
			
			$counter[$v] = 0;
		
		}
		
		//print_r($counter); exit();
		
		echo "</tr>";
		
		foreach ($res as $p=>$row) {
		
			echo "<tr>";
			
				if ($dte) {
				
					if ($site) {
			
						echo "<td>GST</td>";
						
					
					} else {
					
						$d = explode("-",$p);
					
						echo "<td>".$d[0].'-'.$d[1].'-'.$d[2]."</td>";
					
					}
					
				}
				
				foreach ($row as $h=>$r) {
				
					if ($superheader == 'Phone Conv' || $superheader == 'Online Conv') {
							
						echo "<td>".$r."%</td>";
						
					} else if ($superheader == 'Revenue'  || $superheader == 'Averages') {
					
						echo "<td>$".$r."</td>";
					
					} else {
					
						echo "<td>$r</td>";
					
					}
					
					$counter[$h] = $counter[$h]+$r;
				
				}		
				
			echo "</tr>";
		
		}
				
		echo "<tr>";
				
		if ($dte) {
		
			echo "<td>&nbsp;</td>";
			
			foreach ($k as $h=>$v) {
			
				if ($type == 1) {
				
					if ($superheader == 'Revenue'  || $superheader == 'Averages'){
		
						echo "<td>$".$counter[$v]."</td>";
						
					} else {
					
						echo "<td>".$counter[$v]."</td>";
					
					}
				
				} else {
				
					if ($superheader == 'Phone Conv' || $superheader == 'Online Conv') {
				
						echo "<td>".round(($counter[$v]/count($res)),2)."%</td>";
						
					} else if ($superheader == 'Revenue' || $superheader == 'Averages'){
					
						echo "<td>$".round(($counter[$v]/count($res)),2)."</td>";
					
					} else {
					
						echo "<td>".round(($counter[$v]/count($res)),2)."</td>";
					
					}
				
				}
		
			}
			
		} else {
		
			if ($superheader == 'Phone Conv') {
			
						
				echo "<td>".round((($pn/$visits)*100),1)."%</td>";
				
				echo "<td>".round((($t/$visits)*100),1)."%</td>";
					
			
			} else if ($superheader == 'Online Conv') {
			
				echo "<td>".round((($pn/$visits)*100),2)."%</td>";
				
				echo "<td>".round((($t/$visits)*100),2)."%</td>";
			
			
			} else {
		
				foreach ($k as $h=>$v) {
			
					if ($type == 1) {
					
						if ($superheader == 'Revenue' || $superheader == 'Averages'){
			
							echo "<td>$".$counter[$v]."</td>";
							
						} else {
						
							echo "<td>".$counter[$v]."</td>";
						
						}
					
					} else {
					
						if ($superheader == 'Revenue' || $superheader == 'Averages'){
					
							echo "<td>$".round(($counter[$v]/count($res)),2)."</td>";
							
						} else {
						
							echo "<td>".round(($counter[$v]/count($res)),2)."</td>";
						
						}
					
					}
			
				}
				
			}
		
			//echo "<td>$sumCount</td>";
		
		}
		
		echo "</tr>";
		
		echo "</table>";
	
	}

?>