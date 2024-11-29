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
                          <h1>Check User Status</h1>
                        </div><!--/page-heading-->    
                      </div>
                    </div>

                  <div class="content-wrapper">                    
                   

                      <div class="form-wrapper select-height" ng-controller="checkUserStatusCtrl">
                          <div class="row">
                              <form method="post" action="<?php echo Request::root().'/checkForUserActive'; ?>" role="form" class="col-sm-12 myform" id="changerequestmodifyForm" ng-class="{'submitted': submitted}" name="changerequestmodifyForm" novalidate ng-submit="(submitted = true) && requestForm.$invalid && $event.preventDefault()"  autocomplete="off" >

                              <div class="row mg-btm">
                                  <div class="input-field col-sm-4">
                                      <label for="initiator_name">Select User</label>
                                      <select class="form-control" select2=""  ng-model="request.user" name="user"  id="user" >
                                          <option  value=""></option>

                                          <option ng-repeat="r in Alluser" value="<%r.id%>"><%r.first_name%> <%r.last_name%> <%r.username%></option>

                                      </select>
                                      <span ng-cloak class="error-msg " ng-show="(changerequestmodifyForm.user.$dirty || invalidSubmitAttempt) && changerequestmodifyForm.user.$error.required"> This field is required.</span>
                                  </div>
                                  </div>
                                   <div class="row mg-btm" >
                              
                            </div>

                                  <div class="row mg-btm mg-btm">

                                  <div class="row">
                                      <div class="col-sm-12 ">
                                          <button class="btn btn-animate flat blue pd-btn"  type="submit" id="action" name="action" ng-click="dosearch(changerequestmodifyForm,event)" >Submit</button>

                                           <div class="loading-spiner-holder" data-loading >
                                    <div class="loading-spiner">
                                    <img src="<?php echo Request::root(); ?>/protected/public/images/Twirl.gif" />
                                    </div>
                                    </div>
                                      </div>
                                  </div>
                                  </div>
                              </form>
                          </div>
                      </div>


                      </div><!--/form-wrapper-->

                    

                  </div><!--/content-wrapper-->
                </div><!--/s10-->
              </div><!--/row-->
            
      </div><!--/container-->
  </div><!--/main-wrapper-->
  
<?php require app_path().'/views/footer.php'; ?>


<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo Request::root(); ?>/protected/public/js/simply-toast.min.js"></script>
