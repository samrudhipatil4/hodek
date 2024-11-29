<!DOCTYPE html>
<html>
  <head>
  <style type="text/css">
      #chart-container {
        width: 640px;
        height: auto;
      }
    </style>
  </head>

<?php require app_path().'/views/header.php'; ?>
<?php $user_type = Session::get('gid');?>



<div class="col-sm-12" >

    <div class="row">
        <div class="col-sm-8">
            <div class="page-heading">
                <h1>No. of open change requests per stakeholder per change type</h1>
            </div><!--/page-heading-->
           
        </div>
        <div class="col-sm-4">
            <div class="page-heading pull-right">
                <a class="btn btn-animate flat blue pd-btn" href="<?php echo Request::root().'/openCRPerCtypeStakeholder'; ?>">Back To Search</a>
            </div><!--/page-heading-->


        </div>
    </div>
    <form method="post" action="<?php echo Request::root().'/openCRPerCtypeStakeholder/download'; ?>">
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
                        <th width="300">Stakeholders &darr; / Change Type &rarr;</th>
                        <th>
                         <?php $cnt=0;
                                foreach ($cType as $row) {
                                        $cnt++;
                                 } 
                                $width=$cnt*40;?>                       
                            <table>
                            <tr>
                                     <?php $cnt=0;
                             foreach ($cType as $row) { $cnt++;?>
                             <th width="<?php echo $width; ?>"><span><?php echo $row->change_type_name; ?></span></th>
                             <?php } ?> 
                                </tr>
                            </table>
                        </th>
                         
                         </tr>
                    </thead>
                    <tbody>
                      <?php if(sizeof($cType)>0){

                        $i=1;
                        $alldata =[];
                        foreach($stakeholder as $sheet){
                         
                         ?>
                         <tr class="tr-bdr">
                         <td><?php echo $sheet->name;?></td>
                         <td>
                         <table>
                             <tr>
                                <?php foreach($cType as $row){ ?>

                                <td><?php if($formInput['stage_id']==0){
                                  
                                    $count=DB::select(DB::raw("select nos from report_open_change_request_1 where changeType='".$row->change_type_id."' and stakeholder='".$sheet->id."'")) ;
                                    if(!empty($count)){
                                      print_r($count[0]->nos);
                                      $alldata[$sheet->id][$row->change_type_id
                                    ]= $count[0]->nos;
                                    }else{ 
                                      echo 0;
                                      $alldata[$sheet->id][$row->change_type_id
                                    ]= 0;
                                    }
                                   

                                    }else{
                                       
                                        $count=DB::select(DB::raw("select nos from report_open_change_request_stage where changeType='".$row->change_type_id."' and stakeholder='".$sheet->id."' and change_stage='".$formInput['stage_id']."'")) ;
                                        if(!empty($count)){
                                          print_r($count[0]->nos);
                                          $alldata[$sheet->id][$row->change_type_id
                                    ]= $count[0]->nos;
                                        }else{ 
                                          echo 0;
                                          $alldata[$sheet->id][$row->change_type_id
                                    ]= 0;
                                        }
                                         
                                        }?></td>
                                
                                <?php }?> 
                             </tr>
                         </table>
                         </td>
                         
                        </tr>
                    <?php $i=$i+1;} }else{?>
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
 <div id="chart-container">
      <canvas id="mycanvas"></canvas>
    </div>
     <button type="button" onclick="saveAsPDF();">save as pdf</button>
</div>
           

            <!-- summary Table end -->

        </div><!--/content-wrapper-->

    </form>
</div><!--/s10-->
</html>
<?php require app_path().'/views/footer.php'; ?>
 <script type="text/javascript" src="<?php echo Request::root(); ?>/protected/public/Chart.min.js"></script>
    

<script type="text/javascript">
 
$(document).ready(function(){
    //get the line chart canvas
  var ctx = $("#mycanvas");

  //line chart data
  var ctype=[];
   var ctype1=<?php echo json_encode($cType); ?>;
for ( var key in ctype1 ) {
     ctype.push(ctype1[key]['change_type_name']);
   } 
   
   var stakeholder1=<?php echo json_encode($stakeholder); ?>;
   var count=<?php echo json_encode($alldata); ?>;

     
   
    var datasets=[];
   
    var color;
    var data;
    var i=0;

  
  
   
    var 

color = function(){
    return '#' + Math.floor(Math.random()*16777215).toString(16);
} 
 for ( var key in stakeholder1) {
   var dataval=[];
   for(var key1 in ctype1){
      var ind = stakeholder1[key]['id'];
      var ind1 = ctype1[key1]['change_type_id'];
        var cnt = count[ind][ind1];
        var cnt1= cnt;
        
      dataval.push(cnt1);
    }   

  
    datasets[i] =  {
          label: stakeholder1[key]['name'],
          data:dataval,
          backgroundColor: color(),
          
          borderColor:color(),
          
          borderWidth: 2
        }
        
    i++;
  }
  
 
   var  data= {
      labels: ctype,

      datasets:datasets 
    };
//}

  //options
  var options = {
    responsive: true,
   
    title: {
      display: true,
      position: "top",
      text: "Bar Graph",
      fontSize: 18,
      fontColor: "#111"
    },
    legend: {
      display: true,
      position: "bottom",
      labels: {
        fontColor: "#333",
        fontSize: 16
      }
    }
  };

  //create Chart class object
  var chart = new Chart(ctx, {
    type: "bar",
    data: data,
 
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

