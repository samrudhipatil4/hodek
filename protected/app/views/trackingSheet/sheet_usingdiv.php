<?php require app_path().'/views/header.php'; ?>
<?php $user_type = Session::get('gid');?>



<div class="col-sm-12" >

    <div class="row">
        <div class="col-sm-8">
            <div class="page-heading">
                <h1>Tracking Sheet</h1>
            </div><!--/page-heading-->

        </div>
        
    </div>
    <form method="post" action="<?php echo Request::root().'/trackingSheet/download'; ?>">
        <div class="content-wrapper">

              <div class="row mg-btm">
                <div class="col-sm-6">

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
                        <th width="190">Initial Information Sheet Updation</th>
                       
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
                        <th width="210" class="rotate"><span>Risk Approval Superadmin<span></th>
                        <th width="<?= $width2;?>" class="rotate"><span>Streeing Committee Approval<span></th>
                        <th width="190" class="rotate"><span>QA Head Decision<span></th>
                        <th width="190" class="rotate"><span>Customer Evidance Upload<span></th>
                        <th width="190" class="rotate"><span>Customer Evidance Upload <br>Superadmin Approve<span></th>
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
                         <td ><table>
                          <thead>
                          <?php foreach($steeringCommCnt as $row){ ?>

                              <th>
                                  <table>
                                    <tr style="font-weight: bold;">
                                    <td></td>
                                      <td style=""><?php echo 'Steering Committee '.$row->first_name.' '.$row->last_name.'Approval';?></td>
                                      

                                    </tr>
                                    <tr>
                                     <td style="text-align:center">Target Date</td>
                                  <td style="text-align:center">Actual Date</td>
                                  
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
                             
                            <td ><?php echo $row['target_date']; ?></td>
                            <td ><?php echo  $row['actual_date']; ?></td>
                            <?php }?>
                            </tr>
                            </table>
                          </td>
                          <td>
                            <table>
                            <tr>
                            <?php foreach ($sheet['initialInformation'] as $row) { ?>
                             
                            <td><?php echo $row['target_date']; ?></td>
                            <td><?php echo  $row['actual_date']; ?></td>
                            <?php }?>
                            </tr>
                            </table>
                          </td>
                          
                          <td class="test">
                              
                              <div class="row">
                             <?php 
                          //-------------dep0-------------- 


                         foreach($allDepartment as $dept){

                            $department = '';
                         if(!empty($sheet['riskEntry'])){ 
                          $x=0;

                              foreach($sheet['riskEntry'] as $status){
                              
                               $DeptId = explode(' ',$status['process']);
                               
                         
                                  if($dept->d_id ===$DeptId[2]){
                                      
                                      break;
                                  }else{
                                      $x++;
                                  }
                                  
                              }
                          
                           if(isset($sheet['riskEntry'][$x]['actual_date'])){ 
                              ?> 
                              <?php if(isset($sheet['riskEntry'][$x]['actual_date'])){ 
                                  ?> 
                                  <div style="float:left;padding: 0px 2px 0px 5px;width: 2%">
                                  <?php echo $sheet['riskEntry'][$x]['target_date'];?> 
                                  </div>
                                  <div style="float:left;padding: 0px 2px 0px 5px;width: 2%">
                                  <?php echo $sheet['riskEntry'][$x]['actual_date'];?> 
                                  </div> 
                              <?php } else {?> 
                                  <div style="float:left;"></div> 
                                  <div style="float:left;"></div> 
                              <?php }?> 
                          <?php }else{ $department='NO';?>
                                      <div style="float:left;padding: 0px 2px 0px 5px;width: 2%" >   N/A  </div>
                                      <div style="float:left;padding: 0px 2px 0px 5px;width: 2%" >   N/A  </div>  


                                 <?php  } } ?>
                                 <?php 
                                  if($department == 'NO'){ ?>
                                       <div style="float:left;padding: 0px 2px 0px 5px;width: 2%;">N/A</div>
                                      <div style="float:left;padding: 0px 2px 0px 5px;width: 2%">N/A</div> 
                                  <?php }else{
                                 if(!empty($sheet['riskEntryHodApp'])){ 
                          $y=0;

                              foreach($sheet['riskEntryHodApp'] as $status){

                               //echo "<pre>";print_r($sheet);exit;
                               $deptId = explode(' ',$status['process']);
                               
                                 
                                  if($dept->d_id ===$deptId[4]){
                                      
                                      break;
                                  }else{
                                      $y++;
                                  }

                              
                              }
                          
                           if(isset($sheet['riskEntryHodApp'])){
                            

                              ?> 
                              <?php if(isset($sheet['riskEntryHodApp'][$y]['target_date']) ){
                                   
                                  ?> 
                                  <div style="float:left;padding: 0px 2px 0px 5px;width: 2%">
                                  <?php echo $sheet['riskEntryHodApp'][$y]['target_date'];?> 
                                  </div>
                                  <div style="float:left;padding: 0px 2px 0px 5px;width: 2%">
                                  <?php echo $sheet['riskEntryHodApp'][$y]['actual_date'];?> 
                                  </div> 
                              
                              <?php } else { ?> 
                                  <div style="float:left;padding: 0px 2px 0px 5px;width: 2%"></div> 
                                  <div style="float:left;padding: 0px 2px 0px 5px;width: 2%"></div> 
                              <?php }?> 
                          <?php }else{ ?>
                                      <div style="float:left;padding: 0px 2px 0px 5px;width: 2%"></div>
                                      <div style="float:left;padding: 0px 2px 0px 5px;width: 2%" ></div>  
                                 <?php  } }else{ ?>

                                     <div style="float:left;padding: 0px 2px 0px 5px;width: 2%"></div>
                                      <div style="float:left;padding: 0px 2px 0px 5px;width: 2%" ></div> 
                                 <?php }  } } ?>

                              </div>                              
                          </td>
                           <td>
                            <table>
                            <tr>
                            <?php foreach ($sheet['adminRiskapp'] as $row) { ?>
                             
                            <td><?php echo $row['target_date']; ?></td>
                            <td><?php echo  $row['actual_date']; ?></td>
                            <?php }?>
                            </tr>
                            </table>
                          </td>
                           <td>
                            <table>
                            <tr>
                            <?php foreach ($sheet['steerComApp'] as $row) { ?>
                             
                            <td style="padding: 0px 2px 0px 30px;"><?php echo $row['target_date']; ?></td>
                            <td><?php echo  $row['actual_date']; ?></td>
                            <?php }?>
                            </tr>
                            </table>
                          </td>
                             <td>
                            <table>
                            <tr>
                            <?php foreach ($sheet['qaHead'] as $row) { ?>
                             
                            <td><?php echo $row['target_date']; ?></td>
                            <td><?php echo  $row['actual_date']; ?></td>
                            <?php }?>
                            </tr>
                            </table>
                          </td>
                           <td>
                            <table>
                            <tr>
                            <?php foreach ($sheet['custEvdienceUpload'] as $row) { ?>
                             
                            <td><?php echo $row['target_date']; ?></td>
                            <td><?php echo  $row['actual_date']; ?></td>
                            <?php }?>
                            </tr>
                            </table>
                          </td>
                          <td>
                            <table>
                            <tr>
                            <?php foreach ($sheet['adminActivityApp'] as $row) { ?>
                             
                            <td><?php echo $row['target_date']; ?></td>
                            <td><?php echo  $row['actual_date']; ?></td>
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
                               
                             
                                  if($dept->d_id ===$DeptId[6]){
                                      
                                      break;
                                  }else{
                                      $x++;
                                  }
                                  
                              }
                          
                           if(isset($sheet['documentUpload'][$x]['actual_date'])){ 
                              ?> 
                              <?php if(isset($sheet['documentUpload'][$x]['actual_date'])){ 
                                  ?> 
                                  <td  style="float:left;padding: 0px 2px 0px 5px;width: 3.5%">
                                  <?php echo $sheet['documentUpload'][$x]['target_date'];?> 
                                  </td>
                                  <td style="text-align:center;width: 3.5%">
                                  <?php echo $sheet['documentUpload'][$x]['actual_date'];?> 
                                  </td> 
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
