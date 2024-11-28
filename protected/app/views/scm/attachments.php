<?php require app_path().'/views/header.php'; ?>
  <div class="main-wrapper">
    <div class="container">

              <div class="row two-col-row mg-bottom-0">
                <div class="col-sm-2">
                 
                 <!-- Sidebar Comes here! -->
					
					<?php require app_path().'/views/sidebar.php'; ?>
					
					<!-- sidebar ends here -->
                 
                </div><!--/s2-->
                <div class="col-sm-10">
                  
                  <div class="content-wrapper">

                    <div class="row">
                      <div class="col-sm-12">
                        <div class="page-heading">
                          <h2>Attachments</h2>
                        </div><!--/page-heading-->    
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-12">
                        <div class="table-wrapper">
                            <table class="striped border-none">
                                <thead>
                                  <tr>
                                      <th width="5%">Sr. No.</th>
                                      <th>Files Name</th>
                                  </tr>
                                </thead>

                                <tbody>
                                <?php
                             //   echo '<pre>';
                              //  print_r($attachments);exit;
                                $i=0;
                                foreach($attachments as $attachment){
                                ?>
                                  <tr>
                                    <td><?=++$i;?>.</td>
                                    <td><?php echo $attachment->file_name;?>   <a href="<?php echo Request::root().'/download?path=scm&filename='. $attachment->file_name;?>" data-position="bottom" data-delay="50" data-tooltip="Download"><i class="glyphicon glyphicon-download-alt"></i> </a></td>
                                  </tr>
                                <?php }?>

                                </tbody>
                            </table>
                        </div>
                      </div>
                    </div>
                    
                    
                    

                  </div><!--/content-wrapper-->
                </div><!--/s10-->
              </div><!--/row-->
            
      </div><!--/container-->
  </div><!--/main-wrapper-->
  
  <?php require app_path().'/views/footer.php'; ?>
