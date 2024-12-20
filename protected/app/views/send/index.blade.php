<?php
require app_path().'/views/templates/header.php';
          
?>

  <body>
   
<ul class="parsley-error-list"> </ul>


    <div class="login-container" data-ng-controller="ForgetpassCtrl">
        <div class="login-header">
           <a href="#"><img ng-src="<?php Request::root();?>uploads/logos/<%logo%>" alt="CM Logo"></a> 
        </div><!--/logo-wrapper-->

        @if(Session::has('message'))
        {{ Session::get('message') }}
      @endif
    <ul class="parsley-error-list">
      @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>   
        
        <div class="login-body">
          <div class="login-form">
              
            <div class="row">
              
             <form method="POST" action="<?php echo Request::root().'/user/request' ?>" accept-charset="UTF-8" class="form-vertical box " id="fr" name="user_form" novalidate ng-submit="(submitted = true) && user_form.$invalid && $event.preventDefault()">
             <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
             
                <div class="row">       
                  <div class="input-field col-sm-12">
                     <label>Enter Your Email Address</label>
                   <input class="form-control" name="credit_email" type="email" ng-model="credit_email" required="">
                   <span class="error-msg" ng-show="(user_form.credit_email.$dirty || invalidSubmitAttempt) && user_form.credit_email.$error.required">Email is required</span>
                   <span class="error-msg" ng-show="(user_form.credit_email.$dirty || invalidSubmitAttempt) && user_form.credit_email.$error.email">Invalid Email</span>
                  </div>
                </div>
                               
                <div class="row">
                  <div class="col-sm-6">
                    <button type="submit" class="btn btn-large btn-animate flat btn-grn" ng-click="passwordRequest(user_form);"> Submit </button>
                  </div>
                   <div class="col-sm-6">
                    <a href="<?php echo Request::root().'/user/back' ?>" class="btn btn-large btn-animate flat btn-grn">Cancel </a>
                    
                  </div>
                </div>                
              </form>
            </div>
        
          </div><!--/login-form-->
        </div><!--/login-wrapper-->
    <div class="login-footer">
          <p>For Further details</p>
          <p><span>Call us on: <a href="tel:+91 <%ph%>">+91 <%ph%></a></span>or<span>Email us: <a href="mailto:<%email%>"><%email%></a></span></p>
        </div><!--/login-footer-->
    </div><!--/login-container-->



    <!-- Footer -->
 <?php
 require app_path().'/views/templates/footer.php';
//include('templates/footer.php');
?>