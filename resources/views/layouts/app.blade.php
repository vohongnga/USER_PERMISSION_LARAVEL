<!DOCTYPE html>
<html lang="ja">
<!-- begin::Head -->

<head>
    <!--begin::Base Path (base relative path for assets of this page) -->
    <base href="../">
    <!--end::Base Path -->
    <meta charset="utf-8" />
    <meta http-equiv="content-language" content="ja">
    <title>@yield('title') - {{ __('messages.header') }}</title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!--begin::Fonts -->
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: { "families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"] },
            active: function () { sessionStorage.fonts = true; }
        });
    </script>

    <!--end::Fonts -->

    <!--end:: Global Mandatory Vendors -->

    <!--begin:: Global Optional Vendors -->
    <link href="{{ asset('admin/vendors/general/bootstrap-datetime-picker/css/bootstrap-datetimepicker.css') }}"
          rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/vendors/general/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet"
          type="text/css" />
    <link href="{{ asset('admin/vendors/general/animate.css/animate.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/vendors/general/toastr/build/toastr.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/vendors/general/socicon/css/socicon.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/vendors/custom/vendors/line-awesome/css/line-awesome.css') }}" rel="stylesheet"
          type="text/css" />
    <link href="{{ asset('admin/vendors/custom/vendors/flaticon/flaticon.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/vendors/custom/vendors/flaticon2/flaticon.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/vendors/general/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet"
          type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet"
          type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css">

    <!--end:: Global Optional Vendors -->

    <!--begin::Global Theme Styles(used by all pages) -->
    <link href="{{ asset('admin/css/style.bundle.css?v='.uniqid()) }}" rel="stylesheet" type="text/css" />
    <!--begin:: Global Mandatory Vendors -->
    <link href="{{ asset('admin/vendors/general/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet"
          type="text/css" />

    <!--end::Global Theme Styles -->

    <!--begin::Layout Skins(used by all pages) -->

    <!--end::Layout Skins -->
    <link rel="shortcut icon" href="" />
    @stack('css')
</head>

<!-- end::Head -->

<!-- begin::Body -->

<body
    class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-aside--minimize kt-page--loading">

<!-- begin:: Page -->

<!-- begin:: Header Mobile -->
<div id="kt_header_mobile" class="kt-header-mobile  kt-header-mobile--fixed ">
    <div class="kt-header-mobile__toolbar">
        <div class="kt-header-mobile__toolbar-toggler kt-header-mobile__toolbar-toggler--left"
             id="kt_aside_mobile_toggler"><span></span></div>
        <div class="kt-header-mobile__toolbar-toggler" id="kt_header_mobile_toggler"><span></span></div>
        <div class="kt-header-mobile__toolbar-topbar-toggler" id="kt_header_mobile_topbar_toggler"><i
                class="flaticon-more"></i></div>
    </div>
</div>

