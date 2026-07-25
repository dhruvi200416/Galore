<?php
require_once 'admin_auth_check.php';

// Database connection
$con = mysqli_connect("localhost", "root", "", "galore2026");

if (mysqli_connect_errno()) {
    die("Database connection failed: " . mysqli_error($con));
}

// ==================== HANDLE DELETE REQUEST ====================
if (isset($_GET['delete_id'])) {
    $delete_id = mysqli_real_escape_string($con, $_GET['delete_id']);
    $delete_query = "DELETE FROM event_register WHERE id = '$delete_id'";
    if (mysqli_query($con, $delete_query)) {
        header("Location: ad_co_participations.php?msg=deleted");
        exit();
    } else {
        $error_msg = "Error deleting record: " . mysqli_error($con);
        header("Location: ad_co_participations.php?msg=error&error_msg=" . urlencode($error_msg));
        exit();
    }
}

// ==================== HANDLE STATUS TOGGLE ====================
if (isset($_GET['toggle_id'])) {
    $toggle_id = mysqli_real_escape_string($con, $_GET['toggle_id']);
    // FIX: Updated to work with lowercase 'active' and 'inactive'
    $toggle_query = "UPDATE event_register SET status = IF(status = 'active', 'inactive', 'active') WHERE id = '$toggle_id'";
    if (mysqli_query($con, $toggle_query)) {
        header("Location: ad_co_participations.php?msg=toggled");
        exit();
    } else {
        $error_msg = "Error toggling status: " . mysqli_error($con);
        header("Location: ad_co_participations.php?msg=error&error_msg=" . urlencode($error_msg));
        exit();
    }
}

// ==================== HANDLE ADD/EDIT FORM SUBMISSION ====================
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_participant'])) {
    
    $action = isset($_POST['action']) ? $_POST['action'] : 'add';
    $id = isset($_POST['participant_id']) && !empty($_POST['participant_id']) ? mysqli_real_escape_string($con, $_POST['participant_id']) : '';
    $enrollment_no = mysqli_real_escape_string($con, $_POST['enrollment']);
    $full_name = mysqli_real_escape_string($con, $_POST['student_name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phone = mysqli_real_escape_string($con, $_POST['contact']);
    $branch = mysqli_real_escape_string($con, $_POST['branch']);
    $semester = mysqli_real_escape_string($con, $_POST['semester']);
    $school = mysqli_real_escape_string($con, $_POST['school']);
    $event_value = mysqli_real_escape_string($con, $_POST['event']);
    $status = mysqli_real_escape_string($con, $_POST['status']);
    $registration_date = date('Y-m-d H:i:s');
    
    // FIX: Convert status to lowercase for database consistency
    $status = strtolower($status);
    
    // Determine event category
    $event_category = '';
    $outdoor_events = ['Cricket', 'Football', 'Volleyball', 'Basketball', 'Athletics', 'Kabaddi'];
    $indoor_events = ['Chess', 'Carrom', 'Table Tennis', 'Badminton', 'Snooker'];
    $cultural_events = ['Singing', 'Dancing', 'Rangoli', 'Debate', 'Quiz', 'Drama', 'Painting'];
    
    if (in_array($event_value, $outdoor_events)) {
        $event_category = 'Sports_Outdoor';
    } elseif (in_array($event_value, $indoor_events)) {
        $event_category = 'Sports_Indoor';
    } else {
        $event_category = 'cultur';
    }
    
    if ($action == 'add') {
        // Check if enrollment exists
        $check_query = "SELECT id FROM event_register WHERE enrollment_no = '$enrollment_no'";
        $check_result = mysqli_query($con, $check_query);
        
        if (mysqli_num_rows($check_result) > 0) {
            $error_msg = "Enrollment number already exists!";
            header("Location: ad_co_participations.php?msg=error&error_msg=" . urlencode($error_msg));
            exit();
        } else {
            $insert_query = "INSERT INTO event_register (enrollment_no, full_name, email, phone, branch, semester, school, $event_category, registration_date, status) 
                             VALUES ('$enrollment_no', '$full_name', '$email', '$phone', '$branch', '$semester', '$school', '$event_value', '$registration_date', '$status')";
            
            if (mysqli_query($con, $insert_query)) {
                header("Location: ad_co_participations.php?msg=added");
                exit();
            } else {
                $error_msg = "Error inserting record: " . mysqli_error($con);
                header("Location: ad_co_participations.php?msg=error&error_msg=" . urlencode($error_msg));
                exit();
            }
        }
    } elseif ($action == 'edit') {
        $update_query = "UPDATE event_register SET 
                        full_name = '$full_name',
                        email = '$email',
                        phone = '$phone',
                        branch = '$branch',
                        semester = '$semester',
                        school = '$school',
                        $event_category = '$event_value',
                        status = '$status'
                        WHERE id = '$id'";
        
        if (mysqli_query($con, $update_query)) {
            header("Location: ad_co_participations.php?msg=updated");
            exit();
        } else {
            $error_msg = "Error updating record: " . mysqli_error($con);
            header("Location: ad_co_participations.php?msg=error&error_msg=" . urlencode($error_msg));
            exit();
        }
    }
}

// ==================== FETCH PARTICIPANTS WITH COORDINATOR ROLE MATCH ====================
function getParticipantsWithCoordinatorMatch($con) {
    $query = "SELECT er.*, 
              CASE 
                  WHEN er.Sports_Outdoor IS NOT NULL AND er.Sports_Outdoor != '' THEN er.Sports_Outdoor
                  WHEN er.Sports_Indoor IS NOT NULL AND er.Sports_Indoor != '' THEN er.Sports_Indoor
                  WHEN er.cultur IS NOT NULL AND er.cultur != '' THEN er.cultur
                  ELSE ''
              END as event_value,
              adr.coordinator_role,
              adr.full_name as coordinator_name
              FROM event_register er
              LEFT JOIN ad_register adr ON (
                  (er.Sports_Outdoor IS NOT NULL AND er.Sports_Outdoor != '' AND adr.coordinator_role = er.Sports_Outdoor) OR
                  (er.Sports_Indoor IS NOT NULL AND er.Sports_Indoor != '' AND adr.coordinator_role = er.Sports_Indoor) OR
                  (er.cultur IS NOT NULL AND er.cultur != '' AND adr.coordinator_role = er.cultur)
              )
              WHERE (er.Sports_Outdoor IS NOT NULL AND er.Sports_Outdoor != '')
                 OR (er.Sports_Indoor IS NOT NULL AND er.Sports_Indoor != '')
                 OR (er.cultur IS NOT NULL AND er.cultur != '')";
    
    $result = mysqli_query($con, $query);
    $participants = [];
    
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $participants[] = $row;
        }
    }
    return $participants;
}

