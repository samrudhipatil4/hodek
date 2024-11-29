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


<table style="width:80%;margin-bottom:40px;border:1px solid #000;">

    



<div class="summary-table report-wrapper scrollbarX">

    <table class="striped" style="border:1px solid #000;">
        <thead style="border-bottom:1px solid #000">
        <tr class="tr-bdr">

            <th width="50" style="border-right:1px solid #000">Department</th>
            <th width="100" style="border-right:1px solid #000"> >2 Week</th>
            <th width="150" style="border-right:1px solid #000"> >1 Month</th>
            <th width="350" style="border-right:1px solid #000">>2 Month</th>
            <th width="350" style="border-right:1px solid #000">>3 Month</th>    
             </tr>
        </thead>
        <tbody id="checkboxex">
        <?php

        if(sizeof($data)>0){ ?>

        <?php for($i=0;$i<sizeof($data['name']) ;$i++){?>
        <tr>
            <td><?php echo $data['name'][$i];?></td>
            <td><?php echo $data['val1'][$i];?></td>
            <td><?php echo $data['val2'][$i];?></td>
            <td><?php echo $data['val3'][$i];?></td>
            <td><?php echo $data['val4'][$i];?></td>
        </tr>
            
        <?php }  }?>

        </tbody>

    </table>

</body>
</html>