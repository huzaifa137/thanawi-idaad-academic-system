<?php

use App\Http\Controllers\MasterDataController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ClassandSubjectController;
use App\Http\Controllers\UserRightsAndPreviledges;
use App\Mail\userMail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */


Route::get('/send-test-mail', function () {
    Mail::to('youremail@example.com')->send(new userMail());
    return 'Email sent!';
});

Route::controller(UserController::class)->group(function () {

    Route::group(['prefix' => '/users'], function () {

        Route::get('/user-logout', 'userLogout')->name('user-logout');
        Route::get('/student-logout', 'studentLogout')->name('student-logout');

        Route::group(['middleware' => ['AdminAuth']], function () {
            Route::get('/forgot-password', 'forgotPassword')->name('forgot-password');
            Route::get('/login', 'login')->name('users.login');
            Route::get('/', 'login')->name('admin.dashboard');
            Route::post('auth-user-check', 'checkUser')->name('auth-user-check');
            Route::get('/users-profile', 'userProfile')->name('users-profile');
            Route::get('/users-register', 'userRegister');
            Route::get('/users-information', 'userInformation')->name('users.user-information');
            Route::get('user-account-information/{id}', 'userAccountInformation');
            Route::get('/home-page', 'homePage')->name('home.page');
            Route::get('/register', 'register')->name('users.register');
            Route::get('/edit-user-information', 'editUserInformation');
            Route::get('/edit-specific-user/{userid}', 'editSpecificUser');
            Route::get('/terms-and-conditions', 'user_terms_and_conditions')->name('users.terms-and-conditions');
        });

        Route::post('auth-user-selected-school', 'authUserSelectedSchool')->name('auth-user-selected-school');
        Route::post('store-internal-user', 'storeInternalUser')->name('store-internal-user');
        Route::post('update-internal-user', 'storeUpdatedInternalUser')->name('update-internal-user');
        Route::post('save-role', 'saveUserRole')->name('save-role');
        Route::post('store-role-update', 'storeRoleUpdate')->name('store-role-update');
        Route::post('store-updated-information', 'storeUpdatedInformation')->name('store-updated-information');

    });

    Route::group(['middleware' => ['AdminAuth']], function () {
        Route::get('/', 'dashboard')->name('dashboard');
    });

    Route::get('password/reset/{id}', 'createNewPassword')->name('password/reset');
    Route::get('password/set-password/{id}', 'createFirstPassword')->name('password.FirstPassword');
    Route::post('auth.save', 'save')->name('auth.save');
    Route::post('regenerate-otp', 'regenerateOTP')->name('regenerate-otp');
    Route::post('user-generate-forgot-password-link', 'generateForgotPasswordLink')->name('user-generate-forgot-password-link');
    Route::post('user-store-new-password', 'store_new_password')->name('user-store-new-password');
    Route::post('user-store-first-password', 'store_first_password')->name('user-store-first-password');
    Route::post('supplier-user-otp-verification', 'supplierOtpVerification')->name('supplier-user-otp-verification');
    Route::get('reload-captcha', 'reload_captcha')->name('reload-captcha');
});

Route::controller(MasterDataController::class)->group(function () {

    Route::group(['prefix' => 'master-data'], function () {

        Route::get('master-code-to-data', 'masterCodeToData')->name('master-code-to-data');

        Route::get('/load-data', 'loadData')->name('load.data');
        Route::get('master-table', 'master_table')->name('master-table');
        Route::get('master-code', 'master_code')->name('master-code');
        Route::get('requisition-documents', 'requisitionDocuments');
        Route::get('travel-requisition-documents', 'travelRequisitionDocuments');
        Route::get('supplier-prequalification-criteria', 'supplierPrequalificationEvaluationCriteria');
        Route::post('store-prequalification-criteria', 'storePrequalificationCriteria')->name('store-prequalification-criteria');

        Route::get('edit-record/{id}', 'editRecord');
        Route::get('add-record', 'addRecord')->name('add-record');
        Route::get('add-code', 'addMasterCode')->name('add-code');
        Route::get('edit-code/{id}', 'editMasterCode');
        Route::get('master-code-list/{id}', 'masterCodeList')->name('master-code-list');
        Route::get('master-code-list', 'masterCodeList');
        Route::get('edit-supplier-document/{id}', 'editSupplierDocument');
        Route::post('/store-requisition-document', 'storeRequisitionDocument')->name('master-data/store-requisition-document');

    });

    Route::post('store-travel-requisition-document', 'storeTravelRequisitionDocument')->name('store-travel-requisition-document');
    Route::post('update-supplier-document', 'updateSupplierDocument')->name('update-supplier-document');
    Route::post('update-master-record', 'updateMasterrecord')->name('update-master-record');
    Route::post('update-master-code', 'updateMasterCode')->name('update-master-code');
    Route::post('send-master-code', 'sendMasterCode')->name('send-master-code');
    Route::post('add-new-record', 'addNewRecord')->name('add-new-record');

    Route::get('delete-supplier-document/{id}', 'deleteSupplierDocument');
    Route::get('delete-record/{id}', 'deleteRecord');
    Route::get('delete-code/{id}', 'deleteCode');

});