// ==================== GET STATISTICS ====================
function getStatistics($con, $participants) {
    $total = count($participants);
    // Check for lowercase 'active' and 'inactive'
    $active = count(array_filter($participants, function($p) { return strtolower($p['status']) == 'active'; }));
    $inactive = count(array_filter($participants, function($p) { return strtolower($p['status']) == 'inactive'; }));
    
    // School wise stats - Use actual school names from database
    $schoolStats = [];
    
    // Populate stats from participants
    foreach ($participants as $p) {
        $school = $p['school'];
        $status = strtolower($p['status']);
        
        // Initialize school if not exists
        if (!isset($schoolStats[$school])) {
            $schoolStats[$school] = [
                'total' => 0,
                'active' => 0,
                'inactive' => 0,
                'display_name' => $school // Store original name
            ];
        }
        
        $schoolStats[$school]['total']++;
        if ($status == 'active') {
            $schoolStats[$school]['active']++;
        } elseif ($status == 'inactive') {
            $schoolStats[$school]['inactive']++;
        }
    }
    
    // Event wise stats
    $eventStats = [];
    foreach ($participants as $p) {
        $event = $p['event_value'];
        if (!isset($eventStats[$event])) {
            $eventStats[$event] = ['total' => 0, 'active' => 0, 'inactive' => 0];
        }
        $eventStats[$event]['total']++;
        if (strtolower($p['status']) == 'active') {
            $eventStats[$event]['active']++;
        } else {
            $eventStats[$event]['inactive']++;
        }
    }
    
    return ['total' => $total, 'active' => $active, 'inactive' => $inactive, 'schoolStats' => $schoolStats, 'eventStats' => $eventStats];
}
// Get all data
$allParticipants = getParticipantsWithCoordinatorMatch($con);
$stats = getStatistics($con, $allParticipants);
$schoolStats = $stats['schoolStats'];
$eventStats = $stats['eventStats'];

$msg = isset($_GET['msg']) ? $_GET['msg'] : '';
$error_msg = isset($_GET['error_msg']) ? urldecode($_GET['error_msg']) : '';
?>