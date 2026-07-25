<?php
// Start session if not started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database connection
$con = mysqli_connect("localhost", "root", "", "galore2026");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch logged-in user data from registration table
$user_id = $_SESSION['user_id'];
$user_data = [];

$user_query = "SELECT enrollment_no, full_name, email, phone, branch, semester, school FROM registration WHERE id = ? AND status = 'Active'";
$stmt = mysqli_prepare($con, $user_query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$user_result = mysqli_stmt_get_result($stmt);

if ($user_result && mysqli_num_rows($user_result) > 0) {
    $user_data = mysqli_fetch_assoc($user_result);
}
mysqli_stmt_close($stmt);

// Fetch hero data from database
$sql = "SELECT hero_title, hero_subtitle FROM event_reg_header LIMIT 1";
$result = mysqli_query($con, $sql);

$hero_title = "Galore 2026 Event Registration";
$hero_subtitle = "Register for exciting sports and cultural events";

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $hero_title = $row['hero_title'];
    $hero_subtitle = $row['hero_subtitle'];
}

// Initialize variables for form submission
$success_message = "";
$error_message = "";

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register_events'])) {

    // Get personal details
    $enrollment_no = mysqli_real_escape_string($con, trim($_POST['enrollment_no'] ?? ''));
    $full_name = mysqli_real_escape_string($con, trim($_POST['full_name'] ?? ''));
    $email = mysqli_real_escape_string($con, trim($_POST['email'] ?? ''));
    $phone = mysqli_real_escape_string($con, trim($_POST['phone'] ?? ''));
    $branch = mysqli_real_escape_string($con, trim($_POST['branch'] ?? ''));
    $semester = intval($_POST['semester'] ?? 0);
    $school = mysqli_real_escape_string($con, trim($_POST['school'] ?? ''));

    // Get selected events
    $selected_events = $_POST['events'] ?? [];

    // Categorize events
    $outdoor_events_list = ['Cricket', 'Volleyball', 'Basketball', 'Dodgeball'];
    $indoor_events_list = ['Carrom', 'Duo Carrom', 'Chess', 'Table Tennis', 'Duo Table Tennis'];
    $cultural_events_list = ['Drawing', 'Singing', 'Public Speaking', 'Rangoli', 'Solo Dance', 'Duo Dance', 'Group Dance'];

    $sports_outdoor = '';
    $sports_indoor = '';
    $cultural = '';

    // Separate events by category
    foreach ($selected_events as $event) {
        if (in_array($event, $outdoor_events_list)) {
            $sports_outdoor .= ($sports_outdoor ? ', ' : '') . $event;
        } elseif (in_array($event, $indoor_events_list)) {
            $sports_indoor .= ($sports_indoor ? ', ' : '') . $event;
        } elseif (in_array($event, $cultural_events_list)) {
            $cultural .= ($cultural ? ', ' : '') . $event;
        }
    }

    // Set NULL for empty values
    $sports_outdoor = !empty($sports_outdoor) ? $sports_outdoor : null;
    $sports_indoor = !empty($sports_indoor) ? $sports_indoor : null;
    $cultural = !empty($cultural) ? $cultural : null;

    // Validation
    $errors = [];

    if (empty($enrollment_no)) {
        $errors[] = "Enrollment number is required.";
    }
    if (empty($full_name)) {
        $errors[] = "Full name is required.";
    }
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }
    if (empty($phone)) {
        $errors[] = "Phone number is required.";
    } elseif (!preg_match('/^[0-9]{10}$/', $phone)) {
        $errors[] = "Please enter a valid 10-digit phone number.";
    }
    if (empty($branch)) {
        $errors[] = "Branch is required.";
    }
    if ($semester == 0) {
        $errors[] = "Please select a semester.";
    }
    if (empty($school)) {
        $errors[] = "School is required.";
    }
    if (empty($selected_events)) {
        $errors[] = "Please select at least one event to register.";
    }

    if (empty($errors)) {
        // Check if user already registered for events
        $check_sql = "SELECT id FROM event_register WHERE enrollment_no = ?";
        $check_stmt = mysqli_prepare($con, $check_sql);
        mysqli_stmt_bind_param($check_stmt, "s", $enrollment_no);
        mysqli_stmt_execute($check_stmt);
        $check_result = mysqli_stmt_get_result($check_stmt);

        if (mysqli_num_rows($check_result) > 0) {
            // Update existing record
            $update_sql = "UPDATE event_register SET 
                           full_name = ?, 
                           email = ?, 
                           phone = ?, 
                           branch = ?, 
                           semester = ?, 
                           school = ?,
                           Sports_Outdoor = ?, 
                           Sports_Indoor = ?, 
                           cultur = ?, 
                           registration_date = CURRENT_TIMESTAMP 
                           WHERE enrollment_no = ?";

            $update_stmt = mysqli_prepare($con, $update_sql);
            mysqli_stmt_bind_param(
                $update_stmt,
                "ssssisssss",
                $full_name,
                $email,
                $phone,
                $branch,
                $semester,
                $school,
                $sports_outdoor,
                $sports_indoor,
                $cultural,
                $enrollment_no
            );

            if (mysqli_stmt_execute($update_stmt)) {
                $success_message = "Your event registration has been updated successfully!";
            } else {
                $error_message = "Failed to update registration. Error: " . mysqli_error($con);
            }
            mysqli_stmt_close($update_stmt);
        } else {
            // Insert new record
            $insert_sql = "INSERT INTO event_register (enrollment_no, full_name, email, phone, branch, semester, school, Sports_Outdoor, Sports_Indoor, cultur) 
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $insert_stmt = mysqli_prepare($con, $insert_sql);
            mysqli_stmt_bind_param(
                $insert_stmt,
                "sssssissss",
                $enrollment_no,
                $full_name,
                $email,
                $phone,
                $branch,
                $semester,
                $school,
                $sports_outdoor,
                $sports_indoor,
                $cultural
            );

            if (mysqli_stmt_execute($insert_stmt)) {
                $success_message = "Successfully registered for selected event(s)!";
            } else {
                $error_message = "Failed to register. Error: " . mysqli_error($con);
            }
            mysqli_stmt_close($insert_stmt);
        }
        mysqli_stmt_close($check_stmt);
    } else {
        $error_message = implode("<br>", $errors);
    }
}

// Fetch existing registration data if any
$existing_outdoor = [];
$existing_indoor = [];
$existing_cultural = [];

if (!empty($user_data['enrollment_no'])) {
    $check_existing_sql = "SELECT * FROM event_register WHERE enrollment_no = ?";
    $check_stmt = mysqli_prepare($con, $check_existing_sql);
    mysqli_stmt_bind_param($check_stmt, "s", $user_data['enrollment_no']);
    mysqli_stmt_execute($check_stmt);
    $existing_result = mysqli_stmt_get_result($check_stmt);

    if ($existing_result && mysqli_num_rows($existing_result) > 0) {
        $existing_registration = mysqli_fetch_assoc($existing_result);

        // Parse existing events
        if (!empty($existing_registration['Sports_Outdoor'])) {
            $existing_outdoor = explode(', ', $existing_registration['Sports_Outdoor']);
        }
        if (!empty($existing_registration['Sports_Indoor'])) {
            $existing_indoor = explode(', ', $existing_registration['Sports_Indoor']);
        }
        if (!empty($existing_registration['cultur'])) {
            $existing_cultural = explode(', ', $existing_registration['cultur']);
        }
    }
    mysqli_stmt_close($check_stmt);
}
?>