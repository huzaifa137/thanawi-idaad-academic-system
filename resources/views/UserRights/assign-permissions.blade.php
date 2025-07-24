<?php
use App\Http\Controllers\Helper; 
?>
@extends('layouts-side-bar.master')
@section('content')
    <div class="side-app">

        <div class="row">
            <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                <div class="card bg-primary">
                    <div class="card-header">
                        @include('layouts.user-rights-headers')
                    </div>
                    <br>
                    <div class="bg-info d-flex justify-content-between align-items-center px-3 py-2">
                       <h3 class="text-white mb-0">All User Permission Features</h3>
                        <div class="text-white">
                            <button class="btn btn-light"><i class="fa fa-user-shield mr-2"></i>Set User Previledges</button>
                        </div>
                    </div>

                    <br>
                   
                    <div class="card shadow-sm mb-4">
                    <div class="card-header bg-dark text-white">
                        <h4 class="mb-0">Manage Permissions</h4>
                    </div>

                    <form id="permission-form">
                        @csrf
                        <div class="card-body">
                            @if ($permissions->isNotEmpty())
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col" class="text-center">
                                                    <input type="checkbox" id="select-all-rows">
                                                </th>
                                                <th scope="col">Permission Name</th>
                                                <th scope="col" class="text-center">Scope</th>
                                                <th scope="col" class="text-center">
                                                    <input type="checkbox" id="select-all-add"> Add
                                                </th>
                                                <th scope="col" class="text-center">
                                                    <input type="checkbox" id="select-all-view"> View
                                                </th>
                                                <th scope="col" class="text-center">
                                                    <input type="checkbox" id="select-all-edit"> Edit
                                                </th>
                                                <th scope="col" class="text-center">
                                                    <input type="checkbox" id="select-all-delete"> Delete
                                                </th>
                                                <th scope="col" class="text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($permissions as $permission)
                                                @php
                                                    $features = explode(',', $permission->features);
                                                @endphp

                                                <tr class="permission-row" data-name="{{ $permission->name }}" data-scope="{{ $permission->scope }}">
                                                    <td class="text-center">
                                                        <input type="checkbox" class="select-row">
                                                    </td>
                                                    <td>{{ ucfirst(Helper::item_md_name($permission->name)) }}</td>
                                                    <td class="text-center">{{ ucfirst($permission->scope) }}</td>

                                                    @foreach (['add', 'view', 'edit', 'delete'] as $action)
                                                        @php
                                                            // $featureKey = "{$action}_{$permission->name}";
                                                            $featureKey = "{$action}_" . Helper::item_md_name($permission->name);
                                                        @endphp

                                                        <td class="text-center">
                                                            <input type="checkbox"
                                                                class="form-check-input"
                                                                name="permissions[]"
                                                                value="{{ $featureKey }}"
                                                                data-scope="{{ $permission->scope }}"
                                                                {{ in_array($featureKey, $markedFeatures) ? 'checked' : '' }}>
                                                        </td>
                                                    @endforeach

                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-sm btn-primary btn-save-permission">
                                                            <i class="fas fa-save"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>

                                    </table>
                                </div>
                            @else
                                <div class="alert alert-warning text-center" role="alert">
                                    <i class="fas fa-exclamation-triangle me-2"></i> No permissions found to display.
                                </div>
                            @endif

                        <div class="text-end">
                            <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-1"></i> Save All Permissions
                        </button>

                        </div>
                        </div>
                    </form>

                     <div class="card-header bg-dark text-white">
                        <h4 class="mb-0"><i class="fas fa-shield-halved me-2"></i> Set Permissions by Role</h4>
                    </div>

              <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
                <div class="container mt-5">
                    <div class="card shadow-sm border-0">       
                            <ul class="list-group list-group-flush">

                                <li class="list-group-item d-flex flex-column flex-md-row justify-content-between align-items-md-center py-4 px-4 bg-light">
                                    <div class="col-md-3 col-sm-12 mb-3 mb-md-0">
                                        <h4 class="fw-bold text-primary mb-0"><i class="fas fa-crown me-2"></i>Admin</h4>
                                    </div>
                                    <div class="col-md-6 col-sm-12 mb-3 mb-md-0 d-flex flex-wrap align-items-center">
                                        <h6 class="text-muted me-3 mb-2 pb-2"> User Access Control : </h6>
                                        <div class="d-flex flex-wrap">
                                        <span class="badge bg-primary text-white rounded-pill d-inline-flex align-items-center px-3 py-2 me-2 mb-2 shadow-sm" style="font-size: 0.95rem; line-height: 1.2;">
                                        <span class="me-2">Student Access</span>
                                            <button type="button" class="border-0 bg-transparent text-white p-0 m-0 d-flex align-items-center justify-content-center">
                                            &nbsp;<i class="fa fa-trash" style="font-size: 0.85rem; color: rgb(178, 84, 84);" aria-hidden="true"></i>&nbsp;
                                            </button>
                                        </span>

                                        <span class="badge bg-primary text-white rounded-pill d-inline-flex align-items-center px-3 py-2 me-2 mb-2 shadow-sm" style="font-size: 0.95rem; line-height: 1.2;">
                                        <span class="me-2">Student Access</span>
                                            <button type="button" class="border-0 bg-transparent text-white p-0 m-0 d-flex align-items-center justify-content-center">
                                            &nbsp;<i class="fa fa-trash" style="font-size: 0.85rem; color: rgb(178, 84, 84);" aria-hidden="true"></i>&nbsp;
                                            </button>
                                        </span>

                                        <span class="badge bg-primary text-white rounded-pill d-inline-flex align-items-center px-3 py-2 me-2 mb-2 shadow-sm" style="font-size: 0.95rem; line-height: 1.2;">
                                        <span class="me-2">Student Access</span>
                                            <button type="button" class="border-0 bg-transparent text-white p-0 m-0 d-flex align-items-center justify-content-center">
                                            &nbsp;<i class="fa fa-trash" style="font-size: 0.85rem; color: rgb(178, 84, 84);" aria-hidden="true"></i>&nbsp;
                                            </button>
                                        </span>

                                        <span class="badge bg-primary text-white rounded-pill d-inline-flex align-items-center px-3 py-2 me-2 mb-2 shadow-sm" style="font-size: 0.95rem; line-height: 1.2;">
                                        <span class="me-2">Student Access</span>
                                            <button type="button" class="border-0 bg-transparent text-white p-0 m-0 d-flex align-items-center justify-content-center">
                                            &nbsp;<i class="fa fa-trash" style="font-size: 0.85rem; color: rgb(178, 84, 84);" aria-hidden="true"></i>&nbsp;
                                            </button>
                                        </span>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12 text-md-end">
                                        <div class="dropdown">
                                            <button class="btn btn-outline-primary dropdown-toggle" type="button" id="dropdownAdminList" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-plus-circle me-1"></i>Add Permission
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="dropdownAdminList">
                                                <li><h6 class="dropdown-header">Available Permissions</h6></li>
                                                <li><a class="dropdown-item" href="#"><i class="fas fa-users me-2"></i>User Management</a></li>
                                                <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>System Settings</a></li>
                                                <li><a class="dropdown-item" href="#"><i class="fas fa-chart-line me-2"></i>Analytics Dashboard</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                    </div>
                </div>
                

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
        document.addEventListener('DOMContentLoaded', function () {
        ['add', 'view', 'edit', 'delete'].forEach(action => {
            const columnCheckbox = document.getElementById(`select-all-${action}`);
            if (!columnCheckbox) return;
            
            columnCheckbox.addEventListener('change', function () {
                document.querySelectorAll(`input[type="checkbox"][value^="${action}_"]`)
                    .forEach(cb => cb.checked = columnCheckbox.checked);
            });
        });

        document.querySelectorAll('.select-row').forEach(rowCheckbox => {
            rowCheckbox.addEventListener('change', function () {
                const row = rowCheckbox.closest('tr');
                row.querySelectorAll('input[type="checkbox"][name="permissions[]"]')
                    .forEach(cb => cb.checked = rowCheckbox.checked);
            });
        });

            const selectAllRows = document.getElementById('select-all-rows');
            if (selectAllRows) {
                selectAllRows.addEventListener('change', function () {
                    document.querySelectorAll('.select-row').forEach(rowCheckbox => {
                        rowCheckbox.checked = selectAllRows.checked;
                        const row = rowCheckbox.closest('tr');
                        row.querySelectorAll('input[type="checkbox"][name="permissions[]"]')
                            .forEach(cb => cb.checked = selectAllRows.checked);
                    });
                });
            }
        });

        $(document).ready(function () {
            $('#permission-form').on('submit', function (e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Do you want to save these permissions?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, save it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const permissions = [];

                        $('#permission-form input[name="permissions[]"]:checked').each(function () {
                            permissions.push({
                                feature: $(this).val(),
                                scope: $(this).data('scope')
                            });
                        });

                        $.ajax({
                            url: '{{ route("store.multiple.permissions") }}',
                            type: 'POST',
                            contentType: 'application/json',
                            data: JSON.stringify({
                                permissions: permissions,
                                _token: $('meta[name="csrf-token"]').attr('content')
                            }),
                            success: function (response) {
                                Swal.fire('Saved!', response.message, 'success').then(() => {
                                    location.reload();
                                });
                            },
                            error: function (xhr) {
                                $('body').html(xhr.responseText);
                            }
                            // error: function (xhr) {
                            //     Swal.fire({
                            //         icon: 'error',
                            //         title: 'Oops...',
                            //         text: 'Please select permissions!',
                            //     });
                            // }
                        });
                    }
                });
            });
        });


    </script>
@endsection

@section('js')

    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>

    <script>

    </script>
@endsection