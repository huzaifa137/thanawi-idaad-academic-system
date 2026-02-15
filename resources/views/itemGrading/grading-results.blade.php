{{-- resources/views/itemGrading/grading-results.blade.php --}}
@extends('layouts-side-bar.master')

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">

@section('content')
<div class="side-app">
    <div class="container mt-4">
        
        {{-- Header Card --}}
        <div class="card shadow-lg border-0 mb-4">
            <div class="card-header text-white" style="background-color: #28a745;">
                <h4 class="mb-0">
                    <i class="fas fa-star me-2"></i>Grading Results: 
                    {{ $schoolName }} - {{ $category }} - {{ $year }}
                    @if($level)
                        <span class="badge bg-light text-dark ms-2">Level {{ $level }}</span>
                    @endif
                </h4>
            </div>

            <div class="card-body">
                {{-- Statistics Cards --}}
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <h6>Total Students</h6>
                                <h3>{{ $statistics['count'] }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <h6>Average Percentage</h6>
                                <h3>{{ $statistics['average'] }}%</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-warning text-white">
                            <div class="card-body">
                                <h6>Highest Score</h6>
                                <h3>{{ $statistics['highest'] }}%</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-danger text-white">
                            <div class="card-body">
                                <h6>Lowest Score</h6>
                                <h3>{{ $statistics['lowest'] }}%</h3>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Distribution Charts Row --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-info text-white">
                                <h6 class="mb-0">Grade Distribution (Marks)</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Grade</th>
                                                <th>Count</th>
                                                <th>Percentage</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($statistics['grade_distribution'] as $grade => $count)
                                                <tr>
                                                    <td><strong>{{ $grade }}</strong></td>
                                                    <td>{{ $count }}</td>
                                                    <td>
                                                        @if($statistics['count'] > 0)
                                                            {{ round(($count / $statistics['count']) * 100, 1) }}%
                                                        @else
                                                            0%
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-success text-white">
                                <h6 class="mb-0">Classification Distribution (Points)</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Classification</th>
                                                <th>Count</th>
                                                <th>Percentage</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($statistics['class_distribution'] as $class => $count)
                                                <tr>
                                                    <td><strong>{{ $class }}</strong></td>
                                                    <td>{{ $count }}</td>
                                                    <td>
                                                        @if($statistics['count'] > 0)
                                                            {{ round(($count / $statistics['count']) * 100, 1) }}%
                                                        @else
                                                            0%
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Results Table --}}
                <div class="card">
                    <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Student Results</h5>
                        <div>
                            <button class="btn btn-sm btn-light" onclick="exportToExcel()">
                                <i class="fas fa-file-excel"></i> Export
                            </button>
                            <button class="btn btn-sm btn-light" onclick="printResults()">
                                <i class="fas fa-print"></i> Print
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="saveResultsForm" method="POST" action="{{ route('iteb.save.grading') }}">
                            @csrf
                            <input type="hidden" name="year" value="{{ $year }}">
                            <input type="hidden" name="category" value="{{ $category }}">
                            <input type="hidden" name="school_number" value="{{ $schoolNumber }}">
                            <input type="hidden" name="level" value="{{ $level }}">

                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" id="resultsTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Index Number</th>
                                            <th>Total Marks</th>
                                            <th>Max Possible</th>
                                            <th>Percentage</th>
                                            <th>Grade</th>
                                            <th>Classification</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($results as $studentId => $result)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    {{ $studentId }}
                                                    <input type="hidden" name="results[{{ $studentId }}][total_marks]" value="{{ $result['total_marks'] }}">
                                                    <input type="hidden" name="results[{{ $studentId }}][percentage]" value="{{ $result['percentage'] }}">
                                                    <input type="hidden" name="results[{{ $studentId }}][grade]" value="{{ $result['grade'] }}">
                                                    <input type="hidden" name="results[{{ $studentId }}][classification]" value="{{ $result['classification'] }}">
                                                </td>
                                                <td>{{ $result['total_marks'] }}</td>
                                                <td>{{ $result['total_possible'] }}</td>
                                                <td>
                                                    <span class="badge 
                                                        @if($result['percentage'] >= 80) bg-success
                                                        @elseif($result['percentage'] >= 70) bg-primary
                                                        @elseif($result['percentage'] >= 60) bg-info
                                                        @elseif($result['percentage'] >= 50) bg-warning
                                                        @else bg-danger
                                                        @endif
                                                    ">
                                                        {{ $result['percentage'] }}%
                                                    </span>
                                                </td>
                                                <td>
                                                    <strong>{{ $result['grade'] }}</strong>
                                                    <small class="d-block text-muted">{{ $result['grade_comment'] }}</small>
                                                </td>
                                                <td>
                                                    <strong>{{ $result['classification'] }}</strong>
                                                    <small class="d-block text-muted">{{ $result['classification_comment'] }}</small>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-info" 
                                                            onclick="viewDetails('{{ $studentId }}')"
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#detailsModal-{{ $loop->index }}">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </td>
                                            </tr>

                                            {{-- Details Modal --}}
                                            {{-- <div class="modal fade" id="detailsModal-{{ $loop->index }}" tabindex="-1">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-info text-white">
                                                            <h5 class="modal-title">Student Details: {{ $studentId }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h6>Subject Marks</h6>
                                                            <table class="table table-sm table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Subject</th>
                                                                        <th>Mark</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach($result['marks_details'] as $mark)
                                                                        <tr>
                                                                            <td>{{ $mark->subject->md_name ?? 'N/A' }}</td>
                                                                            <td>{{ $mark->mark }}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th>Total</th>
                                                                        <th>{{ $result['total_marks'] }}/{{ $result['total_possible'] }}</th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Percentage</th>
                                                                        <th>{{ $result['percentage'] }}%</th>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> --}}
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </form>

                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <button class="btn btn-success btn-lg" onclick="saveResults()">
                                    <i class="fas fa-save me-2"></i>Save Grading Results
                                </button>
                                <a href="{{ route('iteb.grading.summary') }}" class="btn btn-secondary btn-lg">
                                    <i class="fas fa-arrow-left me-2"></i>Back to Filters
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize DataTable
    $('#resultsTable').DataTable({
        pageLength: 25,
        order: [[4, 'desc']], // Sort by percentage descending
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel"></i> Excel',
                className: 'btn btn-success btn-sm',
                title: 'Grading_Results_{{ $schoolName }}_{{ $category }}_{{ $year }}',
                exportOptions: {
                    columns: [0,1,2,3,4,5,6]
                }
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Print',
                className: 'btn btn-info btn-sm',
                title: 'Grading Results - {{ $schoolName }} - {{ $category }} - {{ $year }}'
            }
        ]
    });
});

function saveResults() {
    if (confirm('Are you sure you want to save these grading results?')) {
        const form = document.getElementById('saveResultsForm');
        const formData = new FormData(form);
        
        fetch('{{ route("iteb.save.grading") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                window.location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while saving results');
        });
    }
}

function viewDetails(studentId) {
    // This function is handled by Bootstrap modal
    console.log('Viewing details for:', studentId);
}

function exportToExcel() {
    $('#resultsTable').DataTable().button('.buttons-excel').trigger();
}

function printResults() {
    $('#resultsTable').DataTable().button('.buttons-print').trigger();
}
</script>
@endpush