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

        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">All Schools</h5>
                <a href="{{ route('school.create-school') }}" class="btn btn-sm btn-secondary">
                    <span
                        class="rounded-circle bg-white text-secondary d-inline-flex align-items-center justify-content-center me-1"
                        style="width: 20px; height: 20px;">
                        <i class="fas fa-plus" style="font-size: 12px;"></i>
                    </span>
                    Add School
                </a>
            </div>

            <div class="card-body p-3">
                <div class="table-responsive">
                    <table id="schoolsTable" class="table table-striped table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 1px;">No</th>
                                <th>School Name</th>
                                <th>School Code</th>
                                <th>School Type</th>
                                <th>School Population</th>
                                <th style="width: 90px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($schools as $key => $school)
                                <tr>
                                    <td class="fw-bold" style="width: 1px;"s>{{ $key + 1 }}</td>
                                    <td class="fw-bold">{{ $school->name }}</td>
                                    <td class="fw-bold">{{ $school->registration_code }}</td>
                                    <td class="fw-bold">{{ Helper::recordMdname($school->school_type) }}</td>
                                    <td class="fw-bold">{{ Helper::recordMdname($school->population) }}</td>

                                    <td class="d-flex align-items-center gap-1">
                                        <a href="{{ route('profile.school', $school->id) }}"
                                            class="btn btn-sm btn-outline-info" title="View School Profile">
                                            <i class="fas fa-user-graduate"></i>
                                        </a>
                                        &nbsp;
                                        <a href="javascript:void(0);" class="btn btn-sm btn-outline-primary btn-edit"
                                            data-id="{{ $school->id }}"
                                            data-edit-url="{{ route('edit.school', $school->id) }}" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        &nbsp;
                                        <a href="javascript:void(0);" class="btn btn-sm btn-outline-danger btn-delete"
                                            data-id="{{ $school->id }}" title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">No products found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <style>
        .table-hover tbody tr:hover {
            background-color: #f8f9fa !important;
        }

        .dataTables_filter input {
            border-radius: 6px;
            padding: 6px 10px;
            border: 1px solid #ccc;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0.35rem 0.65rem;
            margin: 0 2px;
            border-radius: 4px;
            font-size: 0.875rem;
        }

        .dataTables_wrapper .dataTables_length select {
            border-radius: 5px;
            padding: 4px 8px;
        }

        .dt-buttons .btn {
            margin-right: 6px;
            margin-bottom: 10px;
        }
    </style>

    </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            var table = $('#schoolsTable').DataTable({
                responsive: false,
                pageLength: 10,
                order: [
                    [0, 'desc']
                ],
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'copy',
                        className: 'btn btn-sm btn-outline-secondary'
                    },
                    {
                        extend: 'csv',
                        className: 'btn btn-sm btn-outline-secondary'
                    },
                    {
                        extend: 'excel',
                        className: 'btn btn-sm btn-outline-secondary'
                    },
                    {
                        extend: 'pdf',
                        className: 'btn btn-sm btn-outline-secondary'
                    },
                    {
                        extend: 'print',
                        className: 'btn btn-sm btn-outline-secondary'
                    }
                ],
                columnDefs: [{
                        orderable: false,
                        targets: [1, 4, 5]
                    },
                    {
                        className: 'text-center',
                        targets: '_all'
                    }
                ],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search schools..."
                }
            });

            $('#schoolsTable tbody').on('click', '.btn-delete', function() {

                var schoolId = $(this).data('id');
                var row = table.row($(this).parents('tr'));

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/school/' + schoolId,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                row.remove().draw();

                                Swal.fire(
                                    'Deleted!',
                                    'School has been deleted.',
                                    'success'
                                );
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Error!',
                                    'Something went wrong deleting the product.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });

            $('#schoolsTable tbody').on('click', '.btn-edit', function() {
                var editUrl = $(this).data('edit-url');

                Swal.fire({
                    title: 'Edit School?',
                    text: "You are about to edit this school.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#0d6efd',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, proceed!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = editUrl;
                    }
                });
            });

        });
    </script>


    <!-- DataTables + Buttons JS -->

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <!-- Buttons CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css" />

    <!-- Buttons JS -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>

    <!-- Export libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    <!-- Buttons HTML5 export, print and column visibility -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>

    <!-- ECharts js -->
    <script src="{{ URL::asset('assets2/plugins/echarts/echarts.js') }}"></script>
    <!-- Peitychart js-->
    <script src="{{ URL::asset('assets2/plugins/peitychart/jquery.peity.min.js') }}"></script>
    <script src="{{ URL::asset('assets2/plugins/peitychart/peitychart.init.js') }}"></script>
    <!-- Apexchart js-->
    <script src="{{ URL::asset('assets2/js/apexcharts.js') }}"></script>
    <!--Moment js-->
    <script src="{{ URL::asset('assets2/plugins/moment/moment.js') }}"></script>
    <!-- Daterangepicker js-->
    <script src="{{ URL::asset('assets2/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ URL::asset('assets2/js/daterange.js') }}"></script>
    <!---jvectormap js-->
    <script src="{{ URL::asset('assets2/plugins/jvectormap/jquery.vmap.js') }}"></script>
    <script src="{{ URL::asset('assets2/plugins/jvectormap/jquery.vmap.world.js') }}"></script>
    <script src="{{ URL::asset('assets2/plugins/jvectormap/jquery.vmap.sampledata.js') }}"></script>
    <!-- P-scroll js-->
    <script src="{{ URL::asset('assets2/plugins/p-scrollbar/p-scrollbar.js') }}"></script>
    <!-- Index js-->
    <script src="{{ URL::asset('assets2/js/index1.js') }}"></script>
    <!-- Data tables js-->
    <script src="{{ URL::asset('assets2/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets2/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets2/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets2/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets2/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets2/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets2/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets2/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets2/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets2/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets2/plugins/datatable/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets2/plugins/datatable/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets2/js/datatables.js') }}"></script>
    <!--Counters -->
    <script src="{{ URL::asset('assets2/plugins/counters/counterup.min.js') }}"></script>
    <script src="{{ URL::asset('assets2/plugins/counters/waypoints.min.js') }}"></script>
    <!--Chart js -->
    <script src="{{ URL::asset('assets2/plugins/chart/chart.bundle.js') }}"></script>
    <script src="{{ URL::asset('assets2/plugins/chart/utils.js') }}"></script>
@endsection
