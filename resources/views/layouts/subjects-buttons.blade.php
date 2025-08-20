<div class="row w-100 g-2">
    <div class="col-12 col-sm-4 mb-2">
        <a href="{{ route('students.search') }}" class="btn btn-white text-dark w-100">
            <i class="fas fa-search me-2"></i> Search Student
        </a>
    </div>
    <div class="col-12 col-sm-4 mb-2">
        <a href="{{ route('student.dashboard') }}" class="btn btn-success w-100">
            <i class="fas fa-user-plus me-2"></i> Add Students
        </a>
    </div>
    <div class="col-12 col-sm-4 mb-2">
        <a href="{{ route('students.update.profile') }}" class="btn btn-warning w-100">
            <i class="fas fa-user-edit me-2"></i> Update Profiles
        </a>
    </div>
    <div class="col-12 col-sm-4 mb-2">
        <a href="{{ route('students.update.photo') }}" class="btn btn-secondary w-100">
            <i class="fas fa-camera me-2"></i> Update Photos
        </a>
    </div>
    <div class="col-12 col-sm-4 mb-2">
        <a href="{{ route('students.transfer') }}" class="btn btn-dark w-100">
            <i class="fas fa-exchange-alt me-2"></i> Move Students
        </a>
    </div>
    <div class="col-12 col-sm-4 mb-2">
        <a href="{{ route('students.upload.fees') }}" class="btn btn-info w-100">
            <i class="fas fa-file-upload me-2"></i> Upload Fees Balance
        </a>
    </div>
</div>
