<!DOCTYPE html>
<html lang="en">

<head>
    <title>School Dashboard - Galore 2026</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- AOS CSS for scroll animations -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --galore-red: #dc3545;
            --galore-red-dark: #b02a37;
            --galore-dark: #212529;
            --galore-gray: #6c757d;
            --light-red: #f8d7da;
            --light-pink: #fff5f5;
        }

        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
        }

        /* ===== SCHOOL HEADER CARD ===== */
        .school-header {
            background: white;
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            border-top: 4px solid var(--galore-red);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .school-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .school-logo {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #fff5f5 0%, #ffe6e6 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .school-logo i {
            font-size: 2rem;
            color: var(--galore-red);
        }

        .school-details h2 {
            font-size: 1.6rem;
            font-weight: 700;
            margin-bottom: 5px;
            color: var(--galore-dark);
        }

        .school-details p {
            color: var(--galore-gray);
            margin-bottom: 3px;
        }

        .school-stats {
            display: flex;
            gap: 30px;
        }

        .school-stat-item {
            text-align: center;
        }

        .school-stat-number {
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--galore-red);
        }

        .school-stat-label {
            font-size: 0.8rem;
            color: var(--galore-gray);
}        
    </style>
</head>

<body>

    <?php include 'c_navbar.php'; ?>

    <!-- ===== HERO ===== -->
    <section class="hero">
        <h1> Galore 2026 - Engineering</h1>
        <p>School of Engineering & Technology</p>
    </section>

    <div class="container mb-5">

        <!-- ===== SCHOOL HEADER CARD ===== -->
        <div class="school-header" data-aos="fade-up">
            <div class="school-info">
                <div class="school-logo">
                    <i class="fas fa-flask"></i>
                </div>
                <div class="school-details">
                    <h2>School of Engineering</h2>
                    <p><i class="fas fa-user-tie me-1" style="color: var(--galore-red);"></i> Dr. Rajesh Kumar - Coordinator</p>
                    <p><i class="fas fa-envelope me-1" style="color: var(--galore-red);"></i> engineering@galore2026.edu</p>
                </div>
            </div>
            <div class="school-stats">
                <div class="school-stat-item">
                    <div class="school-stat-number">856</div>
                    <div class="school-stat-label">Students</div>
                </div>
                <div class="school-stat-item">
                    <div class="school-stat-number">12</div>
                    <div class="school-stat-label">Events</div>
                </div>
                <div class="school-stat-item">
                    <div class="school-stat-number">156</div>
                    <div class="school-stat-label">Registrations</div>
                </div>
            </div>
        </div>

    </div>
    <?php include 'footer.php'; ?>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

    <script>
        AOS.init({
            duration: 1000,
            once: true
        });

        // Simple notification for demo
        document.querySelectorAll('.action-btn, .btn-galore, .btn-outline-red').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                alert('Demo: ' + this.textContent.trim());
            });
        });
    </script>

</body>

</html>