<!DOCTYPE html>
<html lang="en">
<head>
  <title>Galore Enhanced Footer</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

  <style>
    /* Enhanced Footer Styling */
    .footer-section {
      background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
      color: #f8f9fa;
      font-family: 'Poppins', 'Segoe UI', Arial, sans-serif;
      position: relative;
      overflow: hidden;
    }

    /* Animated background pattern */
    .footer-section::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: radial-gradient(circle at 20% 50%, rgba(220, 53, 69, 0.03) 0%, transparent 50%);
      pointer-events: none;
    }

    .footer-title {
      font-weight: 700;
      font-size: 1.25rem;
      color: #fff;
      margin-bottom: 1.5rem;
      position: relative;
      letter-spacing: 0.5px;
      text-transform: uppercase;
    }

    .footer-title::after {
      content: '';
      display: block;
      width: 60px;
      height: 4px;
      background: linear-gradient(90deg, #dc3545, #ff6b6b);
      margin-top: 10px;
      margin-bottom: 15px;
      border-radius: 2px;
      transition: width 0.3s ease;
    }

    .footer-title:hover::after {
      width: 100px;
    }

    .footer-link {
      color: #e0e0e0;
      text-decoration: none;
      display: inline-block;
      margin-bottom: 12px;
      transition: all 0.3s ease;
      position: relative;
      padding-left: 0;
    }

    .footer-link::before {
      content: '→';
      position: absolute;
      left: -20px;
      opacity: 0;
      transition: all 0.3s ease;
      color: #dc3545;
    }

    .footer-link:hover {
      color: #dc3545;
      padding-left: 20px;
    }

    .footer-link:hover::before {
      opacity: 1;
      left: 0;
    }

    .footer-social {
      display: flex;
      gap: 15px;
      margin-top: 1rem;
    }

    .footer-social .social-link {
      color: #fff;
      text-decoration: none;
      font-weight: 500;
      transition: all 0.3s ease;
      width: 40px;
      height: 40px;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 1.1rem;
    }

    .footer-social .social-link:hover {
      background: #dc3545;
      transform: translateY(-5px);
      box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
    }

    .footer-divider {
      border: none;
      height: 1px;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
      margin: 30px 0 20px;
    }

    /* Contact info styling */
    .contact-info {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 15px;
      color: #e0e0e0;
      transition: transform 0.3s ease;
    }

    .contact-info i {
      width: 30px;
      color: #dc3545;
      font-size: 1.2rem;
    }

    .contact-info:hover {
      transform: translateX(5px);
      color: #fff;
    }

    /* Newsletter section */
    .newsletter-input {
      background: rgba(255, 255, 255, 0.1);
      border: 1px solid rgba(255, 255, 255, 0.2);
      color: #fff;
      padding: 10px 15px;
      border-radius: 25px;
      width: 100%;
      transition: all 0.3s ease;
    }

    .newsletter-input:focus {
      outline: none;
      border-color: #dc3545;
      background: rgba(255, 255, 255, 0.15);
      box-shadow: 0 0 15px rgba(220, 53, 69, 0.3);
    }

    .newsletter-input::placeholder {
      color: rgba(255, 255, 255, 0.6);
    }

    .newsletter-btn {
      background: #dc3545;
      color: #fff;
      border: none;
      padding: 10px 25px;
      border-radius: 25px;
      font-weight: 500;
      transition: all 0.3s ease;
      cursor: pointer;
      width: 100%;
      margin-top: 10px;
    }

    .newsletter-btn:hover {
      background: #c82333;
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(220, 53, 69, 0.4);
    }

    /* Copyright section */
    .copyright {
      text-align: center;
      padding: 1.5rem 0;
      position: relative;
      color: #a0a0a0;
      font-size: 0.95rem;
    }

    .copyright a {
      color: #dc3545;
      text-decoration: none;
      transition: color 0.3s ease;
    }

    .copyright a:hover {
      color: #ff6b6b;
      text-decoration: underline;
    }

    /* Pulse animation for footer */
    @keyframes pulse {
      0% {
        box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.4);
      }
      70% {
        box-shadow: 0 0 0 10px rgba(220, 53, 69, 0);
      }
      100% {
        box-shadow: 0 0 0 0 rgba(220, 53, 69, 0);
      }
    }

    /* Responsive adjustments */
    @media (max-width: 767px) {
      .footer-social {
        justify-content: center;
      }
      
      .contact-info {
        justify-content: center;
      }
      
      .footer-title {
        text-align: center;
      }
      
      .footer-title::after {
        margin-left: auto;
        margin-right: auto;
      }
      
      .footer-link {
        text-align: center;
        display: block;
      }
      
      .footer-link:hover {
        padding-left: 0;
      }
      
      .footer-link::before {
        display: none;
      }
    }

    /* Loading animation for footer entrance */
    .footer-section {
      animation: slideUp 0.8s ease-out;
    }

    @keyframes slideUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Hover effect for columns */
    .footer-section .col-md-4 {
      transition: transform 0.3s ease;
    }

    .footer-section .col-md-4:hover {
      transform: translateY(-5px);
    }

    /* Back to top button */
    .back-to-top {
      position: absolute;
      right: 30px;
      bottom: 30px;
      background: #dc3545;
      color: #fff;
      width: 45px;
      height: 45px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      text-decoration: none;
      transition: all 0.3s ease;
      opacity: 0;
      animation: fadeIn 0.5s ease forwards 1s;
    }

    .back-to-top:hover {
      background: #c82333;
      transform: translateY(-5px);
      box-shadow: 0 5px 15px rgba(220, 53, 69, 0.4);
    }

    @keyframes fadeIn {
      to {
        opacity: 1;
      }
    }
  </style>
