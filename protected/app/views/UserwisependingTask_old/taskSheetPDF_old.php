<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

   <!--  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,700,600italic,700italic,800"> -->
     <link rel="stylesheet" type="text/css" href="<?php echo Request::root(); ?>/protected/public/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="<?php echo Request::root(); ?>/protected/public/css/bootstrap.css">  
  <link rel="stylesheet" href="<?php echo Request::root(); ?>/protected/public/css/bootstrap-dropdown.css">
  <link href="<?php echo Request::root(); ?>/protected/public/css/font-awesome.min.css" rel="stylesheet">
  <link href="<?php echo Request::root(); ?>/protected/public/css/custom.css" rel="stylesheet">
  <link href="<?php echo Request::root(); ?>/protected/public/js/simply-toast.min.css" rel="stylesheet">
   
<style >
  /*table { page-break-after:auto }*/
    thead { display:table-header-group }
    tr    { page-break-inside:avoid }
    th    { page-break-inside:avoid }
    td    { page-break-inside:avoid }
    th>table>tr>td>table>tr>td { page-break-inside:avoid }
    </style>

</head>
<body>
<div class="col-sm-12" >

    <div class="row">
        <div class="col-sm-8">
            <div class="page-heading">
                <h1>Userwise Pending Task</h1>
            </div><!--/page-heading-->

        </div>
        
    </div>
        <div class="content-wrapper">
            <!-- summary Table start -->
         <div class="summary-table" style="font-size: 12px;">

                <table style="border-top: 1px solid #e5e5e5; border-left: 1px solid #e5e5e5;">
                    <thead style="border-bottom:1px solid #dcdcdc;">
                    <tr style="border-bottom:1px solid #dcdcdc;">

                        <th width="3%" style="border-left:1px solid #dcdcdc;padding:5px;font-size: 14px;"><strong><span>Sr. No.<span></strong></th>
                        <th width="10%" style="border-left:1px solid #dcdcdc;padding:5px;font-size: 14px;"><strong><span>CM No.<span></strong></th>
                        <th width="10%" style="border-left:1px solid #dcdcdc;padding:5px;font-size: 14px;"><strong><span>Initiation Date<span></strong></th>
                        <th width="12%" style="border-left:1px solid #dcdcdc;padding:5px;font-size: 14px;"><strong><span>Initiator Name<span></strong></th>
                        <th colspan="5" width="65%" style="border-left:1px solid #dcdcdc;">
                          <table width="100%" style="table-layout: fixed;">
                            <tr style="page-break-inside:avoid;">
                              <td width="15%" style="padding:5px;font-size: 14px;"><strong><span>Assigned To<span></strong></td>
                              <td width="35%" style="border-left:1px solid #dcdcdc;padding:5px;font-size: 14px;"><strong><span>Activity<span></strong></td>
                              <td width="5%" style="border-left:1px solid #dcdcdc;padding:5px;font-size: 14px;"><strong><span>Pending Days<span></strong></td>
                              <td colspan="2" width="40%" style="border-left:1px solid #dcdcdc;">
                                <table width="100%" style="table-layout: fixed;">
                                  <tr style="page-break-inside:avoid;">
                                    <td width="70%" style="padding:5px;font-size: 14px;"><strong><span>Activity Monitoring<span></strong></td>
                                    <td width="30%" style="border-left:1px solid #dcdcdc;padding:5px;font-size: 14px;"><strong><span>Target Date<span></strong></td>
                                  </tr>
                                </table>
                              </th>
                            </tr>
                          </table>
                        </th>

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
                         <td colspan="5" width="65%" style="border-left:1px solid #dcdcdc;">
                           <table width="100%">
                            <?php
                              foreach ($sheet['assigned_to'] as $value) {
                              ?>
                             <tr>
                               <td width="15%" style="padding:5px;"><span><?=$value['assignedto'];?></span></td>
                                <td width="35%" style="border-left:1px solid #dcdcdc;padding:5px;"><span><?=$value['activity'];?></span></td>
                                 <td width="5%" style="border-left:1px solid #dcdcdc;padding:5px;"><span><?=$value['pendingdays'];?></span></td>
                                 <?php if(!empty($value['actmonitoring'])){ ?>
                                <td colspan="2" width="40%" style="border-left:1px solid #dcdcdc;">
                                  <table width="100%">
                                   <?php foreach ($value['actmonitoring'] as $key) { ?>
                                    <tr>
                                      <td width="70%" style="padding:5px;"><span><?php echo $key->assessment_point_department; ?></span></td>
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

            </div><!--/summary-table-->

            <!-- summary Table end -->

        </div><!--/content-wrapper-->
</div><!--/s10-->
</body>
</html>

<script type="text/javascript">
