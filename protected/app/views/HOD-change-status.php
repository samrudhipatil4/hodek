<?php require app_path().'/views/header.php'; ?>
  <div class="main-wrapper">
    <div class="container">

              <div class="row two-col-row mg-bottom-0">
                <div class="col s2">
                  <?php require app_path().'/views/sidebar.php'; ?>
                </div><!--/s2-->
                <div class="col s10">

                    <div class="row">
                      <div class="col s12">
                        <div class="page-heading">
                          <h1>Newly added "New Change request" by <strong>Initiator Name</strong></h1>
                        </div><!--/page-heading-->    
                      </div>
                    </div>

                  <div class="content-wrapper">
                    
                    <div class="status-bar">
                      <div class="row mg-bottom-0">                                          
                        <div class="col s6">
                          <ul>
                           <li> <strong>Task Record CM Number :</strong> DCM/2015/1</li>
                          </ul> 
                        </div>
                        <div class="col s6">
                          <ul class="right">
                           <li> <strong>Current State :</strong> Pending For Approval</li>
                          </ul> 
                        </div>
                      </div>                        
                    </div><!--/status-bar-->
                  
                    
                    <div class="form-wrapper" ng-controller="CtrlNewChangeRequest">
                        <div class="row mg-bottom-0">
                          <form class="col s12">

                            <div class="row">
                              <div class="col s12">
                                <p>Please Select an Operation and click on "OK" button.</p>
                              </div>
                            </div>
                            
                            <div class="row mg-bottom-0">
                                <div class="col s6">
                                    <p>
                                        <input class="with-gap"  type="radio" id="accept" name="radioStatus" ng-model="radioStatus" value="accept" checked />
                                        <label for="accept">Accept</label>  
                                    </p>
                                    <p class="size-12 color-grey mg-none">Submit to Initiator for status, Accept, Reject and To Administrator for Accepted</p>
                                </div>                             
                            </div>
                            
                            <div class="row">
                                <div class="col s6">
                                    <p>
                                        <input class="with-gap" type="radio" id="reject" name="radioStatus" ng-model="radioStatus" value="reject"/>
                                        <label for="reject">Reject</label>  
                                    </p>
                                    <p class="size-12 color-grey mg-none">Add information or make changes to your request</p>
                                </div>
                            </div>
                            
                            <div class="row" ng-if="radioStatus=='accept'">
                              <div class="input-field col s3 datepicker" ng-controller="datePicker">
                                <label for="inputCreated">Select Response Date</label>
                                <input input-date
                                    type="text"
                                    name="created"
                                    id="inputCreated"
                                    ng-model="currentTime"
                                    container="body"
                                    format="dd/mm/yyyy"
                                    months-full="{{ month }}"
                                    months-short="{{ monthShort }}"
                                    weekdays-full="{{ weekdaysFull }}"
                                    weekdays-short="{{ weekdaysShort }}"
                                    weekdays-letter="{{ weekdaysLetter }}"
                                    disable="disable"
                                    min="{{ minDate }}"
                                    max="{{ maxDate }}"
                                    today="today"
                                    clear="clear"
                                    close="close"
                                    select-years="15"
                                    on-start="onStart()"
                                    on-render="onRender()"
                                    on-open="onOpen()"
                                    on-close="onClose()"
                                    on-set="onSet()"
                                    on-stop="onStop()" />
                                    <span class="icon-calendar"><i class="fa fa-calendar"></i></span>
                              </div>                              
                            </div>  

                            <div class="row" ng-if="radioStatus=='reject'">
                              <div class="input-field col s5">
                                <textarea id="textarea" class="materialize-textarea"></textarea>
                                <label for="textarea">Write Comment for Rejection</label>
                              </div>
                            </div> 

                            <div class="row">
                              <div class="col s12 btn-group">                                
                                <a class="btn waves-effect waves-light" href="./HOD-dashboard.html" name="action">OK</a>  
                                <button class="btn waves-effect waves-light" type="button">Cancel</button>
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