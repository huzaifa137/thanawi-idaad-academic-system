<div class="app-sidebar app-sidebar2">
    <div class="app-sidebar__logo" style="height: 155px; padding: 50px 10px;">
        <a class="header-brand" href="{{ url('/student/dashboard') }}">
            <img src="{{ URL::asset('assets/images/brand/uplogolight.png') }}" alt="Covido logo"
                style="height: 90px; width: auto;">
        </a>
    </div>
</div>

<?php
use App\Helpers\PermissionHelper;
?>

<aside class="app-sidebar app-sidebar3">
    <ul class="side-menu" style="margin-top:100px !important;">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

        <li class="slide">
            <a class="side-menu__item" href="{{ url('/student/dashboard') }}">
                <i class="fa fa-home fa-2x mr-3"></i>
                Dashboard </span></a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="{{ route('school.allSchools') }}">
                <i class="fa fa-school fa-2x mr-3"></i>
                Schools
            </a>
        </li>

        {{-- <li class="slide">
            <a class="side-menu__item" href="{{ route('school.teachers') }}">
                <i class="fa fa-user-tie fa-2x mr-3"></i>
                Teachers
            </a>
        </li> --}}

        <li class="slide">
            <a class="side-menu__item" href="{{ route('students.individual.search') }}">
                <i class="fa fa-user-graduate fa-2x mr-3"></i>
                Students
            </a>
        </li>

        {{-- <li class="slide">
            <a class="side-menu__item" href="{{ url('/user-rights-and-previledges/setup') }}">
                <i class="fas fa-user-shield fa-2x mr-3"></i>
                Rights & Previledges
            </a>
        </li> --}}

        {{-- <li class="slide">
            <a class="side-menu__item" href="{{ route('all.specific.students') }}">
                <i class="fa fa-scroll fa-2x mr-3"></i>
                Exams
            </a>
        </li> --}}

        {{-- Original Grading with uploading exam to be uploaded --}}

        {{-- <li class="slide">
            <a class="side-menu__item" href="{{ route('create.examination') }}">
                <i class="fas fa-balance-scale-right fa-2x mr-3"></i>
                Grading
            </a>
        </li> --}}

        <li class="slide">
            <a class="side-menu__item" href="{{  url('/search-iteb-students')  }}">
                <i class="fas fa-balance-scale-right fa-2x mr-3"></i>
                Grading & Marks
            </a>
        </li>

        <style>
            .sub-menu {
                display: none;
                padding-left: 40px;
            }

            .slide.active>.sub-menu {
                display: block;
            }

            .has-sub>a {
                cursor: pointer;
            }
        </style>


        <li class="slide">
            <a class="side-menu__item" href="#" id="logoutMenu">
                <i class="fa fa-sign-out fa-2x mr-3"></i>
                Logout
            </a>
        </li>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script>
            $(document).ready(function() {
                $('#helpSupportToggle').on('click', function(e) {
                    e.preventDefault();
                    $(this).parent('.slide').toggleClass('active');
                });
            });
        </script>

        <script>
            document.getElementById('logoutMenu').addEventListener('click', function(event) {
                event.preventDefault();

                Swal.fire({
                    title: "Are you sure?",
                    text: "Do you really want to Logout ?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, Logout",
                    cancelButtonText: "Cancel",
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '{{ route('student-logout') }}';
                    }
                });

            });
        </script>
    </ul>
</aside>
<!--aside closed-->
