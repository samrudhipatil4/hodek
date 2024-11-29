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
            <th>Project Code</th>
            <th >Stage Name</th>
            <th >Project Manager</th>
            <th >Customer Communication Representative</th>
            <th >Document Verifier
           </th><th >Final Verifier</th>
           <th >Department</th>
            <th >User</th>
           
           
        
  </tr>
  <?php if(sizeof($data)>0){

                        $i=1;
                        foreach($data as $sheet){
                       
                         ?>
                          <tr>
                         <td><?php echo $sheet['id'];?></td>
                          <td><?php echo $sheet['Prj_code'];?></td>
                         <td><?php echo $sheet['stage_name'];?></td>
                         <td><?php if(!empty($sheet['proj_manager'])){ echo $sheet['proj_manager'][0]->first_name." ".$sheet['proj_manager'][0]->last_name; }?></td>
                          <td><?php if(!empty($sheet['cust_comm_repres'])){ echo $sheet['cust_comm_repres'][0]->first_name." ".$sheet['cust_comm_repres'][0]->last_name; }?></td>

                          <td><?php  if(!empty($sheet['docVerifier'])){ echo $sheet['docVerifier'][0]->first_name." ".$sheet['docVerifier'][0]->last_name; }?></td>

                          <td><?php if(!empty($sheet['finalApproval'])){ echo $sheet['finalApproval'][0]->first_name." ".$sheet['finalApproval'][0]->last_name; }?></td>
                         
                        
                        
                          <td><?php  for($i=0;$i<count($sheet['prjDept']);$i++){ 
                               if($i==0){
                                echo $sheet['prjDept'][$i]->d_name; }else{?>
                             <?php echo ','.$sheet['prjDept'][$i]->d_name; ?>
                             <?php } }?>
                               
                         </td>
                          <td><?php  for($i=0;$i<count($sheet['prjDept']);$i++){ 
                               if($i==0){
                                echo $sheet['prjDept'][$i]->first_name.' '.$sheet['prjDept'][$i]->last_name; }else{?>
                             <?php echo ','.$sheet['prjDept'][$i]->first_name.' '.$sheet['prjDept'][$i]->last_name; ?>
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