<?php
use App\Http\Controllers\Helper;
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

        <!-- HTML -->
        <div class="row">
            <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                <div class="card bg-primary">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0 text-white">Set Term Dates</h4>
                        <a href="{{ route('add-academic-year') }}" class="btn btn-secondary">
                            <i class="fas fa-calendar-alt me-2"></i> All Academic Years
                        </a>
                        <a href="{{ route('school.allSchools') }}" class="btn btn-secondary">
                            <i class="fas fa-school me-2"></i> All Schools
                        </a>
                    </div>
                    <div class="card-body bg-light">
                        <form id="createSchoolForm">
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Academic Year</label>
                                        <select name="academic_year" id="academic_year" class="form-control">
                                            <option value="1">Sunday</option>
                                            <option value="2">Monday</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Term</label>
                                        <?php
                                        echo Helper::DropMasterData(config('constants.options.SCHOOL_TERMS'), '', 'academic_term', 1);
                                        ?>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Start Date</label>
                                        <input class="form-control" type="date" name="start_date" id="start_date">
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">End Date</label>
                                        <input class="form-control" type="date" name="end_date" id="end_date">
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Week Starts on</label>
                                        <select name="week_starts_on" id="week_starts_on" class="form-control">
                                            <option value="1">Sunday</option>
                                            <option value="2">Monday</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 text-left">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane"></i> Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const today = new Date().toISOString().split('T')[0];
            const startDate = document.getElementById('start_date');
            const endDate = document.getElementById('end_date');

            startDate.setAttribute('min', today);
            endDate.setAttribute('min', today);

            startDate.addEventListener('change', function() {
                endDate.setAttribute('min', this.value);
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            const today = new Date().toISOString().split('T')[0];
            const startDate = document.getElementById('start_date');
            const endDate = document.getElementById('end_date');

            startDate.setAttribute('min', today);
            endDate.setAttribute('min', today);

            startDate.addEventListener('change', function() {
                endDate.setAttribute('min', this.value);

                if (endDate.value && this.value > endDate.value) {
                    endDate.value = this.value;
                }
            });

            endDate.addEventListener('change', function() {
                startDate.setAttribute('max', this.value);

                if (startDate.value && this.value < startDate.value) {
                    startDate.value = this.value;
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#createSchoolForm').on('submit', function(e) {
                e.preventDefault();

                let isValid = true;
                let $form = $(this);
                let $submitBtn = $form.find('button[type="submit"]');

                $form.find('.form-control, select').removeClass('is-invalid');

                $form.find('input, select').each(function() {
                    if (!$(this).val().trim()) {
                        $(this).addClass('is-invalid');

                        if ($(this).next('.invalid-feedback').length === 0) {
                            $(this).after(
                                '<div class="invalid-feedback">This field is required.</div>');
                        }

                        isValid = false;
                    }
                });

                if (!isValid) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Incomplete Form',
                        text: 'Please fill in all required fields before submitting.'
                    });
                    return;
                }

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You are about to submit the school data.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, submit it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {

                        $submitBtn.prop('disabled', true);
                        const originalBtnHtml = $submitBtn.html();
                        $submitBtn.html('Saving...<i class="fas fa-spinner fa-spin"></i>');

                        $.ajax({
                            url: '{{ route('schools.store') }}',
                            method: 'POST',
                            data: $form.serialize(),
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire(
                                    'Submitted!',
                                    'School has been created successfully.',
                                    'success'
                                );
                                $form[0].reset();
                            },
                            error: function(data) {
                                $('body').html(data.responseText);
                            },
                            complete: function() {
                                $submitBtn.prop('disabled', false).html(
                                    originalBtnHtml);
                            }
                        });
                    }
                });
            });
        });
    </script>
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
