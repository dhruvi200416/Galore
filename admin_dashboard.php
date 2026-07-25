<?php
// At the very top of admin_dashboard.php
require_once 'admin_auth_check.php';

// Now you can access admin session variables
$admin_name = $_SESSION['full_name'];
$admin_role = $_SESSION['role'];
$admin_email = $_SESSION['email'];
// Include the handler file which contains all PHP logic and database operations
include 'admin_dashboard_handler.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | RKU Galore</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --galore-red: #f15a5a;
            --galore-dark: #7a0c15;
            --bg-main: #f3f5f9;
            --glass: #ffffff;
        }

        body {
            background: linear-gradient(135deg, #f3f5f9, #eef1f6);
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            min-height: 100vh;
            display: flex;
            overflow: hidden;
        }

        /* Sidebar - adjust based on your actual admin_header.php */
        .sidebar {
            width: 250px;
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            background: #212529;
            color: white;
            z-index: 100;
        }

        /* Main content area */
        .main-content {
            flex: 1;
            margin-left: 250px;
            height: 100vh;
            overflow-y: auto;
            padding: 40px;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .dashboard-title {
            background: linear-gradient(90deg, #f15a5a, #ff8a8a);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 2.5rem;
            font-weight: 800;
            color: #f15a5a;
        }

        .admin-profile {
            background: white;
            padding: 8px 20px;
            border-radius: 50px;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .admin-profile:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
        }

        .admin-profile img {
            width: 50px;
            height: 40px;
            border-radius: 50%;
            background: #f8f9fa;
            padding: 4px;
            object-fit: contain;
        }

        .admin-profile a {
            text-decoration: none;
        }

        /* ===== STAT CARDS ===== */
        .stat-card {
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
            position: relative;
            overflow: hidden;
            border: none;
            text-align: left;
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(241, 90, 90, 0.15);
        }

        /* Red top border bar */
        .stat-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 6px;
            background: #f15a5a;
        }

        /* TOP-RIGHT ROUND DECORATION */
        .stat-card::after {
            content: "";
            position: absolute;
            width: 140px;
            height: 140px;
            background: rgba(241, 90, 90, 0.18);
            border-radius: 50%;
            top: -50px;
            right: -50px;
            z-index: 0;
            transition: all 0.3s ease;
        }

        .stat-card:hover::after {
            transform: scale(1.2);
        }

        .stat-icon {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            background: #f15a5a;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            margin-bottom: 15px;
            position: relative;
            z-index: 1;
        }

        .stat-title {
            font-size: 0.75rem;
            text-transform: uppercase;
            color: #666;
            font-weight: 700;
            letter-spacing: 0.5px;
            position: relative;
            z-index: 1;
        }

        .stat-value {
            font-size: 2.2rem;
            font-weight: 800;
            color: #f15a5a;
            margin-top: 5px;
            position: relative;
            z-index: 1;
        }

        /* ===== TABLE ===== */
        .custom-table {
            margin-top: 40px;
            background: white;
            border-radius: 20px;
            padding: 35px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
        }

        .table-header-text {
            color: #f15a5a;
            font-weight: 700;
            margin-bottom: 25px;
            font-size: 1.2rem;
        }

        table thead th {
            color: #333;
            font-weight: 700;
            border-bottom: 1px solid #f8f9fa;
            padding-bottom: 15px;
        }

        table tbody td {
            padding: 15px 0;
            color: #444;
            font-size: 0.95rem;
            border: none;
        }

        /* Remove default bootstrap table borders */
        .table> :not(caption)>*>* {
            border-bottom-width: 0;
        }

        /* Responsive adjustments */
        @media (max-width: 991.98px) {
            .sidebar {
                display: none;
            }
            
            .main-content {
                margin-left: 0;
                padding: 20px;
            }
            
            body {
                overflow: auto;
            }
        }
    </style>
</head>

<body>

    <?php include 'admin_header.php'; ?>

    <div class="main-content">
        <div class="top-bar">
            <div class="dashboard-title">Admin Dashboard</div>
            <div class="admin-profile">
                <img src="website/rku_logo.png" alt="Logo">
                <a href="ad_profile.php" class="text-decoration-none text-dark">
                    <div>
                        <strong class="d-block">Admin</strong>
                        <small class="text-muted d-block">RK University</small>
                    </div>
                </a>
            </div>
        </div>

        <div class="row g-3 g-md-4">
            <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                <div class="stat-card">
                    <div class="stat-icon"><i class="bi bi-people"></i></div>
                    <div class="stat-title">Registrations</div>
                    <div class="stat-value"><?php echo number_format($reg_count); ?></div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                <div class="stat-card">
                    <div class="stat-icon"><i class="bi bi-calendar-check"></i></div>
                    <div class="stat-title">Events</div>
                    <div class="stat-value"><?php echo number_format($events_count); ?></div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                <div class="stat-card">
                    <div class="stat-icon"><i class="bi bi-people-fill"></i></div>
                    <div class="stat-title">Participants</div>
                    <div class="stat-value"><?php echo number_format($participants_count); ?></div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                <div class="stat-card">
                    <div class="stat-icon"><i class="bi bi-award-fill"></i></div>
                    <div class="stat-title">Winners</div>
                    <div class="stat-value"><?php echo number_format($winners_count); ?></div>
                </div>
            </div>
        </div>

        <div class="custom-table">
            <h5 class="table-header-text">Recent Registrations</h5>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th class="py-3">Enrollment No</th>
                            <th class="py-3">Name</th>
                            <th class="py-3">Branch</th>
                            <th class="py-3">Semester</th>
                            <th class="py-3">Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($has_results): ?>
                            <?php while ($row = mysqli_fetch_assoc($recent_result)): ?>
                                <tr>
                                    <td class="py-3"><?php echo isset($row['enrollment_no']) ? htmlspecialchars($row['enrollment_no']) : 'N/A'; ?></td>
                                    <td class="py-3">
                                        <?php 
                                        // Try different possible column names for student name
                                        $name = '';
                                        if (isset($row['student_name'])) {
                                            $name = $row['student_name'];
                                        } elseif (isset($row['name'])) {
                                            $name = $row['name'];
                                        } elseif (isset($row['full_name'])) {
                                            $name = $row['full_name'];
                                        } elseif (isset($row['studentname'])) {
                                            $name = $row['studentname'];
                                        } elseif (isset($row['s_name'])) {
                                            $name = $row['s_name'];
                                        } else {
                                            $name = 'Name not found';
                                        }
                                        echo htmlspecialchars($name);
                                        ?>
                                    </td>
                                    <td class="py-3"><?php echo isset($row['branch']) ? htmlspecialchars($row['branch']) : 'N/A'; ?></td>
                                    <td class="py-3"><?php echo isset($row['semester']) ? htmlspecialchars($row['semester']) : 'N/A'; ?></td>
                                    <td class="py-3"><?php echo isset($row['email']) ? htmlspecialchars($row['email']) : 'N/A'; ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center py-3">No recent registrations found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Optional: Add click functionality to stat cards
        $(document).ready(function() {
            $('.stat-card').on('click', function() {
                // You can add navigation or modal popup here
                console.log('Stat card clicked');
            });
        });
    </script>
</body>

</html>