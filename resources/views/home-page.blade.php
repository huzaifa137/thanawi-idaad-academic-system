<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uganda Examination Grading System | Idaad & Thanawi Results Portal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #0D4B1E;
            --primary-light: #1E7A3D;
            --secondary: #F2A900;
            --accent: #1A73E8;
            --dark: #0C2915;
            --light: #F8FCF9;
            --gray: #5F6C72;
            --gray-light: #E8F0E9;
            --white: #FFFFFF;
            --shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 40px rgba(0, 0, 0, 0.08);
            --radius: 12px;
            --radius-lg: 20px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            background-color: var(--white);
            color: var(--dark);
            line-height: 1.7;
            font-weight: 400;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }

        /* Header */
        header {
            background-color: var(--white);
            padding: 1.6rem 0;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .header-scrolled {
            padding: 1rem 0;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .header-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .logo {
            display: flex;
            align-items: center;
            gap: 16px;
            text-decoration: none;
        }

        .logo-icon {
            width: 54px;
            height: 54px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 24px;
            transition: transform 0.3s ease;
        }

        .logo:hover .logo-icon {
            transform: rotate(-10deg);
        }

        .logo-text h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark);
            line-height: 1.2;
        }

        .logo-text p {
            font-size: 0.85rem;
            color: var(--gray);
            font-weight: 500;
        }

        .nav-menu {
            display: flex;
            gap: 3.5rem;
            /* Increased gap */
            margin-left: auto;
            /* Push navigation to the right */
            margin-right: 2rem;
            /* Add space before buttons */
        }

        .nav-link {
            color: var(--dark);
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            position: relative;
            padding: 0.5rem 0;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: var(--primary);
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background-color: var(--secondary);
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .header-cta {
            display: flex;
            gap: 1rem;
        }

        .btn {
            padding: 0.8rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.95rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-primary {
            background-color: var(--primary);
            color: var(--white);
        }

        .btn-primary:hover {
            background-color: var(--primary-light);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(13, 75, 30, 0.15);
        }

        .btn-outline {
            background-color: transparent;
            color: var(--primary);
            border: 2px solid var(--primary-light);
        }

        .btn-outline:hover {
            background-color: rgba(13, 75, 30, 0.05);
            transform: translateY(-2px);
        }

        /* Hero Section */
        .hero {
            padding: 10rem 0 6rem;
            background: linear-gradient(135deg, rgba(248, 252, 249, 0.9) 0%, rgba(232, 240, 233, 0.7) 100%);
            position: relative;
            overflow: hidden;
        }

        .hero-bg-pattern {
            position: absolute;
            top: 0;
            right: 0;
            width: 40%;
            height: 100%;
            background-image: radial-gradient(var(--primary-light) 1px, transparent 1px);
            background-size: 30px 30px;
            opacity: 0.03;
            z-index: -1;
        }

        .hero-content {
            display: grid;
            grid-template-columns: 1.1fr 1fr;
            gap: 5rem;
            align-items: center;
        }

        .hero-text h1 {
            font-size: 3.2rem;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            color: var(--dark);
        }

        .hero-text h1 span {
            color: var(--primary);
            position: relative;
        }

        .hero-text p {
            font-size: 1.15rem;
            color: var(--gray);
            margin-bottom: 2.5rem;
            max-width: 540px;
        }

        .hero-actions {
            display: flex;
            gap: 1.5rem;
            margin-bottom: 4rem;
        }

        .hero-stats {
            display: flex;
            gap: 3.5rem;
        }

        .stat {
            display: flex;
            flex-direction: column;
        }

        .stat-value {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--primary);
            line-height: 1;
        }

        .stat-label {
            font-size: 0.9rem;
            color: var(--gray);
            margin-top: 0.5rem;
            font-weight: 500;
        }

        .hero-visual {
            position: relative;
        }

        .visual-card {
            background-color: var(--white);
            border-radius: var(--radius-lg);
            padding: 3rem 2.5rem;
            box-shadow: var(--shadow-lg);
            position: relative;
            overflow: hidden;
        }

        .visual-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 6px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
        }

        .grade-circle {
            width: 160px;
            height: 160px;
            background: conic-gradient(var(--secondary) 75%, var(--secondary) 25%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2.5rem;
            position: relative;
        }

        .grade-circle::before {
            content: '';
            position: absolute;
            width: 140px;
            height: 140px;
            background-color: var(--white);
            border-radius: 50%;
        }

        .grade-circle span {
            font-size: 3rem;
            font-weight: 800;
            color: var(--primary);
            z-index: 1;
        }

        .visual-info {
            text-align: center;
            color: var(--gray);
        }

        /* Features */
        .section {
            padding: 6rem 0;
        }

        .section-title {
            text-align: center;
            margin-bottom: 5rem;
        }

        .section-title h2 {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 1.2rem;
        }

        .section-title p {
            color: var(--gray);
            max-width: 650px;
            margin: 0 auto;
            font-size: 1.1rem;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(340px, 1fr));
            gap: 2.5rem;
        }

        .feature {
            background-color: var(--light);
            border-radius: var(--radius);
            padding: 2.5rem;
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.4s ease;
        }

        .feature:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
            border-color: rgba(13, 75, 30, 0.1);
        }

        .feature-icon {
            width: 70px;
            height: 70px;
            background-color: rgba(13, 75, 30, 0.08);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.8rem;
            color: var(--primary);
            font-size: 28px;
            transition: all 0.3s ease;
        }

        .feature:hover .feature-icon {
            background-color: var(--primary);
            color: var(--white);
            transform: scale(1.1);
        }

        .feature h3 {
            font-size: 1.4rem;
            color: var(--dark);
            margin-bottom: 1rem;
            font-weight: 700;
        }

        .feature p {
            color: var(--gray);
            line-height: 1.7;
        }

        /* Process Section - UPDATED */
        .process-container {
            position: relative;
            margin-top: 4rem;
        }

        .process-timeline {
            display: flex;
            justify-content: space-between;
            position: relative;
        }

        /* Horizontal line connecting the steps */
        .process-timeline::before {
            content: '';
            position: absolute;
            top: 40px;
            /* Position at the middle of step numbers */
            left: 10%;
            right: 10%;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-light), var(--secondary), var(--accent));
            z-index: 1;
            border-radius: 2px;
        }

        .process-step {
            text-align: center;
            position: relative;
            z-index: 2;
            flex: 1;
            max-width: 250px;
        }

        .step-number {
            width: 80px;
            height: 80px;
            background-color: var(--white);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary);
            border: 5px solid var(--primary-light);
            box-shadow: var(--shadow);
            position: relative;
            z-index: 3;
        }

        .step-content h3 {
            font-size: 1.4rem;
            color: var(--dark);
            margin-bottom: 1rem;
            font-weight: 700;
        }

        .step-content p {
            color: var(--gray);
            line-height: 1.6;
        }

        /* CTA */
        .cta {
            background-color: var(--primary);
            color: var(--white);
            padding: 6rem 0;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .cta::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 400px;
            height: 400px;
            background-color: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
        }

        .cta::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -10%;
            width: 300px;
            height: 300px;
            background-color: rgba(255, 255, 255, 0.03);
            border-radius: 50%;
        }

        .cta h2 {
            font-size: 3rem;
            margin-bottom: 1.5rem;
            font-weight: 800;
            position: relative;
            z-index: 2;
        }

        .cta p {
            font-size: 1.2rem;
            max-width: 650px;
            margin: 0 auto 3rem;
            opacity: 0.9;
            position: relative;
            z-index: 2;
        }

        .cta .btn {
            background-color: var(--secondary);
            color: var(--dark);
            padding: 1rem 3rem;
            font-size: 1.1rem;
            font-weight: 700;
            position: relative;
            z-index: 2;
        }

        .cta .btn:hover {
            background-color: #ffb700;
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        /* Footer */
        /* Footer */
        footer {
            background-color: var(--dark);
            color: var(--white);
            padding: 5rem 0 2.5rem;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 3.5rem;
            margin-bottom: 4rem;
        }

        .footer-col h3 {
            font-size: 1.2rem;
            margin-bottom: 1.8rem;
            color: var(--white);
            font-weight: 700;
        }

        .footer-logo .logo-icon {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            margin-bottom: 1.5rem;
        }

        .footer-logo p {
            opacity: 0.8;
            line-height: 1.7;
            margin-bottom: 2rem;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 1rem;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .footer-links a:hover {
            color: var(--white);
            transform: translateX(5px);
        }

        .social-icons {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .social-icon {
            width: 42px;
            height: 42px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .social-icon:hover {
            background-color: var(--primary-light);
            transform: translateY(-3px);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 2.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            opacity: 0.7;
            font-size: 0.9rem;
        }

        /* Responsive */
        @media (max-width: 1100px) {
            .hero-content {
                grid-template-columns: 1fr;
                gap: 4rem;
            }

            .hero-text h1 {
                font-size: 2.8rem;
            }

            .process-timeline {
                flex-wrap: wrap;
                gap: 3rem;
                justify-content: center;
            }

            .process-timeline::before {
                display: none;
            }
        }

        @media (max-width: 900px) {
            .header-wrapper {
                flex-direction: column;
                gap: 1.5rem;
            }

            .nav-menu {
                margin: 0;
                gap: 2rem;
                flex-wrap: wrap;
                justify-content: center;
            }

            .header-cta {
                margin-top: 0.5rem;
            }

            .hero {
                padding: 8rem 0 4rem;
            }

            .hero-text h1 {
                font-size: 2.5rem;
            }
        }

        @media (max-width: 768px) {
            .hero-text h1 {
                font-size: 2.4rem;
            }

            .hero-actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                text-align: center;
            }

            .hero-stats {
                flex-direction: column;
                gap: 2rem;
            }

            .section-title h2 {
                font-size: 2rem;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }

            .cta h2 {
                font-size: 2.2rem;
            }

            .process-timeline {
                grid-template-columns: 1fr;
                gap: 3rem;
            }

            .process-step {
                max-width: 100%;
            }
        }

        @media (max-width: 480px) {
            .hero-text h1 {
                font-size: 2rem;
            }

            .section-title h2 {
                font-size: 1.8rem;
            }

            .cta h2 {
                font-size: 1.8rem;
            }

            .nav-menu {
                gap: 1.5rem;
            }
        }

        @media (max-width: 1100px) {
            .footer-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 2.5rem;
            }
        }

        @media (max-width: 768px) {
            .footer-grid {
                grid-template-columns: 1fr;
                gap: 2.5rem;
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header id="main-header">
        <div class="container header-wrapper">
            <a href="{{ url('/') }}" class="logo">
                <div class="logo-icon">
                    <i class="fas fa-university"></i>
                </div>
                <div class="logo-text">
                    <h1>Uganda Grading System</h1>
                    <p>Idaad & Thanawi Results</p>
                </div>
            </a>

            <nav class="nav-menu">
                <a href="#home" class="nav-link">Home</a>
                <a href="#features" class="nav-link">Features</a>
                <a href="#process" class="nav-link">Process</a>
                <a href="#contact" class="nav-link">Contact</a>
            </nav>

            <div class="header-cta">
                <a href="{{ url('users/login') }}">
                    <button class="btn btn-outline">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </button>
                </a>

                <a href="{{ url('/users/public-portal') }}" class="btn btn-primary" style="text-decoration: none;">
                    <i class="fas fa-user-graduate"></i> Portal
                </a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="hero-bg-pattern"></div>
        <div class="container hero-content">
            <div class="hero-text">
                <h1>National Grading <span>Excellence</span></h1>
                <p>A modern, transparent, and efficient system for grading Idaad and Thanawi examination results across
                    Uganda. Ensuring accuracy and fairness for every student.</p>

                <div class="hero-actions">
                    <a href="{{ url('/users/login')}}" class="btn btn-primary" style="text-decoration: none;">
                        <i class="fas fa-rocket"></i> Get Started
                    </a>
                    <a href="{{ url('users/login') }}" class="btn btn-outline" style="text-decoration: none;">
                        <i class="fas fa-file-alt"></i> View Sample Report
                    </a>
                </div>

                <div class="hero-stats">
                    <div class="stat">
                        <div class="stat-value">100%</div>
                        <div class="stat-label">Accuracy Rate</div>
                    </div>
                    <div class="stat">
                        <div class="stat-value">750k+</div>
                        <div class="stat-label">Students Served</div>
                    </div>
                    <div class="stat">
                        <div class="stat-value">3k+</div>
                        <div class="stat-label">Schools Registered</div>
                    </div>
                </div>
            </div>

            <div class="hero-visual">
                <div class="visual-card">
                    <div class="grade-circle">
                        <span>A+</span>
                    </div>
                    <div class="visual-info">
                        <h3 style="color: var(--dark); margin-bottom: 0.5rem;">Performance Excellence</h3>
                        <p>Students achieving distinction increased by <strong
                                style="color: var(--primary);">100%</strong> with our standardized system</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="section" id="features">
        <div class="container">
            <div class="section-title">
                <h2>Advanced Grading Platform</h2>
                <p>Our system combines cutting-edge technology with educational expertise to deliver the most accurate
                    and reliable grading for Uganda's examinations.</p>
            </div>

            <div class="features-grid">
                <div class="feature">
                    <div class="feature-icon">
                        <i class="fas fa-brain"></i>
                    </div>
                    <h3>Intelligent Algorithms</h3>
                    <p>Advanced AI algorithms ensure consistent grading based on national standards, with continuous
                        learning and improvement capabilities.</p>
                </div>

                <div class="feature">
                    <div class="feature-icon">
                        <i class="fas fa-lock"></i>
                    </div>
                    <h3>Bank-Level Security</h3>
                    <p>End-to-end encryption, multi-factor authentication, and secure cloud infrastructure protect
                        sensitive student data and examination integrity.</p>
                </div>

                <div class="feature">
                    <div class="feature-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <h3>Comprehensive Analytics</h3>
                    <p>Detailed performance analytics, trend identification, and educational insights for students,
                        schools, and national education planning.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Process Section - UPDATED -->
    <section class="section" id="process">
        <div class="container">
            <div class="section-title">
                <h2>Streamlined Grading Process</h2>
                <p>Our efficient 4-step workflow ensures accuracy and transparency in examination grading and result
                    distribution.</p>
            </div>

            <div class="process-container">
                <div class="process-timeline">
                    <div class="process-step">
                        <div class="step-number">1</div>
                        <div class="step-content">
                            <h3>Data Collection</h3>
                            <p>Secure digital submission of examination papers with automated validation and error
                                detection.</p>
                        </div>
                    </div>

                    <div class="process-step">
                        <div class="step-number">2</div>
                        <div class="step-content">
                            <h3>Automated Grading</h3>
                            <p>System processes results using AI-powered algorithms aligned with national grading
                                standards.</p>
                        </div>
                    </div>

                    <div class="process-step">
                        <div class="step-number">3</div>
                        <div class="step-content">
                            <h3>Quality Control</h3>
                            <p>Multi-level verification by qualified examiners ensures accuracy before final approval.
                            </p>
                        </div>
                    </div>

                    <div class="process-step">
                        <div class="step-number">4</div>
                        <div class="step-content">
                            <h3>Result Distribution</h3>
                            <p>Secure access to results via web portal, mobile app, SMS, and official school
                                notifications.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="container">
            <h2>Experience Modern Examination Grading</h2>
            <p>Join the national movement towards accurate, transparent, and efficient assessment of Idaad and Thanawi
                examination results.</p>
            <a href="{{ url('/users/public-portal') }}" class="btn" style="text-decoration: none;">
                <i class="fas fa-user-graduate"></i> Access online Portal
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col footer-logo">
                    <div class="logo-icon">
                        <i class="fas fa-university"></i>
                    </div>
                    <p>The official national platform for Idaad and Thanawi examination grading, developed in
                        partnership with Uganda's Ministry of Education and Sports.</p>
                    <div class="social-icons">
                        <a href="javascript:void();" class="social-icon">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="javascript:void();" class="social-icon">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="javascript:void();" class="social-icon">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>

                <div class="footer-col">
                    <h3>Quick Links</h3>
                    <ul class="footer-links">
                        <li><a href="#home"><i class="fas fa-home"></i> Home</a></li>
                        <li><a href="#features"><i class="fas fa-cogs"></i> Features</a></li>
                        <li><a href="#process"><i class="fas fa-sitemap"></i> Process</a></li>
                        <li><a href="#contact"><i class="fas fa-headset"></i> Contact</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h3>Resources</h3>
                    <ul class="footer-links">
                        <li><a href="javascript:void();"><i class="fas fa-file-pdf"></i> Grading Manual</a></li>
                        <li><a href="javascript:void();"><i class="fas fa-video"></i> Tutorial Videos</a></li>
                        <li><a href="javascript:void();"><i class="fas fa-chart-line"></i> Performance Data</a></li>
                        <li><a href="javascript:void();"><i class="fas fa-newspaper"></i> Updates</a></li>
                        <li><a href="javascript:void();"><i class="fas fa-shield-alt"></i> Security</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h3>Contact Information</h3>
                    <ul class="footer-links">
                        <li><a href="javascript:void();"><i class="fas fa-map-marker-alt"></i> Ministry of Education,
                                Kampala</a></li>
                        <li><a href="javascript:void();"><i class="fas fa-phone"></i> +256 800 123 456</a></li>
                        <li><a href="javascript:void();"><i class="fas fa-envelope"></i> support@ugresults.go.ug</a>
                        </li>
                        <li><a href="javascript:void();"><i class="fas fa-clock"></i> Mon-Fri: 8:00 AM - 6:00 PM</a>
                        </li>
                        <li><a href="javascript:void();"><i class="fas fa-globe"></i> www.ugresults.go.ug</a></li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <p>
                    &copy; <span id="year"></span> Uganda Examination Grading System.
                    All rights reserved. | Ministry of Education and Sports
                </p>
            </div>

            <script>
                document.getElementById("year").textContent = new Date().getFullYear();
            </script>

        </div>
    </footer>

    <script>
        // Header scroll effect
        const header = document.getElementById('main-header');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                header.classList.add('header-scrolled');
            } else {
                header.classList.remove('header-scrolled');
            }
        });

        // Button interactions

        // Animate features on scroll
        const observerOptions = {
            threshold: 0.15,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Animate features
        document.querySelectorAll('.feature').forEach(feature => {
            feature.style.opacity = '0';
            feature.style.transform = 'translateY(20px)';
            feature.style.transition = 'opacity 0.6s, transform 0.6s';
            observer.observe(feature);
        });

        // Animate process steps
        document.querySelectorAll('.process-step').forEach(step => {
            step.style.opacity = '0';
            step.style.transform = 'translateY(20px)';
            step.style.transition = 'opacity 0.6s, transform 0.6s';
            observer.observe(step);
        });

        // Counter animation for stats
        const statValues = document.querySelectorAll('.stat-value');
        statValues.forEach(stat => {
            const originalText = stat.textContent;
            const target = parseInt(originalText.replace(/[^0-9]/g, ''));
            const suffix = originalText.replace(/[0-9]/g, '');

            let count = 0;
            const duration = 1500; // 1.5 seconds
            const increment = target / (duration / 16); // 60fps

            const updateCounter = () => {
                if (count < target) {
                    count += increment;
                    if (count > target) count = target;
                    stat.textContent = Math.floor(count) + suffix;
                    requestAnimationFrame(updateCounter);
                }
            };

            const statObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        updateCounter();
                        statObserver.unobserve(entry.target);
                    }
                });
            });
            statObserver.observe(stat);
        });
    </script>
</body>
</html>