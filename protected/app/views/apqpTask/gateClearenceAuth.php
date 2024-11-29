<?php require app_path().'/views/apqp_header.php'; ?>

  <div class="main-wrapper">
    <div class="container">


              <div class="row two-col-row mg-bottom-0">
                <div class="col-sm-2">
                    
                </div><!--/s2-->
                <div class="col-sm-10">

                    <div class="row">
                      <div class="col-sm-12">
                        <div class="page-heading">
                          <h1>User Task</h1>
                      
                        </div><!--/page-heading-->    
                      </div>
                    </div>

                  <div class="content-wrapper">

                    <div class="form-wrapper" ng-controller="apqpTaskCtrl" >
                        <div class="row mg-bottom-0">
                         
                          <form method="post" role="form"   action="<?php echo Request::root().'/apqp/clrTask/'.Request::segment(4).'/'.Request::segment(5); ?>" class="col-sm-12 myform" ng-class="{'submitted': submitted}"  name="formdata" novalidate ng-submit="(submitted = true) && formdata.$invalid && $event.preventDefault()" enctype="multipart/form-data" autocomplete="off">

                            
                           <div class="row mg-btm mg-btm" ">
                                       <div class="input-field col-sm-4">
                                        <label for="textarea1">OK</label>
                                      <input class="with-gap" type="radio" id="close" name="radioStatus" ng-model="act.radioStatus" value="4"/>
                                        <span ng-cloak class="error-msg " ng-show="(formdata.asdate.$dirty || invalidSubmitAttempt) && formdata.asdate.$error.required"> This field is required.</span>
                                    </div>
                                    
                                    </div>
                             
                            <br>
                            <div class="row">
                              <div class="col-sm-4 ">
                                  <button class="btn btn-animate flat blue pd-btn" name="submitForm" type="submit"    value="OK" >Send</button>
                              
                                  <div class="loading-spiner-holder" data-loading >
                                      <div class="loading-spiner">
                                          <img src="<?php echo Request::root(); ?>/protected/public/images/Twirl.gif" />
                                      </div>
                                  </div>
                              </div>
                            </div> 

                            </form>
                        </div>
                    </div><!--/form-wrapper-->


                  </div><!--/content-wrapper-->
                </div><!--/s10-->
              </div><!--/row-->
            
      </div><!--/container-->
  </div><!--/main-wrapper-->



<?php require app_path().'/views/footer.php'; ?>
 <script type="text/javascript">

        $("#cost").keydown(function (e) {

        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
</script> 
