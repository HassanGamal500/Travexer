@extends('common.index')
@section('page_title')
    {{trans('admin.edit guide')}}
@endsection
@section('content')
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-wrapper">
      <div class="content-wrapper-before"></div>
      <div class="content-header row">
        <div class="content-header-left col-md-4 col-12 mb-2">
          <h3 class="content-header-title">{{trans('admin.edit guide')}}</h3>
        </div>
        <div class="content-header-right col-md-8 col-12">
          <div class="breadcrumbs-top float-md-right">
            <div class="breadcrumb-wrapper mr-1">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{asset('/admin/guides')}}">{{ trans('admin.guides') }}</a>
                </li>
                <li class="breadcrumb-item active">{{trans('admin.add guide')}}</a>
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

                                <form class="needs-validation" novalidate method="post" action="{{route('update_guide', $users->id)}}" enctype="multipart/form-data">
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

                                        <div class="form-group">
                                            <label for="validationTooltip8">{{trans('admin.select nationality')}}</label>
                                            <select class="form-control round" id="validationTooltip8" name="nationality_id" required>
                                                <option value="" disabled selected>{{trans('admin.select nationality')}}</option>
                                                @foreach($nationalities as $nationality)
                                                <option value="{{$nationality->id}}" {{$users->nationality_id == $nationality->id ? 'selected':''}}>{{$nationality->name}}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-tooltip">
                                                {{ trans('admin.Please Enter Your Nationality.') }}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="validationTooltip10">{{trans('admin.national identity')}}</label>
                                            <input type="tel" pattern="^[0-9]*$" maxlength="15" name="national_identity" id="validationTooltip10" class="form-control round" placeholder="{{trans('admin.enter national identity')}}" value="{{ $users->national_identity }}" required>
                                            <div class="invalid-tooltip">
                                                {{ trans('admin.Please Enter Your National Identity.') }}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="custom-file">
                                                <input type="file" name="front_image" class="custom-file-input" id="inputGroupFile01 validationTooltip11">
                                                <label class="custom-file-label" for="inputGroupFile01 validationTooltip11">{{trans('admin.upload front national identity')}}</label>
                                            </div>
                                            <br>
                                            <input type="hidden" name="old_front_image" value="{{$users->front_national_identity_image}}">
                                            <img src="{{asset($users->front_national_identity_image)}}" class="img-thumbnail" height="70px" width="100px">
                                            <div class="invalid-tooltip">
                                                {{ trans('admin.Please Upload Your Front National Identity.') }}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="custom-file">
                                                <input type="file" name="back_image" class="custom-file-input" id="inputGroupFile01 validationTooltip12">
                                                <label class="custom-file-label" for="inputGroupFile01 validationTooltip12">{{trans('admin.upload back national identity')}}</label>
                                            </div>
                                            <br>
                                            <input type="hidden" name="old_back_image" value="{{$users->back_national_identity_image}}">
                                            <img src="{{asset($users->back_national_identity_image)}}" class="img-thumbnail" height="70px" width="100px">
                                            <div class="invalid-tooltip">
                                                {{ trans('admin.Please Upload Your Back National Identity.') }}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="validationTooltip13">{{trans('admin.selectServices')}}</label>
                                            <select class="form-control round" id="validationTooltip13" name="service_id" required>
                                                <option value="" disabled>{{trans('admin.selectServices')}}</option>
                                                @foreach($services as $service)
                                                <option value="{{$service->id}}" {{$users->service_id == $service->id ? 'selected':''}}>{{$service->name}}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-tooltip">
                                                {{ trans('admin.Please Choose The Service.') }}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="custom-file">
                                                <input type="file" name="attach_field" class="custom-file-input" id="inputGroupFile01 validationTooltip14">
                                                <label class="custom-file-label" for="inputGroupFile01 validationTooltip14">{{trans('admin.upload attach field')}}</label>
                                            </div>
                                            <br>
                                            <input type="hidden" name="old_attach_field" value="{{$users->attach_field_image}}">
                                            <img src="{{asset($users->attach_field_image)}}" class="img-thumbnail" height="70px" width="100px">
                                            <div class="invalid-tooltip">
                                                {{ trans('admin.Please Upload Attach Field.') }}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="validationTooltip15">{{trans('admin.price')}}</label>
                                            <input type="tel" pattern="^[0-9]*$" name="price" id="validationTooltip15" class="form-control round" placeholder="{{trans('admin.enter price')}}" value="{{ $users->price }}" required>
                                            <div class="invalid-tooltip">
                                                {{ trans('admin.Please Enter Your Price.') }}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="validationTooltip16">{{trans('admin.description')}}</label>
                                            <textarea id="validationTooltip16" rows="5" class="form-control round" name="description" placeholder="{{trans('admin.enter description')}}">{{ $users->description }}</textarea>
                                            <div class="invalid-tooltip">
                                                {{ trans('admin.Please Enter Your Description.') }}
                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-actions">
                                        <a href="{{asset('/admin/guides')}}" class="btn btn-danger mr-1">
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
