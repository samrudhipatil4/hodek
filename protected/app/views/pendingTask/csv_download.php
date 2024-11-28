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

            <th width="50" style="border-right:1px solid #000">Sr. No.</th>
            <th width="50" style="border-right:1px solid #000">User Name</th>
            <th width="50" style="border-right:1px solid #000">Department Name</th>
            <th width="50" style="border-right:1px solid #000">Pending For<br>Reinitiation
           </th>
           <th width="50" style="border-right:1px solid #000">HOD Approval<br>
           </th><th width="50" style="border-right:1px solid #000">Define Cross <br>Functional Team 
           </th><th width="50" style="border-right:1px solid #000">Risk Entry
           </th><th width="50" style="border-right:1px solid #000">Risk Entry HOD <br>Approval
           </th><th width="50" style="border-right:1px solid #000">Risk Approval By<br>Superadmin/Project <br>Manager / Initiator
           </th><th width="50" style="border-right:1px solid #000">Steering Commitee <br>Approval
           </th><th width="450" style="border-right:1px solid #000">QA Head Decision
           </th><th width="50" style="border-right:1px solid #000">Customer Evidence <br>Upload
           </th><th width="50" style="border-right:1px solid #000">Customer Evidence <br> Upload Approve
           </th><th width="50" style="border-right:1px solid #000">Activity Document <br> Upload
           </th><th width="50" style="border-right:1px solid #000">Activity Document <br> Upload Approve
           </th>
           <th width="50" style="border-right:1px solid #000">PTR Document Upload
           </th><th width="50" style="border-right:1px solid #000">Horizontal <br>Deployment
           </th><th width="50" style="border-right:1px solid #000">Before After Status
           </th>
           <th width="50" style="border-right:1px solid #000">Total
           </th>
           
        
  </tr>
  <?php if(sizeof($data)>0){

                        $i=1;
                        foreach($data as $sheet){
                          
                         ?>
                         <td><?php echo $i;?></td>
                         <td><?php echo $sheet['allUser'][0]->first_name." ".$sheet['allUser'][0]->last_name;?></td>
                         <td><?php echo $sheet['allUser'][0]->d_name;?></td>
                         <td><?php echo $sheet['reintiate']['total'];?></td>
                         <td><?php echo $sheet['hod_approval']['total'];?></td>
                         <td><?php echo $sheet['ini_info_sheet']['total'];?></td>
                         <td><?php echo $sheet['riskEntry']['total'];?></td>
                         <td><?php echo $sheet['risk_entry_hod']['total'];?></td>
                         <td><?php echo $sheet['risk_admin_app']['total'];?></td>
                         <td><?php echo $sheet['steer_comm']['total'];?></td>
                         <td><?php echo $sheet['QA_head']['total'];?></td>
                         <td><?php echo $sheet['customer_evi_upload']['total'];?></td>
                         <td><?php echo $sheet['admin_cust_app']['total'];?></td>
                         <td><?php echo $sheet['docUpload']['total'];?></td>
                         <td><?php echo $sheet['app_doc_upload']['total'];?></td>
                         <td><?php echo $sheet['ptrUpload']['total'];?></td>
                          <td><?php echo $sheet['hor_dep']['total'];?></td>
                         <td><?php echo $sheet['before_after']['total'];?></td>
                         <td><?php echo $sheet['final_app']['total'];?></td>
                         <td><?php $total= $sheet['reintiate']['total']+$sheet['hod_approval']['total']+$sheet['ini_info_sheet']['total']
                                          +$sheet['riskEntry']['total']+$sheet['risk_entry_hod']['total']+$sheet['risk_admin_app']['total']
                                          +$sheet['steer_comm']['total']+$sheet['QA_head']['total']+$sheet['customer_evi_upload']['total']
                                          +$sheet['admin_cust_app']['total']+$sheet['docUpload']['total']+$sheet['app_doc_upload']['total']
                                          +$sheet['hor_dep']['total']+$sheet['before_after']['total']+$sheet['final_app']['total'];  if($total != 0){echo $total;}?></td>
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

</body>
</html>