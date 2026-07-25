<?php
include 'result_handler.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Galore 2026 - Results</title>

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

        /* HERO SECTION */
        .hero {
            background: linear-gradient(135deg, #dc3545 0%, #b02a37 100%);
            color: white;
            text-align: center;
            padding: 120px 20px;
            position: relative;
            overflow: hidden;
        }

        .hero h1 {
            font-size: 4rem;
            font-weight: 800;
            margin-bottom: 20px;
        }

        .hero p {
            font-size: 1.2rem;
            opacity: 0.9;
        }

        @media (max-width: 768px) {
            .hero {
                padding: 80px 20px;
            }
            
            .hero h1 {
                font-size: 2.5rem;
            }

            .hero p {
                font-size: 1rem;
            }
        }

        /* RESULTS SECTION */
        .results-section {
            max-width: 1200px;
            margin: 60px auto;
            padding: 0 20px 80px;
        }

        .results-section h2 {
            text-align: center;
            font-size: 2.8rem;
            color: var(--galore-red);
            font-weight: 700;
            margin-bottom: 10px;
        }

        @media (max-width: 768px) {
            .results-section h2 {
                font-size: 2.2rem;
            }
        }

        .underline {
            width: 80px;
            height: 4px;
            background: linear-gradient(135deg, var(--galore-red), var(--galore-red-dark));
            margin: 0 auto 50px;
            border-radius: 10px;
        }

        /* RESULT CARDS */
        .result-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(220, 53, 69, 0.15);
            overflow: hidden;
            margin-bottom: 30px;
            transition: all 0.5s ease;
            display: flex;
            align-items: center;
            padding: 25px;
            position: relative;
            border-left: 6px solid transparent;
        }

        .result-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px rgba(220, 53, 69, 0.25);
            border-left-color: var(--galore-red);
        }

        .result-card .position-icon {
            font-size: 3rem;
            margin-right: 25px;
            flex-shrink: 0;
            min-width: 60px;
            text-align: center;
        }

        .result-info {
            flex: 1;
        }

        .result-info h5 {
            margin: 0 0 8px 0;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--galore-red-dark);
        }

        .result-info p {
            margin: 5px 0;
            color: #444;
            font-weight: 500;
        }

        .result-info .team-name {
            font-size: 1.1rem;
            color: #333;
        }

        .result-info .rank {
            background: #f8f9fa;
            padding: 3px 10px;
            border-radius: 20px;
            display: inline-block;
            margin-top: 5px;
            font-size: 0.95rem;
        }

        .result-info .school {
            color: var(--galore-gray);
            font-size: 0.95rem;
        }

        .result-info .event-type {
            color: var(--galore-red);
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 8px;
        }

        .medal-gold {
            color: #FFD700;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .medal-silver {
            color: #C0C0C0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .medal-bronze {
            color: #CD7F32;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Event Icons */
        .event-icon {
            font-size: 2.5rem;
            margin-left: 20px;
            color: var(--galore-red-dark);
            min-width: 60px;
            text-align: center;
            background: rgba(220, 53, 69, 0.1);
            padding: 10px;
            border-radius: 50%;
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Rank Badge Styles */
        .rank-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: bold;
        }

        .rank-1st {
            background: linear-gradient(135deg, #ffd966, #ffc107);
            color: #7a5c00;
        }

        .rank-2nd {
            background: linear-gradient(135deg, #e3e4e5, #c0c0c0);
            color: #4a4a4a;
        }

        .rank-3rd {
            background: linear-gradient(135deg, #e3bc8e, #cd7f32);
            color: white;
        }

        /* School Badge */
        .school-badge {
            background: rgba(220, 53, 69, 0.1);
            color: var(--galore-red);
            padding: 4px 12px;
            border-radius: 20px;
            display: inline-block;
            font-size: 0.85rem;
            font-weight: 600;
        }

        /* No Results State */
        .no-results {
            text-align: center;
            padding: 60px 20px;
            background: #f8f9fa;
            border-radius: 20px;
            color: var(--galore-gray);
        }

        .no-results i {
            font-size: 4rem;
            color: var(--galore-red);
            margin-bottom: 20px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .result-card {
                flex-direction: column;
                text-align: center;
                padding: 20px;
            }

            .result-card .position-icon {
                margin-right: 0;
                margin-bottom: 15px;
            }

            .event-icon {
                margin-left: 0;
                margin-top: 20px;
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

    <!-- HERO SECTION -->
    <section class="hero">
        <h1 class="display-1 display-md-2 display-sm-3" data-aos="fade-down">
            <?php echo isset($header_data['hero_title']) ? htmlspecialchars($header_data['hero_title']) : 'Galore 2026 Results'; ?>
        </h1>
        <p class="lead lead-sm" data-aos="fade-up" data-aos-delay="200">
            <?php echo isset($header_data['hero_subtitle']) ? htmlspecialchars($header_data['hero_subtitle']) : 'See the winners of all events and competitions!'; ?>
        </p>
    </section>

    <!-- RESULTS SECTION -->
    <section class="results-section">

        <h2 class="display-2 display-md-3 display-sm-4" data-aos="fade-up">
            <?php echo isset($header_data['title']) ? htmlspecialchars($header_data['title']) : 'Event Results'; ?>
        </h2>
        <div class="underline" data-aos="fade-up" data-aos-delay="100"></div>

        <div data-aos="fade-up" data-aos-delay="200">

            <?php if (empty($event_results)): ?>
                <div class="no-results">
                    <i class="bi bi-trophy"></i>
                    <h3>No Results Available Yet</h3>
                    <p class="text-muted">Please check back later for updated event results.</p>
                </div>
            <?php else: ?>
                <?php
                $delay = 0;
                foreach ($event_results as $index => $result):
                    $animation = ($index % 2 == 0) ? 'fade-right' : 'fade-left';
                    $rank_icon = getRankIcon(isset($result['ranks']) ? $result['ranks'] : '');
                    $medal_class = getMedalColorClass(isset($result['ranks']) ? $result['ranks'] : '');
                    $event_icon = getEventIcon(isset($result['event_type']) ? $result['event_type'] : '');
                    
                    // Get rank display text
                    $rank_display = isset($result['ranks']) ? $result['ranks'] : 'Winner';
                    
                    // Get rank class for badge
                    $rank_class = '';
                    if (isset($result['ranks'])) {
                        if ($result['ranks'] == '1st' || $result['ranks'] == 'Gold') $rank_class = 'rank-1st';
                        elseif ($result['ranks'] == '2nd' || $result['ranks'] == 'Silver') $rank_class = 'rank-2nd';
                        elseif ($result['ranks'] == '3rd' || $result['ranks'] == 'Bronze') $rank_class = 'rank-3rd';
                    }
                ?>
                    <div class="result-card flex-column flex-md-row text-center text-md-start"
                        data-aos="<?php echo $animation; ?>"
                        data-aos-delay="<?php echo $delay; ?>">

                        <div class="position-icon <?php echo $medal_class; ?> mb-3 mb-md-0 me-md-4">
                            <?php echo $rank_icon; ?>
                        </div>

                        <div class="result-info">
                            <h5><?php echo isset($result['event_name']) ? htmlspecialchars($result['event_name']) : 'Unknown Event'; ?></h5>
                            
                            <p class="event-type">
                                <i class="bi bi-tag"></i>
                                <?php echo isset($result['event_type']) ? htmlspecialchars($result['event_type']) : 'General'; ?>
                            </p>
                            
                            <p class="team-name">
                                <i class="bi bi-people-fill"></i>
                                Team: <?php echo isset($result['team_name']) ? htmlspecialchars($result['team_name']) : 'Not specified'; ?>
                            </p>
                            
                            <p class="school">
                                <i class="bi bi-building"></i>
                                School: <span class="school-badge"><?php echo isset($result['school']) ? htmlspecialchars($result['school']) : 'Not specified'; ?></span>
                            </p>
                            
                            <p class="rank">
                                <i class="bi bi-trophy-fill"></i>
                                Rank: <span class="rank-badge <?php echo $rank_class; ?>"><?php echo htmlspecialchars($rank_display); ?></span>
                            </p>
                        </div>

                        <div class="event-icon mt-3 mt-md-0 ms-md-auto">
                            <?php echo $event_icon; ?>
                        </div>
                    </div>
                <?php
                    $delay += 100;
                endforeach;
                ?>
            <?php endif; ?>

        </div>

        <?php if (!empty($event_results)): ?>
            <div class="text-center mt-5" data-aos="fade-up" data-aos-delay="300">
                <p class="text-muted">
                    <i class="bi bi-info-circle"></i>
                    Congratulations to all the winners! Results are final and certified by the event coordinators.
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