<?php require app_path().'/views/header.php'; ?>

  <div class="main-wrapper">
    <div class="container">

              <div class="row two-col-row mg-bottom-0">

                <div class="col-sm-12">

                    <div class="row mg-btm">
                      <div class="col-sm-6">
                        <div class="page-heading">
                          <h1 class="border-none">User Manual</h1>

                        </div><!--/page-heading-->
                      </div>
                      
                    </div>

                    <div class="seprator"></div>

                  <div class="content-wrapper">

                    <!-- view report -->
                    <div class="row mg-btm">
                      <div class="input-field col-sm-6">
                        
                          <a href="<?php echo Request::root().'/helpdownloaddev'?>" data-position="bottom" data-delay="50" data-tooltip="View" target="_blank" style="color: #1D71A4"><b>Manual For Development Change Request</b></a>
                          
                      </div>
                      
                    </div>

                    <div class="row mg-btm">
                      <div class="input-field col-sm-6">
                        
                          <a href="<?php echo Request::root().'/helpdownloadser'?>" data-position="bottom" data-delay="50" data-tooltip="View" target="_blank" style="color: #1D71A4"><b>Manual For Series Change Request</b></a>
                          
                      </div>
                      
                    </div>
                    <div class="row mg-btm">
                      <div class="input-field col-sm-6">
                        
                          <a href="<?php echo Request::root().'/helpdownloadsummaryrepot'?>" data-position="bottom" data-delay="50" data-tooltip="View" target="_blank" style="color: #1D71A4"><b>Manual For Summary Interpretation Report</b></a>
                      </div>
                     </div>

                  </div><!--/content-wrapper-->
                </div><!--/s10-->
              </div><!--/row-->

      </div><!--/container-->
  </div><!--/main-wrapper-->

  <?php require app_path().'/views/footer.php'; ?>
