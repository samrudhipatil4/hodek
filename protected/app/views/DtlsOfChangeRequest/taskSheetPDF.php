<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

   <!--  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,700,600italic,700italic,800"> -->
   
<style >
  table { page-break-after:auto }
    thead { display:table-header-group }
    tr    { page-break-inside:avoid }
    th    { page-break-inside:avoid }
    td    { page-break-inside:avoid }
    </style>

</head>
<body>
         <div style="width:100% height:auto;">

                <table style="font-size:10px;border-spacing:0;width:100%;max-width:100%;overflow-x:auto!important;table-layout:fixed;border-bottom:1px solid #e5e5e5;">
                    <thead>
                    <tr class="tr-bdr">

                        <th style="width:40px;color:#38393A;border:1px solid #E5E5E5;border-right:none;font-weight:600;padding:10px;text-align:left;vertical-align: bottom;display:table-cell;padding: 15px 5px;"><span>Sr. No.<span></th>
                        <th style="width:100px;color:#38393A;border:1px solid #E5E5E5;border-right:none;font-weight:600;padding:10px;text-align:left;vertical-align: bottom;display:table-cell;padding: 15px 5px;"><span>CM No.<span></th>
                        <th style="width:100px;color:#38393A;border:1px solid #E5E5E5;border-right:none;font-weight:600;padding:10px;text-align:left;vertical-align: bottom;display:table-cell;padding: 15px 5px;"><span>Plant<span></th>
                        <th style="width:150px;color:#38393A;border:1px solid #E5E5E5;border-right:none;font-weight:600;padding:10px;text-align:left;vertical-align: bottom;display:table-cell;padding: 15px 5px;"><span>Initiator Name<span></th>
                        <th style="width:150px;color:#38393A;border:1px solid #E5E5E5;border-right:none;font-weight:600;padding:10px;text-align:left;vertical-align: bottom;display:table-cell;padding: 15px 5px;"><span>Initiator Department<span></th>
                        <th style="width:120px;color:#38393A;border:1px solid #E5E5E5;border-right:none;font-weight:600;padding:10px;text-align:left;vertical-align: bottom;display:table-cell;padding: 15px 5px;"><span>Business<span></th>
                        <th style="width:120px;color:#38393A;border:1px solid #E5E5E5;border-right:none;font-weight:600;padding:10px;text-align:left;vertical-align: bottom;display:table-cell;padding: 15px 5px;"><span>Stakeholder<span></th>
                        <th style="width:100px;color:#38393A;border:1px solid #E5E5E5;border-right:none;font-weight:600;padding:10px;text-align:left;vertical-align: bottom;display:table-cell;padding: 15px 5px;"><span>Change Stage<span></th>
                        <th style="width:100px;color:#38393A;border:1px solid #E5E5E5;border-right:none;font-weight:600;padding:10px;text-align:left;vertical-align: bottom;display:table-cell;padding: 15px 5px;"><span>Change Type<span></th>
                        <th style="width:150px;color:#38393A;border:1px solid #E5E5E5;border-right:none;font-weight:600;padding:10px;text-align:left;vertical-align: bottom;display:table-cell;padding: 15px 5px;"><span>Project Code<span></th>
                        <th style="width:150px;color:#38393A;border:1px solid #E5E5E5;border-right:none;font-weight:600;padding:10px;text-align:left;vertical-align: bottom;display:table-cell;padding: 15px 5px;"><span>Purpose<span></th>
                        <th style="width:150px;color:#38393A;border:1px solid #E5E5E5;border-right:none;font-weight:600;padding:10px;text-align:left;vertical-align: bottom;display:table-cell;padding: 15px 5px;"><span>Customer<span></th>
                        <th style="width:150px;color:#38393A;border:1px solid #E5E5E5;border-right:none;font-weight:600;padding:10px;text-align:left;vertical-align: bottom;display:table-cell;padding: 15px 5px;"><span>Part No<span></th>
                        <th style="width:150px;color:#38393A;border:1px solid #E5E5E5;border-right:none;font-weight:600;padding:10px;text-align:left;vertical-align: bottom;display:table-cell;padding: 15px 5px;"><span>Part Name<span></th>
                        <th style="width:180px;color:#38393A;border:1px solid #E5E5E5;border-right:none;font-weight:600;padding:10px;text-align:left;vertical-align: bottom;display:table-cell;padding: 15px 5px;"><span>Modification Details<span></th>
                        <th style="width:150px;color:#38393A;border:1px solid #E5E5E5;border-right:none;font-weight:600;padding:10px;text-align:left;vertical-align: bottom;display:table-cell;padding: 15px 5px;"><span>Remark<span></th>
                        <th style="width:150px;color:#38393A;border:1px solid #E5E5E5;border-right:none;font-weight:600;padding:10px;text-align:left;vertical-align: bottom;display:table-cell;padding: 15px 5px;"><span>Implementation Date<span></th>
                         <th style="width:150px;color:#38393A;border:1px solid #E5E5E5;border-right:none;font-weight:600;padding:10px;text-align:left;vertical-align: bottom;display:table-cell;padding: 15px 5px;"><span>Cut-Off Date<span></th>
                        <th style="width:200px;color:#38393A;border:1px solid #E5E5E5;border-right:none;font-weight:600;padding:10px;text-align:left;vertical-align: bottom;display:table-cell;padding: 15px 5px;"><span>Status<span></th>
                         </tr>
                    </thead>
                    <tbody>
                      <?php if(sizeof($data)>0){

                        $i=1;
                        foreach($data as $sheet){
                         // print_r($sheet);exit();
                         ?>
                         <td style="padding-left:5px;border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;"><?php echo $i;?></td>
                         <td style="padding-left:5px;border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;"><?php echo $sheet['cmNoview'];?></td>
                         <td style="padding-left:5px;border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;"><?php echo $sheet['plant'];?></td>
                         <td style="padding-left:5px;border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;"><?php echo $sheet['initiator'];?></td>
                         <td style="padding-left:5px;border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;"><?php echo $sheet['dept'];?></td>
                         <td style="padding-left:5px;border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;"><?php echo $sheet['business'];?></td>
                         <td style="padding-left:5px;border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;"><?php echo $sheet['stakeholder'];?></td>
                         <td style="padding-left:5px;border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;"><?php echo $sheet['stage'];?></td>
                         <td style="padding-left:5px;border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;"><?php echo $sheet['type'];?></td>
                         <td style="padding-left:5px;border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;"><?php echo $sheet['projectcode'];?></td>
                         <td style="padding-left:5px;border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;">
                         <ul>
                         <?php foreach($sheet['purpose'] as $row) {?>
                         <li><?php echo $row->changerequest_purpose; ?></li>
                         <?php } ?>
                         </ul>
                         </td>
                         <td style="padding-left:5px;border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;">
                         <ul>
                         <?php foreach($sheet['cust'] as $row) { ?>
                         <li><?php echo $row->cust;?></li>
                         <?php } ?>
                         </ul> 
                         </td>
                         <td style="padding-left:5px;border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;">
                         <ul>
                         <?php foreach($sheet['partno'] as $row) { ?>
                         <li><?php echo $row->part_number;?></li>
                         <?php } ?>
                         </ul>  
                         </td>
                         <td style="padding-left:5px;border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;">
                         <ul>
                         <?php foreach($sheet['partno'] as $row) { ?>
                         <li><?php echo $row->part_name;?></li>
                         <?php } ?>
                         </ul>  
                         </td>
                         <td style="padding-left:5px;border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;"><?php echo $sheet['modDtls'];?></td>
                         <td style="padding-left:5px;border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;"><?php echo $sheet['remark'];?></td>
                         <td style="padding-left:5px;border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;"><?php echo $sheet['impdate'];?></td>
                         <td style="padding-left:5px;border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;"><?php echo $sheet['actualImpDate'];?></td>
                         <td style="padding-left:5px;border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;"><?php echo $sheet['status'];?></td>
                        
                    <tr>
                    
                    </tr>
                    <?php $i=$i+1;}}else{?>
                      <tr>
                        <td>NO Record Found
                        </td>
                      </tr>
                        <?php }?>
                    </tbody>
                </table>

            </div><!--/summary-table-->

</body>
</html>

<script type="text/javascript">
