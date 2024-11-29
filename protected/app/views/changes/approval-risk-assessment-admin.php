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
                                <h1>Approval of Risk Assessment</h1>
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
                    <div class="content-wrapper" ng-controller="Approvalpendingriskassessmentadmin" ng-init="fetch1(<?=Request::segment(3);?>,<?= Session::get('uid');?>)">

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


                                <form method="POST" id="approvalpendingForm" action="<?php echo Request::root().'/changes/add_pending_approval_admin/'.Request::segment(3); ?>/<?=Request::segment(4); ?>" accept-charset="UTF-8" name="approvalpendingForm" class="form-vertical" ng-submit="submitForm()" novalidate>


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
                                            <p class="size-12 color-grey ">Mail to all Steering Committee after approval of all function risk Assessment</p>
                                        </div>
                                    </div>

                                    <div class="row" ng-if="approval.radioStatus=='1'">
                                        <div class="col-sm-6">
                                            <div class="table-wrapper">
                                                <table class="striped">
                                                    <thead>
                                                    <tr>
                                                        <th width="10%">Sr. No.</th>
                                                        <th>Function Name</th>
                                                        <th>Steering Committee Member</th>
                                                        <!-- <th>Action</th>-->

                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr ng-repeat="record in fetch_sub_dep" ng-class="{'success' : records[$index]}">
                                                        <td><%$index+1%>.</td>
                                                        <td><%record.sub_dep_name%></td>
                                                        <td><%record.members.first_name%> <%record.members.last_name%></td>
                                                        <input type="hidden" name="steeringComm" id="steeringComm" value="<%record.members.id%>">

                                                        <!--  <td style="font-size:16px;"><a href="javascript:void(0)" class="tooltipped" data-position="bottom" data-tooltip="Delete Record" ng-click="DelRecord($index,record.dep_id)"><i class="fa fa-trash"></i></a></td>
                                                          -->
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div><!--/table-wrapper-->
                                        </div>
                                    </div>
                                     
                                    <div class="row" ng-if="approval.radioStatus=='1'  && display==true">
                                        <div class="col-sm-6" ng-init="customer=yes">
                                        <br>
                                        <label for="reject">Customer Communication:</label>
                                          <input class="with-gap" type="radio" name="custComm" ng-model="communication.custComm" value="1"  >Yes
                                           <input class="with-gap" type="radio" name="custComm" ng-model="communication.custComm" value="2" >No 
                                        </div>
                                    </div>
                                     <div class="row" ng-if="approval.radioStatus=='1'  && display==true && communication.custComm=='1'">
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
                                                    <input type="hidden" name="custComAvl" id="custComAvl" value="<%option.id%>">


                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                </div><br>
                                
                                   <div class="row mg-btm" ng-if="approval.radioStatus=='1' && stage=='1'">
                                        <div class="input-field col-sm-6">
                                            <label for="reject">COO Approval:</label>
                                           <input class="with-gap" type="radio" name="cooapp" ng-model="cooapp.cooapp" value="1">Yes
                                           <input class="with-gap" type="radio" name="cooapp" ng-model="cooapp.cooapp" value="2" >No 

                                        </div>
                                    </div>
                                <div class="row mg-btm" ng-if="approval.radioStatus=='1'">
                                        <div class="input-field col-sm-6">
                                            <label for="textarea">Write Comment</label>
                                            <textarea id="textarea" rows="3" cols="50" class="form-control" name="reason" ng-model="approval.reason" ></textarea>
                                            <span ng-cloak class="error-msg " ng-show="(approvalpendingForm.reject_reason.$dirty || invalidSubmitAttempt) && approvalpendingForm.reject_reason.$error.required"> This field is required.</span>

                                        </div>
                                    </div>

                                    <div class="row">
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
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <p>
                                                <input class="with-gap" type="radio" id="close" name="radioStatus" ng-model="approval.radioStatus" value="3"/>
                                                <label for="reject">Permanent Reject And Close</label>
                                            </p>
                                            <p class="size-12 color-grey ">If rejected then comments should be provided & this change request is rejected and closed</p>
                                        </div>
                                    </div>

                                    
                                    
                                
                         
                              
                                    <div class="row mg-btm" ng-if="approval.radioStatus=='3'">
                                        <div class="input-field col-sm-6">
                                            <label for="textarea">Write Comment for Rejection</label>
                                            <textarea id="textarea" rows="3" cols="50" class="form-control" name="reject_reason" ng-model="approval.reject_reason" required></textarea>
                                            <span ng-cloak class="error-msg " ng-show="(approvalpendingForm.reject_reason.$dirty || invalidSubmitAttempt) && approvalpendingForm.reject_reason.$error.required"> This field is required.</span>

                                        </div>
                                    </div>

                            <div class="row" ng-if="approval.radioStatus=='2'">
                              <div class="col-sm-6 btn-group" >
                              <input type="hidden" value="<?=Request::segment(3);?>" name="request_id">

                                  <button class="btn btn-animate flat blue pd-btn pull-right" type="submit" value="OK" data-after-submit-value="Saving&hellip;"/>OK</button>

                              </div>
                            </div>

                                    <div class="row" ng-if="approval.radioStatus=='3'">
                                        <div class="col-sm-6 btn-group" >
                                            <input type="hidden" value="<?=Request::segment(3);?>" name="request_id">

                                            <button class="btn btn-animate flat blue pd-btn pull-right" type="submit" id="permenant_reject" ng-click="close_reject(approvalpendingForm,$event)" value="OK" />OK</button>

                                        </div>
                                    </div>
                                    <div class="row mg-btm mg-top" ng-if="approval.radioStatus=='1'">

                                        <div class="col-sm-6 ">
                                            <input type="hidden" value="<?=Request::segment(3);?>" name="request_id">
                                            <button class="btn btn-animate flat blue pd-btn pull-right" type="submit" ng-disabled="disable" value="OK" data-after-submit-value="Saving&hellip;"/>OK</button>

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
<script>


  /*  var element = document.querySelector("form");
    element.addEventListener("submit", function(event) {
         var radioValue = $("input[name='radioStatus']:checked").val();
        if(radioValue == 3){
            var r = confirm("Are you sure you want to permanently reject request?!");
            if (r == true) {
                return true;
            }else{

                event.preventDefault();
                return false;

            }
        }
    });*/

</script>
