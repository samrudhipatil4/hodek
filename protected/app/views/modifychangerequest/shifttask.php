<?php require app_path().'/views/header.php'; ?>


  <div class="main-wrapper">
    <div class="container-fluid">

              <div class="row two-col-row mg-bottom-0">
                <div class="col-sm-2">
                 	<!-- Sidebar Comes here! -->
					
					<?php require app_path().'/views/sidebar.php'; ?>
					
					<!-- sidebar ends here -->
					
					 </div><!--/s2-->
                <div class="col-sm-10">

                  <div class="row">
                      <div class="col-sm-12">
                        <div class="page-heading">
                          <h1>Modify Change Request</h1>
                        </div><!--/page-heading-->    
                      </div>
                    </div>

                  <div class="content-wrapper">                    
                    <div class="row">
                        <div class="col-sm-12">
                        <div class="page-heading mg-btm">
                          <h1>New Change Request Form</h1>
                        </div><!--/page-heading-->    
                      </div>
                    </div>


                      <div class="form-wrapper select-height" ng-controller="shiftTaskCtrl">
                          <div class="row">
                              <form method="post" role="form" class="col-sm-12 myform" id="shiftTaskModify" ng-class="{'submitted': submitted}" name="shiftTaskModify" novalidate ng-submit="(submitted = true) && requestForm.$invalid && $event.preventDefault()"  autocomplete="off" action="<?php echo Request::root().'/changeRequestModifyDetails' ?>">

                              <div class="row mg-btm">

                                  <div class="input-field col-sm-4">


                                      <label for="initiator_name">Select Process</label>


                                      <select class="form-control" select2=""  ng-model="request.m_code" name="m_code" id="m_code" ng-change="getRequestID(request.m_code)" required>
                                            <option  value=""></option>
                                             <option value="1"> CM request  for Dept. HOD Approval</option>
                                          <option value="2">CM  for Updation of Initial Information Sheet</option>
                                          <option value="3"> Risk assessment by CFT member</option>
                                          <option value="4">Risk assessment Approval from HOD</option>
                                         
                                          <option value="5">Overall Risk Assessment</option>
                                           <option value="6"> Steering Committee Member Approval</option>
                                           
                                          <option value="7">Customer communication evidence upload</option>
                                          <option value="8">Customer evidance upload approve</option>
                                          <option value="9"> Monitor activity completion status.</option>
                                          <option value="10">Document Verification</option>
                                            <option value="11">PTR Document Upload</option>
                                          <option value="12">Horizontal Deployment</option>
                                          <option value="13">Before After Status</option>
                                           <option value="14">Final Approval Closer</option>
                                      </select>
                                    <span ng-cloak class="error-msg " ng-show="(shiftTaskModify.m_code.$dirty || invalidSubmitAttempt) && shiftTaskModify.m_code.$error.required"> This field is required.</span>


                                  </div>
                                  <div class="input-field col-sm-3">
                                      <label for="initiator_name">Select Request Id</label>
                                      <select class="form-control" select2=""  ng-model="request.r_id" name="r_id"  id="r_id" required ng-change="getUserName()">
                                          <option  value=""></option>

                                          <option ng-repeat="r in getChangeRequest" value="<%r.r_id%>"><%r.request_id%></option>

                                      </select>
                                      <span ng-cloak class="error-msg " ng-show="(shiftTaskModify.r_id.$dirty || invalidSubmitAttempt) && shiftTaskModify.r_id.$error.required"> This field is required.</span>

                                  </div>

                                    <div class="input-field col-sm-4" ng-if="department">
                                      <label for="Change-Stage">Function</label>
                                      <select class="form-control" select2="" name="d_id" id="d_id" ng-model="request.d_id" ng-change="getUserAccDept()" required >
                                          <option  value=""></option>
                                          <option ng-repeat="department in departments" value="<%department.d_id%>"><%department.d_name%></option>

                                      </select>


                                      <span ng-cloak class="error-msg " ng-show="(changerequestmodifyForm.d_id.$dirty || invalidSubmitAttempt) && changerequestmodifyForm.d_id.$error.required"> This field is required.</span>

                                  </div>
                                  </div>
                                  <div class="row">
                                      <div class="input-field col-sm-4" ng-if="subdepartment">
                                      <label for="Change-Stage">Sub Function</label>
                                      <select class="form-control" select2="" name="sub_dep" id="sub_dep" ng-model="request.sub_dep" ng-change="getSteerCommUser()" required >
                                          <option  value=""></option>
                                          <option ng-repeat="dept in subdepartments" value="<%dept.sub_dep_id%>"><%dept.sub_dep_name%></option>

                                      </select>


                                      <span ng-cloak class="error-msg " ng-show="(changerequestmodifyForm.d_id.$dirty || invalidSubmitAttempt) && changerequestmodifyForm.d_id.$error.required"> This field is required.</span>

                                  </div>
                                     <div class="input-field col-sm-4" ng-if="dep">
                                      <label for="Change-Stage">User</label>
                                       <input type="text" name="name" id="name"  value="<%user.first_name%> <%user.last_name%>" ng-readonly="true"   required> 
                                        <input type="hidden" name="existUser" id="existUser"  value="<%user.id%>" ng-readonly="true"   > 

                                      <span ng-cloak class="error-msg " ng-show="(shiftTaskModify.name.$dirty || invalidSubmitAttempt) && shiftTaskModify.name.$error.required"> This field is required.</span>

                                  </div>

                                  <div class="input-field col-sm-4" ng-if="dep">
                                      <label for="Change-Stage">Change User</label>
                                      <select class="form-control" select2="" name="user" id="user" ng-model="request.user" required >
                                          <option  value=""></option>
                                          <option ng-repeat="user in allUser" value="<%user.id%>"> <%user.first_name%> <%user.last_name%> <%user.username%></option>

                                      </select>


                                      <span ng-cloak class="error-msg " ng-show="(shiftTaskModify.user.$dirty || invalidSubmitAttempt) && shiftTaskModify.user.$error.required"> This field is required.</span>

                                  </div>



                                  </div>


                                  <div class="row mg-btm mg-btm">

                                  <div class="row"  style="margin-top: 50px;">
                                      <div class="col-sm-12 ">
                                          <button class="btn btn-animate flat blue pd-btn" ng-disabled="isDisabled" type="button" id="action" name="action" ng-click="shiftUser(shiftTaskModify)">Shift User</button>

                                           <div class="loading-spiner-holder" data-loading >
                                    <div class="loading-spiner">
                                    <img src="<?php echo Request::root(); ?>/protected/public/images/Twirl.gif" />
                                    </div>
                                    </div>
                                      </div>
                                  </div>
                                  </div>
                              </form>
                          </div>
                      </div>


                      </div><!--/form-wrapper-->

                    

                  </div><!--/content-wrapper-->
                </div><!--/s10-->
              </div><!--/row-->
            
      </div><!--/container-->
  </div><!--/main-wrapper-->
  
<?php require app_path().'/views/footer.php'; ?>


<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo Request::root(); ?>/protected/public/js/simply-toast.min.js"></script>

