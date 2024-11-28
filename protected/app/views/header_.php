<!DOCTYPE html>
<html lang="en" ng-app="myApp">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>Home | CM</title>

  <!-- Bootstrap -->





  <link rel="stylesheet" type="text/css" href="<?php echo Request::root(); ?>/protected/public/css/bootstrap.min.css">
    <script type="text/javascript" src="<?php echo Request::root(); ?>/protected/public/js/jquery.min.js"></script>
<script src="<?php echo Request::root(); ?>/protected/public/js/jquery-ui.js"></script>
  <link rel="stylesheet" href="<?php echo Request::root(); ?>/protected/public/css/jquery-ui.css" />

  <link rel="stylesheet" href="<?php echo Request::root(); ?>/protected/public/css/bootstrap-dropdown.css">

  <link href="<?php echo Request::root(); ?>/protected/public/css/font-awesome.min.css" rel="stylesheet">
  <link href="<?php echo Request::root(); ?>/protected/public/css/select2.min.css" rel="stylesheet" />

  <link href="<?php echo Request::root(); ?>/protected/public/css/custom.css" rel="stylesheet">
  <link href="<?php echo Request::root(); ?>/protected/public/js/simply-toast.min.css" rel="stylesheet">

  <link href="<?php echo Request::root(); ?>/sximo/css/animate.css" rel="stylesheet">
  
   
     

  <script src="<?php echo Request::root(); ?>/protected/public/js/underscore-min.js"></script>
  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

  <![endif]-->

</head>
<body ng-controller="RootCtrl">
<?php $name = Session::get('fid');?>
<?php $user_id = Session::get('uid');?>
<?php $user_type = Session::get('gid');?>


<header>
  <div class="container-fluid">
    <nav class="navbar navbar-fixed">
      <div class="row">
        <div class="logo-wrapper col-sm-2">
          <a href="<?php echo Request::root().'/dashboard' ?>" class="logo"><img src="<?php echo Request::root(); ?>/uploads/Dashboardlogo/<%logo.logo_image%>" alt="Company Logo"></a>
        </div><!--logo-wrapper-->
        <?php $PAGE_NAME=Request::segment(1); ?>
        <div class="col-sm-7 menu">

          <ul id="nav" class="nav">
            <li   <?php if ($PAGE_NAME=='dashboard'){?>  class="active" <?php }?>>
              <a class="" href="<?php echo Request::root().'/dashboard' ?>"><i class="fa fa-th-large"></i> Dashboard</a>
            </li>
            <li   <?php if ($PAGE_NAME=='changes'){?>  class="active" <?php }?>>
              <a class="" href="<?php echo Request::root().'/changes' ?>"><i class="fa fa-plus-circle"></i> Add Change Request</a>
            </li >
            <li   <?php if ($PAGE_NAME=='views'){?>  class="active" <?php }?>>
              <a class="" href="<?php echo Request::root().'/views' ?>"><i class="fa fa-eye"></i> View</a>
            </li>
            <li   <?php if ($PAGE_NAME=='advance-search'){?>  class="active" <?php }?>>
              <a class="" href="<?php echo Request::root().'/advance-search' ?>"><i class="fa fa-search"></i> Search</a>
            </li>
            <li   <?php if ($PAGE_NAME=='reports'){?>  class="active" <?php }?>>
              <a class="" href="<?php echo Request::root().'/reports' ?>"><i class="fa fa-file-text"></i> Reports</a>
            </li>
            <li  <?php if ($PAGE_NAME=='scm'){?>  class="active" <?php }?>>
              <!--<a class="" href="<?php //echo Request::root().'/scm' ?>"><i class="fa fa-cogs"></i> SCM</a>-->
              <a class="" href="#"><i class="fa fa-cogs"></i> SCM</a>
            </li>
          </ul>
        </div>


        <div class="col-sm-3 menu">
          <ul id="right-nav" class="pull-right nav">


            <li class="dropdown profile">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <span><?php echo Session::get('fid');?></span><span class="caret"></span>
              </a>
              <ul class="dropdown-menu">
                <li><a href="<?php echo Request::root().'/changes/profile' ?>" class=""><i class="fa fa-user"></i>Profile</a></li>
                <?php if(in_array(8,explode(',',Session::get('gid')))){?>
                  <li><a href="<?php echo Request::root().'/scm/supplier' ?>"><i class="fa fa-lock"></i>Supplier</a></li>
                <?php } ?>
                <?php if(in_array(1,explode(',',Session::get('gid')))){?>
                  <li><a target="_blank" href="<?php echo Request::root().'/dashboard_admin' ?>"><i class="fa fa-lock"></i>Admin Home</a></li>
                <?php } ?>
                <li><a href="<?php echo Request::root().'/user/logout' ?>"><i class="fa fa-lock"></i>Log Out</a></li>
              </ul>
            </li>

          </ul>
        </div>



      </div><!--/header-nav-->

    </nav><!--/top-navigation-->
  </div><!--/navbar-fixed-->
</header>


