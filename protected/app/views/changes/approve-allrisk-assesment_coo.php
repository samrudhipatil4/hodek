<?php require app_path().'/views/header.php'; ?>

  <div class="main-wrapper">
    <div class="container-fluid">

              <div class="row two-col-row mg-bottom-0">
                <div class="col-sm-2">
                 
                 <!-- Sidebar Comes here! -->
					
					<?php require app_path().'/views/sidebar.php'; ?>
					
					<!-- sidebar ends here -->
                 
                 
                </div><!--/s2-->
                <div class="col-sm-10" ng-controller="CtrlcooApproval" ng-init="getrequestinfo('<?php echo Request::segment(3); ?>',<?= Session::get('uid');?>)">

                    <div class="row">
                      <div class="col-sm-12">
                        <div class="page-heading">
                          <h1>Newly added "New Change request" by <strong><span ng-bind="requestinfos.first_name"></span> <span ng-bind="requestinfos.last_name"></span></strong></h1>
                        </div><!--/page-heading-->    
                      </div>
                    </div>

                  <div class="content-wrapper">
                    
                    <div class="status-bar">
                      <div class="row mg-bottom-0">                                          
                        <div class="col-sm-4">
                          <ul class="pd-none">
                           <li> <strong>Task Record CM Number :</strong> <span ng-bind="cmno"></span></li>
                          </ul> 
                        </div>
                        <div class="col-sm-8">
                          <ul class="pull-right">
                           <li> <strong>Current State :</strong> <span ng-bind="status"></li>
                          </ul> 
                        </div>
                      </div>                        
                    </div><!--/status-bar-->
                  
                    
                    <div class="form-wrapper" >
                        <div class="row mg-bottom-0">
                          <form class="col-sm-12" ng-class="{'submitted': submitted}" name="requestFormcoo" novalidate ng-submit="(submitted = true) && requestFormcoo.$invalid && $event.preventDefault()" autocomplete="off">

                            <div class="row">
                              <div class="col-sm-12">
                                <p>Please Select an Operation and click on "OK" button.</p>
                              </div>
                            </div>
                            
                            <div class="row mg-btm">
                                <div class="col-sm-6">
                                    <p>
                                        <input class="with-gap"  type="radio" id="accept" name="radioStatus" ng-model="act.radioStatus" value="2" checked />
                                        <label for="accept">Accept</label>  

                                    <p class="size-12 color-grey ">Submit to Initiator for status, Accept, Reject and To Administrator for Accepted</p>
                                </div>                             
                            </div>
                            
                            <div class="row mg-btm">
                                <div class="col-sm-6">
                                    <p>
                                        <input class="with-gap" type="radio" id="reject" name="radioStatus" ng-model="act.radioStatus" value="3"/>
                                        <label for="reject">Reject</label>  
                                    </p>
                                    
                                </div>
                            </div>
                            <div class="row mg-btm" ng-if="act.radioStatus=='2'">
                              <div class="input-field col-sm-5">
                                  <label for="textarea">Comment </label>
                                <textarea id="textarea" rows="3"  class="form-control" name="comment" ng-model="act.comment" required></textarea>
                                  <span ng-cloak class="error-msg " ng-show="(requestFormcoo.comment.$dirty || invalidSubmitAttempt) && requestFormcoo.comment.$error.required"> This field is required.</span>

                              </div>
                            </div>

                            <div class="row mg-btm" ng-if="act.radioStatus=='3'">
                              <div class="input-field col-sm-5">
                                  <label for="textarea">Write Comment for Rejection</label>
                                <textarea id="textarea" rows="3"  class="form-control" name="reject_reason" ng-model="act.reject_reason" required></textarea>
                                  <span ng-cloak class="error-msg " ng-show="(requestFormcoo.reject_reason.$dirty || invalidSubmitAttempt) && requestFormcoo.reject_reason.$error.required"> This field is required.</span>

                              </div>
                            </div>
                              

                              <div class="row mg-btm">
                              <div class="col-sm-12 ">
                                <a class="btn btn-animate flat blue pd-btn" name="action" ng-disabled="isDisabled" ng-confirm="Are you sure you want to delete this foo?" ng-click="cooApprovalStatus(requestFormcoo,'<?php echo Request::segment(3); ?>','<?php echo Request::segment(4); ?>')">OK</a>
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

<script type="text/javascript">

    $(document).ready(function() {

    $("#startdate_status1").datepicker({startDate: '<?php echo date('d-m-Y'); ?>'});  
        


    });
</script>