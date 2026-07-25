<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "galore2026");

$email = $_SESSION['email'];

// fetch current data
$result = mysqli_query($con,"SELECT * FROM ad_register WHERE email='$email'");
$user = mysqli_fetch_assoc($result);

$name   = $_POST['full_name'];
$phone  = $_POST['phone'];
$branch = $_POST['branch'];
$school = $_POST['school'];

$changes = false; // track if any change occurs

// Compare submitted data with existing
if($name != $user['full_name'] || $phone != $user['phone'] || $branch != $user['branch'] || $school != $user['school']){
    $changes = true;
}

// Handle profile picture
$profile_pic = $user['profile_pic'];
if(isset($_FILES['profile_pic']) && $_FILES['profile_pic']['name'] != ""){
    $ext = strtolower(pathinfo($_FILES['profile_pic']['name'], PATHINFO_EXTENSION));
    if(!in_array($ext, ['jpg','jpeg','png','gif'])){
        echo "<script>
            alert('Only JPG, PNG, GIF files are allowed!');
            window.location.href='c_profile.php';
        </script>";
        exit();
    }
    $img = time().'_'.basename($_FILES['profile_pic']['name']);
    if(move_uploaded_file($_FILES['profile_pic']['tmp_name'], "uploads/".$img)){
        $profile_pic = $img;
        $changes = true;
    } else {
        echo "<script>
            alert('Error uploading profile picture!');
            window.location.href='c_profile.php';
        </script>";
        exit();
    }
}

// Update if changes
if($changes){
    $sql = "UPDATE ad_register SET 
        full_name='$name',
        phone='$phone',
        branch='$branch',
        school='$school',
        profile_pic='$profile_pic'
        WHERE email='$email'";
    if(mysqli_query($con,$sql)){
        echo "<script>
            alert('Profile updated successfully!');
            window.location.href='c_profile.php';
        </script>";
        exit();
    } else {
        echo "<script>
            alert('Error updating profile: ".mysqli_real_escape_string($con, mysqli_error($con))."');
            window.location.href='c_profile.php';
        </script>";
        exit();
    }
} else {
    echo "<script>
        alert('No changes yet!');
        window.location.href='c_profile.php';
    </script>";
    exit();
}
?>