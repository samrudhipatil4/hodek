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
           <h3><?php echo 'No of change requests pending from >'.$formInput['pending'].' with department after target date' ?></h3>
                <table style="border:1px solid #e5e5e5;">
                    <thead style="border-bottom:1px solid #e5e5e5;">
                    <tr style="border-top:1px solid #e5e5e5;">

                        <th width="300" style="border-right:1px solid #e5e5e5;"><span>Department Name<span></th>
                        <th width="200" style="border-right:1px solid #e5e5e5;"><span><?php echo'Change requests Pending >'.$formInput['pending'];?><span></th>
                       
                         </tr>
                    </thead>
                    <tbody>
                      <?php if(sizeof($data)>0){ 
                        foreach($data as $row){
                        ?>
                        <tr>
                         <td style="border-right:1px solid #e5e5e5;"><?php echo $row->d_name;?></td>
                         <td style="border-right:1px solid #e5e5e5;"><?php echo $row->cnt;?></td>
                         </tr>
                         
                      <?php }}else{?>
                      <tr>
                        <td>NO Record Found
                        </td>
                      </tr>
                        <?php }?>
                    </tbody>
                    
                </table>
</body>
</html>

<script type="text/javascript">
