<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Simple CSV Upload Test</title>
</head>
<body>
    <h1>Simple CSV Upload Test</h1>
    
    <form method="post" action="test_handler_simple.php" enctype="multipart/form-data">
        <input type="file" name="csv_file" accept=".csv" required>
        <button type="submit" name="upload">Upload CSV</button>
    </form>
    
    <h3>CSV Format Required:</h3>
    <pre>id,full_name,email,phone,branch,gender,role,school,password
1,John Doe,john@test.com,1234567890,CS,Male,Admin,Engineering,pass123</pre>
</body>
</html>