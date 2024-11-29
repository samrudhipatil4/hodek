<?php require app_path().'/views/header.php'; ?>
<?php $user_type = Session::get('gid');?>



<div class="col-sm-12" >

    <div class="row">
        <div class="col-sm-8">
            <div class="page-heading">
                <h1>No. of change requests raised per purpose per customer</h1>
            </div><!--/page-heading-->

        </div>
        <div class="col-sm-4">
            <div class="page-heading pull-right">
                <a class="btn btn-animate flat blue pd-btn" href="<?php echo Request::root().'/totalNoOfCRPerCustPerPurpose'; ?>">Back To Search</a>
            </div><!--/page-heading-->


        </div>
    </div>
    <form method="post" action="<?php echo Request::root().'/totalNoOfCRPerCustPerPurpose/download'; ?>">
        <div class="content-wrapper">

              <div class="row mg-btm">
                <div class="col-sm-6">
                   <input type="hidden" name="created_date" value="<?=$formInput['startdate'];?>">
                    <input type="hidden" name="end_date" value="<?=$formInput['enddate'];?>">
                     <input type="hidden" name="stage" value="<?=$formInput['stage_id'];?>">
                      <input type="hidden" name="plant" value="<?=$formInput['plant'];?>">
                       <input type="hidden" name="changeType" value="<?=$formInput['changeType'];?>">
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
                    
                        <th width="300"><span><span></th>
                        <th>
                         <?php $cnt=0;
                                foreach ($purpose as $row) {
                                        $cnt++;
                                 } 
                                $width=$cnt*10;?>                       
                            <table>
                            <tr>
                                     <?php $cnt=0;
                             foreach ($purpose as $row) { $cnt++;?>
                             <th width="<?php echo $width; ?>" class="rotate"><span><?php echo $row->changerequest_purpose; ?></span></th>
                             <?php } ?> 
                                </tr>
                            </table>
                        </th>
                         </tr>
                    </thead>
                    <tbody>
                      <?php if(sizeof($purpose)>0){

                        $i=1;
                        foreach($custdata as $sheet){
                         
                         ?>
                         <tr class="tr-bdr">
                         <td><?php echo $sheet->CustName;?></td>
                         <td>
                         <table>
                             <tr>
                                <?php foreach($purpose as $row){ ?>

                                <td width="<?php echo $width; ?>" style='text-align: center'><?php if($formInput['stage_id']=='' && ($formInput['startdate']=='' && $formInput['enddate']=='')){
                                  
                                    $count=DB::select(DB::raw("select count(request_id) as nos from total_cr_customerpurpose where purpose_id='".$row->purpose_id."' and customer_id='".$sheet->customer_id."'")) ;if(!empty($count)){print_r($count[0]->nos);}else{ echo 0;}
                                    }else if($formInput['stage_id']!='' && ($formInput['startdate']=='' && $formInput['enddate']=='')){
                                       
                                        $count=DB::select(DB::raw("select count(request_id) as nos from total_cr_customerpurpose where change_stage=".$formInput['stage_id']." and purpose_id='".$row->purpose_id."' and customer_id='".$sheet->customer_id."'")) ;
                                        if(!empty($count)){print_r($count[0]->nos);}else{ echo 0;}
                                        }else if($formInput['stage_id']=='' && ($formInput['startdate']!='' && $formInput['enddate']!='')){
                                            $count=DB::select(DB::raw("select count(request_id) as nos from total_cr_customerpurpose where (dt>='".$formInput['startdate']."' and dt<='".$formInput['enddate']."') and purpose_id='".$row->purpose_id."' and customer_id='".$sheet->customer_id."'")) ;
                                        if(!empty($count)){print_r($count[0]->nos);}else{ echo 0;}
                                        }else{
                                            $count=DB::select(DB::raw("select count(request_id) as nos from total_cr_customerpurpose where change_stage='".$formInput['stage_id']."' and (dt>='".$formInput['startdate']."' and dt<='".$formInput['enddate']."') and purpose_id='".$row->purpose_id."' and customer_id='".$sheet->customer_id."'")) ;
                                        if(!empty($count)){print_r($count[0]->nos);}else{ echo 0;}
                                        }
                                        ?>
                                            
                                 </td>
                                
                                <?php }?> 
                             </tr>
                         </table>
                         </td>
                         
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
