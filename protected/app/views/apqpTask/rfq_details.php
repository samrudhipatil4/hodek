<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0, user-scalable=no">
<?php require app_path().'/views/apqp_header.php'; ?>
<style type="text/css">
  .cls-design{
   
    color: skyblue;
    font-weight: bold;
  }
  button:focus {
    background-color: #316886;
  }
  .flat{
    background-color: #316886;
    color: white;
  }
</style>
</head>
  <div class="main-wrapper">
    <div class="container">


              <div class="row two-col-row mg-bottom-0">
                <div class="col-sm-2">
                    
                </div>
                <div class="col-sm-10">

                    <div class="row">
                      <div class="col-sm-12">
                        <div class="page-heading">
                          <h1 style="font-size: 24px;
    font-family: cursive;">Request For Quotation  </h1>
                      
                        </div><!--/page-heading-->    
                      </div>
                    </div>
<?php if(Session::has('message')){

                        echo Session::get('message');

                    }?>
                    <ul class="parsley-error-list">
                        <?php
                        foreach($errors->all() as $error){  ?>
                        <li>echo  $error</li>
                        <?php }?>
                    </ul>
                  <div class="content-wrapper">

                    <div class="form-wrapper" ng-controller="apqpRFQdetails" ng-init="getProject()">
                          


                        <div class="row mg-bottom-0" >
                         
                          <form method="post" role="form"    class="col-sm-12 myform" ng-class="{'submitted': submitted}" id="requestForm" name="requestForm" novalidate ng-submit="(submitted = true) && requestForm.$invalid && $event.preventDefault()" enctype="multipart/form-data" autocomplete="off" action="<?php echo Request::root().'/saveRFQ';?>">
                  
                                   <div class="row mg-btm" style="background-color:#4591ba " >
                               
                            <h4 style="    color: white;
    font-weight: bold;
    font-size: 22px;">Buyer Information</h4>
                            </div>
                               <div class="row mg-btm">
                                <div class="input-field col-sm-4" >
                                <div class="cls-design" >
                          <label>   Customer Name</label> </div>

                              <select class="form-control" select2=""  ng-model="request.customer" name="customer" style="border-color: grey;margin-top: 10px;" required>
                                  <option  value=""></option>
                                  <option ng-repeat="d in customer" value="<%d.CustomerId%>"><%d.FirstName%></option>
                              </select>
                             
                          </div>
                             <div class="input-field col-sm-4">
                              <div class="cls-design"><label>  RFQ Title </label></div>
                             <input  class="form-control" type="text" ng-model="request.txtrfqtitle" name="txtrfqtitle" style="border-color: grey;" required="true" maxlength="50">
                                 <span ng-cloak class="error-msg " ng-show="(requestForm.txtrfqtitle.$dirty || invalidSubmitAttempt) && requestForm.txtrfqtitle.$error.required"> This field is required.</span>
                          </div>
                              <div class="input-field col-sm-4">
                              <div class="cls-design"><label>  RFQ Id </label> </div>
                             <input class="form-control" readonly="true" type="text" ng-model="request.txtrfqid" id="txtrfqid" name="txtrfqid" style="border-color: grey;"  onkeypress="return Numeric1(event);">
                               <!-- <span ng-cloak class="error-msg " ng-show="(requestForm.txtrfqid.$dirty || invalidSubmitAttempt) && requestForm.txtrfqid.$error.required"> This field is required.</span> -->
                          </div>                         

                            </div>
                            <div class="row mg-btm">
                                <div class="input-field col-sm-4">
                             <div class="cls-design"> <label> Project Summary Description </label></div>
                           
                             
                          </div>
                            
                             <div class="col-sm-8">     <textarea name="txtProjSummary" cols="77" ng-model="request.txtProjSummary" required="true"></textarea>                   
                             <span ng-cloak class="error-msg " ng-show="(requestForm.txtProjSummary.$dirty || invalidSubmitAttempt) && requestForm.txtProjSummary.$error.required"> This field is required.</span>
                             </div>

                            </div>
                             <div class="row mg-btm">
                               <div class="input-field col-sm-4"><div class="cls-design"> 
                            <label>  Product Goals </label></div>
                           
                             
                          </div>
                            
                             <div class="col-sm-8">     <textarea name="txtProdGoal" cols="77"></textarea>                   
                             </div>

                            </div>
                             <div class="row mg-btm">
                                <div class="input-field col-sm-4" >
                                <div class="cls-design">
                             <label>Customer Contact Person </label></div>

                             <input class="form-control" type="text" ng-model="request.txtprojlead" name="txtprojlead" style="border-color: grey;" required="true">
                             <span ng-cloak class="error-msg " ng-show="(requestForm.txtprojlead.$dirty || invalidSubmitAttempt) && requestForm.txtprojlead.$error.required"> This field is required.</span>
                          </div>
                             <div class="input-field col-sm-4">
                              <div class="cls-design"><label> Phone </label></div>
                             <input type="text" ng-model="request.txtPhone" ng-maxlength="12" ng-minlength="10" name="txtPhone" style="border-color: grey;" onkeypress="return Numeric1(event);" >
              <span ng-cloak class="error-msg" ng-show=" requestForm.txtPhone.$error.minlength">Input is too short!</span>
          <span ng-cloak class="error-msg" ng-show="requestForm.txtPhone.$error.maxlength">Input is too long!</span>
                              
                          </div>
                              <div class="input-field col-sm-4">
                              <div class="cls-design"><label> Email</label> </div>
                             <input type="text" name="txtEmail" ng-model="request.txtEmail" style="border-color: grey;" ng-pattern="/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/" maxlength="100">
                              <span ng-cloak class="error-msg" ng-show="requestForm.txtEmail.$error.pattern">Invalid email</span>
                          </div>                         

                            </div>
                            <div class="row mg-btm">
                               <div class="input-field col-sm-4"><div class="cls-design"> 
                              <label>Instruction for Submitting Response</label></div>
                           
                             
                          </div>
                            
                             <div class="col-sm-4">     <textarea name="txtInstrForResp" rows="6" cols="40"></textarea>                   
                             </div>
                              <div class="col-sm-4"> 
                               <div class="row mg-btm">
                                <div class="input-field col-sm-12" >
                                <div class="cls-design">
                             <label>Date of RFQ Issue </label></div>

                             <input class="form-control" ng-model="request.txtRFQIssue" type="text" id="txtRFQIssue" name="txtRFQIssue" style="border-color: grey;margin-top: 8px;" required="true" readonly data-date-format="dd/mm/yyyy">
                             <span ng-cloak class="error-msg " ng-show="(requestForm.txtRFQIssue.$dirty || invalidSubmitAttempt) && requestForm.txtRFQIssue.$error.required"> This field is required.</span>
                          </div>
                            
                            </div>   
                            <div class="row mg-btm">
                                <div class="input-field col-sm-12" >
                                <div class="cls-design">
                            <label> Proposal Deadline </label></div>

                             <input class="form-control" ng-model="request.txtPropasaldeadline" type="text" id="txtPropasaldeadline" name="txtPropasaldeadline" style="border-color: grey;margin-top:8px;" required="true" readonly data-date-format="dd/mm/yyyy">
                             <span ng-cloak class="error-msg " ng-show="(requestForm.txtPropasaldeadline.$dirty || invalidSubmitAttempt) && requestForm.txtPropasaldeadline.$error.required"> This field is required.</span>
                          </div>
                            
                            </div>   
                             </div>


                            </div>
                              <div class="row mg-btm " style="background-color:#4591ba ">
                               
                            <h4 style="    color: white;
    font-weight: bold;
    font-size: 22px;">RFQ Documents</h4>
                            </div>
                            <div class="row mg-btm">
                               <div class="input-field col-sm-4"><div class="cls-design"> 
                              <label>Product Details</label></div>
                           
                             
                          </div>
                            
                             <div class="col-sm-8">     <textarea name="txtProdDtls" cols="77"></textarea>                   
                             </div>

                            </div>
                            <div class="row mg-btm">
                               <div class="input-field col-sm-4"><div class="cls-design"> 
                             <label> Technical Requirements</label></div>
                           
                             
                          </div>
                            
                             <div class="col-sm-8">     <textarea name="txtTechReq" cols="77"></textarea>                   
                             </div>

                            </div>
                            <div class="row mg-btm">
                               <div class="input-field col-sm-4"><div class="cls-design"> 
                              <label>Product Goals</label></div>
                          </div>
                            
                             <div class="col-sm-8">     <textarea name="proj_summary" cols="77"></textarea>                   
                             </div>

                            </div>
                            <div class="row mg-btm">
                               <div class="input-field col-sm-4"><div class="cls-design"> 
                              <label>Product Quantity</label></div>
                           
                             
                          </div>
                            
                             <div class="col-sm-8">     <textarea name="txtProdQty" ng-model="request.txtProdQty" cols="77" required="true" onkeypress="return Numeric1(event);" onpaste="return false;"></textarea>                   
                             <span ng-cloak class="error-msg " ng-show="(requestForm.txtProdQty.$dirty || invalidSubmitAttempt) && requestForm.txtProdQty.$error.required"> This field is required.</span>
                             </div>

                            </div>
                            <div class="row mg-btm">
                               <div class="input-field col-sm-4"><div class="cls-design"> 
                              <label>Delivery Requirements</label></div>
                           
                             
                          </div>
                            
                             <div class="col-sm-8">     <textarea name="txtDeliverReq" cols="77"></textarea>                   
                             </div>

                            </div>
                            <div class="row mg-btm">
                               <div class="input-field col-sm-4"><div class="cls-design"> 
                             <label> Support Requirements</label></div>
                           
                             
                          </div>
                            
                             <div class="col-sm-8">     <textarea name="txtSupportReq" cols="77"></textarea>                   
                             </div>

                            </div>
                            <div class="row mg-btm">
                               <div class="input-field col-sm-4"><div class="cls-design"> 
                              <label>Quality Assurance Requirements</label></div>
                           
                             
                          </div>
                            
                             <div class="col-sm-8">     <textarea name="txtqualityreq" cols="77"></textarea>                   
                             </div>

                            </div>
                            <div class="row mg-btm " style="background-color:#4591ba ">
                               
                            <h4 style="    color: white;
    font-weight: bold;
    font-size: 22px;">Terms and Conditions</h4>
                            </div>
                            <div class="row mg-btm">
                               <div class="input-field col-sm-4"><div class="cls-design"> 
                             <label> Legal Requirements</label></div>
                           
                             
                          </div>
                            
                             <div class="col-sm-8">     <textarea name="txtlegalreq" cols="77"></textarea>                   
                             </div>

                            </div>
                             
                            <div class="row mg-btm">
                               <div class="input-field col-sm-4"><div class="cls-design"> 
                             <label>Terms And Conditions</label></div>
                           
                             
                          </div>
                            
                             <div class="col-sm-8">     <textarea name="txtTermsCond" cols="77"></textarea>                   
                             </div>

                            </div>
                            <div class="row mg-btm">
                               <div class="input-field col-sm-4"><div class="cls-design"> 
                              <label>Approximate Price Per Unit</label></div>
                          </div>
                             <div class="col-sm-8">     <textarea name="txtPriceUnit" cols="77" onkeypress="return Numeric(event);" onpaste="return false;"> </textarea>                   
                             </div>
                            </div>
                             <div class="row mg-btm mg-btm">
                                      
                                            <div class="input-field col-sm-4"><div class="cls-design"> 
                             <label> File (Press CTRL for selecting multiple file)</label></div>
                          </div> <div class="col-sm-8">
                                            <input type="file" id="uploadFile" name="uploadFile[]" multiple="multiple">
                                          </div>
                                        
                                        
                                    </div>
                              <div class="row">
                                        <div class="col-sm-12 ">
                                            <br>
                                            <button   class="flat cls-design1" ng-disabled="isDisabled" type="submit" id="saveData"  name="action" ng-click="checkVal(requestForm)">Save</button>
                                            <button class="  flat cls-design1 " ng-disabled="isDisabled" type="submit" id="saveData" ng-click="formcancel()" name="action" >Cancel</button>
                                            
                                        </div>
                                    </div>
                            </form>
                        </div>
                    </div><!--/form-wrapper-->


                  </div><!--/content-wrapper-->
                </div><!--/s10-->
              </div><!--/row-->
            
      </div><!--/container-->
  </div><!--/main-wrapper-->
</html>


<?php require app_path().'/views/footer.php'; ?>
 
<script>

    $(document).ready(function(){
        $("#txtRFQIssue").datepicker({});  
        $("#txtPropasaldeadline").datepicker({});  
      });

    function Numeric1(e){
     if (e.which != 8 && e.which != 0 && (e.which < 47 || e.which > 57) && (e.which < 78 || e.which > 78) && (e.which < 65 || e.which > 65) ) {
        //display error message
        $("#errmsg").html("Digits Only").show().fadeOut("slow");
               return false;
    }
    }
     function Numeric(e){
     if (e.which != 8 && e.which != 0 && (e.which < 46 || e.which > 57) && (e.which < 78 || e.which > 78) && (e.which < 65 || e.which > 65) ) {
        //display error message
        $("#errmsg").html("Digits Only").show().fadeOut("slow");
               return false;
    }
    }

    
     
        </script>