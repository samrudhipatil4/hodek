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
         <h3><?php echo 'No of change requests pending with department from >'.$formInput['pending'].' after target date' ?></h3>
                <table style="font-size:10px;border-spacing:0;width:100%;max-width:100%;overflow-x:auto!important;table-layout:fixed;border-bottom:1px solid #e5e5e5;">
                    <thead>
                    <tr style="border-bottom:1px solid #dcdcdc;">

                        <th style="width:100px;color:#38393A;border:1px solid #E5E5E5;border-right:none;font-weight:600;padding:10px;text-align:left;vertical-align: bottom;display:table-cell;padding: 15px 5px;"><span>Department Name<span></th>
                        <th style="width:100px;color:#38393A;border:1px solid #E5E5E5;border-right:none;font-weight:600;padding:10px;text-align:left;vertical-align: bottom;display:table-cell;padding: 15px 5px;"><span><?php echo'Change requests Pending >'.$formInput['pending'];?><span></th>
                       
                         </tr>
                    </thead>
                    <tbody>
                      <?php if(sizeof($data)>0){ 
                        foreach($data as $row){
                        ?>
                        <tr style="border-bottom:1px solid #dcdcdc;">
                         <td style="padding-left:5px;border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;"><?php echo $row->d_name;?></td>
                         <td style="padding-left:5px;border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;"><?php echo $row->cnt;?></td>
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

</body>
</html>

<script type="text/javascript">
