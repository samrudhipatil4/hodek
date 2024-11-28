<?php require app_path().'/views/header.php'; ?>
  <div class="main-wrapper">
    <div class="container">

              <div class="row two-col-row mg-bottom-0">
                
                <div class="col-sm-12">

                    <div class="row">
                      <div class="col-sm-12">
                        <div class="page-heading">
                          <h1>Activities completion Status monitoring</h1>
                        </div><!--/page-heading-->    
                      </div>
                    </div>
                    <?php
                        if($request_id == ""){
                            $request_id =  Request::segment(3);

                        }else{
                            $request_id = $request_id;

                        }
                        if($userId == ""){
                            $risk_ass_id =  Session::get('uid');

                        }else{
                            $risk_ass_id = $userId;
                        }
                        if($dept_id == ""){
                            $d_id =  Session::get('dep_id');

                        }else{
                            $d_id = $dept_id;
                        }
                    ?>


                    <?php if(Session::has('message')){

                        echo Session::get('message');

                    }?>
                    <ul class="parsley-error-list">
                        <?php
                        foreach($errors->all() as $error){  ?>
                        <li>echo  $error</li>
                        <?php }?>
                    </ul>


                    <div class="content-wrapper" ng-controller="Activity_monitoringCtrl" ng-init="get_data('<?=$request_id;?>','<?=$risk_ass_id?>','<?=$d_id?>')">

                    <div class="status-bar">
                      <div class="row mg-bottom-0">                                          
                        <div class="col-sm-6">
                          <ul class="pd-none">
                           <li> <strong>Task Record CM Number :</strong> <span ng-bind="cmno"></span></li>
                          </ul> 
                        </div>
                        <div class="col-sm-6">
                          <ul class="pull-right">
                           <li> <strong>Current State :</strong><span ng-bind="status"> </li>
                          </ul> 
                        </div>
                      </div>                        
                    </div><!--/status-bar-->

                     <div class="form-wrapper mg-btm"  >


                        <div class="row" >
                          <div class="col-sm-12">
                            <div class="table-wrapper">
                              <table class="striped">
                                <thead>
                                  <tr>

                                      <th width="10%">Department</th>
                                      <th width="12%">Risk Assessment Points</th>
                                      <th width="12%">Applicability</th>
                                      <th width="12%">If No, Please specify the reason</th>
                                      <th width="12%">If Yes, Please mention the De-Risking action</th>
                                      <th width="10%">Responsibility</th>
                                      <th width="10%">Target data</th>
                                      <th width="25%">Document Category & Attachments</th>

                                      
                                  </tr>
                                </thead>
                                <tbody>

                                  <tr ng-repeat="customer in lists" ng-cloak>
                                    <td ng-if="customer.responsibility.department_id==<?php echo $d_id?>"><%customer.responsibility.d_name%></td>
                                    <td ng-if="customer.responsibility.department_id==<?php echo $d_id?>"><%customer.assessment_point%></td>
                                    <td ng-if="customer.responsibility.department_id==<?php echo $d_id?>"><%customer.applicability|Applicability%></td>
                                    <td ng-if="customer.responsibility.department_id==<?php echo $d_id?>"><%customer.reason%></td>
                                    <td ng-if="customer.responsibility.department_id==<?php echo $d_id?>"><%customer.de_risking%></td>
                                    <td ng-if="customer.responsibility.department_id==<?php echo $d_id?>"><%customer.responsibility.name%></td>
                                    <td ng-if="customer.responsibility.department_id==<?php echo $d_id?>"><%customer.target_date|date:'d.M.yyyy'%></td>

                                      <td ng-if="customer.responsibility.department_id==<?php echo $d_id?>">
                                          <table>
                                              <tr ng-repeat="attchment in customer.attachments" ng-init="cntFile(attchment.list_id,attchment.request_id,<?=$dept_id;?>)">
                                                  <td><%attchment.attachment_file%></td>
                                                  <?php if($page == "modifyByUser"){ ?>

                                                  <td>
                                                      <form method="post" id="x_<%attchment.attachment_id%>" enctype="multipart/form-data" action="">
                                                          <input type="hidden" name="list_id" value="<%attchment.attachment_id%>">
                                                          <input type="hidden" name="attachment_name" value="<%attchment.attachment_file%>">
                                                          <input type="hidden" name="delete_attachment" value="1">
                                                          <input type="hidden" name="request_Id" value="<?=$request_id;?>">
                                                          <input type="hidden" name="dept_id" value="<?=$dept_id;?>">
                                                          <input type="hidden" name="user_id" value="<?=$risk_ass_id;?>">
                                                          <input type="hidden" name="activity_upload" value="activity_upload">
                                                            
                                                          <button  type="submit" class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="Delete File" ><i class="fa fa-trash-o"></i></button>
                                                             
                                                      </form>

                                                  </td>
                                                  <?php }else{?>
                                                   
                                                      <td >
                                                      <form method="post" id="x_<%attchment.attachment_id%>" enctype="multipart/form-data" action="">
                                                          <input type="hidden" name="list_id" value="<%attchment.attachment_id%>">
                                                          <input type="hidden" name="attachment_name" value="<%attchment.attachment_file%>">
                                                          <input type="hidden" name="delete_attachment" value="1">
                                                          <input type="hidden" name="request_Id" value="<?=$request_id;?>">
                                                          <input type="hidden" name="dept_id" value="<?=$dept_id;?>">
                                                          <input type="hidden" name="user_id" value="<?=$risk_ass_id;?>">
                                                          <input type="hidden" name="activity_upload" value="activity_upload">
                                                          
                                                          <button  type="submit" class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="Delete File" ng-disabled="isDisabl_<%attchment.list_id%>"><i class="fa fa-trash-o"></i></button>
                                                             
                                                      </form>

                                                  </td>

                                                    <?php }?>
                                              </tr>
                                              <tr>
                                                  <td colspan="2">
                                                      <form method="post" id="x_<%attchment.attachment_id%>" name="fileuploadform" enctype="multipart/form-data" action="">
                                                          <input type="file" name="doc[]" multiple="multiple" accept="<%ext%>" required>
                                                          <input type="hidden" name="risk_assessment_id" value="<%customer.risk_assessment_id%>">
                                                          <input type="hidden" name="applicability" value="<%customer.applicability%>">
                                                          <input type="hidden" name="request_Id" value="<?=$request_id;?>">
                                                          <input type="hidden" name="dept_id" value="<?=$dept_id;?>">
                                                          <input type="hidden" name="user_id" value="<?=$risk_ass_id;?>">
                                                          <input type="hidden" name="activity_upload" value="activity_upload">

                                                          <input type="hidden" name="Upload" multiple value="1">
                                                          <span ng-cloak  class="error-msg " ng-show="(fileuploadform.doc.$dirty || invalidSubmitAttempt) && fileuploadform.doc.$error.required"> This field is required.</span>

                                                          <button class="btn btn-animate flat blue" type="submit" ng-click="check_validation(fileuploadform)" >Upload</button>
                                                      </form>
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

                        </div><!--/form-warpper-->
                  
                        <?php if($page == "modifyByUser"){?>
                         <div class="row mg-top">
                              <div class="col-sm-12">
                                  <form method="post" id="" enctype="multipart/form-data" action="<?php echo Request::root().'/changes/assign_task_to_next_step_frm_activity_monitoring/'.Request::segment(3); ?>/<?=Request::segment(4); ?>"  ng-class="{'submitted': submitted}" name="activity_form" novalidate ng-submit="(submitted = true) && activity_form.$invalid && $event.preventDefault()" autocomplete="off">
                                        <input type="hidden" value="" name="id" required>
                                  <!-- <button class="btn waves-effect waves-light" type="button">Cancel</button>-->
                               <!-- <a class="btn btn-animate flat blue pd-btn pull-right" ng-click="assign_task_to_next_step()">Save</a>-->

                                    <button class="btn btn-animate flat blue pd-btn" type="submit" value="Sumbit" data-after-submit-value="Saving&hellip;"/>Save</button>
                              </form>
                              </div>
                          </div>
                        <?php }else{?>
                        <?php }?>

                      <script type="text/ng-template" id="ActivityModalContent.html">
                          <div class="modal-header">
                              <h3 class="modal-title">Document Category & Attachments</h3>
                          </div>
                          <div class="modal-body">
                              <div class="report-wrapper table-overflow scrollbarX">

                                  <table class="table table-striped table-bordered">
                                      <thead>

                                      <th width="45%"><strong>Category Name: <%lists.category.category%></strong></th>



                                      </thead>
                                      <tbody>


                                      <tr ng-repeat="data1 in lists.attachments">

                                          <td><%data1.attachment_file%></td>
                                          <td><!--
                                                  <a  href="#" class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="Delete Record" ng-click="delete_file($index,data1.attachment_id,data1.attachment_file)" ng-confirm-click="Would you sure to delete?"><i class="fa fa-trash-o"></i></a>
