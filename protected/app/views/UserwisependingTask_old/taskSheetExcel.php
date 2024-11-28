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
               <h3>Userwise Pending Task Report</h3>
                <table style="border-top: 1px solid #e5e5e5; border-left: 1px solid #e5e5e5;">
                    <thead style="border-bottom:1px solid #dcdcdc;">
                    <tr style="border-bottom:1px solid #dcdcdc;">

                        <td width="3%" style="border-left:1px solid #dcdcdc;padding:5px;font-size: 14px;"><span>Sr. No.<span></td>
                        <td wwidth="10%" style="border-left:1px solid #dcdcdc;padding:5px;font-size: 14px;"><span>CM No.<span></td>
                        <td width="10%" style="border-left:1px solid #dcdcdc;padding:5px;font-size: 14px;"><span>Initiation Date<span></td>
                        <td width="12%" style="border-left:1px solid #dcdcdc;padding:5px;font-size: 14px;"><span>Initiator Name<span></td>
                        <td colspan="5" width="65%">
                          <table width="100%">
                            <tr>
                              <td width="15%" style="border-left:1px solid #dcdcdc;padding:5px;font-size: 14px;"><span>Assigned To<span></td>
                              <td width="35%" style="border-left:1px solid #dcdcdc;padding:5px;font-size: 14px;"><span>Activity<span></td>
                              <td width="5%" style="border-left:1px solid #dcdcdc;padding:5px;font-size: 14px;"><span>Pending Days<span></td>
                              <td colspan="2" width="40%">
                                <table width="100%">
                                  <tr>
                                    <td width="70%" style="border-left:1px solid #dcdcdc;padding:5px;font-size: 14px;">Activity Monitoring</td>
                                    <td width="30%" style="border-left:1px solid #dcdcdc;padding:5px;font-size: 14px;">Target Date</td>
                                  </tr>
                                </table>
                              </td>
                            </tr>
                          </table>
                        </td>

                    </tr>
                    </thead>
                    <tbody>
                      <?php if(sizeof($data)>0){

                        $i=1;
                        foreach($data as $sheet){
                         // echo '<pre>';print_r($sheet);exit();
                         ?>
                         <tr style="border-bottom:1px solid #dcdcdc;">
                         <td width="3%" style="border-left:1px solid #dcdcdc;padding:5px;"><?php echo $i;?></td>
                         <td width="10%" style="border-left:1px solid #dcdcdc;padding:5px;"><?php echo $sheet['cmNoview'];?></td>
                         <td width="10%" style="border-left:1px solid #dcdcdc;padding:5px;"><?php echo $sheet['initiation_dt'];?></td>
                         <td width="12%" style="border-left:1px solid #dcdcdc;padding:5px;"><?php echo $sheet['initiator'];?></td>
                         <td colspan="5" width="65%">
                           <table width="100%">
                            <?php
                              foreach ($sheet['assigned_to'] as $value) {
                              ?>
                             <tr>
                               <td width="15%" style="border-left:1px solid #dcdcdc;padding:5px;"><span><?=$value['assignedto'];?></span></td>
                                <td width="35%" style="border-left:1px solid #dcdcdc;padding:5px;"><span><?=$value['activity'];?></span></td>
                                 <td width="5%" style="border-left:1px solid #dcdcdc;padding:5px;"><span><?=$value['pendingdays'];?></span></td>
                                 <?php if(!empty($value['actmonitoring'])){ ?>
                                <td colspan="2" width="40%">
                                  <table width="100%">
                                   <?php foreach ($value['actmonitoring'] as $key) { ?>
                                    <tr>
                                      <td width="70%" style="border-left:1px solid #dcdcdc;padding:5px;"><span><?php echo $key->assessment_point_department; ?></span></td>
                                      <td width="30%" style="border-left:1px solid #dcdcdc;padding:5px;"><span><?php if($key->target_date!='0000-00-00'){ echo $key->target_date; }?></span></td>
                                    </tr>
                                    <?php } ?> 
                                  </table>
                                </td>
                                <?php } else { ?>
                                  <td colspan="2" width="40%">
                                     <table width="100%">
                                      <tr>
                                      <td width="70%" style="border-left:1px solid #dcdcdc;padding:5px;"></td>
                                      <td width="30%" style="border-left:1px solid #dcdcdc;padding:5px;"></td>
                                     </tr>
                                  </table>
                                  </td>
                                 <?php } ?> 
                             </tr>
                              <?php } ?> 
                           </table>
                         </td>

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
