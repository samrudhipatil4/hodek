  <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

   <!--  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,700,600italic,700italic,800"> -->
   
 <!--  <link rel="stylesheet" type="text/css" href="<?php echo Request::root(); ?>/protected/public/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="<?php echo Request::root(); ?>/protected/public/css/bootstrap.css">  
  <link rel="stylesheet" href="<?php echo Request::root(); ?>/protected/public/css/bootstrap-dropdown.css">
  <link href="<?php echo Request::root(); ?>/protected/public/css/font-awesome.min.css" rel="stylesheet">
  <link href="<?php echo Request::root(); ?>/protected/public/css/custom.css" rel="stylesheet">
  <link href="<?php echo Request::root(); ?>/protected/public/js/simply-toast.min.css" rel="stylesheet"> -->
<style type="text/css">
   thead { display:table-header-group }
   table tr  { page-break-inside:avoid }
  
 
</style>
</head>

<body>
  <div class="main-wrapper">
    <div class="container">

              <div class="row two-col-row mg-bottom-0">

                <div class="col-sm-12">
                    <div class="row mg-btm">
                      <div class="col-sm-6">
                        <div class="page-heading">
                          <h1 class="border-none">CM Record</h1>

                        </div><!--/page-heading-->
                      </div>
                      
                    </div>

                    <div class="seprator"></div>

                  <div class="content-wrapper">

                    <!-- view report -->
                    <div class="row mg-bottom-0">
                      <div class="col-sm-12">
                        <h4 class="border-none"><?php echo $summeries['count_request_is_rejected'];?></h4>
                        <div class="table-wrapper">
                           <table class="striped" border="1">
                              <tbody>
                                <tr>
                                  <td width="12.5%"><strong>Change Request No.</strong></td>
                                  <td width="12.5%"><span><?php echo $summeries['cmNo'];?></span></td>
                                  <td width="12.5%"><strong>Change Stage</strong></td>
                                  <td width="12.5%"><?php echo $summeries['stage_name'];?></td>
                                  <td width="12.5%"><strong> Business</strong></td>
                                  <td width="12.5%"><?php echo $summeries['business'];?></td>
                                  <td width="12.5%"><strong>Date</strong></td>
                                  <td width="12.5%"><?php echo $summeries['created_date'];?></td>
                                </tr>
                                <tr>
                                

                                   <td ><strong>Change Type</strong></td>
                                  <td colspan="3"><?php echo $summeries['change_type_name'];?></td>
                                  <td><strong>Change Sub Type</strong></td>
                                   <td colspan="3" class="pd-none">
                                     <?php $cnt=count( $summeries['changeSubType']); for($i=0;$i<$cnt;$i++){
                                       echo $summeries['changeSubType'][$i][0]->sub_type_name.'<br>';
                                      }?>
                                  </td>
                                </tr>
                                <tr>
                                <td><strong>Stakeholder</strong></td>
                                 <td><?php echo $summeries['stakeholder'];?></td>

                                  <td><strong>Part Name</strong></td>
                                  <td colspan="2"class="pd-none">

                                     <?php foreach ($parts as $row) {?>
                                    <ul class="listing">
                                      <li>
                                        <?php echo $row->part_name; ?>
                                        
                                      </li>

                                    </ul>
                                    <?php } ?>
                                  </td>
                                  <td><strong>Part Number</strong></td>
                                   <td colspan="3" class="pd-none">
                                    <?php foreach ($parts as $row) {?>
                                     <ul class="listing">
                                       <li>
                                        <?php echo $row->part_number; ?>
                                         
                                       </li>

                                          </ul>
                                           <?php } ?>
                                  </td>
                                </tr>
                                <tr>
                                 <td><strong>Project Code</strong></td>
                                 <td><?php echo $summeries['project_code'];?></td>
                                  <td><strong>Purpose</strong></td>
                                  <td colspan="2">
                                   <?php foreach ($summeries['change_purpose'] as $row) {?>
                                    <ul class="listing">
                                      <li>
                                        
                                        <?php echo $row['purpose_name']; ?>
                                      </li>
                                    </ul>
                                    <?php } ?>
                                   </td>
                                  <td><strong>Customer Name</strong></td>
                                  <td colspan="3">
                                    <?php foreach ($summeries['customers'] as $row) {?>
                                    <ul class="listing">
                                      <li>
                                      <?php echo $row['customer_name']; ?>
                                        
                                      </li>

                                    </ul>
                                    <?php } ?>
                                </tr>
                                <tr>
                                  <td colspan="2"><strong>Proposed Modifiaction Details</strong></td>
                                  <td colspan="7"><?php echo $summeries['Purpose_Modification_Details'];?></td>
                                </tr>
                                <tr>
                                  <td colspan="1"><strong>Remark</strong></td>
                                  <td colspan="4"><?php echo $summeries['remark'];?></td>
                                   <td colspan="1"><strong>Attachment</strong></td>
                                 <td colspan="3">
                                        <?php foreach ($summeries['get_change_request_attachment'] as $row) {?>
                                       <ul>
                                         <li>
                                           <span ></span> 

                                           <?php if(!empty($row)){ echo $row['attachment_file']; }?>
                                         </li>
                                       </ul>
                                       <?php } ?>
                                    </td>
                                </tr>

                                <tr>
                                  <td colspan="2"><strong>Requested By :</strong></td>
                                  <td colspan="2"><?php echo $summeries['initiator_name'];?></td>
                                  <td colspan="2"><strong>Department Head :</strong></td>
                                  <td colspan="2"><?php echo $summeries['authority_name'];?></td>
                                </tr>
                                <tr>
                                  <td colspan="1"><strong>Approval Response Date</strong></td>
                                  <td colspan="2"><?php echo $summeries['response_date'];?></td>
                                   <td colspan="1"><strong>HOD Approval Comment</strong></td>
                                   <td colspan="5"><?php echo $summeries['hodApproveComment'];?></td>
                                </tr>

                              </tbody>
                            </table>
                            </div>
                             <div class="table-wrapper">
                             <table class="striped" border="1">
                              <h3 align="center">Multidisciplinary approach for change</h3>

                              <tr>
                                <td><strong>Team Leader</strong></td>
                                <td><?php echo $summeries['teamleader']['name'];?></td>
                              </tr>

                              <tr>
                                <td width="10%" class="pd-none">
                                  <table border="1">
                                    <tr><td style="padding:5px 10px; border-bottom:1px solid #e5e5e5;"><strong>Function</strong></td></tr>
                                    <tr><td><strong>Team Member</strong></td></tr>
                                    <tr><td><strong>Project Manager Rejection Comment</strong></td></tr>
                                  </table>
                                </td>
                                <td width="90%" class="nested-table pd-none">
                                  <table class="bordered" border="1">
                                  <tbody><tr>
                                      <?php foreach ($team_members as $row) 
                                    
                                      {?>
                                      <td><strong><?php echo $row['d_name']; ?></strong></td>
                                      <?php } ?>
                                    </tr>
                                    <tr>
                                      <?php foreach ($team_members as $row) {?>
                                      <td><?php echo $row['first_name']." ".$row['last_name']; ?></td>
                                       <?php } ?>
                                    </tr>
                                     <tr>
                                      <?php foreach ($team_members as $row) {?>
                                      <?php if($summeries['prjMgrComment'] == ""){?>
                                      <td><?php echo $row['reject_reason']; ?></td>
                                       <?php  } } ?>
                                    </tr>
                                    </tbody></table>
                                </td>
                              </tr>

                              <tr>
                                <td colspan="2" class="pd-none ">
                                  <table class="borderd-cell" border="1">
                                    <tr class="border-bottom">
                                      <td width="25%"><strong>Current index level stock to be used until stock is zero</strong></td>
                                      <td width="75%" class=""><?php echo $summeries['lev'];?></td>
                                    </tr>
                                    <tr>
                                      <td><strong>Change implementation date of new index level</strong></td>
                                      <td class="pd-none ">
                                        <table class="borderd-cell" border="1">
                                          <tr>
                                            <td width="25%"><strong>Initiation Date</strong></td>
                                            <!--  <td width="25%"><my-date year="summeries.impdate"></my-date></td>-->
                                            <td width="25%"><?php echo $summeries['impdate'];?></td>
                                            <td width="25%"><strong>Current Stock</strong></td>
                                            <td width="25%"><?php echo $summeries['teamleader']['stock'];?></td>
                                          </tr>
                                        </table>
                                      </td>
                                    </tr>
                                  </table>
                                </td>
                              </tr>
                              <tr>
                                 <td colspan="2" class="pd-none" >
                                   <table class="borderd-cell" width="100%" border="1">
                                     <tr >
                                       <td width="10%"><strong>Project Manager</strong>
                                       <span><?php echo $summeries['projrct_mgr']; ?></span>
                                    </td>
                                    <td width="10%"><strong>Project Manager Approve Comment</strong>
                                       <span ><?php echo $summeries['prjMgrComment'];?></span>
                                    </td>
                                     </tr>
                                   </table>
                                 </td>
                               </tr>

						
                            </table>
                            </div>


                          <table border="1">

                            <h3 align="center" style="padding-bottom:0px;margin-bottom:0px;">Risk involvement  in change management</h3>
                          </table>
                          <div >
                          <?php foreach ($risksdatas1 as $risk) {?>
                             <uib-accordion close-others="oneAtATime">
                             <?php if ($risk['riskdata'] !='') {?>
                              <uib-accordion-group is-open="status.open">
                                <uib-accordion-heading>
                               <span><?php echo $risk['sub_dep_name']; ?> <i class="pull-right glyphicon" ng-class="{'glyphicon-triangle-top': status.open, 'glyphicon-triangle-bottom': !status.open}"></i></span>
                                </uib-accordion-heading>

                                <div class="table-wrapper" id="tab_container_<%risk.count%>" border="1">
                                  <table class="striped" border="1">
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
                                      <th>HOD Approval</th>
                                      <th>Attachment option</th>
                                     <!-- <th>Status</th>-->
                                      <th>Verification</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i=0; foreach ($risk['riskdata'] as $list) { ?>
                                    <tr>
                                      <td><span><?php echo $i=$i+1; ?></td>
                                      <td><span><?php echo $list['assessment_point']; ?></td>
                                      
                                       <?php if($list['applicability']==1){?>
                                       <td> <?php echo 'Yes'; ?></td>
                                       <?php } else{?>
                                        
                                        <td> <?php echo 'No'; ?> </td>
                                        <?php } ?>
                                      <td><span><?php echo $list['reason']; ?></td>
                                      <td><span><?php echo $list['de_risking']; ?></td>
                                      <td><span><?php echo $list['responsibility']['name']; ?></td>
                                      <td><span><?php echo $list['target_date']; ?></td>
                                      <td><span><?php echo $list['cost']; ?></td>
                                      <?php if(!empty($list['hod_approval'])){?>
                                      <?php if($list['hod_approval']->status==1){?>
                                       <td> <?php echo 'Yes'; ?></td>
                                       <?php } else{?>
                                        
                                        <td> <?php echo 'No'; ?> </td>
                                        <?php } ?>
                                        <?php }else{ ?>
                                        <td> <?php echo 'No'; ?> </td>
                                        <?php } ?>
                                        <td class="no-pd">
                                        <table border="1">
                                         <?php foreach ($list['attachments'] as $attchment) {?>
                                          <tr>
                                            <td>
                                            <?php echo $attchment['attachment_file']; ?><td>
                                          </tr>

                                    <?php } ?>
                                        </table>
                                      </td>
                                     <!-- <td></td>-->
                                      <?php if(!empty($list['verification_status'])){?>
                                      <?php if($list['verification_status']->status==1){?>
                                       <td> <?php echo 'Yes'; ?></td>
                                       <?php } else{?>
                                        
                                        <td> <?php echo 'No'; ?> </td>
                                        <?php } ?>
                                      <?php } else{?>
                                      <td> <?php echo 'No'; ?> </td>
                                      <?php } ?>
                                    </tr>
                                    <?php } ?>
                                    </tbody>

                                  </table>

                                </div><!--/table-wrapper-->

                              </uib-accordion-group>
                              <?php } ?>
                            </uib-accordion>
                            <?php } ?>

   </div><br>

                             <div class="table-wrapper">
                            <table class="striped mg-bottom-20" border="1">
                              <tbody>
                                <tr>
                                  <td width="25%">Cost Impact & Investment Details </td>
                                  <td width="25%"><?php echo $summeries['totalcost']; ?></td>
                                  <td width="25%">Steering Committee Members</td>
                                  <td width="25%" class="pd-none">
                                    <table border="1">
                                      <tbody>

                                       <?php foreach ($summeries['steering_commitee_member'] as $member) { ?>
                                      <tr>
                                           <td><strong><?php echo $member['name'][0]['name']; ?></strong></td>
                                             <?php if($member['sub_department_id']) {?>
                                            <?php if($member['approval_status'][0]['approval_status']==1){?>
                                            <td> <?php echo 'Approved'; ?></td>
                                            <?php } elseif($member['approval_status'][0]['approval_status']==2){?>
                                        
                                             <td> <?php echo 'Pending'; ?> </td>
                                            <?php }else{ ?>
                                              <td> <?php echo '--'; ?> </td>
                                            <?php }?> 
                                            <?php }?>                                                                             
                                      </tr>
                                      <?php }?>
                                    </tbody>
                                    </table>
                                  </td>
                                </tr>
                                <tr>
                                  <td class="pd-none">
                                    <table class="borderd-cell" border="1">
                                      <tr>
                                        <td width="50%">Customer To be Communicated</td>
                                        <td width="50%" style=":0px !important;">
                                          <ul class="listing no-list">
                                           <?php foreach ($summeries['customer_to_be_communicated'] as $customer) {?>
                                            <li>
                                            <?php if(!empty($customer['customer_name'])){?>
                                            <?php echo $customer['customer_name']['first_name']." ".$customer['customer_name']['last_name']; ?>
                                             
                                            </li>
                                            <?php } ?>
                                            <?php } ?>
                                          </ul>


                                        </td>
                                      </tr>
                                    </table>
                                  </td>
                                  <td class="pd-none">
                                    <table class="borderd-cell" border="1">
                                      <tr>
                                        <td width="50%">Responsibility to get Customer Approval</td>
                                        
                                        <td width="50%">
                                        
                                           <?php if(!empty($summeries['responsibility_to_get_customer_approval'])){ echo $summeries['responsibility_to_get_customer_approval']->first_name." ".$summeries['responsibility_to_get_customer_approval']->last_name; }?>
                                           
                                        </td>
                                      
                                      </tr>
                                    </table>
                                  </td>
                                  <td class="pd-none">
                                    <table class="borderd-cell" border="1">
                                      <tr>
                                        <td width="50%">Customer Approval Attachment</td>
                                        <td width="50%" class="no-pd" style=":0px !important;">
                                          <div class="form-wrapper" >


                                            <div class="row">
                                              <div class="col-sm-12">
                                                <div class="table-wrapper">
                                                  <table class="striped table-border" border="1">
                                                    <thead>
                                                    <tr class="bg-transparent">

                                                      <th >Customer Name</th>

                                                      <th width="30%">Attachments</th>
                                                      <th width="50%">Comment</th>

                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                     <?php foreach ($summeries['customer_approval_attachment'] as $customer) { ?>
                                                     <?php if(!empty($customer['customer_approval_attachment_status'])){ ?>
                                                    <tr>

                                                      <td >
                                                        <?php echo $customer['customer_approval_attachment_status']['FirstName']." ".$customer['customer_approval_attachment_status']['LastName'];?> 
                                                     </td>

                                                      <td class="no-pd">
                                                        <table border="1">
                                                           <?php foreach ($customer['customer_approval_attachment_status']['attachments'] as $attchment) {?>
                                                          <tr>
                                                            <td>
                                                               <?php echo $attchment['doc_name']; ?>
                                                              </td>

                                                          </tr>
                                                          <?php } ?>
                                                        </table>

                                                      </td>
                                                      <td class="no-pd">
                                                        <table border="1">
                                                        <?php foreach ($customer['customer_approval_attachment_status']['attachments'] as $attchment) {?>
                                                          <tr>
                                                            <td >
                                                             <?php echo $attchment['comment']; ?></td>
                                                          </tr>
                                                          <?php } ?>
                                                        </table>

                                                      </td>

                                                    </tr>
                                                    <?php } ?>
                                                    <?php } ?>
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
                                    <table class="borderd-cell" border="1">
                                      <tr>
                                        <td width="21%">Verification status</td>
                                        <?php if(!empty($summeries['verification_status'])){?>
                                        <?php if($summeries['verification_status']->status==1){?>
                                       <td> <?php echo 'Approved'; ?></td>
                                       <?php } elseif($summeries['verification_status']->status==2){?>
                                        
                                        <td> <?php echo 'Pending'; ?> </td>
                                        <?php } else{?>
                                        <td> <?php echo '--'; ?> </td>
                                        <?php } ?>
                                        <?php } ?>
                                        <!-- <td width="50%" style=":0px !important;"><%summeries.verification_status.status|STAPFLT%></td> -->
                                      </tr>
                                    </table>
                                  </td>

                                </tr>
                              </tbody>
                            </table>
                            </div>
                             <div class="table-wrapper">
                            <table class="striped mg-bottom-20" border="1">
                              <tbody>
                                <tr>
                                  <td width="25%">Horizontal Deployment</td>
                                  <td class="no-pd">
                                  <table class="" border="1">
                                    <tbody>
                                    <tr>
                                    <td width="70%" class="td_br">
                                    <?php if(!empty($summeries['hd1'])){?>
                                    <?php echo $summeries['hd1']; ?>
                                    <?php }?>
                                    </td>
                                    <td width="70%"></td>
                                    </tr>
                                    <tr>
                                      <td> Comment</td>
                                      <td> Reason</td>
                                    </tr>
                                    <tr>
                                    <?php if(!empty($summeries['hd'])){?>
                                      <td> <?php echo $summeries['hd']->comment; ?></td>
                                      <td> <?php echo $summeries['hd']->reason; ?></td>
                                      <?php }?>
                                    </tr>
                                    
                                    <tbody>
                                  </table>
                                  </td>
                                  <td width="25%">Change Implemented Date </td>
                                  <td width="25%"><?php echo $summeries['impdate']; ?></td>
                                </tr>
                                <tr>
                                  <td width="25%">Before After status Attachment Option</td>


                                  <td >
                                  <?php foreach ($summeries['before_after_attachement'] as $member) {?>
                                    <ul>

                                      <li>
                                        <span>
                                          <?php echo $member['attachment_file']; ?>
                                        </span>  
                                      </li>
                                    </ul>
                                    <?php } ?>
                                  </td>


                                  <td width="25%">PTR Document</td><!--insert status for varification-->
                                  <td width="25%">
                                  <?php foreach ($summeries['ptrDocument'] as $member) {?>
                                      <ul>

                                      <li>
                                        <span>
                                          <?php echo $member['attachment_file']; ?>
                                        </span>  
                                      </li>
                                    </ul>
                                    <?php } ?>
                                  </td>
                                </tr>
                                <tr>
                                  <td width="25%">Change status</td>
                                  <td width="25%" class="pd-none">
                                    <table class="borderd-cell" border="1">
                                      <td width="25%" class="pd-none">
                                        <table class="borderd-cell" border="1">
                                          <tr>
                                          
                                          <?php if ($summeries['final_closer']->status==20) {?>
                                            <td width="50%" class="border-bottom">
                                            <?php echo 'closed'; ?>
                                            </td>
                                            <?php } ?>
                                          </tr>
                                          <tr>
                                          <?php if ($summeries['final_closer']->status==21) {?>
                                            <td width="50%" class="border-bottom" ng-if="summeries.final_closer.status==21">
                                            <?php echo 'open'; ?></td>
                                            <?php } ?>
                                          </tr>
                                          <tr>
                                          <?php if ($summeries['final_closer']->status==22) {?>
                                            <td width="50%" ng-if="summeries.final_closer.status==22">
                                            <?php echo 'cancelled'; ?></td>
                                            <?php } ?>
                                          </tr>
                                        </table>
                                      </td>

                                    </table>
                                  </td>
                                  <td width="25%" colspan="2" style="text-align:right;"></td>
                                </tr>

                              </tbody>
                            </table>
                            </div>

                      </div>
                    </div>

                  </div><!--/content-wrapper-->
                </div><!--/s10-->
              </div><!--/row-->

      </div><!--/container-->
  </div><!--/main-wrapper-->
 
</body>
  