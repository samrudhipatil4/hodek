<?php require app_path().'/views/header.php'; ?>

    <div class="main-wrapper">
        <div class="container">

            <div class="row two-col-row mg-bottom-0">
                <div class="col-sm-2">
                    <aside class="left-sidebar">
                        <div class="side-box">
                            <ul class="collection with-header">
                            <li class="collection-header">Profile</li>
                            <li class="collection-item"><a href="<?php echo Request::root(); ?>/changes/profile">Change Basic Information</a></li>
                            <li class="collection-item active"><a href="<?php echo Request::root(); ?>/changes/change-password">Change Password</a></li>

                        </ul>
                        </div>

                    </aside>
                </div><!--/s2-->
                <div class="col-sm-10">
                    <div class="content-wrapper">

                        <div class="form-wrapper" ng-controller="profileCtrl" ng-init="getprofileinfo(<?= $user_id;?>)">
                            <div class="row mg-bottom-0">
                                <form method="POST" action="<?php echo Request::root().'/changes/change_password' ?>" accept-charset="UTF-8" name="cPassForm" class="form-vertical" novalidate ng-submit="(submitted = true) && cPassForm.$invalid && $event.preventDefault()">

                               <!-- <form method="post" action="" role="form" class="col-sm-12 myform" ng-class="{'submitted': submitted}" name="cPassForm" novalidate ng-submit="(submitted = true) && cPassForm.$invalid && $event.preventDefault()" autocomplete="off">
                                    -->
                                    <div class="page-heading"><h2>Change Password</h2></div>
                                <div class="pd-20 pd-left-0">
                                 <!-- <div class="row mg-btm mg-top">
                                    <div class="input-field col-sm-6">
                                      <label for="user_name">Old Password</label>
                                      <input id="user_name" type="password" class="validate"  required name="oldpassword" ng-model="oldpassword">
                                       <span ng-cloak="" class="error-msg " ng-show="(cPassForm.oldpassword.$dirty || invalidSubmitAttempt) && cPassForm.oldpassword.$error.required"> This Field is Required.</span>

                                    </div>
                                  </div>-->
                                  <div class="row mg-btm">
                                    <div class="input-field col-sm-6">
                                      <label for="new_password">New Password</label>
                                         <input name="password" type="password" id="password" class="form-control input-sm" ng-model="password" required />
                                       <!--  <input id="new_password" type="password" class="form-control" required ng-model="password" name="password">-->
                                         <span ng-cloak="" class="error-msg " ng-show="(cPassForm.password.$dirty || invalidSubmitAttempt) && cPassForm.password.$error.required"> This Field is Required.</span>


                                    </div>
                                  </div>
                                  <div class="row mg-btm">
                                    <div class="input-field col-sm-6">
                                      <label for="confirm_password">Confirm Password</label>

                                <input id="confirm_password" type="password" class="form-control" required match="password" name="cpassword" ng-model="cpassword">
                                <span ng-cloak="" class="error-msg " ng-show="(cPassForm.cpassword.$dirty || invalidSubmitAttempt) && cPassForm.cpassword.$error.required"> This Field is Required.</span>
                                 <span ng-cloak="" class="error-msg "  ng-show="(cPassForm.cpassword.$dirty || invalidSubmitAttempt) && cPassForm.cpassword.$error.match"> Confirm Password does not matched!</span>

                                    </div>
                                  </div>

                                  <div class="row mg-bottom-0">
                                    <div class="col-sm-12 right-align">
                                      <button class="btn btn-animate flat blue pd-btn" type="submit" ng-click="changePassword(cPassForm)">Save</button>

                                    </div>
                                  </div>
                                </div>

                                </form>

                                    </div>



                            </div><!--/row-->
                        </div><!--/form-wrapper-->


                    </div><!--/content-wrapper-->
                </div><!--/s10-->
            </div><!--/row-->

        </div><!--/container-->
    </div><!--/main-wrapper-->
<?php require app_path().'/views/footer.php'; ?>