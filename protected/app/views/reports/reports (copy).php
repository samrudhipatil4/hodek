<?php require app_path().'/views/header.php'; ?>
  <div class="main-wrapper">
    <div class="container">

              <div class="row two-col-row mg-bottom-0" ng-controller="ReportCtrl">
                  
                   <div ng-show="search_summery">
                <div class="col-sm-2">
                  <!-- Sidebar Comes here! -->
					
		<?php require app_path().'/views/sidebar.php'; ?>
					
					<!-- sidebar ends here -->
                </div><!--/s2-->
                <div class="col-sm-10" >
                 
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="page-heading">
                          <h1>Reports</h1>
                        </div><!--/page-heading-->    
                      </div>
                    </div>

                  <div class="content-wrapper">
                    
                    <div class="row mg-btm">
                      <div class="col-sm-12">
                        <div class="page-heading">
                          <h2>To View Reports, Please Fill up following Data</h2>
                        </div><!--/page-heading-->    
                      </div>
                    </div>
                    
                    <div class="form-wrapper" >
                        <div class="row mg-bottom-0">
                          <form method="post" id="requestForm"  role="form" class="col-sm-12 myform" ng-class="{'submitted': submitted}" name="requestForm" novalidate ng-submit="(submitted = true) && requestForm.$invalid && $event.preventDefault()" autocomplete="off">


                              <div class="row mg-btm">
                                  <div class="input-field col-sm-6">
                                      <label for="changeType">Select Report Type</label>
                                      <select class="form-control " id="report_type" ng-model="search.report_type" name="report_type" ng-change="select_report_type(search.report_type)" required>


                                          <option ng-repeat="report in reports" value="<%report.id%>"><%report.report_name%></option>


                                      </select>

                                      <span ng-cloak class="error-msg " ng-show="(requestForm.report_type.$dirty || invalidSubmitAttempt) && requestForm.report_type.$error.required"> This field is required.</span>

                                  </div>
                              </div>
                            
                            <div class="row mg-btm ">
                              <div class="col-sm-6 page-heading">
                                <h2 class="field-label">Selection Criteria</h2>
                              </div>  
                            </div>

                              <div class="row mg-btm" ng-if="Depts">
                                  <div class="input-field col-sm-6">
                                      <label for="department">Select Department</label>
                                      <select class="form-control " id="changeType" ng-model="search.d_id" name="d_id"  required>

                                          <option ng-repeat="department in dep" value="<%department.d_id%>"><%department.d_name%></option>

                                      </select>

                                      <span ng-cloak class="error-msg " ng-show="(requestForm.d_id.$dirty || invalidSubmitAttempt) && requestForm.d_id.$error.required"> This field is required.</span>

                                  </div>


                              </div>

                             <!-- <div class="row mg-btm" >
                                  <div class="input-field col-sm-3 " ng-if="years">
                                      <label for="year">Select Year</label>
                                      <span year-drop offset="0" range="20" ng-model="search.year" name="year" class="form-control " required></span>
                                      <span ng-cloak class="error-msg " ng-show="(requestForm.year.$dirty || invalidSubmitAttempt) && requestForm.year.$error.required"> This field is required.</span>



                                  </div>
                                  <div class="input-field col-sm-3" ng-if="Months">
                                      <label for="month ">Select Month</label>
                                      <select class="form-control " id="changeType" ng-model="search.month" name="month"  required>

                                          <option ng-repeat="y in months" value="<% y.id %>"><% y.name %></option>

                                      </select>

                                      <span ng-cloak class="error-msg " ng-show="(requestForm.month.$dirty || invalidSubmitAttempt) && requestForm.month.$error.required"> This field is required.</span>

                                  </div>


                              </div>-->
                              <div class="row mg-btm" ng-show="years">


                                  <div class="col-md-3 date-bg" ng-controller="DatepickerDemoCtrl">
                                      <label for="startdate" class="control-label">Target Date</label>
                                      <p class="input-group">
                                          <input type="date" class="form-control datepicker-popup" uib-datepicker-popup  ng-model="search.currentTime1" name="currentTime1" is-open="status.opened" min-date="minDate" max-date="maxDate" datepicker-options="dateOptions" date-disabled="disabled(date, mode)" ng-required="true" close-text="Close" />
                                      <span class="input-group-btn">
                                        <button type="button" class="btn btn-default btn-cal" ng-click="open($event)"><span class="glyphicon glyphicon-calendar"></span></button>
                                      </span>
                                      </p>
                                      <input type="hidden"  id="currentTime" name="startdate"  value="<%search.currentTime1| date:'dd/MM/yyyy'%>">
                                      <span ng-cloak="" class="error-msg " ng-show="(requestForm.currentTime1.$dirty || invalidSubmitAttempt) && requestForm.currentTime1.$error.required"> Target Date is required.</span>
                                      <span ng-cloak="" class="error-msg " ng-show="(requestForm.currentTime1.$dirty || invalidSubmitAttempt) && requestForm.currentTime1.$error.valid"> From Date Must Before End Date.</span>

                                  </div>

                              </div>

                                <div class="row mg-btm" ng-if="Customer">
                                    <div class="input-field col-sm-6" >
                                        <label for="design">Select Customer Name</label>
                                        <select class="form-control" id="design"  ng-model="search.customer_id1" name="customer_id1" required >
                                            <option ng-repeat="customer in customers" value="<%customer.CustomerId%>"><%customer.FirstName%> <%customer.LastName%></option>

                                        </select>


                                        <span ng-cloak class="error-msg " ng-show="(requestForm.customer_id1.$dirty || invalidSubmitAttempt) && requestForm.customer_id1.$error.required"> This field is required.</span>

                                    </div>

                            
                            </div>

                              <div class="row mg-btm" ng-if="stcm1">
                                  <div class="input-field col-sm-6" >
                                      <label for="comittee">Select Steering Committee Member</label>
                                      <select class="form-control" id="design"  ng-model="search.stcm" name="stcm" required >
                                          <option ng-repeat="customer in customers" value="<%customer.CustomerId%>"><%customer.FirstName%></option>

                                      </select>


                                      <span ng-cloak class="error-msg " ng-show="(requestForm.stcm.$dirty || invalidSubmitAttempt) && requestForm.stcm.$error.required"> This field is required.</span>

                                  </div>

                              </div>



                            <div class="row mg-btm" ng-if="radio">
                              <div class="col-sm-6">                               
                                <p class="radio-label">Status</p>                               
                                <div class="row ">
                                  <div class="col-sm-3 ">
                                    <p>
                                        <input class="with-gap" ng-model="search.status" name="status" type="radio" id="radio-1"  value="1" />
                                        <label for="radio-1">Accept</label>  
                                    </p>
                                  </div>
                                  <div class="col-sm-3">
                                    <p>
                                        <input class="with-gap" ng-model="search.status" name="status" type="radio" id="radio-2" value="2"/>
                                        <label for="radio-2">Reject</label>  
                                    </p>
                                  </div>                                    
                                </div>
                              </div>
                            </div>

                            

                            <div class="row">
                              <div class="col-sm-12">
                                <button class="btn btn-animate flat blue pd-btn" type="submit" name="action" ng-click="Dosearch(requestForm)">View Report</button>
                                  <div class="loading-spiner-holder" data-loading ><div class="loading-spiner"><img src="<?php echo Request::root(); ?>/protected/public/images/Twirl.gif" /></div></div>


                              </div>
                            </div>

                            

                          </form>
                        </div><!--/row-->
                    </div><!--/form-wrapper-->

                      <script type="text/ng-template" id="ReportContent.html">



                          <div class="modal-header">
                              <button class="btn btn-animate flat blue pd-btn pull-right" type="button" ng-click="cancel()">X</button>
                              <h3 class="modal-title"><%header%></h3>




                          </div>
                          <div class="modal-body">

                              <div class="row mg-btm report-wrapper">
                                  <div class="col-sm-4 ">
                                      <div class="bdr-box width-box">
                                          <table class="table table-bordered table-striped">
                                              <thead>
                                              <tr>
                                              <th style="width:150px;"><strong></strong></th>
                                              <th><strong>> 1 Week</strong></th>
                                              <th><strong>> 1 Month</strong></th>
                                              <th><strong>> 2 Months</strong></th>
                                              <th><strong>> 3 Months</strong></th>
                                              </tr>
                                              </thead>
                                              <tbody>
                                              <tr class="mg-top">
                                                  <td>

                                          <ul class="pd-none " >
                                              <li ng-repeat="label in labels"><%label%></li>
                                          </ul>
                                                      </td>
                                                  <td style="text-align: right;">

                                          <ul class="pd-none " >

                                              <li ng-repeat="v1 in cdata1 track by $index"><%v1%></li>
                                          </ul>
                                                  </td>
                                                  <td style="text-align: right;">

                                                  <ul class="pd-none ">
                                              <li ng-repeat="v2 in cdata2 track by $index"><%v2%></li>

                                          </ul>
                                                  </td>
                                                  <td style="text-align: right;">

                                                  <ul class="pd-none ">
                                              <li ng-repeat="v3 in cdata3 track by $index"><%v3%></li>
                                          </ul>
                                                  </td>
                                                  <td style="text-align: right;">

                                                  <ul class="pd-none ">
                                              <li ng-repeat="v4 in cdata4 track by $index"><%v4%></li>
                                          </ul>
                                                  </td>

                                              </tr>
                                              </tbody>

                                          </table>
                                      </div>
                                  </div>
                                  <div class="page-heading">

                                      <div class="col-sm-8 bdr-box">
                                          <div class="row">
                                              <div class="col-sm-6">
                                                  <div class="page-heading">
                                                      <h1>Pending >2 Weeks after Target Date</h1>
                                                      <div  class="bar-wrapper">
                                                          <canvas id="bar" class="chart chart-bar"  chart-data="data1" chart-labels="labels"></canvas>
                                                      </div><!--/chart-ctrl-->
                                                  </div>
                                              </div>
                                              <div class="col-sm-6">
                                                  <div class="shadow-none">
                                                      <div class="page-heading">
                                                          <h1>Pending >1 Month after Target Date</h1>
                                                          <div  class="bar-wrapper">
                                                              <canvas id="bar" class="chart chart-bar"  chart-data="data2" chart-labels="labels"></canvas>
                                                          </div><!--/chart-ctrl-->
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>

                                          <div class="row">
                                              <div class="col-sm-6">
                                                  <div class="page-heading">
                                                      <h1>Pending >2 Months after Target Date</h1>
                                                      <div  class="bar-wrapper">
                                                          <canvas id="bar" class="chart chart-bar"  chart-data="data3" chart-labels="labels"></canvas>
                                                      </div><!--/chart-ctrl-->
                                                  </div>
                                              </div>
                                              <div class="col-sm-6">
                                                  <div class="shadow-none">
                                                      <div class="page-heading">
                                                          <h1>Pending >3 Months after Target Date</h1>
                                                          <div  class="bar-wrapper">
                                                              <canvas id="bar" class="chart chart-bar"  chart-data="data4" chart-labels="labels"></canvas>
                                                          </div><!--/chart-ctrl-->
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div><!--/container-->



                          </div>

                          <div class="modal-footer">
                              <!--<button class="btn btn-primary" type="button" ng-click="ok()">Close</button>-->
                             <button class="btn btn-animate flat blue pd-btn" type="button" ng-click="cancel()">X</button>
                          </div>
                      </script>
                    
                  </div>
                    
                 </div>
                  </div>

                  </div><!--/content-wrapper-->
                </div><!--/s10-->
              </div><!--/row-->
            
      </div><!--/container-->
  </div><!--/main-wrapper-->

 <?php require app_path().'/views/footer.php'; ?>
  </body>
</html>