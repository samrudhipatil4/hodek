<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>


<style>

table {
    border-collapse: collapse;
}
table tr{
    padding:0;
}

tr,td,th{
  border:1px solid #000;
}

.sub-table, .sub-table td  {
    border: none;
}
.sub-table tr{
height:58px;
}
.sub-table .border-button{
    border-collapse: collapse;
    border-bottom: 1px solid #000;
    width:100%;
  }
.vertical{
-webkit-transform:rotate(-90deg);
    -moz-transform:rotate(-90deg);
    -o-transform: rotate(-90deg);
    -ms-transform:rotate(-90deg);
    transform: rotate(-90deg);
}
.table-heading{
    height: 117px;
}
.red-background{
background-color:#00bfff;
    color: #00bfff;

}
.red1-background{
background-color:#ff0000;
    color: #ff0000;

}
.green-background{
background-color:green; 
 color: green;
}
.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{
padding:0 !important;
}
.sub-table>tbody>tr>td, .sub-tabletable>tbody>tr>th, .sub-tabletable>tfoot>tr>td, .sub-table>tfoot>tr>th, .sub-table>thead>tr>td, .sub-table>thead>tr>th{
    padding:0 !important;
    display: block;
    height: 61px;
    vertical-align:middle;
}
.same-color-bdr{
    border-right:1px solid #008000 !important;
}
</style>

</head>

<body>
<div class="container">
<div class="col-md-12">
  <div class="col-md-4"><h4>
    <img src="<?php echo Request::root().'/uploads/logos/'.$project_details->logo_image; ?>"  alt="CM Logo">
  </h4>
 </div>
 </div>
    <div class="col-md-12">
  <div class="col-md-4">
    <h5><span style="font-weight: bold;">Project NO : </span><?php 

    echo $project_details->project_no.' Revision '.$project_details->project_revision.' '. $project_details->checkHold; ?></h5>
    <h5><span style="font-weight: bold;">Project Name : </span><?php echo $project_details->project_name ?></h5>
    <h5><span style="font-weight: bold;">Manufacturing Location :</span> <?php echo $project_details->description ?></h5>
    <h5><span style="font-weight: bold;">Project Start Date :</span> <?php echo $project_details->date ?></h5>
    <h5><span style="font-weight: bold;">Project End Date : </span><?php echo date('d F Y',strtotime($project_details->EndDate)); ?></h5>
    <h5><span style="font-weight: bold;">Document Number : </span><?php echo $project_details->document_no; ?></h5>
    <h5><span style="font-weight: bold;">Project Lead and Top Management Approval :</span> <?php echo $project_details->top_app; ?></h5>
    <h5><span style="font-weight: bold;">Customer :</span> <?php echo $project_details->cust; ?></h5>
   <h5><span style="font-weight: bold;">Enquiry Number :</span><?php foreach($enquiry as $key=>$value){ echo $value->enquiry_no; ?></h5>
   <h5><span style="font-weight: bold;">Enquiry Date :</span> <?php echo $value->enquiry_date; ?></h5>
   <h5><span style="font-weight: bold;">Customer Revision Number:</span> <?php echo $value->cust_rev; ?></h5>
   <h5><span style="font-weight: bold;">Customer Part Number :</span> <?php echo $value->cust_part_no; ?></h5>
   <h5><span style="font-weight: bold;">Customer Contact Person :</span> <?php  echo $value->cust_cont_person; ?></h5>
   <h5><span style="font-weight: bold;">Customer contact Number :</span> <?php  echo $value->cust_person_no; ?></h5>
   <h5><span style="font-weight: bold;">Customer Person Email :</span> <?php echo $value->cust_person_email; ?></h5>
   <h5><span style="font-weight: bold;">Engine Details :</span> <?php  echo $value->engine_details; ?></h5>
   <h5><span style="font-weight: bold;">Engine Application Details :</span> <?php  echo $value->engine_appl_details; ?></h5>
   <h5><span style="font-weight: bold;">Similar Product Mfg :</span> <?php  echo $value->similar_product_mfg; ?></h5>
   <h5><span style="font-weight: bold;">Internal Customer Name :</span> <?php  echo $value->internal_cust; ?></h5>
   <h5><span style="font-weight: bold;">Estimated Cost Of Damper :</span> <?php  echo $value->estimated_cost; } ?></h5>
   
   <?php
    if(!empty($project_details->checkDrop)){
    $check = $project_details->checkDrop;  ?>
     <h5><span style="font-weight: bold;">Project is dropped by :</span> <?php echo $check->first_name.' '.$check->last_name;  ?></h5>
     <h5><span style="font-weight: bold;">Remark :</span> <?php echo $check->remark; } ?></h5>
     <h5><span style="font-weight: bold;">Proposal Deadline :</span><?php foreach($enquiry as $key=>$value){ echo $value->deadline; ?></h5>
    <h5><span style="font-weight: bold;">Annual Volume YR1 :</span> <?php echo $value->annual_volY1; ?></h5>
    <h5><span style="font-weight: bold;">Annual Volume YR2 :</span> <?php echo $value->annual_volY2; ?></h5>
    <h5><span style="font-weight: bold;">Annual Volume YR3 :</span> <?php echo $value->annual_volY3; ?></h5>
    <h5><span style="font-weight: bold;">Annual Volume YR4 :</span> <?php echo $value->annual_volY4; ?></h5>
    <h5><span style="font-weight: bold;">Annual Volume YR5 :</span> <?php echo $value->annual_volY5; ?></h5>
    <h5><span style="font-weight: bold;">Prototype Sample :</span> <?php echo $value->proto_sample; }?></h5>

    </div>
