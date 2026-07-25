<?php
require_once 'admin_auth_check.php';

// Start session only if not already active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database connection
$con = mysqli_connect("localhost", "root", "", "galore2026");

// Check connection
if (mysqli_connect_errno()) {
    die("Database connection failed: " . mysqli_error($con));
}

// Include mailer
require_once 'mailer.php';

// ==================== HANDLE SEND EMAIL TO ALL ====================
if (isset($_POST['send_email_to_all']) || isset($_GET['send_emails'])) {
    // Get all active participants with valid emails
    $query = "SELECT id, full_name, email, enrollment_no, phone, branch, semester, school, 
              CASE 
                  WHEN Sports_Outdoor IS NOT NULL AND Sports_Outdoor != '' THEN Sports_Outdoor
                  WHEN Sports_Indoor IS NOT NULL AND Sports_Indoor != '' THEN Sports_Indoor
                  WHEN cultur IS NOT NULL AND cultur != '' THEN cultur
                  ELSE ''
              END as event_value,
              status 
              FROM event_register 
              WHERE email IS NOT NULL AND email != '' 
              AND status = 'active'
              ORDER BY id ASC";
    
    $result = mysqli_query($con, $query);
    $success_count = 0;
    $fail_count = 0;
    $failed_emails = [];
    $total_participants = 0;
    
    if (mysqli_num_rows($result) > 0) {
        $total_participants = mysqli_num_rows($result);
        
        while ($row = mysqli_fetch_assoc($result)) {
            // Build personalized HTML email for each participant with their data
            $email_body = '
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="UTF-8">
                <title>RKU Galore 2026 - Registration Confirmation</title>
                <style>
                    body {
                        font-family: "Segoe UI", Arial, sans-serif;
                        margin: 0;
                        padding: 20px;
                        background-color: #f4f4f4;
                    }
                    .container {
                        max-width: 600px;
                        margin: 0 auto;
                        background: white;
                        border-radius: 12px;
                        overflow: hidden;
                        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
                    }
                    .header {
                        background: linear-gradient(135deg, #dc3545, #b02a37);
                        color: white;
                        padding: 30px;
                        text-align: center;
                    }
                    .header h1 {
                        margin: 0;
                        font-size: 28px;
                    }
                    .header p {
                        margin: 10px 0 0;
                        opacity: 0.9;
                    }
                    .content {
                        padding: 30px;
                    }
                    .greeting {
                        font-size: 18px;
                        color: #333;
                        margin-bottom: 20px;
                    }
                    .greeting strong {
                        color: #dc3545;
                    }
                    .details-card {
                        background: #f8f9fa;
                        border-radius: 10px;
                        padding: 20px;
                        margin: 20px 0;
                        border-left: 4px solid #dc3545;
                    }
                    .details-title {
                        font-size: 18px;
                        font-weight: bold;
                        color: #dc3545;
                        margin-bottom: 15px;
                        border-bottom: 2px solid #dc3545;
                        padding-bottom: 8px;
                        display: inline-block;
                    }
                    .detail-row {
                        display: flex;
                        padding: 8px 0;
                        border-bottom: 1px solid #e0e0e0;
                    }
                    .detail-label {
                        font-weight: bold;
                        width: 130px;
                        color: #555;
                    }
                    .detail-value {
                        flex: 1;
                        color: #333;
                    }
                    .badge {
                        display: inline-block;
                        padding: 4px 12px;
                        border-radius: 20px;
                        font-size: 12px;
                        font-weight: bold;
                    }
                    .badge-active {
                        background: #28a745;
                        color: white;
                    }
                    .info-box {
                        background: #fff3cd;
                        padding: 15px;
                        border-radius: 8px;
                        margin: 20px 0;
                        border-left: 4px solid #ffc107;
                    }
                    .schedule-table {
                        width: 100%;
                        margin: 15px 0;
                        border-collapse: collapse;
                    }
                    .schedule-table td {
                        padding: 10px;
                        border-bottom: 1px solid #e0e0e0;
                    }
                    .footer {
                        background: #f8f9fa;
                        padding: 20px;
                        text-align: center;
                        font-size: 12px;
                        color: #666;
                        border-top: 1px solid #e0e0e0;
                    }
                </style>
            </head>
            <body>
                <div class="container">
                    <div class="header">
                        <h1>🏆 RKU Galore 2026</h1>
                        <p>Annual Sports & Cultural Festival</p>
                    </div>
                    <div class="content">
                        <div class="greeting">
                            Dear <strong>' . htmlspecialchars($row['full_name']) . '</strong>,
                        </div>
                        <p>Thank you for registering for <strong>RKU Galore 2026</strong>! We are excited to have you as a participant.</p>
                        
                        <div class="details-card">
                            <div class="details-title">📋 Your Registration Details</div>
                            <div class="detail-row">
                                <div class="detail-label">Participant ID:</div>
                                <div class="detail-value">#' . $row['id'] . '</div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-label">Full Name:</div>
                                <div class="detail-value">' . htmlspecialchars($row['full_name']) . '</div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-label">Enrollment No:</div>
                                <div class="detail-value">' . htmlspecialchars($row['enrollment_no']) . '</div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-label">Email:</div>
                                <div class="detail-value">' . htmlspecialchars($row['email']) . '</div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-label">Contact No:</div>
                                <div class="detail-value">' . htmlspecialchars($row['phone']) . '</div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-label">Branch:</div>
                                <div class="detail-value">' . htmlspecialchars($row['branch']) . '</div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-label">Semester:</div>
                                <div class="detail-value">' . $row['semester'] . 'th Semester</div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-label">School:</div>
                                <div class="detail-value">' . htmlspecialchars($row['school']) . '</div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-label">Event:</div>
                                <div class="detail-value"><strong>' . htmlspecialchars($row['event_value']) . '</strong></div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-label">Status:</div>
                                <div class="detail-value"><span class="badge badge-active">Active</span></div>
                            </div>
                        </div>
                        
                        <div class="info-box">
                            <strong>📌 Important Information:</strong><br>
                            • Please carry your college ID card for verification<br>
                            • Report to the registration desk 30 minutes before your event<br>
                            • Sports participants must wear appropriate sports attire<br>
                            • Keep this email for reference during the event
                        </div>
                        
                        <table class="schedule-table">
                            <tr><td style="background:#dc3545; color:white; padding:10px; text-align:center;"><strong>📅 Event Schedule</strong></td></tr>
                            <tr><td>📍 <strong>Venue:</strong> RKU Campus Ground & Auditorium</td></tr>
                            <tr><td>⏰ <strong>Reporting Time:</strong> 30 minutes before your scheduled event</td></tr>
                            <tr><td>📞 <strong>Help Desk:</strong> +91 98765 43210</td></tr>
                        </table>
                    </div>
                    <div class="footer">
                        <p>For any queries, please contact:<br>
                        📧 Email: galore@rku.edu.in</p>
                        <p>© ' . date('Y') . ' RKU Galore - All Rights Reserved</p>
                        <p><small>This is an automated confirmation email. Please do not reply to this email.</small></p>
                    </div>
                </div>
            </body>
            </html>';
            
            $subject = "🎉 RKU Galore 2026 - Registration Confirmation for " . htmlspecialchars($row['full_name']);
            
            // Send individual email to each participant
            $email_result = sendEmail($row['email'], $subject, $email_body);
            
            if ($email_result === true) {
                $success_count++;
            } else {
                $fail_count++;
                $failed_emails[] = $row['email'];
            }
        }
    }
    
    // Store results in session
    $_SESSION['email_results'] = [
        'success' => $success_count,
        'fail' => $fail_count,
        'failed_emails' => $failed_emails,
        'total' => $total_participants
    ];
    
    header("Location: ad_c_participations.php?msg=email_sent");
    exit();
}

// ==================== CREATE OR FIX PARTICIPANTS TABLE ====================
$table_check = mysqli_query($con, "SHOW TABLES LIKE 'event_register'");
if (mysqli_num_rows($table_check) == 0) {
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
        status ENUM('active', 'inactive') DEFAULT 'active',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    mysqli_query($con, $event_table);
} else {
    $check_auto = mysqli_query($con, "SHOW COLUMNS FROM event_register LIKE 'id'");
    $column_info = mysqli_fetch_assoc($check_auto);
    if (strpos($column_info['Extra'], 'auto_increment') === false) {
        mysqli_query($con, "ALTER TABLE event_register MODIFY id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY");
    }
}

// ==================== EVENT CATEGORIZATION FUNCTION ====================
function categorizeEvent($event_name) {
    $event_name = strtolower(trim($event_name));
    
    $outdoor_sports = [
        'cricket', 'football', 'soccer', 'volleyball', 'basketball', 'tennis', 
        'athletics', 'running', 'long jump', 'high jump', 'shot put', 'discus throw',
        'javelin throw', 'hockey', 'baseball', 'rugby', 'handball', 'kabaddi',
        'kho kho', 'lagori', 'throwball', 'softball', 'beach volleyball'
    ];
    
    $indoor_sports = [
        'carrom', 'carroms', 'chess', 'table tennis', 'tt', 'badminton', 
        'snooker', 'billiards', 'pool', 'squash', 'boxing', 'wrestling',
        'judo', 'karate', 'taekwondo', 'gymnastics', 'yoga', 'darts',
        'ludo', 'snake and ladder', 'board games', 'indoor cricket', 'futsal'
    ];
    
    $cultural_events = [
        'singing', 'dancing', 'dance', 'music', 'rangoli', 'painting', 'drawing',
        'art', 'debate', 'elocution', 'quiz', 'essay writing', 'poetry', 'recitation',
        'drama', 'acting', 'theatre', 'fashion show', 'modeling', 'photography',
        'instrumental', 'band', 'orchestra', 'solo singing', 'group dance', 'folk dance'
    ];
    
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
    
    return null;
}

// ==================== HANDLE STATUS TOGGLE ====================
if (isset($_GET['toggle_id'])) {
    $toggle_id = mysqli_real_escape_string($con, $_GET['toggle_id']);
    $view_type = isset($_GET['view_type']) ? mysqli_real_escape_string($con, $_GET['view_type']) : 'all';
    $filter_value = isset($_GET['filter_value']) ? mysqli_real_escape_string($con, $_GET['filter_value']) : '';
    
    $toggle_query = "UPDATE event_register SET status = IF(status = 'active', 'inactive', 'active') WHERE id = '$toggle_id'";
    if (mysqli_query($con, $toggle_query)) {
        header("Location: ad_c_participations.php?msg=toggled&view_type=" . urlencode($view_type) . "&filter_value=" . urlencode($filter_value));
        exit();
    } else {
        $error_msg = "Error toggling status: " . mysqli_error($con);
        header("Location: ad_c_participations.php?msg=error&error_msg=" . urlencode($error_msg));
        exit();
    }
}

// ==================== HANDLE DELETE REQUESTS ====================
if (isset($_GET['delete_id'])) {
    $delete_id = mysqli_real_escape_string($con, $_GET['delete_id']);
    $view_type = isset($_GET['view_type']) ? mysqli_real_escape_string($con, $_GET['view_type']) : 'all';
    $filter_value = isset($_GET['filter_value']) ? mysqli_real_escape_string($con, $_GET['filter_value']) : '';
    
    $delete_query = "DELETE FROM event_register WHERE id = '$delete_id'";
    if (mysqli_query($con, $delete_query)) {
        header("Location: ad_c_participations.php?msg=deleted&view_type=" . urlencode($view_type) . "&filter_value=" . urlencode($filter_value));
        exit();
    } else {
        $error_msg = "Error deleting record: " . mysqli_error($con);
        header("Location: ad_c_participations.php?msg=error&error_msg=" . urlencode($error_msg));
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
    
    $status = strtolower($status);
    
    $actual_event_type = categorizeEvent($event_value);
    
    if ($actual_event_type === null) {
        $actual_event_type = 'Cultur';
    }
    
    if ($action == 'add') {
        $check_query = "SELECT id, Sports_Outdoor, Sports_Indoor, cultur FROM event_register WHERE enrollment_no = '$enrollment_no'";
        $check_result = mysqli_query($con, $check_query);
        
        if (mysqli_num_rows($check_result) > 0) {
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
            
            $update_query = "UPDATE event_register SET 
                            full_name = '$full_name',
                            email = '$email',
                            phone = '$phone',
                            branch = '$branch',
                            semester = '$semester',
                            school = '$school',
                            $event_field = '$new_value',
                            status = '$status'
                            WHERE enrollment_no = '$enrollment_no'";
                            
            if (mysqli_query($con, $update_query)) {
                header("Location: ad_c_participations.php?msg=added");
                exit();
            } else {
                $error_msg = "Error updating record: " . mysqli_error($con);
                header("Location: ad_c_participations.php?msg=error&error_msg=" . urlencode($error_msg));
                exit();
            }
        } else {
            $event_field = '';
            if ($actual_event_type == 'Sports_Outdoor') {
                $event_field = "Sports_Outdoor";
            } elseif ($actual_event_type == 'Sports_Indoor') {
                $event_field = "Sports_Indoor";
            } else {
                $event_field = "cultur";
            }
            
            $insert_query = "INSERT INTO event_register (enrollment_no, full_name, email, phone, branch, semester, school, $event_field, registration_date, status) 
                             VALUES ('$enrollment_no', '$full_name', '$email', '$phone', '$branch', '$semester', '$school', '$event_value', '$registration_date', '$status')";
            
            if (mysqli_query($con, $insert_query)) {
                header("Location: ad_c_participations.php?msg=added");
                exit();
            } else {
                $error_msg = "Error inserting record: " . mysqli_error($con);
                header("Location: ad_c_participations.php?msg=error&error_msg=" . urlencode($error_msg));
                exit();
            }
        }
    } elseif ($action == 'edit') {
        $event_field = '';
        $actual_event_type = categorizeEvent($event_value);
        if ($actual_event_type === null) {
            $actual_event_type = 'Cultur';
        }
        
        if ($actual_event_type == 'Sports_Outdoor') {
            $event_field = "Sports_Outdoor";
        } elseif ($actual_event_type == 'Sports_Indoor') {
            $event_field = "Sports_Indoor";
        } else {
            $event_field = "cultur";
        }
        
        $update_query = "UPDATE event_register SET 
                        full_name = '$full_name',
                        enrollment_no = '$enrollment_no',
                        email = '$email',
                        phone = '$phone',
                        branch = '$branch',
                        semester = '$semester',
                        school = '$school',
                        $event_field = '$event_value',
                        status = '$status'
                        WHERE id = '$id'";
        
        if (mysqli_query($con, $update_query)) {
            header("Location: ad_c_participations.php?msg=updated");
            exit();
        } else {
            $error_msg = "Error updating record: " . mysqli_error($con);
            header("Location: ad_c_participations.php?msg=error&error_msg=" . urlencode($error_msg));
            exit();
        }
    }
}

// ==================== FETCH ALL PARTICIPANTS ====================
function getAllParticipants($con) {
    $query = "SELECT id, enrollment_no, full_name, email, phone, branch, semester, school, 
              CASE 
                  WHEN Sports_Outdoor IS NOT NULL AND Sports_Outdoor != '' THEN Sports_Outdoor
                  WHEN Sports_Indoor IS NOT NULL AND Sports_Indoor != '' THEN Sports_Indoor
                  WHEN cultur IS NOT NULL AND cultur != '' THEN cultur
                  ELSE ''
              END as event_value,
              status 
              FROM event_register 
              WHERE (Sports_Outdoor IS NOT NULL AND Sports_Outdoor != '')
                 OR (Sports_Indoor IS NOT NULL AND Sports_Indoor != '')
                 OR (cultur IS NOT NULL AND cultur != '')
              ORDER BY id ASC";
    
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
$allParticipants = getAllParticipants($con);

$total_all = count($allParticipants);
$active_all = count(array_filter($allParticipants, function($p) { return strtolower($p['status']) == 'active'; }));
$inactive_all = count(array_filter($allParticipants, function($p) { return strtolower($p['status']) == 'inactive'; }));

$stats = [
    'all' => ['total' => $total_all, 'active' => $active_all, 'inactive' => $inactive_all]
];

$schoolStats = [];
$schoolNames = [];

$school_query = "SELECT DISTINCT school FROM event_register WHERE school IS NOT NULL AND school != ''";
$school_result = mysqli_query($con, $school_query);

if ($school_result && mysqli_num_rows($school_result) > 0) {
    while ($row = mysqli_fetch_assoc($school_result)) {
        $schoolName = $row['school'];
        $schoolNames[] = $schoolName;
        
        $schoolParticipants = array_filter($allParticipants, function($p) use ($schoolName) {
            return $p['school'] == $schoolName;
        });
        
        $total = count($schoolParticipants);
        $active = count(array_filter($schoolParticipants, function($p) { return strtolower($p['status']) == 'active'; }));
        $inactive = count(array_filter($schoolParticipants, function($p) { return strtolower($p['status']) == 'inactive'; }));
        
        $schoolStats[$schoolName] = [
            'name' => $schoolName,
            'total' => $total,
            'active' => $active,
            'inactive' => $inactive
        ];
    }
}

$schoolStats['SOE'] = $schoolStats['School of Engineering'] ?? ['name' => 'School of Engineering', 'total' => 0, 'active' => 0, 'inactive' => 0];
$schoolStats['SOM'] = $schoolStats['School Of Management'] ?? $schoolStats['School of Management'] ?? ['name' => 'School of Management', 'total' => 0, 'active' => 0, 'inactive' => 0];

$eventStats = [];
foreach ($allParticipants as $participant) {
    $eventValue = $participant['event_value'];
    
    if (strpos($eventValue, ',') !== false) {
        $events = array_map('trim', explode(',', $eventValue));
        foreach ($events as $event) {
            if (!isset($eventStats[$event])) {
                $eventStats[$event] = ['total' => 0, 'active' => 0, 'inactive' => 0];
            }
            $eventStats[$event]['total']++;
            if (strtolower($participant['status']) == 'active') {
                $eventStats[$event]['active']++;
            } else {
                $eventStats[$event]['inactive']++;
            }
        }
    } else {
        if (!isset($eventStats[$eventValue])) {
            $eventStats[$eventValue] = ['total' => 0, 'active' => 0, 'inactive' => 0];
        }
        $eventStats[$eventValue]['total']++;
        if (strtolower($participant['status']) == 'active') {
            $eventStats[$eventValue]['active']++;
        } else {
            $eventStats[$eventValue]['inactive']++;
        }
    }
}

arsort($eventStats);

$eventList = array_keys($eventStats);
if (empty($eventList)) {
    $eventList = ['Cricket', 'Football', 'Chess', 'Basketball', 'Volleyball', 'Badminton'];
}

$msg = isset($_GET['msg']) ? $_GET['msg'] : '';
$error_msg = isset($_GET['error_msg']) ? urldecode($_GET['error_msg']) : '';
$view_type = isset($_GET['view_type']) ? $_GET['view_type'] : 'all';
$filter_value = isset($_GET['filter_value']) ? $_GET['filter_value'] : '';

$email_results = isset($_SESSION['email_results']) ? $_SESSION['email_results'] : null;
unset($_SESSION['email_results']);
?>