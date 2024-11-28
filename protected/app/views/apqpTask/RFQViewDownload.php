
<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link href="<?php echo Request::root(); ?>/protected/public/css/custom-pdf.css" rel="stylesheet"> -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,700,600italic,700italic,800">
<style type="text/css">

   .report-wrapper table tbody > tr > td{
        padding: 5px !important;
        color: #58585 !important;
        font-size: 13px;

  }

  
</style>
</head>
  
<body><?php if(!empty($details)){
  foreach($details as $row){
   ?>
                           <table class="striped" border="1">
                              <tbody>
                                <tr>
                                  <td width="12.5%"><strong>RFQ Id</strong></td>
                                  <td width="12.5%"><?php echo $row['RFQ_Id'];?></td>
                                  <td width="12.5%"><strong>RFQ Title</strong></td>
                                  <td width="12.5%"><?php echo $row['RfqTitle'];?></td>
                                  <td width="12.5%"><strong> Customer</strong></td>
                                  <td width="12.5%"><?php echo $row['customer'];?></td>
                                 
                                </tr>
                              
                                <tr>
                                  <td width="12.5%"><strong>Summary Description</strong></td>
                                  <td width="12.5%" colspan="3"><?php echo $row['summary_desc'];?></td>
                                  <td width="12.5%"><strong>Product Goals</strong></td>
                                  <td width="12.5%" colspan="3"><?php echo $row['product_goals'];?></td>
                                </tr>
                                  <tr>
                                   <td ><strong>Customer Contact Person</strong></td>
                                  <td colspan="3"><?php echo $row['custContactPerson'];?></td>
                                   <td><strong>Phone</strong></td>
                                 <td><?php if($row['phone'] != 0){ echo $row['phone']; } ?></td>
                                  <td><strong>email</strong></td>
                                 <td><?php echo $row['email'];?></td>
                                 
                                </tr>
                                <tr>
                                

                                  <td><strong>instruction_for_respone</strong></td>
                                  <td >
                                        <?php echo $row['instruction_for_respone'];?>
                                  </td>
                                  <td><strong>RFQ Issue Date</strong></td>
                                   <td >
                                        <?php echo $row['rfq_issue_date']; ?>
                                  </td>
                                  <td><strong>Proposal Deadline</strong></td>
                                 <td><?php echo $row['proposal_deadline']; ?></td>
                                </tr>
                                <tr>
                                 
                                  <td><strong>Product Details</strong></td>
                                  <td>  <?php echo $row['prod_details']; ?>
                                   </td>
                                  <td><strong>Technical Requirements</strong></td>
                                  <td>
                                        <?php echo $row['technical_req']; ?>
                                     </td>
                                      <td colspan="2"><strong>Quantity</strong></td>
                                  <td colspan="7"><?php echo $row['quantity'] ?></td>
                                </tr>
                                <tr>
                                  <td><strong>Delivery Requirements</strong></td>
                                  <td colspan="3"><?php echo $row['delivery_req'];?></td>
                                  <td><strong>Support Requirements</strong></td>
                                  <td>     <?php echo $row['support_req'];?> 
                                        </td>
                                </tr>

                                <tr>
                                  <td colspan="2"><strong>Quality Assurance Requirements</strong></td>
                                  <td colspan="2"><?php echo $row['quality_assurance_req'];?></td>
                                  <td colspan="2"><strong>Legal Requirements</strong></td>
                                  <td colspan="2"><?php echo $row['legal_req'];?></td>
                                </tr>
                                <tr>
                                  <td colspan="1"><strong>Terms Condition</strong></td>
                                  <td colspan="2"><?php echo $row['terms_condition'];?></td>
                                   <td colspan="1"><strong>Price Per Unit</strong></td>
                                   <td colspan="5"><?php echo $row['price_per_unit'];?></td>
                                </tr>
                                <tr>
                                 <td><strong>RFQ file</strong></td>
                                  <td>
                                  <?php foreach($row['file'] as $file){
                                    
                                   ?>
                                   <ul>
                                    <?php if($file->file_name != ""){?>
                                         <li >
                                           <?php echo $file->file_name;?>  <a href="<?php echo Request::root().'/download?path=rfq_file&filename='.$file->file_name; ?>" data-position="bottom" data-delay="50" data-tooltip="Download"><i class="glyphicon glyphicon-download-alt"></i></a>
                                           <!--    <a target="_blank" href="<?php echo Request::root().'/viewFile?path=changeRequest&filename='?><%member.attachment_file%>" data-position="bottom" data-delay="50" data-tooltip="Download"><i class="fa fa-eye"></i></a> -->
                                          
                                         </li>
                                         <?php } ?> 
                                       </ul>
                                       <?php } ?>
                                       </td>
                                </tr>

                              </tbody>
                            </table>
<?php } }?>
                            </body>

</html>

                         

                      

  
