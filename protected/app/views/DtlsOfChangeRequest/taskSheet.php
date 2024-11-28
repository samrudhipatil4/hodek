<?php require app_path().'/views/header.php'; ?>
<?php $user_type = Session::get('gid');?>



<div class="col-sm-12" >

    <div class="row">
        <div class="col-sm-8">
            <div class="page-heading">
                <h1>Details of Change Request</h1>
            </div><!--/page-heading-->

        </div>
        <div class="col-sm-4">
            <div class="page-heading pull-right">
                <a class="btn btn-animate flat blue pd-btn" href="<?php echo Request::root().'/changeRequestReport'; ?>">Back To Search</a>
            </div><!--/page-heading-->


        </div>
    </div>
    <form method="post" action="<?php echo Request::root().'/dtlsChangeRequest/download'; ?>">
        <div class="content-wrapper">

              <div class="row mg-btm">
                <div class="col-sm-6">
                   <input type="hidden" name="startdate" value="<?=$formInput['startdate'];?>">
                    <input type="hidden" name="enddate" value="<?=$formInput['enddate'];?>">
                    <input type="hidden" name="dept_id" value="<?=$formInput['dept_id'];?>">
                    <input type="hidden" name="user_id" value="<?=$formInput['user_id'];?>">
                     <input type="hidden" name="stage" value="<?=$formInput['stage_id'];?>">
                      <input type="hidden" name="changeType" value="<?=$formInput['changeType'];?>">
                     <input type="hidden" name="plant" value="<?=$formInput['plant_id'];?>">
                     <input type="hidden" name="project" value="<?=$formInput['project'];?>">
                     <input type="hidden" name="stakeholder" value="<?=$formInput['stakeholder'];?>">
                     <input type="hidden" name="purpose" value="<?=$formInput['purpose'];?>">
                    <div class="action-group pd-top">
                        <form method="post" action="">
                            <button class="btn btn-animate flat blue pd-btn "  value="excel" name="filetype" type="submit">Export to Excel Sheet</button>
                            <button class="btn btn-animate flat blue pd-btn "  value="pdf" name="filetype" type="submit">Export to PDF</button>
                        </form>
                    </div>

                </div>
            </div>
           <div class="summary-table report-wrapper scrollbarX">

                <table class="striped">
                    <thead>
                    <tr class="tr-bdr">

                        <th width="40"><span>Sr. No.<span></th>
                        <th width="150"><span>CM No.<span></th>
                        <th width="150"><span>Plant<span></th>
                        <th width="150"><span>Initiator Name<span></th>
                        <th width="150"><span>Initiator Department<span></th>
                        <th width="150"><span>Business<span></th>
                        <th width="150"><span>Stakeholder<span></th>
                        <th width="150"><span>Change Stage<span></th>
                        <th width="150"><span>Change Type<span></th>
                        <th width="250"><span>Project Code<span></th>
                        <th width="150"><span>Purpose<span></th>
                        <th width="150"><span>Customer<span></th>
                        <th width="150"><span>Part No<span></th>
                        <th width="150"><span>Part Name<span></th>
                        <th width="200"><span>Modification Details<span></th>
                        <th width="150"><span>Remark<span></th>
                        <th width="150"><span>Implementation Date<span></th>
                         <th width="150"><span>Cut-Off Date<span></th>
                        <th width="250"><span>Status<span></th>
                         </tr>
                    </thead>
                    <tbody>
                      <?php if(sizeof($data)>0){

                        $i=1;
                        foreach($data as $sheet){
                         // print_r($sheet);exit();
                         ?>
                         <td><?php echo $i;?></td>
                         <td><?php echo $sheet['cmNoview'];?></td>
                         <td><?php echo $sheet['plant'];?></td>
                         <td><?php echo $sheet['initiator'];?></td>
                         <td><?php echo $sheet['dept'];?></td>
                         <td><?php echo $sheet['business'];?></td>
                         <td><?php echo $sheet['stakeholder'];?></td>
                         <td><?php echo $sheet['stage'];?></td>
                         <td><?php echo $sheet['type'];?></td>
                         <td><?php echo $sheet['projectcode'];?></td>
                         <td>
                         <ul>
                         <?php foreach($sheet['purpose'] as $row) {?>
                         <li style="margin-left: -40px;">&#9830; <?php echo $row->changerequest_purpose; ?></li>
                         <?php } ?>
                         </ul>
                         </td>
                         <td>
                         <ul>
                         <?php foreach($sheet['cust'] as $row) { ?>
                         <li style="margin-left: -40px;">&#9830; <?php echo $row->cust;?></li>
                         <?php } ?>
                         </ul> 
                         </td>
                         <td>
                         <ul>
                         <?php foreach($sheet['partno'] as $row) { ?>
                         <li style="margin-left: -40px;">&#9830; <?php echo $row->part_number;?></li>
                         <?php } ?>
                         </ul>  
                         </td>
                         <td>
                         <ul>
                         <?php foreach($sheet['partno'] as $row) { ?>
                         <li style="margin-left: -40px;">&#9830; <?php echo $row->part_name;?></li>
                         <?php } ?>
                         </ul>  
                         </td>
                         <td><?php echo $sheet['modDtls'];?></td>
                         <td><?php echo $sheet['remark'];?></td>
                         <td><?php echo $sheet['impdate'];?></td>
                         <td><?php echo $sheet['actualImpDate'];?></td>
                         <td><?php echo $sheet['status'];?></td>
                        
                    <tr>
                    
                    </tr>
                    <?php $i=$i+1;}}else{?>
                      <tr>
                        <td>NO Record Found
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
