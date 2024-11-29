<style type="text/css">
  .marginLeft {
    margin-left: 15px;
    
  }

  .font {
   
    font-size: 12px;
  }

</style>
<?php require app_path().'/views/apqp_header.php'; ?>

  <div class="main-wrapper">
    <div class="container">


              <div class="row two-col-row mg-bottom-0">
                <div class="col-sm-2">
                    
                </div><!--/s2-->
              <!--   <div style="width: 100%;overflow-x:  scroll;">
                <table><tr><td>
                  <input type="text" style="width: 2000px;" name="startdate_status"  id="asdate"  readonly data-date-format="dd/mm/yyyy" ng-model="startdate" required/>
                </td></tr></table></div> -->
                <div class="col-sm-10">

                    <div class="row">
                      <div class="col-sm-12">
                        <div class="page-heading">
                          <h1 style="font-size: 24px;
    font-family: cursive;">APQP Task </h1>
                      
                        </div><!--/page-heading-->    
                      </div>
                    </div>

                  <div class="content-wrapper">

                    <div class="form-wrapper" ng-controller="apqpTaskCtrl" ng-init="getTask('<?=Request::segment(3);?>',<?=Request::segment(4);?>,<?=Request::segment(5);?>);getActivityName('<?=Request::segment(3);?>','<?=Request::segment(4);?>');getMaterial('<?=Request::segment(6);?>')">
                          <div class="status-bar">
                      <div class="row mg-bottom-0">                                          
                        <div class="col-sm-4">
                          <ul class="pd-none">
                           <li> <strong>Gate :</strong> <span ng-bind="gate"></span></li>
                          </ul> 
                        </div>
                        <div class="col-sm-4">
                          <ul class="pull-right">
                           <li> <strong>Activity :</strong><span ng-bind="activity"> </li>
                          </ul> 
                        </div>
                        <div class="col-sm-4">
                          <ul class="pull-right">
                           <li> <strong>Material :</strong><span ng-bind="material"> </li>
                            <div id="flagDiv">
                            <li> <strong>Flag :</strong><span ng-bind="flag" id="flag"> </li></div>
                          </ul> 
                        </div>
                      </div>                        
                    </div>
                    <h5> </h5>

                    <div class="row mg-bottom-0" style="width:100%;overflow: scroll;">
                         
                    <form method="post" role="form" action="<?php echo Request::root().'/apqp/submitTask/'.Request::segment(3).'/'.Request::segment(4).'/'.Request::segment(5).'/'.Request::segment(6); ?>" class="col-sm-12 myform" ng-class="{'submitted': submitted}" id="formdata" name="formdata" novalidate ng-submit="(submitted = true) && formdata.$invalid && $event.preventDefault()" enctype="multipart/form-data" autocomplete="off" >
                  
                            
                     <div class="row mg-btm mg-btm" >
                                       <div class="input-field col-sm-6">
                                       <label for="textarea1">Actual Start Date</label>
                                       <!--  <input type="text" name="asdate" id="asdate" rows="3"  class="form-control"   > -->
                                       <input type="text" name="startdate_status"  id="asdate"  readonly data-date-format="dd/mm/yyyy" ng-model="startdate" onchange="changeFlag()" required/>
                                       <input type="hidden" name="project_start_date" id="project_start_date">
                                        <span id="errorProjectStartDate" onclick="checkdatevaL()" style="display: none;"> This field is required.</span>
                                    </div>
                                     
                                    </div>
                                    <div class="" ng-repeat="field in fields track by $index" >
                           <table cellpadding="5" cellspacing="5" >
                                      <tr>
                                      <td>
                                  <div class="">
                                   <label for="textarea"></label>
                                  
                                        <span></span>
                                       <button style="width: 80px;" id="submitDocument<%$index%>" class="btn btn-animate flat blue pd-btn marginLeft" name="submitDocument" type="button"  value="<%$index%>"   onclick="saveTaskDet('<?=Request::segment(3);?>',<?=Request::segment(4)?>,<?=Request::segment(5);?>,this)" >Save</button>

                                       </td>
         <td>                             
    <span style="width: 80px;" class="marginLeft" ng-click="remove($index,'<?=Request::segment(3);?>','<?=Request::segment(4);?>','<?=Request::segment(5);?>')" ng-show="$index"><i style="width: 80px;"  class="fa fa-times-circle " ></i></span>

                                   
                               
                                </td>
                                  

