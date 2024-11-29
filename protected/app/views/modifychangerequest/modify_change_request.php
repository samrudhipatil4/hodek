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
                          <h1>Modify Change Request</h1>
                        </div><!--/page-heading-->    
                      </div>
                    </div>

                  <div class="content-wrapper">                    
                    <div class="row">
                        <div class="col-sm-12">
                        <div class="page-heading mg-btm">
                          <h1>New Change Request Form</h1>
                        </div><!--/page-heading-->    
                      </div>
                    </div>


                      <div class="form-wrapper select-height" ng-controller="changereqmodifyCtrl">
                          <div class="row">
                              <form method="post" role="form" class="col-sm-12 myform" id="changerequestmodifyForm" ng-class="{'submitted': submitted}" name="changerequestmodifyForm" novalidate ng-submit="(submitted = true) && requestForm.$invalid && $event.preventDefault()"  autocomplete="off" action="<?php echo Request::root().'/changeRequestModifyDetails' ?>">

                              <div class="row mg-btm">

                                  <div class="input-field col-sm-4">


                                      <label for="initiator_name">Select Process</label>


                                      <select class="form-control" select2=""  ng-model="request.m_code" name="m_code" id="m_code" ng-change="fill_function(request.m_code)" required>
                                            <option  value=""></option>

                                          <option ng-repeat="d in changerequestModifyName" value="<%d.m_code%>"><%d.details%></option>

                                      </select>
                                    <span ng-cloak class="error-msg " ng-show="(changerequestmodifyForm.m_code.$dirty || invalidSubmitAttempt) && changerequestmodifyForm.m_code.$error.required"> This field is required.</span>


                                  </div>
                                  <div class="input-field col-sm-3">


                                      <label for="initiator_name">Select Request Id</label>


                                      <select class="form-control" select2=""  ng-model="request.r_id" name="r_id"  id="r_id" required>
                                          <option  value=""></option>

                                          <option ng-repeat="r in getChangeRequest" value="<%r.r_id%>"><%r.request_id%></option>

                                      </select>
                                      <span ng-cloak class="error-msg " ng-show="(changerequestmodifyForm.r_id.$dirty || invalidSubmitAttempt) && changerequestmodifyForm.r_id.$error.required"> This field is required.</span>

                                  </div>
                                  <div class="input-field col-sm-4" ng-if="dep">
                                      <label for="Change-Stage">Function</label>
                                      <select class="form-control" select2="" name="d_id" id="d_id" ng-model="request.d_id" required >
                                          <option  value=""></option>
                                          <option ng-repeat="department in departments" value="<%department.d_id%>"><%department.d_name%></option>
                                      </select>
                                      <span ng-cloak class="error-msg " ng-show="(changerequestmodifyForm.d_id.$dirty || invalidSubmitAttempt) && changerequestmodifyForm.d_id.$error.required"> This field is required.</span>
                                  </div>



                                  </div>


                                  <div class="row mg-btm mg-btm">

                                  <div class="row">
                                      <div class="col-sm-12 ">
                                          <button class="btn btn-animate flat blue pd-btn" ng-disabled="isDisabled" type="button" id="action" name="action" ng-click="changeRequestModify(changerequestmodifyForm,$event)">Modify</button>

                                           <div class="loading-spiner-holder" data-loading >
                                    <div class="loading-spiner">
                                    <img src="<?php echo Request::root(); ?>/protected/public/images/Twirl.gif" />
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
<script>
    $(document).ready(function(){

        $("#action").click(function(event)
        {

            if($("#m_code").val() == "2" && $("#r_id").val() != "")
            {
                var request_id=$("#r_id").val();
                var dept_id=$("#d_id").val();

                $.ajax({
                    url: 'checkUserDefined',
                    type: 'POST',
                    data:{request_id:request_id,dept_id:dept_id},
                    beforeSend: function () {
                        $("#fade").show();
                    },
                    success: function (data) {
                        $("#fade").hide();
                        console.log(data);
                       if(data == 0){
                           $.simplyToast('You can not modify team.... team not define by initiator', 'warning');
                           $("#action").prop('disabled', false);
                           return false;
                       }else{

                           $("#changerequestmodifyForm").submit();
                       }

                    }
                });
                return false;
            }else if($("#m_code").val() == "3" && $("#r_id").val() != "" && $("#d_id").val() != "")
            {
                var request_id=$("#r_id").val();
                var dept_id=$("#d_id").val();

                $.ajax({
                    url: 'riskAssessFill',
                    type: 'POST',
                    data:{request_id:request_id,dept_id:dept_id},
                    beforeSend: function () {
                        $("#fade").show();
                    },
                    success: function (data) {
                        $("#fade").hide();
                        console.log(data);
                       if(data == 0){
                           $.simplyToast('You can not modify Risk assessment point.... User has not entered risk assessment point', 'warning');
                           $("#action").prop('disabled', false);
                           return false;
                       }else{

                           $("#changerequestmodifyForm").submit();
                       }

                    }
                });
                return false;
            }else if($("#m_code").val() == "4" && $("#r_id").val() != "" )
            {
                var request_id=$("#r_id").val();


                $.ajax({
                    url: 'getCustCommDecision',
                    type: 'POST',
                    data:{request_id:request_id},
                    beforeSend: function () {
                        $("#fade").show();
                    },
                    success: function (data) {
                        $("#fade").hide();
                        console.log(data);
                       if(data == 0){
                            $.simplyToast('You can not modify customer evidence upload.... QA head not given dicision on customer communication.', 'warning');
                            $("#action").prop('disabled', false);
                            return false;
                        }else{

                            $("#changerequestmodifyForm").submit();
                        }

                    }
                });
                return false;
            }else if($("#m_code").val() == "5" && $("#r_id").val() != "" && $("#d_id").val() != "")
            {
                var request_id=$("#r_id").val();
                var dept_id=$("#d_id").val();

                $.ajax({
                    url: 'getCustverification',
                    type: 'POST',
                    data:{request_id:request_id},
                    beforeSend: function () {
                        $("#fade").show();
                    },
                    success: function (data) {
                        $("#fade").hide();
                        console.log(data);
                        if(data == 0){
                            $.simplyToast('You can not modify activity evidence upload....risk assessment point not approved by superadmin ', 'warning');
                            $("#action").prop('disabled', false);
                            return false;
                        }else{


                            $.ajax({
                    url: 'deptAvilable',
                    type: 'POST',
                    data:{request_id:request_id,dept_id:dept_id},
                    beforeSend: function () {
                        $("#fade").show();
                    },
                    success: function (data) {
                        $("#fade").hide();
                        console.log(data);

                        if(data == 0){
                            $.simplyToast('This department not applicable for this request', 'warning');
                            $("#action").prop('disabled', false);
                            return false;
                        }else{
                            $("#changerequestmodifyForm").submit();
                        }

                    }
                });
                        }

                    }
                });
                return false;
            }else if($("#m_code").val() == "6" && $("#r_id").val() != "" )
            {
                var request_id=$("#r_id").val();


                $.ajax({
                    url: 'getBeforeAfterStatus',
                    type: 'POST',
                    data:{request_id:request_id},
                    beforeSend: function () {
                        $("#fade").show();
                    },
                    success: function (data) {
                        $("#fade").hide();
                        console.log(data);
                        if(data == 0){
                            $.simplyToast('You can not modify implementation date and before after status.... implementation date and before after status not entered by user', 'warning');
                            $("#action").prop('disabled', false);
                            return false;
                        }else{

                            $("#changerequestmodifyForm").submit();
                        }

                    }
                });
                return false;
            }else{
                var x=$("#m_code").val();
                var y=$("#r_id").val();
                var z=$("#d_id").val();
                if(x == "" ||  y == "" || z=="")  {


                    event.preventDefault();
                }else{

                    $("#changerequestmodifyForm").submit();
                }

            }
        });

    });
</script>
