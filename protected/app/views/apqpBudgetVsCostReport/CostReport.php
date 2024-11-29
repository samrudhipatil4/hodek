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
.report-wrapper > table > tbody >  tr > td {
 color: #4c4c4c  !important;
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
    font-family: cursive;">Budget Vs Actual Cost Report </h1>
            </div><!--/page-heading-->

        </div>
         <div class="col-sm-4">
            <div class="page-heading pull-right">
                <a class="btn btn-animate flat blue pd-btn" href="<?php echo Request::root().'/budgetvsactual_report'; ?>">Back To Search</a>
            </div><!--/page-heading-->


        </div>
    </div>

    <form method="post" action="<?php echo Request::root().'/cost_report/download'; ?>">
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

                <table class="striped" border="1">
                    <thead>
                    <tr class="tr-bdr">
                    <th width="50">SR NO</th>
                    <th width="50">Gate No</th>
                    <th width="200">Gate</th>
                    <th width="300">Activity</th>
                    <th width="200">Responsibility</th>
                   
                     <th width="150">Budget Cost</th>
                    <th width="150">Actual Cost</th>
                   	<th width="150">Manpower Cost</th>
                    </tr>
                    
                    </thead>
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
							 	<tr>
							 		<td><?php echo $j;?></td>
							 		<td><?php echo $value['gate_id'].'.'.$i2?></td>
							 		<td><?php echo $value['gate_name'];?></td>
							 		<td><?php echo $value['activity_name'];?></td>
							 			<td><?php echo $value['getUserName'];?></td>
							 	
							 		<td><?php if($value['budgetCost'] != 0){ echo $value['budgetCost'];}?></td>
							<?php $i=1;if(!empty($value['actualCost'])) { 
							 			
							 			foreach($value['actualCost'] as $row){  
							 				if(($row['cost'] != 0 && $value['budgetCost'] != 0) && $row['cost'] > $value['budgetCost']){

							 				
							 				 ?>
							<td style="background-color: red"><?php if($row['cost'] != 0){ echo $row['cost']; } ?></td>
										<?php $i++;
										  }else if(($row['cost'] != 0 && $value['budgetCost'] != 0) && $row['cost'] == $value['budgetCost']){

							 				
							 				 ?>
							<td style="background-color: green"><?php if($row['cost'] != 0){ echo $row['cost']; } ?></td>
										<?php $i++;  }
										else{ ?>
												<td ><?php if($row['cost'] != 0){ echo $row['cost']; } ?>
							 			<?php }
							 			} }?></td>
							 			<?php if(!empty($value['manpowerCost'])) { 
							 			
							 			foreach($value['manpowerCost'] as $row){ ?>
							 			<td>
							 			<?php echo $row['hour']; } } ?></td>
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
							 		<td><?php echo $j;?></td>
							 		<td><?php echo $value['gate_id'].'.'.$i2?></td>
							 		<td><?php echo $value['gate_name'];?></td>
							 		<td><?php echo $value['activity_name'];?></td>
							 		<td><?php echo $value['getUserName'];?></td>
							 		
							 		<td><?php if($value['budgetCost'] != 0){ echo $value['budgetCost']; } ?></td>
							 		<td>
							 		<?php $i=1;if(!empty($value['actualCost'])) { 
							 			foreach($value['actualCost'] as $row){  
							 				
							 				 ?>
												
												<?php 
												if($row['cost'] != 0){ echo $row['cost']; } ?>	
							 			
							 			<?php $i++;  } }?></td>
							 			<td>
							 		<?php if(!empty($value['manpowerCost'])) { 
							 			
							 			foreach($value['manpowerCost'] as $row){ ?>
							 			
							 			<?php echo $row['hour']; } } ?></td>


							 	</tr>
							 	
							 	<?php $i2++;
								$j++; }}?>

								<tr>
								<td colspan="4" ></td>
							 	<td style="background-color: darkturquoise;">Total</td>
							 	<td colspan="" style="background-color: darkturquoise;"><?php if($totbudgetCost != ""){ echo $totbudgetCost; } ?></td>
							 	<td colspan="" style="background-color: darkturquoise;"><?php if($totactualCost != ""){ echo $totactualCost;} ?></td>
							 	<td colspan="" style="background-color: darkturquoise;"><?php if($totmanpowercost != ""){ echo $totmanpowercost;} ?></td>
							 	</tr>
				    </tbody>
                </table>

            </div><!--/summary-table-->
            </div>
            </form>
            </div>
	</body>
	<?php require app_path().'/views/footer.php'; ?>
</html>