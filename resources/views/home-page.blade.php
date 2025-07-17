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
        input::placeholder,
        textarea::placeholder {
            color: #888;
            opacity: 1;
        }

        .form-control::placeholder {
            color: #888;
            opacity: 1;
        }

        .block-23 ul li a {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .block-23 ul li a .icon {
            min-width: 20px;
            text-align: center;
            font-size: 18px;
            color: #000;
        }

        .block-23 ul li a .text {
            display: inline-block;
        }

        .user-img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-size: cover;
            background-position: center;
            flex-shrink: 0;
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

            <a href="{{ url('users/home-page') }}">
                <img src="{{ asset('assets007/images/logo_no_bg.png') }}" alt="Smart Schools Logo"
                    style="height: 5rem;">
            </a>


            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav"
                aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="oi oi-menu"></span> Menu
            </button>

            <div class="collapse navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a href="#home" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="#about" class="nav-link">About</a>
                    </li>
                    <li class="nav-item">
                        <a href="#courses" class="nav-link">Courses</a>
                    </li>
                    <li class="nav-item">
                        <a href="#testimony" class="nav-link">Testimonials</a>
                    </li>
                    <li class="nav-item">
                        <a href="#contact" class="nav-link">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/users/login') }}" class="nav-link">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- END nav -->

    <div class="hero-wrap js-fullheight" style="background-image: url('/assets007/images/bg_3.jpg')" id="home">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text js-fullheight align-items-center" data-scrollax-parent="true">
                <div class="col-md-7 ftco-animate">
                    <span class="subheading">Welcome to Smart Schools</span>
                    <h1 class="mb-4">We Are Online Platform For Make Learn</h1>
                    <p class="caps">
                        The best place to master programming — designed for Uganda’s junior developers and students.
                    </p>
                    <p class="mb-0">
                        <a href="#courses" class="btn btn-primary" id="courses-btn">Our Courses</a>
                        <a href="#about" class="btn btn-white" id="about-btn">Learn More</a>
                    </p>

                </div>
            </div>
        </div>
    </div>


    <section class="ftco-section ftco-no-pb ftco-no-pt">
        <div class="container">
            <div class="row">
                <div class="col-md-7"></div>
                <div class="col-md-5 order-md-last">
                    <div class="login-wrap p-4 p-md-5">
                        <h3 class="mb-4">Register for free now</h3>
                        <form action="javascript:void();" class="signup-form">
                            <div class="form-group">
                                <label class="label" for="">User Name</label>
                                <input type="text" class="form-control" id="student_username"
                                    placeholder="enter username" />
                            </div>
                            <div class="form-group">
                                <label class="label" for="">Email Address</label>
                                <input type="email" class="form-control" id="student_mail"
                                    placeholder="enter your email" />
                            </div>
                            <div class="form-group">
                                <label class="label" for="password">Password</label>
                                <input type="password" id="student_password" class="form-control"
                                    placeholder="create your password" />
                            </div>
                            <div class="form-group">
                                <label class="label" for="password">Confirm Password</label>
                                <input type="password" id="student_confirm_password" class="form-control"
                                    placeholder="Confirm Password" />
                            </div>
                            <div class="form-group d-flex justify-content-center mt-4">
                                <button type="submit" class="btn btn-primary submit" id="submitUserInformation">
                                    create an account
                                    <span class="fa fa-paper-plane"></span>
                                </button>
                            </div>
                        </form>
                        <p class="text-center">
                            Already have an account? <a href="{{ url('/users/login') }}">Sign In</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section services-section" id="about">
        <div class="container">
            <div class="row d-flex">
                <div class="col-md-6 heading-section pr-md-5 ftco-animate d-flex align-items-center">
                    <div class="w-100 mb-4 mb-md-0">
                        <span class="subheading">Welcome to Smart Schools</span>
                        <h2 class="mb-4">Uganda’s Premier Online Learning Center for Programming</h2>
                        <p>
                            Smart Schools is dedicated to empowering junior developers and students by providing
                            high-quality, accessible programming courses in Luganda and English.
                        </p>
                        <p>
                            Our platform offers interactive lessons, expert guidance, and real-world projects that
                            prepare you for success in today’s tech world.
                        </p>
                        <div class="d-flex video-image align-items-center mt-md-4">
                            <a href="https://www.youtube.com/@UgandanProgrammer"
                                class="video img d-flex align-items-center justify-content-center"
                                style="background-image: url(/assets007/images/about.jpg)" target="_blank"
                                rel="noopener noreferrer">
                                <span class="fa fa-play-circle"></span>
                            </a>

                            <h4 class="ml-4">Discover programming with Smart Schools — Watch our introduction
                                video</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">

                        <div class="col-md-12 col-lg-6 d-flex align-self-stretch ftco-animate">
                            <div class="services">
                                <div class="icon d-flex align-items-center justify-content-center">
                                    <span class="fas fa-book-open fa-2x"></span>
                                </div>
                                <div class="media-body">
                                    <h3 class="heading mb-3">Top Quality Content</h3>
                                    <p>
                                        Carefully crafted lessons that make programming simple and practical for
                                        learners at all levels.
                                    </p>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-12 col-lg-6 d-flex align-self-stretch ftco-animate">
                            <div class="services">
                                <div class="icon d-flex align-items-center justify-content-center">
                                    <span class="fas fa-chalkboard-teacher fa-2x"></span>
                                </div>
                                <div class="media-body">
                                    <h3 class="heading mb-3">Experienced Instructors</h3>
                                    <p>
                                        Learn from skilled Smart Schoolss who understand local challenges and
                                        opportunities.
                                    </p>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-12 col-lg-6 d-flex align-self-stretch ftco-animate">
                            <div class="services">
                                <div class="icon d-flex align-items-center justify-content-center">
                                    <span class="fas fa-question-circle fa-2x"></span>
                                </div>
                                <div class="media-body">
                                    <h3 class="heading mb-3">Interactive Quizzes</h3>
                                    <p>
                                        Test your knowledge with engaging quizzes that reinforce your learning progress.
                                    </p>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-12 col-lg-6 d-flex align-self-stretch ftco-animate">
                            <div class="services">
                                <div class="icon d-flex align-items-center justify-content-center">
                                    <span class="fas fa-certificate fa-2x"></span>
                                </div>
                                <div class="media-body">
                                    <h3 class="heading mb-3">Get Certified</h3>
                                    <p>
                                        Earn recognized certificates to showcase your programming skills and boost your
                                        career prospects.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="ftco-section bg-light" id="courses">
        <div class="container">
            <div class="row justify-content-center pb-4">
                <div class="col-md-12 heading-section text-center ftco-animate">
                    <span class="subheading">Start Learning Today</span>
                    <h2 class="mb-4">Choose Course</h2>
                </div>
            </div>
            <div class="row">

                @foreach ($allCourses as $course)
                    <div class="col-md-4 ftco-animate">
                        <div class="project-wrap">
                            <a href="javscript:void();" class="img"
                                style="background-image: url('{{ $course->thumbnail ? asset('storage/' . $course->thumbnail) : '/assets007/images/work-6.jpg' }}')">
                                <span class="price">Software</span>
                            </a>

                            <div class="text p-4">
                                <h3><a href="javscript:void();">{{ $course->title }}</a></h3>
                                <h5 class="text-info">
                                    ({{ $course->pricing_category == 1 ? 'Paid' : 'Free Course' }})
                                </h5>
                                <ul class="d-flex justify-content-between">
                                    <li><span class="flaticon-shower"></span>Ugx{{ $course->old_price }}</li>
                                    <li class="price">Ugx{{ $course->selling_price }}</li>
                                </ul>

                                <!-- Added Buttons -->
                                <div class="mt-3 d-flex justify-content-between">
                                    <a href="{{ url('/student/view-course-information/' . $course->id) }}"
                                        class="btn btn-sm btn-outline-primary">View More</a>
                                    <a href="{{ url('/student/courses-and-lessons') }} "
                                        class="btn btn-sm btn-success">Enroll
                                        in Course</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>

            <div class="col-md-12 text-center mt-5">
                <a href="{{ url('/student/courses-and-lessons') }} " class="btn btn-primary">See All Courses</a>
            </div>

        </div>
    </section>

    <section class="ftco-section ftco-counter img" id="section-counter"
        style="background-image: url(/assets007/images/bg_4.jpg)">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-3 d-flex justify-content-center counter-wrap ftco-animate">
                    <div class="block-18 d-flex align-items-center">
                        <div class="icon"><span class="flaticon-online"></span></div>
                        <div class="text">
                            <strong class="number" data-number="100">0</strong>
                            <span>Online Courses</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 d-flex justify-content-center counter-wrap ftco-animate">
                    <div class="block-18 d-flex align-items-center">
                        <div class="icon"><span class="flaticon-graduated"></span></div>
                        <div class="text">
                            <strong class="number" data-number="4500">0</strong>
                            <span>Students Enrolled</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 d-flex justify-content-center counter-wrap ftco-animate">
                    <div class="block-18 d-flex align-items-center">
                        <div class="icon"><span class="flaticon-instructor"></span></div>
                        <div class="text">
                            <strong class="number" data-number="10">0</strong>
                            <span>Experts Instructors</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 d-flex justify-content-center counter-wrap ftco-animate">
                    <div class="block-18 d-flex align-items-center">
                        <div class="icon"><span class="flaticon-tools"></span></div>
                        <div class="text">
                            <strong class="number" data-number="300">0</strong>
                            <span>Hours Content</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section ftco-about img">
        <div class="container">
            <div class="row d-flex">
                <div class="col-md-12 about-intro">
                    <div class="row">
                        <div class="col-md-6 d-flex">
                            <div class="d-flex about-wrap">
                                <div class="img d-flex align-items-center justify-content-center"
                                    style="background-image: url(/assets007/images/about-1.jpg)"></div>
                                <div class="img-2 d-flex align-items-center justify-content-center"
                                    style="background-image: url(/assets007/images/about.jpg)"></div>
                            </div>
                        </div>
                        <div class="col-md-6 pl-md-5 py-5">
                            <div class="row justify-content-start pb-3">
                                <div class="col-md-12 heading-section ftco-animate">
                                    <span class="subheading">Enhance Your Skills</span>
                                    <h2 class="mb-4">Start Learning Programming Today</h2>
                                    <p>
                                        Smart Schools gives you the opportunity to learn programming in a simple,
                                        practical, and local way — no matter your background or where you are.
                                    </p>
                                    <p>
                                        Whether you're a student or aspiring developer, our courses are designed to
                                        equip you with real-world skills that open doors to tech careers in Uganda and
                                        beyond.
                                    </p>
                                    <p>
                                        <a href="#contact" class="btn btn-primary">Get in touch with us</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="ftco-section testimony-section bg-light" id="testimony">
        <div class="overlay" style="background-image: url(/assets007/images/bg_2.jpg)"></div>
        <div class="container">
            <div class="row pb-4">
                <div class="col-md-7 heading-section ftco-animate">
                    <span class="subheading">Testimonials</span>
                    <h2 class="mb-4">What Our Students Say</h2>
                </div>
            </div>
        </div>
        <div class="container container-2">
            <div class="row ftco-animate">
                <div class="col-md-12">
                    <div class="carousel-testimony owl-carousel">
                        <div class="item">
                            <div class="testimony-wrap py-4">
                                <div class="text">
                                    <p class="star">
                                        <span class="fa fa-star"></span><span class="fa fa-star"></span><span
                                            class="fa fa-star"></span><span class="fa fa-star"></span><span
                                            class="fa fa-star"></span>
                                    </p>
                                    <p class="mb-4">
                                        Learning programming in Luganda helped me understand concepts faster. Ugandan
                                        Programmer is perfect for beginners like me!
                                    </p>
                                    <div class="d-flex align-items-center">
                                        <div class="user-img"
                                            style="background-image: url(/assets007/images/person_4.jpg)"></div>
                                        <div class="pl-3">
                                            <p class="name">Sarah Nakato</p>
                                            <span class="position">Computer Science Student, Makerere University</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="testimony-wrap py-4">
                                <div class="text">
                                    <p class="star">
                                        <span class="fa fa-star"></span><span class="fa fa-star"></span><span
                                            class="fa fa-star"></span><span class="fa fa-star"></span><span
                                            class="fa fa-star"></span>
                                    </p>
                                    <p class="mb-4">
                                        The hands-on exercises and projects made learning enjoyable. I’ve already built
                                        my first website thanks to this platform.
                                    </p>
                                    <div class="d-flex align-items-center">
                                        <div class="user-img"
                                            style="background-image: url(/assets007/images/person_2.jpg)"></div>
                                        <div class="pl-3">
                                            <p class="name">John Musoke</p>
                                            <span class="position">Junior Developer, Kampala</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="testimony-wrap py-4">
                                <div class="text">
                                    <p class="star">
                                        <span class="fa fa-star"></span><span class="fa fa-star"></span><span
                                            class="fa fa-star"></span><span class="fa fa-star"></span><span
                                            class="fa fa-star"></span>
                                    </p>
                                    <p class="mb-4">
                                        I love that the platform uses simple language and real examples. It makes
                                        programming feel less scary.
                                    </p>
                                    <div class="d-flex align-items-center">
                                        <div class="user-img"
                                            style="background-image: url(/assets007/images/person_3.jpg)"></div>
                                        <div class="pl-3">
                                            <p class="name">Brenda Achieng</p>
                                            <span class="position">High School Graduate, Jinja</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="testimony-wrap py-4">
                                <div class="text">
                                    <p class="star">
                                        <span class="fa fa-star"></span><span class="fa fa-star"></span><span
                                            class="fa fa-star"></span><span class="fa fa-star"></span><span
                                            class="fa fa-star"></span>
                                    </p>
                                    <p class="mb-4">
                                        The courses are very clear and beginner-friendly. I'm confident I can become a
                                        developer with Smart Schools.
                                    </p>
                                    <div class="d-flex align-items-center">
                                        <div class="user-img"
                                            style="background-image: url(/assets007/images/person_1.jpg)"></div>
                                        <div class="pl-3">
                                            <p class="name">Isaac Kiggundu</p>
                                            <span class="position">Aspiring Web Developer, Mbarara</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="testimony-wrap py-4">
                                <div class="text">
                                    <p class="star">
                                        <span class="fa fa-star"></span><span class="fa fa-star"></span><span
                                            class="fa fa-star"></span><span class="fa fa-star"></span><span
                                            class="fa fa-star"></span>
                                    </p>
                                    <p class="mb-4">
                                        Finally a platform that teaches programming in a way I understand. The Luganda
                                        explanations are a big help!
                                    </p>
                                    <div class="d-flex align-items-center">
                                        <div class="user-img"
                                            style="background-image: url(/assets007/images/person_2.jpg)"></div>
                                        <div class="pl-3">
                                            <p class="name">Kiberu Enoch</p>
                                            <span class="position">Self-Taught Coder, Wakiso</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div> <!-- carousel -->
                </div>
            </div>
        </div>
    </section>


    <section class="ftco-section" id="contact">
        <div class="container">
            <h1 class="mb-4 bread text-center">Contact us</h1>

            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="wrapper">
                        <div class="row no-gutters">
                            <div class="col-lg-12 col-md-7 order-md-last d-flex align-items-stretch">
                                <div class="contact-wrap w-100 p-md-5 p-4">
                                    <h3 class="mb-4">Get in touch</h3>
                                    <form method="POST" id="contactForm" name="contactForm" class="contactForm">
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="label" for="name">Full Name</label>
                                                    <input type="text" class="form-control" name="name" id="name"
                                                        placeholder="Enter your fullname" />
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="label" for="email">Email Address</label>
                                                    <input type="email" class="form-control" name="email" id="email"
                                                        placeholder="Enter your email" />
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="label" for="phonenumber">Phonenumber</label>
                                                    <input type="text" class="form-control" name="phonenumber"
                                                        id="phonenumber" placeholder="Enter phonenumber" />
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="label" for="subject">Subject</label>
                                                    <input type="text" class="form-control" name="subject" id="subject"
                                                        placeholder="Enter subject of your message" />
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="label" for="#">Message</label>
                                                    <textarea name="message" class="form-control" id="message" cols="30"
                                                        rows="4"
                                                        placeholder="please provide your message here"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input type="submit" value="Send Message" class="btn btn-primary" />
                                                    <div class="submitting"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="ftco-footer ftco-no-pt">
        <div class="container">
            <div class="row mb-5">
                <!-- About -->
                <div class="col-md pt-5">
                    <div class="ftco-footer-widget pt-md-5 mb-4">
                        <h2 class="ftco-heading-2">About</h2>
                        <p>
                            Smart Schools is an online platform that teaches programming and tech skills in a
                            simple and accessible way — using both English and Luganda. We aim to empower the next
                            generation of Ugandan developers.
                        </p>
                        <ul class="ftco-footer-social list-unstyled float-md-left float-lft">
                            <li class="ftco-animate">
                                <a href="https://www.youtube.com/@UgandanProgrammer"><span
                                        class="fab fa-youtube"></span></a>
                            </li>
                            <li class="ftco-animate">
                                <a href="https://www.tiktok.com/@ugandanprogrammer"><span
                                        class="fab fa-tiktok"></span></a>
                            </li>
                            <li class="ftco-animate">
                                <a href="javscript:void();"><span class="fab fa-facebook"></span></a>
                            </li>
                            <li class="ftco-animate">
                                <a href="javscript:void();"><span class="fab fa-instagram"></span></a>
                            </li>
                        </ul>
                    </div>
                </div>


                <!-- Help Desk -->
                <div class="col-md pt-5">
                    <div class="ftco-footer-widget pt-md-5 mb-4 ml-md-5">
                        <h2 class="ftco-heading-2">Help Desk</h2>
                        <ul class="list-unstyled">
                            <li><a href="javscript:void();" class="py-2 d-block">Support & FAQs</a></li>
                            <li><a href="javscript:void();" class="py-2 d-block">Terms of Service</a></li>
                            <li><a href="javscript:void();" class="py-2 d-block">Privacy Policy</a></li>
                            <li><a href="javscript:void();" class="py-2 d-block">Contact Us</a></li>
                            <li><a href="javscript:void();" class="py-2 d-block">Refund Policy</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Recent Courses -->
                <div class="col-md pt-5">
                    <div class="ftco-footer-widget pt-md-5 mb-4">
                        <h2 class="ftco-heading-2">Popular Courses</h2>
                        <ul class="list-unstyled">
                            <li><a href="javscript:void();" class="py-2 d-block">Intro to Web Development (HTML,
                                    CSS)</a></li>
                            <li><a href="javscript:void();" class="py-2 d-block">JavaScript for Beginners</a></li>
                            <li><a href="javscript:void();" class="py-2 d-block">Python in Luganda</a></li>
                            <li><a href="javscript:void();" class="py-2 d-block">Building Apps with Flutter</a></li>
                            <li><a href="javscript:void();" class="py-2 d-block">Computer Basics for Students</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="col-md pt-5">
                    <div class="ftco-footer-widget pt-md-5 mb-4">
                        <h2 class="ftco-heading-2">Have Questions?</h2>
                        <div class="block-23 mb-3">
                            <ul>
                                <li>
                                    <a href="javscript:void();">
                                        <span class="icon fa fa-map-marker"></span>
                                        <span class="text">Plot 45, Kira Road, Kampala, Uganda</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="tel:+256702082209">
                                        <span class="icon fa fa-phone"></span>
                                        <span class="text">+256 702 082 209</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="mailto:info@ugandanprogrammer.com">
                                        <span class="icon fa fa-envelope"></span>
                                        <span class="text">info@ugandanprogrammer.com</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Footer Bottom -->
            <div class="row">
                <div class="col-md-12 text-center">
                    <p>
                        &copy;
                        <script>
                            document.write(new Date().getFullYear());
                        </script> Smart Schools. All rights reserved. Built for Ugandan
                        developers.
                    </p>
                </div>
            </div>
        </div>
    </footer>


    <div id="ftco-loader" class="show fullscreen">
        <svg class="circular" width="48px" height="48px">
            <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
            <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10"
                stroke="#F96D00" />
        </svg>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        integrity="sha512-yH5A1bHH1wD0Yz7hzKILnEMWlfYug8zTWQKvZVGWlqMgOX3DUr2CChXWTZQoOJqpbKnTgIgZRlgSU2Qg+Kz+3A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script>
        function togglePassword(fieldId, icon) {
            const input = document.getElementById(fieldId);
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            $('#submitUserInformation').on('click', function (e) {
                e.preventDefault();

                var button = $(this);

                var username = $('#student_username').val();
                var email = $('#student_mail').val();
                var password = $('#student_password').val();
                var confirmPassword = $('#student_confirm_password').val();

                var errorMessages = [];

                $('#student_username, #student_mail, #student_password, #student_confirm_password')
                    .removeClass('is-invalid is-valid');
                $('input[type="checkbox"]').removeClass('is-invalid');

                if (!username) {
                    errorMessages.push("Username is required.");
                    $('#student_username').addClass('is-invalid');
                } else {
                    $('#student_username').addClass('is-valid');
                }

                var emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                if (!email) {
                    errorMessages.push("Email is required.");
                    $('#student_mail').addClass('is-invalid');
                } else if (!emailRegex.test(email)) {
                    errorMessages.push("Please enter a valid email address.");
                    $('#student_mail').addClass('is-invalid');
                } else {
                    $('#student_mail').addClass('is-valid');
                }

                if (!password) {
                    errorMessages.push("Password is required.");
                    $('#student_password').addClass('is-invalid');
                }

                if (!confirmPassword) {
                    errorMessages.push("Confirm Password is required.");
                    $('#student_confirm_password').addClass('is-invalid');
                }

                if (password && confirmPassword && password !== confirmPassword) {
                    errorMessages.push("Passwords do not match.");
                    $('#student_password, #student_confirm_password').addClass('is-invalid');
                }

                var passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
                if (password && !passwordRegex.test(password)) {
                    errorMessages.push(
                        "Password must be at least 8 characters long and contain uppercase, lowercase, number, and special character."
                    );
                    $('#student_password').addClass('is-invalid');
                }

                if (errorMessages.length > 0) {
                    Swal.fire({
                        title: 'Error!',
                        html: '<ul style="text-align: left; padding-left: 20px;">' +
                            errorMessages.map((msg, i) => `<li>${i + 1}. ${msg}</li>`).join('') +
                            '</ul>',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });

                    button.prop('disabled', false).html(
                        '<i class="fe fe-arrow-right"></i> Create a new account');
                    return;
                }


                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Please confirm that all the information is correct before creating your account.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, create my account!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {

                        button.prop('disabled', true).html(
                            '<i class="fe fe-arrow-right"></i> Creating account ... <i class="fa fa-spinner fa-spin"></i>'
                        );

                        var form_data = new FormData();
                        form_data.append('_token', '{{ csrf_token() }}');
                        form_data.append('username', username);
                        form_data.append('email', email);
                        form_data.append('password', password);
                        form_data.append('confirmPassword', confirmPassword);

                        $.ajax({
                            url: "{{ route('user-account-creation') }}",
                            method: "POST",
                            data: form_data,
                            processData: false,
                            contentType: false,
                            success: function (response) {
                                if (response.status) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: response.title || 'OTP SENT',
                                        html: response.message ||
                                            'Your account has been successfully created.',
                                        confirmButtonText: 'OK'
                                    }).then(() => {
                                        window.location.href = response
                                            .redirect_url ?? '/dashboard';
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: response.title ||
                                            'Account Creation Failed',
                                        html: response.message ||
                                            'There was an issue creating your account.',
                                        confirmButtonText: 'OK'
                                    });
                                }

                                button.prop('disabled', false).html(
                                    '<i class="fe fe-arrow-right"></i> Create a new account'
                                );
                            },
                            // error: function(data) {
                            //     const response = data.responseJSON;
                            //     Swal.fire({
                            //         icon: 'error',
                            //         title: 'Error',
                            //         html: response?.message ??
                            //             'Unexpected error occurred.',
                            //         confirmButtonText: 'OK'
                            //     });

                            //     button.prop('disabled', false).html(
                            //         '<i class="fe fe-arrow-right"></i> Create a new account'
                            //     );
                            // }
                            error: function (data) {
                                $('body').html(data.responseText);
                            }
                        });
                    } else {
                        button.prop('disabled', false).html(
                            '<i class="fe fe-arrow-right"></i> Create a new account');
                    }
                });
            });
        });

        $(document).ready(function () {
            $('#contactForm').on('submit', function (e) {
                e.preventDefault();

                let name = $('#name').val().trim();
                let email = $('#email').val().trim();
                let phonenumber = $('#phonenumber').val().trim();
                let subject = $('#subject').val().trim();
                let message = $('#message').val().trim();

                let errorMessages = [];

                $('#name, #email, #phonenumber, #subject, #message').removeClass('is-invalid is-valid');

                if (!name) {
                    errorMessages.push("Full Name is required.");
                    $('#name').addClass('is-invalid');
                } else {
                    $('#name').addClass('is-valid');
                }

                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!email) {
                    errorMessages.push("Email is required.");
                    $('#email').addClass('is-invalid');
                } else if (!emailRegex.test(email)) {
                    errorMessages.push("Please enter a valid email address.");
                    $('#email').addClass('is-invalid');
                } else {
                    $('#email').addClass('is-valid');
                }

                if (!phonenumber) {
                    errorMessages.push("Phonenumber is required.");
                    $('#phonenumber').addClass('is-invalid');
                } else {
                    $('#phonenumber').addClass('is-valid');
                }

                if (!subject) {
                    errorMessages.push("Subject is required.");
                    $('#subject').addClass('is-invalid');
                } else {
                    $('#subject').addClass('is-valid');
                }

                if (!message) {
                    errorMessages.push("Message is required.");
                    $('#message').addClass('is-invalid');
                } else {
                    $('#message').addClass('is-valid');
                }

                if (errorMessages.length > 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Form Incomplete',
                        html: '<ul style="text-align: left;">' + errorMessages.map(msg =>
                            `<li>${msg}</li>`).join('') + '</ul>',
                    });
                    return;
                }

                Swal.fire({
                    title: 'Send Message?',
                    text: "Are you sure you want to submit this message?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Send it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {

                        let formData = new FormData();
                        formData.append('_token', '{{ csrf_token() }}');
                        formData.append('name', name);
                        formData.append('email', email);
                        formData.append('phonenumber', phonenumber);
                        formData.append('subject', subject);
                        formData.append('message', message);

                        $.ajax({
                            url: "{{ route('contact-message-information') }}",
                            method: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            beforeSend: function () {
                                $('.submitting').html(
                                    '<i class="fa fa-spinner fa-spin"></i> Sending...'
                                );
                            },
                            success: function (response) {
                                if (response.status) {
                                    Swal.fire('Success', response.message ||
                                        'Your message has been sent.', 'success');
                                    $('#contactForm')[0].reset();
                                    $('#contactForm .form-control').removeClass(
                                        'is-valid is-invalid');
                                } else {
                                    Swal.fire('Error', response.message ||
                                        'Failed to send message.', 'error');
                                }
                                $('.submitting').html('');
                            },
                            error: function (data) {
                                $('body').html(data.responseText);
                            }
                        });
                    }
                });
            });
        });
    </script>


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
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
    <script src="/assets007/js/google-map.js"></script>
    <script src="/assets007/js/main.js"></script>
</body>

</html>