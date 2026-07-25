<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Simple Upload Test Results</h1>";

// Database connection
$con = mysqli_connect("localhost", "root", "", "galore2026");

if (mysqli_connect_errno()) {
    die("Database connection failed: " . mysqli_connect_error());
}
echo "<p>✅ Database connected</p>";
$result = mysqli_query($con, "SHOW COLUMNS FROM ad_register WHERE Field = 'role'");
if ($result) {
    $row = mysqli_fetch_assoc($result);
    echo "<p>✅ Role column exists: " . $row['Type'] . "</p>";
} else {
    die("Error checking role column");
}
// Check if file was uploaded
if (!isset($_FILES['csv_file']) || $_FILES['csv_file']['error'] != 0) {
    die("No file uploaded or upload error");
}

$file = $_FILES['csv_file']['tmp_name'];
echo "<p>File uploaded: " . $_FILES['csv_file']['name'] . "</p>";
echo "<p>File size: " . round($_FILES['csv_file']['size'] / 1024, 2) . " KB</p>";

// Read and display file content
$handle = fopen($file, "r");
if (!$handle) {
    die("Cannot open file");
}

echo "<h3>CSV Content:</h3>";
$row = 0;
$inserted = 0;

while (($data = fgetcsv($handle, 10000, ",")) !== FALSE) {
    $row++;
    echo "<p><strong>Row $row:</strong> ";
    print_r($data);
    echo "</p>";
    
    // Skip header row
    if ($row == 1 && (strtolower($data[0]) == 'id' || strtolower($data[1]) == 'full_name')) {
        echo "<p style='color:blue'>Row $row: Header skipped</p>";
        continue;
    }
    
    // Check if we have 9 columns
    if (count($data) < 9) {
        echo "<p style='color:orange'>Row $row: Not enough columns (" . count($data) . "), skipping</p>";
        continue;
    }
    
    // Get data
    $id = mysqli_real_escape_string($con, trim($data[0]));
    $full_name = mysqli_real_escape_string($con, trim($data[1]));
    $email = mysqli_real_escape_string($con, trim($data[2]));
    $phone = mysqli_real_escape_string($con, trim($data[3]));
    $branch = mysqli_real_escape_string($con, trim($data[4]));
    $gender = mysqli_real_escape_string($con, trim($data[5]));
    $role = mysqli_real_escape_string($con, trim($data[6]));
    $school = mysqli_real_escape_string($con, trim($data[7]));
    $password = mysqli_real_escape_string($con, trim($data[8]));
    
    // Check if email already exists
    $check = mysqli_query($con, "SELECT id FROM ad_register WHERE email = '$email'");
    if (mysqli_num_rows($check) > 0) {
        echo "<p style='color:orange'>Row $row: Email $email already exists, skipping</p>";
        continue;
    }
    
    // Insert
    $sql = "INSERT INTO ad_register (id, full_name, email, phone, branch, gender, role, school, password) 
            VALUES ('$id', '$full_name', '$email', '$phone', '$branch', '$gender', '$role', '$school', '$password')";
    
    echo "<p>SQL: " . htmlspecialchars($sql) . "</p>";
    
    if (mysqli_query($con, $sql)) {
        $inserted++;
        echo "<p style='color:green'>✅ Row $row: Inserted successfully</p>";
    } else {
        echo "<p style='color:red'>❌ Row $row: Failed - " . mysqli_error($con) . "</p>";
    }
}

fclose($handle);

echo "<h2>Summary:</h2>";
echo "<p>Total rows processed: $row</p>";
echo "<p style='color:green'>Inserted: $inserted</p>";

// Show current records
$result = mysqli_query($con, "SELECT * FROM ad_register");
echo "<h3>Current Records in Database:</h3>";
echo "<table border='1' cellpadding='5'>";
echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th></tr>";
while ($row_data = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $row_data['id'] . "</td>";
    echo "<td>" . $row_data['full_name'] . "</td>";
    echo "<td>" . $row_data['email'] . "</td>";
    echo "<td>" . $row_data['role'] . "</td>";
    echo "</tr>";
}
echo "</table>";
?>