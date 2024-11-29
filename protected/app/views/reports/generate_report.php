 <div class="modal-body">

                              <div class="row mg-btm report-wrapper">
                                  <div class="col-sm-4 ">
                                      <div class="bdr-box width-box">
                                          <table class="table table-bordered table-striped">
                                              <thead>
                                              <tr>
                                              <th style="width:150px;"><strong></strong></th>
                                              <th><strong>> 1 Week</strong></th>
                                              <th><strong>> 1 Month</strong></th>
                                              <th><strong>> 2 Months</strong></th>
                                              <th><strong>> 3 Months</strong></th>
                                              </tr>
                                              </thead>
                                              <tbody>
                                              <tr class="mg-top">
                                                  <td>

                                          <ul class="pd-none " >
                                              <li ng-repeat="label in labels"><%label%></li>
                                          </ul>
                                                      </td>
                                                  <td style="text-align: right;">

                                          <ul class="pd-none " >

                                              <li ng-repeat="v1 in cdata1 track by $index"><%v1%></li>
                                          </ul>
                                                  </td>
                                                  <td style="text-align: right;">

                                                  <ul class="pd-none ">
                                              <li ng-repeat="v2 in cdata2 track by $index"><%v2%></li>

                                          </ul>
                                                  </td>
                                                  <td style="text-align: right;">

                                                  <ul class="pd-none ">
                                              <li ng-repeat="v3 in cdata3 track by $index"><%v3%></li>
                                          </ul>
                                                  </td>
                                                  <td style="text-align: right;">

                                                  <ul class="pd-none ">
                                              <li ng-repeat="v4 in cdata4 track by $index"><%v4%></li>
                                          </ul>
                                                  </td>

                                              </tr>
                                              </tbody>

                                          </table>
                                      </div>
                                  </div>
                                  <div class="page-heading">

                                      <div class="col-sm-8 bdr-box">
                                          <div class="row">
                                              <div class="col-sm-6">
                                                  <div class="page-heading">
                                                      <h1>Pending >2 Weeks after Target Date</h1>
                                                      <div  class="bar-wrapper">
                                                          <canvas id="bar" class="chart chart-bar"  chart-data="data1" chart-labels="labels"></canvas>
                                                      </div><!--/chart-ctrl-->
                                                  </div>
                                              </div>
                                              <div class="col-sm-6">
                                                  <div class="shadow-none">
                                                      <div class="page-heading">
                                                          <h1>Pending >1 Month after Target Date</h1>
                                                          <div  class="bar-wrapper">
                                                              <canvas id="bar" class="chart chart-bar"  chart-data="data2" chart-labels="labels"></canvas>
                                                          </div><!--/chart-ctrl-->
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>

                                          <div class="row">
                                              <div class="col-sm-6">
                                                  <div class="page-heading">
                                                      <h1>Pending >2 Months after Target Date</h1>
                                                      <div  class="bar-wrapper">
                                                          <canvas id="bar" class="chart chart-bar"  chart-data="data3" chart-labels="labels"></canvas>
                                                      </div><!--/chart-ctrl-->
                                                  </div>
                                              </div>
                                              <div class="col-sm-6">
                                                  <div class="shadow-none">
                                                      <div class="page-heading">
                                                          <h1>Pending >3 Months after Target Date</h1>
                                                          <div  class="bar-wrapper">
                                                              <canvas id="bar" class="chart chart-bar"  chart-data="data4" chart-labels="labels"></canvas>
                                                          </div><!--/chart-ctrl-->
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div><!--/container-->



                          </div>