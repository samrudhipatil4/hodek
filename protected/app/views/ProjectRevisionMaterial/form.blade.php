<!DOCTYPE html>
<html lang="en" ng-app="myApp">
<style type="text/css">
.table-wrapper table {
  border-collapse: initial !important;
  border-spacing: 0;
}
.table-wrapper table thead > tr > th {  
  font-size: 11px;
  font-weight: 600;
  background-color: #808080;
  color: #ffffff;
  border-radius: 0px;
  border-right: 1px solid rgba(255, 255, 255 ,0.15);
  border-left: 1px solid rgba(0, 0, 0,0.35);
  border-bottom: 0;  
  padding: 15px 10px;
}
	.table-wrapper table tbody > tr > td {
  font-size: 12px;
  color: #78797D;
  padding: 2px 10px; 
  border-bottom: 1px solid #E5E5E5 !important;
  border-right: 1px solid #E5E5E5 !important;  
}

</style>

  <div class="page-content row">
    <!-- Page header -->
    <div class="page-header">
      <div class="page-title">
        <h3> {{ $pageTitle }} <small>{{ $pageNote }}</small></h3>
      </div>
      <ul class="breadcrumb">
        <li><a href="{{ URL::to('dashboard_admin') }}">{{ Lang::get('core.home') }}</a></li>
		<li><a href="{{ URL::to('HoldProject?md='.$filtermd) }}">{{ $pageTitle }}</a></li>
        <li class="active">{{ Lang::get('core.addedit') }} </li>
      </ul>
	  	 
    </div>
 
 	<div class="page-content-wrapper" ng-controller="projectRevisionMaterialCtrl">

		<ul class="parsley-error-list">
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
<div class="sbox animated fadeInRight">
	<div class="sbox-title"> <h4> <i class="fa fa-table"></i> <?php echo $pageTitle ;?> <small>{{ $pageNote }}</small></h4></div>
	<div class="sbox-content"> 	

		 {{ Form::open(array('url'=>'ProjectRevisionMaterial/save/'.SiteHelpers::encryptID($row['id']).'?md='.$filtermd.$trackUri, 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ','name'=>'material_revision')) }}

<div class="col-md-12">
						<fieldset><legend>Project Revision</legend>
									
								  <div class="form-group hidethis " style="display:none;">
									<label for="commodity Id" class=" control-label col-md-4 text-left"> Commodity Id </label>
									<div class="col-md-6">
									  {{ Form::text('id', $row['id'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 

									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 
								 <div class="form-group  " >
									<label for="change_type" class=" control-label col-md-4 text-left">Select Project <span class="asterix"> * </span></label>
									<div class="col-md-6">
                                        <select class="form-control" select2=""  ng-model="request.project_no" name="old_project_id" ng-change="getMaterial(request.project_no)" required>
                                            <option  value=""></option>
                                            <option ng-repeat="d in projects" value="<%d.id%>"><%d.project_no%> Revision <%d.project_revision%></option>
                                        </select>
                                        <span ng-cloak class="error-msg " ng-show="(requestForm.business.$dirty || invalidSubmitAttempt) && requestForm.business.$error.required"> This field is required.</span>
                                    </div>
                                    </div>
								  <br>
								 <div class="form-group  " >
								 <div class="col-md-4">
								 </div>
								 <div class="col-md-6">
								 <div class="table-wrapper">
								 	<table class="striped" align="center">
                                             <thead>
                                             
                                                 <th width="20%">Sr. No.</th>
                                                 <th width="60%">Material</th>
                                                
                                                 <th width="10%">Action</th>
                                            
                                             </thead>
                                             <tbody>
                                         <tr ng-repeat="record in material" ng-class="{'success' : records[$index]}">
                                             <td><%$index+1%>.</td>
                                             <td><%record.material_description%></td>
                                             
                                             <td    style=" font-size:16px;" ><a href="javascript:void(0)" ng-click="EditRecord(record.material_description,record.commodity,record.id)" class="" data-position="bottom" data-delay="50" data-tooltip="Edit"><i class="fa fa-pencil"></i> </a></td>
                                                        

                                         </tr>
                                             </tbody>
                                         </table>
                                         </div>
                                         </div>
								  </div>
								 
								 		
									 
									 <br>
									 <div class="row" ng-if="matChange==true">
										<div class="col-md-12">
										<div class="col-md-4">
										</div>
										<div class="col-md-3 text-left">
											<label for="Change Type Name" class="control-label" > Old Material</label>
											
											<input type="text" id="textarea1" class="form-control mg-top" rows="2" ng-model="request.old_material" readonly name="old_material" >
											<input type="hidden" id="old_mat_id" class="form-control mg-top" rows="2" ng-model="request.old_mat_id"  name="old_mat_id" >
											</div>
										
										<div class="col-md-3">
											<label for="Change Type Name" class="control-label" >New Material</label>
											
											<select class="form-control" select2=""  ng-model="request.new_mat" id="new_mat" name="new_mat"  required>
                                            <option  value=""></option>
                                            <option ng-repeat="d in newmaterial" value="<%d.id%>"><%d.material_description%> </option>
                                        </select>
                                         <span style="display:none;color: red"  id="mat_validation" ng-show="material_revision.new_mat.$error.required"> Select Material.</span>
											</div>
										</div>
									</div>
									<br><br>
									<div class="row" ng-if="matChange==true">
										<div class="col-md-12">
										<div class="col-md-6">
										</div>
										<div class="col-md-3">
										<button class="btn btn-primary btn-sm" id="saveDept" name="saveDept" type="button" ng-click="saveNewMaterial(request.new_mat,request.old_material);">Save</button>
										</div>
									</div>
									</div>
									<br><br>
									 <div class="form-group  " >
									<label for="change_type" class=" control-label col-md-4 text-left">Remark<span class="asterix"> * </span></label>
									<div class="col-md-6">
									  {{ Form::text('remark', $row['remark'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true','id'=>'remark','data-parsley'=>'second'  )) }} 
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
					<!-- <button type="submit" name="apply" class="btn btn-info btn-sm" ><i class="fa  fa-check-circle"></i> {{ Lang::get('core.sb_apply') }}</button> -->
					<button type="submit" name="submit" class="btn btn-primary btn-sm" ><i class="fa  fa-save "></i> {{ Lang::get('core.sb_save') }}</button>
					<button type="button" onclick="location.href='{{ URL::to('HoldProject?md='.$masterdetail["filtermd"].$trackUri) }}' " class="btn btn-success btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {{ Lang::get('core.sb_cancel') }} </button>
					</div>	  
			
				  </div> 
		 
		 {{ Form::close() }}
	</div>
</div>		 
</div>	
</div>			 
   <script type="text/javascript">
    var base_url='<?php echo Request::root(); ?>/';
    $(function() {
	//$( "#new_start_date").datepicker({format: 'dd/mm/yyyy'
		
	});

	$(document).ready(function() { 
	
		$.ajax({
                   url:base_url+'getRevisionPrj',
                    type: 'POST',
                    data:{},
                    
                    success: function (data) {
                    	$("#fade").hide();
                    		$("#project_no").html(data);
                    	}
               
		        });
  
	});
		  
	
	</script>
	<?php require app_path().'/views/masterangfooter.php'; ?>	
<?php require app_path().'/views/masterangheader.php'; ?>	
	