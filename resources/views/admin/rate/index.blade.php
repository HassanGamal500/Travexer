@extends('common.index')
@section('page_title')
    {{trans('admin.rates')}}
@endsection
@section('content')
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-wrapper-before"></div>
        <div class="content-header row">
            <div class="content-header-left col-md-4 col-12 mb-2">
                <h3 class="content-header-title">{{ trans('admin.rates') }}</h3>
            </div>
            <div class="content-header-right col-md-8 col-12">
                <div class="breadcrumbs-top float-md-right">
                    <div class="breadcrumb-wrapper mr-1">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/admin')}}">{{ trans('admin.Home') }}</a>
                            </li>
                            <li class="breadcrumb-item active">{{ trans('admin.rates') }}
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <!-- Zero configuration table -->
            <section id="configuration">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{ trans('admin.all rate') }}</h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        {{-- <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li> --}}
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered zero-configuration datatable">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>{{ trans('admin.name') }}</th>
                                                    <th>{{ trans('admin.star') }}</th>
                                                    <th>{{ trans('admin.content') }}</th>
                                                    <th>{{ trans('admin.actions') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($rates as $rate)
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$rate->name}}</td>
                                                    <td>
                                                        @if($rate->star == 1)
                                                        <div id="read-only-stars" title="regular">
                                                            <img alt="1" src="{{asset('theme-assets/images/raty/star-on.png')}}" title="regular">
                                                            &nbsp;
                                                            <img alt="2" src="{{asset('theme-assets/images/raty/star-off.png')}}" title="regular">
                                                            &nbsp;
                                                            <img alt="3" src="{{asset('theme-assets/images/raty/star-off.png')}}" title="regular">
                                                            &nbsp;
                                                            <img alt="4" src="{{asset('theme-assets/images/raty/star-off.png')}}" title="regular">
                                                            &nbsp;
                                                            <img alt="5" src="{{asset('theme-assets/images/raty/star-off.png')}}" title="regular">
                                                        </div>
                                                        @elseif($rate->star == 2)
                                                        <div id="read-only-stars" title="regular">
                                                            <img alt="1" src="{{asset('theme-assets/images/raty/star-on.png')}}" title="regular">
                                                            &nbsp;
                                                            <img alt="2" src="{{asset('theme-assets/images/raty/star-on.png')}}" title="regular">
                                                            &nbsp;
                                                            <img alt="3" src="{{asset('theme-assets/images/raty/star-off.png')}}" title="regular">
                                                            &nbsp;
                                                            <img alt="4" src="{{asset('theme-assets/images/raty/star-off.png')}}" title="regular">
                                                            &nbsp;
                                                            <img alt="5" src="{{asset('theme-assets/images/raty/star-off.png')}}" title="regular">
                                                        </div>
                                                        @elseif($rate->star == 3)
                                                        <div id="read-only-stars" title="regular">
                                                            <img alt="1" src="{{asset('theme-assets/images/raty/star-on.png')}}" title="regular">
                                                            &nbsp;
                                                            <img alt="2" src="{{asset('theme-assets/images/raty/star-on.png')}}" title="regular">
                                                            &nbsp;
                                                            <img alt="3" src="{{asset('theme-assets/images/raty/star-on.png')}}" title="regular">
                                                            &nbsp;
                                                            <img alt="4" src="{{asset('theme-assets/images/raty/star-off.png')}}" title="regular">
                                                            &nbsp;
                                                            <img alt="5" src="{{asset('theme-assets/images/raty/star-off.png')}}" title="regular">
                                                        </div>
                                                        @elseif($rate->star == 4)
                                                        <div id="read-only-stars" title="regular">
                                                            <img alt="1" src="{{asset('theme-assets/images/raty/star-on.png')}}" title="regular">
                                                            &nbsp;
                                                            <img alt="2" src="{{asset('theme-assets/images/raty/star-on.png')}}" title="regular">
                                                            &nbsp;
                                                            <img alt="3" src="{{asset('theme-assets/images/raty/star-on.png')}}" title="regular">
                                                            &nbsp;
                                                            <img alt="4" src="{{asset('theme-assets/images/raty/star-on.png')}}" title="regular">
                                                            &nbsp;
                                                            <img alt="5" src="{{asset('theme-assets/images/raty/star-off.png')}}" title="regular">
                                                        </div>
                                                        @else
                                                        <div id="read-only-stars" title="regular">
                                                            <img alt="1" src="{{asset('theme-assets/images/raty/star-on.png')}}" title="regular">
                                                            &nbsp;
                                                            <img alt="2" src="{{asset('theme-assets/images/raty/star-on.png')}}" title="regular">
                                                            &nbsp;
                                                            <img alt="3" src="{{asset('theme-assets/images/raty/star-on.png')}}" title="regular">
                                                            &nbsp;
                                                            <img alt="4" src="{{asset('theme-assets/images/raty/star-on.png')}}" title="regular">
                                                            &nbsp;
                                                            <img alt="5" src="{{asset('theme-assets/images/raty/star-on.png')}}" title="regular">
                                                        </div>
                                                        @endif
                                                        
                                                    </td>
                                                    <td>{{$rate->content}}</td>
                                                    <td>
                                                        <button class="btn btn-glow btn-bg-gradient-x-red-pink alerts" data-url="{{asset('admin/delete_rate')}}/" data-table="datatable" data-id="{{ $rate->id }}">{{trans('admin.delete')}}</button>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>{{ trans('admin.name') }}</th>
                                                    <th>{{ trans('admin.star') }}</th>
                                                    <th>{{ trans('admin.content') }}</th>
                                                    <th>{{ trans('admin.actions') }}</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!--/ Zero configuration table -->


        </div>
    </div>
</div>
<!-- END: Content-->
@endsection
