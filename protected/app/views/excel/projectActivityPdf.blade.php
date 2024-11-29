<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<link href="<?php echo asset('assets/css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css">
<script src="<?php echo asset('assets/js/bootstrap.min.js') ?>"></script>

<style>
table {
    border-collapse: collapse;
}
table tr{
	padding:0;
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
background-color:green;
    color: green;

}
.green-background{
background-color:blue;	
 color: blue;
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
<div class="table-container">

<div>
  <h4>Project NO : <?php echo $project_details->project_no ?></h4>
  <h4>Project Name : <?php echo $project_details->project_name ?></h4>
  <h4>Manufacturing Location : <?php echo $project_details->description ?></h4>
  <h4>Project Start Date : <?php echo $project_details->date ?></h4>
</div>
<table class="table table-responsive table-bordered">
<?php for( $i = 1 ;$i<= count($total_date_array_all);$i++){
  ?>
    <tr><td colspan="98" style="text-align:center;height:50px;background-color:#ccc"></td></tr>
    <tr class="table-heading">
    <th>Sr.No</th>
    <th>Gate</th> 
    <th>Activity</th>
    <th>Responsibility</th>
     <th></th>
     <th>Duration</th>
     <th>Activity<br> Start Date</th>
     <th>Activity<br> End Date</th>
     <?php for($j=0;$j<count($total_date_array_all[$i]);$j++){ ?>
     <th class=""><?php echo $total_date_array_all[$i][$j] ?></th>
    
     <?php } ?>
     </tr>
         <!-- <th class="vertical">1 st May 2017</th>
     <th class="vertical">2 st May 2017</th>
     <th class="vertical">3 st May 2017</th>
     <th class="vertical">4 st May 2017</th>
     <th class="vertical">5 st May 2017</th>-->
  <?php  for($k = 0;$k<count($all_data[$i]);$k++){
    //echo $all_data[$i][$k]['Gate_Description'];exit;
   ?>
    <tr>
    <td ><?php echo $all_data[$i][$k]['gate_id'].'.'.$all_data[$i][$k]['activity'] ?></td>
    <td ><?php echo $all_data[$i][$k]['Gate_Description'] ?></td>
    <td ><?php echo $all_data[$i][$k]['activityName'] ?></td>
    <td><?php echo  $all_data[$i][$k]['department_name'] ?></td>
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
            <tr><td class="<?php echo $m==0 ?'border-button':''; ?> <?php echo $m==0 && $activity_row[$l]['plan'] == 1 ? 'red-background':($m==1 && $activity_row[$l]['actual'] == 1?'green-background':'') ;?>"></td></tr>
          
          <?php 
        } ?>
           <tr><td class=""></td></tr>
           
          
        </table>
    </td>
    <?php $count++; } 
     // for($p = 0;$p< (60-$count);$p++){
    ?>

     <!--<td >
        <table class="sub-table" width="100%">
        <tr>
          <td></td>
          <td></td>
        </tr>
        </table>
    </td> -->
<?php //} ?>

         
    </tr>
    <?php } ?>
<?php } ?>
</table>
</div>
</div>
</div>
</body>
</html>
