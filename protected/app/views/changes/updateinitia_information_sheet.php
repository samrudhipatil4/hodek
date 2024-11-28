<?php require app_path().'/views/header.php'; ?>
<style>
    .full button span {
        background-color: limegreen;
        border-radius: 32px;
        color: black;
    }
    .partially button span {
        background-color: orange;
        border-radius: 32px;
        color: black;
    }
</style>
<?php if($request_id == ""){
    $r_id=Request::segment(3);

}else{
   
    $r_id=$request_id;

}
if($initiator == ""){

    $initiator =  Session::get('uid');

}else{
 
    $initiator = $initiator;
}
$url=Request::segment(4);

if($url != ""){
 
  $rpsid=Request::segment(4);
}else{
 
  $rpsid='null';
}

?>
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
                          <h1>Define Cross Functional Team</h1>
                        </div><!--/page-heading-->
                      </div>
                    </div>

                  <div class="content-wrapper">

                      <div class="status-bar"  ng-controller="updateInitSheetCtrl" ng-init="fetch('<?=$r_id;?>',<?=$initiator;?>)">
                          <div class="row mg-bottom-0">
                              <div class="col-sm-4">
                                  <ul class="pd-none">
                                      <li> <strong>Task Record CM Number :</strong> <span ng-bind="cmno"></span></li>
                                  </ul>
                                  <input type=hidden id="rId" value="<?php echo $r_id; ?>">
                              </div>
                              <div class="col-sm-8">
                                  <ul class="pull-right">
                                      <li> <strong>Current State :</strong> <span ng-bind="status"></li>
                                  </ul>
                              </div>
                          </div>
                      </div><!--/status-bar-->

                     <div class="form-wrapper" >

                         <div ng-controller="updateInitSheetCtrl" ng-init="fetch1(<?=$r_id;?>)">

                             <div class="row" ng-show="visibleTable">
                                 <div class="col-sm-12">
                                     <div class="table-wrapper">
                                         <table class="striped">
                                             <thead>
                                             <tr>
                                                 <th width="10%">Sr. No.</th>
                                                 <th>Function Name</th>
                                                 <th>Team Member</th>
                                                 <th>Status</th>
                                                 <th width="12%">Action</th>
                                             </tr>
                                             </thead>
                                             <tbody>
                                             <tr ng-repeat="record in availableOptions" ng-class="{'success' : records[$index]}">
                                                 <td><%$index+1%>.</td>
                                                 <td><%record.d_name%></td>
                                                 <td><%record.first_name%> <%record.last_name%></td>

                                                 <td><%record.fetch_status|statusfilter%></td>
                                                 <td>
                                                     <table cellpadding="0" cellspacing="0">


                                                         <tr class="border-none">
                                                       
                                                             <td    style="border:0px !important; font-size:16px;" ><a href="javascript:void(0)" ng-click="EditRecord($index,record.update_sheet_dep_id,record.d_id,<?php echo $r_id; ?>,<?php echo $rpsid; ?>)" class="" data-position="bottom" data-delay="50" data-tooltip="Edit"><i class="fa fa-pencil"></i> </a></td>
                                                            
                                                             <div >
                                                              <?php if($page=="modifyByUser"){?>
                                                             <td ng-if="provision == true && proj==false"><button class="btn btn-animate flat blue pd-btn" type="submit" id="removeDept" name="removeDept" ng-click="removeDept(record.request_id,record.department,<?php echo $rpsid; ?>)">Remove</button></td>
                                                             <?php }else{?>
                                                               <td ng-if="provision == true' && deptProv == true"><button class="btn btn-animate flat blue pd-btn" type="submit" id="removeDeptByAdmin" name="removeDeptByAdmin" ng-click="removeDeptByAdmin(record.request_id,record.department,record.team_member)">Remove</button></td>
                                                              <?php }?>
                                                             </div>
                                                         </tr>

                                                     </table>
                                                 </td>

                                             </tr>
                                             </tbody>
                                         </table>
                                         <p></p>  <p></p>
                                         <form name="addDepartment" method="post" role="form" ng-class="{'submitted': submitted}"  novalidate ng-submit="(submitted = true) && updaterisksheet.$invalid && $event.preventDefault()" autocomplete="off">

                                         <div>
                                         <div class="input-field col-sm-2" ng-if="provision == true && deptAddedForReq < allDept && deptProv == true && proj==false">
                                  
                                     <button class="btn btn-animate flat blue pd-btn" id="addDept" name="addDept" type="submit" ng-click="buttonClick(<?=$r_id;?>,<?php echo $rpsid; ?>)">Add</button>
                         
                              </div>
                              <div class="input-field col-sm-5" ng-if="showDropDown==true">
                                        <label for="dep" >Select Department</label>
                                        <select class="form-control" select2="" ng-model="request.dep_id" name="dep_id" id="dep_id" ng-change="fillUSerByDept();" >
                                            <option  value=""></option>
                                           <option ng-repeat="department in departments" value="<%department.d_id%>"><%department.d_name%></option>
                                        </select>
                                         <span id="dep_id_span" ng-cloak class="error-msg " ng-show="(addDepartment.dep_id.$dirty || invalidSubmitAttempt) && addDepartment.dep_id.$error.required"> Choose Team Member.</span>
                                    </div>

                                    <?php if($page=="modifyByAdmin"){?>
                                        <div class="input-field col-sm-5" ng-if="showDropDown==true">
                                             <label for="first_name">Select Team Member</label>
                                             <select class="form-control" id="first_name" name="first_name"  ng-model="risks.team_member" required="">
                                                 <option  value=""></option>
                                                 <option ng-repeat="option in risks_new" value="<%option.id%>"><%option.first_name%> <%option.last_name%></option>

                                             </select>
                                             <span ng-cloak class="error-msg" ng-show="(addDepartment.first_name.$dirty || invalidSubmitAttempt) && addDepartment.first_name.$error.required"> Choose Team Member.</span>
                                         </div>
                                         <?php } ?>
                                     <?php if($page=="modifyByAdmin"){?>
                                     <div class="input-field col-sm-6" " ng-if="showDropDown==true">
                                   
                                     <button class="btn btn-animate flat blue pd-btn" id="saveDept" name="saveDept" type="submit" ng-click="saveDeptByAdmin(<?=$r_id;?>,addDepartment,<?=$initiator;?>);">Save</button>
                                      </div>
                                    <?php }else{?>
                                       <div ng-if="proj==true && showDropDown==true" class="input-field col-sm-5" >
                                             <label for="first_name">Select Team Member</label>
                                             <select class="form-control" id="first_name" name="first_name"  ng-model="risks.team_member" required="">
                                                 <option  value=""></option>
                                                 <option ng-repeat="option in risks_new" value="<%option.id%>"><%option.first_name%> <%option.last_name%></option>

                                             </select>
                                             <span ng-cloak class="error-msg" ng-show="(addDepartment.first_name.$dirty || invalidSubmitAttempt) && addDepartment.first_name.$error.required"> Choose Team Member.</span>
                                         </div>
                                       <div class="input-field col-sm-6" " ng-if="showDropDown==true">
                                        <button class="btn btn-animate flat blue pd-btn" id="saveDept" name="saveDept" type="submit" ng-click="saveDept(<?=$r_id;?>,addDepartment);">Save</button>
                                        </div>
                                      <?php }?>
                              </div>
                              </form>
                                     </div>

                                 </div>
                             </div>

                         <div class="add-record" ng-if="newReocord1">
                             <div class="row mg-top mg-btm">

                                 <form method="post" role="form" ng-class="{'submitted': submitted}" name="updaterisksheet" novalidate ng-submit="(submitted = true) && updaterisksheet.$invalid && $event.preventDefault()" autocomplete="off">
                                     <div>

                                         <div class="input-field col-sm-3 mg-top">
                                             <label for="textarea1">Function Name</label>
                                             <input type="text" id="textarea1" class="form-control mg-top" rows="2" ng-model="risks.d_name" readonly name="de_risking" >
                                             <input type="hidden" name="d_id" value="<%risks_new.d_id%>">
                                             <input type="hidden" name="d_id" value="<%risks_new.oldUserId%>">

                                         </div>

                                         <div class="input-field col-sm-3 mg-top">
                                             <label for="first_name">Select Team Member</label>
                                             <select class="form-control" name="first_name"  ng-model="risks.team_member" required="">

                                                 <option ng-repeat="option in risks_new" value="<%option.id%>"><%option.first_name%> <%option.last_name%></option>

                                             </select>
                                             <span ng-cloak class="error-msg " ng-show="(updaterisksheet.first_name.$dirty || invalidSubmitAttempt) && updaterisksheet.first_name.$error.required"> Choose Team Member.</span>
                                         </div>

                                         <div class="mg-top">
                                             <div class="col-sm-12 mg-top">
                                                 <button class="btn btn-animate flat blue pd-btn" type="submit" ng-disabled="isDisabled1" name="action" ng-click="UpdateRecord(updaterisksheet,<?=$r_id;?>,'<?php echo $page;?>')">Save</button>
                                                 <button class="btn btn-animate flat blue pd-btn" type="submit" ng-disabled="isDisabled12" name="action" ng-click="cancel(updaterisksheet)">Cancel</button>

                                             </div>
                                         </div>
                                     </div>

                                 </form>
                             </div>
                         </div>
                        </div>
                        </div>

                         <hr/>
                     

                         <div ng-controller="updateInitSheetCtrl" ng-init="getStockInfo('<?php echo $r_id; ?>')">
                         <form method="post" role="form"  name="updatesheetForm" novalidate ng-submit="(submitted = true) && updatesheetForm.$invalid && $event.preventDefault()" autocomplete="off">
                        <div>
                           <div class="row">
                        <div class="col-sm-12">
                        <div class="col-sm-3">
                      <label for="no">Comment : </label>
                        </div>
                        <div class="col-sm-6">
                        <textarea style="margin-left: -175px;margin-top: -12px" id="txtComment" class="form-control" rows="2" name="txtComment" ng-model="updatesheet.txtComment" ></textarea>
                          
                        </div>

                        </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-9">

                           <input type="hidden" id="no_of_days" value="<%days%>">   

                          <div class="row">
                            <div class="col-sm-5 ">
                            <p class="radio-label inline-lbl-radio">Current index level stock to be used until stock is zero</p>
                            </div>
                                  <div class="col-sm-1 ">
                                    <p class="np-pd">
                                        <input class="with-gap" name="selected" type="radio" id="radio" value="1" ng-model="updatesheet.selected" required>
                                        <label for="yes">Yes</label>

                                    </p>
                                  </div>
                                  <div class="col-sm-1 ">
                                    <p class="np-pd">
                                        <input class="with-gap" name="selected" type="radio" id="radio" value="2"  ng-model="updatesheet.selected" required>
                                        <label for="no">No</label>

                                    </p>
                                    <span ng-cloak class="error-msg " ng-show="(updatesheetForm.group1.$dirty || invalidSubmitAttempt) && updatesheetForm.group1.$error.required"> Option is Required.</span>

                                  </div>

                          </div>
                          </div>
                        </div>
                     

                        <div class="row" ng-if="updatesheet.selected == '2'">
                          <div class="col-sm-12">
                            <div class="row ">
                              <div class="col-sm-5 ">
                                <p class="radio-label inline-lbl">if No, Change implementation date of new index level</p>
                              </div>
                                <div class="col-md-3 date-bg">
                                  
                                    <label for="cost" class="control-label">Select Proposed Implementation Date</label>

                                    <input type="text" name="currentTime"  id="currentTime" class="date-picker" readonly data-date-format="dd.mm.yyyy" ng-model="updatesheet.currentTime"   required/>
                                   <span class="glyphicon glyphicon-calendar icon_cal"></span> 

                                    </label>
                                    <span class="error-msg " ng-show="(updatesheetForm.currentTime.$dirty || invalidSubmitAttempt) && updatesheetForm.currentTime.$error.required"> This field is required.</span>
                                </div>
                                <div class="col-sm-3">
                                  <button style="margin-top: 20px;" class="btn btn-animate flat blue pd-btn" type="submit" id="btnsave"  onClick="addStock(<?=$r_id;?>)">Save</button>
                                </div>
                            </div>
                          </div>
                        </div>
                        
                        <div class="row" ng-if="updatesheet.selected == '1'">
                          <div class="col-sm-12">
                            <div class="row ">
                              <div class="col-sm-3">
                                <p class="radio-label inline-lbl ">if Yes, Change implementation date of new index level</p>
                              </div>
                              <div class="input-field col-sm-3">
                                  <label for="current-stock">Current Stock</label>
                                <input id="current-stock" type="number" class="form-control" name="stock" ng-model="updatesheet.stock" >
                               
                                <span ng-cloak class="error-msg " ng-show="(updatesheetForm.stock.$dirty || invalidSubmitAttempt) && updatesheetForm.stock.$error.required"> Current Stock is required.</span>
                                  <span ng-cloak class="error-msg " ng-show="(updatesheetForm.stock.$dirty || invalidSubmitAttempt) && updatesheetForm.stock.$error.number"> Current Stock is Invalid.</span>

                              </div>


                                <div class="col-md-3 date-bg">
                                  <!--  <label for="startdate" class="control-label">Select Date</label>-->

                                    <label for="cost" class="control-label">Proposed Implementation Date </label>

                                    <input type="text" name="currentTime"  id="currentTime" class="date-picker" readonly data-date-format="dd.mm.yyyy" ng-model="updatesheet.currentTime"   required/>
                                    
                                   <span class="glyphicon glyphicon-calendar icon_cal"></span> 

                                    </label>
                                    <span class="error-msg " ng-show="(updatesheetForm.currentTime.$dirty || invalidSubmitAttempt) && updatesheetForm.currentTime.$error.required"> This field is required.</span>

                                </div>
                                <div class="col-sm-3">
                                  <button style="margin-top: 20px;" class="btn btn-animate flat blue pd-btn" type="submit" id="btnsave"  onClick="addStock(<?=$r_id;?>)">Save</button>
                                </div>

                            </div>
                          </div>
                          <div class="input-field col-sm-6 ">

                                      <label for="first_name"><strong>Team Leader:</strong></label> <?php echo Session::get('fid');?>

                                  </div>

                        </div>
                <?php if($page=="modifyByUser"){?>
                        <div class="row">
                              <div class="col-sm-12">
                                <button class="btn btn-animate flat blue pd-btn" type="submit" name="action" ng-disabled="isDisabled" ng-click="addinitial_info_sheet(updatesheetForm,<?=Request::segment(3);?>,<?=Request::segment(4);?>)">Send Mail</button>

                                  <div class="loading-spiner-holder" data-loading >
                                      <div class="loading-spiner">
                                          <img src="<?php echo Request::root(); ?>/protected/public/images/Twirl.gif" />
                                      </div>
                                  </div>
                              </div>
                        </div>
                <?php }else{?>
                            <div class="row">
                                <div class="col-sm-12">
                                    <button class="btn btn-animate flat blue pd-btn" type="submit" name="action" ng-disabled="isDisabled" ng-click="saveInfo_sheet(updatesheetForm,<?=$r_id;?>,<?=$initiator;?>)">Save</button>

                                    <div class="loading-spiner-holder" data-loading >
                                        <div class="loading-spiner">
                                            <img src="<?php echo Request::root(); ?>/protected/public/images/Twirl.gif" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php }?>
                      </form>
                     </div>

                     </div><!--/form-warpper-->

                  </div><!--/content-wrapper-->
                </div><!--/s10-->
              </div><!--/row-->

      </div><!--/container-->

  </div><!--/main-wrapper-->

  <?php require app_path().'/views/footer.php'; ?>

