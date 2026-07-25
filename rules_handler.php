<?php
session_start();
// Error reporting disabled to prevent warnings from displaying
error_reporting(0);
ini_set('display_errors', 0);

// Initialize variables
$header_data = [
    'hero_title' => 'Galore 2026',
    'hero_subtitle' => 'Rules & Circulars',
    'title' => 'Sports Rules & Regulations'
];
$circulars = [];
$conn = null;

// Database connection
$conn = @mysqli_connect("localhost", "root", "", "galore2026");

// Check connection silently
if ($conn) {
    // Set charset
    @mysqli_set_charset($conn, "utf8mb4");

    // Fetch hero section data from rules_header table
    $header_query = "SELECT * FROM rules_header WHERE status = 'Active' LIMIT 1";
    $header_result = @mysqli_query($conn, $header_query);

    // Check if query was successful and fetch data
    if ($header_result && @mysqli_num_rows($header_result) > 0) {
        $fetched_data = @mysqli_fetch_assoc($header_result);
        if ($fetched_data) {
            $header_data = array_merge($header_data, $fetched_data);
        }
    }

    // Fetch circulars from circulars table - ORDER BY id to show Cricket first, then Football, then Carrom
    $circulars_query = "SELECT * FROM circulars WHERE status = 'Active' ORDER BY id ASC";
    $circulars_result = @mysqli_query($conn, $circulars_query);

    // Fetch all circulars into an array
    if ($circulars_result) {
        while ($circular = @mysqli_fetch_assoc($circulars_result)) {
            if ($circular) {
                // Parse the detailed_rules JSON if it exists
                if (!empty($circular['detailed_rules'])) {
                    $circular['rules_data'] = @json_decode($circular['detailed_rules'], true);
                    if (!is_array($circular['rules_data'])) {
                        $circular['rules_data'] = [];
                    }
                } else {
                    $circular['rules_data'] = [];
                }
                $circulars[] = $circular;
            }
        }
    }
}

// Function to safely get array value with default
function safeGet($array, $key, $default = '')
{
    return isset($array[$key]) ? htmlspecialchars($array[$key]) : htmlspecialchars($default);
}

// Helper function to get icon for circular type based on display name
function getGameIcon($display_name)
{
    $name = strtolower($display_name);
    if (strpos($name, 'cricket') !== false) {
        return '<i class="fa-solid fa-baseball-bat-ball"></i>';
    } elseif (strpos($name, 'football') !== false) {
        return '<i class="fa-solid fa-futbol"></i>';
    } elseif (strpos($name, 'carrom') !== false) {
        return '<i class="fa-solid fa-circle-dot"></i>';
    }
    return '<i class="fa-regular fa-file-lines"></i>';
}