</head>

<body>
  
<footer class="footer-section text-light pt-5">
  <div class="container position-relative">

    <div class="row g-4">

      <!-- About Galore -->
      <div class="col-md-4 mb-4">
        <h5 class="footer-title">About Galore</h5>
        <p class="mb-4" style="color: #e0e0e0; line-height: 1.8;">
          Galore is the most awaited Sports and Cultural Festival of RK University,
          bringing students together for competitions, performances, and celebrations of talent.
        </p>
        
        <!-- Newsletter Subscription -->
     
      </div>

      <!-- Quick Links -->
      <div class="col-md-4 mb-4">
        <h5 class="footer-title">Quick Links</h5>
        <ul class="list-unstyled">
          <li><a href="home.php" class="footer-link">About Galore</a></li>
          <li><a href="registration.php" class="footer-link">Registration</a></li>
          <li><a href="login.php" class="footer-link">Login</a></li>
          <li><a href="gallery.php" class="footer-link">Gallery</a></li>
          <li><a href="rules.php" class="footer-link">Rules</a></li>
        </ul>
      </div>

      <!-- Contact Info -->
      <div class="col-md-4 mb-4">
        <h5 class="footer-title">Contact Us</h5>
        
        <div class="contact-info">
          <i class="fas fa-envelope"></i>
          <span>rku.ac.in</span>
        </div>
        
        <div class="contact-info">
          <i class="fas fa-phone-alt"></i>
          <span>+91 98765 43210</span>
        </div>
        
        <div class="contact-info">
          <i class="fas fa-map-marker-alt"></i>
          <span>RK University, Rajkot, Gujarat, India - 360020</span>
        </div>

        <div class="footer-social mt-4">
          <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
          <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
          <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
          <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
          <a href="#" class="social-link"><i class="fab fa-youtube"></i></a>
        </div>
      </div>

    </div>

    <hr class="footer-divider">

    <div class="row align-items-center">
      <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
        <div class="copyright">
          &copy; 2026 <a href="#">Galore Festival</a>. All Rights Reserved.
        </div>
      </div>
      <div class="col-md-6 text-center text-md-end">
        <div class="copyright">
          Designed with by RK University
        </div>
      </div>
    </div>

  </div>

  <!-- Back to Top Button -->
  <a href="#" class="back-to-top" onclick="window.scrollTo({top: 0, behavior: 'smooth'}); return false;">
    <i class="fas fa-arrow-up"></i>
  </a>

</footer>


