
<?php require app_path().'/views/header.php'; ?>
  <div class="main-wrapper">
    <div class="container">

              <div class="row two-col-row mg-bottom-0">
                
                <div class="col s12">

                    <div class="row">
                      <div class="col s12">
                        <div class="page-heading">
                          <h1>Summary Sheet</h1>
                        </div><!--/page-heading-->    
                      </div>
                    </div>

                  <div class="content-wrapper">

                    <div class="row mg-bottom-0">
                        <?php if($user_type==1){?>
                      <div class="col s6">
                        <div class="action-group pd-top">
                         <button name="action" type="submit" class="btn waves-effect waves-light">Remove Selected</button>
                         <button name="action" type="submit" class="btn waves-effect waves-light">Remove All</button>
                        </div>
                      </div>
                        <?php }?>
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
                                <tr>
                                     <?php if($user_type==1){?>
                                    <th width="40" class="center-align"><input type="checkbox" class="default" /></th>
                                     <?php }?>
                                    <th width="50">Sr. No.</th>
                                    <th width="100">CM No.</th>
                                    <th width="150">Change req. date</th>
                                    <th width="350">Description of Change</th>
                                    <th width="200">Customer......</th>
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
                                <tr>
                                <?php if($user_type==1){?>
                                    <td class="center-align"><input type="checkbox" class="default" /></td>
                                  <?php }?> 
                                    
                                    <td>1.</td>
                                  <td>DCM/2015/1</td>
                                  <td>15.01.2015</td>
                                  <td>ID Changed</td>
                                  <td>M&M</td>
                                  <td>Nilesh</td>
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
                                <tr>
                                     <?php if($user_type==1){?>
                                  <td class="center-align"><input type="checkbox" class="default" /></td>
                                  <?php }?> 
                                  <td>2.</td>
                                  <td>SCM/2015/1</td>
                                  <td>20.02.2015</td>
                                  <td>"ABC Supplier" Location Change</td>
                                  <td>Nissan</td>
                                  <td>Arko</td>
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
              </div><!--/row-->
            
      </div><!--/container-->
  </div><!--/main-wrapper-->
  <?php require app_path().'/views/footer.php'; ?>
