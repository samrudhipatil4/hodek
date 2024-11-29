<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,700,600italic,700italic,800">

    <link href="css/font-awesome.min.css" rel="stylesheet">
</head>

<body >






<div >

    <table >
        <thead >
        <tr >

            <th >id</th>
            <th >Plant Code</th>
            <th >Change Stage</th>
            <th >Stakeholder
           </th>
           <th >Department
           </th>
          
           
           
        
  </tr>
  <?php if(sizeof($data)>0){

                        $i=1;
                        foreach($data as $sheet){
                         
                         ?>
                          <tr>
                         <td><?php echo $sheet['id'];?></td>
                         <td><?php echo $sheet['plant_code'];?></td>
                         <td><?php echo $sheet['stage_name'];?></td>
                         <td><?php echo $sheet['stakeholder'];?></td>
                        
                        
                          <td><?php  for($i=0;$i<count($sheet['departments']);$i++){ 
                               if($i==0){
                                echo $sheet['departments'][$i][0]->d_name; }else{?>
                             <?php echo ','.$sheet['departments'][$i][0]->d_name; ?>
                             <?php } }?>
                               
                         </td>
                         
                         
                   
                    
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