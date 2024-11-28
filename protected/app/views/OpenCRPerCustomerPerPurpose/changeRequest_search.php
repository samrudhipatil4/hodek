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
    <div class="container" ng-controller="totalNoOfCRPerCustPerPurposeCtrl">

              <div class="row two-col-row mg-bottom-0" >
                  
                  <div ng-show="search_summery">
         <div class="col-sm-2">
              
                     <!-- Sidebar Comes here! -->
          
          <?php require app_path().'/views/sidebar.php'; ?>
          
          <!-- sidebar ends here -->
                </div><!--/s2-->
                <div class="col-sm-10">

                   <!--  <div class="row">
                      <div class="col-sm-12">
                        <div class="page-heading">
                          <h1>Advanced Search Option</h1>
                        </div>   
                      </div>
                    </div> -->

                  <div class="content-wrapper">
                    
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="page-heading mg-btm">
                          <h2>To View No. of change requests raised per purpose per customer, Please Fill up following Data</h2>
                        </div><!--/page-heading-->    
                      </div>
                    </div>


                    <div class="form-wrapper" >
                        <div class="row mg-bottom-0">
                            <div class="loading-spiner-holder" data-loading ><div class="loading-spiner"><img src="<?php echo Request::root(); ?>/protected/public/images/Twirl.gif" /></div></div>
                           <form method="post" role="form" action="<?php echo Request::root().'/totalNoOfCRPerCustPerPurpose-search-result'; ?>" class="col-sm-12 myform" ng-class="{'submitted': submitted}" name="requestForm" novalidate ng-submit="(submitted = true) && requestForm.$invalid && $event.preventDefault()" autocomplete="off">
                               <div class="row mg-btm">

                                 <div class="col-md-3">
                                     <div class="date-form">
                                         <div class="form-horizontal">
                                             <div class="control-group">
                                                 <label for="startdate" class="control-label">From Date</label>
                                                 <div class="controls">
                                                     <div class="input-group">
                                                         <input id="startdate" type="text" class="date-picker form-control" name="startdate"  data-date-format="dd/mm/yyyy" ng-model="search.startdate"/>
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
                                                         <input id="enddate" type="text" class="date-picker form-control" name="enddate"  data-date-format="dd/mm/yyyy" ng-model="search.enddate"/>
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


                                       <label>Select Stage</label>

                                       <select class="form-control" select2="" ng-model="search.stage" name="stage">
                                         <option  value="? undefined:undefined ?"></option>
                                           <option ng-repeat="data in changestage" value="<%data.change_stage_id%>"><%data.stage_name%></option>

                                       </select>


                                   </div>
                               </div>
                               <div class="row mg-btm">
                                   <div class="input-field col-sm-6 sel">


                                       <label>Select change Type</label>

                                      <select class="form-control" select2=""  ng-model="search.changeType" name="changeType" >

                                           <option ng-repeat="data in changetype" value="<%data.change_type_id%>"><% data.change_type_name %></option>

                                       </select>

                                   </div>
                               </div>
                            <div class="row mg-btm">
                                   <div class="input-field col-sm-6">


                                       <label>Select Plant</label>

                                       <select class="form-control" select2="" ng-model="search.plant" name="plant">
                                        <option  value="? undefined:undefined ?"></option>

                                           <option ng-repeat="data in plantcodes" value="<%data.plant_id%>"><% data.plant_code %></option>

                                       </select>


                                   </div>
                               </div>
                              
                            <div class="row">
                              <div class="col-sm-12 ">
                                <button type="submit" id="btnSubmit" class="btn btn-animate flat blue pd-btn" onclick=''  name="action">Submit</button>
                               
                              </div>
                            </div>
                          </form>
                        </div><!--/row-->
                    </div><!--/form-wrapper-->
                  </div><!--/content-wrapper-->
                </div><!--/s10-->
              </div><!--/row--> 
              
                </div>
                
                </div><!--/row-->
            
      </div><!--/container-->
  </div><!--/main-wrapper-->

  
    <?php require app_path().'/views/footer.php'; ?>
<script type="text/javascript">
  
   $(document).ready(function(){
       
       $("#btnSubmit").click(function(evt){
        
           $start=$('#startdate').val();
          $end=$('#enddate').val();
          if(($start!='') && ($end==undefined)){
            alert("Select To Date");
            evt.preventDefault();
          }
        
       });
   });

</script>