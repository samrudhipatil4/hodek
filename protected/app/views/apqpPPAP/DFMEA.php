
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
    font-family: cursive;">Design Failure Mode and Effects Analysis</h1>
                      
                        </div><!--/page-heading-->    
                      </div>
                    </div>

                  <div class="content-wrapper">

                    <div class="form-wrapper" ng-controller="apqpDFMEACtrl" >
                          


                        <div class="row mg-bottom-0" >
                         
                          <form method="post" role="form"    class="col-sm-12 myform" ng-class="{'submitted': submitted}" id="requestForm" name="requestForm" novalidate ng-submit="(submitted = true) && requestForm.$invalid && $event.preventDefault()" enctype="multipart/form-data" autocomplete="off">
                  
                                   <div class="row mg-btm">
                                   <div class="input-field col-sm-6">
                              <label for="initiator_name">Project</label>
                              <select class="form-control" select2=""  ng-model="request.project" id="project" name="project"  required>
                                  <option  value=""></option>
                                  <option ng-repeat="d in RFQId" value="<%d.id%>"><%d.project_no %> </option>
                              </select>
                              <span ng-cloak class="error-msg " ng-show="(requestForm.project.$dirty || invalidSubmitAttempt) && requestForm.project.$error.required"> This field is required.</span>
                          </div>
                        <div class="input-field col-sm-6">
                              <label for="initiator_name">Part Name and Number</label>
                             <input type="text" class="form-control" id="txtpart" name="txtpart"  ng-model="request.txtpart" style=" border-color: grey;" required="true">
                              <span ng-cloak class="error-msg " ng-show="(requestForm.txtpart.$dirty || invalidSubmitAttempt) && requestForm.txtpart.$error.required"> This field is required.</span>
                          </div>
                                
                                                          

                            </div>
                          <div class="row mg-btm" >
                                    <div class="col-sm-6 input-field">
                                        <label for="lesson">DFMEA Number</label>
                                     <input type="text" class="form-control" name="DFMEANum" id="DFMEANum" ng-model="request.DFMEANum" onkeypress="return Numeric(event);" style=" border-color: grey;" required="true">
                                       
                                       <span ng-cloak class="error-msg " ng-show="(requestForm.DFMEANum.$dirty || invalidSubmitAttempt) && requestForm.DFMEANum.$error.required"> This field is required.</span>
                                        
                                    </div>
                                
                                 
                                    <div class="col-sm-6 input-field">
                                        <label for="lesson">DFMEA Date</label>
                                     <input type="text" class="form-control" name="DFMEADate" id="DFMEADate" ng-model="request.DFMEADate" readonly="true" style=" border-color: grey;" required="true" data-date-format="dd/mm/yyyy">
                                       
                                       <span ng-cloak class="error-msg " ng-show="(requestForm.DFMEADate.$dirty || invalidSubmitAttempt) && requestForm.DFMEADate.$error.required"> This field is required.</span>
                                        
                                   
                                </div>
                                </div>
                                <div class="row mg-btm" style="overflow-x: scroll;">
                                <table class="table" id="maintable" border="1" width="100%" >  
                <thead> 
               
                    <tr style="background-color:#4591ba "> 
                        <th class="header" width="25%">Item/Function</th>  
                        <th class="header" width="25%">Requirements</th>  
                        <th class="header" width="15%">Potential Failure Mode</th> 
                        <th class="header" width="15%">Potential Effects of Failure</th> 
                        <th class="header" width="15%">Severity</th> 
                        <th class="header" width="15%">Classification</th> 
                        <th class="header" width="15%">Potential Causes</th> 
                        <th class="header" width="15%">Current Design Controls Prevention</th> 
                        <th class="header" width="15%">Occurance</th> 
                        <th class="header" width="15%">Current Design Controls Detection</th> 
                        <th class="header" width="15%">Detection ranking</th> 
                        <th class="header" width="15%">Risk Priority Number</th> 
                        <th class="header" width="15%">Recommended Action</th> 
                        <th class="header" width="25%">Responsibility and Target Completion Date</th> 
                        <th class="header" width="15%">Action Results</th> 
                        <th class="header" width="10%"></th>
                    </tr>  
                </thead>  
                         <tbody>  
                    <tr class="data-contact-person table-class-row"> 
                        <td>
                         <textarea class="Clsitem" name="txtitem" id="txtitem1" rows="4"> </textarea>
                        </td>
                      <td > <textarea class="Clsrequirements" name="txtrequirements" id="txtrequirements1" rows="4"></textarea></td>
                      <td> <textarea class="Clsfailuremode" name="txtfailuremode" id="txtfailuremode1" rows="4"></textarea></td>
                        <td> <textarea class="Clseffectsoffailure" name="txteffectsoffailure" id="txteffectsoffailure1" rows="4"></textarea></td>
                        <td><input type="text" class="Clsseverity" name="txtseverity" id="txtseverity1" rows="2" onkeypress="return Numeric(event);" style="border-color: grey;"></td>
                        <td> <textarea class="Clsclassification" name="txtclassification" id="txtclassification1" rows="4"></textarea></td>
                        <td> <textarea class="Clspotcauses" name="txtpotcauses" id="txtpotcauses1" rows="4"></textarea></td>
                        <td> <textarea class="Clsctrlprevention" name="txtctrlprevention" id="txtctrlprevention1" rows="4"></textarea></td>
                        <td> <textarea class="Clsoccurance" name="txtoccurance" id="txtoccurance1" rows="4"></textarea></td>
                        <td> <textarea class="Clsctrldetection" name="txtctrldetection" id="txtctrldetection" rows="4"></textarea></td>
                        <td> <input type="text" class="Clsdetectionrank" name="txtdetectionrank" id="txtdetectionrank1" rows="2" onkeypress="return Numeric(event);" style="border-color: grey;"></td>
                        <td> <input type="text" class="Clsriskpriortyno" name="txtriskpriortyno" id="txtriskpriortyno1" rows="2" onkeypress="return Numeric(event);" style="border-color: grey;"></td>
                        <td> <textarea class="Clsrecommaction" name="txtrecommaction" id="txtrecommaction1" rows="4"></textarea></td>
                        <td> <select style="width:200px" class="form-control select2 Clsresp" name="txtresp" id="txtresp1" rows="4"></select>
                                  <br> <input type="text" class="form-control ClstargetDate" name="txttargetDate"  id="txttargetDate1"  readonly data-date-format="dd/mm/yyyy" />
                        </td>
                        <td> <textarea class="Clsactionresult" name="txtactionresult" id="txtactionresult1" rows="4"></textarea></td>
                           <td> <button style="background-color:#4591ba " type="button" id="btnAdd" class="btn btn-xs btn-primary classAdd">Add More</button>  
                        </td>  
                    </tr>  
                </tbody>   
            </table>  
                                </div>
                         

                           
           

          
           
            <div class="row">
                <div class="col-sm-12 ">
                    <br>
                    <button id="btnSave" class="btn btn-animate flat blue pd-btn" ng-disabled="isDisabled" type="submit" name="action" ng-click="checkValidation(requestForm)" >Save</button>
                    
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



