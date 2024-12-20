<!doctype html>
<html>
<head>
<meta charset="utf-8">

<?php require app_path().'/views/apqp_header.php'; ?>

<script type="text/javascript" src="<?php echo Request::root(); ?>/protected/public/js/jquery.min.js"></script>


 <script type="text/javascript" src="<?php echo Request::root(); ?>/protected/public/js/bootstrap-dropdown.js"></script>

<style>
.green-background{
background-color:#00bfff; 
}
.blue-background{
  background-color:#009933;
}
.red-background{
  background-color:#ff0000;
}
.left-table-container{
overflow-y:auto;  
}
.right-table-container{
overflow-y:auto;  
}
.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
    padding:0;
    vertical-align: top;
    border-top:none;
}
.table>thead>tr>th {
    vertical-align:top;
    border-bottom:none;
  height:90px;
}
.table>tbody>tr{
height:71px;  
}
.only-top-bdr{
border-top:1px solid #000;  
}
.bdr-left{
border-left:1px solid #000; 
}
.sub-table>tbody>tr{
border-bottom:1px solid #000;
height:45px;
border-right:1px solid #000;
width: 58px;
    display: block;
text-align:center;  
}
.bdr-top{
border-top:1px solid #000;  
}
.table>thead>tr{
  border-top:1px solid #000;
}
.table>thead>tr>th{
  border-right:1px solid #000;
}
/*left-table*/
.left-table-container>.table>tbody>tr{
border-bottom:1px solid #000;
height: 90px;
}
.left-table-container>.table>tbody>tr>td{
  border-left:1px solid #000;
font-size: 12px;
}
.left-table-bdr-top{
border-top:1px solid #000;
vertical-align:middle;  
}
.left-sub-table{
width:100%; 
}
.left-sub-table>tbody>tr{
  height:45px;
  display:block;
}
.bdr-only-top{
  border-top:1px solid #000;
}
.right-table>tbody>tr{
border-top:1px solid #000;
border-right:1px solid #000;  
}
.right-table>tbody>tr:last-child{
border-bottom:1px solid #000; 
}
.left-table-boder-right{
  border-right: 1px solid #000;
}

.container-fluid{
  width:100%;
}
.left-side-div{
  width:60%;
}
.right-side-div{
  width:40%;
}

</style>
</head>

