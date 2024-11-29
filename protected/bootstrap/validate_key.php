<?php

if(DIRECTORY_SEPARATOR == '/'){  // for Linux system

 exec("/sbin/ifconfig | grep HWaddr", $output);

  $mac=explode(' ',$output[0]);
  $macaddress=$mac[10].$_SERVER['SERVER_ADDR'];
  $key= crypt($macaddress,'$5$rounds=5000$anexamplestringforsalt$');
  
  if($api_key!=$key){
   						 exit;
                    }else{
                           
                         }

}else if(DIRECTORY_SEPARATOR == '\\'){// For windows system
   ob_start();  
   system('getmac /FO list');  
   $mycomsys=ob_get_contents();  
   ob_clean();  
  $array2=explode("Physical Address: ", $mycomsys);
  $cnt = count($array2);
 
  $f=0;
  for($i=0;$i<$cnt;$i++){
    $macaddress = substr($array2[$i],0,17);
     $key= crypt($macaddress,'$5$rounds=5000$anexamplestringforsalt$');
    
     if($api_key==$key){
             $f=1;
             }
  }
  


  
   if($f!=1){
   
    					echo "Invalid Key";exit;
  					 }
}