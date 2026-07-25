<?php
include 'profile_handler.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>My Profile | RKU Galore</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- AOS -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            --galore-red: #dc3545;
            --galore-red-dark: #b02a37;
            --galore-gray: #6c757d;
        }

        body {
            font-family: "Segoe UI", Arial, sans-serif;
        }

        /* ===== HERO ===== */
        .hero {
            background: linear-gradient(135deg, #dc3545, #7a1c25);
            color: #fff;
            text-align: center;
            padding: 160px 20px 100px;
            position: relative;
            overflow: hidden;
        }

        .hero::after {
            content: "";
            position: absolute;
            bottom: -60px;
            left: 0;
            width: 100%;
            height: 120px;
            background: #fff;
            border-radius: 50% 50% 0 0;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 900;
            letter-spacing: 2px;
            margin-bottom: 12px;
        }

        .hero p {
            font-size: 1.2rem;
            opacity: 0.95;
        }

        /* ===== PROFILE CARD ===== */
        .profile-card {
            max-width: 950px;
            margin: -70px auto 60px;
            background: #fff;
            border-radius: 20px;
            padding: 45px;
            box-shadow: 0 30px 60px rgba(220, 53, 69, 0.25);
            border-top: 6px solid var(--galore-red);
            position: relative;
            z-index: 1;
        }

        .profile-head {
            display: flex;
            align-items: center;
            gap: 30px;
            margin-bottom: 35px;
            flex-wrap: wrap;
        }

        .profile-head img {
            width: 130px;
            height: 130px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--galore-red);
        }

        .profile-head h3 {
            margin: 0;
            color: var(--galore-red);
            font-weight: 700;
        }

        .profile-head p {
            margin: 2px 0;
            color: var(--galore-gray);
        }

        /* ===== INFO GRID ===== */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .info-box {
            background: #fff5f5;
            border-left: 5px solid var(--galore-red);
            padding: 18px 20px;
            border-radius: 12px;
        }

        .info-box small {
            color: var(--galore-gray);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.7rem;
            letter-spacing: 0.5px;
        }

        .info-box p {
            margin: 6px 0 0;
            font-weight: 600;
            font-size: 1rem;
        }

        /* Event Section Styles */
        .events-section {
            margin-top: 35px;
            background: #f8f9fa;
            border-radius: 15px;
            padding: 25px;
            border: 2px solid rgba(220, 53, 69, 0.1);
        }

        .events-section h4 {
            color: var(--galore-red);
            font-size: 1.3rem;
            margin-bottom: 20px;
            font-weight: 700;
            border-bottom: 2px solid var(--galore-red);
            padding-bottom: 10px;
        }

        .event-category {
            background: white;
            border-radius: 12px;
            padding: 15px 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .event-category h5 {
            color: var(--galore-red-dark);
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .event-category h5 i {
            font-size: 1.2rem;
        }

        .event-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .event-badge {
            background: linear-gradient(135deg, #ff4d5a, var(--galore-red));
            color: white;
            padding: 6px 15px;
            border-radius: 25px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .event-badge i {
            font-size: 0.75rem;
        }

        .no-events {
            color: var(--galore-gray);
            font-style: italic;
            padding: 15px;
            text-align: center;
            background: #f8f9fa;
            border-radius: 10px;
        }

        .registration-info {
            background: #e8f5e9;
            border-left: 5px solid #28a745;
            margin-top: 20px;
            padding: 12px 15px;
            border-radius: 10px;
            font-size: 0.85rem;
            color: #155724;
        }

        /* Role Badge */
        .role-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-top: 10px;
        }

        .role-Admin {
            background: #dc3545;
            color: white;
        }

        .role-Coordinator {
            background: #ffc107;
            color: black;
        }

        .role-Judge {
            background: #17a2b8;
            color: white;
        }

        .role-Participant {
            background: #28a745;
            color: white;
        }

        /* Status Badge */
        .status-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
            margin-left: 10px;
        }

        .status-Active {
            background: #28a745;
            color: white;
        }

        .status-Pending {
            background: #ffc107;
            color: black;
        }

        .status-Inactive {
            background: #6c757d;
            color: white;
        }

        /* ===== BUTTON STYLES ===== */
        .profile-actions {
            text-align: center;
            margin-top: 30px;
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .action-btn {
            background: linear-gradient(135deg, #ff4d5a, var(--galore-red));
            color: #fff;
            padding: 12px 32px;
            font-size: 16px;
            border: none;
            border-radius: 12px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .action-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(220, 53, 69, 0.45);
            color: #fff;
        }

        .action-btn-secondary {
            background: linear-gradient(135deg, #6c757d, #495057);
        }

        .action-btn-secondary:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(108, 117, 125, 0.45);
            color: #fff;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.2rem;
            }

            .profile-card {
                padding: 25px;
                margin: -40px 15px 40px;
            }

            .profile-head {
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }
            
            .profile-actions {
                flex-direction: column;
            }
            
            .profile-actions .action-btn {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>

<body>

    <?php include 'navbar.php'; ?>

    <section class="hero">
        <h1>My Profile</h1>
        <p>View & manage your Galore participation</p>
    </section>

    <div class="profile-card" data-aos="fade-up">

        <div class="profile-head" data-aos="fade-right">
            <?php
            // Profile picture path - fixed warning
            $profile_pic_path = "uploads/profile_pics/";
            $default_pic = "website/default-avatar.jpg";
            
            if (!empty($user['profile_pic']) && file_exists($profile_pic_path . $user['profile_pic'])) {
                $profile_pic = $profile_pic_path . $user['profile_pic'];
            } else {
                $profile_pic = $default_pic;
            }
            ?>
            <img src="<?php echo htmlspecialchars($profile_pic); ?>" alt="Profile Picture">
            <div>
                <h3><?php echo htmlspecialchars($user['full_name'] ?? 'N/A'); ?></h3>
                <p class="mb-1">Enrollment No: <?php echo htmlspecialchars($user['enrollment_no'] ?? 'N/A'); ?></p>
                <p class="mb-0"><?php echo htmlspecialchars($user['branch'] ?? 'N/A'); ?></p>
                <span class="role-badge role-<?php echo htmlspecialchars($user['role'] ?? 'Participant'); ?>">
                    <?php echo htmlspecialchars($user['role'] ?? 'Participant'); ?>
                </span>
                <span class="status-badge status-<?php echo htmlspecialchars($user['status'] ?? 'Active'); ?>">
                    <?php echo htmlspecialchars($user['status'] ?? 'Active'); ?>
                </span>
            </div>
        </div>

        <div class="info-grid">
            <div class="info-box">
                <small>Semester</small>
                <p class="mb-0">
                    <?php 
                    if (isset($user['semester']) && !empty($user['semester'])) {
                        $sem = (int)$user['semester'];
                        $suffix = 'th';
                        if ($sem == 1) $suffix = 'st';
                        elseif ($sem == 2) $suffix = 'nd';
                        elseif ($sem == 3) $suffix = 'rd';
                        echo $sem . $suffix . " Semester";
                    } else {
                        echo "Not Specified";
                    }
                    ?>
                </p>
            </div>
            <div class="info-box">
                <small>School</small>
                <p class="mb-0"><?php echo htmlspecialchars($user['school'] ?? 'N/A'); ?></p>
            </div>
            <div class="info-box">
                <small>Gender</small>
                <p class="mb-0"><?php echo htmlspecialchars($user['gender'] ?? 'N/A'); ?></p>
            </div>
            <div class="info-box">
                <small>Email</small>
                <p class="mb-0"><?php echo htmlspecialchars($user['email'] ?? 'N/A'); ?></p>
            </div>
            <div class="info-box">
                <small>Contact No</small>
                <p class="mb-0"><?php echo htmlspecialchars($user['phone'] ?? 'N/A'); ?></p>
            </div>
            <div class="info-box">
                <small>Member Since</small>
                <p class="mb-0">
                    <?php 
                    if (!empty($user['registration_date'])) {
                        echo date('d M Y', strtotime($user['registration_date']));
                    } else {
                        echo "N/A";
                    }
                    ?>
                </p>
            </div>
        </div>

        <!-- Registered Events Section -->
        <div class="events-section" data-aos="fade-up">
            <h4><i class="fas fa-trophy me-2"></i>Registered Events</h4>
            
            <?php if ($registered_events && !empty($registered_events)): ?>
                <!-- Sports Outdoor -->
                <?php if (!empty($outdoor_events) && is_array($outdoor_events)): ?>
                <div class="event-category">
                    <h5><i class="fas fa-futbol"></i> Sports - Outdoor</h5>
                    <div class="event-badges">
                        <?php foreach ($outdoor_events as $event): ?>
                            <?php if (!empty(trim($event))): ?>
                                <span class="event-badge"><i class="fas fa-check-circle"></i> <?php echo htmlspecialchars(trim($event)); ?></span>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Sports Indoor -->
                <?php if (!empty($indoor_events) && is_array($indoor_events)): ?>
                <div class="event-category">
                    <h5><i class="fas fa-table-tennis"></i> Sports - Indoor</h5>
                    <div class="event-badges">
                        <?php foreach ($indoor_events as $event): ?>
                            <?php if (!empty(trim($event))): ?>
                                <span class="event-badge"><i class="fas fa-check-circle"></i> <?php echo htmlspecialchars(trim($event)); ?></span>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Cultural -->
                <?php if (!empty($cultural_events) && is_array($cultural_events)): ?>
                <div class="event-category">
                    <h5><i class="fas fa-music"></i> Cultural</h5>
                    <div class="event-badges">
                        <?php foreach ($cultural_events as $event): ?>
                            <?php if (!empty(trim($event))): ?>
                                <span class="event-badge"><i class="fas fa-check-circle"></i> <?php echo htmlspecialchars(trim($event)); ?></span>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Registration Info -->
                <?php if (isset($registered_events['registration_date']) && !empty($registered_events['registration_date'])): ?>
                <div class="registration-info">
                    <i class="fas fa-calendar-alt me-2"></i>
                    <strong>Registration Date:</strong> <?php echo date('d M Y, h:i A', strtotime($registered_events['registration_date'])); ?>
                </div>
                <?php endif; ?>
                
            <?php else: ?>
                <div class="no-events">
                    <i class="fas fa-info-circle me-2"></i>
                    You haven't registered for any events yet.
                    <div class="mt-3">
                        <a href="event_registration.php" class="btn btn-sm" style="background: var(--galore-red); color: white; border-radius: 20px;">
                            <i class="fas fa-plus-circle me-1"></i> Register Now
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="profile-actions">
            <a href="edit_profile.php" class="action-btn">
                <i class="fas fa-edit me-2"></i>Edit Profile
            </a>
            <a href="event_registration.php" class="action-btn action-btn-secondary">
                <i class="fas fa-calendar-plus me-2"></i>Register for Events
            </a>
        </div>

    </div>

    <?php include 'footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- AOS JS -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

    <script>
        // Initialize AOS
        AOS.init({
            duration: 1200,
            once: true
        });
        
        // Optional: Add smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>

</body>

</html>

<?php
// Close database connection if still open
if (isset($con) && $con) {
    mysqli_close($con);
}
?>