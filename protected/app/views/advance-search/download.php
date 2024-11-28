

<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<div class="row ">
<div class="col-sm-6 pull-right" style="float: right;">
    <ul class="summary-status right-align mg-top-0">
        <li>Activity Completed with required Approval & Verification <span>G</span></li>
        <li>Within defined target date ( Work in Process )  <span>Y</span></li>
        <li>Activity Over due <span>R</span></li>
    </ul>
</div>
</div>

<!-- summary Table start -->
<div class="summary-table report-wrapper">

    <table class="striped">
        <thead>
        <tr>

            <th width="50" style="color:red;">Sr. No.</th>
            <th width="100" class="color">CM No.</th>
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
        <?php
        if(sizeof($data)>0){


            $i=0;
            foreach($data as $jobs){  ?>

                <tr>

                    <td><?=++$i?>.</td>
                    <?php

                    // $originalDate = $jobs->created_date;
                    // $newDate = date("d.m.Y", strtotime($originalDate));
                    // $newDate1= date("d/m/Y", strtotime($originalDate));
                    ?>
                    <td>
                        <span ><?=$jobs['cmNo'];?></span></td>

                    <?php //$jobs->request_id;?></td>

                    <td><?= $jobs['created_date'];?></td>
                    <td><?= $jobs['Purpose_Modification_Details'];?></td>
                    <td>
                        <ul class="listing">
                            <?php
                if(isset($jobs['customers'])&& !empty($jobs['customers'])){
                            foreach($jobs['customers'] as $customer){  ?>

                                <li>
                                    <span ><?=$customer['customer_name'];?></span>

                                </li>
                            <?php } }?>
                        </ul>
                    </td>
                    <td><?= $jobs['initiator_name'];?></td>
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
            <?php } }else{?>
            <tr>
                No Records Found.

            </tr>
        <?php }?>
        </tbody>
    </table>

</div><!--/summary-table-->
