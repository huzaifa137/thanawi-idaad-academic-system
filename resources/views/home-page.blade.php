<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uganda National Education Grading System | Official Idaad & Thanawi Results Portal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #1A5F23;
            --primary-light: #2E8B32;
            --primary-dark: #0D3B13;
            --secondary: #FFC107;
            --secondary-light: #FFD54F;
            --accent: #1976D2;
            --dark: #1A2E1A;
            --light: #F8FDF8;
            --gray: #5D6D7E;
            --gray-light: #EAEDED;
            --white: #FFFFFF;
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.05);
            --shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 10px 30px rgba(0, 0, 0, 0.12);
            --radius: 10px;
            --radius-lg: 16px;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', 'Segoe UI', system-ui, sans-serif;
        }
        
        html {
            scroll-behavior: smooth;
        }
        
        body {
            background-color: var(--light);
            color: #333;
            line-height: 1.6;
            overflow-x: hidden;
        }
        
        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 24px;
        }
        
        /* Header */
        header {
            background-color: var(--white);
            padding: 1.4rem 0;
            box-shadow: var(--shadow-sm);
            position: sticky;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }
        
        .header-content {
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
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            width: 56px;
            height: 56px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            color: var(--white);
            box-shadow: 0 4px 12px rgba(26, 95, 35, 0.2);
            transition: transform 0.3s ease;
        }
        
        .logo:hover .logo-icon {
            transform: rotate(-5deg) scale(1.05);
        }
        
        .logo-text h1 {
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--dark);
            line-height: 1.2;
            letter-spacing: -0.5px;
        }
        
        .logo-text p {
            font-size: 0.85rem;
            color: var(--gray);
            font-weight: 500;
        }
        
        nav ul {
            display: flex;
            list-style: none;
            gap: 2.5rem;
        }
        
        nav a {
            color: var(--dark);
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s;
            position: relative;
            padding: 0.5rem 0;
        }
        
        nav a:hover {
            color: var(--primary);
        }
        
        nav a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 3px;
            background-color: var(--secondary);
            border-radius: 2px;
            transition: width 0.3s ease;
        }
        
        nav a:hover::after {
            width: 100%;
        }
        
        .header-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
        }
        
        .btn {
            padding: 0.85rem 2.2rem;
            border-radius: var(--radius);
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1rem;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: var(--white);
            box-shadow: 0 4px 12px rgba(26, 95, 35, 0.2);
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-light), var(--primary));
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(26, 95, 35, 0.3);
        }
        
        .btn-secondary {
            background-color: transparent;
            color: var(--primary);
            border: 2px solid var(--primary-light);
        }
        
        .btn-secondary:hover {
            background-color: rgba(26, 95, 35, 0.05);
            transform: translateY(-2px);
        }
        
        /* Hero Section */
        .hero {
            padding: 6rem 0 5rem;
            position: relative;
            overflow: hidden;
        }
        
        .hero-bg {
            position: absolute;
            top: 0;
            right: 0;
            width: 45%;
            height: 100%;
            background: linear-gradient(135deg, rgba(26, 95, 35, 0.03) 0%, rgba(46, 139, 50, 0.01) 100%);
            border-radius: 0 0 0 100px;
            z-index: -1;
        }
        
        .hero-content {
            display: grid;
            grid-template-columns: 1.1fr 1fr;
            gap: 5rem;
            align-items: center;
        }
        
        .hero-text h2 {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            color: var(--dark);
            letter-spacing: -1px;
        }
        
        .hero-text h2 span {
            color: var(--primary);
            position: relative;
        }
        
        .hero-text h2 span::after {
            content: '';
            position: absolute;
            bottom: 5px;
            left: 0;
            width: 100%;
            height: 10px;
            background-color: rgba(255, 193, 7, 0.25);
            z-index: -1;
            border-radius: 5px;
        }
        
        .hero-text p {
            font-size: 1.2rem;
            color: var(--gray);
            margin-bottom: 2.5rem;
            max-width: 580px;
        }
        
        .hero-buttons {
            display: flex;
            gap: 1.5rem;
            margin-bottom: 3.5rem;
        }
        
        .hero-stats {
            display: flex;
            gap: 3.5rem;
        }
        
        .stat-item {
            display: flex;
            flex-direction: column;
        }
        
        .stat-number {
            font-size: 2.8rem;
            font-weight: 800;
            color: var(--primary);
            line-height: 1;
            font-feature-settings: "tnum";
        }
        
        .stat-label {
            font-size: 0.95rem;
            color: var(--gray);
            font-weight: 500;
            margin-top: 0.5rem;
        }
        
        .hero-image {
            position: relative;
        }
        
        .dashboard-card {
            background-color: var(--white);
            border-radius: var(--radius-lg);
            padding: 2.5rem;
            box-shadow: var(--shadow-lg);
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .dashboard-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
        }
        
        .grade-display {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 220px;
            background: linear-gradient(135deg, rgba(26, 95, 35, 0.03), rgba(255, 193, 7, 0.03));
            border-radius: var(--radius-lg);
            margin-bottom: 2rem;
            border: 1px dashed rgba(26, 95, 35, 0.1);
        }
        
        .grade-value {
            font-size: 4.5rem;
            font-weight: 800;
            color: var(--primary);
            line-height: 1;
            margin-bottom: 0.5rem;
        }
        
        .grade-label {
            font-size: 1.1rem;
            color: var(--gray);
            font-weight: 500;
        }
        
        /* Features Section */
        .features {
            padding: 6rem 0;
            background-color: var(--white);
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 4.5rem;
        }
        
        .section-title h2 {
            font-size: 2.8rem;
            color: var(--dark);
            margin-bottom: 1.2rem;
            position: relative;
            display: inline-block;
        }
        
        .section-title h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background-color: var(--secondary);
            border-radius: 2px;
        }
        
        .section-title p {
            color: var(--gray);
            max-width: 700px;
            margin: 0 auto;
            font-size: 1.15rem;
            line-height: 1.7;
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(360px, 1fr));
            gap: 2.5rem;
        }
        
        .feature-card {
            background-color: var(--light);
            border-radius: var(--radius-lg);
            padding: 2.5rem;
            box-shadow: var(--shadow);
            transition: all 0.4s ease;
            border: 1px solid rgba(0, 0, 0, 0.05);
            position: relative;
            overflow: hidden;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-lg);
            border-color: rgba(26, 95, 35, 0.15);
        }
        
        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 0;
            background-color: var(--secondary);
            transition: height 0.4s ease;
        }
        
        .feature-card:hover::before {
            height: 100%;
        }
        
        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.8rem;
            color: var(--white);
            font-size: 32px;
            box-shadow: 0 6px 18px rgba(26, 95, 35, 0.15);
            transition: transform 0.3s ease;
        }
        
        .feature-card:hover .feature-icon {
            transform: scale(1.05) rotate(5deg);
        }
        
        .feature-card h3 {
            font-size: 1.5rem;
            color: var(--dark);
            margin-bottom: 1rem;
            font-weight: 700;
        }
        
        .feature-card p {
            color: var(--gray);
            line-height: 1.7;
        }
        
        /* Process Section */
        .process {
            padding: 6rem 0;
            background-color: var(--light);
        }
        
        .process-steps {
            display: flex;
            justify-content: space-between;
            margin-top: 4rem;
            position: relative;
        }
        
        .process-steps::before {
            content: '';
            position: absolute;
            top: 60px;
            left: 10%;
            right: 10%;
            height: 2px;
            background: linear-gradient(90deg, 
                var(--primary-light) 0%, 
                var(--secondary) 25%, 
                var(--accent) 50%, 
                var(--secondary) 75%, 
                var(--primary-light) 100%);
            z-index: 1;
        }
        
        .step {
            text-align: center;
            position: relative;
            z-index: 2;
            flex: 1;
            max-width: 260px;
        }
        
        .step-number {
            width: 100px;
            height: 100px;
            background-color: var(--white);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--primary);
            border: 8px solid var(--light);
            box-shadow: var(--shadow);
            position: relative;
        }
        
        .step-number::after {
            content: '';
            position: absolute;
            top: -8px;
            left: -8px;
            right: -8px;
            bottom: -8px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            z-index: -1;
            opacity: 0.2;
        }
        
        .step h3 {
            font-size: 1.4rem;
            color: var(--dark);
            margin-bottom: 1rem;
            font-weight: 700;
        }
        
        .step p {
            color: var(--gray);
            line-height: 1.6;
        }
        
        /* CTA Section */
        .cta-section {
            padding: 6rem 0;
            background: linear-gradient(135deg, var(--primary-dark), var(--primary));
            color: var(--white);
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .cta-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.03' fill-rule='evenodd'/%3E%3C/svg%3E");
        }
        
        .cta-section h2 {
            font-size: 3.2rem;
            margin-bottom: 1.5rem;
            font-weight: 800;
            position: relative;
            display: inline-block;
        }
        
        .cta-section p {
            font-size: 1.3rem;
            max-width: 700px;
            margin: 0 auto 3rem;
            opacity: 0.9;
            line-height: 1.7;
        }
        
        .cta-section .btn {
            background-color: var(--secondary);
            color: var(--dark);
            padding: 1.1rem 3.2rem;
            font-size: 1.2rem;
            font-weight: 700;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
        }
        
        .cta-section .btn:hover {
            background-color: var(--secondary-light);
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.25);
        }
        
        /* Footer */
        footer {
            background-color: var(--dark);
            color: var(--white);
            padding: 5rem 0 2.5rem;
        }
        
        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 3.5rem;
            margin-bottom: 4rem;
        }
        
        .footer-logo .logo-icon {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            margin-bottom: 1.8rem;
        }
        
        .footer-logo p {
            opacity: 0.8;
            line-height: 1.8;
            margin-bottom: 2rem;
        }
        
        .footer-links h3 {
            font-size: 1.3rem;
            margin-bottom: 1.8rem;
            color: var(--white);
            position: relative;
            padding-bottom: 10px;
        }
        
        .footer-links h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background-color: var(--secondary);
        }
        
        .footer-links ul {
            list-style: none;
        }
        
        .footer-links li {
            margin-bottom: 1rem;
        }
        
        .footer-links a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .footer-links a:hover {
            color: var(--white);
            transform: translateX(5px);
        }
        
        .copyright {
            text-align: center;
            padding-top: 2.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            opacity: 0.7;
            font-size: 0.9rem;
        }
        
        /* Responsive */
        @media (max-width: 1200px) {
            .hero-content {
                grid-template-columns: 1fr;
                gap: 4rem;
            }
            
            .hero-text h2 {
                font-size: 3rem;
            }
            
            .process-steps {
                flex-wrap: wrap;
                gap: 3.5rem;
            }
            
            .process-steps::before {
                display: none;
            }
        }
        
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 1.8rem;
            }
            
            nav ul {
                gap: 1.5rem;
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .hero-text h2 {
                font-size: 2.5rem;
            }
            
            .hero-buttons {
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
                font-size: 2.2rem;
            }
            
            .features-grid {
                grid-template-columns: 1fr;
            }
            
            .cta-section h2 {
                font-size: 2.5rem;
            }
        }
        
        @media (max-width: 480px) {
            .hero-text h2 {
                font-size: 2.2rem;
            }
            
            .section-title h2 {
                font-size: 1.9rem;
            }
            
            .cta-section h2 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container header-content">
            <a href="#" class="logo">
                <div class="logo-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="logo-text">
                    <h1>Uganda National Grading System</h1>
                    <p>Idaad & Thanawi Examination Results</p>
                </div>
            </a>
            
            <nav>
                <ul>
                    <li><a href="#home">Home</a></li>
                    <li><a href="#features">Features</a></li>
                    <li><a href="#process">How It Works</a></li>
                    <li><a href="#resources">Resources</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </nav>
            
            <div class="header-actions">
                <button class="btn btn-secondary">
                    <i class="fas fa-sign-in-alt"></i> Login
                </button>
                <button class="btn btn-primary">
                    <i class="fas fa-user-plus"></i> Register
                </button>
            </div>
        </div>
    </header>
    
    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="hero-bg"></div>
        <div class="container hero-content">
            <div class="hero-text">
                <h2>Standardized Grading for <span>All Uganda Students</span></h2>
                <p>A comprehensive national system for grading Idaad and Thanawi examination results with accuracy, transparency, and efficiency. Ensuring fair assessment for every student across Uganda.</p>
                
                <div class="hero-buttons">
                    <button class="btn btn-primary">
                        <i class="fas fa-rocket"></i> Get Started Now
                    </button>
                    <button class="btn btn-secondary">
                        <i class="fas fa-play-circle"></i> Watch Demo
                    </button>
                </div>
                
                <div class="hero-stats">
                    <div class="stat-item">
                        <div class="stat-number">100%</div>
                        <div class="stat-label">Accuracy Guaranteed</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">24/7</div>
                        <div class="stat-label">System Availability</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">2,500+</div>
                        <div class="stat-label">Schools Registered</div>
                    </div>
                </div>
            </div>
            
            <div class="hero-image">
                <div class="dashboard-card">
                    <div class="grade-display">
                        <div class="grade-value">A+</div>
                        <div class="grade-label">Top Performance Grade</div>
                    </div>
                    <div style="text-align: center; color: var(--gray); font-size: 0.95rem;">
                        <i class="fas fa-chart-line" style="color: var(--primary); margin-right: 6px;"></i>
                        <strong>18% improvement</strong> in grading efficiency since system implementation
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Features Section -->
    <section class="features" id="features">
        <div class="container">
            <div class="section-title">
                <h2>Advanced System Features</h2>
                <p>Our platform provides comprehensive tools for accurate and efficient grading of Idaad and Thanawi examination results nationwide with cutting-edge technology.</p>
            </div>
            
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-robot"></i>
                    </div>
                    <h3>AI-Powered Grading</h3>
                    <p>Advanced algorithms ensure consistent and accurate grading based on national standards, reducing human error and bias with machine learning technology.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3>Enterprise Security</h3>
                    <p>Military-grade encryption, multi-factor authentication, and secure data storage protect student information and examination integrity.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chart-network"></i>
                    </div>
                    <h3>Advanced Analytics</h3>
                    <p>Generate detailed reports, performance analytics, and educational insights for students, schools, and national education authorities.</p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Process Section -->
    <section class="process" id="process">
        <div class="container">
            <div class="section-title">
                <h2>How The System Works</h2>
                <p>A streamlined 4-step process that ensures accuracy and transparency in grading Idaad and Thanawi examinations nationwide.</p>
            </div>
            
            <div class="process-steps">
                <div class="step">
                    <div class="step-number">1</div>
                    <h3>Data Submission</h3>
                    <p>Schools securely upload examination data through our encrypted portal with automatic validation and error checking.</p>
                </div>
                
                <div class="step">
                    <div class="step-number">2</div>
                    <h3>Automated Processing</h3>
                    <p>System processes and grades results using standardized national grading criteria powered by advanced algorithms.</p>
                </div>
                
                <div class="step">
                    <div class="step-number">3</div>
                    <h3>Quality Assurance</h3>
                    <p>Education authorities review and validate grades through a multi-tier approval process before final publication.</p>
                </div>
                
                <div class="step">
                    <div class="step-number">4</div>
                    <h3>Result Distribution</h3>
                    <p>Students and schools access final grades through secure online portals, mobile apps, and SMS notifications.</p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <h2>Ready to Transform Education Assessment?</h2>
            <p>Join thousands of schools and educational institutions across Uganda using our national grading system for accurate and transparent examination results.</p>
            <button class="btn">
                <i class="fas fa-arrow-right"></i> Access Results Portal
            </button>
        </div>
    </section>
    
    <!-- Footer -->
    <footer id="contact">
        <div class="container">
            <div class="footer-content">
                <div class="footer-logo">
                    <div class="logo-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <p>The Uganda National Grading System ensures fair, accurate, and transparent assessment of Idaad and Thanawi examination results for all students nationwide under the Ministry of Education and Sports.</p>
                    <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
                        <div style="width: 42px; height: 42px; background: rgba(255,255,255,0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                            <i class="fab fa-twitter"></i>
                        </div>
                        <div style="width: 42px; height: 42px; background: rgba(255,255,255,0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                            <i class="fab fa-facebook-f"></i>
                        </div>
                        <div style="width: 42px; height: 42px; background: rgba(255,255,255,0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                            <i class="fab fa-linkedin-in"></i>
                        </div>
                    </div>
                </div>
                
                <div class="footer-links">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="#home"><i class="fas fa-home"></i> Home</a></li>
                        <li><a href="#features"><i class="fas fa-star"></i> Features</a></li>
                        <li><a href="#process"><i class="fas fa-cogs"></i> How It Works</a></li>
                        <li><a href="#resources"><i class="fas fa-book"></i> Resources</a></li>
                        <li><a href="#contact"><i class="fas fa-envelope"></i> Contact Us</a></li>
                    </ul>
                </div>
                
                <div class="footer-links">
                    <h3>Resources</h3>
                    <ul>
                        <li><a href="#"><i class="fas fa-file-alt"></i> Grading Criteria</a></li>
                        <li><a href="#"><i class="fas fa-book-open"></i> User Manual</a></li>
                        <li><a href="#"><i class="fas fa-question-circle"></i> FAQs</a></li>
                        <li><a href="#"><i class="fas fa-download"></i> System Updates</a></li>
                        <li><a href="#"><i class="fas fa-shield-alt"></i> Privacy Policy</a></li>
                    </ul>
                </div>
                
                <div class="footer-links">
                    <h3>Contact Us</h3>
                    <ul>
                        <li><a href="#"><i class="fas fa-map-marker-alt"></i> Ministry of Education & Sports, Kampala</a></li>
                        <li><a href="#"><i class="fas fa-phone"></i> +256 312 123 456</a></li>
                        <li><a href="#"><i class="fas fa-envelope"></i> info@ugandagrading.go.ug</a></li>
                        <li><a href="#"><i class="fas fa-clock"></i> Mon-Fri: 8:00 AM - 5:00 PM</a></li>
                        <li><a href="#"><i class="fas fa-globe"></i> www.ugandagrading.go.ug</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="copyright">
                <p>&copy; 2023 Uganda National Grading System. All rights reserved. | Part of the Ministry of Education and Sports, Republic of Uganda</p>
            </div>
        </div>
    </footer>
    
    <script>
        // Header scroll effect
        const header = document.querySelector('header');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                header.style.boxShadow = '0 6px 20px rgba(0, 0, 0, 0.1)';
                header.style.padding = '1rem 0';
            } else {
                header.style.boxShadow = 'var(--shadow-sm)';
                header.style.padding = '1.4rem 0';
            }
        });
        
        // Button interactions
        document.querySelectorAll('.btn').forEach(button => {
            button.addEventListener('click', function() {
                if(this.textContent.includes('Get Started') || this.textContent.includes('Access')) {
                    alert('Redirecting to the secure portal login page...');
                } else if(this.textContent.includes('Login')) {
                    alert('Opening secure login panel...');
                } else if(this.textContent.includes('Register')) {
                    alert('Redirecting to registration page...');
                } else if(this.textContent.includes('Demo')) {
                    alert('Playing system demonstration video...');
                } else {
                    alert('Action triggered: ' + this.textContent.trim());
                }
            });
        });
        
        // Animate elements on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if(entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);
        
        // Observe feature cards
        document.querySelectorAll('.feature-card').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            card.style.transition = 'opacity 0.6s, transform 0.6s';
            observer.observe(card);
        });
        
        // Observe process steps
        document.querySelectorAll('.step').forEach(step => {
            step.style.opacity = '0';
            step.style.transform = 'translateY(30px)';
            step.style.transition = 'opacity 0.6s, transform 0.6s';
            observer.observe(step);
        });
        
        // Counter animation for stats
        const statNumbers = document.querySelectorAll('.stat-number');
        statNumbers.forEach(stat => {
            const target = parseInt(stat.textContent.replace(/[^0-9]/g, ''));
            const suffix = stat.textContent.replace(/[0-9]/g, '');
            let count = 0;
            
            const increment = () => {
                if (count < target) {
                    count += Math.ceil(target / 50);
                    if (count > target) count = target;
                    stat.textContent = count + suffix;
                    setTimeout(increment, 30);
                }
            };
            
            const statObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        setTimeout(increment, 300);
                        statObserver.unobserve(entry.target);
                    }
                });
            });
            
            statObserver.observe(stat);
        });
    </script>
</body>
</html>