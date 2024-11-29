<?php require app_path().'/views/header.php'; ?>
  <div class="main-wrapper">
    <div class="container">

              <div class="row two-col-row mg-bottom-0">
                <div class="col-sm-2">
                  <?php require app_path().'/views/sidebar.php'; ?>
                </div><!--/s2-->
                <div class="col-sm-10">

                  <div class="content-wrapper" ng-controller="CMCloserCTRL" ng-init="get_info('<?php echo Request::segment(3); ?>',<?=Session::get('uid');?>)">
                    <form method="post" role="form" class="col-sm-12 myform" ng-class="{'submitted': submitted}" name="cmCloserForm" novalidate ng-submit="(submitted = true) && cmCloserForm.$invalid && $event.preventDefault()" autocomplete="off">
                    <div class="status-bar">
                      <div class="row mg-bottom-0">                                          
                        <div class="col-sm-6">
                          <ul class="pd-none">
                           <li> <strong>Task Record CM Number :</strong> <span ng-bind="cmno"></span></li>
                          </ul> 
                        </div>
                        <div class="col-sm-6">
                          <ul class="pull-right">
                           <li> <strong>Current State :</strong><span ng-bind="status"> Change Management Closer</li>
                          </ul> 
                        </div>
                      </div>                        
                    </div><!--/status-bar-->
                  
                    
                    <div class="form-wrapper">
                        <div class="row mg-bottom-0">
                          <form class="col-sm-12">

                            <div class="row">
                              <div class="col-sm-12">
                                <p>Please Select an Operation below to change the Management Closer Status.</p>
                              </div>
                            </div>
                            
                            <div class="row mg-bottom-0">
                                <div class="col-sm-6">
                                    <p>
                                        <input class="with-gap"  type="radio" id="closed" name="radioStatus" ng-model="closer.radioStatus" value="20" ng-checked="true" />

                                        <label for="closed">Closed</label>  
                                    </p>
                                   
                                </div>                             
                            </div>
                            
                            <div class="row mg-bottom-0" ng-if="stage!=1">
                                <div class="col-sm-6">
                                    <p>
                                        <input class="with-gap" type="radio" id="open" name="radioStatus" ng-model="closer.radioStatus" value="21"/>

                                        <label for="open">Open</label>  
                                    </p>                                  
                                </div>
                            </div>

                            <div class="row mg-btm" ng-if="stage!='1'">
                                <div class="col-sm-6">
                                    <p>
                                        <input class="with-gap" type="radio" id="cancelled" name="radioStatus" ng-model="closer.radioStatus" value="22"/>

                                        <label for="cancelled">Cancelled</label>
                                    </p>                                    
                                </div>
                            </div>

                             <div class="row mg-btm" ng-if="stage=='1'">
                                <div class="col-sm-6">
                                    <p>
                                        <input class="with-gap" type="radio" id="cancelled" name="radioStatus" ng-model="closer.radioStatus" value="25"/>

                                        <label for="cancelled">Hold</label>
                                    </p>                                    
                                </div>
                            </div>

                             <div class="row" ng-if="stage=='1' && closer.radioStatus!='25'">
                               <div class="input-field col-sm-7 mg-bottom-20">
                                 <label for="textarea">Comment</label>
                                <textarea id="textarea" name="Nocomment" ng-model="closer.Nocomment" class="materialize-textarea" required></textarea>
                                <span ng-cloak class="error-msg " ng-show="(cmCloserForm.Nocomment.$dirty || invalidSubmitAttempt) && cmCloserForm.Nocomment.$error.required"> This field is required.</span>

                              </div>
                            </div> 

                            <div class="row">
                              <div class="col-sm-12 btn-group">                                
                                <button class="btn btn-animate flat blue pd-btn" type="submit" ng-disabled="isDisabled" name="action" ng-click="closeCM(cmCloserForm,closer,<?=Request::segment(3);?>,<?=Request::segment(4);?>)">OK</button>

                              </div>
                            </div> 

                            </form>
                        </div>
                    </div><!--/form-wrapper-->
                    </form>

                  </div><!--/content-wrapper-->
                </div><!--/s10-->
              </div><!--/row-->
            
      </div><!--/container-->
  </div><!--/main-wrapper-->
<?php require app_path().'/views/footer.php'; ?>