<?php require app_path().'/views/apqp_header.php'; ?>
<?php $user_type = Session::get('gid');?>



<div class="col-sm-12" >

    <div class="row">
        <div class="col-sm-8">
            <div class="page-heading">
                <h1>Project Summary Pie Chart Report</h1>
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
                     
                   <!--  <div class="action-group pd-top">
                        <form method="post" action="">
                            <button class="btn btn-animate flat blue pd-btn "  value="excel" name="filetype" type="submit">Export to Excel Sheet</button>
                            <button class="btn btn-animate flat blue pd-btn "  value="pdf" name="filetype" type="submit">Export to PDF</button>
                        </form>
                    </div> -->

                </div>
            </div>
            <div id="chart-container" style="height:600px;width:591px">
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
                      <?php if((sizeof($totatProject)>0)){ ?>
                        <tr>
                         <td><?php echo 'Total project'?></td>
                         <td><?php echo $totatProject;?></td>
                         <td><?php if($totatProject != 0){ echo '100 %';}?></td>
                        </tr>
                         <tr>
                         <td><?php echo 'On time Completed Project'?></td>
                         <td><?php  if(!empty($completedontime)){ echo $completedontime; } ?></td>
                         <td><?php if(!empty($completedontime)){ $per=round(($completedontime/$totatProject)*100,2); echo $per.' %'; } ?></td>
                        </tr>
                        <tr>
                         <td><?php echo 'Delayed Completed Project'?></td>
                         <td><?php if(!empty($completedelayproj)){ echo $completedelayproj; } ?></td>
                         <td><?php if(!empty($completedelayproj)){ $per=round(($completedelayproj/$totatProject)*100,2);echo $per.' %'; } ?></td>
                        </tr>
                         <tr>
                         <td><?php echo 'In Process On Time Project'?></td>
                         <td><?php if(!empty($Inprocessontime)){ echo $Inprocessontime; }?></td>
                         <td><?php if(!empty($Inprocessontime)){ $per=round(($Inprocessontime/$totatProject)*100,2);echo $per.' %';}?></td>
                        </tr>
                        <tr>
                         <td><?php echo 'In Process delayed Project'?></td>
                         <td><?php if(!empty($Inprocessdelayproj)){ echo $Inprocessdelayproj; } ?></td>
                         <td><?php if(!empty($Inprocessdelayproj)){ $per=round(($Inprocessdelayproj/$totatProject)*100,2);echo $per.' %';}?></td>
                        </tr>
                         <tr>
                         <td><?php echo 'Hold Project'?></td>
                         <td><?php if(!empty($holdProj)){ echo $holdProj; } ?></td>
                         <td><?php if(!empty($holdProj)){ $per=round(($holdProj/$totatProject)*100,2);echo $per.' %';}?></td>
                        </tr>
                         <tr>
                         <td><?php echo 'Dropped Project'?></td>
                         <td><?php if(!empty($dropProj)){ echo $dropProj; } ?></td>
                         <td><?php if(!empty($dropProj)){ $per=round(($dropProj/$totatProject)*100,2);echo $per.' %'; }?></td>
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
 <?php if($totatProject !=0){ ?>
      <canvas id="mycanvas" ></canvas>
    <?php }else{ ?>
      <span style="text-align: center;">No data...</span>
    <?php } ?>
</div>
</div>
<div class="row">
 
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
   var totPr=<?php echo $totatProject; ?>;
   var compdelay=<?php echo $completedelayproj; ?>;
   var compontime=<?php echo  $completedontime; ?>;
   var inprodealay=<?php echo  $Inprocessdelayproj; ?>;
   var inproontiome=<?php echo  $Inprocessontime; ?>;
   var dropProj=<?php echo  $dropProj; ?>;
   var holdProj=<?php echo  $holdProj; ?>;




     

      //pie chart data
  var data1 = {
    labels: [ "Delayed Completed","On Time Completed", "In Process Delayed", "In Process On Time","Dropped Project","Hold Project"],
    datasets: [
      {
        label: "TeamA Score",
        data: [ compdelay, compontime, inprodealay, inproontiome,dropProj,holdProj],
        backgroundColor: [
          "#dd8808",
          "#2E8B57",
          "#f9CC29",
         "#9966ff",
             "#DC143C",
              "#07eae7",
            
        ],
        borderColor: [
          "#dd8808",
         "#2E8B57",
          "#f9CC29",
         "#9966ff",
           "#DC143C",
            "#07eae7"
           
        ],
        borderWidth: [1, 1, 1, 1, 1,1]
      }
    ]
  };
   //options
//   var options = {
//     responsive: true,
//     title: {
//       display: true,
//       position: "top",
//       text: "Pie Chart",
//       fontSize: 12,
//       fontColor: "#111"
//     },
//     legend: {
//       display: true,
//       position: "bottom",
//       labels: {
//         fontColor: "#333",
//         fontSize: 12
//       }
//     },
//     onClick:function(e){
//     var activePoints = myChart.getElementsAtEvent(e);
//     var selectedIndex = activePoints[0]._index;
//     alert(this.data.datasets[0].data[selectedIndex]);


// }
//   };

      var ctx = $("#mycanvas");

      //create Chart class object
  var chart1 = new Chart(ctx, {
    type: "pie",
    data: data1,
    options: {
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
    },
    onClick:function(e){
    var activePoints = chart1.getElementsAtEvent(e);
    var selectedIndex = activePoints[0]._index;
     
   var lbl = this.data.labels[selectedIndex];
  var charttype;
   if(lbl =="Delayed Completed"){
    charttype = 1;
   }else if(lbl =="On Time Completed"){
    charttype = 2;
   }else if(lbl =="In Process Delayed"){
    charttype = 3;
   }else if(lbl =="In Process On Time"){
    charttype = 4;
   }else if(lbl =="Dropped Project"){
    charttype = 5;
   }else if(lbl =="Hold Project"){
    charttype = 6;
   }

 var url = "<?php echo Request::root().'/getReportDetails1?charttype=';?>"+charttype;
     window.location.href=url;
 

}
  }
  });


    ctx.onclick = function(evt){
    var activePoint = chart1.getElementAtEvent(evt);
    console.log('activePoint', activePoint)
    // var url = ... make link with data from activePoint
    window.location = 'https://www.google.by/search?q=chart+js+events&oq=chart+js+events'
};
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