<!-- end:: Header Mobile -->
<div class="kt-grid kt-grid--hor kt-grid--root">
    <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">
            <!-- begin:: Header -->
            <div id="kt_header" class="kt-header kt-grid kt-grid--ver kt-header--fixed">
                <div class="d-flex flex-row h-50 justify-content-around border-bottom px-5">
                    <button class="kt-header-menu-wrapper-close" id="kt_header_menu_mobile_close_btn"><i
                            class="la la-close"></i></button>
                    <div class="kt-header-menu-wrapper kt-grid__item kt-grid__item--fluid mr-auto"
                         id="kt_header_menu_wrapper">
                        <div id="kt_header_menu"
                             class="kt-header-menu kt-header-menu-mobile  kt-header-menu--layout-default ">
                            <h4 class="ml-0 my-auto">
                                <a class="cl-mariner font-weight-bold" title="__('messages.header')" href="/">{{ __('messages.header') }}</a></h4>
                        </div>
                    </div>
                    <div class="kt-header__topbar">
                        <div class="kt-header__topbar-item kt-header__topbar-item--user">
                            <div class="dropdown d-flex align-items-center">
                                <a href="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                    {{ Auth::user()->name }}
                                </a>
                                <div class="dropdown-user dropdown-menu py-0 rounded-0 kt-bg-brand" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 32px, 0px);">
                                    <ul class="kt-nav py-0">
                                        <li class="kt-nav__item">
                                            <div class="kt-nav__item kt-nav__item--active">
                                                <form id="frm-logout" action="{{ route('logout') }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-bold text-center w-100 cl-white">
                                                        {{ __('messages.logout') }}
                                                    </button>
                                                </form>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!--end: User bar -->
                    </div>
                </div>
                <!-- end:: Header Topbar -->
            </div>
            <!-- end:: Header -->
            <!-- begin:: Content -->
            <div class="page-title-wrap d-flex justify-content-between align-items-center">
                <div class="page-title py-0 px-0">@yield('page-title')</div>
                <div class="action-title align-items-center">@yield('action-title')</div>
            </div>
        @yield('content')
        <!-- end:: Content -->
            <!-- begin:: Footer -->
            <div class="kt-footer kt-grid__item kt-grid kt-grid--desktop kt-grid--ver-desktop text-center"
                 id="kt_footer">
                <div class="kt-footer__copyright w-100 text-center">
                    <span class="cl-black">Copyright @ {{ date('Y') }} Co.,Ltd All Rights Reserved.</span>
                </div>
            </div>
            <!-- end:: Footer -->
        </div>
    </div>
</div>

<div id="overlay">
    <div class="cv-spinner">
        <span class="spinner"></span>
    </div>
</div>

<!-- end::Quick Panel -->

<!-- begin::Global Config(global config for global JS sciprts) -->
<script>
    var KTAppOptions = {
        "colors": {
            "state": {
                "brand": "#22b9ff",
                "light": "#ffffff",
                "dark": "#282a3c",
                "primary": "#5867dd",
                "success": "#34bfa3",
                "info": "#36a3f7",
                "warning": "#ffb822",
                "danger": "#fd3995"
            },
            "base": {
                "label": ["#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466"],
                "shape": ["#f0f3ff", "#d9dffa", "#afb4d4", "#646c9a"]
            }
        }
    };
</script>

<!-- end::Global Config -->

<!--begin:: Global Mandatory Vendors -->
<script src="{{ asset('admin/vendors/general/jquery/jquery.js') }}" type="text/javascript"></script>
<script src="{{ asset('admin/vendors/general/popper/popper.js') }}" type="text/javascript"></script>
<script src="{{ asset('admin/vendors/general/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('admin/vendors/general/tooltip/tooltip.min.js') }}" type="text/javascript"></script>
<!--end:: Global Mandatory Vendors -->

<!--begin:: Global Optional Vendors -->
<script src="{{ asset('admin/vendors/general/bootstrap-datetime-picker/js/bootstrap-datetimepicker.min.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('admin/vendors/general/bootstrap-datetime-picker/js/bootstrap-datetimepicker.ja.js') }}" type="text/javascript"></script>
<script src="{{ asset('admin/vendors/general/toastr/build/toastr.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('admin/vendors/general/toastr/build/toastr.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('admin/vendors/general/perfect-scrollbar/perfect-scrollbar.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('admin/vendors/general/waypoints/lib/jquery.waypoints.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('admin/vendors/general/counterup/jquery.counterup.js') }}" type="text/javascript"></script>
<script src="{{ asset('admin/vendors/general/bootstrap-tagsinput/bootstrap-tagsinput.js?v='.uniqid()) }}"></script>

<!--end:: Global Optional Vendors -->

<!--begin::Global Theme Bundle(used by all pages) -->
<script src="{{ asset('admin/js/scripts.bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('admin/js/common.js?v='.uniqid()) }}" type="text/javascript"></script>

<!--end::Global Theme Bundle -->
@stack('script')
</body>
<!-- end::Body -->

</html>