<script type="text/javascript">
  $(document).ready(function(){
    var base_url= '<?php echo Request::root(); ?>';
    var r_id='<?php echo Request::segment(3); ?>';
    if(r_id==''){
      var r_id=$('#rId').val();
    }

       $.ajax({
                   url:base_url+'/changes/checkCustDrivenChange',
                    type: 'get',
                    data:{request_id:r_id},
                    beforeSend: function () {
                        $("#fade").show();
                    },
                success: function(data) {
                    $("#fade").hide();
                   if(data== 0){
                      $(".date-picker").datepicker({startDate: '<?php echo date('d-m-Y'); ?>'});  
                   }else{
                      $(".date-picker").datepicker({startDate: '<?php echo date('d-m-Y'); ?>', endDate : '<?php echo date("d-m-Y", strtotime("+14 days")); ?>'});  
                   }
                    
                }
            });
    
       $(document).on('change', "#dep_id", function()
      {

        if( $(this).val() != "" )
        {
          $("#dep_id_span").addClass('ng-hide');
        }

      });

       $(document).on('change', "#radio", function()
      {
       var date=toString($("#no_of_days").val());
       var date1="+"+date+" days";
       // $dd = date1.replace(/"/g, "");
        //alert(dd)

          $.ajax({
                   url:base_url+'/changes/checkCustDrivenChange',
                    type: 'get',
                    data:{request_id:r_id},
                    
                success: function(data) {
                   
                   if(data== 0){
                       $(".date-picker").datepicker({startDate: '<?php echo date('d-m-Y'); ?>'});  
                   }else{
                      
                     $(".date-picker").datepicker({startDate: '<?php echo date('d-m-Y'); ?>', endDate : '<?php echo date("d-m-Y", strtotime("+14 days")); ?>'});  
                   }
                    
                }
            });

      });

       

  });


  function addStock(r_id){
    var base_url= '<?php echo Request::root(); ?>';
    var rpsid1 = '<?php echo Request::segment(4); ?>';
    if(rpsid1 == ''){
      var rpsid ='';
    }else{
      var rpsid=rpsid1;
    }
    var currentstock=$('#current-stock').val();
    var currentdate=$('#currentTime').val();
    var radio=$("input:radio:checked").val();
    
    if(currentdate==''){
      alert('Select implementation date.')
    }
    else{
      $.ajax({
                   url:base_url+'/changes/saveStockandDate',
                    type: 'post',
                    data:{request_id:r_id,currentstock:currentstock,currentdate:currentdate,radio:radio,rpsid:rpsid},
                    
                success: function(data) {
                 
                   if(data==1)
                    {
                      alert('Saved successfully.')
                    }else if(data==2){
                      alert('Updated successfully.')
                    }else{
                      alert("Can not save stock.Task is already completed");
                    }
            }

    });

  }
}

</script>

