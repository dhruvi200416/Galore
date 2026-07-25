<?php
session_start();
// Error reporting disabled to prevent warnings from displaying
error_reporting(0);
ini_set('display_errors', 0);

// Initialize variables
$hero_data = [
    'hero_title' => 'Galore 2026 Schedule',
    'hero_subtitle' => 'Check out the day-wise exciting events planned for the festival!'
];
$schedule_by_day = [];
$conn = null;

// Database connection
$conn = @mysqli_connect("localhost", "root", "", "galore2026");

// Check connection silently
if ($conn) {
    // Set charset
    @mysqli_set_charset($conn, "utf8mb4");
    
    // Fetch hero section data
    $hero_query = "SELECT * FROM schedule_page WHERE status = 'Active' LIMIT 1";
    $hero_result = @mysqli_query($conn, $hero_query);
    
    // Check if query was successful and fetch data
    if ($hero_result && @mysqli_num_rows($hero_result) > 0) {
        $fetched_data = @mysqli_fetch_assoc($hero_result);
        if ($fetched_data) {
            $hero_data = array_merge($hero_data, $fetched_data);
        }
    }
    
    // Fetch schedule events
    $events_query = "SELECT * FROM schedule_events WHERE status = 'Active' ORDER BY 
                     FIELD(day_title, 'Day 1 - 10th Jan 2026', 'Day 2 - 11th Jan 2026', 'Day 3 - 12th Jan 2026'), 
                     event_time ASC";
    $events_result = @mysqli_query($conn, $events_query);
    
    // Group events by day if query was successful
    if ($events_result) {
        while ($event = @mysqli_fetch_assoc($events_result)) {
            if ($event && isset($event['day_title'])) {
                $schedule_by_day[$event['day_title']][] = $event;
            }
        }
    }
}

// Function to safely get array value with default
function safeGet($array, $key, $default = '') {
    return isset($array[$key]) ? htmlspecialchars($array[$key]) : htmlspecialchars($default);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Galore 2026 - Schedule</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- AOS CSS -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --galore-red: #dc3545;
            --galore-red-dark: #b02a37;
            --galore-white: #fff;
            --galore-gray: #6c757d;
            --galore-bg: #fff5f5;
        }

        body {
            font-family: "Segoe UI", Arial, sans-serif;
            margin: 0;
            padding: 0;
            scroll-behavior: smooth;
        }

        /* ===== HERO SECTION ===== */
        .hero {
            background: linear-gradient(135deg, #dc3545, #7a1c25);
            color: #fff;
            text-align: center;
            padding: 160px 20px 100px;
            position: relative;
            overflow: hidden;
        }

        .hero::after {
            content: "";
            position: absolute;
            bottom: -60px;
            left: 0;
            width: 100%;
            height: 120px;
            background: #fff;
            border-radius: 50% 50% 0 0;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 900;
            letter-spacing: 2px;
            margin-bottom: 12px;
        }

        .hero p {
            font-size: 1.2rem;
            opacity: 0.95;
        }

        @media (max-width: 768px) {
            .hero {
                padding: 100px 20px 80px;
            }
            
            .hero h1 {
                font-size: 2.5rem;
            }
            
            .hero p {
                font-size: 1rem;
            }
        }

        /* SCHEDULE CARDS */
        .schedule-section {
            max-width: 1200px;
            margin: 60px auto;
            padding: 0 20px 80px;
        }

        .day-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 15px 35px rgba(220, 53, 69, 0.15);
            overflow: hidden;
            margin-bottom: 30px;
            transition: transform 0.4s, box-shadow 0.4s;
        }

        .day-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(220, 53, 69, 0.3);
        }

        .day-header {
            background: var(--galore-red);
            color: #fff;
            padding: 20px;
            text-align: center;
            font-weight: 700;
            font-size: 1.5rem;
            position: relative;
        }

        .event-list {
            padding: 20px;
        }

        .event-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #eee;
            transition: all 0.3s ease;
        }

        .event-item:last-child {
            border-bottom: none;
        }

        .event-item:hover {
            background: rgba(220, 53, 69, 0.05);
            border-left: 4px solid var(--galore-red);
            padding-left: 16px;
        }

        .event-time {
            font-weight: 600;
            color: var(--galore-red-dark);
            min-width: 100px;
        }

        .event-details {
            flex: 1;
            padding: 0 15px;
        }

        .event-name {
            font-weight: 500;
            color: #333;
            margin-bottom: 4px;
        }

        .event-location {
            font-size: 0.9rem;
            color: var(--galore-gray);
        }

        .no-events {
            text-align: center;
            padding: 60px 20px;
            background: #f8f9fa;
            border-radius: 20px;
            color: var(--galore-gray);
        }

        .no-events i {
            font-size: 4rem;
            color: var(--galore-red);
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .event-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
            
            .event-time {
                min-width: auto;
            }
            
            .event-details {
                padding: 0;
            }
        }
    </style>
