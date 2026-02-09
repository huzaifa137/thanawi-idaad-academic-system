<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Results Portal | Uganda Examination Grading System</title>
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
            --success: #28A745;
            --warning: #FFC107;
            --danger: #DC3545;
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
            background-color: var(--light);
            color: var(--dark);
            line-height: 1.7;
            font-weight: 400;
            min-height: 100vh;
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
            margin-left: auto;
            margin-right: 2rem;
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
            text-decoration: none;
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

        .btn-secondary {
            background-color: var(--secondary);
            color: var(--dark);
        }

        .btn-secondary:hover {
            background-color: #ffb700;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(242, 169, 0, 0.15);
        }

        /* Portal Hero */
        .portal-hero {
            padding: 12rem 0 6rem;
            background: linear-gradient(135deg, rgba(13, 75, 30, 0.95), rgba(30, 122, 61, 0.85)),
                url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80');
            background-size: cover;
            background-position: center;
            color: var(--white);
            text-align: center;
            position: relative;
        }

        .portal-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 20% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
        }

        .portal-hero-content {
            position: relative;
            z-index: 2;
            max-width: 800px;
            margin: 0 auto;
        }

        .portal-hero h1 {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .portal-hero p {
            font-size: 1.25rem;
            opacity: 0.9;
            margin-bottom: 3rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Main Portal Section */
        .portal-main {
            padding: 6rem 0;
            background-color: var(--white);
        }

        .portal-container {
            display: grid;
            grid-template-columns: 1.2fr 0.8fr;
            gap: 4rem;
            align-items: start;
        }

        /* Result Lookup Card */
        .lookup-card {
            background: var(--white);
            border-radius: var(--radius-lg);
            padding: 3rem;
            box-shadow: var(--shadow-lg);
            border: 1px solid rgba(0, 0, 0, 0.05);
            margin-bottom: 3rem;
        }

        .lookup-card h2 {
            font-size: 2rem;
            color: var(--dark);
            margin-bottom: 0.5rem;
            font-weight: 700;
        }

        .lookup-card p {
            color: var(--gray);
            margin-bottom: 2.5rem;
        }

        .form-group {
            margin-bottom: 2rem;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.75rem;
            color: var(--dark);
            font-size: 1rem;
        }

        .form-control {
            width: 100%;
            padding: 1rem 1.5rem;
            border: 2px solid var(--gray-light);
            border-radius: var(--radius);
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: var(--white);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-light);
            box-shadow: 0 0 0 3px rgba(13, 75, 30, 0.1);
        }

        .form-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%235F6C72' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1.5rem center;
            background-size: 16px;
            padding-right: 3rem;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        .captcha-container {
            background-color: var(--light);
            padding: 1.5rem;
            border-radius: var(--radius);
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .captcha-code {
            font-family: 'Courier New', monospace;
            font-size: 1.8rem;
            font-weight: 700;
            letter-spacing: 5px;
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            padding: 0.5rem 1rem;
            border: 1px dashed var(--primary-light);
            border-radius: 8px;
        }

        .btn-block {
            width: 100%;
            padding: 1.2rem;
            font-size: 1.1rem;
            font-weight: 700;
        }

        .portal-info {
            background-color: var(--light);
            border-radius: var(--radius-lg);
            padding: 2.5rem;
            height: fit-content;
            box-shadow: var(--shadow);
        }

        .portal-info h3 {
            font-size: 1.5rem;
            color: var(--dark);
            margin-bottom: 1.5rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .portal-info h3 i {
            color: var(--primary);
        }

        .info-list {
            list-style: none;
            margin-bottom: 2rem;
        }

        .info-list li {
            margin-bottom: 1.25rem;
            padding-left: 2rem;
            position: relative;
        }

        .info-list li::before {
            content: '✓';
            position: absolute;
            left: 0;
            color: var(--success);
            font-weight: bold;
        }

        .alert {
            padding: 1.25rem;
            border-radius: var(--radius);
            margin-bottom: 2rem;
            display: flex;
            align-items: flex-start;
            gap: 1rem;
        }

        .alert-info {
            background-color: rgba(13, 75, 30, 0.08);
            border-left: 4px solid var(--primary);
        }

        .alert-warning {
            background-color: rgba(255, 193, 7, 0.1);
            border-left: 4px solid var(--warning);
        }

        .alert-icon {
            font-size: 1.25rem;
            margin-top: 0.25rem;
        }

        /* Results Display */
        .results-section {
            display: none;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .results-card {
            background: linear-gradient(135deg, var(--white) 0%, var(--light) 100%);
            border-radius: var(--radius-lg);
            padding: 3rem;
            box-shadow: var(--shadow-lg);
            margin-top: 2rem;
        }

        .student-header {
            text-align: center;
            margin-bottom: 3rem;
            padding-bottom: 2rem;
            border-bottom: 2px solid var(--gray-light);
        }

        .student-header h2 {
            color: var(--primary);
            font-size: 2.2rem;
            margin-bottom: 0.5rem;
        }

        .student-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
            background-color: var(--light);
            padding: 1.5rem;
            border-radius: var(--radius);
        }

        .info-item {
            display: flex;
            flex-direction: column;
        }

        .info-label {
            font-size: 0.85rem;
            color: var(--gray);
            margin-bottom: 0.25rem;
        }

        .info-value {
            font-weight: 600;
            color: var(--dark);
            font-size: 1.1rem;
        }

        .results-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 3rem;
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        .results-table thead {
            background-color: var(--primary);
            color: var(--white);
        }

        .results-table th {
            padding: 1.25rem 1.5rem;
            text-align: left;
            font-weight: 600;
            font-size: 1rem;
        }

        .results-table tbody tr {
            border-bottom: 1px solid var(--gray-light);
            transition: background-color 0.3s ease;
        }

        .results-table tbody tr:hover {
            background-color: var(--light);
        }

        .results-table td {
            padding: 1.25rem 1.5rem;
            color: var(--dark);
        }

        .grade {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-weight: 700;
            text-align: center;
            min-width: 60px;
        }

        .grade-a {
            background-color: rgba(40, 167, 69, 0.15);
            color: var(--success);
        }

        .grade-b {
            background-color: rgba(13, 75, 30, 0.15);
            color: var(--primary);
        }

        .grade-c {
            background-color: rgba(255, 193, 7, 0.15);
            color: var(--warning);
        }

        .summary-section {
            background: linear-gradient(135deg, rgba(13, 75, 30, 0.05) 0%, rgba(30, 122, 61, 0.03) 100%);
            padding: 2rem;
            border-radius: var(--radius);
            margin-top: 3rem;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
        }

        .summary-item {
            text-align: center;
        }

        .summary-value {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--primary);
            line-height: 1;
            margin-bottom: 0.5rem;
        }

        .summary-label {
            font-size: 0.9rem;
            color: var(--gray);
            font-weight: 500;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 3rem;
            justify-content: center;
        }

        /* Footer */
        footer {
            background-color: var(--dark);
            color: var(--white);
            padding: 5rem 0 2.5rem;
            margin-top: 6rem;
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
        @media (max-width: 992px) {
            .portal-container {
                grid-template-columns: 1fr;
            }

            .portal-hero h1 {
                font-size: 2.8rem;
            }
        }

        @media (max-width: 768px) {
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

            .portal-hero {
                padding: 10rem 0 4rem;
            }

            .portal-hero h1 {
                font-size: 2.4rem;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .lookup-card {
                padding: 2rem;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                text-align: center;
            }

            .footer-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 2.5rem;
            }
        }

        @media (max-width: 576px) {
            .portal-hero h1 {
                font-size: 2rem;
            }

            .lookup-card h2 {
                font-size: 1.5rem;
            }

            .student-info {
                grid-template-columns: 1fr;
            }

            .results-table {
                display: block;
                overflow-x: auto;
            }

            .footer-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Loading Spinner */
        .loading-spinner {
            display: none;
            text-align: center;
            padding: 3rem;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid var(--gray-light);
            border-top: 5px solid var(--primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 1.5rem;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
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
                    <p>Student Results Portal</p>
                </div>
            </a>

            <nav class="nav-menu">
                <a href="{{ url('/') }}" class="nav-link"><i class="fas fa-home"></i> Home</a>
                <a href="#lookup-form" class="nav-link"><i class="fas fa-search"></i> Check Results</a>
                <a href="#help" class="nav-link"><i class="fas fa-question-circle"></i> Help</a>
                <a href="#contact" class="nav-link"><i class="fas fa-envelope"></i> Contact</a>
            </nav>

            <div class="header-cta">
                <a href="{{ url('users/login') }}" class="btn btn-outline">
                    <i class="fas fa-sign-in-alt"></i> Login
                </a>
            </div>
        </div>
    </header>

    <!-- Portal Hero Section -->
    <section class="portal-hero" id="portal">
        <div class="container portal-hero-content">
            <h1>Check Your Examination Results</h1>
            <p>Enter your registration details to access your Idaad or Thanawi examination results instantly. Secure,
                reliable, and official.</p>
            <a href="#lookup-form" class="btn btn-secondary">
                <i class="fas fa-arrow-down"></i> Check Results Now
            </a>
        </div>
    </section>

    <!-- Main Portal Section -->
    <section class="portal-main">
        <div class="container portal-container">
            <!-- Left Column: Results Lookup Form -->
            <div class="portal-left">
                <div class="lookup-card" id="lookup-form">
                    <h2>Results Lookup</h2>
                    <p>Enter your examination details to retrieve your results</p>

                    <form id="resultsForm">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="registrationNumber">
                                    <i class="fas fa-id-card"></i> Registration Number *
                                </label>
                                <input type="text" id="registrationNumber" class="form-control"
                                    placeholder="e.g., U123456789" required maxlength="20">
                            </div>

                            <div class="form-group">
                                <label for="examYear">
                                    <i class="fas fa-calendar-alt"></i> Examination Year *
                                </label>
                                <select id="examYear" class="form-control form-select" required>
                                    <option value="">Select Year</option>
                                    <option value="2025">2025</option>
                                    <option value="2024">2024</option>
                                    <option value="2023">2023</option>
                                    <option value="2022">2022</option>
                                    <option value="2021">2021</option>
                                    <option value="2020">2020</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="examType">
                                    <i class="fas fa-graduation-cap"></i> Examination Type *
                                </label>
                                <select id="examType" class="form-control form-select" required>
                                    <option value="">Select Exam Type</option>
                                    <option value="idaad">Idaad (Ordinary Level)</option>
                                    <option value="thanawi">Thanawi (Advanced Level)</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="centerNumber">
                                    <i class="fas fa-school"></i> Center Number
                                </label>
                                <input type="text" id="centerNumber" class="form-control" placeholder="Optional">
                            </div>
                        </div>

                        <div class="captcha-container">
                            <div>
                                <label for="captchaInput">
                                    <i class="fas fa-shield-alt"></i> Security Verification
                                </label>
                                <div class="captcha-code" id="captchaText">A3B7C9</div>
                            </div>
                            <div style="flex: 1;">
                                <input type="text" id="captchaInput" class="form-control"
                                    placeholder="Enter the code above" required maxlength="6">
                            </div>
                            <button type="button" class="btn btn-outline" id="refreshCaptcha">
                                <i class="fas fa-redo"></i>
                            </button>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle alert-icon"></i>
                            <div>
                                <strong>Privacy Notice:</strong> Your results are confidential and will only be
                                displayed after successful verification. All data transmission is encrypted.
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-search"></i> Retrieve Results
                        </button>
                    </form>
                </div>

                <!-- Loading Spinner -->
                <div class="loading-spinner" id="loadingSpinner">
                    <div class="spinner"></div>
                    <p>Retrieving your results...</p>
                    <p class="text-muted">This may take a few moments</p>
                </div>

                <!-- Results Display Section -->
                <div class="results-section" id="resultsSection">
                    <div class="results-card">
                        <div class="student-header">
                            <h2 id="studentName">John Kateregga</h2>
                            <p id="studentProgram">Science - Advanced Level</p>
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle alert-icon"></i>
                                <div>
                                    <strong>Results Verified:</strong> Official examination results for <span
                                        id="examDetails">2025 Thanawi Examination</span>
                                </div>
                            </div>
                        </div>

                        <div class="student-info">
                            <div class="info-item">
                                <span class="info-label">Registration Number</span>
                                <span class="info-value" id="displayRegNo">U123456789</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Center Name</span>
                                <span class="info-value" id="displayCenter">Kampala High School</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Examination Year</span>
                                <span class="info-value" id="displayYear">2025</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Index Number</span>
                                <span class="info-value" id="displayIndex">UGN234567</span>
                            </div>
                        </div>

                        <table class="results-table">
                            <thead>
                                <tr>
                                    <th>Subject</th>
                                    <th>Paper Code</th>
                                    <th>Marks</th>
                                    <th>Grade</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody id="resultsTableBody">
                                <!-- Results will be populated here -->
                            </tbody>
                        </table>

                        <div class="summary-section">
                            <div class="summary-grid">
                                <div class="summary-item">
                                    <div class="summary-value" id="totalPoints">18</div>
                                    <div class="summary-label">Total Points</div>
                                </div>
                                <div class="summary-item">
                                    <div class="summary-value" id="division">I</div>
                                    <div class="summary-label">Division</div>
                                </div>
                                <div class="summary-item">
                                    <div class="summary-value" id="aggregate">12</div>
                                    <div class="summary-label">Aggregate</div>
                                </div>
                                <div class="summary-item">
                                    <div class="summary-value" id="overallGrade">A</div>
                                    <div class="summary-label">Overall Grade</div>
                                </div>
                            </div>
                        </div>

                        <div class="action-buttons">
                            <button class="btn btn-primary" id="printResults">
                                <i class="fas fa-print"></i> Print Results
                            </button>
                            <button class="btn btn-outline" id="downloadResults">
                                <i class="fas fa-download"></i> Download PDF
                            </button>
                            <button class="btn btn-outline" id="newSearch">
                                <i class="fas fa-search"></i> New Search
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Information -->
            <div class="portal-info">
                <h3><i class="fas fa-info-circle"></i> Important Information</h3>

                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle alert-icon"></i>
                    <div>
                        <strong>Official Results:</strong> These results are provisional until confirmed by the
                        examination board.
                    </div>
                </div>

                <ul class="info-list">
                    <li>Results are typically released 6-8 weeks after examinations</li>
                    <li>Verify all personal details match your registration information</li>
                    <li>Contact your school administration for result discrepancies</li>
                    <li>Keep your registration number confidential</li>
                    <li>Printed results require official school stamp for verification</li>
                </ul>

                <h3 id="help"><i class="fas fa-question-circle"></i> Frequently Asked Questions</h3>

                <div class="faq-item">
                    <h4>When are results released?</h4>
                    <p>Idaad results: March, Thanawi results: May each year.</p>
                </div>

                <div class="faq-item">
                    <h4>What if I forgot my registration number?</h4>
                    <p>Contact your school administration or the examination board with your personal details.</p>
                </div>

                <div class="faq-item">
                    <h4>Are these results final?</h4>
                    <p>Results are provisional until officially confirmed by the examination board.</p>
                </div>

                <div class="alert alert-info" style="margin-top: 2rem;">
                    <i class="fas fa-phone-alt alert-icon"></i>
                    <div>
                        <strong>Need Help?</strong> Contact support: <br>
                        <strong>Phone:</strong> +256 800 123 456<br>
                        <strong>Email:</strong> results@ugresults.go.ug
                    </div>
                </div>
            </div>
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
                    <p>The official national platform for Idaad and Thanawi examination results, developed in
                        partnership with Uganda's Ministry of Education and Sports.</p>
                    <div class="social-icons">
                        <a href="javascript:void(0)" class="social-icon">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="javascript:void(0)" class="social-icon">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="javascript:void(0)" class="social-icon">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>

                <div class="footer-col">
                    <h3>Quick Links</h3>
                    <ul class="footer-links">
                        <li><a href="{{ url('/') }}"><i class="fas fa-home"></i> Home</a></li>
                        <li><a href="#portal"><i class="fas fa-search"></i> Check Results</a></li>
                        <li><a href="#help"><i class="fas fa-question-circle"></i> Help</a></li>
                        <li><a href="#contact"><i class="fas fa-envelope"></i> Contact</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h3>Examination Resources</h3>
                    <ul class="footer-links">
                        <li><a href="javascript:void(0)"><i class="fas fa-file-pdf"></i> Grading System</a></li>
                        <li><a href="javascript:void(0)"><i class="fas fa-calendar"></i> Examination Calendar</a></li>
                        <li><a href="javascript:void(0)"><i class="fas fa-book"></i> Syllabus</a></li>
                        <li><a href="javascript:void(0)"><i class="fas fa-newspaper"></i> Announcements</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h3>Contact Information</h3>
                    <ul class="footer-links">
                        <li><a href="javascript:void(0)"><i class="fas fa-map-marker-alt"></i> Ministry of Education,
                                Kampala</a></li>
                        <li><a href="javascript:void(0)"><i class="fas fa-phone"></i> +256 800 123 456</a></li>
                        <li><a href="javascript:void(0)"><i class="fas fa-envelope"></i> support@ugresults.go.ug</a>
                        </li>
                        <li><a href="javascript:void(0)"><i class="fas fa-clock"></i> Mon-Fri: 8:00 AM - 6:00 PM</a>
                        </li>
                        <li><a href="javascript:void(0)"><i class="fas fa-globe"></i> www.ugresults.go.ug</a></li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <p>
                    &copy; <span id="year"></span> Uganda Examination Grading System.
                    All rights reserved. | Ministry of Education and Sports
                </p>
            </div>
        </div>
    </footer>

    <script>
        // Set current year in footer
        document.getElementById('year').textContent = new Date().getFullYear();

        // Header scroll effect
        const header = document.getElementById('main-header');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                header.classList.add('header-scrolled');
            } else {
                header.classList.remove('header-scrolled');
            }
        });

        // Generate random CAPTCHA
        function generateCaptcha() {
            const chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
            let captcha = '';
            for (let i = 0; i < 6; i++) {
                captcha += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            document.getElementById('captchaText').textContent = captcha;
            return captcha;
        }

        let currentCaptcha = generateCaptcha();

        // Refresh CAPTCHA
        document.getElementById('refreshCaptcha').addEventListener('click', () => {
            currentCaptcha = generateCaptcha();
        });

        // Sample results data
        const sampleResults = {
            studentName: "Ismail Kateregga",
            program: "Thanawi - Advanced Level",
            regNo: "U123456789",
            center: "Kampala High School",
            year: "2025",
            indexNo: "UGN234567",
            examType: "Thanawi Examination",
            subjects: [{
                    name: "Mathematics",
                    code: "MAT401",
                    marks: 85,
                    grade: "A",
                    remarks: "Excellent"
                },
                {
                    name: "Physics",
                    code: "PHY402",
                    marks: 78,
                    grade: "B+",
                    remarks: "Very Good"
                },
                {
                    name: "Chemistry",
                    code: "CHE403",
                    marks: 82,
                    grade: "A-",
                    remarks: "Excellent"
                },
                {
                    name: "Biology",
                    code: "BIO404",
                    marks: 76,
                    grade: "B",
                    remarks: "Good"
                },
                {
                    name: "Computer Studies",
                    code: "COM405",
                    marks: 90,
                    grade: "A+",
                    remarks: "Outstanding"
                },
                {
                    name: "General Paper",
                    code: "GP406",
                    marks: 65,
                    grade: "C+",
                    remarks: "Satisfactory"
                }
            ],
            totalPoints: 18,
            division: "I",
            aggregate: 12,
            overallGrade: "A"
        };

        // Form submission
        document.getElementById('resultsForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Validate CAPTCHA
            const captchaInput = document.getElementById('captchaInput').value.toUpperCase();
            if (captchaInput !== currentCaptcha) {
                alert('Invalid CAPTCHA code. Please try again.');
                generateCaptcha();
                return;
            }

            // Show loading spinner
            document.getElementById('loadingSpinner').style.display = 'block';
            document.getElementById('resultsSection').style.display = 'none';

            // Simulate API call delay
            setTimeout(() => {
                // Hide loading spinner
                document.getElementById('loadingSpinner').style.display = 'none';

                // Populate results
                populateResults();

                // Show results section
                document.getElementById('resultsSection').style.display = 'block';

                // Scroll to results
                document.getElementById('resultsSection').scrollIntoView({
                    behavior: 'smooth'
                });

                // Generate new CAPTCHA for next search
                currentCaptcha = generateCaptcha();
                document.getElementById('captchaInput').value = '';

            }, 1500);
        });

        // Populate results with sample data
        function populateResults() {
            // Set student info
            document.getElementById('studentName').textContent = sampleResults.studentName;
            document.getElementById('studentProgram').textContent = sampleResults.program;
            document.getElementById('displayRegNo').textContent = sampleResults.regNo;
            document.getElementById('displayCenter').textContent = sampleResults.center;
            document.getElementById('displayYear').textContent = sampleResults.year;
            document.getElementById('displayIndex').textContent = sampleResults.indexNo;
            document.getElementById('examDetails').textContent = `${sampleResults.year} ${sampleResults.examType}`;

            // Set summary values
            document.getElementById('totalPoints').textContent = sampleResults.totalPoints;
            document.getElementById('division').textContent = sampleResults.division;
            document.getElementById('aggregate').textContent = sampleResults.aggregate;
            document.getElementById('overallGrade').textContent = sampleResults.overallGrade;

            // Populate results table
            const tableBody = document.getElementById('resultsTableBody');
            tableBody.innerHTML = '';

            sampleResults.subjects.forEach(subject => {
                const gradeClass = subject.grade.startsWith('A') ? 'grade-a' :
                    subject.grade.startsWith('B') ? 'grade-b' : 'grade-c';

                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${subject.name}</td>
                    <td>${subject.code}</td>
                    <td>${subject.marks}</td>
                    <td><span class="grade ${gradeClass}">${subject.grade}</span></td>
                    <td>${subject.remarks}</td>
                `;
                tableBody.appendChild(row);
            });
        }

        // Print results
        document.getElementById('printResults').addEventListener('click', () => {
            const printContent = document.querySelector('.results-card').innerHTML;
            const originalContent = document.body.innerHTML;

            document.body.innerHTML = `
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Official Results - Uganda Examination Board</title>
                    <style>
                        body { font-family: Arial, sans-serif; padding: 20px; }
                        .student-header { text-align: center; margin-bottom: 30px; }
                        .student-info { display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; margin-bottom: 30px; }
                        .info-item { margin-bottom: 10px; }
                        .info-label { font-size: 12px; color: #666; }
                        .info-value { font-weight: bold; }
                        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
                        th { background-color: #0D4B1E; color: white; padding: 12px; text-align: left; }
                        td { padding: 10px; border-bottom: 1px solid #ddd; }
                        .grade { padding: 5px 10px; border-radius: 20px; font-weight: bold; }
                        .summary-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-top: 30px; }
                        .summary-item { text-align: center; }
                        .summary-value { font-size: 24px; font-weight: bold; }
                        .print-footer { margin-top: 50px; text-align: center; font-size: 12px; color: #666; }
                    </style>
                </head>
                <body>
                    ${printContent}
                    <div class="print-footer">
                        <p>Printed on: ${new Date().toLocaleDateString()} | Official Document - Uganda Examination Board</p>
                        <p>This is a computer-generated document. No signature required.</p>
                    </div>
                </body>
                </html>
            `;

            window.print();
            document.body.innerHTML = originalContent;
            window.location.reload();
        });

        // Download results as PDF
        document.getElementById('downloadResults').addEventListener('click', () => {
            alert('PDF download functionality would be implemented here with a proper PDF generation library.');
        });

        // New search
        document.getElementById('newSearch').addEventListener('click', () => {
            document.getElementById('resultsSection').style.display = 'none';
            document.getElementById('resultsForm').reset();
            currentCaptcha = generateCaptcha();
            document.getElementById('captchaInput').value = '';

            // Scroll to form
            document.getElementById('lookup-form').scrollIntoView({
                behavior: 'smooth'
            });
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;

                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    targetElement.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Animate elements on scroll
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

        // Animate portal info and cards
        document.querySelectorAll('.lookup-card, .portal-info, .feature').forEach(element => {
            element.style.opacity = '0';
            element.style.transform = 'translateY(20px)';
            element.style.transition = 'opacity 0.6s, transform 0.6s';
            observer.observe(element);
        });
    </script>
</body>

</html>
