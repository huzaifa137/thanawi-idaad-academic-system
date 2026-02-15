@extends('layouts-side-bar.master')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    integrity="sha512-p1B9XJvxXlJ0sFh1ExAmH4y3L1kGk+x+r6Gx7q6v5+PgfKhnYzOZ3xGlKEX2eVZCMu1k7r1R7pLLj5p2lP2vXw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

@section('content')
    <div class="side-app">
        <div class="container mt-4">

            <div class="card shadow-lg border-0">
                <div class="card-header text-white" style="background-color: #253f2d;">
                    <h4 class="mb-0">
                        ({{ $schoolName }} - {{ $category }} - {{ $year }})
                    </h4>
                </div>

                <div class="card-body">

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if ($records->count() > 0)
                        <form id="gradingForm" method="POST" action="{{ route('iteb.save.marks') }}">
                            @csrf

                            <div class="row">

                                <!-- LEFT SIDE: Students Table -->
                                <div class="col-md-8">
                                    <div class="card shadow border-0">
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <span class="badge text-white" id="selectedSubjectDisplay"
                                                    style="background-color:#0d4b1e;">
                                                    Current Subject121: Not selected
                                                </span>
                                            </div>
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th width="10%">No</th>
                                                        <th width="40%">Index Number</th>
                                                        <th width="30%">Marks</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="marksTableBody">
                                                    @foreach ($records as $key => $record)
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>
                                                                {{ $record->Student_ID }}
                                                                <input type="hidden" name="students[]"
                                                                    value="{{ $record->Student_ID }}">
                                                            </td>
                                                            <td>
                                                                <input type="number"
                                                                    name="marks[{{ $record->Student_ID }}]"
                                                                    class="form-control mark-input"
                                                                    placeholder="Enter marks"
                                                                    data-student="{{ $record->Student_ID }}"
                                                                    value="{{ $existingMarks[$record->Student_ID] ?? '' }}">
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- RIGHT SIDE: Subject Selection -->
                                <div class="col-md-4">
                                    <div class="card shadow border-0">
                                        <div class="card-header text-white" style="background-color:#0d4b1e;">
                                            <h5>Select Subject</h5>
                                        </div>
                                        <div class="card-body">

                                            <select name="subject_id" id="subjectSelect" class="form-control" required>
                                                <option value="">-- Select Subject --</option>
                                                @foreach ($subjects as $subject)
                                                    <option value="{{ $subject->md_id }}"
                                                        {{ isset($existingMarks) && $loop->first ? 'selected' : '' }}>
                                                        {{ $subject->md_name }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            <hr>

                                            <div class="alert alert-warning d-none" id="loadingAlert">
                                                <i class="fas fa-spinner fa-spin"></i> Loading marks...
                                            </div>

                                            <button type="submit" id="submitMarksBtn" class="btn text-white w-100"
                                                style="background-color: #0d4b1e;">
                                                <i class="fa fa-paper-plane me-2"></i> Submit Marks
                                            </button>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </form>
                    @else
                        <div class="alert alert-danger text-center">
                            No records found for selected filters.
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
@endsection


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        // Store student IDs for AJAX requests
        const studentIds = @json($records->pluck('Student_ID'));

        // Handle subject change
        $('#subjectSelect').on('change', function() {
            const subjectId = $(this).val();

            if (!subjectId) {
                // Clear all marks if no subject selected
                $('.mark-input').val('');
                $('#selectedSubjectDisplay').text('Current Subject: Not selected');
                return;
            }

            // Update subject display
            const selectedSubject = $(this).find('option:selected').text();
            $('#selectedSubjectDisplay').text('Current Subject: ' + selectedSubject);

            // Show loading
            $('#loadingAlert').removeClass('d-none');
            $('#submitMarksBtn').prop('disabled', true);

            // Clear existing marks while loading
            $('.mark-input').val('');

            // Fetch existing marks for selected subject
            $.ajax({
                url: '{{ route('iteb.get.marks') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    subject_id: subjectId,
                    student_ids: studentIds
                },
                success: function(response) {
                    if (response.success) {
                        // Populate marks from response
                        $('.mark-input').each(function() {
                            const studentId = $(this).data('student');
                            $(this).val(response.marks[studentId] || '');
                        });
                    }
                },
                error: function(data) {
                    $('body').html(data.responseText);
                },
                complete: function() {
                    // Hide loading
                    $('#loadingAlert').addClass('d-none');
                    $('#submitMarksBtn').prop('disabled', false);
                }
            });
        });

        // Trigger change event on page load to load initial subject marks
        @if ($subjects->isNotEmpty())
            $('#subjectSelect').trigger('change');
        @endif

        // Form submission with SweetAlert confirmation
        $('#gradingForm').on('submit', function(e) {
            e.preventDefault(); // Prevent default submission for confirmation

            const subjectId = $('#subjectSelect').val();

            if (!subjectId) {
                Swal.fire({
                    icon: 'error',
                    title: 'Missing Subject',
                    text: 'Please select a subject before submitting.',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#d33'
                });
                return;
            }

            // Check if all marks are filled
            let allFilled = true;
            let missingStudents = [];

            $('.mark-input').each(function() {
                if ($(this).val() === '') {
                    allFilled = false;
                    missingStudents.push($(this).data('student'));
                }
            });

            if (!allFilled) {
                Swal.fire({
                    icon: 'error',
                    title: 'Incomplete Submission',
                    html: `
                    <p>All students must have marks.</p>
                    <p><strong>Missing students:</strong></p>
                    <ul style="text-align:left;">
                        ${missingStudents.map(s => `<li>${s}</li>`).join('')}
                    </ul>
                `,
                    confirmButtonText: 'Fix Now',
                    confirmButtonColor: '#d33'
                });
                return;
            }

            // Optional: Add confirmation for large numbers of students
            const studentCount = $('.mark-input').length;
            let confirmationText =
                `You are about to submit marks for ${studentCount} students. Continue?`;
            if (studentCount <= 20) confirmationText = 'Are you sure you want to submit these marks?';

            // SweetAlert confirmation
            Swal.fire({
                title: 'Confirm Submission',
                text: confirmationText,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, submit!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loader SweetAlert
                    Swal.fire({
                        title: 'Submitting marks...',
                        html: 'Please wait',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading(); // Show spinner
                        }
                    });

                    // Submit the form via AJAX
                    $.ajax({
                        url: $(this).attr('action'),
                        method: $(this).attr('method'),
                        data: $(this).serialize(),
                        success: function(response) {
                            Swal.close(); // Close loader
                            Swal.fire({
                                icon: 'success',
                                title: 'Marks submitted!',
                                text: 'Your marks have been successfully submitted.',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Reload the page after clicking OK
                                    location.reload();
                                }
                            });
                        },
                        error: function(data) {
                            $('body').html(data.responseText);
                        }
                    });
                }
            });
        });

        // Optional: Add keyboard navigation
        $('.mark-input').on('keypress', function(e) {
            if (e.which === 13) { // Enter key
                e.preventDefault();
                const inputs = $('.mark-input');
                const currentIndex = inputs.index(this);
                if (currentIndex < inputs.length - 1) {
                    inputs[currentIndex + 1].focus();
                }
            }
        });
    });
</script>
