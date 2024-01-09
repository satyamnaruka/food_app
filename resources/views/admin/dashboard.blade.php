@extends('layouts/master')

@section('title',__('Dashboard'))

@section('content')



<section class="content">
    <div class="container-fluid dashboard-wrap">
        <div class="row ">
            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
                <a href="{{url('admin/user/list')}}">
                    <div class="card-board d-flex">
                        <div class="dash-icon">
                            <i class="fa fa-user text-white" aria-hidden="true"></i>
                        </div>
                        <div class="dash-content">
                            <div class="num-1 text-white">{{$users}}</div>
                            <div class="num-2 text-white">Registered Customer</div>
                            <div class="num-3 text-white">On our app</div>

                        </div>

                    </div>
                </a>
            </div>
            <div class="col-xl-3 col-lg-2 col-md-32 col-sm-12">
                <a href="{{url('admin/service-partner/pending')}}">
                    <div class="card-board d-flex">
                        <div class="dash-icon">
                            <i class="fa fa-user text-white" aria-hidden="true"></i>
                        </div>
                        <div class="dash-content">
                            <div class="num-1 text-white">{{$servicePartner}}</div>
                            <div class="num-2 text-white">Registered Service/Partner</div>
                            <div class="num-3 text-white">On our app</div>

                        </div>

                    </div>
                </a>
            </div>
            <!-- <div class="col-xl-2 col-lg-2 col-md-12 col-sm-12">
                <a href="#">
                    <div class="card-board-1">
                        <div class="dash-txt">
                            <div class="text-white dash-txt-1">0</div>
                            <div class="dash-txt-2 text-white">Total Orders</div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-2 col-lg-2 col-md-12 col-sm-2">
                <a href="#">
                    <div class="card-board-1  card-board-2">
                        <div class="dash-txt">
                            <div class="text-white dash-txt-1">0</div>
                            <div class="dash-txt-2 text-white">Order Status</div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-2 col-lg-2 col-md-12 col-sm-12">
                <a href="#">
                    <div class="card-board-1">
                        <div class="dash-txt">
                            <div class="text-white dash-txt-1">0</div>
                            <div class="dash-txt-2 text-white">Total Sales</div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-2 col-lg-2 col-md-12 col-sm-12">
                <a href="#">
                    <div class="card-board-1 card-board-2">
                        <div class="dash-txt">
                            <div class="text-white dash-txt-1">0.00</div>
                            <div class="dash-txt-2 text-white">Total payment gateway</div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-2 col-lg-2 col-md-12 col-sm-12">
                <a href="#">
                    <div class="card-board-1">
                        <div class="dash-txt">
                            <div class="text-white dash-txt-1">0</div>
                            <div class="dash-txt-2 text-white"> Total time slot and date</div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-2 col-lg-2 col-md-12 col-sm-12">
                <a href="#">
                    <div class="card-board-1 card-board-2">
                        <div class="dash-txt">
                            <div class="text-white dash-txt-1">0</div>
                            <div class="dash-txt-2 text-white">Total Partner</div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-2 col-lg-2 col-md-12 col-sm-12">
                <a href="#">
                    <div class="card-board-1">
                        <div class="dash-txt">
                            <div class="text-white dash-txt-1">0</div>
                            <div class="dash-txt-2 text-white">Total Credit Package</div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-2 col-lg-2 col-md-12 col-sm-12">
                <a href="#">
                    <div class="card-board-1 card-board-2">
                        <div class="dash-txt">
                            <div class="text-white dash-txt-1">0</div>
                            <div class="dash-txt-2 text-white">Total section</div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-2 col-lg-2 col-md-12 col-sm-12">
                <a href="#">
                    <div class="card-board-1">
                        <div class="dash-txt">
                            <div class="text-white dash-txt-1">0</div>
                            <div class="dash-txt-2 text-white">Total city</div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-2 col-lg-2 col-md-12 col-sm-12">
                <a href="#">
                    <div class="card-board-1 card-board-2">
                        <div class="dash-txt">
                            <div class="text-white dash-txt-1">0</div>
                            <div class="dash-txt-2 text-white">Total customer</div>
                        </div>
                    </div>
                </a>
            </div> -->
        </div>
    </div>
</section>











@endsection


@push('custom_js')
<script src="{{ asset('admin-assets/js/chart.min.js')}}"></script>
<script src="{{ asset('admin-assets/js/echarts.js')}}"></script>
<script src="{{ asset('admin-assets/js/apexcharts.min.js') }}"></script>

@endpush