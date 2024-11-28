<!DOCTYPE html>
<html lang="en" ng-app="myApp">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title><?php $companyname = BaseController::getCompanyName();
                echo $companyname;
              ?></title>

  <!-- Bootstrap -->
                                          <!-- kendo multi select css -->
    <link rel="stylesheet" href="<?php echo Request::root(); ?>/protected/public/css/kendo.common.min.css" />
    <link  rel="stylesheet" href="<?php echo Request::root(); ?>/protected/public/css/kendo.rtl.min.css" />
    <link  rel="stylesheet" href="<?php echo Request::root(); ?>/protected/public/css/kendo.default.min.css" />
    <link  rel="stylesheet" href="<?php echo Request::root(); ?>/protected/public/css/kendo.dataviz.min.css" />
    <link  rel="stylesheet" href="<?php echo Request::root(); ?>/protected/public/css/kendo.dataviz.default.min.css" />
    <link rel="stylesheet" href="<?php echo Request::root(); ?>/protected/public/css/kendo.mobile.all.min.css" />
  <link rel="stylesheet" type="text/css" href="<?php echo Request::root(); ?>/protected/public/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo Request::root(); ?>/protected/public/css/bootstrap.css">
  <link rel="stylesheet" href="<?php echo Request::root(); ?>/protected/public/css/datepicker3.min.css" />
  <link rel="stylesheet" href="<?php echo Request::root(); ?>/protected/public/css/bootstrap-dropdown.css">
  <link href="<?php echo Request::root(); ?>/protected/public/css/font-awesome.min.css" rel="stylesheet">
  <link href="<?php echo Request::root(); ?>/protected/public/css/select2.min.css" rel="stylesheet" />

  <link href="<?php echo Request::root(); ?>/protected/public/css/custom.css" rel="stylesheet">
  <link href="<?php echo Request::root(); ?>/protected/public/js/simply-toast.min.css" rel="stylesheet">

  <link href="<?php echo Request::root(); ?>/sximo/css/animate.css" rel="stylesheet">
  
  	<!-- <link media="all" type="text/css" rel="stylesheet" href="http://localhost/hodek/sximo/js/plugins/jasny-bootstrap/css/jasny-bootstrap.min.css">
		<link media="all" type="text/css" rel="stylesheet" href="http://localhost/hodek/sximo/js/plugins/bootstrap.summernote/summernote.css">
		<link media="all" type="text/css" rel="stylesheet" href="http://localhost/hodek/sximo/js/plugins/datepicker/css/bootstrap-datetimepicker.min.css">
		<link media="all" type="text/css" rel="stylesheet" href="http://localhost/hodek/sximo/js/plugins/bootstrap.datetimepicker/css/bootstrap-datetimepicker.min.css">
		<link media="all" type="text/css" rel="stylesheet" href="http://localhost/hodek/sximo/js/plugins/select2/select2.css">
		<link media="all" type="text/css" rel="stylesheet" href="http://localhost/hodek/sximo/js/plugins/iCheck/skins/square/green.css">
		<link media="all" type="text/css" rel="stylesheet" href="http://localhost/hodek/sximo/js/plugins/fancybox/jquery.fancybox.css">
		<link media="all" type="text/css" rel="stylesheet" href="http://localhost/hodek/sximo/css/sximo.css">
		<link media="all" type="text/css" rel="stylesheet" href="http://localhost/hodek/sximo/css/icons.min.css">
		<link media="all" type="text/css" rel="stylesheet" href="http://localhost/hodek/sximo/js/plugins/toastr/toastr.css">
		 -->

  <script src="<?php echo Request::root(); ?>/protected/public/js/underscore-min.js"></script>
  <!-- <script src="http://localhost/hodek/sximo/js/plugins/select2/select2.min.js"></script> -->
    <script src="<?php echo Request::root(); ?>/sximo/js/plugins/jquery.min.js"></script>
		<script src="<?php echo Request::root(); ?>/sximo/js/plugins/jquery.cookie.js"></script>
		<script src="<?php echo Request::root(); ?>/sximo/js/plugins/jquery-ui.min.js"></script>
		<script src="<?php echo Request::root(); ?>/sximo/js/plugins/iCheck/icheck.min.js"></script>
		<script src="<?php echo Request::root(); ?>/sximo/js/plugins/fancybox/jquery.fancybox.js"></script>
		<script src="<?php echo Request::root(); ?>/sximo/js/plugins/prettify.js"></script>
		<script src="<?php echo Request::root(); ?>/sximo/js/plugins/parsley.js"></script>
		<script src="<?php echo Request::root(); ?>/sximo/js/plugins/datepicker/js/bootstrap-datetimepicker.min.js"></script>
		<script src="<?php echo Request::root(); ?>/sximo/js/plugins/switch.min.js"></script>
		<script src="<?php echo Request::root(); ?>/sximo/js/plugins/bootstrap.datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
		<script src="<?php echo Request::root(); ?>/sximo/js/plugins/bootstrap/js/bootstrap.js"></script>
		<script src="<?php echo Request::root(); ?>/sximo/js/plugins/jasny-bootstrap/js/jasny-bootstrap.min.js"></script>
		<!-- <script src="http://localhost/hodek/sximo/js/sximo.js"></script> -->
		<script src="<?php echo Request::root(); ?>/sximo/js/plugins/jquery.jCombo.min.js"></script>
		<script src="<?php echo Request::root(); ?>/sximo/js/plugins/toastr/toastr.js"></script>
		<script src="<?php echo Request::root(); ?>/sximo/js/plugins/bootstrap.summernote/summernote.min.js"></script>
    <!-- <script src="http://localhost/hodek/protected/public/js/jquery.min.js"></script> -->
    <!-- <script src="http://localhost/hodek/protected/public/js/jquery.js"></script> -->

		<link media="all" type="text/css" rel="stylesheet" href="<?php echo Request::root(); ?>/sximo/js/plugins/markitup/skins/simple/style.css">
