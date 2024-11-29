
<?php require app_path().'/views/apqp_header.php'; ?>

  <div class="main-wrapper">
    <div class="container">


              <div class="row two-col-row mg-bottom-0">
                <div class="col-sm-2">
                    
                </div>
                <div class="col-sm-10">

                    <div class="row">
                      <div class="col-sm-12">
                        <div class="page-heading">
                        <h1 style="font-size: 24px;
    font-family: cursive;">Shift Task </h1>
                      
                        </div><!--/page-heading-->    
                      </div>
                    </div>

                  <div class="content-wrapper">

                    <div class="form-wrapper" ng-controller="apqpTaskShiftCtrl" ng-init="getProject()">
                          


                        <div class="row mg-bottom-0" >
                         
            <form method="post" role="form"  class="col-sm-12
                          myform" ng-class="{'submitted': submitted}"
                          id="requestForm" name="requestForm" novalidate  ng-
                          submit="form.$invalid &&
                          $event.preventDefault();form.$submitted=true;"
                          enctype="multipart/form-data" autocomplete="off" >
                  
                                   <div class="row mg-btm">
                                <div class="input-field col-sm-4">
                              <label for="initiator_name">Select Project</label>
                              <select class="form-control" select2="" id="proj_no" ng-model="request.proj_no" name="proj_no" ng-change="getGateInfo(request.proj_no)" required >
                                  <option  value=""></option>
                                  <option ng-repeat="d in file" value="<%d.id%>"><%d.project_no%></option>
                              </select>
                              <span id="projecterror" ng-cloak class="error-msg " ng-show="(requestForm.proj_no.$dirty || invalidSubmitAttempt) && requestForm.proj_no.$error.required"> This field is required.</span>
                          </div>
                           <div class="input-field col-sm-4">
                              <label for="initiator_name">Select Gate</label>
                              <select class="form-control" select2="" id="gate" ng-model="request.gate" name="gate" ng-change="getActivity(request.proj_no,request.gate)" required >
                                  <option  value=""></option>
                                  <option ng-repeat="d in gate" value="<%d.id%>"><%d.Gate_Description%></option>
                              </select>
                              <span id="gateerror" ng-cloak class="error-msg " ng-show="(requestForm.gate.$dirty || invalidSubmitAttempt) && requestForm.gate.$error.required"> This field is required.</span>
                          </div>
                             <div class="input-field col-sm-4">
                              <label for="initiator_name">Select Activity </label>
                              <select class="form-control" select2=""  ng-model="request.activity" id="activity" name="activity" ng-change="getUser(request.activity,request.proj_no,request.gate)"  required>
                                  <option  value=""></option>
                                  <option ng-repeat="d in activity" value="<%d.id%>"><%d.activity%></option>
                              </select>
                              <span id="activityerror" ng-cloak class="error-msg " ng-show="(requestForm.activity.$dirty || invalidSubmitAttempt) && requestForm.activity.$error.required"> This field is required.</span>
                          </div>
                                                    

                            </div>
                          <div class="row">
                           <div class="input-field col-sm-4">
                              <label for="initiator_name">Existing User</label>
                             <input type="text" name="exist_user" ng-model="request.exist_user" readonly>
                             <input type="hidden" name="exist_userId" ng-model="request.exist_userId">
                              
                          </div>  
                          <div class="input-field col-sm-4">
                          <label for="initiator_name">New User</label>
                              <select class="form-control" select2=""  ng-model="request.new_user" id="new_user" name="new_user"   required>
                                  <option  value=""></option>
                                  <option ng-repeat="d in user" value="<%d.id%>"><%d.first_name%> <%d.last_name%></option>
                              </select>
                              <span id="userkerror" ng-cloak class="error-msg " ng-show="(requestForm.new_user.$dirty || invalidSubmitAttempt) && requestForm.new_user.$error.required"> This field is required.</span>
                          </div>
                         
                          </div>
                                   
                                    <div class="row">
                                        <div class="col-sm-12 ">
                                            <br>
                                            <button class="btn btn-animate flat blue pd-btn" ng-disabled="isDisabled" type="submit" id="saveData" ng-click="submitForm(requestForm)" name="action" >Shift User</button>
                                            
                                        </div>
                                    </div>

                            </form>
                        </div>
                    </div><!--/form-wrapper-->


                  </div><!--/content-wrapper-->
                </div><!--/s10-->
              </div><!--/row-->
            
      </div><!--/container-->
  </div><!--/main-wrapper-->



<?php require app_path().'/views/footer.php'; ?>
 
<script type="text/javascript">
var base_url='<?php echo Request::root(); ?>/';


</script>