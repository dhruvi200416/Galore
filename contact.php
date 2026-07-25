<?php
include 'contact_handle.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | RKU Galore</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        :root {
            --galore-red: #dc3545;
            --galore-red-dark: #b02a37;
            --galore-gray: #6c757d;
            --galore-white: #ffffff;
        }

        body {
            font-family: 'Segoe UI', Roboto, sans-serif;
            margin: 0;
            min-height: 100vh;
        }

        /* HERO SECTION */
        .hero {
            background: linear-gradient(135deg, #dc3545 0%, #b02a37 100%);
            color: white;
            text-align: center;
            padding: 120px 20px;
            position: relative;
            overflow: hidden;
        }

        .hero h1 {
            font-size: 4rem;
            font-weight: 800;
            margin-bottom: 20px;
            animation: fadeInDown 0.8s ease;
        }

        .hero p {
            font-size: 1.2rem;
            opacity: 0.9;
            animation: fadeInUp 0.8s ease 0.2s forwards;
            opacity: 0;
            animation-fill-mode: forwards;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .hero {
                padding: 80px 20px;
            }
            
            .hero h1 {
                font-size: 2.5rem;
            }

            .hero p {
                font-size: 1rem;
            }
        }

        /* Welcome Banner for Logged-in Users */
        .welcome-banner {
            background: linear-gradient(135deg, #961837 0%, #890e2b 100%);
            color: white;
            padding: 12px 20px;
            border-radius: 10px;
            margin-bottom: 25px;
            text-align: center;
            animation: fadeSlide 0.5s ease;
        }

        .welcome-banner i {
            margin-right: 10px;
        }

        /* ===== CONTACT CARD ===== */
        .galore-wrapper {
            display: flex;
            justify-content: center;
            padding: 60px 20px;
        }

        .galore-card {
            background: #fff;
            width: 100%;
            max-width: 900px;
            padding: 45px;
            border-radius: 18px;
            border-top: 6px solid var(--galore-red);
            box-shadow: 0 20px 45px rgba(220, 53, 69, 0.18);
            animation: fadeSlide 0.8s ease;
        }

        @keyframes fadeSlide {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .galore-title {
            text-align: center;
            color: var(--galore-red);
            font-size: 2.2rem;
            margin-bottom: 8px;
        }

        .galore-subtitle {
            text-align: center;
            font-size: 0.9rem;
            color: var(--galore-gray);
            margin-bottom: 35px;
        }

        .galore-input-group {
            display: flex;
            flex-direction: column;
            position: relative;
            margin-bottom: 18px;
        }

        .galore-label {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--galore-gray);
            margin-bottom: 6px;
            text-transform: uppercase;
        }

        .galore-input {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #ddd;
            border-radius: 10px;
            font-size: 0.95rem;
            transition: 0.3s;
        }

        .galore-input:focus {
            outline: none;
            border-color: var(--galore-red);
            box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.15);
        }

        .galore-input:read-only {
            background-color: #e9ecef;
            cursor: not-allowed;
        }

        .galore-input.is-valid {
            border-color: #198754;
        }
        
        .galore-input.is-invalid {
            border-color: #dc3545;
        }

        .error-feedback {
            font-size: 0.8rem;
            color: #dc3545;
            margin-top: 5px;
            display: none;
        }
        
        .error-feedback.show {
            display: block;
        }

        textarea.galore-input {
            resize: none;
        }

        .galore-btn {
            background: linear-gradient(135deg, #ff4d5a, var(--galore-red));
            color: #fff;
            padding: 15px;
            border: none;
            border-radius: 12px;
            font-size: 1.05rem;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
            transition: all 0.3s ease;
        }

        .galore-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(220, 53, 69, 0.45);
        }

        .galore-footer {
            text-align: center;
            margin-top: 25px;
            font-size: 0.85rem;
            color: var(--galore-red);
            font-weight: 600;
            padding-top: 18px;
            border-top: 1px solid rgba(220, 53, 69, 0.25);
        }

        .alert {
            border-radius: 10px;
            margin-top: 20px;
        }
        
        .login-prompt {
            text-align: center;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .login-prompt a {
            color: var(--galore-red);
            font-weight: bold;
            text-decoration: none;
        }

        .login-prompt a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <!-- Include Navbar -->
    <?php
    if (file_exists('navbar.php')) {
        include 'navbar.php';
    }
    ?>

    <!-- HERO - DYNAMIC -->
    <section class="hero">
        <h1 class="display-1 display-md-2 display-sm-3">
            <?php echo getHeaderValue($header_data, 'hero_title', 'Contact Galore Team'); ?>
        </h1>
        <p class="lead lead-sm">
            <?php echo getHeaderValue($header_data, 'hero_subtitle', 'We\'re here to help you with events & registration'); ?>
        </p>
    </section>

    <!-- CONTACT FORM -->
    <div class="galore-wrapper">
        <div class="galore-card">

            <h2 class="galore-title h2 h3-sm">
                <?php echo getHeaderValue($header_data, 'form_title', '📩 Get in Touch'); ?>
            </h2>
            <p class="galore-subtitle lead lead-sm">
                <?php echo getHeaderValue($header_data, 'form_subtitle', 'Have any questions? Fill out the form below.'); ?>
            </p>

            <!-- Welcome Banner for Logged-in Users -->
            <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true && !empty($name)): ?>
                <div class="welcome-banner">
                    <i class="fas fa-user-circle"></i> 
                    Welcome back, <?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>! 
                
                </div>
            <?php endif; ?>

            <!-- Login Prompt for Guests -->
            <?php if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true): ?>
                <div class="login-prompt">
                    <i class="fas fa-info-circle me-2"></i>
                    <a href="login.php">Login</a> to auto-fill your information and track your messages.
                </div>
            <?php endif; ?>

            <!-- Error Messages -->
            <?php if (!empty($error_message)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i> <?php echo $error_message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="" method="POST" id="contactForm" novalidate>
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <div class="galore-input-group">
                            <label class="galore-label">Full Name *</label>
                            <input type="text"
                                name="name"
                                id="name"
                                class="galore-input"
                                placeholder="Enter your full name"
                                value="<?php echo getFieldValue('name'); ?>"
                                <?php echo isFieldReadonly('name') ? 'readonly' : ''; ?>
                                required>
                            <div class="error-feedback" id="name_error"></div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="galore-input-group">
                            <label class="galore-label">Email Address *</label>
                            <input type="email"
                                name="email"
                                id="email"
                                class="galore-input"
                                placeholder="yourname@email.com"
                                value="<?php echo getFieldValue('email'); ?>"
                                <?php echo isFieldReadonly('email') ? 'readonly' : ''; ?>
                                required>
                            <div class="error-feedback" id="email_error"></div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="galore-input-group">
                            <label class="galore-label">Phone Number *</label>
                            <input type="tel"
                                name="phone"
                                id="phone"
                                class="galore-input"
                                placeholder="Enter 10-digit phone number"
                                value="<?php echo getFieldValue('phone'); ?>"
                                required>
                            <div class="error-feedback" id="phone_error"></div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="galore-input-group">
                            <label class="galore-label">Subject *</label>
                            <input type="text"
                                name="subject"
                                id="subject"
                                class="galore-input"
                                placeholder="Enter subject"
                                value="<?php echo getFieldValue('subject'); ?>"
                                required>
                            <div class="error-feedback" id="subject_error"></div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="galore-input-group">
                            <label class="galore-label">Message *</label>
                            <textarea name="message"
                                id="message"
                                rows="5"
                                class="galore-input"
                                placeholder="Write your message here..."
                                required><?php echo getFieldValue('message'); ?></textarea>
                            <div class="error-feedback" id="message_error"></div>
                        </div>
                    </div>

                    <div class="col-12">
                        <button type="submit" name="submit" class="galore-btn w-100">
                            <i class="fas fa-paper-plane me-2"></i>Send Message
                        </button>
                    </div>
                </div>
            </form>

            <div class="galore-footer">
                <i class="fas fa-clock me-2"></i>
                <?php echo getHeaderValue($header_data, 'footer_note', 'Galore Team will respond within 24 hours.'); ?>
            </div>

        </div>
    </div>

    <?php 
    // Include footer if exists
    if (file_exists('footer.php')) {
        include_once 'footer.php';
    }
    ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>

<?php
// Close connection
if (isset($con) && $con) {
    mysqli_close($con);
}

?>