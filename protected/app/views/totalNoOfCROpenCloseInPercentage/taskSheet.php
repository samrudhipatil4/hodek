<?php require app_path().'/views/header.php'; ?>
<?php $user_type = Session::get('gid');?>



<div class="col-sm-12" >

    <div class="row">
        <div class="col-sm-8">
            <div class="page-heading">
                <h1>% of open & closed change requests</h1>
            </div><!--/page-heading-->

        </div>
        <div class="col-sm-4">
            <div class="page-heading pull-right">
                <a class="btn btn-animate flat blue pd-btn" href="<?php echo Request::root().'/totalNoOfCRInPercentage'; ?>">Back To Search</a>
            </div><!--/page-heading-->


        </div>
    </div>
    <form method="post" action="<?php echo Request::root().'/totalCRInPercentage-search-result/download'; ?>">
        <div class="content-wrapper">

              <div class="row mg-btm">
                <div class="col-sm-6">
                     <input type="hidden" name="stage" value="<?=$formInput['stage_id'];?>">
                     <input type="hidden" name="plant" value="<?=$formInput['plant'];?>">
                      <input type="hidden" name="changeType" value="<?=$formInput['changeType'];?>">
                    <div class="action-group pd-top">
                        <form method="post" action="">
                            <button class="btn btn-animate flat blue pd-btn "  value="excel" name="filetype" type="submit">Export to Excel Sheet</button>
                            <button class="btn btn-animate flat blue pd-btn "  value="pdf" name="filetype" type="submit">Export to PDF</button>
                        </form>
                    </div>

                </div>
            </div>
           <div class="summary-table report-wrapper scrollbarX">

                <table class="striped">
                    <thead>
                    <tr class="tr-bdr">

                        <th width="100"><span><span></th>
                        <th width="100"><span>Total<span></th>
                        <th width="100"><span>Percentage<span></th>
                        
                     </tr>
                    </thead>
                    <tbody>
                      <?php if((sizeof($total)>0)&&($total[0]->nos!=0)){ ?>
                        <tr>
                         <td><?php echo 'Total Change Request'?></td>
                         <td><?php echo $total[0]->nos;?></td>
                         <td><?php echo '100 %';?></td>
                        </tr>
                         <tr>
                         <td><?php echo 'Open Change Request'?></td>
                         <td><?php echo $open;?></td>
                         <td><?php $per=round(($open/$total[0]->nos)*100,2); echo $per.' %'?></td>
                        </tr>
                        <tr>
                         <td><?php echo 'Closed Change Request'?></td>
                         <td><?php echo $close[0]->nos;?></td>
                         <td><?php $per=round(($close[0]->nos/$total[0]->nos)*100,2);echo $per.' %'?></td>
                        </tr>
                         <tr>
                         <td><?php echo 'Permanent Reject and Close Change Request'?></td>
                         <td><?php echo $permanent_close[0]->nos;?></td>
                         <td><?php $per=round(($permanent_close[0]->nos/$total[0]->nos)*100,2);echo $per.' %'?></td>
                        </tr>
                        <tr>
                         <td><?php echo 'Hold Change Request'?></td>
                         <td><?php echo $hold[0]->cnt;?></td>
                         <td><?php $per=round(($hold[0]->cnt/$total[0]->nos)*100,2);echo $per.' %'?></td>
                        </tr>
                      <?php }else{?>
                      <tr>
                        <td>NO Record Found
                        </td>
                      </tr>
                        <?php }?>
                    </tbody>
                </table>

            </div><!--/summary-table-->

           </br></br>
<div class="row">
 <div id="chart-container" style="height:300px;width:591px">
      <canvas id="mycanvas" ></canvas>
    </div>
    <button type="button" onclick="saveAsPDF();">save as pdf</button>
</div>

            <!-- summary Table end -->

        </div><!--/content-wrapper-->

    </form>
</div><!--/s10-->
<?php require app_path().'/views/footer.php'; ?>



<script type="text/javascript" src="<?php echo Request::root(); ?>/protected/public/Chart.min.js"></script>
    

<script type="text/javascript">
  
$(document).ready(function(){
   var totCR=<?php echo $total[0]->nos; ?>;
   var openCR=<?php echo $open; ?>;
   var closeCR=<?php echo  $close[0]->nos; ?>;
   var permanenrCR=<?php echo  $permanent_close[0]->nos; ?>;
   var holdCR=<?php echo  $hold[0]->cnt; ?>;




     

      //pie chart data
  var data1 = {
    labels: [ "Open CR","Close CR", "Permanent Close CR", "Hold CR"],
    datasets: [
      {
        label: "TeamA Score",
        data: [ openCR, closeCR, permanenrCR, holdCR],
        backgroundColor: [
         
          "#f9CC29",
          "#2E8B57",
         "#DC143C",
            "#07eae7",
        ],
        borderColor: [
          
          "#f9CC29",
         "#2E8B57",
          "#DC143C",
           "#07eae7",
        ],
        borderWidth: [ 1, 1, 1, 1]
      }
    ]
  };
   //options
  var options = {
    responsive: true,
    title: {
      display: true,
      position: "top",
      text: "Pie Chart",
      fontSize: 12,
      fontColor: "#111"
    },
    legend: {
      display: true,
      position: "bottom",
      labels: {
        fontColor: "#333",
        fontSize: 12
      }
    }
  };

      var ctx = $("#mycanvas");

      //create Chart class object
  var chart1 = new Chart(ctx, {
    type: "pie",
    data: data1,
    options: options
  });

   
});

function saveAsPDF() {
     html2canvas(document.getElementById("chart-container"), {
      onrendered: function(canvas) {
         var img = canvas.toDataURL(); //image data of canvas
         var doc = new jsPDF();
         doc.addImage(img, 10, 10);
         doc.save('test.pdf');
      }
   });
}
</script> 