Route::controller(StudentController::class)->group(function () {

    Route::group(['prefix' => '/users'], function () {
        Route::group(['middleware' => ['AdminAuth']], function () {

            Route::get('/register', 'register')->name('users.register');
            Route::get('/terms-and-conditions', 'user_terms_and_conditions')->name('users.terms-and-conditions');
            Route::get('/user-otp', function () {
                $userId = session('userId');
                $userEmail = session('userEmail');
                $userPassword = session('userPassword');

                if (!$userId || !$userEmail) {
                    return redirect()->route('users.login')->with('fail', 'You must be logged in');
                }

                return view('users.otp', compact(['userId', 'userEmail', 'userPassword']));
            });
        });

        Route::post('user-account-creation', 'userAccountCreation')->name('user-account-creation');
        Route::post('contact-message-information', 'contactMessageInformation')->name('contact-message-information');

    });
    Route::get('/clear-session', 'flushSession');
});

Route::controller(StudentController::class)->group(function () {

    Route::group(['middleware' => ['StudentAuth']], function () {

        Route::group(['prefix' => '/student'], function () {

            Route::get('/dashboard', 'studentDashboard')->name('student.dashboard');
            Route::get('/profile', 'studentProfile')->name('student.profile');
            Route::get('/edit-student-profile', 'editStudentProfile');
            Route::get('/courses-and-lessons', 'coursesAndLessons')->name('student.courses.lessons');
            Route::get('/lessons-and-study', 'lessonsAndStudy')->name('student.lesson.study');
            Route::get('/cart', 'addCart')->name('student.cart');
            Route::get('/cart/remove/{id}', 'removeCart')->name('cart.remove');
            Route::get('/checkout', 'checkout')->name('student.checkout');
            Route::get('/courses/filter', 'filterCourses')->name('student.courses.filter');
            Route::get('/course-details/{id}', 'courseDetails')->name('course.details');
            Route::get('/course-study/{id}', 'courseStudy')->name('course.study');
            Route::get('/ongoing-lesson/{id}', 'lessonStudying')->name('lesson.ongoing');
            Route::get('/lesson-details/{id}', 'showLesson')->name('student.lessons.details');
            Route::get('/show/{quiz}', 'showQuizForm')->name('student.quizzes.show');
            Route::get('/all-preview', 'previewAllCertificates')->name('certificates.all');
            Route::get('/{course}/certificate/download', 'download')->name('certificate.download');
            Route::get('/contact-us', 'contactUs')->name('contact.us');

            Route::post('/submit-message', 'submitMesage')->name('student.submit.message');
            Route::post('/{lesson}/complete', 'lessonComplete')->name('student.lessons.complete');
            Route::post('/{quiz}/submit', 'submitQuiz')->name('student.quizzes.submit');
            Route::post('/checkout-process', 'processCheckout')->name('checkout.process');
            Route::post('/add-to-cart/{id}', 'addToCartAction')->name('student.add.cart');
            Route::post('/enroll-course-cart-action/{id}', 'enrollCourseCartAction')->name('student.enroll.course.action');
            Route::post('/cart/update-quantity', 'updateQuantity')->name('cart.updateQuantity');
        });
    });

    Route::get('/select-current-school', 'selectCurrentSchool')->name('select.current.school');

    Route::get('/student/view-course-information/{id}', 'viewCourseInformation')->name('view.course.information');

});

