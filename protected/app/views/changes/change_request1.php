<?php require app_path().'/views/header.php'; ?>

  <div class="main-wrapper">
    <div class="container">

              <div class="row two-col-row mg-bottom-0">
                <div class="col-sm-2">
					<!-- Sidebar Comes here! -->
					
					<?php require app_path().'/views/sidebar.php'; ?>
					
					<!-- sidebar ends here -->
					
                   </div><!--/s2-->
                <div class="col-sm-10">
                  <div class="content-wrapper">
                    
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="page-heading">
                          <h1>New Change Request Form</h1>
                        </div><!--/page-heading-->    
                      </div>
                    </div>
                    
                    <div class="form-wrapper" ng-controller="changereqCtrl">
                        <div class="row mg-bottom-0">
                          <form class="col-sm-12">
                            <div class="row">
                              <div class="input-field col-sm-6">
                                <input id="initiator_name" type="text" ng-model="request.initiator_name" name="initiator_name" class="validate">
                                <label for="initiator_name">Initiator Name</label>
                              </div>
                              <div class="input-field col-sm-6">
                                <input id="emp_id" type="text" ng-model="request.emp_id" name="emp_id" class="validate">
                                <label for="emp_id">Employee User ID (Unique)</label>
                              </div>
                            </div> 

                            <div class="row">
                              <div class="input-field col-sm-6 selectbox" >
                                  <select class="browser-default" ng-model="request.d_id" name="d_name" ng-change="fill_sub_department(request.d_id)">
                                    <option value="" disabled selected>Select Department</option>
                                    <option ng-repeat="department in departments" value="{{department.d_id}}">{{department.d_name}}</option>
                                   <!-- <option value="1">Option 1</option>
                                    <option value="2">Option 2</option>
                                    <option value="3">Option 3</option>-->
                                  </select>
                                  
                                  <span class="icon-arrow"><i class="fa fa-chevron-down"></i></span>
                                  <label for="dept">Select Department</label>
                              </div>
                              <div class="input-field col-sm-6 selectbox" ng-if="hideoption=='show'">
                                  <select class="browser-default" ng-model="request.sub_dep_id" name="sub_dep_name">
                                    <option value="" disabled selected>Select Sub Department</option>
                                     <option ng-repeat="d in sub_departments"value="{{d.sub_dep_id}}">{{d.sub_dep_name}}</option>
                                   <!-- <option value="1">Option 1</option>
                                    <option value="2">Option 2</option>
                                    <option value="3">Option 3</option>-->
                                  </select>
                                  <span class="icon-arrow"><i class="fa fa-chevron-down"></i></span>
                                  <label for="dept">Select Sub-Department</label>
                              </div>
                              
                            </div>

                             <div class="row">
                              <div class="input-field col-sm-6 datepicker" ng-controller="datePicker">
                                <label for="inputCreated">Change Request Initiation Date</label>
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
                              <!--<div class="col-sm-6">
                                <p class="radio-label">Change Stage</p>                               
                                <div class="row mg-none">
                                  <div class="col-sm-3 pd-none">
                                    <p>
                                        <input class="with-gap" name="group1" type="radio" id="radio-1" checked />
                                        <label for="radio-1">Series</label>  
                                    </p>
                                  </div>
                                  <div class="col-sm-3 pd-none">
                                    <p>
                                        <input class="with-gap" name="group1" type="radio" id="radio-2" />
                                        <label for="radio-2">Development</label>  
                                    </p>
                                  </div>                                    
                                </div>
                              </div> -->
                              <div class="input-field col-sm-6 selectbox">
                                  <select class="browser-default" id="Change-Stage" name="change_stage" ng-model="request.change_stage_id"> 
                                    <option value="" disabled selected>Select Change-Stage</option>                                   
                                    <option ng-repeat="data in changestage" value="{{data.change_stage_id}}">{{data.stage_name}}</option>
                                    <!--<option value="Series" selected>Series</option>
                                    <option value="Development">Development</option>-->
                                  </select>
                                  <span class="icon-arrow"><i class="fa fa-chevron-down"></i></span>
                                  <label for="Change-Stage">Change Stage</label> 
                              </div>

                            </div> 

                            <div class="row">
                              <div class="col-sm-6">
                                <p class="radio-label">Change Type</p>                               
                                <div class="row mg-none">
                                  <div class="col-sm-3 pd-none">
                                    <p>
                                        <input class="with-gap"  type="radio" id="radio-3" name="changeType" ng-model="changeType" value="design" checked />
                                        <label for="radio-3">Design</label>  
                                    </p>
                                  </div>
                                  <div class="col-sm-3 pd-none">
                                    <p>
                                        <input class="with-gap" type="radio" id="radio-4" name="changeType" ng-model="changeType" value="process"/>
                                        <label for="radio-4">Process</label>  
                                    </p>
                                  </div> 
                                  <div class="col-sm-3 pd-none">
                                    <p>
                                        <input class="with-gap" type="radio" id="radio-5" name="changeType" ng-model="changeType" value="supplier"/>
                                        <label for="radio-5">Supplier</label>  
                                    </p>
                                  </div>                                    
                                </div>
                              </div>
                              <div class="input-field col-sm-6 selectbox"  ng-show="changeType == 'design'">
                                  <select class="browser-default" id="design">
                                    <option value="" disabled selected>Customer Name</option>
                                    <option value="1">Option 1</option>
                                    <option value="2">Option 2</option>
                                    <option value="3">Option 3</option>
                                  </select>
                                  <span class="icon-arrow"><i class="fa fa-chevron-down"></i></span>
                                  <label for="design">Customer Name</label> 
                              </div>
                              <div class="col-sm-6"  ng-show="changeType == 'process'">
                                <!--<div class="multiselect-box">
                                  <div class="selected-label"><span>{{array}}</span></div>
                                  <ul>
                                    <li ng-repeat="item in list">
                                    <label><input type="checkbox" checkbox-group class="default" />{{item.value}}</label>
                                    </li>
                                  </ul>
                                </div>-->

                                <div class="multiselect-box">
                                  <div class="selected-label">                                 
                                    <div ng-repeat="name in selection" class="selected-item">
                                    {{name}}
                                    </div>
                                    <span class="icon-arrow"><i class="fa fa-chevron-down"></i></span>
                                  </div>
                                  <ul>
                                    <li ng-repeat="employee in employees">
                                      <div class="action-checkbox">
                                        <input id="{{employee.name}}" type="checkbox" value="{{employee.name}}" ng-checked="selection.indexOf(employee.name) > -1" ng-click="toggleSelection(employee.name)" />
                                        <label for="{{employee.name}}">{{employee.name}}</label>
                                      </div>
                                    </li>
                                  </ul>
                                  </div><!--/multiselect-box-->
                                </div>

                                <div class="col-sm-6"  ng-show="changeType == 'supplier'">
                                 <div class="multiselect-box">
                                  <div class="selected-label">                                 
                                    <div ng-repeat="name in selection" class="selected-item">
                                    {{name}}
                                    </div>
                                    <span class="icon-arrow"><i class="fa fa-chevron-down"></i></span>
                                  </div>
                                  <ul>
                                    <li ng-repeat="employee in employees">
                                      <div class="action-checkbox">
                                        <input id="{{employee.name}}" type="checkbox" value="{{employee.name}}" ng-checked="selection.indexOf(employee.name) > -1" ng-click="toggleSelection(employee.name)" />
                                        <label for="{{employee.name}}">{{employee.name}}</label>
                                      </div>
                                    </li>
                                  </ul>
                                  </div><!--/multiselect-box-->
                                </div>
                            </div>
                           
                            <div class="row mg-bottom-0">
                              <div class="input-field col-sm-6">
                                <input id="ext-number" type="text" class="validate" ng-model="field.extNumber">
                                <label for="ext-number">Existing Part Number</label>
                              </div>
                              <div class="input-field col-sm-6">
                                <input id="ext-name" type="text" class="validate" ng-model="field.extName">
                                <label for="ext-name">Existing Part Name</label>
                              </div>                              
                            </div>

                            <div class="row mg-bottom-0" ng-repeat="field in fields">
                              <div class="input-field col-sm-6">
                                <input id="ext-number" type="text" class="validate" ng-model="field.extNumber">
                                <label for="ext-number">Existing Part Number</label>
                              </div>
                              <div class="input-field col-sm-6">
                                <input id="ext-name" type="text" class="validate" ng-model="field.extName">
                                <label for="ext-name">Existing Part Name</label>
                              </div>                              
                            </div>

                            <div class="row">
                              <div class="input-field col-sm-12">
                                <button class="btn waves-effect waves-light right" type="button" ng-click="add()">Add More</button>
                              </div>
                            </div>
                        
                             <div class="row">
                              <div class="input-field col-sm-6 selectbox">
                                  <select class="browser-default" id="change">
                                    <option value="" disabled selected>Purpose of Change</option>
                                    <option value="1">Option 1</option>
                                    <option value="2">Option 2</option>
                                    <option value="3">Option 3</option>
                                  </select>
                                  <span class="icon-arrow"><i class="fa fa-chevron-down"></i></span>
                                  <label for="change">Purpose of Change</label>
                              </div>
                              <div class="input-field col-sm-6 selectbox">
                                  <select class="browser-default" id="approval">
                                    <option value="" disabled selected>Approval Authority from Department HOD</option>
                                    <option value="1">Option 1</option>
                                    <option value="2">Option 2</option>
                                    <option value="3">Option 3</option>
                                  </select>
                                  <span class="icon-arrow"><i class="fa fa-chevron-down"></i></span>
                                  <label for="approval">Approval Authority from Department HOD</label>
                              </div>
                            </div>

                           <!-- <div class="row">
                              <div class="col-sm-6">

                                <div class="multiselect-box">
                                  <div class="selected-label"><span>{{array}}</span></div>
                                  <ul>
                                    <li ng-repeat="item in list">
                                    <label><input type="checkbox" checkbox-group class="default" />{{item.value}}</label>
                                    </li>
                                  </ul>
                                </div>

                              </div>
                            </div>-->

                            <div class="row">
                              <div class="input-field col-sm-6">
                                <input id="plant_code" type="text" class="validate">
                                <label for="plant_code">Plant Code</label>
                              </div>                              
                            </div>
                            
                            <div class="row">
                              <div class="input-field col-sm-12">
                                <textarea id="textarea1" class="materialize-textarea"></textarea>
                                <label for="textarea1">Purpose Modification Details</label>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-sm-12 btn-group">
                                <button class="btn waves-effect waves-light" type="submit" name="action">Submit</button>   
                                <button class="btn waves-effect waves-light" type="button">Save as Draft</button>   
                                <button class="btn waves-effect waves-light " type="reset">Clear</button>        
                              </div>
                            </div>

                           <!-- <div class="row">
                              <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Month</label>
                                    <select id="ms" multiple="multiple">
                                        <option value="1">January</option>
                                        <option value="2">February</option>
                                        <option value="3">March</option>
                                        <option value="4">April</option>
                                        <option value="5">May</option>
                                        <option value="6">June</option>
                                        <option value="7">July</option>
                                        <option value="8">August</option>
                                        <option value="9">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select>
                                </div>
                              </div>
                            </div>-->
                              
                          </form>
                        </div><!--/row-->
                    </div><!--/form-wrapper-->

                    

                  </div><!--/content-wrapper-->
                </div><!--/s10-->
              </div><!--/row-->
            
      </div><!--/container-->
  </div><!--/main-wrapper-->

  <?php require app_path().'/views/footer.php'; ?>
  </body>
</html>
