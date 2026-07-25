<?php
// co_announcement.php - SIMPLE WORKING VERSION
ob_start();
include 'c_navbar.php';

if (!isset($con) || !$con) {
    $con = mysqli_connect("localhost", "root", "", "galore2026");
    if (!$con) {
        die("Database connection failed: " . mysqli_connect_error());
    }
}

include 'mailer.php';
include 'mail_content.php';

// Login check
if (!isset($_SESSION['email']) && !isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get coordinator details
$user_email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
$user_query = "SELECT coordinator_role, school FROM ad_register WHERE email = ? LIMIT 1";
$stmt = mysqli_prepare($con, $user_query);
mysqli_stmt_bind_param($stmt, "s", $user_email);
mysqli_stmt_execute($stmt);
$user_result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($user_result);
$coordinator_role = $user['coordinator_role'] ?? '';
$school = $user['school'] ?? '';

$errors = [];
$successMsg = "";
$email_results = [];

if (isset($_POST['publish_announcement'])) {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    if (empty($title) || empty($content)) {
        $errors[] = "All fields are required!";
    }

    if (empty($errors)) {
        // Get emails - simplified query first
        $email_query = "SELECT DISTINCT email FROM event_register WHERE school = ? AND email IS NOT NULL AND email != '' LIMIT 5";
        $stmt_email = mysqli_prepare($con, $email_query);
        mysqli_stmt_bind_param($stmt_email, "s", $school);
        mysqli_stmt_execute($stmt_email);
        $email_result = mysqli_stmt_get_result($stmt_email);

        $validEmails = [];
        while ($row = mysqli_fetch_assoc($email_result)) {
            if (filter_var($row['email'], FILTER_VALIDATE_EMAIL)) {
                $validEmails[] = $row['email'];
            }
        }
        mysqli_stmt_close($stmt_email);
        $validEmails = array_unique($validEmails);
        
        if (empty($validEmails)) {
            $errors[] = "No valid emails found! Add some test emails to event_register table.";
        } else {
            // Save to database
            $emails_string = implode(",", $validEmails);
            $insert_stmt = mysqli_prepare($con, "INSERT INTO announcements (title, emails, content, coordinator_role, school) VALUES (?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($insert_stmt, "sssss", $title, $emails_string, $content, $coordinator_role, $school);
            
            if (mysqli_stmt_execute($insert_stmt)) {
                // Send emails one by one
                $sent_count = 0;
                $failed_count = 0;
                
                foreach ($validEmails as $email) {
                    $email_body = _wrapEmail(
                        "Galore 2026 Announcement",
                        "<h3>" . htmlspecialchars($title) . "</h3>
                         <p>" . nl2br(htmlspecialchars($content)) . "</p>
                         <hr>
                         <p><small>Sent by: " . htmlspecialchars($coordinator_role) . " (" . htmlspecialchars($school) . ")</small></p>"
                    );
                    
                    $result = sendEmail($email, "Galore 2026: " . $title, $email_body);
                    
                    if ($result === true) {
                        $sent_count++;
                        $email_results[] = "✅ Sent to: $email";
                    } else {
                        $failed_count++;
                        $email_results[] = "❌ Failed: $email - " . $result;
                    }
                }
                
                $successMsg = "✅ Sent: $sent_count, Failed: $failed_count";
                
            } else {
                $errors[] = "Database error: " . mysqli_error($con);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Announcements - Galore 2026</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <section class="hero">
    <h1>Co-cordinator Announcement</h1>
    <p>The Ultimate Sports & Cultural Festival of RK University</p>
</section>
    <div class="container mt-5">
        <h1 class="text-danger">📢 Co-coordinator Announcement</h1>
        <p><?php echo htmlspecialchars($coordinator_role . " – " . $school); ?></p>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger"><?php echo implode('<br>', $errors); ?></div>
        <?php endif; ?>
        
        <?php if (!empty($successMsg)): ?>
            <div class="alert alert-success">
                <strong>Success!</strong> <?php echo $successMsg; ?>
                <?php if (!empty($email_results)): ?>
                    <button class="btn btn-sm btn-link" onclick="toggleResults()">Show Details</button>
                    <div id="results" style="display:none; margin-top:10px;">
                        <?php foreach($email_results as $r) echo "$r<br>"; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body">
                <form method="post">
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Content</label>
                        <textarea name="content" class="form-control" rows="5" required></textarea>
                    </div>
                    <button type="submit" name="publish_announcement" class="btn btn-danger">
                        Publish Announcement
                    </button>
                </form>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script>
        function toggleResults() {
            var div = document.getElementById('results');
            div.style.display = div.style.display === 'none' ? 'block' : 'none';
        }
    </script>
</body>
</html>

<?php
if (isset($con)) mysqli_close($con);
ob_end_flush();
?>