<?php require app_path().'/views/apqp_footer.php'; ?>
 
<script type="text/javascript">
$("#txttargetDate1").datepicker({});
$("#DFMEADate").datepicker({});  
  var base_url='<?php echo Request::root(); ?>/';
  function getUser(rowid){
  $.ajax({
           url:base_url+'getResUSer',
            type: 'POST',
            data:{},
            success: function (data) {
             
              $('#txtresp'+rowid).html(data);
              $("#txttargetDate"+rowid).datepicker({});  
          }
                });
}
  $(document).ready(function () {
getUser(1);
    
         $("#errorCategory").hide();

         $(document).on("click", ".classAdd", function () { 

            var item =  $("#txtitem1").val();
              var failuremode = $("#txtfailuremode1").val();
            var failureeffect = $("#txteffectsoffailure1").val();
            var resp = $("#txtresp1").val();
            var targetdate = $("#txttargetDate1").val();
             
         if (item.trim() == "") {
             //  ValidatorEnable(ContentSection_RequiredFieldValidator1, true);
             $.simplyToast('Enter item/function','warning');
             return false;
         }
             if (failuremode.trim()== "") {
                $.simplyToast('Enter failure mode','warning');
             return false;
         }
         if (failureeffect == 0 || failureeffect==undefined) {
                    //$("#errorCategory").show();
                   $.simplyToast('Enter effects of failure','warning');
                    return false;
          }
             if (resp.trim() == "") {
             $.simplyToast('select responsibility','warning');
           //ValidatorEnable(ContentSection_RequiredFieldKaizen, true);
             return false;
             }
             if (targetdate == "") {
             $.simplyToast('select target date','warning');
           //ValidatorEnable(ContentSection_RequiredFieldKaizen, true);
             return false;
             }
         
         var rowCount = $('.data-contact-person').length + 1;  

            if (rowCount > 2) {
                cnt = rowCount - 1;
               
                var item1 = $("#txtitem"+cnt).val();
               var failuremode =  $("#txtfailuremode" + cnt).val();
               var failureeffect = $("#txteffectsoffailure"+cnt).val();
               var resp = $("#txtresp"+cnt).val();
               var targetdate = $("#txttargetDate"+cnt).val();
                if (item1 == "" || item1==undefined) {
                    // $("#errorCompetition").show();
                    $.simplyToast('Enter item/function','warning');
                    return false;
                }
                if (failuremode == 0 || failuremode==undefined) {
                    //$("#errorCategory").show();
                   $.simplyToast('Enter failure mode','warning');
                    return false;
                }
                 if (failureeffect == 0 || failureeffect==undefined) {
                    //$("#errorCategory").show();
                   $.simplyToast('Enter effects of failure','warning');
                    return false;
                }
               if (resp.trim() == "") {
                 $.simplyToast('select responsibility','warning');
               //ValidatorEnable(ContentSection_RequiredFieldKaizen, true);
                 return false;
                 }
                 if (targetdate == "") {
                 $.simplyToast('select target date','warning');
               //ValidatorEnable(ContentSection_RequiredFieldKaizen, true);
                 return false;
                 }
                
               
                
              }
                
              var item = ' <textarea class="Clsitem" name="txtitem" id="txtitem'+ rowCount +'" rows="4"></textarea>';
              
             var requirement  = '  <textarea class="Clsrequirements" name="txtrequirements" id="txtrequirements'+ rowCount +'" rows="4"></textarea>';
               
              var failuremode = '<textarea class="Clsfailuremode" name="txtfailuremode" id="txtfailuremode'+ rowCount +'" rows="4"></textarea>';
              var failureeffect =' <textarea class="Clseffectsoffailure" name="txteffectsoffailure" id="txteffectsoffailure'+ rowCount +'" rows="4"></textarea>';
             var severity = '<input type="text" class="Clsseverity" name="txtseverity" id="txtseverity'+ rowCount +'" rows="2" onkeypress="return Numeric(event);" style="border-color: grey;">';
             var classification = ' <textarea class="Clsclassification" name="txtclassification" id="txtclassification'+ rowCount +'" rows="4"></textarea>';
             var potCauses = '<textarea class="Clspotcauses" name="txtpotcauses" id="txtpotcauses'+ rowCount +'" rows="4"></textarea>';
             var ctrlPrev = '<textarea class="Clsctrlprevention" name="txtctrlprevention" id="txtctrlprevention'+ rowCount +'" rows="4"></textarea>';
             var occurance = ' <textarea class="Clsoccurance" name="txtoccurance" id="txtoccurance'+ rowCount +'" rows="4"></textarea>';
             var ctrlDetect = ' <textarea class="Clsctrldetection" name="txtctrldetection" id="txtctrldetection'+ rowCount +'" rows="4"></textarea>';
             var detectionrank = ' <input type="text" class="Clsdetectionrank" name="txtdetectionrank" id="txtdetectionrank'+ rowCount +'" rows="2" onkeypress="return Numeric(event);" style="border-color: grey;">';
             var riskprorityno = ' <input type="text" class="Clsriskpriortyno" name="txtriskpriortyno" id="txtriskpriortyno'+ rowCount +'" rows="2" onkeypress="return Numeric(event);" style="border-color: grey;">';
             var recommendedaction=' <textarea class="Clsrecommaction" name="txtrecommaction" id="txtrecommaction'+ rowCount +'" rows="4"></textarea>';
             var responsibility = ' <select style="width:200px" class="form-control select2 Clsresp" name="txtresp" id="txtresp'+ rowCount +'" rows="4"></select> <br> <input type="text" class="form-control ClstargetDate" name="txttargetDate"  id="txttargetDate'+ rowCount +'"  readonly data-date-format="dd/mm/yyyy" />';
             var actionresult = ' <textarea class="Clsactionresult" name="txtactionresult" id="txtactionresult'+ rowCount +'" rows="4"></textarea>';


            
             var contactdiv = '<tr class="data-contact-person">' +  
                  '<td>' + item + '</td > ' +
                 '<td>' + requirement + '</td > ' +
                 '<td>' + failuremode + '</td>' +
                   '<td>' + failureeffect + '</td>' +
                 '<td>' + severity + '</td > ' +
                 '<td>' + classification + '</td > ' +
                 '<td>' + potCauses + '</td > ' +
                 '<td>' + ctrlPrev + '</td > ' +
                 '<td>' + occurance + '</td > ' +
                 '<td>' + ctrlDetect + '</td > ' +
                 '<td>' + detectionrank + '</td > ' +
                 '<td>' + riskprorityno + '</td > ' +
                  '<td>' + recommendedaction + '</td > ' +
                 '<td>' + responsibility + '</td > ' +
                 '<td>' + actionresult + '</td > ' +
                '<td>' +  
                '<button type="button"  id="btnDelete" class="deleteContact btn btn btn-danger btn-xs">Remove</button></td>' +  
                '</tr>';  
             $('#maintable').append(contactdiv); // Adding these controls to Main table class
              getUser(rowCount);
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
    
    });
          
    });


   

     


     
          
  

 

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
   

    $("#btnSave").click(function(e){
      var check = $("#requestForm")[0].checkValidity();
       
        var DFMEAmain = [];
         var DFMEAdet = [];
       
      if(check == true){

         var item1 = $("#txtitem1").val();
         var failuremode =  $("#txtfailuremode1").val();
         var failureeffect = $("#txteffectsoffailure1").val();
         var resp = $("#txtresp1").val();
        var targetdate = $("#txttargetDate1").val();
        
                if (item1.trim() == "" || item1==undefined) {
                    $.simplyToast('Enter item/function','warning');
                    return false;
                }else if (failuremode == 0 || failuremode==undefined) {
                   $.simplyToast('Enter failure mode','warning');
                    return false;
                }else if (failureeffect == 0 || failureeffect==undefined) {
                   $.simplyToast('Enter effects of failure','warning');
                    return false;
                }else if (resp.trim() == "") {
                 $.simplyToast('select responsibility','warning');
                 return false;
                }else if (targetdate == "") {
                 $.simplyToast('select target date','warning');
               //ValidatorEnable(ContentSection_RequiredFieldKaizen, true);
                 return false;
                }else{
                  var f=0;
           $('tr.data-contact-person').each(function () { 
             var item1 = $(this).find('.Clsitem').val();
         var failuremode =  $(this).find('.Clsfailuremode').val();
         var failureeffect = $(this).find('.Clseffectsoffailure').val();
         var resp = $(this).find('.Clsresp').val();
        var targetdate = $(this).find('.ClstargetDate').val();
        var requirements = $(this).find('.Clsrequirements').val();
        var severity = $(this).find('.Clsseverity').val();
        var classification = $(this).find('.Clsclassification').val();
        var potcauses = $(this).find('.Clspotcauses').val();
        var ctrlprevention = $(this).find('.Clsctrlprevention').val();
        var ctrldetection = $(this).find('.Clsctrldetection').val();
         var occurance = $(this).find('.Clsoccurance').val();
        var detectionrank = $(this).find('.Clsdetectionrank').val();
        var riskpriortyno = $(this).find('.Clsriskpriortyno').val();
        var recommaction = $(this).find('.Clsrecommaction').val();
        var actionresult = $(this).find('.Clsactionresult').val();
       
         if (item1.trim() == "" || item1==undefined) {
                    f=1;
                    $.simplyToast('Enter item/function','warning');

                    return false;
        }else if (failuremode.trim() == "" || failuremode==undefined) {
           f=1;
           $.simplyToast('Enter failure mode','warning');
           
            return false;
        }else if (failureeffect.trim() == "" || failureeffect==undefined) {
          f=1;
           $.simplyToast('Enter effects of failure','warning');
            return false;
        }else if (resp.trim() == "") {
        f=1;
         $.simplyToast('select responsibility','warning');
         return false;
        }else if (targetdate.trim() == "") {
        f=1;
         $.simplyToast('select target date','warning');
       //ValidatorEnable(ContentSection_RequiredFieldKaizen, true);
         return false;
        }
       
        var alldata1 = {    
            'item': item1,
            'failuremode': failuremode,
            'failureeffect': failureeffect,
            'resp': resp,
            'targetdate':targetdate,
            'requirements':requirements,
            'severity':severity,
            'classification':classification,
            'potcauses':potcauses,
            'ctrlprevention':ctrlprevention,
            'ctrldetection':ctrldetection,
            'occurance':occurance,
            'detectionrank':detectionrank,
            'riskpriortyno':riskpriortyno,
            'recommaction':recommaction,
            'actionresult':actionresult



        }    
        DFMEAdet.push(alldata1);   
        });

   

   
    var project = $("#project").val();
    var txtpart = $("#txtpart").val();
    var DFMEANum = $("#DFMEANum").val();
    var DFMEADate = $("#DFMEADate").val();
   
    var alldata = {    
            'project': project,
            'txtpart': txtpart,
            'DFMEANum':DFMEANum,
            'DFMEADate':DFMEADate,
            
        }    
        DFMEAmain.push(alldata); 
        if(f==0){
          $("#btnSave").attr("disabled", true);
            $.ajax({
                   url:base_url+'saveDFMEADet',
                    type: 'POST',
                    data:{DFMEAmain:DFMEAmain,DFMEAdet:DFMEAdet},
                     beforeSend: function(){
                    $("#fade").show();
                },
                    success: function (data) {
                      if(data == 1062){
                        $.simplyToast('Duplicate DFMEA Number','warning');
                        $("#btnSave").attr("disabled", false);
                      }else{
                      $.simplyToast('Saved successfully','success');
                        window.location.href = base_url+"apqp_dashboard";
                      }
                      }
               });
          }
      }

    }
    });
    
  
</script>
