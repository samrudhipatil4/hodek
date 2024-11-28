 <footer class="footer">
      <div class="footer-container">
        <div class="container">
          <div><a href="http://www.probitytech.com/" target="_blank"><img src="protected/public/images/login/probity_logo.png" alt="Probity technologies"></a><span class="copyright">Powered By Probity Technologies © 2016</span></div>
        </div>
      </div>
    </footer>
  <input type="hidden" id="pageurl" name="pageurl" value="<?php echo Request::root(); ?>/">
<script>

var App = angular.module('myLogin',[]);//,'ui.select2'
var appurl = $('#pageurl').val();
   // angular.module('myLogin',[])

   App.config(['$interpolateProvider', function ($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
}]);

   App.controller('loginCtrl', ['$scope', '$http','$location','$window',
        function($scope,$http,$location,$window) {

//==================================== Login =========================================
            $scope.userLogin = function(user_form) {

                if(user_form.$invalid) {
                    $scope.invalidSubmitAttempt = true;
                    return;
                }else{

                    return true;
                }
            }


        }]);

    App.controller('ForgetpassCtrl', ['$scope', '$http','$location','$window',
        function($scope,$http,$location,$window) {

//==================================== forget password =========================================
        
    $scope.passwordRequest = function(user_form) {

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
                      
                         $scope.logo=data[0].logo_image;
                         // alert(JSON.stringify($scope.logo));
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


        }]);

</script>



    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
   <!-- <script src="public/js/jquery.min.js"></script> -->
    <!-- Include all compiled plugins (below), or include individual files as needed -->

  </body>
</html>