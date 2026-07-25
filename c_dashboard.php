<?php
session_start();

// Check login - Fixed: Check if logged_in or email exists
if (!isset($_SESSION['logged_in']) && !isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// DB connection
$con = mysqli_connect("localhost", "root", "", "galore2026");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get user from DB using session email
$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';

if (empty($email)) {
    header("Location: login.php");
    exit();
}

// Initialize variables to avoid undefined warnings
$user = null;
$user_name = "User";
$user_role = "Co-coordinator";
$coordinator_role = "";
$dash = [
    'icon1' => 'bi-calendar-check',
    'icon2' => 'bi-person-circle',
    'title' => 'Manage your events and activities'
];
$total_events = 0;
$total_participants = 0;
$total_coordinators = 0;

// Fetch user data using prepared statement
$user_query = "SELECT full_name, role, coordinator_role FROM ad_register WHERE email = ?";
$user_stmt = mysqli_prepare($con, $user_query);

if ($user_stmt) {
    mysqli_stmt_bind_param($user_stmt, "s", $email);
    mysqli_stmt_execute($user_stmt);
    $user_result = mysqli_stmt_get_result($user_stmt);
    $user = mysqli_fetch_assoc($user_result);
    
    // Store values with null coalescing
    $user_name = isset($user['full_name']) ? $user['full_name'] : "User";
    $user_role = isset($user['role']) ? $user['role'] : "Co-coordinator";
    $coordinator_role = isset($user['coordinator_role']) ? $user['coordinator_role'] : "";
    
    mysqli_stmt_close($user_stmt);
}

// Dashboard data
$dash_query = "SELECT * FROM c_dash1 LIMIT 1";
$dash_result = mysqli_query($con, $dash_query);

if ($dash_result && mysqli_num_rows($dash_result) > 0) {
    $dash_data = mysqli_fetch_assoc($dash_result);
    // Merge with defaults to ensure all keys exist
    $dash = array_merge($dash, $dash_data);
    mysqli_free_result($dash_result);
}

// Count total events
$query = "SELECT COUNT(event_name) AS total_events FROM cultural_event";
$result = mysqli_query($con, $query);
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $total_events = isset($row['total_events']) ? (int)$row['total_events'] : 0;
    mysqli_free_result($result);
}

// Count total participants
$query = "SELECT COUNT(id) AS total_participants FROM event_register";
$result = mysqli_query($con, $query);
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $total_participants = isset($row['total_participants']) ? (int)$row['total_participants'] : 0;
    mysqli_free_result($result);
}

// Count total coordinators
$query = "SELECT COUNT(*) AS total_coordinators FROM ad_register 
          WHERE role = 'Co-coordinator' OR role = 'Coordinator'";
