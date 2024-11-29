<!DOCTYPE html>
<html lang="en" ng-app="myApp">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
 

  

  <link href="<?php echo Request::root(); ?>/protected/public/css/font-awesome.min.css" rel="stylesheet">
  <link href="<?php echo Request::root(); ?>/protected/public/css/select2.min.css" rel="stylesheet" />

  
  <link href="<?php echo Request::root(); ?>/protected/public/js/simply-toast.min.css" rel="stylesheet">

  <link href="<?php echo Request::root(); ?>/sximo/css/animate.css" rel="stylesheet">
  
   
  <script src="<?php echo Request::root(); ?>/protected/public/js/underscore-min.js"></script>
  

</head>
<body ng-controller="RootCtrl">
<?php $name = Session::get('fid');?>
<?php $user_id = Session::get('uid');?>
<?php $user_type = Session::get('gid');?>





