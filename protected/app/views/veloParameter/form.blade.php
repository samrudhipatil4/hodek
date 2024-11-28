
  <div class="page-content row">
    <!-- Page header -->
    <div class="page-header">
      <div class="page-title">
        <h3> {{ $pageTitle }} <small>{{ $pageNote }}</small></h3>
      </div>
      <ul class="breadcrumb">
        <li><a href="{{ URL::to('dashboard_admin') }}">{{ Lang::get('core.home') }}</a></li>
		<li><a href="{{ URL::to('Velo_Parameter?md='.$filtermd) }}">{{ $pageTitle }}</a></li>
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

		 {{ Form::open(array('url'=>'Velo_Parameter/save/'.SiteHelpers::encryptID($row['id']).'?md='.$filtermd.$trackUri, 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) }}
<div class="col-md-12">
						<fieldset><legend> Department Add</legend>
									
								  <div class="form-group hidethis " style="display:none;">
									<label for="Change Stage Id" class=" control-label col-md-4 text-left"> Change Stage Id </label>
									<div class="col-md-6">
									  {{ Form::text('id', $row['id'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 
								  <div class="form-group  " >
									<label for="Stage Name" class=" control-label col-md-4 text-left"> Department Add <span class="asterix"> * </span></label>
									<div class="col-md-6">
									 <select name='dept_add'  id='dept_add'
											class='select2 ' row='5' required >
										<option value="">--Please Select--</option>
										<option value="Yes" <?php if($row['dept_add']=="Yes"){ echo "selected='selected'";}?> selected>Yes</option>
										<option value="No" <?php if($row['dept_add']=="No"){ echo "selected='selected'";}?>>No</option>
									</select>
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 
								  	 <div class="form-group  " >
									<label for="Stage Name" class=" control-label col-md-4 text-left"> Horizontal Deployment <span class="asterix"> * </span></label>
									<div class="col-md-6">
									 <select name='horizDeploy'  id='horizDeploy'
											class='select2 ' row='5' required >
										<option value="">--Please Select--</option>
										<option value="Initiator" <?php if($row['horizDeploy']=="Initiator"){ echo "selected='selected'";}?> selected>Initiator</option>
										<option value="User" <?php if($row['horizDeploy']=="User"){ echo "selected='selected'";}?>>User</option>
									</select>
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div>

								   <div class="form-group  " >
									<label for="Stage Name" class=" control-label col-md-4 text-left">Risk Assessment Approve <span class="asterix"> * </span></label>
									<div class="col-md-6">
									 <select name='RiskAssApprove'  id='RiskAssApprove'
											class='select2 ' row='5' required >
										<option value="">--Please Select--</option>
										<option value="Initiator" <?php if($row['RiskAssApprove']=="Initiator"){ echo "selected='selected'";}?> selected>Initiator</option>
										<option value="Superadmin" <?php if($row['RiskAssApprove']=="Superadmin"){ echo "selected='selected'";}?>>Superadmin</option>
									</select>
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div>

								  <div class="form-group  " >
									<label for="Stage Name" class=" control-label col-md-4 text-left">File Upload Type<span class="asterix"> * </span></label>
									<div class="col-md-6">
									 <select name='file_upload_type'  id='file_upload_type'
											class='select2 ' row='5' required >
										<option value="">--Please Select--</option>
										<option value="All" <?php if($row['file_upload_type']=="All"){ echo "selected='selected'";}?> selected>All</option>
										<option value="Specific" <?php if($row['file_upload_type']=="Specific"){ echo "selected='selected'";}?>>Specific</option>
									</select>
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div>
								  <div class="form-group  " >
									<label for="Stage Name" class=" control-label col-md-4 text-left">File Upload Type<span class="asterix"> * </span></label>
									<div class="col-md-6">
									 <input type="number" name="No_of_Days" id="No_of_Days">
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div>
								  </fieldset>
			</div>
			
			
			<div style="clear:both"></div>	
				
					
				  <div class="form-group">
					<label class="col-sm-4 text-right">&nbsp;</label>
					<div class="col-sm-8">	
					<button type="submit" name="apply" class="btn btn-info btn-sm" ><i class="fa  fa-check-circle"></i> {{ Lang::get('core.sb_apply') }}</button>
					<button type="submit" name="submit" class="btn btn-primary btn-sm" ><i class="fa  fa-save "></i> {{ Lang::get('core.sb_save') }}</button>
					<button type="button" onclick="location.href='{{ URL::to('Velo_Parameter?md='.$masterdetail["filtermd"].$trackUri) }}' " class="btn btn-success btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {{ Lang::get('core.sb_cancel') }} </button>
					</div>	  
			
				  </div> 
		 
		 {{ Form::close() }}
	</div>
</div>		 
</div>	
</div>			 
   <script type="text/javascript">
	$(document).ready(function() { 
		 
	});
	</script>		 