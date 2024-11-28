<?php


return array(
   'driver' => 'smtp',
 
    'host' => 'mail.probitytech.com',
 
    'port' => 465,
 
    'from' => array('address' => 'cm@probitytech.com', 'name' => 'Probity Change Management'),
 
     'username' => 'cm@probitytech.com',
	'password' => 'Screen@321',
 
    'sendmail' => '/usr/sbin/sendmail -bs',
 
    'pretend' => false,
);


