<?php require app_path().'/views/header.php'; ?>
<?php $user_type = Session::get('gid');?>



<div class="col-sm-12" >

    <div class="row">
        <div class="col-sm-8">
            <div class="page-heading">
                <h1>Tracking Sheet</h1>
            </div><!--/page-heading-->

        </div>
         <div class="col-sm-4">
            <div class="page-heading pull-right">
                <a class="btn btn-animate flat blue pd-btn" href="<?php echo Request::root().'/tracking_sheet'; ?>">Back To Search</a>
            </div><!--/page-heading-->


        </div>
        
    </div>
    <form method="post" action="<?php echo Request::root().'/trackingSheet/download'; ?>">
        <div class="content-wrapper">

              <div class="row mg-btm">
                <div class="col-sm-6">
                <input type="hidden" name="r_id" value="<?=$formInput['r_id'];?>">
                 <input type="hidden" name="changeType" value="<?=$formInput['changeType'];?>">
                  <input type="hidden" name="change_stage_id" value="<?=$formInput['change_stage_id'];?>">
                   <input type="hidden" name="plantcode" value="<?=$formInput['plantcode'];?>">
                    <div class="action-group pd-top">
                        <form method="post" action="">
                            <button class="btn btn-animate flat blue pd-btn "  value="excel" name="filetype" type="submit">Export to Excel Sheet</button>
                            <button class="btn btn-animate flat blue pd-btn "  value="pdf" name="filetype" type="submit">Export to PDF</button>
                        </form>
                    </div>

                </div>
            </div>
            <!-- summary Table start -->
            <div class="summary-table report-wrapper scrollbarX">

                <table class="striped">
                    <thead>
                    <tr class="tr-bdr">

                        
                                <?php $cnt=0;
                                foreach ($allDepartment as $row) {
                                        $cnt++;
                                 } 
                                $width=$cnt*400;
                                $width1=$cnt*200;
                                $cnt2=0;
                                foreach ($steeringCommCnt as $row) {
                                  $cnt2++;
                                }
                                $width2=$cnt2*250;
                                ?>


                        <th width="50">Sr. No.</th>
                        <th width="100">CM No.</th>
                        <th width="100">Initiation date</th>
                        <th width="190">HOD Approval</th>
                        <th width="190">Define Cross Functional Team </th>
                       
                        <th width="<?=$width;?>" class="rotate pd-none">
                        <table>
                                <tr class="border-bottom">
                                    <td class="center-align">Risk Analysis</td>        
                                </tr>
                                <tr>
                                    <td class="pd-none">
                                        <table class="borderd-cell">
                                            <tr>
                                         <?php $cnt=0;
                                                foreach ($allDepartment as $row) { $cnt++;?>
                                             <td class="rotate pd"><span><?php echo $row->d_name; ?></span></td>
                                           <?php } ?> 
                                                             
                                         
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </th>
                        <th width="210" class="rotate"><span>Risk Approval Project <br>Manager / Initiator<span></th>
                        <th width="210" class="rotate"><span>COO Approval<span></th>
                        <th width="210" class="rotate"><span>Streeing Committee Approval<span></th>
                       
                        <th width="190" class="rotate"><span>Customer Evidance Upload<span></th>
                       
                        <th width="<?=$width1;?>" class="rotate pd-none">
                            <table>
                                <tr class="border-bottom">
                                    <td class="center-align">Activity Status</td>
                                </tr>
                                <tr>
                                    <td class="pd-none">
                                        <table class="borderd-cell">
                                           <td class="pd-none">
                                        <table class="borderd-cell">
                                            <tr >
                                         <?php $cnt=0;
                                                foreach ($allDepartment as $row) { $cnt++;?>
                                             <td class="rotate pd"><span><?php echo $row->d_name; ?></span></td>
                                           <?php } ?> 
                                                             
                                         
                                            </tr>
                                        </table>
                                    </td>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </th>
                       <th width="190" class="rotate"><span>Document Verification Status<span></th>
                       <th width="190" class="rotate"><span>PTR Document Upload<span></th>
                       <th width="190" class="rotate"><span>Horizontal Deployment<span></th>
                       <th width="190" class="rotate"><span>Change Cut-Off Date & <br>Before After Status<span></th>
                       <th width="190" class="rotate"><span>Final Closure<span></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                         <td></td>
                          <td><table>
                             <tr style="font-weight: bold;">
                                 <td>Target Date</td>
                                  <td>Actual Date</td>
                             </tr>
                         </table></td>
                         <td><table>
                             <tr style="font-weight: bold;">
                                 <td>Target Date</td>
                                  <td>Actual Date</td>
                             </tr>
                         </table></td>
                          <td ><table>
                          <thead>
                          <?php foreach($allDepartment as $row){ ?>

                              <th >
                                  <table>
                                    <tr style="font-weight: bold;">
                                      <td >Risk Entry</td>
                                      <td ></td>
                                      <td >Risk HOD Approval</td>

                                    </tr>
                                    <tr>
                                     <td>Target Date</td>
                                  <td >Actual Date</td>
                                  <td>Target Date</td>
                                  <td>Actual Date</td>
                                    </tr>
                                   
                                  </table>
                              </th>
                               <?php } ?>

                          </thead>
                         
                            
                         </table></td>
                         <td><table>
                             <tr style="font-weight: bold;">
                                 <td>Target Date</td>
                                  <td>Actual Date</td>
                             </tr>
                         </table></td>
                         <td><table>
                             <tr style="font-weight: bold;">
                                 <td>Target Date</td>
                                  <td>Actual Date</td>
                             </tr>
                         </table></td>
                         <td ><table>
                          
                            <tr style="font-weight: bold;">
                                 <td>Target Date</td>
                                  <td>Actual Date</td>
                             </tr>
                         </table></td>
                         
                          <td><table>
                             <tr style="font-weight: bold;">
                                 <td>Target Date</td>
                                  <td>Actual Date</td>
                             </tr>
                         </table></td>
                         
                         <td ><table>
                          <thead>
                          <?php foreach($allDepartment as $row){ ?>

                              <th >
                                  <table>
                                    <tr style="font-weight: bold;">
                                      <td style="width:8">Target Date</td>
                                      <td  style="width:8">Actual Date</td>
                                    </tr>
                                    
                                   
                                  </table>
                              </th>
                               <?php } ?>

                          </thead>
                         
                            
                         </table></td>
                          <td><table>
                             <tr style="font-weight: bold;">
                                 <td>Target Date</td>
                                  <td>Actual Date</td>
                             </tr>
                         </table></td>
                          <td><table>
                             <tr style="font-weight: bold;">
                                 <td>Target Date</td>
                                  <td>Actual Date</td>
                             </tr>
                         </table></td>
                          <td><table>
                             <tr style="font-weight: bold;">
                                 <td>Target Date</td>
                                  <td>Actual Date</td>
                             </tr>
                         </table></td>
                          <td><table>
                             <tr style="font-weight: bold;">
                                 <td>Target Date</td>
                                  <td>Actual Date</td>
                             </tr>
                         </table></td>
                         <td><table>
                             <tr style="font-weight: bold;">
                                 <td>Target Date</td>
                                  <td>Actual Date</td>
                             </tr>
                         </table></td>
                        </tr>

                        <?php if(sizeof($data)>0){

                        $i=1;
                        foreach($data as $sheet){ //echo "<pre>";print_r($sheet['riskEntry'][0]['actual_date']);exit; ?>
                       <tr>
                            <td><?php echo $i++;?></td>
                          <td> <a href="<?php echo Request::root().'/views?searchid='.$sheet['cmNo']; ?>"><?php echo $sheet['cmNo'];?></a><span><br><?php echo $sheet['count_request_is_rejected'];?></span></td>
                          <td> <?php echo $sheet['initiatin_date'];?></td>
                          <td>
                            <table>
                            <tr>
                            <?php foreach ($sheet['hod_approval'] as $row) { ?>
                             <?php if($row['target_date'] !=""){
                                    if($row['actual_date'] !=""){?>
                                    <?php if(date("d-m-y", strtotime($row['actual_date'])) > date("d-m-y", strtotime($row['target_date']))){ ?>
                                    <td style="background-color: #bc150d;color:#ffffff"><?php echo $row['target_date']; ?></td>
                                    <td style="background-color: #bc150d;color:#ffffff"><?php echo  $row['actual_date']; ?></td>
                                    <?php }else{?>
                                    <td ><?php echo  $row['target_date']; ?></td>
                                    <td ><?php echo  $row['actual_date']; ?></td>
                            <?php } }else{?>
                                    <?php if( date("d-m-y", strtotime(date('d-m-y'))) > date("d-m-y", strtotime($row['target_date'])) ){ ?>
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
                                    <?php if(date("d-m-y", strtotime($row['actual_date'])) > date("d-m-y", strtotime($row['target_date']))){ ?>
                                    <td style="background-color: #bc150d;color:#ffffff"><?php echo $row['target_date']; ?></td>
                                    <td style="background-color: #bc150d;color:#ffffff"><?php echo  $row['actual_date']; ?></td>
                                    <?php }else{?>
                                    <td ><?php echo  $row['target_date']; ?></td>
                                    <td ><?php echo  $row['actual_date']; ?></td>
                            <?php } }else{?>
                                    <?php if(date("d-m-y", strtotime(date('d-m-y'))) > date("d-m-y", strtotime($row['target_date']))){ ?>
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
                              <table style="table-layout: fixed;">
                              <tr>
                             <?php 
                          //-------------dep0-------------- 


                         foreach($allDepartment as $dept){
                            $department = '';
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

                                     <td style="padding: 0px 2px 0px 5px;width:1.5%;background-color: #bc150d;color:#ffffff">
                                  <?php echo $sheet['riskEntry'][$x]['target_date'];?> 
                                  </td>
                            <td style="text-align:center;width:1.8%;background-color: #bc150d;color:#ffffff"><?php echo  $sheet['riskEntry'][$x]['actual_date']; ?></td>

                            <?php }else{?>
                               <td style="padding: 0px 2px 0px 5px;width: 1.5%;">
                                  <?php echo $sheet['riskEntry'][$x]['target_date'];?> 
                                  </td>
                               <td style="text-align:center;width: 1.8%"><?php echo  $sheet['riskEntry'][$x]['actual_date']; ?></td>

                            <?php } }else{ ?>
                                <?php if(date("d-m-y", strtotime(date('d-m-y'))) > date("d-m-y", strtotime($sheet['riskEntry'][$x]['target_date']))){ ?>

                                     <td style="padding: 0px 2px 0px 5px;width: 1.5%;background-color: #bc150d;color:#ffffff">
                                  <?php echo $sheet['riskEntry'][$x]['target_date'];?> 
                                  </td>
                            <td style="text-align:center;width: 1.8%;background-color: #bc150d;color:#ffffff"><?php echo  $sheet['riskEntry'][$x]['actual_date']; ?></td>

                            <?php }else{?>
                               <td style="padding: 0px 2px 0px 5px;width:1.5%;">
                                  <?php echo $sheet['riskEntry'][$x]['target_date'];?> 
                                  </td>
                               <td style="text-align:center;width:1.8%"><?php echo  $sheet['riskEntry'][$x]['actual_date']; ?></td>

                            <?php }?>
                           <?php }   }?>
                              <?php } else {?> 
                                  <td style="width:1.5%;text-align:center;"></td> 
                                  <td style="width:1.5%;text-align:center;"></td> 
                              <?php }?> 
                          <?php }else{ $department='NO';?>
                                      <td style="width:1.5%;text-align:center;" >   N/A  </td>
                                      <td style="width:1.5%;text-align:center" >   N/A  </td>  


                                 <?php  } } ?>
                                 <?php 
                                  if($department == 'NO'){ ?>
                                       <td style="text-align:center;width: 1.5%">N/A</td>
                                      <td style="text-align:center;width: 1.5%" >N/A</td> 
                                  <?php }else{
                                 if(!empty($sheet['riskEntryHodApp'])){ 
                          $y=0;

                              foreach($sheet['riskEntryHodApp'] as $status){

                               //echo "<pre>";print_r($sheet);exit;
                               $deptId = explode(' ',$status['process']);
                               
                                 
                                  if($dept->d_id ===(int)$deptId[4]){
                                      
                                      break;
                                  }else{
                                      $y++;
                                  }

                              
                              }
                          
                           if(isset($sheet['riskEntryHodApp'])){
                            

                              ?> 
                              <?php if(isset($sheet['riskEntryHodApp'][$y]['target_date']) ){
                                   
                                  ?> 
                                   <?php if($sheet['riskEntryHodApp'][$y]['target_date'] !=""){
                                    if($sheet['riskEntryHodApp'][$y]['actual_date'] !=""){?>
                                 <?php if(date("d-m-y", strtotime($sheet['riskEntryHodApp'][$y]['actual_date'])) > date("d-m-y", strtotime($sheet['riskEntryHodApp'][$y]['target_date']))){ ?>
                                  <td style="text-align:center;width: 1.5%;background-color: #bc150d;color:#ffffff">
                                  <?php echo $sheet['riskEntryHodApp'][$y]['target_date'];?> 
                                  </td>
                            <td style="text-align:center;width: 1.5%;background-color: #bc150d;color:#ffffff"><?php echo  $sheet['riskEntryHodApp'][$y]['actual_date']; ?></td>
                            
                            <?php }else{?>
                               <td style="text-align:center;width: 1.5%">
                                  <?php echo $sheet['riskEntryHodApp'][$y]['target_date'];?> 
                                  </td>
                               <td style="text-align:center;width: 1.5%"><?php echo  $sheet['riskEntryHodApp'][$y]['actual_date']; ?></td>

                            <?php } }else{?>
                                 <?php if(date("d-m-y", strtotime(date('d-m-y'))) > date("d-m-y", strtotime($sheet['riskEntryHodApp'][$y]['target_date']))){ ?>
                                  <td style="text-align:center;width: 1.5%;background-color: #bc150d;color:#ffffff">
                                  <?php echo $sheet['riskEntryHodApp'][$y]['target_date'];?> 
                                  </td>
                            <td style="text-align:center;width: 1.5%;background-color: #bc150d;color:#ffffff"><?php echo  $sheet['riskEntryHodApp'][$y]['actual_date']; ?></td>
                            
                            <?php }else{?>
                               <td style="text-align:center;width: 1.5%">
                                  <?php echo $sheet['riskEntryHodApp'][$y]['target_date'];?> 
                                  </td>
                               <td style="text-align:center;width: 1.5%"><?php echo  $sheet['riskEntryHodApp'][$y]['actual_date']; ?></td>
                              <?php } } }?>
                              
                              <?php } else { ?> 
                                  <td style="text-align:center;width: 1.5%"></td> 
                                  <td style="text-align:center;width: 1.5%"></td> 
                              <?php }?> 
                          <?php }else{ ?>
                                      <td style="text-align:center;width: 1.5%">N/A</td>
                                      <td style="text-align:center;width: 1.5%" >N/A</td>  
                                 <?php  } }else{ ?>

                                     <td style="text-align:center;width: 1.5%"></td>
                                      <td style="text-align:center;width: 1.5%" ></td> 
                                 <?php }  } } ?>

                              </tr>
                              </table>
                          </td>
                           <td>
                            <table>
                            <tr>
                            <?php foreach ($sheet['adminRiskapp'] as $row) { ?>
                             
                            <?php if($row['target_date'] !=""){
                                    if($row['actual_date'] !=""){?>
                                    <?php if(date("d-m-y", strtotime($row['actual_date'])) > date("d-m-y", strtotime($row['target_date']))){ ?>
                                    <td style="background-color: #bc150d;color:#ffffff"><?php echo $row['target_date']; ?></td>
                                    <td style="background-color: #bc150d;color:#ffffff"><?php echo  $row['actual_date']; ?></td>
                                    <?php }else{?>
                                    <td ><?php echo  $row['target_date']; ?></td>
                                    <td ><?php echo  $row['actual_date']; ?></td>
                            <?php } }else{?>
                                    <?php if(date("d-m-y", strtotime(date('d-m-y'))) > date("d-m-y", strtotime($row['target_date']))){ ?>
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
                            <?php if($sheet['checkreq'] == 2){ ?>

                            <td ><?php echo 'N/A'; ?></td>
                                    <td ><?php echo 'N/A'; ?></td>



                            <?php }else{ foreach ($sheet['cooapp'] as $row) { ?>
                             
                            <?php if($row['target_date'] !=""){
                                    if($row['actual_date'] !=""){?>
                                    <?php if(date("d-m-y", strtotime($row['actual_date'])) > date("d-m-y", strtotime($row['target_date']))){ ?>
                                    <td style="background-color: #bc150d;color:#ffffff"><?php echo $row['target_date']; ?></td>
                                    <td style="background-color: #bc150d;color:#ffffff"><?php echo  $row['actual_date']; ?></td>
                                    <?php }else{?>
                                    <td ><?php echo  $row['target_date']; ?></td>
                                    <td ><?php echo  $row['actual_date']; ?></td>
                            <?php } }else{?>
                                    <?php if(date("d-m-y", strtotime(date('d-m-y'))) > date("d-m-y", strtotime($row['target_date']))){ ?>
                                    <td style="background-color: #bc150d;color:#ffffff"><?php echo $row['target_date']; ?></td>
                                    <td style="background-color: #bc150d;color:#ffffff"><?php echo  $row['actual_date']; ?></td>
                                    <?php }else{?>
                                    <td ><?php echo  $row['target_date']; ?></td>
                                    <td ><?php echo  $row['actual_date']; ?></td>
                            <?php }?>

                            <?php }}?>
                            <?php } }?>
                            </tr>
                            </table>
                          </td>
                           <td>
                            <table>
                            <tr>
                             <?php 
                          //-------------dep0-------------- 

                       
                         if(!empty($sheet['steerComApp'])){ 
                          $x=0;
                          
                           if(isset($sheet['steerComApp'][$x]['target_date'])){ 
                              ?> 
                              <?php if(isset($sheet['steerComApp'][$x]['actual_date'])){ 
                                  ?> 
                                  <?php if($sheet['steerComApp'][$x]['target_date'] != ""){
                                    if($sheet['steerComApp'][$x]['actual_date'] != ""){?>
                                  <?php if(date("d-m-y", strtotime($sheet['steerComApp'][$x]['actual_date'])) > date("d-m-y", strtotime($sheet['steerComApp'][$x]['target_date']))){ ?>
                                    <td style="padding: 0px 2px 0px 5px;width: 2.5%;background-color: #bc150d;color:#ffffff">
                                          <?php echo $sheet['steerComApp'][$x]['target_date'];?> 
                                          </td>
                                    <td style="text-align:center;width: 2.5%;background-color: #bc150d;color:#ffffff"><?php echo  $sheet['steerComApp'][$x]['actual_date']; ?></td>

                            <?php }else{?>
                                  <td style="padding: 0px 2px 0px 5px;width: 2.5%">
                                      <?php echo $sheet['steerComApp'][$x]['target_date'];?> 
                                      </td>
                                   <td style="text-align:center;width: 2.5%"><?php echo  $sheet['steerComApp'][$x]['actual_date']; ?></td>
                            <?php } }else{?>
                              <?php if(date("d-m-y", strtotime(date('d-m-y'))) > date("d-m-y", strtotime($sheet['steerComApp'][$x]['target_date']))){ ?>
                                    <td style="padding: 0px 2px 0px 5px;width: 2.5%;background-color: #bc150d;color:#ffffff">
                                          <?php echo $sheet['steerComApp'][$x]['target_date'];?> 
                                          </td>
                                    <td style="text-align:center;width: 2.5%;background-color: #bc150d;color:#ffffff"><?php echo  $sheet['steerComApp'][$x]['actual_date']; ?></td>

                            <?php }else{?>
                                  <td style="padding: 0px 2px 0px 5px;width: 2.5%">
                                      <?php echo $sheet['steerComApp'][$x]['target_date'];?> 
                                      </td>
                                   <td style="text-align:center;width: 2.5%"><?php echo  $sheet['steerComApp'][$x]['actual_date']; ?></td>

                            <?php } } }?>
                              <?php } else {?> 
                                  <td></td> 
                                  <td></td> 
                              <?php }?> 
                          <?php }else{ ?>
                                      <td style="width:2.5%;text-align:center;" >   N/A  </td>
                                      <td style="width:2.5%;text-align:center" >   N/A  </td>  


                                 <?php  } } ?>
                            </tr>
                            </table>
                          </td>
                            
                           <td>
                            <table>
                            <tr>
                            <?php foreach ($sheet['custEvdienceUpload'] as $row) { ?>
                             
                            <?php if($row['target_date'] !=""){
                                    if($row['actual_date'] !=""){?>
                                    <?php if(date("d-m-y", strtotime($row['actual_date'])) > date("d-m-y", strtotime($row['target_date']))){ ?>
                                    <td style="background-color: #bc150d;color:#ffffff"><?php echo $row['target_date']; ?></td>
                                    <td style="background-color: #bc150d;color:#ffffff"><?php echo  $row['actual_date']; ?></td>
                                    <?php }else{?>
                                    <td ><?php echo  $row['target_date']; ?></td>
                                    <td ><?php echo  $row['actual_date']; ?></td>
                            <?php } }else{?>
                                    <?php if(date("d-m-y", strtotime(date('d-m-y'))) > date("d-m-y", strtotime($row['target_date']))){ ?>
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
                            <?php foreach($allDepartment as $dept){

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
                                  
                                   <?php if($sheet['documentUpload'][$x]['target_date'] != ""){
                                    if($sheet['documentUpload'][$x]['actual_date'] != ""){
                                   if(date("d-m-y", strtotime($sheet['documentUpload'][$x]['actual_date'])) >date("d-m-y", strtotime($sheet['documentUpload'][$x]['target_date']))){ ?>
                            <td  style="padding: 0px 2px 0px 5px;width: 3.5%;background-color: #bc150d;color:#ffffff">
                                  <?php echo $sheet['documentUpload'][$x]['target_date'];?> 
                                  </td>
                            <td style="text-align:center;width: 3.5%;background-color: #bc150d;color:#ffffff"><?php echo  $sheet['documentUpload'][$x]['actual_date']; ?></td>
                            <?php }else{?>
                              <td  style="padding: 0px 2px 0px 5px;width: 3.5%">
                                  <?php echo $sheet['documentUpload'][$x]['target_date'];?> 
                                  </td>
                               <td style="text-align:center;width: 3.5%"><?php echo  $sheet['documentUpload'][$x]['actual_date']; ?></td>
                            <?php } }else{
                                if(date("d-m-y", strtotime(date('d-m-y'))) >date("d-m-y", strtotime($sheet['documentUpload'][$x]['target_date']))){ ?>
                            <td  style="padding: 0px 2px 0px 5px;width: 3.5%;background-color: #bc150d;color:#ffffff">
                                  <?php echo $sheet['documentUpload'][$x]['target_date'];?> 
                                  </td>
                            <td style="text-align:center;width: 3.5%;background-color: #bc150d;color:#ffffff"><?php echo  $sheet['documentUpload'][$x]['actual_date']; ?></td>
                            <?php }else{?>
                              <td  style="padding: 0px 2px 0px 5px;width: 3.5%">
                                  <?php echo $sheet['documentUpload'][$x]['target_date'];?> 
                                  </td>
                               <td style="text-align:center;width: 3.5%"><?php echo  $sheet['documentUpload'][$x]['actual_date']; ?></td>
                            <?php } } }else{?>
                              <td style="text-align:center;width: 3.5%;"><?php echo  $sheet['documentUpload'][$x]['actual_date']; ?></td>
                              <?php }?>
                                  
                              <?php } else {?> 
                                  <td style="text-align:center;width: 3.5%"></td> 
                                  <td style="text-align:center"></td> 
                              <?php }?> 
                          <?php }else{ ?>
                                      <td style="text-align:center;width: 3.5%" ><?php echo '   N/A  ';?></td>
                                      <td style="text-align:center;width: 3.5%" ><?php echo '   N/A  ';?></td>  
                                 <?php  } } }?>
                            </tr>
                            </table>
                          </td>
                           <td>
                            <table>
                            <tr>
                            <?php foreach ($sheet['docVerStatus'] as $row) { ?>
                             
                            <?php if($row['target_date'] !=""){
                                    if($row['actual_date'] !=""){?>
                                    <?php if(date("d-m-y", strtotime($row['actual_date'])) > date("d-m-y", strtotime($row['target_date']))){ ?>
                                    <td style="background-color: #bc150d;color:#ffffff"><?php echo $row['target_date']; ?></td>
                                    <td style="background-color: #bc150d;color:#ffffff"><?php echo  $row['actual_date']; ?></td>
                                    <?php }else{?>
                                    <td ><?php echo  $row['target_date']; ?></td>
                                    <td ><?php echo  $row['actual_date']; ?></td>
                            <?php } }else{?>
                                    <?php if(date("d-m-y", strtotime(date('d-m-y'))) > date("d-m-y", strtotime($row['target_date']))){ ?>
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
                            <?php foreach ($sheet['PTRupload'] as $row) { ?>
                             
                            <?php if($row['target_date'] !=""){
                                    if($row['actual_date'] !=""){?>
                                    <?php if(date("d-m-y", strtotime($row['actual_date'])) > date("d-m-y", strtotime($row['target_date']))){ ?>
                                    <td style="background-color: #bc150d;color:#ffffff"><?php echo $row['target_date']; ?></td>
                                    <td style="background-color: #bc150d;color:#ffffff"><?php echo  $row['actual_date']; ?></td>
                                    <?php }else{?>
                                    <td ><?php echo  $row['target_date']; ?></td>
                                    <td ><?php echo  $row['actual_date']; ?></td>
                            <?php } }else{?>
                                    <?php if(date("d-m-y", strtotime(date('d-m-y'))) > date("d-m-y", strtotime($row['target_date']))){ ?>
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
                            <?php foreach ($sheet['horDep'] as $row) { ?>
                             
                            <?php if($row['target_date'] !=""){
                                    if($row['actual_date'] !=""){?>
                                    <?php if(date("d-m-y", strtotime($row['actual_date'])) > date("d-m-y", strtotime($row['target_date']))){ ?>
                                    <td style="background-color: #bc150d;color:#ffffff"><?php echo $row['target_date']; ?></td>
                                    <td style="background-color: #bc150d;color:#ffffff"><?php echo  $row['actual_date']; ?></td>
                                    <?php }else{?>
                                    <td ><?php echo  $row['target_date']; ?></td>
                                    <td ><?php echo  $row['actual_date']; ?></td>
                            <?php } }else{?>
                                    <?php if(date("d-m-y", strtotime(date('d-m-y'))) > date("d-m-y", strtotime($row['target_date']))){ ?>
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
                            <?php foreach ($sheet['beforeAfterStatus'] as $row) { ?>
                             
                            <?php if($row['target_date'] !=""){
                                    if($row['actual_date'] !=""){?>
                                    <?php if(date("d-m-y", strtotime($row['actual_date'])) > date("d-m-y", strtotime($row['target_date']))){ ?>
                                    <td style="background-color: #bc150d;color:#ffffff"><?php echo $row['target_date']; ?></td>
                                    <td style="background-color: #bc150d;color:#ffffff"><?php echo  $row['actual_date']; ?></td>
                                    <?php }else{?>
                                    <td ><?php echo  $row['target_date']; ?></td>
                                    <td ><?php echo  $row['actual_date']; ?></td>
                            <?php } }else{?>
                                    <?php if(date("d-m-y", strtotime(date('d-m-y'))) > date("d-m-y", strtotime($row['target_date']))){ ?>
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
                            <?php foreach ($sheet['finalclose'] as $row) { ?>
                             
                            <?php if($row['target_date'] !=""){
                                    if($row['actual_date'] !=""){?>
                                    <?php if(date("d-m-y", strtotime($row['actual_date'])) > date("d-m-y", strtotime($row['target_date']))){ ?>
                                    <td style="background-color: #bc150d;color:#ffffff"><?php echo $row['target_date']; ?></td>
                                    <td style="background-color: #bc150d;color:#ffffff"><?php echo  $row['actual_date']; ?></td>
                                    <?php }else{?>
                                    <td ><?php echo  $row['target_date']; ?></td>
                                    <td ><?php echo  $row['actual_date']; ?></td>
                            <?php } }else{?>
                                    <?php if(date("d-m-y", strtotime(date('d-m-y'))) > date("d-m-y", strtotime($row['target_date']))){ ?>
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
                                            
                       </tr>
                       <?php } }else{?>
                        <tr>
                        <td>No Record Found</td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>

            </div><!--/summary-table-->

           

            <!-- summary Table end -->

        </div><!--/content-wrapper-->

    </form>
</div><!--/s10-->
<?php require app_path().'/views/footer.php'; ?>


<script type="text/javascript">
