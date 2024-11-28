<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,700,600italic,700italic,800">

    <style type="text/css">
        .green{
            border-style:solid;
            border-width:0px 0px 0px 1px;
            border-color:#E5E5E5;
            background-color:#78943C;
        //padding:3px;
            text-align:center;
            color:#ffffff;
        }

        .red{
            border-style:solid;
            border-width:0px 0px 0px 1px;
            border-color:#E5E5E5;
            background-color:#B9150C;
        //padding:3px;
            text-align:center;
            color:#ffffff;
        }

        .yellow{
            border-style:solid;
            border-width:0px 0px 0px 1px;
            border-color:#E5E5E5;
            text-align:center;
            background-color:#F9CC29;
            color:#ffffff;
        }

thead{display: table-header-group;}
tfoot {display: table-row-group;}
tr {page-break-inside: avoid;}

    </style>
</head>

<body style="font-family: 'Open Sans',sans-serif; font-weight: normal; margin:0 auto;font-size:10px;">




<div style="width:100% height:auto;overflow-x:scroll;">
  <table class="striped" style="border:1px solid #000;">
        <thead style="border-bottom:1px solid #000">
        <tr class="tr-bdr">

            <th width="50">Sr. No.</th>
      <th width="100">Project Number</th>
      <th width="150">Project Name</th>
                        <th width="150">Manufacturing Location</th>
                         <th width="150">Project Start Date</th>
     <?php foreach($activity as $row){

      ?>
                       <th  width= "90px" > <?php echo $row->activity;?></th>
                        <?php } ?>
            
        </tr>
        </thead>
       <tbody>
  <?php      if(sizeof($data)>0){
                
            $i=0;
            foreach($data as $jobs){
                ?>
    <tr>
      <td><?=++$i?>.</td>

    <td>
        <?=$jobs['Project_no'].' Revision'.$jobs['revision'].' '.$jobs['checkHold'].' '.$jobs['checkDrop'];?>
   </td>
   <td><?= $jobs['project_name'];?></td>
   <td><?= $jobs['mfg_location'];?></td>
                                    <td><?= $jobs['proj_start_date'];?></td>
       <?php foreach($activity as $row){ 
          //$class = apqpProjectSummaryReportController::getActDetails($jobs['proj_id'],$row->id);

       foreach($jobs['ActivityStatus'] as $key){
         if($key['activity'] == $row->id && $jobs['proj_id'] == $key['project']){
        
        ?>
                       <td style="font-size: 12px;font-weight: bold; text-align: center; min-width: 40px;padding-left: 2px;color: white; background-color: <?php echo $key['class'];?>"> <?php echo $key['text'];?></td>
                        <?php } }  } ?>
    </tr>
  <?php } } ?>
  </tbody>

    </table>
</div>

</body>
</html>