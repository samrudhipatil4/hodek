<?php

require app_path().'/views/templates/header.php';

?>
<?php echo
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header('Content-Type: text/html');?>
<body>
 <ul class="parsley-error-list"> </ul>


    <div class="login-container" ng-controller="loginCtrl">
        <div class="login-header">
         <!-- <a href="#"><img src="protected/public/images/login/logo.jpg" alt="CM Logo"></a> -->
          <a href="#"><img src="<?php Request::root();?>uploads/logos/{{$logo_image}} "  alt="CM Logo"></a> 
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
              
             <form method="POST" action="<?php echo Request::root().'/user/signin' ?>" accept-charset="UTF-8" name="user_form" class="form-vertical" novalidate ng-submit="(submitted = true) && user_form.$invalid && $event.preventDefault()">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
          
            
             
               <div class="row">       
                  <div class="input-field col-sm-12">
                    <label for="username">Enter Your User ID</label>
                    <input type="text" id="email" ng-model="email" name="email" class="form-control" required  ng-class="{ 'has-error': (form.email.$dirty || submitted) && form.email.$error.required }" >
                  
                    <span class="error-msg" ng-show="(user_form.email.$dirty || invalidSubmitAttempt) && user_form.email.$error.required">Email is required</span>
                    <span class="error-msg" ng-show="(user_form.email.$dirty || invalidSubmitAttempt) && user_form.email.$error.email">Invalid Email</span>


                  </div>
                </div>
                <div class="row">
                  <div class="input-field col-sm-12">
                     <label for="username">Enter Your Password</label>
                     <input id="password" type="password" name="password" ng-model="password" class="form-control" required  ng-class="{ 'has-error': (form.password.$dirty || submitted) && form.password.$error.required }">
                      <span class="error-msg " ng-show="(user_form.password.$dirty || invalidSubmitAttempt) && user_form.password.$error.required"> Password is required.</span>


                  
                   
                  </div>
                </div>
                 <div class="row">
                     <div class=" col-sm-12">
                     <a href="<?php echo Request::root().'/send' ?>" class="pull-right forgot-passwd">Forgot?</a>
                         </div>
                 </div>
                <div class="row">
                  <div class="col-sm-12">
                    <button type="submit" class="btn btn-large btn-animate flat btn-grn" ng-click="userLogin(user_form);">Log In</button>
                 
                  </div>
                </div>                
              </form>
            </div>
        
          </div><!--/login-form-->
        </div><!--/login-wrapper-->
 <div class="login-footer">
          <p>For Further details</p>
          <p><span>Call us on: <a href="tel:+91 {{ $phone_number }}">+91 {{ $phone_number }}</a></span></p>
            <p><span>Email us: <a href="mailto:{{ $email_id }}">{{ $email_id }}</a></span></p>
        </div><!--/login-footer-->


    </div><!--/login-container-->



    <!-- Footer -->
 <?php
 require app_path().'/views/templates/footer.php';

//include('templates/footer.php');
?>

