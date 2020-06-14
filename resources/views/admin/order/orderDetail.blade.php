@extends('common.index')
@section('page_title')
    {{trans('admin.order details')}}
@endsection
@section('content')
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-wrapper-before"></div>
        <div class="content-header row">
            <div class="content-header-left col-md-4 col-12 mb-2">
                <h3 class="content-header-title">{{ trans('admin.order details') }}</h3>
            </div>
            <div class="content-header-right col-md-8 col-12">
                <div class="breadcrumbs-top float-md-right">
                    <div class="breadcrumb-wrapper mr-1">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/admin/order_guide')}}">{{ trans('admin.orders') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ trans('admin.order details') }}
                        </li>
                    </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body" id="">
            <section class="card">
                <div id="invoice-template" class="card-body">
                <div id="printable">
                    <!-- Invoice Company Details -->
                    <div id="invoice-company-details" class="row">
                        <div class="col-md-6 col-sm-12 text-left text-md-left">							
                            <img src="{{asset('theme-assets/images/ico/fav.png')}}" alt="company logo" class="mb-2" width="70">
                            <ul class="px-0 list-unstyled">
                                <li class="text-bold-700">Travexer</li>
                            </ul>
                                
                        </div>
                        <div class="col-md-6 col-sm-12 text-center text-md-right">
                            <h2>{{ trans('admin.OrderID') }}</h2>
                            <p># {{ $orders->id }}</p>
                            <p> {{ $orders->created_at }}</p>				
                        </div>
                    </div>
                    <!--/ Invoice Company Details -->

                    <!-- Invoice Customer Details -->
                    <div id="invoice-customer-details" class="row pt-2">
                        <div class="col-md-6 col-sm-12">
                            <p class="text-muted">{{ trans('admin.bookTo') }}</p>
                            @if($orders->book_type == 1)
                            <ul class="px-0 list-unstyled">
                                <li class="text-bold-700">{{ $orders->guide_name }}</li>
                                {{-- <li>{{ $orders->guide_email }}</li> --}}
                                {{-- <li>{{ $orders->guide_phone }}</li> --}}
                            </ul>
                            @else
                            <ul class="px-0 list-unstyled">
                                <li class="text-bold-700">{{ $orders->trip_title }}</li>
                                <li>{{ $orders->trip_description }}</li>
                                {{-- <li>{{ $orders->guide_phone }}</li> --}}
                            </ul>
                            @endif
                        </div>
                        <div class="col-md-6 col-sm-12 text-center text-md-right">
                            <p class="text-muted">{{ trans('admin.bookFrom') }}</p>
                            <ul class="px-0 list-unstyled">
                                <li class="text-bold-700">{{ $orders->user_name }}</li>
                                <li>{{ $orders->user_email }}</li>
                                <li>{{ $orders->user_phone }}</li>
                                <li>{{ $orders->city_name }}, {{ $orders->country_name }}</li>
                            </ul>
                        </div>
                    </div>
                    <!--/ Invoice Customer Details -->

                    <!-- Invoice Items Details -->
                    <div id="invoice-items-details" class="pt-2">
                        <div class="row">
                            <div class="col-md-12">
                                <p class="lead">{{ trans('admin.BasicInfo') }}</p>
                                <div class="table-responsive">
                                    <table class="table">
                                        @if($orders->book_type == 1)
                                        <tbody>
                                            <tr>
                                                <td>{{ trans('admin.date') }}</td>
                                                <td class="text-right">{{ $orders->date }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('admin.time') }}</td>
                                                <td class="text-right">{{ $orders->time }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-bold-800">{{ trans('admin.price') }}</td>
                                                <td class="text-bold-800 text-right">  {{ $orders->guide_price }} SAR</td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('admin.NOTE') }}</td>
                                                <td class="text-right">{{ $orders->note }}</td>
                                            </tr>
                                        </tbody>
                                        @else
                                        <tbody>
                                            <tr>
                                                <td>{{ trans('admin.date') }}</td>
                                                <td class="text-right">{{ $orders->date }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('admin.time') }}</td>
                                                <td class="text-right">{{ $orders->time }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-bold-800">{{ trans('admin.price') }}</td>
                                                <td class="text-bold-800 text-right">  {{ $orders->trip_price }} SAR</td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('admin.discount') }}</td>
                                                <td class="text-right">{{ $orders->trip_discount }} SAR</td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('admin.trip date') }}</td>
                                                <td class="text-right">{{ $orders->trip_date }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('admin.trip time from') }}</td>
                                                <td class="text-right">{{ $orders->trip_time_from }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('admin.trip time to') }}</td>
                                                <td class="text-right">{{ $orders->trip_time_to }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('admin.childPercent') }}</td>
                                                <td class="text-right">{{ $orders->trip_child_percent }} %</td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('admin.numOfAdult') }}</td>
                                                <td class="text-right">{{ $orders->no_of_adult }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('admin.numOfChild') }}</td>
                                                <td class="text-right">{{ $orders->no_of_child }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('admin.NOTE') }}</td>
                                                <td class="text-right">{{ $orders->note }}</td>
                                            </tr>
                                        </tbody>
                                        @endif
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                    <!-- Invoice Footer -->
                    <div id="invoice-footer">
                        <div class="row">
                            <div class="col-sm-12 text-center">
                                <button type="button" class="btn btn-info btn-lg my-1" onclick="printDiv('printable')"><i class="la la-paper-plane-o"></i> Send Invoice</button>
                            </div>
                        </div>
                    </div>
                    <!--/ Invoice Footer -->

                </div>
            </section>
        </div>
    </div>
</div>
<!-- END: Content-->
@endsection
