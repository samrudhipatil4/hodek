</!DOCTYPE html>
<html>
<head>

	{{-- Check if session has 'uid' and log it --}}
@if (Session::has('uid'))
{{-- Output the user ID --}}
<script>
	console.log("User ID: {{ Session::get('uid') }}");
</script>
@else
{{-- Output a message if 'uid' is not in the session --}}
<script>
	console.log("No user ID found in the session.");
</script>
@endif
 
<style type="text/css">
	
table, th, td {
    
     padding: 5px 3px 5px 8px;
     font-size: 15px;
    
}
</style>
</head>
<body>
  <div class="page-content row">
    <!-- Page header -->
    <div class="page-header">
      <div class="page-title">
        <h3> {{ $pageTitle }} <small>{{ $pageNote }}</small></h3>
      </div>
      <ul class="breadcrumb">
        <li><a href="{{ URL::to('dashboard_admin') }}">{{ Lang::get('core.home') }}</a></li>
		<li><a href="{{ URL::to('changestage?md='.$filtermd) }}">{{ $pageTitle }}</a></li>
        <li class="active">{{ Lang::get('core.addedit') }} </li>
      </ul>
	  	  
    </div>
 
 	<div class="page-content-wrapper">

		<!-- <ul class="parsley-error-list">
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul> -->
<div class="sbox animated fadeInRight">
	<div class="sbox-title"> <h4> <i class="fa fa-table"></i> <?php echo $pageTitle ;?> <small>{{ $pageNote }}</small></h4></div>
	<div class="sbox-content"> 	

		 {{ Form::open(array('url'=>'draftProjectPlan/create'.'?md='.$filtermd.$trackUri, 'class'=>'form-horizontal','id' => 'proj_master')) }}