</div>


                                       <td>
                                      
                                        <label for="textarea1" class="marginLeft font">Parameter</label>
                                        <textarea style="width: 250px;" id="risk<%$index%>" rows="2"  class="form-control marginLeft" ng-model="field.risk" name="risk" onkeyup="hideMessage()" required ></textarea>
                                        <input type="hidden" id="hidparam" name="hidparam" value="">
                                         <span  id="errorrisk<%$index%>"  style="display: none;"> This field is required.</span>
                                       
                                    
                                  </td>
                                 <td>   <label for="textarea1" class="marginLeft font">Action</label>
                                        <textarea style="width: 250px;" id="action<%$index%>" rows="2"  class="form-control marginLeft" ng-model="field.action" name="action" ></textarea>
                                    </td>
                                    <td>
                                    
                                        <label for="textarea1" class="marginLeft font">Cost</label>
                                        <textarea style="width: 200px;" id="cost<%$index%>" rows="2" onkeydown="myFunction(event)" class="form-control marginLeft" ng-model="field.cost" name="cost" ></textarea>
                                      
                                    
                                    </td>
                                    <td>
                                    
                                        <label for="textarea1" class="marginLeft font">Hour</label>
                                        <textarea style="width: 200px;" id="hour<%$index%>" rows="2" onkeypress="return Numeric(event);" class="form-control marginLeft" ng-model="field.hour"  name="hour" >
                                        </textarea>
                                      
                                    
                                    </td>
                                    <td >
                                   <div class="file-field input-field table-wrapper" style="width:200px;">
                                      <div class="marginLeft font">
                                        <span>Browse *</span>

                                         <input size="5" type="file" id="doc"  name="doc<%$index%>[]"  multiple="multiple"  ng-model="field.doc" >
                                         <input type="hidden" name="Upload" id="Upload1" value="<%$index%>">
                                         <input type="hidden" id="aid<%$index%>" name="aid" value="<?php echo  Request::segment(3);?>">
                                         <input type="hidden" id="pid<%$index%>" name="pid" value="<?php echo  Request::segment(4);?>">
                                         <input type="hidden" id="tid<%$index%>" name="tid" value="<?php echo  Request::segment(5);?>">
                                         </div>
                                    </div>
                                         </td>
                                       
                                         <td>
                                         <table class=" font">
                                         <tr  style="width: 300px;" ng-repeat="d in field.doc[0] track by $index" ng-init="child=$index">
                                        <td>
                                        <%child+1%><% ". "+ d.upload_doc%>
                                        <input type="hidden" id="fileId<%child%>" value="<%d.id%>">
                                        <input type="hidden" id="fileName<%child%>" value="<%d.upload_doc%>">
                                        
                                        </td>

                                      <td >
                                        <button  id="btndeleteFile<%$index%>" type="button" class="tooltipped " value="<%$index%>" data-position="bottom" data-delay="50" data-tooltip="Delete File" ng-click="deleteFile(d.id,d.upload_doc)"><i class="fa fa-trash-o"></i></button>
                                      </td>
                                  </tr>
                                  </table>
                                    </td>
                                   <td>   <label for="textarea1" class="marginLeft font">Issue Face</label>
                                        <textarea style="width: 250px;" id="issue<%$index%>" rows="2"  class="form-control marginLeft" ng-model="field.issue" name="issue" ></textarea>
                                    </td>
                                     <td >
                                   <div class="file-field input-field table-wrapper" style="width:200px;">
                                      <div class="marginLeft font">
                                        <span>Browse Issue File</span>

                                         <input size="5" type="file" id="issueDoc"  name="issueDoc<%$index%>[]"  multiple="multiple"  ng-model="field.issueDoc" >
                                         <input type="hidden" name="Upload" id="Upload1" value="<%$index%>">
                                         <input type="hidden" id="aid<%$index%>" name="aid" value="<?php echo  Request::segment(3);?>">
                                         <input type="hidden" id="pid<%$index%>" name="pid" value="<?php echo  Request::segment(4);?>">
                                         <input type="hidden" id="tid<%$index%>" name="tid" value="<?php echo  Request::segment(5);?>">
                                         </div>
                                    </div>
                                         </td> 
                                    <td>
                                         <table class=" font">
                                         <tr  style="width: 300px;" ng-repeat="d in field.Issuedoc[0] track by $index" ng-init="child=$index">
                                        <td>
                                        <%child+1%><% ". "+ d.issue_document%>
                                        <input type="hidden" id="fileId<%child%>" value="<%d.id%>">
                                        <input type="hidden" id="fileName<%child%>" value="<%d.issue_document%>">
                                        
                                        </td>

                                      <td >
                                        <button  id="btndeleteIssueFile<%$index%>" type="button" class="tooltipped " value="<%$index%>" data-position="bottom" data-delay="50" data-tooltip="Delete File" ng-click="deleteIssueFile(d.id,d.issue_document)"><i class="fa fa-trash-o"></i></button>
                                      </td>
                                  </tr>
                                  </table>
                                    </td>
                                   
                                    
                                    <!-- <td>
                                  <div class="">
                                   <label for="textarea"></label>
                                  
                                        <span></span>
                                       <button style="width: 80px;" id="submitDocument<%$index%>" class="btn btn-animate flat blue pd-btn marginLeft" name="submitDocument" type="button"  value="<%$index%>"   onclick="saveTaskDet('<?=Request::segment(3);?>',<?=Request::segment(4)?>,<?=Request::segment(5);?>,this)" >Save</button>

                                       </td>
         <td>                             
    <span style="width: 80px;" class="marginLeft" ng-click="remove($index,'<?=Request::segment(3);?>','<?=Request::segment(4);?>','<?=Request::segment(5);?>')" ng-show="$index"><i style="width: 80px;"  class="fa fa-times-circle " ></i></span>

                                   
                               
                                </td>
                                   -->
                                 </tr>
        
                            </table>
                          <!-- </div> -->
                            <div class="row">
                                    <div class="input-field col-sm-12" >
                                        <button class="btn btn-animate flat blue pd-btn pull-right" id="AddNum" type="button" ng-click="add()" style="margin-right: -515px;">Add More</button>

                                    </div>
                                </div>
                             
                                </br>
                                <div class="row mg-btm mg-btm" ">
                                       <div class="input-field col-sm-6">
                                        <label for="textarea1">Remark</label>
                                       <!--  <input type="text" name="asdate" id="asdate" rows="3"  class="form-control"   > -->
                                      <!--  <input type="text" name="txtremark" ng-model="taskremark" id="remark" onkeyup="hideMessageRemark()"  required/>
                                       -->
                                        <!-- <span id="errorRemark"  style="display: none;"> This field is required.</span> -->
                                         <input type="text" name="txtremark" ng-model="taskremark" id="remark" />
                                      
                                    </div>
                                     
                                    </div>
                                <div class="row">
                              <div class="col-sm-4 ">
                                  
                              
                                  <div class="loading-spiner-holder" data-loading >
                                      <div class="loading-spiner">
                                          <img src="<?php echo Request::root(); ?>/protected/public/images/Twirl.gif" />
                                      </div>
                                  </div>
                              </div>
                            </div> 
                            <br>
                            <div class="row">
                              <div class="col-sm-4 " id="send_button">
                                  <button class="btn btn-animate flat blue pd-btn" name="submitForm"  type="submit"   ng-disabled="dis" value="OK" >Send</button>
                              
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
 var aid = '<?=Request::segment(3);?>';
 var pid = '<?=Request::segment(4);?>';
 var act_id = '<?=Request::segment(5);?>';

 $(document).ready(function() {
    $("#flagDiv").hide();
});



 function deleteFile(param){

    var fileName=$("#fileName"+param.value).val();
    var fileId = $("#fileId"+param.value).val();
    var parent = $("#Upload1").val();
  
    $.ajax({
                     url:base_url+'deleteFile',
                    type: 'post',
                    data:{aid:aid,pid:pid,act_id:act_id,param:val,fileName:fileName},
                    beforeSend: function(){
                    $("#fade").show();
                    },
                    success: function (data) {
                      $.simplyToast('Saved Successfully','success');
                    window.location.reload();
                    
                
                  }
                  });
 }

  function hideMessage(){
       $("#errorrisk0").hide();
  }
  // function hideMessageRemark(){
  //      $("#errorRemark").hide();
  // }
  function checkdateval(){
    $("#errorProjectStartDate").hide();
  }
  function changeFlag(){
    var flag=$("#flag").text();
    // alert('flag'+flag);
          if(flag == 0){
            $("#send_button").hide();
          }else{
            $("#send_button").show();
          }
  }


  $('#formdata').submit(function(){
    // alert('hiii');
      var date =$("#asdate").val();
      var risk =$("#risk0").val();
      var remark=$("#remark").val();
      var hidparam = $("#hidparam").val();
      
       if(date == ""){
         $("#errorProjectStartDate").show();
         $("#errorProjectStartDate").addClass('error-msg');
         return false;
        
        }else if(risk == ""  ){
         $("#errorrisk0").show();
          $("#errorrisk0").addClass('error-msg');
          
          return false;
           
      }
      // else if(remark == ""){
      //    $("#errorRemark").show();
      //     $("#errorRemark").addClass('error-msg');
         
      //      return false;
      // }
      else if(hidparam == ""){
          alert("Please save parameter");
           return false;
      }else{
       $("#fade").show();
                          return true;

        
      }
});
    
  function myFunction(e){
        
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
      }

  function Numeric(e){
        
      if (e.which != 8 && e.which != 0 && (e.which < 47 || e.which > 57)  ) {
        //display error message
        $("#errmsg").html("Digits Only").show().fadeOut("slow");
               return false;
    }
      }
    
