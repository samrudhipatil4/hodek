<!DOCTYPE html>
<html lang="en" >
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title> Summary Sheet | CM </title>

    <!-- Bootstrap -->
    <link href="css/materialize.min.css" rel="stylesheet">
    <link href="css/prism.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">

        
         

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
   
 <!--Custom Css with -->
   
 <style>
 html {
  line-height: 1.5;
}
body {
  font-family: "Open Sans",sans-serif;
  font-weight: normal;
}
 body {
  background-color: hsl(0, 0%, 98%);
  display: flex;
  flex-direction: column;
  font-size: 16px;
  min-height: 100vh;
}
.summary-table .striped th {
  font-weight: 600;
}
.report-wrapper table.striped > tbody > tr:nth-child(2n+1) {
  background-color: hsl(0, 0%, 98%);
}
.summary-table .rotate > span {
  color: hsl(220, 3%, 23%);
  display: block !important;
  margin: 0 auto;
  transform: rotate(-90deg);
  width: 15px;
}
.summary-table .rotate {
  text-align: center !important;
  white-space: nowrap;
}
.borderd-cell > tbody > tr > td {
  border-right: 1px solid hsl(0, 0%, 90%) !important;
}
.report-wrapper table tbody > tr > td {
  color: hsl(228, 2%, 48%);
  font-size: 12px;
}
.report-wrapper table table tr > td {
  border: 0 none;
}
.summary-table .rotate.pd {
  padding-bottom: 10px;
}
.summary-table .rotate {
  height: 160px;
  text-align: center !important;
  vertical-align: bottom;
  white-space: nowrap;
}
.report-wrapper table tbody > tr > td {
  color: hsl(228, 2%, 48%);
  font-size: 12px;
}
.summary-table td.status.yellow, .summary-status li:nth-of-type(2) > span {
  background-color: hsl(47, 95%, 57%) !important;
  color: hsl(0, 0%, 100%);
}
.summary-table td.status {
  border-radius: 0;
  text-align: center;
}
.report-wrapper table tbody > tr > td {
  font-size: 11px;
  padding: 2px 10px;
}
.summary-table td.status.red, .summary-status li:nth-of-type(3) > span {
  background-color: hsl(3, 87%, 39%) !important;
  color: hsl(0, 0%, 100%);
}
.summary-table td.status.green, .summary-status li:nth-of-type(1) > span {
  background-color: hsl(79, 42%, 41%) !important;
  color: hsl(0, 0%, 100%);
}
.summary-table td.status {
  border-radius: 0;
  text-align: center;
}
.center-align {
  text-align: center !important;
}

.report-wrapper table tbody > tr > td {
  border-bottom: 1px solid hsl(0, 0%, 90%);
  border-right: 1px solid hsl(0, 0%, 90%);
}
.pd-none {
  padding: 0 !important;
}
.summary-table .rotate {
  text-align: center !important;
}
.report-wrapper table tbody > tr > td {
  border-bottom: 1px solid hsl(0, 0%, 90%);
  border-right: 1px solid hsl(0, 0%, 90%);
}
.summary-table > table {
  table-layout: fixed;
  width: 100%;
}
.report-wrapper table.striped {
  border-left: 1px solid hsl(0, 0%, 90%);
  border-top: 1px solid hsl(0, 0%, 90%);
}
.main-wrapper {
  flex: 1 0 auto;
}