<div class="col-md-4">
 <?php $data = $project_details->ActivityDate;?>

    <h5><span style="font-weight: bold;">Hour Event</span> </h5>
    <h5><span style="font-weight: bold;">SOP Date :</span> <?php if($project_details->sop_date != '0000-00-00'){ echo date('d F Y',strtotime($project_details->sop_date)); } ?></h5>
    <h5><span style="font-weight: bold;">Part Number : </span><?php echo $project_details->part_no ?></h5>
    <!-- <h5><span style="font-weight: bold;">Engine Details : </span><?php echo $project_details->engine_details ?></h5>
    <h5><span style="font-weight: bold;">Engine Application Details : </span><?php echo $project_details->engine_appl_details ?></h5> -->
    <h5><span style="font-weight: bold;">Annual Volume Data : </span><?php echo $project_details->annual_vol_data ?></h5>
    <h5><span style="font-weight: bold;">Prototype Date :</span> <?php foreach ($enquiry as $key=>$value) { echo $value->proto_date; ?></h5>
   <h5><span style="font-weight: bold;">PILOT Batch :</span> <?php echo $value->pilot_batch; ?></h5>
    <h5><span style="font-weight: bold;">PILOT Date:</span> <?php echo $value->pilot_date; ?></h5>
   <h5><span style="font-weight: bold;">PPAP Batch :</span> <?php echo $value->ppap_batch; ?></h5>
   <h5><span style="font-weight: bold;">PPAP Date :</span> <?php echo $value->ppap_date; ?></h5>
  <h5><span style="font-weight: bold;">SOP Date :</span> <?php echo $value->sop_date; ?></h5>
 <h5><span style="font-weight: bold;">Packaging :</span> <?php echo $value->packaging; ?></h5>
 <h5><span style="font-weight: bold;">Labeling :</span> <?php echo $value->labeling; ?></h5>
  <h5><span style="font-weight: bold;">Painting :</span> <?php echo $value->painting; ?></h5>
  <h5><span style="font-weight: bold;">Any Other :</span> <?php echo $value->any_other; ?></h5>
  <h5><span style="font-weight: bold;">Engine Data Sheet :</span> <?php echo $value->engine_data; ?></h5>
 <h5><span style="font-weight: bold;">Customer Specific Requirement
 :</span> <?php echo $value->specific_req; ?></h5>
 <h5><span style="font-weight: bold;">SOP Quantity
 :</span> <?php echo $value->sop_quantity; ?></h5>
  <h5><span style="font-weight: bold;">Customer Interview :</span> <?php echo $value->cust_interview; ?></h5>
  <h5><span style="font-weight: bold;">Name of the Interviewee
 :</span> <?php echo $value->name_interview; ?></h5>
 <h5><span style="font-weight: bold;">Name of the Interviewer :</span> <?php echo $value->name_interviewer; ?></h5>
  <h5><span style="font-weight: bold;">Inputs/Data Collected :</span> <?php echo $value->input_data; ?></h5>
 <h5><span style="font-weight: bold;">Competitors Name :</span> <?php echo $value->competitors; ?></h5>
  <h5><span style="font-weight: bold;">Product Name :</span> <?php echo $value->product_name; ?></h5>
  <h5><span style="font-weight: bold;">Product & Quality Information :</span> <?php echo $value->product_quality; ?></h5>
 <h5><span style="font-weight: bold;">TGR Reports :</span> <?php echo $value->tgr_report; ?></h5>
<h5><span style="font-weight: bold;">TGW Product/Name :</span> <?php echo $value->tgw_product_name; ?></h5>
<h5><span style="font-weight: bold;">Discrepancy Observed:</span> <?php echo $value->discrepancy; } ?></h5>


