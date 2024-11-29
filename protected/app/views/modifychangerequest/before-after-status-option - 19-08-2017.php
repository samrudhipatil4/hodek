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
                    <?php if($request_id == ""){
                        $request_id =  Request::segment(3);

                    }else{
                        $request_id = $request_id;

                    }?>

                  <div class="content-wrapper">

                    <div class="form-wrapper" ng-controller="BeforeAfterStatusCTRL" ng-init="fetch_changed_file(<?=$request_id; ?>);fetch_changed_date(<?=$request_id; ?>)">
                        <div class="row mg-bottom-0">

                          <form method="post" role="form" action="<?php echo Request::root().'/before_after_status_option_by_admin/'.$request_id; ?>" class="col-sm-12 myform" ng-class="{'submitted': submitted}" name="formdata" novalidate ng-submit="(submitted = true) && formdata.$invalid && $event.preventDefault()" enctype="multipart/form-data" autocomplete="off">

                            <div class="row">
                              <div class="col-sm-12">
                                <p>Change Implementation Date</p>
                              </div>
                            </div>



                         <div class="controls">
                                <div class="input-group col-sm-4">
                                <input id="startdate" class="date-picker form-control " data-date-format="dd/mm/yyyy" type="text" ng-model="result1.post_date" name="startdate" readonly>
                                 <label class="input-group-addon btn" for="startdate">
                                <span class="glyphicon glyphicon-calendar"></span>
                                </label>
                                </div>
                                <span class="error-msg" ng-show="(formdata.startdate.$dirty || invalidSubmitAttempt) && formdata.startdate.$error.required"> This field is required.</span>

                         </div>




                              <div class="row mg-btm" >
                                  <div class="col-sm-4">
                                      <p class="size-12 color-skyblue"></p>
                                      <div class="file-field input-field">
                                          <div class="btn">

                                                <table><tr ng-repeat="file in result">
                                                        <td><%file.attach_file%> </td>
                                                        <td>
                                                            <form method="post" id="x_<%attchment.attachment_id%>" enctype="multipart/form-data" action="">
                                                                <input type="hidden" name="list_id" value="<%file.file_id%>">
                                                                <input type="hidden" name="attachment_name" value="<%attchment.doc_name%>" ng-model="file.attachment_name">
                                                                <input type="hidden" name="delete_attachment" value="1">
                                                                <input type="hidden" name="requestId"  value="<?=$request_id;?>">
                                                                <button  type="submit"  class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="Delete Record" ng-click="deleteRecord(file.file_id,file.r_id,file.attach_file)"  ng-disabled="isDisabl"><i class="fa fa-trash-o"></i></button>

                                                            </form>

                                                        </td>
                                                    </tr></table>



                                          </div>


                                      </div>
                                      <!--<span class=""> Image is required.</span>-->


                                  </div>
                              </div>

                            <div class="row mg-btm" ng-class="{ 'has-error' : formdata.doc.$invalid && !formdata.doc.$pristine }">
                                <div class="col-sm-4">
                                  <p class="size-12 color-skyblue">Add information or make changes to your request</p>
                                    <div class="file-field input-field">
                                      <div class="btn">
                                        <span>Browse *</span>

                                         <input type="file" name="doc[]" multiple="multiple" valid-file  ng-model="doc" >
                                         <input type="hidden" name="Upload" value="1">


                                      </div>


                                    </div>
                                    <!--<span class=""> Image is required.</span>-->


                                </div>
                            </div>

                            <div class="row">
                              <div class="col-sm-4 ">
                                  <button class="btn btn-animate flat blue pd-btn" type="submit"  value="OK" data-after-submit-value="Saving&hellip;">OK</button>
                                <!--  <button class="btn btn-animate flat blue pd-btn" type="submit"  ng-click="beforeafterstatus(formdata)"/>OK</button>-->
                               <!-- <button class="btn btn-animate flat blue pd-btn" type="submit" value="OK" data-after-submit-value="Saving&hellip;"/>OK</button>-->
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

    //$(document).ready(function() {
    //jQuery(function($) {alert();
        // set data-after-submit-value on input:submit to disable button after submit
        $(document).on('submit', 'form', function() {
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
  //  });
</script>
