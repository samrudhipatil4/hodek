<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,700,600italic,700italic,800">

    <style type="text/css">
        .green{
            border-style:solid;
            border-width:0px 0px 0px 1px;
            border-color:#E5E5E5;
            background-color:#78943C;
        //padding:3px;
            text-align:center;
            color:#ffffff;
        }

        .red{
            border-style:solid;
            border-width:0px 0px 0px 1px;
            border-color:#E5E5E5;
            background-color:#B9150C;
        //padding:3px;
            text-align:center;
            color:#ffffff;
        }

        .yellow{
            border-style:solid;
            border-width:0px 0px 0px 1px;
            border-color:#E5E5E5;
            text-align:center;
            background-color:#F9CC29;
            color:#ffffff;
        }

thead{display: table-header-group;}
tfoot {display: table-row-group;}
tr {page-break-inside: avoid;}

    </style>
</head>

<body style="font-family: 'Open Sans',sans-serif; font-weight: normal; margin:0 auto;font-size:10px;">




<div style="width:100% height:auto;overflow-x:scroll;">
    <table style="font-size:10px;border-spacing:0;width:100%;max-width:100%;overflow-x:auto!important;table-layout:fixed;border-bottom:1px solid #e5e5e5;">
        
        <tbody>
        <tr>
            
        <td style="width:1%;color:#38393A;border:1px solid #E5E5E5;font-weight: 600;padding:15px 3px;  text-align: left;vertical-align: bottom;display:table-cell;border-right:none;">Sr. No.</td>
            <td style="width:3%;color:#38393A;border:1px solid #E5E5E5;font-weight: 600;padding:15px 3px;  text-align: left;vertical-align: bottom;display:table-cell;border-right:none;">Project Number</td>

            <td style="width:4%;color:#38393A;border:1px solid #E5E5E5;font-weight: 600;border-right:none;overflow-x:auto;vertical-align: bottom;padding:15px 3px;">Project Name</td>

            <td style="width:3%;color:#38393A;border:1px solid #E5E5E5;font-weight: 600;padding:5px;
               text-align: left;vertical-align: bottom;display: table-cell;padding:15px 5px;border-right:none;">Manufacturing Location</td>

            <td style="width:3%;color:#38393A;border:1px solid #E5E5E5;font-weight: 600;padding:5px;
               text-align: left;vertical-align: bottom;display: table-cell;padding: 15px 5px;border-right:none;">Project Start Date</td>
                <td style="width:7%;color:#38393A;border:1px solid #E5E5E5;font-weight: 600;padding:5px;
               text-align: left;vertical-align: bottom;display: table-cell;padding: 15px 5px;border-right:none;">Lessons</td>

              

        </tr>
        <?php
        if(sizeof($data)>0){
            $i=0;
            foreach($data as $jobs){  ?>
                <tr style="color:hsl(228, 2%, 48%)">
                    <td style="border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;padding-left:5px;"><?=++$i?>.</td>
                    <td style="border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;padding-left:5px;"><?=$jobs['Project_no'].' '.$jobs['checkHold'].' '.$jobs['checkDrop'];?></td>

                    <td style="padding-left:5px;border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;"><?= $jobs['project_name'];?></td>

                    <td style="border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;padding-left:5px;"><?= $jobs['mfg_location'];?></td>
                    <td style="border-style:solid;border-width:0px 0px 0px 1px;border-color:#E5E5E5;padding-left:5px;"><?= $jobs['proj_start_date'];?></td>

                    <td style="border-style:solid;border-width:1px 1px 1px 1px;border-color:#E5E5E5;padding-left:5px;">
                        <ul class="listing" style="list-style-type:none;padding:0px!important;">
                            <?php
                            if(isset($jobs['lesson'])&& !empty($jobs['lesson'])){
                                foreach($jobs['lesson'] as $lesson){  ?>
                                   <li>
                                        <?=$lesson->lesson;?>
                                    </li>
                                <?php }
                            }?>
                        </ul>
                    </td>
                    

                </tr>

            <?php } }
        else{?>
            <tr>
                No Records Found.
            </tr>
        <?php }?>
        </tbody>
    </table>
</div>

</body>
</html>