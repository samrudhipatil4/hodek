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
                          <h1>Approval of Risk Assessment based on Cost involved</h1>
                        </div><!--/page-heading-->    
                      </div>
                    </div>
                    <?php if(Session::has('message')){

                        echo Session::get('message');

                    }?>
                    <ul class="parsley-error-list">
                        <?php
                        foreach($errors->all() as $error){  ?>
                        <li>echo  $error</li>
                        <?php }?>
                    </ul>
                  <div class="content-wrapper" ng-controller="ApprovalriskassessmentBASEDONCOSTCTRL" ng-init="fetch_dep_for_approval_assessment_on_cost('<?php echo Request::segment(3); ?>',<?=Session::get('uid');?>)">
                    
                    <div class="status-bar">
                      <div class="row mg-bottom-0">                                          
                        <div class="col-sm-6">
                          <ul class="pd-none">
                           <li> <strong>Task Record CM Number :</strong><span ng-bind="cmno"></span></li>
                          </ul> 
                        </div>
                        <div class="col-sm-6">
                          <ul class="right">
                           <li> <strong>Current State :</strong> <span ng-bind="status"></li>
                          </ul> 
                        </div>
                      </div>                        
                    </div><!--/status-bar-->
                  
                    
                    <div class="form-wrapper" >
                        <div class="row mg-bottom-0">
                     
                          <form method="POST" action="<?php echo Request::root().'/changes/reject_risk_assessment_based_oncost/'.Request::segment(3); ?>/<?=Request::segment(4); ?>" accept-charset="UTF-8" name="approval_based_costForm" class="form-vertical" novalidate ng-submit="(submitted = true) && approval_based_costForm.$invalid && $event.preventDefault()">
           

                            <div class="row">
                              <div class="col-sm-12">
                                <p>Please Select an Operation and click on "OK" button.</p>
                              </div>
                            </div>
                            
                            <div class="row mg-btm">
                                <div class="col-sm-6">
                                    <p>
                                        <input class="with-gap"  type="radio" id="approve" name="radioStatus" ng-model="approval.radioStatus" value="1"  />
                                        <label for="approve">Approve</label>  

                                    </p>
                                    <p class="size-12 color-grey ">After Steering committee approval Mail to be provided to QA HOD for Customer Communication Decision</p>
                                </div>                             
                            </div>
                            <div class="row mg-btm" ng-if="approval.radioStatus=='1'">
                                  <div class="input-field col-sm-6">
                                      <label for="textarea"> Comment </label>
                                      <textarea id="textarea" rows="3" cols="50" class="form-control" name="comment" id="comment" ng-model="approval.comment" ></textarea>
                                     

                                  </div>
                              </div>
                              <div class="row" ng-if="approval.radioStatus=='1' && visible==true">
                                        <div class="col-sm-6" >
                                        <br>
                                        <label for="reject">Customer Communication:</label>
                                          <input class="with-gap" type="radio" id="custComm" name="custComm" ng-model="communi.custComm" value="1"  >Yes
                                           <input class="with-gap" type="radio" id="custComm" name="custComm" ng-model="communi.custComm" value="2" >No 
                                           <input type="hidden" name="visible"  id="visible" value="<?php echo 1;?>">
                                        </div>
                                    </div>
                                     <div class="row" ng-if="approval.radioStatus=='1' && communi.custComm == '1' && visible==true">
                                    <div class="col-sm-6">
                                    <div class="table-wrapper">
                                        <table class="striped">
                                            <thead>
                                            <tr>
                                                <th width="10%">Sr. No.</th>
                                                <th>Customer Communication Member</th>

                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr ng-repeat="option in custComm" ng-class="{'success' : records[$index]}">
                                                <td><%$index+1%>.</td>
                                                <td><%option.first_name%> <%option.last_name%>
                                                <input type="hidden" name="custCommmem" id="custCommmem" value="<%option.id%>">

                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                </div>

                            
                            <div class="row mg-btm">
                                <div class="col-sm-6">
                                    <p>
                                        <input class="with-gap" type="radio" id="reject" name="radioStatus" ng-model="approval.radioStatus" value="2"/>
                                        <label for="reject">Reject</label>  
                                    </p>
                                    <p class="size-12 color-grey ">If rejected then comments should be provided & same should be return for correction at respective function employee</p>
                                </div>
                            </div>
                            <div class="row mg-btm" ng-if="approval.radioStatus=='2'">


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
                                                      <td><input type="text" id="" name="comment[]" ng-model="comment" placeholder="Write Comment">
                                                          <input type="hidden" value="<%record.team_member%>" name="cid[]">

                                                      </td>


                                                  </tr>
                                                  </tbody>
                                              </table>
                                          </div>


                                      </div>



                            </div>

                              <div class="row mg-btm">
                                  <div class="col-sm-6">
                                      <p>
                                          <input class="with-gap" type="radio" id="close" name="radioStatus" ng-model="approval.radioStatus" value="3"/>
                                          <label for="reject">Permanent Reject And Close</label>
                                      </p>
                                      <p class="size-12 color-grey ">If rejected then comments should be provided & this change request is rejected and closed</p>
                                  </div>
                              </div>
                                 
                            <!-- <div class="row" ng-if="approval.radioStatus=='1'">


                                <div class="col-sm-6">
                                    <div class="table-wrapper">
                                        <table class="striped">
                                            <thead>
                                            <tr>
                                                <th width="10%">Sr. No.</th>
                                                <th>QA HOD Member</th>



                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr ng-repeat="option in qaHODS" ng-class="{'success' : records[$index]}">
                                                <td><%$index+1%>.</td>
                                                <td><%option.name%> <input type="hidden" id="user_id" value="<%option.user_id%>"></td>


                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                            </div> -->
                            
                                    

                         
                              
                              <div class="row mg-btm" ng-if="approval.radioStatus=='3'">
                                  <div class="input-field col-sm-6">
                                      <label for="textarea">Write Comment for Rejection</label>
                                      <textarea id="textarea" rows="3" cols="50" class="form-control" name="reject_reason" ng-model="approval.reject_reason" required></textarea>
                                      <span ng-cloak class="error-msg " ng-show="(approval_based_costForm.reject_reason.$dirty || invalidSubmitAttempt) && approval_based_costForm.reject_reason.$error.required"> This field is required.</span>

                                  </div>
                              </div>


                              <div class="row" ng-if="approval.radioStatus=='2'">
                              <div class="col-sm-6 btn-group" >
                              <input type="hidden" value="<?=Request::segment(3);?>" name="request_id">


                                  <button class="btn btn-animate flat blue pd-btn pull-right" type="submit" value="OK" data-after-submit-value="Saving&hellip;"/>OK</button>
                                
                               
                              </div>
                            </div> 
                            <div class="row mg-top" ng-if="approval.radioStatus=='1'">
                              <div class="col-sm-6" >
                              <input type="hidden" value="<?=Request::segment(3);?>" name="request_id">                              
                                
                                <a class="btn btn-animate flat blue pd-btn pull-right" type="submit" ng-disabled="isDisabled" ng-click="addapproval_assessment_based_ONCOST(approval_based_costForm,approval,<?=Request::segment(3);?>,<?=Request::segment(4);?>)" >OK</a>
                                  <div class="loading-spiner-holder" data-loading >
                                      <div class="loading-spiner">
                                          <img src="<?php echo Request::root(); ?>/protected/public/images/Twirl.gif" />
                                      </div>
                                  </div>
                              </div>
                            </div>
                              <div class="row mg-top" ng-if="approval.radioStatus=='3'">
                                  <div class="col-sm-6" >
                                      <input type="hidden" value="<?=Request::segment(3);?>" name="request_id">

                                      <a class="btn btn-animate flat blue pd-btn pull-right" type="submit" ng-disabled="isDisabled" ng-click="close_assessment_based_ONCOST(approval_based_costForm,approval,<?=Request::segment(3);?>,<?=Request::segment(4);?>)" >OK</a>
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