</div>
<div class="col-md-4">
    <h5><span style="font-weight: bold;">Customer Event</span></h5>
    <h5><span style="font-weight: bold;">Part Number : </span><?php echo $project_details->cust_part_no ?></h5>
    <h5><span style="font-weight: bold;">Prototype Quantity : </span><?php echo $project_details->cust_proto_qty ?></h5>
    <h5><span style="font-weight: bold;"> Prototype Date : </span><?php if($project_details->cust_proto_date != '0000-00-00'){ echo date('d F Y',strtotime($project_details->cust_proto_date)); } ?></h5>
    <h5><span style="font-weight: bold;">PPAP Quantity : </span><?php echo $project_details->cust_ppap_qty ?></h5>
    <h5><span style="font-weight: bold;"> PPAP Date : </span><?php if($project_details->cust_ppap_date != '0000-00-00'){ echo date('d F Y',strtotime($project_details->cust_ppap_date)); } ?></h5>
    <h5><span style="font-weight: bold;"> SOP Date : </span><?php if($project_details->cust_sop_date != '0000-00-00'){ echo date('d F Y',strtotime($project_details->cust_sop_date)); } ?></h5>

<h5><span style="font-weight: bold;">Probable Causes for Discrepancy :</span><?php foreach($enquiry as $key=>$value){ echo $value->cause_discrepancy; ?></h5>
<h5><span style="font-weight: bold;">Customer plant returns & Rejection:</span> <?php echo $value->return_reject; ?></h5>
<h5><span style="font-weight: bold;">Field return Product Analysis:</span> <?php echo $value->field_return; ?></h5>
<h5><span style="font-weight: bold;">Customer Letters/suggestion :</span> <?php echo $value->cust_suggestions; ?></h5>
<h5><span style="font-weight: bold;">Field service reports :</span> <?php echo $value->service_report; ?></h5>
<h5><span style="font-weight: bold;">Transportation & Primiunm Freight :</span> <?php echo $value->transportation; ?></h5>
<h5><span style="font-weight: bold;">Goverment requirements & regulations :</span> <?php echo $value->requirement_regulation; ?></h5>
<h5><span style="font-weight: bold;">Problems & issues Report from Internal customer :</span> <?php echo $value->internal_custo; ?></h5>
<h5><span style="font-weight: bold;">TGR / TGW :</span> <?php echo $value->tgr_tgw; ?></h5>
<h5><span style="font-weight: bold;">Time constriants  :</span> <?php echo $value->time_constriants; ?></h5>
<h5><span style="font-weight: bold;">Cost constraint:</span> <?php echo $value->cost_constraint; ?></h5>
<h5><span style="font-weight: bold;">Investment:</span> <?php echo $value->investment; ?></h5>
<h5><span style="font-weight: bold;">key competitors :</span> <?php echo $value->key_competitor; ?></h5>
<h5><span style="font-weight: bold;">Performance  :</span> <?php echo $value->performance; ?></h5>
<h5><span style="font-weight: bold;">Cost :</span> <?php echo $value->cost; ?></h5>
<h5><span style="font-weight: bold;">New Technology:</span> <?php echo $value->n_techno; ?></h5>
<h5><span style="font-weight: bold;">New resources :</span> <?php echo $value->new_resources; ?></h5>
<h5><span style="font-weight: bold;">Risk Management Analysis :</span> <?php echo $value->risk_mgmt; } ?></h5>
</div>
  </div>
<div class="col-md-12">
<div class="table-container">


