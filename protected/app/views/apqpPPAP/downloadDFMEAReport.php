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
	
	<body>
	<div class="col-sm-12" >

    <div class="row">
        <div class="col-sm-8">
            <div class="page-heading">
                <h1 style="font-size: 24px;
    font-family: cursive;">DFMEA Report </h1>
            </div><!--/page-heading-->

        </div>
         
    </div>

    <form method="post" action="<?php echo Request::root().'/downloadDFMEAReport'; ?>">
        <div class="content-wrapper">

              
       
            <div class="row mg-btm">
        <div class="col-sm-6">

    <h5><span style="font-weight: bold;"> Project: </span> <?php echo $dfmea[0]->project_no;?> </h5>
                  <h5><span style="font-weight: bold;">  DFMEA No: </span>
                      <?php echo $dfmea[0]->dfmea_no;?> </h5>
                   <h5><span style="font-weight: bold;">Part Number and Name: </span><?php echo $dfmea[0]->part_no_name;?> </h5>
                     <h5><span style="font-weight: bold;">DFMEA Date: </span><?php echo date('d-m-Y',strtotime($dfmea[0]->dfmea_date));?> </h5>
                   
                   </div>
                    </div>

		 <div class="summary-table report-wrapper scrollbarX "   >

                <table class="striped" border="1" >
                    <thead>
                   
                    <tr class="tr-bdr">
                    <th width="60">Sr. No.</th>
                     <th width="200">Item/Function</th>
                     <th width="100">Requirements</th>
                     <th width="100">Potential Failure Mode</th>
                     <th width="100">Potential Effects of Failure</th>
                     <th width="60">Severity</th>
                     <th width="100">Classification</th>
                     <th width="100">Potential Causes of Failure</th>
                     <th width="100">Current Design Controls Prevention</th>
                     <th width="100">Current Design Controls Detection</th>
                     <th width="100">Occurance</th>
                     <th width="60">Detection Ranking</th>
                     <th width="60">Risk Priority Number</th>
                     <th width="100">Recommended Action</th>
                     <th width="100">Responsibility </th>
                     <th width="100">Target Completion Date </th>
                     <th width="100">Action Results </th>
                   <!-- 
                     <th width="150">Budget Cost</th>
                    <th width="150">Actual Cost</th> -->
                   	
                    </tr>
                    
                    </thead>
                   <tbody>
                   
                   <?php

                    if(sizeof($data)>0){

                        $i=0;
                        foreach($data as $val){  
                          ?>    <tr>
                          <td><?= $i+1;?></td>
                              <td><?=$val->item;?></td>
                              <td><?=$val->requirements;?></td>
                               <td><?=$val->failure_mode;?></td>
                              <td><?=$val->effects_of_failure;?></td>
                              <td><?php if($val->severity == 0){ echo '';}else{ echo $val->severity; }?></td>
                              <td><?=$val->classification;?></td>
                               <td><?=$val->potential_causes;?></td>
                              <td><?=$val->control_prevention;?></td>
                              <td><?=$val->occurance;?></td>
                              <td><?=$val->control_detection;?></td>
                              <td><?php if($val->detectionrank == 0){ echo '';}else{ echo $val->detectionrank; } ?></td>
                              <td><?php if($val->risk_pririty_no== 0){ echo '';}else{ echo $val->risk_pririty_no;} ?></td>
                              <td><?=$val->recommended_action;?></td>
                              <td><?=$val->first_name.' '.$val->last_name;?></td>
                              <td><?= date('d-m-Y',strtotime($val->target_date));?></td>
                              <td><?=$val->action_result;?></td>    
                                  
                                </tr>

                            <?php $i++;} 
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

</html>