<?php require app_path().'/views/header.php'; ?>

  <div class="main-wrapper">
    <div class="container">

              <div class="row two-col-row mg-bottom-0">
                <div class="col-sm-2">
                    <?php require app_path().'/views/sidebar.php'; ?>
                </div><!--/s2-->
                <div class="col-sm-10">

                    <div class="row">
                      <div class="col-sm-12">
                        <div class="page-heading">
                          <h1>Before/after status option</h1>
                        </div><!--/page-heading-->    
                      </div>
                    </div>
                    <?php if(Session::has('message')){

                        echo Session::get('message');

                    }?>
                  <div class="content-wrapper">

                    <div class="form-wrapper" ng-controller="BeforeAfterStatusCTRL" ng-init="fetch_implementation_date(<?=Request::segment(3); ?>);fetch_changed_file(<?=Request::segment(3); ?>)">
                        <div class="row mg-bottom-0">

                          <form method="post" role="form" action="<?php echo Request::root().'/changes/before-after-status-option/'.Request::segment(3); ?>/<?=Request::segment(4); ?>" class="col-sm-12 myform" ng-class="{'submitted': submitted}" name="formdata" novalidate ng-submit="(submitted = true) && formdata.$invalid && $event.preventDefault()" enctype="multipart/form-data" autocomplete="off">
                          <div 
                            <div class="row">
                              <div class="col-sm-12">
                                <p>Proposed Implementation Date</p>
                              </div>
                            </div>

                            
                         <div class="controls" ng-if="stage=='1'">
                                <div class="input-group col-sm-4">
                                <input type="text" name="startdate"  id="date-picker"  readonly data-date-format="dd/mm/yyyy" ng-model="result" disabled required/>
                                 <label class="input-group-addon btn" for="startdate">
                                <span class="glyphicon glyphicon-calendar"></span>
                                </label>
                                </div>
                               
                                <span class="error-msg" ng-show="(formdata.startdate.$dirty || invalidSubmitAttempt) && formdata.startdate.$error.required"> This field is required.</span>

                                 </div>
                                 <div class="controls" ng-if="stage!='1'">
                                <div class="input-group col-sm-4">
                                <input type="text" name="startdate"  id="date-picker"  readonly data-date-format="dd/mm/yyyy" ng-model="result" required/>
                                 <label class="input-group-addon btn" for="startdate">
                                <span class="glyphicon glyphicon-calendar"></span>
                                </label>
                                </div>
                                
                                <span class="error-msg" ng-show="(formdata.startdate.$dirty || invalidSubmitAttempt) && formdata.startdate.$error.required"> This field is required.</span>

                                 </div>
                                 <input type='hidden' name='startdatehid' value="<% result %>">
                                 <br/>
                                 <div class="row" ng-show="stage=='1'">
                                <div class="col-sm-12">
                                <!-- <p>Actual Implementation Date</p> -->
                                <p>Change Cut-Off Date</p>
                                </div>
                              </div>
                             <div class="controls" ng-if="stage=='1'">
                                <div class="input-group col-sm-4">
                                
                                <input type="text" name="actualdate"  id="actualdate"  readonly data-date-format="dd/mm/yyyy" ng-model="actualdate" required="" />
                                 <label class="input-group-addon btn" for="actualdate">
                                <span class="glyphicon glyphicon-calendar"></span>
                                </label>
                                </div>
                                <span class="error-msg" ng-show="(formdata.actualdate.$dirty || invalidSubmitAttempt) && formdata.actualdate.$error.required"> This field is required.</span>

                                 </div>
                                  <div class="row mg-btm" >
                                  <div class="col-sm-4">
                                      <p class="size-12 color-skyblue"></p>
                                      <div class="file-field input-field">
                                          <div class="btn">

                                                <table><tr ng-repeat="file in result2">
                                                        <td><%file.attach_file%> </td>
                                                        <td>
                                                            <form method="post" id="x_<%attchment.attachment_id%>" enctype="multipart/form-data" action="">
                                                                <input type="hidden" name="list_id" value="<%file.file_id%>">
                                                                <input type="hidden" name="attachment_name" value="<%attchment.doc_name%>" ng-model="file.attachment_name">
                                                                <input type="hidden" name="delete_attachment" value="1">
                                                                <input type="hidden" name="requestId"  value="<?=Request::segment(3);?>">
                                                                <button  type="button"  class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="Delete Record" ng-click="deleteRecord(file.file_id,file.r_id,file.attach_file)"  ng-disabled="isDisabl1"><i class="fa fa-trash-o"></i></button>

                                                            </form>

                                                        </td>
                                                    </tr></table>
                                          </div>

                                      </div>
                                    
                                  </div>
                              </div>

                                 <br/>

                            
                            <div class="row mg-btm" ng-class="{ 'has-error' : formdata.doc.$invalid && !formdata.doc.$pristine }">
                                <div class="col-sm-4">
                                  <p class="size-12 color-skyblue">Add information or make changes to your request</p>
                                    <div class="file-field input-field" ng-if="isDisabl==false">
                                      <div class="btn" >
                                        <span>Browse *</span>
                                         <input type="file" name="doc[]" multiple="multiple" valid-file ng-required="true" ng-model="doc" accept="<%ext%>">
                                         <input type="hidden" name="Upload" value="1">
                                      </div>
                                    </div>
                                     <div class="file-field input-field" ng-if="isDisabl==true">
                                      <div class="btn" >
                                        <span>Browse *</span>
                                         <input type="file" name="doc[]" multiple="multiple"  ng-model="doc" accept="<%ext%>">
                                         <input type="hidden" name="Upload" value="1">
                                      </div>
                                    </div>
                                    <!--<span class=""> Image is required.</span>-->


                                </div>
                            </div>

                            <div class="row">
                              <div class="col-sm-4 " ng-if="isDisabl==true">
                                   <button class="btn btn-animate flat blue pd-btn" type="submit"  value="OK" data-after-submit-value="Saving&hellip;">OK</button>
                                
                                  <div class="loading-spiner-holder" data-loading >
                                      <div class="loading-spiner">
                                          <img src="<?php echo Request::root(); ?>/protected/public/images/Twirl.gif" />
                                      </div>
                                  </div>
                              </div>
                              <div class="col-sm-4 " ng-if="isDisabl==false">
                                   <button class="btn btn-animate flat blue pd-btn" type="submit" ng-disabled="formdata.$invalid" value="OK" data-after-submit-value="Saving&hellip;">OK</button>
                                
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

    $(document).ready(function() {
      $("#actualdate").datepicker({startDate: '<?php echo date('d-m-Y'); ?>'}); 
    //jQuery(function($) {alert();
        // set data-after-submit-value on input:submit to disable button after submit
        $(document).on('submit', 'form', function() {
          $("#fade").show();
            var $form = $(this),
                $button,
                label;
            $form.find(':submit').each(function() {
                $button = $(this);
                label = $button.data('after-submit-value');
                if (typeof label != 'undefined') {
                    $button.val(label).prop('disabled', true);
                }
            });
        });
    
    var base_url= '<?php echo Request::root(); ?>';
    var r_id='<?php echo Request::segment(3); ?>';
    
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
                      $("#date-picker").datepicker({startDate: '<?php echo date('d-m-Y'); ?>'});  
                       $("#actualdate").datepicker({startDate: '<?php echo date('d-m-Y'); ?>'}); 
                   }else{
                      $("#date-picker").datepicker({startDate: '<?php echo date('d-m-Y'); ?>', endDate : '<?php echo date("d-m-Y", strtotime("+14 days")); ?>'}); 
                       $("#actualdate").datepicker({startDate: '<?php echo date('d-m-Y'); ?>'});  
                   }
                    
                }
            });


    });
</script>
