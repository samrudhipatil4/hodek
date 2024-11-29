<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link href="<?php echo Request::root(); ?>/protected/public/css/custom-pdf.css" rel="stylesheet"> -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,700,600italic,700italic,800">
<style>

  /*table { page-break-after:auto }*/
    thead { display:table-header-group }
  tfoot { display:table-row-group }
  tr    { page-break-inside:avoid }
  td    { page-break-inside:avoid }
  th    { page-break-inside:avoid }
  th>table>tr>td>table>tr>td>span { page-break-inside:avoid }
 
.green{
            border-style:solid;
            border-width:0px 0px 0px 1px;
            border-color:#E5E5E5;
            background-color:#78943C;
        /*padding:3px;*/
            text-align:center;
            color:#ffffff;
        }

        .red{
            border-style:solid;
            border-width:0px 0px 0px 1px;
            border-color:#E5E5E5;
            background-color:#B9150C;
        /*padding:3px;*/
            text-align:center;
            color:#ffffff;
        }

        .yellow{
            border-style:solid;
            border-width:0px 0px 0px 1px;
            border-color:#E5E5E5;
            text-align:center;
            background-color:#F9CC29;
            color:#ffffff;
        }

</style>
    
</head>
<body style="font-family: 'Open Sans',sans-serif; font-weight: normal; margin:0 auto;font-size:10px;">
<table style="width:80%;margin-bottom:20px;">
    <tbody>
    <tr>
        <td><span style="display: inline-block;height:22px;line-height:18px;text-align:center; width:25px;background-color:#78943C;color:#ffffff;margin-bottom:5px;margin-right:5px;">G</span>Activity Completed with required Approval & Verification </td>
    </tr>

    <tr>
        <td><span style="display: inline-block;height:22px;line-height:18px;text-align: center; width: 25px;background-color:#F9CC29;color:#ffffff;margin-bottom:5px;margin-right:5px;">Y</span>Within defined target date ( Work in Process ) </td>
    </tr>

    <tr>
        <td><span style=" display: inline-block;height: 22px;line-height:18px;text-align: center; width: 25px;background-color:#B9150C;color:#ffffff;margin-bottom:5px;margin-right:5px;">R</span>Activity Over due</td>
    </tr>
    </tbody>
</table>

<?php


function getlatestStatus($user_dep,$hod_approved){
$class='';
  //  $text = '';

    if($user_dep>0 && $hod_approved>0){

        $class='green';


    }else if($user_dep>0){

        $class='yellow';

    }
echo $class;


}

function getlatestText($user_dep,$hod_approved){

    $text = '';

    if($user_dep>0 && $hod_approved>0){//case = green


        $text = 'G';

    }else if($user_dep>0){//case = yellow

        $text='Y';

    }
    echo $text;


}
//+++++++++++++++++++++ For Activity Status +++++++++++++++++++++++++++


function getlatestStatus_2($user_department,$task_status,$date1,$date2,$admin_status){
    $class='yellow';
    //  $text = '';

    if($user_department>0 && $task_status>1){

      //  echo "in green";exit;

        //case = green

        $class='green';
        //  $text = 'G';

    }else if($date1>$date2 && $task_status<=1 && $admin_status!=2){ //echo "in red";exit;

        $class='red';


    }else if($task_status==1 && $admin_status==2){ //echo "in yellow";exit;
        //case = yellow

        $class='yellow';

    }else if($task_status==1){

        $class='yellow';

    }
    echo $class;


}

function getlatestText_2($user_department,$task_status,$date1,$date2,$admin_status){

    $text = 'Y';

    if($user_department>0 && $task_status>1){//case = green


          $text = 'G';

    }else if($date1>$date2 && $task_status<=1 && $admin_status!=2){

           $text='R';


    }else if($task_status==1 && $admin_status==2){//case = yellow

           $text='Y';

    }else if($task_status==1){

        $text='Y';

    }
      echo $text;


}
//+++++++++++++++++++++ For Activity Status +++++++++++++++++++++++++++




