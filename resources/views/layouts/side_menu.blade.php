	<!--begin::Wrapper-->
	<div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
		<!--begin::Sidebar-->
		<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
			<!--begin::Logo-->
			<div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
				<!--begin::Logo image-->
				<a href="{{url('dashboard')}}">
					<img alt="Logo" src="{{ asset('assets/media/logos/limage.png')}}" class="h-45px app-sidebar-logo-default" />
					<img alt="Logo" src="{{ asset('assets/media/logos/limage.png')}}" class="h-15px app-sidebar-logo-minimize" />
				</a>
				<!--end::Logo image-->
				<!--begin::Sidebar toggle-->
				<div id="kt_app_sidebar_toggle" class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary body-bg h-30px w-30px position-absolute top-50 start-100 translate-middle rotate" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="app-sidebar-minimize">
					<!--begin::Svg Icon | path: icons/duotune/arrows/arr079.svg-->
					<span class="svg-icon svg-icon-2 rotate-180">
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path opacity="0.5" d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z" fill="currentColor" />
							<path d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z" fill="currentColor" />
						</svg>
					</span>
					<!--end::Svg Icon-->
				</div>
				<!--end::Sidebar toggle-->
			</div>
			<!--end::Logo-->
			<!--begin::sidebar menu-->
			<div class="app-sidebar-menu overflow-hidden flex-column-fluid">
				<!--begin::Menu wrapper-->
				<div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer" data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
					<!--begin::Menu-->
					<div class="menu menu-column menu-rounded menu-sub-indention px-3" id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
						<!--begin:Menu item-->


						<!--begin:Menu item-->
						<div class="menu-item">
							<!--begin:Menu link-->
							<a class="menu-link {{request()->is('dashboard')?'active' :''}}" href="{{url('dashboard')}}">
								<span class="menu-icon">
									<span class="svg-icon svg-icon-2">
										<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
											<rect x="2" y="2" width="9" height="9" rx="2" fill="currentColor" />
											<rect opacity="0.3" x="13" y="2" width="9" height="9" rx="2" fill="currentColor" />
											<rect opacity="0.3" x="13" y="13" width="9" height="9" rx="2" fill="currentColor" />
											<rect opacity="0.3" x="2" y="13" width="9" height="9" rx="2" fill="currentColor" />
										</svg>
									</span>
								</span>
								<span class="menu-title">Dashboard</span>
							</a>
							<!--end:Menu link-->
						</div>
						<!--end:Menu item-->

						<!--end:Menu item-->
						<!--begin:Menu item-->
						<div class="menu-item pt-5">
							<!--begin:Menu content-->
							<div class="menu-content">
								<span class="menu-heading fw-bold text-uppercase fs-7">Masters</span>
							</div>
							<!--end:Menu content-->
						</div>
						<!--end:Menu item-->


						<!--begin:Menu item-->
						@if(auth()->user()->is_super_admin ==1 ||auth()->user()->can('department-view'))
						<div class="menu-item">
							<!--begin:Menu link-->
							<a class="menu-link {{request()->is('department')?'active' :''}}" href="{{url('department')}}">
								<span class="menu-icon">
									<span class="svg-icon svg-icon-2">
										<i class="fas fa-chalkboard-teacher"></i>
									</span>
								</span>
								<span class="menu-title">Department</span>
							</a>
							<!--end:Menu link-->
						</div>
						@endif
						<!--end:Menu item-->
						@if(auth()->user()->is_super_admin ==1 ||auth()->user()->can('designation-view'))
						<!--begin:Menu item-->
						<div class="menu-item">
							<!--begin:Menu link-->
							<a class="menu-link {{request()->is('designation')?'active' :''}}" href="{{url('designation')}}">
								<span class="menu-icon">
									<span class="svg-icon svg-icon-2">
										<i class="fas fa-address-card"></i>
									</span>
								</span>
								<span class="menu-title">Designation</span>
							</a>
							<!--end:Menu link-->
						</div>
						<!--end:Menu item-->
						@endif

						@if(auth()->user()->is_super_admin ==1 ||auth()->user()->can('employee-view'))
						<!--begin:Menu item-->
						<div class="menu-item ">
							<!--begin:Menu link-->
							<a class="menu-link {{request()->is('employees')?'active' :''}} " href="{{url('employees')}}">
								<span class="menu-icon">
									<span class="svg-icon svg-icon-2">
										<i class="fas fa-user-graduate"></i>
									</span>
								</span>
								<span class="menu-title">Employee</span>
							</a>
							<!--end:Menu link-->
						</div>
						<!--end:Menu item-->
						@endif
						<!--end:Menu item-->


						@if(auth()->user()->is_super_admin ==1 ||auth()->user()->can('workflow-view'))
						<!--begin:Menu item-->
						<div class="menu-item">
							<!--begin:Menu link-->
							<a class="menu-link {{request()->is('workflow')?'active' :''}}" href="{{url('workflow')}}">
								<span class="menu-icon">
									<span class="svg-icon svg-icon-2">
										<i class="fas fa-drafting-compass"></i>
									</span>
								</span>
								<span class="menu-title">Workflow</span>
							</a>
							<!--end:Menu link-->
						</div>

						@endif
						<!--end:Menu item-->


						<!--end:Menu item-->
						@if(auth()->user()->is_super_admin ==1 ||auth()->user()->can('document-type-view'))

						<!--begin:Menu item-->
						<div class="menu-item">
							<!--begin:Menu link-->
							<a class="menu-link {{request()->is('documentType')?'active' :''}}" href="{{url('documentType')}}">
								<span class="menu-icon">
									<span class="svg-icon svg-icon-2">
										<i class="fas fa-file-alt"></i>
									</span>
								</span>
								<span class="menu-title">Document Type</span>
							</a>
							<!--end:Menu link-->
						</div>
						<!--end:Menu item-->
						@endif
						<!--end:Menu item-->

						<!--begin:Menu item-->
						<div class="menu-item pt-5">
							<!--begin:Menu content-->
							<div class="menu-content">
								<span class="menu-heading fw-bold text-uppercase fs-7">Transaction</span>
							</div>
							<!--end:Menu content-->
						</div>
						<!--end:Menu item-->

						@if(auth()->user()->is_super_admin ==1 ||auth()->user()->can('project-view'))
						<!--begin:Menu item-->
						<div class="menu-item">
							<!--begin:Menu link-->
							<a class="menu-link {{request()->is('projects')?'active' :''}}" href="{{url('projects')}}">
								<span class="menu-icon">
									<span class="svg-icon svg-icon-2">
										<i class="fas fa-drafting-compass"></i>
									</span>
								</span>
								<span class="menu-title">Projects</span>
							</a>
							<!--end:Menu link-->
						</div>
						<!--end:Menu item-->
						@endif
						<!--end:Menu item-->


						@if(auth()->user()->is_super_admin ==1 ||auth()->user()->can('project-view'))
						<!--begin:Menu item-->
						<div class="menu-item">
							<!--begin:Menu link-->
							<a class="menu-link {{request()->is('doclisting')?'active' :''}}" href="{{url('doclisting')}}">
								<span class="menu-icon">
									<span class="svg-icon svg-icon-2">
										<i class="fas fa-drafting-compass"></i>
									</span>
								</span>
								<span class="menu-title">Document Listing</span>
							</a>
							<!--end:Menu link-->
						</div>
						<!--end:Menu item-->
						@endif
						<!--end:Menu item-->


						<!--begin:Menu item-->
						<div class="menu-item pt-5">
							<!--begin:Menu content-->
							<div class="menu-content">
								<span class="menu-heading fw-bold text-uppercase fs-7">Settings</span>
							</div>
							<!--end:Menu content-->
						</div>
						<!--end:Menu item-->

						@if(auth()->user()->is_super_admin ==1 ||auth()->user()->can('role-view'))
						<div class="menu-item">
							<!--begin:Menu link-->
							<a class="menu-link {{request()->is('roles')?'active' :''}}" href="{{url('roles')}}">
								<span class="menu-icon">
									<span class="svg-icon svg-icon-2">
										<i class="fas fa-drafting-compass"></i>
									</span>
								</span>
								<span class="menu-title">Privileges</span>
							</a>
							<!--end:Menu link-->
						</div>
						@endif

						<!--end:Menu item-->
						@if(auth()->user()->is_super_admin ==1 ||auth()->user()->can('user-view'))

						<div class="menu-item">
							<!--begin:Menu link-->
							<a class="menu-link {{request()->is('users')?'active' :''}}" href="{{url('users')}}">
								<span class="menu-icon">
									<span class="svg-icon svg-icon-2">
										<i class="fas fa-drafting-compass"></i>
									</span>
								</span>
								<span class="menu-title">User Enroll</span>
							</a>
							<!--end:Menu link-->
						</div>
						<!--end:Menu item-->
						@endif
						<!--begin:Menu item-->
						<div class="menu-item pt-5">
							<!--begin:Menu content-->
							<div class="menu-content">
								<span class="menu-heading fw-bold text-uppercase fs-7">Reports</span>
							</div>
							<!--end:Menu content-->
						</div>
						<!--end:Menu item-->


						<div class="menu-item">
							<!--begin:Menu link-->
							<a class="menu-link {{request()->is('datewiseReportIndex')?'active' :''}}" href="{{url('datewiseReportIndex')}}">
								<span class="menu-icon">
									<span class="svg-icon svg-icon-2">
										<i class="fas fa-drafting-compass"></i>
									</span>
								</span>
								<span class="menu-title">Datewise Report</span>
							</a>
							<!--end:Menu link-->
						</div>
						<div class="menu-item">
							<!--begin:Menu link-->
							<a class="menu-link {{request()->is('projectwiseReportIndex')?'active' :''}}" href="{{url('projectwiseReportIndex')}}">
								<span class="menu-icon">
									<span class="svg-icon svg-icon-2">
										<i class="fas fa-drafting-compass"></i>
									</span>
								</span>
								<span class="menu-title">Projectwise Report</span>
							</a>
							<!--end:Menu link-->
						</div>
						<div class="menu-item">
							<!--begin:Menu link-->
							<a class="menu-link {{request()->is('documentWiseReportIndex')?'active' :''}}" href="{{url('documentWiseReportIndex')}}">
								<span class="menu-icon">
									<span class="svg-icon svg-icon-2">
										<i class="fas fa-drafting-compass"></i>
									</span>
								</span>
								<span class="menu-title">Documentwise Report</span>
							</a>
							<!--end:Menu link-->
						</div>

						<div class="menu-item">
							<!--begin:Menu link-->
							<a class="menu-link {{request()->is('userWiseReportIndex')?'active' :''}}" href="{{url('userWiseReportIndex')}}">
								<span class="menu-icon">
									<span class="svg-icon svg-icon-2">
										<i class="fas fa-drafting-compass"></i>
									</span>
								</span>
								<span class="menu-title">Userwise Report</span>
							</a>
							<!--end:Menu link-->
						</div>
					</div>
					<!--end::Menu-->
				</div>
				<!--end::Menu wrapper-->
			</div>
			<!--end::sidebar menu-->

		</div>
		<!--end::Sidebar-->
		<!--begin::Main-->
		<div class="app-main flex-column flex-row-fluid" id="kt_app_main">