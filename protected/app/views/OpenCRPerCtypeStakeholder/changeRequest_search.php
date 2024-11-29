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
                          <h2>To View open change requests per stakeholder per change type, Please Fill up following Data</h2>
                        </div><!--/page-heading-->    
                      </div>
                    </div>


                    <div class="form-wrapper" >
                        <div class="row mg-bottom-0">
                            <div class="loading-spiner-holder" data-loading ><div class="loading-spiner"><img src="<?php echo Request::root(); ?>/protected/public/images/Twirl.gif" /></div></div>
                           <form method="post"  role="form" action="<?php echo Request::root().'/openCRPerCtypeStakeholder-search-result'; ?>" class="col-sm-12 myform" ng-class="{'submitted': submitted}" name="requestForm" novalidate ng-submit="(submitted = true) && requestForm.$invalid && $event.preventDefault()" autocomplete="off">
                  
                               <div class="row mg-btm">
                                   <div class="input-field col-sm-6">


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
                              
                            
                               </div>
                            <div class="row">
                              <div class="col-sm-12 ">
                                <button class="btn btn-animate flat blue pd-btn " type="submit" name="action">Submit</button>
                               
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
