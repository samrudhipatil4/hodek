<style>
    .btn-back {
        color: #34B0E6 !important;
        cursor: pointer;
        font-weight: 400;
    }
    .btn-back:hover { color: #282828 !important;}
</style>
<?php require app_path().'/views/apqp_header.php'; ?>
 
  <div class="main-wrapper">
    <div class="container" ng-controller="gantchartCtrl">

              <div class="row two-col-row mg-bottom-0" >
                  
                
         <div class="col-sm-2">
              
                </div><!--/s2-->
                <div class="col-sm-10">
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="page-heading">
                          <h1 style="font-size: 24px;
    font-family: cursive;">Project Documentation Report</h1>
                        </div><!--/page-heading-->    
                      </div>
                    </div>
                  <div class="content-wrapper">
                    
                    <div class="form-wrapper" >
                        <div class="row mg-bottom-0">
                            <div class="loading-spiner-holder" data-loading ><div class="loading-spiner"><img src="<?php echo Request::root(); ?>/protected/public/images/Twirl.gif" /></div></div>
                           <form method="post"  role="form" action="<?php echo Request::root().'/getProjDocReport'; ?>" class="col-sm-12 myform" ng-class="{'submitted': submitted}" name="requestForm" novalidate ng-submit="(submitted = true) && requestForm.$invalid && $event.preventDefault()" autocomplete="off">
                             <div class="row mg-btm">
                                <div class="input-field col-sm-6">
                              <label for="initiator_name">Select Project</label>
                              <select class="form-control" select2=""  ng-model="request.proj_no" name="proj_no"  required>
                                  <option  value=""></option>
                                  <option ng-repeat="d in file" value="<%d.id%>"><%d.project_no%></option>
                              </select>
                              <span ng-cloak class="error-msg " ng-show="(requestForm.proj_no.$dirty || invalidSubmitAttempt) && requestForm.proj_no.$error.required"> This field is required.</span>
                          </div>
                                                          

                            </div>

                              
                               </div>
                            <div class="row">
                              <div class="col-sm-12 ">
                                <button class="btn btn-animate flat blue pd-btn " type="submit" name="action" ng-click="checkVal(requestForm)">Submit</button>
                                <!-- <button class="btn " type="reset">Clear</button>-->
                              </div>
                            </div>

                          </form>
                        </div><!--/row-->
                    </div><!--/form-wrapper-->
                    

                    
                  </div><!--/content-wrapper-->
                </div><!--/s10-->
              </div><!--/row-->
               
              
             
                
                </div><!--/row-->
            
      </div><!--/container-->
  </div><!--/main-wrapper-->

  
    <?php require app_path().'/views/footer.php'; ?>
