
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Email Template | CM</title>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,400italic,600italic' rel='stylesheet' type='text/css'>


    <style >
        .email-table {
            margin: 0 auto;
            font-family: 'Open Sans', sans-serif;

        }

        .email-table table thead tr th{
            background-color: transparent;
            color: #000;
            text-align: left;
            padding: 0px;
        }
        .email-table table thead tr th{
            padding: 5px 0px;
            font-size: 14px;
        }

        .email-table tfoot > tr > td  {

        }
        .borderd-table{
            border: 1px solid #e5e5e5 !important;
        }
        .borderd-table thead > tr > th {
            border-top: 0;
            border-right: 1px solid #e5e5e5;
            border-bottom: 2px solid #e5e5e5;
            border-left: 0;
            padding: 7px 5px !important;
            font-size: 12px !important;
        }
        .borderd-table tbody > tr > td {
            border-right: 1px solid #e5e5e5;
            border-bottom: 1px solid #e5e5e5;
            padding: 5px !important;
            font-size: 12px;
        }
        .borderd-table tbody > tr:last-child > td {
            border-bottom:0px;
        }
        .borderd-table tbody > tr > td:last-child, .borderd-table thead > tr > th:last-child  {
            border-right: 0;
        }

    </style>

</head>
<body>

<table class="striped">
                              <tbody>
                                <tr>
                                  <td width="12.5%"><strong>Change Request No.</strong></td>
                                   <td width="12.5%"><?php echo $cmNo;?></td></span></td>
                                  <td width="12.5%"><strong>Change Stage</strong></td>
                                     <td width="12.5%"><?php echo $stage_name;?></td>
                                  <td width="12.5%"><strong> Business</strong></td>
                                  <td width="12.5%"><?php echo $business;?></td>
                                  <td width="12.5%"><strong>Date</strong></td>
                                  <td width="12.5%"><?php echo $created_date;?></td>
                                </tr>
                                <tr>
                                

                                   <td ><strong>Change Type</strong></td>
                                  
                                  <td width="12.5%"><?php echo $change_type_name;?></td>
                                  <td><strong>Change Sub Type</strong></td>
                                   <td width="12.5%"><?php echo $changeSubType;?></td>

                                   
                                </tr>
                                <tr>
                                <td><strong>Stakeholder</strong></td>
                                 <td width="12.5%"><?php echo $stakeholder;?></td>
                                  <td><strong>Customer</strong></td>
                                 <td>
                                   <ul class="listing">
                                    <?php if(!empty($customers)) {foreach($customers as $cust){?>
                                    <li><?php echo $cust['customer_name'];?></li>
                                    <?php } }?>
                                </ul>
                                 </td>
                                 
                                </tr>
                                <tr>
                                 <td><strong>Project Code</strong></td>
                                
                                 <td width="12.5%"><?php echo $project_code;?></td>
                                 <td><strong>Part Name</strong></td>
                                 <td>
                                   <ul class="listing">
                                    <?php if(!empty($parts)){foreach($parts as $part){?>
                                    <li><?php echo $part->part_name;?></li>
                                    <?php }}?>
                                </ul>
                                 </td>
                                 <td><strong>Part number</strong></td>
                                 <td>
                                   <ul class="listing">
                                    <?php if(!empty($parts)){foreach($parts as $part){?>
                                    <li><?php echo $part->part_number;?></li>
                                    <?php }}?>
                                </ul>
                                 </td>

                                </tr>
                                <tr>
                                  <td colspan="2"><strong>Proposed Modifiaction Details</strong></td>
                                 
                                  <td width="12.5%"><?php echo $Purpose_Modification_Details;?></td>
                                  <td><strong>Purposer</strong></td>
                                 <td>
                                   <ul class="listing">
                                    <?php if(!empty($change_purpose)){foreach($change_purpose as $purpose){?>
                                    <li><?php echo $purpose['purpose_name'];?></li>
                                    <?php }}?>
                                </ul>
                                 </td>
                                </tr>
                                <tr>
                                  <td colspan="2"><strong>Remark</strong></td>
                                  
                                  <td width="12.5%"><?php echo $remark;?></td>
                                </tr>

                                <tr>
                                  <td colspan="2"><strong>Requested By :</strong></td>
                                  
                                  <td width="12.5%"><?php echo $initiator_name;?></td>
                                  <td colspan="2"><strong>Department Head :</strong></td>
                                 
                                   <td width="12.5%"><?php echo $authority_name;?></td>
                                </tr>
                                <tr>
                                  <td colspan="1"><strong>Approval Response Date</strong></td>
                                 
                                   <td width="12.5%"><?php echo $response_date;?></td>
                                   <td colspan="1"><strong>HOD Approval Comment</strong></td>
                                   
                                    <td width="12.5%"><?php echo $hodApproveComment;?></td>
                                </tr>

                              </tbody>
                            </table>
                              <table class="striped">
                              <caption align="top">Multidisciplinary approach for change</caption>

                              <tr>
                                <td><strong>Team Leader</strong></td>
                                <td><?php echo $teamleader['name'];?></td>
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
                                    <?php if(!empty($team_members)){foreach($team_members as $team){?>
                                      <td ><?php echo $team->d_name;?></td>
                                      <?php }}?>
                                    </tr>
                                    <tr>

                                     <?php if(!empty($team_members)){foreach($team_members as $team){?>
                                      <td ><?php echo $team->first_name.' '.$team->first_name;?></td>
                                      <?php }}?>
                                    </tr>
                                    </tbody></table>
                                </td>
                              </tr>

                              <tr>
                                <td colspan="2" class="pd-none ">
                                  <table class="borderd-cell">
                                    <tr class="border-bottom">
                                      <td width="25%"><strong>Current index level stock to be used until stock is zero</strong></td>
                                      <?php 
                                       if($index_level=='1'){ ?>
                                          <td width="75%" class=""><?php echo 'Yes';?></td>
                                          <?php }else if($index_level=='2'){ ?>
                                            <td width="75%" class=""><?php echo 'No';?></td> ?>
                                          <?php  }else{ ?>
                                           <td width="75%" class=""><?php ?></td> 
                                          <?php  }?>
                                     
                                    </tr>
                                    <tr>
                                      <td><strong>Change implementation date of new index level</strong></td>
                                      <td class="pd-none ">
                                        <table class="borderd-cell">
                                          <tr>
                                            <td width="25%"><strong>Initiation Date</strong></td>
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
                                 <td colspan="2" class="pd-none ">
                                   <table class="borderd-cell">

                                     <tr >
                                       <td width="30%"><strong>Attachment File</strong></td>
                                       <td width="70%">
                                       <ul  >
                                       <?php if(!empty($get_change_request_attachment)){?>

                                         <li>
                                           <span ng-bind="attachment_file"><?php echo $get_change_request_attachment;?></span>  <a href="<?php echo Request::root().'/Provision/download?path=changeRequest&filename='?><?php echo $get_change_request_attachment.'&rid='?> <%summeries.cmNo%><?php echo '&status=2'?>" data-position="bottom" data-delay="50" data-tooltip="Download"><i class="glyphicon glyphicon-download-alt"></i></a>



                                         </li>
                                         <?php }?>
                                       </ul>
                                    </td>
                                     </tr>

                                   </table>
                                 </td>
                               </tr>

                            </table>
                               <table border='1'>

                            <strong>Risk involvement  in change management</strong>
                          </table>


                          <div  >

                             
                                 <?php if(!empty($risksdatas1)) { foreach($risksdatas1 as $risk){ ?>
                             
                              
                               <span align="central"> <strong><?php echo $risk['sub_dep_name'];?></strong></span>
                               

                                <div class="table-wrapper" >
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
                                      
                                    </tr>
                                    </thead>
                                    <tbody>
                                    
                                    <?php  $i=0;
                                        foreach($risk['riskdata'] as $point) { 
                                            ?>
                                    <tr>
                                   
                                      <td><?php echo $i+1;?></td>
                                      <td><?php echo $point['assessment_point'];?></td>
                                      <td><?php if($point['applicability'] == 2){echo 'NO';}else{ echo 'YES';} ?></td>
                                      <td><?php echo $point['reason'];?></td>
                                      <td><?php echo $point['de_risking'];?></td>
                                      <td><?php echo $point['responsibility']['name']?></td>
                                      <td><?php echo $point['target_date'];?></td>
                                      <td><?php echo $point['cost'];?></td>
                                      <td><?php if($point['hod_approval']->status == 1){echo 'YES';}else{echo 'NO';}?></td>
                                     
                                      
                                      
                                    
                                    </tr>


                                    <?php $i++;} ?>
</tbody>
</table>

                                    <?php }  }?>
                                    

                                </div><!--/table-wrapper-->

                            


   </div>

</body>

</html>



