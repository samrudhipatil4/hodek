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
                          <h1>Customer Communication Decision</h1>
                        </div><!--/page-heading-->    
                      </div>
                    </div>

                  <div class="content-wrapper" ng-controller="customerComDecisionCtrl"  ng-init="get_info('<?php echo Request::segment(3); ?>',<?=Session::get('uid');?>)">

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
                     <div ng-controller="customerComDecisionCtrl1" ng-init="get_cust_data(<?=Request::segment(3);?>)">

                         <form method="post" role="form"  ng-class="{'submitted': submitted}" name="requestList" novalidate ng-submit="(submitted = true) && requestList.$invalid && $event.preventDefault()" autocomplete="off">

                         <div class="row mg-btm" >

                            <div class="input-field col-sm-6">
                                  <label for="change">Select Customer to be Communicated</label>
                                  <select class="form-control" ng-model="request.description" name="description" required>
                                      <option ng-repeat="customer in customers" value="<%customer.CustomerId%>"><%customer.FirstName%> <%customer.LastName%></option>
                                  </select>


                                  <span class="error-msg " ng-show="(requestList.description.$dirty || invalidSubmitAttempt) && requestList.description.$error.required"> This field is required.</span>

                              </div>



                            <div class="input-field col-sm-2 mg-top-23">
                              <a class="btn btn-animate flat blue pd-btn"" ng-click="AddRecord(requestList,request,'<?=Request::segment(3);?>')">Add Record</a>
                            </div>

                        </div>

                         </form>



                        <div class="row" ng-show="visibleTable">
                          <div class="col-sm-6">
                            <div class="table-wrapper">
                              <table class="striped">
                                <thead>
                                  <tr>
                                      <th width="10%">Sr. No.</th>
                                      <th>Customer Name</th>
                                   
                                      <th width="20%">Delete Record</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr ng-repeat="customer in lists">
                                    <td><%$index+1%>.</td>
                                    <td><%customer.FirstName%> <%customer.LastName%></td>
                                  
                                    <td>
                                      <table class="actions">
                                        <tr>

                                          <td style="text-align:center;"><a href="javascript:void(0)" ng-click="DelRecord($index,customer.id,<?=Request::segment(3);?>)"><i class="fa fa-trash-o"></i></a>
                                          </td>
                                        </tr>
                                      </table>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </div><!--/table-wrapper-->
                          </div>
                        </div>

                     
                    </div>



                        <div class="mg-top"  ng-controller="customerComDecision" ng-init="get_cust_data(<?=Request::segment(3);?>)">


                            <form method="post" role="form"  ng-class="{'submitted': submitted}" name="requestForm" novalidate ng-submit="(submitted = true) && requestForm.$invalid && $event.preventDefault()" autocomplete="off">


                                <div class="row mg-btm">
                                    <div class="col-sm-3">
                                        <label class="radio-label inline-lbl-radio pd-none">Select Your Decision</label>
                                    </div>
                                    <div class="col-sm-1 pd-none mg-top-15">

                                            <input class="with-gap" name="group1" type="radio" id="Yes" value="1" ng-model="request.decision" />
                                            <label for="Yes">Yes</label>

                                    </div>
                                    <div class="col-sm-1 pd-none mg-top-15">

                                            <input class="with-gap" name="group1" type="radio" id="No" value="0" ng-model="request.decision"/>
                                            <label for="No">No</label>

                                    </div>
                                </div>


                        <div class="row" ng-if="request.decision==1">
                          <div class="col-sm-9 ">
                            <div class="row ">

                                <div class=" mg-bottom-0">
                                    <div class="col-sm-9">
                                        <p class="radio-label inline-lbl">Please Select Responsible person to get Customer Approval</p>
                                    </div>
                                </div>

                              <div class="input-field col-sm-4 ">
                                  <label for="change">Select Function</label>
                                  <select class="form-control " ng-model="request.dep_id" name="dep_id" ng-change="fill_sub_department(request.dep_id)" required>

                                      <option ng-repeat="department in departments" value="<%department.d_id%>"><%department.d_name%></option>

                                  </select>


                                  <span class="error-msg " ng-show="(requestForm.dep_id.$dirty || invalidSubmitAttempt) && requestForm.dep_id.$error.required"> This field is required.</span>

                              </div>
                              <div class="input-field col-sm-4 " ng-if="sub_departments.length">
                                  <label for="change">Select Sub-function</label>
                                  <select class="form-control " ng-model="request.sub_dep_id" name="sub_dep_id" ng-change="fill_user(request.sub_dep_id)">

                                      <option ng-repeat="d in sub_departments" value="<%d.sub_dep_id%>"><%d.sub_dep_name%></option>
                                  </select>


                              </div>

                              <div class="input-field col-sm-4 mg-btm">
                                  <label for="change">Select Responsible Person</label>
                                  <select class="form-control" id="change" ng-model="request.user_ids" name="user_ids" required>

                                      <option ng-repeat="user in users" value="<%user.id%>"><%user.first_name%> <%user.last_name%></option>
                                  </select>

                                  <span class="error-msg " ng-show="(requestForm.user_ids.$dirty || invalidSubmitAttempt) && requestForm.user_ids.$error.required"> This field is required.</span>

                              </div>
                              
                            </div>
                          </div>
                            <div class="mg-top">
                                <div class="col-sm-12">
                                    <button class="btn btn-animate flat blue pd-btn" type="submit" ng-disabled="isDisabled" name="action" ng-click="addRequest(requestForm,<?=Request::segment(3);?>,<?=Request::segment(4);?>)">Send Mail</button>
                                    <div class="loading-spiner-holder" data-loading >
                                        <div class="loading-spiner">
                                            <img src="<?php echo Request::root(); ?>/protected/public/images/Twirl.gif" />
                                        </div>
                                    </div>
                                </div>
                            </div>



                        </div>

                                <div class="row mg-top" ng-if="request.decision==0">
                                    <div class="col-sm-6 mg-btm">
                                        <div class="table-wrapper">
                                            <table class="striped">
                                                <thead>
                                                <tr>
                                                    <th width="10%">Sr. No.</th>
                                                    <th>Function Name</th>
                                                    <th>Team Member</th>

                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr ng-repeat="record in availableOptions" ng-class="{'success' : records[$index]}">
                                                    <td><%$index+1%>.</td>
                                                    <td><%record.d_name%></td>
                                                    <td><%record.first_name%> <%record.last_name%></td>


                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>


                                    </div>
                                    <div class="col-sm-12">
                                        <button class="btn btn-animate flat blue pd-btn" type="submit" ng-disabled="isDisabled" name="action" ng-click="addRequest_dno(requestForm,<?=Request::segment(3);?>,<?=Request::segment(4);?>)">Send Mail</button>
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

                     </div><!--/form-warpper-->


                  </div><!--/content-wrapper-->
                </div><!--/s10-->
              </div><!--/row-->
            
      </div><!--/container-->
  </div><!--/main-wrapper-->
<?php require app_path().'/views/footer.php'; ?>
