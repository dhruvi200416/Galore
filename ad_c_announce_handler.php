<?php
require_once 'admin_auth_check.php';

$con = mysqli_connect("localhost", "root", "");

// Create database if not exists (to avoid error if it already exists)
$create_db = "CREATE DATABASE IF NOT EXISTS galore2026";
if (mysqli_query($con, $create_db)) {
    //  echo "Database checked/created successfully<br>";
} else {
    echo "Database error: " . mysqli_error($con) . "<br>";
}

// Select the database
mysqli_select_db($con, "galore2026");

// Create co_announce1 table (for Announcements)
$announce1_table = "CREATE TABLE IF NOT EXISTS co_announce1 (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    hero_title VARCHAR(255) NOT NULL,
    hero_subtitle VARCHAR(255) NOT NULL,
    status ENUM('Active','Inactive') NOT NULL DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  );";

if (mysqli_query($con, $announce1_table)) {
    // echo "Table 'co_announce1' created successfully";
} else {
    // echo "Table not created: " . mysqli_error($con);
}

// Create co_announce2 table (for Statistics)
$announce2_table = "CREATE TABLE IF NOT EXISTS co_announce2 (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    icon VARCHAR(100) NOT NULL,
    count INT(11) NOT NULL,
    heading VARCHAR(255) NOT NULL,
    status ENUM('Active','Inactive') NOT NULL DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  );";

if (mysqli_query($con, $announce2_table)) {
    // echo "Table 'co_announce2' created successfully";
} else {
    // echo "Table not created: " . mysqli_error($con);
}

// Handle form submission for announcement page (co_announce1)
if (isset($_POST['submit_announce'])) {

    // Get form data (status not included from form)
    $hero_title = mysqli_real_escape_string($con, $_POST['gallery_hero_title']);
    $hero_subtitle = mysqli_real_escape_string($con, $_POST['gallery_hero_subtitle']);

    // Check if editing or adding
    if (isset($_POST['edit_id_announce']) && !empty($_POST['edit_id_announce'])) {
        // Update existing announcement - status not updated from form
        $edit_id = mysqli_real_escape_string($con, $_POST['edit_id_announce']);

        $update_query = "UPDATE co_announce1 SET 
                        hero_title = '$hero_title',
                        hero_subtitle = '$hero_subtitle'
                        WHERE id = '$edit_id'";

        if (mysqli_query($con, $update_query)) {
            // Redirect to the same page to prevent form resubmission
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "<script>alert('Error updating announcement: " . mysqli_error($con) . "');</script>";
        }
    } else {
        // Insert new announcement - status defaults to 'Active' from table definition
        $insert_query = "INSERT INTO co_announce1 (hero_title, hero_subtitle) 
                         VALUES ('$hero_title', '$hero_subtitle')";

        if (mysqli_query($con, $insert_query)) {
            // Redirect to the same page to prevent form resubmission
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
        }
    }
}

// Handle form submission for statistics (co_announce2)
if (isset($_POST['submit_stats'])) {

    // Get form data (status not included from form)
    $icon = mysqli_real_escape_string($con, $_POST['stats_icon']);
    $count = mysqli_real_escape_string($con, $_POST['stats_count']);
    $heading = mysqli_real_escape_string($con, $_POST['stats_heading']);

    // Check if editing or adding
    if (isset($_POST['edit_id_stats']) && !empty($_POST['edit_id_stats'])) {
        // Update existing statistics - status not updated from form
        $edit_id = mysqli_real_escape_string($con, $_POST['edit_id_stats']);

        $update_query = "UPDATE co_announce2 SET 
                        icon = '$icon',
                        count = '$count',
                        heading = '$heading'
                        WHERE id = '$edit_id'";

        if (mysqli_query($con, $update_query)) {
            // Redirect to the same page to prevent form resubmission
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "<script>alert('Error updating statistics: " . mysqli_error($con) . "');</script>";
        }
    } else {
        // Insert new statistics - status defaults to 'Active' from table definition
        $insert_query = "INSERT INTO co_announce2 (icon, count, heading) 
                         VALUES ('$icon', '$count', '$heading')";

        if (mysqli_query($con, $insert_query)) {
            // Redirect to the same page to prevent form resubmission
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
        }
    }
}

// Handle status toggle request for announcements
if (isset($_GET['toggle_id_announce'])) {
    $toggle_id = mysqli_real_escape_string($con, $_GET['toggle_id_announce']);

    $toggle_query = "UPDATE co_announce1 SET status = IF(status = 'Active', 'Inactive', 'Active') WHERE id = '$toggle_id'";
    if (mysqli_query($con, $toggle_query)) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "<script>alert('Error toggling announcement status: " . mysqli_error($con) . "');</script>";
    }
}

// Handle status toggle request for statistics
if (isset($_GET['toggle_id_stats'])) {
    $toggle_id = mysqli_real_escape_string($con, $_GET['toggle_id_stats']);

    $toggle_query = "UPDATE co_announce2 SET status = IF(status = 'Active', 'Inactive', 'Active') WHERE id = '$toggle_id'";
    if (mysqli_query($con, $toggle_query)) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "<script>alert('Error toggling statistics status: " . mysqli_error($con) . "');</script>";
    }
}

// Handle delete request for announcements
if (isset($_GET['delete_id_announce'])) {
    $delete_id = mysqli_real_escape_string($con, $_GET['delete_id_announce']);

    $delete_query = "DELETE FROM co_announce1 WHERE id = '$delete_id'";
    if (mysqli_query($con, $delete_query)) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "<script>alert('Error deleting announcement: " . mysqli_error($con) . "');</script>";
    }
}

// Handle delete request for statistics
if (isset($_GET['delete_id_stats'])) {
    $delete_id = mysqli_real_escape_string($con, $_GET['delete_id_stats']);

    $delete_query = "DELETE FROM co_announce2 WHERE id = '$delete_id'";
    if (mysqli_query($con, $delete_query)) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "<script>alert('Error deleting statistics: " . mysqli_error($con) . "');</script>";
    }
}

// Fetch all announcements from database for display
$announceData = [];
$select_query = "SELECT * FROM co_announce1 ORDER BY id ASC";
$result = mysqli_query($con, $select_query);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $announceData[] = $row;
    }
}

// Fetch all statistics from database for display
$statsData = [];
$select_query = "SELECT * FROM co_announce2 ORDER BY id ASC";
$result = mysqli_query($con, $select_query);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $statsData[] = $row;
    }
}
?>
