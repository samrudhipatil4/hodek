<?php require app_path().'/views/apqp_header.php'; ?>
<style type="text/css">
.vertical {
  writing-mode: vertical-rl;
  text-orientation: sideways-right;
}
 table {
  position: relative;
 /* width: 700px;*/
  background-color: #fff;
  overflow: hidden;
  border-collapse: inherit;
}


/*thead*/
thead {
  position: relative;
  display: block; /*seperates the header from the body allowing it to be positioned*/
  /*width: 700px;*/
  overflow: visible;
  
}

thead th {
  background-color:#FFFAFA;
 
  height: 32px;
  border: 1px inset;
}

thead th:nth-child(1) {/*first cell in the header*/
  position: relative;
  
  background-color: #FFFAFA;
}
thead th:nth-child(2) {/*first cell in the header*/
  position: relative;
  
  background-color: #FFFAFA;
}
thead th:nth-child(3) {/*first cell in the header*/
  position: relative;
  
  background-color: #FFFAFA;
}
thead th:nth-child(4) {/*first cell in the header*/
  position: relative;
  
  background-color: #FFFAFA;
}
thead th:nth-child(5) {/*first cell in the header*/
  position: relative;
  
  background-color: #FFFAFA;
}


/*tbody*/
tbody {
  position: relative;
  display: block; /*seperates the tbody from the header*/
 /* width:700px;*/
  height: 500px;
  overflow: scroll;
  word-break: break-word;
}

tbody td {
  background-color:#fff;
  
  border: 1px inset;
}

tbody tr td:nth-child(1) {  /*the first cell in each tr*/
  position: relative;
 
  height: 40px;
  background-color: #FFFAFA;
}
tbody tr td:nth-child(2) {  /*the first cell in each tr*/
  position: relative;
 
  height: 40px;
  background-color: #FFFAFA;
}
tbody tr td:nth-child(3) {  /*the first cell in each tr*/
  position: relative;
 
  height: 40px;
  background-color: #FFFAFA;
}
tbody tr td:nth-child(4) {  /*the first cell in each tr*/
  position: relative;
 
  height: 40px;
  background-color:#FFFAFA;
}
tbody tr td:nth-child(5) {  /*the first cell in each tr*/
  position: relative;
 
  height: 40px;
  background-color: #FFFAFA;
}

