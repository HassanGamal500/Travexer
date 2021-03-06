@extends('common.index')
@section('page_title')
    {{trans('admin.companies')}}
@endsection
@section('content')
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-wrapper-before"></div>
        <div class="content-header row">
            <div class="content-header-left col-md-4 col-12 mb-2">
                <h3 class="content-header-title">{{ trans('admin.companies') }}</h3>
                <br>
                <a href="{{url(route('add_company'))}}" class="btn btn-glow btn-bg-gradient-x-blue-green col-12 col-md-5 mr-1 mb-1">{{ trans('admin.AddNew') }}</a>
            </div>
            <div class="content-header-right col-md-8 col-12">
                <div class="breadcrumbs-top float-md-right">
                    <div class="breadcrumb-wrapper mr-1">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/admin')}}">{{ trans('admin.Home') }}</a>
                            </li>
                            <li class="breadcrumb-item active">{{ trans('admin.companies') }}
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
                                <h4 class="card-title">{{ trans('admin.all company') }}</h4>
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
                                                    <th>{{ trans('admin.phone') }}</th>
                                                    <th>{{ trans('admin.email') }}</th>
                                                    <th>{{ trans('admin.join') }}</th>
                                                    <th>{{ trans('admin.activate') }}</th>
                                                    <th>{{ trans('admin.actions') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($users as $user)
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$user->name}}</td>
                                                    <td>{{$user->phone}}</td>
                                                    <td>{{$user->email}}</td>
                                                    <td>
                                                        <input type="checkbox" data-id="{{$user->id}}" data-type="is_join" id="switcheryColor1" class="switchery toggle-class" data-color="warning" data-secondary-color="warning" {{ $user->is_join ? 'checked' : '' }} data-switchery="true" style="display: none;">
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" data-id="{{$user->id}}" data-type="user" id="switcheryColor1" class="switchery toggle-class" data-color="warning" data-secondary-color="warning" {{ $user->active ? 'checked' : '' }} data-switchery="true" style="display: none;">
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-glow btn-bg-gradient-x-orange-yellow dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                {{trans('admin.action')}}
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item" href="{{url(route('edit_company', $user->id))}}">{{trans('admin.edit')}}</a>
                                                                <button class="dropdown-item alerts" data-url="{{asset('admin/delete_company')}}/" data-table="datatable" data-id="{{ $user->id }}">{{trans('admin.delete')}}</button>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>{{ trans('admin.name') }}</th>
                                                    <th>{{ trans('admin.phone') }}</th>
                                                    <th>{{ trans('admin.email') }}</th>
                                                    <th>{{ trans('admin.join') }}</th>
                                                    <th>{{ trans('admin.activate') }}</th>
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
