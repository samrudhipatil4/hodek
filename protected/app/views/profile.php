<?php require app_path().'/views/header.php'; ?>

<div class="main-wrapper">
    <div class="container">

        <div class="row two-col-row mg-bottom-0">
            <div class="col-sm-2">
                <aside class="left-sidebar">
                    <div class="side-box">
                        <ul class="collection with-header">
                            <li class="collection-header">Profile</li>
                            <li class="collection-item active"><a class="" href="<?php echo Request::root(); ?>/changes/profile">Change Basic Information</a></li>
                            <li class="collection-item"><a href="<?php echo Request::root(); ?>/changes/change-password">Change Password</a></li>

                        </ul>
                    </div>

                </aside>
            </div><!--/s2-->
            <div class="col-sm-10">
                <div class="content-wrapper">

                    <div class="form-wrapper" ng-controller="profileCtrl" ng-init="getprofileinfo(<?= $user_id;?>)">
                        <div class="row mg-bottom-0">
                            <form class="col-sm-12" id="profileForm" method="post" role="form" class="col-sm-12 myform" ng-class="{'submitted': submitted}" name="profileForm" novalidate ng-submit="(submitted = true) && profileForm.$invalid && $event.preventDefault()" autocomplete="off">

                            <div class="page-heading">
                                    <h2>Basic Information</h2></div>
                                <div class="pd-20 pd-left-0">
                                    <div class="row mg-btm">
                                        <div class="input-field col-sm-6">
                                            <label for="last_name">First Name</label>
                                            <input id="first_name" type="text" class="validate" name="first_name" ng-model="requestinfos.first_name" required>
                                            <span ng-cloak="" class="error-msg " ng-show="(Form1.sub_dep_id.$dirty || invalidSubmitAttempt) && Form1.sub_dep_id.$error.required"> This Field is Required.</span>

                                        </div>
                                    </div>
                                    <div class="row mg-btm">
                                        <div class="input-field col-sm-6">
                                            <label for="last_name">Last Name</label>
                                            <input id="last_name" type="text" class="form-control"  name="last_name" ng-model="requestinfos.last_name" >
                                            <span ng-cloak="" class="error-msg " ng-show="(Form1.sub_dep_id.$dirty || invalidSubmitAttempt) && Form1.sub_dep_id.$error.required"> This Field is Required.</span>

                                        </div>
                                    </div>
                                    <div class="row mg-btm">
                                        <div class="input-field col-sm-6">
                                            <label for="email">Email ID</label>
                                            <input id="email" type="text" class="form-control" name="email" ng-model="requestinfos.email" readonly>
                                        </div>
                                    </div>

                                    <div class="row mg-btm">
                                        <div class="input-field col-sm-6">
                                            <label for="dept">Department</label>
                                            <input id="dept" type="text" class="form-control" name="d_name" ng-model="requestinfos.d_name" readonly>
                                        </div>
                                    </div>
                                    <div class="row mg-btm">
                                        <div class="input-field col-sm-6">
                                            <label for="sub_dept">Sub Department</label>
                                            <input id="sub_dept" type="text" class="form-control" name="sub_dep_name" ng-model="requestinfos.sub_dep_name" readonly>
                                        </div>
                                    </div>


                                  <!--  <div class="row mg-btm">
                                        <div class="col-sm-6">
                                            <div class="file-field input-field">
                                                <div class="btn">
                                                    <span>Profile Image</span>
                                                    <input type="file" name="image" id="image" my-upload>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="file-field input-field">
                                                <img ng-src="<?php //echo Request::root(); ?>/uploads/users/<%requestinfos.avatar%>" height="100px" width="100px">
                                                <input type="hidden" name="oldimage" ng-model="oldimage" ng-init="oldimage='requestinfos.avatar'">
                                            </div>
                                        </div>
                                    </div>-->


                                    <div class="row mg-bottom-0">
                                        <div class="col-sm-12 right-align">
                                            <button class="btn btn-animate flat blue pd-btn" type="submit" name="action" ng-click="saveProfile(profileForm)">Update</button>

                                        </div>
                                    </div>
                                </div>


                        </form>
                    </div><!--/row-->
                </div><!--/form-wrapper-->


            </div><!--/content-wrapper-->
        </div><!--/s10-->
    </div><!--/row-->

</div><!--/container-->
</div><!--/main-wrapper-->
<?php require app_path().'/views/footer.php'; ?>