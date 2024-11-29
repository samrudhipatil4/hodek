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
                            <?php if($request_id == ""){
                                $request_id =  Request::segment(3);

                            }else{
                                $request_id = $request_id;

                            }
                            if($risk_assessor_id == ""){
                                $risk_ass_id =  Session::get('uid');

                            }else{
                                $risk_ass_id = $risk_assessor_id;
                            }
                            if($dept_id == ""){
                                $d_id =  Session::get('dep_id');

                            }else{
                                $d_id = $dept_id;
                            }
                            $url=Request::segment(4);
                            
                            if($url != ""){
                             
                              $rpsid=Request::segment(4);
                            }else{
                             
                              $rpsid='null';
                            }
                         ?>
                        </div><!--/page-heading-->    
                      </div>
                    </div>

                    <div class="content-wrapper" >

                      <div class="status-bar" ng-controller="CtrlRiskAnalysis1" ng-init="get_info('<?php echo $request_id; ?>','<?php echo $risk_ass_id; ?>','<?php echo $d_id; ?>')">
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
                    
                      <div class="form-wrapper" ng-cloak>

                          <div ng-controller="CtrlRiskAnalysis" ng-init="fetch('<?php echo $request_id; ?>','<?php echo $risk_ass_id; ?>','<?php echo $d_id; ?>');get_change_request_details('<?php echo $request_id; ?>')">
                            <div class="row mg-btm" >

                                <div class="col-sm-12">

                                    <div class="table-wrapper">
                                        <section class="report-wrapper">

                                            <table class="striped">
                                                <tbody >
                                                <tr >
                                                    <td width="12.5%"><strong>Change Request No.</strong></td>
                                                    <td width="12.5%"><span ng-bind="details.cmNo"></span></td>
                                                    <td width="12.5%"><strong>Change Stage</strong></td>
                                                    <td width="12.5%"><span ng-bind="details.change_stage"></span></td>
                                                    <td width="12.5%"><strong>Business</strong></td>
                                                    <td width="12.5%"><span ng-bind="details.business"></span></td>
                                                    <td colspan="2"><strong>Date</strong></td>
                                                    <td colspan="2"><span ng-bind="details.dt"></span></td>
                                                </tr>
                                                <tr>
                                                
                                                   
                                                    <td><strong>Change Type</strong></td>
                                                    <td colspan="4"class="pd-none">

                                                        <span ng-bind="details.changeType"></span>
                                                       

                                                    </td>
                                                    <td><strong>Change Sub Type</strong></td>
                                                    <td colspan="4" class="pd-none">
                                                        <span ng-bind="details.changeSubType"></span>
                                                    </td>
                                                </tr>
                                                 <tr>
                                                
                                                    <td><strong>Stakeholder</strong></td>
                                              <td><span ng-bind="details.stakeholder"></span></td>
                                                    <td><strong>Part Name</strong></td>
                                                    <td colspan="3"class="pd-none">


                                                        <ul class="listing">
                                                            <li  ng-repeat="partname in details.parts">

                                                                <span ng-bind="partname.part_name"></span>
                                                            </li>

                                                        </ul>

                                                    </td>
                                                    <td><strong>Part Number</strong></td>
                                                    <td colspan="3" class="pd-none">
                                                        <ul class="listing">
                                                            <li  ng-repeat="partnumber in details.parts">

                                                                <span ng-bind="partnumber.part_number"></span>
                                                            </li>

                                                        </ul>
                                                    </td>
                                                </tr>
                                                <tr>
                                                 <td><strong>Project Code</strong></td>
                                              <td><span ng-bind="details.proj_code"></span></td>
                                                    <td><strong>Purpose</strong></td>
                                                    <td colspan="3">
                                                        <ul class="listing">
                                                            <li ng-repeat="purpose in details.change_purpose ">

                                                                <span ng-bind="purpose.purpose_name"></span>
                                                            </li>


                                                        </ul>

                                                    </td>
                                                    <td><strong>Customer Name</strong></td>
                                                    <td colspan="3">

                                                        <ul class="listing">
                                                            <li ng-repeat="customer in details.customers ">

                                                                <span ng-bind="customer.customer_name"></span>
                                                            </li>


                                                        </ul>

                                                </tr>
                                                <tr>
                                                    <td colspan="2"><strong>Proposed Modifiaction Details</strong></td>
                                                    <td colspan="7"><span ng-bind="details.Purpose_Modification_Details"></span></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="1"><strong>Remark</strong></td>
                                                    <td colspan="4"><span ng-bind="details.remark"></span></td>
                                                    <td colspan="1"><strong>Attachment file</strong></td>
                                                  <td colspan="3"> <ul ng-repeat="member in details.get_change_request_attachment" >

                                                    <li ng-if="member.attachment_file!=''">
                                                   <span ng-bind="member.attachment_file"></span>  <a href="<?php echo Request::root().'/download?path=changeRequest&filename='?><%member.attachment_file%>" data-position="bottom" data-delay="50" data-tooltip="Download"><i class="glyphicon glyphicon-download-alt"></i></a>



                                         </li>
                                       </ul></td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2"><strong>Requested By :</strong></td>
                                                    <td colspan="2"><span ng-bind="details.initiator_name"></span></td>
                                                    <td colspan="2"><strong>Department Head :</strong></td>
                                                    <td colspan="2"><span ng-bind="details.Approval_Authority"></span></td>
                                                </tr>
                                                <tr>
                                                 <td colspan="1"><strong>HOD Approval Comment</strong></td>
                                                  <td colspan="5"><span ng-bind="details.hodApproveComment"></span></td>
                                                    <td colspan="2"><strong>Approval Response Date</strong></td>
                                                    <td colspan="7"><span ng-bind="details.response_date"></span></td>
                                                </tr>
                                                <tr>
                                                 <td colspan="2"><strong>Current index level stock to be used until stock is zero</strong></td>
                                                  <td colspan="5"><span ng-bind="details.level"></span></td>
                                                 
                                                </tr>
                                                <tr>
                                                 <td colspan="1"><strong>Current stock</strong></td>
                                                  <td colspan="2"><span ng-bind="details.stock"></span></td>
                                                    <td colspan="2"><strong>Implementation Date</strong></td>
                                                    <td colspan="7"><span ng-bind="details.impDate"></span></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            </section>
                                        <p></p>
                                        <p></p>
                                      <table class="striped" >
                                        <thead>
                                            <tr>
                                              <th width="5%">Sr. No.</th>
                                              <th width="25%">Impact Analysis Points</th>
                                              <th>Applicability</th>            
                                              <th width="25%">Reason</th>
                                              <th width="25%">Countermeasure Action</th>
                                              <!--<th>Responsibility</th>-->
                                              <th>Target Date</th>
                                              <th>Any Cost Involved</th>
                                              <th>Cost Per Piece</th>
                                              <th>Status</th>
                                              <th>Action</th>                                          
                                            </tr>
                                        </thead>
                                        <tbody >
                                            <tr ng-repeat="task in tasks" ng-class="{'success' : tasks[$index]}" >
                                              <td><%$index+1%>.</td>
                                              <td><%task.assessment_point_department%></td>
                                              <td><%task.applicability | Applicability%></td>
                                              <td><%task.reason%></td>
                                                <td><%task.de_risking%></td>
                                             <!-- <td><%task.responsibility%></td>-->
                                              <td><%task.target_date| date:'dd.MM.yyyy'%></td>
                                              <td><%task.cost%></td>
                                              <td><%task.piececost%></td>
                                               <td><%task.status | statusfilter%></td>
                                              <td >
                                                <table cellpadding="0" cellspacing="0">
                                                  
                                                  <!--<tr class="border-none" ng-if="task.request_id!='0'"> -->
                                                  <tr class="border-none"> 
                                                    <td style="border:0px !important; font-size:16px;"><a href="javascript:void(0)" ng-click="EditRecord($index,task.risk_assessment_id,'<?php echo $risk_ass_id; ?>','<?php echo $d_id; ?>','<?php echo $request_id; ?>','<?php echo $rpsid;?>')" class="" data-position="bottom" data-delay="50" data-tooltip="Edit" ><i class="fa fa-check" ></i></a></td>
                                                 
                                                  </tr>
                                                  
                                                </table>
                                              </td>
                                            </tr>
                                  
                                        </tbody>              
                                      </table>
                                    </div><!--/table-wrapper-->
                                </div>
                            </div>

                            <div class="row ">
                                <div class="col-sm-12">
                                  
                                </div>
                            </div>

                        <div class="add-record" ng-if="newReocord1">
                              <div >

                                <form method="post" role="form" ng-class="{'submitted': submitted}" name="updateform" novalidate ng-submit="(submitted = true) && updateform.$invalid && $event.preventDefault()" autocomplete="off">
                                  <div>



                                    <div class="row mg-btm">
                                        <div class="input-field col-sm-6">
                                            <label for="description">Impact Analysis Points: </label> <span ng-bind="risks.assessment_point_department"></span>

                                      </div>

                                           
                                    </div>

                                    <div class="row mg-btm">
                                        <div class="col-sm-3">
                                          <p class="radio-label inline-lbl-radio pd-none" style="font-size:1em;">Applicability</p>
                                      </div>
                                      <div class="col-sm-1 pd-none">
                                            <p>
                                              <input class="with-gap" name="group1" type="radio" id="Yes" value="1" ng-model="risks.applicability" ng-disabled="isDisabled"/>
                                              <label for="Yes">Yes</label>  
                                            </p>
                                        </div>
                                        <div class="col-sm-1 pd-none">
                                            <p>
                                              <input class="with-gap" name="group1" type="radio" id="No" value="2" ng-model="risks.applicability" ng-disabled="isDisabled"/>
                                              <label for="No">No</label>  
                                            </p>
                                        </div>
                                    </div>

                                    <div class="row" ng-if="risks.applicability == '2'">
                                        <div class="input-field col-sm-6 mg-btm">
                                            <label for="textarea1">Specify The Reason</label>
                                          <textarea id="textarea1" class="form-control mg-top" rows="2" ng-model="risks.reason" name="reason" required></textarea>
                                            <span ng-cloak class="error-msg " ng-show="(updateform.reason.$dirty || invalidSubmitAttempt) && updateform.reason.$error.required"> This field is required.</span>

                                        </div>
                                    </div>
                        <div ng-if="risks.applicability == '1'">

                                      <div class="row">
                                          <div class="input-field col-sm-6 mg-btm">
                                              <label for="textarea1">Specify Countermeasure Action</label>
                                            <textarea id="textarea1" class="form-control mg-top" rows="2" ng-model="risks.de_risking" name="de_risking" required></textarea>
                                              <span ng-cloak class="error-msg " ng-show="(updateform.de_risking.$dirty || invalidSubmitAttempt) && updateform.de_risking.$error.required"> This field is required.</span>


                                          </div>
                                      </div>

                                      <div class="row mg-bottom-15">
                                          <div class="col-sm-6">

                                            <div class="row mg-bottom-0">


                                                  
                                       <div class="input-field col-sm-4">
                                                      <label for="cost" class="">Target Date</label>

                                                      <input type="text" id="target_d" name="target_date" readonly data-date-format="dd.mm.yyyy" ng-model="risks.target_date" class="t_date" jqdatepicker required/>
                                                      <span class="glyphicon glyphicon-calendar icon_cal"></span>

                                                      
                                                      <span class="error-msg " ng-show="(updateform.target_date.$dirty || invalidSubmitAttempt) && updateform.target_date.$error.required"> This field is required.</span>

                                                  </div>


                                                <div class="input-field col-sm-4">
                                                    <label for="cost" class="">Cost Involved</label>
                                                  <input id="cost" type="text" placeholder="Value in INR" class="form-control" ng-model="risks.cost" name="cost" ng-pattern="/^(\d)+$/">
                                                    
                                                    <span ng-cloak class="error-msg " ng-show="(updateform.cost.$dirty || invalidSubmitAttempt) && updateform.cost.$error.required"> This field is required.</span>
                                                    <span ng-cloak class="error-msg " ng-show="(updateform.cost.$dirty || invalidSubmitAttempt) && updateform.cost.$error.pattern"> Current Cost is Invalid.</span>
                                                  </div>
                                                     <div class="input-field col-sm-4">
                                                    <label for="cost" class="">Cost Per Piece</label>
                                                  <input id="piececost" type="text" placeholder="Value in INR" class="form-control" ng-model="risks.piececost" name="piececost" ng-pattern="/^(\d)+$/">
                                                    
                                                    <span ng-cloak class="error-msg " ng-show="(updateform.piececost.$dirty || invalidSubmitAttempt) && updateform.piececost.$error.required"> This field is required.</span>
                                                    <span ng-cloak class="error-msg " ng-show="(updateform.piececost.$dirty || invalidSubmitAttempt) && updateform.piececost.$error.pattern"> Current Cost is Invalid.</span>
                                                  </div>
                                            </div>

                                          </div>
                                      </div>
                                    </div>

                                    <div class="row mg-top mg-btm">
                                        <div class="col-sm-12 ">
                                            <button class="btn btn-animate flat blue pd-btn" type="submit" ng-disabled="isDisabled1" name="action" ng-click="UpdateRecord(updateform,risks.risk_assessment_id,<?=$request_id;?>,<?=$rpsid;?>)">Save</button>
                                            <button class="btn btn-animate flat blue pd-btn" type="submit" ng-disabled="isDisabled12" name="action" ng-click="cancel(updateform)">Cancel</button>

                                        </div>
                                    </div>
                                    </div>

                                </form>
                                </div>
                          </div><!--/add-record-->
                          <div class="row ">
                                <div class="col-sm-12">
                                  <button class="btn btn-animate flat blue pd-btn" type="submit" ng-click="completeAllPoints(<?=Request::segment(3);?>,'<?php echo $risk_ass_id; ?>','<?php echo $d_id; ?>')"
                                       >APPLY N/A TO ALL INCOMPLETE POINTS</button>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-sm-12">
                                  <br>
                                </div>
                            </div>
                        </div>
              <div ng-controller="CtrlRiskAnalysisAll" ng-init="fetchAppv('<?php echo $request_id; ?>')">
                <form method="post" role="form" ng-class="{'submitted': submitted}" name="updaterisksheet" novalidate ng-submit="(submitted = true) && updaterisksheet.$invalid && $event.preventDefault()" autocomplete="off">

                                <div class="row">
                                    <div class="col-sm-12">
                                      <div class="page-heading">

                                      </div><!--/page-heading-->
                                    </div>
                                </div>
                                
                                 <?php if($page=="modifybyriskAss"){?>
                                  <div class="row mg-btm" >
                                      <div class="input-field col-sm-6">
                                          <label for="approval">Approval Authority: </label> <span><%hod.name%></span>
                                          <input type="hidden"  name="Approval_Authority" id="Approval_Authority" value="<%hod.id%>" >

                                      </div>

                                  </div>
                                 <?php }else{
                                 } ?>


                           

                    <?php if($page=="modifybyriskAss"){?>
                                <div class="row mg-top">
                                      <div class="col-sm-12 ">
                                        <button class="btn btn-animate flat blue pd-btn" type="submit" ng-disabled="isDisabled" name="action" ng-click="update_risk_sheet(updaterisksheet,<?=Request::segment(3);?>,<?=Request::segment(4);?>,'<?php echo $risk_ass_id; ?>','<?php echo $d_id; ?>')">Send</button>
                                          <div class="loading-spiner-holder" data-loading >
                                              <div class="loading-spiner">
                                                <img src="<?php echo Request::root(); ?>/protected/public/images/Twirl.gif" />
                                            </div>
                                        </div>
                                    </div>
                              </div>
                            <?php }else{
                            }?>

                            </form>
                            </div>
                        </div><!--/form-warpper-->                    
                    </div><!--/content-wrapper-->
                </div><!--/s10-->
            </div><!--/row-->
        </div><!--/container-->
    </div><!--/main-wrapper-->
<?php require app_path().'/views/footer.php'; ?>
 <script type="text/javascript">
  $(document).ready(function(){

var base_url= '<?php echo Request::root(); ?>';

 $("#target_d").datepicker({
  startDate: '<?php echo date('d-m-Y'); ?>'
  
})

$(document).on("change", "#target_d", function () {
       var selectdate=$(this).val();

      var parts = selectdate.split('.');
      var dmyDate = parts[2] + '-' + parts[1] + '-' + parts[0];
       var r_id=<?=Request::segment(3);?>
       
       $.ajax({
                   url:base_url+'/changes/checkImplementationDate',
                    type: 'get',
                    data:{request_id:r_id},
                    
                success: function(data) {
                   
                   if(new Date(dmyDate) > new Date(data))
                    {
                      alert('Target date is greater than proposed implementation date.')
                }
            }

    });

  });

});
</script>