<html>
  <head>
    
  </head>
  <body>
  <div class="col-sm-12" >

    <div class="row">
        <div class="col-sm-8">
            <div class="page-heading">
                <h1>Project Documentation Report</h1>
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
                    <th width="150">Activity Start Date</th>
                    <th width="150">Activity End Date</th>
                    <th width="150">Actual Activity Start Date</th>
                    <th width="150">Actual Activity Completition Date</th>
                    <th width="150">Remark</th>
                    <th width="200">Document
                    		<table>
                    		<tr>
                   
                    	<th width="50" style="text-align: center;">SR.NO</td>
							 		<th width="225" style="text-align: center;border-left: 1px solid #dddddd;border-right: 1px solid  #dddddd;">Parameter</th>
							 		<th width="225" style="text-align: center;border-left: 1px solid #dddddd;border-right: 1px solid  #dddddd;">Action</th>
							 		<th width="225" style="text-align: center;border-left: 1px solid #dddddd;border-right: 1px solid  #dddddd;">Cost</th>
							 		<th width="225" style="text-align: center;border-left: 1px solid #dddddd;border-right: 1px solid  #dddddd;">Document</th>
							 		<th width="225" style="text-align: center;border-left: 1px solid #dddddd;border-right: 1px solid  #dddddd;">Remark</th>
							 		<th width="225" style="text-align: center;border-left: 1px solid #dddddd;border-right: 1px solid  #dddddd;">Updated date</th>
							 		<th width="225" style="text-align: center;border-left: 1px solid #dddddd;border-right: 1px solid  #dddddd;">Issue</th>
							 		<th width="225" style="text-align: center;border-left: 1px solid #dddddd;border-right: 1px solid  #dddddd;">Issue Document</th>
                    </tr>
                    		</table>
                    </th>
                   
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
							 		<td><?php echo date('d M Y',strtotime($value['activity_start_date']));?></td>
							 		<td><?php echo date('d M Y',strtotime($value['activity_end_date']));?></td>
							 		<td><?php foreach ($alldata1 as $value1) {
							 			if($value['gate_id'] == $value1['gate_id']){
							 				if($value['activity'] == $value1['activity_id']){ 
							 					echo date('d M Y',strtotime($value1['actual_start_date']));
							 			}}
							 		}?>

							 		</td>
							 		<td></td>
							 		<td><?php echo $value['remark'];?></td>
									<td><table>
							 		<?php $i=1;if(!empty($value['document'])) { 
							 			foreach($value['document'] as $row){  
							 				if($row['id'] == $value['d_id']){ ?>
												<tr><td width="50" style="border-left: 1px solid #dddddd;border-right: 1px solid  #dddddd;"><?php echo $i;?></td>
												<td width="225" style="border-left: 1px solid #dddddd;border-right: 1px solid  #dddddd;"> <?php echo $row['parameter'].' '; ?>	</td>
												<td width="225" style="border-left: 1px solid #dddddd;border-right: 1px solid  #dddddd;"> <?php echo $row['action'].' '; ?>	</td>
												<td width="225" style="border-left: 1px solid #dddddd;border-right: 1px solid  #dddddd;"> <?php echo $row['cost'].' '; ?>	</td>
												<td width="225" style="border-left: 1px solid #dddddd;border-right: 1px solid  #dddddd;">
												<?php if(!empty($row['doc'])) { 
												foreach($row['doc'] as $key){ 
														 if(!empty($key)) {
														 	$m=1;
														 	foreach ($key as $val ) {
														  ?>
												<?php echo $m.'.'.$val->upload_doc; ?>
							 		<?php if(!empty($val->upload_doc)){?><a href="<?php echo Request::root().'/download?path=apqp_activity_document&filename='.$val->upload_doc;?>" data-position="bottom" data-delay="50" data-tooltip="Download"><i class="glyphicon glyphicon-download-alt"></i><?php echo '<br>';?></a><?php } $m++;}  }} }?>
							 			 
							 			 </td>
							 			 	
							 			 	<td width="225" style="border-left: 1px solid #dddddd;border-right: 1px solid  #dddddd;">
												<?php if(!empty($row['doc'])) { 
												foreach($row['doc'] as $key){ 
														 if(!empty($key)) {
														 	$m=1;
														 	foreach ($key as $val ) {
														  ?>
												<?php if(!empty($val->updated_doc_remark)){ echo $m.'.'.$val->updated_doc_remark.'<br>';} ?>
							 		<?php  $m++;}  }} }?>
							 			 
							 			 </td>
							 			 <td width="225" style="border-left: 1px solid #dddddd;border-right: 1px solid  #dddddd;">
												<?php if(!empty($row['doc'])) { 
												foreach($row['doc'] as $key){ 
														 if(!empty($key)) {
														 	$m=1;
														 	foreach ($key as $val ) {
														  ?>
												<?php if($val->updated_date != '0000-00-00 00:00:00' && $val->updated_date != null) echo $m.'.'.date('d-m-Y',strtotime($val->updated_date)).'<br>'; ?>
							 		<?php  $m++;}  }} }?>
							 			 
							 			 </td>
							 			 <td width="225" style="border-left: 1px solid #dddddd;border-right: 1px solid  #dddddd;"> <?php echo $row['issue']; ?>	</td>
							 			 <td width="225" style="border-left: 1px solid #dddddd;border-right: 1px solid  #dddddd;">
							 			 <?php if(!empty($row['issuedoc'])) { 
												foreach($row['issuedoc'] as $key){ 
														 if(!empty($key)) {
														 	$m=1;
														 	foreach ($key as $val ) {
														  ?>
												<?php echo $m.'.'.$val->issue_document; ?>
							 		<?php if(!empty($val->issue_document)){?><a href="<?php echo Request::root().'/download?path=apqp_issue_document&filename='.$val->issue_document;?>" data-position="bottom" data-delay="50" data-tooltip="Download"><i class="glyphicon glyphicon-download-alt"></i><?php echo '<br>';?></a><?php } $m++;}  }} }?>
							 			 </td>
							 			 </tr>
							 			<?php $i++; } } }?></table></td>

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
							 		<td><?php echo date('d M Y',strtotime($value['activity_start_date']));?></td>
							 		<td><?php echo date('d M Y',strtotime($value['activity_end_date']));?></td>
							 		<td><?php foreach ($alldata1 as $value1) {
							 			if($value['gate_id'] == $value1['gate_id']){
							 				if($value['activity'] == $value1['activity_id']){ 
							 					echo date('d M Y',strtotime($value1['actual_start_date']));
							 			}}
							 		}?>

							 		</td>
							 		<td></td>
							 		<td><?php echo $value['remark'];?></td>
							 		<td><table>
							 		<?php $i=1;if(!empty($value['document'])) { 
							 			foreach($value['document'] as $row){  
							 				if($row['id'] == $value['d_id']){ ?>
												<tr><td width="50" style="border-left: 1px solid #dddddd;border-right: 1px solid  #dddddd;"><?php echo $i;?></td>
												<td width="225" style="border-left: 1px solid #dddddd;border-right: 1px solid  #dddddd;"> <?php echo $row['parameter'].' '; ?>	</td>
												<td width="225" style="border-left: 1px solid #dddddd;border-right: 1px solid  #dddddd;"> <?php echo $row['action'].' '; ?>	</td>
												<td width="225" style="border-left: 1px solid #dddddd;border-right: 1px solid  #dddddd;"> <?php echo $row['cost'].' '; ?>	</td>
												<td width="225" style="border-left: 1px solid #dddddd;border-right: 1px solid  #dddddd;">
												<?php if(!empty($row['doc'])) { 
												foreach($row['doc'] as $key){ 
														 if(!empty($key)) {
														 	$m=1;
														 	foreach ($key as $val ) {
														  ?>
												<?php echo $m.'.'.$val->upload_doc; ?>
							 		<?php if(!empty($val->upload_doc)){?><a href="<?php echo Request::root().'/download?path=apqp_activity_document&filename='.$val->upload_doc;?>" data-position="bottom" data-delay="50" data-tooltip="Download"><i class="glyphicon glyphicon-download-alt"></i><?php echo '<br>';?></a><?php } $m++;}  }} }?>
							 			 
							 			 </td>
							 			 <td width="225" style="border-left: 1px solid #dddddd;border-right: 1px solid  #dddddd;">
												<?php if(!empty($row['doc'])) { 
												foreach($row['doc'] as $key){ 
														 if(!empty($key)) {
														 	$m=1;
														 	foreach ($key as $val ) {
														  ?>
												<?php if(!empty($val->updated_doc_remark)){ echo $m.'.'.$val->updated_doc_remark.'<br>';} ?>
							 		<?php  $m++;}  }} }?>
							 			 
							 			 </td>
							 			 <td width="225" style="border-left: 1px solid #dddddd;border-right: 1px solid  #dddddd;">
												<?php if(!empty($row['doc'])) { 
												foreach($row['doc'] as $key){ 
														 if(!empty($key)) {
														 	$m=1;
														 	foreach ($key as $val ) {
														  ?>
												<?php if($val->updated_date != '0000-00-00 00:00:00' && $val->updated_date != null) echo $m.'.'.date('d-m-Y',strtotime($val->updated_date)).'<br>'; ?>
							 		<?php  $m++;}  }} }?>
							 			 
							 			 </td>
							 			 <td width="225" style="border-left: 1px solid #dddddd;border-right: 1px solid  #dddddd;"> <?php echo $row['issue']; ?>	</td>
							 			 <td width="225" style="border-left: 1px solid #dddddd;border-right: 1px solid  #dddddd;">
							 			 <?php if(!empty($row['issuedoc'])) { 
												foreach($row['issuedoc'] as $key){ 
														 if(!empty($key)) {
														 	$m=1;
														 	foreach ($key as $val ) {
														  ?>
												<?php echo $m.'.'.$val->issue_document; ?>
							 		<?php if(!empty($val->issue_document)){?><a href="<?php echo Request::root().'/download?path=apqp_issue_document&filename='.$val->issue_document;?>" data-position="bottom" data-delay="50" data-tooltip="Download"><i class="glyphicon glyphicon-download-alt"></i><?php echo '<br>';?></a><?php } $m++;}  }} }?>
							 			 </td>
							 			 </tr>
							 			<?php $i++; } } }?></table></td>
							 		


							 	</tr>
							 	<?php $i2++;
								$j++; }}?>
								
                   
                    </tbody>
                </table>

                </br>
