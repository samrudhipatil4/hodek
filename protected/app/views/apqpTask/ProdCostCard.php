
<?php require app_path().'/views/apqp_header.php'; ?>
<style type="text/css">
 .header{  color: white;
    font-size: 16px;
    font-weight: bold;
  }
  
</style>
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
    font-family: cursive;">Product Cost Card</h1>
                      
                        </div><!--/page-heading-->    
                      </div>
                    </div>

                  <div class="content-wrapper">

                    <div class="form-wrapper" ng-controller="apqpCostCardCtrl" >
                          


                        <div class="row mg-bottom-0" >
                         
                          <form method="post" role="form"    class="col-sm-12 myform" ng-class="{'submitted': submitted}" id="requestForm" name="requestForm" novalidate ng-submit="(submitted = true) && requestForm.$invalid && $event.preventDefault()" enctype="multipart/form-data" autocomplete="off">
                  
                                   <div class="row mg-btm">
                        <div class="input-field col-sm-6">
                              <label for="initiator_name">Project</label>
                             <input type="text" class="form-control" id="project" name="project"  ng-model="request.project" style=" border-color: grey;" required="true">
                              <span ng-cloak class="error-msg " ng-show="(requestForm.project.$dirty || invalidSubmitAttempt) && requestForm.project.$error.required"> This field is required.</span>
                          </div>
                                <div class="input-field col-sm-6">
                              <label for="initiator_name">Select RFQ</label>
                              <select class="form-control" select2=""  ng-model="request.RFQId" id="RFQId" name="RFQId"  required>
                                  <option  value=""></option>
                                  <option ng-repeat="d in RFQId" value="<%d.id%>"><%d.rfq_id %> <%d.rfq_title %></option>
                              </select>
                              <span ng-cloak class="error-msg " ng-show="(requestForm.RFQId.$dirty || invalidSubmitAttempt) && requestForm.RFQId.$error.required"> This field is required.</span>
                          </div>
                                                          

                            </div>
                          <div class="row mg-btm" >
                                    <div class="col-sm-6 input-field">
                                        <label for="lesson">Batch Size(Unit)</label>
                                     <input type="text" class="form-control" name="batchSize" id="batchSize" ng-model="request.batchSize" onkeypress="return Numeric(event);" style=" border-color: grey;" required="true">
                                       
                                       <span ng-cloak class="error-msg " ng-show="(requestForm.batchSize.$dirty || invalidSubmitAttempt) && requestForm.batchSize.$error.required"> This field is required.</span>
                                        
                                    </div>
                                </div>
                                <div class="row mg-btm">
                                <table class="table" id="maintable" border="1" width="100%">  
                <thead> 
                <tr  style="background-color:#4591ba ">
                <td class="header" colspan="5" style="font-size: 17px;">Material Costs</td>
                </tr> 
                    <tr style="background-color:#4591ba "> <th class="header"  width="25%">Materials</th>
                        <th class="header" width="25%">Quantity</th>  
                        <th class="header" width="25%">Rate</th>  
                        <th class="header" width="15%">Total Cost</th> 
                        <th class="header" width="10%"></th>
                    </tr>  
                </thead>  
                         <tbody>  
                    <tr class="data-contact-person table-class-row"> 
                        <td> <input maxlength="100" type="text" name="material" class="form-control Clsmaterial border"  id="materials1"  style=" border-color: grey;" >
                        <span ng-cloak class="error-msg " ng-show="(requestForm.materials1.$dirty || invalidSubmitAttempt) && requestForm.materials1.$error.required"> This field is required.</span>
                        </td>
                <td > <input type="text" maxlength="23" name="quantity" onkeyup="calTotal(1)" onkeypress="return Numeric1(event);" class="form-control Clsquantity border"  id="quantity1"  style=" border-color: grey;"></td>
                <td> <input type="text" min="0" max="18" step="0.0039" name="rate" onkeyup="calTotal(1)" onkeypress="return Numeric1(event);" class="form-control Clsrate border"  id="rate1"  style=" border-color: grey;"></td>
                        <td> <input type="text" name="total" readonly="true" class="form-control Clstotal border"  id="mattotal1"  style=" border-color: grey;"></td>
                           <td> <button style="background-color:#4591ba " type="button" id="btnAdd" class="btn btn-xs btn-primary classAdd">Add More</button>  
                        </td>  
                    </tr>  
                </tbody>   
            </table>  
                                </div>
                         <div class="row mg-btm">
                         <div class="col-sm-6 ">
                         </div>
                          <div class="col-sm-3 ">
                         <label class="pull-right">Total</label>
                         </div> <div class="col-sm-3 ">
                         <input  class="form-control pull-right" type="text" name="tot" id="allmattot" readonly="true">
                         </div>
                         </div>

                           <div class="row mg-btm">
                                <table class="table" id="production" border="1" style="width:70%">  
                <thead> 
                <tr  style="background-color:#4591ba ">
                <td class="header" colspan="3" style="font-size: 17px;">Production Costs</td>
                </tr> 
                    <tr style="background-color:#4591ba "> <th class="header"  width="35%">Process Details</th>
                        
                        <th class="header" width="25%"> Cost</th> 
                        <th class="header" width="10%"></th>
                    </tr>  
                </thead>  
                         <tbody>  
                    <tr class="data-production-cost table-class-row"> 
                        <td> <input type="text" name="txtprocess" class="form-control Clsprocess border"  id="txtprocess1"  style=" border-color: grey;" maxlength="100">
                     
                        </td>
                
                <td> <input type="text" min="0" max="18" step="0.0039" onkeyup="calprodTotal(1)" name="txtcost"  onkeypress="return Numeric1(event);" class="form-control Clscost border"  id="txtcost1"  style=" border-color: grey;"></td>
                     
                           <td> <button style="background-color:#4591ba " type="button" id="btnAdd" class="btn btn-xs btn-primary classAddProd">Add More</button>  
                        </td>  
                    </tr>  
                </tbody>   
            </table>  
                                </div>
           <div class="row mg-btm">
            <div class="col-sm-12" style="    margin-left: 260px">
              <div class="col-sm-3 ">
             <label class="pull-right">Total</label>
             </div> <div class="col-sm-3 ">
             <input  class="form-control pull-right" type="text" name="tot" id="allprodTotal" readonly="true">
             </div>
             </div>
           </div>

           <div class="row mg-btm">
                                <table class="table" id="other" border="1" style="width:70%">  
                <thead> 
                <tr  style="background-color:#4591ba ">
                <td class="header" colspan="3" style="font-size: 17px;">Other Costs</td>
                </tr> 
                    <tr style="background-color:#4591ba "> <th class="header"  width="35%" maxlength="100">Cost Type</th>
                        
                        <th class="header" width="25%"> Cost</th> 
                        <th class="header" width="10%"></th>
                    </tr>  
                </thead>  
                         <tbody>  
                    <tr class="data-other-cost table-class-row"> 
                        <td> <input type="text" name="txtcosttype" class="form-control Clscosttype border"  id="txtcosttype"  style=" border-color: grey;" >
                     
                        </td>
                
                <td> <input type="text" min="0" max="18" step="0.0039" onkeyup="calotherTotal(1)" name="txtothercost"  onkeypress="return Numeric1(event);" class="form-control Clsothercost border"  id="txtothercost1"  style=" border-color: grey;"></td>
                     
                           <td> <button style="background-color:#4591ba " type="button" id="btnAdd" class="btn btn-xs btn-primary classAddOthercost">Add More</button>  
                        </td>  
                    </tr>  
                </tbody>   
            </table>  
                                </div>
           <div class="row mg-btm">
            <div class="col-sm-12" style="    margin-left: 260px">
             <div class="col-sm-3 ">
             <label class="pull-right">Total</label>
             </div> 
             <div class="col-sm-3 ">
             <input  class="form-control pull-right" type="text" name="tot" id="allotherTotal" readonly="true">
             </div>
             </div>
           </div>
           </br></br>
            <div class="row mg-btm">
            <div class="col-sm-6" >
            </div>
             <div class="col-sm-3 ">
             <label class="pull-right">Total Cost</label>
             </div> 
             <div class="col-sm-3 ">
             <input  class="form-control pull-right" type="text" name="tot" id="txttotalCost" readonly="true">
             </div>
             
           </div>
            <div class="row">
                <div class="col-sm-12 ">
                    <br>
                    <button id="btnSave" class="btn btn-animate flat blue pd-btn" ng-disabled="isDisabled" type="submit" name="action" ng-click="saveRFQClose(requestForm)" >Save</button>
                    
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



