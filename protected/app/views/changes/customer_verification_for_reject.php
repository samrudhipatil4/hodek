<?php require app_path().'/views/header.php'; ?>

  <div class="main-wrapper">
    <div class="container">

              <div class="row two-col-row mg-bottom-0">
                <div class="col-sm-2">
                 
                 <!-- Sidebar Comes here! -->
					
					<?php require app_path().'/views/sidebar.php'; ?>
					
					<!-- sidebar ends here -->
                 
                 
                </div><!--/s2-->
                <div class="col-sm-10" ng-controller="customer_verificationCtrl_for_reject" ng-init="get_info('<?php echo Request::segment(3); ?>')">

                  <div class="content-wrapper">
                    
                    <div class="status-bar">
                      <div class="row mg-bottom-0">                                          
                        <div class="col-sm-6">
                          <ul class="pd-none">
                           <li> <strong>Task Record CM Number :</strong> <span ng-bind="cmno"></span></li>
                          </ul> 
                        </div>
                        <div class="col-sm-6">
                          <ul class="pull-right">
                           <li> <strong>Current State :</strong> <span ng-bind="status"></li>
                          </ul> 
                        </div>
                      </div>                        
                    </div><!--/status-bar-->
                  
                    
                    <div class="form-wrapper" >
                        <div class="row mg-bottom-0">
                          <form class="col-sm-12" ng-class="{'submitted': submitted}" name="customer_verificationForm" novalidate ng-submit="(submitted = true) && requestForm.$invalid && $event.preventDefault()" autocomplete="off">

                            <div class="row">
                              <div class="col-sm-12">
                                <p>Please Select an Operation and click on "OK" button.</p>
                              </div>
                            </div>
                            
                            <div class="row mg-bottom-0">
                                <div class="col-sm-6">
                                    <p>
                                        <input class="with-gap"  type="radio" id="accept" name="radioStatus" ng-model="verify.radioStatus" value="1" checked />
                                        <label for="accept">Verified & Approved</label>
                                    </p>
                                    <p class="size-12 color-grey "><strong>After Verification & approval Mail to be provided to all activity closer Responsible employee</strong></p>
                                </div>                             
                            </div>
                            
                            <div class="row">
                                <div class="col-sm-6">
                                    <p>
                                        <input class="with-gap" type="radio" id="reject" name="radioStatus" ng-model="verify.radioStatus" value="2"/>
                                        <label for="reject">Reject</label>
                                    </p>
                                    <p class="size-12 color-grey"><strong>Please Add your comment for rejection.</strong></p>
                                </div>
                            </div>
                            


                              <div class="row mg-btm mg-btm" ng-if="verify.radioStatus=='2'">
                                  <div class="input-field col-sm-6">
                                      <label for="textarea">Write Comment for Rejection</label>
                                      <textarea name="reject_reason" ng-model="verify.reject_reason" class="form-control " rows="3" id="textarea" required></textarea>

                                      <span ng-cloak class="error-msg " ng-show="(customer_verificationForm.reject_reason.$dirty || invalidSubmitAttempt) && customer_verificationForm.reject_reason.$error.required"> This field is required.</span>

                                  </div>

                              </div>

                            <div class="row">
                              <div class="col-sm-6 ">
                                <a class="btn btn-animate flat blue pd-btn pull-right" ng-disabled="isDisabled" name="action" ng-click="verify_customer_for_reject(customer_verificationForm,'<?php echo Request::segment(3); ?>','<?php echo Request::segment(4); ?>')">OK</a>
                                  <div class="loading-spiner-holder" data-loading >
                                      <div class="loading-spiner">
                                          <img src="<?php echo Request::root(); ?>/protected/public/images/Twirl.gif" />
                                      </div>
                                  </div>
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
