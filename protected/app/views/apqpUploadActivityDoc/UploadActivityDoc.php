
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
    font-family: cursive;">Upload Document </h1>
                      
                        </div><!--/page-heading-->    
                      </div>
                    </div>

                  <div class="content-wrapper">

                    <div class="form-wrapper" ng-controller="uploadActivityDocCtrl" ng-init="getProject()">
                          


                        <div class="row mg-bottom-0" >
                         
            <form method="post" role="form"  class="col-sm-12
                          myform" ng-class="{'submitted': submitted}"
                          id="requestForm" name="requestForm" novalidate  ng-
                          submit="form.$invalid &&
                          $event.preventDefault();form.$submitted=true;"
                          enctype="multipart/form-data" autocomplete="off" >
                  
                                   <div class="row mg-btm">
                                <div class="input-field col-sm-4">
                              <label for="initiator_name">Select Project</label>
                              <select class="form-control" select2="" id="proj_no" ng-model="request.proj_no" name="proj_no" ng-change="getGateInfo(request.proj_no)" required >
                                  <option  value=""></option>
                                  <option ng-repeat="d in file" value="<%d.id%>"><%d.project_no%></option>
                              </select>
                              <span id="projecterror" ng-cloak class="error-msg " ng-show="(requestForm.proj_no.$dirty || invalidSubmitAttempt) && requestForm.proj_no.$error.required"> This field is required.</span>
                          </div>
                           <div class="input-field col-sm-4">
                              <label for="initiator_name">Select Gate</label>
                              <select class="form-control" select2="" id="gate" ng-model="request.gate" name="gate" ng-change="getActivity(request.proj_no,request.gate)" required >
                                  <option  value=""></option>
                                  <option ng-repeat="d in gate" value="<%d.id%>"><%d.Gate_Description%></option>
                              </select>
                              <span id="gateerror" ng-cloak class="error-msg " ng-show="(requestForm.proj_no.$dirty || invalidSubmitAttempt) && requestForm.proj_no.$error.required"> This field is required.</span>
                          </div>
                             <div class="input-field col-sm-4">
                              <label for="initiator_name">Select Activity </label>
                              <select class="form-control" select2=""  ng-model="request.activity" id="activity" name="activity" ng-change="getParam(request.activity,request.proj_no,request.gate)"  required>
                                  <option  value=""></option>
                                  <option ng-repeat="d in activity" value="<%d.id%>"><%d.activity%></option>
                              </select>
                              <span id="activityerror" ng-cloak class="error-msg " ng-show="(requestForm.activity.$dirty || invalidSubmitAttempt) && requestForm.activity.$error.required"> This field is required.</span>
                          </div>
                                                    

                            </div>
                          <div class="row">
                           <div class="input-field col-sm-4">
                              <label for="initiator_name">Select Parameter</label>
                              <select class="form-control" select2=""  ng-model="request.param" name="param" id="param" required >
                                  <option  value=""></option>
                                  <option ng-repeat="d in param" value="<%d.parameter%>"><%d.risk%></option>
                              </select>
                              <span id="paramerror" ng-cloak class="error-msg " ng-show="(requestForm.param.$dirty || invalidSubmitAttempt) && requestForm.param.$error.required"> This field is required.</span>
                          </div>  
                          <div class="input-field col-sm-4">
                          <label for="initiator_name">Remark</label>
                              <textarea type="text" class="form-control" id="remark" name="remark"  required></textarea>
                              <span id="remarkerror" ng-cloak class="error-msg " ng-show="(requestForm.uploadFile.$dirty || invalidSubmitAttempt) && requestForm.uploadFile.$error.required"> This field is required.</span>
                          </div>
                          <div class="col-sm-4" style="margin-top: 40px;">
                              <input type="file" id="uploadFile" name="uploadFile[]" multiple="multiple" required>
                              <span id="fileerror" ng-cloak class="error-msg " ng-show="(requestForm.uploadFile.$dirty || invalidSubmitAttempt) && requestForm.uploadFile.$error.required"> This field is required.</span>
                          </div>
                          </div>
                                   
                                    <div class="row">
                                        <div class="col-sm-12 ">
                                            <br>
                                            <button class="btn btn-animate flat blue pd-btn" ng-disabled="isDisabled" type="submit" id="saveData"  name="action" >Save</button>
                                            
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
var base_url='<?php echo Request::root(); ?>/';

