<!DOCTYPE html>
<html lang="en" ng-app="myApp1">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>Essem Srinisons Change Management</title>

  <!-- Bootstrap -->


                                          <!-- kendo multi select css -->
    <link rel="stylesheet" href="<?php echo Request::root(); ?>/protected/public/css/kendo.common.min.css" />
    <link  rel="stylesheet" href="<?php echo Request::root(); ?>/protected/public/css/kendo.rtl.min.css" />
    <link  rel="stylesheet" href="<?php echo Request::root(); ?>/protected/public/css/kendo.default.min.css" />
    <link  rel="stylesheet" href="<?php echo Request::root(); ?>/protected/public/css/kendo.dataviz.min.css" />
    <link  rel="stylesheet" href="<?php echo Request::root(); ?>/protected/public/css/kendo.dataviz.default.min.css" />
    <link rel="stylesheet" href="<?php echo Request::root(); ?>/protected/public/css/kendo.mobile.all.min.css" />







  <link rel="stylesheet" type="text/css" href="<?php echo Request::root(); ?>/protected/public/css/bootstrap.min.css">

  <link rel="stylesheet" href="<?php echo Request::root(); ?>/protected/public/css/datepicker3.min.css" />

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
            <li class="dropdown profile">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-file-text"></i><span>Reports</span><span class="caret"></span>
              </a>
              <ul class="dropdown-menu">
                <li   <?php if ($PAGE_NAME=='advance-search'){?>  class="active" <?php }?>>
              <a class="" href="<?php echo Request::root().'/advance-search' ?>"><i class="fa fa-search"></i> Summary Sheet</a>
            </li>
            <li   <?php if ($PAGE_NAME=='tracking_sheet'){?>  class="active" <?php }?>>
              <a class="" href="<?php echo Request::root().'/tracking_sheet' ?>"><i class="fa fa-file-text"></i> TrackingSheet</a>
            </li>

            <?php  $group = Session::get('gid');
                  $g_id =explode(',', $group);
                 foreach ($g_id as $key) {
                
                  if($key == 12 || $user_id==1){ ?>
                   
                 
            <li   <?php if ($PAGE_NAME=='pending_task'){?>  class="active" <?php }?>>
              <a class="" href="<?php echo Request::root().'/pending_task' ?>"><i class="fa fa-file-text"></i> PendingTask</a>
            </li> <?php  }
                 }
            ?>
            <li   <?php if ($PAGE_NAME=='reports'){?>  class="active" <?php }?>>
              <a class="" href="<?php echo Request::root().'/reports' ?>"><i class="fa fa-file-text"></i> Graphical Reports</a>
            </li>
              <li   <?php if ($PAGE_NAME=='reports'){?>  class="active" <?php }?>>
              <a class="" href="<?php echo Request::root().'/userwise_pending_tasks' ?>"><i class="fa fa-file-text"></i>Userwise Pending Task Report</a>
            </li>
            <li   <?php if ($PAGE_NAME=='reports'){?>  class="active" <?php }?>>
              <a class="" href="<?php echo Request::root().'/changeRequestReport' ?>"><i class="fa fa-file-text"></i>Details Of Change Request Report</a>
            </li>  
              </ul>
            </li>
              <?php if ($user_id==1 || $user_id == 114){?>
            <li class="dropdown profile">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-file-text"></i><span>MIS Reports</span><span class="caret"></span>
              </a>
              <ul class="dropdown-menu">
                <li   <?php if ($PAGE_NAME=='openCRPerCtypeStakeholder'){?>  class="active" <?php }?>>
                <a class="" href="<?php echo Request::root().'/openCRPerCtypeStakeholder' ?>"><i class="fa fa-search"></i>No. of open  change requests per stakeholder per change type</a>
                </li>

                <li   <?php if ($PAGE_NAME=='totalNoOfCRInPercentage'){?>  class="active" <?php }?>>
                <a class="" href="<?php echo Request::root().'/totalNoOfCRInPercentage' ?>"><i class="fa fa-search"></i>% of open & closed  change requests</a>
                </li>

                <li   <?php if ($PAGE_NAME=='totalNoOfCRPerCustPerPurpose'){?>  class="active" <?php }?>>
                <a class="" href="<?php echo Request::root().'/totalNoOfCRPerCustPerPurpose' ?>"><i class="fa fa-search"></i>No. of change requests raised per purpose per customer</a>
                </li>

                <li   <?php if ($PAGE_NAME=='PendingCRFormTargetDate'){?>  class="active" <?php }?>>
                <a class="" href="<?php echo Request::root().'/PendingCRFormTargetDate' ?>"><i class="fa fa-search"></i>Change requests  pending with department after target date</a>
                </li>

              </ul>
            </li>
            <?php } ?>
           
           <?php  $group = Session::get('gid');
                  $g_id =explode(',', $group);
                 foreach ($g_id as $key) {
                
                   ?>
            <?php if ($user_id==1 || $key == 14){?>
            <li  <?php if ($PAGE_NAME=='modifyChangeRequest'){?>  class="active" <?php }?>>
              <!--<a class="" href="<?php //echo Request::root().'/scm' ?>"><i class="fa fa-cogs"></i> SCM</a>-->
              <a class="" href="<?php echo Request::root().'/modifyChangeRequest' ?>"><i class="fa fa-cogs" ></i> Modify Change Request</a>
            </li>
            <?php } }?>
            <li   <?php if ($PAGE_NAME=='help'){?>  class="active" <?php }?>>
              <a class="" href="<?php echo Request::root().'/help' ?>"><i class="fa fa-th-large"></i> Help</a>
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


