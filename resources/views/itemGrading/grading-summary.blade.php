{{-- resources/views/itemGrading/grading-summary.blade.php --}}
@extends('layouts-side-bar.master')

@section('content')
<div class="side-app">
    <div class="container mt-4">
        <div class="card shadow-lg border-0">
            <div class="card-header text-white" style="background-color: #17a2b8;">
                <h4 class="mb-0">
                    <i class="fas fa-chart-line me-2"></i>Grading Summary
                </h4>
            </div>

            <div class="card-body">
                <form action="{{ route('iteb.process.grading') }}" method="POST" id="gradingFilterForm">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">Year <span class="text-danger">*</span></label>
                                <select name="year" class="form-control" required>
                                    <option value="">-- Select Year --</option>
                                    @foreach($years as $year)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">Category <span class="text-danger">*</span></label>
                                <select name="category" class="form-control" required>
                                    <option value="">-- Select Category --</option>
                                    @foreach($categories as $key => $value)
                                        <option value="{{ $key }}">{{ $value }} ({{ $key }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">School (Optional)</label>
                                <select name="school_number" class="form-control">
                                    <option value="">-- All Schools --</option>
                                    @foreach($schools as $code => $name)
                                        <option value="{{ $code }}">{{ $name }} ({{ $code }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">Level</label>
                                <select name="level" class="form-control">
                                    <option value="A">Level A</option>
                                    <option value="O">Level O</option>
                                </select>
                                <small class="text-muted">Grading level for classification</small>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-info text-white px-5 py-2">
                                <i class="fas fa-calculator me-2"></i>Generate Grading Report
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Quick Stats Card --}}
        <div class="row mt-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h6>Total Students</h6>
                        <h3>{{ $years->count() > 0 ? '—' : '0' }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h6>Graded So Far</h6>
                        <h3>{{ $years->count() > 0 ? '—' : '0' }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h6>Pending Grading</h6>
                        <h3>{{ $years->count() > 0 ? '—' : '0' }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h6>Avg Performance</h6>
                        <h3>{{ $years->count() > 0 ? '—' : '0%' }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Optional: Add AJAX to load schools based on category/year
    // Or add loading indicators
});
</script>
@endpush