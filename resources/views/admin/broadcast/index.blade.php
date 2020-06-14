@extends('common.index')
@section('page_title')
    {{trans('admin.broadcasts')}}
@endsection
@section('content')
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-wrapper-before"></div>
        <div class="content-header row">
            <div class="content-header-left col-md-4 col-12 mb-2">
                <h3 class="content-header-title">{{ trans('admin.broadcasts') }}</h3>
            </div>
            <div class="content-header-right col-md-8 col-12">
                <div class="breadcrumbs-top float-md-right">
                    <div class="breadcrumb-wrapper mr-1">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/admin')}}">{{ trans('admin.Home') }}</a>
                            </li>
                            <li class="breadcrumb-item active">{{ trans('admin.broadcasts') }}
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
                                <h4 class="card-title">{{ trans('admin.all broadcasts') }}</h4>
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
                                                    <th>{{ trans('admin.date') }}</th>
                                                    <th>{{ trans('admin.start') }}</th>
                                                    <th>{{ trans('admin.end') }}</th>
                                                    <th>{{ trans('admin.actions') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($broadcasts as $broadcast)
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$broadcast->user_name}}</td>
                                                    <td>{{$broadcast->date}}</td>
                                                    <td>{{$broadcast->start}}</td>
                                                    <td>{{$broadcast->end}}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-glow btn-bg-gradient-x-orange-yellow get_broadcast" data-id="{{ $broadcast->id }}" data-target="#warning">
                                                            {{ trans('admin.detail') }}
                                                        </button>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>{{ trans('admin.name') }}</th>
                                                    <th>{{ trans('admin.date') }}</th>
                                                    <th>{{ trans('admin.start') }}</th>
                                                    <th>{{ trans('admin.end') }}</th>
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
            <!-- Modal -->
            <div class="modal fade text-left modal_broadcast" id="warning" tabindex="-1" role="dialog" aria-labelledby="myModalLabel12" style="display: none;" aria-hidden="true">
                <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-warning white">
                        <h4 class="modal-title white" id="myModalLabel12"><i class="la la-tree"></i> {{ trans('admin.detail') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5><i class="la la-arrow-right"></i> {{ trans('admin.name') }} : </h5>
                            </div>
                            <div class="col-md-6 text-left">
                                <h6 class="name"></h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <h5><i class="la la-arrow-right"></i> {{ trans('admin.email') }} : </h5>
                            </div>
                            <div class="col-md-6 text-left">
                                <h6 class="email"></h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <h5><i class="la la-arrow-right"></i> {{ trans('admin.phone') }} : </h5>
                            </div>
                            <div class="col-md-6 text-left">
                                <h6 class="phone"></h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <h5><i class="la la-arrow-right"></i> {{ trans('admin.date') }} : </h5>
                            </div>
                            <div class="col-md-6 text-left">
                                <h6 class="date"></h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <h5><i class="la la-arrow-right"></i> {{ trans('admin.start') }} : </h5>
                            </div>
                            <div class="col-md-6 text-left">
                                <h6 class="start"></h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <h5><i class="la la-arrow-right"></i> {{ trans('admin.end') }} : </h5>
                            </div>
                            <div class="col-md-6 text-left">
                                <h6 class="end"></h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <h5><i class="la la-arrow-right"></i> {{ trans('admin.NOTE') }} : </h5>
                            </div>
                            <div class="col-md-6 text-left">
                                <h6 class="note"></h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <h5><i class="la la-arrow-right"></i> {{ trans('admin.service') }} : </h5>
                            </div>
                            <div class="col-md-6 text-left">
                                <h6 class="service"></h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <h5><i class="la la-arrow-right"></i> {{ trans('admin.Country') }} : </h5>
                            </div>
                            <div class="col-md-6 text-left">
                                <h6 class="country"></h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <h5><i class="la la-arrow-right"></i> {{ trans('admin.City') }} : </h5>
                            </div>
                            <div class="col-md-6 text-left">
                                <h6 class="city"></h6>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn grey btn-warning" data-dismiss="modal">Close</button>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Content-->
@endsection
