<?php

/*
    function getDays($sStartDate, $sEndDate){  
 
      $sStartDate = gmdate("Y-m-d", strtotime($sStartDate));  
      $sEndDate = gmdate("Y-m-d", strtotime($sEndDate));  
      
      $aDays[] = $sStartDate;  
 
      $sCurrentDate = $sStartDate;  
      
      while($sCurrentDate < $sEndDate){  

        $sCurrentDate = gmdate("Y-m-d", strtotime("+1 day", strtotime($sCurrentDate)));  
      
        $aDays[] = $sCurrentDate;  
      }  

      return $aDays;  
    } 
*/
    
    function getDays($sStartDate, $sEndDate){  

      $sStartDate = gmdate("Y-m-d", strtotime($sStartDate));  
      $sEndDate = gmdate("Y-m-d", strtotime($sEndDate)+(60*60*24));  
 
      $sCurrentDate = $sStartDate;  
            
      $set = 0;
      
      while($sCurrentDate < $sEndDate){  
  
  		$tArr['start'] = $sCurrentDate;
  		
  		if ($set == 0) {
      		
      		$tArr['start'] = $sStartDate;
      		$tArr['end'] = $sCurrentDate; 
      		$set = 1; 
      		     	
      	} else {
        	
      	$sCurrentDate = gmdate("Y-m-d", strtotime("+1 day", strtotime($sCurrentDate)));      
      	
        $tArr['end'] = $sCurrentDate;  
        
        $aDays[] = $tArr; 
        
        }     
                
        $tArr = array();
                        
      }  
      
      return $aDays;  
    } 
    
    function getWeeks($sStartDate, $sEndDate){  

      $sStartDate = gmdate("Y-m-d", strtotime($sStartDate));  
      $sEndDate = gmdate("Y-m-d", strtotime($sEndDate));  
 
      $sCurrentDate = $sStartDate;  
            
      $set = 0;
      
      while($sCurrentDate < $sEndDate){  
  
  		$tArr['start'] = $sCurrentDate;
  		
  		if ($set == 0) {
      		
      		$tArr['start'] = $sStartDate;
      		$tArr['end'] = $sCurrentDate; 
      		$set = 1; 
      		     	
      	} else {
        	
      	$sCurrentDate = gmdate("Y-m-d", strtotime("+1 week", strtotime($sCurrentDate)));      
      	
        $tArr['end'] = $sCurrentDate;  
        
        $aDays[] = $tArr; 
        
        }     
                
        $tArr = array();
                        
      }  
      
      return $aDays;  
    } 
    
    function getMonths($sStartDate, $sEndDate){  

      $sStartDate = gmdate("Y-m", strtotime($sStartDate));  
      $sEndDate = gmdate("Y-m", strtotime($sEndDate));  
 
      $sCurrentDate = $sStartDate;  
            
      $set = 0;
      
      while($sCurrentDate < $sEndDate){  
  
  		$tArr['start'] = $sCurrentDate."-01";
  		
  		if ($set == 0) {
      		
      		$tArr['start'] = $sStartDate."-01";
      		$tArr['end'] = $sCurrentDate."-01"; 
      		$set = 1; 
      		     	
      	} else {
        	
      	$sCurrentDate = gmdate("Y-m", strtotime("+1 month", strtotime($sCurrentDate)));      
      	
        $tArr['end'] = $sCurrentDate."-01";  
        
        $aDays[] = $tArr; 
        
        }     
                
        $tArr = array();
                        
      }  
      
      return $aDays;  
    } 
    
?>