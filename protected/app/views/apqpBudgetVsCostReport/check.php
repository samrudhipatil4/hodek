<html>
  <head>
   <style type="text/css">
     table,th,td{
   
 border-collapse: collapse;
  word-wrap: break-word;
}
thead{display: table-header-group;}
tfoot {display: table-row-group;}
tr {page-break-inside: avoid;}
   </style>
  </head>
  <body>
  <div class="col-sm-12" >

    <div class="row">
        <div class="col-sm-8">
            <div class="page-heading">
                <h1>Budget Vs Actual Cost Report</h1>
            </div><!--/page-heading-->

        </div>
        
    </div>
    <div class="row mg-btm">
			  <div class="col-sm-6"><h4>
			    <?php  if(!empty($prjDetails['projectDts'])){
			    	
			    	$dtl=$prjDetails['projectDts'];
			    	
			      ?>
			      <h5><span style="font-weight: bold;">Project Number : </span><?php echo $dtl->project_no.' '.$prjDetails['checkHold'];  ?></h5>
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
    <form method="post" action="<?php echo Request::root().'/project_report/download'; ?>">
        <div class="content-wrapper">

             
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
                    </thead>                    <tbody>
                   
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
							 		
							 		<td><?php if($value['budgetCost'] != 0){ echo $value['budgetCost']; } ?></td>
							<td>
							 		<?php if(!empty($value['actualCost'])) { 
							 			foreach($value['actualCost'] as $row){  
							 				 ?>
												 <?php if($row['cost'] != 0){ echo $row['cost']; } ?>
												

							 			
							 			<?php   } }?></td>
							 			<td>
							 			<?php if(!empty($value['manpowerCost'])) { 
							 			
							 			foreach($value['manpowerCost'] as $row){ ?>
							 			
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
							 		<?php if(!empty($value['actualCost'])) { 
							 			foreach($value['actualCost'] as $row){  
							 				 ?>
												
												 <?php if($row['cost'] != 0){ echo $row['cost']; } ?>	
												

							 			
							 			<?php   } }?></td>
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
</html>