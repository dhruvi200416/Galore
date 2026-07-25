<?php 
require_once 'admin_header.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard | RKU Galore</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --galore-red: #dc3545;
            --galore-gray: #6c757d;
            --galore-dark: #333;
        }

        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .upload-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 90vh;
            padding: 40px 20px;
            margin-left: 20%;
        }

        .upload-card {
            background: #ffffff;
            width: 100%;
            max-width: 700px;
            padding: 50px;
            border-radius: 18px;
            border-top: 6px solid var(--galore-red);
            box-shadow: 0 20px 45px rgba(220, 53, 69, 0.18);
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .upload-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 55px rgba(220, 53, 69, 0.25);
        }

        .upload-header {
            margin-bottom: 35px;
        }

        .upload-header h2 {
            color: var(--galore-red);
            font-size: 2.2rem;
            font-weight: 800;
            margin-bottom: 10px;
        }

        .upload-header p {
            color: var(--galore-gray);
            font-size: 0.95rem;
            margin-bottom: 0;
        }

        .upload-icon {
            font-size: 4rem;
            color: var(--galore-red);
            margin-bottom: 20px;
        }

        .file-input-wrapper {
            position: relative;
            margin: 30px 0;
        }

        .custom-file-upload {
            display: inline-block;
            padding: 18px 25px;
            background: linear-gradient(135deg, #f8f9fa, #ffffff);
            border: 2px dashed var(--galore-red);
            border-radius: 12px;
            cursor: pointer;
            width: 100%;
            text-align: left;
            color: var(--galore-gray);
            transition: all 0.3s ease;
            font-size: 1rem;
        }

        .custom-file-upload:hover {
            background: linear-gradient(135deg, #ffffff, #fff5f5);
            border-color: #b02a37;
            transform: translateY(-2px);
        }

        .custom-file-upload i {
            margin-right: 12px;
            color: var(--galore-red);
            font-size: 1.2rem;
        }

        #file-name {
            font-weight: 500;
            color: var(--galore-dark);
        }

        input[type="file"] {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            cursor: pointer;
        }

        .btn-upload {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #ff4d5a, var(--galore-red));
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s ease;
            margin-top: 10px;
        }

        .btn-upload:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(220, 53, 69, 0.35);
        }

        .btn-upload:active {
            transform: translateY(0);
        }

        .msg {
            margin-top: 25px;
            padding: 12px;
            border-radius: 10px;
            background: #d4edda;
            color: #155724;
            font-weight: 500;
            display: inline-block;
            width: 100%;
        }

        .error-msg {
            margin-top: 25px;
            padding: 12px;
            border-radius: 10px;
            background: #f8d7da;
            color: #721c24;
            font-weight: 500;
            display: inline-block;
            width: 100%;
        }

        .csv-format-hint {
            margin-top: 25px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 10px;
            text-align: left;
            border-left: 4px solid var(--galore-red);
        }

        .csv-format-hint h6 {
            color: var(--galore-red);
            font-weight: bold;
            margin-bottom: 10px;
        }

        .csv-format-hint small {
            color: #6c757d;
            font-size: 0.75rem;
        }

        .csv-format-hint code {
            background: #e9ecef;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 0.7rem;
            color: var(--galore-red);
        }

        .badge-info {
            background: #e9ecef;
            color: #495057;
            padding: 5px 10px;
            border-radius: 8px;
            font-size: 0.8rem;
            margin-top: 10px;
            display: inline-block;
        }
    </style>
</head>

<body>
    <div class="upload-wrapper">
        <div class="upload-card">
            <div class="upload-header">
                <div class="upload-icon">
                    <i class="bi bi-filetype-csv"></i>
                </div>
                <h2>Upload CSV Data</h2>
                <p>Import bulk data for Admin, Coordinator, and Co-coordinator from CSV file</p>
                <div class="badge-info">
                    <i class="bi bi-info-circle"></i> CSV format required - All rows will be imported
                </div>
            </div>

            <!-- FIXED FORM - Removed JavaScript conflicts -->
            <form method="POST" action="ad_excel_upload_handler.php" enctype="multipart/form-data">
                <div class="file-input-wrapper">
                    <div class="custom-file-upload">
                        <i class="bi bi-cloud-upload"></i>
                        <span id="file-name">Choose CSV file...</span>
                    </div>
                    <input type="file" name="csv_file" accept=".csv" required>
                </div>

                <button type="submit" name="upload" class="btn-upload">
                    <i class="bi bi-upload"></i> Upload & Sync Data
                </button>
            </form>

            <!-- Display messages from session -->
            <?php
            if (isset($_SESSION['upload_msg'])) {
                echo '<div class="msg"><i class="bi bi-check-circle-fill"></i> ' . $_SESSION['upload_msg'] . '</div>';
                unset($_SESSION['upload_msg']);
            }
            if (isset($_SESSION['upload_error'])) {
                echo '<div class="error-msg"><i class="bi bi-exclamation-triangle-fill"></i> ' . $_SESSION['upload_error'] . '</div>';
                unset($_SESSION['upload_error']);
            }
            ?>

            <div class="csv-format-hint">
                <h6><i class="bi bi-filetype-csv"></i> CSV Format Requirements:</h6>
                <small>Your CSV file must have <strong class="highlight">9 columns</strong> in this exact order:</small>
                <div class="mt-2">
                    <code>1. ID</code>
                    <code>2. Full Name</code>
                    <code>3. Email</code>
                    <code>4. Phone</code>
                    <code>5. Branch</code>
                    <code>6. Gender</code>
                    <code>7. Role</code>
                    <code>8. School</code>
                    <code>9. Password</code>
                </div>
                <div class="mt-3 pt-2 border-top">
                    <small class="text-success d-block">
                        <i class="bi bi-check-circle"></i> <strong>Auto-filled fields (not needed in CSV):</strong>
                    </small>
                    <small class="text-muted d-block mt-1">
                        • <strong>Status</strong> - Will be set to 'active' automatically<br>
                        • <strong>Profile Picture</strong> - Will be set to default/empty
                    </small>
                </div>
                <small class="text-warning mt-2 d-block">
                    <i class="bi bi-exclamation-triangle"></i> Note: The first row (header) will be automatically skipped
                </small>
            </div>
        </div>
    </div>

    <!-- Simplified JavaScript without conflicting submit handlers -->
    <script>
        // Simple file name display only - NO form submission interference
        const fileInput = document.querySelector('input[type="file"]');
        const fileNameSpan = document.getElementById('file-name');
        
        if (fileInput) {
            fileInput.addEventListener('change', function(e) {
                const fileName = e.target.files[0] ? e.target.files[0].name : 'Choose CSV file...';
                fileNameSpan.textContent = fileName;
                
                const fileInputWrapper = document.querySelector('.custom-file-upload');
                if (e.target.files[0]) {
                    if (fileName.toLowerCase().endsWith('.csv')) {
                        fileInputWrapper.style.borderColor = '#28a745';
                        fileInputWrapper.style.background = 'linear-gradient(135deg, #f0fff4, #ffffff)';
                    } else {
                        fileInputWrapper.style.borderColor = '#dc3545';
                        fileInputWrapper.style.background = 'linear-gradient(135deg, #fff5f5, #ffffff)';
                        alert('Please select a .csv file');
                        this.value = '';
                        fileNameSpan.textContent = 'Choose CSV file...';
                    }
                } else {
                    fileInputWrapper.style.borderColor = '#dc3545';
                    fileInputWrapper.style.background = 'linear-gradient(135deg, #f8f9fa, #ffffff)';
                }
            });
        }
    </script>
</body>

</html>