<table class="table table-responsive table-bordered">
<?php for( $i = 1 ;$i<= count($total_date_array_all);$i++){
  ?>
    <tr><td colspan="98" style="text-align:center;height:50px;background-color:#ccc"></td></tr>
    <tr class="table-heading">
    <th>Sr.No</th>
    <th>Gate</th> 
    <th>Activity</th>
    <th>Responsibility</th>
    <th>Remark</th>
                    <th>Attachment File</th>
                    <th>Dependent Activity</th>
                    <th>Dependent Phase</th>
     <th></th>
     <th>Duration</th>
     <th>Activity<br> Start Date</th>
     <th>Activity<br> End Date</th>
     <?php for($j=0;$j<count($total_date_array_all[$i]);$j++){ ?>
     <th class=""><?php echo date('d',strtotime($total_date_array_all[$i][$j])); 
                     ?> - <?php echo date('d M Y',strtotime($total_date_array_all[$i][$j]."+6 days")); 
                     ?></th>
    
     <?php } ?>
     </tr>
        
  <?php
    $pgate = '';
     $pregate ='';
    $premat='';
 
    for($k = 0;$k<count($all_data[$i]);$k++){
    $ngate = $all_data[$i][$k]['gate_id'];
                  if($ngate != $pgate){ ?>
                     <tr style="height: 71px" class="left-table-bdr-top"><td  colspan="6" style="font-weight:bold;"><?php echo 'Phase '.$all_data[$i][$k]['gate_id'].' '.$all_data[$i][$k]['Gate_Description'];?></td></tr>
                   <?php $i2 = 1;
                  }
                  $pgate = $ngate;
   ?>
   <?php if($all_data[$i][$k]['material_id'] == 0){?>      
    <tr>
    <td ><?php echo $all_data[$i][$k]['gate_id'].'.'.$i2; ?></td>
    <td ><?php echo $all_data[$i][$k]['Gate_Description'] ?></td>
    <td ><?php echo $all_data[$i][$k]['activityName'] ?></td>
    <td><?php foreach($responsibility as $key=>$user){ 
                if( $user->activity_name  == $all_data[$i][$k]['activityName']){
                  echo $user->username;
                }
                          } ?>
    </td>
    <td><?php foreach($remark as $key=>$value){?>
          <?php if( $value->activity ==$all_data[$i][$k]['activityName']){
            echo $value->remark;
           }?>
        <?php }?>
    </td>
    <td><?php foreach($upload_doc as $key=>$val){?>
          <?php 
            if($val->activity == $all_data[$i][$k]['activityName']){
              echo $val->upload_doc;
               if(!empty($val->upload_doc)){?><a href="<?php echo Request::root().'/download?path=apqp_activity_document&filename='.$val->upload_doc;?>" data-position="bottom" data-delay="50" data-tooltip="Download"><i class="glyphicon glyphicon-download-alt"></i><?php echo '<br>';?></a><?php } ;        
            }?> 
        <?php }?>
    </td>
    <td><?php foreach($refer as $key=>$value){ 
          //dd($value);
          if( $value->refActivity != NULL){
            if($value->activity == $all_data[$i][$k]['activityName']){
              echo $value->refActivity;
            }
         }
        }?>
    </td>
    <td><?php foreach($refer as $key=>$value){ 
          //dd($value);
          if( $value->refActivity != NULL){
            if($value->activity == $all_data[$i][$k]['activityName']){
              echo $all_data[$i][$k]['Gate_Description'];
            }
         }
        }?>
    </td>
    <td>
        <table class="sub-table" width="100%">
          <tr><td class="border-button">Plan</td></tr>
          <tr><td>Actual</td></tr>
        </table>
    </td>
    <td>
        <table class="sub-table" width="100%">
          <tr><td class="border-button"><?php echo $all_data[$i][$k]['lead_time']; ?></td></tr>
          <tr><td><?php echo $all_data[$i][$k]['actual_duaration']; ?></td></tr>
        </table>
    </td>
    <td>
        <table class="sub-table" width="100%">
          <tr><td class="border-button"><?php echo $all_data[$i][$k]['plan_start_date'] ?></td></tr>
          <tr><td><?php echo $all_data[$i][$k]['actual_start_date'] ?></td></tr>
        </table>
    </td>
    <td>
        <table class="sub-table" width="100%">
          <tr><td class="border-button"><?php echo  $all_data[$i][$k]['plan_end_date'] ?></td></tr>
          <tr><td><?php echo $all_data[$i][$k]['actual_end_date'] ?></td></tr>
        </table>
    </td>
       <?php 
    $activity_row = $all_data[$i][$k]['activity_date'];

    $count = 1;
    for($l = 0;$l<count($activity_row);$l++){?>
     <td >
        <table class="sub-table" width="100%">
        
          <?php 
          
          for($m =0;$m<count($activity_row[$l]);$m++){?>
            <tr><td class="<?php echo $m==0 ?'border-button':''; ?> <?php echo $m==0 && $activity_row[$l]['plan'] == 1 ? 'red-background':($m==1 && $activity_row[$l]['actual'] == 1?( strtotime($all_data[$i][$k]['actual_end_date']) > strtotime($all_data[$i][$k]['plan_end_date']) )?'red1-background':'green-background':'') ;?>"></td></tr>
          
          <?php 
        } ?>
          <!--  <tr><td class=""></td></tr> -->
           
          
        </table>
    </td>
    <?php $count++; } 
     // for($p = 0;$p< (60-$count);$p++){
    ?>

   
<?php //} ?>

         
    </tr>
    <?php }else{

      $mat = DB::table('apqp_material_master')
                          ->select('material_description')
                          ->where('id',$all_data[$i][$k]['material_id'])
                          ->get();
                          $newmat = $all_data[$i][$k]['material_id'];
                  if($ngate != $pregate || $newmat != $premat){ ?>
                   <tr style="height: 71px" class="left-table-bdr-top"><td  colspan="6" style="font-weight:bold;"><?php echo $mat[0]->material_description;?></td></tr>

                  <?php } $premat=$newmat;
                  $pregate=$ngate;
                  ?>
      <tr>
    <td ><?php echo $all_data[$i][$k]['gate_id'].'.'.$i2; ?></td>
    <td ><?php echo $all_data[$i][$k]['Gate_Description'] ?></td>
    <td ><?php echo $all_data[$i][$k]['activityName'] ?></td>
    <td><?php foreach($responsibility as $key=>$user){ 
                if( $user->activity_name  == $all_data[$i][$k]['activityName']){
                  echo $user->username;
                }
                          } ?>
    </td>
    <td><?php foreach($remark as $key=>$value){?>
          <?php if( $value->activity ==$all_data[$i][$k]['activityName']){
            echo $value->remark;
           }?>
        <?php }?>
    </td>
    <td><?php foreach($upload_doc as $key=>$val){?>
          <?php 
            if($val->activity == $all_data[$i][$k]['activityName']){
              echo $val->upload_doc;
               if(!empty($val->upload_doc)){?><a href="<?php echo Request::root().'/download?path=apqp_activity_document&filename='.$val->upload_doc;?>" data-position="bottom" data-delay="50" data-tooltip="Download"><i class="glyphicon glyphicon-download-alt"></i><?php echo '<br>';?></a><?php } ;        
            }?> 
        <?php }?>
    </td>
    <td><?php foreach($refer as $key=>$value){ 
          //dd($value);
          if( $value->refActivity != NULL){
            if($value->activity == $all_data[$i][$k]['activityName']){
              echo $value->refActivity;
            }
         }
        }?>
    </td>
    <td><?php foreach($refer as $key=>$value){ 
          //dd($value);
          if( $value->refActivity != NULL){
            if($value->activity == $all_data[$i][$k]['activityName']){
              echo $all_data[$i][$k]['Gate_Description'];
            }
         }
        }?>
    </td>
    <td>
        <table class="sub-table" width="100%">
          <tr><td class="border-button">Plan</td></tr>
          <tr><td>Actual</td></tr>
        </table>
    </td>
    <td>
        <table class="sub-table" width="100%">
          <tr><td class="border-button"><?php echo $all_data[$i][$k]['lead_time']; ?></td></tr>
          <tr><td><?php echo $all_data[$i][$k]['actual_duaration']; ?></td></tr>
        </table>
    </td>
    <td>
        <table class="sub-table" width="100%">
          <tr><td class="border-button"><?php echo $all_data[$i][$k]['plan_start_date'] ?></td></tr>
          <tr><td><?php echo $all_data[$i][$k]['actual_start_date'] ?></td></tr>
        </table>
    </td>
    <td>
        <table class="sub-table" width="100%">
          <tr><td class="border-button"><?php echo  $all_data[$i][$k]['plan_end_date'] ?></td></tr>
          <tr><td><?php echo $all_data[$i][$k]['actual_end_date'] ?></td></tr>
        </table>
    </td>
       <?php 
    $activity_row = $all_data[$i][$k]['activity_date'];

    $count = 1;
    for($l = 0;$l<count($activity_row);$l++){?>
     <td >
        <table class="sub-table" width="100%">
        
          <?php 
          
          for($m =0;$m<count($activity_row[$l]);$m++){?>
            <tr><td class="<?php echo $m==0 ?'border-button':''; ?> <?php echo $m==0 && $activity_row[$l]['plan'] == 1 ? 'red-background':($m==1 && $activity_row[$l]['actual'] == 1?( strtotime($all_data[$i][$k]['actual_end_date']) > strtotime($all_data[$i][$k]['plan_end_date']) )?'red1-background':'green-background':'') ;?>"></td></tr>
          
          <?php 
        } ?>
          <!--  <tr><td class=""></td></tr> -->
           
          
        </table>
    </td>
    <?php $count++; } 
     // for($p = 0;$p< (60-$count);$p++){
    ?>

   
<?php //} ?>

         
    </tr>
    <?php } ?>
    <?php $i2++;} ?>
    
<?php } ?>
</table>
</div>
</div>
</div>
</body>
</html>
