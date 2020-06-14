<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta name="description" content="Chameleon Admin is a modern Bootstrap 4 webapp &amp; admin dashboard html template with a large number of components, elegant design, clean and organized code.">
        <meta name="keywords" content="admin template, Chameleon admin template, dashboard template, gradient admin template, responsive admin template, webapp, eCommerce dashboard, analytic dashboard">
        <meta name="author" content="ThemeSelect">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>{{ trans('admin.login') }}</title>
        <link rel="apple-touch-icon" href="{{asset('theme-assets/images/ico/apple-icon-120.png')}}">
        <link rel="shortcut icon" type="image/x-icon" href="{{asset('theme-assets/images/ico/fav.png')}}">
        <link href="https://fonts.googleapis.com/css?family=Muli:300,300i,400,400i,600,600i,700,700i%7CComfortaa:300,400,700" rel="stylesheet">
        <link href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css" rel="stylesheet">
        <!-- BEGIN VENDOR CSS-->
        <!-- <link rel="stylesheet" type="text/css" href="theme-assets/css/vendors.css"> -->
        <link rel="stylesheet" type="text/css" href="{{asset('theme-assets/vendors/css/vendors.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('theme-assets/vendors/css/forms/toggle/switchery.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('theme-assets/css/plugins/forms/switch.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('theme-assets/css/core/colors/palette-switch.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('theme-assets/vendors/css/charts/chartist.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('theme-assets/vendors/css/charts/chartist-plugin-tooltip.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('theme-assets/vendors/css/file-uploaders/dropzone.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('theme-assets/vendors/css/forms/icheck/icheck.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('theme-assets/vendors/css/forms/icheck/custom.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('theme-assets/vendors/css/timeline/vertical-timeline.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('theme-assets/vendors/css/tables/datatable/datatables.min.css')}}">
        <!-- END VENDOR CSS-->
        <!-- BEGIN: Theme CSS-->
        <link rel="stylesheet" type="text/css" href="{{asset('theme-assets/css/bootstrap.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('theme-assets/css/bootstrap-extended.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('theme-assets/css/colors.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('theme-assets/css/components.min.css')}}">
        <!-- END: Theme CSS-->
        <!-- BEGIN CHAMELEON  CSS-->
        <link rel="stylesheet" type="text/css" href="{{asset('theme-assets/css/app-lite.css')}}">
        <!-- END CHAMELEON  CSS-->
        <!-- BEGIN Page Level CSS-->
        <link rel="stylesheet" type="text/css" href="{{asset('theme-assets/css/core/menu/menu-types/vertical-menu.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('theme-assets/css/core/colors/palette-gradient.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('theme-assets/fonts/simple-line-icons/style.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('theme-assets/css/core/colors/palette-gradient.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('theme-assets/css/pages/timeline.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('theme-assets/css/plugins/file-uploaders/dropzone.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('theme-assets/css/pages/dashboard-ecommerce.min.css')}}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.0/css/perfect-scrollbar.min.css">
        <link rel="stylesheet" type="text/css" href="{{asset('theme-assets/css/style.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('theme-assets/css/pages/login-register.min.css')}}">
        <!-- END Page Level CSS-->
        <!-- BEGIN Custom CSS-->
        <!-- END Custom CSS-->
    </head>
  <!-- END: Head-->

  <!-- BEGIN: Body-->
  <body class="vertical-layout vertical-menu 1-column  bg-full-screen-image blank-page blank-page" data-open="click" data-menu="vertical-menu" data-color="bg-gradient-x-purple-blue" data-col="1-column">
 
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-wrapper-before"></div>
            <div class="content-header row"></div>
            <div class="content-body">
                <section class="flexbox-container">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <div class="col-lg-4 col-md-6 col-10 box-shadow-2 p-0">
                            <div class="card border-grey border-lighten-3 px-1 py-1 m-0">
                                <div class="card-header border-0">
                                    <div class="text-center mb-1">
                                        <img src="{{asset('theme-assets/images/logo/logo.png')}}" alt="branding logo">
                                    </div>
                                    <div class="font-large-1  text-center">                       
                                        {{ trans('admin.Member Login') }}
                                    </div>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form class="form-horizontal" method="post" action="{{ route('admin.login.post') }}" novalidate>
                                            @csrf
                                            @if(session()->has('error'))
                                            <div class="alert alert-danger alert-dismissible mb-2" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                                <strong>{{session()->get('error')}}</strong>
                                            </div>
                                            @endif
                                            <fieldset class="form-group position-relative has-icon-left">
                                                <input type="text" class="form-control round" id="user-name" name="email" value="{{ old('email') }}" placeholder="{{trans('admin.enter email')}}" required>
                                                <div class="form-control-position">
                                                    <i class="ft-user"></i>
                                                </div>
                                            </fieldset>
                                            <fieldset class="form-group position-relative has-icon-left">
                                                <input type="password" class="form-control round" id="user-password" name="password" placeholder="{{trans('admin.enter password')}}" required>
                                                <div class="form-control-position">
                                                    <i class="ft-lock"></i>
                                                </div>
                                            </fieldset>
                                            <div class="form-group row">
                                                <div class="col-md-6 col-12 text-center text-sm-left">
                                                    <div class="custom-control custom-checkbox small">
                                                        <input type="checkbox" name="remember" class="custom-control-input" id="customCheck">
                                                        <label class="custom-control-label" for="customCheck">{{trans('admin.remember me')}}</label>
                                                    </div>
                                                </div>
                                            </div>                           
                                            <div class="form-group text-center">
                                                <button type="submit" class="btn round btn-block btn-glow btn-bg-gradient-x-orange-yellow col-12 mr-1 mb-1">{{ trans('admin.login') }}</button>    
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <!-- END: Content-->

    <!-- BEGIN VENDOR JS-->
    <script src="{{asset('theme-assets/vendors/js/vendors.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('theme-assets/vendors/js/forms/toggle/switchery.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('theme-assets/js/scripts/forms/switch.min.js')}}" type="text/javascript"></script>
    <!-- BEGIN VENDOR JS-->
    <!-- BEGIN PAGE VENDOR JS-->
    @if(Request::is('/'))
    <script src="{{asset('theme-assets/vendors/js/charts/chartist.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('theme-assets/vendors/js/charts/chartist-plugin-tooltip.min.js')}}" type="text/javascript"></script>
    @endif
    <script src="{{asset('theme-assets/vendors/js/timeline/horizontal-timeline.js')}}" type="text/javascript"></script>
    <script src="{{asset('theme-assets/vendors/js/extensions/dropzone.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('theme-assets/vendors/js/forms/icheck/icheck.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('theme-assets/vendors/js/forms/validation/jqBootstrapValidation.js')}}" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.0/perfect-scrollbar.min.js"></script>
    <!-- END PAGE VENDOR JS-->
    <!-- BEGIN CHAMELEON  JS-->
    <!-- <script src="theme-assets/js/core/app-menu-lite.js" type="text/javascript"></script>
    <script src="theme-assets/js/core/app-lite.js" type="text/javascript"></script> -->
    <script src="{{asset('theme-assets/js/core/app-menu.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('theme-assets/js/core/app.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('theme-assets/js/scripts/customizer.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('theme-assets/vendors/js/jquery.sharrre.js')}}" type="text/javascript"></script>
    <!-- END CHAMELEON  JS-->
    <!-- BEGIN PAGE LEVEL JS-->
    <!-- <script src="theme-assets/js/scripts/pages/dashboard-lite.js" type="text/javascript"></script> -->
    @if(Request::is('/'))
    <script src="{{asset('theme-assets/js/scripts/pages/dashboard-ecommerce.min.js')}}" type="text/javascript"></script>
    @endif
    <script src="{{asset('theme-assets/js/scripts/forms/form-login-register.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('theme-assets/vendors/js/tables/datatable/datatables.min.js')}}" type="text/javascript"></script>
    <!-- END PAGE LEVEL JS-->

</body>
<!-- END: Body-->
</html>