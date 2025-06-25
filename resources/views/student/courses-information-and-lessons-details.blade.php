<!DOCTYPE html>
<html lang="en">

<head>
    <title>Smart Schools</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet" />

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />

    <link rel="stylesheet" href="/assets007/css/animate.css" />

    <link rel="stylesheet" href="/assets007/css/owl.carousel.min.css" />
    <link rel="stylesheet" href="/assets007/css/owl.theme.default.min.css" />
    <link rel="stylesheet" href="/assets007/css/magnific-popup.css" />

    <link rel="stylesheet" href="/assets007/css/bootstrap-datepicker.css" />
    <link rel="stylesheet" href="/assets007/css/jquery.timepicker.css" />

    <link rel="icon" href="{{ URL::asset('assets/images/brand/favicon.ico') }}" type="image/x-icon" />
    <link rel="stylesheet" href="/assets007/css/style.css" />

    <style>
        .navbar {
            background-color: #004080 !important;
        }

        .navbar-brand {
            color: #ffffff !important;
            font-weight: bold;
            font-size: 1.5rem;
        }

        .navbar-brand span {
            color: #00bfff;
        }

        .navbar-nav .nav-link {
            color: #ffffff !important;
            margin: 0 0.5rem;
            transition: color 0.3s, background-color 0.3s;
            border-radius: 4px;
            padding: 8px 12px;
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-item.active .nav-link {
            background-color: #00bfff !important;
            color: #003366 !important;
        }

        .navbar-toggler {
            border-color: #ffffff;
        }

        .navbar-toggler .oi {
            color: #ffffff;
        }

        @media (max-width: 991.98px) {
            .navbar-collapse {
                background-color: #004080;
                padding: 1rem;
            }
        }
    </style>



</head>

<body>

    <?php
    use App\Http\Controllers\Helper;
    use App\Http\Controllers\Controller;
    $controller = new Controller();
    ?>

    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
        <div class="container">
            <a class="navbar-brand" href="{{ url('users/home-page') }}">
                <span>Ugandan</span> Programmer
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav"
                aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="oi oi-menu"></span> Menu
            </button>

            <div class="collapse navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a href="{{ url('users/home-page') }}" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item active">
                        <a href="#home" class="nav-link">Course Information</a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ url('/users/login') }}" class="nav-link">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <section class="ftco-section bg-light" id="courses">
        <div class="container">
            <!-- Course Header -->
            <div class="row justify-content-center pb-4">
                <div class="main-profile w-100">
                    <div class="row">
                        <!-- Course Image & Info -->
                        <div class="col-lg-12 mb-4">
                            <div class="box-widget widget-user p-3 bg-white shadow-sm rounded">
                                <div class="widget-user-image d-flex flex-wrap">
                                    <div class="text-center w-100 w-sm-50 mb-3 mb-sm-0">
                                        <img src="{{ $course->thumbnail ? asset('storage/' . $course->thumbnail) : asset('assets/images/products/default.jpg') }}"
                                            alt="Course Thumbnail" class="img-fluid rounded w-100">
                                    </div>
                                    <div class="ml-sm-4 mt-3">
                                        <h4 class="font-weight-bold mb-3">{{ $course->title }}</h4>

                                        <!-- Instructor Info -->
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fa fa-user text-primary mr-2"></i>
                                            <div>{{ Helper::item_md_name($course->instructor_id) }} <span
                                                    class="text-muted">(Instructor)</span></div>
                                        </div>

                                        <!-- Email -->
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fa fa-envelope text-danger mr-2"></i>
                                            <div>ugandanprogrammer137@gmail.com</div>
                                        </div>

                                        <!-- Phone -->
                                        <div class="d-flex align-items-center mb-3">
                                            <i class="fa fa-phone text-success mr-2"></i>
                                            <div>+256 702 082 209</div>
                                        </div>

                                        <!-- Pricing -->
                                        <p class="mb-0">
                                            <span class="text-danger font-weight-bold"
                                                style="text-decoration: line-through;">
                                                Ugx{{ $course->old_price }}
                                            </span>
                                            <span class="font-weight-bold text-dark ml-2 fs-4">
                                                Ugx{{ $course->selling_price }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabs Section -->
                    <div class="profile-cover mt-4">
                        <div class="wideget-user-tab">
                            <div class="tab-menu-heading p-0 bg-white rounded-top shadow-sm">
                                <div class="tabs-menu1 px-3">
                                    <ul class="nav nav-tabs">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#tab-7">
                                                <i class="fas fa-chart-pie mr-1"></i> Overview
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#tab-8">
                                                <i class="fas fa-book-open mr-1"></i> Curriculum
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Tabs Content -->
                            <div class="tab-content bg-white p-4 shadow-sm rounded-bottom">
                                <!-- Overview Tab -->
                                <div class="tab-pane fade show active" id="tab-7">
                                    <div class="row">
                                        <!-- Course Overview -->
                                        <div class="col-md-6 mb-4">
                                            <h5 class="font-weight-bold mb-3">Course Overview</h5>
                                            <p class="text-justify">
                                                This course is designed to provide a flexible and interactive learning
                                                experience through our advanced e-learning platform. Whether you're a
                                                beginner or looking to enhance existing skills, you'll find engaging
                                                content tailored to your pace and goals.
                                            </p>
                                            <p class="text-justify">
                                                With expertly curated modules, real-world case studies, and hands-on
                                                exercises, you’ll gain practical knowledge that can be immediately
                                                applied. Our platform ensures 24/7 access, allowing you to study
                                                anytime, anywhere.
                                            </p>
                                            <p class="mb-0">
                                                Join a community of learners and take control of your education journey.
                                            </p>
                                        </div>


                                        @php
                                            $coursez = (object) [
                                                'lessons_count' => 5,
                                                'quizzes_count' => 3,
                                                'difficulty' => 'beginner',
                                            ];

                                            $formattedFollowers = number_format(rand(100, 2000));
                                        @endphp

                                        <div class="col-md-6">
                                            <h5 class="font-weight-bold mb-3">Course Features</h5>
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item d-flex justify-content-between">
                                                    <span><i class="fas fa-file-alt mr-2"></i> Lessons</span>
                                                    <span>{{ $coursez->lessons_count ?? 0 }}</span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between">
                                                    <span><i class="fas fa-question-circle mr-2"></i> Quizzes</span>
                                                    <span>{{ $coursez->quizzes_count ?? 0 }}</span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between">
                                                    <span><i class="fas fa-clock mr-2"></i> Duration</span>
                                                    <span>Flexible</span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between">
                                                    <span><i class="fas fa-signal mr-2"></i> Skill Level</span>
                                                    <span>{{ ucfirst($course->difficulty) }}</span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between">
                                                    <span><i class="fas fa-language mr-2"></i> Language</span>
                                                    <span>{{ Helper::item_md_name($course->language) }}</span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between">
                                                    <span><i class="fas fa-users mr-2"></i> Students</span>
                                                    <span>{{ $formattedFollowers }}</span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between">
                                                    <span><i class="fas fa-certificate mr-2"></i> Certificate</span>
                                                    <span>Yes</span>
                                                </li>
                                            </ul>
                                        </div>

                                    </div>
                                </div>

                                <div class="tab-pane fade" id="tab-8">
                                    <div class="accordion" id="courseModulesAccordion">
                                        @forelse ($course->modules as $index => $module)
                                            <div class="card mb-2">
                                                <div class="card-header bg-white"
                                                    id="moduleHeading{{ $index }}">
                                                    <h5 class="mb-0">
                                                        <button
                                                            class="btn btn-link text-left w-100 d-flex justify-content-between"
                                                            data-toggle="collapse"
                                                            data-target="#moduleCollapse{{ $index }}"
                                                            aria-expanded="false"
                                                            aria-controls="moduleCollapse{{ $index }}">
                                                            <span>
                                                                <i class="fa fa-folder text-primary mr-2"></i>
                                                                {{ $module->title }}
                                                                <small
                                                                    class="text-muted">({{ $module->lessons->count() }}
                                                                    lessons)</small>
                                                            </span>
                                                            <i class="fa fa-chevron-down"></i>
                                                        </button>
                                                    </h5>
                                                </div>
                                                <div id="moduleCollapse{{ $index }}" class="collapse"
                                                    aria-labelledby="moduleHeading{{ $index }}"
                                                    data-parent="#courseModulesAccordion">
                                                    <div class="card-body">
                                                        @if ($module->lessons->count())
                                                            <ul class="list-group list-group-flush">
                                                                @foreach ($module->lessons as $lesson)
                                                                    <li
                                                                        class="list-group-item d-flex align-items-center">
                                                                        <i
                                                                            class="fa fa-play-circle text-success mr-2"></i>
                                                                        {{ $lesson->title }}
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @else
                                                            <p class="text-muted">No lessons added to this module yet.
                                                            </p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <p class="text-muted">No curriculum available.</p>
                                        @endforelse
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="ftco-loader" class="show fullscreen">
            <svg class="circular" width="48px" height="48px">
                <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4"
                    stroke="#eeeeee" />
                <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4"
                    stroke="#F96D00" />
            </svg>
        </div>
    </section>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        integrity="sha512-yH5A1bHH1wD0Yz7hzKILnEMWlfYug8zTWQKvZVGWlqMgOX3DUr2CChXWTZQoOJqpbKnTgIgZRlgSU2Qg+Kz+3A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


    <script src="/assets007/js/jquery.min.js"></script>
    <script src="/assets007/js/jquery-migrate-3.0.1.min.js"></script>
    <script src="/assets007/js/popper.min.js"></script>
    <script src="/assets007/js/bootstrap.min.js"></script>
    <script src="/assets007/js/jquery.easing.1.3.js"></script>
    <script src="/assets007/js/jquery.waypoints.min.js"></script>
    <script src="/assets007/js/jquery.stellar.min.js"></script>
    <script src="/assets007/js/owl.carousel.min.js"></script>
    <script src="/assets007/js/jquery.magnific-popup.min.js"></script>
    <script src="/assets007/js/jquery.animateNumber.min.js"></script>
    <script src="/assets007/js/bootstrap-datepicker.js"></script>
    <script src="/assets007/js/scrollax.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
    <script src="/assets007/js/google-map.js"></script>
    <script src="/assets007/js/main.js"></script>
</body>

</html>
