<?php require app_path().'/views/header.php'; ?>
  <div class="main-wrapper">
    <div class="container">

              <div class="row two-col-row mg-bottom-0">

                <div class="col-sm-12">

                    <div class="row">
                      <div class="col-sm-12">
                        <div class="page-heading">
                          <h1>Customer Communication Decision</h1>
                        </div><!--/page-heading-->    
                      </div>
                    </div>

                  <div class="content-wrapper" ng-controller="customerComAttachmentsCtrl_reject" ng-init="get_cust_data(<?=Request::segment(3);?>)">

                    <div class="status-bar">
                      <div class="row mg-bottom-0">                                          
                        <div class="col-sm-6">
                          <ul class="pd-none">
                           <li> <strong>Task Record CM Number :</strong> <span ng-bind="cmno"></span></li>
                          </ul> 
                        </div>
                        <div class="col-sm-6">
                          <ul class="pull-right">
                           <li> <strong>Current State :</strong> <span ng-bind="status"></li>
                          </ul> 
                        </div>
                      </div>                        
                    </div><!--/status-bar-->
                    
                     <div class="form-wrapper" >


                        <div class="row" ng-show="visibleTable">
                          <div class="col-sm-12">
                            <div class="table-wrapper">
                              <table class="striped">
                                <thead>
                                  <tr>
                                      <th width="5%">Sr. No.</th>
                                      <th>Customer Name</th>
                                      <th width="10%">Decision</th>
                                      <th width="30%">Horizontal Deployment Status</th>
                                      <th width="30%">Attachments</th>

                                  </tr>
                                </thead>
                                <tbody>

                                  <tr ng-repeat="customer in lists">
                                    <td><%$index+1%>.</td>
                                    <td><%customer.FirstName%> <%customer.LastName%></td>
                                    <td><%customer.decision |decision_filter%></td>
                                    <td><%customer.Responsibility%></td>
                                    <td>
                                        <table>
                                            <th>Name</th>
                                            <th>comment</th>
                                            <tr><td></td><td></td></tr>
                                            <tr ng-repeat="attchment in customer.attachments">
                                                <td><%attchment.doc_name%></td>
                                                <td><%attchment.comment%></td>

                                                <td>
                                                    <form method="post" id="x_<%attchment.attachment_id%>" enctype="multipart/form-data" action="">
                                                        <input type="hidden" name="list_id" value="<%attchment.attachment_id%>">
                                                        <input type="hidden" name="attachment_name" value="<%attchment.doc_name%>">
                                                        <input type="hidden" name="delete_attachment" value="1">
                                                    <button  type="submit" class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="Delete Attachment"><i class="fa fa-trash-o"></i></button>

                                                    </form>

                                                </td>

                                            </tr>
                                            <tr>
                                               <td colspan="2">
                                                <form method="post" id="x_<%attchment.attachment_id%>" name="fileuploadform" enctype="multipart/form-data" action="">
                                                    <label>Comment</label><input type="text" name="comment" >
                                                    <p></p>
                                                <input type="file" name="doc[]" multiple="multiple"  required>
                                               <input type="hidden" name="list_id" value="<%customer.list_id%>">
                                                    <input type="hidden" name="Upload" multiple value="1">
                                                    <span ng-cloak  class="error-msg " ng-show="(fileuploadform.doc.$dirty || invalidSubmitAttempt) && fileuploadform.doc.$error.required"> This field is required.</span>

                                                    <button class="btn btn-animate flat blue" type="submit" ng-click="check_validation(fileuploadform)" >Upload</button>
                                                </form>
                                                </td>

                                            </tr>


                                        </table>



                                    </td>
                                  <!--  <td>
                                      <table class="actions">
                                        <tr>
                                          <td style="text-align:center;">

                                              <select class="form-control" ng-model="customer.status"  ng-change="update_status(customer.status,'<?=Request::segment(3);?>',customer.list_id)">

                                                  <option value="1">Open</option>
                                                  <option value="2">Closed</option>
                                              </select>
                                          </td>
                                        </tr>
                                      </table>
                                    </td>-->
                                  </tr>
                                </tbody>
                              </table>
                                <div class="row mg-top">
                                    <div class="col-sm-12">
                                        <form method="post" name="customer_form" action="<?php echo Request::root().'/changes/submit_customer_communication_list_for_reject/'?><?=Request::segment(3)?>/<?=Request::segment(4);?>" ng-class="{'submitted': submitted}"  novalidate ng-submit="(submitted = true) && customer_form.$invalid && $event.preventDefault()" autocomplete="off">
                                            <input type="hidden" name="request_id" value="<?=Request::segment(3);?>">
                                       <button class="btn btn-animate flat blue pd-btn pull-right" ng-disabled="isDisabled" type="submit" ng-click="chk_v()">Save</button>
                                       </form>

                                         </div>
                                </div>
                            </div><!--/table-wrapper-->
                          </div>
                        </div>

                        </div><!--/form-warpper-->


                  </div><!--/content-wrapper-->
                </div><!--/s10-->
              </div><!--/row-->
            
      </div><!--/container-->
  </div><!--/main-wrapper-->
<?php require app_path().'/views/footer.php'; ?>