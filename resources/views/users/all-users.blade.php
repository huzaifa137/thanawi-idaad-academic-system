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
                        @include('layouts.users-config-header')
                    </div>

                    <div class="card-body bg-light">
                        <form id="createSchoolTeacher">
                            <div class="row">
                                {{-- <input type="hidden" name="school_id" id="school_id" value="0"> --}}
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label class="form-label" for="username">username</label>
                                        <input type="text" id="username" name="username" class="form-control"
                                            placeholder="Enter username">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="firstname">Firstname</label>
                                        <input type="text" id="firstname" name="firstname" class="form-control"
                                            placeholder="Enter firstname">
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label" for="phonenumber">Phone Number</label>
                                        <input type="tel" id="phonenumber" name="phonenumber" class="form-control"
                                            placeholder="Enter phone number">
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label class="form-label" for="gender">Gender</label>
                                        <select id="gender" name="gender" class="form-control">
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="Email">Email</label>
                                        <input type="text" id="email" name="email" class="form-control"
                                            placeholder="Enter user email">
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
        $(document).ready(function () {
            $('#createSchoolTeacher').on('submit', function (e) {
                e.preventDefault();

                let isValid = true;
                let $form = $(this);
                let $submitBtn = $form.find('button[type="submit"]');

                $form.find('.form-control, select').removeClass('is-invalid');

                const requiredFields = ['username', 'firstname', 'phonenumber', 'email'];

                requiredFields.forEach(function (field) {
                    let input = $form.find(`[name="${field}"]`);
                    if (!input.val().trim()) {
                        input.addClass('is-invalid');

                        if (input.next('.invalid-feedback').length === 0) {
                            input.after(
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
                    text: "You are about to submit the teacher data.",
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
                            url: '{{ route('users.store.new.user') }}',
                            method: 'POST',
                            data: $form.serialize(),
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            success: function (response) {
                                Swal.fire(
                                    'Submitted!',
                                    response.message,
                                    'success'
                                );
                                $form[0].reset();
                            },
                            // error: function (xhr) {
                            //     if (xhr.status === 422) {
                            //         let errors = xhr.responseJSON.errors;
                            //         for (let field in errors) {
                            //             let input = $form.find(`[name="${field}"]`);
                            //             input.addClass('is-invalid');
                            //             if (input.next('.invalid-feedback').length === 0) {
                            //                 input.after(`<div class="invalid-feedback">${errors[field][0]}</div>`);
                            //             }
                            //         }
                            //         Swal.fire({
                            //             icon: 'error',
                            //             title: 'Validation Error',
                            //             text: 'Please fix the errors and try again.'
                            //         });
                            //     } else {
                            //         // Show the actual error in the response
                            //         let errorMessage = xhr.responseJSON?.message || xhr.statusText || 'An unexpected error occurred';

                            //         Swal.fire({
                            //             icon: 'error',
                            //             title: 'Server Error',
                            //             html: `<pre>${errorMessage}</pre>`, // show full error message
                            //         });
                            //     }
                            // },
                            error: function(data) {
                                $('body').html(data.responseText);
                            },
                            complete: function () {
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