Route::controller(SchoolController::class)->group(function () {

    Route::get('create-school', 'createSchool')->name('school.create-school');
    Route::get('term-dates/{schoolId}', 'termDates')->name('school.term-dates');
    Route::get('all-schools', 'allSchools')->name('school.allSchools');
    Route::get('/edit-school/{id}/', 'editSchool')->name('edit.school');
    Route::get('/school-profile', 'schoolProfile')->name('profile.school');
    Route::get('/school-individual-profile/{id}', 'schoolIndividualProfile')->name('profile.individual.school');
    Route::get('/school-options/{id}/', 'schoolOptions')->name('school.options');

    Route::delete('/school/{schoolId}', 'deleteSchool')->name('school.delete');

    Route::post('/create/new/schools/', 'createNewSchool')->name('create.new-school');
    Route::post('/update-school', 'updateSchool')->name('update.school');
    Route::post('/store-school-profile', 'storeSchoolProfile')->name('schools.store.profile');
    Route::post('/school/configure', 'configureSchoolOptions')->name('school.configure');
    Route::post('/schools/{id}/change-status', 'changeStatus');

    Route::get('admin-user', 'adminUser')->name('admin.user');
    Route::get('student-user', 'studentUser')->name('student.user');

    Route::get('/add-academic-year', 'addAcademicYear')->name('add-academic-year');
    Route::post('/academic-years', 'storeYear')->name('academic-years.store');

    Route::patch('/academic-years/{id}/activate', 'activate')->name('academic-years.activate');
    Route::patch('/academic-years/{id}/deactivate', 'deactivate')->name('academic-years.deactivate');

    Route::delete('/academic-years/{id}', 'destroy')->name('academic-years.destroy');
    Route::put('/academic-years/{id}', 'updateYear')->name('academic-years.update');

    Route::delete('/academic-years/{id}', 'destroyTerm')->name('academic-years.destroy');
    Route::post('/store-term-dates', 'storeTermDate')->name('term-dates.store');
    Route::post('/select-school', 'selectSchool')->name('school.select');

});

Route::controller(TeacherController::class)->group(function () {


    Route::get('add-teachers', 'addTeachers')->name('school.add-teachers');
    Route::get('/teachers', 'allTeachers')->name('teachers.all');
    Route::get('/school-teachers', 'schoolTeachers')->name('school.teachers');
    Route::get('/individual-school-teachers/{id}', 'individualSchoolTeachers')->name('individual.school.teachers');
    Route::get('/teacher-profile/{id}', 'teacherProfile')->name('teacher.profile');
    Route::get('/update-teacher-profile/{id}', 'updateteacherProfile')->name('update.teacher.profile');

    Route::post('/store-teachers', 'storeTeacher')->name('teachers.store');
    Route::post('/teachers/update/{teacher}', 'storeUpdatedTeacherProfile')->name('teachers.update');

    Route::delete('/teachers/{id}', 'destroyTeacher')->name('teachers.destroy');

});

Route::controller(ClassandSubjectController::class)->group(function () {

    Route::get('create-class', 'createClass')->name('school.create-class');
    Route::get('manage-classes', 'manageClasses')->name('manage.classes');
    Route::get('manage-class-streams/{id}', 'manageClassStreams')->name('manage.class.streams');
    Route::get('/class-stream-subjects/{classId}/{streamId}', 'attachedStreamSubjects')->name('class.stream.subjects');
    Route::get('edit-class-subjects', 'editClassSubjects')->name('school.edit-class-subject');

    Route::post('/schools/class/store', 'storeClass')->name('schools.class-store');
    Route::post('/assign-class-supervisor', 'assignSupervisor')->name('class.assignSupervisor');
    Route::post('/remove-class-supervisor', 'removeSupervisor')->name('class.removeSupervisor');
    Route::post('/remove-class-teacher', 'removeClassTeacher')->name('class.removeClassTeacher');
    Route::post('/assign-class-teacher', 'assignClassTeacher')->name('class.assignClassTeacher');

    Route::delete('/streams/{stream}', 'deleteStream')->name('streams.delete');


    // Route to display the edit form for a specific assignment
    // Route::get('/assign-subjects/{assignmentId}/edit', [ClassandSubjectController::class, 'edit'])->name('assign.subjects.edit');

    // // Route to handle the update submission for a specific assignment
    // Route::put('/assign-subjects/{assignmentId}', [ClassandSubjectController::class, 'update'])->name('assign.subjects.update');


    Route::post('/assign-class-subject-teacher-one', 'assignSubjectTeacher1')->name('class.assignSubjectTeacher1');
    Route::post('/remove-class-subject-teacher-one', 'removeSubjectTeacher1')->name('class.removeSubjectTeacher1');

    Route::post('/assign-class-subject-teacher-two', 'assignSubjectTeacher2')->name('class.assignSubjectTeacher2');
    Route::post('/remove-class-subject-teacher-two', 'removeSubjectTeacher2')->name('class.removeSubjectTeacher2');
});


