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

// ==================== CREATE COORDINATOR TABLE (c_dash1) ====================
$c_dash1_table = "CREATE TABLE IF NOT EXISTS c_dash1 (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    hero_title VARCHAR(255) NOT NULL,
    hero_sub VARCHAR(255) NOT NULL,
    title VARCHAR(255) NOT NULL,
    icon1 VARCHAR(100) NOT NULL,
    name VARCHAR(255) NOT NULL,
    role VARCHAR(255) NOT NULL,
    icon2 VARCHAR(100) NOT NULL,
    status ENUM('Active','Inactive') NOT NULL DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);";

if (mysqli_query($con, $c_dash1_table)) {
    // echo "Table 'c_dash1' created successfully<br>";
} else {
    // echo "Table not created: " . mysqli_error($con) . "<br>";
}

// ==================== CREATE EVENTS TABLE (c_dash2) ====================
$c_dash2_table = "CREATE TABLE IF NOT EXISTS c_dash2 (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    icon VARCHAR(100) NOT NULL,
    count INT(11) NOT NULL DEFAULT 0,
    detail TEXT NOT NULL,
    status ENUM('Active','Inactive') NOT NULL DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);";

if (mysqli_query($con, $c_dash2_table)) {
    // echo "Table 'c_dash2' created successfully<br>";
} else {
    // echo "Table not created: " . mysqli_error($con) . "<br>";
}

// ==================== CREATE THIRD TABLE (c_dash3) - Same as original events table ====================
$c_dash3_table = "CREATE TABLE IF NOT EXISTS c_dash3 (
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

if (mysqli_query($con, $c_dash3_table)) {
    // echo "Table 'c_dash3' created successfully<br>";
} else {
    // echo "Table not created: " . mysqli_error($con) . "<br>";
}

// ==================== HANDLE C_DASH1 FORM SUBMISSION ====================
if (isset($_POST['submit_c_dash1'])) {

    // Get form data
    $hero_title = mysqli_real_escape_string($con, $_POST['hero_title']);
    $hero_sub = mysqli_real_escape_string($con, $_POST['hero_sub']);
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $icon1 = mysqli_real_escape_string($con, $_POST['icon1']);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $role = mysqli_real_escape_string($con, $_POST['role']);
    $icon2 = mysqli_real_escape_string($con, $_POST['icon2']);

    // Check if editing or adding
    if (isset($_POST['edit_id']) && !empty($_POST['edit_id'])) {
        // Update existing record
        $edit_id = mysqli_real_escape_string($con, $_POST['edit_id']);

        $update_query = "UPDATE c_dash1 SET 
                        hero_title = '$hero_title',
                        hero_sub = '$hero_sub',
                        title = '$title',
                        icon1 = '$icon1',
                        name = '$name',
                        role = '$role',
                        icon2 = '$icon2'
                        WHERE id = '$edit_id'";

        if (mysqli_query($con, $update_query)) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "<script>alert('Error updating record: " . mysqli_error($con) . "');</script>";
        }
    } else {
        // Insert new record with default status 'Active'
        $insert_query = "INSERT INTO c_dash1 (hero_title, hero_sub, title, icon1, name, role, icon2, status) 
                         VALUES ('$hero_title', '$hero_sub', '$title', '$icon1', '$name', '$role', '$icon2', 'Active')";

        if (mysqli_query($con, $insert_query)) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
        }
    }
}

// ==================== HANDLE C_DASH2 FORM SUBMISSION ====================
if (isset($_POST['submit_c_dash2'])) {

    // Get form data
    $icon = mysqli_real_escape_string($con, $_POST['icon']);
    $count = mysqli_real_escape_string($con, $_POST['count']);
    $detail = mysqli_real_escape_string($con, $_POST['detail']);

    // Check if editing or adding
    if (isset($_POST['edit_id']) && !empty($_POST['edit_id'])) {
        // Update existing record
        $edit_id = mysqli_real_escape_string($con, $_POST['edit_id']);

        $update_query = "UPDATE c_dash2 SET 
                        icon = '$icon',
                        count = '$count',
                        detail = '$detail'
                        WHERE id = '$edit_id'";

        if (mysqli_query($con, $update_query)) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "<script>alert('Error updating record: " . mysqli_error($con) . "');</script>";
        }
    } else {
        // Insert new record with default status 'Active'
        $insert_query = "INSERT INTO c_dash2 (icon, count, detail, status) 
                         VALUES ('$icon', '$count', '$detail', 'Active')";

        if (mysqli_query($con, $insert_query)) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
        }
    }
}

