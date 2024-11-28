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

                  <div class="content-wrapper">

                    <div class="status-bar">
                      <div class="row mg-bottom-0">
                        <div class="col-sm-6">
                          <ul class="pd-none">
                           <li> <strong>Task Record CM Number :</strong></li>
                          </ul>
                        </div>
                        <div class="col-sm-6">
                          <ul class="right">
                           <li> <strong>Current State :</strong> Approval of Risk Assessement</li>
                          </ul>
                        </div>
                      </div>
                    </div><!--/status-bar-->


                    <div class="form-wrapper" ng-controller="CtrlNewChangeRequest">
                        <div class="row mg-bottom-0">
                          <form class="col-sm-12">

                            <div class="row">
                              <div class="col-sm-12">
                                <p>Please Select an Operation and click on "OK" button.</p>
                              </div>
                            </div>

                            <div class="row mg-bottom-0">
                                <div class="col-sm-6">
                                    <p>
                                        <input class="with-gap"  type="radio" id="approve" name="radioStatus" ng-model="radioStatus" value="approve" checked />
                                        <label for="approve">Approve</label>
                                    </p>
                                    <p class="size-12 color-grey mg-none">Mail to all Steering Committee after approval of all function risk Assessment</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <p>
                                        <input class="with-gap" type="radio" id="reject" name="radioStatus" ng-model="radioStatus" value="reject"/>
                                        <label for="reject">Reject</label>
                                    </p>
                                    <p class="size-12 color-grey mg-none">If rejected then comments should be provided & same should be return for correction at respective function employee</p>
                                </div>
                            </div>
                            </div>

                            <div class="row" ng-show="radioStatus=='approve'">
                               <div class="input-field col-sm-3 selectbox" >
                                  <select class="browser-default" id="sub-dept">
                                    <option value="" disabled selected>Sub-department Name</option>
                                    <option value="1">Option 1</option>
                                    <option value="2">Option 2</option>
                                    <option value="3">Option 3</option>
                                  </select>
                                  <span class="icon-arrow"><i class="fa fa-chevron-down"></i></span>
                                  <label for="sub-dept">Select Sub-department Name</label>
                              </div>
                              <div class="input-field col-sm-3 selectbox" >
                                  <select class="browser-default" id="username">
                                    <option value="" disabled selected>Select User Name</option>
                                    <option value="1">Option 1</option>
                                    <option value="2">Option 2</option>
                                    <option value="3">Option 3</option>
                                  </select>
                                  <span class="icon-arrow"><i class="fa fa-chevron-down"></i></span>
                                  <label for="username">Select User Name</label>
                              </div>
                            </div>

                           <!-- <div class="row" ng-show="radioStatus=='reject'">
                              <div class="input-field col-sm-6">
                                <textarea id="textarea" class="materialize-textarea"></textarea>
                                <label for="textarea">Write Comment for Rejection</label>
                              </div>
                            </div>  -->

                            <div class="row" ng-show="radioStatus=='reject'">
                              <div class="col-sm-6">
                                <div class="table-wrapper table-input">
                                  <table class="striped">
                                    <thead>
                                      <tr>
                                          <th width="30%">Sub-department Name</th>
                                          <th>Comment</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                        <td>Design</td>
                                        <td><input type="text" id="initiator_name" name="comment"></td>
                                      </tr>
                                      <tr>
                                        <td>Manufacturing</td>
                                        <td><input type="text" id="initiator_name" name="comment"></td>
                                      </tr>
                                      <tr>
                                        <td>Purchase</td>
                                        <td><input type="text" id="initiator_name" name="comment"></td>
                                      </tr>
                                      <tr>
                                        <td>SQA</td>
                                        <td><input type="text" id="initiator_name" name="comment"></td>
                                      </tr>
                                      <tr>
                                        <td>Production</td>
                                        <td><input type="text" id="initiator_name" name="comment"></td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div><!--/table-wrapper-->
                              </div>
                            </div>




                            <div class="row">
                              <div class="col-sm-12 btn-group">
                                <a class="btn waves-effect waves-light" href="./HOD-dashboard.html" name="action">OK</a>
                                <button class="btn waves-effect waves-light" type="button">Cancel</button>
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
