


 <div class="summary-table report-wrapper scrollbarX">
                              
                        <table class="striped">
                              <thead>
                                <tr>
                                    
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
                                  <td><span ng-bind="job.cmNo"></span></td>

                                  <td><span ng-bind="job.created_date"></span></td>
                                  <td><span ng-bind="job.Purpose_Modification_Details "></span></td>
                                  <td>
                                      <ul class="listing">
                                          <li ng-repeat="customer in job.customers">
                                              <span ng-bind="customer.customer_name "></span>


                                          </li>


                                      </ul>

                                    </td>
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
                   