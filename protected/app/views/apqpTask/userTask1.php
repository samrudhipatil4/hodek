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

                    <div class="form-wrapper" ng-controller="apqpTaskCtrl" ng-init="getTask(<?=Request::segment(3);?>,<?=Request::segment(4);?>,<?=Request::segment(5);?>);getFile(<?=Request::segment(3);?>,<?=Request::segment(4);?>,<?=Request::segment(5);?>)">
                        <div class="row mg-bottom-0">
                         
                          <form method="post" role="form"   action="<?php echo Request::root().'/apqp/submitTask/'.Request::segment(3).'/'.Request::segment(4).'/'.Request::segment(5); ?>" class="col-sm-12 myform" ng-class="{'submitted': submitted}" id="formdata" name="formdata" novalidate ng-submit="(submitted = true) && formdata.$invalid && $event.preventDefault()" enctype="multipart/form-data" autocomplete="off" >

                            
                           <div class="row mg-btm mg-btm" ">
                                       <div class="input-field col-sm-6">
                                        <label for="textarea1">Actual Start Date</label>
                                       <!--  <input type="text" name="asdate" id="asdate" rows="3"  class="form-control"   > -->
                                       <input type="text" name="startdate_status"  id="asdate"  readonly data-date-format="dd/mm/yyyy" ng-model="result" required/>
                                        <span ng-cloak class="error-msg " ng-show="(formdata.asdate.$dirty || invalidSubmitAttempt) && formdata.asdate.$error.required"> This field is required.</span>
                                    </div>
                                     
                                    </div>
                           
                                  <div class="row mg-btm mg-btm" ng-repeat="field in fields track by $index">
                                       <div class="input-field col-sm-3">
                                        <label for="textarea1">Parameter</label>
                                        <textarea id="risk<%$index%>" rows="2"  class="form-control" ng-model="field.risk" name="risk" ></textarea>
                                        <span ng-cloak class="error-msg " ng-show="(formdata.risk.$dirty || invalidSubmitAttempt) && formdata.risk.$error.required"> This field is required.</span>
                                    </div>
                                  
                                 
                                       <div class="input-field col-sm-2">
                                        <label for="textarea1">Action</label>
                                        <textarea id="action<%$index%>" rows="2"  class="form-control" ng-model="field.action" name="action" ></textarea>
                                        <span ng-cloak class="error-msg " ng-show="(formdata.action.$dirty || invalidSubmitAttempt) && formdata.action.$error.required"> This field is required.</span>
                                    </div>
                                    <div class="input-field col-sm-2">
                                        <label for="textarea1">Cost</label>
                                        <textarea id="cost<%$index%>" rows="2" onkeydown="myFunction(event)" class="form-control" ng-model="field.cost" name="cost" ></textarea>
                                        <span ng-cloak class="error-msg " ng-show="(formdata.cost.$dirty || invalidSubmitAttempt) && formdata.cost.$error.required"> This field is required.</span>
                                    </div>
                                    <div class="col-sm-4">
                                   <label for="textarea"> Document Upload</label>
                                    <div class="file-field input-field">
                                      <div class="btn">
                                        <span>Browse *</span>

                                         <input size="5" type="file" id="doc"  name="doc<%$index%>[]"  multiple="multiple"  ng-model="field.doc" >
                                         <input type="hidden" name="Upload" value="<%$index%>">
                                         <input type="hidden" id="aid<%$index%>" name="aid" value="<?php echo  Request::segment(3);?>">
                                         <input type="hidden" id="pid<%$index%>" name="pid" value="<?php echo  Request::segment(4);?>">
                                         <input type="hidden" id="tid<%$index%>" name="tid" value="<?php echo  Request::segment(5);?>">


                                      </div>
                                    </div>
                                    </div>
                                  <div class="col-sm-1">
                                   <label for="textarea"></label>
                                    <div class="file-field input-field">

                                        <span></span>
                                       <button style="margin-top: 10px;
    margin-left: -52px;" id="submitDocument<%$index%>" class="btn btn-animate flat blue pd-btn" name="submitDocument" type="button"  value="<%$index%>"   onclick="saveTaskDet(<?=Request::segment(3);?>,<?=Request::segment(4)?>,<?=Request::segment(5);?>,this)" >Save</button>
                                      
    <span class="icon-delete" ng-click="remove($index)" ng-show="$index"><i class="fa fa-times-circle"></i></span>

                                    </div>
                                </div>
                                  
                                 
        
                            </div>
                            <div class="row">
                                    <div class="input-field col-sm-12" >
                                        <button class="btn btn-animate flat blue pd-btn pull-right" id="AddNum" type="button" ng-click="add()">Add More</button>

                                    </div>
                                </div>
                             
                                </br>
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
                              <div class="col-sm-4 ">
                                  <button class="btn btn-animate flat blue pd-btn" name="submitForm" type="submit"   ng-disabled="dis" value="OK" >Send</button>
                              
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
    



</script> 

<script>

   var base_url='<?php echo Request::root(); ?>/';
    
        $(document).ready(function(){
       // Numeric();
        
        $("#asdate").datepicker();  
      });
       function saveTaskDet(aid,pid,actid,val){
      var risk=$("#risk"+val.value).val();
      var action=$("#action"+val.value).val();
      var cost=$("#cost"+val.value).val();
      var aid=$("#aid"+val.value).val();
      var pid=$("#pid"+val.value).val();
      var tid=$("#tid"+val.value).val();
      var Upload=$("#submitDocument"+val.value).val();
      var asdate=$("#asdate").val();
      var form =new FormData($("#formdata")[0]);
      if(risk == ""){
        alert("Please enter parameter");
      }else{
        $.ajax({
                url:base_url+'fileUpload',
               type: 'POST',
                data: new FormData($("#formdata")[0]),
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function(){
                    $("#fade").show();
                },
                success: function(data) {
                   $("#fade").hide();
                  
                    return false;
                }
            });
       $.ajax({
                     url:base_url+'userDetails',
                    type: 'POST',
                    data:{risk:risk,action:action,cost:cost,aid:aid,pid:pid,tid:tid,asdate:asdate,Upload:Upload},
                    
                    success: function (data) {
                      
                   
                    }
               
            });

       $.ajax({
                     url:base_url+'getTask1',
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
