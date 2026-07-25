<?php
require_once 'admin_auth_check.php';

// Database connection
$con = mysqli_connect("localhost", "root", "", "galore2026");

// Check connection
if (mysqli_connect_errno()) {
    die("Database connection failed: " . mysqli_error($con));
}

// ==================== CREATE OR FIX EVENT_REGISTER TABLE ====================
// First, check if table exists and fix structure
$table_check = mysqli_query($con, "SHOW TABLES LIKE 'event_register'");
if (mysqli_num_rows($table_check) == 0) {
    // Create new table with proper AUTO_INCREMENT
    $event_table = "CREATE TABLE event_register (
        id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        enrollment_no VARCHAR(50) NOT NULL,
        full_name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        phone VARCHAR(15) NOT NULL,
        branch VARCHAR(100) NOT NULL,
        semester VARCHAR(20) NOT NULL,
        school VARCHAR(100) NOT NULL,
        Sports_Outdoor TEXT,
        Sports_Indoor TEXT,
        cultur TEXT,
        registration_date DATETIME DEFAULT NULL,
        status ENUM('Active', 'Inactive') DEFAULT 'Active',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    mysqli_query($con, $event_table);
} else {
    // Check if id column has AUTO_INCREMENT
    $check_auto = mysqli_query($con, "SHOW COLUMNS FROM event_register LIKE 'id'");
    $column_info = mysqli_fetch_assoc($check_auto);

    if (strpos($column_info['Extra'], 'auto_increment') === false) {
        // Fix the table structure - modify id to AUTO_INCREMENT
        mysqli_query($con, "ALTER TABLE event_register MODIFY id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY");
    }
}

// ==================== EVENT CATEGORIZATION FUNCTION ====================
function categorizeEvent($event_name)
{
    $event_name = strtolower(trim($event_name));

    // Sports Outdoor events
    $outdoor_sports = [
        'cricket',
        'football',
        'soccer',
        'volleyball',
        'basketball',
        'tennis',
        'athletics',
        'running',
        'long jump',
        'high jump',
        'shot put',
        'discus throw',
        'javelin throw',
        'hockey',
        'baseball',
        'rugby',
        'handball',
        'kabaddi',
        'kho kho',
        'lagori',
        'throwball',
        'softball',
        'beach volleyball'
    ];

    // Sports Indoor events
    $indoor_sports = [
        'carrom',
        'carroms',
        'chess',
        'table tennis',
        'tt',
        'badminton',
        'snooker',
        'billiards',
        'pool',
        'squash',
        'boxing',
        'wrestling',
        'judo',
        'karate',
        'taekwondo',
        'gymnastics',
        'yoga',
        'darts',
        'ludo',
        'snake and ladder',
        'board games',
        'indoor cricket',
        'futsal'
    ];

    // Cultural events
    $cultural_events = [
        'singing',
        'dancing',
        'dance',
        'music',
        'rangoli',
        'painting',
        'drawing',
        'art',
        'debate',
        'elocution',
        'quiz',
        'essay writing',
        'poetry',
        'recitation',
        'drama',
        'acting',
        'theatre',
        'fashion show',
        'modeling',
        'photography',
        'instrumental',
        'band',
        'orchestra',
        'solo singing',
        'group dance',
        'folk dance'
    ];

    // Check if event matches any category
    foreach ($outdoor_sports as $sport) {
        if (strpos($event_name, $sport) !== false) {
            return 'Sports_Outdoor';
        }
    }

    foreach ($indoor_sports as $sport) {
        if (strpos($event_name, $sport) !== false) {
            return 'Sports_Indoor';
        }
    }

    foreach ($cultural_events as $cultural) {
        if (strpos($event_name, $cultural) !== false) {
            return 'Cultur';
        }
    }

    // Default: return null if no match found
    return null;
}

// ==================== HANDLE STATUS TOGGLE ====================
if (isset($_GET['toggle_event_id'])) {
    $toggle_id = mysqli_real_escape_string($con, $_GET['toggle_event_id']);
    $event_type = isset($_GET['event']) ? mysqli_real_escape_string($con, $_GET['event']) : '';

    $toggle_query = "UPDATE event_register SET status = IF(status = 'Active', 'Inactive', 'Active') WHERE id = '$toggle_id'";
    if (mysqli_query($con, $toggle_query)) {
        if ($event_type) {
            header("Location: ad_c_school.php?event=" . urlencode($event_type) . "&msg=toggled");
        } else {
            header("Location: ad_c_school.php?msg=toggled");
        }
        exit();
    } else {
        echo "<script>alert('Error toggling status: " . mysqli_error($con) . "');</script>";
    }
}

// ==================== HANDLE DELETE REQUESTS ====================
if (isset($_GET['delete_id']) && isset($_GET['event'])) {
    $delete_id = mysqli_real_escape_string($con, $_GET['delete_id']);
    $event_type = mysqli_real_escape_string($con, $_GET['event']);

    $delete_query = "DELETE FROM event_register WHERE id = '$delete_id'";
    if (mysqli_query($con, $delete_query)) {
        header("Location: ad_c_school.php?event=" . urlencode($event_type) . "&msg=deleted");
        exit();
    } else {
        echo "<script>alert('Error deleting record: " . mysqli_error($con) . "');</script>";
    }
}

