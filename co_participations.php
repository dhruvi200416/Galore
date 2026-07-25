<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$con = mysqli_connect("localhost", "root", "", "galore2026");

// get logged-in user
$email = $_SESSION['email'];

$user_query = "SELECT coordinator_role FROM ad_register WHERE email='$email'";
$user_result = mysqli_query($con, $user_query);
$user = mysqli_fetch_assoc($user_result);

$coordinator_role = $user['coordinator_role'];

// fetch participants based on coordinator role
$query = "SELECT * FROM event_register 
          WHERE Sports_Outdoor='$coordinator_role' 
          OR Sports_Indoor='$coordinator_role'";

$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Participants</title>
</head>
<body>
<!-- HERO -->
<section class="hero">
    <h1>Participation</h1>
    <p>View & manage your Galore participation</p>
</section>

<h2>Participants for: <?php echo $coordinator_role; ?></h2>

<table border="1" cellpadding="10">
<tr>
    <th>Name</th>
    <th>Enrollment</th>
    <th>Branch</th>
    <th>Event</th>
    <th>Phone</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>
<tr>
    <td><?php echo $row['full_name']; ?></td>
    <td><?php echo $row['enrollment_no']; ?></td>
    <td><?php echo $row['branch']; ?></td>
    <td>
        <?php 
        echo $row['Sports_Outdoor'] . " / " . $row['Sports_Indoor']; 
        ?>
    </td>
    <td><?php echo $row['phone']; ?></td>
</tr>
<?php } ?>

</table>

</body>
</html> 