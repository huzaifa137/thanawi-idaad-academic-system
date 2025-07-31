<?php
// Removed: use App\Http\Controllers\Controller; $controller = new Controller(); (unnecessary instantiation)
use App\Http\Controllers\Helper; // Keep if Helper::recordMdname is still used or for other helpers
?>
@extends('layouts-side-bar.master')

@section('css')
    {{-- Only include essential CSS for the table and layout --}}
    {{-- DataTables CSS (using Bootstrap 5 version for consistency) --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    {{-- DataTables Buttons CSS --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css" />
    {{-- Add any other CSS specific to master layout/styling if not already in master.blade.php --}}
@endsection

@section('content')
    <!-- Student Dashboard -->
    <div class="side-app">

        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">All Schools</h5>
                <a href="{{ route('school.create-school') }}" class="btn btn-sm btn-info">
                    <span
                        class="rounded-circle bg-white text-info d-inline-flex align-items-center justify-content-center me-1"
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
                                <th>Status</th>
                                <th style="width: 90px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            @php
                                $statusConfig = [
                                    10 => ['label' => 'Active', 'class' => 'text-success', 'icon' => 'fas fa-check-circle'],
                                    0 => ['label' => 'Banned', 'class' => 'text-danger', 'icon' => 'fas fa-ban'],
                                    8 => ['label' => 'Locked', 'class' => 'text-warning', 'icon' => 'fas fa-lock'],
                                    9 => ['label' => 'Suspended', 'class' => 'text-secondary', 'icon' => 'fas fa-user-slash'],
                                    1 => ['label' => 'Pending Activation', 'class' => 'text-secondary', 'icon' => 'fas fa-clock'],
                                ];
                            @endphp

                            @forelse ($schools as $key => $school)
                                <tr>

                                    <td class="fw-bold" style="width: 1px;">{{ $key + 1 }}</td>
                                    <td class="fw-bold">{{ $school->name }}</td>
                                    <td class="fw-bold">{{ $school->registration_code }}</td>
                                    <td class="fw-bold">{{ Helper::recordMdname($school->school_type) }}</td>
                                    <td class="fw-bold">{{ Helper::recordMdname($school->population) }}</td>
                                    <td>
                                        @php
                                            $status = $statusConfig[$school->school_status] ?? ['label' => 'Unknown', 'class' => 'text-muted', 'icon' => 'fas fa-question-circle'];
                                        @endphp
                                        <span class="{{ $status['class'] }}">
                                            <i class="{{ $status['icon'] }}"></i> {{ $status['label'] }}
                                        </span>
                                    </td>

                                    <td class="d-flex align-items-center gap-1">
                                        <style>
                                            .btn-inline-pink {
                                                color: rgb(250, 12, 115);
                                                border: 1px solid rgb(250, 12, 115);
                                                background-color: transparent;
                                            }

                                            .btn-inline-pink:hover {
                                                background-color: rgb(250, 12, 115);
                                                color: white;
                                            }

                                            .btn-inline-orange {
                                                color: #FF9800;
                                                border: 1px solid #FF9800;
                                                ;
                                                background-color: transparent;
                                            }

                                            .btn-inline-orange:hover {
                                                background-color: #FF9800;
                                                ;
                                                color: white;
                                            }
                                        </style>

                                        <a href="{{ route('profile.individual.school', $school->id) }}"
                                            class="btn btn-sm btn-outline-info" title="View School Profile">
                                            <i class="fas fa-university"></i>
                                        </a>
                                        &nbsp;

                                        <a href="{{ route('school.term-dates', $school->id) }}"
                                            class="btn btn-sm btn-inline-pink" title="Select Date">
                                            <i class="fas fa-calendar-alt"></i>
                                        </a>
                                        &nbsp;

                                        <a href="{{ route('individual.school.teachers', $school->id) }}"
                                            class="btn btn-sm btn-inline-orange" title="Teachers">
                                            <i class="fas fa-chalkboard-teacher"></i>
                                        </a>
                                        &nbsp;
                                        <a href="{{ route('school.options', $school->id) }}"
                                            class="btn btn-sm btn-outline-success" title="View School Profile">
                                            <i class="fas fa-cogs"></i>
                                        </a>
                                        &nbsp;

                                        <a href="javascript:void(0);"
                                            class="btn btn-sm btn-outline-info btn-change-school-status"
                                            data-id="{{ $school->id }}" data-status="{{ $school->school_status }}"
                                            title="Change Status">
                                            <i class="fas fa-sync-alt"></i>
                                        </a>
                                        &nbsp;

                                        <a href="javascript:void(0);" class="btn btn-sm btn-outline-primary btn-edit"
                                            data-id="{{ $school->id }}" data-edit-url="{{ route('edit.school', $school->id) }}"
                                            title="Edit">
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
                                    <td colspan="6" class="text-center text-muted py-4">No schools found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Change School Status Modal -->
                    <div class="modal fade" id="changeSchoolStatusModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <form id="changeSchoolStatusForm">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Change School Status</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" id="schoolStatusId">
                                        <div class="form-group">
                                            <label for="newSchoolStatus">Select New Status</label>
                                            <select id="newSchoolStatus" class="form-control">
                                                <option value="1">Pending Activation</option>
                                                <option value="10">Active</option>
                                                <option value="0">Banned</option>
                                                <option value="8">Locked</option>
                                                <option value="9">Suspended</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">Change Status</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
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

    {{-- Removed extra closing divs, assuming they are part of master layout --}}
    {{-- SweetAlert2 and Bootstrap JS moved to the bottom of the @section('content') or master layout's body end --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

@endsection

@section('js')
    {{-- jQuery is typically loaded in the master layout before other scripts that depend on it --}}
    {{-- Ensure jQuery is loaded *before* DataTables, either here or in your master.blade.php --}}

    {{-- DataTables JS (using CDN for consistency) --}}
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    {{-- DataTables Buttons JS --}}
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>

    {{-- Export libraries (only if you intend to use export buttons like Excel, PDF) --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    {{-- Buttons HTML5 export, print and column visibility (only if used) --}}
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>

    <script>
        $(document).ready(function () {
            var table = $('#schoolsTable').DataTable({
                responsive: false, // Ensure this is compatible with your CSS/layout
                pageLength: 10,
                order: [
                    [0, 'asc']
                ],
                dom: 'frtip', // Defines table controls (Filter, Row length, Table, Info, Paging)
                columnDefs: [{
                    orderable: false,
                    targets: [1, 4, 5] // Adjust these target indices if columns change
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

            // Delete functionality
            $('#schoolsTable tbody').on('click', '.btn-delete', function () {
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
                            success: function (response) {
                                row.remove()
                                    .draw(); // Remove row from DataTable and redraw

                                Swal.fire(
                                    'Deleted!',
                                    'School has been deleted.',
                                    'success'
                                );
                            },
                            error: function (xhr) {
                                Swal.fire(
                                    'Error!',
                                    'Something went wrong deleting the school.',
                                    'error'
                                );
                            }
                            // error: function(data) {
                            // $('body').html(data.responseText);
                            // }
                        });
                    }
                });
            });

            // Edit functionality
            $('#schoolsTable tbody').on('click', '.btn-edit', function () {
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

        $(document).ready(function () {
            // Open modal with current school status
            $('.btn-change-school-status').on('click', function () {
                const schoolId = $(this).data('id');
                const currentStatus = $(this).data('status');

                $('#schoolStatusId').val(schoolId);

                const $select = $('#newSchoolStatus');
                $select.val(currentStatus); // Set value (in case browser already supports it)

                // Reorder options dynamically
                const currentOption = $select.find('option[value="' + currentStatus + '"]');
                if (currentOption.length) {
                    $select.prepend(currentOption); // Move to top
                }

                $('#changeSchoolStatusModal').modal('show');
            });


            // Submit status change with confirmation
            $('#changeSchoolStatusForm').on('submit', function (e) {
                e.preventDefault();
                const schoolId = $('#schoolStatusId').val();
                const newStatus = $('#newSchoolStatus').val();

                $('#changeSchoolStatusModal').modal('hide');

                setTimeout(() => {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This will update the school's status.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#28a745',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, change it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: `/schools/${schoolId}/change-status`,
                                type: 'POST',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    status: newStatus
                                },
                                success: function (response) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Updated!',
                                        text: response.message || 'School status updated.',
                                        timer: 2000,
                                        showConfirmButton: false
                                    });

                                    // Reload to update UI
                                    location.reload();
                                },
                                // error: function (xhr) {
                                //     Swal.fire('Error', 'Failed to change status.', 'error');
                                // }
                                error: function (data) {
                                    $('body').html(data.responseText);
                                }
                            });
                        }
                    });
                }, 300);
            });
        });
    </script>
@endsection