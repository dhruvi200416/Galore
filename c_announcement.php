<?php
session_start();
include 'co_navbar.php';
include 'mailer.php';
include 'c_mail_content.php';

$con = mysqli_connect("localhost", "root", "", "galore2026");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$successMsg = "";
$errorMsg = "";

// Handle form submission
if(isset($_POST['publish'])){
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $game = mysqli_real_escape_string($con, $_POST['game']);
    $content = mysqli_real_escape_string($con, $_POST['content']);
    $email = $_SESSION['email'];
    
    // Get coordinator name
    $coordinator_name = "";
    $coordinator_query = mysqli_query($con, "SELECT coordinator_role FROM ad_register WHERE email = '$email'");
    if($coordinator_data = mysqli_fetch_assoc($coordinator_query)){
        $coordinator_name = $coordinator_data['coordinator_role'];
    }
    
    // Insert into c_announcement table
    $insert = mysqli_query($con, "INSERT INTO c_announcement (title, content, game, created_by, status) 
                                  VALUES('$title', '$content', '$game', '$coordinator_name', 'Active')");
    
    if($insert){
        // Get participants based on selected game
        $participants_query = "";
        
        if($game == 'general') {
            // Send to ALL participants from event_register
            $participants_query = "SELECT DISTINCT email FROM event_register";
        } else {
            // Send to participants who registered for specific game
            $participants_query = "SELECT DISTINCT email FROM event_register WHERE game = '$game'";
        }
        
        $participants_result = mysqli_query($con, $participants_query);
        
        if(!$participants_result) {
            $errorMsg = "❌ Error fetching participants: " . mysqli_error($con);
        } else {
            $sent_count = 0;
            $failed_count = 0;
            $failed_emails = [];
            
            $body = getMailContent($title, $content, ucfirst($game));
            
            // Check if any participants found
            if(mysqli_num_rows($participants_result) == 0) {
                $errorMsg = "❌ No participants found for selected game: $game";
            } else {
                // Loop through all participants and send email
                while($participant = mysqli_fetch_assoc($participants_result)) {
                    $participant_email = $participant['email'];
                    
                    $send = sendEmail($participant_email, "Galore 2026: " . $title, $body);
                    
                    if($send === true) {
                        $sent_count++;
                    } else {
                        $failed_count++;
                        $failed_emails[] = $participant_email;
                    }
                }
                
                // Also send to coordinator for record (optional)
                $coordinator_email = $email;
                sendEmail($coordinator_email, "Galore 2026: " . $title . " (Copy for Coordinator)", $body);
                
                if($sent_count > 0) {
                    $successMsg = "✅ Announcement Published! Sent to $sent_count participants";
                    if($failed_count > 0) {
                        $successMsg .= "<br>⚠️ Failed to send to $failed_count participants: " . implode(", ", $failed_emails);
                    }
                } else {
                    $errorMsg = "❌ Failed to send emails to any participant";
                }
            }
        }
        
    } else {
        $errorMsg = "❌ Failed to save announcement: " . mysqli_error($con);
    }
}

// Fetch counts
$totalQuery = mysqli_query($con, "SELECT COUNT(*) AS total FROM c_announcement");
$totalAnnouncements = mysqli_fetch_assoc($totalQuery)['total'] ?? 0;

$todayQuery = mysqli_query($con, "SELECT COUNT(*) AS today FROM c_announcement WHERE DATE(created_at) = CURDATE()");
$todayAnnouncements = mysqli_fetch_assoc($todayQuery)['today'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Announcement Manager - Galore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>

        .create-announcement-card {
            background: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            border-left: 8px solid #dc3545;
        }
        .btn-publish {
            background: #dc3545;
            color: white;
            padding: 12px 25px;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            transition: transform 0.2s;
        }
        .btn-publish:hover {
            background: #bb2d3b;
            transform: translateY(-2px);
        }
        .stats-card {
            background: white;
            border-radius: 20px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
            margin-bottom: 20px;
            transition: transform 0.2s;
        }
        .stats-card:hover {
            transform: translateY(-5px);
        }
        .stats-icon {
            width: 50px;
            height: 50px;
            background: #ffe5e5;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .stats-icon i { color: #dc3545; font-size: 20px; }
        .stats-content h6 { margin: 0; color: #6c757d; }
        .stats-content h2 { margin: 0; color: #dc3545; font-weight: 700; }
        .form-label {
            font-weight: 600;
            color: #333;
        }
        .alert {
            border-radius: 12px;
        }
    </style>
</head>

<body>

<?php include 'co_navbar.php'; ?>

<section class="hero">
    <h1>Coordinator Announcement</h1>
    <p>The Ultimate Sports & Cultural Festival of RK University</p>
</section>

<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="stats-card">
                <div class="stats-icon"><i class="fas fa-bullhorn"></i></div>
                <div class="stats-content">
                    <h6>Total Announcements</h6>
                    <h2><?php echo $totalAnnouncements; ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="stats-card">
                <div class="stats-icon"><i class="fas fa-calendar-day"></i></div>
                <div class="stats-content">
                    <h6>Today's Announcements</h6>
                    <h2><?php echo $todayAnnouncements; ?></h2>
                </div>
            </div>
        </div>
    </div>

    <?php if($successMsg != ""): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo $successMsg; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    <?php if($errorMsg != ""): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $errorMsg; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="create-announcement-card">
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Announcement Title *</label>
                <input type="text" name="title" class="form-control" required placeholder="Enter announcement title">
            </div>
            <div class="mb-3">
                <label class="form-label">Target Game *</label>
                <select class="form-select" name="game" required>
                    <option value="general">📢 General (All Participants)</option>
                    <option value="cricket">🏏 Cricket Participants Only</option>
                    <option value="football">⚽ Football Participants Only</option>
                </select>
                <small class="text-muted">Select which group should receive this announcement</small>
            </div>
            <div class="mb-3">
                <label class="form-label">Announcement Content *</label>
                <textarea name="content" class="form-control" rows="6" required placeholder="Write your announcement here..."></textarea>
            </div>
            <button type="submit" name="publish" class="btn-publish">
                <i class="fas fa-paper-plane me-2"></i>Publish Announcement
            </button>
        </form>
    </div>
</div>
<br><br>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
if(isset($con)) mysqli_close($con);
?>