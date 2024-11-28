<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,700,600italic,700italic,800">

    <link href="css/font-awesome.min.css" rel="stylesheet">
</head>

<body style="font-family: 'Open Sans',sans-serif; font-weight: normal; margin:0 auto;font-size:10px;">


<table style="width:80%;margin-bottom:40px;border:1px solid #000;">

    
</table>



<div class="summary-table report-wrapper scrollbarX">

    <table class="striped" style="border:1px solid #000;">
        <thead style="border-bottom:1px solid #000">
        <tr class="tr-bdr">

            <th width="50" style="border-right:1px solid #000">Sr. No.</th>
            <th width="100" style="border-right:1px solid #000">CM No.</th>
            <th width="450" style="border-right:1px solid #000">Initiation date</th>
            <th width="450" style="border-right:1px solid #000">HOD Approval
           </th>
            <th width="450" style="border-right:1px solid #000"><span>Define Cross  <br>Functional Team  </span>
                
            </th>
            <?php foreach ($allDepartment as $row) { ?>
            <th width="6750" class="rotate pd-none">
            <?php echo $row->d_name;?>
                
            </th>
             <?php } ?>
            <th width="450" class="rotate" style="border-right:1px solid #000"><span>Risk Approval of  <br>Superadmin</span>
            </th>
             <th width="450" class="rotate" style="border-right:1px solid #000"><span>COO Approval</span>
            </th>
            
            <th width="450" class="rotate" style="border-right:1px solid #000"><span>Steering Committee Approval</span>
            </th>

            <th width="450" class="rotate" style="border-right:1px solid #000"><span>Customer Evidence <br>Upload</span>
            </th>
           
