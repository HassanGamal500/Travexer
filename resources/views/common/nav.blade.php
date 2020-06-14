<audio id="mysound" src="{{asset('theme-assets/sound/not-bad.mp3')}}"></audio>
<!-- BEGIN: Header-->
<nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-light"> 
    <div class="navbar-wrapper">
      <div class="navbar-container content">
        <div class="collapse navbar-collapse show" id="navbar-mobile">
          <ul class="nav navbar-nav mr-auto float-left">
            <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a></li>
            <li class="nav-item d-none d-md-block"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu"></i></a></li>
            <li class="nav-item d-none d-md-block"><a class="nav-link nav-link-expand" href="#"><i class="ficon ft-maximize"></i></a></li>
          </ul>
          <ul class="nav navbar-nav float-right">         
            <li class="dropdown dropdown-language nav-item">
              <a class="dropdown-toggle nav-link" id="dropdown-flag" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                @if(App::isLocale('ar'))
                <i class="flag-icon flag-icon-eg"></i>
                @else
                <i class="flag-icon flag-icon-us"></i>
                @endif
                <span class="selected-language"></span>
              </a>
              <div class="dropdown-menu" aria-labelledby="dropdown-flag">
                <div class="arrow_box">
                  <a class="dropdown-item" href="{{asset('admin/lang/en')}}"><i class="flag-icon flag-icon-us"></i>{{ trans('admin.English') }}</a>
                  <a class="dropdown-item" href="{{asset('admin/lang/ar')}}"><i class="flag-icon flag-icon-eg"></i>{{ trans('admin.Arabic') }}</a>
                </div>
              </div>
            </li>
            <li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon ft-mail">@if(messageCount() > 0)<span class="badge badge-pill badge-sm badge-danger badge-up badge-glow">{{ messageCount() }}</span>@endif</i></a>
                @if(App::isLocale('ar'))
                <ul class="dropdown-menu dropdown-menu-media dropdown-menu-left">
                @else
                <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                @endif
                    <div class="arrow_box_right">
                        <li class="dropdown-menu-header">
                            <h6 class="dropdown-header m-0"><span class="grey darken-2">{{ trans('admin.contacts') }}</span></h6>
                        </li>
                        <li class="scrollable-container media-list w-100">
                            @foreach(messageContact() as $contact)
                            <a href="javascript:void(0)">
                                <div class="media">
                                    <div class="media-body">
                                        <h6 class="media-heading text-bold-700">{{ $contact->contact_name }}</h6>
                                        <p class="notification-text font-small-3 text-muted text-bold-600">{{ $contact->contact_message }}</p><small>
                                        <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">{{ $contact->created_at }}</time></small>
                                    </div>
                                </div>
                            </a>
                            @endforeach
                            <a href="javascript:void(0)"></a>
                        </li>
                        <li class="dropdown-menu-footer"><a class="dropdown-item text-right info pr-1" href="{{ asset('admin/contact_web') }}">Read all</a></li>
                    </div>
                </ul>
            </li>
            <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown"><span class="avatar avatar-online"><img src="{{asset(auth()->guard('admin')->user()->image)}}" alt="avatar"></span></a>
                @if(App::isLocale('ar'))
                <div class="dropdown-menu dropdown-menu-left">
                @else
                <div class="dropdown-menu dropdown-menu-right">
                @endif
                    <div class="arrow_box_right">
                        <a class="dropdown-item" href="{{url(route('edit_profile', auth()->guard('admin')->user()->id))}}">
                            <i class="ft-user"></i> {{ trans('admin.profile_link') }}</a>
                            <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ URL::to(route('admin.logout'))}}"><i class="ft-power"></i> {{ trans('admin.sign_out') }}</a>
                    </div>
                </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>
  <!-- END: Header-->
