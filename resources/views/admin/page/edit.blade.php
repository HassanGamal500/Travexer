@extends('common.index')
@section('page_title')
    {{trans('admin.edit page')}}
@endsection
@section('content')
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-wrapper">
      <div class="content-wrapper-before"></div>
      <div class="content-header row">
        <div class="content-header-left col-md-4 col-12 mb-2">
          <h3 class="content-header-title">{{trans('admin.edit page')}}</h3>
        </div>
        <div class="content-header-right col-md-8 col-12">
          <div class="breadcrumbs-top float-md-right">
            <div class="breadcrumb-wrapper mr-1">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{asset('/admin/pages')}}">{{ trans('admin.pages') }}</a>
                </li>
                <li class="breadcrumb-item active">{{trans('admin.edit page')}}</a>
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

                                <form class="needs-validation" novalidate method="post" action="{{route('update_page', $pages[0]->id)}}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-body">

                                        <div class="form-group">
                                            <label for="validationTooltip1">{{trans('admin.name')}} ({{trans('admin.english')}})</label>
                                            <input type="text"  pattern="^[A-Za-z0-9_.,/{}@#!~%()-<>\s]+$" maxlength="100" name="page_description_name[1]" id="validationTooltip1" class="form-control round" placeholder="{{trans('admin.enter name english')}}" value="{{ $pages[0]->name }}" required>
                                            <div class="invalid-tooltip">
                                                {{ trans('admin.Please Enter Name English.') }}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="validationTooltip2">{{trans('admin.name')}} ({{trans('admin.arabic')}})</label>
                                            <input type="text"  pattern="^[\u0621-\u064A\u0660-\u0669\u06f0-\u06f9\s0-9_.,/{}@#!~%()<>-]+$" maxlength="100" name="page_description_name[2]" id="validationTooltip2" class="form-control round" placeholder="{{trans('admin.enter name arabic')}}" value="{{ $pages[1]->name }}" required>
                                            <div class="invalid-tooltip">
                                                {{ trans('admin.Please Enter Name Arabic.') }}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="validationTooltip1">{{trans('admin.description')}} ({{trans('admin.english')}})</label>
                                            <textarea name="page_description_content[1]" id="ckeditor" cols="30" rows="15" class="ckeditor" required>{{ $pages[0]->content }}</textarea>
                                            <div class="invalid-tooltip">
                                                {{ trans('admin.Please Enter Description English.') }}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="validationTooltip1">{{trans('admin.description')}} ({{trans('admin.arabic')}})</label>
                                            <textarea name="page_description_content[2]" id="ckeditor" cols="30" rows="15" class="ckeditor" required>{{ $pages[1]->content }}</textarea>
                                            <div class="invalid-tooltip">
                                                {{ trans('admin.Please Enter Description Arabic.') }}
                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-actions">
                                        <a href="{{asset('/admin/pages')}}" class="btn btn-danger mr-1">
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