<link media="all" type="text/css" rel="stylesheet" href="<?php echo Request::root(); ?>/sximo/js/plugins/markitup/sets/default/style.css">
<script src="<?php echo Request::root(); ?>/sximo/js/plugins/markitup/jquery.markitup.js"></script>
<script src="<?php echo Request::root(); ?>/sximo/js/plugins/markitup/sets/default/set.js"></script>
</head>
<body ng-controller="RootCtrl">
<?php $name = Session::get('fid');?>
<?php $user_id = Session::get('uid');?>
<?php $user_type = Session::get('gid');?>


<header>
  <div class="container-fluid" >
    <nav class="navbar navbar-fixed">
      <div class="row">
        <div class="logo-wrapper col-sm-2">
       <?php $companyname = BaseController::getCompanyName();
                echo $companyname;
              ?>
        </div>
        <!--  <div class="logo-wrapper col-sm-2">
          <a href="<?php echo Request::root().'/dashboard' ?>" class="logo"><img ng-src="<?php echo Request::root(); ?>/uploads/Dashboardlogo/<%logo.logo_image%>" alt="Company Logo"></a>
        </div> --><!--logo-wrapper-->
        <?php $PAGE_NAME=Request::segment(1); ?>
        <div class="col-sm-8 menu">

          <ul id="nav" class="nav">
            <li   <?php if ($PAGE_NAME=='apqp_dashboard'){?>  class="active" <?php }?>>
              <a class="" href="<?php echo Request::root().'/apqp_dashboard' ?>"><i class="fa fa-th-large"></i> Dashboard</a>
            </li>
            <?php if ($user_id==1 ){ ?>
             <li   <?php if ($PAGE_NAME=='lesson_learned'){?>  class="active" <?php }?>>
              <a class="" href="<?php echo Request::root().'/lesson_learned' ?>"><i class="fa fa-th-large"></i> Add Lessons Learned</a>
            </li>
            <?php } ?>
             <?php if ($user_id==1 ){ ?>
             <li   <?php if ($PAGE_NAME=='uploadActivitydoc'){?>  class="active" <?php }?>>
              <a class="" href="<?php echo Request::root().'/uploadActivitydoc' ?>"><i class="fa fa-upload"></i> Upload Activity Document</a>
            </li>
            <?php } ?>
            <?php if ($user_id==1 ){ ?>
             <li   <?php if ($PAGE_NAME=='projectReview'){?>  class="active" <?php }?>>
              <a class="" href="<?php echo Request::root().'/projectReview' ?>"><i class="fa fa-book"></i> Project Review</a>
            </li>
            <?php } ?>
            <?php if ($user_id==1 ){ ?>
             <li   <?php if ($PAGE_NAME=='taskShift'){?>  class="active" <?php }?>>
              <a class="" href="<?php echo Request::root().'/apqptaskShift' ?>"><i class="fa fa-tasks"></i> Task Shift</a>
            </li>
            <?php } ?>
             <?php if ($user_id==1 ){ ?>
              <li class="dropdown profile">
               <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-file-text"></i><span>Enquiry</span><span class="caret"></span>
              </a>
               <ul class="dropdown-menu">
             <li   <?php if ($PAGE_NAME=='enquiry'){?>  class="active" <?php }?>>
              <a class="" href="<?php echo Request::root().'/enquiry' ?>"><i class="fa fa-tasks"></i> Add Enquiry</a>
            </li>
            <li   <?php if ($PAGE_NAME=='closeRFQ'){?>  class="active" <?php }?>>
              <a class="" href="<?php echo Request::root().'/closeRFQ' ?>"><i class="fa fa-tasks"></i> Close RFQ</a>
            </li>
             <li   <?php if ($PAGE_NAME=='CostCard'){?>  class="active" <?php }?>>
              <a class="" href="<?php echo Request::root().'/CostCard' ?>"><i class="fa fa-credit-card"></i>Add Cost Card</a>
            </li>
             <li   <?php if ($PAGE_NAME=='viewEnquiry'){?>  class="active" <?php }?>>
              <a class="" href="<?php echo Request::root().'/viewEnquiry' ?>"><i class="fa fa-credit-card"></i>View Enquiry</a>
            </li>
            </ul>
            </li>
            <li class="dropdown profile">
               <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-file-text"></i><span>PPAP</span><span class="caret"></span>
              </a>
               <ul class="dropdown-menu">
              <li   <?php if ($PAGE_NAME=='getDFEMA'){?>  class="active" <?php }?>>
              <a class="" href="<?php echo Request::root().'/getDFEMA' ?>"><i class="fa fa-search"></i>Add DFMEA</a>
            </li>
             <li   <?php if ($PAGE_NAME=='getPFEMA'){?>  class="active" <?php }?>>
              <a class="" href="<?php echo Request::root().'/getPFMEA' ?>"><i class="fa fa-search"></i>Add PFMEA</a>
            </li>
             <li   <?php if ($PAGE_NAME=='reportDFEMA'){?>  class="active" <?php }?>>
              <a class="" href="<?php echo Request::root().'/reportDFEMA' ?>"><i class="fa fa-search"></i>DFMEA Report</a>
            </li>
            <li   <?php if ($PAGE_NAME=='reportPFEMA'){?>  class="active" <?php }?>>
              <a class="" href="<?php echo Request::root().'/reportPFEMA' ?>"><i class="fa fa-search"></i>PFMEA Report</a>
            </li>
            </ul>
            </li>
            <?php } ?>
             <li class="dropdown profile">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-file-text"></i><span>Reports</span><span class="caret"></span>
              </a>
               <ul class="dropdown-menu">
                <li   <?php if ($PAGE_NAME=='ganttChart'){?>  class="active" <?php }?>>
              <a class="" href="<?php echo Request::root().'/ganttChart' ?>"><i class="fa fa-search"></i>Gantt Chart</a>
            </li>
             <li   <?php if ($PAGE_NAME=='ganttChartCommonAct'){?>  class="active" <?php }?>>
              <a class="" href="<?php echo Request::root().'/ganttChartCommonAct' ?>"><i class="fa fa-search"></i>Common Activity Gantt Chart</a>
            </li>
            <li   <?php if ($PAGE_NAME=='ganttChartMatAct'){?>  class="active" <?php }?>>
              <a class="" href="<?php echo Request::root().'/ganttChartMatAct' ?>"><i class="fa fa-search"></i>Material Activity Gantt Chart</a>
            </li>
             <li   <?php if ($PAGE_NAME=='project_dct_report'){?>  class="active" <?php }?>>
              <a class="" href="<?php echo Request::root().'/project_dct_report' ?>"><i class="fa fa-search"></i>Project Documentation Report</a>
            </li>
           <li   <?php if ($PAGE_NAME=='lesson_learned_report'){?>  class="active" <?php }?>>
              <a class="" href="<?php echo Request::root().'/lesson_learned_report' ?>"><i class="fa fa-search"></i>Project Lesson Learned Report</a>
            </li>
          <li   <?php if ($PAGE_NAME=='budgetvsactual_report'){?>  class="active" <?php }?>>
              <a class="" href="<?php echo Request::root().'/budgetvsactual_report' ?>"><i class="fa fa-search"></i>Budget Vs Actual Cost Report</a>
            </li>
                <li   <?php if ($PAGE_NAME=='projectReview_Report'){?>  class="active" <?php }?>>
              <a class="" href="<?php echo Request::root().'/projectReview_Report' ?>"><i class="fa fa-search"></i>Project Review Report</a>
            </li>
             <li   <?php if ($PAGE_NAME=='projectSummary_Report'){?>  class="active" <?php }?>>
              <a class="" href="<?php echo Request::root().'/projectSummary_Report' ?>"><i class="fa fa-search"></i>Project Summary Report</a>
            </li> 
             <li   <?php if ($PAGE_NAME=='projectSummary_PieChartReport'){?>  class="active" <?php }?>>
              <a class="" href="<?php echo Request::root().'/projectSummary_PieChartReport' ?>"><i class="fa fa-search"></i>Project Summary Pie Chart Report</a>
            </li> 

              </ul> 
            </li>
           <!-- <li class="dropdown profile">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-file-text"></i><span>Project</span><span class="caret"></span>
              </a>
              <ul class="dropdown-menu">
                <li   <?php if ($PAGE_NAME=='advance-search'){?>  class="active" <?php }?>>
              <a class="" href="<?php echo Request::root().'/advance-search' ?>"><i class="fa fa-plus"></i>   NEW PROJECT</a>
            </li>
            <li   <?php if ($PAGE_NAME=='tracking_sheet'){?>  class="active" <?php }?>>
              <a class="" href="<?php echo Request::root().'/tracking_sheet' ?>"><i class="fa fa-pencil-square-o"></i> EDIT PROJECT</a>
            </li>
           
              </ul>
            </li>-->

          


             




           
          </ul>
        </div>


        <div class="col-sm-2 menu">
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
                <?php if(in_array(1,explode(',',Session::get('gid'))) ) {?>
                  <li><a target="_blank" href="<?php echo Request::root().'/apqp_dashboard_admin' ?>"><i class="fa fa-lock"></i>Admin Home</a></li>
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