<?php foreach ($allDepartment as $row) { ?>
            <th width="6750" class="rotate pd-none">
            <?php echo $row->d_name;?>
                
            </th>
             <?php } ?>
              <th width="450" class="rotate" style="border-right:1px solid #000"><span>Document Verification <br>Status</span>
            </th>
             <th width="450" class="rotate" style="border-right:1px solid #000"><span>Horizontal Deployment</span>
            </th>
             <th width="450" class="rotate" style="border-right:1px solid #000"><span>Change Cut-Off Date <br>Before After Status</span>
            </th>
             <th width="450" class="rotate" style="border-right:1px solid #000"><span>Final Closure</span>
            </th>
        </tr>
        
        </thead>
        <tbody>
        <tr>
          <td></td>
          <td></td>
          <td></td>
          <td>
            <table>
              <tr>
                <td>Target Date</td>
                <td>Actual Date</td>
              </tr>
            </table>
          </td>
           <td>
            <table>
              <tr>
                <td>Target Date</td>
                <td>Actual Date</td>
              </tr>
            </table>
          </td>
          <?php foreach ($allDepartment as $row) { ?>
          <td>
            <table>
              <tr>
                <td style="align:center;">Risk Entry</td>
                <td style="align:center;">HOD Approval</td>
              </tr>
              <tr>
                <td>
            <table>
              <tr>
                <td>Target Date</td>
                <td>Actual Date</td>
              </tr>
            </table>
          </td>
           <td>
            <table>
              <tr>
                <td>Target Date</td>
                <td>Actual Date</td>
              </tr>
            </table>
          </td>
          <td>
            <table>
              <tr>
                <td>Target Date</td>
                <td>Actual Date</td>
              </tr>
            </table>
          </td>
              </tr>

            </table>
          </td>
          <?php } ?>
          <td>
            <table>
              <tr>
                <td>Target Date</td>
                <td>Actual Date</td>
              </tr>
            </table>
          </td>
          
          <td>
            <table>
              <tr>
                <td>Target Date</td>
                <td>Actual Date</td>
              </tr>
            </table>
          </td>
         
          <td>
            <table>
              <tr>
                <td>Target Date</td>
                <td>Actual Date</td>
              </tr>
            </table>
          </td>
         
          <?php foreach($allDepartment as $row){ ?>
          <td>
            <table>
              <tr>
                <td>Target Date</td>
                <td>Actual Date</td>
              </tr>
            </table>
          </td>
          <?php } ?>
           <td>
            <table>
              <tr>
                <td>Target Date</td>
                <td>Actual Date</td>
              </tr>
            </table>
          </td>
           <td>
            <table>
              <tr>
                <td>Target Date</td>
                <td>Actual Date</td>
              </tr>
            </table>
          </td>
           <td>
            <table>
              <tr>
                <td>Target Date</td>
                <td>Actual Date</td>
              </tr>
            </table>
          </td>
           <td>
            <table>
              <tr>
                <td>Target Date</td>
                <td>Actual Date</td>
              </tr>
            </table>
          </td>
  </tr>
  <?php if(sizeof($data)>0){

                        $i=1;
                        foreach($data as $sheet){ //echo "<pre>";print_r($sheet['riskEntry'][0]['actual_date']);exit; ?>
                       <tr>
                            <td><?php echo $i++;?></td>
                          <td> <?php echo $sheet['cmNo'];?><span><br><?php echo $sheet['count_request_is_rejected'];?></span></td>
                          <td> <?php echo $sheet['initiatin_date'];?></td>
                          <td>
                            <table>
                            <tr>
                            <?php foreach ($sheet['hod_approval'] as $row) { ?>
                             
                            <?php if($row['target_date'] !=""){
                                    if($row['actual_date'] !=""){?>
                                    <?php if(date("y-m-d", strtotime($row['actual_date'])) > date("y-m-d", strtotime($row['target_date']))){ ?>
                                    <td style="background-color: #bc150d;color:#ffffff"><?php echo $row['target_date']; ?></td>
                                    <td style="background-color: #bc150d;color:#ffffff"><?php echo  $row['actual_date']; ?></td>
                                    <?php }else{?>
                                    <td ><?php echo  $row['target_date']; ?></td>
                                    <td ><?php echo  $row['actual_date']; ?></td>
                            <?php } }else{?>
                                    <?php if(date("y-m-d", strtotime(date('d-m-y'))) > date("y-m-d", strtotime($row['target_date']))){ ?>
                                    <td style="background-color: #bc150d;color:#ffffff"><?php echo $row['target_date']; ?></td>
                                    <td style="background-color: #bc150d;color:#ffffff"><?php echo  $row['actual_date']; ?></td>
                                    <?php }else{?>
                                    <td ><?php echo  $row['target_date']; ?></td>
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
                                    <?php if(date("y-m-d", strtotime($row['actual_date'])) > date("y-m-d", strtotime($row['target_date']))){ ?>
                                    <td style="background-color: #bc150d;color:#ffffff"><?php echo $row['target_date']; ?></td>
                                    <td style="background-color: #bc150d;color:#ffffff"><?php echo  $row['actual_date']; ?></td>
                                    <?php }else{?>
                                    <td ><?php echo  $row['target_date']; ?></td>
                                    <td ><?php echo  $row['actual_date']; ?></td>
                            <?php } }else{?>
                                    <?php if(date("y-m-d", strtotime(date('d-m-y'))) > date("y-m-d", strtotime($row['target_date']))){ ?>
                                    <td style="background-color: #bc150d;color:#ffffff"><?php echo $row['target_date']; ?></td>
                                    <td style="background-color: #bc150d;color:#ffffff"><?php echo  $row['actual_date']; ?></td>
                                    <?php }else{?>
                                    <td ><?php echo  $row['target_date']; ?></td>
                                    <td ><?php echo  $row['actual_date']; ?></td>
                            <?php }?>

                            <?php }}?>
                            <?php }?>
                            </tr>
                            </table>
                          </td>
                        
                        <?php foreach ($allDepartment as $dept) { $department='';?>
          <td>
            <table>
              
              <tr>
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
                                  <?php if(date("y-m-d", strtotime($sheet['riskEntry'][$x]['actual_date'])) > date("y-m-d", strtotime($sheet['riskEntry'][$x]['target_date']))){ ?>

                                     <td style="padding: 0px 2px 0px 5px;width: 2.5%;background-color: #bc150d;color:#ffffff">
                                  <?php echo $sheet['riskEntry'][$x]['target_date'];?> 
                                  </td>
                            <td style="text-align:center;width: 2.5%;background-color: #bc150d;color:#ffffff"><?php echo  $sheet['riskEntry'][$x]['actual_date']; ?></td>

                            <?php }else{?>
                               <td style="padding: 0px 2px 0px 5px;width: 2.5%;">
                                  <?php echo $sheet['riskEntry'][$x]['target_date'];?> 
                                  </td>
                               <td style="text-align:center;width: 2.5%"><?php echo  $sheet['riskEntry'][$x]['actual_date']; ?></td>

                            <?php } }else{ ?>
                                <?php if(date("y-m-d", strtotime(date('d-m-y'))) > date("y-m-d", strtotime($sheet['riskEntry'][$x]['target_date']))){ ?>

                                     <td style="padding: 0px 2px 0px 5px;width: 2.5%;background-color: #bc150d;color:#ffffff">
                                  <?php echo $sheet['riskEntry'][$x]['target_date'];?> 
                                  </td>
                            <td style="text-align:center;width: 2.5%;background-color: #bc150d;color:#ffffff"><?php echo  $sheet['riskEntry'][$x]['actual_date']; ?></td>

                            <?php }else{?>
                               <td style="padding: 0px 2px 0px 5px;width: 2.5%;">
                                  <?php echo $sheet['riskEntry'][$x]['target_date'];?> 
                                  </td>
                               <td style="text-align:center;width: 2.5%"><?php echo  $sheet['riskEntry'][$x]['actual_date']; ?></td>

                            <?php }?>
                           <?php }   }?>
                                   
                              <?php } else {?> 
                                  <td></td> 
                                  <td></td> 
                              <?php }?> 
                          <?php }else{ $department = 'NO';?>
                                      <td  style=" padding: 0px 2px 0px 25px;" >N/A</td>
                                      <td  style=" padding: 0px 2px 0px 25px;">N/A</td>  
                                 <?php  } } ?>
              </tr>
            </table>
          </td>
          <td>
            <table>
              <tr>
                 <?php if($department == 'NO'){ ?>
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
                                  <td style=" padding: 0px 2px 0px 5px;">
                                  <?php echo $sheet['riskEntryHodApp'][$y]['target_date'];?> 
                                  </td>
                                  <td style=" padding: 0px 2px 0px 5px;">
                                  <?php echo $sheet['riskEntryHodApp'][$y]['actual_date'];?> 
                                  </td> 
                              <?php } else {?> 
                                  <td></td> 
                                  <td></td> 
                              <?php }?> 
                          <?php }else{ ?>
                                      <td  style=" padding: 0px 5px 0px 25px;">N/A</td>
                                      <td style=" padding: 0px 2px 0px 25px;">N/A</td>  
                                 <?php  }  }else{?>
                                  <td  style=" padding: 0px 5px 0px 25px;"></td>
                                      <td style=" padding: 0px 2px 0px 25px;"></td> 
                                  <?php } }?>
              </tr>
            </table>
          </td>
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
                                    <?php if(date("y-m-d", strtotime($row['actual_date'])) > date("y-m-d", strtotime($row['target_date']))){ ?>
                                    <td style="background-color: #bc150d;color:#ffffff"><?php echo $row['target_date']; ?></td>
                                    <td style="padding:0px 1px 0px 3px;background-color: #bc150d;color:#ffffff"><?php echo  $row['actual_date']; ?></td>
                                    <?php }else{?>
                                    <td ><?php echo  $row['target_date']; ?></td>
                                    <td style="padding:0px 1px 0px 3px;"><?php echo  $row['actual_date']; ?></td>
                            <?php } }else{?>
                                    <?php if(date("y-m-d", strtotime(date('d-m-y'))) > date("y-m-d", strtotime($row['target_date']))){ ?>
                                    <td style="padding:0px 1px 0px 3px;background-color: #bc150d;color:#ffffff"><?php echo $row['target_date']; ?></td>
                                    <td style="background-color: #bc150d;color:#ffffff"><?php echo  $row['actual_date']; ?></td>
                                    <?php }else{?>
                                    <td style="padding:0px 1px 0px 3px;"><?php echo  $row['target_date']; ?></td>
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
                            <?php if($sheet['checkreq'] == 2){ ?>

                            <td ><?php echo 'N/A'; ?></td>
                                    <td ><?php echo 'N/A'; ?></td>



                            <?php }else{ foreach ($sheet['cooapp'] as $row) { ?>
                             
                            <?php if($row['target_date'] !=""){
                                    if($row['actual_date'] !=""){?>
                                    <?php if(date("d-m-y", strtotime($row['actual_date'])) > date("d-m-y", strtotime($row['target_date']))){ ?>
                                    <td style="padding:0px 10px 0px 3px;"><?php echo $row['target_date']; ?></td>
                                    <td style="padding:0px 10px 0px 3px;"><?php echo  $row['actual_date']; ?></td>
                                    <?php }else{?>
                                    <td style="padding:0px 10px 0px 3px;"><?php echo  $row['target_date']; ?></td>
                                    <td style="padding:0px 10px 0px 3px;"><?php echo  $row['actual_date']; ?></td>
                            <?php } }else{?>
                                    <?php if(date("d-m-y", strtotime(date('d-m-y'))) > date("d-m-y", strtotime($row['target_date']))){ ?>
                                    <td style="padding:0px 10px 0px 3px;" ?></td>
                                    <td style="padding:0px 10px 0px 3px;"><?php echo  $row['actual_date']; ?></td>
                                    <?php }else{?>
                                    <td style="padding:0px 10px 0px 3px;"><?php echo  $row['target_date']; ?></td>
                                    <td  style="padding:0px 10px 0px 3px;"><?php echo  $row['actual_date']; ?></td>
                            <?php }?>

                            <?php }}?>
                            <?php } }?>
                            </tr>
                            </table>
                          </td>
                           <?php foreach ($sheet['steerComApp'] as $row) { ?>

                          
                          <td>
                            <table>
                                <tr>
                                   <td  style="padding:0px 10px 0px 3px;"><?php echo $row['target_date']; ?></td>
                            <td ><?php echo  $row['actual_date']; ?></td>
                                </tr>
                            </table>
                          </td>
                          <?php } ?>
                          
                          <td>
                            <table>
                            <tr>
                            <?php foreach ($sheet['custEvdienceUpload'] as $row) { ?>
                             
                            <td  style=" padding:0px 1px 0px 3px;"><?php echo $row['target_date']; ?></td>
                            <td ><?php echo  $row['actual_date']; ?></td>
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
                             
                            <td  style=" padding:0px 1px 0px 3px;"><?php echo $row['target_date']; ?></td>
                            <td ><?php echo  $row['actual_date']; ?></td>
                            <?php }?>
                            </tr>
                            </table>
                          </td>
                         
                          <td>
                            <table>
                            <tr>
                            <?php foreach ($sheet['horDep'] as $row) { ?>
                             
                            <td  style=" padding:0px 1px 0px 3px;"><?php echo $row['target_date']; ?></td>
                            <td ><?php echo  $row['actual_date']; ?></td>
                            <?php }?>
                            </tr>
                            </table>
                          </td>
                         
                          <td>
                            <table>
                            <tr>
                            <?php foreach ($sheet['beforeAfterStatus'] as $row) { ?>
                             
                            <td  style=" padding:0px 1px 0px 3px;"><?php echo $row['target_date']; ?></td>
                            <td ><?php echo  $row['actual_date']; ?></td>
                            <?php }?>
                            </tr>
                            </table>
                          </td>
                         
                          <td>
                            <table>
                            <tr>
                            <?php foreach ($sheet['finalclose'] as $row) { ?>
                             
                            <td  style=" padding:0px 1px 0px 3px;"><?php echo $row['target_date']; ?></td>
                            <td ><?php echo  $row['actual_date']; ?></td>
                            <?php }?>
                            </tr>
                            </table>
                          </td>
                         
                          
                         
                      
                            
                        </tr>
                       <?php } }?>

        </tbody>
       

    </table>

</body>
</html>