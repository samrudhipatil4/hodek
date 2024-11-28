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






<div class="summary-table report-wrapper scrollbarX">

    <table class="striped" style="border:1px solid #000;">
        <thead style="border-bottom:1px solid #000">
        <tr class="tr-bdr">

            <th width="50" style="border-right:1px solid #000">Sr. No.</th>
            <th width="150" style="border-right:1px solid #000">Project Number</th>
            <th width="250" style="border-right:1px solid #000">Project Name</th>
            <th width="250" style="border-right:1px solid #000">Manufacturing Location</th>
            <th width="150" style="border-right:1px solid #000">Project Start Date</th>
            <th width="300" style="border-right:1px solid #000"> Lessons</th>
            
        </tr>
        </thead>
        <tbody id="checkboxex">
        <?php

        if(sizeof($data)>0){

            $i=0;
            foreach($data as $jobs){  ?>

                    <tr style="border-top:1px solid #000">

                        <td style="border-right:1px solid #000"><?=++$i?>.</td>

                        <td style="border-right:1px solid #000">
                            <?=$jobs['Project_no'].' '.$jobs['checkHold'].' '.$jobs['checkDrop'];?></td>

                        <td style="border-right:1px solid #000"><?= $jobs['project_name'];?></td>
                        <td style="border-right:1px solid #000"><?= $jobs['mfg_location'];?></td>
                        <td style="border-right:1px solid #000"><?= $jobs['proj_start_date'];?></td>
                        <td style="border-right:1px solid #000">

                            <?php
                            if(isset($jobs['lesson'])&& !empty($jobs['lesson'])){?>
                                <ul class="listing bdr-btm">

                                    <?php foreach($jobs['lesson'] as $lesson){  ?>

                                        <li>
                                            <span><?=$lesson->lesson;?></span>

                                        </li>
                                    <?php } }?>
                                </ul>
 

                        </td>

                         
                           
                    </tr>

                <?php } }else{?>
            <tr>
                No Records Found.

            </tr>
        <?php }?>

        </tbody>

    </table>

</body>
</html>