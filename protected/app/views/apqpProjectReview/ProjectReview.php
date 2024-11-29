
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
    font-family: cursive;">Project Review </h1>
                      
                        </div><!--/page-heading-->    
                      </div>
                    </div>

                  <div class="content-wrapper">

                    <div class="form-wrapper" ng-controller="ProjectReviewCtrl" ng-init="getProject()">
                          


                        <div class="row mg-bottom-0" >
                         
            <form method="post" role="form"  class="col-sm-12
                          myform" ng-class="{'submitted': submitted}"
                          id="requestForm" name="requestForm" novalidate  ng-
                          submit="form.$invalid &&
                          $event.preventDefault();form.$submitted=true;"
                          enctype="multipart/form-data" autocomplete="off" >
                  
                                   <div class="row mg-btm">
                                <div class="input-field col-sm-6">
                              <label for="initiator_name">Select Project</label>
                              <select class="form-control" select2="" id="proj_no" ng-model="request.proj_no" name="proj_no" onclick="disableError();" ng-change="getGate(request.proj_no)" required >
                                  <option  value=""></option>
                                  <option ng-repeat="d in file" value="<%d.id%>"><%d.project_no%></option>
                              </select>
                              <span id="projecterror" ng-cloak class="error-msg " ng-show="(requestForm.proj_no.$dirty || invalidSubmitAttempt) && requestForm.proj_no.$error.required"> This field is required.</span>
                          </div>
                             <div class="input-field col-sm-6">
                              <label for="initiator_name">Select Gate </label>
                              <select class="form-control" select2=""  ng-model="request.gate" id="gate" name="gate" required>
                                  <option  value=""></option>
                                  <option ng-repeat="d in gate" value="<%d.id%>"><%d.Gate_Description%></option>
                              </select>
                              
                          </div>
                                                       

                            </div>
                          <div class="row">
                          <div class="input-field col-sm-6">
                          <label for="initiator_name">Comment</label>
                              <textarea type="text" onkeyup="disableError('comment');" class="form-control" id="comment" name="comment"  required></textarea>
                              <span id="commenterror" ng-cloak class="error-msg " ng-show="(requestForm.comment.$dirty || invalidSubmitAttempt) && requestForm.comment.$error.required"> This field is required.</span>
                          </div>
                           <div class="input-field col-sm-6">
                          <label for="initiator_name">Date</label>
                               <input type="text"  name="startdate_status"  id="startdate_status1"  readonly data-date-format="dd/mm/yyyy" ng-model="result" required/>
                              <span id="dateerror" ng-cloak class="error-msg " ng-show="(requestForm.date.$dirty || invalidSubmitAttempt) && requestForm.date.$error.required"> This field is required.</span>
                          </div>
                          </div>
                          <div class="row">
                          <div class="input-field col-sm-6">
                          <label for="initiator_name">Team Member</label>
                               <select  class="form-control" select2="" multiple id="member" ng-model="request.member" name="member[]" required>
                                            <option  value=""></option>
                                            <option ng-repeat="d in member" value="<%d.id%>"><%d.first_name%> <%d.last_name%></option>
                                        </select>
                              <span id="membererror" ng-cloak class="error-msg " ng-show="(requestForm.member.$dirty || invalidSubmitAttempt) && requestForm.uploadFile.$error.required"> This field is required.</span>
                          </div>
                          <div class="col-sm-6" style="margin-top: 25px;">
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
$("#startdate_status1").datepicker({

});

$(function() {
    $("#startdate_status1").click(function() {
          var id = "startdate_status1"
        disableError(id);
    });
});
$("#proj_no").change(function(){
   var id = "proj_no"
  disableError(id);

});
$("#member").change(function(){
    var id = "member"
  disableError(id);
});
$("#uploadFile").change(function(){
     var id = "uploadFile"
  disableError(id);
});

function disableError(id){

    var proj_no =$("#proj_no").val();
       
   var comment= $("#comment").val();
  var file = $("#uploadFile").val();
  var date = $("#startdate_status1").val();
  var member = $("#member").val();
      if(id == "proj_no"){  
    if(proj_no == "")
        {
          $('#projecterror').addClass('ng-show').removeClass('ng-hide');
        }else{
           $('#projecterror').addClass('ng-hide').removeClass('ng-show');
        }
      }
      if(id == "comment"){
        if(comment == "" )
        {
          $('#commenterror').addClass('ng-show').removeClass('ng-hide');
        }else{
           $('#commenterror').addClass('ng-hide').removeClass('ng-show');
        }
      }
      if(id == "date"){
          if(date == "" )
        {
          $('#dateerror').addClass('ng-show').removeClass('ng-hide');
        }else{
          $('#dateerror').addClass('ng-hide').removeClass('ng-show');
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
         if(id == "member"){
        if(member == "" || member == null)
        {
          $('#membererror').addClass('ng-show').removeClass('ng-hide');
        }else{
          $('#membererror').addClass('ng-hide').removeClass('ng-show');
        }
      }
}  
  $("#saveData").click(function(){

     var project =$("#proj_no").val();
       
        var comment= $("#comment").val();
        var file = $("#uploadFile").val();
        var date = $("#startdate_status1").val();
        var member = $("#member").val();
        
    if(project == "" )
        {
          $('#projecterror').addClass('ng-show').removeClass('ng-hide');
        }else{
           $('#projecterror').addClass('ng-hide').removeClass('ng-show');
        }
        if(comment == "" )
        {
          $('#commenterror').addClass('ng-show').removeClass('ng-hide');
        }else{
           $('#commenterror').addClass('ng-hide').removeClass('ng-show');
        }
          if(date == "" )
        {
          $('#dateerror').addClass('ng-show').removeClass('ng-hide');
        }else{
          $('#dateerror').addClass('ng-hide').removeClass('ng-show');
        }

        if(file == "" )
        {
          $('#fileerror').addClass('ng-show').removeClass('ng-hide');
        }else{
          $('#fileerror').addClass('ng-hide').removeClass('ng-show');
        }

        if(member == "" || member == null)
        {
          $('#membererror').addClass('ng-show').removeClass('ng-hide');
        }else{
          $('#membererror').addClass('ng-hide').removeClass('ng-show');
        }

       
        if(project != "" && file != "" && comment != "" && date != "" && (member != "" || member != null)){
         $.ajax({
              //url: 'http://10.51.80.87/CM/changeReqUpload',

                url: base_url+'projectReview/addReview',
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
                   // alert("Saved successfully");
                   window.location.href=base_url+'projectReview';
                    return false;
                }
            });
       }
        
  });

</script>