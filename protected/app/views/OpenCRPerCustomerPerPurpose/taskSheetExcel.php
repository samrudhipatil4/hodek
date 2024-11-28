<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,700,600italic,700italic,800">

    <link href="css/font-awesome.min.css" rel="stylesheet">
   
</head>
<body style="font-family: 'Open Sans',sans-serif; font-weight: normal; margin:0 auto;font-size:10px;">
            <h3>No. of change requests raised per purpose per customer</h3>
                <table style="border:1px solid #e5e5e5;">
                    <thead style="border-bottom:1px solid #e5e5e5;">
                    <tr style="border-top:1px solid #e5e5e5;">
                    <th style="width:300px;color:#38393A;border:1px solid #E5E5E5;border-right:none;font-weight:600;padding:10px;text-align:left;vertical-align: bottom;display:table-cell;padding: 15px 5px;"><span><span></th>
                        <th>
                         <?php $cnt=0;
                                foreach ($purpose as $row) {
                                        $cnt++;
                                 } 
                                $width=$cnt*10;?>                       
                            <table>
                            <tr>
                                     <?php $cnt=0;
                             foreach ($purpose as $row) { $cnt++;?>
                             <th width="<?php echo $width; ?>" class="rotate"><span><?php echo $row->changerequest_purpose; ?></span></th>
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
                         <tr class="tr-bdr">
                         <td><?php echo $sheet->CustName;?></td>
                         <td>
                         <table>
                             <tr>
                                <?php foreach($purpose as $row){ ?>

                                <td width="<?php echo $width; ?>" style='text-align: center'><?php if($formInput['stage_id']=='' && ($formInput['startdate']=='' && $formInput['enddate']=='')){
                                  
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
                </table>
            
</body>
</html>

<script type="text/javascript">
