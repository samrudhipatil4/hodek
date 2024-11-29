
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Email Template | CM</title>
    
    <style >
        table, th, td {
    border: 0.5px solid grey;
    border-collapse: collapse;
  }
  table { page-break-after:auto }
    thead { display:table-header-group }
    tr    { page-break-inside:avoid }
    th    { page-break-inside:avoid }
    </style>

</head>
<body>

<table border="1" width="100%">
<caption style="font-size: 20px"><strong>Change Request Details</strong></caption>
    <tr>
     <td width="25%"><strong>Change Request No.</strong></td>
     <td width="25%"><?php echo $summeries['cmNo']?></td></span></td>
       <td width="25%"><strong>Change Stage</strong></td>
       <td width="25%"><?php echo $summeries['stage_name'];?></td>
    <tr>
   
     <tr>
     <td width="25%"><strong>Business</strong></td>
      <td width="25%"><?php echo $summeries['business'];;?></td>
       <td width="25%"><strong>Date</strong></td>
        <td width="25%"><?php echo $summeries['created_date'];?></td>
    </tr>
    <tr>
     <td width="25%"><strong>Change Type</strong></td>
      <td width="25%"><?php echo $summeries['change_type_name'];?></td>
       <td width="25%"><strong>Change Sub Type</strong></td>
        <td width="25%"><?php echo $summeries['changeSubType'];?></td>
    </tr>
    <tr>
        <td width="25%"><strong>Stakeholder</strong></td>
                                 <td width="25%"><?php echo $summeries['stakeholder'];?></td>
                                  <td width="25%"><strong>Customer</strong></td>
                                 <td width="25%">
                                   <ul class="listing">
                                    <?php if(!empty($summeries['customers'])) {foreach($summeries['customers'] as $cust){?>
                                    <li><?php echo $cust['customer_name'];?></li>
                                    <?php } }?>
                                </ul>
                                 </td>
    </tr>
    <tr>
        <td width="25%"><strong>Project Code</strong></td>
                                
                                 <td width="25%"><?php echo $summeries['project_code'];?></td>
                                 <td width="25%"><strong>Part Name</strong></td>
                                 <td width="25%">
                                   <ul class="listing">
                                    <?php if(!empty($parts)){foreach($parts as $part){?>
                                    <li><?php echo $part->part_name;?></li>
                                    <?php }}?>
                                </ul>
                                 </td>
    </tr>
    <tr>
         <td width="25%"><strong>Part number</strong></td>
                                 <td width="25%">
                                   <ul class="listing">
                                    <?php if(!empty($parts)){foreach($parts as $part){?>
                                    <li><?php echo $part->part_number;?></li>
                                    <?php }}?>
                                </ul>
                                 </td>
                                  <td width="25%"><strong>Proposed Modifiaction Details</strong></td>
                                 
                                  <td width="25%"><?php echo $summeries['Purpose_Modification_Details'];?></td>
    </tr>
    <tr>
      <td width="25%"><strong>Purpose</strong></td>
                                 <td width="25%">
                                   <ul class="listing">
                                    <?php if(!empty($summeries['change_purpose'])){foreach($summeries['change_purpose'] as $purpose){?>
                                    <li><?php echo $purpose['purpose_name'];?></li>
                                    <?php }}?>
                                </ul>
                                 </td>
                                  <td width="25%"><strong>Remark</strong></td>
                                  
                                  <td width="25%"><?php echo $summeries['remark'];?></td>
    </tr>
    <tr>
         <td width="25%"><strong>Requested By :</strong></td>
                                  
                                  <td width="25%"><?php echo $summeries['initiator_name'];?></td>
                                  <td width="25%"><strong>Department Head :</strong></td>
                                 
                                   <td width="25%"><?php echo $summeries['authority_name'];?></td>
    </tr>
    <tr>
     <td width="25%"><strong>Approval Response Date</strong></td>
                                 
                                   <td width="25%"><?php echo $summeries['response_date'];?></td>
                                   <td width="25%"><strong>HOD Approval Comment</strong></td>
                                   
                                    <td width="25%"><?php echo $summeries['hodApproveComment'];?></td>
    </tr>
  
