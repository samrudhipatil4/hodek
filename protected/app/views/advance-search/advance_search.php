<style>
    .btn-back {
        color: #34B0E6 !important;
        cursor: pointer;
        font-weight: 400;
    }
    .btn-back:hover { color: #282828 !important;}
</style>
<?php require app_path().'/views/header.php'; ?>
 
  <div class="main-wrapper">
    <div class="container" ng-controller="AdvancedsearchCtrl">

              <div class="row two-col-row mg-bottom-0" >
                  
                  <div ng-show="search_summery">
         <div class="col-sm-2">
              
                     <!-- Sidebar Comes here! -->
          
          <?php require app_path().'/views/sidebar.php'; ?>
          
          <!-- sidebar ends here -->
                </div><!--/s2-->
                <div class="col-sm-10">

                    <div class="row">
                      <div class="col-sm-12">
                        <div class="page-heading">
                          <h1>Advanced Search Option</h1>
                        </div><!--/page-heading-->    
                      </div>
                    </div>

                  <div class="content-wrapper">
                    
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="page-heading mg-btm">
                          <h2>To View Summary Sheets, Please Fill up following Data</h2>
                        </div><!--/page-heading-->    
                      </div>
                    </div>


                    <div class="form-wrapper" >
                        <div class="row mg-bottom-0">
                            <div class="loading-spiner-holder" data-loading ><div class="loading-spiner"><img src="<?php echo Request::root(); ?>/protected/public/images/Twirl.gif" /></div></div>
                           <form method="post"  role="form" action="<?php echo Request::root().'/advance-search-result'; ?>" class="col-sm-12 myform" ng-class="{'submitted': submitted}" name="requestForm" novalidate ng-submit="(submitted = true) && requestForm.$invalid && $event.preventDefault()" autocomplete="off">
                            <div class="row mg-btm">

                                 <div class="col-md-6">
                                     <div class="date-form">
                                         <div class="form-horizontal">
                                             <div class="control-group">
                                                 <label for="startdate" class="control-label">Select Request Id</label>
                                             <select class="form-control" select2=""  ng-model="search.r_id" name="r_id" id="r_id"   >
                                          <option  value=""></option>

                                          <option ng-repeat="r in getChangeRequest" value="<%r.r_id%>"><%r.request_id%></option>

                                      </select>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                                 </div>
                             <div class="row mg-btm">

                                 <div class="col-md-3">
                                     <div class="date-form">
                                         <div class="form-horizontal">
                                             <div class="control-group">
                                                 <label for="startdate" class="control-label">From Date</label>
                                                 <div class="controls">
                                                     <div class="input-group">
                                                         <input id="startdate" type="text" class="date-picker form-control" name="startdate"  ng-model="search.startdate"  ng-required='!search.r_id'  data-date-format="dd/mm/yyyy" />
                                                         <label for="startdate" class="input-group-addon btn"><span class="glyphicon glyphicon-calendar"></span></label>

                                                     </div>

                                                     <span ng-cloak="" class="error-msg " ng-show="(requestForm.startdate.$dirty || invalidSubmitAttempt) && requestForm.startdate.$error.required"> From Date is required.</span>
                                                     <span ng-cloak="" class="error-msg " ng-show="(requestForm.startdate.$dirty || invalidSubmitAttempt) && requestForm.startdate.$error.valid"> From Date Must Before End Date.</span>

                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>

                                 <div class="col-md-3">
                                     <div class="date-form">
                                         <div class="form-horizontal">
                                             <div class="control-group">
                                                 <label for="startdate" class="control-label">To Date</label>
                                                 <div class="controls">
                                                     <div class="input-group">
                                                         <input id="enddate" type="text" class="date-picker form-control" name="enddate"  ng-model="search.enddate" data-date-format="dd/mm/yyyy" required="true"  ng-required='!search.r_id' />
                                                         <label for="enddate" class="input-group-addon btn"><span class="glyphicon glyphicon-calendar"></span>
                                                         </label>

                                                     </div>
                                                     <span ng-cloak="" class="error-msg " ng-show="(requestForm.enddate.$dirty || invalidSubmitAttempt) && requestForm.enddate.$error.required"> To Date is required.</span>
                                                     <span ng-cloak="" class="error-msg " ng-show="(requestForm.enddate.$dirty || invalidSubmitAttempt) && requestForm.enddate.$error.valid"> End Date Must Greater Than End Date.</span>

                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>


                            </div>

                               <div class="row mg-btm">
                                   <div class="input-field col-sm-6 sel">


                                       <label>Select Change Stage</label>

                                       <select class="form-control" select2=""   ng-change="getProjectByStage(search.change_stage_id)" ng-model="search.change_stage_id" name="change_stage_id[]">
                                          <option  value=""></option>
                                           <option ng-repeat="data in changestage" value="<%data.change_stage_id%>"><% data.stage_name %></option>

                                       </select>


                                   </div>
                               </div>

                               <div class="row mg-btm">
                                   <div class="input-field col-sm-6 sel">


                                       <label>Select Change Type</label>

                                       <select class="form-control" select2="" multiple ng-model="search.changeType" name="changeType[]" >

                                           <option ng-repeat="data in changetype" value="<%data.change_type_id%>"><% data.change_type_name %></option>

                                       </select>


                                   </div>
                               </div>


                               <div class="row mg-btm">
                                   <div class="input-field col-sm-6 sel">


                                       <label>Customer Name</label>

                                       <select class="form-control" select2="" multiple ng-model="search.customer_id" name="customer_id[]"  >

                                           <option ng-repeat="customer in customers" value="<%customer.CustomerId%>"><% customer.FirstName %></option>

                                       </select>


                                   </div>
                               </div>

                               <div class="row mg-btm">
                                   <div class="input-field col-sm-6 sel">


                                       <label>Select Purpose of Change</label>

                                       <select class="form-control" select2="" multiple ng-model="search.changerequest_purpose" name="changerequest_purpose[]"  >

                                           <option ng-repeat="opt in purposechange" value="<%opt.id%>"><%opt.changerequest_purpose%></option>

                                       </select>


                                   </div>
                               </div>

                               <div class="row mg-btm">
                                   <div class="input-field col-sm-6 sel">


                                       <label>Select Plant Code</label>

                                       <select class="form-control" select2="" multiple ng-model="search.changerequest_plantcode" name="changerequest_plantcode[]"  >

                                           <option ng-repeat="d in plantcodes" value="<%d.plant_id%>"><%d.plant_code%></option>

                                       </select>


                                   </div>
                               </div>

                               <div class="row mg-btm">
                                   <div class="input-field col-sm-6 sel">


                                       <label>Select Project Code</label>

                                       <select class="form-control" select2="" multiple ng-model="search.changerequest_projectcode" name="changerequest_projectcode[]"  >

                                           <option ng-repeat="d in projectcodes" value="<%d.id%>"><%d.project_code%></option>

                                       </select>


                                   </div>
                               </div>


                               </div>
                            <div class="row">
                              <div class="col-sm-12 ">
                                <button class="btn btn-animate flat blue pd-btn " type="submit" name="action" ng-click="dosearch(requestForm,search)">Submit</button>
                                <!-- <button class="btn " type="reset">Clear</button>-->
                              </div>
                            </div>

                            

                          </form>
                        </div><!--/row-->
                    </div><!--/form-wrapper-->
                    

                    
                    
                  </div><!--/content-wrapper-->
                </div><!--/s10-->
              </div><!--/row-->
                <div id="summarysheet" ng-show="summery">
              <div class="col-sm-12" >

                    <div class="row">
                      <div class="col-sm-12">
                        <div class="page-heading ">
                            <h1>Summary Sheet <span ng-click="backToSearch();" class="btn btn-animate flat blue pd-btn pull-right">Back To Search</span></h1>
                        </div><!--/page-heading-->  
                         
                      </div>                        
                         
                      </div>
                    </div>

                  <div class="content-wrapper">

                    <div class="row mg-bottom-0">
                      <div class="col-sm-6">
                          <?php if($user_type==1){?>
                        <div class="action-group pd-top">
                         <button name="action" type="submit" class="btn ">Remove Selected</button>
                         <button name="action" type="submit" class="btn ">Remove All</button>
                         <button class="btn " type="submit" name="action">Export to Excel Sheet</button>
                         
                        
                        </div>
                          <?php } else {?>
                          <div class="action-group pd-top">
                              <form method="post" action="">
                              <button class="btn btn-animate flat blue pd-btn"  name="excel" type="submit">Export to Excel Sheets</button>
                              <button class="btn btn-animate flat blue pd-btn"  name="pdf" type="submit">Export to PDF</button>
                                  </form>
                          </div>
                          <?php } ?>
                          </div>
                      <div class="col-sm-6 pull-right">
                        <ul class="summary-status right-align mg-top-0">
                          <li>Activity Completed with required Approval & Verification <span>G</span></li>
                          <li>Within defined target date ( Work in Process )  <span>Y</span></li>
                          <li>Activity Over due <span>R</span></li>
                        </ul>
                      </div>
                    </div>
                    
                    <!-- summary Table start -->
                    <?php require app_path().'/views/advance-search/summery.php'; ?>
                    <!-- summary Table end -->

                  </div><!--/content-wrapper-->
                </div><!--/s10-->
 
              
                </div>
                
                </div><!--/row-->
            
      </div><!--/container-->
  </div><!--/main-wrapper-->

  
    <?php require app_path().'/views/footer.php'; ?>
    <script>

    $(document).ready(function(){

      // $('.date-picker').datepicker({
      //     dateFormat: 'dd-mm-yy'
      //  });
 });
 </script>