</head>

<body>

    <?php 
    // Silent include for navbar
    if (file_exists('navbar.php')) {
        include 'navbar.php';
    }
    ?>

    <!-- HERO -->
    <section class="hero">
        <h1 class="display-1 display-md-2 display-sm-3" data-aos="fade-down">
            <?php echo safeGet($hero_data, 'hero_title', 'Galore 2026 Schedule'); ?>
        </h1>
        <p class="lead lead-sm" data-aos="fade-up" data-aos-delay="200">
            <?php echo safeGet($hero_data, 'hero_subtitle', 'Check out the day-wise exciting events planned for the festival!'); ?>
        </p>
    </section>

    <!-- SCHEDULE SECTION -->
    <section class="schedule-section">
        
        <?php if (empty($schedule_by_day)): ?>
            <div class="no-events" data-aos="fade-up">
                <i class="bi bi-calendar-x"></i>
                <h4>No Events Scheduled Yet!</h4>
                <p class="text-muted">Please check back later for the updated event schedule.</p>
            </div>
        <?php else: ?>
            
            <?php 
            $delay = 0;
            foreach ($schedule_by_day as $day_title => $events): 
                if (empty($events)) continue;
            ?>
                <!-- Day Card -->
                <div class="day-card" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
                    <div class="day-header">
                        <?php echo htmlspecialchars($day_title); ?>
                    </div>
                    <div class="event-list">
                        <?php foreach ($events as $event): ?>
                            <div class="event-item flex-column flex-md-row align-items-start align-items-md-center">
                                <div class="event-time">
                                    <?php echo isset($event['event_time']) ? htmlspecialchars($event['event_time']) : 'TBA'; ?>
                                </div>
                                <div class="event-details">
                                    <div class="event-name">
                                        <?php echo isset($event['event_name']) ? htmlspecialchars($event['event_name']) : 'Event Name'; ?>
                                    </div>
                                    <div class="event-location">
                                        <i class="bi bi-geo-alt-fill" style="color: var(--galore-red);"></i>
                                        <?php echo isset($event['event_location']) ? htmlspecialchars($event['event_location']) : 'Location TBA'; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php 
                $delay += 100;
            endforeach; 
            ?>
            
        <?php endif; ?>

        <!-- Additional Information -->
        <?php if (!empty($schedule_by_day)): ?>
            <div class="text-center mt-5" data-aos="fade-up" data-aos-delay="300">
                <p class="text-muted">
                    <i class="bi bi-info-circle"></i> 
                    Schedule is subject to change. Please check back regularly for updates.
                </p>
            </div>
        <?php endif; ?>

    </section>

    <?php 
    // Silent include for footer
    if (file_exists('footer.php')) {
        include 'footer.php';
    }
    ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- AOS JS -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        if (typeof AOS !== 'undefined') {
            AOS.init({
                duration: 1200,
                once: true,
                offset: 100
            });
        }
    </script>

</body>

</html>

<?php
// Close connection silently
if (isset($conn) && $conn) {
    @mysqli_close($conn);
}
?>