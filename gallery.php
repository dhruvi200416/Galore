<?php
session_start();
include 'gallery_handler.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Galore – Gallery</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />

    <style>
        :root {
            --galore-red: #dc3545;
            --galore-red-dark: #b02a37;
            --galore-white: #ffffff;
        }

        body {
            font-family: "Segoe UI", Arial, sans-serif;
            overflow-x: hidden;
        }

        .container {
            max-width: 1200px;
            padding: 60px 20px;
        }

        /* ===== Hero Section ===== */
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
            .hero h1 {
                font-size: 2.5rem;
            }
            .hero p {
                font-size: 1rem;
            }
        }

        /* ===== Gallery Cards ===== */
        .gallery-card {
            position: relative;
            overflow: hidden;
            border-radius: 16px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
            cursor: pointer;
            background: #fff;
            height: 100%;
            min-height: 260px;
        }

        .gallery-card img {
            width: 100%;
            height: 260px;
            object-fit: cover;
            transition: transform 0.6s cubic-bezier(0.25, 1, 0.5, 1);
            display: block;
        }

        .gallery-card:hover img {
            transform: scale(1.1);
        }

        .gallery-overlay {
            position: absolute;
            inset: 0;
            background: rgba(220, 53, 69, 0.85);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.3rem;
            font-weight: 600;
            opacity: 0;
            transition: opacity 0.4s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .gallery-card:hover .gallery-overlay {
            opacity: 1;
        }

        /* Loading and Error States */
        .no-images {
            text-align: center;
            padding: 60px 20px;
            background: #f8f9fa;
            border-radius: 16px;
            color: var(--galore-gray);
        }

        .no-images i {
            font-size: 4rem;
            color: var(--galore-red);
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <?php include 'navbar.php'; ?>

    <!-- HERO SECTION - DYNAMIC -->
    <section class="hero">
        <h1 class="display-1 display-md-2 display-sm-3" data-aos="fade-down">
            <?php echo htmlspecialchars($hero_data['hero_title']); ?>
        </h1>
        <p class="lead lead-sm" data-aos="fade-up" data-aos-delay="200">
            <?php echo htmlspecialchars($hero_data['hero_subtitle']); ?>
        </p>
    </section>

    <!-- GALLERY SECTION - DYNAMIC -->
    <div class="container">
        <?php if (empty($gallery_images)): ?>
            <!-- No images found -->
            <div class="no-images" data-aos="fade-up">
                <i class="bi bi-images"></i>
                <h3>No Gallery Images Found</h3>
                <p class="text-muted">Please check back later for updated gallery content.</p>
            </div>
        <?php else: ?>
            <!-- Display gallery images -->
            <div class="row g-4">
                <?php 
                $delay = 0;
                foreach ($gallery_images as $index => $image): 
                    // Calculate delay for animation (0, 100, 200, then repeat)
                    $current_delay = ($index % 3) * 100;
                ?>
                    <div class="col-12 col-sm-6 col-md-4" data-aos="zoom-in" data-aos-delay="<?php echo $current_delay; ?>">
                        <div class="gallery-card">
                            <a href="<?php echo htmlspecialchars($image['image']); ?>" class="glightbox" data-gallery="galore-gallery">
                                <img src="<?php echo htmlspecialchars($image['image']); ?>" 
                                     alt="<?php echo htmlspecialchars($image['alt_text']); ?>" 
                                     class="img-fluid"
                                     loading="lazy">
                                <div class="gallery-overlay"><?php echo htmlspecialchars($image['overlay_text']); ?></div>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <?php include 'footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- AOS JS -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    
    <!-- GLightbox JS -->
    <script src="https://cdn.jsdelivr.net/gh/mcstudios/glightbox/dist/js/glightbox.min.js"></script>

    <script>
        // Initialize AOS
        AOS.init({
            duration: 1200,
            once: true,
            offset: 100
        });

        // Initialize GLightbox
        const lightbox = GLightbox({
            selector: '.glightbox',
            touchNavigation: true,
            loop: true,
            zoomable: true,
            draggable: true,
            openEffect: 'zoom',
            closeEffect: 'zoom',
            slideEffect: 'slide'
        });
    </script>

</body>

</html>