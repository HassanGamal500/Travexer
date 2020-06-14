@extends('common.index')
@section('page_title')
    {{trans('admin.add faq')}}
@endsection
@section('content')
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-wrapper">
      <div class="content-wrapper-before"></div>
      <div class="content-header row">
        <div class="content-header-left col-md-4 col-12 mb-2">
          <h3 class="content-header-title">{{trans('admin.add faq')}}</h3>
        </div>
        <div class="content-header-right col-md-8 col-12">
          <div class="breadcrumbs-top float-md-right">
            <div class="breadcrumb-wrapper mr-1">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{asset('/admin/faqs')}}">{{ trans('admin.faqs') }}</a>
                </li>
                <li class="breadcrumb-item active">{{trans('admin.add faq')}}</a>
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

                                <form class="needs-validation" novalidate method="post" action="{{route('store_faq')}}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-body">

                                        <div class="form-group">
                                            <label for="validationTooltip1">{{trans('admin.question')}} ({{trans('admin.english')}})</label>
                                            <input type="text" pattern="^[A-Za-z0-9_.,?\x22\x27/{}@#!~%()-<>\s]+$" maxlength="150" name="faq_question[1]" id="validationTooltip1" class="form-control round" placeholder="{{trans('admin.enter question english')}}" value="{{ old('faq_question.1') }}" required>
                                            <div class="invalid-tooltip">
                                                {{ trans('admin.Please Enter Question English.') }}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="validationTooltip2">{{trans('admin.question')}} ({{trans('admin.arabic')}})</label>
                                            <input type="text" pattern="^[\u0621-\u064A\u0660-\u0669\u06f0-\u06f9\s0-9_.,؟\x22\x27/{}@#!~%()<>-]+$" maxlength="150" name="faq_question[2]" id="validationTooltip2" class="form-control round" placeholder="{{trans('admin.enter question arabic')}}" value="{{ old('faq_question.2') }}" required>
                                            <div class="invalid-tooltip">
                                                {{ trans('admin.Please Enter Question Arabic.') }}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="validationTooltip16">{{trans('admin.answer')}} ({{trans('admin.english')}})</label>
                                            <textarea id="validationTooltip16" pattern="^[A-Za-z0-9_.,?\x22\x27/{}@#!~%()-<>\s]+$" rows="5" class="form-control round" name="faq_answer[1]" placeholder="{{trans('admin.enter asnwer english')}}" required>{{ old('faq_answer.1') }}</textarea>
                                            <div class="invalid-tooltip">
                                                {{ trans('admin.Please Enter Answer English.') }}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="validationTooltip17">{{trans('admin.answer')}} ({{trans('admin.arabic')}})</label>
                                            <textarea id="validationTooltip17" pattern="^[\u0621-\u064A\u0660-\u0669\u06f0-\u06f9\s0-9_.,؟\x22\x27/{}@#!~%()<>-]+$" rows="5" class="form-control round" name="faq_answer[2]" placeholder="{{trans('admin.enter asnwer arabic')}}" required>{{ old('faq_answer.2') }}</textarea>
                                            <div class="invalid-tooltip">
                                                {{ trans('admin.Please Enter Answer Arabic.') }}
                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-actions">
                                        <a href="{{asset('/admin/faqs')}}" class="btn btn-danger mr-1">
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
