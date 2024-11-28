<?php require app_path().'/views/header.php'; ?>
<?php $user_type = Session::get('gid');?>



<div class="col-sm-12" >

    <div class="row">
        <div class="col-sm-8">
            <div class="page-heading">
                <h1>User Status</h1>
            </div><!--/page-heading-->

        </div>
        
    </div>
    <form method="post" action="<?php echo Request::root().'/checkForUserActiveDownload'; ?>">
        <div class="content-wrapper">

              <div class="row mg-btm">
                <div class="col-sm-6">

                    <div class="action-group pd-top">
                        <form method="post" action="">
                            <button class="btn btn-animate flat blue pd-btn "  value="excel" name="filetype" type="submit">Export to Excel Sheet</button>
                            <button class="btn btn-animate flat blue pd-btn "  value="pdf" name="filetype" type="submit">Export to PDF</button>
                            <input type="hidden" name="user" value="<?php echo $arr['user'];?>">
                        </form>
                    </div>

                </div>
            </div>
            <!-- summary Table start -->
            <div class="summary-table report-wrapper scrollbarX">

                <table class="striped">
                    <thead>
                    <tr class="tr-bdr">

                        <th width="20" ><span>Sr. No.<span></th>
                        <th width="20" ><span>User Name<span></th>
                        <th width="120" ><span>User Involed In<span></th>
                       

                         </tr>
                    </thead>
                    <tbody>
                    <?php if(sizeof($data)>0){

                        $i=1;
                        foreach($data as $sheet){
                       
                         ?>
                         <tr border="1">
                         <td><?php echo $i;?></td>
                         <td><?php echo $sheet['username'][0]->first_name." ".$sheet['username'][0]->last_name." ".$sheet['username'][0]->last_name.'<br>'; ?>
                       </td>
                         <td>
                        <?php  if(!empty($sheet['userTask'])){ 
                              foreach( $sheet['userTask'] as $key){
                                
                            echo $key['cmNoSearch'].'  '.$key['message'].'<br>';
                        }
                        }
                        if(!empty($sheet['CFTForSeries'])){
                          
         
                         foreach( $sheet['CFTForSeries'] as $key){

                             echo 'CFT Member For Change Request '.$key['cmNoSearch'].'<br>';
                             }
                             }
                         if(!empty($sheet['projectManager'])){
                         foreach( $sheet['projectManager'] as $key){ 
                            echo 'Project Manager For Project  '.$key->project_code.'<br>';
                             }
                             }
                             if(!empty($sheet['custCommrep'])){ 
                                 foreach( $sheet['custCommrep'] as $key){ 
                            echo 'Customer Communication Representative For Project  '.$key->project_code.'<br>';
                             }
                         }
                             if(!empty($sheet['custCommApp'])){ 
                                  foreach( $sheet['custCommApp'] as $key){ 
                            echo 'Customer Communication Approval Member For Project  '.$key->project_code.'<br>';
                             }
                         }
                             if(!empty($sheet['docVer'])){ 
                                 foreach( $sheet['docVer'] as $key){ 
                            echo 'Document Verifier For Project  '.$key->project_code.'<br>';
                             }
                         }
                             if(!empty($sheet['finalApproval'])){ 
                                  foreach( $sheet['finalApproval'] as $key){ 
                            echo 'Final Approval Member For Project  '.$key->project_code.'<br>';
                             }
                         }
                             if(!empty($sheet['projectMasterCFT'])){ 
                                 foreach( $sheet['projectMasterCFT'] as $key){ 
                            echo 'CFT Member For Project  '.$key->project_code.'<br>';
                             }
                         }
                         if(!empty($sheet['docverifyconfig'])){ 
                                
                            echo 'document verifier in Document Verifier Master<br>';
                           
                         }
                         
                         if(!empty($sheet['riskAppForSeries'])){ 
                                 
                            echo 'Overall Risk Approval Member in Document Verifier Master <br>';
                             
                         }
                         if(!empty($sheet['CFTRepresentative'])){ 
                                 
                            echo 'CFT Team Representative in CFT Team Representative Master<br>';
                             
                         }
                         if(!empty($sheet['custComm'])){ 
                                
                            echo 'Customer Communication Document Upload Member in  Customer Communication Management Master <br>';
                             
                         }
                         if(!empty($sheet['custCommapp'])){ 
                                
                            echo 'Customer Communication Approval in  Customer Communication Management Master <br>';
                            
                         }
                        ;?></td>
                         
                      </tr>
                        <?php $i++;} }?>
                    </tbody>
                </table>

            </div><!--/summary-table-->

           

            <!-- summary Table end -->

        </div><!--/content-wrapper-->

    </form>
</div><!--/s10-->
<?php require app_path().'/views/footer.php'; ?>


<script type="text/javascript">
