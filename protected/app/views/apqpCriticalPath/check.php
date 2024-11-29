<html>
  <head>
   <style type="text/css">
     table,th,td{
   
 border-collapse: collapse;
 
}
   </style>
  </head>
  <body>
  <div class="col-sm-12" >

    <div class="row">
        <div class="col-sm-8">
            <div class="page-heading">
                <h1>Project Documentation Report</h1>
            </div><!--/page-heading-->

        </div>
        
    </div>
    <form method="post" action="<?php echo Request::root().'/project_report/download'; ?>">
        <div class="content-wrapper">

             
     <div class="summary-table report-wrapper scrollbarX"  >

                <table class="striped" border="1">
                    <thead>
                    <tr class="tr-bdr">
                    <th width="50">SR NO</th>
                    <th width="50">Gate No</th>
                    <th width="200">Gate</th>
                    <th width="300">Activity</th>
                    <th width="200">Responsibility</th>
                    <th width="150">Activity Start Date</th>
                    <th width="150">Activity End Date</th>
                    <th width="200">Document</th>
                   
                    </tr>
                    </thead>
                    <tbody>
                   
                   <?php 
                      $i1=1;  $j=1;
                
                $pregate ='';
                $premat='';
                $pgate = '';
                foreach ($alldata as $value) {

                  $ngate = $value['gate_id'];
                  if($ngate != $pgate){
                    $i2 = 1; ?>
                    <tr><td  colspan="6" style="font-weight:bold;"><?php echo 'Gate '.$value['gate_id'];?></td></tr>
                    <?php }
                $pgate = $ngate;

                if($value['material_id'] == 0){ ?>
                <tr>
                  <td><?php echo $j;?></td>
                  <td><?php echo $value['gate_id'].'.'.$i2?></td>
                  <td><?php echo $value['gate_name'];?></td>
                  <td><?php echo $value['activity_name'];?></td>
                    <td><?php echo $value['getUserName'];?></td>
                  <td><?php echo $value['activity_start_date'];?></td>
                  <td><?php echo $value['activity_end_date'];?></td>
                  <td><?php print_r($value['document'][0]['act_id']);?></td>

                </tr>
                <?php $i2++;
                $j++; }else{
                  $newgate = $value['gate_id'];
                  $newmat = $value['material_id'];
                  if($newgate != $pregate || $newmat != $premat){ ?>

                    <tr><td colspan="2"></td><td colspan=4 style="font-weight:bold;"><div><?php echo $value['mat_name']; ?></div></td></tr>
                    <?php } $pregate=$newgate;
                  $premat=$newmat;?>
<tr>
                  <td><?php echo $j;?></td>
                  <td><?php echo $value['gate_id'].'.'.$i2?></td>
                  <td><?php echo $value['gate_name'];?></td>
                  <td><?php echo $value['activity_name'];?></td>
                  <td><?php echo $value['getUserName'];?></td>
                  <td><?php echo $value['activity_start_date'];?></td>
                  <td><?php echo $value['activity_end_date'];?></td>
                  <td><?php if($value['document']['id'] == $value['d_id']){
                    echo $value['document']['doc']; ?>
                     <a href="<?php echo Request::root().'/download?path=apqp_activity_document&filename='.$value['document']['doc']?>" data-position="bottom" data-delay="50" data-tooltip="Download"><i class="glyphicon glyphicon-download-alt"></i></a>

                    <?php };?></td>
                  


                </tr>
                <?php $i2++;
                $j++; }}?>
                
                   
                    </tbody>
                </table>

            </div><!--/summary-table-->
            </div>
            </form>
            </div>
  </body>
</html>