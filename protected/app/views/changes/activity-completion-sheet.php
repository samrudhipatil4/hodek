<?php require app_path().'/views/header.php'; ?>

  <?php if(Session::has('message')){

                        echo Session::get('message');

                    }?>
                    <ul class="parsley-error-list">
                        <?php
                        foreach($errors->all() as $error){  ?>
                        <li>echo  $error</li>
                        <?php }?>
                    </ul>

  <div class="main-wrapper">
    <div class="container">

              <div class="row two-col-row mg-bottom-0">
                <div class="col-sm-2">

              <!-- Sidebar Comes here! -->

          <?php require app_path().'/views/sidebar.php'; ?>
                </div><!--/s2-->
                <div class="col-sm-10">

                    <div class="row">
                      <div class="col-sm-12">
                        <div class="page-heading">
                          <h1>Activity Completion Sheet Verify</h1>
                        </div><!--/page-heading-->    
                      </div>
                    </div>

                  <div class="content-wrapper" ng-controller="ActivityCompletionSheetVerifyCTRL" ng-init="get_info('<?php echo Request::segment(3); ?>',<?=Session::get('uid');?>)">

                    <div class="status-bar">
                      <div class="row mg-bottom-0">                                          
                        <div class="col-sm-6">
                          <ul class="pd-none">
                           <li> <strong>Task Record CM Number :</strong> <span ng-bind="cmno"></span></li>
                          </ul> 
                        </div>
                        <div class="col-sm-6">
                          <ul class="pull-right">
                           <li> <strong>Current State :</strong><span ng-bind="status"> </li>
                          </ul> 
                        </div>
                      </div>                        
                    </div><!--/status-bar-->
                                     
                    
                    <div class="form-wrapper" >
                        <div class="row mg-bottom-0">

                              <form method="POST" name="verify_activity_completion" action="<?php echo Request::root().'/changes/verify_activity_completion_sheet/'.Request::segment(3); ?>/<?=Request::segment(4); ?>" accept-charset="UTF-8" name="activity_completion_sheet" class="form-vertical" novalidate ng-submit="(submitted = true) && activity_completion_sheet.$invalid && $event.preventDefault()">


                              <div class="row">
                              <div class="col-sm-12">
                                <p>Please Select an Operation and click on "OK" button.</p>
                              </div>
                            </div>
                            
                            <div class="row mg-bottom-0">
                                <div class="col-sm-6">
                                    <p>
                                        <input class="with-gap"  type="radio" id="accept" name="radioStatus" ng-model="activity.radioStatus" value="1" checked />
                                        <label for="accept">Verified and Approved</label>  
                                    </p>
                                   
                                </div>                             
                            </div>
                            
                            <div class="row">
                                <div class="col-sm-6">
                                    <p>
                                        <input class="with-gap" type="radio" id="reject" name="radioStatus" ng-model="activity.radioStatus" value="2"/>
                                        <label for="reject">Reject</label>  
                                    </p>
                                    <p class="size-12 color-grey "> Please Add your comment for rejection.</p>
                                </div>
                            </div>

                              <div class="row mg-btm mg-btm" ng-if="activity.radioStatus=='2'">



                                          <div class="col-sm-6">
                                              <div class="table-wrapper">
                                                  <table class="striped">
                                                      <thead>
                                                      <tr>
                                                          <th width="10%">Sr. No.</th>
                                                          <th>Function Name</th>
                                                          <th>Team Member</th>
                                                          <th>Comment</th>

                                                      </tr>
                                                      </thead>
                                                      <tbody>
                                                      <tr ng-repeat="record in availableOptions" ng-class="{'success' : records[$index]}">
                                                          <td><%$index+1%>.</td>
                                                          <td><%record.d_name%></td>
                                                          <td><%record.first_name%> <%record.last_name%></td>
                                                          <td><input type="text" id="commentid" name="comment[]" ng-model="comment" placeholder="Write Comment">
                                                              <input type="hidden" value="<%record.team_member%>" name="cid[]">
                                                              <input type="hidden" value="<%record.d_id%>" name="did[]">

                                                          </td>


                                                      </tr>
                                                      </tbody>
                                                  </table>
                                              </div>


                                          </div>




                                 <!-- <div class="input-field col-sm-6">
                                      <label for="textarea">Write Comment for Rejection</label>
                                      <textarea name="reject_reason" ng-model="activity.reject_reason" class="form-control " rows="3" id="textarea" required></textarea>

                                      <span ng-cloak class="error-msg " ng-show="(customer_verificationForm.reject_reason.$dirty || invalidSubmitAttempt) && customer_verificationForm.reject_reason.$error.required"> This field is required.</span>

                                  </div>-->

                              </div>
                                  <div class="row">
                                      <div class="col-sm-6">
                                          <p>
                                              <input class="with-gap" type="radio" id="close" name="radioStatus" ng-model="activity.radioStatus" value="3"/>
                                              <label for="reject">Permanent Reject And Close</label>
                                          </p>
                                          <p class="size-12 color-grey "> Please Add your comment for rejection.</p>
                                      </div>
                                  </div>
                                  <div class="row mg-btm mg-btm" ng-if="activity.radioStatus=='3'">
                                      <div class="input-field col-sm-6">
                                          <label for="textarea">Write Comment for Rejection</label>
                                          <textarea name="close_reason" ng-model="activity.close_reason" class="form-control " rows="3" id="textarea" required></textarea>

                                          <span ng-cloak class="error-msg " ng-show="(verify_activity_completion.close_reason.$dirty || invalidSubmitAttempt) && verify_activity_completion.close_reason.$error.required"> This field is required.</span>

                                      </div>

                                  </div>

                                  <div class="row mg-top" ng-if="activity.radioStatus=='3'">
                                      <div class="col-sm-6  ">
                                          <div class="loading-spiner-holder" data-loading >
                                              <div class="loading-spiner">
                                                  <img src="<?php echo Request::root(); ?>/protected/public/images/Twirl.gif" />
                                              </div>
                                          </div>
                                          <input type="hidden" value="<?=Request::segment(3);?>" name="request_id">


                                          <button class="btn btn-animate flat blue pd-btn pull-right" type="submit" value="OK" ng-click="verify_activity(verify_activity_completion,$event)" />OK</button>
                                          <!-- <button  class="btn btn-animate flat blue pd-btn" ng-disabled="isDisabled" type="button" name="action" ng-click="activity_completion_sheet_verify(activity,<?=Request::segment(3);?>,<?=Request::segment(4);?>)">OK</button>
                                    -->


                                      </div>
                                  </div>

                                  <div class="row mg-top" ng-if="activity.radioStatus=='1'|| activity.radioStatus=='2'">
                              <div class="col-sm-6  ">
                                  <div class="loading-spiner-holder" data-loading >
                                      <div class="loading-spiner">
                                          <img src="<?php echo Request::root(); ?>/protected/public/images/Twirl.gif" />
                                      </div>
                                  </div>
                                  <input type="hidden" value="<?=Request::segment(3);?>" name="request_id">


                                  <button class="btn btn-animate flat blue pd-btn pull-right" type="submit" value="OK"  data-after-submit-value="Saving&hellip;"/>OK</button>
                               <!-- <button  class="btn btn-animate flat blue pd-btn" ng-disabled="isDisabled" type="button" name="action" ng-click="activity_completion_sheet_verify(activity,<?=Request::segment(3);?>,<?=Request::segment(4);?>)">OK</button>
                                    -->


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

    //$(document).ready(function() {
    //jQuery(function($) {alert();
    // set data-after-submit-value on input:submit to disable button after submit
    $(document).on('submit', 'form', function() {
       $("#fade").show();
        var $form = $(this),
            $button,
            label;
        $form.find(':submit').each(function() {
            $button = $(this);
            label = $button.data('after-submit-value');
            if (typeof label != 'undefined') {
                $button.val(label).prop('disabled', true);
            }
        });
    });
    //  });
</script>

  