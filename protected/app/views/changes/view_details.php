<?php require app_path().'/views/header.php'; ?>

<div class="main-wrapper">
  <div class="container" ng-controller="Ctrlactivitymonitoring">

    <div class="row two-col-row mg-bottom-0">

      <div class="col-sm-12">

        <div class="row mg-btm">
          <div class="col-sm-6">
            <div class="page-heading">
              <h1 class="border-none">View CM Record</h1>
            </div><!--/page-heading-->
          </div>

        </div>

        <div class="seprator"></div>

        <div class="content-wrapper" ng-show="showReport" ng-init="summeryReport('<?php echo Request::segment(3); ?>')">

          <!-- view report -->
          <div class="row mg-btm">
            <div class="col-sm-12">
              <h4 class="border-none"><span ng-bind="summeries.count_request_is_rejected"></h4>
                         <h5 class="border-none"><strong>Reject Comment:- </strong><span ng-bind="summeries.count_request_is_remark"></h5>
              <section class="report-wrapper" >
                 <table class="striped">
                              <tbody>
                                <tr>
                                  <td width="12.5%"><strong>Change Request No.</strong></td>
                                  <td width="12.5%"><span ng-bind="summeries.cmNo"></span></td>
                                  <td width="12.5%"><strong>Change Stage</strong></td>
                                  <td width="12.5%"><span ng-bind="summeries.stage_name"></span></td>
                                  <td width="12.5%"><strong> Business</strong></td>
                                  <td width="12.5%"><span ng-bind="summeries.business"></span></td>
                                  <td width="12.5%"><strong>Date</strong></td>
                                  <td width="12.5%"><span ng-bind="summeries.created_date"></span></td>
                                </tr>
                                <tr>
                                <tr>
                                  <td width="12.5%"><strong>Manufacturing Location</strong></td>
                                  <td width="12.5%" colspan="3"><span ng-bind="summeries.plant_code"></span></td>
                                  <td width="12.5%"><strong>Dispatch Location</strong></td>
                                  <td width="12.5%" colspan="3"><span ng-bind="summeries.dispatchloc"></span></td>
                                </tr>

                                   <td ><strong>Change Type</strong></td>
                                  <td colspan="3"><span ng-bind="summeries.change_type_name"></span></td>
                                  <td><strong>Change Sub Type</strong></td>
                                   <td colspan="3" class="pd-none">


                                    <ul class="listing" >
                                      <li  ng-repeat="type in subtype">

                                        <span ng-bind="type"></span>
                                      </li>

                                    </ul>

                                  </td>
                                </tr>
                                <tr>
                                <td><strong>Stakeholder</strong></td>
                                 <td><span ng-bind="summeries.stakeholder"></span></td>

                                  <td><strong>Part Name</strong></td>
                                  <td colspan="2"class="pd-none">


                                    <ul class="listing">
                                      <li  ng-repeat="partname in parts">

                                        <span ng-bind="partname.part_name"></span>
                                      </li>

                                    </ul>

                                  </td>
                                  <td><strong>Part Number</strong></td>
                                   <td colspan="3" class="pd-none">
                                     <ul class="listing">
                                       <li  ng-repeat="partnumber in parts">

                                         <span ng-bind="partnumber.part_number"></span>
                                       </li>

                                          </ul>
                                  </td>
                                </tr>
                                <tr>
                                 <td><strong>Project Code</strong></td>
                                 <td><span ng-bind="summeries.project_code"></span></td>
                                  <td><strong>Purpose</strong></td>
                                  <td colspan="2">
                                    <ul class="listing">
                                      <li ng-repeat="purpose in summeries.change_purpose ">

                                        <span ng-bind="purpose.purpose_name"></span>
                                      </li>


                                    </ul>

                                   </td>
                                  <td><strong>Customer Name</strong></td>
                                  <td colspan="3">

                                    <ul class="listing">
                                      <li ng-repeat="customer in summeries.customers ">

                                        <span ng-bind="customer.customer_name"></span>
                                      </li>


                                    </ul>

                                </tr>
                                <tr>
                                  <td colspan="2"><strong>Proposed Modifiaction Details</strong></td>
                                  <td colspan="7"><span ng-bind="summeries.Purpose_Modification_Details"></span></td>
                                </tr>
                                <tr>
                                  <td><strong>Remark</strong></td>
                                  <td colspan="3"><span ng-bind="summeries.remark"></span></td>
                                  <td><strong>Attachment file</strong></td>
                                  <td> <ul ng-repeat="member in summeries.get_change_request_attachment" >

                                         <li ng-if="member.attachment_file!=''">
                                           <span ng-bind="member.attachment_file"></span>  <a href="<?php echo Request::root().'/download?path=changeRequest&filename='?><%member.attachment_file%>" data-position="bottom" data-delay="50" data-tooltip="Download"><i class="glyphicon glyphicon-download-alt"></i></a>



                                         </li>
                                       </ul></td>
                                </tr>

                                <tr>
                                  <td colspan="2"><strong>Requested By :</strong></td>
                                  <td colspan="2"><span ng-bind="summeries.initiator_name"></span></td>
                                  <td colspan="2"><strong>Department Head :</strong></td>
                                  <td colspan="2"><span ng-bind="summeries.authority_name"></span></td>
                                </tr>
                                <tr>
                                  <td colspan="1"><strong>Approval Response Date</strong></td>
                                  <td colspan="2"><span ng-bind="summeries.response_date"></span></td>
                                   <td colspan="1"><strong>HOD Approval Comment</strong></td>
                                   <td colspan="5"><span ng-bind="summeries.hodApproveComment"></span></td>
                                </tr>

                              </tbody>
                            </table>

               <table class="striped">
                              <caption align="top">Multidisciplinary approach for change</caption>

                              <tr>
                                <td><strong>Team Leader</strong></td>
                                <td><span ng-bind="summeries.teamleader.name"></span></td>
                              </tr>
                                <tr>
                                <td><strong>Comment</strong></td>
                                <td><span ng-bind="summeries.teamleader.comment"></span></td>
                              </tr>

                              <tr>
                                <td width="10%" class="pd-none">
                                  <table>
                                    <tr><td style="padding:5px 10px; border-bottom:1px solid #e5e5e5;"><strong>Function</strong></td></tr>
                                    <tr><td><strong>Team Member</strong></td></tr>

                                  </table>
                                </td>
                                <td width="90%" class="nested-table pd-none">
                                  <table class="bordered">
                                    <tbody><tr>

                                      <td ng-repeat="dep in team_members"><strong><span ng-bind="dep.d_name"></span></strong></td>
                                    </tr>
                                    <tr>

                                      <td ng-repeat="member in team_members"><span ng-bind="member.first_name"></span> <span ng-bind="member.last_name"></span></td>
                                    </tr>
                                   
                                    </tbody></table>
                                </td>
                              </tr>
                             <tr>
                                <td width="10%" class="pd-none">
                                  <table>
                                    <tr><td style="padding:5px 10px; border-bottom:1px solid #e5e5e5;"><strong>Project Manager Rejection Comment</strong></td>
                                </tr>
                              </table>
                              </td>
                               <td width="90%" class="nested-table pd-none">
                                  <table class="bordered">
                                    <tbody> <tr >
                           
                                  <td ng-if="summeries.prjMgrComment == ''" ng-repeat="comment in team_members">
                                  <span ng-bind="comment.reject_reason"></span></td>
                                    </tr>
                                   
                                    </tbody></table>
                                </td>
                              </tr>

                              <tr>
                                <td colspan="2" class="pd-none ">
                                  <table class="borderd-cell">
                                    <tr class="border-bottom">
                                      <td width="25%"><strong>Current index level stock to be used until stock is zero</strong></td>
                                      <td width="75%" class=""><%summeries.lev%></td>
                                    </tr>
                                    <tr>
                                      <td><strong>Change implementation date of new index level</strong></td>
                                      <td class="pd-none ">
                                        <table class="borderd-cell">
                                          <tr>
                                            <td width="25%"><strong>Proposed Implementation Date</strong></td>
                                            <!--  <td width="25%"><my-date year="summeries.impdate"></my-date></td>-->
                                            <td width="25%"><span ng-bind="summeries.impdate"></span></></td>
                                            <td width="25%"><strong>Current Stock</strong></td>
                                            <td width="25%"><span ng-bind="summeries.teamleader.stock"></span></td>
                                          </tr>
                                        </table>
                                      </td>
                                    </tr>
                                  </table>
                                </td>
                              </tr>
          <tr>
                                 <td colspan="2" class="pd-none" >
                                   <table class="borderd-cell" width="100%">
                                     <tr >
                                       <td width="10%"><strong>Project Manager</strong>
                                       <span ng-bind="summeries.projrct_mgr"></span>
                                    </td>
                                    <td width="10%"><strong>Project Manager Approve Comment</strong>
                                       <span ng-bind="summeries.prjMgrComment"></span>
                                    </td>
                                     </tr>
                                   </table>
                                 </td>
                               </tr>


                            </table>



                <table >

                  <caption align="top" style="padding-bottom:0px;margin-bottom:0px;">Risk involvement  in change management</caption>
                </table>


                <div  >

                  <uib-accordion close-others="oneAtATime" ng-repeat="risk in risksdatas1" ng-if="risk.riskdata.length!=''">

                    <uib-accordion-group is-open="status.open">
                      <uib-accordion-heading>
                        <span ng-bind="risk.sub_dep_name"> <i class="pull-right glyphicon" ng-class="{'glyphicon-triangle-top': status.open, 'glyphicon-triangle-bottom': !status.open}"></i></span>
                      </uib-accordion-heading>

                      <div class="table-wrapper">
                        <table class="striped">
                          <thead>
                          <tr>
                            <th>Sr. No.</th>
                            <th>Risk Assessment Points</th>
                            <th>Applicability</th>
                            <th>If No, Please specify the reason</th>
                            <th>If Yes, Please mention the De-Risking action</th>
                            <th>Responsibility</th>
                            <th>Target date</th>
                            <th>Any Cost Involved</th>
                             <th>Cost Per Piece</th>
                            <th>HOD Approval</th>
                            <th>Attachment option</th>
                            <!-- <th>Status</th>-->
                            <th>Verification</th>
                          </tr>
                          </thead>
                          <tbody>
                          <tr ng-repeat="list in risk.riskdata">
                            <td><span ng-bind="<% $index+1%>"></td>
                            <td><span ng-bind="list.assessment_point"></td>
                            <td><span ng-bind="list.applicability |Applicability"></td>
                            <td><span ng-bind="list.reason"></td>
                            <td><span ng-bind="list.de_risking"></td>
                            <td><span ng-bind="list.responsibility.name"></td>
                            <td><span ng-bind="list.target_date|date:'d.M.yyyy'"></td>
                            <td><span ng-bind="list.cost"></td>
                             <td><span ng-bind="list.piececost"></td>
                            <td ng-if="list.hod_approval.status!=''"><span ng-bind="list.hod_approval.status|Applicability"></td>
                            <td class="no-pd">
                              <table>
                                <tr ng-repeat="attchment in list.attachments">


                                  <td><%attchment.attachment_file%> <a href="<?php echo Request::root().'/download?path=attachments&filename='?><%attchment.attachment_file%>" data-position="bottom" data-delay="50" data-tooltip="Download"><i class="glyphicon glyphicon-download-alt"></i></a></td>



                                </tr>

                              </table>
                            </td>
                            <!-- <td></td>-->
                            <td><span ng-bind="list.verification_status.status|Applicability"></td>

                          </tr>

                          </tbody>

                        </table>

                      </div><!--/table-wrapper-->

                    </uib-accordion-group>
                  </uib-accordion>

                </div>


                   <table class="striped mg-bottom-20">
                              <tbody>
                                 <tr>
                                   <td width="25%">
                                  <table>
                                  
                                    <tr>Cost Impact & Investment Details :&nbsp;&nbsp;<b><%summeries.totalcost%></b><br> </tr>
                                    <tr>Total Cost Per Piece:&nbsp;&nbsp;<b><%summeries.totcostperpiece%></b> </tr>
                                 
                                    </table>
                                  </td>
                                  <td width="25%">
                                    <table>
                                    <tr rowspan="2"><td>
                                      COO approval
                                    </td>
                                    <td>
                                      <table>
                                        <tr><td>
                                        status
                                        </td>
                                        <td>
                                          Comment
                                        </td>  
                                        </tr>
                                        <tr><td>
                                         <%summeries.coostatus%>
                                        </td>
                                        <td>
                                        <%summeries.coocomment%>
                                        </td>
                                        </tr>
                                      </table>
                                    </td>  
                                    </tr>
                                    </table>
                                  </td>
                                  <td width="25%">Steering Committee Members</td>
                                  <td width="25%" class="pd-none">
                                    <table>
                                      <tbody>
                                      <tr>
                                      <th>Member</th>
                                      <th>Status</th>
                                      <th>Comment</th>
                                      </tr>
                                      <tr ng-repeat="member in summeries.steering_commitee_member">
                                            <td><strong><% member.name[0].name%></strong></td>
                                            <td ng-if="member.sub_department_id[0].sub_department_id"><%member.approval_status[0].approval_status|STAPFLT%></td>
                                             <td ng-if="member.sub_department_id[0].sub_department_id"><% $index+1%>.  <%member.approval_status[0].comment%></td>
                                          
                                      </tr>
                                    </tbody>
                                    </table>
                                  </td>
                                </tr>

                                <tr>
                                  <td class="pd-none">
                                    <table class="borderd-cell">
                                    <tr>
                                        <td width="50%">Customer Communication Decision</td>
                                        <td width="50%" style=":0px !important;">
                                          <%summeries.custcomdec%>
                                        </td>
                                      </tr>
                                      <!-- <tr>
                                        <td width="50%" ng-if="summeries.custcomdec=='Yes'">Customer To be Communicated</td>
                                        <td width="50%" style=":0px !important;" ng-if="summeries.custcomdec=='Yes'">
                                          <ul class="listing no-list">
                                            <li ng-repeat="customer in summeries.custtobeCommunicated">
                                             <%customer.custtobeCommunicated.first_name%>  <%customer.custtobeCommunicated.last_name%>
                                            </li>


                                          </ul>


                                        </td>
                                      </tr> -->
                                    </table>
                                  </td>
                                  <td class="pd-none">
                                    <table class="borderd-cell">
                                      <tr>
                                        <td width="50%">Responsibility to get Customer Approval</td>
                                        <td width="50%"><%summeries.custapprovaluser%></td>
                                      </tr>
                                    </table>
                                  </td>
                                  <td class="pd-none">
                                    <table class="borderd-cell">
                                      <tr>
                                        <td width="50%">Customer Approval Attachment</td>
                                        <td width="50%" class="no-pd" style=":0px !important;">
                                          <div class="form-wrapper" >


                                            <div class="row">
                                              <div class="col-sm-12">
                                                <div class="table-wrapper">
                                                  <table class="striped table-border">
                                                    <thead>
                                                    <tr class="bg-transparent">

                                                      <th >Customer Name</th>

                                                      <th width="30%">Attachments</th>
                                                      <th width="50%">Comment</th>

                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr ng-repeat="customer in summeries.customer_approval_attachment">

                                                      <td ><%customer.customer_approval_attachment_status.FirstName%> <%customer.customer_approval_attachment_status.LastName%></td>

                                                      <td class="no-pd">
                                                        <table>

                                                          <tr ng-repeat="attchment in customer.customer_approval_attachment_status.attachments">
                                                            <td><%attchment.doc_name%> <a href="<?php echo Request::root().'/download?path=attachments&filename='?><%attchment.doc_name%>" data-position="bottom" data-delay="50" data-tooltip="Download"><i class="glyphicon glyphicon-download-alt"></i></a></td>

                                                          </tr>

                                                        </table>

                                                      </td>
                                                      <td class="no-pd">
                                                        <table>
                                                          <tr ng-repeat="attchment in customer.customer_approval_attachment_status.attachments">
                                                            <td ><%attchment.comment %> </td>

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

                                        </td>
                                      </tr>
                                    </table>
                                  </td>
                                  <td class="pd-none">
                                    <table class="borderd-cell">
                                      <tr>
                                        <td width="21%">Document Verification status</td>
                                        <td width="50%" style=":0px !important;"><%summeries.verification_status[0].status|STAPFLT%></td>
                                      </tr>
                                    </table>
                                  </td>

                                </tr>
                              </tbody>
                            </table>

                            <table class="striped mg-bottom-20">
                              <tbody>
                                <tr>
                                  <td width="25%">Horizontal Deployment</td>
                                  <td class="no-pd">
                                  <table class="">
                                    <tbody>
                                    <tr>
                                    <td width="70%" class="td_br">
                                    <%summeries.hd1%>
                                    </td>
                                    <td width="70%"></td>
                                    </tr>
                                    <tr>
                                      <td> Comment</td>
                                      <td> Reason</td>
                                    </tr>
                                    <tr>
                                      <td> <%summeries.hd.comment%></td>
                                      <td> <%summeries.hd.reason%></td>
                                    </tr>
                                    
                                      
                                    
                                    <tbody>
                                  </table>
                                  </td>
                                  <td width="25%">Cut-Off Date </td>
                                  <td width="25%"><%summeries.actual_date%></td>
                                </tr>
                                <tr>
                                  <td width="25%">Before After status Attachment Option</td>


                                  <td >
                                    <ul ng-repeat="member in summeries.before_after_attachement" >

                                      <li ng-if="member.attachment_file!=''">
                                        <span ng-bind="member.attachment_file"></span>  <a href="<?php echo Request::root().'/download?path=before_after_status_option_attachment&filename='?><%member.attachment_file%>" data-position="bottom" data-delay="50" data-tooltip="Download"><i class="glyphicon glyphicon-download-alt"></i></a>



                                      </li>
                                    </ul>


                                  </td>


                                  <td width="25%">PTR Document</td><!--insert status for varification-->
                                  <td width="25%">
                                    <%summeries.ptrapplicable%>
                                      <ul ng-repeat="member in summeries.ptrDocument" >

                                      <li ng-if="member.attachment_file!=''">
                                        <span ng-bind="member.attachment_file"></span>  <a href="<?php echo Request::root().'/download?path=PTRDocument&filename='?><%member.attachment_file%>" data-position="bottom" data-delay="50" data-tooltip="Download"><i class="glyphicon glyphicon-download-alt"></i></a>



                                      </li>
                                    </ul>
                                  </td>
                                </tr>
                                <tr>
                                  <td width="25%">Final Close status</td>
                                  <td width="25%" class="pd-none">
                                    <table class="borderd-cell">
                                      <td width="25%" class="pd-none">
                                        <table class="borderd-cell">
                                          <tr>
                                            <td width="50%" class="border-bottom" ng-if="summeries.final_closer.status==20"><%summeries.final_closer.status|Closerfiler%></td>

                                          </tr>
                                          <tr>
                                            <td width="50%" class="border-bottom" ng-if="summeries.final_closer.status==21"><%summeries.final_closer.status|Closerfiler%></td>

                                          </tr>
                                          <tr>
                                            <td width="50%" ng-if="summeries.final_closer.status==22 && summeries.final_closer.close==2"><%summeries.final_closer.status|Closerfiler%></td>

                                          </tr>
                                        </table>
                                      </td>

                                    </table>
                                  </td>
                                  <td width="25%"">Final Closer Comment</td>
                                  <td width="25%" class="pd-none">
                                    <%summeries.final_closer.comment%>
                                  </td>
                                </tr>

                              </tbody>
                            </table>

              </section>


            </div>
          </div>

          <div class="row mt-top">

            <div class="col-sm-6">
              <form action="<?php echo Request::root().'/changes/activity-completion-sheet/'.Request::segment(3); ?>/<?=Request::segment(4); ?>">

                <button class="btn btn-animate flat blue pd-btn pull-right" type="submit" >NEXT</button>
              </form>
            </div>

          </div>

        </div><!--/content-wrapper-->
      </div><!--/s10-->
    </div><!--/row-->

  </div><!--/container-->
</div><!--/main-wrapper-->

<?php require app_path().'/views/footer.php'; ?>
