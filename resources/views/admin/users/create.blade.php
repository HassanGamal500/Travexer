@extends('common.index')
@section('page_title')
    {{trans('admin.add user')}}
@endsection
@section('content')
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-wrapper">
      <div class="content-wrapper-before"></div>
      <div class="content-header row">
        <div class="content-header-left col-md-4 col-12 mb-2">
          <h3 class="content-header-title">{{trans('admin.add user')}}</h3>
        </div>
        <div class="content-header-right col-md-8 col-12">
          <div class="breadcrumbs-top float-md-right">
            <div class="breadcrumb-wrapper mr-1">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{asset('/admin/users')}}">{{ trans('admin.users') }}</a>
                </li>
                <li class="breadcrumb-item active">{{trans('admin.add user')}}</a>
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

                                <form class="needs-validation" novalidate method="post" action="{{route('store_user')}}" enctype="multipart/form-data">
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

                                        <div class="form-group">
                                            <label for="validationTooltip6">{{trans('admin.gender')}}</label>
                                            <select class="form-control round" id="validationTooltip6" name="gender" required>
                                                <option value="" disabled selected>{{trans('admin.Select Gender')}}</option>
                                                <option value="male">{{trans('admin.male')}}</option>
                                                <option value="female">{{trans('admin.female')}}</option>
                                            </select>
                                            <div class="invalid-tooltip">
                                                {{ trans('admin.Please Enter Your Gender.') }}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="validationTooltip7">{{ trans('admin.birthofdate') }}</label>
                                            <input type="date" id="validationTooltip7" class="form-control round" name="birthofdate" required>
                                            <div class="invalid-tooltip">
                                                {{ trans('admin.Please Enter Your Birthday.') }}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="validationTooltip8">{{trans('admin.SelectCountry')}}</label>
                                            <select class="form-control round country_id" id="validationTooltip8" name="country_id" required>
                                                <option value="" disabled selected>{{trans('admin.SelectCountry')}}</option>
                                                @foreach($countries as $country)
                                                <option value="{{$country->id}}">{{$country->name}}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-tooltip">
                                                {{ trans('admin.Please Enter Your Country.') }}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="validationTooltip9">{{trans('admin.select city')}}</label>
                                            <select class="form-control round city_id" id="validationTooltip9" name="city_id" required>
                                                <option value="" disabled selected>{{trans('admin.select city')}}</option>
                                            </select>
                                            <div class="invalid-tooltip">
                                                {{ trans('admin.Please Enter Your City.') }}
                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-actions">
                                        <a href="{{asset('/admin/users')}}" class="btn btn-danger mr-1">
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