// ==================== HANDLE C_DASH3 FORM SUBMISSION ====================
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
        // Update existing event
        $edit_id = mysqli_real_escape_string($con, $_POST['edit_id']);

        $update_query = "UPDATE c_dash3 SET 
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
        $insert_query = "INSERT INTO c_dash3 (event_name, category, school, date_range, time, venue, status, total_registrations, pending_registrations, icon) 
                         VALUES ('$event_name', '$category', '$school', '$date_range', '$time', '$venue', '$status', '$total_registrations', '$pending_registrations', '$icon')";

        if (mysqli_query($con, $insert_query)) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
        }
    }
}

// ==================== HANDLE STATUS TOGGLE FOR C_DASH1 ====================
if (isset($_GET['toggle_c_dash1_id'])) {
    $toggle_id = mysqli_real_escape_string($con, $_GET['toggle_c_dash1_id']);

    $toggle_query = "UPDATE c_dash1 SET status = IF(status = 'Active', 'Inactive', 'Active') WHERE id = '$toggle_id'";
    if (mysqli_query($con, $toggle_query)) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "<script>alert('Error toggling status: " . mysqli_error($con) . "');</script>";
    }
}

// ==================== HANDLE STATUS TOGGLE FOR C_DASH2 ====================
if (isset($_GET['toggle_c_dash2_id'])) {
    $toggle_id = mysqli_real_escape_string($con, $_GET['toggle_c_dash2_id']);

    $toggle_query = "UPDATE c_dash2 SET status = IF(status = 'Active', 'Inactive', 'Active') WHERE id = '$toggle_id'";
    if (mysqli_query($con, $toggle_query)) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "<script>alert('Error toggling status: " . mysqli_error($con) . "');</script>";
    }
}

// ==================== HANDLE DELETE REQUESTS ====================
// Delete from c_dash1
if (isset($_GET['delete_c_dash1_id'])) {
    $delete_id = mysqli_real_escape_string($con, $_GET['delete_c_dash1_id']);

    $delete_query = "DELETE FROM c_dash1 WHERE id = '$delete_id'";
    if (mysqli_query($con, $delete_query)) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "<script>alert('Error deleting record: " . mysqli_error($con) . "');</script>";
    }
}

// Delete from c_dash2
if (isset($_GET['delete_c_dash2_id'])) {
    $delete_id = mysqli_real_escape_string($con, $_GET['delete_c_dash2_id']);

    $delete_query = "DELETE FROM c_dash2 WHERE id = '$delete_id'";
    if (mysqli_query($con, $delete_query)) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "<script>alert('Error deleting record: " . mysqli_error($con) . "');</script>";
    }
}

// Delete from c_dash3
if (isset($_GET['delete_c_dash3_id'])) {
    $delete_id = mysqli_real_escape_string($con, $_GET['delete_c_dash3_id']);

    $delete_query = "DELETE FROM c_dash3 WHERE id = '$delete_id'";
    if (mysqli_query($con, $delete_query)) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "<script>alert('Error deleting event: " . mysqli_error($con) . "');</script>";
    }
}

// ==================== FETCH ALL C_DASH1 RECORDS ====================
$c_dash1Data = [];
$select_query = "SELECT * FROM c_dash1 ORDER BY id ASC";
$result = mysqli_query($con, $select_query);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $c_dash1Data[] = $row;
    }
}

// ==================== FETCH ALL C_DASH2 RECORDS ====================
$c_dash2Data = [];
$select_query = "SELECT * FROM c_dash2 ORDER BY id ASC";
$result = mysqli_query($con, $select_query);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $c_dash2Data[] = $row;
    }
}

// ==================== FETCH ALL C_DASH3 RECORDS ====================
$c_dash3Data = [];
$select_query = "SELECT * FROM c_dash3 ORDER BY id ASC";
$result = mysqli_query($con, $select_query);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $c_dash3Data[] = $row;
    }
}
?>