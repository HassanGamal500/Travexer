<!DOCTYPE html>
@if(App::isLocale('ar'))
<html class="loading" lang="en" data-textdirection="rtl">
@else
<html class="loading" lang="en" data-textdirection="ltr">
@endif
@include('common.meta')
<body class="vertical-layout vertical-menu 2-columns   fixed-navbar" data-open="click" data-menu="vertical-menu" data-color="bg-warning" data-col="2-columns">

    <div class="pace  pace-inactive">
        <div class="pace-progress" data-progress-text="100%" data-progress="99" style="transform: translate3d(100%, 0px, 0px);">
            <div class="pace-progress-inner"></div>
        </div>
        <div class="pace-activity"></div>
    </div>

@include('common.nav')

@include('common.sidebar')

@yield('content')

@include('common.footer')

@include('common.script')

</body>

</html>
