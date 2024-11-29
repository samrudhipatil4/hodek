<html>
	<head>
		<?php require app_path().'/views/apqp_header.php'; ?>
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

                <table class="striped" border="1" style="margin-left: auto;
margin-right: auto;width:60%">
                    <thead>
                    <tr class="tr-bdr">
                    <th width="50">Activity</th>
                    <th width="50">Duration</th>
                    <th width="50">Previous Reference Activity</th>
                    </tr>
                    </thead>
                    <tbody>
                   
                   <?php foreach($withoutPrevAct as $row){?>
                   <tr>
                   <td><?php echo $row['mat_id'].' '.$row['aid'];?></td>
                   <td><?php echo $row['duration'];?></td>
                   <td><?php if($row['prev_act'] == 0){ }else{
                   	echo $row['prev_act'];
                   	} ?></td>
                   </tr>
                   <?php }?>
                   <?php foreach($withPrevAct as $row){ ?>
                   <tr>
                   <td><?php echo $row['mat_id'].' '.$row['aid'];?></td>
                   <td><?php echo $row['duration'];?></td>
                   <td><?php if($row['prev_act'] == 0){ }else{
                   	echo $row['prev_act'];
                   	} ?></td>
                   </tr>
                   <?php }?>
								
                   
                    </tbody>
                </table>

            </div><!--/summary-table-->
            </div>
            </form>
            </div>
	</body>
</html>