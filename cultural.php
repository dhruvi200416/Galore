<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Cultural Events | Galore 2026</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- AOS -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            --galore-red: #dc3545;
            --galore-dark: #7a1c25;
            --galore-gray: #6c757d;
        }

        body {
            font-family: "Segoe UI", Arial, sans-serif;
            background: #f8f9fa;
        }

        /* ===== HERO ===== */
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

        /* ===== SECTION ===== */
        .sports-section {
            padding: 80px 0;
            margin-top: -40px;
        }

        .section-title {
            text-align: center;
            font-weight: 800;
            color: var(--galore-red);
            margin-bottom: 6px;
        }

        .section-subtitle {
            text-align: center;
            color: var(--galore-gray);
            margin-bottom: 55px;
        }

        /* ===== EVENT CARD ===== */
        .event-card {
            background: #fff;
            border-radius: 20px;
            padding: 32px 26px;
            height: 100%;
            box-shadow: 0 18px 40px rgba(0, 0, 0, 0.12);
            border-top: 5px solid var(--galore-red);
            transition: all 0.35s ease;
            display: flex;
            flex-direction: column;
        }

        .event-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 30px 55px rgba(220, 53, 69, 0.35);
        }

        .event-card h5 {
            font-weight: 800;
            color: var(--galore-red);
            margin-bottom: 14px;
            font-size: 1.15rem;
        }

        .event-card p {
            font-size: 0.95rem;
            color: #555;
            line-height: 1.65;
            flex-grow: 1;
        }

        /* ===== NOTE ===== */
        .note {
            text-align: center;
            margin-top: 55px;
            font-weight: 600;
            color: var(--galore-red);
        }
        
        /* ===== NO EVENTS MESSAGE ===== */
        .no-events {
            text-align: center;
            padding: 40px;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        .no-events i {
            font-size: 4rem;
            color: var(--galore-red);
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

<?php include 'navbar.php'; ?>

<?php
// Database connection
$con = mysqli_connect("localhost", "root", "", "galore2026");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch cultural header data (only active)
$header_query = "SELECT hero_title, hero_subtitle, section_title, section_subtitle, note_text 
                 FROM cultural_header 
                 WHERE status = 'Active' 
                 ORDER BY id ASC LIMIT 1";
$header_result = mysqli_query($con, $header_query);
$header_data = mysqli_fetch_assoc($header_result);

// Fetch cultural events (only active)
$events_query = "SELECT id, event_name, description 
                 FROM cultural_event 
                 WHERE status = 'Active' 
                 ORDER BY id ASC";
$events_result = mysqli_query($con, $events_query);
$events = [];
while ($row = mysqli_fetch_assoc($events_result)) {
    $events[] = $row;
}
$event_count = count($events);
?>

<!-- HERO -->
<section class="hero">
    <h1 class="display-1 display-md-2 display-sm-3">
        <?php echo htmlspecialchars($header_data['hero_title'] ?? 'Cultural Events'); ?>
    </h1>
    <p class="lead lead-sm">
        <?php echo htmlspecialchars($header_data['hero_subtitle'] ?? 'Show your talent and light up Galore 2026'); ?>
    </p>
</section>

<!-- CONTENT -->
<section class="sports-section">
    <div class="container">

        <?php if ($header_data): ?>
            <h3 class="section-title h3 h4-sm"><?php echo htmlspecialchars($header_data['section_title']); ?></h3>
            <p class="section-subtitle lead lead-sm"><?php echo htmlspecialchars($header_data['section_subtitle']); ?></p>
        <?php else: ?>
            <h3 class="section-title h3 h4-sm">Cultural Event List</h3>
            <p class="section-subtitle lead lead-sm">Creativity, expression, and celebration of talent</p>
        <?php endif; ?>

        <?php if ($event_count > 0): ?>
            <div class="row g-4">
                <?php 
                $delay = 0;
                foreach ($events as $event): 
                ?>
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
                        <div class="event-card">
                            <h5 class="h5 h6-sm"><?php echo htmlspecialchars($event['event_name']); ?></h5>
                            <p class="mb-0"><?php echo htmlspecialchars($event['description']); ?></p>
                        </div>
                    </div>
                <?php 
                    $delay += 100;
                endforeach; 
                ?>
            </div>
        <?php else: ?>
            <div class="no-events" data-aos="fade-up">
                <i class="fas fa-calendar-times"></i>
                <h4>No Cultural Events Available</h4>
                <p class="text-muted">Check back later for exciting cultural events!</p>
            </div>
        <?php endif; ?>

        <?php if ($header_data && !empty($header_data['note_text'])): ?>
            <p class="note lead lead-sm"><?php echo htmlspecialchars($header_data['note_text']); ?></p>
        <?php else: ?>
            <p class="note lead lead-sm">
                * Event rules and judging criteria will be announced during Galore 2026
            </p>
        <?php endif; ?>

    </div>
</section>

<?php include 'footer.php'; ?>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
<script>
    AOS.init({
        duration: 900,
        once: true
    });
</script>

</body>
</html>