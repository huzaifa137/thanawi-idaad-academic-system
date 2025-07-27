<?php
use App\Http\Controllers\Helper;
use App\Helpers\PermissionHelper;
use App\Http\Controllers\Controller;
$controller = new Controller();
?>
@extends('layouts-side-bar.master')
@section('css')
    <!---jvectormap css-->
    <link href="{{ URL::asset('assets/plugins/jvectormap/jqvmap.css') }}" rel="stylesheet" />
    <!-- Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <!--Daterangepicker css-->
    <link href="{{ URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet" />
@endsection

@section('content')
    <!-- Student Dashboard -->
    <div class="side-app">

        <div class="page-header">
            <h1 class="page-title">

                @if (PermissionHelper::userPermissionSectionAccess(session('LoggedStudent'), 158, 'school'))
                    Welcome,

                @else

                @endif

                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                <script>
                    @if(session('error'))
                        Swal.fire({
                            icon: 'warning',
                            title: 'Error',
                            text: '{{ session('error') }}',
                            timer: 7000,
                            showConfirmButton: false
                        });
                    @endif
                </script>


                {{-- @if (!empty($student->firstname) && !empty($student->lastname))
                {{ $student->firstname }} {{ $student->lastname }}
                @else
                {{ $student->username }}
                @endif --}}
            </h1>
        </div>

        <!-- Include Bootstrap Icons -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
        <style>
            .dashboard-card {
                position: relative;
                overflow: hidden;
                border-radius: 0.75rem;
                transition: transform 0.3s ease, box-shadow 0.3s ease;
                min-height: 120px;
            }

            .dashboard-card:hover {
                transform: translateY(-3px);
                box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            }

            .dashboard-icon {
                font-size: 1.75rem;
                padding: 0.5rem;
                border-radius: 0.5rem;
                background: rgba(255, 255, 255, 0.15);
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }

            .card-overlay {
                position: absolute;
                top: -50%;
                left: -50%;
                width: 200%;
                height: 200%;
                background: radial-gradient(circle, rgba(255, 255, 255, 0.1), transparent 70%);
                transform: rotate(45deg);
                pointer-events: none;
                z-index: 1;
            }

            .dashboard-card .card-body {
                position: relative;
                z-index: 2;
                padding: 1rem 1.25rem;
            }

            .card-metric {
                font-weight: 600;
                font-size: 1.5rem;
                line-height: 1.2;
            }

            .label-sub {
                font-size: 0.8rem;
                opacity: 0.85;
                margin-top: 0.25rem;
            }

            .card-title {
                font-size: 0.9rem;
                margin-bottom: 0.25rem;
            }

            #chart-pie2 {
                height: 400px;
                width: 100%;
                max-width: 400px;
                margin: 0 auto;
            }
        </style>
        <div class="row g-3">

            <!-- Courses Enrolled -->
            <div class="col-sm-6 col-xl-3">
                <div class="card dashboard-card text-white" style="background: linear-gradient(135deg, #1e3c72, #2a5298);">
                    <div class="card-overlay"></div>
                    <div class="card-body d-flex align-items-center">
                        <div class="dashboard-icon me-3">
                            <i class="bi bi-mortarboard-fill"></i>
                        </div>
                        <div>
                            <div class="card-title">&nbsp;&nbsp;Courses &nbsp;&nbsp;Enrolled</div>
                            <div class="card-metric">&nbsp;&nbsp;0</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modules -->
            <div class="col-sm-6 col-xl-3">
                <div class="card dashboard-card text-white" style="background: linear-gradient(135deg, #4e54c8, #8f94fb);">
                    <div class="card-overlay"></div>
                    <div class="card-body d-flex align-items-center">
                        <div class="dashboard-icon me-3">
                            <i class="bi bi-layers-fill"></i>
                        </div>
                        <div>
                            <div class="card-title">&nbsp;&nbsp;Modules</div>
                            <div class="card-metric">&nbsp;&nbsp;0</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lessons Completed -->
            <div class="col-sm-6 col-xl-3">
                <div class="card dashboard-card text-white" style="background: linear-gradient(135deg, #11998e, #38ef7d);">
                    <div class="card-overlay"></div>
                    <div class="card-body d-flex align-items-center">
                        <div class="dashboard-icon me-3">
                            <i class="bi bi-bookmark-check-fill"></i>
                        </div>
                        <div>
                            <div class="card-title">&nbsp;&nbsp;Lessons &nbsp;&nbsp;Completed</div>
                            <div class="card-metric">&nbsp;&nbsp;0</div>
                            <div class="label-sub">
                                &nbsp;&nbsp;Progress :
                                @if (true)
                                    100%
                                @else
                                    0%
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quizzes Passed -->
            <div class="col-sm-6 col-xl-3">
                <div class="card dashboard-card text-dark" style="background: linear-gradient(135deg, #f7971e, #ffd200);">
                    <div class="card-overlay"></div>
                    <div class="card-body d-flex align-items-center">
                        <div class="dashboard-icon me-3 bg-light text-dark">
                            <i class="bi bi-award-fill"></i>
                        </div>
                        <div>
                            <div class="card-title">&nbsp;&nbsp;Quizzes Done</div>
                            <div class="card-metric">&nbsp;&nbsp;0</div>
                            <div class="label-sub">
                                &nbsp;&nbsp;Performance : 100%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Enrolled Courses Status</h3>
                    </div>
                    <div class="card-body">
                        <div id="chart-pie2" class="chartsh"></div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/5.16.0/d3.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/c3/0.7.20/c3.min.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/c3/0.7.20/c3.min.css" rel="stylesheet">


    </div>
    </div>
    </div>
@endsection
@section('js')

    <!-- c3.js Charts js-->
    <script src="{{ URL::asset('assets/plugins/charts-c3/d3.v5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/charts-c3/c3-chart.js') }}"></script>
    <script src="{{ URL::asset('assets/js/charts.js') }}"></script>

    <!-- ECharts js -->
    <script src="{{ URL::asset('assets/plugins/echarts/echarts.js') }}"></script>
    <!-- Peitychart js-->
    <script src="{{ URL::asset('assets/plugins/peitychart/jquery.peity.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/peitychart/peitychart.init.js') }}"></script>
    <!-- Apexchart js-->
    <script src="{{ URL::asset('assets/js/apexcharts.js') }}"></script>
    <!--Moment js-->
    <script src="{{ URL::asset('assets/plugins/moment/moment.js') }}"></script>
    <!-- Daterangepicker js-->
    <script src="{{ URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ URL::asset('assets/js/daterange.js') }}"></script>
    <!---jvectormap js-->
    <script src="{{ URL::asset('assets/plugins/jvectormap/jquery.vmap.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jvectormap/jquery.vmap.world.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jvectormap/jquery.vmap.sampledata.js') }}"></script>
    <!-- Index js-->
    <script src="{{ URL::asset('assets/js/index1.js') }}"></script>
    <!-- Data tables js-->
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/datatables.js') }}"></script>
    <!--Counters -->
    <script src="{{ URL::asset('assets/plugins/counters/counterup.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/counters/waypoints.min.js') }}"></script>
    <!--Chart js -->
    <script src="{{ URL::asset('assets/plugins/chart/chart.bundle.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/chart/utils.js') }}"></script>
@endsection