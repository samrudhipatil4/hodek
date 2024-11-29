<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,700,600italic,700italic,800">

    <link href="css/font-awesome.min.css" rel="stylesheet">
</head>

<body style="font-family: 'Open Sans',sans-serif; font-weight: normal; margin:0 auto;font-size:10px;">


<table style="width:80%;margin-bottom:40px;border:1px solid #000;">

    
</table>



<div class="summary-table report-wrapper scrollbarX">

    <table class="striped" style="border:1px solid #000;">
        <thead style="border-bottom:1px solid #000">
        <tr class="tr-bdr">

            <th width="50" style="border-right:1px solid #000">id</th>
            <th width="50" style="border-right:1px solid #000">Change Stage</th>
            <th width="50" style="border-right:1px solid #000">Plant Code</th>
            <th width="50" style="border-right:1px solid #000">Stakeholder
           </th>
           <th width="50" style="border-right:1px solid #000">customer Communication Member
           </th>
           <th width="50" style="border-right:1px solid #000">Steering Commitee Member
           </th>
           
           
        
  </tr>
  <?php if(sizeof($data)>0){

                        $i=1;
                        foreach($data as $sheet){

                         
                         ?>
                            <tr>
                         <td><?php echo $sheet['id'];?></td>
                         <td><?php echo $sheet['stage_name'];?></td>
                          <td><?php echo $sheet['plant_code'];?></td>
                         <td><?php echo $sheet['stakeholder'];?></td>
                         <td><?php echo $sheet['cust_comm_user'][0]->first_name." ".$sheet['cust_comm_user'][0]->last_name?></td>
                        
                          <td><?php  for($i=0;$i<count($sheet['steer_member']);$i++){?><?php 
                            if($i==0){
                              echo $sheet['steer_member'][$i][0]->first_name.' '.$sheet['steer_member'][$i][0]->last_name;
                            }else{
                            echo ','.$sheet['steer_member'][$i][0]->first_name.' '.$sheet['steer_member'][$i][0]->last_name; ?> <?php }}?></td>
                         
                         
                    
                    
                    </tr>
                    <?php $i=$i+1;}} else{?>
                      <tr>
                        <td>NO Record Found
                        </td>
                      </tr>
                        <?php }?>

        </tbody>
       

    </table>

</body>
</html>