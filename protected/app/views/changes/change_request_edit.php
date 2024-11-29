<?php require app_path().'/views/header_edit.php'; ?>

<style>
    ul.dropdown-menu li {
        cursor: pointer;
    }

    ul.dropdown-menu li span.red {
        color: red;
    }

    ul.dropdown-menu li span.green {
        color: green;
    }




</style>

 <style scoped>
    .demo-section {
      width: 400px;
    }
    .demo-section p {
      padding: 5px 0;
    }
    .k-list-scroller{overflow-y:auto;}

    .k-state-selected, .k-state-selected:link, .k-state-selected:visited, .k-list > .k-state-selected, .k-list > .k-state-highlight, .k-panel > .k-state-selected, .k-button:active, .k-ghost-splitbar-vertical, .k-ghost-splitbar-horizontal, .k-draghandle.k-state-selected:hover, .k-scheduler .k-scheduler-toolbar .k-state-selected, .k-marquee-color {
  background-color: #248CCB !important;
  border-color: #248CCB;
 
}
.k-state-selected, .k-button:active, .k-draghandle.k-state-selected:hover {
  background-image: none;
  background:#248CCB!important;
}
.k-link:hover:not(.k-state-disabled) > .k-i-close, .k-link:hover:not(.k-state-disabled) > .k-delete, .k-link:hover:not(.k-state-disabled) > .k-group-delete, .k-state-hover .k-i-close, .k-state-hover .k-delete, .k-state-hover .k-group-delete, .k-button:hover .k-i-close, .k-button:hover .k-delete, .k-button:hover .k-group-delete, .k-textbox:hover .k-i-close, .k-textbox:hover .k-delete, .k-textbox:hover .k-group-delete, .k-button:active .k-i-close, .k-button:active .k-delete, .k-button:active .k-group-delete {
  background-position: ;
}
  </style>


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
                            <?php if($request_id == ""){
                              $r_id=Request::segment(3);

                            }else{
                              // $r_id=Session::get('r_id');
                                $r_id=$request_id;
                            }?>
                        </div><!--/page-heading-->
                      </div>
                    </div>



                      <div class="form-wrapper" ng-controller="EditchangereqCtrl" ng-init="editrequestinfo('<?php echo $r_id; ?>');getInitDept('<?php echo $r_id;?>')">
                          <div class="row">
                              <form method="post" role="form" class="col-sm-12 myform" ng-class="{'submitted': submitted}" name="requestForm" novalidate ng-submit="(submitted = true) && requestForm.$invalid && $event.preventDefault()" autocomplete="off">

                              <div class="row mg-btm">
                              <div class="input-field col-sm-6">
                                        <label for="initiator_name">Select Business</label>
                                        <select class="form-control"   id="change"  ng-model="request.business"  name="business" ng-change="checkPrjApply(request.business)" required> 
                                            <option  value=""></option>
                                            <option ng-repeat="d in business" value="<%d.id%>"><%d.busi_code%></option>
                                        </select>
                                        <span ng-cloak class="error-msg " ng-show="(requestForm.business.$dirty || invalidSubmitAttempt) && requestForm.business.$error.required"> This field is required.</span>
                                    </div>
                                    <div class="input-field col-sm-6" ng-if="disPrj == false">
                                        <label for="stakeholder">Select Project Code</label>
                                        <select class="form-control" select2=""  id="project_code" ng-model="request.code" name="project_code" ng-change="getStage(request.project_code)" required="">
                                            <option  value=""></option>
                                            <option ng-repeat="d in project_code" value="<%d.id%>"><%d.project_code%></option>
                                        </select>
                                        <span ng-cloak class="error-msg " ng-show="(requestForm.project_code.$dirty || invalidSubmitAttempt) && requestForm.project_code.$error.required"> This field is required.</span>
                                    </div>
                                    <div class="input-field col-sm-6" ng-if="disPrj == true">
                                        <label for="stakeholder">Select Project Code</label>
                                        <select class="form-control" select2=""  id="project_code" ng-model="request.code" name="project_code" ng-change="getStage(request.project_code)" ng-disabled="disPrj">
                                            <option  value=""></option>
                                            <option ng-repeat="d in project_code" value="<%d.id%>"><%d.project_code%></option>
                                        </select>
                                        <span ng-cloak class="error-msg " ng-show="(requestForm.project_code.$dirty || invalidSubmitAttempt) && requestForm.project_code.$error.required"> This field is required.</span>
                                    </div>
                                  <div class="input-field col-sm-6">

                                      <label for="initiator_name">Select Manufacturing location</label>

                                      <select class="form-control"   id="change"  ng-model="request.plant_id" name="plant_id" required>
                                            <option  value=""></option>

                                          <option ng-repeat="d in plantcodes" value="<%d.plant_id%>"><%d.plant_code%></option>

                                      </select>
                                    <span ng-cloak class="error-msg " ng-show="(requestForm.plant_id.$dirty || invalidSubmitAttempt) && requestForm.plant_id.$error.required"> This field is required.</span>


                                  </div>
                                      <div ng-if="dropdownView == true " class="input-field col-sm-6">
                                      <input type='hidden' id='dis_loc' value="<%request.dispatch_loc%>">
                                          <label for="Change-Stage">Select Change Stage</label>
                                          <select class="form-control"   id="change_stage_id" name="change_stage_id" ng-model="request.change_stage" required ng-disabled="drpdwn" ng-change="getDispatchLocation(request.change_stage_id);">
                                             <option  value=""></option>
                                              <option ng-repeat="data in changestage" value="<%data.change_stage_id%>"><%data.stage_name%></option>

                                          </select>


                                          <span ng-cloak class="error-msg " ng-show="(requestForm.change_stage_id.$dirty || invalidSubmitAttempt) && requestForm.change_stage_id.$error.required"> This field is required.</span>

                                      </div>
                                      <div ng-if="textView == true" class="input-field col-sm-6">

                                        <label for="Change-Stage">Select Change Stage</label>
                                        <input type="text" name="change_stage_id" ng-model='stage.stage_name' ng-disabled="true"> 
                                       <input type="hidden" name="change_stage" id="change_stage"  value="<% stage.change_stage_id%>" ng-disabled="true"> 
                                        
                                        <span ng-cloak class="error-msg " ng-show="(requestForm.change_stage_id.$dirty || invalidSubmitAttempt) && requestForm.change_stage_id.$error.required"> This field is required.</span>
                                    </div>
                                  </div>
                                  <div class="row mg-btm">
                                  <div class="input-field col-sm-6">
                                      <label for="stakeholder">Select Stakeholder</label>
                                      <select class="form-control"   id="change"  ng-model="request.stakeholder" name="stakeholder" required>
                                            <option  value=""></option>

                                          <option ng-repeat="d in stakeholder" value="<%d.id%>"><%d.name%></option>
                                      </select>
                                    <span ng-cloak class="error-msg " ng-show="(requestForm.stakeholder.$dirty || invalidSubmitAttempt) && requestForm.stakeholder.$error.required"> This field is required.</span>
                                  </div>
                                    <div class="input-field col-sm-6" id='disloc' ng-if="disloc==true">
                                         <label for="stakeholder">Select Dispatch location</label><br>
                                        <select width="200px" class="form-control" select2="" ng-model="request.dispatch_loc" name="dispatch_loc" required>
                                            <option  value=""></option>
                                            <option ng-repeat="d in dispatchlocation" value="<%d.plant_id%>"><%d.plant_code%></option>
                                        </select>
                                        <span ng-cloak class="error-msg " ng-show="(requestForm.dispatch_loc.$dirty || invalidSubmitAttempt) && requestForm.dispatch_loc.$error.required"> This field is required.</span>
                                    </div>
                                  </div>
                                  </div>
                                  <div class="row mg-btm" >
                                      <div class="input-field col-sm-6" ng-if="viewdeptIni==false">
                                          <label for="dept">Select Initiator Department</label>
                                          <select class="form-control" ng-model="request.dep_id" name="dep_name" ng-change="fill_sub_department(request.dep_id)" required>
                                             <option  value=""></option>
                                              <option ng-repeat="department in departments" value="<%department.d_id%>"><%department.d_name%></option>

                                          </select>


                                          <span ng-cloak class="error-msg " ng-show="(requestForm.dep_name.$dirty || invalidSubmitAttempt) && requestForm.dep_name.$error.required"> This field is required.</span>

                                      </div>
                                      <div  class="input-field col-sm-6" ng-if="viewdeptIni==true">
                                        <label for="Change-Stage">Select Initiator Department</label>
                                        <input type="text" name="dep_id" id="dep_id" ng-model='iniDept.d_name' value="<% stage.department%>" ng-disabled="true"> 
                                        <input type="hidden" name="dep_id1" id="dep_id1"  value="<% iniDept.department%>" > 
                                        <input type="hidden" name="displayDept" id="displayDept"   value="displayDept"> 
                                       
                                        
                                        
                                    </div>
                                      <div class="input-field col-sm-6" ng-show="sub_dep" ng-if="viewdeptIni==false">
                                          <label for="dept">Select Initiator Sub-Department</label>
                                          <select class="form-control" ng-model="request.sub_dep_id" name="sub_dep_id" >
                                              <option  value=""></option>
                                              <option ng-repeat="d in sub_departments" value="<%d.sub_dep_id%>"><%d.sub_dep_name%></option>
                                          </select>


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
                                          <select class="form-control" id="changeType" ng-model="request.changeType" name="changeType" ng-change="fill_customer_name(request.changeType,'<?php echo $r_id; ?>');removeAllPart(request.changeType,'<?php echo $r_id; ?>');" ng-disabled="isDisabled"  required>
                                                 <option  value=""></option>
                                              <option ng-repeat="data in changetype" value="<%data.change_type_id+'@'+data.change_type_cust_mapping+'@'+data.change_type_part_mapping%>"><%data.change_type_name%></option>

                                          </select>

                                          <span ng-cloak class="error-msg " ng-show="(requestForm.changeType.$dirty || invalidSubmitAttempt) && requestForm.changeType.$error.required"> This field is required.</span>

                                      </div>
                                     <div class="input-field col-sm-6 sel" ng-if="sub_type">
                                        <label for="design">Select Change Sub Type</label>
                                        <select class="form-control" select2="" multiple ng-model="request.sub_type_id" name="sub_type_id" id="sub_type_id" required>
                                           
                                             <option  value=""></option>
                                            <option ng-repeat="d in sub_type_name" value="<%d.sub_type_id%>"><%d.sub_type_name%></option>
                                        </select>
                                        <span ng-cloak class="error-msg " ng-show="(requestForm.sub_type_id.$dirty || invalidSubmitAttempt) && requestForm.sub_type_id.$error.required"> This field is required.</span>
                                        <input type="hidden" id="sub_type" value="<%request.sub_type_id%>">
                                    </div>
                                      
                                  </div>

                                  <div class="row mg-btm">
                                     
                                      <div class="input-field col-sm-6"  ng-if="hideoption=='hide'">
                                          <label for="design">Select Customer Name</label>
                                          <select class="form-control " id="design" ng-model="request.customers_id_single" name="customer_id" ng-disabled="isDisabled" required>
                                           <option  value=""></option>

                                              <option ng-repeat="customer in customers" value="<%customer.CustomerId%>"><%customer.FirstName%> <%customer.LastName%></option>

                                          </select>

                                          <span id="customersingle" ng-cloak  class="error-msg " ng-show="(requestForm.customer_id.$dirty || invalidSubmitAttempt) && requestForm.customer_id.$error.required"> This field is required.</span>

                                      </div>

                                      <div class="input-field col-sm-6 sel" ng-if="hideoption=='show'">
                                          <label for="design">Select Customer Name</label>

                                       <!-- <dropdown-multiselects dropdown-title="Select Something" pre-selected="member" model="request.selected_items" options="customers" ></dropdown-multiselects>-->
                                        <select id="statemultiselect" kendo-multi-select="" k-option-label="'Select States...'" k-data-text-field="'FirstName'" k-data-value-field="'CustomerId'" k-data-source="customers" k-ng-model="request.selected_items" ng-disabled="isDisabled"></select>
                                        <span id="customerMulti" ng-cloak  class="error-msg " ng-show="(requestForm.customer_id.$dirty || invalidSubmitAttempt) && requestForm.customer_id.$error.required"> This field is required.</span>
                                      </div>
                                  </div>


                            <div class="row mg-btm" ng-repeat="field in request_part track by $index">

                             <div class="col-sm-6 input-field">
                               <label for="ext-name">Existing Part Name</label>
                                <input id="ext-name" type="text" class="form-control" ng-model='field.part_name' name="extName[]">
                                <span ng-cloak class="error-msg " ng-show="(requestForm.extName.$dirty || invalidSubmitAttempt) && requestForm.extName.$error.required"> This field is required.</span>



                              </div>
                              <div class="col-sm-6 input-field">
                               <label for="ext-number">Existing Part Number</label>
                                <input id="ext-number" type="text" class="form-control" ng-model='field.part_number' name="extNumber[]" onpaste="return false;" onkeypress="return Numeric(event);">
                                <span ng-cloak class="error-msg " ng-show="(requestForm.extNumber.$dirty || invalidSubmitAttempt) && requestForm.extNumber.$error.required"> This field is required.</span>
                                  <span class="icon-delete" ng-cloak ng-click="remove($index,field.parts_id)" ng-show="$index"><i class="fa fa-times-circle"></i></span>


                              </div>
                                <input type="hidden" name="part_number" ng-model="field.parts_id" value="field.part_ids">
                            </div>

                            <div class="row">
                              <div class="input-field col-sm-12" ng-if="partval!='Single'">
                                <button class="btn btn-animate flat blue pd-btn pull-right" type="button" ng-click="add()" ng-disabled="isDisabled">Add More</button>
                              </div>
                            </div>






                                  <div class="row mg-btm">
                                      <div class="input-field col-sm-6 sel">
                                          <label for="change">Select Purpose of Change (Multiple Select) </label>
                                         
                                          <select id="statemultiselect11" kendo-multi-select="" k-option-label="'Purpose of Change...'" k-data-text-field="'changerequest_purpose'" k-data-value-field="'id'" k-data-source="states" ng-model="request.selected_items_for_purpose" required></select>

                                          <span id="statemultiselect11_span" ng-cloak class="error-msg " ng-show="(requestForm.changerequest_purpose.$dirty || invalidSubmitAttempt) && requestForm.changerequest_purpose.$error.required"> This field is required.</span>


                                      </div>

                                      <div class="col-md-6 date-bg">
                                  <!--  <label for="startdate" class="control-label">Select Date</label>-->

                                    <label for="cost" class="control-label">Change Request Date</label>

                                   <?php if($page=="modify"){?>
                                     <input type="text" name="dt"   id="calender1"  ng-model="request.created_date1" readonly data-date-format="dd/mm/yyyy"    required/>
                                     <?php }else{ ?>
                                    <input type="text" name="dt"  id="calender" ng-model="res" readonly data-date-format="dd/mm/yyyy"    required/>
                                    <?php } ?>
                                   <span class="glyphicon glyphicon-calendar icon_cal"></span> 

                                    </label>
                                    <span class="error-msg " ng-show="(updatesheetForm.currentTime.$dirty || invalidSubmitAttempt) && updatesheetForm.currentTime.$error.required"> This field is required.</span>
 
                                    

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
                                          <label for="approval">Approval Authority from Department HOD</label> <span ng-bind="request.Approval_Authority"></span></span>
                                          <input type="hidden"  name="Approval_Authority" id="Approval_Authority" ng-model="request.Approval_Authority_id" >
                                          <input type="hidden"  name="Approval_Authority" id="inititor_id" ng-model="request.initiator_id" >
                                          <input type="hidden"  name="Authority" id="Authority" value="<%request.initiator_id%>" >
                                          


                                      </div>

                                  </div>
                                  <div class="row mg-btm mg-btm">
                                      <div class="input-field col-sm-12">
                                          <label for="textarea">Remark</label>
                                           <input type="hidden" id="apprptdata" name="apprptdata" ng-model="request.apprptdata">
                                            <input type="hidden" id="uploadFileName" name="uploadFileName" ng-model="request.uploadFileName">
                                          <textarea id="textarea" rows="3"  class="form-control" ng-model="request.remark" name="remark"></textarea>

                                          <span ng-cloak  class="error-msg " ng-show="(requestForm.remark.$dirty || invalidSubmitAttempt) && requestForm.remark.$error.required"> This field is required.</span>

                                      </div>

                                  </div >
                                 

                                  <div style="padding-top:<% 70+(cntOfFile*60) %>px;">
                                    &nbsp;
                                    
                                  </div>

                                  <div class="row">
                                      <div class="col-sm-12 ">
                                          <?php if($page=="editByIni"){ ?>
                                          <button class="btn btn-animate flat blue pd-btn" type="submit" name="action" ng-disabled="isDisabled" ng-click="addRequest_fdraft(requestForm,1,'<?php echo $r_id; ?>','<?php echo Request::segment(4); ?>')">Submit</button>
                                          <button ng-if="request.status==5" class="btn btn-animate flat blue pd-btn" type="submit" ng-click="EditRequest(requestForm,'<?php echo $r_id; ?>','<?php echo $page; ?>')">Update</button>
                                          <?php }?>
                                          <?php if($page=="modify"){ ?>
                                              <button  class="btn btn-animate flat blue pd-btn" type="submit" ng-click="EditRequest(requestForm,'<?php echo $r_id; ?>','<?php echo $page; ?>')">Update</button>

                                          <?php }?>
                                         
                                           <div class="loading-spiner-holder" data-loading >
                                    <div class="loading-spiner">
                                    <img src="<?php echo Request::root(); ?>/protected/public/images/Twirl.gif" />
                                    </div>
                                    </div>
                                      </div>
                                  </div>
                              </form>
                              <div style="float: left;margin-top: -<% 140+(cntOfFile*60) %>px;padding-left: 15px;">
                                <form method="post" name=""   action="<?php echo Request::root().'/deleteChangeReqAttachment'?>">
                                <div class="row mg-btm mg-btm" >
                                        <div class="input-field col-sm-12">
                                            <table border="0">
                                      <tr ng-repeat="result in changeReqFile" id="tr_<%result.id%>">
                                          <td width="35%">
                                              <%result.attached_file%>

                                          </td>
                                          <td width="65%">
                                            <input type="hidden" name="attach_id"  value="<%result.id%>">
                                              <input type="hidden" id="changeReqFile" name="changeReqFile" value="<%result.attached_file%>">
                                              <input type="hidden" name="dele_changeReqFile" value="1">
                                              <button  type="button" id="button" class="tooltipped" data-position="bottom" data-delay="50"  data-tooltip="Delete File" ng-click="deleteAttachement(result.id,result.attached_file)"><i class="fa fa-trash-o"></i></button>
                                          </td>

                                      </tr>
                                  </table>
                                        </div>
                                        
                                    </div>
                                    </form>
                                     <form  name="fileUpload" id="fileUpload" enctype="multipart/form-data" >
                                   <div class="row mg-btm mg-btm">
                                        <div class="input-field col-sm-6">
                                            <label for="textarea">File</label>
                                            <input type="file" id="uploadFile" name="uploadFile[]" multiple="multiple">
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


