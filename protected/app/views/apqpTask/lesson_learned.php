
<?php require app_path().'/views/apqp_header.php'; ?>

  <div class="main-wrapper">
    <div class="container">


              <div class="row two-col-row mg-bottom-0">
                <div class="col-sm-2">
                    
                </div>
                <div class="col-sm-10">

                    <div class="row">
                      <div class="col-sm-12">
                        <div class="page-heading">
                          <h1 style="font-size: 24px;
    font-family: cursive;">Lesson Learned Report </h1>
                      
                        </div><!--/page-heading-->    
                      </div>
                    </div>

                  <div class="content-wrapper">

                    <div class="form-wrapper" ng-controller="apqpLessonLearnCtrl" ng-init="getProject()">
                          


                        <div class="row mg-bottom-0" >
                         
                          <form method="post" role="form"    class="col-sm-12 myform" ng-class="{'submitted': submitted}" id="requestForm" name="requestForm" novalidate ng-submit="(submitted = true) && formdata.$invalid && $event.preventDefault()" enctype="multipart/form-data" autocomplete="off" >
                  
                                   <div class="row mg-btm">
                                <div class="input-field col-sm-6">
                              <label for="initiator_name">Select Project</label>
                              <select class="form-control" select2=""  ng-model="request.proj_no" name="proj_no" ng-change="getLessonAvl(request.proj_no)"  required>
                                  <option  value=""></option>
                                  <option ng-repeat="d in file" value="<%d.id%>"><%d.project_no%></option>
                              </select>
                              <span ng-cloak class="error-msg " ng-show="(requestForm.proj_no.$dirty || invalidSubmitAttempt) && requestForm.proj_no.$error.required"> This field is required.</span>
                          </div>
                                                          

                            </div>
                          <div class="row mg-btm" ng-repeat="field in fields track by $index">
                                    
                                    <div class="col-sm-6 input-field">
                                        <label for="lesson">Lesson Learned</label>
                                       <!--  <input id="lesson<%$index%>"  type="text" class="form-control" ng-model="field.lesson" name="lesson[]"  required> -->
                                        <textarea id="lesson<%$index%>"  type="text" class="form-control" ng-model="field.lesson" name="lesson[]"  required></textarea>
                                       
                                        <span   id="errormsg"  ></span>
                                        
                                        <span class="icon-delete" ng-click="remove($index)" ng-show="$index"><i class="fa fa-times-circle"></i></span>
                                    </div>
                                </div>
                                    <div class="row">
                                      <div class="col-sm-6">
                                      
                                        <button class="btn btn-animate flat blue pd-btn pull-right " id="AddNum" type="button" ng-click="add()" >Add More</button>

                                 
                                    </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 ">
                                            <br>
                                            <button class="btn btn-animate flat blue pd-btn" ng-disabled="isDisabled" type="submit" name="action" ng-click="saveLesson(requestForm)">Save</button>
                                            
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
 
