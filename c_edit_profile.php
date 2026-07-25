<?php
session_start();
include 'co_navbar.php';

$con = mysqli_connect("localhost", "root", "", "galore2026");
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
    <title>Edit Profile | Galore 2026</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap & Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Your existing CSS remains unchanged */
        body { font-family: "Segoe UI", sans-serif; background: linear-gradient(135deg, #ffffff, #f8f9fa); }
        .edit-card { max-width: 900px; margin: 60px auto; background: white; border-radius: 25px; padding: 40px; box-shadow: 0 20px 60px rgba(0,0,0,0.15); border-top: 6px solid #dc3545; }
        .profile-header { display: flex; align-items: center; gap: 30px; margin-bottom: 30px; flex-wrap: wrap; }
        .profile-avatar img { width: 120px; height: 120px; border-radius: 50%; border: 4px solid #dc3545; }
        .profile-header h3 { color: #dc3545; font-weight: 700; margin-bottom: 5px; }
        .file-text { font-size: 12px; color: gray; }
        .input-box { background: #fff5f5; padding: 18px; border-radius: 12px; border-left: 5px solid #dc3545; }
        .input-box label { font-size: 13px; color: gray; font-weight: 600; }
        .input-box input, .input-box select { border: none; background: transparent; font-weight: 600; margin-top: 5px; width: 100%; outline: none; }
        .form-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; }
        .btn-save { background: #dc3545; color: white; padding: 12px 30px; border-radius: 25px; border: none; font-weight: 600; }
        .btn-cancel { background: #6c757d; color: white; padding: 12px 30px; border-radius: 25px; border: none; font-weight: 600; }
        .btn-save:hover { background: #b02a37; }
        .btn-cancel:hover { background: #5a6268; }
        @media(max-width:768px){ .form-grid{ grid-template-columns:1fr; } .profile-header{ flex-direction: column; text-align: center; } }
    </style>
</head>
<body>

<section class="hero">
    <h1>My Profile</h1>
    <p>View & manage your Galore participation</p>
</section>

<div class="edit-card">

    <form action="c_update_profile.php" method="POST" enctype="multipart/form-data">

        <!-- HEADER -->
        <div class="profile-header">
            <div class="profile-avatar">
                <img src="uploads/<?php echo !empty($image) ? $image : 'user.png'; ?>" id="preview">
            </div>

            <div>
                <h3><?php echo $name; ?></h3>
                <p class="text-muted">Update your profile information below</p>

                <!-- ✅ Move file input inside the form -->
                <input type="file" name="profile_pic" id="upload" class="form-control mt-2" style="max-width:250px;">
                <div class="file-text">Max size: 2MB (JPG, PNG, GIF only)</div>
            </div>
        </div>

        <div class="form-grid">

            <div class="input-box">
                <label>Full Name *</label>
                <input type="text" name="full_name" value="<?php echo $name; ?>">
            </div>

            <div class="input-box">
                <label>Contact Number *</label>
                <input type="text" name="phone" value="<?php echo $phone; ?>">
            </div>

            <div class="input-box">
                <label>Branch *</label>
                <input type="text" name="branch" value="<?php echo $branch; ?>">
            </div>

            <div class="input-box">
                <label>School *</label>
                <input type="text" name="school" value="<?php echo $school; ?>">
            </div>

            <div class="input-box">
                <label>Email *</label>
                <input type="email" value="<?php echo $email; ?>" readonly>
            </div>

           
        </div>

        <!-- BUTTONS -->
        <div class="text-center mt-4">
            <button type="submit" class="btn-save">Save Changes</button>
            <a href="c_profile.php" class="btn-cancel ms-2">Cancel</a>
        </div>

    </form>

</div>

<?php include 'footer.php'; ?>

<script>
document.getElementById('upload').addEventListener('change', function(e){
    const file = e.target.files[0];
    if(file){
        document.getElementById('preview').src = URL.createObjectURL(file);
    }
});
</script>

</body>
</html>