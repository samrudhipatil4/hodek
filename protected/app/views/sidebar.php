
<aside class="left-sidebar" ng-controller="SidebarCtrl">
    <div class="side-box">
        <ul class="collection with-header">
            <li class="collection-header">Recent Assigned Task To Me</li>
            <li>
                <div class="loading-spiner-holder" data-loading >
                    <div class="loading-spiner"><img src="<?php echo Request::root(); ?>/protected/public/images/Twirl.gif" />
                    </div>
                </div>


            </li>
             <li class="collection-item" ng-repeat="recentTaskTo in recentTasksToMe|limitTo:5">
                <a href="<?php echo Request::root().'/views?searchid=<%recentTaskTo.cmNoSearch%>' ?>"><span ng-bind="recentTaskTo.cmNo"></span></a></li> 

        </ul>
    </div>
    <div class="side-box">
        <ul class="collection with-header">
            <li class="collection-header">Recent Assigned Task By Me</li>
            <li>
                <div class="loading-spiner-holder" data-loading >
                    <div class="loading-spiner"><img src="<?php echo Request::root(); ?>/protected/public/images/Twirl.gif" />
                    </div>
                </div>


            </li>
            <li class="collection-item" ng-repeat="recentTaskByM in recentTasksByMe |limitTo:5"><a href="<?php echo Request::root().'/views?searchid=<%recentTaskByM.cmNoSearch%>' ?>">
                    <span ng-bind="recentTaskByM.cmNo"></span></a></li>

        </ul>
    </div>
</aside>

