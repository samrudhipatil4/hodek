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
            <h3>Details of Change Request Report</h3>
                <table style="border:1px solid #e5e5e5;">
                    <thead style="border-bottom:1px solid #e5e5e5;">
                    <tr style="border-top:1px solid #e5e5e5;">

                        <th width="40" style="border-right:1px solid #e5e5e5;"><span>Sr. No.<span></th>
                        <th width="150" style="border-right:1px solid #e5e5e5;"><span>CM No.<span></th>
                        <th width="150" style="border-right:1px solid #e5e5e5;"><span>Plant<span></th>
                        <th width="150" style="border-right:1px solid #e5e5e5;"><span>Initiator Name<span></th>
                        <th width="150" style="border-right:1px solid #e5e5e5;"><span>Initiator Department<span></th>
                        <th width="150" style="border-right:1px solid #e5e5e5;"><span>Business<span></th>
                        <th width="150" style="border-right:1px solid #e5e5e5;"><span>Stakeholder<span></th>
                        <th width="150" style="border-right:1px solid #e5e5e5;"><span>Change Stage<span></th>
                        <th width="150" style="border-right:1px solid #e5e5e5;"><span>Change Type<span></th>
                        <th width="250" style="border-right:1px solid #e5e5e5;"><span>Project Code<span></th>
                        <th width="150" style="border-right:1px solid #e5e5e5;"><span>Purpose<span></th>
                        <th width="150" style="border-right:1px solid #e5e5e5;"><span>Customer<span></th>
                        <th width="150" style="border-right:1px solid #e5e5e5;"><span>Part No<span></th>
                        <th width="150" style="border-right:1px solid #e5e5e5;"><span>Part Name<span></th>
                        <th width="200" style="border-right:1px solid #e5e5e5;"><span>Modification Details<span></th>
                        <th width="150" style="border-right:1px solid #e5e5e5;"><span>Remark<span></th>
                        <th width="150" style="border-right:1px solid #e5e5e5;"><span>Implementation Date<span></th>
                        <th width="150" style="border-right:1px solid #e5e5e5;"><span>Cut-Off Date<span></th>
                        <th width="250" style="border-right:1px solid #e5e5e5;"><span>Status<span></th>
                         </tr>
                    </thead>
                    <tbody>
                      <?php if(sizeof($data)>0){

                        $i=1;
                        foreach($data as $sheet){
                         // print_r($sheet);exit();
                         ?>
                         <tr style="border-top:1px solid #e5e5e5;">
                         <td style="border-right:1px solid #e5e5e5;"><?php echo $i;?></td>
                         <td style="border-right:1px solid #e5e5e5;"><?php echo $sheet['cmNoview'];?></td>
                         <td style="border-right:1px solid #e5e5e5;"><?php echo $sheet['plant'];?></td>
                         <td style="border-right:1px solid #e5e5e5;"><?php echo $sheet['initiator'];?></td>
                         <td style="border-right:1px solid #e5e5e5;"><?php echo $sheet['dept'];?></td>
                         <td style="border-right:1px solid #e5e5e5;"><?php echo $sheet['business'];?></td>
                         <td style="border-right:1px solid #e5e5e5;"><?php echo $sheet['stakeholder'];?></td>
                         <td style="border-right:1px solid #e5e5e5;"><?php echo $sheet['stage'];?></td>
                         <td style="border-right:1px solid #e5e5e5;"><?php echo $sheet['type'];?></td>
                         <td style="border-right:1px solid #e5e5e5;"><?php echo $sheet['projectcode'];?></td>
                         <td style="border-right:1px solid #e5e5e5;">
                         <ul>
                         <?php foreach($sheet['purpose'] as $row) {?>
                         <li>&#9830; <?php echo $row->changerequest_purpose; ?></li>
                         <?php } ?>
                         </ul>
                         </td>
                         <td style="border-right:1px solid #e5e5e5;">
                         <ul>
                         <?php foreach($sheet['cust'] as $row) { ?>
                         <li>&#9830; <?php echo $row->cust;?></li>
                         <?php } ?>
                         </ul> 
                         </td>
                         <td style="border-right:1px solid #e5e5e5;">
                         <ul>
                         <?php foreach($sheet['partno'] as $row) { ?>
                         <li>&#9830; <?php echo $row->part_number;?></li>
                         <?php } ?>
                         </ul>  
                         </td>
                         <td style="border-right:1px solid #e5e5e5;">
                         <ul>
                         <?php foreach($sheet['partno'] as $row) { ?>
                         <li>&#9830; <?php echo $row->part_name;?></li>
                         <?php } ?>
                         </ul>  
                         </td>
                         <td style="border-right:1px solid #e5e5e5;text-align: left;"><?php echo $sheet['modDtls'];?></td>
                         <td style="border-right:1px solid #e5e5e5;"><?php echo $sheet['remark'];?></td>
                         <td style="border-right:1px solid #e5e5e5;"><?php echo $sheet['impdate'];?></td>
                          <td style="border-right:1px solid #e5e5e5;"><?php echo $sheet['actualImpDate'];?></td>
                         <td style="border-right:1px solid #e5e5e5;"><?php echo $sheet['status'];?></td>                   
                        </tr>
                    <?php $i=$i+1;}}else{?>
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
