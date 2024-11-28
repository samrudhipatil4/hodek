
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
    font-family: cursive;">PFMEA Report </h1>
                      
                        </div><!--/page-heading-->    
                      </div>
                    </div>

                  <div class="content-wrapper">

                    <div class="form-wrapper" ng-controller="PFMEAReportCtrl">
                          


                        <div class="row mg-bottom-0" >
                         
<form method="post" role="form"  class="col-sm-12
                          myform" ng-class="{'submitted': submitted}"
                          id="requestForm" name="requestForm" novalidate  ng-submit="(submitted = true) && requestForm.$invalid && $event.preventDefault()"
                          enctype="multipart/form-data" autocomplete="off" action="<?php echo Request::root().'/view_PFMEA_report'; ?>">
                  
                                   <div class="row mg-btm">
                                <div class="input-field col-sm-6">
                              <label for="initiator_name">Select PFMEA Number</label>
                            <select class="form-control" select2="" id="pfmea_no" ng-model="request.pfmea_no" name="pfmea_no" required="true">
                                  <option  value=""></option>
                                  <option ng-repeat="d in pfmeano" value="<%d.pfmea_id%>"><%d.pfmea_no%></option>
                              </select>
                               <span ng-cloak class="error-msg " ng-show="(requestForm.pfmea_no.$dirty || invalidSubmitAttempt) && requestForm.pfmea_no.$error.required"> This field is required.</span>
                          </div>
                            </div>
                     <div class="row">
                        <div class="col-sm-12 ">
                           <br>
                        <button class="btn btn-animate flat blue pd-btn" ng-disabled="isDisabled" type="submit" id="saveData" name="action" ng-click="checkVal(requestForm)">Submit</button>
                                            
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



<?php require app_path().'/views/apqp_footer.php'; ?>
 
