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
                        @include('layouts.grading-buttons')
                    </div>
                </div>
            </div>
        </div>

        <style>
            .school-card {
                background: #fff;
                border-radius: 12px;
                box-shadow: 0 2px 16px rgba(0, 0, 0, 0.08);
                border: 1px solid #eef2f7;
                overflow: hidden;
                transition: all 0.3s ease;
            }

            .school-card:hover {
                box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
                transform: translateY(-2px);
            }

            .school-header {
                background: linear-gradient(135deg, #f8fafc 0%, #eef2f7 100%);
                border-bottom: 1px solid #e2e8f0;
            }

            .school-icon {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 48px;
                height: 48px;
                background: linear-gradient(135deg, #287C44 0%, #34A853 100%);
                border-radius: 10px;
                color: white;
                font-size: 1.25rem;
            }

            .school-name {
                color: #1e293b;
                font-weight: 700;
                font-size: 1.5rem;
            }

            .exam-card {
                background: #fff;
                border: 1px solid #e2e8f0;
                border-radius: 12px;
                padding: 1.5rem;
                height: 100%;
                transition: all 0.3s ease;
            }

            .exam-card:hover {
                border-color: #287C44;
                box-shadow: 0 4px 12px rgba(40, 124, 68, 0.1);
            }

            .exam-card-header {
                display: flex;
                align-items: center;
                margin-bottom: 1.5rem;
            }

            .exam-icon {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 56px;
                height: 56px;
                border-radius: 12px;
                margin-right: 1rem;
            }

            .exam-card--thanawi .exam-icon {
                background: linear-gradient(135deg, #0F4C22 0%, #0F4C22 100%);
                color: white;
            }

            .exam-card--idaad .exam-icon {
                background: linear-gradient(135deg, #0F4C22 0%, #0F4C22 100%);
                color: white;
            }

            .exam-title {
                color: #1e293b;
                font-weight: 600;
                margin-bottom: 0.25rem;
            }

            .exam-description {
                color: #64748b;
                font-size: 0.875rem;
                margin-bottom: 0;
            }

            .exam-stats {
                display: flex;
                gap: 2rem;
            }

            .stat-item {
                display: flex;
                flex-direction: column;
            }

            .stat-label {
                color: #64748b;
                font-size: 0.875rem;
                margin-bottom: 0.25rem;
            }

            .stat-value {
                font-weight: 600;
                color: #1e293b;
            }

            .btn-icon {
                width: 40px;
                height: 40px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border-radius: 8px;
            }

            .empty-state {
                text-align: center;
                padding: 4rem 2rem;
            }

            .empty-state-icon {
                font-size: 4rem;
                color: #cbd5e1;
                margin-bottom: 1.5rem;
            }

            .empty-state h3 {
                color: #475569;
                margin-bottom: 0.5rem;
            }

            .empty-state p {
                color: #94a3b8;
            }

            .modal-header {
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            }

            .modal-footer {
                border-top: 1px solid #dee2e6;
            }

            .border-dashed {
                border-style: dashed !important;
            }

            .bg-light-info {
                background-color: rgba(13, 202, 240, 0.1) !important;
            }

            .bg-light-warning {
                background-color: rgba(255, 193, 7, 0.1) !important;
            }

            .btn-close-white {
                filter: invert(1) grayscale(100%) brightness(200%);
            }

            .modal-content {
                border-radius: 12px;
                overflow: hidden;
            }

            .swal2-container {
                z-index: 99999 !important;
            }
        </style>

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
                            <span @if ($activeYear == 'No Active year Set') style="color: red;" @endif>
                                {{ $activeYear }}
                            </span>
                        </h5>
                    </div>

                    <div class="card-body bg-white" id="searchResults">
                        @if ($groupedStudents->isEmpty())
                            <div class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="fas fa-user-graduate"></i>
                                </div>
                                <h3>No Students Found</h3>
                                <p>No students match your current search criteria</p>
                            </div>
                        @else
                            @foreach ($groupedStudents as $schoolName => $students)
                                <div class="school-card mb-5">
                                    <!-- Header Section -->
                                    <div class="school-header d-flex justify-content-between align-items-center p-4">
                                        <div class="school-info">
                                            <div class="d-flex align-items-center">
                                                <span class="school-icon">
                                                    <i class="fas fa-school"></i>
                                                </span>
                                                <div class="ms-3">
                                                    <h2 class="school-name mb-1"><span
                                                            style="padding-left: 10px;">{{ $schoolName }}</span></h2>
                                                    <div class="school-meta">
                                                        <span class="badge bg-primary-soft text-primary me-2">
                                                            <i class="fas fa-users me-1"></i>
                                                            {{ Helper::schoolStudentsCount($students->first()->school_id) }}
                                                            Students
                                                        </span>
                                                        <span class="text-muted">
                                                            <i class="fas fa-calendar-alt me-1"></i>
                                                            {{ Helper::active_year() }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Quick Actions -->
                                        <div class="school-actions">
                                            <div class="dropdown">
                                                <button class="btn btn-light btn-icon" data-bs-toggle="dropdown">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <h6 class="dropdown-header">Import Actions</h6>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#importThanawiModal"
                                                        data-school-id="{{ $students->first()->school_id }}"
                                                        data-school-name="{{ $schoolName }}">
                                                        <i class="fas fa-file-import text-primary me-2"></i>
                                                        Import Thanawi Exams
                                                    </a>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#importIdaadModal"
                                                        data-school-id="{{ $students->first()->school_id }}"
                                                        data-school-name="{{ $schoolName }}">
                                                        <i class="fas fa-file-import text-primary me-2"></i>
                                                        Import Idaad Exams
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <h6 class="dropdown-header">Export Actions</h6>
                                                    <a class="dropdown-item export-btn"
                                                        href="{{ route('students.export', ['schoolId' => $students->first()->school_id, 'type' => 'thanawi']) }}">
                                                        <i class="fas fa-file-export text-success me-2"></i>
                                                        Export Thanawi
                                                    </a>
                                                    <a class="dropdown-item export-btn"
                                                        href="{{ route('students.export', ['schoolId' => $students->first()->school_id, 'type' => 'idaad']) }}">
                                                        <i class="fas fa-file-export text-success me-2"></i>
                                                        Export Idaad
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Exam Management Section -->
                                    <div class="school-content p-4">
                                        <div class="row g-4">
                                            <!-- Thanawi Section -->
                                            <div class="col-lg-6">
                                                <div class="exam-card exam-card--thanawi">
                                                    <div class="exam-card-header">
                                                        <div class="exam-icon">
                                                            <i class="fas fa-graduation-cap"></i>
                                                        </div>
                                                        <div class="exam-info">
                                                            <h4 class="exam-title">Thanawi Exams</h4>
                                                            <p class="exam-description">Secondary level examination data
                                                                management</p>
                                                        </div>
                                                    </div>
                                                    <div class="exam-card-body">
                                                        <div class="exam-stats">
                                                            <div class="stat-item">
                                                                <span class="stat-label">Status</span>
                                                                <span class="stat-value text-success">Active</span>
                                                            </div>
                                                        </div>
                                                        <div class="exam-actions mt-4">
                                                            <div class="row g-2">
                                                                <div class="col-6">
                                                                    <button class="btn btn-primary w-100"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#importThanawiModal"
                                                                        data-school-id="{{ $students->first()->school_id }}"
                                                                        data-school-name="{{ $schoolName }}">
                                                                        <i class="fas fa-upload me-2"></i> Import
                                                                    </button>
                                                                </div>
                                                                <div class="col-6">
                                                                    <a href="{{ route('students.export', ['schoolId' => $students->first()->school_id, 'type' => 'thanawi']) }}"
                                                                        class="btn btn-success w-100 export-btn">
                                                                        <i class="fas fa-download me-2"></i>
                                                                        Export
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Idaad Section -->
                                            <div class="col-lg-6">
                                                <div class="exam-card exam-card--idaad">
                                                    <div class="exam-card-header">
                                                        <div class="exam-icon">
                                                            <i class="fas fa-book-open"></i>
                                                        </div>
                                                        <div class="exam-info">
                                                            <h4 class="exam-title">Idaad Exams</h4>
                                                            <p class="exam-description">Preparatory level examination data
                                                                management</p>
                                                        </div>
                                                    </div>
                                                    <div class="exam-card-body">
                                                        <div class="exam-stats">
                                                            <div class="stat-item">
                                                                <span class="stat-label">Status</span>
                                                                <span class="stat-value text-success">Active</span>
                                                            </div>
                                                        </div>
                                                        <div class="exam-actions mt-4">
                                                            <div class="row g-2">
                                                                <div class="col-6">
                                                                    <button class="btn btn-primary w-100"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#importIdaadModal"
                                                                        data-school-id="{{ $students->first()->school_id }}"
                                                                        data-school-name="{{ $schoolName }}">
                                                                        <i class="fas fa-upload me-2"></i> Import
                                                                    </button>
                                                                </div>
                                                                <div class="col-6">
                                                                    <a href="{{ route('students.export', ['schoolId' => $students->first()->school_id, 'type' => 'idaad']) }}"
                                                                        class="btn btn-success w-100 export-btn">
                                                                        <i class="fas fa-download me-2"></i>
                                                                        Export
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <!-- Import Thanawi Modal -->
                <div class="modal fade" id="importThanawiModal" tabindex="-1" aria-labelledby="importThanawiModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <form method="POST" action="{{ route('import.thanawi') }}" enctype="multipart/form-data"
                            class="modal-content border-0 shadow-lg" id="importThanawiForm">
                            @csrf
                            <input type="hidden" name="school_id" id="thanawi_school_id">

                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title d-flex align-items-center" id="importThanawiModalLabel">
                                    <i class="fas fa-file-import" style="margin-right: 5px;"></i>
                                    <span>Import Thanawi Exam Results</span>
                                </h5>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body p-4">
                                <div class="alert alert-info border-0 bg-light-info d-flex align-items-center mb-4"
                                    role="alert">
                                    <i class="fas fa-info-circle mr-2 text-info" style="font-size: 1.25rem;"></i>
                                    <div>
                                        <small class="text-uppercase font-weight-bold d-block">Instructions</small>
                                        Upload Excel file containing Thanawi exam results. Ensure the file follows the
                                        required format.
                                    </div>
                                </div>


                                <div class="mb-4">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <label class="form-label fw-bold m-0 text-dark">Select Excel File</label>
                                        <span
                                            class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3">
                                            Required
                                        </span>
                                    </div>

                                    <div class="position-relative rounded-4 bg-light border border-2 border-dashed border-primary 
                                d-flex align-items-center justify-content-center"
                                        style="height: 180px; transition: all 0.3s ease;">
                                        <input type="file" name="file" id="thanawi-file-input"
                                            class="position-absolute top-0 start-0 w-100 h-100 opacity-0"
                                            style="cursor: pointer; z-index: 5;" accept=".xlsx,.xls,.csv" required>

                                        <div class="text-center p-3">
                                            <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center 
                                        justify-content-center mb-3 shadow-sm"
                                                style="width: 54px; height: 54px;">
                                                <i class="fas fa-file-excel fs-3"></i>
                                            </div>
                                            <h6 class="fw-bold mb-1" id="thanawi-label">Drop your Excel file here</h6>
                                            <p class="text-muted small mb-0" id="thanawi-sub-label">or click to browse
                                                computer</p>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between mt-2 px-1">
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle me-1"></i>Supports: .xlsx, .xls, .csv
                                        </small>
                                        <small class="text-muted">Max: 10MB</small>
                                    </div>
                                </div>

                                <div class="form-group mb-4">
                                    <label class="form-label fw-bold">Academic Year</label>
                                    <input type="text" class="form-control" value="{{ Helper::active_year() }}"
                                        readonly>
                                    <small class="text-muted">Results will be imported for the active academic year</small>
                                </div>

                                <div class="form-group mb-4">
                                    <label class="form-label fw-bold">School Name</label>
                                    <input type="text" class="form-control" id="thanawi_school_name_display" readonly>
                                    <small class="text-muted">Results will be imported for this school</small>
                                </div>

                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="thanawi-overwrite"
                                        name="overwrite">
                                    <label class="form-check-label" for="thanawi-overwrite">
                                        Overwrite existing results for this exam
                                    </label>
                                    <small class="text-muted d-block mt-1">If checked, existing results will be
                                        replaced</small>
                                </div>
                            </div>

                            <div class="modal-footer bg-light border-top-0 px-4 py-3">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                    <i class="fas fa-times me-1"></i> Cancel
                                </button>
                                <button type="submit" class="btn btn-primary px-4 shadow-sm"
                                    id="confirmThanawiUploadBtn">
                                    <i class="fas fa-upload me-1"></i> Upload & Process
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Import Idaad Modal -->
                <div class="modal fade" id="importIdaadModal" tabindex="-1" aria-labelledby="importIdaadModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <form method="POST" action="{{ route('import.idaad') }}" enctype="multipart/form-data"
                            class="modal-content border-0 shadow-lg" id="importIdaadForm">
                            @csrf
                            <input type="hidden" name="school_id" id="idaad_school_id">

                            <div class="modal-header bg-info text-white">
                                <h5 class="modal-title d-flex align-items-center" id="importIdaadModalLabel">
                                    <i class="fas fa-file-import me-2" style="margin-right:5px;"></i>
                                    <span>Import Idaad Exam Results</span>
                                </h5>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body p-4">
                                <div class="alert alert-info border-0 bg-light-info d-flex align-items-center mb-4"
                                    role="alert">
                                    <i class="fas fa-info-circle mr-2 text-info" style="font-size: 1.25rem;"></i>
                                    <div>
                                        <small class="text-uppercase font-weight-bold d-block">Instructions</small>
                                        Upload Excel file containing Idaad exam results. Ensure the file follows the
                                        required format.
                                    </div>
                                </div>


                                <div class="mb-4">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <label class="form-label fw-bold m-0 text-dark">Select Excel File</label>
                                        <span
                                            class="badge bg-info-subtle text-info border border-info-subtle rounded-pill px-3">
                                            Required
                                        </span>
                                    </div>

                                    <div class="position-relative rounded-4 bg-light border border-2 border-dashed border-info 
                                d-flex align-items-center justify-content-center"
                                        style="height: 180px; transition: all 0.3s ease;">
                                        <input type="file" name="file" id="idaad-file-input"
                                            class="position-absolute top-0 start-0 w-100 h-100 opacity-0"
                                            style="cursor: pointer; z-index: 5;" accept=".xlsx,.xls,.csv" required>

                                        <div class="text-center p-3">
                                            <div class="bg-info text-white rounded-circle d-inline-flex align-items-center 
                                        justify-content-center mb-3 shadow-sm"
                                                style="width: 54px; height: 54px;">
                                                <i class="fas fa-file-excel fs-3"></i>
                                            </div>
                                            <h6 class="fw-bold mb-1" id="idaad-label">Drop your Excel file here</h6>
                                            <p class="text-muted small mb-0" id="idaad-sub-label">or click to browse
                                                computer</p>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between mt-2 px-1">
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle me-1"></i>Supports: .xlsx, .xls, .csv
                                        </small>
                                        <small class="text-muted">Max: 10MB</small>
                                    </div>
                                </div>

                                <div class="form-group mb-4">
                                    <label class="form-label fw-bold">Academic Year</label>
                                    <input type="text" class="form-control" value="{{ Helper::active_year() }}"
                                        readonly>
                                    <small class="text-muted">Results will be imported for the active academic year</small>
                                </div>

                                <div class="form-group mb-4">
                                    <label class="form-label fw-bold">School Name</label>
                                    <input type="text" class="form-control" id="idaad_school_name_display" readonly>
                                    <small class="text-muted">Results will be imported for this school</small>
                                </div>

                                <div class="form-group mb-4">
                                    <label class="form-label fw-bold">School Name</label>
                                    <input type="text" class="form-control" value="{{ Helper::active_year() }}"
                                        readonly>
                                    <small class="text-muted">Results will be imported for the active academic year</small>
                                </div>

                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="idaad-overwrite"
                                        name="overwrite">
                                    <label class="form-check-label" for="idaad-overwrite">
                                        Overwrite existing results for this exam
                                    </label>
                                    <small class="text-muted d-block mt-1">If checked, existing results will be
                                        replaced</small>
                                </div>
                            </div>

                            <div class="modal-footer bg-light border-top-0 px-4 py-3">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                    <i class="fas fa-times me-1"></i> Cancel
                                </button>
                                <button type="submit" class="btn btn-info px-4 shadow-sm text-white"
                                    id="confirmIdaadUploadBtn">
                                    <i class="fas fa-upload me-1"></i> Upload & Process
                                </button>
                            </div>
                        </form>
                    </div>
                </div>


                <script>
                    document.addEventListener('DOMContentLoaded', function() {

                        document.querySelectorAll('[data-bs-target="#importThanawiModal"]').forEach(button => {
                            button.addEventListener('click', function() {
                                const schoolId = this.getAttribute('data-school-id');
                                const schoolName = this.getAttribute('data-school-name');

                                console.log('Thanawi Import - School:', schoolName, 'ID:', schoolId);

                                // Set values in modal
                                if (schoolId) {
                                    document.getElementById('thanawi_school_id').value = schoolId;
                                }
                                if (schoolName) {
                                    document.getElementById('thanawi_school_name_display').value = schoolName;
                                }
                            });
                        });

                        document.querySelectorAll('[data-bs-target="#importIdaadModal"]').forEach(button => {
                            button.addEventListener('click', function() {
                                const schoolId = this.getAttribute('data-school-id');
                                const schoolName = this.getAttribute('data-school-name');

                                console.log('Idaad Import - School:', schoolName, 'ID:', schoolId);

                                // Set values in modal
                                if (schoolId) {
                                    document.getElementById('idaad_school_id').value = schoolId;
                                }
                                if (schoolName) {
                                    document.getElementById('idaad_school_name_display').value = schoolName;
                                }
                            });
                        });

                        document.getElementById('thanawi-file-input').addEventListener('change', function(e) {
                            const name = e.target.files[0]?.name;
                            if (name) {
                                document.getElementById('thanawi-label').innerText = name;
                                document.getElementById('thanawi-label').classList.add('text-primary');
                                document.getElementById('thanawi-sub-label').innerText = "File selected successfully";
                            }
                        });

                        document.getElementById('idaad-file-input').addEventListener('change', function(e) {
                            const name = e.target.files[0]?.name;
                            if (name) {
                                document.getElementById('idaad-label').innerText = name;
                                document.getElementById('idaad-label').classList.add('text-info');
                                document.getElementById('idaad-sub-label').innerText = "File selected successfully";
                            }
                        });

                        document.getElementById('importThanawiForm').addEventListener('submit', function(e) {
                            const activeYear = "{{ Helper::active_year() }}";
                            if (activeYear === "No Active year Set") {
                                e.preventDefault();
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'No Active Academic Year',
                                    text: 'Please set an active academic year before importing.',
                                    confirmButtonColor: '#287C44',
                                    confirmButtonText: 'Set Active Year'
                                });
                                return false;
                            }

                            const fileInput = document.getElementById('thanawi-file-input');
                            if (!fileInput.files.length) {
                                e.preventDefault();
                                Swal.fire({
                                    icon: 'error',
                                    title: 'No File Selected',
                                    text: 'Please select an Excel file to upload.',
                                    confirmButtonColor: '#0d6efd'
                                });
                                return false;
                            }

                            // Show confirmation dialog
                            e.preventDefault();

                            Swal.fire({
                                title: 'Confirm Import',
                                html: `Are you sure you want to import Thanawi exam results for <strong>${document.getElementById('thanawi_school_name_display').value}</strong>?`,
                                icon: 'question',
                                showCancelButton: true,
                                confirmButtonColor: '#0d6efd',
                                cancelButtonColor: '#6c757d',
                                confirmButtonText: 'Yes, import now',
                                cancelButtonText: 'Cancel'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Show simple loading SweetAlert
                                    Swal.fire({
                                        title: 'Uploading File',
                                        text: 'Please wait while we process your file...',
                                        icon: 'info',
                                        showConfirmButton: false,
                                        allowOutsideClick: false,
                                        allowEscapeKey: false,
                                        didOpen: () => {
                                            Swal.showLoading();
                                        }
                                    });

                                    // Disable submit button
                                    const btn = document.getElementById('confirmThanawiUploadBtn');
                                    btn.disabled = true;
                                    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Processing...';

                                    // Now submit the form
                                    this.submit();
                                }
                            });
                        });

                        document.getElementById('importIdaadForm').addEventListener('submit', function(e) {
                            const activeYear = "{{ Helper::active_year() }}";
                            if (activeYear === "No Active year Set") {
                                e.preventDefault();
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'No Active Academic Year',
                                    text: 'Please set an active academic year before importing.',
                                    confirmButtonColor: '#287C44',
                                    confirmButtonText: 'Set Active Year'
                                });
                                return false;
                            }

                            const fileInput = document.getElementById('idaad-file-input');
                            if (!fileInput.files.length) {
                                e.preventDefault();
                                Swal.fire({
                                    icon: 'error',
                                    title: 'No File Selected',
                                    text: 'Please select an Excel file to upload.',
                                    confirmButtonColor: '#0ea5e9'
                                });
                                return false;
                            }

                            // Show confirmation dialog
                            e.preventDefault(); // Prevent default only to show confirmation

                            Swal.fire({
                                title: 'Confirm Import',
                                html: `Are you sure you want to import Idaad exam results for <strong>${document.getElementById('idaad_school_name_display').value}</strong>?`,
                                icon: 'question',
                                showCancelButton: true,
                                confirmButtonColor: '#0ea5e9',
                                cancelButtonColor: '#6c757d',
                                confirmButtonText: 'Yes, import now',
                                cancelButtonText: 'Cancel'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Show simple loading SweetAlert
                                    Swal.fire({
                                        title: 'Uploading File',
                                        text: 'Please wait while we process your file...',
                                        icon: 'info',
                                        showConfirmButton: false,
                                        allowOutsideClick: false,
                                        allowEscapeKey: false,
                                        didOpen: () => {
                                            Swal.showLoading();
                                        }
                                    });

                                    // Disable submit button
                                    const btn = document.getElementById('confirmIdaadUploadBtn');
                                    btn.disabled = true;
                                    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Processing...';

                                    // Now submit the form
                                    this.submit();
                                }
                            });
                        });

                        // Reset form when modal is closed
                        document.getElementById('importThanawiModal').addEventListener('hidden.bs.modal', function() {
                            document.getElementById('importThanawiForm').reset();
                            document.getElementById('thanawi-label').innerText = 'Drop your Excel file here';
                            document.getElementById('thanawi-label').classList.remove('text-primary');
                            document.getElementById('thanawi-sub-label').innerText = 'or click to browse computer';
                            document.getElementById('thanawi_school_name_display').value = '';
                            const btn = document.getElementById('confirmThanawiUploadBtn');
                            btn.disabled = false;
                            btn.innerHTML = '<i class="fas fa-upload me-1"></i> Upload & Process';
                        });

                        document.getElementById('importIdaadModal').addEventListener('hidden.bs.modal', function() {
                            document.getElementById('importIdaadForm').reset();
                            document.getElementById('idaad-label').innerText = 'Drop your Excel file here';
                            document.getElementById('idaad-label').classList.remove('text-info');
                            document.getElementById('idaad-sub-label').innerText = 'or click to browse computer';
                            document.getElementById('idaad_school_name_display').value = '';
                            const btn = document.getElementById('confirmIdaadUploadBtn');
                            btn.disabled = false;
                            btn.innerHTML = '<i class="fas fa-upload me-1"></i> Upload & Process';
                        });
                    });

                    // Add this to your JavaScript to handle form submission responses
                    // You can add this after your existing JavaScript

                    // Handle form submission response
                    function handleFormResponse(formId) {
                        const form = document.getElementById(formId);

                        form.addEventListener('ajax:success', function(event) {
                            const [data, status, xhr] = event.detail;

                            Swal.fire({
                                icon: 'success',
                                title: 'Upload Successful!',
                                text: data.message || 'File uploaded successfully',
                                confirmButtonColor: '#287C44'
                            }).then(() => {
                                // Close modal
                                const modal = bootstrap.Modal.getInstance(document.getElementById(formId.includes(
                                    'thanawi') ? 'importThanawiModal' : 'importIdaadModal'));
                                modal.hide();

                                // Optional: Refresh page or update UI
                                window.location.reload();
                            });
                        });

                        form.addEventListener('ajax:error', function(event) {
                            const [xhr, status, error] = event.detail;

                            Swal.fire({
                                icon: 'error',
                                title: 'Upload Failed',
                                text: xhr.responseJSON?.message || 'An error occurred during upload',
                                confirmButtonColor: '#dc3545'
                            });
                        });
                    }
                </script>

                <!-- Add this JavaScript after your existing script -->
                <script>
                    // Set school ID when import buttons are clicked
                    document.querySelectorAll('[data-bs-target="#importThanawiModal"]').forEach(button => {
                        button.addEventListener('click', function() {
                            const schoolCard = this.closest('.school-card');
                            const schoolId = schoolCard.querySelector('.export-btn').href.match(/schoolId=([^&]*)/)[1];
                            document.getElementById('thanawi_school_id').value = schoolId;
                        });
                    });

                    document.querySelectorAll('[data-bs-target="#importIdaadModal"]').forEach(button => {
                        button.addEventListener('click', function() {
                            const schoolCard = this.closest('.school-card');
                            const schoolId = schoolCard.querySelector('.export-btn').href.match(/schoolId=([^&]*)/)[1];
                            document.getElementById('idaad_school_id').value = schoolId;
                        });
                    });

                    // File input handlers
                    document.getElementById('thanawi-file-input').addEventListener('change', function(e) {
                        const name = e.target.files[0]?.name;
                        if (name) {
                            document.getElementById('thanawi-label').innerText = name;
                            document.getElementById('thanawi-label').classList.add('text-primary');
                            document.getElementById('thanawi-sub-label').innerText = "File selected successfully";
                        }
                    });

                    document.getElementById('idaad-file-input').addEventListener('change', function(e) {
                        const name = e.target.files[0]?.name;
                        if (name) {
                            document.getElementById('idaad-label').innerText = name;
                            document.getElementById('idaad-label').classList.add('text-info');
                            document.getElementById('idaad-sub-label').innerText = "File selected successfully";
                        }
                    });

                    // Form submission handlers
                    document.getElementById('importThanawiForm').addEventListener('submit', function(e) {
                        e.preventDefault();

                        const activeYear = "{{ Helper::active_year() }}";
                        if (activeYear === "No Active year Set") {
                            Swal.fire({
                                icon: 'warning',
                                title: 'No Active Academic Year',
                                text: 'Please set an active academic year before importing.',
                                confirmButtonColor: '#287C44',
                                confirmButtonText: 'Set Active Year'
                            });
                            return false;
                        }

                        Swal.fire({
                            title: 'Confirm Import',
                            html: 'Are you sure you want to import Thanawi exam results?',
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#0d6efd',
                            cancelButtonColor: '#6c757d',
                            confirmButtonText: 'Yes, import',
                            cancelButtonText: 'Cancel'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                const btn = document.getElementById('confirmThanawiUploadBtn');
                                btn.disabled = true;
                                btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Processing...';
                                this.submit();
                            }
                        });
                    });

                    document.getElementById('importIdaadForm').addEventListener('submit', function(e) {
                        e.preventDefault();

                        const activeYear = "{{ Helper::active_year() }}";
                        if (activeYear === "No Active year Set") {
                            Swal.fire({
                                icon: 'warning',
                                title: 'No Active Academic Year',
                                text: 'Please set an active academic year before importing.',
                                confirmButtonColor: '#287C44',
                                confirmButtonText: 'Set Active Year'
                            });
                            return false;
                        }

                        Swal.fire({
                            title: 'Confirm Import',
                            html: 'Are you sure you want to import Idaad exam results?',
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#0ea5e9',
                            cancelButtonColor: '#6c757d',
                            confirmButtonText: 'Yes, import',
                            cancelButtonText: 'Cancel'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                const btn = document.getElementById('confirmIdaadUploadBtn');
                                btn.disabled = true;
                                btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Processing...';
                                this.submit();
                            }
                        });
                    });

                    // Reset form when modal is closed
                    document.getElementById('importThanawiModal').addEventListener('hidden.bs.modal', function() {
                        document.getElementById('importThanawiForm').reset();
                        document.getElementById('thanawi-label').innerText = 'Drop your Excel file here';
                        document.getElementById('thanawi-label').classList.remove('text-primary');
                        document.getElementById('thanawi-sub-label').innerText = 'or click to browse computer';
                        document.getElementById('confirmThanawiUploadBtn').disabled = false;
                        document.getElementById('confirmThanawiUploadBtn').innerHTML =
                            '<i class="fas fa-upload me-1"></i> Upload & Process';
                    });

                    document.getElementById('importIdaadModal').addEventListener('hidden.bs.modal', function() {
                        document.getElementById('importIdaadForm').reset();
                        document.getElementById('idaad-label').innerText = 'Drop your Excel file here';
                        document.getElementById('idaad-label').classList.remove('text-info');
                        document.getElementById('idaad-sub-label').innerText = 'or click to browse computer';
                        document.getElementById('confirmIdaadUploadBtn').disabled = false;
                        document.getElementById('confirmIdaadUploadBtn').innerHTML =
                            '<i class="fas fa-upload me-1"></i> Upload & Process';
                    });
                </script>
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

    <script></script>
@endsection
