<?php require app_path().'/views/header.php'; ?>

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
                    <div class="form-wrapper select-height" ng-controller="changereqCtrl">
                        <div class="row">
                            <form method="post" role="form" class="col-sm-12 myform" ng-class="{'submitted': submitted}" name="requestForm" novalidate ng-submit="(submitted = true) && requestForm.$invalid && $event.preventDefault()"  autocomplete="off">
                                <div class="row mg-btm">

                                    <div class="input-field col-sm-6">
                                        <label for="initiator_name">Select Business</label>
                                        <select class="form-control" select2=""  ng-model="request.business" name="business" ng-change="checkPrjApply(request.business)" required>
                                            <option  value=""></option>
                                            <option ng-repeat="d in business" value="<%d.id%>"><%d.busi_code%></option>
                                        </select>
                                        <span ng-cloak class="error-msg " ng-show="(requestForm.business.$dirty || invalidSubmitAttempt) && requestForm.business.$error.required"> This field is required.</span>
                                    </div>
                                    <div class="input-field col-sm-6" ng-if="disPrj == false">
                                        <label for="stakeholder">Select Project Code</label>
                                        <select class="form-control" select2=""  id="project_code" ng-model="request.project_code" name="project_code" ng-change="getStage(request.project_code)" required="">
                                            <option  value=""></option>
                                            <option ng-repeat="d in project_code" value="<%d.id%>"><%d.project_code%></option>
                                        </select>
                                        <span ng-cloak class="error-msg " ng-show="(requestForm.project_code.$dirty || invalidSubmitAttempt) && requestForm.project_code.$error.required"> This field is required.</span>
                                    </div>
                                    <div class="input-field col-sm-6" ng-if="disPrj == true">
                                        <label for="stakeholder">Select Project Code</label>
                                        <select class="form-control" select2=""  id="project_code" ng-model="request.project_code" name="project_code" ng-change="getStage(request.project_code)" ng-disabled="disPrj">
                                            <option  value=""></option>
                                            <option ng-repeat="d in project_code" value="<%d.id%>"><%d.project_code%></option>
                                        </select>
                                        <span ng-cloak class="error-msg " ng-show="(requestForm.project_code.$dirty || invalidSubmitAttempt) && requestForm.project_code.$error.required"> This field is required.</span>
                                    </div>
                                    <div class="input-field col-sm-6">
                                        <label for="initiator_name">Select Manufacturing location</label>
                                        <select class="form-control" select2="" ng-change="getProjectcode(request.plant_id)" ng-model="request.plant_id" name="plant_id" required>
                                            <option  value=""></option>
                                            <option ng-repeat="d in plantcodes" value="<%d.plant_id%>"><%d.plant_code%></option>
                                        </select>
                                        <span ng-cloak class="error-msg " ng-show="(requestForm.plant_id.$dirty || invalidSubmitAttempt) && requestForm.plant_id.$error.required"> This field is required.</span>
                                    </div>
                                    <div ng-if="dropdownView == true" class="input-field col-sm-6">
                                        <label for="Change-Stage">Select Change Stage</label>
                                        <select class="form-control" select2="" name="change_stage_id"  id="change_stage_id" ng-model="request.change_stage_id" ng-change="getDispatchLocation(request.change_stage_id);" required >
                                            <option  value=""></option>
                                            <option ng-repeat="data in changestage" value="<%data.change_stage_id%>" ><%data.stage_name%></option>
                                        </select>
                                        <span ng-cloak class="error-msg " ng-show="(requestForm.change_stage_id.$dirty || invalidSubmitAttempt) && requestForm.change_stage_id.$error.required"> This field is required.</span>
                                    </div>
                                    <div ng-if="textView == true" class="input-field col-sm-6">
                                        <label for="Change-Stage">Select Change Stage</label>
                                        <input type="text" name="change_stage_id" id="change_stage_id" ng-model='stage.stage_name' value="<% stage.change_stage_id%>" ng-disabled="true"> 
                                        <input type="hidden" name="change_stage" id="change_stage"  value="<% stage.change_stage_id%>" ng-disabled="true"> 
                                       
                                        
                                        <span ng-cloak class="error-msg " ng-show="(requestForm.change_stage_id.$dirty || invalidSubmitAttempt) && requestForm.change_stage_id.$error.required"> This field is required.</span>
                                    </div>
                                    
                                </div>
                                <div class="row mg-btm">
                                    <div class="input-field col-sm-6">
                                        <label for="stakeholder">Select Stakeholder</label>
                                        <select class="form-control" select2=""  ng-model="request.stakeholder" name="stakeholder" required>
                                            <option  value=""></option>
                                            <option ng-repeat="d in stakeholder" value="<%d.id%>"><%d.name%></option>
                                        </select>
                                        <span ng-cloak class="error-msg " ng-show="(requestForm.stakeholder.$dirty || invalidSubmitAttempt) && requestForm.stakeholder.$error.required"> This field is required.</span>
                                    </div>
                                    
                                    <div class="input-field col-sm-6" id='disloc' ng-if="disloc==true">
                                         <label for="stakeholder">Select Dispatch location</label>
                                        <select class="form-control" select2="" ng-model="request.dispatch_loc" name="dispatch_loc" required="">
                                            <option  value=""></option>
                                            <option ng-repeat="d in plantcodes" value="<%d.plant_id%>"><%d.plant_code%></option>
                                        </select>
                                        <span ng-cloak class="error-msg " ng-show="(requestForm.dispatch_loc.$dirty || invalidSubmitAttempt) && requestForm.dispatch_loc.$error.required"> This field is required.</span>
                                    </div>
                                    
                                </div>
                                <div class="row mg-btm">
                                    <div class="input-field col-sm-6" ng-if="viewdeptIni==false">
                                        <label for="dept">Select Initiator Department</label>
                                        <select class="form-control" select2="" ng-model="request.dep_id" name="dep_name" ng-change="fill_sub_department(request.dep_id)" required>
                                            <option  value=""></option>
                                            <option ng-repeat="department in departments" value="<%department.d_id%>"><%department.d_name%></option>
                                        </select>
                                        <input type="hidden" name="displayDept" id="displayDept"   value=""> 
                                        <input type="hidden" name="dpt_id_view" id="dpt_id_view"   value="<%dept_id_view%>"> 
                                        <span ng-cloak class="error-msg " ng-show="(requestForm.dep_name.$dirty || invalidSubmitAttempt) && requestForm.dep_name.$error.required"> This field is required.</span>
                                    </div>
                                    <div  class="input-field col-sm-6" ng-if="viewdeptIni==true">
                                        <label for="Change-Stage">Select Initiator Department</label>
                                        <input type="text" name="dep_id" id="dep_id" ng-model='iniDept.d_name' value="<% stage.department%>" ng-disabled="true"> 
                                        <input type="hidden" name="dep_id1" id="dep_id1"  value="<% iniDept.department%>" > 
                                        <input type="hidden" name="displayDept" id="displayDept"   value="displayDept"> 
                                       
                                        
                                        
                                    </div>
                                    <div class="input-field col-sm-6" ng-if="sub_dep && viewdeptIni==false" >
                                        <label for="dept">Select Initiator Sub-Department</label>
                                        <select class="form-control" select2="" ng-model="request.sub_dep_id" name="sub_dep_id" ng-change="getSubDept(request.sub_dep_id)" >
                                            <option  value=""></option>
                                            <option ng-repeat="d in sub_departments" value="<%d.sub_dep_id%>"><%d.sub_dep_name%></option>
                                            
                                        </select>
                                        <input type="hidden"  id="sub_dep_id"  value="<% sub_dep_id%>" > 
                                        <span ng-cloak class="error-msg " ng-show="(requestForm.sub_dep_id.$dirty || invalidSubmitAttempt) && requestForm.sub_dep_id.$error.required"> This field is required.</span>
                                    </div>
                                    <div  class="input-field col-sm-6" ng-if="viewdeptIni==true && iniDept.sub_dep_name !=null">
                                        <label for="Change-Stage">Select Initiator Sub-Department</label>
                                        <input type="text" name="sub_dep_id" id="sub_dep_id" ng-model='iniDept.sub_dep_name' value="<% stage.change_stage_id%>" ng-disabled="true"> 
                                        <input type="hidden" name="sub_dep_id1" id="sub_dep_id1"  value="<% iniDept.sub_dep_id%>" ng-disabled="true"> 
                                       
                                        
                                        
                                    </div>
                                </div>
                                <div class="row mg-btm">
                                    <div class="input-field col-sm-6">
                                        <label for="changeType">Select Change Type</label>
                                        <select class="form-control" select2=""  ng-model="request.changeType" name="changeType" ng-change="fill_customer_name(request.changeType);fillSubChangeType(request.changeType)" required>
                                            <option  value=""></option>
                                            <option ng-repeat="data in changetype" value="<%data.change_type_id+'@'+data.change_type_cust_mapping+'@'+data.change_type_part_mapping%>"><%data.change_type_name%></option>
                                        </select>
                                        <span ng-cloak class="error-msg " ng-show="(requestForm.changeType.$dirty || invalidSubmitAttempt) && requestForm.changeType.$error.required"> This field is required.</span>
                                    </div>
                                    <div class="input-field col-sm-6 sel" ng-if="sub_type">
                                        <label for="design">Select Change Sub Type</label>
                                        <select class="form-control" select2="" multiple ng-model="request.sub_type_id" name="sub_type_id" required>
                                           
                                             <option  value=""></option>
                                            <option ng-repeat="d in sub_type_name" value="<%d.sub_type_id%>"><%d.sub_type_name%></option>
                                        </select>
                                        <span ng-cloak class="error-msg " ng-show="(requestForm.sub_type_id.$dirty || invalidSubmitAttempt) && requestForm.sub_type_id.$error.required"> This field is required.</span>
                                    </div>
                                    
                                </div>
                                
                                 <div class="row mg-btm">
                                    
                                    <div class="input-field col-sm-6"  ng-if="CustMap=='Single'">
                                        <label for="design">Select Customer Name</label>
                                        <select class="form-control" select2="" name="customer_id" data-ng-model="request.customer_id" required>
                                            <!-- <select class="form-control" select2="" id="design" ng-model="request.customer_id" name="customer_id"  required>-->
                                            <option  value=""></option>
                                            <option ng-repeat="customer in customers" value="<%customer.CustomerId%>"><%customer.FirstName%> <%customer.LastName%></option>
                                        </select>
                                        <span ng-cloak  class="error-msg " ng-show="(requestForm.customer_id.$dirty || invalidSubmitAttempt) && requestForm.customer_id.$error.required"> This field is required.</span>
                                    </div>
                                    <div class="input-field col-sm-6 sel" ng-if="CustMap!='Single'">
                                        <label for="design">Select Customer Name</label>
                                        <select class="form-control" select2="" multiple name="customer_id1" data-ng-model="request.customer_id1" required>
                                            <!-- <select class="form-control" id="design" select2="" multiple ng-model="request.customer_id1" name="customer_id1" required >-->
                                            <option  value=""></option>
                                            <option ng-repeat="customer in customers" value="<%customer.CustomerId%>"><%customer.FirstName%> <%customer.LastName%></option>
                                        </select>
                                        <span ng-cloak class="error-msg " ng-show="(requestForm.customer_id1.$dirty || invalidSubmitAttempt) && requestForm.customer_id1.$error.required"> This field is required.</span>
                                    </div>
                                </div>
                               
                                <div class="row mg-btm" ng-repeat="field in fields track by $index">
                                    <div class="col-sm-6 input-field">
                                        <label for="ext-name">Existing Part Name</label>
                                        <input id="ext-name" type="text" class="form-control" ng-model="field.extName" name="extName[]" >
                                        <span ng-cloak class="error-msg " ng-show="(requestForm.extName.$dirty || invalidSubmitAttempt) && requestForm.extName.$error.required"> This field is required.</span>
                                    </div>
                                    <div class="col-sm-6 input-field">
                                        <label for="ext-number">Existing Part Number</label>
                                        <input id="ext-number"  type="text" class="form-control" ng-model="field.extNumber" name="extNumber[]" onpaste="return false;">
                                        <span ng-cloak class="error-msg " ng-show="(requestForm.extNumber.$dirty || invalidSubmitAttempt) && requestForm.extNumber.$error.required"> This field is required.</span>
                                        <span id="errmsg" ng-cloak class="error-msg " ng-show="(requestForm.extNumber.$dirty || invalidSubmitAttempt) && requestForm.extNumber.$error.number"></span>
                                        <span class="icon-delete" ng-click="remove($index)" ng-show="$index"><i class="fa fa-times-circle"></i></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col-sm-12" ng-if="CustPart!='Single'">
                                        <button class="btn btn-animate flat blue pd-btn pull-right" id="AddNum" type="button" ng-click="add()">Add More</button>
                                    </div>
                                </div>
                                <div class="row mg-btm">
                                    <div class="input-field col-sm-6 sel">
                                        <label for="change">Select Purpose of Change (Multiple Select)</label>
                                        <select class="form-control" select2="" multiple  ng-model="request.changerequest_purpose" name="changerequest_purpose" required>
                                            <option  value=""></option>
                                            <option ng-repeat="d in purposechange"value="<%d.id%>"><%d.changerequest_purpose%></option>
                                        </select>
                                        <span ng-cloak class="error-msg " ng-show="(requestForm.changerequest_purpose.$dirty || invalidSubmitAttempt) && requestForm.changerequest_purpose.$error.required"> This field is required.</span>
                                    </div>
                                    <div class="input-field col-sm-6 " >
                                        <div class="date-form">
                                            <div class="form-horizontal">
                                                <div class="control-group">
                                                    <label for="startdate" class="control-label">Change Request Date</label>
                                                    <div class="controls mg-top">
                                                       
                                                         <div class="input-group col-sm-12">
                                                            <input type="text" name="startdate_status"  id="startdate_status1"  readonly data-date-format="dd/mm/yyyy" ng-model="result" required/>
                                                             <label class="input-group-addon btn" for="startdate">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                            </label>
                                                            </div>
                                                        <span ng-cloak class="error-msg " ng-show="(requestForm.dt.$dirty || invalidSubmitAttempt) && requestForm.dt.$error.required"> This field is required.</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                                        <label for="approval">Approval Authority from Department HOD</label> <span><%hod.name%></span></span>
                                        <input type="hidden"  name="Approval_Authority" id="Approval_Authority"  value="<%hod.id%>" >
                                        
                                    </div>
                                </div>
                                <div class="row mg-btm mg-btm">
                                    <div class="input-field col-sm-12">
                                        <label for="textarea">Remark</label>
                                        <input type="hidden" id="uploadFileName" name="uploadFileName" ng-model="request.uploadFileName">
                                        <textarea id="textarea" rows="3"  class="form-control" ng-model="request.remark" name="remark"></textarea>
                                        <span ng-cloak  class="error-msg " ng-show="(requestForm.remark.$dirty || invalidSubmitAttempt) && requestForm.remark.$error.required"> This field is required.</span>
                                    </div>
                                </div>
                               <div>
                                    <br><br>
                                </div>
                                <div class="row mg-btm mg-btm">
                                    <div class="row">
                                        <div class="col-sm-12 ">
                                            <br>
                                            <button class="btn btn-animate flat blue pd-btn" ng-disabled="isDisabled" type="submit" name="action" ng-click="addRequest(requestForm,1,formdata)">Submit</button>
                                            <button class="btn btn-animate flat blue pd-btn" ng-disabled="isDisabled" type="submit" ng-click="addRequest(requestForm,5)">Save as Draft</button>
                                            <div class="loading-spiner-holder" data-loading >
                                                <div class="loading-spiner">
                                                    <img src="<?php echo Request::root(); ?>/protected/public/images/Twirl.gif" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                           <div style="float: left;margin-top: -140px;padding-left: 15px;">
                                <form name="fileUpload" id="fileUpload" enctype="multipart/form-data">
                                    <div class="row mg-btm mg-btm">
                                        <div class="input-field col-sm-12">
                                            <label for="textarea">File (Press CTRL for selecting multiple file)</label>
                                            <input type="file" id="uploadFile" name="uploadFile[]" multiple="multiple" accept="<%ext%>" >
                                          <p id="demo" style="color:#FF6030;;font-size:70%;"></p>
                                        </div>
                                        
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div><!--/form-wrapper-->

            </div><!--/content-wrapper-->
        </div><!--/s10-->
    </div><!--/row-->

