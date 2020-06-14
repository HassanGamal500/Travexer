<!-- BEGIN: Main Menu-->
<div class="main-menu menu-fixed menu-accordion menu-shadow menu-dark" data-scroll-to-active="false" data-img="{{url('theme-assets/images/backgrounds/04.jpg')}}">
    <div class="navbar-header">
      <ul class="nav navbar-nav flex-row">
        <li class="nav-item mr-auto">
          <a class="navbar-brand" href="{{asset('/admin')}}">
            <img class="brand-logo" alt="Chameleon admin logo" src="{{url('theme-assets/images/ico/fav.png')}}">
            <h3 class="brand-text">Travexer</h3>
          </a>
        </li>
        <li class="nav-item d-md-none"><a class="nav-link close-navbar"><i class="ft-x"></i></a></li>
      </ul>
    </div>
    <div class="navigation-background"></div>
    <div class="main-menu-content">
      <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
        <li class="nav-item {{request()->is() == 'admin' ? 'open' : ''}}"><a href="{{asset('/admin')}}"><i class="ft-home"></i><span class="menu-title" data-i18n="">{{ trans('admin.header_dashboard') }}</span></a>
        </li>
        @if(role('user_view') == 1 || role('guide_view') == 1 || role('company_view') == 1 || user_type() == 1)
        <li class="nav-item has-sub 
          {{setOpen('admin/users')}}{{setOpen('admin/add_user')}}{{setOpen('admin/edit_user')}}
          {{setOpen('admin/guides')}}{{setOpen('admin/add_guide')}}{{setOpen('admin/edit_guide')}}
          {{setOpen('admin/companies')}}{{setOpen('admin/add_company')}}{{setOpen('admin/edit_company')}}">
          <a href="#"><i class="ft-users"></i><span class="menu-title" data-i18n="">{{ trans('admin.users') }}</span></a>
          <ul class="menu-content">
            @if(role('user_view') == 1 || user_type() == 1)
            <li class="{{setActive('admin/users')}}{{setActive('admin/add_user')}}{{setActive('admin/edit_user')}}"><a class="menu-item" href="{{asset('admin/users')}}">{{ trans('admin.link_customers') }}</a>
            </li>
            @endif
            @if(role('guide_view') == 1 || user_type() == 1)
            <li class="{{setActive('admin/guides')}}{{setActive('admin/add_guide')}}{{setActive('admin/edit_guide')}}"><a class="menu-item" href="{{asset('admin/guides')}}">{{ trans('admin.guides') }}</a>
            </li>
            @endif
            @if(role('company_view') == 1 || user_type() == 1)
            <li class="{{setActive('admin/companies')}}{{setActive('admin/add_company')}}{{setActive('admin/edit_company')}}"><a class="menu-item" href="{{asset('admin/companies')}}">{{ trans('admin.companies') }}</a>
            </li>
            @endif
          </ul>
        </li>
        @endif
        @if(role('service_view') == 1 || user_type() == 1)
        <li class="nav-item {{setOpen('admin/services')}}{{setOpen('admin/add_service')}}{{setOpen('admin/edit_service')}}"><a href="{{asset('admin/services')}}"><i class="ft-feather"></i><span class="menu-title" data-i18n="">{{ trans('admin.service') }}</span></a>
        </li>
        @endif
        @if(role('advertisement_view') == 1 || user_type() == 1)
        <li class="nav-item {{setOpen('admin/advertisements')}}{{setOpen('admin/add_advertisement')}}{{setOpen('admin/edit_advertisement')}}"><a href="{{asset('admin/advertisements')}}"><i class="ft-image"></i><span class="menu-title" data-i18n="">{{ trans('admin.advertisements') }}</span></a>
        </li>
        @endif
        @if(role('notification_view') == 1 || user_type() == 1)
        <li class="nav-item {{setOpen('admin/notifications')}}{{setOpen('admin/add_notification')}}"><a href="{{asset('admin/notifications')}}"><i class="ft-bell"></i><span class="menu-title" data-i18n="">{{ trans('admin.notifications') }}</span></a>
        </li>
        @endif
        @if(role('admin_view') == 1 || user_type() == 1)
        <li class="nav-item {{setOpen('admin/administrations')}}{{setOpen('admin/add_administration')}}{{setOpen('admin/edit_administration')}}"><a href="{{asset('admin/administrations')}}"><i class="ft-aperture"></i><span class="menu-title" data-i18n="">{{ trans('admin.administration') }}</span></a>
        </li>
        @endif
        @if(role('broadcast_view') == 1 || user_type() == 1)
        <li class="nav-item {{setOpen('admin/broadcasts')}}"><a href="{{asset('admin/broadcasts')}}"><i class="ft-radio"></i><span class="menu-title" data-i18n="">{{ trans('admin.broadcasts') }}</span></a>
        </li>
        @endif
        @if(role('trip_view') == 1 || user_type() == 1)
        <li class="nav-item {{setOpen('admin/trips')}}{{setOpen('admin/info')}}"><a href="{{asset('admin/trips')}}"><i class="icon-plane"></i><span class="menu-title" data-i18n="">{{ trans('admin.trips') }}</span></a>
        </li>
        @endif
        @if(role('subscribe_view') == 1 || user_type() == 1)
        <li class="nav-item {{setOpen('admin/subscribes')}}"><a href="{{asset('admin/subscribes')}}"><i class="ft-tag"></i><span class="menu-title" data-i18n="">{{ trans('admin.subscribes') }}</span></a>
        </li>
        @endif
        @if(role('order_view') == 1 || user_type() == 1)
        <li class="nav-item has-sub {{setOpen('admin/order_guide')}}{{setOpen('admin/order_trip')}}"><a href="#"><i class="ft-shopping-cart"></i><span class="menu-title" data-i18n="">{{ trans('admin.orders') }}</span></a>
          <ul class="menu-content">
            <li class="{{setActive('admin/order_guide')}}"><a class="menu-item" href="{{asset('admin/order_guide')}}">{{ trans('admin.guides') }}</a>
            </li>
            <li class="{{setActive('admin/order_trip')}}"><a class="menu-item" href="{{asset('admin/order_trip')}}">{{ trans('admin.trips') }}</a>
            </li>
          </ul>
        </li>
        @endif
        @if(role('country_view') == 1 || role('city_view') == 1 || role('nationality_view') == 1 || user_type() == 1)
        <li class="nav-item has-sub 
          {{setOpen('admin/countries')}}{{setOpen('admin/add_country')}}{{setOpen('admin/edit_country')}}
          {{setOpen('admin/cities')}}{{setOpen('admin/add_city')}}{{setOpen('admin/edit_city')}}
          {{setOpen('admin/nationalities')}}{{setOpen('admin/add_nationality')}}{{setOpen('admin/edit_nationality')}}"><a href="#"><i class="ft-map-pin"></i><span class="menu-title" data-i18n="">{{ trans('admin.location') }}</span></a>
          <ul class="menu-content">
            @if(role('country_view') == 1 || user_type() == 1)
            <li class="{{setActive('admin/countries')}}{{setActive('admin/add_country')}}{{setActive('admin/edit_country')}}"><a class="menu-item" href="{{asset('admin/countries')}}">{{ trans('admin.Country') }}</a>
            </li>
            @endif
            @if(role('city_view') == 1 || user_type() == 1)
            <li class="{{setActive('admin/cities')}}{{setActive('admin/add_city')}}{{setActive('admin/edit_city')}}"><a class="menu-item" href="{{asset('admin/cities')}}">{{ trans('admin.City') }}</a>
            </li>
            @endif
            @if(role('nationality_view') == 1 || user_type() == 1)
            <li class="{{setActive('admin/nationalities')}}{{setActive('admin/add_nationality')}}{{setActive('admin/edit_nationality')}}"><a class="menu-item" href="{{asset('admin/nationalities')}}">{{ trans('admin.Nationality') }}</a>
            </li>
            @endif
          </ul>
        </li>
        @endif
        @if(role('dolane_update') == 1 || role('dolane_img_view') == 1 || user_type() == 1)
        <li class="nav-item has-sub {{setOpen('admin/dolane')}}
          {{setOpen('admin/dolane_images')}}{{setOpen('admin/add_dolane_image')}}{{setOpen('admin/edit_dolane_image')}}"><a href="#"><i class="ft-map"></i><span class="menu-title" data-i18n="">{{ trans('admin.dolane') }}</span></a>
          <ul class="menu-content">
            @if(role('dolane_update') == 1 || user_type() == 1)
            <li class="{{request()->segment(2) == 'dolane' ? 'active' : ''}}"><a class="menu-item" href="{{asset('admin/dolane')}}">{{ trans('admin.dolane detail') }}</a>
            </li>
            @endif
            @if(role('dolane_img_view') == 1 || user_type() == 1)
            <li class="{{setActive('admin/dolane_images')}}{{setActive('admin/add_dolane_image')}}{{setActive('admin/edit_dolane_image')}}"><a class="menu-item" href="{{asset('admin/dolane_images')}}">{{ trans('admin.Dolane Images') }}</a>
            </li>
            @endif
          </ul>
        </li>
        @endif
        @if(role('contact_view') == 1 || user_type() == 1)
        <li class="nav-item has-sub {{setOpen('admin/contact_web')}}{{setOpen('admin/contact_phone')}}"><a href="#"><i class="ft-message-circle"></i><span class="menu-title" data-i18n="">{{ trans('admin.contacts') }}</span></a>
          <ul class="menu-content">
            <li class="{{setActive('admin/contact_web')}}"><a class="menu-item" href="{{asset('admin/contact_web')}}">{{ trans('admin.web') }}</a>
            </li>
            <li class="{{setActive('admin/contact_phone')}}"><a class="menu-item" href="{{asset('admin/contact_phone')}}">{{ trans('admin.phone') }}</a>
            </li>
          </ul>
        </li>
        @endif
        @if(role('rate_view') == 1 || user_type() == 1)
        <li class="nav-item has-sub {{setOpen('admin/guide_rates')}}{{setOpen('admin/trip_rates')}}"><a href="#"><i class="icon-star"></i><span class="menu-title" data-i18n="">{{ trans('admin.rates') }}</span></a>
          <ul class="menu-content">
            <li class="{{setActive('admin/guide_rates')}}"><a class="menu-item" href="{{asset('admin/guide_rates')}}">{{ trans('admin.guides') }}</a>
            </li>
            <li class="{{setActive('admin/trip_rates')}}"><a class="menu-item" href="{{asset('admin/trip_rates')}}">{{ trans('admin.trips') }}</a>
            </li>
          </ul>
        </li>
        @endif
        @if(role('faq_view') == 1 || role('page_view') == 1 || role('about_update') == 1 || role('screen_shot_view') == 1 || user_type() == 1)
        <li class="nav-item has-sub 
          {{setOpen('admin/faqs')}}{{setOpen('admin/add_faq')}}{{setOpen('admin/edit_faq')}}
          {{setOpen('admin/screen_shot')}}{{setOpen('admin/add_screen_shot')}}{{setOpen('admin/edit_screen_shot')}}
          {{setOpen('admin/about')}}{{setOpen('admin/pages')}}{{setOpen('admin/edit_pages')}}"><a href="#"><i class="ft-settings"></i><span class="menu-title" data-i18n="">{{ trans('admin.Setting') }}</span></a>
          <ul class="menu-content">
            @if(role('faq_view') == 1 || user_type() == 1)
            <li class="{{setActive('admin/faqs')}}{{setActive('admin/add_faq')}}{{setActive('admin/edit_faq')}}"><a class="menu-item" href="{{asset('admin/faqs')}}">{{ trans('admin.faq') }}</a>
            </li>
            @endif
            @if(role('page_view') == 1 || user_type() == 1)
            <li class="{{setActive('admin/pages')}}{{setActive('admin/edit_pages')}}"><a class="menu-item" href="{{asset('admin/pages')}}">{{ trans('admin.pages') }}</a>
            </li>
            @endif
            @if(role('about_update') == 1 || user_type() == 1)
            <li class="{{setActive('admin/about')}}"><a class="menu-item" href="{{asset('admin/about')}}">{{ trans('admin.aboutUs') }}</a>
            </li>
            @endif
            @if(role('screen_shot_view') == 1 || user_type() == 1)
            <li class="{{setActive('admin/screen_shot')}}{{setActive('admin/add_screen_shot')}}{{setActive('admin/edit_screen_shot')}}"><a class="menu-item" href="{{asset('admin/screen_shot')}}">{{ trans('admin.screenShot') }}</a>
            </li>
            @endif
          </ul>
        </li>
        @endif
      </ul>
    </div>
</div>
  <!-- END: Main Menu-->