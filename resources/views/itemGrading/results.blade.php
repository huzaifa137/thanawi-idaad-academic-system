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

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {

                            @if (session('success'))
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: @json(session('success')),
                                    confirmButtonColor: '#3085d6'
                                });
                            @endif

                            @if ($errors->any())
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Validation Error',
                                    html: `{!! implode('<br>', $errors->all()) !!}`,
                                    confirmButtonColor: '#d33'
                                });
                            @endif

                        });
                    </script>

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
                                                    Current Subject:
                                                    @if (old('subject_id'))
                                                        {{ $subjects->firstWhere('md_id', old('subject_id'))->md_name ?? 'Not selected' }}
                                                    @elseif(isset($selectedSubjectId))
                                                        {{ $subjects->firstWhere('md_id', $selectedSubjectId)->md_name ?? 'Not selected' }}
                                                    @else
                                                        Not selected
                                                    @endif
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
                                                                    class="form-control mark-input @error('marks.' . $record->Student_ID) is-invalid @enderror"
                                                                    placeholder="Enter marks"
                                                                    data-student="{{ $record->Student_ID }}"
                                                                    value="{{ old('marks.' . $record->Student_ID, $existingMarks[$record->Student_ID] ?? '') }}">
                                                                @error('marks.' . $record->Student_ID)
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
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

                                            <select name="subject_id" id="subjectSelect"
                                                class="form-control @error('subject_id') is-invalid @enderror" required>
                                                <option value="">-- Select Subject --</option>
                                                @foreach ($subjects as $subject)
                                                    <option value="{{ $subject->md_id }}"
                                                        {{ old('subject_id', $selectedSubjectId ?? '') == $subject->md_id ? 'selected' : '' }}>
                                                        {{ $subject->md_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('subject_id')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror

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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        // Store student IDs for AJAX requests
        const studentIds = @json($records->pluck('Student_ID'));

        // Check if we have old subject selection
        const oldSubjectId = @json(old('subject_id'));
        const hasErrors = @json($errors->any());

        // Function to load marks for a subject
        function loadMarksForSubject(subjectId) {
            if (!subjectId) {
                // Clear all marks if no subject selected
                $('.mark-input').val('');
                $('#selectedSubjectDisplay').text('Current Subject: Not selected');
                return;
            }

            // Update subject display
            const selectedSubject = $('#subjectSelect option:selected').text();
            $('#selectedSubjectDisplay').text('Current Subject: ' + selectedSubject);

            // Only fetch marks via AJAX if there are no old inputs and no errors
            // This prevents overwriting old values with existing marks from database
            if (!hasErrors && !oldSubjectId) {
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
                        console.error('Error loading marks:', data);
                    },
                    complete: function() {
                        // Hide loading
                        $('#loadingAlert').addClass('d-none');
                        $('#submitMarksBtn').prop('disabled', false);
                    }
                });
            }
        }

        // Handle subject change
        $('#subjectSelect').on('change', function() {
            const subjectId = $(this).val();
            loadMarksForSubject(subjectId);
        });

        // On page load, if there's an old subject or selected subject, load appropriate marks
        @if ($subjects->isNotEmpty())
            // If there's an old subject (from validation error), use that
            @if (old('subject_id'))
                $('#subjectSelect').val('{{ old('subject_id') }}');
                loadMarksForSubject('{{ old('subject_id') }}');
            @elseif (isset($selectedSubjectId))
                // Otherwise use the selected subject from controller
                $('#subjectSelect').val('{{ $selectedSubjectId }}');
                loadMarksForSubject('{{ $selectedSubjectId }}');
            @endif
        @endif

        // AUTO-TAB FUNCTIONALITY: Move to next input after entering 2 digits
        $('.mark-input').on('input', function() {
            // Get current value
            let currentValue = $(this).val();

            // Remove any non-numeric characters
            currentValue = currentValue.replace(/[^0-9]/g, '');

            // Limit to 2 digits
            if (currentValue.length > 2) {
                currentValue = currentValue.slice(0, 2);
            }

            // Update input value
            $(this).val(currentValue);

            // If we have 2 digits, move to next input
            if (currentValue.length === 2) {
                const inputs = $('.mark-input');
                const currentIndex = inputs.index(this);

                // If not the last input, focus on next one
                if (currentIndex < inputs.length - 1) {
                    $(inputs[currentIndex + 1]).focus();
                }
            }
        });

        // Also handle keyup for backspace navigation (optional enhancement)
        $('.mark-input').on('keydown', function(e) {
            const inputs = $('.mark-input');
            const currentIndex = inputs.index(this);

            // If backspace is pressed and input is empty, move to previous input
            if (e.key === 'Backspace' && $(this).val().length === 0 && currentIndex > 0) {
                $(inputs[currentIndex - 1]).focus();
            }

            // If left arrow key is pressed, move to previous input
            if (e.key === 'ArrowLeft' && currentIndex > 0) {
                e.preventDefault();
                $(inputs[currentIndex - 1]).focus();
            }

            // If right arrow key is pressed, move to next input
            if (e.key === 'ArrowRight' && currentIndex < inputs.length - 1) {
                e.preventDefault();
                $(inputs[currentIndex + 1]).focus();
            }
        });

        // Prevent entering more than 2 digits via paste
        $('.mark-input').on('paste', function(e) {
            e.preventDefault();

            // Get pasted data
            let pastedData = (e.originalEvent.clipboardData || window.clipboardData).getData('text');

            // Remove non-numeric and limit to 2 digits
            pastedData = pastedData.replace(/[^0-9]/g, '').slice(0, 2);

            // Set the value
            $(this).val(pastedData);

            // If we have 2 digits, move to next input
            if (pastedData.length === 2) {
                const inputs = $('.mark-input');
                const currentIndex = inputs.index(this);

                if (currentIndex < inputs.length - 1) {
                    $(inputs[currentIndex + 1]).focus();
                }
            }
        });

        // Form submission with SweetAlert confirmation - WITH LOADING INDICATOR
        $('#gradingForm').on('submit', function(e) {
            const subjectId = $('#subjectSelect').val();

            if (!subjectId) {
                e.preventDefault(); // Prevent submission
                Swal.fire({
                    icon: 'error',
                    title: 'Missing Subject',
                    text: 'Please select a subject before submitting.',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#d33'
                });
                return false;
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
                e.preventDefault(); // Prevent submission
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
                return false;
            }

            // Check if all marks are exactly 2 digits
            let invalidMarks = [];
            $('.mark-input').each(function() {
                const mark = $(this).val();
                if (mark.length !== 2) {
                    invalidMarks.push($(this).data('student'));
                }
            });

            if (invalidMarks.length > 0) {
                e.preventDefault(); // Prevent submission
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Marks',
                    html: `
                    <p>All marks must be exactly 2 digits.</p>
                    <p><strong>Students with invalid marks:</strong></p>
                    <ul style="text-align:left;">
                        ${invalidMarks.map(s => `<li>${s}</li>`).join('')}
                    </ul>
                `,
                    confirmButtonText: 'Fix Now',
                    confirmButtonColor: '#d33'
                });
                return false;
            }

            // Optional: Add confirmation for large numbers of students
            const studentCount = $('.mark-input').length;

            // Show confirmation dialog
            e.preventDefault(); // Prevent default submission first

            Swal.fire({
                title: 'Confirm Submission',
                text: studentCount <= 20 ? 'Are you sure you want to submit these marks?' :
                    `You are about to submit marks for ${studentCount} students. Continue?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, submit!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading indicator
                    Swal.fire({
                        title: 'Submitting marks...',
                        html: 'Please wait',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading(); // Show spinner
                        }
                    });
                    
                    // Submit the form normally after a tiny delay to ensure Swal is shown
                    setTimeout(() => {
                        $('#gradingForm')[0].submit();
                    }, 100);
                }
            });

            return false; // Prevent default submission
        });

        // Optional: Add keyboard navigation with Enter key
        $('.mark-input').on('keypress', function(e) {
            if (e.which === 13) { // Enter key
                e.preventDefault();
                const inputs = $('.mark-input');
                const currentIndex = inputs.index(this);
                if (currentIndex < inputs.length - 1) {
                    $(inputs[currentIndex + 1]).focus();
                }
            }
        });
    });
</script>
