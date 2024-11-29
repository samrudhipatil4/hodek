
<body>
   
<ul class="parsley-error-list"> </ul>


    <div class="login-container" data-ng-controller="ResetpassCtrl">
        <div class="login-header">
           <a href="#"><img src="<?php echo Request::root(); ?>/uploads/logos/<%logo1%>" alt="CM Logo"></a> 
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
             
             
             <form method="POST" action="<?php echo Request::root().'/user/doreset/'.$verCode ?>" accept-charset="UTF-8" class="form-vertical" name="user_form" novalidate ng-submit="(submitted = true) && user_form.$invalid && $event.preventDefault()">
              <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
             <!-- <input type="hidden" name="_token" value="<?php //echo csrf_token(); ?>""v5UapjvhPJr1Ep6UMDXkAajH4rTBo274kFE1HDr3">-->
            
               <!-- <form class="12" action="check/user" method="POST"> -->
              

                <div class="row">       
                  <div class="input-field col-sm-12">
                    <label for="username">New Password</label>
                  <input class="validate form-control" name="password" ng-model="password" type="password" required="">
                   <span class="error-msg " ng-show="(user_form.password.$dirty || invalidSubmitAttempt) && user_form.password.$error.required"> Password is required.</span>
                  </div>
                </div>
                <div class="row">
                  <div class="input-field col-sm-12">
                    <label for="password">Re-type Password</label>
                    <input class="validate form-control" name="password_confirmation" ng-model="password_confirmation" type="password" required="">
                    <span class="error-msg " ng-show="(user_form.password_confirmation.$dirty || invalidSubmitAttempt) && user_form.password_confirmation.$error.required"> Password is required.</span>
                  
                    
                                       
                  </div>
                </div>                
                <div class="row">
                  <div class="col-sm-12">
                   
                    <button type="submit" class="btn btn-animate flat btn-grn btn-large" ng-click="resetpassword(user_form);">Reset My Password</button>
                  </div>
                </div>                
              </form>
            </div>
        
          </div><!--/login-form-->
        </div><!--/login-wrapper-->
 <div class="login-footer">
          <p>For Further details</p>
          <p><span>Call us on: <a href="tel:+91 <%ph%>">+91 <%ph%></a></span></p>
           <p>  <span>Email us: <a href="<%email%>"><%email%></a></span></p>
        </div><!--/login-footer-->


    </div><!--/login-container-->
