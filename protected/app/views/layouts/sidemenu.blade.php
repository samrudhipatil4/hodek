	<?php  $id=Session::get('gid');
	  $phase=Session::get('phase');

	  if($id==14 || $phase== 'APQP'){?>
	  {{--*/ $sidebar = SiteHelpers::menus('apqp') /*--}}
	  <?php }else{ ?>
	    {{--*/ $sidebar = SiteHelpers::menus('sidebar') /*--}}
	  <?php }?>


	

<nav role="navigation" class="navbar-default navbar-static-side">
     <div class="sidebar-collapse">				  
       <ul id="sidemenu" class="nav expanded-menu">
		
		<li class="nav-header">
			<div class="dropdown profile-element" style="text-align:center;"> <span>
				{{ SiteHelpers::avatar()}}
				 </span>
				<a href="{{ URL::to('user/profile') }}" >
				<span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">{{ Session::get('fid') }}</strong>
				 <br />
				{{ Lang::get('core.lastlogin') }} : <br />
				<small>{{ date("H:i F j, Y", strtotime(Session::get('ll'))) }}</small>				
				 </span> 
				 </span>
				 </a>
			</div>
			<div class="photo-header "> {{ SiteHelpers::avatar( 50 )}} </div>
		</li> 
		@foreach ($sidebar as $menu)
			 <li @if(Request::is($menu['module'])) class="active" @endif>
			 	<a 
					@if($menu['menu_type'] =='external')
						href="{{ $menu['url'] }}" 
					@else
						href="{{ URL::to($menu['module'])}}" 
					@endif				
			 	
				 @if(count($menu['childs']) > 0 ) class="expand level-closed" @endif>
				 	<i class="{{$menu['menu_icons']}}"></i> <span class="nav-label">
					
					@if(CNF_MULTILANG ==1 && isset($menu['menu_lang']['title'][Session::get('lang')]))
						{{ $menu['menu_lang']['title'][Session::get('lang')] }}
					@else
						{{$menu['menu_name']}}
					@endif						
					
					</span><span class="fa arrow"></span>	 
				</a> 
				@if(count($menu['childs']) > 0)
					<ul class="nav nav-second-level">
						@foreach ($menu['childs'] as $menu2)
						 <li @if(Request::is($menu2['module'])) class="active" @endif>
						 	<a 
								@if($menu2['menu_type'] =='external')
									href="{{ $menu2['url']}}" 
								@else
									href="{{ URL::to($menu2['module'])}}"  
								@endif									
							>
							<i class="{{$menu2['menu_icons']}}"></i>
							@if(CNF_MULTILANG ==1 && isset($menu2['menu_lang']['title'][Session::get('lang')]))
								{{ $menu2['menu_lang']['title'][Session::get('lang')] }}
							@else
								{{$menu2['menu_name']}}
							@endif	
							</a> 
							@if(count($menu2['childs']) > 0)
							<ul class="nav nav-third-level">
								@foreach($menu2['childs'] as $menu3)
									<li @if(Request::is($menu3['module'])) class="active" @endif>
										<a 
											@if($menu['menu_type'] =='external')
												href="{{ $menu3['url'] }}" 
											@else
												href="{{ URL::to($menu3['module'])}}" 
											@endif										
										
										>
										<i class="{{$menu3['menu_icons']}}"></i> 
										@if(CNF_MULTILANG ==1 && isset($menu3['menu_lang']['title'][Session::get('lang')]))
											{{ $menu3['menu_lang']['title'][Session::get('lang')] }}
										@else
											{{$menu3['menu_name']}}
										@endif											
											
										</a>
									</li>	
								@endforeach
							</ul>
							@endif							
						</li>							
						@endforeach
					</ul>
				@endif
			</li>
		@endforeach
      </ul>
	</div>
</nav>	  
	  