<!-- Bootstrap JS (optional, for some components) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function () {
  function validateInput(input) {
    var field = $(input);
    var value = field.val() ? field.val().trim() : "";
    var errorfield = $("#" + field.attr("name") + "_error");
    var validationType = field.data("validation");
    var minLength = field.data("min") || 0;
    var maxLength = field.data("max") || 9999;
    var fileSize = field.data("filesize") || 0;
    var fileType = field.data("filetype") || "";
    let errorMessage = "";
    var isFileInput = field.attr("type") === "file";
    var isCheckbox = field.attr("type") === "checkbox";

    if (validationType) {
      // Required field validation (all types)
      if (validationType.includes("required")) {
        if (isCheckbox) {
          if (!field.is(":checked")) {
            errorMessage = "You must accept the terms and conditions.";
          }
        } else if (isFileInput) {
          if (!field[0].files || field[0].files.length === 0) {
            errorMessage = "This field is required.";
          }
        } else if (value === "" || value === "0" || value === null) {
          errorMessage = "This field is required.";
        }
      }

      // Only continue with other validations if field has a value
      if (value !== "" && !errorMessage) {
        // Minimum length validation
        if (validationType.includes("min") && value.length < minLength) {
          errorMessage = `This field must be at least ${minLength} characters long.`;
        }

        // Maximum length validation
        if (validationType.includes("max") && value.length > maxLength) {
          errorMessage = `This field must be at most ${maxLength} characters long.`;
        }

        if(validationType.includes('alphabetic'))
        {
          alphabet_regex = /^[a-zA-Z\s]+$/;
          if(!alphabet_regex.test(value))
          {
            errorMessage = "Please enter alphabetic characters only.";
          }
        }

        // Email format validation
        if (validationType.includes("email")) {
          const emailRegex = /^[\w-\.]+@([\w-]+\.)+[\w]{2,4}$/;
          if (!emailRegex.test(value)) {
            errorMessage = "Please enter a valid email address.";
          }
        }

        // Numeric value validation
        if (validationType.includes("number")) {
          const numberRegex = /^[0-9]+$/;
          if (!numberRegex.test(value)) {
            errorMessage = "Please enter only numbers.";
          }
        }

        // Strong password validation (at least 8 chars, 1 upper, 1 lower, 1 number, 1 special)
        if (validationType.includes("strongPassword")) {
          const passwordRegex =
            /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
          if (!passwordRegex.test(value)) {
            errorMessage =
              "Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character.";
          }
        }

        // Password confirmation validation
        if (validationType.includes("confirmPassword")) {
          const confirmPassword = $("#" + field.attr("name") + "_confirm").val();
          if (value !== confirmPassword) {
            errorMessage = "Passwords do not match.";
          }
        }

        // Dropdown selection validation
        if (validationType.includes("select") && (value === "" || value === "0" || value === null)) {
          errorMessage = "Please select an option.";
        }
      }

      // File validations (only if file is selected)
      if (isFileInput && field[0].files && field[0].files.length > 0) {
        const file = field[0].files[0];
        
        // File size validation
        if (validationType.includes("fileSize")) {
          if (file.size > fileSize * 1024) {
            errorMessage = `File size must be less than ${fileSize}KB.`;
          }
        }

        // File type validation
        if (validationType.includes("fileType") && !errorMessage) {
          const fileExtension = file.name.split(".").pop().toLowerCase();
          const allowedExtensions = fileType
            .split(",")
            .map((ext) => ext.trim().toLowerCase());
          if (!allowedExtensions.includes(fileExtension)) {
            errorMessage = `File type must be ${fileType}.`;
          }
        }
      }

      if (errorMessage) {
        errorfield.text(errorMessage).show();
        field.addClass("is-invalid").removeClass("is-valid");
        errorfield.addClass("small text-danger");
        return false;
      } else {
        errorfield.text("").hide();
        field.removeClass("is-invalid").addClass("is-valid");
        return true;
      }
    }
    return true;
  }
  $("input, textarea, select").on("input change", function () {
    validateInput(this);
  });

  $("form").on("submit", function (e) {
    let isValid = true;
    $(this)
      .find("input, textarea, select")
      .each(function () {
        const fieldValid = validateInput(this);
        if (!fieldValid) {
          isValid = false;
        }
      });
    if (!isValid) {
      e.preventDefault();
      return false;
    }
  });
});
</script>

</body>
</html>