.container {
  max-width: 100% !important;
  padding: 0 30px;
  width: 100% !important;
}
.mg-bottom-0 {
  margin-bottom: 0 !important;
}
.content-wrapper {
  background-color: hsl(0, 0%, 100%);
  border: 1px solid hsl(206, 11%, 88%);
  border-radius: 5px;
  padding: 20px;
}
.mg-top-0 {
  margin-top: 0 !important;
}
ul {
  list-style-type: none !important;
}
.summary-status > li {
  font-size: 12px !important;
  margin-bottom: 5px;
}
.summary-status > li > span {
  display: inline-block;
  height: 22px;
  line-height: 22px;
  text-align: center;
  width: 25px;
}
.summary-table td.status.yellow, .summary-status li:nth-of-type(2) > span {
  background-color: hsl(47, 95%, 57%) !important;
}
.summary-status > li > span {
  display: inline-block;
  height: 22px;
  line-height: 22px;
  text-align: center;
  width: 25px;
}
.summary-status > li {
  font-size: 12px !important;
}
table {
  width: 100%;
}
.borderd-cell .border-bottom, .border-bottom {
  border-bottom: 1px solid hsl(0, 0%, 90%) !important;
}
.summary-table .rotate > span {
  display: block !important;
}
.summary-table td.status.green, .summary-status li:nth-of-type(1) > span {
  background-color: hsl(79, 42%, 41%) !important;
}
.summary-table, .scrollbarX, .scrollbarX2 {
  overflow-x: auto;
  padding-bottom: 10px;
  position: relative;
}
.left-sidebar, .content-wrapper {
  margin: 2.1rem 0 0;
}
.container {
  max-width: 100% !important;
  width: 100% !important;
}
.mg-bottom-0 {
  margin-bottom: 0 !important;
}

