<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

   <!--  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,700,600italic,700italic,800"> -->
     
   
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

    <!-- <div class="row">
        <div class="col-sm-8">
            <div class="page-heading">
                <h1>Userwise Pending Task</h1>
            </div>

        </div> -->
            <!-- summary Table start -->
         <div style="width:100% height:auto;">

                <table style="font-size:10px;border-spacing:0;width:100%;max-width:100%;overflow-x:auto!important;table-layout:fixed;border-bottom:1px solid #e5e5e5;">
                    <thead>
                    <tr>
                        <th width="3%" style="color:#38393A;border:1px solid #E5E5E5;border-right:none;font-weight:600;padding:10px;text-align:left;vertical-align: bottom;display:table-cell;padding: 15px 5px;"><strong><span>Sr. No.<span></strong></th>
                        <th width="10%" style="color:#38393A;border:1px solid #E5E5E5;border-right:none;font-weight:600;padding:10px;text-align:left;vertical-align: bottom;display:table-cell;padding: 15px 5px;"><strong><span>CM No.<span></strong></th>
                        <th width="10%" style="color:#38393A;border:1px solid #E5E5E5;border-right:none;font-weight:600;padding:10px;text-align:left;vertical-align: bottom;display:table-cell;padding: 15px 5px;"><strong><span>Initiation Date<span></strong></th>
                        <th width="12%" style="color:#38393A;border:1px solid #E5E5E5;border-right:none;font-weight:600;padding:10px;text-align:left;vertical-align: bottom;display:table-cell;padding: 15px 5px;"><strong><span>Initiator Name<span></strong></th>
                        <th colspan="5" width="65%" style="border:1px solid #E5E5E5;text-align:center;padding:5px;color:#77788D;">
                          <table width="100%">
                            <tr>
                              <td width="15%" style="color:#38393A;border:1px solid #E5E5E5;border-right:none;font-weight:600;padding:10px;text-align:left;vertical-align: bottom;display:table-cell;padding: 15px 5px;"><strong><span>Assigned To<span></strong></td>
                              <td width="35%" style="color:#38393A;border:1px solid #E5E5E5;border-right:none;font-weight:600;padding:10px;text-align:left;vertical-align: bottom;display:table-cell;padding: 15px 5px;"><strong><span>Activity<span></strong></td>
                              <td width="5%" style="color:#38393A;border:1px solid #E5E5E5;border-right:none;font-weight:600;padding:10px;text-align:left;vertical-align: bottom;display:table-cell;padding: 15px 5px;"><strong><span>Pending Days<span></strong></td>
                              <td colspan="2" width="40%" style="padding: 0 !important;">
                                <table style="table-layout: fixed; width: 100%;">
                                  <tr style="page-break-inside:avoid;">
                                    <td width="70%" style="color:#38393A;border:1px solid #E5E5E5;font-weight: 600;padding:5px;text-align: left;vertical-align: bottom;display: table-cell;padding:15px 5px;border-right:none;word-wrap: break-word;"><strong><span>Activity Monitoring<span></strong></td>
                                    <td width="30%" style="color:#38393A;border:1px solid #E5E5E5;font-weight: 600;padding:5px;text-align: left;vertical-align: bottom;display: table-cell;padding:15px 5px;border-right:none;word-wrap: break-word;"><strong><span>Target Date<span></strong></td>
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
                         <tr>
                         <td width="3%" style="padding-left:5px;border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;"><?php echo $i;?></td>
                         <td width="10%" style="padding-left:5px;border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;"><?php echo $sheet['cmNoview'];?></td>
                         <td width="10%" style="padding-left:5px;border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;"><?php echo $sheet['initiation_dt'];?></td>
                         <td width="12%" style="padding-left:5px;border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;"><?php echo $sheet['initiator'];?></td>
                         <td colspan="5" width="65%">
                           <table width="100%">
                            <?php
                              foreach ($sheet['assigned_to'] as $value) {
                              ?>
                             <tr>
                               <td width="15%" style="padding-left:5px;border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;"><span><?=$value['assignedto'];?></span></td>
                                <td width="35%" style="padding-left:5px;border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;"><span><?=$value['activity'];?></span></td>
                                 <td width="5%" style="padding-left:5px;border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;"><span><?=$value['pendingdays'];?></span></td>
                                 <?php if(!empty($value['actmonitoring'])){ ?>
                                <td colspan="2" width="40%">
                                  <table width="100%">
                                   <?php foreach ($value['actmonitoring'] as $key) { ?>
                                    <tr>
                                      <td width="70%" style="padding-left:5px;border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;"><span><?php echo $key->assessment_point_department; ?></span></td>
                                      <td width="30%" style="padding-left:5px;border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;"><span><?php if($key->target_date!='0000-00-00'){ echo $key->target_date; }?></span></td>
                                    </tr>
                                    <?php } ?> 
                                  </table>
                                </td>
                                <?php } else { ?>
                                  <td colspan="2" width="40%">
                                     <table width="100%">
                                      <tr>
                                      <td width="70%" style="padding-left:5px;border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;"></td>
                                      <td width="30%" style="padding-left:5px;border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;"></td>
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

</body>
</html>

<script type="text/javascript">