<?php require app_path().'/views/footer.php'; ?>
 
<script type="text/javascript">
  var base_url='<?php echo Request::root(); ?>/';
  $(document).ready(function () {
         $("#errorCategory").hide();

         $(document).on("click", ".classAdd", function () { 

            var material =  $("#materials1").val();
             var qty = $("#quantity1").val();
             var rate = $("#rate1").val();
             
             
         if (material == "") {
             //  ValidatorEnable(ContentSection_RequiredFieldValidator1, true);
             $.simplyToast('Enter material','warning');
             return false;
         }
             if (qty== "") {
                $.simplyToast('Enter quantity','warning');
             return false;
         }
             if (rate == "") {
             $.simplyToast('Enter rate','warning');
           //ValidatorEnable(ContentSection_RequiredFieldKaizen, true);
             return false;
             }
             
         
         var rowCount = $('.data-contact-person').length + 1;  

            if (rowCount > 2) {
                cnt = rowCount - 1;
                if ($("#materials" + cnt).val() == 0) {
                    // $("#errorCompetition").show();
                    $.simplyToast('Enter material','warning');
                    return false;
                }
                if ($("#quantity" + cnt).val() == 0) {
                    //$("#errorCategory").show();
                   $.simplyToast('Enter quantity','warning');
                    return false;
                }
                if ($("#rate" + cnt).val() == 0) {
                   // $("#errorCategory").hide();
                   //$("#errorKaizen").show();
                    $.simplyToast('Enter rate','warning');
                     return false;
                }
                
               
                
              }
                
              var material = '<input type="text" name="material" class="form-control Clsmaterial"  id="materials'+ rowCount +'"  style=" border-color: grey;" >';
              
             var qty  = '<input type="text" name="quantity"  class="form-control Clsquantity"  id="quantity'+ rowCount +'"  onkeyup="calTotal('+rowCount+')" onkeypress="return Numeric1(event);" style=" border-color: grey;">';
               
              var rate = '<input type="text" name="rate" class="form-control Clsrate"  id="rate'+ rowCount +'"  onkeyup="calTotal('+rowCount+')" onkeypress="return Numeric1(event);" style=" border-color: grey;" >';
             var total = '<input type="text" readonly="true" name="total" class="form-control Clstotal"  id="mattotal'+ rowCount +'"   style=" border-color: grey;">';
            
             var contactdiv = '<tr class="data-contact-person">' +  
                  '<td>' + material + '</td > ' +
                 '<td>' + qty + '</td > ' +
                 '<td>' + rate + '</td>' +
                 '<td>' + total + '</td > ' +
                 
                '<td>' +  
                '<button type="button"  id="btnDelete" class="deleteContact btn btn btn-danger btn-xs">Remove</button></td>' +  
                '</tr>';  
             $('#maintable').append(contactdiv); // Adding these controls to Main table class
             
         });

     $(document).on("click", ".deleteContact", function () {  
            $(this).closest("tr").remove(); 

            var allmattot=0;
       var materialtot=0;
      var tot1=0;
     $('tr.data-contact-person').each(function () {    
         tot1 = parseFloat($(this).find('.Clstotal').val());  
        allmattot = parseFloat(allmattot)+tot1;
           
      });
      materialtot = allmattot;
    $("#allmattot").val(materialtot.toFixed(4));
    calculateTotalCost();
    });
          
    });


   $(document).on("click", ".classAddProd", function () { 

            var Process =  $("#txtprocess1").val();
             var cost = $("#txtcost1").val();
             
             
         if (Process == "") {
             //  ValidatorEnable(ContentSection_RequiredFieldValidator1, true);
             $.simplyToast('Enter process','warning');
             return false;
         }
             if (cost== "") {
               $.simplyToast('Enter cost','warning');
             return false;
         }
            
             
         
         var rowCount = $('.data-production-cost').length + 1;  

            if (rowCount > 2) {
                cnt = rowCount - 1;
                if ($("#txtprocess" + cnt).val() == 0) {
                    // $("#errorCompetition").show();
                   $.simplyToast('Enter process','warning');
                    return false;
                }
                if ($("#txtcost" + cnt).val() == 0) {
                    //$("#errorCategory").show();
                    $.simplyToast('Enter cost','warning');
                    return false;
              }
                
          }

             
              var Process = '<input type="text" name="txtprocess" class="form-control Clsprocess"  id="txtprocess'+ rowCount +'"  style=" border-color: grey;" >';
              var cost = '<input type="text" name="txtcost" class="form-control Clscost"  id="txtcost'+ rowCount +'"  onkeyup="calprodTotal('+rowCount+')" onkeypress="return Numeric1(event);" style=" border-color: grey;" >';
            
             var contactdiv = '<tr class="data-production-cost">' +  
                  '<td>' + Process + '</td > ' +
                 '<td>' + cost + '</td > ' +
                
                 
                '<td>' +  
                '<button type="button"  id="btnDelete" class="deleteProduction btn btn btn-danger btn-xs">Remove</button></td>' +  
                '</tr>';  
             $('#production').append(contactdiv); // Adding these controls to Main table class
             
         });

     $(document).on("click", ".deleteProduction", function () {  
            $(this).closest("tr").remove(); 
 var allprodtot = 0;
            var productiontot=0;
   var tot1=0;
     $('tr.data-production-cost').each(function () {    
         tot1 = parseFloat($(this).find('.Clscost').val());  
        allprodtot = parseFloat(allprodtot)+tot1;
           
    });
      productiontot = allprodtot;
    
    $("#allprodTotal").val(productiontot.toFixed(4));
       calculateTotalCost();
    });

     $(document).on("click", ".classAddOthercost", function () { 

            var type =  $("#txtcosttype").val();
             var cost = $("#txtothercost1").val();
             
             
         if (type == "") {
             //  ValidatorEnable(ContentSection_RequiredFieldValidator1, true);
            $.simplyToast('Enter cost type','warning');
             return false;
         }
             if (cost== "") {
                $.simplyToast('Enter cost','warning');
             return false;
         }
            
             
         
         var rowCount = $('.data-other-cost').length + 1;  

            if (rowCount > 2) {
                cnt = rowCount - 1;
                if ($("#txtothercost" + cnt).val() == 0) {
                    // $("#errorCompetition").show();
                    $.simplyToast('Enter process,','warning');
                    return false;
                }
                if ($("#txtothercost" + cnt).val() == 0) {
                    //$("#errorCategory").show();
                   $.simplyToast('Enter cost','warning');
                    return false;
              
                 
              }
                
          }

             
              var Process = '<input type="text" name="txtcosttype" class="form-control Clscosttype"  id="txtcosttype'+ rowCount +'"  style=" border-color: grey;" >';
              var cost = '<input type="text" name="txtothercost" class="form-control Clsothercost"  id="txtothercost'+ rowCount +'"  onkeyup="calotherTotal('+rowCount+')" onkeypress="return Numeric1(event);" style=" border-color: grey;" >';
            
             var contactdiv = '<tr class="data-other-cost">' +  
                  '<td>' + Process + '</td > ' +
                 '<td>' + cost + '</td > ' +
                '<td>' +  
                '<button type="button"  id="btnDelete" class="deleteOtherCost btn btn btn-danger btn-xs">Remove</button></td>' +  
                '</tr>';  
             $('#other').append(contactdiv); // Adding these controls to Main table class
             
         });

     $(document).on("click", ".deleteOtherCost", function () {  
            $(this).closest("tr").remove(); 
 var allothertot = 0;
            var othertot=0;
   var tot1=0;
     $('tr.data-other-cost').each(function () {    
         tot1 = parseFloat($(this).find('.Clsothercost').val());  
        allothertot = parseFloat(allothertot)+tot1;
           
    });
      othertot = allothertot;
    
    $("#allotherTotal").val(othertot.toFixed(4));
    calculateTotalCost();
            // closest used to remove the respective 'tr' in which I have my controls   
    });
          
   function calprodTotal(row){
    var allprodtot = 0;
    var productiontot=0;
   var tot1=0;
     $('tr.data-production-cost').each(function () {    
         tot1 = parseFloat($(this).find('.Clscost').val());  
       if(!isNaN(tot1)){
       allprodtot = parseFloat(allprodtot)+tot1;
     }
           
    });
      productiontot = allprodtot;
    
    $("#allprodTotal").val(productiontot.toFixed(4));
    calculateTotalCost();
   }
    function calotherTotal(row){
   var allothertot = 0;
            var othertot=0;
   var tot1=0;
     $('tr.data-other-cost').each(function () {    
         tot1 = parseFloat($(this).find('.Clsothercost').val());if(!isNaN(tot1)){
             allothertot = parseFloat(allothertot)+tot1;
         }
       
           
    });
      othertot = allothertot;
    
    $("#allotherTotal").val(othertot.toFixed(4));
    calculateTotalCost();
   }

  function calTotal(row) {
    var qty = $("#quantity"+row).val();
    var rate = $("#rate"+row).val();

    if(qty != "" && rate != ""){
      var tot = qty*rate;
    }else if(qty != "" && rate == ""){
      var tot = qty*0;
    }else{
      var tot=0;
    }
    $("#mattotal"+row).val(tot.toFixed(4));
   
    var allmattot=0;
   var materialtot=0;
   var tot1=0;
     $('tr.data-contact-person').each(function () {    
         tot1 = parseFloat($(this).find('.Clstotal').val());  
        allmattot = parseFloat(allmattot)+tot1;
           
    });
      materialtot = allmattot;
    
    $("#allmattot").val(materialtot.toFixed(4));
    calculateTotalCost();
   }

   function Numeric1(e){
     if (e.which != 8 && e.which != 0 && (e.which < 46 || e.which > 57) && (e.which < 78 || e.which > 78) && (e.which < 65 || e.which > 65) ) {
        //display error message
        $("#errmsg").html("Digits Only").show().fadeOut("slow");
               return false;
             }
    }
    function Numeric(e){
     if (e.which != 8 && e.which != 0 && (e.which < 47 || e.which > 57) && (e.which < 78 || e.which > 78) && (e.which < 65 || e.which > 65) ) {
        //display error message
        $("#errmsg").html("Digits Only").show().fadeOut("slow");
               return false;
             }
    }
    function calculateTotalCost(){
      var tot1=0;
      var tot2=0;
      var tot3=0;
      var allmattot=0;
      var allothertot=0;
      var allprodtot=0;
      var totalcost=0;
       $('tr.data-contact-person').each(function () {    
         tot1 = parseFloat($(this).find('.Clstotal').val());  
        allmattot = parseFloat(allmattot)+tot1;
           
    });
       $('tr.data-other-cost').each(function () {    
         tot2 = parseFloat($(this).find('.Clsothercost').val());  
        allothertot = parseFloat(allothertot)+tot2;
           
      });

        $('tr.data-production-cost').each(function () {    
         tot3 = parseFloat($(this).find('.Clscost').val());  
        allprodtot = parseFloat(allprodtot)+tot3;
         
    });
        if(isNaN(allmattot)){
          allmattot = parseFloat(0);
        }
        if(isNaN(allothertot)){
          allothertot = parseFloat(0);
        }
        if(isNaN(allprodtot)){
          allprodtot = parseFloat(0);
        }
        totalcost= allmattot+ allothertot+allprodtot;
        
        $("#txttotalCost").val(totalcost.toFixed(4));
        //document.getElementById('totalcost').value=totalcost.toFixed(4);
       // $('#totalcost').attr('value', totalcost.toFixed(4));
    }

    $("#btnSave").click(function(){
      var check = $("#requestForm")[0].checkValidity();
       var materialcost = [];
        var productioncost = [];
        var othercostdet = [];
        var costdetails=[];
      if(check == true){
        if($("#materials1").val()==""){
           $.simplyToast('Enter material','warning');
        }else if($("#quantity1").val()==""){
           $.simplyToast('Enter quantity','warning');
        }else if($("#rate1").val()==""){
           $.simplyToast('Enter quantity','warning');
        }else if($("#txtprocess1").val()==""){
           $.simplyToast('Enter process','warning');
        }else if($("#txtcost1").val()==""){
           $.simplyToast('Enter production cost','warning');
        }else if($("#txtcosttype").val()==""){
           $.simplyToast('Enter other cost type','warning');
        }else if($("#txtothercost1").val()==""){
           $.simplyToast('Enter other cost','warning');
        }else{
           $('tr.data-contact-person').each(function () {    
        var material = $(this).find('.Clsmaterial').val();
        var quantity = $(this).find('.Clsquantity').val();
        var rate = $(this).find('.Clsrate').val();
        var total = $(this).find('.Clstotal').val();
       
        if (material == "") {
           $.simplyToast('Enter material','warning');
           return false;
        }else if(quantity ==""){
         $.simplyToast('Enter quantity','warning');
         return false;
        }else if(rate ==""){
         $.simplyToast('Enter rate','warning');
         return false;
        }
       
        var alldata = {    
            'material': material,
            'quantity': quantity,
            'rate': rate,
            'total': total,
        }    
        materialcost.push(alldata);   
        });

    $('tr.data-production-cost').each(function () {    
        var Process = $(this).find('.Clsprocess').val();
        var cost = $(this).find('.Clscost').val();
        if (Process == "") {
           $.simplyToast('Enter Process','warning');
           return false;
        }else if(cost ==""){
         $.simplyToast('Enter production cost','warning');
         return false;
        }
        var proddata = {    
            'Process': Process,
            'cost': cost,
        }    
        productioncost.push(proddata);   
        });

    $('tr.data-other-cost').each(function () {    
        var costtype= $(this).find('.Clscosttype').val();
        var othercost = $(this).find('.Clsothercost').val();
        if (costtype == "") {
           $.simplyToast('Enter cost type','warning');
           return false;
        }else if(othercost ==""){
         $.simplyToast('Enter other cost','warning');
         return false;
        }
        var otherdata = {    
            'costtype': costtype,
            'othercost': othercost,
           
        }    
        othercostdet.push(otherdata);   
        });

    var proj = $("#project").val();
    var rfq = $("#RFQId").val();
    var batch = $("#batchSize").val();
    var totalcost = $("#txttotalCost").val();
    var mattot = $("#allmattot").val();
    var prodtot = $("#allprodTotal").val();
    var othertot = $("#allotherTotal").val();
    var costdata = {    
            'project': proj,
            'rfq': rfq,
            'batch':batch,
            'totalcost':totalcost,
            'mattot':mattot,
            'prodtot':prodtot,
            'othertot':othertot,

        }    
        costdetails.push(costdata); 

            $.ajax({
                   url:base_url+'saveRFQCost',
                    type: 'POST',
                    data:{materialcost:materialcost,productioncost:productioncost,othercost:othercostdet,costdetails:costdetails},
                     beforeSend: function(){
                    $("#fade").show();
                },
                    success: function (data) {
                      $("#fade").hide();
                     
                      $.simplyToast('Saved successfully','success');
                        window.location.href = base_url+"apqp_dashboard";
                      }
               });
      }

    }
    });
    
  
</script>