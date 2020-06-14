@extends('common.index')
@section('page_title')
    {{trans('admin.edit administration')}}
@endsection
@section('content')
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-wrapper">
      <div class="content-wrapper-before"></div>
      <div class="content-header row">
        <div class="content-header-left col-md-4 col-12 mb-2">
          <h3 class="content-header-title">{{trans('admin.edit administration')}}</h3>
        </div>
        <div class="content-header-right col-md-8 col-12">
          <div class="breadcrumbs-top float-md-right">
            <div class="breadcrumb-wrapper mr-1">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{asset('/admin/administrations')}}">{{ trans('admin.administrations') }}</a>
                </li>
                <li class="breadcrumb-item active">{{trans('admin.edit administration')}}</a>
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

                                <form class="needs-validation" novalidate method="post" action="{{route('update_administration', $users->id)}}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-body">

                                        <div class="form-group">
                                            <label for="validationTooltip1">{{trans('admin.name')}}</label>
                                            <input type="text"  name="name" id="validationTooltip1" class="form-control round" placeholder="{{trans('admin.enter name')}}" value="{{ $users->name }}" required>
                                            <div class="invalid-tooltip">
                                                {{ trans('admin.Please Enter Your Name.') }}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="validationTooltip2">{{trans('admin.phone')}}</label>
                                            <input type="tel" pattern="^[0-9]*$" name="phone" id="validationTooltip2" class="form-control round" placeholder="{{trans('admin.enter phone')}}" value="{{ $users->phone }}" required>
                                            <div class="invalid-tooltip">
                                                {{ trans('admin.Please Enter Your Phone Number.') }}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="validationTooltip3">{{trans('admin.email')}}</label>
                                            <input type="email" name="email" id="validationTooltip3" class="form-control round" placeholder="{{trans('admin.enter email')}}" value="{{ $users->email }}" required>
                                            <div class="invalid-tooltip">
                                                {{ trans('admin.Please Enter Your Email Address.') }}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="validationTooltip4">{{trans('admin.password')}}</label>
                                            <input type="password" name="password" id="validationTooltip4" class="form-control round" placeholder="{{trans('admin.enter new password')}}">
                                        </div>

                                        <div class="form-group">
                                            <div class="custom-file">
                                                <input type="file" name="image" class="custom-file-input" id="inputGroupFile01 validationTooltip5">
                                                <label class="custom-file-label" for="inputGroupFile01 validationTooltip5">{{trans('admin.upload photo')}}</label>
                                            </div>
                                            <br>
                                            <input type="hidden" name="old_image" value="{{$users->image}}">
                                            <img src="{{asset($users->image)}}" class="img-thumbnail" height="70px" width="100px">
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4 skin skin-line" style="border: 1px solid #EEE;">
                                                <h3 class="text-center mt-2">{{ trans('admin.user') }}</h3>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="user_view" {{ $manages->user_view == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.view') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="user_create" {{ $manages->user_create == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.create') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="user_update" {{ $manages->user_update == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.update') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="user_delete" {{ $manages->user_delete == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.delete') }}</label>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="col-md-4 skin skin-line" style="border: 1px solid #EEE;">
                                                <h3 class="text-center mt-2">{{ trans('admin.guide') }}</h3>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="guide_view" {{ $manages->guide_view == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.view') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="guide_create" {{ $manages->guide_create == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.create') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="guide_update" {{ $manages->guide_update == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.update') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="guide_delete" {{ $manages->guide_delete == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.delete') }}</label>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="col-md-4 skin skin-line" style="border: 1px solid #EEE;">
                                                <h3 class="text-center mt-2">{{ trans('admin.company') }}</h3>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="company_view" {{ $manages->company_view == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.view') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="company_create" {{ $manages->company_create == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.create') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="company_update" {{ $manages->company_update == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.update') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="company_delete" {{ $manages->company_delete == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.delete') }}</label>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="col-md-4 skin skin-line" style="border: 1px solid #EEE;">
                                                <h3 class="text-center mt-2">{{ trans('admin.advertisement') }}</h3>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="advertisement_view" {{ $manages->advertisement_view == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.view') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="advertisement_create" {{ $manages->advertisement_create == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.create') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="advertisement_update" {{ $manages->advertisement_update == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.update') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="advertisement_delete" {{ $manages->advertisement_delete == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.delete') }}</label>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="col-md-4 skin skin-line" style="border: 1px solid #EEE;">
                                                <h3 class="text-center mt-2">{{ trans('admin.page') }}</h3>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="page_view" {{ $manages->page_view == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.view') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="page_update" {{ $manages->page_update == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.update') }}</label>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="col-md-4 skin skin-line" style="border: 1px solid #EEE;">
                                                <h3 class="text-center mt-2">{{ trans('admin.notification') }}</h3>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="notification_view" {{ $manages->notification_view == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.view') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="notification_create" {{ $manages->notification_create == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.create') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="notification_delete" {{ $manages->notification_delete == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.delete') }}</label>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="col-md-4 skin skin-line" style="border: 1px solid #EEE;">
                                                <h3 class="text-center mt-2">{{ trans('admin.contact') }}</h3>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="contact_view" {{ $manages->contact_view == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.view') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="contact_delete" {{ $manages->contact_delete == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.delete') }}</label>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="col-md-4 skin skin-line" style="border: 1px solid #EEE;">
                                                <h3 class="text-center mt-2">{{ trans('admin.rate') }}</h3>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="rate_view" {{ $manages->rate_view == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.view') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="rate_delete" {{ $manages->rate_delete == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.delete') }}</label>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="col-md-4 skin skin-line" style="border: 1px solid #EEE;">
                                                <h3 class="text-center mt-2">{{ trans('admin.country') }}</h3>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="country_view" {{ $manages->country_view == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.view') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="country_create" {{ $manages->country_create == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.create') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="country_update" {{ $manages->country_update == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.update') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="country_delete" {{ $manages->country_delete == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.delete') }}</label>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="col-md-4 skin skin-line" style="border: 1px solid #EEE;">
                                                <h3 class="text-center mt-2">{{ trans('admin.city') }}</h3>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="city_view" {{ $manages->city_view == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.view') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="city_create" {{ $manages->city_create == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.create') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="city_update" {{ $manages->city_update == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.update') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="city_delete" {{ $manages->city_delete == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.delete') }}</label>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="col-md-4 skin skin-line" style="border: 1px solid #EEE;">
                                                <h3 class="text-center mt-2">{{ trans('admin.nationality') }}</h3>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="nationality_view" {{ $manages->nationality_view == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.view') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="nationality_create" {{ $manages->nationality_create == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.create') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="nationality_update" {{ $manages->nationality_update == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.update') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="nationality_delete" {{ $manages->nationality_delete == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.delete') }}</label>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="col-md-4 skin skin-line" style="border: 1px solid #EEE;">
                                                <h3 class="text-center mt-2">{{ trans('admin.service') }}</h3>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="service_view" {{ $manages->service_view == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.view') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="service_create" {{ $manages->service_create == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.create') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="service_update" {{ $manages->service_update == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.update') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="service_delete" {{ $manages->service_delete == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.delete') }}</label>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="col-md-4 skin skin-line" style="border: 1px solid #EEE;">
                                                <h3 class="text-center mt-2">{{ trans('admin.dolane') }}</h3>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="dolane_update" {{ $manages->dolane_update == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.update') }}</label>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="col-md-4 skin skin-line" style="border: 1px solid #EEE;">
                                                <h3 class="text-center mt-2">{{ trans('admin.dolane image') }}</h3>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="dolane_img_view" {{ $manages->dolane_img_view == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.view') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="dolane_img_create" {{ $manages->dolane_img_create == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.create') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="dolane_img_update" {{ $manages->dolane_img_update == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.update') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="dolane_img_delete" {{ $manages->dolane_img_delete == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.delete') }}</label>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="col-md-4 skin skin-line" style="border: 1px solid #EEE;">
                                                <h3 class="text-center mt-2">{{ trans('admin.faq') }}</h3>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="faq_view" {{ $manages->faq_view == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.view') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="faq_create" {{ $manages->faq_create == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.create') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="faq_update" {{ $manages->faq_update == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.update') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="faq_delete" {{ $manages->faq_delete == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.delete') }}</label>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="col-md-4 skin skin-line" style="border: 1px solid #EEE;">
                                                <h3 class="text-center mt-2">{{ trans('admin.about') }}</h3>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="about_update" {{ $manages->about_update == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.update') }}</label>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="col-md-4 skin skin-line" style="border: 1px solid #EEE;">
                                                <h3 class="text-center mt-2">{{ trans('admin.screen_shot') }}</h3>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="screen_shot_view" {{ $manages->screen_shot_view == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.view') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="screen_shot_create" {{ $manages->screen_shot_create == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.create') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="screen_shot_update" {{ $manages->screen_shot_update == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.update') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="screen_shot_delete" {{ $manages->screen_shot_delete == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.delete') }}</label>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="col-md-4 skin skin-line" style="border: 1px solid #EEE;">
                                                <h3 class="text-center mt-2">{{ trans('admin.broadcast') }}</h3>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="broadcast_view" {{ $manages->broadcast_view == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.view') }}</label>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="col-md-4 skin skin-line" style="border: 1px solid #EEE;">
                                                <h3 class="text-center mt-2">{{ trans('admin.trip') }}</h3>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="trip_view" {{ $manages->trip_view == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.view') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="trip_update" {{ $manages->trip_update == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.update') }}</label>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="col-md-4 skin skin-line" style="border: 1px solid #EEE;">
                                                <h3 class="text-center mt-2">{{ trans('admin.trip_info') }}</h3>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="trip_info_view" {{ $manages->trip_info_view == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.view') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="trip_info_update" {{ $manages->trip_info_update == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.update') }}</label>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="col-md-4 skin skin-line" style="border: 1px solid #EEE;">
                                                <h3 class="text-center mt-2">{{ trans('admin.order') }}</h3>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="order_view" {{ $manages->order_view == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.view') }}</label>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="col-md-4 skin skin-line" style="border: 1px solid #EEE;">
                                                <h3 class="text-center mt-2">{{ trans('admin.administration') }}</h3>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="admin_view" {{ $manages->admin_view == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.view') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="admin_create" {{ $manages->admin_create == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.create') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="admin_update" {{ $manages->admin_update == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.update') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="admin_delete" {{ $manages->admin_delete == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.delete') }}</label>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="col-md-4 skin skin-line" style="border: 1px solid #EEE;">
                                                <h3 class="text-center mt-2">{{ trans('admin.subscribe') }}</h3>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="subscribe_view" {{ $manages->subscribe_view == 1 ? 'checked' : ''}}>
                                                        <label for="input-1">{{ trans('admin.view') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset>
                                                        <input type="checkbox" id="input-1" name="subscribe_delete" {{ $manages->subscribe_delete == 1 ? 'checked' : ''}}>
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
