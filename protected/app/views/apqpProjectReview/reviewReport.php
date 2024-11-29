<html>
<style type="text/css">
	.summary-table1, .scrollbarX, .scrollbarX2{
 
  padding-bottom: 10px;
  position: relative;
}
.summary-table1 > table{
   table-layout: fixed; width: 100%;
   word-wrap: break-word;
}
.col-border{
	border-left: 1px solid #dddddd;
	border-right: 1px solid  #dddddd;
}

</style>
	<head>
		<?php require app_path().'/views/apqp_header.php'; ?>
	</head>
	<body>
	<div class="col-sm-12" >

    <div class="row">
        <div class="col-sm-8">
            <div class="page-heading">
                <h1 style="font-size: 24px;
    font-family: cursive;">Project Review Report </h1>
            </div><!--/page-heading-->

        </div>
         <div class="col-sm-4">
            <div class="page-heading pull-right">
                <a class="btn btn-animate flat blue pd-btn" href="<?php echo Request::root().'/projectReview_Report'; ?>">Back To Search</a>
            </div><!--/page-heading-->


        </div>
    </div>

    <form method="post" action="<?php echo Request::root().'/review_report/download'; ?>">
        <div class="content-wrapper">

              <div class="row mg-btm">
                <div class="col-sm-6">

                    <div class="action-group pd-top">
                        <form method="post" action="">
                            <button class="btn btn-animate flat blue pd-btn "  value="excel" name="filetype" type="submit">Export to Excel Sheet</button>
                            <button class="btn btn-animate flat blue pd-btn "  value="pdf" name="filetype" type="submit">Export to PDF</button>
                            <input type="hidden" name="proj_no" value="<?php echo $project_id;?>">
                        </form>
                    </div>

                </div>
            </div>
         <!--    <div class="row mg-btm">
			  <div class="col-sm-6"><h4>
			    <?php  if(!empty($prjDetails['projectDts'])){
			    	
			    	$dtl=$prjDetails['projectDts'];
			    	//echo $dtl->project_no;exit();
			      ?>
            <?php if(!empty($dtl)){?>
			      <h5><span style="font-weight: bold;">Project Number : </span><?php echo $dtl->project_no.' Revision '.$dtl->project_revision; if(!empty($prjDetails['checkHold'])){ $prjDetails['checkHold']; }  ?></h5>
			      <h5><span style="font-weight: bold;">Project Name : </span><?php echo $dtl->project_name;  ?></h5>
			      <h5><span style="font-weight: bold;">Project Start Date : </span><?php echo date('d F Y',strtotime($dtl->project_start_date));  }?></h5>
            <?php } ?>
			      <?php  if(!empty($prjDetails['checkDrop'])){

			    	$drop=$prjDetails['checkDrop'][0];
			      ?>
			     <h5><span style="font-weight: bold;">Project is dropped by :</span> <?php echo $drop->first_name.' '.$drop->last_name;  ?></h5>
			     <h5><span style="font-weight: bold;">Remark :</span> <?php echo $drop->remark; } ?></h5>
			  </h4>
			 </div>
 		</div> -->

            

		 <div class="summary-table report-wrapper scrollbarX"  >

                <table class="striped" border="1">
                    <thead>
                    <tr class="tr-bdr">
                    <th width="50">SR NO</th>
                    <th width="120">Project </th>
                    <th width="150">Gate</th>
                    <th width="100">Review Date</th>
                    <th width="150">Comment</th>
                     <th width="150">Team Member</th>
                     <th width="100">File</th>
                   <!-- 
                     <th width="150">Budget Cost</th>
                    <th width="150">Actual Cost</th> -->
                   	
                    </tr>
                    
                    </thead>
                    <tbody>
                   
                   <?php

                    if(sizeof($alldata)>0){

                        $i=0;
                        foreach($alldata as $val){  
                      //echo '<pre>';print_r($val['checkHold']);exit();
                    //}
                        
                        	?>

                                <tr>

                                    

                                    <td><?=++$i?>.</td>

                                    <td>
                                        <?=$val['project_no'].' '.$val['checkHold'].' '.$val['checkDrop'];?>
                                   </td>

                                   <td><table>
                                   <?php foreach($val['allreview']['gate'] as $key){ 
                                   ?>
                                    <tr><td> <?= $key->Gate_Description; ?></td>
                                    		<?php } ?>
                                    </tr></table></td>
                                    <td><table>
                                    <?php foreach($val['allreview']['reviewDatecomment'] as $key){ ?>
                                  <tr><td>
                                  	 <?= date('d-m-Y',strtotime($key->review_date));?></td>
                                   <?php  } ?>
                                   </table></td>
                                    <td><table>
                                    <?php foreach($val['allreview']['reviewDatecomment'] as $key){ ?>
                                  <tr>
                                    <td><?= $key->comment;?></td> </tr>
                                   <?php  } ?>
                                   </table></td>
                                   <td><table>
                                  <tr>
                                    <td>
                        		  <?php foreach($val['reviewMember'] as $key){ 
                        		  		foreach($key as $k1){
                        		   ?>
                                    <?= $k1->first_name.' '.$k1->last_name.'<br>';?>
                                    	 <?php  } } ?>
                                    </td> </tr>
                                  
                                   </table></td>
                                   <td><table>
                                  <tr>
                                    <td>
                        		  <?php foreach($val['reviewfile'] as $key){ 
                        		  		foreach($key as $k1){
                        		   ?>
                                    <?= $k1->file_name.'<br>';?>
                                    <a href="<?php echo Request::root().'/download?path=review_document&filename='.$k1->file_name;?>" data-position="bottom" data-delay="50" data-tooltip="Download"><i class="glyphicon glyphicon-download-alt"></i><?php echo '<br>';?></a>
                                    	 <?php  } } ?>
                                    </td> </tr>
                                  
                                   </table></td>
                                  
                                </tr>

                            <?php } 
                            }   else{?>
                        <tr>
                            No Records Found.

                        </tr>
                    <?php } ?>
                   
                    </tbody>
                </table>

            </div><!--/summary-table-->
            </div>
            </form>
            </div>
	</body>
	<?php require app_path().'/views/footer.php'; ?>
</html>