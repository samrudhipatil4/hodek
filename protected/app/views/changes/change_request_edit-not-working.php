<!DOCTYPE html>
<?php
function getMultiSelect($aComplete=array(),$aUsed=array()){
    $aNotUsed=array_diff($aComplete,$aUsed);
    $control='<form>';
    $control.='<select style="margin: 0px; padding: 0px; border: 0px none; display: none;" id="tokenize_focus" class="tokenize-sample" multiple="multiple">';
    $key=0;
    if(isset($aUsed) && !empty($aUsed)){

        foreach($aUsed as $data){
            $control.='<option selected="selected" value="'.$key++.'">'.$data.'</option>';
        }
    }
    if(isset($aNotUsed) && !empty($aNotUsed)){
        foreach($aNotUsed as $data){
            $control.='<option value="'.$key++.'">'.$data.'</option>';
        }
    }
    $control.='</select>';
    $control.='<div class="tokenize-sample Tokenize">';
    $control.='<ul class="TokensContainer">';
    $control.='<li class="TokenSearch"><input size="5"></li>';
    $control.='</ul>';
    $control.='<ul style="display: none;" class="Dropdown"></ul>';
    $control.='</div></form>';
    echo $control;
}
?>
<?php require app_path().'/views/header.php'; ?>


<link href="<?php echo Request::root(); ?>/protected/public/css/tokenize.css" rel="stylesheet">
<!--<link href="<?php// echo Request::root(); ?>/protected/public/css/styles.css" rel="stylesheet">-->
<link href="<?php echo Request::root(); ?>/protected/public/css/jquery.css" rel="stylesheet">


    <script type="text/javascript" src="<?php echo Request::root(); ?>/protected/public/js/jquery.js"></script>
    <script type="text/javascript" src="<?php echo Request::root(); ?>/protected/public/js/jquery-ui.js"></script>
    <script type="text/javascript" src="<?php echo Request::root(); ?>/protected/public/js/tokenize.js"></script>




  <div class="main-wrapper">
    <div class="container-fluid">

              <div class="row two-col-row mg-bottom-0">
                <div class="col-sm-2">
                 	<!-- Sidebar Comes here! -->

					<?php require app_path().'/views/sidebar.php'; ?>

					<!-- sidebar ends here -->

					 </div><!--/s2-->
                <div class="col-sm-10">

                  <div class="row">
                      <div class="col-sm-12">
                        <div class="page-heading">
                          <h1>Add Change Request</h1>
                        </div><!--/page-heading-->
                      </div>
                    </div>

                  <div class="content-wrapper">
                    <div class="row">
                        <div class="col-sm-12">
                        <div class="page-heading mg-btm">
                          <h1>New Change Request Form</h1>
                        </div><!--/page-heading-->
                      </div>
                    </div>

                      <?php

                      $request = json_decode( file_get_contents(Request::root().'/protected/app/views/changes/temp.php') );
                      $variable = $request;



                      print_r($variable);


                      $aComplete=array("1"=>"Mohan","2"=>"seeta","3"=>"GEETA");
                      if(isset($_GET['id'])){
                          $aUsed=array("1"=>"Mohan");
                      }else{
                          $aUsed=array();
                      }
                      getMultiSelect($aComplete,$aUsed);
                      ?>

                      <div class="form-wrapper" ng-controller="EditchangereqCtrl" ng-init="editrequestinfo('<?php echo Request::segment(3); ?>')" >
                          <div class="row">
                              <form method="post" role="form" class="col-sm-12 myform" ng-class="{'submitted': submitted}" name="requestForm" novalidate ng-submit="(submitted = true) && requestForm.$invalid && $event.preventDefault()" autocomplete="off">

                              <div class="row mg-btm">
                                  <div class="input-field col-sm-6">


                                      <label for="initiator_name">Select Plant Code</label>


                                      <select class="form-control"   id="change"  ng-model="request.plant_id" name="plant_id" required>
                                            <option  value=""></option>

                                          <option ng-repeat="d in plantcodes" value="<%d.plant_id%>"><%d.plant_code%></option>

                                      </select>
                                    <span ng-cloak class="error-msg " ng-show="(requestForm.plant_id.$dirty || invalidSubmitAttempt) && requestForm.plant_id.$error.required"> This field is required.</span>


                                  </div>
                                      <div class="input-field col-sm-6">
                                          <label for="Change-Stage">Select Change Stage</label>
                                          <select class="form-control"  id="Change-Stage" name="change_stage_id" ng-model="request.change_stage" required >
                                             <option  value=""></option>
                                              <option ng-repeat="data in changestage" value="<%data.change_stage_id%>"><%data.stage_name%></option>

                                          </select>


                                          <span ng-cloak class="error-msg " ng-show="(requestForm.change_stage_id.$dirty || invalidSubmitAttempt) && requestForm.change_stage_id.$error.required"> This field is required.</span>

                                      </div>
                                  </div>
                                  <div class="row mg-btm">
                                      <div class="input-field col-sm-6">
                                          <label for="dept">Select Department</label>
                                          <select class="form-control" ng-model="request.dep_id" name="dep_name" ng-change="fill_sub_department(request.dep_id)" required>
                                             <option  value=""></option>
                                              <option ng-repeat="department in departments" value="<%department.d_id%>"><%department.d_name%></option>

                                          </select>


                                          <span ng-cloak class="error-msg " ng-show="(requestForm.dep_name.$dirty || invalidSubmitAttempt) && requestForm.dep_name.$error.required"> This field is required.</span>

                                      </div>
                                      <div class="input-field col-sm-6" ng-show="sub_dep">
                                          <label for="dept">Select Sub-Department</label>
                                          <select class="form-control" ng-model="request.sub_dep_id" name="sub_dep_id" >
                                                         <option  value=""></option>
                                              <option ng-repeat="d in sub_departments" value="<%d.sub_dep_id%>"><%d.sub_dep_name%></option>
                                          </select>


                                          <span ng-cloak class="error-msg " ng-show="(requestForm.sub_dep_id.$dirty || invalidSubmitAttempt) && requestForm.sub_dep_id.$error.required"> This field is required.</span>

                                      </div>
                                  </div>
                                  <div class="row mg-btm">
                                      <div class="input-field col-sm-6">
                                          <label for="changeType">Select Change Type</label>
                                          <select class="form-control" id="changeType" ng-model="request.changeType" name="changeType" ng-change="fill_customer_name(request.changeType)" required>
                                                 <option  value=""></option>
                                              <option ng-repeat="data in changetype" value="<%data.change_type_id%>"><%data.change_type_name%></option>

                                          </select>

                                          <span ng-cloak class="error-msg " ng-show="(requestForm.changeType.$dirty || invalidSubmitAttempt) && requestForm.changeType.$error.required"> This field is required.</span>

                                      </div>
                                      <div class="input-field col-sm-6"  ng-show="hideoption=='hide'">
                                          <label for="design">Select Customer Name</label>
                                          <select class="form-control js-example-placeholder-single " id="design" ng-model="request.customer_id" name="customer_id"  >
                                           <option  value=""></option>

                                              <option ng-repeat="customer in customers" value="<%customer.CustomerId%>"><%customer.FirstName%> <%customer.LastName%></option>

                                          </select>


                                          <span ng-cloak  class="error-msg " ng-show="(requestForm.customer_id.$dirty || invalidSubmitAttempt) && requestForm.customer_id.$error.required"> This field is required.</span>

                                      </div>

                                      <div class="input-field col-sm-6 sel" ng-show="hideoption=='show'">
                                          <label for="design">Select Customer Name</label>
                                          <select class="form-control" id="design" multiple ng-model="request.customer_id1" name="customer_id1"  >
                                           <option  value=""></option>


                                              <option ng-repeat="customer in customers" value="<%customer.CustomerId%>"><%customer.FirstName%> <%customer.LastName%></option>


                                          </select>


                                          <span ng-cloak class="error-msg " ng-show="(requestForm.customer_id1.$dirty || invalidSubmitAttempt) && requestForm.customer_id1.$error.required"> This field is required.</span>

                                      </div>
                                  </div>
                                <!--  <div class="row mg-btm">
                                      <div class="input-field col-sm-12 sel">
                                          <label for="change">Select Parts</label>

                                          <select class="form-control js-example-placeholder-multiple" multiple id="change"  ng-model="request.partinfo" name="partinfo" required>
                                           <option  value=""></option>

                                              <option ng-repeat="part in parts" value="<%part.id%>"><%part.Part_Name%> (<%part.Auto_Part_number%>)</option>

                                          </select>
                                           <span ng-cloak class="error-msg " ng-show="(requestForm.partinfo.$dirty || invalidSubmitAttempt) && requestForm.partinfo.$error.required"> This field is required.</span>

                                      </div>
                                  </div>-->




                            <div class="row mg-btm" ng-repeat="field in fields track by $index">

                             <div class="col-sm-6 input-field">
                               <label for="ext-name">Existing Part Name</label>
                                <input id="ext-name" type="text" class="form-control" ng-model="request.part_name" name="extName[]" required>
                                <span ng-cloak class="error-msg " ng-show="(requestForm.extName.$dirty || invalidSubmitAttempt) && requestForm.extName.$error.required"> This field is required.</span>



                              </div>
                              <div class="col-sm-6 input-field">
                               <label for="ext-number">Existing Part Number</label>
                                <input id="ext-number" type="text" class="form-control" ng-model="request.part_number" name="extNumber[]" required>
                                <span ng-cloak class="error-msg " ng-show="(requestForm.extNumber.$dirty || invalidSubmitAttempt) && requestForm.extNumber.$error.required"> This field is required.</span>
                                 <span class="icon-delete" ng-click="remove($index)" ng-show="$index"><i class="fa fa-times-circle"></i></span>


                              </div>

                            </div>

                            <div class="row">
                              <div class="input-field col-sm-12">
                                <button class="btn btn-animate flat blue pd-btn pull-right" type="button" ng-click="add()">Add More</button>
                              </div>
                            </div>






                                  <div class="row mg-btm">
                                      <div class="input-field col-sm-12 sel">
                                          <label for="change">Select Purpose of Change</label>
                                          <!-- <dropdown-multiselect dropdown-title="Select Something" pre-selected="member1" model="selected_items" options="states"></dropdown-multiselect> <pre>selected roles = <%selected_items | json%></pre>-->
      <!--  <dropdown-multiselect dropdown-title="Select Something" pre-selected="member.change_purpose" ng-model="selected_items" options="states"></dropdown-multiselect> <pre>selected roles = <%selected_items | json%></pre>
