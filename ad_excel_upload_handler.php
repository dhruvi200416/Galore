<?php
// Start session at the beginning
session_start();

// Remove the debug code from the beginning - just keep this check
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['upload_error'] = "Invalid request method.";
    header("Location: ad_excel_upload.php");
    exit();
}

// Database connection
$con = mysqli_connect("localhost", "root", "", "galore2026");

// Check connection
if (mysqli_connect_errno()) {
    $_SESSION['upload_error'] = "Database connection failed: " . mysqli_connect_error();
    header("Location: ad_excel_upload.php");
    exit();
}

// Check if form was submitted with upload button
if (!isset($_POST['upload'])) {
    $_SESSION['upload_error'] = "Form not submitted properly. Please use the upload button.";
    header("Location: ad_excel_upload.php");
    exit();
}

// Check if file was uploaded
if (!isset($_FILES['csv_file']) || $_FILES['csv_file']['error'] != 0) {
    $error_msg = "Please select a valid CSV file to upload.";
    if (isset($_FILES['csv_file']['error'])) {
        switch ($_FILES['csv_file']['error']) {
            case UPLOAD_ERR_INI_SIZE:
                $error_msg = "File too large (exceeds server limit)";
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $error_msg = "File too large (exceeds form limit)";
                break;
            case UPLOAD_ERR_NO_FILE:
                $error_msg = "No file was selected";
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $error_msg = "Server temporary folder missing";
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $error_msg = "Failed to write file to disk";
                break;
        }
    }
    $_SESSION['upload_error'] = $error_msg;
    header("Location: ad_excel_upload.php");
    exit();
}

$file = $_FILES['csv_file']['tmp_name'];
$file_name = $_FILES['csv_file']['name'];
$file_size = $_FILES['csv_file']['size'];

// Check file extension
$file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
if ($file_extension != 'csv') {
    $_SESSION['upload_error'] = "Please upload a CSV file. You uploaded: " . htmlspecialchars($file_extension);
    header("Location: ad_excel_upload.php");
    exit();
}

// Check file size (max 10MB)
if ($file_size > 10 * 1024 * 1024) {
    $_SESSION['upload_error'] = "File is too large. Maximum size is 10MB.";
    header("Location: ad_excel_upload.php");
    exit();
}

// Function to clean CSV data
function clean_csv_data($data)
{
    $data = trim($data);
    if (substr($data, 0, 3) == "\xEF\xBB\xBF") {
        $data = substr($data, 3);
    }
    $data = trim($data, '"');
    if ($data === '') {
        return null;
    }
    return $data;
}

// Open the file
$handle = fopen($file, "r");
if ($handle === false) {
    $_SESSION['upload_error'] = "Could not open the uploaded file.";
    header("Location: ad_excel_upload.php");
    exit();
}

// Start transaction
mysqli_begin_transaction($con);

try {
    // Delete old data
    $delete_result = mysqli_query($con, "DELETE FROM ad_register");
    if (!$delete_result) {
        throw new Exception("Failed to clear existing data: " . mysqli_error($con));
    }

    $row = 0;
    $inserted = 0;
    $skipped = 0;
    $errors = [];
    $header_skipped = false;

    // Read CSV line by line
    while (($data = fgetcsv($handle, 10000, ",")) !== FALSE) {
        $row++;
        
        if (empty(array_filter($data))) {
            $skipped++;
            continue;
        }

        $data = array_map('clean_csv_data', $data);
        
        // Skip header row
        if (!$header_skipped && $row == 1) {
            $first_cell = strtolower(trim($data[0] ?? ''));
            if ($first_cell == 'id' || $first_cell == 'full_name' || $first_cell == 'email') {
                $header_skipped = true;
                continue;
            }
            $header_skipped = true;
        }

        $column_count = count($data);
        
        if ($column_count < 9) {
            $skipped++;
            $errors[] = "Row $row: Insufficient columns (" . $column_count . "/9 needed)";
            continue;
        }
        
        $id = isset($data[0]) ? mysqli_real_escape_string($con, $data[0]) : '';
        $full_name = isset($data[1]) ? mysqli_real_escape_string($con, $data[1]) : '';
        $email = isset($data[2]) ? mysqli_real_escape_string($con, $data[2]) : '';
        $phone = isset($data[3]) ? mysqli_real_escape_string($con, $data[3]) : '';
        $branch = isset($data[4]) ? mysqli_real_escape_string($con, $data[4]) : '';
        $gender = isset($data[5]) ? mysqli_real_escape_string($con, $data[5]) : '';
        $role = isset($data[6]) ? mysqli_real_escape_string($con, $data[6]) : '';
        $school = isset($data[7]) ? mysqli_real_escape_string($con, $data[7]) : '';
        
        // Handle password from correct column
        $password = '';
        if ($column_count >= 11) {
            $password = isset($data[10]) ? $data[10] : '';
        } elseif ($column_count == 10) {
            $password = isset($data[9]) ? $data[9] : '';
        } else {
            $password = isset($data[8]) ? $data[8] : '';
        }
        
        $password = mysqli_real_escape_string($con, $password);

        // Validate required fields
        if (empty($full_name) || empty($email) || empty($password)) {
            $skipped++;
            $errors[] = "Row $row: Missing required fields";
            continue;
        }

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $skipped++;
            $errors[] = "Row $row: Invalid email format: $email";
            continue;
        }

        // Set default status
        $default_status = 'Active';
        
        // Build INSERT query
        $sql = "INSERT INTO ad_register (id, full_name, email, phone, branch, gender, role, school, password, status) 
                VALUES ('$id', '$full_name', '$email', '$phone', '$branch', '$gender', '$role', '$school', '$password', '$default_status')";
        
        $result = mysqli_query($con, $sql);

        if ($result) {
            $inserted++;
        } else {
            $skipped++;
            $errors[] = "Row $row: Database error - " . mysqli_error($con);
        }
    }

    fclose($handle);

    if ($inserted == 0 && $row > 1) {
        throw new Exception("No records were inserted. Please check your CSV format.");
    }

    mysqli_commit($con);

    // Success message
    $success_msg = "<strong>✅ Data Synced Successfully!</strong><br><br>";
    $success_msg .= "📊 <strong>$inserted</strong> records inserted successfully.<br>";
    $success_msg .= "⏭️ <strong>$skipped</strong> records skipped.<br>";
    $success_msg .= "📄 Total rows processed: " . ($row - ($header_skipped ? 1 : 0));

    if (!empty($errors)) {
        $success_msg .= "<br><br>⚠️ Issues encountered:<br>";
        foreach (array_slice($errors, 0, 5) as $error) {
            $success_msg .= "• " . htmlspecialchars($error) . "<br>";
        }
    }

    $_SESSION['upload_msg'] = $success_msg;

} catch (Exception $e) {
    mysqli_rollback($con);
    if (isset($handle) && is_resource($handle)) {
        fclose($handle);
    }
    $_SESSION['upload_error'] = "Upload failed: " . $e->getMessage();
}

header("Location: ad_excel_upload.php");
exit();
?>