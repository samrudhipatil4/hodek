<?php require app_path().'/views/apqp_header.php'; ?>
<style type="text/css">

   .report-wrapper table tbody > tr > td{
        padding: 5px !important;
        color: #58585 !important;
        font-size: 13px;

  }

</style>
  <div class="main-wrapper">
    <div class="container" ng-controller="RFQView">

              <div class="row two-col-row mg-bottom-0">

                <div class="col-sm-12">

                    <div class="row mg-btm">
                      <div class="col-sm-6">
                        <div class="page-heading">
                          <h1 class="border-none">View RFQ</h1>
                          <div class="btn-wrap">
                         <form method="post" action="<?php echo Request::root().'/downloadRFQView'; ?>">
                        <!--/page-heading-->
                        
                        <?php if(isset($_GET['searchid']) ) {?>
                       <input type="hidden" name="RFQId" value="<?=$_GET['searchid']?>">
                                  <button style="margin-top: -80px;margin-left: 150px;" class="btn btn-animate flat blue pd-btn  view_btn" type="submit">PDF Download</button>
                                  <?php }?>
                                  </form>
                                  </div>
                        </div><!--/page-heading-->
                      </div>
                      <div class="col-sm-6" ng-cloak="">
                        <?php if(!isset($_GET['link']) ) {?>
                           <form method="get" role="form" action="" class="col-sm-12 myform" ng-class="{'submitted': submitted}" name="requestForm" novalidate ng-submit="(submitted = true) && requestForm.$invalid && $event.preventDefault()" autocomplete="off">

                              <div class="inline-form pull-right col-sm-6">

                               <!--  <div class="input-wrap"> -->
                               <div class="col-sm-8">
                                    <select class="form-control" select2=""  ng-model="request.searchid" name="searchid"  id="searchid" required  >
                                          <option  value=""></option>

                                           <option ng-repeat="d in RFQId" value="<%d.id%>"><%d.rfq_id %> <%d.rfq_title %></option>

                                      </select>
                                    <span class="error-msg " ng-show="(requestForm.searchid.$dirty || invalidSubmitAttempt) && requestForm.searchid.$error.required"> Unique ID is required.</span>

                                <!-- </div> -->
                                </div>
                                <div class="col-sm-4">
                                <div class="btn-wrap">

                                  <button style="margin-top: -3px;" class="btn btn-animate flat blue pd-btn  view_btn" ng-click="SearchRFQ(requestForm,search)" type="submit">View</button>
                                </div>
                                </div>
                              </div>
                            </form>
                        <?php } elseif(isset($_GET['link'])&& ($_GET['link']=='user')){?>
                          <div class="btn-wrap">
                          <input type="hidden" name="fromDashboard" id="fromDashboard" value="<?php echo $_GET['link'];?>">
                          </div>

                        <?php }?>
                      </div>
                    </div>

                    <div class="seprator"></div>

                  <div class="content-wrapper" ng-cloak="" ng-show="showReport" ng-init="SearchRFQ('<?php if(isset($_GET['searchid']))echo $_GET['searchid']; ?>')">

                    <!-- view report -->
                    <div class="row mg-bottom-0">
                      <div class="col-sm-12">
                        <h4 class="border-none"><span ng-bind="summeries.c"></h4>
                        <h5 class="border-none" ><strong>Reject Comment:- </strong><span ng-bind="summeries.count_request_is_remark"></h5>
                        <section class="report-wrapper">

                           <table class="striped">
                              <tbody>
                                <tr>
                                  <td width="12.5%"><strong>RFQ Id</strong></td>
                                  <td width="12.5%"><span ng-bind="summeries.RFQ_Id"></span></td>
                                  <td width="12.5%"><strong>RFQ Title</strong></td>
                                  <td width="12.5%"><span ng-bind="summeries.RfqTitle"></span></td>
                                  <td width="12.5%"><strong> Customer</strong></td>
                                  <td width="12.5%"><span ng-bind="summeries.customer"></span></td>
                                 
                                </tr>
                                <tr>
                                <tr>
                                  <td width="12.5%"><strong>Summary Description</strong></td>
                                  <td width="12.5%" colspan="3"><span ng-bind="summeries.summary_desc"></span></td>
                                  <td width="12.5%"><strong>Product Goals</strong></td>
                                  <td width="12.5%" colspan="3"><span ng-bind="summeries.product_goals"></span></td>
                                </tr>

                                   <td ><strong>Customer Contact Person</strong></td>
                                  <td ><span ng-bind="summeries.custContactPerson"></span></td>
                                  <td><strong>Phone</strong></td>
                                 <td ng-if="summeries.phone != 0"><span ng-bind="summeries.phone"></span></td>
                                  <td><strong>email</strong></td>
                                 <td><span ng-bind="summeries.email"></span></td>
                                 
                                </tr>
                                <tr>
                                

                                  <td><strong>instruction_for_respone</strong></td>
                                  <td colspan="2">
                                        <span ng-bind="summeries.instruction_for_respone"></span>
                                  </td>
                                  <td><strong>RFQ Issue Date</strong></td>
                                   <td >
                                         <span ng-bind="summeries.rfq_issue_date"></span>
                                  </td>
                                  <td><strong>Proposal Deadline</strong></td>
                                 <td><span ng-bind="summeries.proposal_deadline"></span></td>
                                </tr>
                                <tr>
                                 
                                  <td><strong>Product Details</strong></td>
                                  <td colspan="2">  <span ng-bind="summeries.prod_details"></span>
                                   </td>
                                  <td><strong>Technical Requirements</strong></td>
                                  <td colspan="2">
                                        <span ng-bind="summeries.technical_req"></span>
                                     </td>
                                      <td ><strong>Quantity</strong></td>
                                  <td ><span ng-bind="summeries.quantity"></span></td>
                                </tr>
                                <tr>
                                  <td><strong>Delivery Requirements</strong></td>
                                  <td colspan="2"><span ng-bind="summeries.delivery_req"></span></td>
                                  <td><strong>Support Requirements</strong></td>
                                  <td colspan="2">     <span ng-bind="summeries.support_req"></span> 
                                        </td>
                                </tr>

                                <tr>
                                  <td ><strong>Quality Assurance Requirements</strong></td>
                                  <td colspan="2"><span ng-bind="summeries.quality_assurance_req"></span></td>
                                  <td ><strong>Legal Requirements</strong></td>
                                  <td colspan="2"><span ng-bind="summeries.legal_req"></span></td>
                                </tr>
                                <tr>
                                  <td colspan="1"><strong>Terms Condition</strong></td>
                                  <td colspan="2"><span ng-bind="summeries.terms_condition"></span></td>
                                   <td colspan="1"><strong>Price Per Unit</strong></td>
                                   <td colspan="5"><span ng-bind="summeries.price_per_unit"></span></td>
                                </tr>
                                <tr>
                                 <td><strong>RFQ file</strong></td>
                                  <td> <ul ng-repeat="f in summeries.file" >

                                         <li ng-if="f.file_name!=''">
                                           <span ng-bind="f.file_name"></span>  <a href="<?php echo Request::root().'/download?path=rfq_file&filename='?><%f.file_name%>" data-position="bottom" data-delay="50" data-tooltip="Download"><i class="glyphicon glyphicon-download-alt"></i></a>
                                           <!--    <a target="_blank" href="<?php echo Request::root().'/viewFile?path=changeRequest&filename='?><%member.attachment_file%>" data-position="bottom" data-delay="50" data-tooltip="Download"><i class="fa fa-eye"></i></a> -->
                                        


                                         </li>
                                       </ul></td>
                                </tr>

                              </tbody>
                            </table>

                            



                         

                        </section>

                  <!--       <div class="btn-wrap pull-right" ng-if="summeries.result!=1">
                           <?php if(isset($_GET['link'])&& ($_GET['link']=='user')){?>
                        <a class="btn btn-animate flat blue pd-btn  view_btn " href="<?php echo Request::root().'/<%summeries.close_details.next_url%>' ?><%summeries.request_id%>/<%summeries.close_details.id%>">Request Action</a>
                        <?php }?>
                         <a class="btn btn-animate flat blue pd-btn  view_btn " href="<?php echo Request::root(); ?>"><< Back to Dashboard</a>

                          <?php if(isset($_SESSION['btntype'])){$type= $_SESSION['btntype'];
                          if($type == "summerySheet"){
                          ?>
                          <a class="btn btn-animate flat blue pd-btn  view_btn " href="<?php echo Request::root().'/advance-search-result_view'; ?>"><< Back to Summery Sheet</a>
                          <?php }else{?>
                            <a class="btn btn-animate flat blue pd-btn  view_btn " href="<?php echo Request::root().'/tracking_sheet'; ?>"><< Back to Tracking Sheet</a>
                            <?php }}?>
                        </div> -->


<!-- 
                        <div class="row" ng-if="summeries.result==1">
                          <div class="col-sm-12 btn-group">
                             No Record Found
                          </div>
                        </div> -->

                      </div>
                    </div>

                  </div><!--/content-wrapper-->
                </div><!--/s10-->
              </div><!--/row-->

      </div><!--/container-->
  </div><!--/main-wrapper-->

  <?php require app_path().'/views/apqp_footer.php'; ?>
