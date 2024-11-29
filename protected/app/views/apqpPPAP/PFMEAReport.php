<html>
<style type="text/css">
/*	table { border-collapse: collapse; width: 100%; }
th, td { background: #fff; padding: 8px 16px; }


.tableFixHead {
  overflow: auto;
  height: 800px;
}

.tableFixHead thead th {
  position: sticky;
  top: 0;
}*/

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
    font-family: cursive;">PFMEA Report </h1>
            </div><!--/page-heading-->

        </div>
         <div class="col-sm-4">
            <div class="page-heading pull-right">
                <a class="btn btn-animate flat blue pd-btn" href="<?php echo Request::root().'/reportPFEMA'; ?>">Back To Search</a>
            </div><!--/page-heading-->


        </div>
    </div>

    <form method="post" action="<?php echo Request::root().'/downloadPFMEAReport'; ?>">
        <div class="content-wrapper">

              <div class="row mg-btm">
                <div class="col-sm-6">

                    <div class="action-group pd-top">
                        <form method="post" action="">
                            <button class="btn btn-animate flat blue pd-btn "  value="excel" name="filetype" type="submit">Export to Excel Sheet</button>
                            <button class="btn btn-animate flat blue pd-btn "  value="pdf" name="filetype" type="submit">Export to PDF</button>
                            <input type="hidden" name="pfmea_no" value="<?php echo $pfmea_no;?>">
                        </form>
                    </div>

                </div>
            </div>
       <div class="row mg-btm">
        <div class="col-sm-6">

    <h5><span style="font-weight: bold;"> Project: </span> <?php echo $pfmea[0]->project_no;?> </h5>
                  <h5><span style="font-weight: bold;">  PFMEA No: </span>
                      <?php echo $pfmea[0]->pfmea_no;?> </h5>
                   <h5><span style="font-weight: bold;">Part Number and Name: </span><?php echo $pfmea[0]->part_no_name;?> </h5>
                     <h5><span style="font-weight: bold;">PFMEA Date: </span><?php echo date('d-m-Y',strtotime($pfmea[0]->pfmea_date));?> </h5>
                   
                   </div>
                    </div>

		 <div class="summary-table report-wrapper scrollbarX "   >


                <table class="striped" border="1" style="width:120%;table-layout: auto;">
                    <thead>
                   
                    <tr class="tr-bdr">
                    <th width="30">Sr. No.</th>
                     <th width="200">Process step/Function</th>
                     <th width="200">Requirements</th>
                     <th width="200">Potential Failure Mode</th>
                     <th width="300">Potential Effects of Failure</th>
                     <th width="20">Severity</th>
                     <th width="100">Classification</th>
                     <th width="200">Potential Causes of Failure</th>
                     <th width="200">Current Process Controls Prevention</th>
                     <th width="200">Current Process Controls Detection</th>
                     <th width="100">Occurance</th>
                     <th width="20">Detection Ranking</th>
                     <th width="20">Risk Priority Number</th>
                     <th width="200">Recommended Action</th>
                     <th width="100">Responsibility </th>
                     <th width="100">Target Completion Date </th>
                     <th width="300">Action Results </th>
                 
                   	
                    </tr>
                    
                    </thead>
                   <tbody>
                   
                   <?php

                    if(sizeof($data)>0){

                        $i=0;
                        foreach($data as $val){  
                          ?>    <tr>
                          <td><?= $i+1;?></td>
                              <td><?=$val->process_step;?></td>
                              <td><?=$val->requirements;?></td>
                               <td><?=$val->failure_mode;?></td>
                              <td><?=$val->effects_of_failure;?></td>
                              <td><?php if($val->severity == 0){ echo ''; }else{ echo $val->severity;};?></td>
                              <td><?=$val->classification;?></td>
                               <td><?=$val->potential_causes;?></td>
                              <td><?=$val->control_prevention;?></td>
                              <td><?=$val->occurance;?></td>
                              <td><?=$val->control_detection;?></td>
                              <td><?php if($val->detectionrank == 0){ echo '';}else{ echo $val->detectionrank; } ?></td>
                              <td><?php if($val->risk_pririty_no == 0){ echo ''; }else{ echo $val->risk_pririty_no;}?></td>
                              <td><?=$val->recommended_action;?></td>
                              <td><?=$val->first_name.' '.$val->last_name;?></td>
                              <td><?= date('d-m-Y',strtotime($val->target_date));?></td>
                              <td><?=$val->action_result;?></td>    
                                  
                                </tr>

                            <?php $i++;} 
                            }else{?>
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