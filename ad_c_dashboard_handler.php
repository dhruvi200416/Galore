<?php
require_once 'admin_auth_check.php';

// Database connection
$con = mysqli_connect("localhost", "root", "");

// Create database if not exists
$create_db = "CREATE DATABASE IF NOT EXISTS galore2026";
if (mysqli_query($con, $create_db)) {
    // Database created or already exists
} else {
    die("Database error: " . mysqli_error($con));
}

// Select the database
mysqli_select_db($con, "galore2026");

// ==================== CREATE co_dash1 TABLE (Dashboard Items) ====================
$co_dash1_table = "CREATE TABLE IF NOT EXISTS co_dash1 (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    icon VARCHAR(100) NOT NULL,
    hero_title VARCHAR(255) NOT NULL,
    hero_subtitle VARCHAR(255) NOT NULL,
    title VARCHAR(255) NOT NULL,
    icons TEXT NOT NULL,
    sub TEXT NOT NULL,
    status ENUM('Active','Inactive') NOT NULL DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);";

if (!mysqli_query($con, $co_dash1_table)) {
    // echo "Error creating co_dash1: " . mysqli_error($con);
}

// ==================== CREATE co_dash2 TABLE (Statistics Items) ====================
$co_dash2_table = "CREATE TABLE IF NOT EXISTS co_dash2 (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    icon VARCHAR(100) NOT NULL,
    count_val VARCHAR(50) NOT NULL,
    title VARCHAR(255) NOT NULL,
    status ENUM('Active','Inactive') NOT NULL DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);";

if (!mysqli_query($con, $co_dash2_table)) {
    // echo "Error creating co_dash2: " . mysqli_error($con);
}

// ==================== CREATE co_dash3 TABLE (Events) ====================
$co_dash3_table = "CREATE TABLE IF NOT EXISTS co_dash3 (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    event_name VARCHAR(255) NOT NULL,
    category VARCHAR(100) NOT NULL,
    school VARCHAR(255) NOT NULL,
    date_range VARCHAR(100) NOT NULL,
    time VARCHAR(50) NOT NULL,
    venue VARCHAR(255) NOT NULL,
    status ENUM('Scheduled','Pending','Upcoming','Completed') NOT NULL DEFAULT 'Pending',
    total_registrations INT(11) NOT NULL DEFAULT 0,
    pending_registrations INT(11) NOT NULL DEFAULT 0,
    icon VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);";

if (!mysqli_query($con, $co_dash3_table)) {
    // echo "Error creating co_dash3: " . mysqli_error($con);
}

// ==================== HANDLE co_dash1 FORM SUBMISSION ====================
if (isset($_POST['submit_c_dash1'])) {
    // Get form data
    $icon = mysqli_real_escape_string($con, $_POST['icon']);
    $hero_title = mysqli_real_escape_string($con, $_POST['hero_title']);
    $hero_subtitle = mysqli_real_escape_string($con, $_POST['hero_subtitle']);
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $icons = mysqli_real_escape_string($con, $_POST['icons']);
    $sub = mysqli_real_escape_string($con, $_POST['sub']);
    
    // Check if editing or adding
    if (isset($_POST['edit_id']) && !empty($_POST['edit_id'])) {
        $edit_id = mysqli_real_escape_string($con, $_POST['edit_id']);
        $update_query = "UPDATE co_dash1 SET 
                        icon = '$icon',
                        hero_title = '$hero_title',
                        hero_subtitle = '$hero_subtitle',
                        title = '$title',
                        icons = '$icons',
                        sub = '$sub'
                        WHERE id = '$edit_id'";
        if (mysqli_query($con, $update_query)) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "<script>alert('Error updating record: " . mysqli_error($con) . "');</script>";
        }
    } else {
        // Insert new record with default status 'Active'
        $insert_query = "INSERT INTO co_dash1 (icon, hero_title, hero_subtitle, title, icons, sub, status) 
                         VALUES ('$icon', '$hero_title', '$hero_subtitle', '$title', '$icons', '$sub', 'Active')";
        if (mysqli_query($con, $insert_query)) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
        }
    }
}

// ==================== HANDLE co_dash2 FORM SUBMISSION ====================
if (isset($_POST['submit_c_dash2'])) {
    // Get form data
    $icon = mysqli_real_escape_string($con, $_POST['stats_icon']);
    $count_val = mysqli_real_escape_string($con, $_POST['stats_count']);
    $title = mysqli_real_escape_string($con, $_POST['stats_title']);
    
    // Check if editing or adding
    if (isset($_POST['edit_id']) && !empty($_POST['edit_id'])) {
        $edit_id = mysqli_real_escape_string($con, $_POST['edit_id']);
        $update_query = "UPDATE co_dash2 SET 
                        icon = '$icon',
                        count_val = '$count_val',
                        title = '$title'
                        WHERE id = '$edit_id'";
        if (mysqli_query($con, $update_query)) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "<script>alert('Error updating record: " . mysqli_error($con) . "');</script>";
        }
    } else {
        // Insert new record with default status 'Active'
        $insert_query = "INSERT INTO co_dash2 (icon, count_val, title, status) 
                         VALUES ('$icon', '$count_val', '$title', 'Active')";
        if (mysqli_query($con, $insert_query)) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
        }
    }
}

