<?php require app_path().'/views/header.php'; ?>

   <?php if(Session::has('message')){

                        echo Session::get('message');

                    }?>
                    <ul class="parsley-error-list">
                        <?php
                        foreach($errors->all() as $error){  ?>
                        <li>echo  $error</li>
                        <?php }?>
                    </ul>
   <div class="main-wrapper">
    <div class="container" >
         
              <div class="row">
                <div class="col-sm-12">
                  <div class="page-heading mg-btm" ng-controller="memberfindCtrl" ng-init="member_dep(<?php echo Session::get('uid')?>)">
                    <h1 ng-cloak>Welcome  <%member.first_name%> <%member.last_name%> </h1>
                  </div><!--/page-heading-->    
                </div>
              </div>

              <!-- Notification counter -->


        <div class="row" ng-controller="DashboardCounterCtrl" ng-cloak >
            <div class="col-sm-3" ng-cloak>
                <div class="card-panel shadow-none counter">
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="circle-icon">
                                <i class="fa fa-retweet"></i>
                            </div>
                        </div>
                        <div class="col-sm-7 pd-none">
                            <hgroup>
                                <h5>Change Management</h5>
                                <h2><span ng-bind="counter.initiated"></span></h2>
                            </hgroup>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3" ng-cloak>
                <div class="card-panel shadow-none counter">
                    <div class="row ">
                        <div class="col-sm-5">
                            <div class="circle-icon">
                                <i class="fa fa-pencil"></i>
                            </div>
                        </div>
                        <div class="col-sm-7 pd-none">
                            <hgroup>
                                <h5>Drafted</h5>
                                <h2><span ng-bind="counter.drafted"></span></h2>
                            </hgroup>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3" ng-cloak>
                <div class="card-panel shadow-none counter mg-bottom-0">
                    <div class="row ">
                        <div class="col-sm-5">
                            <div class="circle-icon">
                                <i class="fa fa-check"></i>
                            </div>
                        </div>
                        <div class="col-sm-7 pd-none">
                            <hgroup>
                                <h5>Accepted</h5>
                                <h2><span ng-bind="counter.accepted"></span></h2>
                            </hgroup>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3" ng-cloak>
                <div class="card-panel shadow-none counter mg-bottom-0">
                    <div class="row ">
                        <div class="col-sm-5">
                            <div class="circle-icon">
                                <i class="fa fa-times"></i>
                            </div>
                        </div>
                        <div class="col-sm-7 pd-none">
                            <hgroup>
                                <h5>Rejected</h5>
                                <h2><span ng-bind="counter.rejected"></span></h2>
                            </hgroup>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--/row-->




        <!-- pie/donut charts -->
        <div class="row">
           <div class="col-sm-3" ng-controller="PieCtrl1">
                <div class="flip" ng-cloak>
                    <div class="card shadow-none wrapper">
                        <div class="loading-spiner-holder" data-loading >
                            <div class="loading-spiner">
                                <img src="<?php echo Request::root(); ?>/protected/public/images/Twirl.gif" />
                            </div>
                        </div>

                        <div class="card-image face front anim">
                            <div  class="pie-wrapper">
                                <canvas id="pie" class="chart chart-pie" chart-data="values" chart-labels="labels"></canvas>
                            </div><!--/chart-ctrl-->
                            <div class="flip_bckgd">
                                <a href="#" class="flip_btn">Change Type <i class="fa fa-ellipsis-v pull-right"></i></a>
                            </div>
                        </div>
                        <div class="face back anim">
                            <div class="mg-top" id="card-reveal1">
                                <span class="card-title ">Change Type</span>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true"></span>
                                </button>
                                <p class="mg-top-20"><!--enter your test here--></p><br>
                                <div class="row mg-btm-10">
                                    <div class="col-sm-6">
                                        <ul class="legend pd-left-0">
                                            <li ng-repeat="label in labels track by $index">
                                                <%label %>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-sm-6 pd-left-0">
                                        <ul class="legend pd-left-0">
                                            <li ng-repeat="val1 in values track by $index">
                                                <% val1 %>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <div class="col-sm-3" ng-controller="PieCtrl2">
                <div class="flip" ng-cloak>
                    <div class="card shadow-none wrapper">
                        <div class="loading-spiner-holder" data-loading >
                            <div class="loading-spiner">
                                <img src="<?php echo Request::root(); ?>/protected/public/images/Twirl.gif" />
                            </div>
                        </div>

                        <div class="card-image face front anim">
                            <div  class="pie-wrapper">
                                <canvas id="pie" class="chart chart-pie" chart-data="values" chart-labels="labels" ></canvas>
                            </div><!--/chart-ctrl-->
                            <div class="flip_bckgd">
                                <a href="#" class="flip_btn">Change Stage <i class="fa fa-ellipsis-v pull-right"></i></a>
                            </div>
                        </div>
                        <div class="face back anim">
                            <div class="mg-top" id="card-reveal1">
                                <span class="card-title">Change Stage</span>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true"></span>
                                </button>
                                <p class="mg-top-20"><!--enter your test here--></p><br>
                                <div class="row mg-btm-10">
                                    <div class="col-sm-6">
                                        <ul class="legend pd-left-0">
                                            <li ng-repeat="label in labels track by $index">
                                                <%label %></li>
                                        </ul>
                                    </div>
                                    <div class="col-sm-6 pd-left-0">
                                        <ul class="legend">
                                            <li ng-repeat="val1 in values track by $index">
                                                <% val1 %></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6" ng-controller="BarCtrl">
                <div class="flip" ng-cloak>
                    <div class="card shadow-none wrapper">
                        <div class="loading-spiner-holder" data-loading >
                            <div class="loading-spiner">
                                <img src="<?php echo Request::root(); ?>/protected/public/images/Twirl.gif" />
                            </div>
                        </div>

                        <div class="card-image face front purpose">
                            <div  class="bar-wrapper">
                                <canvas id="bar" class="chart chart-bar"  chart-data="data" chart-labels="labels"></canvas>
                            </div><!--/chart-ctrl-->
                            <div class="flip_bckgd">
                                <a href="#" class="flip_btn">Change Purpose <i class="fa fa-ellipsis-v pull-right"></i></a>
                            </div>
                        </div>
                        <div class="face back purpose">
                            <div class="mg-top" id="card-reveal1">
                                <span class="card-title">Change Purpose</span>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true"></span>
                                </button>
                                <p class="mg-top-20"><!--enter your test here--></p><br>
                                <div class="row mg-btm-10">
                                    <div class="col-sm-6">
                                        <ul class="legend pd-left-0">
                                            <li ng-repeat="label in labels track by $index">
                                                <%label %></li>
                                        </ul>
                                    </div>
                                    <div class="col-sm-6">
                                        <ul class="legend">
                                            <li ng-repeat="val1 in values track by $index" >
                                                <% val1 %></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>






        </div><!--/row-->



        <!--// Assigned Task to Me-->
        <div class="row" ng-cloak="">
            <div class="col-sm-12">
                <div ng-controller="AssignedTaskToMeCtrl" class="">

                    <uib-accordion close-others="oneAtATime" ng-cloak>

                        <uib-accordion-group ng-init="status.open=true" is-open="status.open">
                            <uib-accordion-heading>
                                Assigned Task To Me  <span class="records pull-right"><span ng-bind="assignedtaskstome.length"> </span> Records <i class="pull-right glyphicon" ng-class="{'glyphicon-triangle-top': status.open, 'glyphicon-triangle-bottom': !status.open}"></i></span>
                            </uib-accordion-heading>
                            <div class="collapsible-body">
                                <div class="toolbar">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="pagination-wrapper">
                                                <ul class="no-lft">
                                                    <li>Page
                                                        <ul class="pagination">
                                                            <li class=""><a href="javascript:void(0)" ng-click="prevPage()"><i class="fa fa-angle-left"></i></a></li>
                                                            <li class="active">
                                                                <div class="select-box">
                                                                    <select class="form-control" ng-model='currentPage' ng-change="setPage(currentPage)">
                                                                        <option ng-repeat="n in range(1,pageCount())" value="<%n%>" ng-selected="n === currentPage"><%n%></option>
                                                                    </select>
                                                                </div>
                                                            </li>
                                                            <li class=""><a href="javascript:void(0)" ng-click="nextPage()"><i class="fa fa-angle-right"></i></a></li>
                                                        </ul>
                                                    </li>
                                                    <li>

                                                        <ul>
                                                            <li> View </li>
                                                            <li>
                                                                <div class="select-box">



                                                                    <select ng-model="entryLimit" class="form-control">

                                                                        <option>5</option>
                                                                        <option>10</option>
                                                                        <option>20</option>
                                                                        <option>50</option>
                                                                        <option>100</option>
                                                                    </select>

                                                                </div>
                                                            </li>
                                                            <li>per page</li>
                                                        </ul>
                                                    </li>
                                                    <li>
                                                        Total <span ng-bind="filtered.length"> </span> records found
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <form>
                                                <div class="search-form">
                                                    <input type="text" class="input-search" Placeholder="Refine your results" ng-model="search">

                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-wrapper">
                                <table class="striped">
                                    <thead>
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th><a href="javascript:void(0)" ng-click="sortType = 'change_type_name'; sortReverse = !sortReverse" class="datasort">CM No. <i class="fa fa-arrows-v"></i></a></th>
                                        <th><a href="javascript:void(0)" ng-click="sortType = 'created_date'; sortReverse = !sortReverse" class="datasort">CR Initiation Date <i class="fa fa-arrows-v"></i></a></th>
                                        <th><a href="javascript:void(0)" ng-click="sortType = 'FirstName'; sortReverse = !sortReverse" class="datasort">Customer Name <i class="fa fa-arrows-v"></i></a></th>
                                        <th><a href="javascript:void(0)" ng-click="sortType = 'initiator_name'; sortReverse = !sortReverse" class="datasort">Initiator Name <i class="fa fa-arrows-v"></i></a></th>
                                        <th><a href="javascript:void(0)" ng-click="sortType = 'stage_name'; sortReverse = !sortReverse" class="datasort">Change Stage <i class="fa fa-arrows-v"></i></a></th>
                                        <th><a href="javascript:void(0)" ng-click="sortType = 'change_type_name'; sortReverse = !sortReverse" class="datasort">Change Type<i class="fa fa-arrows-v"></i></a></th>
                                        <th><a href="javascript:void(0)" ng-click="sortType = 'changerequest_purpose'; sortReverse = !sortReverse" class="datasort">Purpose_Modification_Details <i class="fa fa-arrows-v"></i></a></th>
                                        <th><a href="javascript:void(0)" ng-click="sortType = 'rb'; sortReverse = !sortReverse" class="datasort">Assigned By<i class="fa fa-arrows-v"></i></a></th>
                                        <th><a href="javascript:void(0)" ng-click="sortType = 'imd'; sortReverse = !sortReverse" class="datasort">Implementation Date <i class="fa fa-arrows-v"></i></a> </th>
                                        <th><a href="javascript:void(0)" ng-click="sortType = 'status'; sortReverse = !sortReverse" class="datasort">Status <i class="fa fa-arrows-v"></i></a></th>
                                        <th><a href="javascript:void(0)" ng-click="sortType = 'comment'; sortReverse = !sortReverse" class="datasort">Comment <i class="fa fa-arrows-v"></i></a></th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <tr ng-repeat="assignedTask in filtered = (assignedtaskstome| filter:search | orderBy : sortType:sortReverse) | startFrom:(currentPage - 1) * entryLimit | limitTo:entryLimit">
                                        <!--<tr ng-repeat="assignedTask in filtered = (assignedtaskstome| filter:search | orderBy : sortType:sortReverse) | startFrom:(currentPage - 1) * entryLimit | limitTo:entryLimit">-->
                                        <td><span ng-bind="$index+1"></span>.</td>

                                        <td>

                                            <span  ng-bind="assignedTask.cmNo"></span>

                                        </td>
                                        <td><span ng-bind="assignedTask.created_date"></span></td>
                                        <td>
                                            <ul>
                                                <li ng-repeat="customer in assignedTask.customers"><% customer.customer_name %></li>

                                            </ul>

                                        </td>
                                        <td><span ng-bind="assignedTask.initiator_name"></span></td>
                                        <td><span ng-bind="assignedTask.stage_name"></span></td>
                                        <td><span ng-bind="assignedTask.change_type_name"></span></td>
                                        <td><span ng-bind="assignedTask.Purpose_Modification_Details"></span></td>
                                       <!--  <td>
                                            <ul>
                                                <li ng-repeat="purpose in assignedTask.change_purpose"><% purpose.purpose_name %></li>

                                            </ul>

                                        </td> -->
                                        <td><a href="" ng-click="open('lg',assignedTask.user_info)" class="color-darkgrey"><span ng-bind="assignedTask.user_info.name"></span></a></td>
                                      <!--  <td><my-date year="assignedTask.impdate"></my-date></td>-->
                                        <td><span ng-bind="assignedTask.impdate"></span></td>
                                        <td><!--<span my-task="" rate="assignedTask.status"></span>--><span ng-bind="assignedTask.status"></span></td>
                                        <td><!--<span my-task="" rate="assignedTask.status"></span>--><span ng-bind="assignedTask.comment"></span></td>
                                        <td>
                                            <table class="actions" >

                                                <tr>
                                                    <td >

                                                        <a  href="<?php echo Request::root().'/views?searchid=<%assignedTask.cmNoSearch%>&link=user' ?>" class="" data-position="bottom" data-delay="50" data-tooltip="View Record"><i class="fa fa-eye"></i></a>

                                                       </td>
                                                    <td>
                                                        <a href="<?php echo Request::root().'/<%assignedTask.next_url%>' ?><%assignedTask.request_id%>/<%assignedTask.close_id%>" class="" data-position="bottom" data-delay="50" data-tooltip="Request Action"><i class="fa fa-check"></i></a>

                                                    </td>

                                                </tr>

                                            </table>
                                        </td>
                                    </tr>

                                </table>

                            </div><!--/table-wrapper-->

                        </uib-accordion-group>
                    </uib-accordion>
                </div>
            </div>
        </div>

        <!--// Assigned Task to Me-->
        <div class="row" ng-cloak="">
            <div class="col-sm-12">
                <div ng-controller="SavedCrByMeCtrl">
                    <uib-accordion close-others="oneAtATime" ng-cloak>

                        <uib-accordion-group ng-init="status.open=true" is-open="status.open">
                            <uib-accordion-heading>
                               Saved CR By Me  <span class="records pull-right"><span ng-bind="assignedtaskstome.length"> </span> Records <i class="pull-right glyphicon" ng-class="{'glyphicon-triangle-top': status.open, 'glyphicon-triangle-bottom': !status.open}"></i></span>
                            </uib-accordion-heading>
                            <div class="collapsible-body">
                                <div class="toolbar">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="pagination-wrapper">
                                                <ul class="no-lft">
                                                    <li>Page
                                                        <ul class="pagination">
                                                            <li class=""><a href="javascript:void(0)" ng-click="prevPage()"><i class="fa fa-angle-left"></i></a></li>
                                                            <li class="active">
                                                                <div class="select-box">
                                                                    <select class="form-control" ng-model='currentPage' ng-change="setPage(currentPage)">
                                                                        <option ng-repeat="n in range(1,pageCount())" value="<%n%>" ng-selected="n === currentPage"><%n%></option>
                                                                    </select>
                                                                </div>
                                                            </li>
                                                            <li class=""><a href="javascript:void(0)" ng-click="nextPage()"><i class="fa fa-angle-right"></i></a></li>
                                                        </ul>
                                                    </li>
                                                    <li>

                                                        <ul>
                                                            <li> View </li>
                                                            <li>
                                                                <div class="select-box">

                                                                    <select class="form-control" ng-model="entryLimit">
                                                                        <option value="5">5</option>
                                                                        <option value="10">10</option>
                                                                        <option value="20">20</option>
                                                                        <option value="50">50</option>
                                                                        <option value="100">100</option>
                                                                    </select>

                                                                </div>
                                                            </li>
                                                            <li>per page</li>
                                                        </ul>
                                                    </li>
                                                    <li>
                                                      Total <span ng-bind="filtered.length"> </span> records found
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <form>
                                                <div class="search-form">
                                                    <input type="text" class="input-search" Placeholder="Refine your results" ng-model="search">

                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-wrapper">
                                <table class="striped">
                                    <thead>
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th><a href="javascript:void(0)" ng-click="sortType = 'change_type_name'; sortReverse = !sortReverse" class="datasort">CM No. <i class="fa fa-arrows-v"></i></a></th>
                                        <th><a href="javascript:void(0)" ng-click="sortType = 'created_date'; sortReverse = !sortReverse" class="datasort">CR Initiation Date <i class="fa fa-arrows-v"></i></a></th>
                                        <th><a href="javascript:void(0)" ng-click="sortType = 'FirstName'; sortReverse = !sortReverse" class="datasort">Customer Name <i class="fa fa-arrows-v"></i></a></th>
                                        <th><a href="javascript:void(0)" ng-click="sortType = 'initiator_name'; sortReverse = !sortReverse" class="datasort">Initiator Name <i class="fa fa-arrows-v"></i></a></th>
                                        <th><a href="javascript:void(0)" ng-click="sortType = 'stage_name'; sortReverse = !sortReverse" class="datasort">Change Stage <i class="fa fa-arrows-v"></i></a></th>
                                        <th><a href="javascript:void(0)" ng-click="sortType = 'change_type_name'; sortReverse = !sortReverse" class="datasort">Change Type<i class="fa fa-arrows-v"></i></a></th>
                                        <th><a href="javascript:void(0)" ng-click="sortType = 'changerequest_purpose'; sortReverse = !sortReverse" class="datasort">Purpose_Modification_Details <i class="fa fa-arrows-v"></i></a></th>
                                        <th><a href="javascript:void(0)" ng-click="sortType = 'rb'; sortReverse = !sortReverse" class="datasort">Assigned To<i class="fa fa-arrows-v"></i></a></th>
                                        <th><a href="javascript:void(0)" ng-click="sortType = 'imd'; sortReverse = !sortReverse" class="datasort">Implementation Date <i class="fa fa-arrows-v"></i></a> </th>
                                        <th><a href="javascript:void(0)" ng-click="sortType = 'status'; sortReverse = !sortReverse" class="datasort">Status <i class="fa fa-arrows-v"></i></a></th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <tr ng-repeat="assignedTask in filtered = (assignedtaskstome| filter:search | orderBy : sortType:sortReverse) | startFrom:(currentPage - 1) * entryLimit | limitTo:entryLimit">
                                        <!--<tr ng-repeat="assignedTask in filtered = (assignedtaskstome| filter:search | orderBy : sortType:sortReverse) | startFrom:(currentPage - 1) * entryLimit | limitTo:entryLimit">-->
                                        <td><span ng-bind="$index+1"></span>.</td>

                                        <td>

                                            <span  ng-bind="assignedTask.cmNo"></span>
                                        </td>
                                        <td><span ng-bind="assignedTask.created_date"></span></td>
                                        <td>
                                            <ul>
                                                <li ng-repeat="customer in assignedTask.customers"><% customer.customer_name %></li>

                                            </ul>

                                        </td>
                                        <td><span ng-bind="assignedTask.initiator_name"></span></td>
                                        <td><span ng-bind="assignedTask.stage_name"></span></td>
                                        <td><span ng-bind="assignedTask.change_type_name"></span></td>
                                         <td><span ng-bind="assignedTask.Purpose_Modification_Details"></span></td>
                                        <!-- <td>
                                            <ul>
                                                <li ng-repeat="purpose in assignedTask.change_purpose"><% purpose.purpose_name %></li>

                                            </ul>

                                        </td> -->
                                        <td><span ng-bind="assignedTask.user_info.name"></span></td>
                                        <td><span ng-bind="assignedTask.imd"></span></td>
                                        <td><span my-task="" rate="assignedTask.status"></span></td>
                                        <td>

                                            <table class="actions">

                                                    <tr>
                                                        <td>
                                                            <a href="<?php echo Request::root().'/views?searchid=<%assignedTask.cmNoSearch%>' ?>" class="" data-position="bottom" data-delay="50" data-tooltip="View Record"><i class="fa fa-eye"></i></a>
                                                        </td>
                                                        <td>
                                                            <a href="<?php echo Request::root().'/changes/edit_change_request/' ?><%assignedTask.request_id%>" class="" data-position="bottom" data-delay="50" data-tooltip="Request Action"><i class="fa fa-pencil"></i></a>

                                                        </td>

                                                    </tr>


                                            </table>
                                        </td>
                                    </tr>

                                </table>

                            </div><!--/table-wrapper-->

                        </uib-accordion-group>
                    </uib-accordion>
                </div>
            </div>
        </div>
        <!--// Assigned Task to Me-->
        <div class="row" ng-cloak="">
            <div class="col-sm-12">
                <div ng-controller="AssignedTaskByMeCtrl" >
                    <uib-accordion close-others="oneAtATime">

                        <uib-accordion-group ng-init="status.open=true" is-open="status.open" ng-cloak>
                            <uib-accordion-heading>
                                Assigned Task By Me  <span class="records pull-right"><span ng-bind="assignedtaskstome.length"> </span> Records <i class="pull-right glyphicon" ng-class="{'glyphicon-triangle-top': status.open, 'glyphicon-triangle-bottom': !status.open}"></i></span>
                            </uib-accordion-heading>
                            <div class="collapsible-body">
                                <div class="toolbar">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="pagination-wrapper">
                                                <ul class="no-lft">
                                                    <li>Page
                                                        <ul class="pagination">
                                                            <li class=""><a href="javascript:void(0)" ng-click="prevPage()"><i class="fa fa-angle-left"></i></a></li>
                                                            <li class="active">
                                                                <div class="select-box">
                                                                    <select class="form-control" ng-model='currentPage' ng-change="setPage(currentPage)">
                                                                        <option ng-repeat="n in range(1,pageCount())" value="<%n%>" ng-selected="n === currentPage"><%n%></option>
                                                                    </select>
                                                                </div>
                                                            </li>
                                                            <li class=""><a href="javascript:void(0)" ng-click="nextPage()"><i class="fa fa-angle-right"></i></a></li>
                                                        </ul>
                                                    </li>
                                                    <li>

                                                        <ul>
                                                            <li> View </li>
                                                            <li>
                                                                 <div class="select-box">

                                                                    <select class="form-control" ng-model="entryLimit">
                                                                        <option>5</option>
                                                                        <option >10</option>
                                                                        <option >20</option>
                                                                        <option >50</option>
                                                                        <option >100</option>

                                                                    </select>

                                                                </div>
                                                            </li>
                                                            <li>per page</li>
                                                        </ul>
                                                    </li>
                                                    <li>
                                                        Total <span ng-bind="filtered.length"> </span> records found
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <form>
                                                <div class="search-form">
                                                    <input type="text" class="input-search" Placeholder="Refine your results" ng-model="search">

                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-wrapper">
                                <table class="striped">
                                    <thead>
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th><a href="javascript:void(0)" ng-click="sortType = 'change_type_name'; sortReverse = !sortReverse" class="datasort">CM No. <i class="fa fa-arrows-v"></i></a></th>
                                        <th><a href="javascript:void(0)" ng-click="sortType = 'created_date'; sortReverse = !sortReverse" class="datasort">CR Initiation Date <i class="fa fa-arrows-v"></i></a></th>
                                        <th><a href="javascript:void(0)" ng-click="sortType = 'FirstName'; sortReverse = !sortReverse" class="datasort">Customer Name <i class="fa fa-arrows-v"></i></a></th>
                                        <th><a href="javascript:void(0)" ng-click="sortType = 'initiator_name'; sortReverse = !sortReverse" class="datasort">Initiator Name <i class="fa fa-arrows-v"></i></a></th>
                                        <th><a href="javascript:void(0)" ng-click="sortType = 'stage_name'; sortReverse = !sortReverse" class="datasort">Change Stage <i class="fa fa-arrows-v"></i></a></th>
                                        <th><a href="javascript:void(0)" ng-click="sortType = 'change_type_name'; sortReverse = !sortReverse" class="datasort">Change Type<i class="fa fa-arrows-v"></i></a></th>
                                        <th><a href="javascript:void(0)" ng-click="sortType = 'changerequest_purpose'; sortReverse = !sortReverse" class="datasort">Purpose_Modification_Details <i class="fa fa-arrows-v"></i></a></th>
                                        <th><a href="javascript:void(0)" ng-click="sortType = 'rb'; sortReverse = !sortReverse" class="datasort">Assigned To<i class="fa fa-arrows-v"></i></a></th>
                                        <th><a href="javascript:void(0)" ng-click="sortType = 'imd'; sortReverse = !sortReverse" class="datasort">Implementation Date <i class="fa fa-arrows-v"></i></a> </th>
                                        <th><a href="javascript:void(0)" ng-click="sortType = 'status'; sortReverse = !sortReverse" class="datasort">Status <i class="fa fa-arrows-v"></i></a></th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <tr ng-repeat="assignedTask in filtered = (assignedtaskstome| filter:search | orderBy : sortType:sortReverse) | startFrom:(currentPage - 1) * entryLimit | limitTo:entryLimit">
                                        <!--<tr ng-repeat="assignedTask in filtered = (assignedtaskstome| filter:search | orderBy : sortType:sortReverse) | startFrom:(currentPage - 1) * entryLimit | limitTo:entryLimit">-->
                                        <td><span ng-bind="$index+1"></span>.</td>

                                        <td>
                                            <span  ng-bind="assignedTask.cmNo"></span>
                                        </td>
                                        <td><span ng-bind="assignedTask.created_date"></span></td>
                                        <td>
                                            <ul>
                                                <li ng-repeat="customer in assignedTask.customers"><% customer.customer_name %></li>

                                            </ul>

                                        </td>
                                        <td><span ng-bind="assignedTask.initiator_name"></span></td>
                                        <td><span ng-bind="assignedTask.stage_name"></span></td>
                                        <td><span ng-bind="assignedTask.change_type_name"></span></td>
                                        <td><span ng-bind="assignedTask.Purpose_Modification_Details"></span></td>
                                       <!--  <td>
                                            <ul>
                                                <li ng-repeat="purpose in assignedTask.Purpose_Modification_Details"><% purpose.purpose_name %></li>

                                            </ul>

                                        </td> -->
                                        <td><a href="" ng-click="open('lg',assignedTask.user_info)" class="color-darkgrey"><span ng-bind="assignedTask.user_info.name"></span></a></td>

                                       <!-- <td><my-date year="assignedTask.impdate"></my-date></td>-->
                                        <td><span ng-bind="assignedTask.impdate"></span></td>

                                        <td><span ng-bind="assignedTask.status"></span></td>
                                        <td>
                                            <table class="actions">



                                                    <tr>
                                                        <td>
                                                            <a href="<?php echo Request::root().'/views?searchid=<%assignedTask.cmNoSearch%>' ?>" class="" data-position="bottom" data-delay="50" data-tooltip="View Record"><i class="fa fa-eye"></i></a>

                                                        </td>
                                                        <td>
                                                          <!--  <a href="<?php echo Request::root().'/<%assignedTask.next_url%>' ?><%assignedTask.request_id%>" class="" data-position="bottom" data-delay="50" data-tooltip="Request Action"><i class="fa fa-check"></i></a> -->

                                                        </td>

                                                    </tr>


                                            </table>
                                        </td>
                                    </tr>

                                </table>

                            </div><!--/table-wrapper-->

                        </uib-accordion-group>
                    </uib-accordion>
                </div>
            </div>
        </div>




        <script type="text/ng-template" id="myModalContent.html">
            <div class="modal-header">
                <h3 class="modal-title">User Details</h3>
            </div>
            <div class="modal-body">
                <div class="report-wrapper table-overflow scrollbarX">
                    <table class="table table-striped table-bordered">
                        <thead>



                        </thead>
                        <tbody>
                        <tr>
                            <td>Name</td>
                            <td><%users.name%></td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td><%users.email%></td>
                        </tr>
                        <tr>
                            <td>Department</td>
                            <td><%users.d_name%></td>
                        </tr>
                        <tr>
                            <td>Sub Department</td>
                            <td><%users.sub_dep_name%></td>
                        </tr>
                        <tr>
                            <td>Mobile No.</td>
                            <td><%users.mobile_no%></td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer">

                <button class="btn btn-animate flat blue pd-btn pull-left" type="button" ng-click="cancel()">Close</button>
            </div>
        </script>
            
      </div><!--/container-->
  </div><!--/main-wrapper-->


<?php require app_path().'/views/footer.php'; ?>

<!--
<script type="text/javascript">
    $(function(){

        $('#show-first').on('click',function(){
            $('#card-reveal1').slideToggle('slow');
        });

        $('#card-reveal1 .close').on('click',function(){
            $('#card-reveal1').slideToggle('slow');
        });

        $('#show-second').on('click',function(){
            $('#card-reveal2').slideToggle('slow');
        });

        $('#card-reveal2 .close').on('click',function(){
            $('#card-reveal2').slideToggle('slow');
        });

        $('#show-third').on('click',function(){
            $('#card-reveal3').slideToggle('slow');
        });

        $('#card-reveal3 .close').on('click',function(){
            $('#card-reveal3').slideToggle('slow');
        });


    });
    /*$(function(){

     $('#show-second').on('click',function(){
     $('#card-reveal2').slideToggle('slow');
     });

     $('#card-reveal2 .close').on('click',function(){
     $('#card-reveal2').slideToggle('slow');
     });

     });*/

    $('.flip').click(function(){
        $(this).find('.card').toggleClass('flipped');

    });


</script>-->