<body>
<div class="container-fluid">
<div class="row">
        <div class="col-sm-8">
            <div class="page-heading">
                <h1 style="font-size: 24px;
    font-family: cursive;">Gantt Chart</h1>
            </div><!--/page-heading-->
        </div>
         <div class="col-sm-4">
            <div class="page-heading pull-right">
                <a class="btn btn-animate flat blue pd-btn" href="<?php echo Request::root().'/ganttChart'; ?>">Back To Search</a>
            </div><!--/page-heading-->
        </div>
    </div>

  <div class="col-md-12">
    <div class="col-md-8">
     <a class="btn btn-animate flat blue pd-btn" href="{{ url('pdfMonthly/') }}{{'/'.$project_details->id;}}">PDF Download</a>
     <a class="btn btn-animate flat blue pd-btn" href="{{ url('excelMonthly/') }}{{'/'.$project_details->id;}}">Excel Download</a>
  </div>
    <!-- <div class="col-md-2" style="margin-left: 223px;">
      <a class="btn btn-animate flat blue pd-btn" href="<?php echo Request::root().'/ganttChart'; ?>">Back To Search</a>
    </div> -->
    </br></br>
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

  </div>
  <div class="col-md-5 col-sm-6 xol-xs-6 left-side-div" style="padding-right:0;">
      <div class="left-table-container">
            <table class="table bdr-left-table left-table-boder-right"> 
              <thead>              
                <tr>
                    <th class="bdr-left">Sr.No</th>
                    <th  align="center">Gate</th>
                    <th align="center">Activity</th>
                    <th>Responsibility</th>
                    <th>Remark</th>
                    <th>Attachment File</th>
                    <th>Dependent Activity</th>
                    <th>Dependent Phase</th>
                    <th></th>
                    <th>Duration</th>
                    <th>Activity Start Date</th>
                    <th>Activity End Date</th>
                </tr> 
            </thead> 
              <?php 
                 $key = 1;
                 $get_id = '';
                 $pregate ='';
                $premat='';
                $pgate = '';
                 foreach($activities as $z=>$row){
                  $ngate = $row->gate_id;
                  if($ngate != $pgate){
                     ?>
                    <tr style="height: 71px" class="left-table-bdr-top"><td  colspan="8" style="font-weight:bold;"><?php echo 'Phase '.$row->gate_id.' '.$row->Gate_Description;?></td></tr>
                    <?php }
                    $pgate = $ngate;
                  if($z != 0)
                  {
                    if($get_id != $row->gate_id)
                      $key = 1;
                  }
              ?>     
              <?php if($row->material_id == 0){?>        
                <tr class="left-table-bdr-top">
                    <td><?php echo $row->gate_id.'.'.$key ?></td>
                    <td><?php echo $row->Gate_Description ?></td>
                    <td style="white-space: nowrap;"><?php echo $row->activityName ?></td>
                    <td><?php foreach($responsibility as $key=>$user){ 
                      if( $user->activity_name  == $row->activityName){
                        echo $user->username;
                      }
                }?>
          </td>
          <td>
            <?php foreach($remark as $key=>$value){?>
            <?php if( $value->activity ==$row->activityName){
              echo $value->remark;
           }?>
         <?php }?>
        </td>
          <td>
             <?php foreach($upload_doc as $key=>$val){?>
            <?php 
           if($val->activity == $row->activityName){
               echo $val->upload_doc;
            if(!empty($val->upload_doc)){?><a href="<?php echo Request::root().'/download?path=apqp_activity_document&filename='.$val->upload_doc;?>" data-position="bottom" data-delay="50" data-tooltip="Download"><i class="glyphicon glyphicon-download-alt"></i><?php echo '<br>';?></a><?php } ; 
          }
            ?> 
          <?php }?>
        </td>
        <td style="white-space: nowrap;"><?php foreach($refer as $key=>$value){ 
          //dd($value);
          if( $value->refActivity != NULL){
            if($value->activity == $row->activityName){
            echo $value->refActivity;
          }
           }
            }?>
        </td>
        <td>
          <?php foreach($refer as $key=>$value){ 
            //dd($value);
            if( $value->refActivity != NULL){
              if($value->activity == $row->activityName){
              echo $row->Gate_Description;
            }
             }
              }?>
        </td>
          <td>
                      <table class="left-sub-table">
                          <tr>
                              <td>plan</td>
                            </tr>
                            <tr class="bdr-only-top">
                              <td>Actual</td>
                            </tr>
                        </table>
                    </td>
                    <td>
                      <table class="left-sub-table">
                          <tr>
                              <td align="center"><?php echo $row->lead_time; ?></td>
                            </tr>
                            <tr class="bdr-only-top" >
                              <td><?php echo $row->actual_duaration; ?></td>
                            </tr>
                        </table>
                    </td>
                     <td>
                      <table class="left-sub-table">
                          <tr>
                              <td><?php echo date('d M Y',strtotime($row->plan_start_date)); ?></td>
                            </tr>
                            <tr class="bdr-only-top">
                              <td><?php if($row->actual_start_date != ""){
                                  echo date('d M Y',strtotime($row->actual_start_date));
                                } ?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                      <table class="left-sub-table">
                          <tr>
                              <td><?php echo date('d M Y',strtotime($row->plan_end_date)); ?></td>
                            </tr>
                            <tr class="bdr-only-top">
                              <td><?php if($row->actual_end_date != ""){
                                echo date('d M Y',strtotime($row->actual_end_date));
                              }
                               ?></td>
                            </tr>
                        </table>
                    </td>
                </tr> 
                <?php }else{ 
                   $mat = DB::table('apqp_material_master')
                          ->select('material_description')
                          ->where('id',$row->material_id)
                          ->get();
                          $newmat = $row->material_id;
                  if($ngate != $pregate || $newmat != $premat){ ?>
                   <tr style="height: 71px" class="left-table-bdr-top"><td  colspan="6" style="font-weight:bold;"><?php echo $mat[0]->material_description;?></td></tr>

                  <?php } $premat=$newmat;
                  $pregate=$ngate;
                  ?>
                <tr class="left-table-bdr-top">
                    <td><?php echo $row->gate_id.'.'.$key ?></td>
                    <td><?php echo $row->Gate_Description ?></td>
                  <td style="white-space: nowrap;"><?php echo $row->activityName ?></td>
                    <td><?php foreach($responsibility as $key=>$user){ 
                      if( $user->activity_name  == $row->activityName){
                        echo $user->username;
                      }
                }?>
          </td>
          <td>
            <?php foreach($remark as $key=>$value){?>
            <?php if( $value->activity ==$row->activityName){
              echo $value->remark;
           }?>
         <?php }?>
        </td>
          <td>
             <?php foreach($upload_doc as $key=>$val){?>
            <?php 
           if($val->activity == $row->activityName){
               echo $val->upload_doc;
            if(!empty($val->upload_doc)){?><a href="<?php echo Request::root().'/download?path=apqp_activity_document&filename='.$val->upload_doc;?>" data-position="bottom" data-delay="50" data-tooltip="Download"><i class="glyphicon glyphicon-download-alt"></i><?php echo '<br>';?></a><?php } ; 
          }
            ?> 
          <?php }?>
        </td>
        <td style="white-space: nowrap;"><?php foreach($refer as $key=>$value){ 
          //dd($value);
          if( $value->refActivity != NULL){
            if($value->activity == $row->activityName){
            echo $value->refActivity;
          }
           }
            }?>
        </td>
        <td>
          <?php foreach($refer as $key=>$value){ 
            //dd($value);
            if( $value->refActivity != NULL){
              if($value->activity == $row->activityName){
              echo $row->Gate_Description;
            }
             }
              }?>
        </td>
                    <td>
                      <table class="left-sub-table">
                          <tr>
                              <td>plan</td>
                            </tr>
                            <tr class="bdr-only-top">
                              <td>Actual</td>
                            </tr>
                        </table>
                    </td>
                    <td>
                      <table class="left-sub-table">
                          <tr>
                              <td align="center"><?php echo $row->lead_time; ?></td>
                            </tr>
                            <tr class="bdr-only-top" >
                              <td><?php echo $row->actual_duaration; ?></td>
                            </tr>
                        </table>
                    </td>
                      <td>
                      <table class="left-sub-table">
                          <tr>
                              <td><?php echo date('d M Y',strtotime($row->plan_start_date)); ?></td>
                            </tr>
                            <tr class="bdr-only-top">
                              <td><?php if($row->actual_start_date != ""){
                                  echo date('d M Y',strtotime($row->actual_start_date));
                                } ?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                      <table class="left-sub-table">
                          <tr>
                              <td><?php echo date('d M Y',strtotime($row->plan_end_date)); ?></td>
                            </tr>
                            <tr class="bdr-only-top">
                              <td><?php if($row->actual_end_date != ""){
                                echo date('d M Y',strtotime($row->actual_end_date));
                              }
                               ?></td>
                            </tr>
                        </table>
                    </td>
                </tr> 
                  <?php } ?>
          <?php 
            $key++;
            $get_id = $row->gate_id;
          } ?>            
            </table>
        </div>
    </div>
    <div class="col-md-7 col-sm-6 col-xs-6 right-side-div" style="padding-left:0;">
      <div class="right-table-container">
          <table class="table bdr-right right-table"> 
            <thead>              
                <tr>
                    <?php for($i=0;$i<count($project_all_dates);$i++){ ?>
                    <th><?php echo $project_all_dates[$i]; ?></th>
                    <?php } ?>
                </tr>
             </thead>  
             <tbody>
             <?php 
               $key = 1;
               $get_id = '';
                $pregate ='';
                $premat='';
                $pgate = '';
               foreach($activities as $z=>$row){
                 $ngate = $row->gate_id;
                  if($ngate != $pgate){
                     ?>
                    <tr><td  class="bdr-only-top" colspan=<?php echo count($project_all_dates)+2;?> style="font-weight:bold;"></td></tr>
                    <?php }
                    $pgate = $ngate;
                if($z != 0)
                {
                  if($get_id != $row->gate_id)
                    $key = 1;
                }
              ?>   
               <?php if($row->material_id == 0){?>           
                <tr>
                   
                    <?php 
                         $activity_row = $row->activity_row;
                         //echo '';print_r($activity_row);exit()
                         for($i = 0;$i<count($activity_row);$i++){ ?>
                    
                    <td>
                      <table class="left-sub-table bdr-left ">
                        <?php for($j =0;$j<count($activity_row[$i]);$j++){?>
                          <tr class="<?php echo $j!=0 ?'bdr-only-top':''; ?> <?php echo $j==0 && $activity_row[$i]['plan'] == 1 ? 'green-background':($j==1 && $activity_row[$i]['actual'] == 1?( strtotime($row->actual_end_date) > strtotime($row->plan_end_date) )?'red-background':'blue-background':'') ;?>">
                              <td></td>
                            </tr>
                          <?php } ?>
                        </table>
                    </td>
                    <?php } ?>
                </tr>

                <?php }else{
                   $newmat = $row->material_id;
                  if($ngate != $pregate || $newmat != $premat){ ?>
                   <tr style="height: 71px" class="left-table-bdr-top"><td  colspan=<?php echo count($project_all_dates)+2;?> style="font-weight:bold;"></tr>
                  <?php } $premat=$newmat;
                    $pregate=$ngate;
                  ?>      
                  <tr>
                  <?php 
                         $activity_row = $row->activity_row;
                         for($i = 0;$i<count($activity_row);$i++){ ?>
                      <td>
                      <table class="left-sub-table bdr-left ">
                        <?php for($j =0;$j<count($activity_row[$i]);$j++){?>
                          <tr class="<?php echo $j!=0 ?'bdr-only-top':''; ?> <?php echo $j==0 && $activity_row[$i]['plan'] == 1 ? 'green-background':($j==1 && $activity_row[$i]['actual'] == 1?( strtotime($row->actual_end_date) > strtotime($row->plan_end_date) )?'red-background':'blue-background':'') ;?>">
                              <td></td>
                            </tr>
                          <?php } ?>
                        </table>
                    </td>
                    <?php } ?>
                </tr>
                <?php } ?>
                <?php } ?>                
              </tbody>
            </table>
        </div>
    </div>
</body>
</html>