$result = mysqli_query($con, $query);
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $total_coordinators = isset($row['total_coordinators']) ? (int)$row['total_coordinators'] : 0;
    mysqli_free_result($result);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Co-Coordinator Dashboard – Galore 2026</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap 5.3 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- AOS -->
  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

  <!-- Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    :root {
      --primary-red: #dc3545;
      --dark-red: #b02a37;
      --light-red: #f8d7da;
      --gradient-red: linear-gradient(135deg, #dc3545, #b02a37);
      --galore-gray: #6c757d;
      --galore-dark: #212529;
    }

    body {
      font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
      min-height: 100vh;
      background: #f8f9fa;
      padding-top: 0;
    }

    /* Hero */
    .hero {
      background: var(--gradient-red);
      color: white;
      text-align: center;
      padding: 80px 20px 80px;
      position: relative;
      overflow: hidden;
    }

    .hero::after {
      content: "";
      position: absolute;
      bottom: -50px;
      left: 0;
      width: 100%;
      height: 100px;
      background: white;
      border-radius: 50% 50% 0 0;
    }

    .hero h1 {
      font-size: clamp(2.4rem, 7vw, 4.2rem);
      font-weight: 900;
      letter-spacing: 1.5px;
      margin-bottom: 0.75rem;
    }

    .hero p {
      font-size: 1.2rem;
      opacity: 0.95;
    }

    /* Dashboard header */
    .dashboard-header {
      background: var(--gradient-red);
      color: white;
      border-radius: 1.25rem;
      padding: 2rem 1.5rem;
      margin: 1.5rem 0;
      box-shadow: 0 10px 30px rgba(220, 53, 69, 0.15);
      position: relative;
      overflow: hidden;
    }

    /* Stats cards */
    .stat-card {
      border-radius: 1rem;
      padding: 1.5rem;
      box-shadow: 0 6px 18px rgba(0,0,0,0.08);
      transition: transform 0.25s ease, box-shadow 0.25s ease;
      border-top: 4px solid var(--primary-red);
      text-align: center;
      background: white;
    }

    .stat-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 12px 28px rgba(0,0,0,0.12);
    }

    .stat-icon {
      width: 3.75rem;
      height: 3.75rem;
      border-radius: 50%;
      background: linear-gradient(135deg, #fff5f5, #ffe6e6);
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 1rem;
    }

    .stat-icon i {
      font-size: 1.6rem;
      color: var(--primary-red);
    }

    .stat-number {
      font-size: clamp(1.8rem, 6vw, 2.5rem);
      font-weight: 700;
      color: var(--galore-dark);
    }

    .stat-card p {
      color: var(--galore-gray);
      margin-top: 0.5rem;
      font-weight: 500;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .hero {
        padding: 60px 20px 60px;
      }
      
      .hero h1 {
        font-size: 1.8rem;
      }
      
      .hero p {
        font-size: 1rem;
      }
      
      .dashboard-header {
        text-align: center;
      }
      
      .dashboard-header .text-lg-end {
        text-align: center !important;
        margin-top: 1.5rem;
      }
      
      .stat-card {
        margin-bottom: 1rem;
      }
    }
  </style>
</head>
<body>

<?php include 'co_navbar.php'; ?>

<!-- Hero -->
<section class="hero">
  <div class="container">
    <h1>Welcome, <?php echo htmlspecialchars($user_name); ?> 👋</h1>
    <p class="lead">
      <?php 
      if (!empty($user_role)) {
          echo htmlspecialchars($user_role);
          if (!empty($coordinator_role)) {
              echo " | " . htmlspecialchars($coordinator_role);
          }
      } else {
          echo "Co-coordinator";
      }
      ?>
    </p>
  </div>
</section>

<div class="container py-4 py-md-5">

  <!-- Welcome Header -->
  <div class="dashboard-header mb-4 mb-md-5" data-aos="fade-up">
    <div class="row align-items-center g-4">

      <div class="col-12 col-lg-8">
        <div class="d-inline-flex align-items-center gap-2 bg-white bg-opacity-25 border border-white border-opacity-25 rounded-pill px-3 py-2 mb-3 fw-semibold">
          <i class="bi <?php echo htmlspecialchars($dash['icon1'] ?? 'bi-calendar-check'); ?>"></i>
          <?php 
          if (!empty($user_role)) {
              echo htmlspecialchars($user_role);
              if (!empty($coordinator_role)) {
                  echo " | " . htmlspecialchars($coordinator_role);
              }
          } else {
              echo "Co-coordinator";
          }
          ?>
        </div>

        <h1 class="display-5 fw-bold mb-3">
          Welcome back 👋, <?php echo htmlspecialchars($user_name); ?>
        </h1>

        <p class="lead mb-0">
          <?php echo htmlspecialchars($dash['title'] ?? 'Manage your events and activities'); ?>
        </p>
      </div>

      <div class="col-12 col-lg-4 text-center text-lg-end">
        <div class="card shadow-sm border-0 mx-auto" style="max-width: 320px;">
          <div class="card-body text-center">

            <div class="mx-auto mb-3 rounded-circle d-flex align-items-center justify-content-center"
                 style="width:80px;height:80px;background:linear-gradient(135deg,#fff5f5,#ffe6e6);">
              <i class="bi <?php echo htmlspecialchars($dash['icon2'] ?? 'bi-person-circle'); ?> display-4"
                 style="color:var(--primary-red);"></i>
            </div>

            <h6 class="fw-bold mb-1">
              <?php echo htmlspecialchars($user_name); ?>
            </h6>

            <small class="text-muted d-block mb-3">
              <?php 
              if (!empty($user_role)) {
                  echo htmlspecialchars($user_role);
                  if (!empty($coordinator_role)) {
                      echo " | " . htmlspecialchars($coordinator_role);
                  }
              } else {
                  echo "Co-coordinator";
              }
              ?>
            </small>

          </div>
        </div>
      </div>

    </div>
  </div>

  <!-- Stats -->
  <div class="row g-4 mb-4 mb-md-5 justify-content-center" data-aos="fade-up" data-aos-delay="100">
    <div class="col-12 col-sm-6 col-lg-4">
      <div class="stat-card h-100">
        <div class="stat-icon"><i class="fas fa-calendar-alt"></i></div>
        <div class="stat-number"><?php echo number_format($total_events); ?></div>
        <p>Assigned Events</p>
      </div>
    </div>
    
    <div class="col-12 col-sm-6 col-lg-4">
      <div class="stat-card h-100">
        <div class="stat-icon"><i class="fas fa-users"></i></div>
        <div class="stat-number"><?php echo number_format($total_participants); ?></div>
        <p>Total Participants</p>
      </div>
    </div>
    
    <div class="col-12 col-sm-6 col-lg-4">
      <div class="stat-card h-100">
        <div class="stat-icon"><i class="fas fa-user-tie"></i></div>
        <div class="stat-number"><?php echo number_format($total_coordinators); ?></div>
        <p>Co-coordinators</p>
      </div>
    </div>
  </div>

</div>

<?php include 'footer.php'; ?>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
  AOS.init({
    duration: 1000,
    once: true,
    offset: 60
  });
</script>

</body>
</html>

<?php
// Close database connection
if (isset($con) && $con) {
    mysqli_close($con);
}
?>