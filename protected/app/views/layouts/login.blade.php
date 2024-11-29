<!DOCTYPE html>
<html lang="en" ng-app="myLogin">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

     <title>CM Login Page</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link href="<?php echo Request::root(); ?>/protected/public/css/login-style.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo Request::root(); ?>/sximo/css/animate.css">
    <link href="<?php echo Request::root(); ?>/protected/public/css/prism.min.css" rel="stylesheet">
    <script type="text/javascript" src="<?php echo Request::root(); ?>/protected/public/js/prism.min.js"></script>
    <link href="<?php echo Request::root(); ?>/protected/public/css/font-awesome.min.css" rel="stylesheet">
    


    <link href="<?php echo Request::root(); ?>/protected/public/css/custom.css" rel="stylesheet">
    <link href="<?php echo Request::root(); ?>/protected/public/js/simply-toast.min.css" rel="stylesheet">
   

    <!-- Bootstrap Core CSS -->
        <link media="all" type="text/css" rel="stylesheet" href="sximo/css/icons.min.css"><!-- Use for error message icon -->
        <script src="<?php echo Request::root(); ?>/sximo/js/plugins/jquery.min.js"></script>
        <script src="<?php echo Request::root(); ?>/sximo/js/plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Custom CSS -->
   

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
<!--<link rel="stylesheet" href = "http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">-->
<!--<script src= "http://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js"></script>-->

<script src= "<?php echo Request::root(); ?>/protected/public/jquery.form.js"></script>

<script src= "<?php echo Request::root(); ?>/protected/public/angular.min.js"></script>
<script src= "<?php echo Request::root(); ?>/protected/public/js/app.js"></script>
<script src= "<?php echo Request::root(); ?>/sximo/js/plugins/parsley.js"></script>

<script type="text/javascript" src="<?php echo Request::root(); ?>/protected/public/js/custom.js"></script>
    


 {{ $content }}

  <footer class="footer">
      <div class="footer-container">
        <div class="container">
          <div><a href="http://www.probitytech.com/" target="_blank"><img src="<?php echo Request::root(); ?>/protected/public/images/login/probity_logo.png" alt="Probity technologies"></a><span class="copyright">Powered By Probity Technologies 2015</span></div>
        </div>
      </div>
    </footer>
  <input type="hidden" id="pageurl" name="pageurl" value="<?php echo Request::root(); ?>/">
<script>

var App = angular.module('myLogin',[]);//,'ui.select2'
var appurl = $('#pageurl').val();
  

   App.config(['$interpolateProvider', function ($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
}]);

   

    App.controller('ResetpassCtrl', ['$scope', '$http','$location','$window',
    function($scope,$http,$location,$window) {

//==================================== Reset Form validation =========================================
    $scope.resetpassword = function(user_form) {

        if(user_form.$invalid) {
           
            $scope.invalidSubmitAttempt = true;
            return;
        }else{
                    return true;
                }
    }

             $scope.getlogo = function(){

                    $http
                    .get(appurl + 'user/logo')
                    .success(function(data, status, headers, config) {
                      
                         $scope.logo1=data[0].logo_image;
                         
                    });

                     $http
                    .get(appurl + 'user/login_pgdt')
                    .success(function(data, status, headers, config) {
                      
                         $scope.ph=data[0].phone_number;
                         $scope.email=data[0].email_id;
                         // alert(JSON.stringify($scope.logo));
                    });
          };

           $scope.getlogo();
   
}])

</script>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
   <!-- <script src="public/js/jquery.min.js"></script> -->
    <!-- Include all compiled plugins (below), or include individual files as needed -->

  </body>
</html>