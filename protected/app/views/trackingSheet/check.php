<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,700,600italic,700italic,800">

   
</head>

<body style="font-family: 'Open Sans',sans-serif; font-weight: normal; margin:0 auto;font-size:10px;">




<div style="width:100% height:auto;overflow-x:scroll;">
    <table style="font-size:10px;border-spacing:0;width:100%;max-width:100%;overflow-x:auto;table-layout:auto;border-bottom:1px solid #e5e5e5;">
        <thead>
        <tr>
        <?php $cnt=0;
                                foreach ($allDepartment as $row) {
                                        $cnt++;

                                 } 
                                ?>
            <th colspan="4"></th>
            <th colspan="<?=$cnt;?>" style="border:1px solid #E5E5E5;border-bottom:none;text-align:center;padding:5px;color:#77788D;">Risk Analysis</th>
            <th colspan="7"></th>
            <th colspan="<?=$cnt;?>" style="border:1px solid #E5E5E5;border-bottom:none;text-align:center;padding:5px;color:#77788D;">Activity Status</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td  width="40" style="color:#38393A;border:1px solid #E5E5E5;border-right:none;font-weight:600;padding:10px;text-align:left;vertical-align: bottom;display:table-cell;padding: 15px 5px;">CM No.</td>

            <td  width="40" style="color:#38393A;border:1px solid #E5E5E5;font-weight: 600;padding:15px 3px;  text-align: left;vertical-align: bottom;display:table-cell;border-right:none;">Initiation date</td>

            <td  width="70" style="color:#38393A;border:1px solid #E5E5E5;font-weight: 600;border-right:none;overflow-x:auto;vertical-align: bottom;padding:15px 3px;">HOD Approval</td>

            <td  width="70" style="color:#38393A;border:1px solid #E5E5E5;font-weight: 600;padding:5px;
               text-align: left;vertical-align: bottom;display: table-cell;padding: 15px 5px;border-right:none;">Define Cross Functional Team</td>

            

            <?php foreach ($allDepartment as $row) {?>
                                              <td width="160" style="height:170px;text-align: center !important;vertical-align: bottom;white-space:nowrap;border:1px solid #E5E5E5;padding-bottom: 10px;border-right:none;"><span style="color: #38393A;display: block !important;margin: 0 0 50px;transform: rotate(-90deg);width:12%;font-weight:600;"><?php echo $row->d_name; ?></span></td>
                                           <?php } ?>
                                           <td width="50" style="height:170px;text-align: center !important;vertical-align: bottom;white-space:nowrap;border:1px solid #E5E5E5;padding-bottom: 10px;border-right:none;"><span style="color: #38393A;display: block !important;margin: 0 0 45px;transform: rotate(-90deg);width:12%;font-weight:600;">Risk Approval Superadmin
