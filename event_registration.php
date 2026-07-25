<?php
include 'event_register_handler.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Event Registration | RKU Galore</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
      font-family: 'Segoe UI', Roboto, sans-serif;
      margin: 0;
      min-height: 100vh;
      background: #f8f9fa;
    }

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

    .galore-wrapper {
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 60px 20px 80px;
    }

    .galore-card {
      background: #ffffff;
      width: 100%;
      max-width: 1000px;
      padding: 45px;
      border-radius: 18px;
      border-top: 6px solid var(--galore-red);
      box-shadow: 0 20px 45px rgba(220, 53, 69, 0.18);
      animation: fadeSlide 0.8s ease forwards;
    }

    @keyframes fadeSlide {
      from {
        opacity: 0;
        transform: translateY(40px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .galore-title {
      text-align: center;
      color: var(--galore-red);
      font-size: 2.2rem;
      margin-bottom: 10px;
    }

    .galore-deadline {
      text-align: center;
      font-size: 0.9rem;
      font-weight: 600;
      color: var(--galore-red);
      background: rgba(220, 53, 69, 0.1);
      padding: 6px 16px;
      border-radius: 20px;
      display: inline-block;
      margin: 0 auto 35px;
    }

    .alert {
      border-radius: 10px;
      margin-bottom: 20px;
      padding: 15px 20px;
    }

    .alert-success {
      background-color: #d4edda;
      border-color: #c3e6cb;
      color: #155724;
    }

    .alert-danger {
      background-color: #f8d7da;
      border-color: #f5c6cb;
      color: #721c24;
    }

    .galore-input-group {
      display: flex;
      flex-direction: column;
      margin-bottom: 15px;
      position: relative;
    }

    .galore-label {
      font-size: 0.75rem;
      font-weight: 700;
      color: var(--galore-gray);
      margin-bottom: 6px;
      text-transform: uppercase;
    }

    .galore-input {
      padding: 13px 15px;
      border: 2px solid #ddd;
      border-radius: 10px;
      font-size: 0.95rem;
      transition: all 0.3s ease;
      width: 100%;
    }

    .galore-input:focus {
      outline: none;
      border-color: var(--galore-red);
      box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.15);
    }

    .galore-btn {
      background: linear-gradient(135deg, #ff4d5a, var(--galore-red));
      color: #fff;
      padding: 15px;
      border: none;
      border-radius: 12px;
      font-size: 1.05rem;
      font-weight: bold;
      cursor: pointer;
      margin-top: 10px;
      transition: all 0.3s ease;
      width: 100%;
    }

    .galore-btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 12px 30px rgba(220, 53, 69, 0.45);
    }

    .galore-footer {
      text-align: center;
      margin-top: 25px;
      font-size: 0.85rem;
      color: var(--galore-red);
      font-weight: 600;
      padding-top: 18px;
      border-top: 1px solid rgba(220, 53, 69, 0.25);
    }

    .phone-input-container {
      position: relative;
      display: flex;
      align-items: center;
    }

    .country-code {
      position: absolute;
      left: 15px;
      color: var(--galore-gray);
      font-weight: 600;
      font-size: 0.95rem;
      pointer-events: none;
      z-index: 1;
    }

    .phone-input {
      padding-left: 70px !important;
    }

    .section {
      background: #f8f9fa;
      border-radius: 15px;
      padding: 25px;
      margin: 20px 0;
      border: 2px solid rgba(220, 53, 69, 0.1);
    }

    .section h3 {
      color: var(--galore-red);
      font-size: 1.5rem;
      margin-bottom: 20px;
      font-weight: 700;
      border-bottom: 2px solid var(--galore-red);
      padding-bottom: 10px;
    }

    .participation-box {
      background: white;
      border-radius: 12px;
      padding: 20px;
      margin-bottom: 25px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
      border-left: 4px solid var(--galore-red);
    }

    .participation-box strong {
      color: var(--galore-dark);
      font-size: 1.2rem;
      margin-bottom: 15px;
      display: block;
    }

    .participation-events {
      display: flex;
      flex-wrap: wrap;
      gap: 12px;
    }

    .event-chip {
      display: inline-flex;
      align-items: center;
      padding: 10px 20px;
      background: #f8f9fa;
      border: 2px solid #dee2e6;
      border-radius: 30px;
      cursor: pointer;
      transition: all 0.3s ease;
      font-size: 0.95rem;
      user-select: none;
    }

    .event-chip:hover {
      background: rgba(220, 53, 69, 0.1);
      border-color: var(--galore-red);
    }

    .event-chip input[type="checkbox"] {
      margin-right: 8px;
      accent-color: var(--galore-red);
    }

    .event-chip:has(input:checked) {
      background: var(--galore-red);
      border-color: var(--galore-red);
      color: white;
    }

    .team-badge {
      background: #ffc107;
      color: #212529;
      padding: 3px 10px;
      border-radius: 20px;
      font-size: 0.7rem;
      font-weight: 600;
      margin-left: 8px;
    }

    @media (max-width: 768px) {
      .hero h1 {
        font-size: 2.2rem;
      }
      .galore-card {
        padding: 25px;
      }
      .participation-events {
        gap: 8px;
      }
      .event-chip {
        padding: 8px 15px;
        font-size: 0.85rem;
      }
    }
  </style>
</head>

<body>

  <?php 
  if (file_exists('navbar.php')) {
      include 'navbar.php'; 
  }
  ?>

  <section class="hero">
    <h1><?php echo htmlspecialchars($hero_title); ?></h1>
    <p><?php echo htmlspecialchars($hero_subtitle); ?></p>
  </section>

  <div class="galore-wrapper">
    <div class="galore-card">

      <h2 class="galore-title">🎪 Event Registration</h2>
      <div class="galore-deadline">Last Date: 15 January 2026</div>

      <?php if (!empty($success_message)): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <i class="fas fa-check-circle me-2"></i> <?php echo htmlspecialchars($success_message); ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>

      <?php if (!empty($error_message)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <i class="fas fa-exclamation-circle me-2"></i> <?php echo htmlspecialchars($error_message); ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>

      <!-- IMPORTANT: Form action points to itself -->
      <form id="eventRegistrationForm" action="event_registration.php" method="POST">
        
        <div class="section">
          <h3><i class="fas fa-user-circle me-2"></i>Personal Details</h3>
          <div class="row g-3">
            <div class="col-md-6">
              <div class="galore-input-group">
                <label class="galore-label">Enrollment No *</label>
                <input type="text" name="enrollment_no" class="galore-input" 
                  value="<?php echo htmlspecialchars($user_data['enrollment_no'] ?? ''); ?>" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="galore-input-group">
                <label class="galore-label">Full Name *</label>
                <input type="text" name="full_name" class="galore-input" 
                  value="<?php echo htmlspecialchars($user_data['full_name'] ?? ''); ?>" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="galore-input-group">
                <label class="galore-label">Email *</label>
                <input type="email" name="email" class="galore-input" 
                  value="<?php echo htmlspecialchars($user_data['email'] ?? ''); ?>" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="galore-input-group">
                <label class="galore-label">Phone Number *</label>
                <div class="phone-input-container">
                  <span class="country-code">+91</span>
                  <input type="tel" name="phone" class="galore-input phone-input" maxlength="10"
                    value="<?php echo htmlspecialchars($user_data['phone'] ?? ''); ?>" required>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="galore-input-group">
                <label class="galore-label">Branch *</label>
                <input type="text" name="branch" class="galore-input" 
                  value="<?php echo htmlspecialchars($user_data['branch'] ?? ''); ?>" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="galore-input-group">
                <label class="galore-label">Semester *</label>
                <select name="semester" class="galore-input" required>
                  <option value="">Select Semester</option>
                  <?php for($i = 1; $i <= 8; $i++): ?>
                    <option value="<?php echo $i; ?>" <?php echo (($user_data['semester'] ?? '') == $i) ? 'selected' : ''; ?>>
                      Semester <?php echo $i; ?>
                    </option>
                  <?php endfor; ?>
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="galore-input-group">
                <label class="galore-label">School *</label>
                <input type="text" name="school" class="galore-input" 
                  value="<?php echo htmlspecialchars($user_data['school'] ?? ''); ?>" required>
              </div>
            </div>
          </div>
        </div>

        <div class="section">
          <h3><i class="fas fa-calendar-alt me-2"></i>Select Events <span class="text-danger">*</span></h3>
          
          <div class="participation-box">
            <strong>Sports – Outdoor</strong>
            <div class="participation-events">
              <label class="event-chip"><input type="checkbox" name="events[]" value="Cricket" <?php echo in_array('Cricket', $existing_outdoor) ? 'checked' : ''; ?>> Cricket <span class="team-badge">Team</span></label>
              <label class="event-chip"><input type="checkbox" name="events[]" value="Volleyball" <?php echo in_array('Volleyball', $existing_outdoor) ? 'checked' : ''; ?>> Volleyball <span class="team-badge">Team</span></label>
              <label class="event-chip"><input type="checkbox" name="events[]" value="Basketball" <?php echo in_array('Basketball', $existing_outdoor) ? 'checked' : ''; ?>> Basketball <span class="team-badge">Team</span></label>
              <label class="event-chip"><input type="checkbox" name="events[]" value="Dodgeball" <?php echo in_array('Dodgeball', $existing_outdoor) ? 'checked' : ''; ?>> Dodgeball <span class="team-badge">Team</span></label>
            </div>
          </div>

          <div class="participation-box">
            <strong>Sports – Indoor</strong>
            <div class="participation-events">
              <label class="event-chip"><input type="checkbox" name="events[]" value="Carrom" <?php echo in_array('Carrom', $existing_indoor) ? 'checked' : ''; ?>> Carrom</label>
              <label class="event-chip"><input type="checkbox" name="events[]" value="Duo Carrom" <?php echo in_array('Duo Carrom', $existing_indoor) ? 'checked' : ''; ?>> Duo Carrom <span class="team-badge">Team</span></label>
              <label class="event-chip"><input type="checkbox" name="events[]" value="Chess" <?php echo in_array('Chess', $existing_indoor) ? 'checked' : ''; ?>> Chess</label>
              <label class="event-chip"><input type="checkbox" name="events[]" value="Table Tennis" <?php echo in_array('Table Tennis', $existing_indoor) ? 'checked' : ''; ?>> Table Tennis</label>
              <label class="event-chip"><input type="checkbox" name="events[]" value="Duo Table Tennis" <?php echo in_array('Duo Table Tennis', $existing_indoor) ? 'checked' : ''; ?>> Duo Table Tennis <span class="team-badge">Team</span></label>
            </div>
          </div>

          <div class="participation-box">
            <strong>Cultural</strong>
            <div class="participation-events">
              <label class="event-chip"><input type="checkbox" name="events[]" value="Drawing" <?php echo in_array('Drawing', $existing_cultural) ? 'checked' : ''; ?>> Drawing</label>
              <label class="event-chip"><input type="checkbox" name="events[]" value="Singing" <?php echo in_array('Singing', $existing_cultural) ? 'checked' : ''; ?>> Singing</label>
              <label class="event-chip"><input type="checkbox" name="events[]" value="Public Speaking" <?php echo in_array('Public Speaking', $existing_cultural) ? 'checked' : ''; ?>> Public Speaking</label>
              <label class="event-chip"><input type="checkbox" name="events[]" value="Rangoli" <?php echo in_array('Rangoli', $existing_cultural) ? 'checked' : ''; ?>> Rangoli</label>
              <label class="event-chip"><input type="checkbox" name="events[]" value="Solo Dance" <?php echo in_array('Solo Dance', $existing_cultural) ? 'checked' : ''; ?>> Solo Dance</label>
              <label class="event-chip"><input type="checkbox" name="events[]" value="Duo Dance" <?php echo in_array('Duo Dance', $existing_cultural) ? 'checked' : ''; ?>> Duo Dance <span class="team-badge">Team</span></label>
              <label class="event-chip"><input type="checkbox" name="events[]" value="Group Dance" <?php echo in_array('Group Dance', $existing_cultural) ? 'checked' : ''; ?>> Group Dance <span class="team-badge">Team</span></label>
            </div>
          </div>
        </div>

        <button type="submit" name="register_events" class="galore-btn">
          <i class="fas fa-check-circle me-2"></i>Register for Selected Events
        </button>
      </form>

      <div class="galore-footer">
        * Select at least one event - Team events require additional information
      </div>
    </div>
  </div>

  <?php 
  if (file_exists('footer.php')) {
      include 'footer.php'; 
  }
  ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>

</body>

</html>

<?php
// Close database connection
if (isset($con) && $con) {
    mysqli_close($con);
}
?>