// ==================== HANDLE ADD/EDIT FORM SUBMISSION ====================
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_event_registration'])) {

    $action = isset($_POST['action']) ? $_POST['action'] : '';
    $current_event_type = mysqli_real_escape_string($con, $_POST['event_type']);

    // Get form data
    $id = isset($_POST['id']) && !empty($_POST['id']) ? mysqli_real_escape_string($con, $_POST['id']) : '';
    $enrollment_no = mysqli_real_escape_string($con, $_POST['enrollment_no']);
    $full_name = mysqli_real_escape_string($con, $_POST['full_name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $branch = mysqli_real_escape_string($con, $_POST['branch']);
    $semester = mysqli_real_escape_string($con, $_POST['semester']);
    $school = mysqli_real_escape_string($con, $_POST['school']);
    $event_value = mysqli_real_escape_string($con, $_POST['event_value']);
    $status = mysqli_real_escape_string($con, $_POST['status']);
    $registration_date = date('Y-m-d H:i:s');

    // Determine the actual event type based on the event name
    $actual_event_type = categorizeEvent($event_value);

    // If event couldn't be categorized, use the current event type
    if ($actual_event_type === null) {
        $actual_event_type = $current_event_type;
    }

    if ($action == 'add') {
        // Check if enrollment exists
        $check_query = "SELECT id, Sports_Outdoor, Sports_Indoor, cultur FROM event_register WHERE enrollment_no = '$enrollment_no'";
        $check_result = mysqli_query($con, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            // Update existing record - add new event to existing student
            $existing = mysqli_fetch_assoc($check_result);
            $event_field = '';
            $current_value = '';

            if ($actual_event_type == 'Sports_Outdoor') {
                $event_field = "Sports_Outdoor";
                $current_value = $existing['Sports_Outdoor'];
            } elseif ($actual_event_type == 'Sports_Indoor') {
                $event_field = "Sports_Indoor";
                $current_value = $existing['Sports_Indoor'];
            } else {
                $event_field = "cultur";
                $current_value = $existing['cultur'];
            }

            if (!empty($current_value)) {
                $new_value = $current_value . ', ' . $event_value;
            } else {
                $new_value = $event_value;
            }

            $update_query = "UPDATE event_register SET $event_field = '$new_value', status = '$status' WHERE enrollment_no = '$enrollment_no'";
            if (mysqli_query($con, $update_query)) {
                // Redirect to the actual event type page
                $redirect_event = ($actual_event_type == 'Cultur') ? 'Cultur' : $actual_event_type;
                header("Location: ad_c_school.php?event=" . urlencode($redirect_event) . "&msg=added");
                exit();
            } else {
                echo "<script>alert('Error updating record: " . mysqli_error($con) . "');</script>";
            }
        } else {
            // Insert new student record - let MySQL auto-generate the ID
            $event_field = '';
            if ($actual_event_type == 'Sports_Outdoor') {
                $event_field = "Sports_Outdoor";
            } elseif ($actual_event_type == 'Sports_Indoor') {
                $event_field = "Sports_Indoor";
            } else {
                $event_field = "cultur";
            }

            // Remove id from insert query to let AUTO_INCREMENT work
            $insert_query = "INSERT INTO event_register (enrollment_no, full_name, email, phone, branch, semester, school, $event_field, registration_date, status) 
                             VALUES ('$enrollment_no', '$full_name', '$email', '$phone', '$branch', '$semester', '$school', '$event_value', '$registration_date', '$status')";

            if (mysqli_query($con, $insert_query)) {
                // Redirect to the actual event type page
                $redirect_event = ($actual_event_type == 'Cultur') ? 'Cultur' : $actual_event_type;
                header("Location: ad_c_school.php?event=" . urlencode($redirect_event) . "&msg=added");
                exit();
            } else {
                echo "<script>alert('Error inserting record: " . mysqli_error($con) . "');</script>";
            }
        }
    } elseif ($action == 'edit') {
        // Update existing record - for edit, we keep it in the same table
        $event_field = '';
        if ($current_event_type == 'Sports_Outdoor') {
            $event_field = "Sports_Outdoor";
        } elseif ($current_event_type == 'Sports_Indoor') {
            $event_field = "Sports_Indoor";
        } else {
            $event_field = "cultur";
        }

        $update_query = "UPDATE event_register SET 
                        full_name = '$full_name',
                        email = '$email',
                        phone = '$phone',
                        branch = '$branch',
                        semester = '$semester',
                        school = '$school',
                        $event_field = '$event_value',
                        status = '$status'
                        WHERE id = '$id'";

        if (mysqli_query($con, $update_query)) {
            header("Location: ad_c_school.php?event=" . urlencode($current_event_type) . "&msg=updated");
            exit();
        } else {
            echo "<script>alert('Error updating record: " . mysqli_error($con) . "');</script>";
        }
    }
}

// ==================== FETCH ALL REGISTRATIONS FOR AN EVENT ====================
function getEventRegistrations($con, $event_type)
{
    if ($event_type == 'Sports_Outdoor') {
        $query = "SELECT *, Sports_Outdoor as event_value FROM event_register WHERE Sports_Outdoor IS NOT NULL AND Sports_Outdoor != '' ORDER BY id ASC";
    } elseif ($event_type == 'Sports_Indoor') {
        $query = "SELECT *, Sports_Indoor as event_value FROM event_register WHERE Sports_Indoor IS NOT NULL AND Sports_Indoor != '' ORDER BY id ASC";
    } else {
        $query = "SELECT *, cultur as event_value FROM event_register WHERE cultur IS NOT NULL AND cultur != '' ORDER BY id ASC";
    }

    $result = mysqli_query($con, $query);
    $registrations = [];

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $registrations[] = $row;
        }
    }
    return $registrations;
}