<div class="col-md-12">
						<fieldset><legend> Draft Project Plan</legend>
									
								  <div class="form-group hidethis " style="display:none;">
									<label for="Change Stage Id" class=" control-label col-md-2 text-left"> Change Stage Id </label>
									<div class="col-md-6">
									  {{ Form::text('id', $row['id'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 					
								  <div class="form-group  " >
									<label for="Stage Name" class=" control-label col-md-2 text-left"> Project Number<span class="asterix"> * </span></label>
									<div class="col-md-3">
									
									<select name='proj_no' id="proj_no" rows='5'  value="" 
							class='select2 '    ></select> 
									 </div> 
									  <label for="Stage Name" class=" control-label col-md-2 text-left"> Project Name <span class="asterix"> * </span></label>
									 <div class="col-md-3">
									<input type="hidden" name="proj_name1" id="proj_name1" >
									<input type="hidden" name="proj_no1" id="proj_no1" >
									 	<input type="text" name="proj_name" id="proj_name" class="form-control" > 
									 </div>
								  </div>
								   <div class="form-group  " >
									<label for="Stage Name" class=" control-label col-md-2 text-left"> manufacturing location <span class="asterix"> * </span></label>
									<div class="col-md-3">
									<input type="text" name="mfg_loc" id="mfg_loc" class="form-control" > 
									 </div> 
									  <label for="Stage Name" class=" control-label col-md-2 text-left"> Project Start Date <span class="asterix"> * </span></label>
									 <div class="col-md-3" id='dateno' style="display: block;">
									<input type="text" name="proj_sDate" id="proj_sDate" disabled="true" class="form-control">
									 	
									 </div>
									  <div class="col-md-3" id='dateyes' style="display: none;">
									
									 	{{ Form::text('date', '', array('id' => 'proj_StartDate','class' => 'form-control','onkeydown'=>"return false;"))}}
									 </div>
								  </div>  </fieldset>
			</div>
			
			
			<div style="clear:both"></div>	
				
					
				  <div class="form-group" >
					<label class="col-sm-4 text-right">&nbsp;</label>
					<div class="col-sm-8">	
					
						<button type="submit" name="submit" id="submitProject" class="btn btn-primary btn-sm">
							<i class="fa fa-save"></i>
							{{ Session::get('uid') == 1 ? 'Release HOD Plan' : 'Assign to HOD' }}
						</button>

						@if(Session::get('uid') == 1)
							<p id="reltohod" style="display: none; color: green; margin-top: 5px;">Project released to HOD successfully</p>
						@endif
					</div>	  
			
				  </div> 
				  <div class="form-group  " id="allActivity">
				  </div>
				  <div style="clear:both"><br></div>	
				   <div class="form-group  " id="addActive"  style="display:block;">
				
	 	<label class="col-sm-4 text-right">&nbsp;</label>
					<div class="col-sm-8">	
					

		<button  id="addAct"  class="btn btn-primary btn-sm" > Add Activity</button>
		

					
					</div>
		 
	</div>
	 {{ Form::close() }}
		 <div class="form-group  " id="project_rel"  style="display:block;">
				
	 	<label class="col-sm-4 text-right">&nbsp;</label>

<div class="container">
  
  <!-- Trigger the modal with a button -->
  

  <!-- Modal -->
  

	 	
  {{-- modification we have to show when user_id != 1 --}}
		{{-- <div style="display: none" class="col-sm-8">	
			<button  name="submit" id="updateProject" style="width: 200px;
			height: 50px;
			font-size: 18px;" class="btn btn-primary btn-sm" > Modify Project Plan</button>
			<button   id="relProject" style="width: 200px;
			height: 50px;
			font-size: 18px;" class="btn btn-primary btn-sm"  > Release Project Plan</button>
					
		</div> --}}
		 

		<div class="col-sm-8" 
		
    style="display: {{ Session::get('uid') == 1 ? 'none' : 'block' }};">
	<button id="coptasks" 
        style="width: 200px; height: 50px; font-size: 18px;" 
        class="btn btn-primary btn-sm">
        complete Task
    </button>	
    <button name="submit" id="updateProject" 
        style="width: 200px; height: 50px; font-size: 18px;" 
        class="btn btn-primary btn-sm">
        Modify Project Plan
    </button>
    <button id="relProject" 
        style="width: 200px; height: 50px; font-size: 18px;" 
        class="btn btn-primary btn-sm">
        Release Project Plan
    </button>
</div>

	</div>
</div>		 
</div>	
</div>	
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content  modal-lg">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">User Involved in Existing Projects</h4>
        </div>
        <div class="modal-body">
        <div id="userdata"></div>
        </div>
        <div class="modal-footer">
          <button id="id_cancel" type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
    <button type="button" class="btn btn-primary" id="id_ok">OK</button>
        </div>
      </div>
      
    </div>
  </div>
  
</div>		 
   <script type="text/javascript">
   var base_url='<?php echo Request::root(); ?>/';
$(document).ready(function() { 


$("#addAct").click(function(){
	var date= $("#proj_StartDate").val();
		var no = $("#proj_no").val();
		//var no1 = $('#proj_no option:selected').text();
		var no1 =  $("#proj_no1").val();
	    var table = $("#project_plan table");
		var drftProjData =[];
	    $("#project_plan tr:gt(0)").each(function () {
        var this_row = $(this);
        
        var gate = $.trim(this_row.find('td:eq(2)').html())
        var activity = $.trim(this_row.find('td:eq(3)').html())
        var respon = $.trim(this_row.find('td:eq(4)').html())
        var start_date = $.trim(this_row.find('td:eq(5)').html())
        var end_date = $.trim(this_row.find('td:eq(6)').html())
        var ref_act = $.trim(this_row.find('td:eq(7)').html())
        var act_id = $.trim(this_row.find('td:eq(8)').html())
        var dept = $.trim(this_row.find('td:eq(9)').html())
        var gate_id = $.trim(this_row.find('td:eq(10)').html())
        var mat_id = $.trim(this_row.find('td:eq(11)').html())
        var user_id = $.trim(this_row.find('td:eq(12)').html())

        if(gate_id != ''){
        drftProjData.push({ 
                   proj_id : no, 
                   proj_no :no1,
                   proj_start_date:date,
                   gate :gate_id,
                   act :act_id,
                   dept:dept,
                   res:user_id,
                   mat_id:mat_id,
                   act_start_date:start_date,
                   act_end_date:end_date,
                   prev_ref_act:ref_act
               });
    }
    
        
    });
			$.ajax({
					url:base_url+'genDraftProj',
					type: 'POST',
					data:{allData:drftProjData,projId:no},
					success: function (data) {
					
					}
				});
});
		document.getElementById('project_rel').style.display = "none";
		document.getElementById('addActive').style.display = "none";
		 $.ajax({
                   url:base_url+'getPrj',
                    type: 'POST',
                    data:{},
                    
                    success: function (data) {
                    	$("#fade").hide();
                    		$("#proj_no").html(data);
                    	}
               });
});

$("#proj_no").change(function(){
		var no = $("#proj_no").val();
		
		$.ajax({
                   url:base_url+'getProjectInfo',
                    type: 'POST',
                    data:{proj_no:no},
                    
                    success: function (data) {
                    var myArray = jQuery.parseJSON(data);
					       jQuery(myArray).each(function( index, element ) { 
					       $.ajax({
                   		url:base_url+'checkprjSave',
                    	type: 'POST',
                    	data:{proj_no:no,},
                   		 success: function (data) {
                   			if(data.trim()== 'no'){
	                   		document.getElementById('dateyes').style.display = "block";
	                   		document.getElementById('dateno').style.display = "none";
	                   		$("#proj_name").val(element.project_name);
					       $("#mfg_loc").val(element.plant_code);
					       $("#proj_StartDate").val(element.project_start_date);
					       $("#proj_no1").val(element.project_no);
					       $('#proj_StartDate').datepicker('setDate', element.project_start_date);
					       $("#allActivity").html(""); 
				                   		document.getElementById('project_rel').style.display = "none";
				                   		document.getElementById('addActive').style.display = "none";
					       return false;
                   			}else{
                   				document.getElementById('dateyes').style.display = "none";
	                   		document.getElementById('dateno').style.display = "block";
                   				$("#proj_name").val(element.project_name);
					       		$("#mfg_loc").val(element.plant_code);
                   				$("#proj_sDate").val(data);
                   				$("#proj_no1").val(element.project_no);
                   				$("#allActivity").html(""); 
				                   		document.getElementById('project_rel').style.display = "none";
				                   		document.getElementById('addActive').style.display = "none";
                   				return false;
                   			}
                   			}
              		 	});    
					       	
					       
					       
					       });
                    }
               
		        });
	});
// $("#submitProject").click(function(evt){
// 		var no = $("#proj_no").val();
// 		evt.preventDefault();
// 		 $.ajax({
//        		url:base_url+'checkprjSave',
//         	type: 'POST',
//         	data:{proj_no:no},
//        		 success: function (data) {
//        			if(data.trim()== 'no'){
//        				$("#")
//            			date = $("#proj_StartDate").val();
//        			}else{
//        				date = $("#proj_sDate").val();

//        			}
       			  
		
// 		var pno1 = $('#proj_no option:selected').text();
// 		var no1 =  $("#proj_no1").val();
// 		// var pno = pno1.split("Revision");
// 		// no1=pno[0];
// 		$("#proj_name1").val(no1);
// 		if(no == ''){
// 			alert('please select project number');
// 		}else if(date == ''){
// 			alert('please select date');
// 		}else{

// 				$.ajax({
// 	                   url:base_url+'checkDate',
// 	                    type: 'POST',
// 	                    data:{date:date},
// 	                    success: function (data) {
// 	                    	if(data.trim()== 'same'){
// 	                    		alert('change date');
	                    	
// 	                    	}else{
// 	                    		$.ajax({
// 		                   		url:base_url+'checkAllCondForGenDraft',
// 		                    	type: 'POST',
// 		                    	data:{proj_no:no,proj_id:no1},
// 		                   		 success: function (data) {
// 		                   		if(data.trim()=='noact'){
// 		                   			alert('Common activity is not defined.Please add activity');
// 		                   		}else if(data.trim()=='commodity'){
// 		                   			alert('Component activity is not defined for component');
// 		                   		}else if(data.trim()=='noUser'){
// 		                   			alert('User is not defined for all activity please edit project');
// 		                   			$("#allActivity").html('');
// 		                   		}else if(data.trim()=='noclr'){
// 		                   			alert('Gate clearence team is not defined for all gate please edit project');
// 		                   		}else{
// 			                    		$.ajax({
// 				                   		url:base_url+'saveProject',
// 				                    	type: 'POST',
// 				                    	data:{proj_no:no,date:date},
// 				                   		 success: function (data) {
				                   		 
// 				                   		$("#allActivity").html(data); 
// 				                   		document.getElementById('project_rel').style.display = "block";
// 				                   		document.getElementById('addActive').style.display = "block";
// 				                   		}
// 				              		 });
			                    		
// 		                   		}
// 		                   	}
// 		              		 });
// 		                   	}
// 	                    }
// 	               });
// 			}
// 		}
//   		 	}); 
// });


$("#submitProject").click(function (evt) {
        evt.preventDefault();

        var no = $("#proj_no").val();
        var date = $("#proj_StartDate").val() || $("#proj_sDate").val();

        // Validation
        if (!no) {
            alert('Please select project number');
            return;
        }
        if (!date) {
            alert('Please select date');
            return;
        }

        // Start AJAX chain for submitProject
        $.ajax({
            url: base_url + 'checkprjSave',
            type: 'POST',
            data: { proj_no: no },
            success: function (data) {
                if (data.trim() === 'no') {
                    date = $("#proj_StartDate").val();
                } else {
                    date = $("#proj_sDate").val();
                }

                $.ajax({
                    url: base_url + 'checkDate',
                    type: 'POST',
                    data: { date: date },
                    success: function (data) {
                        if (data.trim() === 'same') {
                            alert('Change date');
                            return;
                        }

                        $.ajax({
                            url: base_url + 'checkAllCondForGenDraft',
                            type: 'POST',
                            data: { proj_no: no, proj_id: $("#proj_no1").val() },
                            success: function (data) {
                                if (data.trim() === 'noact') {
                                    alert('Common activity is not defined. Please add activity');
                                    return;
                                } else if (data.trim() === 'commodity') {
                                    alert('Component activity is not defined for component');
                                    return;
                                } else if (data.trim() === 'noUser') {
                                    alert('User is not defined for all activity. Please edit project');
                                    $("#allActivity").html('');
                                    return;
                                } else if (data.trim() === 'noclr') {
                                    alert('Gate clearance team is not defined for all gates. Please edit project');
                                    return;
                                }

                                // Save Project and then call Update Project
                                $.ajax({
                                    url: base_url + 'saveProject',
                                    type: 'POST',
                                    data: { proj_no: no, date: date },
                                    success: function (data) {
                                        $("#allActivity").html(data);
                                        document.getElementById('project_rel').style.display = "block";
                                        document.getElementById('addActive').style.display = "block";

                                        // Call the updateProject logic
                                        callUpdateProject(no, date);
                                    }
                                });
                            }
                        });
                    }
                });
            }
        });
});



$("#relProject").click(function(evt){
		  $("#relProject").prop('disabled', true);
		$("#fade").show();
		evt.preventDefault();
		var date= $("#proj_StartDate").val();
		var no = $("#proj_no").val();
		var no1 = $('#proj_no option:selected').text();
		var no2 =  $("#proj_no1").val();
	    var table = $("#project_plan table");
		var drftProjData =[];
		
	    $("#project_plan tr:gt(0)").each(function () {
        var this_row = $(this);

       
         var gate = $.trim(this_row.find('td:eq(2)').html())
        var activity = $.trim(this_row.find('td:eq(3)').html())
        var lead_time = $.trim(this_row.find('td:eq(4)').html())
        var cost =""
        var respon = $.trim(this_row.find('td:eq(6)').html())
        var start_date = $.trim(this_row.find('td:eq(7)').html())
        var end_date = $.trim(this_row.find('td:eq(8)').html())
        var ref_act = $.trim(this_row.find('td:eq(9)').html())
        var act_id = $.trim(this_row.find('td:eq(10)').html())
        var dept = $.trim(this_row.find('td:eq(11)').html())
        var gate_id = $.trim(this_row.find('td:eq(12)').html())
        var mat_id = $.trim(this_row.find('td:eq(13)').html())
        var user_id = $.trim(this_row.find('td:eq(14)').html())

        if(gate_id != ''){
        drftProjData.push({ 
                   proj_id : no, 
                   proj_no :no2,
                   proj_start_date:date,
                   gate :gate_id,
                   act :act_id,
                   lead_time :lead_time,
                   cost :cost,
                   dept:dept,
                   res:user_id,
                   mat_id:mat_id,
                   act_start_date:start_date,
                   act_end_date:end_date,
                   prev_ref_act:ref_act
               });
    }

    
    });
	 
	$.ajax({
       		url:base_url+'checkinvolvmentofuser',
        	type: 'POST',
        	data:{allData:drftProjData,genproject:'yes',projId:no},
       		 success: function (data) {
       		 	console.log(data);
       		 	$("#fade").hide();
       		 	 var html = "<table border='1|1'>";
       		 	  html+="<tr bgcolor='#ddd'>";
       		 	      html+="<td>Sr. No</td>";
			    	  html+="<td>Project No</td>";
			    	  html+="<td>User</td>";
			    	  html+="<td>Project Activity</td>";
			    	  html+="</tr>";
			    for (var i = 0; i < data.length; i++) {
			    	var i1=i+1;
			        html+="<tr>";
			        html+="<td>"+i1+"</td>";
			        html+="<td>"+data[i].project_id+"</td>";
			        html+="<td>"+data[i].user+"</td>";
			        html+="<td>"+data[i].activity+"</td>";

			        html+="</tr>";

			    }
			    html+="</table>";
    $("#userdata").html(html);
       		 	$('#myModal').modal('show');
       		 	
       		 	 $('#id_ok').click(function(){
       		 	 	$("#id_ok").prop('disabled', true);
       		 	 	$("#id_cancel").prop('disabled', true);
       		 	 		$("#fade").show();
				$.ajax({
		       		url:base_url+'genDraftProj',
		        	type: 'POST',
		        	data:{allData:drftProjData,genproject:'yes',projId:no},
		       		 success: function (data) {
		       		 	window.location.href = base_url+"draftProjectPlan";	
		       		}
		  		 });
			    });
       		 	  $("#myModal").on('hidden.bs.modal', function(){
				     $("#relProject").prop('disabled', false);
				  });
    
       		}
  		 }); 
	

});
// $("#updateProject").click(function(evt){
		
// 		evt.preventDefault();
// 		$("#fade").show();
// 		var date= $("#proj_StartDate").val();
// 		var no = $("#proj_no").val();
// 		var no1 =  $("#proj_no1").val();
		
// 	    var table = $("#project_plan table");
// 		var drftProjData =[];
// 		var k=0;
// 	    $("#project_plan tr:gt(0)").each(function () {
//         var this_row = $(this);

//         var id='updateBut'+k;
//         var id1='noUpdate'+k;
//         var id2='Update'+k;
//         var id3='action'+k;
//         var id4='calNo'+k;
//         var id5='calYes'+k;
//         var id8='updateBut'+k;
//         var usr='dept_user'+k;
//         var lead='editlead'+k;
//         var cost='costperact'+k;
//          var active_id='activeId'+k;
//         var act_start_date = 'startdate'+k;
//         var prjId = 'prjId'+k;
//         $("#fade").hide();
		
//         $("#"+id).css("display", "block");
//         $("#"+id1).hide(); 
//         $("#"+id2).show(); 
//           $("#"+id3).show(); 
//           $("#"+id4).hide(); 
//         $("#"+id5).show(); 
//        $("#"+lead).show();
//         $("#"+cost).show();
		
        
//         var gate = $.trim(this_row.find('td:eq(2)').html())
//         var activity = $.trim(this_row.find('td:eq(3)').html())
//         var lead_time = $.trim(this_row.find('td:eq(4)').html())
//         var cost =""
//         var respon = $.trim(this_row.find('td:eq(6)').html())
//         var start_date = $.trim(this_row.find('td:eq(7)').html())
//         var end_date = $.trim(this_row.find('td:eq(8)').html())
//         var ref_act = $.trim(this_row.find('td:eq(9)').html())
//         var act_id = $.trim(this_row.find('td:eq(10)').html())
//         var dept = $.trim(this_row.find('td:eq(11)').html())
//         var gate_id = $.trim(this_row.find('td:eq(12)').html())
//         var mat_id = $.trim(this_row.find('td:eq(13)').html())
//         var user_id = $.trim(this_row.find('td:eq(14)').html())

//         if(gate_id != ''){
//         drftProjData.push({ 
//                    proj_id : no, 
//                    proj_no :no1,
//                    proj_start_date:date,
//                    gate :gate_id,
//                    act :act_id,
//                    lead_time :lead_time,
//                    cost :cost,
//                    dept:dept,
//                    res:user_id,
//                    mat_id:mat_id,
//                    act_start_date:start_date,
//                    act_end_date:end_date,
//                    prev_ref_act:ref_act
//                });
//     }

    
//     k++;

         
//     });

	   
// 	$.ajax({
//        		url:base_url+'genDraftProj',
//         	type: 'POST',
//         	data:{allData:drftProjData,projId:no},
//        		 success: function (data) {
//        			$.ajax({
//                    		url:base_url+'saveProject',
//                     	type: 'POST',
//                     	data:{proj_no:no,date:date},
//                    		 success: function (data) {
//                    		$("#allActivity").html(data); 
//                    			updateProj();
//                    		}
//               		 });
//        		}
//   		 });

// });

function callUpdateProject(no, date) {
        var drftProjData = [];
        var k = 0;

        $("#project_plan tr:gt(0)").each(function () {
            var this_row = $(this);

            var gate_id = $.trim(this_row.find('td:eq(12)').html());
            var act_id = $.trim(this_row.find('td:eq(10)').html());
            var lead_time = $.trim(this_row.find('td:eq(4)').html());
            var user_id = $.trim(this_row.find('td:eq(14)').html());
            var dept = $.trim(this_row.find('td:eq(11)').html());
            var mat_id = $.trim(this_row.find('td:eq(13)').html());
            var start_date = $.trim(this_row.find('td:eq(7)').html());
            var end_date = $.trim(this_row.find('td:eq(8)').html());
            var ref_act = $.trim(this_row.find('td:eq(9)').html());

            if (gate_id) {
                drftProjData.push({
                    proj_id: no,
                    proj_no: $("#proj_no1").val(),
                    proj_start_date: date,
                    gate: gate_id,
                    act: act_id,
                    lead_time: lead_time,
                    cost: "",
                    dept: dept,
                    res: user_id,
                    mat_id: mat_id,
                    act_start_date: start_date,
                    act_end_date: end_date,
                    prev_ref_act: ref_act
                });
            }

            k++;
        });

        // AJAX call to genDraftProj
        $.ajax({
            url: base_url + 'genDraftProj',
            type: 'POST',
            data: { allData: drftProjData, projId: no },
            success: function (data) {
                $.ajax({
                    url: base_url + 'saveProject',
                    type: 'POST',
                    data: { proj_no: no, date: date },
                    success: function (data) {
                        $("#allActivity").html(data);
                        updateProj(); // Call updateProj() if it's defined elsewhere
						// Show the success message
						$("#reltohod").text("Project released to HOD successfully").show();
							}
						});
            }
        });
    }



	function updateProj(){
		
		var drftProjData =[];
		var k=0;
		var date= $("#proj_StartDate").val();
		var no = $("#proj_no").val();
		 $("#project_plan tr:gt(0)").each(function () {
        var this_row = $(this);
         
           
        var id='updateBut'+k;
        var id1='noUpdate'+k;
        var id2='Update'+k;
        var id3='action'+k;
        var id4='calNo'+k;
        var id5='calYes'+k;
        var id8='updateBut'+k;
        var usr='dept_user'+k;
        var lead='editlead'+k;
        var costact='costperact'+k;
         var active_id='activeId'+k;
        var act_start_date = 'startdate'+k;
        var prjId = 'prjId'+k;

		
        $("#"+id).css("display", "block");
        $("#"+id1).hide(); 
        $("#"+id2).show(); 
          $("#"+id3).show(); 
          $("#"+id4).hide(); 
        $("#"+id5).show(); 
        $("#"+lead).show();
        $("#"+costact).show(); 
         $("#fade").hide();

        $("#"+id8).click(function(evt){
    	 $("#fade").show();
		evt.preventDefault();
		var user= $("#"+usr).val();
		var sdate = $("#"+act_start_date).val();
		var aid=$("#"+active_id).val();
		var pid=$("#"+prjId).val();
		var lead_time=$("#"+lead).val();
		var cost=$("#"+costact).val();
		var plan_start_date = $("#"+id4).html();
		$.ajax({
       		url:base_url+'checkDate',
        	type: 'POST',
        	data:{date:sdate},
       		 success: function (data) {
       			if(data.trim() == 'user'){
       				alert('its holiday');
       			}else{
		$.ajax({
       		url:base_url+'updateProjectDet',
        	type: 'POST',
        	data:{user:user,sdate:sdate,aid:aid,pid:pid,proj_id:no,lead_time:lead_time,plan_start_date:plan_start_date,cost:cost},
       		 success: function (data) {
       			$.ajax({
                   		url:base_url+'saveProject',
                    	type: 'POST',
                    	data:{proj_no:no,date:date},
                   		 success: function (data) {
                   		 	 $("#fade").hide();
                   		$("#allActivity").html(data); 
                   			updateProj();
                   		}
              		 });
       		}
  		 });

		}
       		}
  		 });
		
	});
     
    k++;

         
    });
	}
	
	</script>	

<script>


 	function numeric(e) {

        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    }




</script>
 
</body>

</html>