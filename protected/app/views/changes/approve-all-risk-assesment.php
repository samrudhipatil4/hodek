<?php require app_path().'/views/header.php'; ?>

    <div class="main-wrapper">
        <div class="container">

            <div class="row two-col-row mg-bottom-0">
                <div class="col-sm-2">
                    <?php require app_path().'/views/sidebar.php'; ?>
                </div><!--/s2-->
                <div class="col-sm-10">

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="page-heading">
                                <h1>Approve Risk Assessment from Admin</h1>
                            </div><!--/page-heading-->
                        </div>
                    </div>

                    <div class="content-wrapper" ng-controller="AllRiskAssessmentApprovalCTRL" ng-init="fetch_allrisk_assessment_approval('<?php echo Request::segment(3); ?>')">

                        <div class="form-wrapper">
                            <ul class="collapsible accordian-task" data-collapsible="accordion" ng-repeat="data in risks" ng-if="data.riskdata.length!=''">
                                <li>
                                    <div class="collapsible-header "><span ng-bind="data.sub_dep_name"></span></div>
                                    <div class="collapsible-body">

                                        <div class="table-wrapper">
                                            <table class="striped">
                                                <thead>
                                                <tr>
                                                    <th>SN.</th>
                                                    <th>Risk Assessment Points</th>
                                                    <th>Applicability</th>
                                                    <th>If No, Please specify the reason</th>
                                                    <th>If Yes, Please mention the De-Risking action</th>
                                                    <th>Responsibility</th>
                                                    <th>Target date</th>
                                                    <th>Any Cost Involved</th>

                                                </tr>
                                                </thead>

                                                <tbody>
                                                <tr ng-repeat="point in data.riskdata">
                                                    <td><span ng-bind="$index+1">.</span></td>
                                                    <td><span ng-bind="point.assessment_point"></span></td>
                                                    <td><span ng-bind="point.applicability | Applicability"></span></td>
                                                    <td><span ng-bind="point.reason"></span></td>
                                                    <td><span ng-bind="point.de_risking"></span></td>
                                                    <td><span ng-bind="point.responsibility.name"></span></td>
                                                    <td><span ng-bind="point.target_date| date:'dd.MM.yyyy'"></span></td>
                                                    <td><span ng-bind="point.cost"></span></td>

                                                </tr>

                                            </table>
                                        </div><!--/table-wrapper-->
                                    </div><!--/collapsible-body-->

                                </li>
                            </ul>

                            <div class="row mg-top">
                                <div class="col-sm-12 ">

                                    <a class="btn btn-animate flat blue pd-btn pull-right" href="<?php echo Request::root().'/changes/approval-risk-assessment-admin/'.Request::segment(3); ?>/<?=Request::segment(4); ?>">Next</a>
                                </div>
                            </div>

                        </div><!--/form-wrapper-->

                    </div><!--/content-wrapper-->
                </div><!--/s10-->
            </div><!--/row-->

        </div><!--/container-->
    </div><!--/main-wrapper-->
<?php require app_path().'/views/footer.php'; ?>