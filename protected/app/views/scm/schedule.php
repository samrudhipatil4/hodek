<?php require app_path().'/views/header.php'; ?>
<style>

.select {
    background: #fff none repeat scroll 0 0;
    border-color: #aaa #c8c8c8 #c8c8c8 #aaa;
    border-style: solid;
    border-width: 1px;
    font: 18px arial,helvetica,sans-serif;
}

.form-list td.value {
    padding-right: 5px !important;
    width: 300px;
}
</style>

  <div class="main-wrapper">
    <div class="container-fluid">

              <div class="row two-col-row mg-bottom-0">
                <div class="col-sm-2">
                 	<!-- Sidebar Comes here! -->
					
					<?php require app_path().'/views/scm/scm_sidebar.php'; ?>
					
					<!-- sidebar ends here -->
					
					 </div><!--/s2-->
                <div class="col-sm-10">


                  <div class="content-wrapper">                    
                    <div class="row">
                        <div class="col-sm-12">
                        <div class="page-heading mg-btm">
                          <h1>Schedule Email</h1>
                        </div><!--/page-heading-->    
                      </div>
                    </div>

                      <div class="form-wrapper" >


                    <div class="row" >
                    <form method="post"  action="<?php echo Request::root().'/save_cron_job' ?>" role="form" class="col-sm-12 myform" ng-class="{'submitted': submitted}" name="requestForm" novalidate >

                    <div class="col-sm-8">

                              <table class="form-list" cellspacing="0">
                            <colgroup class="label"></colgroup>
                            <colgroup class="value"></colgroup>
                            <colgroup class="scope-label"></colgroup>


                             <tbody>
                             <tr id="row_currency_import_enabled" >
                             <td class="label"><label for="currency_import_enabled"> Enabled</label></td><td class="value">
                             <select  class="select" name="status" id="currency_import_enabled">
                            <option value="1">Yes</option>
                            <option selected="selected" value="0">No</option>
                            </select>
                            </td><td class=""></td></tr>

                            <tr id="row_currency_import_time">
                            <td class="label">
                            <label for="currency_import_time"> Start Time</label></td>
                            <td class="value"><input type="hidden" id="currency_import_time">
                            <select class="select" style="width:50px" type="time" class="" name="hour">
                            <option selected="selected" value="00">00</option><option value="01">01</option><option value="02">02</option><option value="03">03</option><option value="04">04</option><option value="05">05</option><option value="06">06</option><option value="07">07</option><option value="08">08</option><option value="09">09</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option></select>
                            &nbsp;:&nbsp;<select class="select" style="width:50px" type="time" class=" select" name="minute">
                            <option selected="selected" value="00">00</option><option value="01">01</option><option value="02">02</option><option value="03">03</option><option value="04">04</option><option value="05">05</option><option value="06">06</option><option value="07">07</option><option value="08">08</option><option value="09">09</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option><option value="32">32</option><option value="33">33</option><option value="34">34</option><option value="35">35</option><option value="36">36</option><option value="37">37</option><option value="38">38</option><option value="39">39</option><option value="40">40</option><option value="41">41</option><option value="42">42</option><option value="43">43</option><option value="44">44</option><option value="45">45</option><option value="46">46</option><option value="47">47</option><option value="48">48</option><option value="49">49</option><option value="50">50</option><option value="51">51</option><option value="52">52</option><option value="53">53</option><option value="54">54</option><option value="55">55</option><option value="56">56</option><option value="57">57</option><option value="58">58</option><option value="59">59</option></select>
                            &nbsp;:&nbsp;<select class="select" style="width:50px" type="time" class=" select" name="second">
                            <option selected="selected" value="00">00</option><option value="01">01</option><option value="02">02</option><option value="03">03</option><option value="04">04</option><option value="05">05</option><option value="06">06</option><option value="07">07</option><option value="08">08</option><option value="09">09</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option><option value="32">32</option><option value="33">33</option><option value="34">34</option><option value="35">35</option><option value="36">36</option><option value="37">37</option><option value="38">38</option><option value="39">39</option><option value="40">40</option><option value="41">41</option><option value="42">42</option><option value="43">43</option><option value="44">44</option><option value="45">45</option><option value="46">46</option><option value="47">47</option><option value="48">48</option><option value="49">49</option><option value="50">50</option><option value="51">51</option><option value="52">52</option><option value="53">53</option><option value="54">54</option><option value="55">55</option><option value="56">56</option><option value="57">57</option><option value="58">58</option><option value="59">59</option></select>
                            </td><td class=""></td></tr><tr id="row_currency_import_frequency"><td class="label"><label for="currency_import_frequency"> Frequency</label></td><td class="value"><select class=" select" name="groups[import][fields][frequency][value]" id="currency_import_frequency">
                            <option value="D">Daily</option>
                            <option value="W">Weekly</option>
                            <option value="M">Monthly</option>
                            </select>
                            </td><td class=""></td></tr>
                            <tr id="row_currency_import_error_email"><td class="label"><label for="currency_import_error_email"> Error Email Recipient</label></td><td class="value"><input type="text" class=" validate-email input-text" value="" name="groups[import][fields][error_email][value]" id="currency_import_error_email">
                            </td><td class=""></td></tr>
                            <tr id="row_currency_import_error_email_identity">
                            <td class="label">
                            <label for="currency_import_error_email_identity"> Error Email Sender</label></td>
                            <td class="value">
                            <select class=" select" name="general_contact" id="currency_import_error_email_identity">
                            <option selected="selected" value="general">General Contact</option>
                            <option value="sales">Sales Representative</option>
                            <option value="support">Customer Support</option>
                            <option value="custom1">Custom Email 1</option>
                            <option value="custom2">Custom Email 2</option>
                            </select>
                            </td><td class=""></td></tr>
                            <tr id="row_currency_import_error_email_template">
                            <td class="label">
                            <label for="currency_import_error_email_template"> Error Email Template</label></td><td class="value">
                            <select class=" select" name="email_template" id="currency_import_error_email_template">
                            <option selected="selected" value="currency_import_error_email_template">Currency Update Warnings (Default Template from Locale)</option>
                            </select>
                            </td><td class=""></td>
                            </tr>
                            </tbody>

                              </table>


</div>

                                  <div class="row " >

                                    <div class="input-field col-sm-6  mg-top-23">

                                    <button type="submit" class="btn btn-animate flat blue pd-btn"  name="action" >Submit</button>


                                  </div>
                                  </div>
                                    </form>
                    </div>




                          </div>
                      </div>


                      </div><!--/form-wrapper-->

                    

                  </div><!--/content-wrapper-->
                </div><!--/s10-->
              </div><!--/row-->
            
      </div><!--/container-->
  </div><!--/main-wrapper-->
  
<?php require app_path().'/views/footer.php'; ?>