<?php
session_start();

// ✅ Login check
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// ✅ DB connection
$con = mysqli_connect("localhost", "root", "", "galore2026");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// ✅ User data (fetch role + coordinator_role)
$email = $_SESSION['email'];
$user_query = "SELECT full_name, role, coordinator_role FROM ad_register WHERE email='$email'";
$user_result = mysqli_query($con, $user_query);
$user = mysqli_fetch_assoc($user_result);

$user_name = $user['full_name'] ?? "";
$user_role = $user['role'] ?? "";
$coordinator_role = $user['coordinator_role'] ?? "";

// ✅ Dashboard data
$dash_query = "SELECT * FROM c_dash1 LIMIT 1";
$dash_result = mysqli_query($con, $dash_query);
$dash = mysqli_fetch_assoc($dash_result);

// ✅ Total Events
$query = "SELECT COUNT(*) AS total_events FROM cultural_event";
$result = mysqli_query($con, $query);
$total_events = mysqli_fetch_assoc($result)['total_events'] ?? 0;

// ✅ Total Participants
$query = "SELECT COUNT(*) AS total_participants FROM event_register";
$result = mysqli_query($con, $query);
$total_participants = mysqli_fetch_assoc($result)['total_participants'] ?? 0;

// ✅ Total Coordinators
$query = "SELECT COUNT(*) AS total_coordinators 
          FROM ad_register 
          WHERE role='Co-cordinator'";
$result = mysqli_query($con, $query);
$total_coordinators = mysqli_fetch_assoc($result)['total_coordinators'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Co-Coordinator Dashboard – Galore 2026</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- AOS -->
  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

  <!-- Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <!-- SAME CSS -->
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
    }



    .dashboard-header {
      background: var(--gradient-red);
      color: white;
      border-radius: 1.25rem;
      padding: 2rem 1.5rem;
      margin: 1.5rem 0;
      box-shadow: 0 10px 30px rgba(220, 53, 69, 0.15);
    }

    .stat-card {
      border-radius: 1rem;
      padding: 1.5rem;
      box-shadow: 0 6px 18px rgba(0,0,0,0.08);
      border-top: 4px solid var(--primary-red);
      text-align: center;
      background: white;
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

    .stat-number {
      font-size: 2rem;
      font-weight: 700;
    }
  </style>
</head>

<body>

<?php include 'c_navbar.php'; ?>

<!-- HERO -->
<section class="hero">
  <div class="container">
    <h1>Welcome, <?php echo $user_name; ?> 👋</h1>
    <p class="lead">
      <?php echo $user_role; ?> <?php if($coordinator_role) { echo " | " . $coordinator_role; } ?>
    </p>
  </div>
</section>

<div class="container py-5">

<!-- HEADER -->
<div class="dashboard-header mb-4 mb-md-5" data-aos="fade-up">
  <div class="row align-items-center">

    <!-- LEFT SIDE -->
    <div class="col-12 col-lg-8">
      <div class="d-inline-flex align-items-center gap-2 bg-white bg-opacity-25 border border-white border-opacity-25 rounded-pill px-3 py-2 mb-3 fw-semibold">
         <i class="bi <?php echo $dash['icon1']; ?>"></i>
         <?php echo $user_role; ?> <?php if($coordinator_role) { echo " | " . $coordinator_role; } ?>
      </div>
      <h2>Welcome back, <?php echo $user_name; ?> 👋</h2>
      <p class="lead mb-0"><?php echo $dash['title']; ?></p>
    </div>

    <!-- RIGHT SIDE (YOUR CARD) -->
    <div class="col-12 col-lg-4 text-center text-lg-end">
      <div class="card shadow-sm border-0 mx-auto" style="max-width: 320px;">
        <div class="card-body text-center">

          <div class="mx-auto mb-3 rounded-circle d-flex align-items-center justify-content-center"
          style="width:80px;height:80px;background:linear-gradient(135deg,#fff5f5,#ffe6e6);">

            <i class="bi <?php echo $dash['icon2']; ?> display-4"
            style="color:var(--primary-red);"></i>

          </div>

          <h6 class="fw-bold mb-1">
            <?php echo $user_name; ?>
          </h6>

          <small class="text-muted d-block mb-3">
            <?php echo $user_role; ?> <?php if($coordinator_role) { echo " | " . $coordinator_role; } ?>
          </small>

        </div>
      </div>
    </div>

  </div>
</div>

<!-- STATS -->
<!-- <div class="row text-center mt-4">

  <div class="col-md-4">
    <div class="stat-card">
      <div class="stat-icon"><i class="fas fa-calendar-alt"></i></div>
      <div class="stat-number"><?php echo $total_events; ?></div>
      <p>Events</p>
    </div>
  </div>

  <div class="col-md-4">
    <div class="stat-card">
      <div class="stat-icon"><i class="fas fa-users"></i></div>
      <div class="stat-number"><?php echo $total_participants; ?></div>
      <p>Participants</p>
    </div>
  </div>

  <div class="col-md-4">
    <div class="stat-card">
      <div class="stat-icon"><i class="fas fa-user-tie"></i></div>
      <div class="stat-number"><?php echo $total_coordinators; ?></div>
      <p>Coordinators</p>
    </div>
  </div>

</div> -->

</div>

<?php include 'footer.php'; ?>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

<script>
AOS.init({
  duration: 1000,
  once: true
});
</script>

</body>
</html>