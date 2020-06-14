@extends('common.index')
@section('page_title')
    {{trans('admin.aboutUs')}}
@endsection
@section('content')
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-wrapper">
      <div class="content-wrapper-before"></div>
      <div class="content-header row">
        <div class="content-header-left col-md-4 col-12 mb-2">
          <h3 class="content-header-title">{{trans('admin.aboutUs')}}</h3>
        </div>
        <div class="content-header-right col-md-8 col-12">
          <div class="breadcrumbs-top float-md-right">
            <div class="breadcrumb-wrapper mr-1">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{asset('/admin')}}">{{ trans('admin.Home') }}</a>
                </li>
                <li class="breadcrumb-item active">{{trans('admin.aboutUs')}}</a>
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

                                <form class="needs-validation" novalidate method="post" action="{{route('update_about')}}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-body">

                                        <div class="form-group">
                                            <label for="validationTooltip1">{{trans('admin.description')}} ({{trans('admin.english')}})</label>
                                            <textarea name="description[1]" rows="5" class="form-control" placeholder="{{trans('admin.enter description english')}}" required>{{ $about[0]->description }}</textarea>
                                            <div class="invalid-tooltip">
                                                {{ trans('admin.Please Enter Description English.') }}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="validationTooltip1">{{trans('admin.description')}} ({{trans('admin.arabic')}})</label>
                                            <textarea name="description[2]" rows="5" class="form-control" placeholder="{{trans('admin.enter description arabic')}}" required>{{ $about[1]->description }}</textarea>
                                            <div class="invalid-tooltip">
                                                {{ trans('admin.Please Enter Description Arabic.') }}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="validationTooltip1">{{trans('admin.mission')}} ({{trans('admin.english')}})</label>
                                            <textarea name="mission[1]" rows="5" class="form-control" placeholder="{{trans('admin.enter mission english')}}" required>{{ $about[0]->mission }}</textarea>
                                            <div class="invalid-tooltip">
                                                {{ trans('admin.Please Enter Mission English.') }}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="validationTooltip1">{{trans('admin.mission')}} ({{trans('admin.arabic')}})</label>
                                            <textarea name="mission[2]" rows="5" class="form-control" placeholder="{{trans('admin.enter mission arabic')}}" required>{{ $about[1]->mission }}</textarea>
                                            <div class="invalid-tooltip">
                                                {{ trans('admin.Please Enter Mission Arabic.') }}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="validationTooltip1">{{trans('admin.vission')}} ({{trans('admin.english')}})</label>
                                            <textarea name="vission[1]" rows="5" class="form-control" placeholder="{{trans('admin.enter vission english')}}" required>{{ $about[0]->vission }}</textarea>
                                            <div class="invalid-tooltip">
                                                {{ trans('admin.Please Enter Vission English.') }}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="validationTooltip1">{{trans('admin.vission')}} ({{trans('admin.arabic')}})</label>
                                            <textarea name="vission[2]" rows="5" class="form-control" placeholder="{{trans('admin.enter vission arabic')}}" required>{{ $about[1]->vission }}</textarea>
                                            <div class="invalid-tooltip">
                                                {{ trans('admin.Please Enter Vission Arabic.') }}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="validationTooltip1">{{trans('admin.values')}} ({{trans('admin.english')}})</label>
                                            <textarea name="values[1]" rows="5" class="form-control" placeholder="{{trans('admin.enter values english')}}" required>{{ $about[0]->values }}</textarea>
                                            <div class="invalid-tooltip">
                                                {{ trans('admin.Please Enter Values English.') }}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="validationTooltip1">{{trans('admin.values')}} ({{trans('admin.arabic')}})</label>
                                            <textarea name="values[2]" rows="5" class="form-control" placeholder="{{trans('admin.enter values arabic')}}" required>{{ $about[1]->values }}</textarea>
                                            <div class="invalid-tooltip">
                                                {{ trans('admin.Please Enter Values Arabic.') }}
                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-actions">
                                        <a href="{{asset('/admin')}}" class="btn btn-danger mr-1">
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
