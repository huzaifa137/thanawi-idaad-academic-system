<?php
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

    <style>
        .form-builder-section {
            position: relative;
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            background-color: #f8f9fa;
        }

        .delete-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            color: #dc3545;
        }

        .delete-btn:hover {
            color: #a71d2a;
        }

        .option-wrapper {
            position: relative;
            margin-bottom: 10px;
        }

        .delete-option-btn {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #dc3545;
            font-size: 1.2rem;
            cursor: pointer;
        }

        .dropdown-options-list li {
            font-size: 0.95rem;
        }

        .dropdown-options-list .btn {
            font-size: 0.75rem;
            padding: 2px 6px;
        }

        .filter-box {
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        .filter-small {
            max-width: 340px;
        }
    </style>

    <div class="side-app">

        <div class="row">

            <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="col-md-12 p-4">

                        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"
                            rel="stylesheet">

                        <section id="Approved_suppliers">

                            <div id="addCodeForm">
                                <h3 class="heading text-primary">Add Topic</h3>

                                <form id="createSchoolForm" action="{{ route('create.new-topic') }}" method="POST">
                                    @csrf
                                    <meta name="csrf-token" content="{{ csrf_token() }}">

                                    <div class="formSep">
                                        <!-- Row 1: Senior -->
                                        <div class="row">
                                            <div class="col-sm-4 col-md-4">
                                                <label for="">Senior</label>
                                                <select class="form-control select2" id="senior_id" name="senior_id"
                                                    required>
                                                    <option value="">-- Select --</option>
                                                    @foreach ($SecondaryClasses as $class)
                                                        <option value="{{ $class->md_id }}">{{ $class->md_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-sm-4 col-md-4">
                                                <label for="">Subject</label>
                                                <select class="form-control select2" id="subject_id" name="subject_id"
                                                    required>
                                                    <option value="">-- Select --</option>
                                                    @foreach ($Subjects as $class)
                                                        <option value="{{ $class->md_id }}">{{ $class->md_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-sm-4 col-md-4">
                                                <label for="">Competency</label>
                                                <select class="form-control select2" id="Competency" name="Competency"
                                                    required>
                                                    <option value="1" selected>1</option>
                                                    <option value="1">2</option>
                                                    <option value="1">3</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Dynamic Topics Section -->
                                        <div id="topicsWrapper" class="mt-4">
                                            <div class="topic-group mb-4 border p-3 rounded">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label>Topic</label>
                                                        <input type="text" name="topic_name[]" class="form-control"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-md-12">
                                                        <label>Topic Description</label>
                                                        <textarea name="topic_description[]" class="form-control" rows="3"
                                                            required></textarea>
                                                    </div>
                                                </div>
                                                <button type="button"
                                                    class="btn btn-danger btn-sm mt-3 remove-topic d-none">
                                                    <i class="bi bi-trash"></i> Remove Topic
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Add Topic Button -->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="button" id="addTopicBtn"
                                                    class="btn btn-outline-primary btn-sm">
                                                    <i class="bi bi-plus-circle"></i> Add Topic
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Hidden Date Field -->
                                        <div class="row" style="display: none">
                                            <div class="col-sm-3 col-md-3 margTp">
                                                <label for="">md_date_added</label>
                                                <input class="form-control" type="text" name="md_date_added"
                                                    id="md_date_added">
                                            </div>
                                        </div>

                                        <!-- Row 4: Submit Button -->
                                        <div class="row mt-4">
                                            <div class="col-sm-3 col-md-3">
                                                <button class="btn btn-md btn-primary" type="submit" id="add_new_data">
                                                    <i class="fa fa-fw fa-save"></i> Save
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </section>
                    </div>
                </div>

                <h3 class="mt-4 mb-3 pb-0 text-primary">Topics</h3>

                <div class="form-group filter-box">
                    <label for="seniorFilter">Select Senior:</label>
                    <select id="seniorFilter" class="form-control" style="max-width: 600px;">
                        <option value="">-- Select Senior --</option>
                        @foreach($groupedTopics as $senior => $subjects)
                            <option value="{{ $senior }}" @if($loop->first) selected @endif>{{ $senior }}</option>
                        @endforeach
                    </select>
                </div>

                <div id="topicsTableContainer">
                    <!-- Your dynamic content -->
                </div>


            </div>
        </div>

    </div>

    </div>
    </div>
    </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const seniorFilter = document.getElementById('seniorFilter');
            const tableContainer = document.getElementById('topicsTableContainer');

            function fetchTopics() {
                const selectedSenior = seniorFilter.value;

                fetch("{{ route('fetch.topics.by.senior') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({ senior: selectedSenior }),
                })
                    .then(response => response.text())
                    .then(html => {
                        tableContainer.innerHTML = html;
                    })
                    .catch(error => {
                        console.error('Error fetching topics:', error);
                    });
            }

            seniorFilter.addEventListener('change', fetchTopics);

            if (seniorFilter.value) {
                fetchTopics();
            }
        });

    </script>

    <script>
        $(document).ready(function () {
            $('#addTopicBtn').on('click', function () {
                const topicIndex = $('#topicsWrapper .topic-group').length + 1;

                const topicHtml = `
                                                                                                                                                                    <div class="topic-group mb-4 border p-3 rounded">
                                                                                                                                                                        <div class="row">
                                                                                                                                                                            <div class="col-md-12">
                                                                                                                                                                                <label>Topic</label>
                                                                                                                                                                                <input type="text" name="topic_name[]" class="form-control" required>
                                                                                                                                                                            </div>
                                                                                                                                                                        </div>
                                                                                                                                                                        <div class="row mt-3">
                                                                                                                                                                            <div class="col-md-12">
                                                                                                                                                                                <label>Topic Description</label>
                                                                                                                                                                                <textarea name="topic_description[]" class="form-control" rows="3" required></textarea>
                                                                                                                                                                            </div>
                                                                                                                                                                        </div>
                                                                                                                                                                        <button type="button" class="btn btn-danger btn-sm mt-3 remove-topic">
                                                                                                                                                                            <i class="bi bi-trash"></i> Remove Topic
                                                                                                                                                                        </button>
                                                                                                                                                                    </div>
                                                                                                                                                                `;

                $('#topicsWrapper').append(topicHtml);
                $('.remove-topic').removeClass('d-none');
            });

            $('#topicsWrapper').on('click', '.remove-topic', function () {
                $(this).closest('.topic-group').remove();

                if ($('#topicsWrapper .topic-group').length === 1) {
                    $('.remove-topic').addClass('d-none');
                }
            });
        });

        $(document).ready(function () {
            $('#createSchoolForm').on('submit', function (e) {
                e.preventDefault();

                let isValid = true;
                let $form = $(this);
                let $submitBtn = $form.find('button[type="submit"]');

                $form.find('.form-control, select, textarea').removeClass('is-invalid');
                $form.find('.invalid-feedback').remove();

                $form.find('input[name="topic_name[]"], textarea[name="topic_description[]"], select[name="senior_id"] , select[name="subject_id"]').each(function () {
                    if (!$(this).val().trim()) {
                        $(this).addClass('is-invalid');

                        if ($(this).next('.invalid-feedback').length === 0) {
                            $(this).after('<div class="invalid-feedback">This field is required.</div>');
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
                    text: "You are about to submit the data.",
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
                            url: '{{ route('create.new-topic') }}',
                            method: 'POST',
                            data: $form.serialize(),
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            success: function (response) {
                                Swal.fire(
                                    'Submitted!',
                                    response.message || 'Topics have been saved successfully.',
                                    'success'
                                );
                                $form[0].reset();

                                $('#topicsWrapper .topic-group:gt(0)').remove();
                                $('#topicsWrapper .topic-group:first').find('input, textarea').val('');
                                $('.remove-topic').addClass('d-none');
                            },
                            // error: function (data) {
                            //     console.error(data);
                            //     Swal.fire('Error!', 'An error occurred while saving.', 'error');
                            // },
                            error: function (data) {
                                $('body').html(data.responseText);
                            },
                            complete: function () {
                                $submitBtn.prop('disabled', false).html(originalBtnHtml);
                            }
                        });
                    }
                });
            });
        });

        $(document).on('click', '.edit-topic-btn', function () {
            const topicId = $(this).data('id');

            Swal.fire({
                title: 'Edit Topic?',
                text: 'Do you want to edit this topic?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, edit',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Fetch topic details via AJAX
                    $.get(`/topics/${topicId}`, function (data) {
                        $('#edit_topic_id').val(data.id);
                        // $('#edit_competency').val(data.Competency);
                        $('#edit_topic_name').val(data.topic_name);
                        $('#edit_topic_description').val(data.topic_description);

                        $('#editTopicModal').modal('show');
                    });
                }
            });
        });

        // Submit Edit Topic
        $(document).on('submit', '#editTopicForm', function (e) {
            e.preventDefault();
            console.log('Edit form submitted!');

            const topicId = $('#edit_topic_id').val();
            const formData = $(this).serialize() + '&_method=PUT';

            $.ajax({
                url: `/update-topics/${topicId}`,
                type: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    $('#editTopicModal').modal('hide');

                    Swal.fire({
                        title: 'Updated!',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        location.reload();
                    });
                },
                // error: function (data) {
                //     $('body').html(data.responseText);
                // }
                error: function (xhr) {
                $('body').html(xhr.responseText); // Debug
            }
            });
        });




        // Delete Topic
        $(document).on('click', '.delete-topic-btn', function () {
            const topicId = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: 'This will permanently delete the topic.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/topics/${topicId}`,
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            Swal.fire({
                                title: 'Deleted!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function (data) {
                            $('body').html(data.responseText);
                        }
                    });
                }
            });
        });

    </script>

@endsection
@section('js')

    <!-- c3.js Charts js-->
    <script src=" {{ URL::asset('assets/plugins/charts-c3/d3.v5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/charts-c3/c3-chart.js') }}"></script>
    <script src="{{ URL::asset('assets/js/charts.js') }}"></script>

    <!-- ECharts js -->
    <script src="{{ URL::asset('assets/plugins/echarts/echarts.js') }}"></script>
    <!-- Peitychart js-->
    <script src=" {{ URL::asset('assets/plugins/peitychart/jquery.peity.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/peitychart/peitychart.init.js') }}"></script>
    <!-- Apexchart js-->
    <script src="{{ URL::asset('assets/js/apexcharts.js') }}"></script>
    <!--Moment js-->
    <script src="{{ URL::asset('assets/plugins/moment/moment.js') }}"></script>
    <!-- Daterangepicker js-->
    <script src="{{ URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ URL::asset('assets/js/daterange.js') }}"></script>
    <!---jvectormap js-->
    <script src=" {{ URL::asset('assets/plugins/jvectormap/jquery.vmap.js') }}"></script>
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