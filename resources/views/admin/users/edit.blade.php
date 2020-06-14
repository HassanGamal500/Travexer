@extends('common.index')
@section('page_title')
    {{trans('admin.edit user')}}
@endsection
@section('content')
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-wrapper">
      <div class="content-wrapper-before"></div>
      <div class="content-header row">
        <div class="content-header-left col-md-4 col-12 mb-2">
          <h3 class="content-header-title">{{trans('admin.edit user')}}</h3>
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

                                <form class="needs-validation" novalidate method="post" action="{{route('update_user', $users->id)}}" enctype="multipart/form-data">
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

                                        <div class="form-group">
                                            <label for="validationTooltip6">{{trans('admin.gender')}}</label>
                                            <select class="form-control round" id="validationTooltip6" name="gender" required>
                                                <option value="" disabled selected>{{trans('admin.Select Gender')}}</option>
                                                <option value="male" {{$users->gender == 'male' ? 'selected':''}}>{{trans('admin.male')}}</option>
                                                <option value="female" {{$users->gender == 'female' ? 'selected':''}}>{{trans('admin.female')}}</option>
                                            </select>
                                            <div class="invalid-tooltip">
                                                {{ trans('admin.Please Enter Your Gender.') }}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="validationTooltip7">{{ trans('admin.birthofdate') }}</label>
                                            <input type="date" id="validationTooltip7" class="form-control round" name="birthofdate" value="{{ $users->birth_of_date }}" required>
                                            <div class="invalid-tooltip">
                                                {{ trans('admin.Please Enter Your Birthday.') }}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="validationTooltip8">{{trans('admin.SelectCountry')}}</label>
                                            <select class="form-control round country_id" id="validationTooltip8" name="country_id" required>
                                                <option value="" disabled>{{trans('admin.SelectCountry')}}</option>
                                                @foreach($countries as $country)
                                                <option value="{{$country->id}}" {{$users->country_id == $country->id ? 'selected':''}}>{{$country->name}}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-tooltip">
                                                {{ trans('admin.Please Enter Your Country.') }}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="validationTooltip9">{{trans('admin.select city')}}</label>
                                            <select class="form-control round city_id" id="validationTooltip9" name="city_id" required>
                                                <option value="" disabled>{{trans('admin.select city')}}</option>
                                                @foreach($cities as $city)
                                                <option value="{{$city->id}}" {{$users->city_id == $city->id ? 'selected':''}}>{{$city->name}}</option>
                                                @endforeach
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
