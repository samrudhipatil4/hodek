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
                        <td width="10%" style="border-left:1px solid #dcdcdc;padding:5px;font-size: 14px;"><strong><span>CM No.<span></strong></td>
                        <td width="10%" style="border-left:1px solid #dcdcdc;padding:5px;font-size: 14px;"><strong><span>Initiation Date<span></strong></td>
                        <td width="12%" style="border-left:1px solid #dcdcdc;padding:5px;font-size: 14px;"><strong><span>Initiator Name<span></strong></td>
                        <td colspan="5" width="65%" style="border-left:1px solid #dcdcdc;">
                          <table width="100%">
                            <tr>
                              <td width="15%" style="padding:5px;font-size: 14px;"><strong><span>Assigned To<span></strong></td>
                              <td width="35%" style="border-left:1px solid #dcdcdc;padding:5px;font-size: 14px;"><strong><span>Activity<span></strong></td>
                              <td width="5%" style="border-left:1px solid #dcdcdc;padding:5px;font-size: 14px;"><strong><span>Pending Days<span></strong></td>
                              <td colspan="2" width="40%" style="border-left:1px solid #dcdcdc;">
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

                        $i=1;
                        foreach($data as $sheet){
                         // echo '<pre>';print_r($sheet);exit();
                         ?>
                         <tr style="border-bottom:1px solid #dcdcdc;">
                         <td width="3%" style="border-left:1px solid #dcdcdc;padding:5px;"><?php echo $i;?></td>
                         <td width="10%" style="border-left:1px solid #dcdcdc;padding:5px;"><?php echo $sheet['cmNoview'];?></td>
                         <td width="10%" style="border-left:1px solid #dcdcdc;padding:5px;"><?php echo $sheet['initiation_dt'];?></td>
                         <td width="12%" style="border-left:1px solid #dcdcdc;padding:5px;"><?php echo $sheet['initiator'];?></td>
                         <td colspan="5" width="65%" style="border-left:1px solid #dcdcdc;">
                           <table width="100%">
                            <?php
                              foreach ($sheet['assigned_to'] as $value) {
                              ?>
                             <tr>
                               <td width="15%" style="padding:5px;"><span><?=$value['assignedto'];?></span></td>
                                <td width="35%" style="border-left:1px solid #dcdcdc;padding:5px;"><span><?=$value['activity'];?></span></td>
                                 <td width="5%" style="border-left:1px solid #dcdcdc;padding:5px;"><span><?=$value['pendingdays'];?></span></td>
                                 <?php if(!empty($value['actmonitoring'])){ ?>
                                <td colspan="2" width="40%" style="border-left:1px solid #dcdcdc;">
                                  <table width="100%">
                                   <?php foreach ($value['actmonitoring'] as $key) { ?>
                                    <tr>
                                      <td width="70%" style="padding:5px;"><span><?php echo $key->assessment_point_department; ?></span></td>
                                      <td width="30%" style="border-left:1px solid #dcdcdc;padding:5px;"><span><?php if($key->target_date!='0000-00-00'){ echo $key->target_date; }?></span></td>
                                    </tr>
                                    <?php } ?> 
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
                              <?php } ?> 
                           </table>
                         </td>

                         </tr>
                   
                    <?php $i=$i+1;}}else{?>
                      <tr>
                        <td colspan="9">NO Record Found
                        </td>
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
