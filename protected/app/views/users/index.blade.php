{{--*/ usort($tableGrid, "SiteHelpers::_sort") /*--}}
<div class="page-content row">
	<!-- Page header -->
	<div class="page-header">
		<div class="page-title">
			<h3> {{ $pageTitle }} <small>{{ $pageNote }}</small></h3>
		</div>

		<ul class="breadcrumb">
			<li><a href="{{ URL::to('dashboard_admin') }}">{{ Lang::get('core.home'); }}</a></li>
			<li class="active">{{ $pageTitle }}</li>
		</ul>

	</div>

	<div class="page-content-wrapper m-t">
		<ul class="nav nav-tabs" style="margin-bottom:10px;">
			<li class="active"><a href="{{ URL::to('users')}}"> Users </a></li>

		</ul>

		@if(Session::has('message'))
			{{ Session::get('message') }}
		@endif
		<div class="sbox animated fadeInRight">
			<div class="sbox-title"> <h5> <i class="fa fa-table"></i> <?php echo $pageTitle ;?> <small>{{ $pageNote }}</small></h5>

			</div>
			<div class="sbox-content">
				<div class="toolbar-line">
					@if($access['is_add'] ==1)
						<a href="{{ URL::to('users/add') }}" class="tips btn btn-sm btn-white"  title="{{ Lang::get('core.btn_create') }}">
							<i class="fa fa-plus-circle text-info"></i>&nbsp; {{ Lang::get('core.btn_create') }}</a>
					@endif
					@if($access['is_remove'] ==1)
						<a href="javascript://ajax"  onclick="SximoDelete();" class="tips btn btn-sm btn-white" title="{{ Lang::get('core.btn_remove') }}">
							<i class="fa fa-minus-circle text-danger"></i>&nbsp; {{ Lang::get('core.btn_remove') }}</a>
					@endif
					@if($access['is_excel'] ==1)
						<a href="{{ URL::to('users/download') }}" class="tips btn btn-sm btn-white" title="{{ Lang::get('core.btn_download') }}">
							<i class="fa fa-download text-warning"></i>&nbsp;{{ Lang::get('core.btn_download') }} </a>
					@endif
				</div>

				{{ Form::open(array('url'=>'users/destroy/', 'class'=>'form-horizontal' ,'ID' =>'SximoTable' )) }}
				<div class="table-responsive">
					<table class="table table-striped  ">
						<thead>
						<tr>
							<th> No </th>
							<th> <input type="checkbox" class="checkall" /></th>
							<th>Avatar</th>

							<th>{{ Lang::get('core.username') }}</th>
							<th>{{ Lang::get('core.firstname') }}</th>
							<th>{{ Lang::get('core.lastname') }}</th>
							<th>{{ Lang::get('Function') }}</th>
							<th>{{ Lang::get('Sub-Function') }}</th>

							<th>Status</th>
							<th>{{ Lang::get('core.btn_action') }}</th>
						</tr>
						</thead>

						<tbody>
						<tr id="sximo-quick-search" >
							@if($access['is_detail'] ==1)<td> </td>@endif
							<td> </td>
							@foreach ($tableGrid as $t)
								@if($t['view'] =='1')
									<td>
										{{ SiteHelpers::transForm($t['field'] , $tableForm) }}
									</td>
								@endif
							@endforeach
							<td style="width:100px;">
								<input type="hidden"  value="Search">
								<button type="button"  class=" do-quick-search btn btn-sx btn-info"> GO</button></td>
						</tr>
						@foreach ($rowData as $row)
							<tr>
								<td width="50"> {{ ++$i }} </td>
								<td width="50"><input type="checkbox" class="ids" name="id[]" value="{{ $row->id }}" />  </td>
								@foreach ($tableGrid as $field)
									@if($field['view'] =='1')
										<td>

											@if($field['field'] == 'avatar')
												<?php if( file_exists( './uploads/users/'.$row->avatar) && $row->avatar !='') { ?>
												<img src="{{ URL::to('uploads/users').'/'.$row->avatar }} " border="0" width="40" class="img-circle" />
												<?php  } else { ?>
												<img alt="" src="http://www.gravatar.com/avatar/{{ md5($row->email) }}" width="40" class="img-circle" />
												<?php } ?>

											@elseif($field['field'] =='active')
												{{ ($row->active ==1 ? '<lable class="label label-success">Active</label>' : '<lable class="label label-danger">Inactive</label>')  }}

											@else
												{{--*/ $conn = (isset($field['conn']) ? $field['conn'] : array() ) /*--}}
												{{ SiteHelpers::gridDisplay($row->$field['field'],$field['field'],$conn) }}
											@endif
										</td>
									@endif
								@endforeach
								<td>

									{{--*/ $id = SiteHelpers::encryptID($row->id) /*--}}

									@if($access['is_edit'] ==1)
										<a  href="{{ URL::to('users/add/'.$id)}}"  class="tips btn btn-xs btn-white"  title="{{ Lang::get('core.btn_edit') }}"> <i class="fa fa-edit"></i></a>
									@endif


								</td>
							</tr>

						@endforeach

						</tbody>

					</table>
				</div>
				{{ Form::close() }}

				@include('footer_admin')
				</lable>
				</lable>



			</div>
		</div>
		<script>
			$(document).ready(function(){

				$('.do-quick-search').click(function(){
					$('#SximoTable').attr('action','{{ URL::to("users/multisearch")}}');
					$('#SximoTable').submit();
				});

			});
		</script>