</style>
<div class="col-sm-12" >

    <div class="row">
        <div class="col-sm-8">
            <div class="page-heading">
                <h1 style="font-size: 24px;
    font-family: cursive;">Project Summary Report </h1>
            </div><!--/page-heading-->

        </div>
        <div class="col-sm-4">
            <div class="page-heading pull-right">
                <a class="btn btn-animate flat blue pd-btn" href="<?php echo Request::root().'/projectSummary_Report'; ?>">Back To Search</a>
            </div><!--/page-heading-->


        </div>
    </div>
    <form method="post" action="<?php echo Request::root().'/summaryreportReport/download'; ?>">
        <div class="content-wrapper">

            <div class="row mg-btm">
                <div class="col-sm-6">
                <input type="hidden" name="proj_no" value="<?=$formInput['proj_no'];?>">
                
                  <input type="hidden" name="charttype" value="<?=$formInput['charttype'];?>">
                    
                    <div class="action-group pd-top">
                        <form method="post" action="">
                            <button class="btn btn-animate flat blue pd-btn "  value="excel" name="filetype" type="submit">Export to Excel Sheet</button>
                            <button class="btn btn-animate flat blue pd-btn "  value="pdf" name="filetype" type="submit">Export to PDF</button>
                        </form>
                    </div>



                </div>
                <div class="col-sm-6 pull-right">
                    <ul class="summary-status right-align mg-top-0">
                        <li>Activity Completed  <span>G</span></li>
                        <li>Within defined target date ( Work in Process )  <span>Y</span></li>
                        <li>Activity Over due <span>R</span></li>
                    </ul>
                </div>
               
            </div>
          <body>
          <?php $i=0;
    

   foreach($activity as $row){
    $i++;
   } $wid = 37*$i;
   $wid2=($wid)+540;
   if($wid2 > 1500){
    $wid1 = 1150;
   }else{
    $wid1 = $wid2+20;
   }
    ?>
  <table style="font-size: 14px;border: 1px solid #ddd;width:<?php echo $wid1.'px';?>">
    <thead style="width:<?php echo $wid1.'px'?>">
    <!--  <tr>
   <th width="30" ></th>
   <th width="135"></th>
   <th width="135" ></th>
   <th width="130" ></th>
   <th width="110"></th>

  <?php $i=0;
    

   foreach($activity as $row){
    $i++;
   } $wid = 40*$i; ?>
 <?php 
    $pgate = '';
    $actCnt = 0;
   foreach($activity as $row){
     $ngate = $row->gate_id;
                if($ngate != $pgate){
                    $cnt = apqpProjectSummaryReportController::countAct($row->template,$row->gate_id);
                    $wid = 40*$cnt;
                   // echo $cnt;
                   // echo $wid;exit();
                    $i1 = 1; ?>
                   <th border="1"  style="font-size: 11px;font-weight: bold; width:<?php echo $wid.'px';?>;background-color: darkorange;" colspan="<?php echo $cnt;?>" ><?php echo $row->Gate_Description; ?></th>
                    <?php }
            $pgate = $ngate;

  } ?>
  
  </tr>  -->
    <tr>
      <th style="min-width: 30px;white-space: initial;" >Sr. No.</th>
      <th style="min-width: 135px;white-space: initial;">Project Number</th>
      <th style="min-width: 135px;white-space: initial;">Project Name</th>
    <th style="min-width: 130px;white-space: initial;">Manufacturing Location</th>
     <th style="min-width: 110px;white-space: initial;">Project Start Date</th>
     <?php foreach($activity as $row){

      ?>
                       <th  class="rotate pd" style="min-width: 40px;white-space: nowrap;"><div class="vertical"> <?php echo $row->activity;?></div></th>
                        <?php } ?>
                       
    </tr>
    </thead>
    <tbody style="width:<?php echo $wid1.'px';?>">
  <?php      if(sizeof($data)>0){
                
            $i=0;
            foreach($data as $jobs){
              //echo '<pre>';print_r($jobs['checkDrop'][0]);exit();
                ?>
    <tr>
     <td style="min-width: 30px"><?=++$i?>.</td>

   <td style="min-width: 135px">
      <span><a href="<?php echo Request::root().'/summaryReport?prjId='.$jobs['proj_id']; ?>">    <?=$jobs['Project_no'].' Revision'.$jobs['revision'].' '.$jobs['checkHold'];?>
   </a></span></td>
   <td style="min-width: 135px"><?= $jobs['project_name'];?></td>
   <td style="min-width: 130px"><?= $jobs['mfg_location'];?></td>
      <td style="min-width: 110px"><?= $jobs['proj_start_date'];?></td>
       <?php foreach($activity as $row){ 
        //  $class = apqpProjectSummaryReportController::getActDetails($jobs['proj_id'],$row->id);
      
        foreach($jobs['ActivityStatus'] as $key){
         if($key['activity'] == $row->id && $jobs['proj_id'] == $key['project']){
        
        ?>
                       <td style="font-size: 12px;font-weight: bold; text-align: center; min-width: 40px;padding-left: 2px;color: white; background-color: <?php echo $key['class'];?>"> <?php echo $key['text'];?></td>
                        <?php } }  } ?>
    </tr>
  <?php } } ?>
  </tbody>
  </table>
</body>

</div>
</form>
</div>
<?php require app_path().'/views/apqp_footer.php'; ?>

<script type="text/javascript">
  $(document).ready(function() {
  $('tbody').scroll(function(e) { //detect a scroll event on the tbody
    /*
    Setting the thead left value to the negative valule of tbody.scrollLeft will make it track the movement
    of the tbody element. Setting an elements left value to that of the tbody.scrollLeft left makes it maintain       it's relative position at the left of the table.    
    */
    $('thead').css("left", -$("tbody").scrollLeft()); //fix the thead relative to the body scrolling
    $('thead th:nth-child(1)').css("left", $("tbody").scrollLeft()); //fix the first cell of the header
    $('tbody td:nth-child(1)').css("left", $("tbody").scrollLeft()); //fix the first column of tdbody
    $('thead th:nth-child(2)').css("left", $("tbody").scrollLeft()); //fix the first cell of the header
    $('tbody td:nth-child(2)').css("left", $("tbody").scrollLeft()); //fix the first column of tdbody
    $('thead th:nth-child(3)').css("left", $("tbody").scrollLeft()); //fix the first cell of the header
    $('tbody td:nth-child(3)').css("left", $("tbody").scrollLeft()); //fix the first column of tdbody
    $('thead th:nth-child(4)').css("left", $("tbody").scrollLeft()); //fix the first cell of the header
    $('tbody td:nth-child(4)').css("left", $("tbody").scrollLeft()); //fix the first column of tdbody
    $('thead th:nth-child(5)').css("left", $("tbody").scrollLeft()); //fix the first cell of the header
    $('tbody td:nth-child(5)').css("left", $("tbody").scrollLeft()); //fix the first column of tdbody
  });
});

</script>