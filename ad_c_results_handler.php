<?php
require_once 'admin_auth_check.php';

$con = mysqli_connect("localhost", "root", "", "galore2026");

if (mysqli_connect_errno()) {
    die("Database connection failed: " . mysqli_error($con));
}

// Create event_results table with new field names
$results_table = "CREATE TABLE IF NOT EXISTS event_results (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    event_name VARCHAR(100) NOT NULL,
    event_type VARCHAR(50) NOT NULL,
    team_name VARCHAR(100) NOT NULL,
    school VARCHAR(100) NOT NULL,
    ranks VARCHAR(50) NOT NULL,
    status ENUM('Active', 'Inactive') DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
mysqli_query($con, $results_table);

// Handle Delete
if (isset($_GET['delete_id'])) {
    $delete_id = mysqli_real_escape_string($con, $_GET['delete_id']);
    $event_name = isset($_GET['event_name']) ? mysqli_real_escape_string($con, $_GET['event_name']) : '';
    mysqli_query($con, "DELETE FROM event_results WHERE id = '$delete_id'");
    header("Location: ad_c_results.php?msg=deleted&event=" . urlencode($event_name));
    exit();
}

// Handle Add/Edit
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_result'])) {
    $action = $_POST['action'];
    $id = isset($_POST['result_id']) ? $_POST['result_id'] : '';
    $event_name = mysqli_real_escape_string($con, $_POST['event_name']);
    $event_type = mysqli_real_escape_string($con, $_POST['event_type']);
    $team_name = mysqli_real_escape_string($con, $_POST['team_name']);
    $school = mysqli_real_escape_string($con, $_POST['school']);
    $ranks = mysqli_real_escape_string($con, $_POST['ranks']);
    $status = mysqli_real_escape_string($con, $_POST['status']);
    
    if ($action == 'add') {
        mysqli_query($con, "INSERT INTO event_results (event_name, event_type, team_name, school, ranks, status) 
                           VALUES ('$event_name', '$event_type', '$team_name', '$school', '$ranks', '$status')");
        header("Location: ad_c_results.php?msg=added&event=" . urlencode($event_name));
    } else {
        mysqli_query($con, "UPDATE event_results SET 
                           event_name='$event_name', 
                           event_type='$event_type', 
                           team_name='$team_name', 
                           school='$school', 
                           ranks='$ranks', 
                           status='$status' 
                           WHERE id='$id'");
        header("Location: ad_c_results.php?msg=updated&event=" . urlencode($event_name));
    }
    exit();
}

// Get event statistics - Map Winner to 1st Place, Runner-up to 2nd Place, 2nd Runner-up to 3rd Place
$stats_query = mysqli_query($con, "SELECT 
    er.event_name, 
    COUNT(*) as total,
    SUM(CASE 
        WHEN LOWER(er.ranks) = 'winner' 
             OR LOWER(er.ranks) = '1st' 
             OR LOWER(er.ranks) = 'gold' 
             OR LOWER(er.ranks) = '1st place'
        THEN 1 ELSE 0 END
    ) as first_place,
    SUM(CASE 
        WHEN LOWER(er.ranks) = 'runner-up' 
             OR LOWER(er.ranks) = 'runner up'
             OR LOWER(er.ranks) = '2nd' 
             OR LOWER(er.ranks) = 'silver' 
             OR LOWER(er.ranks) = '2nd place'
        THEN 1 ELSE 0 END
    ) as second_place,
    SUM(CASE 
        WHEN LOWER(er.ranks) = '2nd runner-up' 
             OR LOWER(er.ranks) = 'second runner up'
             OR LOWER(er.ranks) = '3rd' 
             OR LOWER(er.ranks) = 'bronze' 
             OR LOWER(er.ranks) = '3rd place'
        THEN 1 ELSE 0 END
    ) as third_place
    FROM event_results er
    WHERE er.status = 'Active'
    GROUP BY er.event_name
    ORDER BY er.event_name ASC");
    
$eventStats = [];
while ($row = mysqli_fetch_assoc($stats_query)) {
    $eventStats[$row['event_name']] = [
        'total' => $row['total'],
        'first_place' => $row['first_place'],
        'second_place' => $row['second_place'],
        'third_place' => $row['third_place']
    ];
}

// Get results for current event
$current_event = isset($_GET['event']) ? $_GET['event'] : '';
$results = [];
if ($current_event && isset($eventStats[$current_event])) {
    $res_query = mysqli_query($con, "SELECT * FROM event_results 
                              WHERE event_name = '$current_event' AND status = 'Active'
                              ORDER BY 
                                  CASE 
                                      WHEN LOWER(ranks) = 'winner' OR LOWER(ranks) = '1st' OR LOWER(ranks) = 'gold' THEN 1 
                                      WHEN LOWER(ranks) = 'runner-up' OR LOWER(ranks) = '2nd' OR LOWER(ranks) = 'silver' THEN 2 
                                      WHEN LOWER(ranks) = '2nd runner-up' OR LOWER(ranks) = '3rd' OR LOWER(ranks) = 'bronze' THEN 3 
                                      ELSE 4 
                                  END");
    while ($row = mysqli_fetch_assoc($res_query)) {
        $results[] = $row;
    }
}

// Get all distinct teams for dropdown
$teams_query = mysqli_query($con, "SELECT DISTINCT team_name FROM event_results WHERE status='Active' ORDER BY team_name ASC");
$allTeams = [];
while ($row = mysqli_fetch_assoc($teams_query)) {
    $allTeams[] = $row;
}

// Helper function to get rank icon
function getRankIcon($ranks) {
    $rank_lower = strtolower($ranks);
    if ($rank_lower == 'winner' || $rank_lower == '1st' || $rank_lower == 'gold') return '🥇';
    if ($rank_lower == 'runner-up' || $rank_lower == 'runner up' || $rank_lower == '2nd' || $rank_lower == 'silver') return '🥈';
    if ($rank_lower == '2nd runner-up' || $rank_lower == 'second runner up' || $rank_lower == '3rd' || $rank_lower == 'bronze') return '🥉';
    return '🏆';
}

// Helper function to get rank display text
function getRankDisplayText($ranks) {
    $rank_lower = strtolower($ranks);
    if ($rank_lower == 'winner' || $rank_lower == '1st' || $rank_lower == 'gold') return '🥇 Winner (1st Place)';
    if ($rank_lower == 'runner-up' || $rank_lower == 'runner up' || $rank_lower == '2nd' || $rank_lower == 'silver') return '🥈 Runner-up (2nd Place)';
    if ($rank_lower == '2nd runner-up' || $rank_lower == 'second runner up' || $rank_lower == '3rd' || $rank_lower == 'bronze') return '🥉 2nd Runner-up (3rd Place)';
    return $ranks;
}

// Helper function to get event type icon
function getEventTypeIcon($event_type) {
    switch ($event_type) {
        case 'Sports':
            return '⚽';
        case 'Cultural':
            return '🎭';
        case 'Technical':
            return '💻';
        case 'Academic':
            return '📚';
        default:
            return '🏆';
    }
}

$msg = isset($_GET['msg']) ? $_GET['msg'] : '';
$error_msg = isset($_GET['error_msg']) ? $_GET['error_msg'] : '';
?>