function getStatus($iDptId,$aDone){
    $sClass="--";
    if(in_array($iDptId,$aDone)){
        $sClass="yellow";
    }
    echo $sClass;
}
function getStatusText($iDptId,$aDone){
    $sClass="--";
    if(in_array($iDptId,$aDone)){
        $sClass="Y";
    }
    echo $sClass;
}
?>



<?php
function getStatus1($iDptId,$aDone){
    $sClass="green";
    if(in_array($iDptId,$aDone)){
        $sClass="red";
    }
    echo $sClass;
}
function getStatusText1($iDptId,$aDone){
    $sClass="G";
    if(in_array($iDptId,$aDone)){
        $sClass="R";
    }
    echo $sClass;
}
?>


            <!-- summary Table start -->
            <div style="width:100% height:auto;">

                <table style="font-size:10px;border-spacing:0;width:100%;max-width:100%;overflow-x:auto!important;table-layout:fixed;border-bottom:1px solid #e5e5e5;">
                    <thead>
                    <tr>

                          <?php $cnt=0;
                                foreach ($allDepartment as $row) {
                                        $cnt++;
                                 } 
                                $width=$cnt*40;?>


                        <th style="width:100px;color:#38393A;border:1px solid #E5E5E5;border-right:none;font-weight:600;padding:10px;text-align:left;vertical-align: bottom;display:table-cell;padding: 15px 5px;">CM No.</th>
                        <th style="width:150px;color:#38393A;border:1px solid #E5E5E5;font-weight: 600;padding:15px 3px;  text-align: left;vertical-align: bottom;display:table-cell;border-right:none;">Change req. date</th>
                        <th style="width:350px;color:#38393A;border:1px solid #E5E5E5;font-weight: 600;border-right:none;overflow-x:auto;vertical-align: bottom;padding:15px 3px;">Description of Change</th>
                        <th style="width:200px;color:#38393A;border:1px solid #E5E5E5;font-weight: 600;padding:5px;
               text-align: left;vertical-align: bottom;display: table-cell;padding: 15px 5px;border-right:none;">Customers</th>

                    <th style="width:200px;color:#38393A;border:1px solid #E5E5E5;font-weight: 600;padding:5px;
               text-align: left;vertical-align: bottom;display: table-cell;padding: 15px 5px;border-right:none;">Proposed Implementation Date</th>
                <th style="width:200px;color:#38393A;border:1px solid #E5E5E5;font-weight: 600;padding:5px;
               text-align: left;vertical-align: bottom;display: table-cell;padding: 15px 5px;border-right:none;">Cut-Off Date</th>

                        <th style="width:200px;color:#38393A;border:1px solid #E5E5E5;font-weight: 600;padding:5px;
               text-align: left;vertical-align: bottom;display: table-cell;padding:15px 5px;border-right:none;">Initiator Name</th>
               <th style="width:40px;color:#38393A;border:1px solid #E5E5E5;font-weight: 600;padding:5px;
               text-align: left;vertical-align: bottom;display: table-cell;padding:15px 5px;border-right:none;word-wrap: break-word;">HOD Approval</th>
               <th style="width:40px;color:#38393A;border:1px solid #E5E5E5;font-weight: 600;padding:5px;
               text-align: left;vertical-align: bottom;display: table-cell;padding:15px 5px;border-right:none;word-wrap: break-word;">Define CFT</th>
                        <th width="<?php echo $width; ?>" style="border:1px solid #E5E5E5;border-bottom:none;text-align:center;padding:5px;color:#77788D;">
                        <table>
                                <tr style="border-bottom:1px solid #e5e5e5 !important;">
                                    <td style="text-align: center !important;">Risk Analysis</td>        
                                </tr>
                                <tr>
                                    <td style="padding: 0 !important;">
                                        <table style="table-layout: fixed; width: 100%;">
                                            <tr style="page-break-inside:avoid;">
                                         <?php $cnt=0;
                                                foreach ($allDepartment as $row) { $cnt++;?>
                                             <td style="height:170px;width:43px;color:#38393A;border:1px solid #E5E5E5;font-weight: 600;padding:5px;text-align: left;vertical-align: bottom;display: table-cell;padding:15px 5px;border-right:none;word-wrap: break-word;"><?php echo $row->d_name; ?></td>
                                           <?php } ?> 
                                                             
                                         
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </th>
                       <!--  <th style="width:40px;color:#38393A;border:1px solid #E5E5E5;font-weight: 600;padding:5px;
               text-align: left;vertical-align: bottom;display: table-cell;padding:15px 5px;border-right:none;">Steering Committee<br>Approval</th> -->

                    <th style="width:40px;color:#38393A;border:1px solid #E5E5E5;font-weight: 600;padding:5px;
               text-align: left;vertical-align: bottom;display: table-cell;padding:15px 5px;border-right:none;word-wrap: break-word;">COO Approval</th>
                        <th style="width:40px;color:#38393A;border:1px solid #E5E5E5;font-weight: 600;padding:5px;
               text-align: left;vertical-align: bottom;display: table-cell;padding:15px 5px;border-right:none;word-wrap: break-word;">Steering Committee<br>Approval</th>
                        <th style="width:40px;color:#38393A;border:1px solid #E5E5E5;font-weight: 600;padding:5px;
               text-align: left;vertical-align: bottom;display: table-cell;padding:15px 5px;border-right:none;word-wrap: break-word;">Customer Approval<br>Status</th>
                        
                        <th width="<?php echo $width;?>" style="border:1px solid #E5E5E5;border-bottom:none;text-align:center;padding:5px;color:#77788D;">
                            <table>
                                <tr style="border-bottom:1px solid #e5e5e5 !important;">
                                    <td style="text-align: center !important;">Activity Status</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0 !important;">
                                        <table style="table-layout: fixed; width: 100%;">
                                            <tr style="page-break-inside:avoid;">
                                              
                                            <?php foreach ($allDepartment as $row) {?>
                                             <td style="height:170px;width:43px;color:#38393A;border:1px solid #E5E5E5;font-weight: 600;padding:5px;text-align: left;vertical-align: bottom;display: table-cell;padding:15px 5px;border-right:none;word-wrap: break-word;"><?php echo $row->d_name; ?></td>
                                           <?php } ?>
                                                     
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </th>
                        <th style="width:40px;color:#38393A;border:1px solid #E5E5E5;font-weight: 600;padding:5px;
               text-align: left;vertical-align: bottom;display: table-cell;padding:15px 5px;border-right:none;word-wrap: break-word;">Document Verification Status</th>
                        <th style="width:40px;color:#38393A;border:1px solid #E5E5E5;font-weight: 600;padding:5px;
               text-align: left;vertical-align: bottom;display: table-cell;padding:15px 5px;border-right:none;word-wrap: break-word;">Change Cut-Off<br>date</th>
                        <th style="width:40px;color:#38393A;border:1px solid #E5E5E5;font-weight: 600;padding:5px;
               text-align: left;vertical-align: bottom;display: table-cell;padding:15px 5px;border-right:none;word-wrap: break-word;">Before / After<br>Comprision</th>
                <th style="width:40px;color:#38393A;border:1px solid #E5E5E5;font-weight: 600;padding:5px;
               text-align: left;vertical-align: bottom;display: table-cell;padding:15px 5px;border-right:none;word-wrap: break-word;">Final Approval Status</th>
                    </tr>
                    </thead>
                    <tbody id="checkboxex">
                    <?php

                    if(sizeof($data)>0){

                        $i=0;
                        foreach($data as $jobs){  ?>

                            <?php if(isset($jobs['customers'])&& !empty($jobs['customers'])){?>



                                <tr style="color:hsl(228, 2%, 48%)">

                                    <!------------New code below------------>



                                    <!------------New code above------------>

                                   <!--  <td><?=++$i?>.</td> -->

                                    <td>
                                        <!-- <span ><?=$jobs['cmNo'];?></span>
                                    <span style="color:dodgerblue"><h5><?=$jobs['count_request_is_rejected'];?></span></h5> -->

                                        <span style="border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;padding-left:5px;"><?=$jobs['cmNo'];?><h5><?=$jobs['count_request_is_rejected'];?></span></h5></span>
                                    </td>
                                    
                                    <td style="padding-left:5px;border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;"><?= $jobs['created_date'];?></td>
                                    <td style="border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;padding-left:5px;"><?= $jobs['Purpose_Modification_Details'];?></td>
                                    <td style="border-style:solid;border-width:1px 1px 1px 1px;border-color:#E5E5E5;padding-left:5px;">

                                        <?php
                                        if(isset($jobs['customers'])&& !empty($jobs['customers']) && (count($jobs['customers']))>1){?>
                                            <ul class="listing" style="list-style-type:none;padding:0px!important;">

                                                <?php foreach($jobs['customers'] as $customer){  ?>

                                                    <li>
                                                        <span><?=$customer['customer_name'];?></span>

                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        <?php } else if(isset($jobs['customers'])&& !empty($jobs['customers'])){

                                            foreach($jobs['customers'] as $customer){  ?>


                                                <?=$customer['customer_name'];?>
                                            <?php   } }?>

                                    </td>

                                    <td>

                                        <?php
                                        if(isset($jobs['customers'])&& !empty($jobs['customers']) && (count($jobs['customers']))>1){?>
                                            <ul class="listing" style="list-style-type:none;padding:0px!important;">

                                                <?php foreach($jobs['customers'] as $customer){  ?>

                                                    <li>
                                                        <span><?=$customer['Proposed_date'];?></span>

                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        <?php } else if(isset($jobs['customers'])&& !empty($jobs['customers'])){

                                            foreach($jobs['customers'] as $customer){ ?>


                                                <?= $customer['Proposed_date'];?>
                                            <?php   } }?>

                                    </td>
                                    <td>

                                        <?php
                                        if(isset($jobs['customers'])&& !empty($jobs['customers']) && (count($jobs['customers']))>1){?>
                                            <ul class="listing" style="list-style-type:none;padding:0px!important;">

                                                <?php foreach($jobs['customers'] as $customer){  ?>

                                                    <li>
                                                        <span><?=$customer['actual_date'];?></span>

                                                    </li>
                                                <?php } ?>
                                            </ul>

                                        <?php } else if(isset($jobs['customers'])&& !empty($jobs['customers'])){

                                            foreach($jobs['customers'] as $customer){  ?>


                                                <?= $customer['actual_date'];?>
                                            <?php   } }?>

                                    </td>

                                    <td>

                                        <?php
                                        if(isset($jobs['customers'])&& !empty($jobs['customers']) && (count($jobs['customers']))>1){?>
                                            <ul class="listing" style="list-style-type:none;padding:0px!important;">

                                                <?php foreach($jobs['customers'] as $customer){  ?>

                                                    <li>
                                                        <span><?=$jobs['initiator_name'];?></span>

                                                    </li>
                                                <?php } ?>
                                            </ul>



                                        <?php } else if(isset($jobs['customers'])&& !empty($jobs['customers'])){

                                            foreach($jobs['customers'] as $customer){  ?>


                                                <?= $jobs['initiator_name'];?>
                                            <?php   } }?>


                                    </td>
                                   <?php if(!empty($jobs['HODapproval'])){ ?>
                                    <td style="padding:5px 7px;border:none;height:60px;margin:0px;" class="status <?=$jobs['HODapproval']['status']?>"><?php echo $jobs['HODapproval']['text']?></td>
                        <?php }?>
                        <?php if(!empty($jobs['DefineCFT'])){ ?>
                                    <td style="padding:5px 7px;border:none;height:60px;margin:0px;" class="status <?=$jobs['DefineCFT']['status']?>"><?php echo $jobs['DefineCFT']['text']?></td>
                                   <?php }?>
                                    <td style="padding:0px!important;border:none;margin:0px;">

                                        <?php
                                        $k='';
                                        if(isset($jobs['customers'])&& !empty($jobs['customers'])){


                                            foreach($jobs['customers'] as $customer){
                                                 $aCustomerStatus=$customer['status'];
                                                  
                                                ?>

                                                <table style="padding:0px!important;border:none;margin:0px;" >
                                                        <tr style="padding:0px!important; border:none;margin:0px;"> 
                                                        <?php 
                                                        //-------------dep0-------------- 


                                                       foreach($allDepartment as $dept){

                                                       if(!empty( $aCustomerStatus)){ 
                                                        $x=0;

                                                            foreach($aCustomerStatus as $status){
                                                      
                                                                if($dept->d_id === $status['all_reqDept']){
                                                                    
                                                                    break;
                                                                }else{
                                                                    $x++;
                                                                }
                                                            }
                                                        //} 

                                                  
                                                         if(isset($aCustomerStatus[$x]['user_dep'])){ 
                                                            ?> 
                                                            <?php if(isset($aCustomerStatus[$x]['dep_1'])){ 
                                                                ?> 
                                                                <td  style="width:40px;text-align: center !important;vertical-align: bottom;border:none;table-cell;padding: 5px 7px;margin:0px;" class="status <?php getlatestStatus($aCustomerStatus[$x]['user_dep'],$aCustomerStatus[$x]['hod_approved'])?>" >

                                                                <?php getlatestText($aCustomerStatus[$x]['user_dep'],$aCustomerStatus[$x]['hod_approved'])?> 
                                                                </td> 
                                                            <?php } else {?> 
                                                                <td style="width:40px;text-align: center !important;vertical-align: bottom;white-space:nowrap;padding:5px 7px;border:none!important;margin:0px;"></td> 
                                                            <?php }?> 
                                                        <?php }else{ ?>
                                                                    <td style="width:40px;text-align: center !important;vertical-align: bottom;white-space:nowrap;padding:5px 7px;border:none!important;margin:0px;">N</td> 
                                                               <?php  } } }?>   
                                                    </tr>
                                                 
                                                </table>


                                            <?php } }?>


                                    </td>
                                    <?php if(!empty($jobs['cooappstatus'])){ ?>
                                    <td style="padding:5px 7px;border:none;height:60px;margin:0px;" class="status <?=$jobs['cooappstatus']['status']?>"><?php echo $jobs['cooappstatus']['text']?></td>
                                   <?php }?>
                                    <?php
                                    if(isset($jobs['customers'])&& !empty($jobs['customers'])){


                                        if(isset($customer['status_steering']['dep_'])){?>
                                           <td class="status <?=$customer['status_steering']['class_']?>" style="padding:5px 7px;border:none;height:60px;margin:0px;"><?php echo $customer['status_steering']['text_']?>
                                        </td>

                                        <?php } else {?>
                                            <td style="text-align: center !important;white-space:nowrap;padding:5px 5px;border:none;height:60px;margin:0px;"></td>
                                        <?php }?>


                                    <?php } ?>

                                    <?php
                                    if(isset($jobs['customers'])&& !empty($jobs['customers'])){


                                        if(isset($customer['customer_approval']['dep_'])){?>


                                            <td style="text-align: center !important;white-space:nowrap;padding:5px 7px;border:none;height:60px;margin:0px;" class="status <?=$customer['customer_approval']['class_']?>"><?php echo $customer['customer_approval']['text_']?></td>
                                        <?php } else {?>
                                            <td style="text-align: center !important;white-space:nowrap;padding:5px 5px;border:none;height:60px;margin:0px;"></td>
                                        <?php }?>


                                    <?php } ?>

                                   
                                    <td class="pd-none">

                                        <?php
                                        $k='';
                                        if(isset($jobs['customers'])&& !empty($jobs['customers'])){


                                            foreach($jobs['customers'] as $customer){
                                                $aCustomerStatus_2=$customer['status2'];
                                             
                                                ?>

                                                <table class="bordered-cell" style="padding:0px!important;border:none;margin:0px;">
                                                    <tr style="padding:0px!important;border:none;margin:0px;">
                                                        <?php
                                                        //-------------dep0--------------
                                                         foreach($allDepartment as $dept){ 
                                                        $x=0;
                                                        if(!empty( $aCustomerStatus_2)){ 
                                                            foreach($aCustomerStatus as $status){
                                                                if($dept->d_id === $status['all_reqDept']){
                                                                    break;
                                                                }else{
                                                                    $x++;
                                                                }
                                                            }
                                                        //}
                                                        if(isset($aCustomerStatus_2[$x]['user_department'])){
                                                            ?>
                                                            <?php 
                                                            if(isset($aCustomerStatus_2[$x]['dep_1'])){
                                                                ?>
                                                                <td style="width:40px;text-align: center !important;vertical-align: bottom;white-space:nowrap;padding:5px 7px;border:none;margin:0px;" class="status <?php getlatestStatus_2($aCustomerStatus_2[$x]['user_department'],$aCustomerStatus_2[$x]['task_status'],$aCustomerStatus_2[$x]['date1'],$aCustomerStatus_2[$x]['date2'],$aCustomerStatus_2[$x]['admin_status'])?>">
                                                                    <?php getlatestText_2($aCustomerStatus_2[$x]['user_department'],$aCustomerStatus_2[$x]['task_status'],$aCustomerStatus_2[$x]['date1'],$aCustomerStatus_2[$x]['date2'],$aCustomerStatus_2[$x]['admin_status'])?>
                                                                </td>
                                                            <?php } else {?>
                                                                <td style="width:40px;text-align: center !important;vertical-align: bottom;white-space:nowrap;padding:5px 7px;border:none;margin:0px;"></td>
                                                            <?php }?>
                                                        <?php }else{ ?>
                                                                 <td style="width:40px;text-align: center !important;vertical-align: bottom;white-space:nowrap;padding:5px 7px;border:none;margin:0px;">N</td>
                                                        <?php } } }?>

                                                      

                                                    </tr>
                                                </table>


                                            <?php } }?>

                                    </td>

                                     <?php
                                    if(isset($jobs['customers'])&& !empty($jobs['customers'])){


                                        if(isset($customer['documentverifystatus']['dep_'])){?>


                                            <td style="text-align: center !important;white-space:nowrap;padding:5px 7px;border:none;height:60px;" class="status <?=$customer['documentverifystatus']['class_']?>"><?php echo $customer['documentverifystatus']['text_']?></td>
                                        <?php } else {?>
                                            <td style="text-align: center !important;white-space:nowrap;padding:5px 7px;border:none;height:60px;"></td>
                                        <?php }?>


                                    <?php } ?>

                                    <?php
                                    if(isset($jobs['customers'])&& !empty($jobs['customers'])){


                                        if(isset($customer['change_implementation_data']['dep_'])){?>


                                            <td style="text-align: center !important;white-space:nowrap;padding:5px 7px;border:none;height:60px;" class="status <?=$customer['change_implementation_data']['class_']?>"><?php echo $customer['change_implementation_data']['text_']?></td>
                                        <?php } else {?>
                                            <td style="text-align: center !important;white-space:nowrap;padding:5px 7px;border:none;height:60px;"></td>
                                        <?php }?>


                                    <?php } ?>


                                    <?php
                                    if(isset($jobs['customers'])&& !empty($jobs['customers'])){


                                        if(isset($customer['before_after_comparison']['dep_'])){?>


                                            <td style="text-align: center !important;white-space:nowrap;padding:5px 7px;border:none;height:60px;" class="status <?=$customer['before_after_comparison']['class_']?>"><?php echo $customer['before_after_comparison']['text_']?></td>
                                        <?php } else {?>
                                            <td style="text-align: center !important;white-space:nowrap;padding:5px 7px;border:none;height:60px;"></td>
                                        <?php }?>


                                    <?php } ?>

                                    <?php
                                    if(isset($jobs['customers'])&& !empty($jobs['customers'])){


                                        if(isset($customer['Final_approval']['dep_'])){?>


                                            <td style="text-align: center !important;white-space:nowrap;padding:5px 7px;border:none;height:60px;" class="status <?=$customer['Final_approval']['class_']?>"><?php echo $customer['Final_approval']['text_']?></td>
                                        <?php } else {?>
                                            <td style="text-align: center !important;white-space:nowrap;padding:5px 7px;border:none;height:60px;"></td>
                                        <?php }?>


                                    <?php } ?>
                                </tr>

                            <?php }  }  }else{?>
                        <tr>
                            No Records Found.

                        </tr>
                    <?php }?>
                    </tbody>
                </table>

            <!-- </div> --><!--/summary-table-->

<!--/s10-->
</body>
</html>

