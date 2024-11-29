<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

   <!--  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,700,600italic,700italic,800"> -->
   
<style >
  table { page-break-after:auto }
    thead { display:table-header-group }
    tr    { page-break-inside:avoid }
    th    { page-break-inside:avoid }
    td    { page-break-inside:avoid }
    </style>

</head>
<body>
    <input type="hidden" name="stage_id" value="<?=$formInput['stage_id'];?>">
         <div style="width:100% height:auto;">
            <h3>Open development change requests per stakeholder per change type</h3>
                <table style="font-size:10px;border-spacing:0;width:100%;max-width:100%;overflow-x:auto!important;table-layout:fixed;border-bottom:1px solid #e5e5e5;">
                    <thead>
                    <tr style="border-bottom:1px solid #dcdcdc;">

                        <th style="width:300px;color:#38393A;border:1px solid #E5E5E5;border-right:none;font-weight:600;padding:10px;text-align:left;vertical-align: bottom;display:table-cell;padding: 15px 5px;"><span>Stakeholders &darr; / Change Type &rarr;<span></th>
                       <th style="color:#38393A;border:1px solid #E5E5E5;border-right:none;font-weight:600;padding:10px;text-align:left;vertical-align: bottom;display:table-cell;padding: 15px 5px;">
                         <?php $cnt=0;
                                foreach ($cType as $row) {
                                        $cnt++;
                                 } 
                                $width=$cnt*40;?>                       
                            <table>
                            <tr>
                                     <?php $cnt=0;
                             foreach ($cType as $row) { $cnt++;?>
                             <th width="<?php echo $width; ?>" ><span><?php echo $row->change_type_name; ?></span></th>
                             <?php } ?> 
                                </tr>
                            </table>
                        </th>
                         </tr>
                    </thead>
                    <tbody>
                      <?php if(sizeof($cType)>0){

                        $i=1;
                        foreach($stakeholder as $sheet){
                         
                         ?>
                         <tr style="border-bottom:1px solid #dcdcdc;">
                         <td style="padding-left:5px;border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;"><?php echo $sheet->name;?></td>
                         <td style="padding-left:5px;border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;">
                          <?php $cnt=0;
                                foreach ($cType as $row) {
                                        $cnt++;
                                 } 
                                $width=$cnt*40;?>    
                         <table>
                             <tr style="border-bottom:1px solid #dcdcdc;">
                                <?php foreach($cType as $row){ ?>

                                <td width="<?php echo $width; ?>" ><?php if($formInput['stage_id']==0){
                                   
                                     $count=DB::select(DB::raw("select nos from report_open_change_request_1 where changeType='".$row->change_type_id."' and stakeholder='".$sheet->id."'")) ;if(!empty($count)){print_r($count[0]->nos);}else{ echo 0;}
                                    }else{
                                        
                                        $count=DB::select(DB::raw("select nos from report_open_change_request_stage where changeType='".$row->change_type_id."' and stakeholder='".$sheet->id."' and change_stage='".$formInput['stage_id']."'")) ;
                                        if(!empty($count)){print_r($count[0]->nos);}else{ echo 0;}
                                        }?>
                                            
                                </td>
                                
                                <?php }?> 
                             </tr>
                         </table>
                         </td>
                         
                        </tr>
                    <?php $i=$i+1;}}else{?>
                      <tr>
                        <td>NO Record Found
                        </td>
                      </tr>
                        <?php }?>
                    </tbody>    


                </table>

            </div><!--/summary-table-->

</body>
</html>

<script type="text/javascript">
