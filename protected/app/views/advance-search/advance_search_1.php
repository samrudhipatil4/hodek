<style>
    .btn-back {
        color: #34B0E6 !important;
        cursor: pointer;
        font-weight: 400;
    }
    .btn-back:hover { color: #282828 !important;}
</style>
<?php require app_path().'/views/header.php'; ?>
 
  <div class="main-wrapper">
    <div class="container">

              <div class="row two-col-row mg-bottom-0" ng-controller="AdvancedsearchCtrl">
                  
                  <div ng-show="search_summery">
         <div class="col s2">
              
                     <!-- Sidebar Comes here! -->
          
          <?php require app_path().'/views/sidebar.php'; ?>
          
          <!-- sidebar ends here -->
                </div><!--/s2-->
                <div class="col s10">

                    <div class="row">
                      <div class="col s12">
                        <div class="page-heading">
                          <h1>Advanced Search Option</h1>
                        </div><!--/page-heading-->    
                      </div>
                    </div>

                  <div class="content-wrapper">
                    
                    <div class="row">
                      <div class="col s12">
                        <div class="page-heading">
                          <h2>To View Summary Sheets, Please Fill up following Data</h2>
                        </div><!--/page-heading-->    
                      </div>
                    </div>
                    
                    <div class="form-wrapper" >
                        <div class="row mg-bottom-0">
                            <div class="loading-spiner-holder" data-loading ><div class="loading-spiner"><img src="<?php echo Request::root(); ?>/protected/public/images/Twirl.gif" /></div></div>
                           <form method="post" role="form" class="col s12 myform" ng-class="{'submitted': submitted}" name="requestForm" novalidate ng-submit="(submitted = true) && requestForm.$invalid && $event.preventDefault()" autocomplete="off">
                             <div class="row">
                              <div class="input-field col s3 datepicker" >
                                <label for="inputCreated">From Date</label>
                                 <input input-date
                                    type="text"
                                    name="startdate"
                                    id="inputCreated"
                                    required
                                    ng-model="search.startdate"
                                    container="body"
                                    format="dd/mm/yyyy"
                                    months-full="<%month%>"
                                    months-short="<%monthShort%>"
                                    weekdays-full="<%weekdaysFull%>"
                                    weekdays-short="<%weekdaysShort%>"
                                    weekdays-letter="<%weekdaysLetter%>"
                                    disable="disable"
                                    min="<%minDate %>"
                                    max="<%maxDate%>"
                                    today="today"
                                    clear="clear"
                                    close="close"
                                    select-years="15"
                                    on-start="onStart()"
                                    on-render="onRender()"
                                    on-open="onOpen()"
                                    on-close="onClose()"
                                    on-set="onSet()"
                                    on-stop="onStop()" />
                                    <span class="icon-calendar"><i class="fa fa-calendar"></i></span>
                                    <span class="error-msg " ng-show="(requestForm.startdate.$dirty || invalidSubmitAttempt) && requestForm.startdate.$error.required"> From Date is required.</span>
                                    <span class="error-msg " ng-show="(requestForm.startdate.$dirty || invalidSubmitAttempt) && requestForm.startdate.$error.valid"> From Date Must Before End Date.</span>
                              
                              </div>

                              <div class="input-field col s3 datepicker" >
                                <label for="inputCreated">To Date</label>
                                <input input-date
                                    type="text"
                                    name="enddate"
                                    id="inputCreated"
                                    required=""
                                    ng-model="search.enddate"
                                    container="body"
                                    format="dd/mm/yyyy"
                                    months-full="<%month%>"
                                    months-short="<%monthShort%>"
                                    weekdays-full="<%weekdaysFull%>"
                                    weekdays-short="<%weekdaysShort%>"
                                    weekdays-letter="<%weekdaysLetter%>"
                                    disable="disable"
                                    min="<%minDate %>"
                                    max="new Date()"
                                    today="today"
                                    clear="clear"
                                    close="close"
                                    select-years="15"
                                    on-start="onStart()"
                                    on-render="onRender()"
                                    on-open="onOpen()"
                                    on-close="onClose()"
                                    on-set="onSet()"
                                    on-stop="onStop()" />
                                    <span class="icon-calendar"><i class="fa fa-calendar"></i></span>
                                    <span class="error-msg " ng-show="(requestForm.enddate.$dirty || invalidSubmitAttempt) && requestForm.enddate.$error.required"> To Date is required.</span>
                                    <span class="error-msg " ng-show="(requestForm.enddate.$dirty || invalidSubmitAttempt) && requestForm.enddate.$error.valid"> End Date Must Greater Than End Date.</span>
                              </div>
                                                           
                            </div> 

                            <div class="row">
                              
                              <div class="input-field col s6 selectbox">
                                 <select class="browser-default" id="Change-Stage" name="change_stage_id" ng-model="search.change_stage_id"  > 
                                                             
                                    <option ng-repeat="data in changestage" value="<%data.change_stage_id%>"><%data.stage_name%></option>
                                   
                                  </select>
                                  <span class="icon-arrow"><i class="fa fa-chevron-down"></i></span>
                                  <label for="Change-Stage">Select Change Stage</label> 
                                  <span class="error-msg " ng-show="(requestForm.change_stage_id.$dirty || invalidSubmitAttempt) && requestForm.change_stage_id.$error.required"> Change Stage is required.</span>
                                  
                              </div>
                            </div>

                            <div class="row">
                               <div class="input-field col s6 selectbox">
                                 <select class="browser-default" id="changeType" ng-model="search.changeType" name="changeType" ng-change="fill_customer_name(request.changeType)" >
                                   
                                     <option ng-repeat="data in changetype" value="<%data.change_type_id%>"><%data.change_type_name%></option>
                                   
                                  </select>                                  
                                  <span class="icon-arrow"><i class="fa fa-chevron-down"></i></span>
                                  <label for="changeType"> Change Type</label> <%changetype.change_type_name%>
                                  <span class="error-msg " ng-show="(requestForm.changeType.$dirty || invalidSubmitAttempt) && requestForm.changeType.$error.required"> Change Request Initiation Date is required.</span>
                                  
                              </div>
                            </div>                            

                            <div class="row">
                              <div class="input-field col s6 selectbox" >
                                  <div class="multiselect-box">
                                  <label>Customer Name</label>
                                  <div class="selected-label">                                 
                                    <div ng-repeat="name in selection" class="selected-item">
                                    <%name%>
                                    </div>
                                      
                                    <span class="icon-arrow"><i class="fa fa-chevron-down"></i></span>
                                  </div>
                                  <ul>
                                    <li ng-repeat="customer in customers">
                                      <div class="action-checkbox">
                                        <input id="<%customer.CustomerId%>" type="checkbox" value="<%customer.CustomerId%>" ng-checked="selection.indexOf(customer.FirstName,customer.CustomerId) > -1" ng-click="toggleSelection(customer.FirstName,customer.CustomerId)" ng-model="search.customer_id" name="customer_id[]"  />
                                        <label for="<%customer.CustomerId%>"><% customer.FirstName %></label>
                                      </div>
                                    </li>
                                  </ul>
                                </div><!--/multiselect-box-->
                              </div>                             
                            </div>                            

                            <div class="row">
                              <div class="col s12 btn-group">                                
                                <button class="btn waves-effect waves-light" type="submit" name="action" ng-click="dosearch(requestForm,search)">Submit</button>   
                                 <button class="btn waves-effect waves-light" type="reset">Clear</button>        
                              </div>
                            </div>

                            

                          </form>
                        </div><!--/row-->
                    </div><!--/form-wrapper-->
                    

                    
                    
                  </div><!--/content-wrapper-->
                </div><!--/s10-->
              </div><!--/row-->
                <div id="summarysheet" ng-show="summery">
              <div class="col s12" >

                    <div class="row">
                      <div class="col s12">
                        <div class="page-heading">
                            <h1>Summary Sheet <span ng-click="backToSearch();" class="btn-back right">Back To Search</span></h1>
                        </div><!--/page-heading-->  
                         
                      </div>                        
                         
                      </div>
                    </div>

                  <div class="content-wrapper">

                    <div class="row mg-bottom-0">
                      <div class="col s6">
                          <?php if($user_type==1){?>
                        <div class="action-group pd-top">
                         <button name="action" type="submit" class="btn waves-effect waves-light">Remove Selected</button>
                         <button name="action" type="submit" class="btn waves-effect waves-light">Remove All</button>
                        </div>
                          <?php }?>
                      </div>
                      <div class="col s6 right">
                        <ul class="summary-status right-align mg-top-0">
                          <li>Activity Completed with required Approval & Verification <span>G</span></li>
                          <li>Within defined target date ( Work in Process )  <span>Y</span></li>
                          <li>Activity Over due <span>R</span></li>
                        </ul>
                      </div>
                    </div>
                    
                    <!-- summary Table start -->
                    <div class="summary-table report-wrapper scrollbarX">
                              
                        <table class="striped">
                              <thead>
                                <tr class="tr-bdr">
                                    
                                    <?php if($user_type==1){?>
                                    <th width="40" class="center-align"><input type="checkbox" class="default" /></th>
                                    <?php }?>
                                    
                                    
                                    <th width="50">Sr. No.</th>
                                    <th width="100">CM No.</th>
                                    <th width="150">Change req. date</th>
                                    <th width="350">Description of Change</th>
                                    <th width="200">Customer</th>
                                    <th width="200">Initiator Name</th>
                                    <th width="300" class="rotate pd-none">
                                      <table>
                                        <tr class="border-bottom">
                                          <td class="center-align">Risk Analysis</td>
                                        </tr>
                                        <tr>
                                          <td class="pd-none">
                                            <table class="borderd-cell">
                                              <tr>
                                                <td class="rotate pd"><span>Design</span></td>
                                                <td class="rotate pd"><span>Mfg. eng.</span></td>
                                                <td class="rotate pd"><span>Purchase</span></td>
                                                <td class="rotate pd"><span>SQA</span></td>
                                                <td class="rotate pd"><span>PO & System</span></td>
                                                <td class="rotate pd"><span>Logistic</span></td>
                                                <td class="rotate pd"><span>Production</span></td>
                                                <td class="rotate pd"><span>Process QA</span></td>
                                              </tr>
                                            </table>
                                          </td>
                                        </tr>
                                      </table>
                                    </th>
                                    <th width="50" class="rotate"><span>Steering Committee<br>Approval<span></th>
                                    <th width="50" class="rotate"><span>Customer Approval<br>Decision<span></th>
                                    <th width="50" class="rotate"><span>Customer Approval<br> Status<span></th>
                                    <th width="300" class="rotate pd-none">
                                      <table>
                                        <tr class="border-bottom">
                                          <td class="center-align">Activity Status</td>
                                        </tr>
                                        <tr>
                                          <td class="pd-none">
                                            <table class="borderd-cell">
                                              <tr>
                                                <td class="rotate pd"><span>Design</span></td>
                                                <td class="rotate pd"><span>Mfg. eng.</span></td>
                                                <td class="rotate pd"><span>Purchase</span></td>
                                                <td class="rotate pd"><span>SQA</span></td>
                                                <td class="rotate pd"><span>PO & System</span></td>
                                                <td class="rotate pd"><span>Logistic</span></td>
                                                <td class="rotate pd"><span>Production</span></td>
                                                <td class="rotate pd"><span>Process QA</span></td>
                                              </tr>
                                            </table>
                                          </td>
                                        </tr>
                                      </table>
                                    </th>
                                    <th width="50" class="rotate"><span>Change Implementation<br>date</span></th>
                                    <th width="50" class="rotate"><span>Before / After<br>Comprision</span></th>
                                </tr>
                              </thead>
                              <tbody>
                                  
                                     
                                  <tr ng-repeat="job in summeries">
                                   <?php if($user_type==1){?>
                                  <td class="center-align"><input type="checkbox" class="default" /></td>
                                     <?php }?>
                                  <td><span ng-bind="<% $index+1 %>"></span>.</td>
                                  <td><span my-cm-no="" type="job.change_type_name" year="job.created_date" rid="job.request_id"></span></td>
                               
                                  <td><span my-date year="job.created_date"></span></td>
                                  <td><span ng-bind="job.changerequest_purpose "></span></td>
                                  <td><span ng-bind="job.FirstName "></span></td>
                                  <td><span ng-bind="job.initiator_name"></span></td>
                                  <td class="pd-none">
                                    <table class="borderd-cell">
                                      <tr>
                                      <td class="status green">G</td>
                                      <td class="status green">G</td>
                                      <td class="status yellow">Y</td>
                                      <td class="status green">G</td>
                                      <td class="status green">G</td>
                                      <td class="status red">R</td>
                                      <td class="status green">G</td>
                                      <td class="status green">G</td>
                                      </tr>
                                    </table>
                                  </td>
                                  <td class="status green">G</td>
                                  <td class="status green">G</td>
                                  <td class="status green">G</td>
                                  <td class="pd-none">
                                    <table class="borderd-cell">
                                      <tr>
                                      <td class="status green">G</td>
                                      <td class="status green">G</td>
                                      <td class="status green">G</td>
                                      <td class="status green">G</td>
                                      <td class="status yellow">Y</td>
                                      <td class="status green">G</td>
                                      <td class="status red">R</td>
                                      <td class="status green">G</td>
                                      </tr>
                                    </table>
                                  </td>
                                  <td class="status green">G</td>
                                  <td class="status green">G</td>
                                </tr>
                               
                                </tbody>
                            </table>
                        
                    </div><!--/summary-table-->
                    
                    <!-- summary Table end -->

                  </div><!--/content-wrapper-->
                </div><!--/s10-->
 
              
                </div>
                
                </div><!--/row-->
            
      </div><!--/container-->
  </div><!--/main-wrapper-->

  
    <?php require app_path().'/views/footer.php'; ?>
