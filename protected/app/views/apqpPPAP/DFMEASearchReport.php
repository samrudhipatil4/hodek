
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
    font-family: cursive;">DFMEA Report </h1>
                      
                        </div><!--/page-heading-->    
                      </div>
                    </div>

                  <div class="content-wrapper">

                    <div class="form-wrapper" ng-controller="DFMEAReportCtrl">
                          


                        <div class="row mg-bottom-0" >
                         
<form method="post" role="form"  class="col-sm-12
                          myform" ng-class="{'submitted': submitted}"
                          id="requestForm" name="requestForm" novalidate  ng-submit="(submitted = true) && requestForm.$invalid && $event.preventDefault()"
                          enctype="multipart/form-data" autocomplete="off" action="<?php echo Request::root().'/view_DFMEA_report'; ?>">
                  
                                   <div class="row mg-btm">
                                <div class="input-field col-sm-6">
                              <label for="initiator_name">Select DFMEA Number</label>
                            <select class="form-control" select2="" id="dfmea_no" ng-model="request.dfmea_no" name="dfmea_no" required="true">
                                  <option  value=""></option>
                                  <option ng-repeat="d in dfmeano" value="<%d.dfmea_id%>"><%d.dfmea_no%></option>
                              </select>
                               <span ng-cloak class="error-msg " ng-show="(requestForm.dfmea_no.$dirty || invalidSubmitAttempt) && requestForm.dfmea_no.$error.required"> This field is required.</span>
                          </div>
                                                                                 

                            </div>
                         
                                   
                                    <div class="row">
                                        <div class="col-sm-12 ">
                                            <br>
                        <button class="btn btn-animate flat blue pd-btn" ng-disabled="isDisabled" type="submit" id="saveData"  name="action" ng-click="checkVal(requestForm)">Submit</button>
                                            
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
 