.summary-table .striped th {
  border-radius: 0;
  border-right: 1px solid hsl(0, 0%, 90%);
  color: hsl(220, 3%, 23%);
  font-size: 12px;
  font-weight: 600;
  padding: 5px;
  text-align: left;
  vertical-align: bottom;
}
</style> 

  </head>
  <body>
    


  <div class="main-wrapper">
    <div class="container">

              <div class="row two-col-row mg-bottom-0">
                
                <div class="col s12">


                  <div class="content-wrapper">

                    <div class="row mg-bottom-0">
                      <div class="col s6">
                    
                      </div>
                      <div class="col s12">
                        <ul class="summary-status right-align mg-top-0">
                          <li>Activity Completed with required Approval & Verification <span>G</span></li>
                          <li>Within defined target date ( Work in Process )  <span>Y</span></li>
                          <li>Activity Over due <span>R</span></li>
                        </ul>
                      </div>
                    </div>
                    
                    <!-- summary Table start -->
                    <div class="summary-table report-wrapper scrollbarX">
                              
                        <table class="striped">
                              <thead>
                                <tr>
                                    <th width="50">Sr. No.</th>
                                    <th width="100">CM No.</th>
                                    <th width="150">Change req. date</th>
                                    <th width="350">Description of Change</th>
                                    <th width="200">Customer</th>
                                    <th width="200">Initiator Name</th>
                                    <th width="300" class="rotate pd-none">
                                      <table>
                                        <tr class="border-bottom">
                                          <td class="center-align">Risk Analysis</td>
                                        </tr>
                                        <tr>
                                          <td class="pd-none">
                                            <table class="borderd-cell">
                                              <tr>
                                                <td class="rotate pd"><span>Design</span></td>
                                                <td class="rotate pd"><span>Mfg. eng.</span></td>
                                                <td class="rotate pd"><span>Purchase</span></td>
                                                <td class="rotate pd"><span>SQA</span></td>
                                                <td class="rotate pd"><span>PO & System</span></td>
                                                <td class="rotate pd"><span>Logistic</span></td>
                                                <td class="rotate pd"><span>Production</span></td>
                                                <td class="rotate pd"><span>Process QA</span></td>
                                              </tr>
                                            </table>
                                          </td>
                                        </tr>
                                      </table>
                                    </th>
                                    <th width="50" class="rotate"><span>Steering Committee<br>Approval<span></th>
                                    <th width="50" class="rotate"><span>Customer Approval<br>Decision<span></th>
                                    <th width="50" class="rotate"><span>Customer Approval<br> Status<span></th>
                                    <th width="300" class="rotate pd-none">
                                      <table>
                                        <tr class="border-bottom">
                                          <td class="center-align">Activity Status</td>
                                        </tr>
                                        <tr>
                                          <td class="pd-none">
                                            <table class="borderd-cell">
                                              <tr>
                                                <td class="rotate pd"><span>Design</span></td>
                                                <td class="rotate pd"><span>Mfg. eng.</span></td>
                                                <td class="rotate pd"><span>Purchase</span></td>
                                                <td class="rotate pd"><span>SQA</span></td>
                                                <td class="rotate pd"><span>PO & System</span></td>
                                                <td class="rotate pd"><span>Logistic</span></td>
                                                <td class="rotate pd"><span>Production</span></td>
                                                <td class="rotate pd"><span>Process QA</span></td>
                                              </tr>
                                            </table>
                                          </td>
                                        </tr>
                                      </table>
                                    </th>
                                    <th width="50" class="rotate"><span>Change Implementation<br>date</span></th>
                                    <th width="50" class="rotate"><span>Before / After<br>Comprision</span></th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                
                                  <td>1.</td>
                                  <td>DCM/2015/1</td>
                                  <td>15.01.2015</td>
                                  <td>ID Changed</td>
                                  <td>M&M</td>
                                  <td>Nilesh</td>
                                  <td class="pd-none">
                                    <table class="borderd-cell">
                                      <tr>
                                      <td class="status green">G</td>
                                      <td class="status green">G</td>
                                      <td class="status yellow">Y</td>
                                      <td class="status green">G</td>
                                      <td class="status green">G</td>
                                      <td class="status red tooltipped" data-position="bottom" data-delay="50" data-tooltip="Lorem ipsum dolor sit amet">R</td>
                                      <td class="status green">G</td>
                                      <td class="status green">G</td>
                                      </tr>
                                    </table>
                                  </td>
                                  <td class="status green">G</td>
                                  <td class="status green">G</td>
                                  <td class="status green">G</td>
                                  <td class="pd-none">
                                    <table class="borderd-cell">
                                      <tr>
                                      <td class="status green">G</td>
                                      <td class="status green">G</td>
                                      <td class="status green">G</td>
                                      <td class="status green">G</td>
                                      <td class="status yellow">Y</td>
                                      <td class="status green">G</td>
                                      <td class="status red tooltipped" data-position="bottom" data-delay="50" data-tooltip="Lorem ipsum dolor sit amet">R</td>
                                      <td class="status green">G</td>
                                      </tr>
                                    </table>
                                  </td>
                                  <td class="status green">G</td>
                                  <td class="status green">G</td>
                                </tr>
                                <tr>
                               
                                  <td>2.</td>
                                  <td>SCM/2015/1</td>
                                  <td>20.02.2015</td>
                                  <td>"ABC Supplier" Location Change</td>
                                  <td>Nissan</td>
                                  <td>Arko</td>
                                  <td class="pd-none">
                                    <table class="borderd-cell">
                                      <tr>
                                      <td class="status green">G</td>
                                      <td class="status green">G</td>
                                      <td class="status yellow">Y</td>
                                      <td class="status green">G</td>
                                      <td class="status green">G</td>
                                      <td class="status red tooltipped" data-position="bottom" data-delay="50" data-tooltip="Lorem ipsum dolor sit amet">R</td>
                                      <td class="status green">G</td>
                                      <td class="status green">G</td>
                                      </tr>
                                    </table>
                                  </td>
                                  <td class="status green">G</td>
                                  <td class="status green">G</td>
                                  <td class="status green">G</td>
                                  <td class="pd-none">
                                    <table class="borderd-cell">
                                      <tr>
                                      <td class="status green">G</td>
                                      <td class="status green">G</td>
                                      <td class="status green">G</td>
                                      <td class="status green">G</td>
                                      <td class="status yellow">Y</td>
                                      <td class="status green">G</td>
                                      <td class="status red">R</td>
                                      <td class="status green">G</td>
                                      </tr>
                                    </table>
                                  </td>
                                  <td class="status green">G</td>
                                  <td class="status green">G</td>
                                </tr>
                                <tr>
                                
                                  <td>4.</td>
                                  <td>SCM/2015/2</td>
                                  <td>04.05.2015</td>
                                  <td>Part "X" Source Change from "Supplier A" to "Supplier B"</td>
                                  <td>TML</td>
                                  <td>Prafulla</td>
                                  <td class="pd-none">
                                    <table class="borderd-cell">
                                      <tr>
                                      <td class="status green">G</td>
                                      <td class="status green">G</td>
                                      <td class="status yellow">Y</td>
                                      <td class="status green">G</td>
                                      <td class="status green">G</td>
                                      <td class="status red tooltipped" data-position="bottom" data-delay="50" data-tooltip="Lorem ipsum dolor sit amet">R</td>
                                      <td class="status green">G</td>
                                      <td class="status green">G</td>
                                      </tr>
                                    </table>
                                  </td>
                                  <td class="status green">G</td>
                                  <td class="status green">G</td>
                                  <td class="status green">G</td>
                                  <td class="pd-none">
                                    <table class="borderd-cell">
                                      <tr>
                                      <td class="status green">G</td>
                                      <td class="status green">G</td>
                                      <td class="status green">G</td>
                                      <td class="status green">G</td>
                                      <td class="status yellow">Y</td>
                                      <td class="status green">G</td>
                                      <td class="status red tooltipped" data-position="bottom" data-delay="50" data-tooltip="Lorem ipsum dolor sit amet">R</td>
                                      <td class="status green">G</td>
                                      </tr>
                                    </table>
                                  </td>
                                  <td class="status green">G</td>
                                  <td class="status green">G</td>
                                </tr>
                                <tr>
                                
                                  <td>5.</td>
                                  <td>SCM/2015/1</td>
                                  <td>20.02.2015</td>
                                  <td>"ABC Supplier" Location Change</td>
                                  <td>Nissan</td>
                                  <td>Arko</td>
                                  <td class="pd-none">
                                    <table class="borderd-cell">
                                      <tr>
                                      <td class="status green">G</td>
                                      <td class="status green">G</td>
                                      <td class="status yellow">Y</td>
                                      <td class="status green">G</td>
                                      <td class="status green">G</td>
                                      <td class="status red">R</td>
                                      <td class="status green">G</td>
                                      <td class="status green">G</td>
                                      </tr>
                                    </table>
                                  </td>
                                  <td class="status green">G</td>
                                  <td class="status green">G</td>
                                  <td class="status green">G</td>
                                  <td class="pd-none">
                                    <table class="borderd-cell">
                                      <tr>
                                      <td class="status green">G</td>
                                      <td class="status green">G</td>
                                      <td class="status green">G</td>
                                      <td class="status green">G</td>
                                      <td class="status yellow">Y</td>
                                      <td class="status green">G</td>
                                      <td class="status red">R</td>
                                      <td class="status green">G</td>
                                      </tr>
                                    </table>
                                  </td>
                                  <td class="status green">G</td>
                                  <td class="status green">G</td>
                                </tr>
                                <tr>
                                
                                  <td>6.</td>
                                  <td>SCM/2015/2</td>
                                  <td>04.05.2015</td>
                                  <td>Part "X" Source Change from "Supplier A" to "Supplier B"</td>
                                  <td>TML</td>
                                  <td>Prafulla</td>
                                  <td class="pd-none">
                                    <table class="borderd-cell">
                                      <tr>
                                      <td class="status green">G</td>
                                      <td class="status green">G</td>
                                      <td class="status yellow">Y</td>
                                      <td class="status green">G</td>
                                      <td class="status green">G</td>
                                      <td class="status red tooltipped" data-position="bottom" data-delay="50" data-tooltip="Lorem ipsum dolor sit amet">R</td>
                                      <td class="status green">G</td>
                                      <td class="status green">G</td>
                                      </tr>
                                    </table>
                                  </td>
                                  <td class="status green">G</td>
                                  <td class="status green">G</td>
                                  <td class="status green">G</td>
                                  <td class="pd-none">
                                    <table class="borderd-cell">
                                      <tr>
                                      <td class="status green">G</td>
                                      <td class="status green">G</td>
                                      <td class="status green">G</td>
                                      <td class="status green">G</td>
                                      <td class="status yellow">Y</td>
                                      <td class="status green">G</td>
                                      <td class="status red">R</td>
                                      <td class="status green">G</td>
                                      </tr>
                                    </table>
                                  </td>
                                  <td class="status green">G</td>
                                  <td class="status green">G</td>
                                </tr>                                
                              </tbody>
                            </table>
                        
                    </div><!--/summary-table-->
                    
                    <!-- summary Table end -->

                  </div><!--/content-wrapper-->
                </div><!--/s10-->
              </div><!--/row-->
            
      </div><!--/container-->
  </div><!--/main-wrapper-->

   


  </body>
</html>
