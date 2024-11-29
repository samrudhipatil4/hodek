<?php // echo '<pre>';print_r($res);exit;?>
<?php require app_path().'/views/header.php'; ?>
  <div class="main-wrapper">
    <div class="container">

              <div class="row two-col-row mg-bottom-0">
                
                <div class="col-sm-12">

                    <div class="row">
                      <div class="col-sm-12">
                        <div class="page-heading">
                          <h1>Supplier Change Management Status Monitoring Sheet</h1>
                        </div><!--/page-heading-->    
                      </div>
                    </div>

                  <div class="content-wrapper">
                    
                    <!-- Year 2016 table -->
                    <?php
                    if(isset($res)&& sizeof($res)>0){
                    foreach($res as $year) {?>
                    <div class="row mg-btm">
                      <div class="col-sm-12">
                        <h2 class="table-title"> SCM Status Monitoring Sheet - <?php echo $year['year'];?></h2>
                        <div class="report-wrapper table-overflow">
                        <table class="striped">
                              <tbody>

                                <tr>
                                  <td width="60">Sr. No.</td>
                                  <td width="300">Suppier Name</td>

                                 <?php for ($i = 1; $i <= 12; $i++)
                                    {
                                        $month_name = date('F', mktime(0, 0, 0, $i, 1, 2011));

                                    ?>
                                  <td width="500" class="pd-none">
                                      <table class="borderd-cell">
                                        <tbody>
                                          <tr>
                                            <th class="border-right-0 center-align"><strong>Month <?=$month_name?> <?=$year['year']?></strong></th>
                                          </tr>
                                        </tbody>
                                      </table>
                                      <table class="borderd-cell fixed">
                                        <tbody>                                          
                                          <tr>
                                            <td width="45%"><strong>Supplier is Communicated Done on</strong></td>
                                            <td width="10%"><strong>Man</strong></td>
                                            <td width="15%"><strong>Machine</strong></td>
                                            <td width="15%"><strong>Material</strong></td>
                                            <td width="15%"><strong>Method</strong></td>
                                          </tr>                                            
                                        </tbody>
                                      </table>
                                  </td>
                                  <?php } ?>


                                 </tr>


                                <?php $count=0;
                                foreach($year['supplierdata'] as $supplier) {?>
                                <tr>

                                  <td><?=++$count;?>.</td>
                                  <td><?=$supplier['company_name']?></td>
                                  <?php for ($i = 1; $i <= 12; $i++){
                                    if(!empty($supplier['supplierdata1'][$i-1])){?>
                                      <td width="500" class="pd-none">
                                    <table class="borderd-cell fixed">
                                      <tbody>
                                        <tr>
                                          <td width="45%"><?php
                                          // echo $supplier['supplierdata1'][$i-1]->created_at;

                                            $date=explode(' ',$supplier['supplierdata1'][$i-1]->created_at);
                                            $date1=explode('-',$date[0]);

                                            echo $date1[2].'.'.$date1[1].'.'.$date1[0];



                                            ?></td>

                                          <?php if($supplier['supplierdata1'][$i-1]->man==0){
                                            echo '<td width="10%" class="td_green">NO</td>';

                                            }else{?>
                                          <td width="10%" class="td_red">
                                              <a href="<?php echo Request::root().'/scm/view_attachments/' ?><?=$supplier['supplierdata1'][$i-1]->id?>" target="_blank" class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="View Attachments">YES</a>
                                          </td>
                                            <?php } ?>


                                 <?php if($supplier['supplierdata1'][$i-1]->machine==0){echo ' <td width="15%" class="td_green">NO</td>';

                                            }else{?>
                                          <td width="10%" class="td_red">
                                              <a href="<?php echo Request::root().'/scm/view_attachments/' ?><?=$supplier['supplierdata1'][$i-1]->id?>" target="_blank"  class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="View Attachments">YES</a>
                                        </td>
                                            <?php } ?>



                                          <?php if($supplier['supplierdata1'][$i-1]->material==0){echo '<td width="15%" class="td_green">NO</td>';

                                            }else{?>
                                          <td width="15%" class="td_red">
                                              <a href="<?php echo Request::root().'/scm/view_attachments/' ?><?=$supplier['supplierdata1'][$i-1]->id?>" target="_blank"  class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="View Attachments">YES</a>
                                          </td>
                                            <?php } ?>



                                          <?php if($supplier['supplierdata1'][$i-1]->method==0){echo '<td width="15%" class="td_green">NO</td>';

                                            }else{?>
                                          <td width="15%" class="td_red">
                                              <a href="<?php echo Request::root().'/scm/view_attachments/' ?><?=$supplier['supplierdata1'][$i-1]->id?>" target="_blank"  class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="View Attachments">YES</a>
                                        </td>
                                            <?php } ?>

                                        </tr>
                                      </tbody>
                                    </table>
                                  </td>
                                   <?php }else{?>
                                      <td width="500" class="pd-none">
                                    <table class="borderd-cell fixed">
                                      <tbody>
                                        <tr>
                                          <td width="45%">---</td>
                                          <td width="10%">---</td>
                                          <td width="15%">---</td>
                                          <td width="15%">---</td>
                                          <td width="15%">---</td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </td>

                                 <?php   }?>

                                  <?php }

                                  }?>



                                </tr>



                              </tbody>
                          </table>

                        </div><!--/table-overflow-->
                      </div><!--/s12-->
                    </div><!--/row-->
                    <?php } }?>

                  </div><!--/content-wrapper-->
                </div><!--/s10-->
              </div><!--/row-->
            
      </div><!--/container-->
  </div><!--/main-wrapper-->
    <?php require app_path().'/views/footer.php'; ?>
