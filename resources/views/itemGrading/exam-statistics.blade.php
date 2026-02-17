@extends('layouts-side-bar.master')

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

@section('content')
    <div class="side-app">
        <div class="container mt-4">
            <div class="card shadow-lg border-0 mb-4">
                <div class="card-header text-white d-flex justify-content-between align-items-center"
                    style="background-color: #17a2b8;">
                    <h4 class="mb-0">
                        <i class="fas fa-chart-bar me-2"></i> Exam Statistics : {{ $year }} - {{ $category }}
                    </h4>
                    <span class="badge badge-light text-dark">Level {{ $level }}</span>
                </div>

                <div class="card-body">
                    <!-- Filter Form -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <form action="{{ route('iteb.exam.statistics') }}" method="POST"
                                class="form-inline justify-content-center">
                                @csrf
                                <div class="row g-3 align-items-end">
                                    <div class="col-md-3">
                                        <label class="fw-bold">Year</label>
                                        <select name="year" class="form-control" required>
                                            <option value="">Select Year</option>
                                            @foreach ($years ?? [] as $y)
                                                <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>
                                                    {{ $y }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="fw-bold">Category</label>
                                        <select name="category" class="form-control" required>
                                            <option value="">Select Category</option>
                                            <option value="ID" {{ $category == 'ID' ? 'selected' : '' }}>Idaad (ID)
                                            </option>
                                            <option value="TH" {{ $category == 'TH' ? 'selected' : '' }}>Thanawi (TH)
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="fw-bold">Level</label>
                                        <select name="level" class="form-control">
                                            <option value="A" {{ $level == 'A' ? 'selected' : '' }}>Level A</option>
                                            <option value="O" {{ $level == 'O' ? 'selected' : '' }}>Level O</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit" class="btn text-white px-4"
                                            style="background-color: #17a2b8;">
                                            <i class="fas fa-search me-2"></i> Generate Statistics
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <hr>

                    <!-- Statistics Results -->
                    @if (isset($schoolsTable))
                        <!-- 1- Number of schools registered -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h5 class="bg-light p-2 rounded">1- Number of schools registered for Exams
                                    {{ $year }}:</h5>
                                <table class="table table-bordered table-hover">
                                    <thead class="table-secondary">
                                        <tr>
                                            <th>S/N</th>
                                            <th>{{ $levelName }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($schoolsTable as $index => $school)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $school['count'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- 2- Number of students registered -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h5 class="bg-light p-2 rounded">2- Number of students registered:</h5>
                                <table class="table table-bordered table-hover">
                                    <thead class="table-secondary">
                                        <tr>
                                            <th>S/N</th>
                                            <th>{{ $levelName }}</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($studentsRegisteredTable as $index => $student)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $student['count'] }}</td>
                                                <td>{{ $student['total'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- 3- Grading Summary (IDAAD/THANAWI LEVEL) -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h5 class="bg-light p-2 rounded">3- Grading Summary - {{ $levelName }}:</h5>
                                <table class="table table-bordered table-hover">
                                    <thead class="table-secondary">
                                        <tr>
                                            <th>S/N</th>
                                            <th>{{ $levelName }}</th>
                                            <th>Male</th>
                                            <th>%</th>
                                            <th>Female</th>
                                            <th>%</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>a.</td>
                                            <td>Excellent D1</td>
                                            <td>{{ $gradingSummary['D1']['male_count'] }}</td>
                                            <td>{{ $gradingSummary['D1']['male_percent'] }}%</td>
                                            <td>{{ $gradingSummary['D1']['female_count'] }}</td>
                                            <td>{{ $gradingSummary['D1']['female_percent'] }}%</td>
                                            <td>{{ $gradingSummary['D1']['total'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>b.</td>
                                            <td>Very good D2</td>
                                            <td>{{ $gradingSummary['D2']['male_count'] }}</td>
                                            <td>{{ $gradingSummary['D2']['male_percent'] }}%</td>
                                            <td>{{ $gradingSummary['D2']['female_count'] }}</td>
                                            <td>{{ $gradingSummary['D2']['female_percent'] }}%</td>
                                            <td>{{ $gradingSummary['D2']['total'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>c.</td>
                                            <td>Good C3</td>
                                            <td>{{ $gradingSummary['C3']['male_count'] }}</td>
                                            <td>{{ $gradingSummary['C3']['male_percent'] }}%</td>
                                            <td>{{ $gradingSummary['C3']['female_count'] }}</td>
                                            <td>{{ $gradingSummary['C3']['female_percent'] }}%</td>
                                            <td>{{ $gradingSummary['C3']['total'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>d.</td>
                                            <td>Pass C4</td>
                                            <td>{{ $gradingSummary['C4']['male_count'] }}</td>
                                            <td>{{ $gradingSummary['C4']['male_percent'] }}%</td>
                                            <td>{{ $gradingSummary['C4']['female_count'] }}</td>
                                            <td>{{ $gradingSummary['C4']['female_percent'] }}%</td>
                                            <td>{{ $gradingSummary['C4']['total'] }}</td>
                                        </tr>
                                        <tr class="table-warning fw-bold">
                                            <td colspan="2">Total</td>
                                            <td>{{ $totals['male_total'] }}</td>
                                            <td>{{ $totals['male_total'] > 0 ? round(($totals['male_total'] / $totals['overall_total']) * 100, 2) : 0 }}%
                                            </td>
                                            <td>{{ $totals['female_total'] }}</td>
                                            <td>{{ $totals['female_total'] > 0 ? round(($totals['female_total'] / $totals['overall_total']) * 100, 2) : 0 }}%
                                            </td>
                                            <td>{{ $totals['overall_total'] }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- 4- Students Failed -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h5 class="bg-light p-2 rounded">4- Students failed:</h5>
                                <table class="table table-bordered table-hover">
                                    <thead class="table-danger">
                                        <tr>
                                            <th>S/N</th>
                                            <th>{{ $levelName }}</th>
                                            <th>Male</th>
                                            <th>Female</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td>{{ $failedBreakdown['male_failed'] }}</td>
                                            <td>{{ $failedBreakdown['female_failed'] }}</td>
                                            <td>{{ $failedBreakdown['total_failed'] }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Summary Cards -->
                        <div class="row mt-4">
                            <div class="col-md-4">
                                <div class="card bg-primary text-white">
                                    <div class="card-body">
                                        <h5>Registered Students</h5>
                                        <h3>{{ $registeredStudents }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-success text-white">
                                    <div class="card-body">
                                        <h5>Graded Students</h5>
                                        <h3>{{ $totalGraded }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-danger text-white">
                                    <div class="card-body">
                                        <h5>Failed Students</h5>
                                        <h3>{{ $failedBreakdown['total_failed'] }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Back Button -->
                        <div class="row mt-4">
                            <div class="col-12 text-center">
                                <a href="{{ route('iteb.grading.summary') }}" class="btn btn-secondary btn-lg">
                                    <i class="fas fa-arrow-left me-2"></i> Back to Dashboard
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
