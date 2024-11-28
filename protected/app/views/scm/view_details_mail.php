  <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

   <!--  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,700,600italic,700italic,800"> -->
   
  <link rel="stylesheet" type="text/css" href="<?php echo Request::root(); ?>/protected/public/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="<?php echo Request::root(); ?>/protected/public/css/bootstrap.css">  
  <link rel="stylesheet" href="<?php echo Request::root(); ?>/protected/public/css/bootstrap-dropdown.css">
  <link href="<?php echo Request::root(); ?>/protected/public/css/font-awesome.min.css" rel="stylesheet">
  <link href="<?php echo Request::root(); ?>/protected/public/css/custom.css" rel="stylesheet">
  <link href="<?php echo Request::root(); ?>/protected/public/js/simply-toast.min.css" rel="stylesheet">
<style type="text/css">
   table    { page-break-inside:avoid }
  
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
                           <table class="striped">
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
                                     <?php echo $summeries['changeSubType'];?>
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
                                  <td colspan="2"><strong>Remark</strong></td>
                                  <td colspan="7"><?php echo $summeries['remark'];?></td>
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
                             <table class="striped">
                              <h3 align="center">Multidisciplinary approach for change</h3>

                              <tr>
                                <td><strong>Team Leader</strong></td>
                                <td><?php echo $summeries['teamleader']['name'];?></td>
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
                                      <?php foreach ($team_members as $row) 
                                      
                                      {?>
                                      <td><strong><?php echo $row->d_name; ?></strong></td>
                                      <?php } ?>
                                    </tr>
                                    <tr>
                                      <?php foreach ($team_members as $row) {?>
                                      <td><?php echo $row->first_name." ".$row->last_name; ?></td>
                                       <?php } ?>
                                    </tr>
                                    </tbody></table>
                                </td>
                              </tr>

                              <tr>
                                <td colspan="2" class="pd-none ">
                                  <table class="borderd-cell">
                                    <tr class="border-bottom">
                                      <td width="25%"><strong>Current index level stock to be used until stock is zero</strong></td>
                                      <td width="75%" class=""><?php echo $summeries['lev'];?></td>
                                    </tr>
                                    <tr>
                                      <td><strong>Change implementation date of new index level</strong></td>
                                      <td class="pd-none ">
                                        <table class="borderd-cell">
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
                                 <td colspan="2" class="pd-none ">
                                   <table class="borderd-cell">

                                     <tr >
                                       <td width="30%"><strong>Attachment File</strong></td>
                                       <td width="70%">
                                        <?php foreach ($summeries['get_change_request_attachment'] as $row) {?>
                                       <ul>
                                         <li>
                                           <span ></span> 
                                           <?php echo $row->attachment_file; ?>
                                         </li>
                                       </ul>
                                       <?php } ?>
                                    </td>
                                     </tr>

                                   </table>
                                 </td>
                               </tr>

                            </table>
                            </div>


                          <table >

                            <h3 align="center" style="padding-bottom:0px;margin-bottom:0px;">Risk involvement  in change management</h3>
                          </table>
                          <div >
                          <?php foreach ($risksdatas1 as $risk) {?>
                             <?php if ($risk['riskdata'] !='') {?>
                               <span><?php echo $risk['sub_dep_name']; ?> <i class="pull-right glyphicon" ng-class="{'glyphicon-triangle-top': status.open, 'glyphicon-triangle-bottom': !status.open}"></i></span><br>

                                <div class="table-wrapper" id="tab_container_<%risk.count%>">
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
                                      <th>HOD Approval</th>
                                      <th>Attachment option</th>
                                     <!-- <th>Status</th>-->
                                      <th>Verification</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($risk['riskdata'] as $list) { $index =0;?>
                                    <tr>
                                      <td><span><?php echo $index+1; ?></td>
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
                                        <table>
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

                              <?php } ?>
                            <?php } ?>

   </div><br>

                             
                             

                      </div>
                    </div>

                  </div><!--/content-wrapper-->
                </div><!--/s10-->
              </div><!--/row-->

      </div><!--/container-->
  </div><!--/main-wrapper-->
 
</body>
  