// ==================== HANDLE co_dash3 FORM SUBMISSION ====================
if (isset($_POST['submit_c_dash3'])) {
    // Get form data
    $event_name = mysqli_real_escape_string($con, $_POST['event_name']);
    $category = mysqli_real_escape_string($con, $_POST['category']);
    $school = mysqli_real_escape_string($con, $_POST['school']);
    $date_range = mysqli_real_escape_string($con, $_POST['date_range']);
    $time = mysqli_real_escape_string($con, $_POST['time']);
    $venue = mysqli_real_escape_string($con, $_POST['venue']);
    $status = mysqli_real_escape_string($con, $_POST['status']);
    $total_registrations = mysqli_real_escape_string($con, $_POST['total_registrations']);
    $pending_registrations = mysqli_real_escape_string($con, $_POST['pending_registrations']);
    $icon = mysqli_real_escape_string($con, $_POST['event_icon']);
    
    // Check if editing or adding
    if (isset($_POST['edit_id']) && !empty($_POST['edit_id'])) {
        $edit_id = mysqli_real_escape_string($con, $_POST['edit_id']);
        $update_query = "UPDATE co_dash3 SET 
                        event_name = '$event_name',
                        category = '$category',
                        school = '$school',
                        date_range = '$date_range',
                        time = '$time',
                        venue = '$venue',
                        status = '$status',
                        total_registrations = '$total_registrations',
                        pending_registrations = '$pending_registrations',
                        icon = '$icon'
                        WHERE id = '$edit_id'";
        if (mysqli_query($con, $update_query)) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "<script>alert('Error updating event: " . mysqli_error($con) . "');</script>";
        }
    } else {
        // Insert new event
        $insert_query = "INSERT INTO co_dash3 (event_name, category, school, date_range, time, venue, status, total_registrations, pending_registrations, icon) 
                         VALUES ('$event_name', '$category', '$school', '$date_range', '$time', '$venue', '$status', '$total_registrations', '$pending_registrations', '$icon')";
        if (mysqli_query($con, $insert_query)) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
        }
    }
}

// ==================== HANDLE STATUS TOGGLE FOR co_dash1 ====================
if (isset($_GET['toggle_c_dash1_id'])) {
    $toggle_id = mysqli_real_escape_string($con, $_GET['toggle_c_dash1_id']);
    $toggle_query = "UPDATE co_dash1 SET status = IF(status = 'Active', 'Inactive', 'Active') WHERE id = '$toggle_id'";
    if (mysqli_query($con, $toggle_query)) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

// ==================== HANDLE STATUS TOGGLE FOR co_dash2 ====================
if (isset($_GET['toggle_c_dash2_id'])) {
    $toggle_id = mysqli_real_escape_string($con, $_GET['toggle_c_dash2_id']);
    $toggle_query = "UPDATE co_dash2 SET status = IF(status = 'Active', 'Inactive', 'Active') WHERE id = '$toggle_id'";
    if (mysqli_query($con, $toggle_query)) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

// ==================== HANDLE DELETE REQUESTS ====================
// Delete from co_dash1
if (isset($_GET['delete_c_dash1_id'])) {
    $delete_id = mysqli_real_escape_string($con, $_GET['delete_c_dash1_id']);
    $delete_query = "DELETE FROM co_dash1 WHERE id = '$delete_id'";
    if (mysqli_query($con, $delete_query)) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

// Delete from co_dash2
if (isset($_GET['delete_c_dash2_id'])) {
    $delete_id = mysqli_real_escape_string($con, $_GET['delete_c_dash2_id']);
    $delete_query = "DELETE FROM co_dash2 WHERE id = '$delete_id'";
    if (mysqli_query($con, $delete_query)) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

// Delete from co_dash3
if (isset($_GET['delete_c_dash3_id'])) {
    $delete_id = mysqli_real_escape_string($con, $_GET['delete_c_dash3_id']);
    $delete_query = "DELETE FROM co_dash3 WHERE id = '$delete_id'";
    if (mysqli_query($con, $delete_query)) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

// ==================== FETCH ALL co_dash1 RECORDS ====================
$c_dash1Data = [];
$select_query = "SELECT * FROM co_dash1 ORDER BY id ASC";
$result = mysqli_query($con, $select_query);
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $c_dash1Data[] = $row;
    }
}

// ==================== FETCH ALL co_dash2 RECORDS ====================
$c_dash2Data = [];
$select_query = "SELECT * FROM co_dash2 ORDER BY id ASC";
$result = mysqli_query($con, $select_query);
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $c_dash2Data[] = $row;
    }
}

// ==================== FETCH ALL co_dash3 RECORDS ====================
$c_dash3Data = [];
$select_query = "SELECT * FROM co_dash3 ORDER BY id ASC";
$result = mysqli_query($con, $select_query);
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $c_dash3Data[] = $row;
    }
}
?>