// ==================== GET STATISTICS FOR ALL EVENTS ====================
$events = ['Sports_Outdoor', 'Sports_Indoor', 'Cultur'];
$eventStats = [];

foreach ($events as $event) {
    if ($event == 'Sports_Outdoor') {
        $total_result = mysqli_query($con, "SELECT COUNT(*) as c FROM event_register WHERE Sports_Outdoor IS NOT NULL AND Sports_Outdoor != ''");
        $total = $total_result ? mysqli_fetch_assoc($total_result)['c'] : 0;

        $active_result = mysqli_query($con, "SELECT COUNT(*) as c FROM event_register WHERE Sports_Outdoor IS NOT NULL AND Sports_Outdoor != '' AND status='Active'");
        $active = $active_result ? mysqli_fetch_assoc($active_result)['c'] : 0;

        $inactive_result = mysqli_query($con, "SELECT COUNT(*) as c FROM event_register WHERE Sports_Outdoor IS NOT NULL AND Sports_Outdoor != '' AND status='Inactive'");
        $inactive = $inactive_result ? mysqli_fetch_assoc($inactive_result)['c'] : 0;
    } elseif ($event == 'Sports_Indoor') {
        $total_result = mysqli_query($con, "SELECT COUNT(*) as c FROM event_register WHERE Sports_Indoor IS NOT NULL AND Sports_Indoor != ''");
        $total = $total_result ? mysqli_fetch_assoc($total_result)['c'] : 0;

        $active_result = mysqli_query($con, "SELECT COUNT(*) as c FROM event_register WHERE Sports_Indoor IS NOT NULL AND Sports_Indoor != '' AND status='Active'");
        $active = $active_result ? mysqli_fetch_assoc($active_result)['c'] : 0;

        $inactive_result = mysqli_query($con, "SELECT COUNT(*) as c FROM event_register WHERE Sports_Indoor IS NOT NULL AND Sports_Indoor != '' AND status='Inactive'");
        $inactive = $inactive_result ? mysqli_fetch_assoc($inactive_result)['c'] : 0;
    } else {
        $total_result = mysqli_query($con, "SELECT COUNT(*) as c FROM event_register WHERE cultur IS NOT NULL AND cultur != ''");
        $total = $total_result ? mysqli_fetch_assoc($total_result)['c'] : 0;

        $active_result = mysqli_query($con, "SELECT COUNT(*) as c FROM event_register WHERE cultur IS NOT NULL AND cultur != '' AND status='Active'");
        $active = $active_result ? mysqli_fetch_assoc($active_result)['c'] : 0;

        $inactive_result = mysqli_query($con, "SELECT COUNT(*) as c FROM event_register WHERE cultur IS NOT NULL AND cultur != '' AND status='Inactive'");
        $inactive = $inactive_result ? mysqli_fetch_assoc($inactive_result)['c'] : 0;
    }
    $eventStats[$event] = ['total' => $total, 'active' => $active, 'inactive' => $inactive];
}

// Get current event from URL
$current_event = isset($_GET['event']) ? $_GET['event'] : '';
$edit_id = isset($_GET['edit']) ? $_GET['edit'] : '';
$msg = isset($_GET['msg']) ? $_GET['msg'] : '';

// Get registrations for current event
$registrations = [];
if ($current_event) {
    $registrations = getEventRegistrations($con, $current_event);
}

// Get edit data
$edit_data = null;
if ($edit_id && $current_event) {
    foreach ($registrations as $reg) {
        if ($reg['id'] == $edit_id) {
            $edit_data = $reg;
            if ($current_event == 'Sports_Outdoor') {
                $edit_data['event_value'] = $edit_data['Sports_Outdoor'];
            } elseif ($current_event == 'Sports_Indoor') {
                $edit_data['event_value'] = $edit_data['Sports_Indoor'];
            } else {
                $edit_data['event_value'] = $edit_data['cultur'];
            }
            break;
        }
    }
}
