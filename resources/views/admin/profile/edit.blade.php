@extends('common.index')
@section('page_title')
    {{trans('admin.profile_link')}}
@endsection
@section('content')
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-wrapper">
      <div class="content-wrapper-before"></div>
      <div class="content-header row">
        <div class="content-header-left col-md-4 col-12 mb-2">
          <h3 class="content-header-title">{{trans('admin.profile_link')}}</h3>
        </div>
        <div class="content-header-right col-md-8 col-12">
          <div class="breadcrumbs-top float-md-right">
            <div class="breadcrumb-wrapper mr-1">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{asset('/admin')}}">Home</a>
                </li>
                <li class="breadcrumb-item active"><a href="#">{{trans('admin.profile_link')}}</a>
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

                                <form class="needs-validation" novalidate method="post" action="{{route('update_profile', $users->id)}}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-body">

                                        <div class="form-group">
                                            <label for="validationTooltip">{{trans('admin.name')}}</label>
                                            <input type="text"  name="name" id="validationTooltip" class="form-control round" placeholder="{{trans('admin.enter name')}}" value="{{$users->name}}" required>
                                            <div class="invalid-tooltip">
                                                {{ trans('admin.Please Enter Your Name.') }}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="validationTooltip">{{trans('admin.phone')}}</label>
                                            <input type="tel" pattern="^[0-9]*$"  name="phone" id="validationTooltip" class="form-control round" placeholder="{{trans('admin.enter phone')}}" value="{{$users->phone}}" required>
                                            <div class="invalid-tooltip">
                                                {{ trans('admin.Please Enter Your Phone Number.') }}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="validationTooltip">{{trans('admin.email')}}</label>
                                            <input type="email" name="email" id="validationTooltip" class="form-control round" placeholder="{{trans('admin.enter email')}}" value="{{$users->email}}" required>
                                            <div class="invalid-tooltip">
                                                {{ trans('admin.Please Enter Your Email Address.') }}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="validationTooltip">{{trans('admin.password')}}</label>
                                            <input type="password" name="password" id="validationTooltip" class="form-control round" placeholder="{{trans('admin.enter new password')}}">
                                        </div>

                                        <div class="form-group">
                                            <label for="validationTooltip">{{trans('admin.upload photo')}}</label>
                                            <input type="file" name="image" id="validationTooltip" class="form-control-file">
                                            <br>
                                            <input type="hidden" name="old_image" value="{{$users->image}}">
                                            <img src="{{asset($users->image)}}" class="img-thumbnail" height="70px" width="100px">
                                        </div>

                                        
                                    </div>

                                    <div class="form-actions">
                                        <a href="{{ url()->previous() }}" class="btn btn-danger mr-1">
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
