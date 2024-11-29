<?php require app_path().'/views/header.php'; ?>

  <div class="main-wrapper">
    <div class="container">

              <div class="row two-col-row mg-bottom-0">
                <div class="col-sm-2">
                    <?php require app_path().'/views/sidebar.php'; ?>
                </div><!--/s2-->
                 <div class="col-sm-10">

                    <div class="row">
                      <div class="col-sm-12">
                        <div class="page-heading">
                          <h1>Horizontal Deployment <strong><?php echo Session::get('fid');?></strong></h1>
                        </div><!--/page-heading-->    
                      </div>
                    </div>

                  <div class="content-wrapper">
                    
                    <div class="form-wrapper" ng-controller="HorizontalDeploymentCTRL" ng-init="get_customer_for_horizontal_deployment(<?=Request::segment(3);?>)">
                        <div class="row mg-bottom-0">
                          <form method="post" role="form" class="col-sm-12 myform" ng-class="{'submitted': submitted}" name="HorizontalDepForm" novalidate ng-submit="(submitted = true) && HorizontalDepForm.$invalid && $event.preventDefault()" autocomplete="off">

                            <div class="row">
                              <div class="col-sm-12">
                                <p>Please Select an Operation and click on "Ok" button.</p>
                              </div>
                            </div>
                            
                            <div class="row mg-bottom-0">
                                <div class="col-sm-12">
                                    <p>
                                        <input class="with-gap"  type="radio" id="yes" name="radioStatus" ng-model="activity.radioStatus" value="1" checked />
                                        <label for="yes">Yes </label>
                                    </p>
                                 </div>                             
                            </div>
                            <div class="row" ng-show="activity.radioStatus=='1'">

                                <div class="input-field col-sm-7 sel mg-bottom-20">
                                    <p> In case of Process Change for more than one Customer</p>
                                    <label for="design">Select Customer Name</label>
                                    <select class="form-control" select2="" multiple ng-model="activity.customer_id" name="customer_id"  required>
                                        <option  value=""></option>

                                        <option ng-repeat="customer in customers" value="<%customer.CustomerId%>"><%customer.FirstName%> <%customer.LastName%></option>

                                    </select>

                                    <span ng-cloak class="error-msg " ng-show="(HorizontalDepForm.customer_id.$dirty || invalidSubmitAttempt) && HorizontalDepForm.customer_id.$error.required"> This field is required.</span>

                                </div>



                              <div class="input-field col-sm-7 mg-bottom-20">

                                 <label for="textarea">Please Mention Part Name, Part Number & Modification Details.</label>
                                <textarea id="textarea" name="comment" ng-model="activity.comment" class="materialize-textarea" required></textarea>
                                <span ng-cloak class="error-msg " ng-show="(HorizontalDepForm.comment.$dirty || invalidSubmitAttempt) && HorizontalDepForm.comment.$error.required"> This field is required.</span>

                              </div>
                               <div class="input-field col-sm-7 mg-bottom-20">

                                 <label for="textarea">Write Reason</label>
                                <textarea id="textarea" name="reason" ng-model="activity.reason" class="materialize-textarea" required></textarea>
                                <span ng-cloak class="error-msg " ng-show="(HorizontalDepForm.reason.$dirty || invalidSubmitAttempt) && HorizontalDepForm.reason.$error.required"> This field is required.</span>

                              </div>
                            </div> 
                            
                            <div class="row">
                                <div class="col-sm-12">
                                    <p>
                                        <input class="with-gap" type="radio" id="reject" name="radioStatus" ng-model="activity.radioStatus" value="2"/>
                                        <label for="reject">No</label>  
                                    </p>
                                    <p class="size-12 color-grey"></p>
                                </div>
                            </div>
                            <input type="hidden" name='stage' id='stage' value='<% stage %>'>
                             <div class="row" ng-show="activity.radioStatus=='2' && stage=='1'">


                               <div class="input-field col-sm-7 mg-bottom-20">

                                 <label for="textarea">Comment</label>
                                <textarea id="textarea" name="Nocomment" ng-model="activity.Nocomment" class="materialize-textarea" ng-required="radioStatus=='2'"></textarea>
                                <span ng-cloak class="error-msg " ng-show="(HorizontalDepForm.Nocomment.$dirty || invalidSubmitAttempt) && HorizontalDepForm.Nocomment.$error.required"> This field is required.</span>

                              </div>
                            </div> 
                            

                            <div class="row">
                              <div class="col-sm-12 " ng-if="activity.radioStatus=='1'">
                                <button button class="btn btn-animate flat blue pd-btn" type="button" ng-disabled="isDisabled" name="action" ng-click="horizontal_dep(HorizontalDepForm,activity,<?=Request::segment(3);?>,<?=Request::segment(4);?>)">OK</button>
                               <!-- <button class="btn " type="button">Cancel</button>-->

                                  <div class="loading-spiner-holder" data-loading >
                                      <div class="loading-spiner">
                                          <img src="<?php echo Request::root(); ?>/protected/public/images/Twirl.gif" />
                                      </div>
                                  </div>
                              </div>
                                <div class="col-sm-12 " ng-if="activity.radioStatus=='2'">
                                    <button button class="btn btn-animate flat blue pd-btn" type="button" ng-disabled="isDisabled" name="action" ng-click="horizontal_dep_acc(HorizontalDepForm,activity,<?=Request::segment(3);?>,<?=Request::segment(4);?>)">OK</button>
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