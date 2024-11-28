<?php require app_path().'/views/apqp_header.php'; ?>







<div class="col-sm-12" >

    <div class="row">
        <div class="col-sm-8">
            <div class="page-heading">
                <h1 style="font-size: 24px;
    font-family: cursive;">Lesson Learned Report </h1>
            </div><!--/page-heading-->

        </div>
        <div class="col-sm-4">
            <div class="page-heading pull-right">
                <a class="btn btn-animate flat blue pd-btn" href="<?php echo Request::root().'/lesson_learned_report'; ?>">Back To Search</a>
            </div><!--/page-heading-->


        </div>
    </div>
    <form method="post" action="<?php echo Request::root().'/lessonReport/download'; ?>">
        <div class="content-wrapper">

            <div class="row mg-btm">
                <div class="col-sm-6">
                <input type="hidden" name="proj_no" value="<?=$formInput['proj_no'];?>">
                    



                    <div class="action-group pd-top">
                        <form method="post" action="">
                            <button class="btn btn-animate flat blue pd-btn "  value="excel" name="filetype" type="submit">Export to Excel Sheet</button>
                            <button class="btn btn-animate flat blue pd-btn "  value="pdf" name="filetype" type="submit">Export to PDF</button>
                        </form>
                    </div>



                </div>
               
            </div>

            <!-- summary Table start -->
            <div class="summary-table report-wrapper scrollbarX">

                <table class="striped">
                    <thead>
                    <tr class="tr-bdr">

                        <th width="50">Sr. No.</th>
                        <th width="100">Project Number</th>
                        <th width="150">Project Name</th>
                        <th width="150">Manufacturing Location</th>
                         <th width="150">Project Start Date</th>
                        <th width="250">Lessons</th>
                        
                    </tr>
                    </thead>
                    <tbody id="checkboxex">
                    <?php

                    if(sizeof($data)>0){

                        $i=0;
                        foreach($data as $jobs){  ?>

                                <tr>

                                    

                                    <td><?=++$i?>.</td>

                                    <td>
                                        <?=$jobs['Project_no'].' '.$jobs['checkHold'].' '.$jobs['checkDrop'];?>
                                   </td>



                                    <td><?= $jobs['project_name'];?></td>
                                    <td><?= $jobs['mfg_location'];?></td>
                                    <td><?= $jobs['proj_start_date'];?></td>
                                    <td>

                                        <?php
                                        if(isset($jobs['lesson'])&& !empty($jobs['lesson']) ){?>
                                            <ul class="listing bdr-btm no-pd">

                                                <?php foreach($jobs['lesson'] as $lesson){  ?>

                                                    <li>
                                                        <span><?=$lesson->lesson;?></span>

                                                    </li>
                                                <?php } ?>
                                            </ul>

                                    </td>
                                    


                                    <?php } ?>
                                </tr>

                            <?php } }   else{?>
                        <tr>
                            No Records Found.

                        </tr>
                    <?php } ?>
                    </tbody>
                </table>

            </div><!--/summary-table-->


            <!-- summary Table end -->

        </div><!--/content-wrapper-->

    </form>
</div><!--/s10-->
<?php require app_path().'/views/footer.php'; ?>



