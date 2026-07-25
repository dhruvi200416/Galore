<?php
session_start();
// Error reporting disabled to prevent warnings from displaying
error_reporting(0);
ini_set('display_errors', 0);

// Database connection
$conn = @mysqli_connect("localhost", "root", "", "galore2026");

// Check connection
if (!$conn) {
    // Silent fail - no warning displayed
    $conn = null;
}

// Set charset to avoid encoding issues
if ($conn) {
    @mysqli_set_charset($conn, "utf8mb4");
}

// Initialize variables with default values
$header_data = [
    'hero_title' => 'Galore 2026 Results',
    'hero_subtitle' => 'See the winners of all events and competitions!',
    'title' => 'Event Results'
];

$event_results = [];

// Fetch hero section data if connection exists
if ($conn) {
    $header_query = "SELECT * FROM result_header WHERE status = 'Active' LIMIT 1";
    $header_result = @mysqli_query($conn, $header_query);

    if ($header_result && @mysqli_num_rows($header_result) > 0) {
        $fetched_data = @mysqli_fetch_assoc($header_result);
        if ($fetched_data) {
            $header_data = array_merge($header_data, $fetched_data);
        }
    }

    // Fetch event results with new field structure
    $results_query = "SELECT * FROM event_results WHERE status = 'Active' ORDER BY 
                      CASE ranks
                          WHEN '1st' THEN 1
                          WHEN 'Gold' THEN 1
                          WHEN '2nd' THEN 2
                          WHEN 'Silver' THEN 2
                          WHEN '3rd' THEN 3
                          WHEN 'Bronze' THEN 3
                          ELSE 4
                      END, event_name ASC";
    $results_result = @mysqli_query($conn, $results_query);

    if ($results_result) {
        while ($result = @mysqli_fetch_assoc($results_result)) {
            if ($result) {
                $event_results[] = $result;
            }
        }
    }
}

// Function to get rank icon and medal color class
function getRankIcon($ranks)
{
    if ($ranks == '1st' || $ranks == 'Gold') return '🥇';
    if ($ranks == '2nd' || $ranks == 'Silver') return '🥈';
    if ($ranks == '3rd' || $ranks == 'Bronze') return '🥉';
    return '🏆';
}

// Function to get medal color class based on rank
function getMedalColorClass($ranks)
{
    if ($ranks == '1st' || $ranks == 'Gold') return 'medal-gold';
    if ($ranks == '2nd' || $ranks == 'Silver') return 'medal-silver';
    if ($ranks == '3rd' || $ranks == 'Bronze') return 'medal-bronze';
    return '';
}

// Function to get event icon based on event type
function getEventIcon($event_type)
{
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

// Safe echo function to prevent undefined variable warnings
function safeEcho($value, $default = '')
{
    echo isset($value) ? htmlspecialchars($value) : htmlspecialchars($default);
}
?>