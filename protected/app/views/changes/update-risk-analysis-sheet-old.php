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

                  <div class="content-wrapper">

                    <div class="status-bar">
                      <div class="row mg-bottom-0">                                          
                        <div class="col-sm-6">
                          <ul>
                           <li> <strong>Task Record CM Number :</strong> DCM/2015/1</li>
                          </ul> 
                        </div>
                        <div class="col-sm-6">
                          <ul class="right">
                           <li> <strong>Current State :</strong> Update Risk Analysis Sheet</li>
                          </ul> 
                        </div>
                      </div>                        
                    </div><!--/status-bar-->
                    
                     <div class="form-wrapper" ng-controller="CtrlRiskAnalysis">

                      <form role="form">

                        <div class="row">
                          <div class="col-sm-12">
                            <div class="table-wrapper">
                              <table class="striped">
                                <thead>
                                  <tr>
                                      <th width="5%">Sr. No.</th>
                                      <th>Risk Assessment Points</th>
                                      <th>Applicability</th>                               
                                      <th>If No, PI specify the reason</th>
                                      <th>If Yes, PI mention the De-Risking action</th>
                                      <th>Responsibility</th>
                                      <th>Target Date</th>
                                      <th>Any Cost Involved</th>                                           
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td>1.</td>
                                    <td>lorem</td>
                                    <td>lorem</td>
                                    <td>No</td>
                                    <td>Yes</td>
                                    <td>lorem</td>
                                    <td>22/02/2015</td>
                                    <td>00.00</td>
                                  </tr>
                                  <tr>
                                    <td>2.</td>
                                    <td>lorem</td>
                                    <td>lorem</td>
                                    <td>No</td>
                                    <td>Yes</td>
                                    <td>lorem</td>
                                    <td>22/02/2015</td>
                                    <td>00.00</td>
                                  </tr>
                                  <tr>
                                    <td>3.</td>
                                    <td>lorem</td>
                                    <td>lorem</td>
                                    <td>No</td>
                                    <td>Yes</td>
                                    <td>lorem</td>
                                    <td>22/02/2015</td>
                                    <td>00.00</td>
                                  </tr>
                                  <tr>
                                    <td>4.</td>
                                    <td>lorem</td>
                                    <td>lorem</td>
                                    <td>No</td>
                                    <td>Yes</td>
                                    <td>lorem</td>
                                    <td>22/02/2015</td>
                                    <td>00.00</td>
                                  </tr>
                                  <tr>
                                    <td>5.</td>
                                    <td>lorem</td>
                                    <td>lorem</td>
                                    <td>No</td>
                                    <td>Yes</td>
                                    <td>lorem</td>
                                    <td>22/02/2015</td>
                                    <td>00.00</td>
                                  </tr>
                                  
                                  <tr ng-repeat="task in tasks">
                                    <td>{{$index+6}}.</td>
                                    <td>{{task.riskAssessment}}</td>
                                    <td>{{task.applicability}}</td>
                                    <td>{{task.no}}</td>
                                    <td>{{task.yes}}</td>
                                    <td>{{task.responsibility}}</td>
                                    <td>{{task.date}}</td>
                                    <td>{{task.cost}}</td>
                                  </tr>
                                </tbody>              
                              </table>
                            </div><!--/table-wrapper-->
                          </div>
                        </div>

                        <div class="row">                          
                            <div class="input-field col-sm-6">
                                <input id="description" type="text" class="validate" ng-model="description">
                                <label for="description">Risk Assessment Points</label>
                            </div>

                            <div class="input-field col-sm-2 inline-btn">
                              <button class="btn waves-effect waves-light" type="button" ng-click="AddRecord()">Add Record</button>
                            </div>

                        </div>
                        

                        <div class="row mg-bottom-0">
                          <div class="col-sm-9">
                            <p class="radio-label inline-lbl">Select approval authority from Department HOD Master</p>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-sm-9 pd-none">
                            <div class="row mg-none">
                              <div class="input-field col-sm-8 selectbox">
                                  <select class="browser-default" id="change">
                                    <option value="" disabled selected>Select Department</option>
                                    <option value="1">Option 1</option>
                                    <option value="2">Option 2</option>
                                    <option value="3">Option 3</option>
                                  </select>
                                  <span class="icon-arrow"><i class="fa fa-chevron-down"></i></span>
                                  <label for="change">Select Department</label>
                              </div>                              
                            </div>
                          </div>
                        </div>                        

                        <div class="row">
                              <div class="col-sm-12 btn-group">
                                <button class="btn waves-effect waves-light" type="submit" name="action">Send</button>
                                <button class="btn waves-effect waves-light " type="reset">Cancel</button>        
                              </div>
                        </div>
                      </form>
                     </div><!--/form-warpper-->                    

                  </div><!--/content-wrapper-->
                </div><!--/s10-->
              </div><!--/row-->
            
      </div><!--/container-->
  </div><!--/main-wrapper-->
<?php require app_path().'/views/footer.php'; ?>