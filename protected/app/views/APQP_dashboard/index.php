<style>
.main-wrapper {
  max-width: 100%;
  overflow-x: hidden;
}
</style>
<?php require app_path().'/views/apqp_header.php'; ?>

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
                  <div class="page-heading mg-btm" ng-controller="findUserName" ng-init="member_dep(<?php echo Session::get('uid')?>)">
                    <h1 ng-cloak>Welcome  <%member.first_name%> <%member.last_name%> </h1>
                  </div><!--/page-heading-->    
                </div>
              </div>
        </div><!--/row-->


        <?php
        $main_user_id = Session::get('uid')
?>

<?php if ($main_user_id != 1): ?>
        <!--// Pending task for HOD -->
        <div class="row" ng-cloak="">
            <div class="col-sm-12">
                <div ng-controller="pendingAPQPTask" class="">

                    <uib-accordion close-others="oneAtATime" ng-cloak>

                        <uib-accordion-group ng-init="status.open=true" is-open="status.open">
                            <uib-accordion-heading>
                                Pending Task To Me  <span class="records pull-right"> Records <i class="pull-right glyphicon" ng-class="{'glyphicon-triangle-top': status.open, 'glyphicon-triangle-bottom': !status.open}"></i></span>
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
                                        <th><a href="javascript:void(0)" ng-click="sortType = 'change_type_name'; sortReverse = !sortReverse" class="datasort">Project Number  <i class="fa fa-arrows-v"></i></a></th>
                                        <th><a href="javascript:void(0)" ng-click="sortType = 'created_date'; sortReverse = !sortReverse" class="datasort">Project Name <i class="fa fa-arrows-v"></i></a></th>
                                         <th><a href="javascript:void(0)" ng-click="sortType = 'created_date'; sortReverse = !sortReverse" class="datasort">manufacturing location <i class="fa fa-arrows-v"></i></a></th>
                                        <th><a href="javascript:void(0)" ng-click="sortType = 'initiator_name'; sortReverse = !sortReverse" class="datasort">Project Start Date<i class="fa fa-arrows-v"></i></a></th>                                        
                                        <th>Action</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <tr ng-repeat="pendingProjecttask in filtered = (pendingProjecttaskstome| filter:search | orderBy : sortType:sortReverse) | startFrom:(currentPage - 1) * entryLimit | limitTo:entryLimit">
                                        <!--<tr ng-repeat="assignedTask in filtered = (assignedtaskstome| filter:search | orderBy : sortType:sortReverse) | startFrom:(currentPage - 1) * entryLimit | limitTo:entryLimit">-->
                                        <td><span ng-bind="$index+1"></span>.</td>
                                        <td>
                                            <span ng-bind="pendingProjecttask.pending_project_id" style="display:none;"></span>
                                        </td>
                                        <td>
                                            <span  ng-bind="pendingProjecttask.pending_project_no"></span>
                                        </td>
                                        <td><span ng-bind="pendingProjecttask.pending_project_name"></span></td>
                                           <td><span ng-bind="pendingProjecttask.pending_project_manulocation"></span></td>
                                        <td ><span ng-bind="pendingProjecttask.pending_project_startdate"></span></td>
                                        </td>
                                        <td>
                                            <table class="actions" >
                                                <tr>
                                                    
                                                    <td>

                                                    <form ng-controller="assignToHodsForm" action="javascript:void(0);" method="post">
                        <button 
                            type="button" 
                            style="background-color: #007bff; color: white; border: none; padding: 8px 12px; cursor: pointer; border-radius: 4px;"
                            ng-click="assignToHods(
                                pendingProjecttask.pending_project_no, 
                                pendingProjecttask.pending_project_name, 
                                pendingProjecttask.pending_project_manulocation, 
                                pendingProjecttask.pending_project_startdate,
                                pendingProjecttask.pending_project_id
                            )">
                            Assign to HODS
                        </button>
                    </form>
                                                        
                              
                           
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

        <?php endif; ?>


        <!--// Assigned Task to Me-->
        <div class="row" ng-cloak="">
            <div class="col-sm-12">
                <div ng-controller="assignedAPQPTask" class="">

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
                                        <th><a href="javascript:void(0)" ng-click="sortType = 'change_type_name'; sortReverse = !sortReverse" class="datasort">Project No  <i class="fa fa-arrows-v"></i></a></th>
                                        <th><a href="javascript:void(0)" ng-click="sortType = 'created_date'; sortReverse = !sortReverse" class="datasort">Project Name <i class="fa fa-arrows-v"></i></a></th>
                                         <th><a href="javascript:void(0)" ng-click="sortType = 'created_date'; sortReverse = !sortReverse" class="datasort">Gate <i class="fa fa-arrows-v"></i></a></th>
                                        <th><a href="javascript:void(0)" ng-click="sortType = 'initiator_name'; sortReverse = !sortReverse" class="datasort">Activity<i class="fa fa-arrows-v"></i></a></th>
                                        <th><a href="javascript:void(0)" ng-click="sortType = 'FirstName'; sortReverse = !sortReverse" class="datasort">Planned Activity Start Date <i class="fa fa-arrows-v"></i></a></th>
                                        <th><a href="javascript:void(0)" ng-click="sortType = 'initiator_name'; sortReverse = !sortReverse" class="datasort">Planned Activity End Date <i class="fa fa-arrows-v"></i></a></th>
                                        
                                        
                                        <th>Action</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <tr ng-repeat="assignedTask in filtered = (assignedtaskstome| filter:search | orderBy : sortType:sortReverse) | startFrom:(currentPage - 1) * entryLimit | limitTo:entryLimit">
                                        <!--<tr ng-repeat="assignedTask in filtered = (assignedtaskstome| filter:search | orderBy : sortType:sortReverse) | startFrom:(currentPage - 1) * entryLimit | limitTo:entryLimit">-->
                                        <td><span ng-bind="$index+1"></span>.</td>
                                        <td>
                                            <span  ng-bind="assignedTask.proj_id"></span>
                                        </td>
                                        <td><span ng-bind="assignedTask.proj_name"></span></td>
                                           <td><span ng-bind="assignedTask.gate_id"></span></td>
                                        <td ><span ng-bind="assignedTask.activity"></span></td>
                                        </td>
                                        <td><span ng-bind="assignedTask.start_date"></span></td>
                                        <td><span ng-bind="assignedTask.end_date"></span></td>                       
                                        <td>
                                            <table class="actions" >

                                                <tr>
                                                    
                                                    <td>
                                                    <span ng-if="assignedTask.hold_project == 0">
                              
                           
                                                        <a href="<?php echo Request::root().'/<%assignedTask.next_url%>/<%assignedTask.aid%>/<%assignedTask.pid%>/<%assignedTask.id%>/<%assignedTask.mat_id%>' ?>" class="" data-position="bottom" data-delay="50" data-tooltip="Request Action"><i class="fa fa-check"></i></a>
                                                         </span>
                                                          <span ng-if="assignedTask.hold_project == 1">
                              
                           
                                                        <a onclick="return getHoldMsg()" href="<?php echo Request::root().'/<%assignedTask.next_url%>/<%assignedTask.aid%>/<%assignedTask.pid%>/<%assignedTask.id%>/<%assignedTask.mat_id%>' ?>" class="" data-position="bottom" data-delay="50" data-tooltip="Request Action"><i class="fa fa-check"></i></a>
                                                         </span>
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


<?php require app_path().'/views/apqp_footer.php'; ?>
<script type="text/javascript">
    function getHoldMsg(){
        alert('Project on hold.');
        return false;
    }
</script>


<script type="text/javascript">

$(document).ready(function () {
    $("#assignToHodsForm").on("submit", function (event) {
        alter("clicked");
        event.preventDefault(); // Prevent the default form submission
        // Prepare the data for the AJAX request (if any)
        let requestData = {
            // Add any required data here
            exampleKey: "exampleValue" 
        };

        // Make the AJAX call
        $.ajax({
            url: base_url + "assignToHods", // Replace with your endpoint
            type: "POST",
            data: requestData,
            success: function (response) {
                // Handle the success case
                console.log("Success:", response);
                alert("Assigned to HODS successfully.");
            },
            error: function (xhr, status, error) {
                // Handle errors
                console.error("Error:", error);
                alert("Failed to assign to HODS. Please try again.");
            }
        });
    });
});

</script>
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