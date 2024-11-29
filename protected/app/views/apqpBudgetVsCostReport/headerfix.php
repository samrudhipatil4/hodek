<html>
<style type="text/css">
	.summary-table1, .scrollbarX, .scrollbarX2{
 
  padding-bottom: 10px;
  position: relative;
}
.summary-table1 > table{
   table-layout: fixed; width: 100%;
}
.tbl-header{
  background-color: rgba(255,255,255,0.3);
 }
.tbl-content{
  height:800px;
  overflow-x:auto;
  margin-top: 0px;
  border: 1px solid rgba(255,255,255,0.3);
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
                <h1>Project Documentation Report</h1>
            </div><!--/page-heading-->

        </div>
         <div class="col-sm-4">
            <div class="page-heading pull-right">
                <a class="btn btn-animate flat blue pd-btn" href="<?php echo Request::root().'/project_dct_report'; ?>">Back To Search</a>
            </div><!--/page-heading-->


        </div>
    </div>

    <form method="post" action="<?php echo Request::root().'/project_report/download'; ?>">
        <div class="content-wrapper">

              <div class="row mg-btm">
                <div class="col-sm-6">

                    <div class="action-group pd-top">
                        <form method="post" action="">
                            <button class="btn btn-animate flat blue pd-btn "  value="excel" name="filetype" type="submit">Export to Excel Sheet</button>
                            <button class="btn btn-animate flat blue pd-btn "  value="pdf" name="filetype" type="submit">Export to PDF</button>
                            <input type="hidden" name="proj_id" value="<?php echo $project_id;?>">
                        </form>
                    </div>

                </div>
            </div>
            <div class="row mg-btm">
			  <div class="col-sm-6"><h4>
			    <?php  if(!empty($prjDetails['projectDts'])){
			    	
			    	$dtl=$prjDetails['projectDts'];
			    	
			      ?>
			      <h5><span style="font-weight: bold;">Project Number : </span><?php echo $dtl->project_no.' Revision '.$dtl->project_revision.' '.$prjDetails['checkHold'];  ?></h5>
			      <h5><span style="font-weight: bold;">Project Name : </span><?php echo $dtl->project_name;  ?></h5>
			      <h5><span style="font-weight: bold;">Project Start Date : </span><?php echo date('d F Y',strtotime($dtl->project_start_date));  }?></h5>
			      <?php  if(!empty($prjDetails['checkDrop'])){

			    	$drop=$prjDetails['checkDrop'][0];
			      ?>
			     <h5><span style="font-weight: bold;">Project is dropped by :</span> <?php echo $drop->first_name.' '.$drop->last_name;  ?></h5>
			     <h5><span style="font-weight: bold;">Remark :</span> <?php echo $drop->remark; } ?></h5>
			  </h4>
			 </div>
 		</div>

            

		 <div class="summary-table report-wrapper scrollbarX"  >
		 	 <div class="tbl-header">
                <table class="striped" border="1" cellpadding="0" cellspacing="0" border="0">
                    <thead>
                    <tr class="tr-bdr">
                    <th width="50">SR NO</th>
                    <th width="50">Gate No</th>
                    <th width="200">Gate</th>
                    <th width="300">Activity</th>
                    <th width="200">Responsibility</th>
                    <th width="150">Activity Start Date</th>
                    <th width="150">Activity End Date</th>
                     <th width="150">Remark</th>
                    <th width="700" style="text-align: center;">     Document
                    		<table>
                    		<tr>
                   
                    	<th width="50" style="text-align: center;">SR.NO</th>
							 		<th width="225" style="text-align: center;">Parameter</th>
							 		<th width="225" style="text-align: center;">Action</th>
							 		<th width="225" style="text-align: center;">Cost</th>
							 		<th width="225" style="text-align: center;">Document</th>
                    </tr>
                    		</table>
                    </th>
                   	
                    </tr>
                    
                    </thead>
                    </table>
                    </div>
                    <div class="tbl-content">
                    <table class="striped" border="1" cellpadding="0" cellspacing="0" border="0">
                    <tbody>
                   
                   <?php 
                   		$i1=1;	$j=1;
							 	
							 	$pregate ='';
							 	$premat='';
							 	$pgate = '';
								foreach ($alldata as $value) {

									$ngate = $value['gate_id'];
									if($ngate != $pgate){
										$i2 = 1; ?>
										<tr><td  colspan="6" style="font-weight:bold;"><?php echo 'Gate '.$value['gate_id'];?></td></tr>
										<?php }
								$pgate = $ngate;

							 	if($value['material_id'] == 0){ ?>
							 	<tr class="tr-bdr">
							 		<td width="5"><?php echo $j;?></td>
							 		<td width="10"><?php echo $value['gate_id'].'.'.$i2?></td>
							 		<td width="120"><?php echo $value['gate_name'];?></td>
							 		<td width="200"><?php echo $value['activity_name'];?></td>
							 		<td width="170"><?php echo $value['getUserName'];?></td>
							 		<td width="120"><?php  echo date('d M Y',strtotime($value['activity_start_date']));?></td>
							 		<td width="125"><?php echo date('d M Y',strtotime($value['activity_end_date']));?></td>
							 		<td width="120"><?php echo $value['remark'];?></td>
							<td width="700"><div class="summary-table1"  ><table >
							 		<?php $i=1;if(!empty($value['document'])) { 
							 			
							 			foreach($value['document'] as $row){  
							 				if($row['id'] == $value['d_id']){ ?>
												<tr><td style="width:10"><?php echo $i;?></td>
												<td width="225"> <?php echo $row['parameter'].' '; ?>	</td>
												<td width="225"> <?php echo $row['action'].' '; ?>	</td>
												<td width="225"> <?php echo $row['cost'].' '; ?>	</td>
												<td width="225">
												<?php if(!empty($row['doc'])) { 
												foreach($row['doc'] as $key){ 
														 if(!empty($key)) {
														 	$m=1;
														 	foreach ($key as $val ) {
														  ?>
												<?php echo $m.'.'.$val->upload_doc; ?>
							 		<?php if(!empty($val->upload_doc)){?><a href="<?php echo Request::root().'/download?path=apqp_activity_document&filename='.$val->upload_doc;?>" data-position="bottom" data-delay="50" data-tooltip="Download"><i class="glyphicon glyphicon-download-alt"></i><?php echo '<br>';?></a><?php } $m++;}  }} }?>
							 			 
							 			 </td></tr>
							 			<?php $i++; } } }?></table></div></td>

							 	</tr>
							 	<?php $i2++;
								$j++; }else{
							 		$newgate = $value['gate_id'];
							 		$newmat = $value['material_id'];
							 		if($newgate != $pregate || $newmat != $premat){ ?>

							 			<tr><td colspan="2"></td><td colspan=4 style="font-weight:bold;"><div><?php echo $value['mat_name']; ?></div></td></tr>
							 			<?php } $pregate=$newgate;
							 		$premat=$newmat;?>
<tr>
							 		<td width="5"><?php echo $j;?></td>
							 		<td width="10"><?php echo $value['gate_id'].'.'.$i2?></td>
							 		<td width="120"><?php echo $value['gate_name'];?></td>
							 		<td width="200"><?php echo $value['activity_name'];?></td>
							 		<td width="170"><?php echo $value['getUserName'];?></td>
							 		<td width="120"><?php echo date('d M Y',strtotime($value['activity_start_date']));?></td>
							 		<td width="120"><?php echo date('d M Y',strtotime($value['activity_end_date']));?></td>
							 		<td width="120"><?php echo $value['remark'];?></td>
							 		<td width="700"><div class="summary-table1"  ><table  >
							 		<?php $i=1;if(!empty($value['document'])) { 
							 			foreach($value['document'] as $row){  
							 				if($row['id'] == $value['d_id']){ ?>
												<tr><td style="width:10"><?php echo $i;?></td>
												<td width="225"> <?php echo $row['parameter'].' '; ?>	</td>
												<td width="225"> <?php echo $row['action'].' '; ?>	</td>
												<td width="225"> <?php echo $row['cost'].' '; ?>	</td>
												<td width="225">		
													<?php if(!empty($row['doc'])) { 
													foreach($row['doc'] as $key){ 
														 if(!empty($key)) { 
														 	$m=1;
														foreach ($key as $val ) {
															
														 	?>
												
												<?php echo $m.'.'.$val->upload_doc; ?>

							 					
							 		<?php if(!empty($val->upload_doc)){?><a href="<?php echo Request::root().'/download?path=apqp_activity_document&filename='.$val->upload_doc;?>" data-position="bottom" data-delay="50" data-tooltip="Download"><i class="glyphicon glyphicon-download-alt"></i><?php echo '<br>';?></a><?php } $m++;} } }}?>
							 			 
							 			 </td></tr>
							 			<?php $i++; } } }?></table></div></td>
							 		


							 	</tr>
							 	<?php $i2++;
								$j++; }}?>
								
                   
                    </tbody>
                </table>
                </div>
            </div><!--/summary-table-->
            </div>
            </form>
            </div>
	</body>
	<?php require app_path().'/views/footer.php'; ?>
	<script type="text/javascript">
		$(window).on("load resize ", function() {
  var scrollWidth = $('.tbl-content').width() - $('.tbl-content table').width();
  $('.tbl-header').css({'padding-right':scrollWidth});
}).resize();
	</script>
</html>