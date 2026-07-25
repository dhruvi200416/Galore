<?php
session_start();
include 'co_navbar.php';

// DB connection
$con = mysqli_connect("localhost", "root", "", "galore2026");

// Get logged-in user
$email = $_SESSION['email'];
$result = mysqli_query($con, "SELECT * FROM ad_register WHERE email='$email'");
$user = mysqli_fetch_assoc($result);

// SAFE VALUES
$name   = $user['full_name'] ?? '';
$phone  = $user['phone'] ?? '';
$branch = $user['branch'] ?? '';
$gender = $user['gender'] ?? '';
$school = $user['school'] ?? '';
$image  = $user['profile_pic'] ?? 'user.png';
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

        .profile-card {
            max-width: 900px;
            margin: -80px auto 50px;
            background: white;
            border-radius: 25px;
            padding: 40px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.15);
        }

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

<!-- HERO -->
<section class="hero">
    <h1>My Profile</h1>
    <p>View & manage your Galore participation</p>
</section>

<!-- PROFILE -->
<div class="profile-card" data-aos="fade-up">

    <div class="profile-header">
        <div class="profile-avatar">
        <img src="uploads/<?php echo !empty($user['profile_pic']) ? $user['profile_pic'] : 'user.png'; ?>">
        </div>

        <div>
            <h3><?php echo $name; ?></h3>
            <p><?php echo $branch; ?></p>

        </div>
    </div>

    <div class="info-grid">

        <div class="info-box">
            <small>School</small>
            <p><?php echo $school; ?></p>
        </div>

       

        <div class="info-box">
            <small>Email</small>
            <p><?php echo $email; ?></p>
        </div>

        <div class="info-box">
            <small>Contact No</small>
            <p><?php echo $phone; ?></p>
        </div>

    </div>

    <div class="text-center">
        <a href="c_edit_profile.php" class="btn-edit">
            <i class="fas fa-edit"></i> Edit Profile
        </a>
        <a href="c_change_password.php" class="btn-edit">
            <i class="fas fa-edit"></i> Change password
        </a>
    </div>

</div>

<?php include 'footer.php'; ?>

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