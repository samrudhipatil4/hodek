
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
                          <h1>Update risk analysis sheet</h1>
                        </div><!--/page-heading-->    
                      </div>
                    </div>

                  <div class="content-wrapper" >

                    <div class="status-bar" ng-controller="CtrlRiskAnalysis1" ng-init="get_info('<?php echo Request::segment(3); ?>')">
                      <div class="row mg-bottom-0">                                          
                        <div class="col-sm-4">
                          <ul class="pd-none">
                           <li> <strong>Task Record CM Number :</strong> <span ng-bind="cmno"></span></li>
                          </ul> 
                        </div>
                        <div class="col-sm-8">
                          <ul class="pull-right">
                           <li> <strong>Current State :</strong> <span ng-bind="assignedtaskstome.status"></li>
                          </ul> 
                        </div>
                      </div>                        
                    </div><!--/status-bar-->
                    
                     <div class="form-wrapper" >

                        <div ng-controller="CtrlRiskAnalysis" ng-init="fetch('<?php echo Request::segment(3); ?>')">
                        <div class="row mg-btm" >
                          <div class="col-sm-12">
                            <div class="table-wrapper">
                              <table class="striped">
                                <thead>
                                  <tr>
                                      <th width="5%">Sr. No.</th>
                                      <th width="25%">Risk Assessment Points</th>
                                      <th>Applicability</th>            
                                      <th width="25%">Reason</th>
                                      <th width="25%">De-Risking Action</th>
                                      <!--<th>Responsibility</th>-->
                                      <th>Target Date</th>
                                      <th>Any Cost Involved</th>
                                      <th>Status</th>
                                      <th>Action</th>                                          
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr ng-repeat="task in tasks" ng-class="{'success' : tasks[$index]}">
                                    <td><%$index+1%>.</td>
                                    <td><%task.assessment_point_department%></td>
                                    <td><%task.applicability | Applicability%></td>
                                    <td><%task.reason%></td>
                                      <td><%task.de_risking%></td>
                                   <!-- <td><%task.responsibility%></td>-->
                                    <td><%task.target_date| date:'dd.MM.yyyy'%></td>
                                    <td><%task.cost%></td>
                                      <td><%task.status | statusfilter%></td>
                                     

                                    <td >
                                      <table cellpadding="0" cellspacing="0">
                                        
                                        <!--<tr class="border-none" ng-if="task.request_id!='0'"> -->
                                        <tr class="border-none"> 
                                          <td style="border:0px !important; font-size:16px;"><a href="javascript:void(0)" ng-click="EditRecord($index,task.risk_assessment_id)" class="" data-position="bottom" data-delay="50" data-tooltip="Edit"><i class="fa fa-check"></i></a></td>
                                        <!--  <td style="border:0px !important; font-size:16px;"><a href="javascript:void(0)" class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="Delete Record" ng-click="DelRecord($index,task.risk_assessment_id)"><i class="fa fa-trash"></i></a></td>-->
                                        </tr>
                                        
                                      </table>
                                    </td>
                                  </tr>
                                  
                                </tbody>              
                              </table>
                            </div><!--/table-wrapper-->
                          </div>
                        </div>

                        <div class="row ">
                              <div class="col-sm-12">
                               <!-- <button class="btn  btn-animate flat blue pd-btn pull-right" ng-disabled="isDisabled" type="submit" name="action" ng-click="btnToggle()"><span ng-bind="btnLabel"></span></button>-->
                              </div>
                        </div>

                      

                   <div class="add-record" ng-if="newReocord1">
                       <div >

                       <form method="post" role="form" ng-class="{'submitted': submitted}" name="updateform" novalidate ng-submit="(submitted = true) && updateform.$invalid && $event.preventDefault()" autocomplete="off">
                        <div>



                        <div class="row mg-btm">
                          <div class="input-field col-sm-6">
                              <label for="description">Risk Assessment Points: </label> <span><%risks.assessment_point_department%></span>

                          </div>

                                           
                        </div>

                        <div class="row mg-btm">
                           <div class="col-sm-3">
                            <p class="radio-label inline-lbl-radio pd-none" style="font-size:1em;">Applicability</p>
                            </div>
                            <div class="col-sm-1 pd-none">
                              <p>
                              <input class="with-gap" name="group1" type="radio" id="Yes" value="1" ng-model="risks.applicability" />
                              <label for="Yes">Yes</label>  
                              </p>
                            </div>
                            <div class="col-sm-1 pd-none">
                              <p>
                              <input class="with-gap" name="group1" type="radio" id="No" value="2" ng-model="risks.applicability"/>
                              <label for="No">No</label>  
                              </p>
                            </div>
                        </div>

                        <div class="row" ng-if="risks.applicability == '2'">
                          <div class="input-field col-sm-6 mg-btm">
                              <label for="textarea1">Specify The Reason</label>
                            <textarea id="textarea1" class="form-control mg-top" rows="2" ng-model="risks.reason" name="reason" required></textarea>
                              <span ng-cloak class="error-msg " ng-show="(updateform.reason.$dirty || invalidSubmitAttempt) && updateform.reason.$error.required"> This field is required.</span>

                          </div>
                        </div>

                        
                      
                      <div ng-if="risks.applicability == '1'">

                        <div class="row">
                          <div class="input-field col-sm-6 mg-btm">
                              <label for="textarea1">Specify De-Risking Action</label>
                            <textarea id="textarea1" class="form-control mg-top" rows="2" ng-model="risks.de_risking" name="de_risking" required></textarea>
                              <span ng-cloak class="error-msg " ng-show="(updateform.de_risking.$dirty || invalidSubmitAttempt) && updateform.de_risking.$error.required"> This field is required.</span>


                          </div>
                        </div>

                        <div class="row mg-bottom-15">
                          <div class="col-sm-6">

                            <div class="row mg-bottom-0">


                                    <div class="input-field col-sm-4">
                                        <label for="cost" class="">Target Date</label>

                                        <input type="text" name="target_date"  readonly data-date-format="dd.mm.yyyy" ng-model="risks.target_date" jqdatepicker required/>
                                        <span class="glyphicon glyphicon-calendar icon_cal"></span>

                                        </label>
                                        <span class="error-msg " ng-show="(updateform.target_date.$dirty || invalidSubmitAttempt) && updateform.target_date.$error.required"> This field is required.</span>

                                    </div>


                              <div class="input-field col-sm-4">
                                  <label for="cost" class="">Cost Involved</label>
                                <input id="cost" type="text" class="form-control" ng-model="risks.cost" name="cost" required ng-pattern="/^(\d)+$/">
                                <!--  <span ng-cloak class="error-msg " ng-show="(updateform.cost.$dirty || invalidSubmitAttempt) && updateform.cost.$error.required"> This field is required.</span>-->
                                  <span ng-cloak class="error-msg " ng-show="(updateform.cost.$dirty || invalidSubmitAttempt) && updateform.cost.$error.required"> This field is required.</span>
                                  <span ng-cloak class="error-msg " ng-show="(updateform.cost.$dirty || invalidSubmitAttempt) && updateform.cost.$error.pattern"> Current Cost is Invalid.</span>


                              </div>
                            </div>

                          </div>
                        </div>
                      </div>

                      <div class="row mg-top mg-btm">
                          <div class="col-sm-12 ">
                                <button class="btn btn-animate flat blue pd-btn" type="submit" ng-disabled="isDisabled1" name="action" ng-click="UpdateRecord(updateform,risks.risk_assessment_id,<?=Request::segment(3);?>)">Save</button>
                                <button class="btn btn-animate flat blue pd-btn" type="submit" ng-disabled="isDisabled12" name="action" ng-click="cancel(updateform)">Cancel</button>

                          </div>
                      </div>
                           </div>

                         </form>
                           </div>
                   </div><!--/add-record-->

                    </div>








                     <div ng-controller="CtrlRiskAnalysisAll">


                         <form method="post" role="form" ng-class="{'submitted': submitted}" name="updaterisksheet" novalidate ng-submit="(submitted = true) && updaterisksheet.$invalid && $event.preventDefault()" autocomplete="off">

                        <div>
                         <div class="row">
                          <div class="col-sm-12">
                            <div class="page-heading">

                            </div><!--/page-heading-->
                          </div>
                      </div>


                            <div class="row mg-btm">
                                <div class="input-field col-sm-6">
                                    <label for="approval">Approval Authority from Department HOD: </label> <span><%hod.first_name%></span> <span><%hod.last_name%></span>
                                    <input type="hidden"  name="Approval_Authority" id="Approval_Authority" value="<%hod.id%>" >

                                </div>

                            </div>

                   <!--     <div class="row">
                          <div class="col-sm-12 pd-none">

                              <div class="input-field col-sm-6 ">
                                  <label for="approval">Select Approval Authority from Department HOD</label>
                                  <select class="form-control" id="approval" ng-model="risk.Approval_Authority" name="Approval_Authority" required>

                                      <option ng-repeat="d in deps" value="<%d.id%>"><%d.first_name%> <%d.last_name%></option>

                                  </select>



                                  <span class="error-msg " ng-show="(updaterisksheet.Approval_Authority.$dirty || invalidSubmitAttempt) && updaterisksheet.Approval_Authority.$error.required"> This field is required.</span>

                              </div>                              

                          </div>
                        </div>          -->

                        <div class="row mg-top">
                              <div class="col-sm-12 ">
                                <button class="btn btn-animate flat blue pd-btn" type="submit" ng-disabled="isDisabled" name="action" ng-click="update_risk_sheet(updaterisksheet,<?=Request::segment(3);?>,<?=Request::segment(4);?>)">Send</button>
                                  <div class="loading-spiner-holder" data-loading >
                                      <div class="loading-spiner">
                                          <img src="<?php echo Request::root(); ?>/protected/public/images/Twirl.gif" />
                                      </div>
                                  </div>
                              </div>
                        </div>
                            <div>
                      </form>
                            </div>
                         </div>
                     </div><!--/form-warpper-->                    

                  </div><!--/content-wrapper-->
                </div><!--/s10-->
              </div><!--/row-->
            
      </div><!--/container-->
  </div><!--/main-wrapper-->
<?php require app_path().'/views/footer.php'; ?>
 