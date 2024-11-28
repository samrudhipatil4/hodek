<?php require app_path().'/views/header.php'; ?>
  <div class="main-wrapper">
    <div class="container">

              <div class="row two-col-row mg-bottom-0" ng-controller="ReportCtrl">
                  
                   <div ng-show="search_summery">
                <div class="col-sm-2" ng-show="Depts==false">
                  <!-- Sidebar Comes here! -->
					
		<?php require app_path().'/views/sidebar.php'; ?>
					
					<!-- sidebar ends here -->
                </div><!--/s2-->
                <div class="col-sm-10" ng-show="Depts==false">
                 
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
                          <h2>To View Graphical Reports, Please Fill up following Data</h2>
                        </div><!--/page-heading-->    
                      </div>
                    </div>
                    
                    <div class="form-wrapper" >
                        <div class="row mg-bottom-0">
                       <form method="post" id="requestForm"  role="form" class="col-sm-12 myform" ng-class="{'submitted': submitted}" name="requestForm" novalidate ng-submit="(submitted = true) && requestForm.$invalid && $event.preventDefault()" autocomplete="off">

                              <div class="row mg-btm">

                                  <div class="col-md-3">
                                      <div class="date-form">
                                          <div class="form-horizontal">
                                              <div class="control-group">
                                                  <label for="startdate" class="control-label">From Date</label>
                                                  <div class="controls">
                                                      <div class="input-group">
                                                          <input id="startdate" type="text" class="date-picker form-control" name="startdate"  ng-model="search.startdate" data-date-format="dd/mm/yyyy" required/>
                                                          <label for="startdate" class="input-group-addon btn"><span class="glyphicon glyphicon-calendar"></span></label>

                                                      </div>
                                                      <span ng-cloak="" class="error-msg " ng-show="(requestForm.startdate.$dirty || invalidSubmitAttempt) && requestForm.startdate.$error.required"> From Date is required.</span>
                                                      <span ng-cloak="" class="error-msg " ng-show="(requestForm.startdate.$dirty || invalidSubmitAttempt) && requestForm.startdate.$error.valid"> From Date Must Before End Date.</span>

                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>

                                  <div class="col-md-3">
                                      <div class="date-form">
                                          <div class="form-horizontal">
                                              <div class="control-group">
                                                  <label for="startdate" class="control-label">To Date</label>
                                                  <div class="controls">
                                                      <div class="input-group">
                                                          <input id="enddate" type="text" class="date-picker form-control" name="enddate"  ng-model="search.enddate" required data-date-format="dd/mm/yyyy" />
                                                          <label for="enddate" class="input-group-addon btn"><span class="glyphicon glyphicon-calendar"></span>
                                                          </label>

                                                      </div>
                                                      <span ng-cloak="" class="error-msg " ng-show="(requestForm.enddate.$dirty || invalidSubmitAttempt) && requestForm.enddate.$error.required"> To Date is required.</span>
                                                      <span ng-cloak="" class="error-msg " ng-show="(requestForm.enddate.$dirty || invalidSubmitAttempt) && requestForm.enddate.$error.valid"> End Date Must Greater Than End Date.</span>

                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>


                              </div>

                              <div class="row mg-btm">
                                  <div class="input-field col-sm-6 sel">


                                      <label>Select Change Stage</label>

                                      <select class="form-control"   ng-model="search.change_stage_id" name="change_stage_id">
                                        <option  value="? undefined:undefined ?"></option>
                                          <option ng-repeat="data in changestage" value="<%data.change_stage_id%>"><% data.stage_name %></option>

                                      </select>


                                  </div>
                              </div>

                              <div class="row mg-btm">
                                  <div class="input-field col-sm-6 sel">


                                      <label>Select Change Type</label>

                                      <select class="form-control" ng-model="search.changeType" name="changeType" >
                                      <option  value="? undefined:undefined ?"></option>
                                          <option ng-repeat="data in changetype" value="<%data.change_type_id%>"><% data.change_type_name %></option>

                                      </select>


                                  </div>
                              </div>


                              <div class="row mg-btm">
                                  <div class="input-field col-sm-6 sel">


                                      <label>Customer Name</label>

                                      <select class="form-control" ng-model="search.customer_id" name="customer_id"  >
                                        <option  value="? undefined:undefined ?"></option>
                                          <option ng-repeat="customer in customers" value="<%customer.CustomerId%>"><% customer.FirstName %> <% customer.LastName %></option>

                                      </select>


                                  </div>
                              </div>

                              <div class="row mg-btm">
                                  <div class="input-field col-sm-6">
                                      <label for="changeType">Select Report Type</label>
                                      <select class="form-control " id="report_type" ng-model="search.report_type" name="report_type" ng-change="select_report_type(search.report_type)" required>


                                          <option ng-repeat="report in reports" value="<%report.id%>"><%report.id%> - <%report.report_name%></option>


                                      </select>

                                      <span ng-cloak class="error-msg " ng-show="(requestForm.report_type.$dirty || invalidSubmitAttempt) && requestForm.report_type.$error.required"> This field is required.</span>

                                  </div>
                              </div>
   

                            <div class="row">
                              <div class="col-sm-12">
                                <button class="btn btn-animate flat blue pd-btn" type="submit" name="action" ng-click="Dosearch(requestForm,search)">View Report</button>
                                  <div class="loading-spiner-holder" data-loading >
                                      <div class="loading-spiner"><img src="<?php echo Request::root(); ?>/protected/public/images/Twirl.gif" />
                                      </div>
                                  </div>


                              </div>
                            </div>

                            

                          </form>
                        </div><!--/row-->
                    </div><!--/form-wrapper-->

                      <script type="text/ng-template" id="ReportContent.html">



                          <div class="modal-header">
                              <button class="btn btn-animate flat blue pd-btn pull-right" type="button" ng-click="cancel()">X</button>

                              <h4 class="modal-title"><%header%></h4>
                               <input type="hidden" id="apprptdata" name="apprptdata" ng-model="request.apprptdata">
                            



                          </div>
                           <a href="<?php echo Request::root().'/excelGeneration'; ?>"><button style="margin-left: 20px;" ng-click="getexcel()" class="btn btn-animate flat blue pd-btn">Export To Excel</button></a>
                          <div class="modal-body">

                              <div class="row mg-btm report-wrapper">
                                  <div class="col-sm-3 ">
                                      <div class="bdr-box width-box">
                                          <table class="table table-bordered table-striped">
                                              <thead >
                                              <tr>
                                              <th style="width:180px;"><strong></strong></th>
                                              <th><strong>> 2 Week</strong></th>
                                              <th><strong>> 1 Month</strong></th>
                                              <th><strong>> 2 Months</strong></th>
                                              <th><strong>> 3 Months</strong></th>
                                              </tr>
                                              </thead>
                                              <tbody>
                                              <tr class="mg-top">
                                                  <td>

                                          <ul class="pd-none " >
                                              <li style="width:180px" ng-repeat="label in labels"><%label%></li>
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

                                      <div class="col-sm-8">
                                          <div class="row">
                                              <div class="col-sm-4 col-width" style="width:30%!important;">
                                                  <div class="page-heading">
                                                      <h1>Pending >2 Weeks after Target Date</h1>
                                                      <div  class="bar-wrapper chart-width">
                                                          <canvas id="bar" class="chart chart-bar"  chart-data="data1" chart-labels="labels"></canvas>
                                                      </div><!--/chart-ctrl-->
                                                  </div>
                                              </div>
                                              <div class="col-sm-4 col-width" style="width:30%!important;">
                                                  <div class="shadow-none">
                                                      <div class="page-heading">
                                                          <h1>Pending >1 Month after Target Date</h1>
                                                          <div  class="bar-wrapper chart-width">
                                                              <canvas id="bar" class="chart chart-bar"  chart-data="data2" chart-labels="labels"></canvas>
                                                          </div><!--/chart-ctrl-->
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>

                                          <div class="row">
                                              <div class="col-sm-4 col-width" style="width:30%!important;">
                                                  <div class="page-heading">
                                                      <h1>Pending >2 Months after Target Date</h1>
                                                      <div  class="bar-wrapper chart-width">
                                                          <canvas id="bar" class="chart chart-bar"  chart-data="data3" chart-labels="labels"></canvas>
                                                      </div><!--/chart-ctrl-->
                                                  </div>
                                              </div>
                                              <div class="col-sm-4 col-width" style="width:30%!important;">
                                                  <div class="shadow-none">
                                                      <div class="page-heading">
                                                          <h1>Pending >3 Months after Target Date</h1>
                                                          <div  class="bar-wrapper chart-width">
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

                  </div><!--/content-wrapper-->
                </div><!--/s10-->
              </div><!--/row-->
            
      </div><!--/container-->
  </div><!--/main-wrapper-->
<div ng-show="Depts==false">
 <?php require app_path().'/views/footer.php'; ?>
    </div>
  </body>
</html>