</div><!--/container-->
</div><!--/main-wrapper-->

<?php require app_path().'/views/footer.php'; ?>
<script>

    $(document).ready(function(){
       // Numeric();
        
        $("#startdate_status1").datepicker({startDate: '<?php echo date('d-m-Y'); ?>',endDate: '<?php echo date('d-m-Y'); ?>'});  
        $("#uploadFile").change(function(e)
        {
           var ext = $('#uploadFile').val().split('.').pop().toLowerCase();

            if($("#uploadFile").val() == ""){
                $.simplyToast('Please select file.', 'warning');
                return false;
            }
            if($.inArray(ext, ['tif','gif','png','jpg','jpeg','pdf']) == -1) {
                    alert('invalid extension!');
                     $("#uploadFile").replaceWith($("#uploadFile").val('').clone(true));
                    return false;


            }

            $.ajax({
                url: 'changeReqUpload',
                type: 'POST',
                data: new FormData($("#fileUpload")[0]),
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function(){
                    $("#fade").show();
                },
                success: function(data) {
                    $("#fade").hide();
                    console.log(data);
                    $("#uploadFileName").val(data);
                    //$.simplyToast('Your file submited successfully.', 'success');
                    // $("#fileUpload")[0].reset();
                    return false;
                }
            });
        });

         $(document).on('click', '#AddNum', function() {
                    Numeric();
            }); 

        

         
        

    });

    function getDispatchLocation(){
    // alert('dispatch location');
    var stage=$('#change_stage_id').val();
    if(stage==1){
      $('#disloc').show();
    }else{
      $('#disloc').hide();
    }
  }

    function Numeric(e){
     if (e.which != 8 && e.which != 0 && (e.which < 47 || e.which > 57) && (e.which < 78 || e.which > 78) && (e.which < 65 || e.which > 65) ) {
        //display error message
        $("#errmsg").html("Digits Only").show().fadeOut("slow");
               return false;
    }
    }
</script>