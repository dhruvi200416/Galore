<?php
session_start();
error_reporting(0);
ini_set('display_errors', 0);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | RKU Galore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Same styles as before */
        :root { --galore-red: #dc3545; --galore-gray: #6c757d; }
        body { font-family: 'Segoe UI', Roboto, sans-serif; margin: 0; min-height: 100vh; }
        .hero { background: linear-gradient(135deg, #dc3545, #7a1c25); color: #fff; text-align: center; padding: 160px 20px 100px; position: relative; overflow: hidden; }
        .hero::after { content: ""; position: absolute; bottom: -60px; left: 0; width: 100%; height: 120px; background: #fff; border-radius: 50% 50% 0 0; }
        .hero h1 { font-size: 3.5rem; font-weight: 900; letter-spacing: 2px; margin-bottom: 12px; }
        .hero p { font-size: 1.2rem; opacity: 0.95; }
        .galore-wrapper { display: flex; justify-content: center; align-items: center; padding: 60px 20px 80px; }
        .galore-card { background: #ffffff; width: 100%; max-width: 900px; padding: 40px; border-radius: 18px; border-top: 6px solid var(--galore-red); box-shadow: 0 20px 45px rgba(220, 53, 69, 0.18); animation: fadeSlide 0.8s ease forwards; }
        @keyframes fadeSlide { from { opacity: 0; transform: translateY(40px); } to { opacity: 1; transform: translateY(0); } }
        .galore-title { text-align: center; color: var(--galore-red); font-size: 2rem; margin-bottom: 15px; }
        .info-text { text-align: center; font-size: 0.95rem; color: var(--galore-gray); margin-bottom: 30px; }
        .galore-input { width: 100%; padding: 13px 15px; border: 2px solid #ddd; border-radius: 10px; font-size: 0.95rem; }
        .galore-input:focus { outline: none; border-color: var(--galore-red); box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.15); }
        .galore-btn { width: 100%; background: linear-gradient(135deg, #ff4d5a, var(--galore-red)); color: #fff; padding: 14px; border: none; border-radius: 12px; font-size: 1rem; font-weight: bold; cursor: pointer; margin-top: 10px; transition: all 0.3s ease; }
        .galore-btn:hover { transform: translateY(-3px); box-shadow: 0 12px 30px rgba(220, 53, 69, 0.45); }
        .footer-links { text-align: center; margin-top: 25px; font-size: 0.85rem; color: var(--galore-gray); }
        .footer-links a { color: var(--galore-red); text-decoration: none; font-weight: 700; }
        .alert { border-radius: 10px; margin-bottom: 20px; }
        @media (max-width: 768px) { .hero h1 { font-size: 2.2rem; } .galore-card { padding: 25px; } }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    
    <section class="hero">
        <h1>Forgot Password?</h1>
        <p>Don't worry, we'll help you get back to Galore 2026</p>
    </section>
    
    <div class="galore-wrapper">
        <div class="galore-card">
            <h2 class="galore-title">🔑 Recover Account</h2>
            <p class="info-text">Enter your registered email address or enrollment number.</p>
            
            <!-- Display success/error messages -->
            <?php if (isset($_GET['success']) && !empty($_GET['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i> <?php echo htmlspecialchars($_GET['success']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            
            <?php if (isset($_GET['error']) && !empty($_GET['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i> <?php echo htmlspecialchars($_GET['error']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            
            <!-- Form submits to reset_password.php -->
            <form action="reset_password.php" method="POST">
                <div class="mb-3">
                    <label class="form-label fw-bold text-uppercase small">Email / Enrollment No *</label>
                    <input type="text" name="recovery_id" class="galore-input" placeholder="e.g., 21CE045 or email@rku.ac.in" required>
                </div>
                <button type="submit" name="submit" class="galore-btn"><i class="fas fa-paper-plane me-2"></i>Send Reset Link</button>
            </form>
            
            <div class="footer-links">
                <a href="login.php">Back to Login</a>
            </div>
        </div>
    </div>
    
    <?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>