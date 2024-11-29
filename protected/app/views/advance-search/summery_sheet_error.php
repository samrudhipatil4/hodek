<?php require app_path().'/views/header.php'; ?>
<?php $user_type = Session::get('gid');?>
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


<div class="col-sm-12" >

    <div class="row">
        <div class="col-sm-8">
            <div class="page-heading">
                <h1>Summary Sheet</h1>
            </div><!--/page-heading-->

        </div>
        <div class="col-sm-4">
            <div class="page-heading pull-right">
                <a class="btn btn-animate flat blue pd-btn" href="<?php echo Request::root().'/advance-search'; ?>">Back To Search</a>
            </div><!--/page-heading-->


        </div>
    </div>
    <form method="post" action="<?php echo Request::root().'/advance-search/download'; ?>">
        <div class="content-wrapper">

            <div class="row mg-btm">
                <div class="col-sm-6">

                    <input type="hidden" name="startdate" value="<?=$formInput['startdate'];?>">
                    <input type="hidden" name="enddate" value="<?=$formInput['enddate'];?>">
                    <input type="hidden" name="change_type" value="<?=$formInput['change_type'];?>">
                    <input type="hidden" name="change_stage_id" value="<?=$formInput['change_stage_id'];?>">
                    <input type="hidden" name="plantcode" value="<?=$formInput['plantcode'];?>">
                    <input type="hidden" name="purpose" value="<?=$formInput['purpose'];?>">
                    <input type="hidden" name="customer_id" value="<?=$formInput['customer_id'];?>">




                    <div class="action-group pd-top">
                        <form method="post" action="">
                            <button class="btn btn-animate flat blue pd-btn "  value="excel" name="filetype" type="submit">Export to Excel Sheet</button>
                            <button class="btn btn-animate flat blue pd-btn "  value="pdf" name="filetype" type="submit">Export to PDF</button>
                        </form>
                    </div>



                </div>
                <div class="col-sm-6 pull-right">
                    <ul class="summary-status right-align mg-top-0">
                        <li>Activity Completed with required Approval & Verification <span>G</span></li>
                        <li>Within defined target date ( Work in Process )  <span>Y</span></li>
                        <li>Activity Over due <span>R</span></li>
                    </ul>
                </div>
            </div>

            <!-- summary Table start -->
            <div class="summary-table report-wrapper scrollbarX">

                <table class="striped">
                    <thead>
                    <tr class="tr-bdr">

                        <?php if($user_type==1){?>
                            <th width="40" class="rotate pd"><span>Hide</span><!--<input type="checkbox" id="checkall" class="default" />--></th>
                        <?php  }?>






                        <th width="50">Sr. No.</th>
                        <th width="100">CM No.</th>
                        <th width="150">Change req. date</th>
                        <th width="350">Description of Change</th>
                        <th width="200">Customers</th>
                        <th width="200">Initiator Name</th>
                        <th width="400" class="rotate pd-none">
                            <table>
                                <tr class="border-bottom">
                                    <td class="center-align">Risk Analysis</td>
                                </tr>
                                <tr>
                                    <td class="pd-none">
                                        <table class="borderd-cell">
                                            <tr>
                                                <td class="rotate pd"><span>Design</span></td>
                                                <td class="rotate pd"><span>Mfg. eng.</span></td>
                                                <td class="rotate pd"><span>Purchase</span></td>
                                                <td class="rotate pd"><span>Quality</span></td>
                                                <td class="rotate pd"><span>Logistic</span></td>
                                                <td class="rotate pd"><span>Production</span></td>
                                                <td class="rotate pd"><span>PO & System</span></td>
                                                <td class="rotate pd"><span>Maintenance</span></td>
                                                <td class="rotate pd"><span>Customer</span></td>
                                                <td class="rotate pd"><span>Finance</span></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </th>
                        <th width="50" class="rotate"><span>Steering Committee<br>Approval<span></th>
                        <th width="50" class="rotate"><span>Customer Approval<br>Decision<span></th>
                        <th width="50" class="rotate"><span>Customer Approval<br> Status<span></th>
                        <th width="400" class="rotate pd-none">
                            <table>
                                <tr class="border-bottom">
                                    <td class="center-align">Activity Status</td>
                                </tr>
                                <tr>
                                    <td class="pd-none">
                                        <table class="borderd-cell">
                                            <tr>
                                                <td class="rotate pd"><span>Design</span></td>
                                                <td class="rotate pd"><span>Mfg. eng.</span></td>
                                                <td class="rotate pd"><span>Purchase</span></td>
                                                <td class="rotate pd"><span>Quality</span></td>
                                                <td class="rotate pd"><span>Logistic</span></td>
                                                <td class="rotate pd"><span>Production</span></td>
                                                <td class="rotate pd"><span>PO & System</span></td>
                                                <td class="rotate pd"><span>Maintenance</span></td>
                                                <td class="rotate pd"><span>Customer</span></td>
                                                <td class="rotate pd"><span>Finance</span></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </th>
                        <th width="50" class="rotate"><span>Change Implementation<br>date</span></th>
                        <th width="50" class="rotate"><span>Before / After<br>Comprision</span></th>
                    </tr>
                    </thead>
                    <tbody id="checkboxex">
                    <?php

                    if(sizeof($data)>0){

                        $i=0;
                        foreach($data as $jobs){  ?>

                            <?php if(isset($jobs['customers'])&& !empty($jobs['customers'])){?>



                                <tr>

                                    <!------------New code below------------>



                                    <?php if($user_type==1){?>

                                        <td class="center-align">

                                            <?php
                                            if(isset($jobs['customers'])&& !empty($jobs['customers'])){





                                                foreach($jobs['customers'] as $customer){  ?>

                                                    <?php  if($customer['flag']==1){
                                                        $inputtag = 'checked';

                                                    }else
                                                    {$inputtag = 'checkbox';
                                                    }?>

                                                    <input type="checkbox" id="" class="default" value="<?=$jobs['request_id'];?>/<?=$customer['id'];?>" name="removeddata1[]" <?php echo $inputtag;?>/>
                                                    <input type="hidden" value="0" name="removeddata2">

                                                <?php } }?>


                                        </td>
                                    <?php }?>

                                    <!------------New code above------------>

                                    <td><?=++$i?>.</td>

                                    <td>
                                        <span ><?=$jobs['cmNo'];?></span>
                                    <span style="color:dodgerblue"><h5><?=$jobs['count_request_is_rejected'];?></span></h5></td>



                                    <td><?= $jobs['created_date'];?></td>
                                    <td><?= $jobs['Purpose_Modification_Details'];?></td>
                                    <td>

                                        <?php
                                        if(isset($jobs['customers'])&& !empty($jobs['customers']) && (count($jobs['customers']))>1){?>
                                            <ul class="listing bdr-btm no-pd">

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
                                            <ul class="listing bdr-btm no-pd">

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
                                    <td class="pd-none">


                                        <?php
                                        $k='';
                                        if(isset($jobs['customers'])&& !empty($jobs['customers'])){


                                            foreach($jobs['customers'] as $customer){
                                                 $aCustomerStatus=$customer['status'];

                                                ?>

                                                <table class="borderd-cell">
                                                    <tr>
                                                        <?php
                                                        //-------------dep0--------------
                                                       for($k=0;$k<=9;$k++){
                                                        if(isset($aCustomerStatus[$k]['user_dep'])){
                                                            ?>
                                                            <?php if(isset($aCustomerStatus[$k]['dep_1'])){
                                                                ?>
                                                                <td class="status <?php getlatestStatus($aCustomerStatus[$k]['user_dep'],$aCustomerStatus[$k]['hod_approved'])?>"><?php getlatestText($aCustomerStatus[$k]['user_dep'],$aCustomerStatus[$k]['hod_approved'])?>
                                                                </td>
                                                            <?php } else {?>
                                                                <td></td>
                                                            <?php }?>
                                                        <?php } }?>

                                                        



                                                    </tr>
                                                </table>


                                            <?php } }?>


                                    </td>
                                    <?php
                                    if(isset($jobs['customers'])&& !empty($jobs['customers'])){


                                        if(isset($customer['status_steering']['dep_'])){?>


                                            <td class="status <?=$customer['status_steering']['class_']?>"><?php echo $customer['status_steering']['text_']?></td>
                                        <?php } else {?>
                                            <td></td>
                                        <?php }?>


                                    <?php } ?>

                                    <?php
                                    if(isset($jobs['customers'])&& !empty($jobs['customers'])){


                                        if(isset($customer['customer_approval']['dep_'])){?>


                                            <td class="status <?=$customer['customer_approval']['class_']?>"><?php echo $customer['customer_approval']['text_']?></td>
                                        <?php } else {?>
                                            <td></td>
                                        <?php }?>


                                    <?php } ?>

                                    <?php
                                    if(isset($jobs['customers'])&& !empty($jobs['customers'])){


                                        if(isset($customer['customer_approval_status']['dep_'])){?>


                                            <td class="status <?=$customer['customer_approval_status']['class_']?>"><?php echo $customer['customer_approval_status']['text_']?></td>
                                        <?php } else {?>
                                            <td></td>
                                        <?php }?>


                                    <?php } ?>

                                    <td class="pd-none">

                                        <?php
                                        $k='';
                                        if(isset($jobs['customers'])&& !empty($jobs['customers'])){


                                            foreach($jobs['customers'] as $customer){
                                                $aCustomerStatus_2=$customer['status2'];
                                              //   echo '<pre>';
                                              //  print_r($aCustomerStatus_2);exit;

                                                /*   if(isset($customer['status']) && is_array($customer['status'])){
                                                       $aDone=array();
                                                       foreach($customer['status'] as $data){

                                                         //  echo '<pre>';
                                                         //  print_r($data);

                                                           if($data['class_1']!='--' && $data['class_1']!='yellow'){
                                                               array_push($aDone,$data['department']);
                                                           }

                                                       }

                                                   }*/


                                                ?>

                                                <table class="borderd-cell">
                                                    <tr>
                                                        <?php
                                                        //-------------dep0--------------
                                                        $j=0;
                                                        if(isset($aCustomerStatus_2[$j]['user_department'])){
                                                            ?>
                                                            <?php if(isset($aCustomerStatus_2[$j]['dep_1'])){
                                                                ?>
                                                                <td class="status <?php getlatestStatus_2($aCustomerStatus_2[$j]['user_department'],$aCustomerStatus_2[$j]['task_status'],$aCustomerStatus_2[$j]['date1'],$aCustomerStatus_2[$j]['date2'],$aCustomerStatus_2[$j]['admin_status'])?>">
                                                                    <?php getlatestText_2($aCustomerStatus_2[$j]['user_department'],$aCustomerStatus_2[$j]['task_status'],$aCustomerStatus_2[$j]['date1'],$aCustomerStatus_2[$j]['date2'],$aCustomerStatus_2[$j]['admin_status'])?>
                                                                </td>
                                                            <?php } else {?>
                                                                <td></td>
                                                            <?php }?>
                                                        <?php } ?>

                                                        <?php
                                                        //-------------dep1--------------
                                                        $j=1;
                                                        if(isset($aCustomerStatus_2[$j]['user_department'])){
                                                            ?>
                                                            <?php if(isset($aCustomerStatus_2[$j]['dep_1'])){
                                                                ?>
                                                                <td class="status <?php getlatestStatus_2($aCustomerStatus_2[$j]['user_department'],$aCustomerStatus_2[$j]['task_status'],$aCustomerStatus_2[$j]['date1'],$aCustomerStatus_2[$j]['date2'],$aCustomerStatus_2[$j]['admin_status'])?>">
                                                                    <?php getlatestText_2($aCustomerStatus_2[$j]['user_department'],$aCustomerStatus_2[$j]['task_status'],$aCustomerStatus_2[$j]['date1'],$aCustomerStatus_2[$j]['date2'],$aCustomerStatus_2[$j]['admin_status'])?>
                                                                </td>
                                                            <?php } else {?>
                                                                <td></td>
                                                            <?php }?>
                                                        <?php } ?>

                                                        <?php
                                                        //-------------dep2--------------
                                                        $j=2;
                                                        if(isset($aCustomerStatus_2[$j]['user_department'])){
                                                            ?>
                                                            <?php if(isset($aCustomerStatus_2[$j]['dep_1'])){
                                                                ?>
                                                                <td class="status <?php getlatestStatus_2($aCustomerStatus_2[$j]['user_department'],$aCustomerStatus_2[$j]['task_status'],$aCustomerStatus_2[$j]['date1'],$aCustomerStatus_2[$j]['date2'],$aCustomerStatus_2[$j]['admin_status'])?>">
                                                                    <?php getlatestText_2($aCustomerStatus_2[$j]['user_department'],$aCustomerStatus_2[$j]['task_status'],$aCustomerStatus_2[$j]['date1'],$aCustomerStatus_2[$j]['date2'],$aCustomerStatus_2[$j]['admin_status'])?>
                                                                </td>
                                                            <?php } else {?>
                                                                <td></td>
                                                            <?php }?>
                                                        <?php } ?>

                                                        <?php
                                                        //-------------dep3--------------
                                                        $j=3;
                                                        if(isset($aCustomerStatus_2[$j]['user_department'])){
                                                            ?>
                                                            <?php if(isset($aCustomerStatus_2[$j]['dep_1'])){
                                                                ?>
                                                                <td class="status <?php getlatestStatus_2($aCustomerStatus_2[$j]['user_department'],$aCustomerStatus_2[$j]['task_status'],$aCustomerStatus_2[$j]['date1'],$aCustomerStatus_2[$j]['date2'],$aCustomerStatus_2[$j]['admin_status'])?>">
                                                                    <?php getlatestText_2($aCustomerStatus_2[$j]['user_department'],$aCustomerStatus_2[$j]['task_status'],$aCustomerStatus_2[$j]['date1'],$aCustomerStatus_2[$j]['date2'],$aCustomerStatus_2[$j]['admin_status'])?>
                                                                </td>
                                                            <?php } else {?>
                                                                <td></td>
                                                            <?php }?>
                                                        <?php } ?>

                                                        <?php
                                                        //-------------dep4--------------
                                                        $j=4;
                                                        if(isset($aCustomerStatus_2[$j]['user_department'])){
                                                            ?>
                                                            <?php if(isset($aCustomerStatus_2[$j]['dep_1'])){
                                                                ?>
                                                                <td class="status <?php getlatestStatus_2($aCustomerStatus_2[$j]['user_department'],$aCustomerStatus_2[$j]['task_status'],$aCustomerStatus_2[$j]['date1'],$aCustomerStatus_2[$j]['date2'],$aCustomerStatus_2[$j]['admin_status'])?>">
                                                                    <?php getlatestText_2($aCustomerStatus_2[$j]['user_department'],$aCustomerStatus_2[$j]['task_status'],$aCustomerStatus_2[$j]['date1'],$aCustomerStatus_2[$j]['date2'],$aCustomerStatus_2[$j]['admin_status'])?>
                                                                </td>
                                                            <?php } else {?>
                                                                <td></td>
                                                            <?php }?>
                                                        <?php } ?>

                                                        <?php
                                                        //-------------dep5--------------
                                                        $j=5;
                                                        if(isset($aCustomerStatus_2[$j]['user_department'])){
                                                            ?>
                                                            <?php if(isset($aCustomerStatus_2[$j]['dep_1'])){
                                                                ?>
                                                                <td class="status <?php getlatestStatus_2($aCustomerStatus_2[$j]['user_department'],$aCustomerStatus_2[$j]['task_status'],$aCustomerStatus_2[$j]['date1'],$aCustomerStatus_2[$j]['date2'],$aCustomerStatus_2[$j]['admin_status'])?>">
                                                                    <?php getlatestText_2($aCustomerStatus_2[$j]['user_department'],$aCustomerStatus_2[$j]['task_status'],$aCustomerStatus_2[$j]['date1'],$aCustomerStatus_2[$j]['date2'],$aCustomerStatus_2[$j]['admin_status'])?>
                                                                </td>
                                                            <?php } else {?>
                                                                <td></td>
                                                            <?php }?>
                                                        <?php } ?>

                                                        <?php
                                                        //-------------dep6--------------
                                                        $j=6;
                                                        if(isset($aCustomerStatus_2[$j]['user_department'])){
                                                            ?>
                                                            <?php if(isset($aCustomerStatus_2[$j]['dep_1'])){
                                                                ?>
                                                                <td class="status <?php getlatestStatus_2($aCustomerStatus_2[$j]['user_department'],$aCustomerStatus_2[$j]['task_status'],$aCustomerStatus_2[$j]['date1'],$aCustomerStatus_2[$j]['date2'],$aCustomerStatus_2[$j]['admin_status'])?>">
                                                                    <?php getlatestText_2($aCustomerStatus_2[$j]['user_department'],$aCustomerStatus_2[$j]['task_status'],$aCustomerStatus_2[$j]['date1'],$aCustomerStatus_2[$j]['date2'],$aCustomerStatus_2[$j]['admin_status'])?>
                                                                </td>
                                                            <?php } else {?>
                                                                <td></td>
                                                            <?php }?>
                                                        <?php } ?>

                                                        <?php
                                                        //-------------dep7--------------
                                                        $j=7;
                                                        if(isset($aCustomerStatus_2[$j]['user_department'])){
                                                            ?>
                                                            <?php if(isset($aCustomerStatus_2[$j]['dep_1'])){
                                                                ?>
                                                                <td class="status <?php getlatestStatus_2($aCustomerStatus_2[$j]['user_department'],$aCustomerStatus_2[$j]['task_status'],$aCustomerStatus_2[$j]['date1'],$aCustomerStatus_2[$j]['date2'],$aCustomerStatus_2[$j]['admin_status'])?>">
                                                                    <?php getlatestText_2($aCustomerStatus_2[$j]['user_department'],$aCustomerStatus_2[$j]['task_status'],$aCustomerStatus_2[$j]['date1'],$aCustomerStatus_2[$j]['date2'],$aCustomerStatus_2[$j]['admin_status'])?>
                                                                </td>
                                                            <?php } else {?>
                                                                <td></td>
                                                            <?php }?>
                                                        <?php } ?>

                                                        <?php
                                                        //-------------dep8--------------
                                                        $j=8;
                                                        if(isset($aCustomerStatus_2[$j]['user_department'])){
                                                            ?>
                                                            <?php if(isset($aCustomerStatus_2[$j]['dep_1'])){
                                                                ?>
                                                                <td class="status <?php getlatestStatus_2($aCustomerStatus_2[$j]['user_department'],$aCustomerStatus_2[$j]['task_status'],$aCustomerStatus_2[$j]['date1'],$aCustomerStatus_2[$j]['date2'],$aCustomerStatus_2[$j]['admin_status'])?>">
                                                                    <?php getlatestText_2($aCustomerStatus_2[$j]['user_department'],$aCustomerStatus_2[$j]['task_status'],$aCustomerStatus_2[$j]['date1'],$aCustomerStatus_2[$j]['date2'],$aCustomerStatus_2[$j]['admin_status'])?>
                                                                </td>
                                                            <?php } else {?>
                                                                <td></td>
                                                            <?php }?>
                                                        <?php } ?>

                                                        <?php
                                                        //-------------dep9--------------
                                                        $j=9;
                                                        if(isset($aCustomerStatus_2[$j]['user_department'])){
                                                            ?>
                                                            <?php if(isset($aCustomerStatus_2[$j]['dep_1'])){
                                                                ?>
                                                                <td class="status <?php getlatestStatus_2($aCustomerStatus_2[$j]['user_department'],$aCustomerStatus_2[$j]['task_status'],$aCustomerStatus_2[$j]['date1'],$aCustomerStatus_2[$j]['date2'],$aCustomerStatus_2[$j]['admin_status'])?>">
                                                                    <?php getlatestText_2($aCustomerStatus_2[$j]['user_department'],$aCustomerStatus_2[$j]['task_status'],$aCustomerStatus_2[$j]['date1'],$aCustomerStatus_2[$j]['date2'],$aCustomerStatus_2[$j]['admin_status'])?>
                                                                </td>
                                                            <?php } else {?>
                                                                <td></td>
                                                            <?php }?>
                                                        <?php } ?>

                                                    </tr>
                                                </table>


                                            <?php } }?>

                                    </td>

                                    <?php
                                    if(isset($jobs['customers'])&& !empty($jobs['customers'])){


                                        if(isset($customer['change_implementation_data']['dep_'])){?>


                                            <td class="status <?=$customer['change_implementation_data']['class_']?>"><?php echo $customer['change_implementation_data']['text_']?></td>
                                        <?php } else {?>
                                            <td></td>
                                        <?php }?>


                                    <?php } ?>


                                    <?php
                                    if(isset($jobs['customers'])&& !empty($jobs['customers'])){


                                        if(isset($customer['before_after_comparison']['dep_'])){?>


                                            <td class="status <?=$customer['before_after_comparison']['class_']?>"><?php echo $customer['before_after_comparison']['text_']?></td>
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

            </div><!--/summary-table-->

            <?php if($user_type==1){?>
                <div class="action-group pd-top">
                    <!-- <button  type="submit" class="btn btn-animate flat blue pd-btn " name="filetype" value="remove">HIDE Selected(From Show Column)</button>

                     <button  type="submit" class="btn btn-animate flat blue pd-btn " name="filetype" value="show">SHOW Selected(From Hidden Column)</button>-->

                    <button  type="submit" class="btn btn-animate flat blue pd-btn " name="filetype" value="hide_data">Hide</button>

                </div>
            <?php }?>

            <!-- summary Table end -->

        </div><!--/content-wrapper-->

    </form>
</div><!--/s10-->
<?php require app_path().'/views/footer.php'; ?>


<script type="text/javascript">
    $(document).ready(function(){
        // alert();
        $("#checkall").click(function(){//alert();
            $("#checkboxex").find(":checkbox").attr("checked",this.checked);
        });
    })
</script>
