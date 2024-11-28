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
            <h3>% of open & closed development change requests</h3>
                <table style="border:1px solid #e5e5e5;">
                    <thead style="border-bottom:1px solid #e5e5e5;">
                    <tr style="border-top:1px solid #e5e5e5;">

                        <th width="300" style="border-right:1px solid #e5e5e5;"><span><span></th>
                        <th width="200" style="border-right:1px solid #e5e5e5;"><span>Total<span></th>
                        <th width="200" style="border-right:1px solid #e5e5e5;"><span>Percentage<span></th>
                        
                         </tr>
                    </thead>
                    <tbody>
                      <?php if((sizeof($total)>0)&&($total[0]->nos!=0)){ ?>
                        <tr>
                         <td style="border-right:1px solid #e5e5e5;"><?php echo 'Total Change Request'?></td>
                         <td style="border-right:1px solid #e5e5e5;"><?php echo $total[0]->nos;?></td>
                         <td style="border-right:1px solid #e5e5e5;"><?php echo '100 %';?></td>
                        </tr>
                         <tr style="border-top:1px solid #e5e5e5;">
                         <td style="border-right:1px solid #e5e5e5;"><?php echo 'Open Change Request'?></td>
                         <td style="border-right:1px solid #e5e5e5;"><?php echo $open;?></td>
                         <td style="border-right:1px solid #e5e5e5;"><?php $per=round(($open/$total[0]->nos)*100,2); echo $per.' %'?></td>
                        </tr>
                        <tr>
                         <td style="border-right:1px solid #e5e5e5;"><?php echo 'Closed Change Request'?></td>
                         <td style="border-right:1px solid #e5e5e5;"><?php echo $close[0]->nos;?></td>
                         <td style="border-right:1px solid #e5e5e5;"><?php $per=round(($close[0]->nos/$total[0]->nos)*100,2);echo $per.' %'?></td>
                        </tr>
                        <tr>
                         <td style="border-right:1px solid #e5e5e5;"><?php echo 'Permanent Reject and Close Change Request'?></td>
                         <td style="border-right:1px solid #e5e5e5;"><?php echo $permanent_close[0]->nos;?></td>
                         <td style="border-right:1px solid #e5e5e5;"><?php $per=round(($permanent_close[0]->nos/$total[0]->nos)*100,2);echo $per.' %'?></td>
                        </tr>
                        <tr>
                         <td style="border-right:1px solid #e5e5e5;"><?php echo 'Hold Change Request'?></td>
                         <td style="border-right:1px solid #e5e5e5;"><?php echo $hold[0]->cnt;?></td>
                         <td style="border-right:1px solid #e5e5e5;"><?php $per=round(($hold[0]->cnt/$total[0]->nos)*100,2);echo $per.' %'?></td>
                        </tr>
                      <?php }else{?>
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
