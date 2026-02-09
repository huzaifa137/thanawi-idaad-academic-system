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
                        @include('layouts.subjects-buttons')
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <!-- Results -->
                <div class="card mt-4" id="resultsCard">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">All Students</h5>
                        @php
                            $activeYear = Helper::active_year();
                        @endphp
                        <h5 class="mb-0">
                            Active Year :
                            <span @if($activeYear == 'No Active year Set') style="color: red;" @endif>
                                {{ $activeYear }}
                            </span>
                        </h5>
                    </div>

                    <div class="card-body bg-white" id="searchResults">

                        @if ($groupedStudents->isEmpty())
                            <div class="alert alert-info">
                                No students found.
                            </div>
                        @else

                            @foreach ($groupedStudents as $schoolName => $students)

                                <div class="mb-5 border rounded p-4 shadow-sm">

                                    <!-- School Header -->
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h4 class="fw-bold text-primary mb-0">
                                            {{ $schoolName }}
                                        </h4>

                                        <div class="button-group">
                                            <a href="{{ route('students.export', ['schoolId' => $students->first()->school_id, 'type' => 'thanawi']) }}"
                                                class="btn text-white export-btn" style="background-color: #287C44;">
                                                <i class="fas fa-file-export me-2"></i> Export Thanawi Class
                                            </a>

                                            <a href="{{ route('students.export', ['schoolId' => $students->first()->school_id, 'type' => 'idaad']) }}"
                                                class="btn text-white export-btn" style="background-color: #287C44;">
                                                <i class="fas fa-file-export me-2"></i> Export Idaad Class
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Students Table -->
                                    <div class="table-responsive">
                                        <table class="table table-bordered align-middle">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Admission Number</th>
                                                    <th>Class</th>
                                                    <th>Stream</th>
                                                    <th>Gender</th>
                                                    <th>Phone</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($students as $key => $student)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $student->firstname }} {{ $student->lastname }}</td>
                                                        <td>{{ $student->admission_number }}</td>
                                                        <td>{{ $student->senior }}</td>
                                                        <td>{{ $student->stream }}</td>
                                                        <td>{{ $student->gender }}</td>
                                                        <td>{{ $student->primary_contact }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <script>
                                        document.querySelectorAll('.export-btn').forEach(button => {
                                            button.addEventListener('click', function (e) {

                                                let activeYear = "{{ Helper::active_year() }}";

                                                if (activeYear === "No Active year Set") {
                                                    e.preventDefault();

                                                    Swal.fire({
                                                        icon: 'warning',
                                                        title: 'No Active Academic Year',
                                                        text: 'Please set an active academic year before exporting.',
                                                        confirmButtonColor: '#287C44',
                                                        confirmButtonText: 'Set Active Year'
                                                    });
                                                }

                                            });
                                        });
                                    </script>

                                </div>

                            @endforeach

                        @endif

                    </div>

                </div>
            </div>
        </div>




    </div>
    </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

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