-->
                                             </td>

                                      </tr>
                                      <tr>

                                          <td colspan="2">
                                              <form method="post" id="" enctype="multipart/form-data" action="<?php echo Request::root().'/changes/submit_cat_attachments/'?><?php echo Request::segment(3); ?>">
                                                  <input type="file" name="multi_doc[]" multiple>
                                                  <input type="hidden" name="list_id" value="<%lists.risk_assessment_id%>">
                                                  <input type="hidden" name="category_id" value="<%lists.category.risk_assessment_document_id%>">
                                                  <button class="btn btn-animate flat blue" type="submit" >Upload</button>
                                                  <button class="btn btn-animate flat blue pd-btn " type="button" ng-click="cancel()">Cancel</button>
                                              </form>
                                          </td>

                                      </tr>

                                      </tbody>
                                  </table>
                              </div>
                          </div>


                         <!-- <div class="modal-footer">

                              <button class="btn btn-animate flat blue pd-btn pull-right" type="button" ng-click="cancel()">X</button>


                          </div>-->
                      </script>
                  </div><!--/content-wrapper-->
                </div><!--/s10-->
              </div><!--/row-->
            
      </div><!--/container-->
  </div><!--/main-wrapper-->
<?php require app_path().'/views/footer.php'; ?>

<script type="text/javascript">

    $(document).on('submit', 'form', function() {
        $("#fade").show();
        var $form = $(this),
            $button,
            label;
        $form.find(':submit').each(function() {
            $button = $(this);
            label = $button.data('after-submit-value');
            if (typeof label != 'undefined') {
                $button.val(label).prop('disabled', true);
            }
        });
    });

</script>

