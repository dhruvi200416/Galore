<?php
session_start();
include 'c_navbar.php';

$con = mysqli_connect("localhost", "root", "", "galore2026");

$email = $_SESSION['email'];
$result = mysqli_query($con, "SELECT * FROM ad_register WHERE email='$email'");
$user = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>My Profile | Galore 2026</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- AOS -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: "Segoe UI", sans-serif;
            background: #f8f9fa;
        }

        /* HERO */
        .hero {
            background: linear-gradient(135deg, #dc3545, #7a1c25);
            color: white;
            text-align: center;
            padding: 140px 20px 100px;
            position: relative;
        }

        .hero::after {
            content: "";
            position: absolute;
            bottom: -60px;
            width: 100%;
            height: 120px;
            background: #f8f9fa;
            border-radius: 50% 50% 0 0;
        }

        .hero h1 {
            font-size: 3rem;
            font-weight: 800;
        }

        .hero p {
            opacity: 0.9;
        }

        /* PROFILE CARD */
        .profile-card {
            max-width: 900px;
            margin: -80px auto 50px;
            background: white;
            border-radius: 25px;
            padding: 40px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.15);
        }

        /* HEADER */
        .profile-header {
            display: flex;
            align-items: center;
            gap: 25px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .profile-avatar img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid #dc3545;
        }

        .profile-header h3 {
            color: #dc3545;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .profile-header p {
            margin: 2px 0;
            color: #555;
        }

        .badge-group span {
            margin-right: 8px;
            padding: 6px 12px;
            border-radius: 20px;
        }

        /* INFO GRID */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .info-box {
            background: #fff5f5;
            padding: 20px;
            border-radius: 12px;
            border-left: 5px solid #dc3545;
        }

        .info-box small {
            color: gray;
            font-weight: 600;
        }

        .info-box p {
            margin: 5px 0 0;
            font-weight: bold;
        }

        /* BUTTON */
        .btn-edit {
            background: #dc3545;
            color: white;
            padding: 12px 30px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
        }

        .btn-edit:hover {
            background: #b02a37;
            color: white;
        }

        /* MOBILE */
        @media (max-width: 768px) {
            .info-grid {
                grid-template-columns: 1fr;
            }

            .profile-header {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
</head>

<body>

<!-- NAVBAR -->
<?php include 'c_navbar.php'; ?>

<!-- HERO -->
<section class="hero">
    <h1>My Profile</h1>
    <p>View & manage your Galore participation</p>
</section>

<!-- PROFILE CARD -->
<div class="profile-card" data-aos="fade-up">

    <!-- HEADER -->
    <div class="profile-header">
        <div class="profile-avatar">
        <img src="uploads/<?php echo !empty($user['profile_pic']) ? $user['profile_pic'] : 'user.png'; ?>">
        </div>

        <div>
  <h3><?php echo $user['full_name']; ?></h3>
        <p><?php echo $user['branch']; ?></p>

            
        </div>
    </div>

    <!-- INFO -->
<div class="info-grid">
        <div class="info-box"><small>Contact</small><p><?php echo $user['full_name']; ?></p></div>
            <div class="info-box"><small>Contact</small><p><?php echo $user['branch']; ?></p></div>
    <div class="info-box"><small>School</small><p><?php echo $user['school']; ?></p></div>
    <div class="info-box"><small>Email</small><p><?php echo $user['email']; ?></p></div>
    <div class="info-box"><small>Contact</small><p><?php echo $user['phone']; ?></p></div>
</div>

    <!-- BUTTON -->
    <div class="text-center">
        <a href="co_edit_profile.php" class="btn-edit">
            <i class="fas fa-edit"></i> Edit Profile
        </a>
         <a href="co_change_password.php" class="btn-edit">
            <i class="fas fa-edit"></i> Chnage Password
            </a>
    </div>

</div>

<!-- FOOTER -->
<?php include 'footer.php'; ?>

<!-- JS -->
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