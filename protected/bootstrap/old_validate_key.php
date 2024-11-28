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
   system('ipconfig /all');  
   $mycomsys=ob_get_contents();  
   ob_clean();  
   $find_mac = "Physical"; //find the "Physical" & Find the position of Physical text  
   $pmac = strpos($mycomsys, $find_mac);  
   $mac=substr($mycomsys,($pmac+36),17);  

   $macaddress=$mac.$_SERVER['SERVER_ADDR'];

   $key= crypt($macaddress,'$5$rounds=5000$anexamplestringforsalt$');
  
   if($api_key!=$key){
    					exit;
  					 }else{

						   }
}