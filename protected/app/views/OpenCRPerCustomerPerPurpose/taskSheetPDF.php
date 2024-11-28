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
         <div style="width:100% height:auto;">
         <h3>No. of change requests raised per purpose per customer</h3>
                <table style="font-size:10px;border-spacing:0;width:100%;max-width:100%;overflow-x:auto!important;table-layout:fixed;border-bottom:1px solid #e5e5e5;">
                    <thead>
                    <tr style="border-bottom:1px solid #dcdcdc;">

                        <th style="width:300px;color:#38393A;border:1px solid #E5E5E5;border-right:none;font-weight:600;padding:10px;text-align:left;vertical-align: bottom;display:table-cell;padding: 15px 5px;"><span><span></th>
                        <th>
                         <?php $cnt=0;
                                foreach ($purpose as $row) {
                                        $cnt++;
                                 } 
                                $width=$cnt*20;?>                       
                            <table>
                            <tr>
                                     <?php $cnt=0;
                             foreach ($purpose as $row) { $cnt++;?>
                             <th width="<?php echo $width; ?>" style="color:#38393A;border:1px solid #E5E5E5;font-weight:600;padding:10px;display:table-cell;padding: 15px 5px;"><span style="height: 250px;width: 20px;text-align:center;vertical-align: bottom;-webkit-transform:rotate(90deg);-moz-transform:rotate(90deg);-o-transform: rotate(90deg);-ms-transform:rotate(90deg);transform: rotate(90deg);white-space:nowrap;display:block!important;"><?php echo $row->changerequest_purpose; ?></span></th>
                             <?php } ?> 
                                </tr>
                            </table>
                        </th>
                         </tr>
                    </thead>
                    <tbody>
                      <?php if(sizeof($purpose)>0){

                        $i=1;
                        foreach($custdata as $sheet){
                         
                         ?>
                         <tr style="border-bottom:1px solid #dcdcdc;">
                         <td style="width:300px;padding-left:5px;border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;"><?php echo $sheet->CustName;?></td>
                         <td>
                         <?php $cnt=0;
                                foreach ($purpose as $row) {
                                        $cnt++;
                                 } 
                                $width=$cnt*20;?>     
                         <table style="padding:0px!important; border:none;margin:0px;">
                             <tr style="padding:0px!important;border:none;">
                                <?php foreach($purpose as $row){ ?>

                                <td  width="<?php echo $width; ?>" style='text-align: center;'><?php if($formInput['stage_id']=='' && ($formInput['startdate']=='' && $formInput['enddate']=='')){
                                  
                                    $count=DB::select(DB::raw("select count(request_id) as nos from total_cr_customerpurpose where purpose_id='".$row->purpose_id."' and customer_id='".$sheet->customer_id."'")) ;if(!empty($count)){print_r($count[0]->nos);}else{ echo 0;}
                                    }else if($formInput['stage_id']!='' && ($formInput['startdate']=='' && $formInput['enddate']=='')){
                                       
                                        $count=DB::select(DB::raw("select count(request_id) as nos from total_cr_customerpurpose where change_stage=".$formInput['stage_id']." and purpose_id='".$row->purpose_id."' and customer_id='".$sheet->customer_id."'")) ;
                                        if(!empty($count)){print_r($count[0]->nos);}else{ echo 0;}
                                        }else if($formInput['stage_id']=='' && ($formInput['startdate']!='' && $formInput['enddate']!='')){
                                            $count=DB::select(DB::raw("select count(request_id) as nos from total_cr_customerpurpose where (dt>='".$formInput['startdate']."' and dt<='".$formInput['enddate']."') and purpose_id='".$row->purpose_id."' and customer_id='".$sheet->customer_id."'")) ;
                                        if(!empty($count)){print_r($count[0]->nos);}else{ echo 0;}
                                        }else{
                                            $count=DB::select(DB::raw("select count(request_id) as nos from total_cr_customerpurpose where change_stage='".$formInput['stage_id']."' and (dt>='".$formInput['startdate']."' and dt<='".$formInput['enddate']."') and purpose_id='".$row->purpose_id."' and customer_id='".$sheet->customer_id."'")) ;
                                        if(!empty($count)){print_r($count[0]->nos);}else{ echo 0;}
                                        }
                                        ?>
                                            
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
                    </tbody>
                </table>

            </div><!--/summary-table-->

</body>
</html>

<script type="text/javascript">
