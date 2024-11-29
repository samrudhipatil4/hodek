<!DOCTYPE html>
<html>
<head>
<style type="text/css">
body {
    position: relative;
}
.table-wrapper { 
    overflow-x:scroll;
    overflow-y:visible;
    width:950px;
    margin-left: 300px;

}


table,th,td{
    border: 1px solid black;
 border-collapse: collapse;
 text-overflow: ellipsis;
}

td, th {
    padding: 5px 20px;
    width: 100px;
     margin: auto;
    text-align: left;
     text-overflow: ellipsis;

}
tbody tr {


}


th:first-child {
    position: absolute;
    left: 5px
}
th:nth-child(2){
    position: absolute;
     left: 148px
}


</style>

<script src="https://code.jquery.com/jquery-2.2.3.min.js"></script>
  <meta charset="utf-8">
  <title>JS Bin</title>
</head>
<body>
<div>
    <h1>SOME RANDOM TEXT</h1>
</div>
<div class="table-wrapper">
    <table id="consumption-data" class="data">
        <thead class="header">
            <tr>
                <th   class="headborder" >Month</th>
                 <th  ><span>Month</span></th>
                  <?php $id= $data2;

            $startdate=DB::table('apqp_draft_project_plan')
                  ->select('project_start_date')
                  ->where('project_id',$id)
                  ->first();
                  

            $data=DB::table('apqp_draft_project_plan')
                  ->select('activity_end_date')
                  ->where('project_id',$id)
                  ->orderBy('activity_end_date')
                  ->get();

        foreach ($data as $key) {
          $date_arr[]=$key->activity_end_date;
        }
        for ($i = 0; $i < count($date_arr); $i++)
        {
          if ($i == 0)
          {
              $max_date = date('Y-m-d H:i:s', strtotime($date_arr[$i]));
              
          }
          else if ($i != 0)
          {
              $new_date = date('Y-m-d H:i:s', strtotime($date_arr[$i]));
              if ($new_date > $max_date)
              {
                  $max_date = $new_date;
              }
              
          }

        } 


           $begin = new DateTime($startdate->project_start_date);
$end = new DateTime($max_date);

$interval = DateInterval::createFromDateString('1 day');
$period = new DatePeriod($begin, $interval, $end); ?>

<?php foreach ( $period as $dt ){ ?>
<th>
 <?php  echo $dt->format( "Y-m-d \n" );
        }
        ?></th>


            </tr>
        </thead>
        <tbody  class="results">
            <tr  >
                <th >Jan sfsdfsddkjbkbhk</th>
                 <th >Month</th>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
            </tr>
            <tr>
                <th >Feb</th>
                 <th>Month</th>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
            </tr>
            <tr>
                <th >Mar</th>
                 <th >Month</th>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
            </tr>
            <tr>
                <th >Apr</th>
                 <th>Month</th>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td> 
                <td>3163</td>
                <td>3163</td>
                <td>3163</td> 
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
            </tr>
            <tr>    
                <th >May</th>
                 <th>Month</th>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
            </tr>
            <tr>
                <th >Jun</th>
                 <th>Month</th>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
            </tr>

            <tr>
                <th>...</th>
                 <th>Month</th>
                <td>...</td>
                <td>...</td>
                <td>...</td>
                <td>...</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
                <td>3163</td>
            </tr>
        </tbody>
    </table>
</div>

<div>
</div>
</body>
<script type="text/javascript">
    $(function () {  
  $('.table-wrapper tr').each(function () {
    var tr = $(this),
        h = 0;
    tr.children().each(function () {
      var td = $(this),
          tdh = td.height();
      if (tdh > h) h = tdh;
    });
    tr.css({height: h + 'px'});
  });
});
</script>
</html>