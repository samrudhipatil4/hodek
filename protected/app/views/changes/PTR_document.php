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
                          <h1>PTR Document</h1>
                        </div><!--/page-heading-->    
                      </div>
                    </div>

                  <div class="content-wrapper">

                    <div class="form-wrapper" ng-controller="PTRCtrl" ng-init="getData()">
                        <div class="row mg-bottom-0">

                          <form method="post" role="form" action="<?php echo Request::root().'/changes/PTR_doc_upload/'.Request::segment(3); ?>/<?=Request::segment(4); ?>" class="col-sm-12 myform" ng-class="{'submitted': submitted}" name="formdata" novalidate ng-submit="(submitted = true) && formdata.$invalid && $event.preventDefault()" enctype="multipart/form-data" autocomplete="off">

                            <div class="row mg-btm" ng-class="{ 'has-error' : formdata.doc.$invalid && !formdata.doc.$pristine }">
                                <div class="col-sm-4">
                                   <label for="textarea">PTR Document Upload</label>
                                    <div class="file-field input-field">
                                      <div class="btn">
                                        <span>Browse *</span>

                                         <input type="file" name="doc[]" multiple="multiple" valid-file ng-required="true" ng-model="doc" accept="<%ext%>">
                                         <input type="hidden" name="Upload" value="1">
                                      </div>

                                    </div>
                                    <!--<span class=""> Image is required.</span>-->


                                </div>
                            </div>
                             <div class="row mg-btm mg-btm" ">
                                      <div class="input-field col-sm-6">
                                          <label for="textarea">Write Comment </label>
                                          <textarea name="comment"  class="form-control " rows="3" style="width: 304px; height: 69px;" id="textarea" ></textarea>

                                      </div>

                                  </div>

                            <div class="row">
                              <div class="col-sm-4 ">
                                  <button class="btn btn-animate flat blue pd-btn" type="submit" ng-disabled="formdata.$invalid" value="OK" data-after-submit-value="Saving&hellip;">OK</button>
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
