<?php require app_path().'/views/header.php'; ?>
<?php $user_type = Session::get('gid');?>



<div class="col-sm-12" >

    <div class="row">
        <div class="col-sm-8">
            <div class="page-heading">
                <h1>Pending Task</h1>
            </div><!--/page-heading-->

        </div>
        
    </div>
    <form method="post" action="<?php echo Request::root().'/pending_task/download'; ?>">
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

                        <th width="20" class="rotate"><span>Sr. No.<span></th>
                        <th width="70" class="rotate"><span>User Name<span></th>
                        <th width="70" class="rotate"><span>Department Name<span></th>
                        <th width="30" class="rotate"><span>Pending For<br>Reinitiation<span></th>
                        <th width="30" class="rotate"><span>HOD Approval<span></th>
                        <th width="30" class="rotate"><span>Define Cross <br>Functional Team<span></th>
                       <th width="30" class="rotate"><span>Risk Entry<span>
                        </th>
                        <th width="30" class="rotate"><span>Risk Entry HOD <br>Approval<span></th>
                        <th width="30" class="rotate"><span>Risk Approval By<br>Superadmin/Project <br>Manager / Initiator<span></th>
                         <th width="30" class="rotate"><span>Steering Commitee <br>Approval<span></th>
                          <th width="30" class="rotate"><span>QA Head Decision<span></th>
                           <th width="30" class="rotate"><span>Customer Evidence <br>Upload<span></th>
                           <th width="30" class="rotate"><span>Customer Evidence <br> Upload Approve<span></th>
                           <th width="30" class="rotate"><span>Activity Document <br> Upload <span></th>
                           <th width="30" class="rotate"><span>Activity Document <br> Upload Approve<span></th>
                           <th width="30" class="rotate"><span>PTR Document <br> Upload<span></th>
                           <th width="30" class="rotate"><span>Horizontal <br>Deployment <span></th>
                           <th width="30" class="rotate"><span>Before After Status<span></th>
                           <th width="30" class="rotate"><span>Final Approval<span></th>
                            <th width="30" class="rotate"><span>TOTAL<span></th>

                         </tr>
                    </thead>
                    <tbody>
                    <?php if(sizeof($data)>0){

                        $i=1;
                        foreach($data as $sheet){
                         
                         ?>
                         <td><?php echo $i;?></td>
                         <td><?php echo $sheet['allUser'][0]->first_name." ".$sheet['allUser'][0]->last_name;?></td>
                         <td><?php echo $sheet['allUser'][0]->d_name;?></td>
                         <td><?php echo $sheet['reintiate']['total'];?></td>
                         <td><?php echo $sheet['hod_approval']['total'];?></td>
                         <td><?php echo $sheet['ini_info_sheet']['total'];?></td>
                         <td><?php echo $sheet['riskEntry']['total'];?></td>
                         <td><?php echo $sheet['risk_entry_hod']['total'];?></td>
                         <td><?php echo $sheet['risk_admin_app']['total'];?></td>
                         <td><?php echo $sheet['steer_comm']['total'];?></td>
                         <td><?php echo $sheet['QA_head']['total'];?></td>
                         <td><?php echo $sheet['customer_evi_upload']['total'];?></td>
                         <td><?php echo $sheet['admin_cust_app']['total'];?></td>
                         <td><?php echo $sheet['docUpload']['total'];?></td>
                         <td><?php echo $sheet['app_doc_upload']['total'];?></td>
                         <td><?php echo $sheet['ptrUpload']['total'];?></td>
                          <td><?php echo $sheet['hor_dep']['total'];?></td>
                         <td><?php echo $sheet['before_after']['total'];?></td>
                         <td><?php echo $sheet['final_app']['total'];?></td>
                         <td><?php $total= $sheet['reintiate']['total']+$sheet['hod_approval']['total']+$sheet['ini_info_sheet']['total']
                                          +$sheet['riskEntry']['total']+$sheet['risk_entry_hod']['total']+$sheet['risk_admin_app']['total']
                                          +$sheet['steer_comm']['total']+$sheet['QA_head']['total']+$sheet['customer_evi_upload']['total']
                                          +$sheet['admin_cust_app']['total']+$sheet['docUpload']['total']+$sheet['app_doc_upload']['total']
                                          +$sheet['hor_dep']['total']+$sheet['before_after']['total']+$sheet['final_app']['total'];  if($total != 0){echo $total;}?></td>
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
