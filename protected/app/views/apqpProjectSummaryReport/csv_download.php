<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

   

    <link href="css/font-awesome.min.css" rel="stylesheet">
</head>

<body style="font-family: 'Open Sans',sans-serif; font-weight: normal; margin:0 auto;font-size:10px;">






<div class="summary-table report-wrapper scrollbarX">

    <table class="striped" style="border:1px solid #000;">
        <thead style="border-bottom:1px solid #000">
        <tr class="tr-bdr">

            <th width="50">Sr. No.</th>
      <th style="border-right:1px solid #000" width="100">Project Number</th>
      <th style="border-right:1px solid #000" width="150">Project Name</th>
                        <th style="border-right:1px solid #000" width="150">Manufacturing Location</th>
                         <th style="border-right:1px solid #000"  width="150">Project Start Date</th>
     <?php foreach($activity as $row){

      ?>
                       <th style="border-right:1px solid #000"  width= "90px" > <?php echo $row->activity;?></th>
                        <?php } ?>
            
        </tr>
        </thead>
       <tbody>
  <?php      if(sizeof($data)>0){
                
            $i=0;
            foreach($data as $jobs){
                ?>
    <tr style="border-bottom:1px solid #000;">
      <td style="border-right:1px solid #000"><?=++$i?>.</td>

    <td style="border-right:1px solid #000">
        <?=$jobs['Project_no'].' Revision'.$jobs['revision'].' '.$jobs['checkHold'].' '.$jobs['checkDrop'];?>
   </td>
   <td style="border-right:1px solid #000"><?= $jobs['project_name'];?></td>
   <td style="border-right:1px solid #000"><?= $jobs['mfg_location'];?></td>
                                    <td><?= $jobs['proj_start_date'];?></td>
       <?php foreach($activity as $row){ 
          // $class = apqpProjectSummaryReportController::getActDetails($jobs['proj_id'],$row->id);

         foreach($jobs['ActivityStatus'] as $key){
         if($key['activity'] == $row->id && $jobs['proj_id'] == $key['project']){
        
        ?>
                       <td style="font-size: 12px;font-weight: bold; text-align: center; min-width: 40px;padding-left: 2px;color: white; background-color: <?php echo $key['class'];?>"> <?php echo $key['text'];?></td>
                        <?php } }  } ?>
    </tr>
  <?php } } ?>
  </tbody>

    </table>

</body>
</html>