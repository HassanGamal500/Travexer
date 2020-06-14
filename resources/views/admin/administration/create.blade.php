@extends('common.index')
@section('page_title')
    {{trans('admin.add administration')}}
@endsection
@section('content')
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-wrapper">
      <div class="content-wrapper-before"></div>
      <div class="content-header row">
        <div class="content-header-left col-md-4 col-12 mb-2">
          <h3 class="content-header-title">{{trans('admin.add administration')}}</h3>
        </div>
        <div class="content-header-right col-md-8 col-12">
          <div class="breadcrumbs-top float-md-right">
            <div class="breadcrumb-wrapper mr-1">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{asset('/admin/administrations')}}">{{ trans('admin.administrations') }}</a>
                </li>
                <li class="breadcrumb-item active">{{trans('admin.add administration')}}</a>
                </li>
              </ol>
            </div>
          </div>
        </div>
      </div>
      <div class="content-body">
        <!-- Basic form layout section start -->
        <section id="basic-form-layouts input-validation">
            <div class="row match-height">
                <div class="col-md-10 offset-1">
                    @if(session()->has('error'))
                            <div class="alert round bg-danger alert-icon-left alert-dismissible mb-2" role="alert">
                                <span class="alert-icon">
                                    <i class="ft-thumbs-up"></i>
                                </span>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                <strong>{{session()->get('error')}}</strong>
                            </div>
                        @elseif(session()->has('message'))
                            <div class="alert round bg-success alert-icon-left alert-dismissible mb-2" role="alert">
                                <span class="alert-icon">
                                    <i class="ft-thumbs-up"></i>
                                </span>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                <strong>{{session()->get('message')}}</strong>
                            </div>
                        @endif
                    <div class="card">
                        <div class="card-content collapse show">
                            <div class="card-body">

                                <form class="needs-validation" novalidate method="post" action="{{route('store_administration')}}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-body">

                                        <div class="form-group">
                                            <label for="validationTooltip1">{{trans('admin.name')}}</label>
                                            <input type="text"  name="name" id="validationTooltip1" class="form-control round" placeholder="{{trans('admin.enter name')}}" value="{{ old('name') }}" required>
                                            <div class="invalid-tooltip">
                                                {{ trans('admin.Please Enter Your Name.') }}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="validationTooltip2">{{trans('admin.phone')}}</label>
                                            <input type="tel" pattern="^[0-9]*$" name="phone" id="validationTooltip2" class="form-control round" placeholder="{{trans('admin.enter phone')}}" value="{{ old('phone') }}" required>
                                            <div class="invalid-tooltip">
                                                {{ trans('admin.Please Enter Your Phone Number.') }}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="validationTooltip3">{{trans('admin.email')}}</label>
                                            <input type="email" name="email" id="validationTooltip3" class="form-control round" placeholder="{{trans('admin.enter email')}}" value="{{ old('email') }}" required>
                                            <div class="invalid-tooltip">
                                                {{ trans('admin.Please Enter Your Email Address.') }}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="validationTooltip4">{{trans('admin.password')}}</label>
                                            <input type="password" name="password" id="validationTooltip4" class="form-control round" placeholder="{{trans('admin.enter new password')}}" required>
                                            <div class="invalid-tooltip">
                                                {{ trans('admin.Please Enter Your New Password.') }}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="custom-file">
                                                <input type="file" name="image" class="custom-file-input" id="inputGroupFile01 validationTooltip5" required>
                                                <label class="custom-file-label" for="inputGroupFile01 validationTooltip5">{{trans('admin.upload photo')}}</label>
                                            </div>
                                            <div class="invalid-tooltip">
                                                {{ trans('admin.Please Upload Your Photo.') }}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 skin skin-line" style="border: 1px solid #EEE;">
                                                <h3 class="text-center mt-2">{{ trans('admin.user') }}</h3>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="user_view">
                                                        <label for="input-1">{{ trans('admin.view') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="user_create">
                                                        <label for="input-1">{{ trans('admin.create') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="user_update">
                                                        <label for="input-1">{{ trans('admin.update') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="user_delete">
                                                        <label for="input-1">{{ trans('admin.delete') }}</label>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="col-md-4 skin skin-line" style="border: 1px solid #EEE;">
                                                <h3 class="text-center mt-2">{{ trans('admin.guide') }}</h3>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="guide_view">
                                                        <label for="input-1">{{ trans('admin.view') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="guide_create">
                                                        <label for="input-1">{{ trans('admin.create') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="guide_update">
                                                        <label for="input-1">{{ trans('admin.update') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="guide_delete">
                                                        <label for="input-1">{{ trans('admin.delete') }}</label>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="col-md-4 skin skin-line" style="border: 1px solid #EEE;">
                                                <h3 class="text-center mt-2">{{ trans('admin.company') }}</h3>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="company_view">
                                                        <label for="input-1">{{ trans('admin.view') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="company_create">
                                                        <label for="input-1">{{ trans('admin.create') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="company_update">
                                                        <label for="input-1">{{ trans('admin.update') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="company_delete">
                                                        <label for="input-1">{{ trans('admin.delete') }}</label>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="col-md-4 skin skin-line" style="border: 1px solid #EEE;">
                                                <h3 class="text-center mt-2">{{ trans('admin.advertisement') }}</h3>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="advertisement_view">
                                                        <label for="input-1">{{ trans('admin.view') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="advertisement_create">
                                                        <label for="input-1">{{ trans('admin.create') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="advertisement_update">
                                                        <label for="input-1">{{ trans('admin.update') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="advertisement_delete">
                                                        <label for="input-1">{{ trans('admin.delete') }}</label>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="col-md-4 skin skin-line" style="border: 1px solid #EEE;">
                                                <h3 class="text-center mt-2">{{ trans('admin.page') }}</h3>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="page_view">
                                                        <label for="input-1">{{ trans('admin.view') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="page_update">
                                                        <label for="input-1">{{ trans('admin.update') }}</label>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="col-md-4 skin skin-line" style="border: 1px solid #EEE;">
                                                <h3 class="text-center mt-2">{{ trans('admin.notification') }}</h3>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="notification_view">
                                                        <label for="input-1">{{ trans('admin.view') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="notification_create">
                                                        <label for="input-1">{{ trans('admin.create') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="notification_delete">
                                                        <label for="input-1">{{ trans('admin.delete') }}</label>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="col-md-4 skin skin-line" style="border: 1px solid #EEE;">
                                                <h3 class="text-center mt-2">{{ trans('admin.contact') }}</h3>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="contact_view">
                                                        <label for="input-1">{{ trans('admin.view') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="contact_delete">
                                                        <label for="input-1">{{ trans('admin.delete') }}</label>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="col-md-4 skin skin-line" style="border: 1px solid #EEE;">
                                                <h3 class="text-center mt-2">{{ trans('admin.rate') }}</h3>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="rate_view">
                                                        <label for="input-1">{{ trans('admin.view') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="rate_delete">
                                                        <label for="input-1">{{ trans('admin.delete') }}</label>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="col-md-4 skin skin-line" style="border: 1px solid #EEE;">
                                                <h3 class="text-center mt-2">{{ trans('admin.country') }}</h3>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="country_view">
                                                        <label for="input-1">{{ trans('admin.view') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="country_create">
                                                        <label for="input-1">{{ trans('admin.create') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="country_update">
                                                        <label for="input-1">{{ trans('admin.update') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="country_delete">
                                                        <label for="input-1">{{ trans('admin.delete') }}</label>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="col-md-4 skin skin-line" style="border: 1px solid #EEE;">
                                                <h3 class="text-center mt-2">{{ trans('admin.city') }}</h3>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="city_view">
                                                        <label for="input-1">{{ trans('admin.view') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="city_create">
                                                        <label for="input-1">{{ trans('admin.create') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="city_update">
                                                        <label for="input-1">{{ trans('admin.update') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="city_delete">
                                                        <label for="input-1">{{ trans('admin.delete') }}</label>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="col-md-4 skin skin-line" style="border: 1px solid #EEE;">
                                                <h3 class="text-center mt-2">{{ trans('admin.nationality') }}</h3>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="nationality_view">
                                                        <label for="input-1">{{ trans('admin.view') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="nationality_create">
                                                        <label for="input-1">{{ trans('admin.create') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="nationality_update">
                                                        <label for="input-1">{{ trans('admin.update') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="nationality_delete">
                                                        <label for="input-1">{{ trans('admin.delete') }}</label>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="col-md-4 skin skin-line" style="border: 1px solid #EEE;">
                                                <h3 class="text-center mt-2">{{ trans('admin.service') }}</h3>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="service_view">
                                                        <label for="input-1">{{ trans('admin.view') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="service_create">
                                                        <label for="input-1">{{ trans('admin.create') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="service_update">
                                                        <label for="input-1">{{ trans('admin.update') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="service_delete">
                                                        <label for="input-1">{{ trans('admin.delete') }}</label>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="col-md-4 skin skin-line" style="border: 1px solid #EEE;">
                                                <h3 class="text-center mt-2">{{ trans('admin.dolane') }}</h3>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="dolane_update">
                                                        <label for="input-1">{{ trans('admin.update') }}</label>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="col-md-4 skin skin-line" style="border: 1px solid #EEE;">
                                                <h3 class="text-center mt-2">{{ trans('admin.dolane image') }}</h3>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="dolane_img_view">
                                                        <label for="input-1">{{ trans('admin.view') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="dolane_img_create">
                                                        <label for="input-1">{{ trans('admin.create') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="dolane_img_update">
                                                        <label for="input-1">{{ trans('admin.update') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="dolane_img_delete">
                                                        <label for="input-1">{{ trans('admin.delete') }}</label>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="col-md-4 skin skin-line" style="border: 1px solid #EEE;">
                                                <h3 class="text-center mt-2">{{ trans('admin.faq') }}</h3>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="faq_view">
                                                        <label for="input-1">{{ trans('admin.view') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="faq_create">
                                                        <label for="input-1">{{ trans('admin.create') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="faq_update">
                                                        <label for="input-1">{{ trans('admin.update') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="faq_delete">
                                                        <label for="input-1">{{ trans('admin.delete') }}</label>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="col-md-4 skin skin-line" style="border: 1px solid #EEE;">
                                                <h3 class="text-center mt-2">{{ trans('admin.about') }}</h3>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="about_update">
                                                        <label for="input-1">{{ trans('admin.update') }}</label>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="col-md-4 skin skin-line" style="border: 1px solid #EEE;">
                                                <h3 class="text-center mt-2">{{ trans('admin.screen_shot') }}</h3>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="screen_shot_view">
                                                        <label for="input-1">{{ trans('admin.view') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="screen_shot_create">
                                                        <label for="input-1">{{ trans('admin.create') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="screen_shot_update">
                                                        <label for="input-1">{{ trans('admin.update') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="screen_shot_delete">
                                                        <label for="input-1">{{ trans('admin.delete') }}</label>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="col-md-4 skin skin-line" style="border: 1px solid #EEE;">
                                                <h3 class="text-center mt-2">{{ trans('admin.broadcast') }}</h3>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="broadcast_view">
                                                        <label for="input-1">{{ trans('admin.view') }}</label>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="col-md-4 skin skin-line" style="border: 1px solid #EEE;">
                                                <h3 class="text-center mt-2">{{ trans('admin.trip') }}</h3>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="trip_view">
                                                        <label for="input-1">{{ trans('admin.view') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="trip_update">
                                                        <label for="input-1">{{ trans('admin.update') }}</label>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="col-md-4 skin skin-line" style="border: 1px solid #EEE;">
                                                <h3 class="text-center mt-2">{{ trans('admin.trip_info') }}</h3>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="trip_info_view">
                                                        <label for="input-1">{{ trans('admin.view') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="trip_info_update">
                                                        <label for="input-1">{{ trans('admin.update') }}</label>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="col-md-4 skin skin-line" style="border: 1px solid #EEE;">
                                                <h3 class="text-center mt-2">{{ trans('admin.order') }}</h3>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="order_view">
                                                        <label for="input-1">{{ trans('admin.view') }}</label>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="col-md-4 skin skin-line" style="border: 1px solid #EEE;">
                                                <h3 class="text-center mt-2">{{ trans('admin.administration') }}</h3>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="admin_view">
                                                        <label for="input-1">{{ trans('admin.view') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="admin_create">
                                                        <label for="input-1">{{ trans('admin.create') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="admin_update">
                                                        <label for="input-1">{{ trans('admin.update') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="admin_delete">
                                                        <label for="input-1">{{ trans('admin.delete') }}</label>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="col-md-4 skin skin-line" style="border: 1px solid #EEE;">
                                                <h3 class="text-center mt-2">{{ trans('admin.subscribe') }}</h3>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="subscribe_view">
                                                        <label for="input-1">{{ trans('admin.view') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="subscribe_delete">
                                                        <label for="input-1">{{ trans('admin.delete') }}</label>
                                                    </fieldset>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                    <div class="form-actions">
                                        <a href="{{asset('/admin/administrations')}}" class="btn btn-danger mr-1">
                                            <i class="ft-x"></i> {{ trans('admin.Cancel') }}
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="la la-check-square-o"></i> {{ trans('admin.Save') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- // Basic form layout section end -->
      </div>
    </div>
  </div>
<!-- END: Content-->
@endsection
