<!DOCTYPE html>

<html lang="en">
<!--begin::Head-->

<head>
    <base href="../" />
    <title>Switch</title>
    <meta charset="utf-8" />
    <meta name="description"
        content="The most advanced Bootstrap Admin Theme on Themeforest trusted by 100,000 beginners and professionals. Multi-demo, Dark Mode, RTL support and complete React, Angular, Vue, Asp.Net Core, Rails, Spring, Blazor, Django, Flask & Laravel versions. Grab your copy now and get life-time updates for free." />
    <meta name="keywords"
        content="metronic, bootstrap, bootstrap 5, angular, VueJs, React, Asp.Net Core, Rails, Spring, Blazor, Django, Flask & Laravel starter kits, admin themes, web design, figma, web development, free templates, free admin themes, bootstrap theme, bootstrap template, bootstrap dashboard, bootstrap dak mode, bootstrap button, bootstrap datepicker, bootstrap timepicker, fullcalendar, datatables, flaticon" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title"
        content="Metronic - Bootstrap 5 HTML, VueJS, React, Angular. Laravel, Asp.Net Core, Ruby on Rails, Spring Boot, Blazor, Django, Express Node.js & Flask Admin Dashboard Theme" />
    <meta property="og:url" content="https://keenthemes.com/metronic" />
    <meta property="og:site_name" content="Keenthemes | Metronic" />
    <meta http-equiv="Content-Security-Policy"
        content="
    default-src 'self';
    script-src 'self' 'unsafe-inline'  https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/ https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js https://code.jquery.com/jquery-3.3.1.slim.min.js https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js https://cdn.datatables.net/ https://ajax.googleapis.com/ https://unpkg.com;
    {{-- script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/ https://cdn.datatables.net/ https://ajax.googleapis.com/ https://unpkg.com; --}}
    style-src 'self' 'unsafe-inline' https://fonts.googleapis.com/css https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/ 'unsafe-inline' 'self';
    img-src 'self' data: https://images/;
    connect-src 'self';
    font-src 'self' https://fonts.gstatic.com/ data:;
    frame-src 'none';
    object-src 'none';
" />
    <link rel="canonical" href="https://preview.keenthemes.com/metronic8" />
    <link rel="shortcut icon" href="{{ asset('assets/media/logos/limage.png') }}" />
    <!--begin::Fonts(mandatory for all pages)-->
    <!-- //dhana changed -->
    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" /> -->
    <!--end::Fonts-->
    <!--begin::Vendor Stylesheets(used for this page only)-->
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet"
        type="text/css" />
    <!--end::Vendor Stylesheets-->
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <script data-require="jquery@*" data-semver="3.0.0" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.js">
    </script>
    {{-- <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.js"></script> --}}


    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>

    <link href="{{ asset('assets/css/basicStyle.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('assets/js/basicFunctions.js') }}"></script>
    <script>
        var hostUrl = "assets/";
    </script>
    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    {{-- <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script> --}}
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Vendors Javascript(used for this page only)-->
    {{-- <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script> --}}
    <!--end::Vendors Javascript-->
    <!--begin::Custom Javascript(used for this page only)-->

    <!--end::Global Stylesheets Bundle-->

    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet"
        type="text/css" />
    {{-- <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script> --}}
    <script src="{{ asset('assets/js/custom/apps/support-center/tickets/create.js') }}"></script>

    <script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/custom/widgets.js') }}"></script>
    <script src="{{ asset('assets/js/custom/apps/chat/chat.js') }}"></script>
    <script src="{{ asset('assets/js/custom/utilities/modals/upgrade-plan.js') }}"></script>
    <script src="{{ asset('assets/js/custom/utilities/modals/create-app.js') }}"></script>
    <script src="{{ asset('assets/js/custom/utilities/modals/users-search.js') }}"></script>
    <script data-require="jquery@*" data-semver="3.0.0" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.js">
    </script>

</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true"
    data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true"
    data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true"
    data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">
    @include('loader')
    <!--begin::Theme mode setup on page load-->
    <script>
        var defaultThemeMode = "light";
        var themeMode;
        if (document.documentElement) {
            if (document.documentElement.hasAttribute("data-theme-mode")) {
                themeMode = document.documentElement.getAttribute("data-theme-mode");
            } else {
                if (localStorage.getItem("data-theme") !== null) {
                    themeMode = localStorage.getItem("data-theme");
                } else {
                    themeMode = defaultThemeMode;
                }
            }
            if (themeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            }
            document.documentElement.setAttribute("data-theme", themeMode);
        }
    </script>
    <!--end::Theme mode setup on page load-->
    <!--begin::App-->
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <!--begin::Page-->
        <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
            <!--begin::Header-->
            <div id="kt_app_header" class="app-header">
                <!--begin::Header container-->
                <div class="app-container container-fluid d-flex align-items-stretch justify-content-between"
                    id="kt_app_header_container">
                    <!--begin::Sidebar mobile toggle-->
                    <div class="d-flex align-items-center d-lg-none ms-n3 me-1 me-md-2" title="Show sidebar menu">
                        <div class="btn btn-icon btn-active-color-primary w-35px h-35px"
                            id="kt_app_sidebar_mobile_toggle">
                            <!--begin::Svg Icon | path: icons/duotune/abstract/abs015.svg-->
                            <span class="svg-icon svg-icon-2 svg-icon-md-1">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z"
                                        fill="currentColor" />
                                    <path opacity="0.3"
                                        d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z"
                                        fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </div>
                    </div>
                    <!--end::Sidebar mobile toggle-->
                    <!--begin::Mobile logo-->
                    <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
                        <a href="../../demo1/dist/index.html" class="d-lg-none">
                            <img alt="Logo" src="assets/media/logos/limage.png" class="h-30px" />
                        </a>
                    </div>
                    <!--end::Mobile logo-->
                    <!--begin::Header wrapper-->
                    <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1"
                        id="kt_app_header_wrapper">
                        <!--begin::Menu wrapper-->
                        <div class="app-header-menu app-header-mobile-drawer align-items-stretch" data-kt-drawer="true"
                            data-kt-drawer-name="app-header-menu" data-kt-drawer-activate="{default: true, lg: false}"
                            data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="end"
                            data-kt-drawer-toggle="#kt_app_header_menu_toggle" data-kt-swapper="true"
                            data-kt-swapper-mode="{default: 'append', lg: 'prepend'}"
                            data-kt-swapper-parent="{default: '#kt_app_body', lg: '#kt_app_header_wrapper'}">
                            <!--begin::Menu-->
                            <div class="menu menu-rounded menu-column menu-lg-row my-5 my-lg-0 align-items-center fw-semibold px-2 px-lg-0"
                                id="kt_app_header_menu" data-kt-menu="true">
                                <h1>Online Approval Management System</h1>

                            </div>
                            <!--end::Menu-->
                        </div>
                        <!--end::Menu wrapper-->
                        <!--begin::Navbar-->
                        <div class="app-navbar flex-shrink-0">
                            {{-- <h3>Loggined In:{{Session('logginedUser')}}</h3> --}}
                            <div class="app-navbar-item ms-1 ms-md-3" id="kt_header_user_menu_toggle">
                                <h6 class="badge switchPrimaryBtn badge-lg">{{ Session('logginedUser') }}</h6>
                                &nbsp;&nbsp;
                                <div class="symbol symbol-30px symbol-md-40px" data-kt-menu-trigger="{default: "
                                    click", lg: "hover" }" data-kt-menu-attach="parent"
                                    data-kt-menu-placement="bottom-end">
                                    <?php
                                    $pic = App\Models\Employee::where(['id' => Session('employeeId')])
                                        ->pluck('profile_image')
                                        ->first();
                                    ?>
                                    @if (!$pic)
                                        <div class="symbol symbol-35px ">
                                            <span class="symbol-label"
                                                style="background-image:url({{ asset('images') . '/' . 'admin-icon-3.jpg' }})"></span>
                                        </div>
                                        {{-- <img src="{{ asset('images') . '/' . 'admin-icon-3.jpg' }}" alt="user" width="48px" height="54px"> --}}
                                    @else
                                        <div class="symbol symbol-35px ">
                                            <span class="symbol-label"
                                                style="background-image:url({{ asset('images') . '/Employee/' . $pic }})"></span>
                                        </div>
                                        {{-- <img src="{{ asset('images') . '/Employee/' . $pic }}" alt="user" width="48px" height="54px"> --}}
                                    @endif


                                </div>
                                {{-- @if (Session('profile'))
                             <div class="cursor-pointer symbol symbol-30px symbol-md-40px"
                                    data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                                    data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                               <img src="{{ asset(Session('profile'))}}" alt="user" width="48px" height="54px"/>
                            </div>
                            @else
                            <div class="cursor-pointer symbol symbol-30px symbol-md-40px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                                <img src="{{ asset('images/admin-icon-3.jpg') }}" alt="user" width="48px" height="54px" />
                            </div>
                            @endif --}}

                            </div>

                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-muted menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px"
                                data-kt-menu="true" data-kt-element="theme-mode-menu">
                                <a>logout</a>
                            </div>
                            <div class="app-navbar-item ms-1 ms-md-3" id="kt_header_user_menu_toggle">
                                <!--begin::Menu wrapper-->

                                <button type="button"
                                    onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();"
                                    class="btn btn-sm btn-icon btn-light btn-active-danger" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Logout">
                                    <i class="fas fa-sign-out-alt"></i>

                                </button>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>


                                <!--end::Menu wrapper-->
                            </div>
                            <!--end::User menu-->

                        </div>
                        <!--end::Navbar-->
                    </div>
                    <!--end::Header wrapper-->
                </div>
                <!--end::Header container-->
            </div>
            <!--end::Header-->
