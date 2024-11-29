   
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
    font-family: cursive;"> Project Summary Report </h1>
                      
                        </div><!--/page-heading-->    
                      </div>
                    </div>

                  <div class="content-wrapper">

                    <div class="form-wrapper" ng-controller="apqpsummaryReportCtrl" >
                          


                        <div class="row mg-bottom-0" >
                         
                         <form method="post"  role="form" action="<?php echo Request::root().'/getReportDetails'; ?>" class="col-sm-12 myform" ng-class="{'submitted': submitted}" name="requestForm" novalidate ng-submit="(submitted = true) && requestForm.$invalid && $event.preventDefault()" autocomplete="off">
                          <!--     <div class="row mg-btm">
                                <div class="input-field col-sm-6">
                              <label for="initiator_name">Select Template</label>
                              <select class="form-control" select2=""  ng-model="request.template" name="template" ng-change="getProject(request.template)"  required >
                                  <option  value=""></option>
                                  <option ng-repeat="d in template" value="<%d.template_id%>"><%d.template_desc%></option>
                              </select>
                              <span ng-cloak class="error-msg " ng-show="(requestForm.template.$dirty || invalidSubmitAttempt) && requestForm.template.$error.required"> This field is required.</span>
                          </div>
                            </div> -->
                                   <div class="row mg-btm">
                                <div class="input-field col-sm-6">
                              <label for="initiator_name">Select Project</label>
                              <select class="form-control" select2=""  ng-model="request.proj_no" name="proj_no"  >
                                  <option  value=""></option>
                                  <option ng-repeat="d in file" value="<%d.id%>"><%d.project_no%></option>
                              </select>
                              <span ng-cloak class="error-msg " ng-show="(requestForm.proj_no.$dirty || invalidSubmitAttempt) && requestForm.proj_no.$error.required"> This field is required.</span>
                          </div>
                            </div>
                           
                                   
                                    <div class="row">
                                        <div class="col-sm-12 ">
                                            <br>
                                            <button class="btn btn-animate flat blue pd-btn" ng-click="checkVal(requestForm)"  ng-disabled="isDisabled" type="submit" name="action" >Submit</button>
                                            
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
 