$("#proj_no").change(function(){
  var id = "proj_no";
  disableError(id);
});
$("#activity").change(function(){
  var id = "activity";
  disableError(id);
});
$("#param").change(function(){
    var id = "param";
  disableError(id);
});
$("#uploadFile").change(function(){
  var id = "uploadFile";
  disableError(id);
});
$("#gate").change(function(){
  var id = "gate";
  disableError(id);
})
function disableError(id){
   var project =$("#proj_no").val();
    var gate =$("#gate").val();
    var activity = $("#activity").val();
    var param= $("#param").val();
    var file = $("#uploadFile").val();
        if(id == "proj_no"){
    if(project == "" )
        {
          $('#projecterror').addClass('ng-show').removeClass('ng-hide');
        }else{
           $('#projecterror').addClass('ng-hide').removeClass('ng-show');
        }
      }
      if(id == "gate"){
    if(gate == "" )
        {
          $('#gateerror').addClass('ng-show').removeClass('ng-hide');
        }else{
           $('#gateerror').addClass('ng-hide').removeClass('ng-show');
        }
      }
      if(id == "activity"){
        if(activity == "" )
        {
          
          $('#activityerror').addClass('ng-show').removeClass('ng-hide');
        }else{
           $('#activityerror').addClass('ng-hide').removeClass('ng-show');
        }
      }
      if(id == "param"){
          if(param == "" )
        {
          $('#paramerror').addClass('ng-show').removeClass('ng-hide');
        }else{
          $('#paramerror').addClass('ng-hide').removeClass('ng-show');
        }
      }
      if(id == "uploadFile"){
        if(file == "" )
        {
          $('#fileerror').addClass('ng-show').removeClass('ng-hide');
        }else{
          $('#fileerror').addClass('ng-hide').removeClass('ng-show');
        }
      } 
}
  $("#saveData").click(function(){

     var project =$("#proj_no").val();
     var gate = $("#gate").val();

        var activity = $("#activity").val();
        var param= $("#param").val();
        var file = $("#uploadFile").val();
        var remark = $("#remark").val();
    if(project == "" )
        {
          
          $('#projecterror').addClass('ng-show').removeClass('ng-hide');
        }else{
           $('#projecterror').addClass('ng-hide').removeClass('ng-show');
        }
        if(gate == "" )
        {
          $('#gateerror').addClass('ng-show').removeClass('ng-hide');
        }else{
           $('#gateerror').addClass('ng-hide').removeClass('ng-show');
        }
      
        if(activity == "" )
        {
          
          $('#activityerror').addClass('ng-show').removeClass('ng-hide');
        }else{
           $('#activityerror').addClass('ng-hide').removeClass('ng-show');
        }
          if(param == "" )
        {
          $('#paramerror').addClass('ng-show').removeClass('ng-hide');
        }else{
          $('#paramerror').addClass('ng-hide').removeClass('ng-show');
        }

        if(file == "" )
        {
          $('#fileerror').addClass('ng-show').removeClass('ng-hide');
        }else{
          $('#fileerror').addClass('ng-hide').removeClass('ng-show');
        }

       
        if(project != "" && activity != "" && param != "" && file != ""){
         $.ajax({
              //url: 'http://10.51.80.87/CM/changeReqUpload',

                url: base_url+'uploaddoc/uploadFile/'+project+'/'+activity+'/'+param,
                type: 'POST',
                data: new FormData($("#requestForm")[0]),
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function(){
                    $("#fade").show();
                },
                success: function(data) {
                    $("#fade").hide();
                    $.simplyToast('Saved successfully.', 'success');
                    //alert("Saved successfully");
                   window.location.href=base_url+'uploadActivitydoc';
                    return false;
                }
            });
       }
        
  });

</script>