<?php require app_path().'/views/footer_edit.php'; ?>

<script type="text/javascript">

 function Numeric(e){
     if (e.which != 8 && e.which != 0 && (e.which < 47 || e.which > 57) && (e.which < 78 || e.which > 78) && (e.which < 65 || e.which > 65) ) {
        //display error message
        $("#errmsg").html("Digits Only").show().fadeOut("slow");
               return false;
        }
    }
 // window.onload=set_subType();
  $(document).ready(function(){

 $("#calender").datepicker({startDate: '<?php echo date('d-m-Y'); ?>',endDate: '<?php echo date('d-m-Y'); ?>'});  
      $("#statemultiselect11").change(function()
      {
        if( $(this).val() != null )
        {
          $("#statemultiselect11_span").addClass('ng-hide');
        }

      });

     
      $(document).on('change', "#statemultiselect", function()
      {
        
        if( $(this).val() != null )
        {
          $("#customerMulti").addClass('ng-hide');
        }
        
      });
       $(document).on('change', "#design", function()
      {
        
        if( $(this).val() != null )
        {
          $("#customersingle").addClass('ng-hide');
        }
        
      });

  });

  function getDispatchLocation(){
    // alert('dispatch location');
    var stage=$('#change_stage_id').val();
    if(stage==1){
      $('#disloc').show();
      // $('#dispatch_loc option:selected').val($('#dis_loc').val());
    }else{
      $('#disloc').hide();
    }
  }

  // function set_subType(){
  //   if( $('#sub_type').val() != '' )
  //       {
  //         alert($('#sub_type').val());
  //         $("#sub_type_id").val($('#sub_type').val());
  //       }
  // }

</script>
<script>
    $(document).ready(function(){
      
      var base_url='<?php echo Request::root(); ?>/';
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
              //url: 'http://10.51.80.87/CM/changeReqUpload',

                url: base_url+'changeReqUpload',
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
                    
                    return false;
                }
            });
        });

    });
</script>


