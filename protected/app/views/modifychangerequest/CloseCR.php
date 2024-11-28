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
                          <h1>Permanent Close Change Request</h1>
                        </div><!--/page-heading-->    
                      </div>
                    </div>

                  <div class="content-wrapper">                    
                    <div class="row">
                        <div class="col-sm-12">
                        <div class="page-heading mg-btm">
                          <h1>Permanent Close Change Request</h1>
                        </div><!--/page-heading-->    
                      </div>
                    </div>


                      <div class="form-wrapper select-height" ng-controller="CloseCRCtrl">
                          <div class="row">
                              <form method="post" role="form" class="col-sm-12 myform" id="changerequestmodifyForm" ng-class="{'submitted': submitted}" name="changerequestmodifyForm" novalidate ng-submit="(submitted = true) && requestForm.$invalid && $event.preventDefault()"  autocomplete="off" >

                              <div class="row mg-btm">
                                  <div class="input-field col-sm-4">
                                      <label for="initiator_name">Select Request Id</label>
                                      <select class="form-control" select2=""  ng-model="request.r_id" name="r_id"  id="r_id" required>
                                          <option  value=""></option>

                                          <option ng-repeat="r in getChangeRequest" value="<%r.r_id%>"><%r.request_id%></option>

                                      </select>
                                      <span ng-cloak class="error-msg " ng-show="(changerequestmodifyForm.r_id.$dirty || invalidSubmitAttempt) && changerequestmodifyForm.r_id.$error.required"> This field is required.</span>
                                  </div>
                                  </div>
                                   <div class="row mg-btm" >
                              <div class="input-field col-sm-5">
                                  <label for="textarea">Write Comment for Rejection</label>
                                <textarea id="textarea" rows="3"  class="form-control" name="reject_reason" ng-model="request.reject_reason" required></textarea>
                                 <span ng-cloak class="error-msg " ng-show="(changerequestmodifyForm.reject_reason.$dirty || invalidSubmitAttempt) && changerequestmodifyForm.reject_reason.$error.required"> This field is required.</span>

                              </div>
                            </div>

                                  <div class="row mg-btm mg-btm">

                                  <div class="row">
                                      <div class="col-sm-12 ">
                                          <button class="btn btn-animate flat blue pd-btn" ng-disabled="isDisabled" type="button" id="action" name="action" ng-click="CloseCR(changerequestmodifyForm,$event)">Close Request</button>

                                           <div class="loading-spiner-holder" data-loading >
                                    <div class="loading-spiner">
                                    <img src="<?php echo Request::root(); ?>/protected/public/images/Twirl.gif" />
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