</table >
                <table width="100%" border="1" width="100%">
                <caption style="font-size: 20px"><strong><br>Multidisciplinary approach for change</strong>   
                <tr>
                <?php $cnt=0;if(!empty($summeries['team_members'])){ foreach($summeries['team_members'] as $team) { $cnt=$cnt+1; ?>
                                     
                                      <?php } } ?>
                 <td ><strong>Team Leader</strong></td>
                                                <td colspan="<?php echo $cnt;?>"><?php echo $summeries['teamleader']['name'];?></td>
                </tr> 
                 <tr>
                                <td  >
                                 
                                  <strong>Function</strong></td>
                                   
                                 
                                   
                                    <?php if(!empty($team_members)){foreach($team_members as $team){ ?>
                                      <td ><?php echo $team->d_name;?></td>
                                      <?php }}?>
                                    
                              </tr>
                              <tr>
                                <td  >
                                 
                                  <strong>Team Member</strong></td>
                                   
                                 
                                   
                                    <?php if(!empty($team_members)){foreach($team_members as $team){ ?>
                                      <td ><?php echo $team->first_name.' '.$team->last_name;?></td>
                                      <?php }}?>
                                    
                              </tr>
                                 <tr>
                
                 <td ><strong>Current index level stock to be used until stock is zero</strong></td>
                                                <?php 
                                       if($summeries['index_level']=='1'){ ?>
                                          <td colspan="<?php echo $cnt;?>"><?php echo 'Yes';?></td>
                                          <?php }else if($summeries['index_level']=='2'){ ?>
                                            <td colspan="<?php echo $cnt;?>"><?php echo 'No';?></td> ?>
                                          <?php  }else{ ?>
                                           <td colspan="<?php echo $cnt;?>"><?php ?></td> 
                                          <?php  }?>
                </tr> 
                  <tr><td><strong>
                Change implementation date of new index level</strong></td>
                                                <td><strong>Initiation Date</strong></td>
                                                 <td ><?php echo $summeries['impdate'];?></td>
                                                  <td><strong>Current Stock</strong></td>
                                                 <td ><?php echo $summeries['teamleader']['stock'];?></span></></td>
                </tr> 
                <tr>
                  <td>
                    <table border="1" width="100%"><tr>
                      <td width="30"><strong>Cost Impact & Investment Details</strong></td>
                      <td width="70"><?php echo $summeries['totalcost'];?></td>
                    </tr></table>
                  </td>
                </tr>

</table>
<table border="1" width="100%">
 <caption style="font-size: 20px"><strong>Risk involvement in change management</strong> 
<tr><td>
    <?php if(!empty($summeries['risksdatas1'])) {  foreach($summeries['risksdatas1'] as $risk){ ?>
                             
                              
                               <span align="central" style="font-size: 20px;display:inline-block;margin-bottom: 10px;margin-top: 20px"> <strong><?php echo $risk['sub_dep_name'];?></strong></span></td>
                               <table border="1" width="100%">
                                <tr>
                                      <td width="3%"><strong>Sr. No.</strong></td>
                                      <td width="27%"><strong>Risk Assessment Points</strong></td>
                                      <td width="5%"><strong>Applicability</strong></td>
                                      <td width="10%"><strong>If No, Please specify the reason</strong></td>
                                      <td width="15%"><strong>If Yes, Please mention the De-Risking action</strong></td>
                                      <td width="13%"><strong>Responsibility</strong></td>
                                      <td width="7%"><strong>Target date</strong></td>
                                      <td width="10%"><strong>Any Cost Involved</strong></td>
                                      <td width="10%"><strong>HOD Approval</strong></td>              
                                      
                                 </tr>
                                </table>

                                <div>
                                  <table border="1" width="100%">
                                    
                                    <?php  $i=0;
                                        foreach($risk['riskdata'] as $point) { 
                                            ?>
                                    <tr>
                                   
                                      <td width="3%"><?php echo $i+1;?></td>
                                      <td width="27%"><?php echo $point['assessment_point'];?></td>
                                      <td width="5%"><?php if($point['applicability'] == 2){echo 'NO';}else{ echo 'YES';} ?></td>
                                      <td width="10%"><?php echo $point['reason'];?></td>
                                      <td width="15%"><?php echo $point['de_risking'];?></td>
                                      <td width="13%"><?php echo $point['responsibility']['name']?></td>
                                      <td width="7%"><?php echo $point['target_date'];?></td>
                                      <td width="10%"><?php echo $point['cost'];?></td>
                                      <td width="10%"><?php if($point['hod_approval']->status == 1){echo 'YES';}else{echo 'NO';}?></td>
                                    
                                    </tr>


                                    <?php $i++;} ?>
</table>

                                    <?php }  }?>
</td>
</tr>
</table>

 
</body>

</html>



