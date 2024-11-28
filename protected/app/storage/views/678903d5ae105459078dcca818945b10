
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>






</head>

<body>
<div class="container">
<div class="col-md-12">
<div class="table-container">


    <div>
 
    <h5><span style="font-weight: bold;">Project NO : </span><?php echo $project_details->project_no.' '. $project_details->checkHold; ?></h5>
    <h5><span style="font-weight: bold;">Project Name : </span><?php echo $project_details->project_name ?></h5>
    <h5><span style="font-weight: bold;">Manufacturing Location :</span> <?php echo $project_details->description ?></h5>
    <h5><span style="font-weight: bold;">Project Start Date :</span> <?php echo $project_details->date ?></h5>
    <h5><span style="font-weight: bold;">Project End Date : </span><?php echo date('d F Y',strtotime($project_details->EndDate)); ?></h5>
    
</div>

<table>
  <tr>
    <th>Sr.No</th>
    <th>Gate</th>
    <th>Activity</th>
    <th>Responsibility</th>
    <th></th>
    <th>Duration</th>
    <th>Activity Start Date</th>
    <th>Activity End Date</th>
     <?php for($i=0;$i<count($project_all_dates);$i++){ ?>
     <th style="font-size:8px" class=""><?php echo $project_all_dates[$i] ?></th>
    <?php } ?>
    
  </tr>
   
  <?php  $key = 1;
         $get_id = '';
          $pregate ='';
          $premat='';
          $pgate = '';
   foreach($mail_activity_details as $z=>$row){ 
    
             $ngate = $row['gate_id'];
                  if($ngate != $pgate){
                     ?>
                    <tr style="height: 71px" class="left-table-bdr-top"><td  colspan="6" style="font-weight:bold;"><?php echo 'Phase '.$row['gate_id'].' '.$row['Gate_Description'];?></td></tr>
                    <?php }
                    $pgate = $ngate;
                  if($z != 0)
                  {
                    if($get_id != $row['gate_id'])
                      $key = 1;
                  }
    ?>
    <?php if($row['material_id'] == 0){?>
  <tr>
    <td><?php echo $row['gate_id'].'.'. $key ?></td>
    <td ><?php echo $row['Gate_Description'] ?></td>
    <td ><?php echo $row['activityName'] ?></td>
    <td ><?php echo $row['department_name'] ?></td>
    <td ><?php echo $row['type'] == 0 ? 'Plan':'Actual'?></td>
    <td><?php echo $row['lead_time'];?></td>
    <td ><?php echo $row['plan_start_date'];?></td>
    <td ><?php echo $row['plan_end_date'];?></td>
    <?php for($i=0;$i<count($row['date_activity']);$i++){ ?>
    <td <?php echo ($row['type'] == 0 &&  $row['date_activity'][$i] == 1 ? 'style="background-color:#00bfff"': ($row['type'] == 1 &&  $row['date_activity'][$i] == 1? $z != 0 && strtotime($row['plan_end_date']) > strtotime($mail_activity_details[$z-1]['plan_end_date']) ?'style="background-color:#ff0000"':'style="background-color:#009933"':''));?> ></td>
      <?php } ?>  
  </tr>
  <?php }else{ 
    $mat = DB::table('apqp_material_master')
                          ->select('material_description')
                          ->where('id',$row['material_id'])
                          ->get();
                          $newmat = $row['material_id'];
                  if($ngate != $pregate || $newmat != $premat){ ?>
                   <tr style="height: 71px" class="left-table-bdr-top"><td  colspan="6" style="font-weight:bold;"><?php echo $mat[0]->material_description;?></td></tr>

                  <?php } $premat=$newmat;
                  $pregate=$ngate;
    ?>
      <tr>
    <td><?php echo $row['gate_id'].'.'. $key ?></td>
    <td ><?php echo $row['Gate_Description'] ?></td>
    <td ><?php echo $row['activityName'] ?></td>
    <td ><?php echo $row['department_name'] ?></td>
    <td ><?php echo $row['type'] == 0 ? 'Plan':'Actual'?></td>
    <td><?php echo $row['lead_time'];?></td>
    <td ><?php echo $row['plan_start_date'];?></td>
    <td ><?php echo $row['plan_end_date'];?></td>
    <?php for($i=0;$i<count($row['date_activity']);$i++){ ?>
     <td <?php echo ($row['type'] == 0 &&  $row['date_activity'][$i] == 1 ? 'style="background-color:#00bfff"': ($row['type'] == 1 &&  $row['date_activity'][$i] == 1?$z != 0 && strtotime($row['plan_end_date']) > strtotime($mail_activity_details[$z-1]['plan_end_date']) ?'style="background-color:#ff0000"':'style="background-color:#009933"':''));?> ></td>
      <?php } ?>  
  </tr>
   <?php }?>

  <?php 
   $key++;
            $get_id =$row['gate_id'];
  } ?>
</table>
</div>
</div>
</body>

</html>