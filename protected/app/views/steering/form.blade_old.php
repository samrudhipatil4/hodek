<div class="page-content row">
	<!-- Page header -->
	<div class="page-header">
		<div class="page-title">
			<h3> {{ $pageTitle }} <small>{{ $pageNote }}</small></h3>
		</div>
		<ul class="breadcrumb">
			<li><a href="{{ URL::to('dashboard_admin') }}">{{ Lang::get('core.home') }}</a></li>

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

				{{ Form::open(array('url'=>'steering/save/'.SiteHelpers::encryptID($row['id']), 'class'=>'form-horizontal','files' => true ,'parsley-validate novalidate'=>'')) }}
				<div class="col-md-12">
					<fieldset><legend> Steering User</legend>

						<div class="form-group hidethis " style="display:none;">
							<label for="Id" class=" control-label col-md-4 text-left"> Id </label>
							<div class="col-md-6">
								{{ Form::text('id', $row['id'],array('class'=>'form-control', 'placeholder'=>'',   )) }}
							</div>
							<div class="col-md-2">

							</div>
						</div>
						<div class="form-group  " >
							<label for="Group / Level" class=" control-label col-md-4 text-left"> User Roles <span class="asterix">  </span></label>
							<div class="col-md-6">


			                    <label id='group_id'>  </label>
								<!--<select name='group_id[]' rows='5'  id='group_id'
										required  >


								</select>-->


							</div>

						</div>
						
						<div class="form-group  " >
							<label for="Username" class=" control-label col-md-4 text-left"> Employee ID <span class="asterix"> * </span></label>
							<div class="col-md-6">
								{{ Form::text('username', $row['username'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true'  )) }}
							</div>
							<div class="col-md-2">

							</div>
						</div>
						<div class="form-group  " >
							<label for="First Name" class=" control-label col-md-4 text-left"> First Name <span class="asterix"> * </span></label>
							<div class="col-md-6">
								{{ Form::text('first_name', $row['first_name'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true'  )) }}
							</div>
							<div class="col-md-2">

							</div>
						</div>
						<div class="form-group  " >
							<label for="Last Name" class=" control-label col-md-4 text-left"> Last Name <span class="asterix">  </span></label>
							<div class="col-md-6">
								{{ Form::text('last_name', $row['last_name'],array('class'=>'form-control', 'placeholder'=>''  )) }}
							</div>
							<div class="col-md-2">

							</div>
						</div>
						<div class="form-group  " >
							<label for="Email" class=" control-label col-md-4 text-left"> Email <span class="asterix"> * </span></label>
							<div class="col-md-6">
								{{ Form::text('email', $row['email'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true', 'parsley-type'=>'email'   )) }}
							</div>
							<div class="col-md-2">

							</div>
						</div>

						<div class="form-group">

							<label for="ipt" class=" control-label col-md-4 text-left" > </label>
							<div class="col-md-8">
								@if($row['id'] !='')
									{{ Lang::get('core.notepassword') }}
								@else
								@endif
							</div>
						</div>
						<div class="form-group">
							<label for="ipt" class=" control-label col-md-4"> {{ Lang::get('core.newpassword') }} <span class="asterix">  </span></label>
							<div class="col-md-6">
								<input name="password" type="password" id="password" class="form-control input-sm" value=""
									   @if($row['id'] =='')
									   required
										@endif
								/>
							</div>
						</div>

						<div class="form-group">
							<label for="ipt" class=" control-label col-md-4"> {{ Lang::get('core.conewpassword') }} <span class="asterix">  </span></label>
							<div class="col-md-6">
								<input name="password_confirmation" type="password" id="password_confirmation" class="form-control input-sm" value=""
									   @if($row['id'] =='')
									   required
										@endif
								/>
							</div>
						</div>
						<div class="form-group  " >
							<label for="Department" class=" control-label col-md-4 text-left"> Function </label>
							<div class="col-md-6">
								
								<label id='department'>  </label>
								<!--<select name='department' rows='5' id='department' onChange="fetch_sub_department(this.value)"
										required  >


								</select>-->
								{{ Form::hidden('department', '11',array('class'=>'form-control', 'placeholder'=>''  )) }}


							</div>
							<div class="col-md-2">

							</div>
						</div>
						<div class="form-group  " >
							<label for="Sub Department" class=" control-label col-md-4 text-left"> Sub Function </label>


							<div class="col-md-6">
								<label id='sub_department'>  </label>
							<!--	<select name='sub_department' rows='5' id='sub_department'
										required  >


								</select>-->
									{{ Form::hidden('sub_department', '19',array('class'=>'form-control', 'placeholder'=>''  )) }}
									{{ Form::hidden('group_id', '5',array('class'=>'form-control', 'placeholder'=>''  )) }}


							</div>
							<div class="col-md-2">

							</div>
						</div>

						<div class="form-group  " >
							<label for="Status" class=" control-label col-md-4 text-left"> Status <span class="asterix">  </span></label>
							<div class="col-md-6">
								

								<label class='radio radio-inline'>
									<input type='radio' name='active' value ='0' checked required @if($row['active'] == '0') checked="checked" @endif > Inactive </label>
								<label class='radio radio-inline'>
									<input type='radio' name='active' value ='1'  required @if($row['active'] == '1') checked="checked" @endif > Active </label>
							</div>
							<div class="col-md-2">

							</div>
						</div>
						<!--<div class="form-group  " >
							<label for="Avatar" class=" control-label col-md-4 text-left"> Avatar </label>
							<div class="col-md-6">
								<input  type='file' name='avatar' id='avatar' @if($row['avatar'] =='') class='required' @endif style='width:150px !important;'  />
								<div >

									{{ SiteHelpers::showUploadedFile($row['avatar'],'/uploads/users') }}
									@if($row['avatar'] !='')
										<a href="{{ URL::to('employee/removecurrentfiles?file=/uploads/'.$row['Foto'].'&id='.$row['EmployeeId'].'&field=Foto') }}" class="removeCurrentFiles"> Remove current file</a>
									@endif
								</div>

							</div>

							<div class="col-md-2">

							</div>
						</div>-->

						<div class="form-group  " >
							<label for="Mobile No" class=" control-label col-md-4 text-left"> Mobile No <span class="asterix"> * </span></label>
							<div class="col-md-6">
								{{ Form::text('mobile_no', $row['mobile_no'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true', 'parsley-type'=>'number'   )) }}
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
					</div>

				</div>

				{{ Form::close() }}
			</div>
		</div>
	</div>
</div>





<?php

$myd=explode(',',$row["group_id"]);

?>

<script type="text/javascript">
	$(document).ready(function() {





	});
</script>



<script type='text/javascript'>


	var base_url='<?php echo Request::root(); ?>/';


	function fetch_sub_department(value)
	{

		$.ajax({
			type:"POST",
			cache:false,
			data: { dep_id: value },
			url:base_url+'steering/sub_department_ajax',

			success:function(response){

				$('#sub_department').html(response);
			}
		});


	}//end function;

</script>


<script type="text/javascript">
	window.onload=fetch_group();
	window.onload=fetch_function();
	window.onload=fetch_sub_function();


	var base_url='<?php echo Request::root(); ?>/';

	function fetch_group()
	{<?php
		if(isset($row['id']) && !empty($row['id'])){//echo"aasdhello";exit;

			$id=$row['id'];



		}else{

			$id='s';

		}
?>
		$.ajax({
		type:"get",
		cache:false,
		//data: { dep_id: value },
		url:base_url+'steering/group_ajax/<?=$id;?>',

		success:function(response){

			$('#group_id').html(response);
		}
	});


	}//end function;

	function fetch_function()
	{<?php
		if(isset($row['id']) && !empty($row['id'])){//echo"aasdhello";exit;

			$id=$row['id'];



		}else{

			$id='s';

		}
?>
		$.ajax({
		type:"get",
		cache:false,
		//data: { dep_id: value },
		url:base_url+'steering/department_ajax/<?=$id;?>',

		success:function(response){

			$('#department').html(response);
		}
	});


	}//end function;

	function fetch_sub_function()


	{<?php
		if(isset($row['department']) && !empty($row['department'] && isset($row['id']) && !empty($row['id']))){//echo $row['dep_id'];exit;


				// $userid = "";
			//$userid=$row['id'];
			$id=$row['department'];




		}else{

			$id='s';

		}
?>
		$.ajax({
		type:"get",
		cache:false,
		//data: { dep_id: value },
		url:base_url+'steering/subdepartment_ajax/<?=$id;?>/<?=$row['id'];?>',

		success:function(response){

			$('#sub_department').html(response);
		}
	});


	}//end function;



</script>