Route::controller(UserRightsAndPreviledges::class)->group(function () {

    Route::group(['middleware' => ['StudentAuth']], function () {
        Route::group(['prefix' => '/user-rights-and-previledges'], function () {

            Route::get('/setup', 'setup')->name('all.roles.setup');
            Route::get('/all-roles', 'allRoles')->name('all.users.roles');
            Route::get('/all-permissions', 'allPermissions')->name('all.users.permissions');
            Route::get('/assign-permissions', 'assignPermissions')->name('assign.users.permissions');

            Route::get('add-users', 'addUsers')->name('add-users');
        });

        // routes/web.php

        Route::post('/roles/add-user', 'addUserToRole')->name('roles.add-user');
        Route::post('/roles/remove-user', 'deleteUserFromRole')->name('roles.removeUser');

        Route::get('/users/{id}/details', 'getUserDetails');
        Route::get('/roles/{id}', 'editRole');
        Route::put('/roles/{id}', 'updateRole');

        Route::post('/store-role', 'storeRole')->name('store.role');
        Route::post('/store-permission-role', 'storePermissionRole')->name('store.permission.role');
        Route::post('/permissions/store-multiple', 'storeMultiplePermissions')
            ->name('store.multiple.permissions');

        Route::delete('/roles/{id}', 'deleteRole');
        Route::delete('/permissions/delete', 'destroyGroup')->name('permissions.delete');
        Route::delete('/user/{userId}', 'deleteUser')->name('user.delete');

        Route::post('/assign-permissions/{roleId}', 'storeRolePermissions')->name('storeRolePermissions');
        Route::post('/remove-permissions/{roleId}/remove', 'removePermission');
        Route::post('/assign-user-to-role', 'assignUserToRole')->name('assignUserToRole');
        Route::post('/remove-user-from-role', 'removeUserFromRole')->name('removeUserFromRole');

        Route::post('/store-new-user', 'storeNewUser')->name('users.store.new.user');
        Route::post('/update-user-information', 'updateUserInformation')->name('users.update.information');
        Route::post('/users/{id}/change-status', 'changeStatus');

    });


    Route::controller(StudentController::class)->prefix('students')->group(function () {

        Route::get('students-dashboard', 'studentPortal')->name('student.dashboard');
        Route::get('update-profile', action: 'updateProfiles')->name('students.update.profile');
        // Route::get('update-photo', 'updatePhoto')->name('students.update.photo');
        // Route::post('upload-fees', 'uploadFees')->name('students.upload.fees');
        Route::get('/search', 'searchStudent')->name('students.individual.search');
        Route::get('/search/ajax', 'searchAjax')->name('students.search.ajax');

        Route::get('/students/{student}/edit', 'edit')->name('students.edit');

        Route::get('/Information/{id}', 'showStudentInformation');
        Route::put('/update/{id}', 'updateStudentInformation');
        Route::post('/students/store', 'storeStudent')->name('students.store');

        Route::get('/transfer-form', 'moveStudentForm')->name('students.transfer');

        Route::get('/streams/by-class', 'getStreamsByClass')->name('streams.by.class');
        Route::get('/students/search', 'searchStudentsByClassStream')->name('students.search');
        Route::post('/students/move', 'moveStudent')->name('students.move');

    });

    Route::controller(SubjectController::class)->prefix('students')->group(function () {
        Route::get('subjects-dashboard', 'subjectDashboard')->name('subjects.dashboard');

    });
});