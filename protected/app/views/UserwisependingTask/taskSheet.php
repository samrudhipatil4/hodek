<?php require app_path().'/views/header.php'; ?>
<?php $user_type = Session::get('gid');?>



<div class="col-sm-12" >

    <div class="row">
        <div class="col-sm-8">
            <div class="page-heading">
                <h1>Pending Task</h1>
            </div><!--/page-heading-->

        </div>
         <div class="col-sm-4">
            <div class="page-heading pull-right">
                <a class="btn btn-animate flat blue pd-btn" href="<?php echo Request::root().'/userwise_pending_tasks'; ?>">Back To Search</a>
            </div><!--/page-heading-->


        </div>
    </div>
    <form method="post" action="<?php echo Request::root().'/userpending_task/download'; ?>">
        <div class="content-wrapper">

              <div class="row mg-btm">
                <div class="col-sm-6">
                   <input type="hidden" name="startdate" value="<?=$formInput['startdate'];?>">
                    <input type="hidden" name="enddate" value="<?=$formInput['enddate'];?>">
                    <input type="hidden" name="dept_id" value="<?=$formInput['dept_id'];?>">
                    <input type="hidden" name="user_id" value="<?=$formInput['user_id'];?>">
                     <input type="hidden" name="quest" value="<?=$formInput['quest'];?>">
                      <input type="hidden" name="changeType" value="<?=$formInput['changeType'];?>">
                       <input type="hidden" name="change_stage_id" value="<?=$formInput['change_stage_id'];?>">
                        <input type="hidden" name="plantcode" value="<?=$formInput['plantcode'];?>">
                         <input type="hidden" name="r_id" value="<?=$formInput['r_id'];?>"> 
                    <div class="action-group pd-top">
                        <form method="post" action="">
                            <button class="btn btn-animate flat blue pd-btn "  value="excel" name="filetype" type="submit">Export to Excel Sheet</button>
                            <button class="btn btn-animate flat blue pd-btn "  value="pdf" name="filetype" type="submit">Export to PDF</button>
                        </form>
                    </div>

                </div>
            </div>
            <!-- summary Table start -->
            <div class="summary-table" style="font-size: 12px;">

                <table style="border-top: 1px solid #e5e5e5; border-left: 1px solid #e5e5e5;border-right: 1px solid #e5e5e5;">
                    <thead style="border-bottom:1px solid #dcdcdc;">
                    <tr style="border-bottom:1px solid #dcdcdc;">

                        <td width="3%" style="border-left:1px solid #dcdcdc;padding:5px;font-size: 14px;"><strong><span>Sr. No.<span></strong></td>
                        <td width="9%" style="border-left:1px solid #dcdcdc;padding:5px;font-size: 14px;"><strong><span>CM No.<span></strong></td>
                        <td width="7%" style="border-left:1px solid #dcdcdc;padding:5px;font-size: 14px;"><strong><span>Initiation Date<span></strong></td>
                        <td width="8%" style="border-left:1px solid #dcdcdc;padding:5px;font-size: 14px;"><strong><span>Initiator Name<span></strong></td>
                        <td width="13%" style="border-left:1px solid #dcdcdc;padding:5px;font-size: 14px;"><strong><span>Part Name<span></strong></td>
                        <td width="13%" style="border-left:1px solid #dcdcdc;padding:5px;font-size: 14px;"><strong><span>Part Number<span></strong></td>
                         <td width="13%" style="border-left:1px solid #dcdcdc;padding:5px;font-size: 14px;"><strong><span>Modification Details<span></strong></td>
                        <td colspan="5" width="60%" style="border-left:1px solid #dcdcdc;">
                          <table width="100%">
                            <tr>
                              <td width="15%" style="padding:5px;font-size: 14px;"><strong><span>Assigned To<span></strong></td>
                              <td width="35%" style="border-left:1px solid #dcdcdc;padding:5px;font-size: 14px;"><strong><span>Activity<span></strong></td>
                              <td width="3%" style="border-left:1px solid #dcdcdc;padding:5px;font-size: 14px;"><strong><span>Pending Days<span></strong></td>
                              <td colspan="2" width="50%" style="border-left:1px solid #dcdcdc;">
                                <table width="100%">
                                  <tr>
                                    <td width="70%" style="padding:5px;font-size: 14px;"><strong><span>Activity Monitoring<span></strong></td>
                                    <td width="30%" style="border-left:1px solid #dcdcdc;padding:5px;font-size: 14px;"><strong><span>Target Date<span></strong></td>
                                  </tr>
                                </table>
                              </td>
                            </tr>
                          </table>
                        </td>

                    </tr>
                    </thead>
                    <tbody>
                      <?php if(sizeof($data)>0){
                        if($formInput['quest']==''){
                        $i=1;
                        foreach($data as $sheet){
                         
                         ?>
                        <tr style="border-bottom:1px solid #dcdcdc;">
                         <td width="3%" style="border-left:1px solid #dcdcdc;padding:5px;"><?php echo $i;?></td>
                         <td width="10%" style="border-left:1px solid #dcdcdc;padding:5px;"><?php echo $sheet['cmNoview'];?></td>
                         <td width="10%" style="border-left:1px solid #dcdcdc;padding:5px;"><?php echo $sheet['initiation_dt'];?></td>
                         <td width="12%" style="border-left:1px solid #dcdcdc;padding:5px;"><?php echo $sheet['initiator'];?></td>

                         <td width="5%" style="border-left:1px solid #dcdcdc;padding:5px;">  
                                 <ul class="listing">
                                <?php foreach($sheet['part'] as $partname ){ ?>
                               
                                   <li> <?php echo $partname->part_name.'<br>'; ?></li>
                                 
                                  <?php } ?>
                                    </ul>
                                  
                        </td>
                        <td width="5%" style="border-left:1px solid #dcdcdc;padding:5px;">  
                               <ul class="listing">
                                <?php foreach($sheet['part'] as $partname ){

                                    echo $partname->part_number.'<br>';
                                  } ?>
                                    </ul>
                        </td>
                         <td width="5%" style="border-left:1px solid #dcdcdc;padding:5px;"><?php echo $sheet['modDtls'];?></td>
                         <td colspan="5" width="60%" style="border-left:1px solid #dcdcdc;">
                           <table width="100%">
                            <?php
                              foreach ($sheet['assigned_to'] as $value) {
                                // echo '<pre>';print_r($sheet['assigned_to']);exit();
                              ?>
                             <tr>
                               <td width="15%" style="padding:5px;"><span><?=$value['assignedto'];?><?php echo ' ('.$value['department'].')';?></span></td>
                                <td width="35%" style="border-left:1px solid #dcdcdc;padding:5px;"><span><?=$value['activity'];?></span></td>
                                 <td width="5%" style="border-left:1px solid #dcdcdc;padding:5px;"><span><?=$value['pendingdays'];?></span></td>
                                 <?php if(!empty($value['actmonitoring'])){ ?>
                                <td colspan="2" width="50%" style="border-left:1px solid #dcdcdc;">
                                  <table width="100%">
                                   <?php foreach ($value['actmonitoring'] as $key) { ?>
                                    <tr>
                                      <td width="70%" style="padding:5px;"><span><?php echo $key->assessment_point_department; ?></span></td>
                                      <td width="30%" style="border-left:1px solid #dcdcdc;padding:5px;"><span><?php if($key->target_date!='0000-00-00'){ echo  date("d-m-Y", strtotime($key->target_date)); }?></span></td>
                                    </tr>
                                    <?php } ?> 
                                  </table>
                                </td>
                                <?php } else { ?>
                                  <td colspan="2" width="50%">
                                     <table width="100%">
                                      <tr>
                                      <td width="70%" style="border-left:1px solid #dcdcdc;padding:5px;"></td>
                                      <td width="30%" style="border-left:1px solid #dcdcdc;padding:5px;"></td>
                                     </tr>
                                  </table>
                                  </td>
                                 <?php } ?> 
                             </tr>
                              <?php } ?> 
                           </table>
                         </td>

                         </tr>
                   
                    <?php $i=$i+1;}}else{ $i=0;
                      foreach($data as $sheet){
                        
                        foreach ($sheet['assigned_to'] as $value) { 
                          if(!empty($value['actmonitoring'])){
                          foreach ($value['actmonitoring'] as $key) {
                            if(!empty($key)){
                              $i=$i+1;
                      ?>
                           <tr style="border-bottom:1px solid #dcdcdc;">
                         <td width="3%" style="border-left:1px solid #dcdcdc;padding:5px;"><?php  if(!empty($key)){ echo $i; }?></td>
                         <td width="10%" style="border-left:1px solid #dcdcdc;padding:5px;"><?php  if(!empty($key)){ echo $sheet['cmNoview']; }?></td>
                         <td width="10%" style="border-left:1px solid #dcdcdc;padding:5px;"><?php  if(!empty($key)){ echo $sheet['initiation_dt']; }?></td>
                         <td width="12%" style="border-left:1px solid #dcdcdc;padding:5px;"><?php  if(!empty($key)){ echo $sheet['initiator']; }?></td>

                          <td width="5%" style="border-left:1px solid #dcdcdc;padding:5px;">  
                                 <ul class="listing">
                                <?php foreach($sheet['part'] as $partname ){ ?>
                               
                                   <li> <?php echo $partname->part_name.'<br>'; ?></li>
                                 
                                  <?php } ?>
                                    </ul>
                                  
                        </td>
                        <td width="5%" style="border-left:1px solid #dcdcdc;padding:5px;">  
                               <ul class="listing">
                                <?php foreach($sheet['part'] as $partname ){

                                    echo $partname->part_number.'<br>';
                                  } ?>
                                    </ul>
                        </td>
                         <td width="5%" style="border-left:1px solid #dcdcdc;padding:5px;"><?php if(!empty($key)){ echo $sheet['modDtls']; }?></td>
                         <td colspan="5" width="60%" style="border-left:1px solid #dcdcdc;">
                           <table width="100%">
                            <!--  <?php
                              foreach ($sheet['assigned_to'] as $value) {
                              ?>  -->
                             <tr>
                               <td width="15%" style="padding:5px;"><span><?php  if(!empty($value['actmonitoring'])){ echo $value['assignedto'].' ('.$value['department'].')';}?></span></td>
                                <td width="35%" style="border-left:1px solid #dcdcdc;padding:5px;"><span><?php  if(!empty($value['actmonitoring'])){ echo $value['activity'];}?></span></td>
                                 <td width="5%" style="border-left:1px solid #dcdcdc;padding:5px;"><span><?php  if(!empty($value['actmonitoring'])){ echo $value['pendingdays']; }?></span></td>
                                 <?php if(!empty($value['actmonitoring'])){ ?>
                                <td colspan="2" width="50%" style="border-left:1px solid #dcdcdc;">
                                  <table width="100%">
                                  <!--  <?php foreach ($value['actmonitoring'] as $key) { ?> -->
                                    <tr>
                                      <td width="70%" style="padding:5px;"><span><?php echo $key->assessment_point_department; ?></span></td>
                                      <td width="30%" style="border-left:1px solid #dcdcdc;padding:5px;"><span><?php if($key->target_date!='0000-00-00'){ 
                                        $date = date_create($key->target_date);
                                        echo date_format($date, 'd-m-Y');
                                         }?></span></td>
                                    </tr>
                                    <!-- <?php } ?>  -->
                                  </table>
                                </td>
                                <?php } else { ?>
                                  <td colspan="2" width="40%">
                                     <table width="100%">
                                      <tr>
                                      <td width="70%" style="border-left:1px solid #dcdcdc;padding:5px;"></td>
                                      <td width="30%" style="border-left:1px solid #dcdcdc;padding:5px;"></td>
                                     </tr>
                                  </table>
                                  </td>
                                 <?php } ?> 
                             </tr>
                              <!-- <?php }?>   -->

                           </table>
                         </td>

                         </tr>
                        <?php }}}}}}}else{ ?>
                           <tr>
                            <td colspan="9">NO Record Found
                            </td>
                          </tr>
                        <?php } ?>
                    </tbody>
                </table>

            </div><!--/summary-table-->

           

            <!-- summary Table end -->

        </div><!--/content-wrapper-->

    </form>
</div><!--/s10-->
<?php require app_path().'/views/footer.php'; ?>


<script type="text/javascript">
