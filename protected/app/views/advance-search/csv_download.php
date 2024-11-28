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

    <tbody>
    <tr>
        <td style="border-bottom:1px solid #000;"><span style="display: inline-block;height:22px;line-height:18px;text-align:center; width:25px;background-color:#78943C;color:#ffffff;margin-bottom:5px;margin-right:5px;">G</span>Activity Completed with required Approval & Verification </td>
    </tr>

    <tr>
        <td style="border-bottom:1px solid #000;"><span style="display: inline-block;height:22px;line-height:18px;text-align: center; width: 25px;background-color:#F9CC29;color:#ffffff;margin-bottom:5px;margin-right:5px;">Y</span>Within defined target date ( Work in Process ) </td>
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

    if($user_dep>0 && $hod_approved>0){//case = green

        $class='green';
        //  $text = 'G';

    }else if($user_dep>0){//case = yellow

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


<div class="summary-table report-wrapper scrollbarX">

    <table class="striped" style="border:1px solid #000;">
        <thead style="border-bottom:1px solid #000">
        <tr class="tr-bdr">

            <th width="50" style="border-right:1px solid #000">Sr. No.</th>
            <th width="100" style="border-right:1px solid #000">CM No.</th>
            <th width="150" style="border-right:1px solid #000">Change req. date</th>
            <th width="350" style="border-right:1px solid #000">Description of Change</th>
            <th width="200" style="border-right:1px solid #000">Customers</th>
            <th width="200" style="border-right:1px solid #000">Proposed Implementation Date</th>
            <th width="200" style="border-right:1px solid #000">Cut-Off Date</th>
            <th width="200" style="border-right:1px solid #000">Initiator Name</th>
            <th width="50" class="rotate" style="border-right:1px solid #000"><span>HOD Approval<span></th>
            <th width="50" class="rotate" style="border-right:1px solid #000"><span>Define CFT<span></th>
            <th width="400" class="rotate pd-none">
                <table>
                    <tr class="border-bottom" >
                        <td class="center-align" style="border-bottom:1px solid #000;border-right:1px solid #000;">Risk Analysis</td>
                    </tr>
                    <tr>
                        <td class="pd-none">
                            <table class="borderd-cell">
                                <tr>
                                    <?php foreach ($allDepartment as $row) {?>
                                             <td class="rotate pd" style="border-right:1px solid #000"><span><?php echo $row->d_name; ?></span></td>
                                           <?php } ?>
                                 
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </th>
            <th width="50" class="rotate" style="border-right:1px solid #000"><span>COO Approval<span></th>
            <th width="50" class="rotate" style="border-right:1px solid #000"><span>Steering Committee<br>Approval<span></th>
           
            <th width="50" class="rotate" style="border-right:1px solid #000"><span>Customer Approval<br> Status<span></th>
            <th width="400" class="rotate pd-none">
                <table>
                    <tr class="border-bottom">
                        <td class="center-align" style="border-bottom:1px solid #000;border-right:1px solid #000;">Activity Status</td>
                    </tr>
                    <tr>
                        <td class="pd-none">
                            <table class="borderd-cell">
                                <tr>
                                 <?php foreach ($allDepartment as $row) {?>
                                             <td class="rotate pd" style="border-right:1px solid #000"><span><?php echo $row->d_name; ?></span></td>
                                           <?php } ?>
                                    
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </th>
             <th width="50" class="rotate" style="border-right:1px solid #000"><span>Document Verification Status</span></th>
            <th width="50" class="rotate" style="border-right:1px solid #000"><span>Change Cut-Off<br>date</span></th>
            <th width="50" class="rotate"><span>Before / After<br>Comprision</span></th>
             <th width="50" class="rotate" style="border-right:1px solid #000"><span>Final Closer Status</span></th>
        </tr>
        </thead>
        <tbody id="checkboxex">
        <?php

        if(sizeof($data)>0){

            $i=0;
            foreach($data as $jobs){  ?>

                <?php if(isset($jobs['customers'])&& !empty($jobs['customers'])){?>

                    <tr style="border-top:1px solid #000">

                        <td style="border-right:1px solid #000"><?=++$i?>.</td>

                        <td style="border-right:1px solid #000">
                            <span ><?=$jobs['cmNo']." ".$jobs['count_request_is_rejected'];?></span></td>

                        <td style="border-right:1px solid #000"><?= $jobs['created_date'];?></td>
                        <td style="border-right:1px solid #000"><?= $jobs['Purpose_Modification_Details'];?></td>
                        <td style="border-right:1px solid #000">

                            <?php
                            if(isset($jobs['customers'])&& !empty($jobs['customers']) && (count($jobs['customers']))>1){?>
                                <ul class="listing bdr-btm">

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

                         <td style="border-right:1px solid #000">

                            <?php
                            if(isset($jobs['customers'])&& !empty($jobs['customers']) && (count($jobs['customers']))>1){?>
                                <ul class="listing bdr-btm">

                                    <?php foreach($jobs['customers'] as $customer){  ?>

                                        <li>
                                            <span><?=$customer['Proposed_date'];?></span>

                                        </li>
                                    <?php } ?>
                                </ul>



                            <?php } else if(isset($jobs['customers'])&& !empty($jobs['customers'])){

                                foreach($jobs['customers'] as $customer){  ?>


                                    <?=$customer['Proposed_date'];?>
                                <?php   } }?>

                        </td>
                         <td style="border-right:1px solid #000">

                            <?php
                            if(isset($jobs['customers'])&& !empty($jobs['customers']) && (count($jobs['customers']))>1){?>
                                <ul class="listing bdr-btm">

                                    <?php foreach($jobs['customers'] as $customer){  ?>

                                        <li>
                                            <span><?=$customer['actual_date'];?></span>

                                        </li>
                                    <?php } ?>
                                </ul>



                            <?php } else if(isset($jobs['customers'])&& !empty($jobs['customers'])){

                                foreach($jobs['customers'] as $customer){  ?>


                                    <?=$customer['actual_date'];?>
                                <?php   } }?>

                        </td>

                        <td style="border-right:1px solid #000;">

                            <?php
                            if(isset($jobs['customers'])&& !empty($jobs['customers']) && (count($jobs['customers']))>1){?>
                                <ul class="listing bdr-btm">

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
                                    <td style="border-right:1px solid #000;text-align:center;" class="status <?=$jobs['HODapproval']['status']?>"><?php echo $jobs['HODapproval']['text']?></td>
                        <?php }?>
                        <?php if(!empty($jobs['DefineCFT'])){ ?>
                                    <td style="border-right:1px solid #000;text-align:center;" class="status <?=$jobs['DefineCFT']['status']?>"><?php echo $jobs['DefineCFT']['text']?></td>
                                   <?php }?>
                        <td class="pd-none" style="border-right:1px solid #000">
                            <?php
                            $k='';
                            if(isset($jobs['customers'])&& !empty($jobs['customers'])){


                                foreach($jobs['customers'] as $customer){
                                    $aCustomerStatus=$customer['status'];

                                    ?>
                                    <table class="borderd-cell" style="width:100%">
                                        <tr>
                                            <?php
                                            //-------------dep0--------------
                                            $k=0;?><td><table><tr style="border-bottom:1px solid #000;text-align:center;">

                                                        <?php foreach($allDepartment as $dept){ 
                                                             if(!empty( $aCustomerStatus)){ 
                                                        $x=0;
                                                            foreach($aCustomerStatus as $status){
                                                        
                                                                if($dept->d_id === $status['all_reqDept']){
                                                                    
                                                                    break;
                                                                }else{
                                                                    $x++;
                                                                }
                                                            }
                                                        if(isset($aCustomerStatus[$x]['user_dep'])){
                                                            ?>
                                                            <?php if(isset($aCustomerStatus[$x]['dep_1'])){
                                                                ?>
                                                                <td style="border-right:1px solid #000" class="status <?php getlatestStatus($aCustomerStatus[$x]['user_dep'],$aCustomerStatus[$x]['hod_approved'])?>"><?php getlatestText($aCustomerStatus[$x]['user_dep'],$aCustomerStatus[$x]['hod_approved'])?>
                                                                </td>
                                                            <?php } else {?>
                                                                <td></td>
                                                            <?php }?>
                                                        <?php }else{ ?>
                                                                 <td>N</td>
                                                       <?php } } }?>

                                                       
                                                    </tr></table></td>



                                        </tr>
                                    </table>


                                <?php } }?>


                        </td>

                        <?php if(!empty($jobs['cooappstatus'])){ ?>
                                    <td style="border-right:1px solid #000;text-align:center;" class="status <?=$jobs['cooappstatus']['status']?>"><?php echo $jobs['cooappstatus']['text']?></td>
                                   <?php }?>
                        <?php
                        if(isset($jobs['customers'])&& !empty($jobs['customers'])){


                            if(isset($customer['status_steering']['dep_'])){?>


                                <td style="border-right:1px solid #000;text-align:center;" class="status <?=$customer['status_steering']['class_']?>"><?php echo $customer['status_steering']['text_']?></td>
                            <?php } else {?>
                                <td></td>
                            <?php }?>


                        <?php } ?>

                        <?php
                        if(isset($jobs['customers'])&& !empty($jobs['customers'])){


                            if(isset($customer['customer_approval']['dep_'])){?>


                                <td style="border-right:1px solid #000;text-align:center;" class="status <?=$customer['customer_approval']['class_']?>"><?php echo $customer['customer_approval']['text_']?></td>
                            <?php } else {?>
                                <td></td>
                            <?php }?>


                        <?php } ?>

                        <td class="pd-none" style="border-right:1px solid #000">

                            <?php
                            $k='';
                            if(isset($jobs['customers'])&& !empty($jobs['customers'])){


                                foreach($jobs['customers'] as $customer){
                                    $aCustomerStatus_2=$customer['status2'];

                                    ?>


                                    <table class="borderd-cell" style="width:100%">
                                        <tr>
                                            <?php
                                            //-------------dep0--------------
                                            $j=0;?><td><table><tr style="border-bottom:1px solid #000;text-align:center;"><?php
                                                foreach($allDepartment as $dept){ 
                                                       if(!empty( $aCustomerStatus_2)){ 
                                                        $x=0;
                                                            foreach($aCustomerStatus as $status){
                                                        
                                                                if($dept->d_id === $status['all_reqDept']){
                                                                    
                                                                    break;
                                                                }else{
                                                                    $x++;
                                                                }
                                                            }

                                                        if(isset($aCustomerStatus_2[$x]['user_department'])){
                                                            ?>
                                                            <?php if(isset($aCustomerStatus_2[$x]['dep_1'])){
                                                                ?>
                                                                <td style="border-right:1px solid #000" class="status <?php getlatestStatus_2($aCustomerStatus_2[$x]['user_department'],$aCustomerStatus_2[$x]['task_status'],$aCustomerStatus_2[$x]['date1'],$aCustomerStatus_2[$x]['date2'],$aCustomerStatus_2[$x]['admin_status'])?>">
                                                                    <?php getlatestText_2($aCustomerStatus_2[$x]['user_department'],$aCustomerStatus_2[$x]['task_status'],$aCustomerStatus_2[$x]['date1'],$aCustomerStatus_2[$x]['date2'],$aCustomerStatus_2[$x]['admin_status'])?>
                                                                </td>
                                                            <?php } else {?>
                                                                <td></td>
                                                            <?php }?>
                                                        <?php }else{ ?>
                                                            <td>N</td>
                                                       <?php } } }?>

                                                       
                                                    </tr></table></td>
                                        </tr>
                                    </table>


                                <?php } }?>

                        </td>

                        <?php
                        if(isset($jobs['customers'])&& !empty($jobs['customers'])){


                            if(isset($customer['documentverifystatus']['dep_'])){?>


                                <td style="border-right:1px solid #000;text-align:center;" class="status <?=$customer['documentverifystatus']['class_']?>"><?php echo $customer['documentverifystatus']['text_']?></td>
                            <?php } else {?>
                                <td></td>
                            <?php }?>


                        <?php } ?>


                        <?php
                        if(isset($jobs['customers'])&& !empty($jobs['customers'])){


                            if(isset($customer['change_implementation_data']['dep_'])){?>


                                <td style="border-right:1px solid #000;text-align:center;" class="status <?=$customer['change_implementation_data']['class_']?>"><?php echo $customer['change_implementation_data']['text_']?></td>
                            <?php } else {?>
                                <td></td>
                            <?php }?>


                        <?php } ?>


                        <?php
                        if(isset($jobs['customers'])&& !empty($jobs['customers'])){


                            if(isset($customer['before_after_comparison']['dep_'])){?>


                                <td style="border-right:1px solid #000;text-align:center;" class="status <?=$customer['before_after_comparison']['class_']?>"><?php echo $customer['before_after_comparison']['text_']?></td>
                            <?php } else {?>
                                <td></td>
                            <?php }?>


                        <?php } ?>

                        <?php
                        if(isset($jobs['customers'])&& !empty($jobs['customers'])){


                            if(isset($customer['Final_approval']['dep_'])){?>


                                <td style="border-right:1px solid #000;text-align:center;" class="status <?=$customer['Final_approval']['class_']?>"><?php echo $customer['Final_approval']['text_']?></td>
                            <?php } else {?>
                                <td></td>
                            <?php }?>


                        <?php } ?>
                    </tr>

                <?php } }}else{?>
            <tr>
                No Records Found.

            </tr>
        <?php }?>

        </tbody>

    </table>

</body>
</html>