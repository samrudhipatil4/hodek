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

                  <div class="content-wrapper" ng-controller="ApprovalpendingriskassessmentCTRL" ng-init="fetch1(<?=Request::segment(3);?>)">

                    <div class="status-bar">
                      <div class="row mg-bottom-0">
                        <div class="col-sm-6">
                          <ul class="pd-none">
                           <li> <strong>Task Record CM Number :</strong> <span ng-bind="cmno"></span></li>
                          </ul>
                        </div>
                        <div class="col-sm-6">
                          <ul class="pull-right">
                           <li> <strong>Current State :</strong> <span ng-bind="assignedtaskstome.status"></li>
                          </ul>
                        </div>
                      </div>
                    </div><!--/status-bar-->


                    <div class="form-wrapper" >
                        <div class="row mg-bottom-0">


                             <form method="POST" action="<?php echo Request::root().'/changes/add_pending_approval/'.Request::segment(3); ?>/<?=Request::segment(4); ?>" accept-charset="UTF-8" name="approvalpendingForm" class="form-vertical" ng-submit="submitForm()" novalidate>


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

                            <div class="row">
                                <div class="col-sm-6">
                                    <p>
                                        <input class="with-gap" type="radio" id="reject" name="radioStatus" ng-model="approval.radioStatus" value="2"/>
                                        <label for="reject">Reject</label>
                                    </p>
                                    <p class="size-12 color-grey ">If rejected then comments should be provided & same should be return for correction at respective function employee</p>
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


                                  <!--  <td style="font-size:16px;"><a href="javascript:void(0)" class="tooltipped" data-position="bottom" data-tooltip="Delete Record" ng-click="DelRecord($index,record.dep_id)"><i class="fa fa-trash"></i></a></td>
                                    -->
                                  </tr>
                                </tbody>
                              </table>
                            </div><!--/table-wrapper-->
                          </div>
                        </div>

                            <div class="row" ng-if="approval.radioStatus=='2'" ng-class="{ 'has-error' : approvalpendingForm.comment.$invalid && !approvalpendingForm.comment.$pristine }">
                                <div class="input-field col-sm-6">
                                    <label for="textarea">Write Comment for Rejection</label>
                                    <textarea id="textarea" rows="3"  class="form-control" name="comment" ng-model="comment" required></textarea>
                                    <input type="hidden" value="<%fetch_sub_dep.sub_dep_id%>" name="cid">
                                    <p ng-cloak ng-show="approvalpendingForm.comment.$invalid && !approvalpendingForm.comment.$pristine" class="error-msg">This field is required.</p>

                                </div>
                             <!-- <div class="col-sm-6">
                                <div class="table-wrapper table-input">
                                  <table class="striped">
                                    <thead>
                                      <tr>
                                          <th width="30%">Sub-department Name</th>
                                          <th>Comment</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr ng-repeat="data in fetch_sub_dep">
                                        <td><%data.sub_dep_name%></td>
                                        <td>
                                            <input type="text" id="" class="form-control" name="comment[]" ng-model="comment" placeholder="Write Comment">
                                          <input type="hidden" value="<%data.sub_dep_id%>" name="cid[]">

                                        </td>

                                      </tr>

                                    </tbody>
                                  </table>
                                </div>
                              </div>-->
                            </div>

                            <div class="row mg-btm mg-top" ng-if="approval.radioStatus=='2'">
                              <div class="col-sm-6 " >
                              <input type="hidden" value="<?=Request::segment(3);?>" name="request_id">

                                 <button class="btn btn-animate flat blue pd-btn pull-right" type="submit" ng-disabled="approvalpendingForm.$invalid">OK</button>
                                  <div class="loading-spiner-holder" data-loading >
                                      <div class="loading-spiner">
                                          <img src="<?php echo Request::root(); ?>/protected/public/images/Twirl.gif" />
                                      </div>
                                  </div>
                              </div>
                            </div>
                            <div class="row mg-btm mg-top" ng-if="approval.radioStatus=='1'">

                              <div class="col-sm-6 ">
                              <input type="hidden" value="<?=Request::segment(3);?>" name="request_id">
                                  <button class="btn btn-animate flat blue pd-btn pull-right" type="submit" value="OK" data-after-submit-value="Saving&hellip;"/>OK</button>

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

