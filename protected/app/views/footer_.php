<footer class="page-footer">
      <div class="footer-copyright">
        
          <div class="container">        
              <div class="row mg-bottom-0">
                <div class="col s12">
                  <a href="http://www.probitytech.com/" target="_blank"><img src="<?php echo Request::root(); ?>/protected/public/images/login/probity_logo.png" alt="Probity technologies"></a>
                  <span class="copyright pull-right">Powered By Probity Technologies © 2016</span>
                </div>
              </div>            
          </div>
        
      </div>
  </footer>
  <input type="hidden" id="user_id" value="<?php echo Session::get('uid'); ?>" ng-model="user_id" name="user_id" ng-init="user_id='<?php echo Session::get('uid'); ?>'"> 
  <input type="hidden" id="pageurl" name="pageurl" value="<?php echo Request::root(); ?>/">


    <!-- jQuery (necessary JavaScript plugins) -->

    <script type="text/javascript" src="<?php echo Request::root(); ?>/protected/public/js/lodash.min.js"></script>

    <script type="text/javascript" src="<?php echo Request::root(); ?>/protected/public/js/1.4.6/angular.min.js"></script>
    <script type="text/javascript" src="<?php echo Request::root(); ?>/protected/public/js/angular-animate.js"></script>
    <script type="text/javascript" src="<?php echo Request::root(); ?>/protected/public/js/ui-bootstrap-tpls.min.js"></script>

    <script type="text/javascript" src="<?php echo Request::root(); ?>/protected/public/js/simply-toast.min.js"></script>
    <script type="text/javascript" src="<?php echo Request::root(); ?>/protected/public/js/jquery.form.min.js"></script>
     
    

    <!-- pie chart -->
    <script type="text/javascript" src="<?php echo Request::root(); ?>/protected/public/js/Chart.min.js"></script>
    <script type="text/javascript" src="<?php echo Request::root(); ?>/protected/public/js/angular-chart.min.js"></script>
    <link rel="stylesheet" href="<?php echo Request::root(); ?>/protected/public/css/angular-chart.min.css">
    
    <link rel="stylesheet" href="<?php echo Request::root(); ?>/protected/public/css/perfect-scrollbar.min.css">
    <script type="text/javascript" src="<?php echo Request::root(); ?>/protected/public/js/perfect-scrollbar.min.js"></script>

    <script type="text/javascript" src="<?php echo Request::root(); ?>/protected/public/js/ui-bootstrap-tpls-0.14.3.js"></script>
    <!-- Include App and Controller files-->
    <script type="text/javascript" src="<?php echo Request::root(); ?>/protected/public/js/custom.js"></script>
    <script type="text/javascript" src="<?php echo Request::root(); ?>/protected/public/js/app.js"></script>
    <script type="text/javascript" src="<?php echo Request::root(); ?>/protected/public/js/controllers.js"></script>

    <!-- multi select dropdown -->



<script type="text/javascript" src="<?php echo Request::root(); ?>/protected/public/js/underscore-min.js"></script>
    <script type="text/javascript" src="<?php echo Request::root(); ?>/protected/public/js/bootstrap-dropdown.js"></script>
   


    <script type="text/javascript" src="<?php echo Request::root(); ?>/protected/public/js/select2.min.js"></script>
   

<!--
<script type="text/javascript">
    $(document).ready(function() {
        // show the alert
        setTimeout(function() {
            $(".alert").alert('close');
        }, 2000);
    });
</script>-->


<!--<script>

  $(".js-example-placeholder-multiple").select2({
   // placeholder: "Select a state"
      allowClear: true
  });
  $(".js-example-placeholder-single").select2({
   // placeholder: "Select a state"
     // allowClear: true
  });
</script>-->

