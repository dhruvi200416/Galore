<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "galore2026");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch hero section data from gallery_page table
$hero_query = "SELECT * FROM gallery_page WHERE status = 'Active' LIMIT 1";
$hero_result = mysqli_query($conn, $hero_query);

// Check if query was successful and fetch data
if ($hero_result && mysqli_num_rows($hero_result) > 0) {
    $hero_data = mysqli_fetch_assoc($hero_result);
} else {
    // Default values if no data in database
    $hero_data = [
        'hero_title' => 'Galore 2026 Gallery',
        'hero_subtitle' => 'Check out the memorable moments from our events!'
    ];
}

// Fetch gallery images from gallery_images table
$images_query = "SELECT * FROM gallery_images WHERE status = 'Active' ORDER BY id ASC";
$images_result = mysqli_query($conn, $images_query);

// Check if query was successful
if (!$images_result) {
    die("Error fetching images: " . mysqli_error($conn));
}

// Fetch all images into an array
$gallery_images = [];
while ($image = mysqli_fetch_assoc($images_result)) {
    $gallery_images[] = $image;
}