</span></td>

            <td width="70" style="height:170px;text-align: center !important;vertical-align: bottom;white-space:nowrap;border:1px solid #E5E5E5;padding-bottom: 10px;border-right:none;"><span style="color: #38393A;display: block !important;margin: 0 0 55px;transform: rotate(-90deg);width:12%;font-weight:600;">Steering Committee <br>Approval</span></td>
           
            <td width="80" style="height:170px;text-align: center !important;vertical-align: bottom;white-space:nowrap;border:1px solid #E5E5E5;padding-bottom: 10px;border-right:none;"><span style="color: #38393A;display: block !important;margin: 0 0 45px;transform: rotate(-90deg);width:12%;font-weight:600;">Customer Evidance Upload</span></td>

           

               
            <?php foreach ($allDepartment as $row) {?>
                                           <td width="80" style="height:170px;text-align: center !important;vertical-align: bottom;white-space:nowrap;border:1px solid #E5E5E5;padding-bottom: 10px;border-right:none;"><span style="color: #38393A;display: block !important;margin: 0 0 50px;transform: rotate(-90deg);width: 20px;font-weight:600;"><?php echo $row->d_name; ?></span></td>
                                       <?php } ?>

  <td width="80" style="height:170px;text-align: center !important;vertical-align: bottom;white-space:nowrap;border:1px solid #E5E5E5;padding-bottom: 10px;border-right:none;"><span style="color: #38393A;display: block !important;margin: 0 0 45px;transform: rotate(-90deg);width:12%;font-weight:600;">Document Verification Status</span></td>
    <td width="80" style="height:170px;text-align: center !important;vertical-align: bottom;white-space:nowrap;border:1px solid #E5E5E5;padding-bottom: 10px;border-right:none;"><span style="color: #38393A;display: block !important;margin: 0 0 45px;transform: rotate(-90deg);width:12%;font-weight:600;">Horizontal Deployment</span></td>
      <td width="80" style="height:170px;text-align: center !important;vertical-align: bottom;white-space:nowrap;border:1px solid #E5E5E5;padding-bottom: 10px;border-right:none;"><span style="color: #38393A;display: block !important;margin: 0 0 45px;transform: rotate(-90deg);width:12%;font-weight:600;">Change Cut-Off Date & <br>Before After Status</span></td>
        <td width="80" style="height:170px;text-align: center !important;vertical-align: bottom;white-space:nowrap;border:1px solid #E5E5E5;padding-bottom: 10px;border-right:none;"><span style="color: #38393A;display: block !important;margin: 0 0 45px;transform: rotate(-90deg);width:12%;font-weight:600;">Final Closure</span></td>

        </tr>
        <tr>
        <td   style="border: 1px solid #ddd;"></td>
        <td   style="border-collapse: collapse;border: 1px solid #ddd;"></td>
        <td style="border-collapse: collapse;border: 1px solid #ddd;">
            <table>
                <tr>
                    <td  style="text-align:center;padding-right: 20px;">Target Date</td>
                    <td  style="text-align:center;">Actual Date</td>
                </tr>
            </table>
        </td>
        <td style="border: 1px solid #ddd;">
            <table>
                <tr>
                    <td  style="text-align:center;padding-right: 20px;">Target Date</td>
                    <td  style="text-align:center;">Actual Date</td>
                </tr>
            </table>
        </td>
        <?php foreach ($allDepartment as $row) {?>
        <td  style="border: 1px solid #ddd;">
            <table>
                <tr>
                    <td style="text-align:center;padding-right: 20px;">Risk Entry</td>
                    <td style="text-align:center;">Risk HOD Approval</td>
                </tr>
                <tr>
                <td>
                    <table>
                        <tr>
                             <td  style="text-align:center;padding-right: 20px;">Target Date</td>
                    <td  style="text-align:center;">Actual Date</td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table>
                        <tr>
                            <td  style="text-align:center;padding-right: 20px;">Target Date</td>
                    <td  style="text-align:center;">Actual Date</td>
                        </tr>
                    </table>
                </td>
                </tr>
            </table>
        </td>
        <?php }?>
        <td style="border: 1px solid #ddd;">
            <table>
                <tr>
                    <td  style="text-align:center;padding-right: 20px;">Target Date</td>
                    <td  style="text-align:center;">Actual Date</td>
                </tr>
            </table>
        </td>
        
        <td style="border: 1px solid #ddd;">
            <table>
                <tr>
                    <td  style="text-align:center;padding-right: 20px;">Target Date</td>
                    <td  style="text-align:center;">Actual Date</td>
                </tr>
            </table>
        </td>
        
       
        <td style="border: 1px solid #ddd;">
            <table>
                <tr>
                    <td  style="text-align:center;padding-right: 20px;">Target Date</td>
                    <td  style="text-align:center;">Actual Date</td>
                </tr>
            </table>
        </td>
       
         <?php foreach ($allDepartment as $row) {?>
        <td style="border: 1px solid #ddd;">
            <table>
                <tr>
                    <td  style="text-align:center;padding-right: 20px;">Target Date</td>
                    <td  style="text-align:center;">Actual Date</td>
                </tr>
            </table>
        </td>
        <?php }?>
         <td>
                    <table>
                        <tr>
                             <td  style="text-align:center;padding-right: 20px;">Target Date</td>
                    <td  style="text-align:center;">Actual Date</td>
                        </tr>
                    </table>
                </td>
                 <td>
                    <table>
                        <tr>
                             <td  style="text-align:center;padding-right: 20px;">Target Date</td>
                    <td  style="text-align:center;">Actual Date</td>
                        </tr>
                    </table>
                </td>
                 <td>
                    <table>
                        <tr>
                             <td  style="text-align:center;padding-right: 20px;">Target Date</td>
                    <td  style="text-align:center;">Actual Date</td>
                        </tr>
                    </table>
                </td>
                 <td>
                    <table>
                        <tr>
                             <td  style="text-align:center;padding-right: 20px;">Target Date</td>
                    <td  style="text-align:center;">Actual Date</td>
                        </tr>
                    </table>
                </td>

        </tr>
        <?php if(sizeof($data)>0){

                        $i=1;
                        foreach($data as $sheet){  ?>
                       <tr>
                          <td style="text-align:center;"> <?php echo $sheet['cmNo'];?><span><br><?php echo $sheet['count_request_is_rejected'];?></span></td>
                          <td style="text-align:center;"> <?php echo $sheet['initiatin_date'];?></td>
                          <td>
                            <table>
                            <tr>
                            <?php foreach ($sheet['hod_approval'] as $row) { ?>
                            <?php if($row['target_date'] !=""){
                                    if($row['actual_date'] !=""){?>
                                    <?php if(date("d-m-y", strtotime($row['actual_date'])) > date("d-m-y", strtotime($row['target_date']))){ ?>
                                    <td style="padding: 0px 2px 0px 5px;background-color: #bc150d;color:#ffffff"><?php echo $row['target_date']; ?></td>
                                    <td style="background-color: #bc150d;color:#ffffff"><?php echo  $row['actual_date']; ?></td>
                                    <?php }else{?>
                                    <td style=" padding: 0px 2px 0px 5px;"><?php echo  $row['target_date']; ?></td>
                                    <td ><?php echo  $row['actual_date']; ?></td>
                            <?php } }else{?>
                                    <?php if(date("d-m-y", strtotime(date('d-m-y'))) > date("d-m-y", strtotime($row['target_date']))){ ?>
                                    <td style="padding: 0px 2px 0px 5px;background-color: #bc150d;color:#ffffff"><?php echo $row['target_date']; ?></td>
                                    <td style="background-color: #bc150d;color:#ffffff"><?php echo  $row['actual_date']; ?></td>
                                    <?php }else{?>
                                    <td style=" padding: 0px 2px 0px 5px;"><?php echo  $row['target_date']; ?></td>
                                    <td ><?php echo  $row['actual_date']; ?></td>
                            <?php }?>

                            <?php }}?> 
                            
                            <?php }?>
                            </tr>
                            </table>
                          </td>
                          <td>
                            <table>
                            <tr>
                            <?php foreach ($sheet['initialInformation'] as $row) { ?>
                             
                            <?php if($row['target_date'] !=""){
                                    if($row['actual_date'] !=""){?>
                                    <?php if(date("d-m-y", strtotime($row['actual_date'])) > date("d-m-y", strtotime($row['target_date']))){ ?>
                                    <td style="padding: 0px 2px 0px 5px;background-color: #bc150d;color:#ffffff"><?php echo $row['target_date']; ?></td>
                                    <td style="background-color: #bc150d;color:#ffffff"><?php echo  $row['actual_date']; ?></td>
                                    <?php }else{?>
                                    <td style=" padding: 0px 2px 0px 5px;"><?php echo  $row['target_date']; ?></td>
                                    <td ><?php echo  $row['actual_date']; ?></td>
                            <?php } }else{?>
                                    <?php if(date("d-m-y", strtotime(date('d-m-y'))) > date("d-m-y", strtotime($row['target_date']))){ ?>
                                    <td style="padding: 0px 2px 0px 5px;background-color: #bc150d;color:#ffffff"><?php echo $row['target_date']; ?></td>
                                    <td style="background-color: #bc150d;color:#ffffff"><?php echo  $row['actual_date']; ?></td>
                                    <?php }else{?>
                                    <td style=" padding: 0px 2px 0px 5px;"><?php echo  $row['target_date']; ?></td>
                                    <td ><?php echo  $row['actual_date']; ?></td>
                            <?php }?>

                            <?php }}?> 
                            <?php }?>
                            </tr>
                            </table>
                          </td>
                          <?php 
                        
                         foreach($allDepartment as $dept){  $department='';?>
                         <td>
                              <table>
                              <tr>
                             <?php 
                         if(!empty($sheet['riskEntry'])){ 
                          $x=0;

                              foreach($sheet['riskEntry'] as $status){
                               // print_r($status['process']);exit;
                               $DeptId = explode(' ',$status['process']);
                               
                         
                                  if($dept->d_id ===(int)$DeptId[2]){
                                      
                                      break;
                                  }else{
                                      $x++;
                                  }
                                  
                              }
                          
                           if(isset($sheet['riskEntry'][$x]['actual_date'])){ 
                              ?> 
                              <?php if(isset($sheet['riskEntry'][$x]['actual_date'])){ 
                                  ?> 
                                   <?php if($sheet['riskEntry'][$x]['target_date'] !=""){
                                    if($sheet['riskEntry'][$x]['actual_date'] !=""){?>
                                  <?php if(date("d-m-y", strtotime($sheet['riskEntry'][$x]['actual_date'])) > date("d-m-y", strtotime($sheet['riskEntry'][$x]['target_date']))){ ?>

                                     <td style="padding: 0px 2px 0px 5px;background-color: #bc150d;color:#ffffff">
                                  <?php echo $sheet['riskEntry'][$x]['target_date'];?> 
                                  </td>
                            <td style="padding: 0px 2px 0px 5px;background-color: #bc150d;color:#ffffff"><?php echo  $sheet['riskEntry'][$x]['actual_date']; ?></td>

                            <?php }else{?>
                               <td style="padding: 0px 2px 0px 5px;">
                                  <?php echo $sheet['riskEntry'][$x]['target_date'];?> 
                                  </td>
                               <td style="padding: 0px 2px 0px 5px;"><?php echo  $sheet['riskEntry'][$x]['actual_date']; ?></td>

                            <?php } }else{ ?>
                                <?php if(date("d-m-y", strtotime(date('d-m-y'))) > date("d-m-y", strtotime($sheet['riskEntry'][$x]['target_date']))){ ?>

                                     <td style="padding: 0px 2px 0px 5px;background-color: #bc150d;color:#ffffff">
                                  <?php echo $sheet['riskEntry'][$x]['target_date'];?> 
                                  </td>
                            <td style="padding: 0px 2px 0px 5px;background-color: #bc150d;color:#ffffff"><?php echo  $sheet['riskEntry'][$x]['actual_date']; ?></td>

                            <?php }else{?>
                               <td style="padding: 0px 2px 0px 5px;">
                                  <?php echo $sheet['riskEntry'][$x]['target_date'];?> 
                                  </td>
                               <td style="padding: 0px 2px 0px 5px;"><?php echo  $sheet['riskEntry'][$x]['actual_date']; ?></td>

                            <?php }?>
                           <?php }   }?>
                                   
                              <?php } else {?> 
                                  <td></td> 
                                  <td></td> 
                              <?php }?> 
                          <?php }else{ $department = 'NO'; ?>
                                      <td  style=" padding: 0px 2px 0px 25px;" >N/A</td>
                                      <td  style=" padding: 0px 2px 0px 25px;">N/A</td>  
                                 <?php  } } ?>
                                 <?php 
                                 if($department == 'NO'){ ?>
                                      <td  style=" padding: 0px 2px 0px 25px;" >N/A</td>
                                      <td  style=" padding: 0px 2px 0px 25px;">N/A</td> 
                                  <?php }else{
                                 if(!empty($sheet['riskEntryHodApp'])){ 
                          $y=0;

                              foreach($sheet['riskEntryHodApp'] as $status){
                               // print_r($status['process']);exit;
                               $deptId = explode(' ',$status['process']);
                               
                                 
                                  if($dept->d_id ===(int)$deptId[4]){
                                      
                                      break;
                                  }else{
                                      $y++;
                                  }
                              
                              }
                          
                           if(isset($sheet['riskEntryHodApp']) ){ 
                              ?> 
                              <?php if(isset($sheet['riskEntryHodApp'][$y]['actual_date'])){ 
                                  ?> 
                                   <?php if($sheet['riskEntryHodApp'][$y]['target_date'] !=""){
                                    if($sheet['riskEntryHodApp'][$y]['actual_date'] !=""){?>
                                 <?php if(date("d-m-y", strtotime($sheet['riskEntryHodApp'][$y]['actual_date'])) > date("d-m-y", strtotime($sheet['riskEntryHodApp'][$y]['target_date']))){ ?>
                                  <td style="padding: 0px 2px 0px 5px;background-color: #bc150d;color:#ffffff">
                                  <?php echo $sheet['riskEntryHodApp'][$y]['target_date'];?> 
                                  </td>
                            <td style="padding: 0px 2px 0px 5px;background-color: #bc150d;color:#ffffff"><?php echo  $sheet['riskEntryHodApp'][$y]['actual_date']; ?></td>
                            
                            <?php }else{?>
                               <td style="padding: 0px 2px 0px 5px;">
                                  <?php echo $sheet['riskEntryHodApp'][$y]['target_date'];?> 
                                  </td>
                               <td style="padding: 0px 2px 0px 5px;"><?php echo  $sheet['riskEntryHodApp'][$y]['actual_date']; ?></td>

                            <?php } }else{?>
                                 <?php if(date("d-m-y", strtotime(date('d-m-y'))) > date("d-m-y", strtotime($sheet['riskEntryHodApp'][$y]['target_date']))){ ?>
                                  <td style="padding: 0px 2px 0px 5px;background-color: #bc150d;color:#ffffff">
                                  <?php echo $sheet['riskEntryHodApp'][$y]['target_date'];?> 
                                  </td>
                            <td style="padding: 0px 2px 0px 5px;background-color: #bc150d;color:#ffffff"><?php echo  $sheet['riskEntryHodApp'][$y]['actual_date']; ?></td>
                            
                            <?php }else{?>
                               <td style="padding: 0px 2px 0px 5px;">
                                  <?php echo $sheet['riskEntryHodApp'][$y]['target_date'];?> 
                                  </td>
                               <td style="padding: 0px 2px 0px 5px;"><?php echo  $sheet['riskEntryHodApp'][$y]['actual_date']; ?></td>
                              <?php } } }?>
                                  
                              <?php } else {?> 
                                  <td></td> 
                                  <td></td> 
                              <?php }?> 
                          <?php }else{ ?>
                                      <td  style=" padding: 0px 2px 0px 5px;">N/A</td>
                                      <td style=" padding: 0px 2px 0px 5px;">N/A</td>  
                                 <?php  }  }else{?>
                                    <td  style=" padding: 0px 2px 0px 5px;"></td>
                                      <td style=" padding: 0px 2px 0px 5px;"></td> 
                                    <?php } }?>
                              </tr>
                              </table>
                          </td>
                      <?php } ?>
                      <td>
                            <table>
                            <tr>
                            <?php foreach ($sheet['adminRiskapp'] as $row) { ?>
                             
                            <?php if($row['target_date'] !=""){
                                    if($row['actual_date'] !=""){?>
                                    <?php if(date("d-m-y", strtotime($row['actual_date'])) > date("d-m-y", strtotime($row['target_date']))){ ?>
                                    <td style="padding: 0px 1px 0px 3px;background-color: #bc150d;color:#ffffff"><?php echo $row['target_date']; ?></td>
                                    <td style="background-color: #bc150d;color:#ffffff"><?php echo  $row['actual_date']; ?></td>
                                    <?php }else{?>
                                    <td style=" padding: 0px 1px 0px 3px;"><?php echo  $row['target_date']; ?></td>
                                    <td ><?php echo  $row['actual_date']; ?></td>
                            <?php } }else{?>
                                    <?php if(date("d-m-y", strtotime(date('d-m-y'))) > date("d-m-y", strtotime($row['target_date']))){ ?>
                                    <td style="padding: 0px 1px 0px 3px;background-color: #bc150d;color:#ffffff"><?php echo $row['target_date']; ?></td>
                                    <td style="background-color: #bc150d;color:#ffffff"><?php echo  $row['actual_date']; ?></td>
                                    <?php }else{?>
                                    <td style=" padding: 0px 1px 0px 3px;"><?php echo  $row['target_date']; ?></td>
                                    <td ><?php echo  $row['actual_date']; ?></td>
                            <?php }?>

                            <?php }}?> 
                            <?php }?>
                            </tr>
                            </table>
                          </td>
                           <?php foreach ($sheet['steerComApp'] as $row) { ?>

                          
                          <td>
                            <table>
                                <tr>
                                   <?php if($row['target_date'] !=""){
                                    if($row['actual_date'] !=""){?>
                                    <?php if(date("d-m-y", strtotime($row['actual_date'])) > date("d-m-y", strtotime($row['target_date']))){ ?>
                                    <td style="padding: 0px 10px 0px 3px;background-color: #bc150d;color:#ffffff"><?php echo $row['target_date']; ?></td>
                                    <td style="background-color: #bc150d;color:#ffffff"><?php echo  $row['actual_date']; ?></td>
                                    <?php }else{?>
                                    <td style=" padding: 0px 10px 0px 3px;"><?php echo  $row['target_date']; ?></td>
                                    <td ><?php echo  $row['actual_date']; ?></td>
                            <?php } }else{?>
                                    <?php if(date("d-m-y", strtotime(date('d-m-y'))) > date("d-m-y", strtotime($row['target_date']))){ ?>
                                    <td style="padding: 0px 10px 0px 3px;background-color: #bc150d;color:#ffffff"><?php echo $row['target_date']; ?></td>
                                    <td style="background-color: #bc150d;color:#ffffff"><?php echo  $row['actual_date']; ?></td>
                                    <?php }else{?>
                                    <td style=" padding: 0px 10px 0px 3px;"><?php echo  $row['target_date']; ?></td>
                                    <td ><?php echo  $row['actual_date']; ?></td>
                            <?php }?>

                            <?php }}?> 
                                </tr>
                            </table>
                          </td>
                          <?php } ?>
                          
                          <td>
                            <table>
                            <tr>
                            <?php foreach ($sheet['custEvdienceUpload'] as $row) { ?>
                             
                             <?php if($row['target_date'] !=""){
                                    if($row['actual_date'] !=""){?>
                                    <?php if(date("d-m-y", strtotime($row['actual_date'])) > date("d-m-y", strtotime($row['target_date']))){ ?>
                                    <td style="padding: 0px 1px 0px 3px;background-color: #bc150d;color:#ffffff"><?php echo $row['target_date']; ?></td>
                                    <td style="background-color: #bc150d;color:#ffffff"><?php echo  $row['actual_date']; ?></td>
                                    <?php }else{?>
                                    <td style=" padding: 0px 1px 0px 3px;"><?php echo  $row['target_date']; ?></td>
                                    <td ><?php echo  $row['actual_date']; ?></td>
                            <?php } }else{?>
                                    <?php if(date("d-m-y", strtotime(date('d-m-y'))) > date("d-m-y", strtotime($row['target_date']))){ ?>
                                    <td style="padding: 0px 1px 0px 3px;background-color: #bc150d;color:#ffffff"><?php echo $row['target_date']; ?></td>
                                    <td style="background-color: #bc150d;color:#ffffff"><?php echo  $row['actual_date']; ?></td>
                                    <?php }else{?>
                                    <td style=" padding: 0px 1px 0px 3px;"><?php echo  $row['target_date']; ?></td>
                                    <td ><?php echo  $row['actual_date']; ?></td>
                            <?php }?>

                            <?php }}?> 
                            <?php }?>
                            </tr>
                            </table>
                          </td>
                          
                           <?php 
                         
                         foreach($allDepartment as $dept){ ?>
                         <td>
                              <table>
                              <tr>
                             <?php 
                         
                         if(!empty($sheet['documentUpload'])){ 
                          $x=0;

                              foreach($sheet['documentUpload'] as $status){
                               // print_r($status['process']);exit;
                               $DeptId = explode(' ',$status['process']);
                               
                         
                                  if($dept->d_id ===(int)$DeptId[6]){
                                      
                                      break;
                                  }else{
                                      $x++;
                                  }
                                  
                              }
                          
                           if(isset($sheet['documentUpload'][$x]['actual_date'])){ 
                              ?> 
                              <?php if(isset($sheet['documentUpload'][$x]['actual_date'])){ 
                                  ?> 
                                    <td style=" padding: 0px 2px 0px 3px;">
                                  <?php echo $sheet['documentUpload'][$x]['target_date'];?> 
                                  </td>
                                  <td >
                                  <?php echo $sheet['documentUpload'][$x]['actual_date'];?> 
                                  </td> 
                                   
                              <?php } else {?> 
                                  <td></td> 
                                  <td></td> 
                              <?php }?> 
                          <?php }else{ ?>
                                      <td  style=" padding: 0px 2px 0px 25px;" >N/A</td>
                                      <td  style=" padding: 0px 2px 0px 25px;">N/A</td>  
                                 <?php  } } ?>
                                

                                

                              </tr>
                              </table>
                          </td>
                      <?php } ?>
                      <td>
                            <table>
                            <tr>
                            <?php foreach ($sheet['docVerStatus'] as $row) { ?>
                             
                             <?php if($row['target_date'] !=""){
                                    if($row['actual_date'] !=""){?>
                                    <?php if(date("d-m-y", strtotime($row['actual_date'])) > date("d-m-y", strtotime($row['target_date']))){ ?>
                                    <td style="padding: 0px 1px 0px 3px;background-color: #bc150d;color:#ffffff"><?php echo $row['target_date']; ?></td>
                                    <td style="background-color: #bc150d;color:#ffffff"><?php echo  $row['actual_date']; ?></td>
                                    <?php }else{?>
                                    <td style=" padding: 0px 1px 0px 3px;"><?php echo  $row['target_date']; ?></td>
                                    <td ><?php echo  $row['actual_date']; ?></td>
                            <?php } }else{?>
                                    <?php if(date("d-m-y", strtotime(date('d-m-y'))) > date("d-m-y", strtotime($row['target_date']))){ ?>
                                    <td style="padding: 0px 1px 0px 3px;background-color: #bc150d;color:#ffffff"><?php echo $row['target_date']; ?></td>
                                    <td style="background-color: #bc150d;color:#ffffff"><?php echo  $row['actual_date']; ?></td>
                                    <?php }else{?>
                                    <td style=" padding: 0px 1px 0px 3px;"><?php echo  $row['target_date']; ?></td>
                                    <td ><?php echo  $row['actual_date']; ?></td>
                            <?php }?>

                            <?php }}?> 
                            <?php }?>
                            </tr>
                            </table>
                          </td>
                          <td>
                            <table>
                            <tr>
                            <?php foreach ($sheet['horDep'] as $row) { ?>
                             
                             <?php if($row['target_date'] !=""){
                                    if($row['actual_date'] !=""){?>
                                    <?php if(date("d-m-y", strtotime($row['actual_date'])) > date("d-m-y", strtotime($row['target_date']))){ ?>
                                    <td style="padding: 0px 1px 0px 3px;background-color: #bc150d;color:#ffffff"><?php echo $row['target_date']; ?></td>
                                    <td style="background-color: #bc150d;color:#ffffff"><?php echo  $row['actual_date']; ?></td>
                                    <?php }else{?>
                                    <td style=" padding: 0px 1px 0px 3px;"><?php echo  $row['target_date']; ?></td>
                                    <td ><?php echo  $row['actual_date']; ?></td>
                            <?php } }else{?>
                                    <?php if(date("d-m-y", strtotime(date('d-m-y'))) > date("d-m-y", strtotime($row['target_date']))){ ?>
                                    <td style="padding: 0px 1px 0px 3px;background-color: #bc150d;color:#ffffff"><?php echo $row['target_date']; ?></td>
                                    <td style="background-color: #bc150d;color:#ffffff"><?php echo  $row['actual_date']; ?></td>
                                    <?php }else{?>
                                    <td style=" padding: 0px 1px 0px 3px;"><?php echo  $row['target_date']; ?></td>
                                    <td ><?php echo  $row['actual_date']; ?></td>
                            <?php }?>

                            <?php }}?> 
                            <?php }?>
                            </tr>
                            </table>
                          </td>
                          <td>
                            <table>
                            <tr>
                            <?php foreach ($sheet['beforeAfterStatus'] as $row) { ?>
                             
                             <?php if($row['target_date'] !=""){
                                    if($row['actual_date'] !=""){?>
                                    <?php if(date("d-m-y", strtotime($row['actual_date'])) > date("d-m-y", strtotime($row['target_date']))){ ?>
                                    <td style="padding: 0px 1px 0px 3px;background-color: #bc150d;color:#ffffff"><?php echo $row['target_date']; ?></td>
                                    <td style="background-color: #bc150d;color:#ffffff"><?php echo  $row['actual_date']; ?></td>
                                    <?php }else{?>
                                    <td style=" padding: 0px 1px 0px 3px;"><?php echo  $row['target_date']; ?></td>
                                    <td ><?php echo  $row['actual_date']; ?></td>
                            <?php } }else{?>
                                    <?php if(date("d-m-y", strtotime(date('d-m-y'))) > date("d-m-y", strtotime($row['target_date']))){ ?>
                                    <td style="padding: 0px 1px 0px 3px;background-color: #bc150d;color:#ffffff"><?php echo $row['target_date']; ?></td>
                                    <td style="background-color: #bc150d;color:#ffffff"><?php echo  $row['actual_date']; ?></td>
                                    <?php }else{?>
                                    <td style=" padding: 0px 1px 0px 3px;"><?php echo  $row['target_date']; ?></td>
                                    <td ><?php echo  $row['actual_date']; ?></td>
                            <?php }?>

                            <?php }}?> 
                            <?php }?>
                            </tr>
                            </table>
                          </td>
                          <td>
                            <table>
                            <tr>
                            <?php foreach ($sheet['finalclose'] as $row) { ?>
                             
                             <?php if($row['target_date'] !=""){
                                    if($row['actual_date'] !=""){?>
                                    <?php if(date("d-m-y", strtotime($row['actual_date'])) > date("d-m-y", strtotime($row['target_date']))){ ?>
                                    <td style="padding: 0px 1px 0px 3px;background-color: #bc150d;color:#ffffff"><?php echo $row['target_date']; ?></td>
                                    <td style="background-color: #bc150d;color:#ffffff"><?php echo  $row['actual_date']; ?></td>
                                    <?php }else{?>
                                    <td style=" padding: 0px 1px 0px 3px;"><?php echo  $row['target_date']; ?></td>
                                    <td ><?php echo  $row['actual_date']; ?></td>
                            <?php } }else{?>
                                    <?php if(date("d-m-y", strtotime(date('d-m-y'))) > date("d-m-y", strtotime($row['target_date']))){ ?>
                                    <td style="padding: 0px 1px 0px 3px;background-color: #bc150d;color:#ffffff"><?php echo $row['target_date']; ?></td>
                                    <td style="background-color: #bc150d;color:#ffffff"><?php echo  $row['actual_date']; ?></td>
                                    <?php }else{?>
                                    <td style=" padding: 0px 1px 0px 3px;"><?php echo  $row['target_date']; ?></td>
                                    <td ><?php echo  $row['actual_date']; ?></td>
                            <?php }?>

                            <?php }}?> 
                            <?php }?>
                            </tr>
                            </table>
                          </td>
                        </tr>
                       <?php } }?>
                       
        </tbody>
    </table>
</div>

</body>
</html>