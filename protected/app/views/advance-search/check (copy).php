<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,700,600italic,700italic,800">

    <link href="css/font-awesome.min.css" rel="stylesheet">
    <style type="text/css">
        .green{
            border-style:solid;
            border-width:0px 0px 0px 1px;
            border-color:#E5E5E5;
            background-color:#78943C;
            padding:3px;
            text-align:center;
            color:#ffffff;
        }

        .red{
            border-style:solid;
            border-width:0px 0px 0px 1px;
            border-color:#E5E5E5;
            background-color:#B9150C;
            padding:3px;
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
function getStatus($iDptId,$aDone){
    $sClass="yellow";
    if(in_array($iDptId,$aDone)){
        $sClass="green";
    }
    echo $sClass;
}
function getStatusText($iDptId,$aDone){
    $sClass="Y";
    if(in_array($iDptId,$aDone)){
        $sClass="G";
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


<table style="font-size:10px;border-spacing:0;width:100%;overflow-x:auto!important;table-layout:fixed;" >
    <thead>
    <tr>
        <th colspan="5">
        </th>
        <th colspan="8" style="border:1px solid #E5E5E5;border-bottom:none;text-align:center;padding:5px;color:#77788D;">Risk Analysis</th>
        <th colspan="3">
        </th>
        <th colspan="8" style="border:1px solid #E5E5E5;border-bottom:none;text-align:center;padding:5px;color:#77788D;">Activity Status</th>
    </tr>
    </thead>


    <tbody>
    <tr>
        <td style="width:7%;color:#38393A;border:1px solid #E5E5E5;border-right:none;font-weight:600;padding:10px;
       text-align:left;vertical-align: bottom;display:table-cell;padding: 15px 5px;">CM No1.</td>

        <td style="width:7%;color:#38393A;border:1px solid #E5E5E5;font-weight: 600;padding:15px 3px;
       text-align: left;vertical-align: bottom;display:table-cell;border-right:none;">Change req. date</td>

        <td style="width:7%;color:#38393A;border:1px solid #E5E5E5;font-weight: 600;padding:5px;
       text-align: left;vertical-align: bottom;display: table-cell;padding: 15px 5px;border-right:none;">Description of Change</td>

        <td style="width:7%;color:#38393A;border:1px solid #E5E5E5;font-weight: 600;padding:5px;
       text-align: left;vertical-align: bottom;display: table-cell;padding: 15px 5px;border-right:none;">Customer</td>

        <td style="width:7%;color:#38393A;border:1px solid #E5E5E5;font-weight: 600;padding:5px;
       text-align: left;vertical-align: bottom;display: table-cell;padding:15px 5px;border-right:none;">Initiator Name</td>

        <td style="height:170px;text-align: center !important;vertical-align: bottom;white-space:nowrap;border:1px solid #E5E5E5;padding-bottom: 10px;border-right:none;"><span style="color: #38393A;display: block !important;margin: 0 auto 1px;transform: rotate(-90deg);width: 15px;font-weight:600;">Design</span></td>

        <td style="height:170px;text-align: center !important;vertical-align: bottom;white-space:nowrap;border:1px solid #E5E5E5;padding-bottom: 10px;border-right:none;"><span <span style="color: #38393A;display: block !important;margin: 0 auto 5px;transform: rotate(-90deg);width: 15px;font-weight:600;">Mfg. eng.</span></td>

        <td style="height:170px;text-align: center !important;vertical-align: bottom;white-space:nowrap;border:1px solid #E5E5E5;padding-bottom: 10px;border-right:none;"><span style="color: #38393A;display: block !important;margin: 0 auto 8px;transform: rotate(-90deg);width:5px;font-weight:600;">Purchase</span></td>

        <td style="height:170px;text-align: center !important;vertical-align: bottom;white-space:nowrap;border:1px solid #E5E5E5;padding-bottom:10px;border-right:none;"><span style="color:#38393A;display: block !important;margin: 0 auto;transform: rotate(-90deg);width:5px;font-weight:600;">SQA</span></td>

        <td style="height:170px;text-align: center !important;vertical-align:bottom;white-space:nowrap;border:1px solid #E5E5E5;padding-bottom:5px;border-right:none;"><span style="color: #38393A;display: block !important;margin: 0 auto 20px;transform: rotate(-90deg);width:10px;font-weight:600;">PO & System</span></td>

        <td style="height:170px;text-align: center !important;vertical-align: bottom;white-space:nowrap;border:1px solid #E5E5E5;padding-bottom: 10px;border-right:none;"><span style="#38393A;display: block !important;margin: 0 auto 5px;transform: rotate(-90deg);width: 15px;font-weight:600;">Logistic</span></td>

        <td style="height:170px;text-align: center !important;vertical-align:bottom;white-space:nowrap;border:1px solid #E5E5E5;padding-bottom:5px;border-right:none;"><span style="color: #38393A;display: block !important;margin: 0 auto 20px;transform: rotate(-90deg);width:10px;font-weight:600;">PO & System</span></td>

        <td style="height:170px;text-align: center !important;vertical-align: bottom;white-space:nowrap;border:1px solid #E5E5E5;padding-bottom: 10px;border-right:none;"><span style="#38393A;display: block !important;margin: 0 auto 5px;transform: rotate(-90deg);width: 15px;font-weight:600;">Logistic</span></td>

        <td style="height:170px;text-align: center !important;vertical-align: bottom;white-space:nowrap;border:1px solid #E5E5E5;padding-bottom: 10px;border-right:none;"><span style="color: #38393A;display: block !important;margin: 0 auto 10px;transform: rotate(-90deg);width: 15px;font-weight:600;">Production</span></td>

        <td style="height:170px;text-align: center !important;vertical-align: bottom;white-space:nowrap;border:1px solid #E5E5E5;padding-bottom: 10px;border-right:none;"><span style="color: #38393A;display: block !important;margin: 0 auto 12px;transform: rotate(-90deg);width: 15px;font-weight:600;">Process QA</span></td>

        <td style="height:170px;text-align: center !important;vertical-align: bottom;white-space:nowrap;border:1px solid #E5E5E5;padding-bottom: 10px;border-right:none;"><span style="color: #38393A;display: block !important;margin: 0 auto 55px;transform: rotate(-90deg);width: 15px;font-weight:600;">Steering Committee Approval</span></td>

        <td style="height:170px;text-align: center !important;vertical-align: bottom;white-space:nowrap;border:1px solid #E5E5E5;padding-bottom: 10px;border-right:none;"><span style="color: #38393A;display: block !important;margin: 0 auto 52px;transform: rotate(-90deg);width: 15px;font-weight:600;">Customer Approval Decision</span></td>


        <td style="height:170px;text-align: center !important;vertical-align: bottom;white-space:nowrap;border:1px solid #E5E5E5;padding-bottom: 10px;border-right:none;"><span style="color: #38393A;display: block !important;margin: 0 auto 45px;transform: rotate(-90deg);width: 15px;font-weight:600;">Customer Approval Status</span></td>

        <td style="height:170px;text-align: center !important;vertical-align: bottom;white-space:nowrap;border:1px solid #E5E5E5;padding-bottom: 10px;border-right:none;"><span style="color: #38393A;display: block !important;margin: 0 auto 1px;transform: rotate(-90deg);width: 15px;font-weight:600;">Design</span></td>

        <td style="height:170px;text-align: center !important;vertical-align: bottom;white-space:nowrap;border:1px solid #E5E5E5;padding-bottom: 10px;border-right:none;"><span style="color: #38393A;display: block !important;margin: 0 auto 5px;transform: rotate(-90deg);width: 15px;font-weight:600;">Mfg. eng.</span></td>

        <td style="height:170px;text-align: center !important;vertical-align: bottom;white-space:nowrap;border:1px solid #E5E5E5;padding-bottom: 10px;border-right:none;"><span style="color: #38393A;display: block !important;margin: 0 auto 5px;transform: rotate(-90deg);width: 15px;font-weight:600;">Purchase</span></td>

        <td style="height:170px;text-align: center !important;vertical-align: bottom;white-space:nowrap;border:1px solid #E5E5E5;border-right:none;"><span style="color: #38393A;display: block !important;margin: 0 auto 3px;transform: rotate(-90deg);width:15px;font-weight:600;">SQA</span></td>

        <td style="height:170px;text-align: center !important;vertical-align: bottom;white-space:nowrap;border:1px solid #E5E5E5;padding-bottom: 10px;border-right:none;"><span style="color: #38393A;display: block !important;margin: 0 auto 15px;transform: rotate(-90deg);width: 15px;font-weight:600;">PO & System</span></td>

        <td style="height:170px;text-align: center !important;vertical-align:bottom;white-space:nowrap;border:1px solid #E5E5E5;padding-bottom:5px;border-right:none;"><span style="color: #38393A;display: block !important;margin: 0 auto 20px;transform: rotate(-90deg);width:10px;font-weight:600;">PO & System</span></td>

        <td style="height:170px;text-align: center !important;vertical-align: bottom;white-space:nowrap;border:1px solid #E5E5E5;padding-bottom: 10px;border-right:none;"><span style="#38393A;display: block !important;margin: 0 auto 5px;transform: rotate(-90deg);width: 15px;font-weight:600;">Logistic</span></td>

        <td style="height:170px;text-align: center !important;vertical-align: bottom;white-space:nowrap;border:1px solid #E5E5E5;padding-bottom: 10px;border-right:none;"><span style="color: #38393A;display: block !important;margin: 0 auto 5px;transform: rotate(-90deg);width: 15px;font-weight:600;">Logistic</span></td>

        <td style="height:170px;text-align: center !important;vertical-align: bottom;white-space:nowrap;border:1px solid #E5E5E5;padding-bottom: 10px;border-right:none;"><span style="color: #38393A;display: block !important;margin: 0 auto 10px;transform: rotate(-90deg);width: 15px;font-weight:600;">Production</span></td>

        <td style="height:170px;text-align: center !important;vertical-align: bottom;white-space:nowrap;border:1px solid #E5E5E5;padding-bottom: 10px;border-right:none;"><span style="color: #38393A;display: block !important;margin: 0 auto 12px;transform: rotate(-90deg);width: 15px;font-weight:600;">Process QA</span></td>

        <td style="height:170px;text-align: center !important;vertical-align: bottom;white-space:nowrap;border:1px solid #E5E5E5;padding-bottom: 10px;border-right:none;"><span style="color: #38393A;display: block !important;margin: 0 auto 52px;transform: rotate(-90deg);width: 15px;font-weight:600;">Change Implementation date</span></td>

        <td style="height:170px;text-align: center !important;vertical-align: bottom;white-space:nowrap;border:1px solid #E5E5E5;padding-bottom: 10px;"><span style="color: #38393A;display: block !important;margin: 0 auto 45px;transform: rotate(-90deg);width: 15px;font-weight:600;border-right:none;">Before / After Comprision</span></td>

    </tr>
    <?php
    if(sizeof($data)>0){


    $i=0;
    foreach($data as $jobs){  ?>
        <tr style="background-color:#F9F9F9; color:hsl(228, 2%, 48%)">
        <td style="border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;padding-left:5px;"><?=$jobs['cmNo'];?></td>
        <td style="padding-left:5px;border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;"><?= $jobs['created_date'];?></td>
        <td style="border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;padding-left:5px;"><?= $jobs['Purpose_Modification_Details'];?></td>
        <td style="border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;padding-left:5px;"><ul class="listing" style="list-style-type:none;">
                <?php
                if(isset($jobs['customers'])&& !empty($jobs['customers'])){
                    foreach($jobs['customers'] as $customer){  ?>

                        <li>
                            <?=$customer['customer_name'];?>

                        </li>
                    <?php } }?>
            </ul></td>

        <td style="border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;padding-left:5px;"><?= $jobs['initiator_name'];?></td>
        <td class="pd-none">
            <?php
            if(isset($jobs['customers'])&& !empty($jobs['customers'])){


                foreach($jobs['customers'] as $customer){

                    if(isset($customer['status']) && is_array($customer['status'])){
                        $aDone=array();
                        foreach($customer['status'] as $data){

                            if($data['class_1']!='yellow'){
                                array_push($aDone,$data['department']);
                            }

                        }

                    }
                    ?>
                    <table class="borderd-cell">
                        <tr>
                            <?php if(isset($customer['status'][0]['dep_1'])){

                                ?>


                                <td class="status <?php getStatus(1,$aDone)?>" style="border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;padding:3px;text-align:center;color:#ffffff;"><?php getStatusText(1,$aDone)?></td>
                            <?php } else {?>
                                <td></td>
                            <?php }?>

                            <?php if(isset($customer['status'][1]['dep_1'])){?>
                                <td class="status <?php getStatus(2,$aDone)?>" style="border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;padding:3px;text-align:center;color:#ffffff;"><?php getStatusText(2,$aDone)?></td>
                            <?php } else {?>
                                <td></td>
                            <?php }?>

                            <?php if(isset($customer['status'][2]['dep_1'])){?>
                                <td class="status <?php getStatus(3,$aDone)?>" style="border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;padding:3px;text-align:center;color:#ffffff;"><?php getStatusText(3,$aDone)?></td>
                            <?php } else {?>
                                <td></td>
                            <?php }?>

                            <?php if(isset($customer['status'][3]['dep_1'])){?>
                                <td class="status <?php getStatus(4,$aDone)?>" style="border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;padding:3px;text-align:center;color:#ffffff;"><?php getStatusText(4,$aDone)?></td>
                            <?php } else {?>
                                <td></td>
                            <?php }?>
                            <?php if(isset($customer['status'][4]['dep_1'])){?>
                                <td class="status <?php getStatus(5,$aDone)?>" style="border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;padding:3px;text-align:center;color:#ffffff;"><?php getStatusText(5,$aDone)?></td>
                            <?php } else {?>
                                <td></td>
                            <?php }?>
                            <?php if(isset($customer['status'][5]['dep_1'])){?>
                                <td class="status <?php getStatus(6,$aDone)?>" style="border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;padding:3px;text-align:center;color:#ffffff;"><?php getStatusText(6,$aDone)?></td>
                            <?php } else {?>
                                <td></td>
                            <?php }?>
                            <?php if(isset($customer['status'][6]['dep_1'])){?>
                                <td class="status <?php getStatus(7,$aDone)?>" style="border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;padding:3px;text-align:center;color:#ffffff;"><?php getStatusText(7,$aDone)?></td>
                            <?php } else {?>
                                <td></td>
                            <?php }?>
                            <?php if(isset($customer['status'][7]['dep_1'])){?>
                                <td class="status <?php getStatus(8,$aDone)?>" style="border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;padding:3px;text-align:center;color:#ffffff;"><?php getStatusText(8,$aDone)?></td>
                            <?php } else {?>
                                <td></td>
                            <?php }?>
                            <?php if(isset($customer['status'][8]['dep_1'])){?>
                                <td class="status <?php getStatus(9,$aDone)?>" style="border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;padding:3px;text-align:center;color:#ffffff;"><?php getStatusText(9,$aDone)?></td>
                            <?php } else {?>
                                <td></td>
                            <?php }?>
                            <?php if(isset($customer['status'][9]['dep_1'])){?>
                                <td class="status <?php getStatus(10,$aDone)?>" style="border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;padding:3px;text-align:center;color:#ffffff;"><?php getStatusText(10,$aDone)?></td>
                            <?php } else {?>
                                <td></td>
                            <?php }?>


                        </tr>
                    </table>


                <?php } }?>


        </td>
        <td class="no-pd">
            <table class="bordered-cell">
                <tr><?php
                    if(isset($jobs['customers'])&& !empty($jobs['customers'])){


                        if(isset($customer['status_steering']['dep_'])){?>


                            <td class="status <?=$customer['status_steering']['class_']?>"><?php echo $customer['status_steering']['text_']?></td>
                        <?php } else {?>
                            <td></td>
                        <?php }?>


                    <?php } ?></tr></table></td>

        <?php
        if(isset($jobs['customers'])&& !empty($jobs['customers'])){


            if(isset($customer['customer_approval']['dep_'])){?>


                <td class="status <?=$customer['customer_approval']['class_']?>" style="border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;padding-left:5px;"><?php echo $customer['customer_approval']['text_']?></td>
            <?php } else {?>
                <td></td>
            <?php }?>


        <?php } ?>

        <?php
        if(isset($jobs['customers'])&& !empty($jobs['customers'])){


            if(isset($customer['customer_approval_status']['dep_'])){?>


                <td class="status <?=$customer['customer_approval_status']['class_']?>" style="border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;padding-left:5px;"><?php echo $customer['customer_approval_status']['text_']?></td>
            <?php } else {?>
                <td></td>
            <?php }?>


        <?php } ?>

        <td class="pd-none">

            <?php
            if(isset($jobs['customers'])&& !empty($jobs['customers'])){


                foreach($jobs['customers'] as $customer){



                    if(isset($customer['status2']) && is_array($customer['status2'])){
                        $aDone=array();
                        foreach($customer['status2'] as $data){
                            // echo '<pre>';
                            // print_r($data);exit;

                            array_push($aDone,$data['department']);
                        }
                    }
                    ?>

                    <table class="borderd-cell">
                        <tr>


                            <?php if(isset($customer['status2'][9]['dep_'])){?>
                                <td class="status <?=$customer['status2'][9]['class_']?>" style="border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;padding-left:5px;"><?php echo $customer['status2'][9]['text_']?></td>
                            <?php } else {?>
                                <td></td>
                            <?php }?>

                            <?php if(isset($customer['status2'][8]['dep_'])){?>
                                <td class="status <?=$customer['status2'][8]['class_']?>" style="border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;padding-left:5px;"><?php echo $customer['status2'][8]['text_']?></td>
                            <?php } else {?>
                                <td></td>
                            <?php }?>

                            <?php if(isset($customer['status2'][7]['dep_'])){?>
                                <td class="status <?=$customer['status2'][7]['class_']?>" style="border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;padding-left:5px;"><?php echo $customer['status2'][7]['text_']?></td>
                            <?php } else {?>
                                <td></td>
                            <?php }?>
                            <?php if(isset($customer['status2'][6]['dep_'])){?>
                                <td class="status <?=$customer['status2'][6]['class_']?>" style="border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;padding-left:5px;"><?php echo $customer['status2'][6]['text_']?></td>
                            <?php } else {?>
                                <td></td>
                            <?php }?>
                            <?php if(isset($customer['status2'][5]['dep_'])){?>
                                <td class="status <?=$customer['status2'][5]['class_']?>" style="border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;padding-left:5px;"><?php echo $customer['status2'][5]['text_']?></td>
                            <?php } else {?>
                                <td></td>
                            <?php }?>
                            <?php if(isset($customer['status2'][4]['dep_'])){?>
                                <td class="status <?=$customer['status2'][4]['class_']?>" style="border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;padding-left:5px;"><?php echo $customer['status2'][4]['text_']?></td>
                            <?php } else {?>
                                <td></td>
                            <?php }?>
                            <?php if(isset($customer['status2'][3]['dep_'])){?>
                                <td class="status <?=$customer['status2'][3]['class_']?>" style="border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;padding-left:5px;"><?php echo $customer['status2'][3]['text_']?></td>
                            <?php } else {?>
                                <td></td>
                            <?php }?>
                            <?php if(isset($customer['status2'][2]['dep_'])){?>
                                <td class="status <?=$customer['status2'][2]['class_']?>" style="border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;padding-left:5px;"><?php echo $customer['status2'][2]['text_']?></td>
                            <?php } else {?>
                                <td></td>
                            <?php }?>
                            <?php if(isset($customer['status2'][1]['dep_'])){?>
                                <td class="status <?=$customer['status2'][1]['class_']?>" style="border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;padding-left:5px;"><?php echo $customer['status2'][1]['text_']?></td>
                            <?php } else {?>
                                <td></td>
                            <?php }?>
                            <?php if(isset($customer['status2'][0]['dep_'])){?>

                                <td class="status <?=$customer['status2'][0]['class_']?>" style="border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;padding-left:5px;"><?php echo $customer['status2'][0]['text_']?></td>
                            <?php } else {?>
                                <td></td>
                            <?php }?>


                        </tr>
                    </table>


                <?php } }?>

        </td>

        <?php
        if(isset($jobs['customers'])&& !empty($jobs['customers'])){


            if(isset($customer['change_implementation_data']['dep_'])){?>


                <td class="status <?=$customer['change_implementation_data']['class_']?>" style="border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;padding-left:5px;"><?php echo $customer['change_implementation_data']['text_']?></td>
            <?php } else {?>
                <td></td>
            <?php }?>


        <?php } ?>


        <?php
        if(isset($jobs['customers'])&& !empty($jobs['customers'])){


            if(isset($customer['before_after_comparison']['dep_'])){?>


                <td class="status <?=$customer['before_after_comparison']['class_']?>" style="border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;padding-left:5px;"><?php echo $customer['before_after_comparison']['text_']?></td>
            <?php } else {?>
                <td></td>
            <?php }?>

            <!--td style="border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;background-color:#78943C;padding:3px;text-align:center;color:#ffffff;">G</td>
            <td style="border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;background-color:#78943C;padding:3px;text-align:center;color:#ffffff;">G</td>
            <td style="border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;text-align:center;background-color:#F9CC29;color:#ffffff;">Y</td>
            <td style="border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;background-color:#78943C;padding:3px;text-align:center;color:#ffffff;">G</td>
            <td style="border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;background-color:#78943C;padding:3px;text-align:center;color:#ffffff;">G</td>

            <td style="border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;background-color:#B9150C;padding:3px;text-align:center;color:#ffffff;">R</td>

            <td style="border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;background-color:#78943C;padding:3px;text-align:center;color:#ffffff;">G</td>

            <td style="border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;background-color:#78943C;padding:3px;text-align:center;color:#ffffff;">G</td>

            <td style="border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;background-color:#78943C;padding:3px;text-align:center;color:#ffffff;">G</td>

            <td style="border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;background-color:#78943C;padding:3px;text-align:center;color:#ffffff;">G</td>

            <td style="border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;background-color:#78943C;padding:3px;text-align:center;color:#ffffff;">G</td>

            <td style="border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;background-color:#78943C;padding:3px;text-align:center;color:#ffffff;">G</td>

            <td style="border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;background-color:#78943C;padding:3px;text-align:center;color:#ffffff;">G</td>

            <td style="border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;background-color:#78943C;padding:3px;text-align:center;color:#ffffff;">G</td>

            <td style="border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;background-color:#78943C;padding:3px;text-align:center;color:#ffffff;">G</td>

            <td style="border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;text-align:center;background-color:#F9CC29;color:#ffffff;">Y</td>

            <td style="border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;background-color:#78943C;padding:3px;text-align:center;color:#ffffff;">G</td>

            <td style="border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;background-color:#B9150C;padding:3px;text-align:center;color:#ffffff;">R</td>

            <td style="border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;background-color:#78943C;padding:3px;text-align:center;color:#ffffff;">G</td>

            <td style="border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;background-color:#78943C;padding:3px;text-align:center;color:#ffffff;">G</td>

            <td style="border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;background-color:#78943C;padding:3px;text-align:center;color:#ffffff;">G</td-->


            </tr>
        <?php } } }else{?>
        <tr>
            No Records Found.

        </tr>
    <?php }?>

    </tbody>

</table>

</body>
</html>