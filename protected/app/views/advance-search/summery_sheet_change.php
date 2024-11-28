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
                <h1>Summary Sheet </h1>
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
                <input type="hidden" name="r_id" value="<?=$formInput['r_id'];?>">
                    <input type="hidden" name="startdate" value="<?=$formInput['startdate'];?>">
                    <input type="hidden" name="enddate" value="<?=$formInput['enddate'];?>">
                    <input type="hidden" name="change_type" value="<?=$formInput['change_type'];?>">
                    <input type="hidden" name="change_stage_id" value="<?=$formInput['change_stage_id'];?>">
                    <input type="hidden" name="plantcode" value="<?=$formInput['plantcode'];?>">
                    <input type="hidden" name="purpose" value="<?=$formInput['purpose'];?>">
                    <input type="hidden" name="customer_id" value="<?=$formInput['customer_id'];?>">
                    <input type="hidden" name="projectcode" value="<?=$formInput['projectcode'];?>">



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
            <table>
            <tr>
            <td>
                <table class="striped">
                    <thead>
                    <tr class="tr-bdr">

                        <?php if($user_type==1){?>
                            <th width="40" class="rotate pd"><span>Hide</span><!--<input type="checkbox" id="checkall" class="default" />--></th>
                        <?php  } ?>

                          <?php $cnt=0;
                                foreach ($allDepartment as $row) {
                                        $cnt++;
                                 } 
                                $width=$cnt*40;?>




                        <th width="50">Sr. No.</th>
                        <th width="100">CM No.</th>
                        <th width="150">Change req. date</th>
                        <th width="350">Description of Change</th>
                        <th width="200">Customers</th>
                        <th width="100">Proposed Implementation Date</th>
                        <th width="100">Actual Implementation Date</th>
                        <th width="200">Initiator Name</th>
                       
                    </tr>
                    </thead>
                    <tbody id="checkboxex">
                    <?php

                    if(sizeof($data)>0){

                        $i=0;
                        foreach($data as $jobs){  ?>

                            <?php if(isset($jobs['customers'])&& !empty($jobs['customers'])){?>



                                

                            <?php }  }  }else{?>
                        <tr>
                            No Records Found.

                        </tr>
                    <?php }?>
                    </tbody>
                </table>
                </td>
                <td>
                <table class="striped">
                    <thead>
                    <tr class="tr-bdr">

                        <?php if($user_type==1){?>
                            <th width="40" class="rotate pd"><span>Hide</span><!--<input type="checkbox" id="checkall" class="default" />--></th>
                        <?php  } ?>

                          <?php $cnt=0;
                                foreach ($allDepartment as $row) {
                                        $cnt++;
                                 } 
                                $width=$cnt*40;?>




                       
                        <th width="<?php echo $width; ?>" class="rotate pd-none">
                        <table>
                                <tr class="border-bottom">
                                    <td class="center-align">Risk Analysis</td>        
                                </tr>
                                <tr>
                                    <td class="pd-none">
                                        <table class="borderd-cell">
                                            <tr>
                                         <?php $cnt=0;
                                                foreach ($allDepartment as $row) { $cnt++;?>
                                             <td class="rotate pd"><span><?php echo $row->d_name; ?></span></td>
                                           <?php } ?> 
                                                             
                                         
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </th>
                        <th width="50" class="rotate"><span>COO Approval<span></th>
                        <th width="50" class="rotate"><span>Steering Committee Approval<span></th>
                        <th width="50" class="rotate"><span>Customer Approval Status<span></th>
                        <!-- <th width="50" class="rotate"><span>Customer Approval<br> Status<span></th> -->
                        <th width="<?php echo $width;?>" class="rotate pd-none">
                            <table>
                                <tr class="border-bottom">
                                    <td class="center-align">Activity Status</td>
                                </tr>
                                <tr>
                                    <td class="pd-none">
                                        <table class="borderd-cell">
                                            <tr>
                                              
                                            <?php foreach ($allDepartment as $row) {?>
                                             <td class="rotate pd"><span><?php echo $row->d_name; ?></span></td>
                                           <?php } ?>
                                                     
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </th>
                        <th width="50" class="rotate"><span>Document Verification Status</span></th>
                        <th width="50" class="rotate"><span>Change Implementation date</span></th>
                        <th width="50" class="rotate"><span>Before / After Comparision</span></th>
                        <th width="50" class="rotate"><span>Final Closer Status</span></th>
                    </tr>
                    </thead>
                    </table>
                </td>
                </tr>
                <tr>
                 <?php

                    if(sizeof($data)>0){

                        $i=0;
                        foreach($data as $jobs){  ?>

                           ?>


<?php } } ?>
                </tr>
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
