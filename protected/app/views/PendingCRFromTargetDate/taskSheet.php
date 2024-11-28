<?php require app_path().'/views/header.php'; ?>
<?php $user_type = Session::get('gid');?>



<div class="col-sm-12" >

    <div class="row">
        <div class="col-sm-8">
            <div class="page-heading">
                <h1><?php echo 'No of change requests pending with department from >'.$formInput['pending'].' after target date' ?></h1>
            </div><!--/page-heading-->

        </div>
        <div class="col-sm-4">
            <div class="page-heading pull-right">
                <a class="btn btn-animate flat blue pd-btn" href="<?php echo Request::root().'/PendingCRFormTargetDate'; ?>">Back To Search</a>
            </div><!--/page-heading-->


        </div>
    </div>
    <form method="post" action="<?php echo Request::root().'/PendingCRFormTargetDate/download'; ?>">
        <div class="content-wrapper">

              <div class="row mg-btm">
                <div class="col-sm-6">
                     <input type="hidden" name="stage" value="<?=$formInput['stage_id'];?>">
                     <input type="hidden" name="plant" value="<?=$formInput['plant'];?>">
                      <input type="hidden" name="changeType" value="<?=$formInput['changeType'];?>">
                     <input type="hidden" name="pending" value="<?=$formInput['pending'];?>">
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

                        <th width="100"><span>Department Name<span></th>
                        <th width="100"><span><?php echo'Change requests Pending >'.$formInput['pending'];?><span></th>
                       
                     </tr>
                    </thead>
                    <tbody>
                      <?php if(sizeof($data)>0){ 
                        foreach($data as $row){
                        ?>
                        <tr>
                         <td><?php echo $row->d_name;?></td>
                         <td><?php echo $row->cnt;?></td>
                        </tr>
                         
                      <?php }}else{?>
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
 <div id="chart-container" style="width:600px;height: 500px">
      <canvas id="mycanvas"></canvas>
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
    var data=<?php echo json_encode($data); ?>;
var deptname=[];
var cnt=[];
    for ( var key in data ) {
     //d_name = 
     deptname.push(data[key]['d_name']);
     //pending_cnt = ;
     cnt.push(data[key]['cnt']);
  }
   

   
    
 
      // var deptname = [];
      // var cnt = [];

     
      //   deptname.push(d_name);
      //   cnt.push(pending_cnt);
     

        var chartdata = {
                
                  labels: deptname,
                  datasets: [
                      {
                          label: 'CR Pending',
                          backgroundColor: '#00ccff',
                          borderColor: '#46d5f1',
                          hoverBackgroundColor: '#CCCCCC',
                          hoverBorderColor: '#666666',
                          data: cnt
                      }
                  ],


              };

              //options
  var options = {
    
    scales: {
      yAxes: [{
        ticks: {
          min: 0,

        }
      }],
       xAxes: [{
      ticks: {
        autoSkip: false,
        maxRotation: 80,
        minRotation: 80
      }
    }]
    },

  };

      var ctx = $("#mycanvas");

      var barGraph = new Chart(ctx, {
                        type: 'bar',
                        data: chartdata,
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
