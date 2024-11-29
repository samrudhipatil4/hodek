<?php require app_path().'/views/header.php'; ?>


  <div class="main-wrapper">
    <div class="container-fluid">

              <div class="row two-col-row mg-bottom-0">
                <div class="col-sm-2">
                 	<!-- Sidebar Comes here! -->
					
					<?php require app_path().'/views/scm/scm_sidebar.php'; ?>
					
					<!-- sidebar ends here -->
					
					 </div><!--/s2-->
                <div class="col-sm-10">


                  <div class="content-wrapper">                    
                    <div class="row">
                        <div class="col-sm-12">
                        <div class="page-heading mg-btm">
                          <h1>New Change Request Form</h1>
                        </div><!--/page-heading-->    
                      </div>
                    </div>

                      <div class="form-wrapper" ng-controller="ScmaddCtrl">
                          <div class="row ">
                            <?php if(empty(Request::segment(3))){?>
                              <div class="row mg-btm" ng-show="main_form">
                                  <div class="input-field col-sm-6">


                                      <label for="initiator_name">Select Supplier</label>


                                      <select class="form-control "  id="change"  ng-model="request.supplier_id" name="supplier_id" >
                                      <option value="">Select Supplier</option>
                                          <option ng-repeat="d in suppliers" value="<%d.supplier_id%>"><%d.company_name%></option>
                                      </select>

                                  </div>
                                    <div class="input-field col-sm-6  mg-top-23" ng-show="request.supplier_id">

                                    <a class="btn btn-animate flat blue pd-btn"  name="action" ng-click="next(request.supplier_id)">NEXT</a>


                                  </div>
                                  </div>
                                  <?php } ?>
                                 <form method="post" enctype="multipart/form-data" action="<?php echo Request::root().'/scm/supplier/' ?><?php echo Request::segment(3);?>" role="form" class="col-sm-12 myform" ng-class="{'submitted': submitted}" name="requestForm" novalidate ng-submit="(submitted = true) && requestForm.$invalid && $event.preventDefault()" autocomplete="off">

                                  <div >
                                  <?php if( !empty(Request::segment(3))){?>

                                  <div class="row mg-btm">
                                  <div class="input-field col-sm-12">


                                      <label for="initiator_name">Any change done in Last Months</label>



                                  </div>
                                  </div>

                                  <div class="row ">
                                      <div class="input-field col-sm-6">
                                          <label for="change">Man </label>

                                          <select class="form-control "  id="change"  ng-model="request.man" name="man" required>
                                              <option  value="">Select</option>
                                              <option  value="1">YES</option>
                                              <option  value="0">NO</option>

                                          </select>
                                           <span ng-cloak class="error-msg " ng-show="(requestForm.man.$dirty || invalidSubmitAttempt) && requestForm.man.$error.required"> This field is required.</span>

                                      </div>
                                       <div class="input-field col-sm-6" ng-cloak="" ng-if="request.man==1">
                                          <label for="change">Attach File </label>
                                            <input type="file" class="bdr" name="man_file[]" ng-model="request.man_file" multiple="multiple" valid-file ng-required="true">
                                            <span ng-cloak class="error-msg " ng-show="(requestForm.man_file.$dirty || invalidSubmitAttempt) && requestForm.man_file.$error.required"> This field is required.</span>


                                      </div>
                                  </div>
                                  <div class="row ">
                                      <div class="input-field col-sm-6">
                                          <label for="change">Machine </label>

                                          <select class="form-control"  id="change"  ng-model="request.machine" name="machine" required>
                                                <option  value="">Select</option>
                                              <option  value="1">YES</option>
                                              <option  value="0">NO</option>
                                          </select>
                                           <span ng-cloak class="error-msg " ng-show="(requestForm.machine.$dirty || invalidSubmitAttempt) && requestForm.machine.$error.required"> This field is required.</span>

                                      </div>
                                      <div class="input-field col-sm-6" ng-cloak="" ng-if="request.machine==1">
                                          <label for="change">Attach File </label>
                                            <input type="file" name="machine_file[]" ng-model="request.machine_file" multiple="multiple" valid-file ng-required="true">
                                            <span ng-cloak class="error-msg " ng-show="(requestForm.machine.$dirty || invalidSubmitAttempt) && requestForm.machine_file.$error.file"> This field is required.</span>


                                      </div>
                                  </div>
                                  <div class="row ">
                                      <div class="input-field col-sm-6">
                                          <label for="change">Material </label>

                                          <select class="form-control "  id="change"  ng-model="request.material" name="material" required>
                                               <option  value="">Select</option>
                                              <option  value="1">YES</option>
                                              <option  value="0">NO</option>

                                          </select>
                                           <span ng-cloak class="error-msg " ng-show="(requestForm.material.$dirty || invalidSubmitAttempt) && requestForm.material.$error.required"> This field is required.</span>

                                      </div>
                                      <div class="input-field col-sm-6" ng-cloak="" ng-if="request.material==1">
                                          <label for="change">Attach File </label>
                                            <input type="file" name="material_file[]" ng-model="request.material_file" multiple="multiple" valid-file ng-required="true">
                                            <span ng-cloak class="error-msg " ng-show="(requestForm.material_file.$dirty || invalidSubmitAttempt) && requestForm.material_file.$error.file"> This field is required.</span>


                                      </div>
                                  </div>
                                  <div class="row">
                                      <div class="input-field col-sm-6">
                                          <label for="change">Method  </label>

                                          <select class="form-control "  id="change"  ng-model="request.method" name="method" required>

                                             <option  value="">Select</option>
                                              <option  value="1">YES</option>
                                              <option  value="0">NO</option>

                                          </select>
                                           <span ng-cloak class="error-msg " ng-show="(requestForm.method.$dirty || invalidSubmitAttempt) && requestForm.method.$error.required"> This field is required.</span>

                                      </div>
                                      <div class="input-field col-sm-6" ng-cloak="" ng-if="request.method==1">
                                          <label for="change">Attach File </label>
                                            <input type="file" name="method_file[]" ng-model="request.method_file" multiple="multiple" valid-file ng-required="true">
                                            <span ng-cloak class="error-msg " ng-show="(requestForm.method_file.$dirty || invalidSubmitAttempt) && requestForm.method_file.$error.file"> This field is required.</span>


                                      </div>
                                  </div>

                                     <div class="row ">
                              <div class="col-md-3">
                                  <div class="date-form">
                                      <div class="form-horizontal">
                                          <div class="control-group">
                                              <label for="startdate" class="control-label">Set Date</label>
                                              <div class="controls">
                                                  <div class="input-group">
                                                      <input id="startdate" type="text" class="date-picker form-control" name="startdate" ng-model="request.startdate" required/>
                                                      <label for="startdate" class="input-group-addon btn"><span class="glyphicon glyphicon-calendar"></span></label>

                                                  </div>
                                                  <span ng-cloak="" class="error-msg " ng-show="(requestForm.startdate.$dirty || invalidSubmitAttempt) && requestForm.startdate.$error.required"> This field  is required.</span>
                                                  <span ng-cloak="" class="error-msg " ng-show="(requestForm.startdate.$dirty || invalidSubmitAttempt) && requestForm.startdate.$error.valid"> From Date Must Before End Date.</span>

                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              </div>


                                  <div class="row mg-btm">
                                      <div class="input-field col-sm-12">
                                          <label for="textarea">Remark</label>
                                          <textarea id="textarea" rows="3"  class="form-control" ng-model="request.remark" name="remark"></textarea>

                                          <span ng-cloak  class="error-msg " ng-show="(requestForm.remark.$dirty || invalidSubmitAttempt) && requestForm.remark.$error.required"> This field is required.</span>

                                      </div>

                                  </div>

                                  <div class="row">
                                      <div class="col-sm-12">
                                          <button class="btn btn-animate flat blue pd-btn" type="submit" name="action" ng-click="add(requestForm)">Submit</button>

                                          <div class="loading-spiner-holder" data-loading >
                                    <div class="loading-spiner"><img src="<?php echo Request::root(); ?>/protected/public/images/Twirl.gif" />
                                    </div>
                                    </div>
                                      </div>
                                  </div>
                                  <?php }?>
                                  </div>
                              </form>


                          </div>
                      </div>


                      </div><!--/form-wrapper-->

                    

                  </div><!--/content-wrapper-->
                </div><!--/s10-->
              </div><!--/row-->
            
      </div><!--/container-->
  </div><!--/main-wrapper-->
  
<?php require app_path().'/views/footer.php'; ?>