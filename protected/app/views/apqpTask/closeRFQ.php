
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
    font-family: cursive;">Close RFQ</h1>
                      
                        </div><!--/page-heading-->    
                      </div>
                    </div>

                  <div class="content-wrapper">

                    <div class="form-wrapper" ng-controller="apqpRFQCloseCtrl" >
                          


                        <div class="row mg-bottom-0" >
                         
                          <form method="post" role="form"    class="col-sm-12 myform" ng-class="{'submitted': submitted}" id="requestForm" name="requestForm" novalidate ng-submit="(submitted = true) && requestForm.$invalid && $event.preventDefault()" enctype="multipart/form-data" autocomplete="off" >
                  
                                   <div class="row mg-btm">
                                <div class="input-field col-sm-6">
                              <label for="initiator_name">Select RFQ</label>
                              <select class="form-control" select2=""  ng-model="request.RFQId" name="RFQId"  required>
                                  <option  value=""></option>
                                  <option ng-repeat="d in RFQId" value="<%d.id%>"><%d.rfq_id %> <%d.rfq_title %></option>
                              </select>
                              <span ng-cloak class="error-msg " ng-show="(requestForm.RFQId.$dirty || invalidSubmitAttempt) && requestForm.RFQId.$error.required"> This field is required.</span>
                          </div>
                                                          

                            </div>
                          <div class="row mg-btm" >
                                    <div class="col-sm-6 input-field">
                                        <label for="lesson">Reason</label>
                                     
                                        <textarea id="reason"  type="text" class="form-control" ng-model="request.reason" name="reason"  required></textarea>
                                       <span ng-cloak class="error-msg " ng-show="(requestForm.reason.$dirty || invalidSubmitAttempt) && requestForm.reason.$error.required"> This field is required.</span>
                                        
                                    </div>
                                </div>
                        
                                    <div class="row">
                                        <div class="col-sm-12 ">
                                            <br>
                                            <button class="btn btn-animate flat blue pd-btn" ng-disabled="isDisabled" type="submit" name="action" ng-click="saveRFQClose(requestForm)">Save</button>
                                            
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
 
