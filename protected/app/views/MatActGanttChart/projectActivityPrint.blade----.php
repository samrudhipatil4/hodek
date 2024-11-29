<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>

<script src="<?php echo asset('assets/js/jquery-3.1.1.min.js') ?>"></script>




<style>
table {
    border-collapse: collapse;
}
table tr{
	padding:0;
}
 td , th
{
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
background-color:green;
    color: green;
    -webkit-print-color-adjust: exact;
   
}
.green-background{
background-color:blue;	
 color: blue;
 -webkit-print-color-adjust: exact;
 
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
 <tr class="table-heading">
    <th>Sr.No</th>
    <th>Gate</th> 
    <th>Activity</th>
    <th>Responsibility</th>
     <th></th>
     <th>Duration</th>
     <th>Activity<br> Start Date</th>
     <th>Activity<br> End Date</th>
     <?php for($i=0;$i<count($project_all_dates);$i++){ ?>
     <th class=""><?php echo $project_all_dates[$i] ?></th>
     <?php } ?>
         <!-- <th class="vertical">1 st May 2017</th>
     <th class="vertical">2 st May 2017</th>
     <th class="vertical">3 st May 2017</th>
     <th class="vertical">4 st May 2017</th>
     <th class="vertical">5 st May 2017</th>-->
  </tr>
   <?php foreach($activities as $row){?>
    <tr>
  	<td ><?php echo $row->gate_id.'.'.$row->activity ?></td>
    <td ><?php echo $row->Gate_Description ?></td>
    <td ><?php echo $row->activityName ?></td>
    <td><?php echo $row->department_name?></td>
    <td>
        <table class="sub-table" width="100%">
          <tr><td class="border-button">Plan</td></tr>
          <tr><td>Actual</td></tr>
        </table>
    </td>
    <td>
        <table class="sub-table" width="100%">
          <tr><td class="border-button"><?php echo $row->lead_time; ?></td></tr>
          <tr><td><?php echo $row->actual_duaration; ?></td></tr>
        </table>
    </td>
    <td>
        <table class="sub-table" width="100%">
          <tr><td class="border-button"><?php echo $row->plan_start_date ?></td></tr>
          <tr><td><?php echo $row->actual_start_date ?></td></tr>
        </table>
    </td>
    <td>
        <table class="sub-table" width="100%">
          <tr><td class="border-button" ><?php echo $row->plan_end_date ?></td></tr>
          <tr><td><?php echo $row->actual_end_date ?></td></tr>
        </table>
    </td>
   <?php 
      $activity_row = $row->activity_row;
    for($i = 0;$i<count($activity_row);$i++){?>
     <td >
        <table class="sub-table" width="100%">
        
          <?php for($j =0;$j<count($activity_row[$i]);$j++){?>
            <tr><td class="<?php echo $j==0 ?'border-button':''; ?> <?php echo $j==0 && $activity_row[$i]['plan'] == 1 ? 'red-background':($j==1 && $activity_row[$i]['actual'] == 1?'green-background':'') ;?>"></td></tr>
          
          <?php } ?>
          
        </table>
    </td>
    <?php } ?>
         
    </tr>
    <?php } ?>
    
    <!--<tr>
    <td>Actual</td>
    <td>calculate</td>
    <td>activity start date2</td>
    <td>activity end date-2</td>
    <td>2</td>
    <td>2/5/2017-2</td>
    <td class="green-background"></td>
    <td class="green-background"></td>
    <td>5/5/2017-2</td>
  </tr>
   <tr>
  	<td rowspan="2">1</td>
    <td rowspan="2">gate value</td>
    <td rowspan="2">activityvalue</td>
    <td rowspan="2">activityvalue</td>
    <td>Plan</td>
    <td>Loren ipsum dolor sit amet</td>
    <td>activity value-1</td>
    <td>activity end date-1</td>
    <td>1</td>
    <td>2/5/2017</td>
    <td>loren</td>
    <td>ipsum</td>
    <td>dolor</td>
  </tr>
  <tr>
    <td>Actual</td>
    <td>calculate</td>
    <td>activity start date2</td>
    <td>activity end date-2</td>
    <td>2</td>
    <td>2/5/2017-2</td>
    <td>3/5/2017-2</td>
    <td>4/5/2017-2</td>
    <td>5/5/2017-2</td>
  </tr>
   <tr>
  	<td rowspan="2">1</td>
    <td rowspan="2">gate value</td>
    <td rowspan="2">activityvalue</td>
    <td rowspan="2">activityvalue</td>
    <td>Plan</td>
    <td>Loren ipsum dolor sit amet</td>
    <td>activity value-1</td>
    <td>activity end date-1</td>
    <td>1</td>
    <td>2/5/2017</td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td>Actual</td>
    <td>calculate</td>
    <td>activity start date2</td>
    <td>activity end date-2</td>
    <td>2</td>
    <td>2/5/2017-2</td>
    <td>3/5/2017-2</td>
    <td>4/5/2017-2</td>
    <td>5/5/2017-2</td>
  </tr>
   <tr>
  	<td rowspan="2">1</td>
    <td rowspan="2">gate value</td>
    <td rowspan="2">activityvalue</td>
    <td rowspan="2">activityvalue</td>
    <td>Plan</td>
    <td>Loren ipsum dolor sit amet</td>
    <td>activity value-1</td>
    <td>activity end date-1</td>
    <td>1</td>
    <td>2/5/2017</td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td>Actual</td>
    <td>calculate</td>
    <td>activity start date2</td>
    <td>activity end date-2</td>
    <td>2</td>
    <td>2/5/2017-2</td>
    <td>3/5/2017-2</td>
    <td>4/5/2017-2</td>
    <td>5/5/2017-2</td>
  </tr>
   <tr>
  	<td rowspan="2">1</td>
    <td rowspan="2">gate value</td>
    <td rowspan="2">activityvalue</td>
    <td rowspan="2">activityvalue</td>
    <td>Plan</td>
    <td>Loren ipsum dolor sit amet</td>
    <td>activity value-1</td>
    <td>activity end date-1</td>
    <td>1</td>
    <td>2/5/2017</td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td>Actual</td>
    <td>calculate</td>
    <td>activity start date2</td>
    <td>activity end date-2</td>
    <td>2</td>
    <td>2/5/2017-2</td>
    <td>3/5/2017-2</td>
    <td>4/5/2017-2</td>
    <td>5/5/2017-2</td>
  </tr>-->
  
</table>
</div>
</div>
</div>
</body>
</html>
<script type="text/javascript">
$(document).ready(function() {
    window.print();
});
</script>

