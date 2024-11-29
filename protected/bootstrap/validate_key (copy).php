<?php

exec("/sbin/ifconfig | grep HWaddr", $output);

//print_r( $output);

$mac=explode(' ',$output[0]);
 $macaddress=$mac[10].$_SERVER['SERVER_ADDR'];


$key= crypt($macaddress,'$5$rounds=5000$anexamplestringforsalt$');

if($api_key!=$key){//echo "in validkey";
  //  exit;
}
//exit;