</script> 

<script>

   var base_url='<?php echo Request::root(); ?>/';
   var pid = '<?=Request::segment(4);?>';
   var aid = '<?=Request::segment(3);?>';
   var act_id = '<?=Request::segment(5);?>';
        $(document).ready(function(){
          
           $.ajax({
                     url:base_url+'getProjectStartDate',
                    type: 'post',
                    data:{pid:pid},
                    success: function (data) {
                   var startDate1 = new Date(data[0]['project_start_date']);
                    $("#asdate").datepicker({startDate: startDate1,endDate: '<?php echo date('d-m-Y'); ?>'});  
                  }
                  });
            $.ajax({
                     url:base_url+'apqp/checkParamkSave',
                    type: 'post',
                    data:{pid:pid,aid:aid,act_id:act_id},
                    success: function (data) {
                      if(data=='save'){
                        $("#hidparam").val("save");
                      }
                      // if(flag == 0){
                      //     $("#send_button").hide();
                      //   }else{
                      //     $("#send_button").show();
                      //   }
                     
                  }
                  });
               
            });   
  function saveTaskDet(aid,pid,actid,val){
       
      var risk=$("#risk"+val.value).val();
      var action=$("#action"+val.value).val();
      var cost=$("#cost"+val.value).val();
       var hour=$("#hour"+val.value).val();
      var aid=$("#aid"+val.value).val();
      var issue =$("#issue"+val.value).val();
      var pid=$("#pid"+val.value).val();
      var tid=$("#tid"+val.value).val();
      var Upload=$("#submitDocument"+val.value).val();
      var asdate=$("#asdate").val();
      var form =new FormData($("#formdata")[0]);
      var remark=$("#remark").val();
      // var flag=$("#flag").text();
      // alert('flag'+flag);
      if(risk == ""){
        alert("Please enter parameter");
      }else{
        $.ajax({
                url:base_url+'fileUpload/'+Upload,
               type: 'POST',
                data: new FormData($("#formdata")[0]),
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function(){
                    $("#fade").show();
                },
                success: function(data) {
                   $("#fade").show();
                    window.location.reload();
                     $("#fade").hide();
                   $.simplyToast('Saved Successfully','success'); 
                }
            });
       $.ajax({
                     url:base_url+'userDetails',
                    type: 'POST',
                    data:{risk:risk,action:action,cost:cost,aid:aid,pid:pid,tid:tid,asdate:asdate,Upload:Upload,issue:issue,hour:hour},
                    
                    success: function (data) {
                      $("#hidparam").val("save");
                       $("#fade").show();
                    return false;
                   
                    }
               
            });

       $.ajax({      url:base_url+'getTask1',
                    type: 'POST',
                    data:{aid:aid,pid:pid,tid:tid},
                    
                    success: function (data) {
                      alert(data);
                      $("#asdate").val(data);
                    }
               
            });

      }
       }
       
</script>
