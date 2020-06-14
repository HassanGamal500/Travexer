@extends('common.index')
@section('page_title')
    {{trans('admin.header_dashboard')}}
@endsection
@section('content')
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-wrapper-before"></div>
        <div class="content-header row"></div>
        <div class="content-body">

            <div class="row mt-5">
                <a class="col-xl-3 col-lg-6 col-12" href="{{ asset('admin/users') }}">
                    <div class="card pull-up bg-gradient-x-purple-blue">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="align-self-top">
                                        <i class="icon-users icon-opacity text-white font-large-4 float-left"></i>
                                    </div>
                                    <div class="media-body text-white text-right align-self-bottom mt-3">
                                        <span class="d-block mb-1 font-medium-1">{{ trans('admin.users') }}</span>
                                        <h1 class="text-white mb-0">{{ $results['users'] }}</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                <a class="col-xl-3 col-lg-6 col-12" href="{{ asset('admin/guides') }}">
                    <div class="card pull-up bg-gradient-x-purple-red">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="align-self-top">
                                        <i class="icon-users icon-opacity text-white font-large-4 float-left"></i>
                                    </div>
                                    <div class="media-body text-white text-right align-self-bottom mt-3">
                                        <span class="d-block mb-1 font-medium-1">{{ trans('admin.guides') }}</span>
                                        <h1 class="text-white mb-0">{{ $results['guides'] }}</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                <a class="col-xl-3 col-lg-6 col-12" href="{{ asset('admin/companies') }}">
                    <div class="card pull-up bg-gradient-x-blue-green">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="align-self-top">
                                        <i class="icon-users icon-opacity text-white font-large-4 float-left"></i>
                                    </div>
                                    <div class="media-body text-white text-right align-self-bottom mt-3">
                                        <span class="d-block mb-1 font-medium-1">{{ trans('admin.companies') }}</span>
                                        <h1 class="text-white mb-0">{{ $results['companies'] }}</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                <div class="col-xl-3 col-lg-6 col-12">
                    <div class="card pull-up bg-gradient-x-orange-yellow">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="align-self-top">
                                        <i class="icon-wallet icon-opacity text-white font-large-4 float-left"></i>
                                    </div>
                                    <div class="media-body text-white text-right align-self-bottom mt-3">
                                        <span class="d-block mb-1 font-medium-1">{{ trans('admin.Total Revenue') }}</span>
                                        @if(App::isLocale('en'))
                                        <h1 class="text-white mb-0">{{ $results['total'] }} SAR</h1>
                                        @else
                                        <h1 class="text-white mb-0">ريال {{ $results['total'] }}</h1>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <a class="col-xl-3 col-lg-6 col-12" href="{{ asset('admin/broadcasts') }}">
                    <div class="card pull-up bg-gradient-x-blue-cyan">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="align-self-top">
                                        <i class="ft-radio icon-opacity text-white font-large-4 float-left"></i>
                                    </div>
                                    <div class="media-body text-white text-right align-self-bottom mt-3">
                                        <span class="d-block mb-1 font-medium-1">{{ trans('admin.broadcasts') }}</span>
                                        <h1 class="text-white mb-0">{{ $results['broadcasts'] }}</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                <a class="col-xl-3 col-lg-6 col-12" href="{{ asset('admin/trips') }}">
                    <div class="card pull-up bg-gradient-x-red-pink">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="align-self-top">
                                        <i class="icon-plane icon-opacity text-white font-large-4 float-left"></i>
                                    </div>
                                    <div class="media-body text-white text-right align-self-bottom mt-3">
                                        <span class="d-block mb-1 font-medium-1">{{ trans('admin.trips') }}</span>
                                        <h1 class="text-white mb-0">{{ $results['trips'] }}</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                <div class="col-xl-3 col-lg-6 col-12">
                    <div class="card pull-up bg-gradient-x-purple-blue">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="align-self-top">
                                        <i class="icon-basket-loaded icon-opacity text-white font-large-4 float-left"></i>
                                    </div>
                                    <div class="media-body text-white text-right align-self-bottom mt-3">
                                        <span class="d-block mb-1 font-medium-1">{{ trans('admin.orders') }}</span>
                                        <h1 class="text-white mb-0">{{ $results['orders'] }}</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-12">
                    <div class="card pull-up bg-gradient-x-purple-red">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="align-self-top">
                                        <i class="icon-star icon-opacity text-white font-large-4 float-left"></i>
                                    </div>
                                    <div class="media-body text-white text-right align-self-bottom mt-3">
                                        <span class="d-block mb-1">{{ trans('admin.rates') }}</span>
                                        <h1 class="text-white mb-0">{{ $results['rates'] }}</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <a class="col-xl-3 col-lg-6 col-12" href="{{ asset('admin/administrations') }}">
                    <div class="card pull-up bg-gradient-x-blue-green">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="align-self-top">
                                        <i class="ft-aperture icon-opacity text-white font-large-4 float-left"></i>
                                    </div>
                                    <div class="media-body text-white text-right align-self-bottom mt-3">
                                        <span class="d-block mb-1 font-medium-1">{{ trans('admin.administrations') }}</span>
                                        <h1 class="text-white mb-0">{{ $results['admins'] }}</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                <a class="col-xl-3 col-lg-6 col-12" href="{{ asset('admin/services') }}">
                    <div class="card pull-up bg-gradient-x-orange-yellow">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="align-self-top">
                                        <i class="ft-feather icon-opacity text-white font-large-4 float-left"></i>
                                    </div>
                                    <div class="media-body text-white text-right align-self-bottom mt-3">
                                        <span class="d-block mb-1 font-medium-1">{{ trans('admin.services') }}</span>
                                        <h1 class="text-white mb-0">{{ $results['services'] }}</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                <div class="col-xl-3 col-lg-6 col-12">
                    <div class="card pull-up bg-gradient-x-blue-cyan">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="align-self-top">
                                        <i class="ft-message-circle icon-opacity text-white font-large-4 float-left"></i>
                                    </div>
                                    <div class="media-body text-white text-right align-self-bottom mt-3">
                                        <span class="d-block mb-1 font-medium-1">{{ trans('admin.contacts') }}</span>
                                        <h1 class="text-white mb-0">{{ $results['contacts'] }}</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <a class="col-xl-3 col-lg-6 col-12" href="{{ asset('admin/notifications') }}">
                    <div class="card pull-up bg-gradient-x-red-pink">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="align-self-top">
                                        <i class="ft-bell icon-opacity text-white font-large-4 float-left"></i>
                                    </div>
                                    <div class="media-body text-white text-right align-self-bottom mt-3">
                                        <span class="d-block mb-1 font-medium-1">{{ trans('admin.notifications') }}</span>
                                        <h1 class="text-white mb-0">{{ $results['notifications'] }}</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                <a class="col-xl-3 col-lg-6 col-12" href="{{ asset('admin/subscribes') }}">
                    <div class="card pull-up bg-gradient-x-purple-blue">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="align-self-top">
                                        <i class="icon-tag icon-opacity text-white font-large-4 float-left"></i>
                                    </div>
                                    <div class="media-body text-white text-right align-self-bottom mt-3">
                                        <span class="d-block mb-1 font-medium-1">{{ trans('admin.subscribes') }}</span>
                                        <h1 class="text-white mb-0">{{ $results['subscribes'] }}</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                <a class="col-xl-3 col-lg-6 col-12" href="{{ asset('admin/countries') }}">
                    <div class="card pull-up bg-gradient-x-purple-red">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="align-self-top">
                                        <i class="icon-pointer icon-opacity text-white font-large-4 float-left"></i>
                                    </div>
                                    <div class="media-body text-white text-right align-self-bottom mt-3">
                                        <span class="d-block mb-1 font-medium-1">{{ trans('admin.countries') }}</span>
                                        <h1 class="text-white mb-0">{{ $results['countries'] }}</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                <a class="col-xl-3 col-lg-6 col-12" href="{{ asset('admin/cities') }}">
                    <div class="card pull-up bg-gradient-x-blue-green">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="align-self-top">
                                        <i class="icon-pointer icon-opacity text-white font-large-4 float-left"></i>
                                    </div>
                                    <div class="media-body text-white text-right align-self-bottom mt-3">
                                        <span class="d-block mb-1 font-medium-1">{{ trans('admin.cities') }}</span>
                                        <h1 class="text-white mb-0">{{ $results['cities'] }}</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                <a class="col-xl-3 col-lg-6 col-12" href="{{ asset('admin/nationalities') }}">
                    <div class="card pull-up bg-gradient-x-orange-yellow">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="align-self-top">
                                        <i class="icon-pointer icon-opacity text-white font-large-4 float-left"></i>
                                    </div>
                                    <div class="media-body text-white text-right align-self-bottom mt-3">
                                        <span class="d-block mb-1 font-medium-1">{{ trans('admin.nationalities') }}</span>
                                        <h1 class="text-white mb-0">{{ $results['nationalities'] }}</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
  <!-- END: Content-->
@endsection
