
  <div class="page-content row">
    <!-- Page header -->
    <div class="page-header">
      <div class="page-title">
        <h3> {{ $pageTitle }} <small>{{ $pageNote }}</small></h3>
      </div>
      <ul class="breadcrumb">
        <li><a href="{{ URL::to('dashboard_admin') }}">{{ Lang::get('core.home') }}</a></li>
		<li><a href="{{ URL::to('riskassessmentpoints?md='.$filtermd) }}">{{ $pageTitle }}</a></li>
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

		 {{ Form::open(array('url'=>'riskassessmentpoints/save/'.SiteHelpers::encryptID($row['risk_assessment_id_admin']).'?md='.$filtermd.$trackUri, 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) }}
<div class="col-md-12">
						<fieldset><legend> RiskAssessment</legend>
									
								  <div class="form-group hidethis " style="display:none;">
									<label for="Risk Assessment Id Admin" class=" control-label col-md-4 text-left"> Risk Assessment Id Admin </label>
									<div class="col-md-6">
									  {{ Form::text('risk_assessment_id_admin', $row['risk_assessment_id_admin'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 					
								  <div class="form-group  " >
									<label for="Function" class=" control-label col-md-4 text-left"> Function <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  <select name='risk_sub_department' rows='5' id='risk_sub_department' code='{$risk_sub_department}' 
							class='select2 '  required  ></select> 
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 					
								  <div class="form-group  " >
									<label for="Assessment Point" class=" control-label col-md-4 text-left"> Assessment Point <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  <textarea name='assessment_point_department' rows='2' id='assessment_point_department' class='form-control '  
				         required  >{{ $row['assessment_point_department'] }}</textarea> 
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div>
							<div class="form-group  " >
								<label for="Function" class=" control-label col-md-4 text-left"> Status </label>
								<div class="col-md-6">
									<select name='status' rows='5' id='status'
											class='select2 '    >
										<option value="active" <?php if($row['status']=="active"){ echo "selected='selected'";}?> >Active</option>
										<option value="inactive" <?php if($row['status']=="inactive"){ echo "selected='selected'";}?>>Inactive</option>
									</select>
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
					<button type="submit" name="submit" class="btn btn-primary btn-sm" ><i class="fa  fa-save "></i> {{ Lang::get('core.sb_save') }}</button>
					<button type="button" onclick="location.href='{{ URL::to('riskassessmentpoints?md='.$masterdetail["filtermd"].$trackUri) }}' " class="btn btn-success btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {{ Lang::get('core.sb_cancel') }} </button>
					</div>	  
			
				  </div> 
		 
		 {{ Form::close() }}
	</div>
</div>		 
</div>	
</div>			 
   <script type="text/javascript">
	$(document).ready(function() { 
		
		$("#risk_sub_department").jCombo("{{ URL::to('riskassessmentpoints/comboselect?filter=tb_departments:d_id:d_name') }}",
		{  selected_value : '{{ $row["risk_sub_department"] }}' });
		 
	});
	</script>		 