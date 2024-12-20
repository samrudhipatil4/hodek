
  <div class="page-content row">
    <!-- Page header -->
    <div class="page-header">
      <div class="page-title">
        <h3> {{ $pageTitle }} <small>{{ $pageNote }}</small></h3>
      </div>
      <ul class="breadcrumb">
        <li><a href="{{ URL::to('dashboard_admin') }}">{{ Lang::get('core.home') }}</a></li>
		<li><a href="{{ URL::to('projectMaster?md='.$filtermd) }}">{{ $pageTitle }}</a></li>
        <li class="active">{{ Lang::get('core.addedit') }} </li>
        
      </ul>
	  	  
    </div>
 
 	<div class="page-content-wrapper">

		<ul class="parsley-error-list">
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
<div class="sbox animated fadeInRight">
	<div class="sbox-title"> <h4> <i class="fa fa-table"></i> <?php echo $pageTitle ;?> <small>{{ $pageNote }}</small></h4></div>
	<div class="sbox-content"> 	

		 {{ Form::open(array('url'=>'projectMaster/save/'.SiteHelpers::encryptID($row['id']).'?md='.$filtermd.$trackUri, 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ','id' => 'proj_master')) }}
<div class="col-md-12">
						<fieldset><legend> Project Master</legend>
									<div class="form-group  hidethis " style="display:none;">
									<label for="Change Stage Id" class=" control-label col-md-4 text-left"> Change Stage Id </label>
									<div class="col-md-6">
									<?php //session_start();?>
									  {{ Form::text('proj_department', $row['project_code'],array('class'=>'form-control', 'placeholder'=>'' )) }} 
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 
								  <div class="form-group hidethis " style="display:none;">
									<label for="Change Stage Id" class=" control-label col-md-4 text-left"> Change Stage Id </label>
									<div class="col-md-6">
									<?php //session_start();?>
									  {{ Form::text('id', $row['id'],array('class'=>'form-control', 'placeholder'=>'','id'=>'edit' )) }} 
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 
								  
								 
								   <div class="form-group  " >
									<label for="Stage Name" class=" control-label col-md-4 text-left"> Project code <span class="asterix"> * </span></label>
									<div class="col-md-6">
									{{Session::get('projcet_code')}}
 									{{ Form::text('project_code', $row['project_code'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true' ,'id' => 'project_code','onblur'=> 'checkProject()')) }} 
 									@if($row['project_code'] == "") 
 									<input type="hidden" name="new_old" id="new_old" value="<php echo $row['id']; ?>"/>
 									 <input type="hidden" name="session" id="session" value="<?php  if(isset($_SESSION['data'])){ echo $_SESSION['data'];}?>"/>
 									 <?php unset($_SESSION['data']);?>
 									 @else
 									 <input type="hidden" name="session" id="session" value="<?php  echo $row['project_code'];?>"/>
 									 @endif

									 </div> </div>
								 <div class="form-group  " >
									<label for="Stage Name" class=" control-label col-md-4 text-left"> Project Description <span class="asterix"> * </span></label>
									<div class="col-md-6">
									
 									{{ Form::text('project_description', $row['project_description'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true','id'=>'project_description'  )) }} 
 									@if($row['project_description'] == "") 
 									 <input type="hidden" name="session1" id="session1" value="<?php  if(isset($_SESSION['description'])){ echo $_SESSION['description'];}?>"/>
 									 <?php unset($_SESSION['description']);?>
 									 @else
 									 <input type="hidden" name="session1" id="session1" value="<?php  echo $row['project_description'];?>"/>
 									 @endif
									 </div> 
									 	<div class="col-md-2">
									 	
									 </div>
									 </div> 
									  <div class="form-group  " >
									<label for="stakeholder" class=" control-label col-md-4 text-left"> Change Stage <span class="asterix"> * </span></label>
									<div class="col-md-6">
										<?php if($row['id'] != "" && $row['change_stage'] == 1){ ?>
											 <select name='change_stage' rows='5' id='change_stage'  
											class='select2 '  onchange="checkStage()" required disabled='true'>
											<option value="">--Select Stage--</option>
											<?php foreach ($stage as $row1) { ?>
												 <option value="<?php echo $row1['change_stage_id'];?>" <?php if($row['change_stage']== $row1['change_stage_id']){ echo "selected='selected'";}?>><?php echo $row1['stage_name'];?></option>
											<?php } ?>
											</select> 	
										<?php }else{ ?>
									    <select name='change_stage' rows='5' id='change_stage'  
											class='select2 '  onchange="checkStage()" required >
											<option value="">--Select Stage--</option>
											<?php foreach ($stage as $row1) { ?>
												 <option value="<?php echo $row1['change_stage_id'];?>" <?php if($row['change_stage']== $row1['change_stage_id']){ echo "selected='selected'";}?>><?php echo $row1['stage_name'];?></option>
											<?php } ?>
											</select> 
											<?php }?>
											@if($row['change_stage'] == "") 
 									 <input type="hidden" name="session3" id="session3" value="<?php  if(isset($_SESSION['stage'])){ echo $_SESSION['stage'];}?>"/>
 									 <?php unset($_SESSION['stage']);?>
 									 @else
 									 <input type="hidden" name="session3" id="session3" value="<?php  echo $row['change_stage'];?>"/>
 									 @endif
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div>
								
									  <div class="form-group  " id="prj_mgr" style="display:block">
									<label for="stakeholder" class=" control-label col-md-4 text-left"> Project Manager <span class="asterix"> * </span></label>
									<div class="col-md-6">
									 <?php if($_SESSION['valid']=='Yes'){?>
									   <select name='project_manager' rows='5' id='project_manager'  
											class='select2 '  required >
											<?php }else{?>
												<select name='project_manager' rows='5' id='project_manager'  
											class='select2 '   >
												<?php }?>
											<option value="">--Select User--</option>
											<?php foreach ($member as $row1) { ?>
												 <option value="<?php echo $row1['id'];?>" <?php if($row['project_manager']== $row1['id']){ echo "selected='selected'";}?>><?php echo $row1['name'];?></option>
											<?php } ?>
											</select> 
											@if($row['project_manager'] == "") 
 									 <input type="hidden" name="session2" id="session2" value="<?php  if(isset($_SESSION['proj_mgr'])){ echo $_SESSION['proj_mgr'];}?>"/>
 									 <?php unset($_SESSION['proj_mgr']);?>
 									 @else
 									 <input type="hidden" name="session2" id="session2" value="<?php  echo $row['project_manager'];?>"/>
 									 @endif
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div>
								  	<div class="form-group  " id="cust_comm" style="display:block">
									<label for="stakeholder" class=" control-label col-md-4 text-left"> Customer Communication Representative <span class="asterix"> * </span></label>
									<div class="col-md-6">
									   <select name='cust_comm_repres' rows='5' id='cust_comm_repres'  
											class='select2 '  required  >
											<option value="">--Select User--</option>
											<?php foreach ($member as $row1) {  

													//$selected = ($row1['id'] == $row['cust_comm_repres']) ? 'selected' : '';
												?>
												<option value="<?php echo $row1['id'];?>" <?php if($row['cust_comm_repres']== $row1['id']){ echo "selected='selected'";}?>><?php echo $row1['name'];?></option>
											<?php } ?>
											</select> 
											@if($row['cust_comm_repres'] == "") 
 									 <input type="hidden" name="session4" id="session4" value="<?php  if(isset($_SESSION['comm'])){ echo $_SESSION['comm'];}?>"/>
 									 <?php unset($_SESSION['comm']);?>
 									 @else
 									 <input type="hidden" name="session4" id="session4" value="<?php  echo $row['cust_comm_repres'];?>"/>
 									 @endif
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div>
								  <div class="form-group  " id="cust_comm_app" style="display:block">
									<label for="stakeholder" class=" control-label col-md-4 text-left"> Customer Communication Approval <span class="asterix"> * </span></label>
									<div class="col-md-6">
									   <select name='cust_comm_approval' rows='5' id='cust_comm_approval'  
											class='select2 '  required  >
											<option value="">--Select User--</option>
											<?php foreach ($member as $row1) {  

													//$selected = ($row1['id'] == $row['cust_comm_repres']) ? 'selected' : '';
												?>
												<option value="<?php echo $row1['id'];?>" <?php if($row['cust_comm_approval']== $row1['id']){ echo "selected='selected'";}?>><?php echo $row1['name'];?></option>
											<?php } ?>
											</select> 
											@if($row['cust_comm_repres'] == "") 
 									 <input type="hidden" name="session4" id="session4" value="<?php  if(isset($_SESSION['cust_app'])){ echo $_SESSION['cust_app'];}?>"/>
 									 <?php unset($_SESSION['cust_app']);?>
 									 @else
 									 <input type="hidden" name="session9" id="session9" value="<?php  echo $row['cust_comm_approval'];?>"/>
 									 @endif
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div>
								  <div class="form-group  " id="docVer" style="display:block">
									<label for="stakeholder" class=" control-label col-md-4 text-left"> Document Verification By <span class="asterix"> * </span></label>
									<div class="col-md-6">
									   <select name='documentVerify' rows='5' id='documentVerify'  
											class='select2 '  required  >
											<option value="">--Select User--</option>
											<?php foreach ($member as $row1) {  ?>
												<option value="<?php echo $row1['id'];?>" <?php if($row['documentVerify']== $row1['id']){ echo "selected='selected'";}?> ><?php echo $row1['name'];?></option>
											<?php } ?>
											</select> 
											@if($row['documentVerify'] == "") 
 									 <input type="hidden" name="session5" id="session5" value="<?php  if(isset($_SESSION['docver'])){ echo $_SESSION['docver'];}?>"/>
 									 <?php unset($_SESSION['docver']);?>
 									 @else
 									 <input type="hidden" name="session5" id="session5" value="<?php  echo $row['documentVerify'];?>"/>
 									 @endif
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div>
								  <div class="form-group  " id="finalApp" style="display:block">
									<label for="stakeholder" class=" control-label col-md-4 text-left">Final Approval and Close Authority <span class="asterix"> * </span></label>
									<div class="col-md-6">
									   <select name='finalApproval' rows='5' id='finalApproval'  
											class='select2 '  required  >
											<option value="">--Select User--</option>
											<?php foreach ($member as $row1) { ?>
												 <option value="<?php echo $row1['id'];?>" <?php if($row['finalApproval']== $row1['id']){ echo "selected='selected'";}?>><?php echo $row1['name'];?></option>
											<?php } ?>
											</select> 
											@if($row['finalApproval'] == "") 
 									 <input type="hidden" name="session6" id="session6" value="<?php  if(isset($_SESSION['final'])){ echo $_SESSION['final'];}?>"/>
 									 <?php unset($_SESSION['final']);?>
 									 @else
 									 <input type="hidden" name="session6" id="session6" value="<?php  echo $row['finalApproval'];?>"/>
 									 @endif

									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div>

								    <div class="form-group  " id="OnSeries" style="display:block;">
									<label for="stakeholder" class=" control-label col-md-4 text-left"> Select Team  <span class="asterix"> * </span></label>
									<div class="col-md-6" id="loadtbl">
									   <table  width="100%" border="1">
									   <thead>
                                             <tr>
                                                 <th width="10%">Sr. No.</th>
                                                 <th>Function Name</th>
                                                 <th>Team Member</th>
                                                 
                                                 <th width="12%" colspan="2">Action</th>
                                             </tr>
                                             </thead>
                                              <tbody>
									   <?php $i=0; $cnt=0;foreach ($department as $row) { 
									  
									   ?>
										<tr colspan="2">
										
											<td align="center" height="40"><?php echo $i=$i+1;?></td>
											<td align="center" height="50"><?php echo $row->d_name;?></td>
											
												
													<td align="center" height="50"><div id="div_<?php echo $row->d_id;?>"><?php echo $row->first_name.' '.$row->last_name;?></div></td>
											
											
											<td align="center"><a href="javascript:void(0)" onclick="UpdateStatus('<?php echo $row->d_id;?>','<?php echo $row->d_name;?>','<?php echo $row->user_id;?>')" class="" data-position="bottom" data-delay="50" data-tooltip="Edit"><i  style="font-size:17px" align="center" class="fa fa-pencil"></i></a></td>
											<td align="center"><a href="javascript:void(0)" onclick="deleteDepartment('<?php echo $row->d_id;?>')" class="" data-position="bottom" data-delay="50" data-tooltip="Edit"><i  style="color:red;font-size:17px" align="center" class="fa fa-times "></i></a></td>	
										</tr>

										<?php $cnt++;}?>
										<input type="hidden" name="tolDept" id="totDept" value="<?php echo $cnt;?>">
											</tbody>
									</table>
									 </div> 

									 <div class="col-md-2">
									 	
									 </div>

								  </div>


								  	<div class="form-group  " id="welcomeDiv" style="display:none;">
									<label for="Stage Name" class=" control-label col-md-4 text-left"><span class="asterix"> * </span></label>
									<div class="col-md-6" >
									
                                     <div>

                                         <div class="input-field col-sm-3 mg-top">
                                             <label for="textarea1">Function Name</label>
                                             <input type="text" id="department" class="form-control mg-top" rows="2" ng-model="risks.d_name" readonly name="department" >
                                         
                                         </div>

                                         <div class="input-field col-sm-3 mg-top">
                                             <label for="first_name">Select Team Member</label>
                                             <select name='user' rows='5'  id='user'
										  >
								</select>
          
                                         </div>
										 <div class="mg-top">
                                             <div class="col-sm-12 mg-top">
                                                 <button class="btn btn-primary btn-sm" type="button"  name="saveUser" name="saveUser" value="saveUser" onclick="checkClick()">Save</button>
                                                 <button type="button" onclick="hideDiv()" class="btn btn-success btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {{ Lang::get('core.sb_cancel') }} </button>

                                             </div>
                                         </div>
                                     </div>

									 </div>
									 	 <div class="col-md-2">
									 	
									 </div>
									  </div>
									  
								   
									 </fieldset>
			</div>						
			
			
			<div style="clear:both"></div>	
			<input type="hidden" name="" id="dept_id">
				    	<div class="form-group" id="displayDept" style="display:none;">
									<label for="stakeholder" class=" control-label col-md-4 text-left"> <span class="asterix">  </span></label>
									<div class="col-md-4">
									  <select name='sub_department'  id='sub_department'
										required  style="margin-left: 40px;">
										<option>--Select department</option>
										<?php $cnt1=0;foreach($depart as $row){?>
											
											<option value="<?php echo $row->d_id;?>"><?php echo $row->d_name;?></option>
										<?php $cnt1++;}?>
										<input type="hidden" name="totDeptForAdd" id="totDeptForAdd" value="<?php echo $cnt1;?>">
								</select>
									

									 </div> 
									 <div class="col-md-4" >
									 	<button  style="padding-left: 22px;margin-left: -99px;" type="button" name="submit_dept"  id="submit_dept" class="btn btn-info btn-sm"> Submit</button>
									 </div>
								  </div>
					 <div class="form-group">
					<label class="col-sm-4 text-right">&nbsp;</label>
					<div class="col-sm-1">	
					<button style="display:block" type="button" name="add_dept" id="add_dept"  class="btn btn-info btn-sm"> Add Dept</button>
					
					
					</div>	 
					<div class="col-sm-1">	
					
					<button style="margin-left: 10px;"style="display:block;" type="button" id="butCancel" onclick="hideDiv1()" class="btn btn-success btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {{ Lang::get('core.sb_cancel') }} </button>
					
					</div>	 
			
				  </div> 
				  <div class="form-group  " >
									<label for="Logo Image" class=" control-label col-md-4 text-left"> Logo Image <span class="asterix"> * </span></label>
									<div class="col-md-4">
									  <input  type='file' accept=".csv, .ods,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" name='logo_image' id='logo_image'  style='width:150px !important;'  />
				 	  <br />
			 
				 	<div >
					
					</div>					
				 
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 
				  <div class="form-group">
					<label class="col-sm-4 text-right">&nbsp;</label>
					<div class="col-sm-8">	
					<!-- <button type="submit" name="apply" id="apply" class="btn btn-info btn-sm" ><i class="fa  fa-check-circle"></i> {{ Lang::get('core.sb_apply') }}</button> -->
					<button type="submit"  id="submit"  name="submit" class="btn btn-primary btn-sm" value="all"><i class="fa  fa-save "></i> {{ Lang::get('core.sb_save') }}</button>
					<button type="button" onclick="location.href='{{ URL::to('projectMaster?md='.$masterdetail["filtermd"].$trackUri) }}' " class="btn btn-success btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {{ Lang::get('core.sb_cancel') }} </button>
					</div>	  
			
				  </div> 
				  
				 
		 {{ Form::close() }}
	</div>
</div>		 
</div>	
</div>	
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo Request::root(); ?>/protected/public/js/simply-toast.min.js"></script>		 
   <script type="text/javascript">
	var base_url='<?php echo Request::root(); ?>/';
	window.onload = assignValue();
	window.onload = getDataOfSeries();
	

	function getDataOfSeries(){
			var value = $('#change_stage').val();
			if(value == 1){
						var companyPanel = $('#prj_mgr');
         
				document.getElementById("project_manager").disabled = true;
				document.getElementById("cust_comm_repres").disabled = true;
				document.getElementById("documentVerify").disabled = true;
				document.getElementById("finalApproval").disabled = true;
				document.getElementById('add_dept').style.display = "none";
				document.getElementById('OnSeries').style.display = "none";
				document.getElementById('butCancel').style.display = "none";
				document.getElementById('finalApp').style.display = "none";
				document.getElementById('docVer').style.display = "none";
				document.getElementById('cust_comm').style.display = "none";
				document.getElementById('prj_mgr').style.display = "none";
					var p1='series';
					$.ajax({
                   url:base_url+'projectMaster/setStageSess',
                    type: 'POST',
                    data:{edit:p1},
                    
                    success: function (data) {
                    		
                      
                    }
               
		        });
					
				
				}else{
				
					var p1='development';
					document.getElementById('add_dept').style.display = "block";
				document.getElementById('OnSeries').style.display = "block";
				document.getElementById('butCancel').style.display = "block";
				document.getElementById('finalApp').style.display = "block";
				document.getElementById('docVer').style.display = "block";
				document.getElementById('cust_comm').style.display = "block";
				document.getElementById('prj_mgr').style.display = "block";
					$.ajax({
                   url:base_url+'projectMaster/setStageSess',
                    type: 'POST',
                    data:{edit:p1},
                    
                    success: function (data) {
                    
                      
                    }
               
		        });
				}
	}
	
	function hideDiv1(){
		document.getElementById('displayDept').style.display = "none";
	}
	
	$("#logo_image").change(function(){

		var ext = $('#logo_image').val().split('.').pop().toLowerCase();

            
            if($.inArray(ext, ['csv','ods','xls','xlsx']) == -1) {
                    alert('invalid extension!');
                    return false;
            }
       $.ajax({
                 url:base_url+'projectMaster/changeReqUpload1',
                type: 'POST',
                data: new FormData($("#proj_master")[0]),
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function(){
                    $("#fade").show();
                },
                success: function(data) {
                	if(data.trim() == 'save'){
                		window.location.href = base_url+'projectMaster';
                	}else{
                   		alert(data);
               		}
                }
            });
		
	});
	function hideDiv(){
		document.getElementById('welcomeDiv').style.display = "none";
	}
	function assignValue(){
		var val =$('#session').val();
		$('#project_code').val(val);

		var val1 =$('#session1').val();
		$('#project_description').val(val1);

		var val2 =$('#session2').val();
		$('#project_manager').val(val2);

		var val3 =$('#session3').val();
		$('#change_stage').val(val3);

		var val4 =$('#session4').val();
		$('#cust_comm_repres').val(val4);

		var val5 =$('#session5').val();
		$('#documentVerify').val(val5);

		var val6 =$('#session6').val();
		$('#finalApproval').val(val6);
		
		
	}

	

		 function UpdateStatus(d_id,d_name,user_id)
    		{
    			$("#dept_id").val(d_id);

	    		document.getElementById('welcomeDiv').style.display = "block";
		        document.getElementById("department").value = d_name;
		            
		           $.ajax({
                   url:base_url+'projectMaster/get_User',
                    type: 'POST',
                    data:{dept_id:d_id,user_id:user_id},
                    beforeSend: function () {
                        $("#fade").show();
                    },
                    success: function (data) {
                        $("#fade").hide();
                        $('#user').html(data);
                        document.getElementById("department").value = d_name;
                       

                    }
               
		        });
    
}

function checkClick(){
	var checkEdit = $("#edit").val();

	var dept = $("#dept_id").val();
	var proj_code = $('#project_code').val();
	
	var user = $( "#user option:selected" ).val();
		if (proj_code == "") {
				alert('please enter project code');
				return false;
			}
		 if (user == " ") {
			alert('please select user');
			return false;
		}
				$.ajax({
                   url:base_url+'projectMaster/save_User',
                    type: 'POST',
                    data:{edit:checkEdit,proj_code:proj_code,dept_id:dept,user:user},
                    beforeSend: function () {
                        $("#fade").show();
                    },
                    success: function (data) {
                        $("#fade").hide();
                        if(data == 1){
                        	$.simplyToast('Duplicate Project', 'warning');
                        	return false;
                        }
                       	data = JSON.parse(data);
                       	data = data[0];

                       	$("#div_"+dept).html(data.first_name+' '+data.last_name);

                       	document.getElementById('welcomeDiv').style.display = "none";
                    }
               
		        });
}

		
		function deleteDepartment(d_id){
			var edit = $('#edit').val();
				
			var proj_code = $('#project_code').val();
			var desc = $('#project_description').val();
			var mgr = $('#project_manager').val();
			var stage = $('#change_stage').val();
			var comm = $('#cust_comm_repres').val();
			var docver = $('#documentVerify').val();
			var final = $('#finalApproval').val();
			if (proj_code == "") {
					alert('please enter project code');
					return false;
				}
				$.ajax({
                   url:base_url+'projectMaster/deleteDepartment',
                    type: 'POST',
                    data:{edit:edit,dept_id:d_id,proj_code:proj_code,desc:desc,mgr:mgr,stage:stage,comm:comm,docver:docver,final:final},
                    beforeSend: function () {
                        $("#fade").show();
                    },
                    success: function (data) {
                    		
                        if(data ==0){
                        	
                        	 $.simplyToast('Project code avilable.', 'warning');
                         
                        }else{

                        	location.reload();
                        }
                   
                    }
               
		        });
		}

		
			function checkStage(){
				var value = $('#change_stage').val();
				var pid = $('#edit').val();
				$.ajax({
                   url:base_url+'projectMaster/checkProjectTask',
                    type: 'POST',
                    data:{edit:pid},
                    
                    success: function (data) {
                    	
                    if(data==1 && value == 1){
                    	 $.simplyToast('You can not edit change stage.', 'warning');
                    }else{
                    	
                    	
                   
				if(value == 1){
						var companyPanel = $('#prj_mgr');
         
				document.getElementById("project_manager").disabled = true;
				document.getElementById("cust_comm_repres").disabled = true;
				document.getElementById("documentVerify").disabled = true;
				document.getElementById("finalApproval").disabled = true;
				document.getElementById('add_dept').style.display = "none";
				document.getElementById('OnSeries').style.display = "none";
				document.getElementById('butCancel').style.display = "none";
				document.getElementById('finalApp').style.display = "none";
				document.getElementById('docVer').style.display = "none";
				document.getElementById('cust_comm').style.display = "none";
				document.getElementById('prj_mgr').style.display = "none";
					var p1='series';
					$.ajax({
                   url:base_url+'projectMaster/setStageSess',
                    type: 'POST',
                    data:{edit:p1},
                    
                    success: function (data) {
                    		
                      
                    }
               
		        });
					
				
				}else{
				
					var p1='development';
					document.getElementById('add_dept').style.display = "block";
				document.getElementById('OnSeries').style.display = "block";
				document.getElementById('butCancel').style.display = "block";
				document.getElementById('finalApp').style.display = "block";
				document.getElementById('docVer').style.display = "block";
				document.getElementById('cust_comm').style.display = "block";
				document.getElementById('prj_mgr').style.display = "block";
					$.ajax({
                   url:base_url+'projectMaster/setStageSess',
                    type: 'POST',
                    data:{edit:p1},
                    
                    success: function (data) {
                    		
                      
                    }
               
		        });
				}

				 }		
                      
                    }
               
		        });

				
			}	

		function checkProject(){
			var proj_code = $('#project_code').val();
			$.ajax({
                   url:base_url+'projectMaster/checkProject',
                    type: 'POST',
                    data:{proj_code:proj_code},
                    
                    success: function (data) {
                    	if(data== 1)
                    	{
                    		$.simplyToast('Duplicate Project', 'warning');
                        	return false;
                    	}
                  
                  
                    }
               
		        });
		}

		$("#add_dept").click(function () {
			document.getElementById('displayDept').style.display = "block";
		});

		

		$("#submit_dept").click(function () {
			var desc = $('#project_description').val();
			var mgr = $('#project_manager').val();
			var stage = $('#change_stage').val();
			var comm = $('#cust_comm_repres').val();
			var docver = $('#documentVerify').val();
			var final = $('#finalApproval').val();
			var proj_code = $('#project_code').val();
			var dept = $("#sub_department").val();

			if (proj_code == "") {
					alert('please enter project code');
					return false;
				}
			var tot=$("#totDept").val();
			var tot1=$("#totDeptForAdd").val();
			if(tot == tot1){
				alert("department is already added!");
			}else{
				$.ajax({
                   url:base_url+'projectMaster/add_deptart',
                    type: 'POST',
                    data:{dept:dept,proj_code:proj_code,desc:desc,mgr:mgr,stage:stage,comm:comm,docver:docver,final:final},
                    
                    success: function (data) {
                    	
                    	if(data == 0){
                    		alert("department is already added!");
                    	}else{
                    		location.reload();
                    	}
                  
                  
                    }
               
		        });
			}
		});


</script>

