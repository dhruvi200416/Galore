<!DOCTYPE html>
<html lang="en">

<head>
  <title>Galore – Animated Page with Carousel</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- AOS CSS for scroll animations -->
  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

  <style>
    :root {
      --galore-red: #dc3545;
      --galore-red-dark: #b02a37;
      --galore-bg: #f8f9fa;
      --galore-dark: #212529;
      --galore-gray: #6c757d;
      --galore-white: #ffffff;
    }

    body {
      margin: 0;
      padding: 0;
      font-family: "Segoe UI", Arial, sans-serif;
      background: linear-gradient(135deg, #ffffff 0%, #fff5f5 40%, #f8f9fa 100%);
    }

    .header-content {
      text-align: center;
      margin-bottom: 60px;
    }

    .header-content h2 {
      font-size: 2.2rem;
      color: var(--galore-red);
      font-weight: 700;
    }

    .header-content p {
      color: var(--galore-gray);
      font-weight: 500;
    }

    .underline {
      width: 60px;
      height: 4px;
      background: linear-gradient(135deg, var(--galore-red), var(--galore-red-dark));
      margin: 12px auto;
      border-radius: 10px;
    }

    .about-image img {
      width: 100%;
      border-radius: 16px;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
      transition: transform 0.5s ease;
    }

    .about-image img:hover {
      transform: scale(1.06);
    }

    .about-text h3 {
      font-weight: 700;
      margin-bottom: 15px;
    }

    .about-text h3 span {
      color: var(--galore-red);
    }

    .about-text p {
      color: #444;
      line-height: 1.7;
    }

    /* ================= CAROUSEL ================= */
    #fastCarousel {
      margin-top: 10%;
      width: 100%;
      height: 70vh;
      overflow: hidden;
    }

    #fastCarousel .carousel-inner,
    #fastCarousel .carousel-item {
      height: 100%;
    }

    #fastCarousel .carousel-item img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 1s ease;
    }

    /* ================= COORDINATOR AUTO SCROLL ================= */
    .coordinator-scroll-wrapper {
      overflow: hidden;
      position: relative;
      width: 100%;
      padding-bottom: 15px;
    }

    .coordinator-scroll.track {
      display: flex;
      gap: 20px;
      animation: scroll-left 25s linear infinite;
    }

    .coordinator-scroll.track:hover {
      animation-play-state: paused;
    }

    @keyframes scroll-left {
      0% {
        transform: translateX(0);
      }

      100% {
        transform: translateX(-50%);
      }
    }

    .coordinator-card {
      min-width: 260px;
      max-width: 260px;
      flex-shrink: 0;
    }

    .download-btn {
      display: inline-block;
      padding: 10px 25px;
      background: linear-gradient(135deg, #ff4d5a, var(--galore-red));
      color: white;
      text-decoration: none;
      border-radius: 25px;
      font-weight: 600;
      transition: all 0.3s ease;
    }

    .download-btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 10px 20px rgba(220, 53, 69, 0.3);
      color: white;
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

  // Fetch active carousel slides
  $carousel_query = "SELECT id, image, title, alt_text FROM carousel_slide 
                   WHERE status = 'Active' 
                   ORDER BY id ASC";
  $carousel_result = mysqli_query($con, $carousel_query);
  $slides = [];
  while ($row = mysqli_fetch_assoc($carousel_result)) {
    $slides[] = $row;
  }
  $slide_count = count($slides);

// Fetch active home info from database ONLY
$home_query = "SELECT heading, sub_heading FROM home_info 
               WHERE status = 'Active' 
               ORDER BY id ASC LIMIT 1";
$home_result = mysqli_query($con, $home_query);
$home_data = mysqli_fetch_assoc($home_result);
?>

  <!-- ================= DYNAMIC CAROUSEL ================= -->
  <br><br><br><br><br>
  <?php if ($slide_count > 0): ?>
    <div class="container-fluid p-0">
      <div id="galoreCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="3000">

        <!-- Indicators -->
        <?php if ($slide_count > 1): ?>
          <div class="carousel-indicators">
            <?php for ($i = 0; $i < $slide_count; $i++): ?>
              <button type="button"
                data-bs-target="#galoreCarousel"
                data-bs-slide-to="<?php echo $i; ?>"
                <?php echo $i === 0 ? 'class="active" aria-current="true"' : ''; ?>
                aria-label="Slide <?php echo $i + 1; ?>">
              </button>
            <?php endfor; ?>
          </div>
        <?php endif; ?>

        <!-- Slides -->
        <div class="carousel-inner">
          <?php foreach ($slides as $index => $slide): ?>
            <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
              <img src="<?php echo htmlspecialchars($slide['image']); ?>"
                class="d-block w-100"
                alt="<?php echo htmlspecialchars($slide['alt_text'] ?: $slide['title']); ?>"
                style="height: 600px; object-fit: cover;">

              <!-- Caption -->
              <?php if (!empty($slide['title'])): ?>
                <div class="carousel-caption d-none d-md-block">
                  <div class="bg-dark bg-opacity-50 p-4 rounded">
                    <h3 class="text-white"><?php echo htmlspecialchars($slide['title']); ?></h3>
                  </div>
                </div>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        </div>

        <!-- Controls -->
        <?php if ($slide_count > 1): ?>
          <button class="carousel-control-prev" type="button" data-bs-target="#galoreCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#galoreCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        <?php endif; ?>
      </div>
    </div>
    <br>

  <?php else: ?>
    <!-- Fallback when no active slides -->
    <!-- <div class="container my-5">
      <div class="alert alert-info text-center">
        <h4><i class="fas fa-images me-2"></i>Carousel Coming Soon!</h4>
        <p>Check back later for exciting Galore 2026 event images.</p>
      </div>
    </div> -->
  <?php endif; ?>


<?php
// Fetch active home events
$home_query = "SELECT heading, sub_heading FROM home_info 
WHERE status='Active' LIMIT 1";

$home_result = mysqli_query($con,$home_query);
$home_data = mysqli_fetch_assoc($home_result);


// ✅ ADD THIS QUERY
$events_query = "SELECT * FROM home_events WHERE status='Active' ORDER BY id ASC";
$events_result = mysqli_query($con,$events_query);

if(!$events_result){
die("Query Failed: ".mysqli_error($con));
}
?>
<!-- ================= ABOUT SECTION ================= -->
<section class="about-section">
<div class="container">

<!-- Dynamic Header -->
<?php if ($home_data): ?>
<div class="header-content" data-aos="fade-down">
<h2 class="h1 h2-sm"><?php echo htmlspecialchars($home_data['heading']); ?></h2>
<p class="lead"><?php echo htmlspecialchars($home_data['sub_heading']); ?></p>
<div class="underline"></div>
</div>
<?php endif; ?>


<?php
$counter = 0;

while($event = mysqli_fetch_assoc($events_result)):

$reverse = ($counter % 2 != 0) ? "flex-lg-row-reverse" : "";
?>

<div class="row align-items-center g-5 mb-5 <?php echo $reverse; ?>" data-aos="fade-up">

<!-- IMAGE -->
<div class="col-lg-6" data-aos="zoom-in">
<div class="about-image">
<img src="<?php echo htmlspecialchars($event['image']); ?>" 
alt="<?php echo htmlspecialchars($event['heading']); ?>" 
class="img-fluid">
</div>
</div>

<!-- TEXT -->
<div class="col-lg-6" data-aos="fade-left">
<div class="about-text">

<h3 class="h3 h4-sm">
<?php echo htmlspecialchars($event['heading']); ?>
</h3>

<p class="mb-4">
<?php echo htmlspecialchars($event['description']); ?>
</p>

<a href="<?php echo htmlspecialchars($event['button_link']); ?>" 
class="download-btn" 
data-aos="flip-up">

<?php echo htmlspecialchars($event['button_text']); ?>

</a>

</div>
</div>

</div>

<?php 
$counter++;
endwhile; 
?>

</div>
</section>

  <!-- ================= COORDINATOR SECTION ================= -->
   <?php
// Fetch Active Coordinators
$coordinator_query = "SELECT image, name, role, phone 
                      FROM home_coordinators 
                      WHERE status='Active' 
                      ORDER BY id ASC";

$coordinator_result = mysqli_query($con, $coordinator_query);

if(!$coordinator_result){
    die("Coordinator Query Failed: " . mysqli_error($con));
}
?>
 <div class="coordinator-scroll-wrapper">
<div class="coordinator-scroll track">

<?php while($coordinator = mysqli_fetch_assoc($coordinator_result)) { ?>

<div class="card coordinator-card shadow-sm">

<img src="<?php echo htmlspecialchars($coordinator['image']); ?>" 
class="card-img-top" 
alt="<?php echo htmlspecialchars($coordinator['name']); ?>">

<div class="card-body text-center">

<h5 class="card-title">
<?php echo htmlspecialchars($coordinator['name']); ?>
</h5>

<p class="card-text mb-1">
<?php echo htmlspecialchars($coordinator['role']); ?>
</p>

<small class="text-muted">
📞 <?php echo htmlspecialchars($coordinator['phone']); ?>
</small>

</div>
</div>

<?php } ?>

</div>
</div>

  <?php include 'footer.php'; ?>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- AOS JS -->
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
  <script>
    AOS.init({
      duration: 1200,
      once: true
    });
  </script>

  <!-- Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

</body>

</html>