-->

                                          <!--  <select class="form-control" multiple id="change"  ng-model="request.change_purpose" name="changerequest_purpose" required>
                                             <option  value=""></option>

                                              <option ng-repeat="d in purposechange"value="<%d.id%>"><%d.changerequest_purpose%></option>

                                          </select>

                                           <span ng-cloak class="error-msg " ng-show="(requestForm.changerequest_purpose.$dirty || invalidSubmitAttempt) && requestForm.changerequest_purpose.$error.required"> This field is required.</span>
                                            -->




                                      </div>

                                      <script type="text/javascript">
                                          $('select#tokenize_focus').tokenize({displayDropdownOnFocus: true});
                                      </script>
                                  </div>

                                  <div class="row mg-btm">
                                      <div class="input-field col-sm-12">
                                          <label for="textarea1">Proposed Modification Details</label>
                                          <textarea id="textarea1" rows="3"  class="form-control" ng-model="request.Purpose_Modification_Details" name="Purpose_Modification_Details" required></textarea>

                                          <span ng-cloak class="error-msg " ng-show="(requestForm.Purpose_Modification_Details.$dirty || invalidSubmitAttempt) && requestForm.Purpose_Modification_Details.$error.required"> This field is required.</span>

                                      </div>
                                  </div>
                                  <div class="row mg-btm">
                                      <div class="input-field col-sm-6">
                                          <label for="approval">Approval Authority from Department HOD</label> <span><%hod.first_name%></span> <span><%hod.last_name%></span>
                                          <input type="hidden"  name="Approval_Authority" id="Approval_Authority" value="<%hod.id%>" >

                                          <!--
                                          <select class="form-control js-example-placeholder-single" id="approval" ng-model="request.Approval_Authority" name="Approval_Authority" required>
                                                 <option  value=""></option>
                                              <option ng-repeat="d in hoddepartments" value="<%d.user_id%>"><%d.name%></option>

                                          </select>

                                          <span ng-cloak class="error-msg " ng-show="(requestForm.Approval_Authority.$dirty || invalidSubmitAttempt) && requestForm.Approval_Authority.$error.required"> This field is required.</span>
                                            -->
                                      </div>

                                  </div>
                                  <div class="row mg-btm mg-btm">
                                      <div class="input-field col-sm-12">
                                          <label for="textarea">Remark</label>
                                          <textarea id="textarea" rows="3"  class="form-control" ng-model="request.remark" name="remark"></textarea>

                                          <span ng-cloak  class="error-msg " ng-show="(requestForm.remark.$dirty || invalidSubmitAttempt) && requestForm.remark.$error.required"> This field is required.</span>

                                      </div>

                                  </div>



                                  <div class="row">
                                      <div class="col-sm-12 ">
                                          <button class="btn btn-animate flat blue pd-btn" type="submit" name="action" ng-click="addRequest(requestForm,1)">Submit</button>
                                          <button class="btn btn-animate flat blue pd-btn" type="submit" ng-click="addRequest(requestForm,5)">Update</button>
                                           <div class="loading-spiner-holder" data-loading >
                                    <div class="loading-spiner">
                                    <img src="<?php echo Request::root(); ?>/protected/public/images/Twirl.gif" />
                                    </div>
                                    </div>
                                      </div>
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