<h4>Project Review</h4>
</br>
                 <table class="striped" border="1">
                    <?php  if(sizeof($reviewData)>0){ ?>

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

                    
                        $i=0;
                        foreach($reviewData as $val){  
                       // echo '<pre>';print_r($val);exit();
                        	?>

                                <tr>

                                    

                                    <td><?=++$i?>.</td>

                                    <td>
                                        <?=$val['project_no'];?>
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
                            }    ?>
                   
                    </tbody>
                </table>
                 </br>
<h4>Project Lesson</h4>
</br>

               <table  class="striped" border="1">
                   <?php if(sizeof($lessondata)>0){ ?>
                    <thead>
                    <tr class="tr-bdr">

                        <th width="50">Sr. No.</th>
                        <th width="100">Project Number</th>
                        <th width="150">Project Name</th>
                        <th width="150">Manufacturing Location</th>
                         <th width="150">Project Start Date</th>
                        <th width="250">Lessons</th>
                        
                    </tr>
                    </thead>
                    <tbody id="checkboxex">
                    <?php
                        $i=0;
                        foreach($lessondata as $jobs){  ?>

                                <tr>

                                    

                                    <td><?=++$i?>.</td>

                                    <td>
                                        <?=$jobs['Project_no'];?>
                                   </td>



                                    <td><?= $jobs['project_name'];?></td>
                                    <td><?= $jobs['mfg_location'];?></td>
                                    <td><?= $jobs['proj_start_date'];?></td>
                                    <td>

                                        <?php
                                        if(isset($jobs['lesson'])&& !empty($jobs['lesson']) ){?>
                                            <ul class="listing bdr-btm no-pd">

                                                <?php foreach($jobs['lesson'] as $lesson){  ?>

                                                    <li>
                                                        <span><?=$lesson->lesson;?></span>

                                                    </li>
                                                <?php } ?>
                                            </ul>

                                    </td>
                                    


                                    <?php } ?>
                                </tr>

                            <?php } } ?>
                             </tbody>
                </table>

            </div><!--/summary-table-->
            </div>
            </form>
            </div>
  </body>
</html>