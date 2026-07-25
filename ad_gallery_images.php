<?php
include 'ad_gallery_images_handler.php';
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

    <!-- FORM + TABLE CSS (No media queries) -->
    <style>
        :root {
            --galore-red: #dc3545;
            --galore-gray: #6c757d;
            --galore-dark: #333;
            --glass: rgba(255, 255, 255, 0.05);
        }

        /* ADD BUTTON */
        .btn-add-image {
            background: linear-gradient(135deg, #ff4d5a, var(--galore-red));
            color: #fff;
            padding: 15px 22px;
            border: none;
            border-radius: 12px;
            font-size: 1.05rem;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s ease;
        }

        .btn-add-image:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(220, 53, 69, 0.45);
        }

        /* FORM */
        .add-image-form-container {
            background: #ffffff;
            width: 100%;
            max-width: 900px;
            margin: 30px auto;
            padding: 45px;
            border-radius: 18px;
            border-top: 6px solid var(--galore-red);
            box-shadow: 0 20px 45px rgba(220, 53, 69, 0.18);
        }

        .form-title {
            text-align: center;
            color: var(--galore-red);
            font-size: 2.2rem;
            margin-bottom: 25px;
            font-weight: 800;
        }

        #imageForm {
            display: grid;
            grid-template-columns: 1fr;
            gap: 18px;
        }

        @media (min-width: 768px) {
            #imageForm {
                grid-template-columns: 1fr 1fr;
            }

            .full-width {
                grid-column: span 2;
            }

            .form-buttons {
                grid-column: span 2;
            }
        }

        .galore-input-group {
            display: flex;
            flex-direction: column;
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
        }

        .galore-textarea {
            padding: 13px 15px;
            border: 2px solid #ddd;
            border-radius: 10px;
            font-size: 0.95rem;
            min-height: 120px;
            resize: vertical;
        }

        .galore-input:focus,
        .galore-textarea:focus {
            outline: none;
            border-color: var(--galore-red);
            box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.15);
        }

        /* Image preview styling - MATCHING FIRST CODE */
        .image-preview-container {
            margin-top: 10px;
            text-align: center;
        }

        .preview-img {
            max-width: 100px;
            max-height: 100px;
            border-radius: 8px;
            border: 3px solid var(--galore-red);
            object-fit: cover;
        }

        .file-input-wrapper {
            position: relative;
        }

        .custom-file-upload {
            display: inline-block;
            padding: 13px 15px;
            background: #f8f9fa;
            border: 2px solid #ddd;
            border-radius: 10px;
            cursor: pointer;
            width: 100%;
            text-align: left;
            color: var(--galore-gray);
        }

        .custom-file-upload i {
            margin-right: 8px;
            color: var(--galore-red);
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

        /* Validation Styles */
        .error-message {
            font-size: 0.8rem;
            margin-top: 0.25rem;
            display: block;
            color: #dc3545 !important;
            animation: fadeIn 0.3s ease-in;
            min-height: 20px;
        }

        .is-valid {
            border-color: #198754 !important;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23198754' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
            padding-right: calc(1.5em + 0.75rem);
        }

        .is-invalid {
            border-color: #dc3545 !important;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
            padding-right: calc(1.5em + 0.75rem);
        }

        .is-valid:focus {
            border-color: #198754 !important;
            box-shadow: 0 0 0 4px rgba(25, 135, 84, 0.15) !important;
            outline: none;
        }

        .is-invalid:focus {
            border-color: #dc3545 !important;
            box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.15) !important;
            outline: none;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-5px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-buttons {
            display: flex;
            justify-content: center;
            gap: 12px;
        }

        .btn-save {
            background: linear-gradient(135deg, #ff4d5a, var(--galore-red));
            color: white;
            padding: 15px 22px;
            border-radius: 12px;
            font-weight: bold;
            border: none;
        }

        .btn-cancel {
            background: #6c757d;
            color: white;
            padding: 15px 22px;
            border-radius: 12px;
            font-weight: bold;
            border: none;
        }

        /* TABLE CONTAINER WITH RED BORDER */
        .data-table-container {
            background: #ffffff;
            padding: 30px;
            border-radius: 18px;
            border-top: 6px solid var(--galore-red);
            box-shadow: 0 20px 45px rgba(220, 53, 69, 0.18);
            margin-top: 30px;
            width: 100%;
            overflow-x: auto;
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .table-header h2 {
            color: var(--galore-red);
            font-size: 1.8rem;
            font-weight: 700;
            margin: 0;
        }

        .search-box {
            position: relative;
            min-width: 300px;
        }

        .search-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--galore-gray);
            font-size: 1rem;
        }

        .search-box input {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border: 2px solid #e0e0e0;
            border-radius: 50px;
            font-size: 0.95rem;
            background-color: #f8f9fa;
            transition: all 0.3s ease;
        }

        .search-box input:focus {
            outline: none;
            border-color: var(--galore-red);
            box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.15);
            background-color: #ffffff;
        }

        .search-box input::placeholder {
            color: #999;
            font-style: italic;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table thead {
            background: rgba(220, 53, 69, 0.1);
        }

        .data-table th {
            padding: 15px;
            text-align: left;
            font-weight: 700;
            color: var(--galore-red);
            border-bottom: 2px solid var(--galore-red);
        }

        .data-table td {
            padding: 15px;
            border-bottom: 1px solid #dee2e6;
            vertical-align: middle;
        }

        .data-table tbody tr:hover {
            background: rgba(220, 53, 69, 0.1);
        }

        /* ACTION BUTTONS */
        .action-btn {
            padding: 8px 15px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
            margin-right: 8px;
            margin-bottom: 5px;
        }

        .action-btn:last-child {
            margin-right: 0;
        }

        .action-btn:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        .main-content {
            padding: 30px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .top-bar {
            background: #ffffff;
            padding: 25px;
            border-radius: 18px;
            border-top: 6px solid var(--galore-red);
            box-shadow: 0 20px 45px rgba(220, 53, 69, 0.18);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .top-bar h1 {
            color: var(--galore-red);
            font-size: 2rem;
            font-weight: 800;
            margin: 0;
        }

        /* PAGINATION */
        .pagination-container {
            margin-top: 25px;
            display: flex;
            justify-content: center;
        }

        .pagination .page-link {
            color: var(--galore-red);
            border: 1px solid #dee2e6;
            margin: 0 2px;
            border-radius: 8px;
            padding: 8px 15px;
        }

        .pagination .active .page-link {
            background: var(--galore-red);
            color: white;
            border-color: var(--galore-red);
        }

        .pagination .page-item.disabled .page-link {
            color: #6c757d;
            background: #f8f9fa;
        }

        /* IMAGE PREVIEW - ORIGINAL HOVER EFFECT */
        .gallery-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid #ddd;
            transition: transform 0.3s ease;
            cursor: pointer;
        }

        .gallery-img:hover {
            transform: scale(2);
            z-index: 10;
            position: relative;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }

        .preview-container {
            position: relative;
            display: inline-block;
        }

        .image-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 5px;
            font-size: 0.75rem;
            text-align: center;
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
        }

        /* CENTERED MODAL CONTENT */
        .modal-dialog-centered {
            display: flex;
            align-items: center;
            min-height: calc(100% - 3.5rem);
        }

        .modal-content {
            width: 100%;
        }

        .modal-body {
            text-align: center;
        }

        .modal-body img {
            max-height: 400px;
            width: auto;
            margin: 0 auto;
            display: block;
        }

        .modal-body p {
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

    <?php require 'admin_header.php'; ?>

    <main class="main-content">

        <div class="top-bar d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3" id="topBar">
            <h1 class="mb-0" id="pageTitle">Gallery Images Management</h1>
            <button class="btn-add-image" id="openFormBtn">
                <i class="bi bi-plus-circle"></i> Add Gallery Image
            </button>
        </div>

        <!-- FORM -->
        <div class="add-image-form-container" id="addImageForm" style="display:none;">
            <h3 class="form-title" id="formTitleText">Add Gallery Image</h3>

            <form id="imageForm" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="edit_id" id="edit_id" value="">

                <div class="galore-input-group full-width">
                    <label class="galore-label">Upload Image <span class="text-danger" id="imageRequired">*</span></label>
                    <div class="file-input-wrapper">
                        <div class="custom-file-upload">
                            <i class="bi bi-camera"></i>
                            <span id="file-name">Choose file...</span>
                        </div>
                        <input type="file" name="image" class="galore-input" accept="image/jpeg, image/png, image/jpg, image/gif" id="imageUpload" data-validation="required">
                    </div>
                    <span id="image_error" class="error-message"></span>
                    <div class="image-preview-container" id="imagePreviewContainer" style="margin-top: 15px; display: none;">
                        <img id="imagePreview" class="preview-img" src="#" alt="Preview">
                    </div>
                    <small class="text-muted mt-1" id="imageHelpText">Leave empty to keep existing image when editing</small>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Overlay Text <span class="text-danger">*</span></label>
                    <input type="text" name="overlay_text" class="galore-input" data-validation="required min" data-min="3" data-max="100" placeholder="Text shown on image hover (e.g., Football, Dance)">
                    <span id="overlay_text_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Alt Text <span class="text-danger">*</span></label>
                    <input type="text" name="alt_text" class="galore-input" data-validation="required min" data-min="3" data-max="200" placeholder="Alternative text for accessibility">
                    <span id="alt_text_error" class="error-message"></span>
                </div>

                <div class="form-buttons full-width" id="formButtons">
                    <button type="submit" name="submit" class="btn-save">Save Image</button>
                    <button type="button" class="btn-cancel" id="cancelForm">Cancel</button>
                </div>

            </form>
        </div>

        <!-- TABLE -->
        <div class="data-table-container">

            <div class="table-header" id="tableHeader">
                <h2 class="mb-0">Gallery Images Data</h2>

                <div class="search-box" id="searchBox">
                    <i class="bi bi-search"></i>
                    <input type="text" id="searchInput" placeholder="Search images...">
                </div>
            </div>

            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Overlay Text</th>
                            <th>Alt Text</th>
                            <th id="actionsHeader">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="imagesTableBody"></tbody>
                </table>
            </div>

            <div class="pagination-container">
                <ul class="pagination" id="pagination"></ul>
            </div>
        </div>

    </main>

    <!-- VIEW MODAL - CENTERED (No footer close button) -->
    <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" style="border-radius:18px;border-top:6px solid var(--galore-red);">
                <div class="modal-header text-white" style="background:var(--galore-red);">
                    <h5 class="modal-title fw-bold">Image Full Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="mb-4 d-flex justify-content-center align-items-center" style="min-height: 300px;">
                        <img id="v_image" src="" alt="" class="img-fluid rounded" style="max-height: 400px; max-width: 100%;">
                    </div>
                    <div class="text-start">
                        <p><b>ID:</b> <span id="v_id"></span></p>
                        <p><b>Overlay Text:</b> <span id="v_overlay_text"></span></p>
                        <p><b>Alt Text:</b> <span id="v_alt_text"></span></p>
                        <p><b>Image URL:</b> <br><small id="v_image_url" class="text-muted"></small></p>
                    </div>
                </div>
                <!-- Modal footer removed - only close button in header remains -->
            </div>
        </div>
    </div>

    <!-- SCRIPTS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Use PHP to pass database images to JavaScript
        let imagesData = <?php echo json_encode($imagesData); ?>;

        // If no images in database, use empty array
        if (!imagesData || imagesData.length === 0) {
            imagesData = [];
        }

        const rowsPerPage = 5;
        let currentPage = 1;
        let editId = null; // Track editing row
        let isEditing = false; // Track if we're in edit mode
        let currentImageFile = null; // Store current image file
        let currentImageData = null; // Store current image data for preview

        const addImageForm = $("#addImageForm");
        const formTitleText = $("#formTitleText");
        const imageUpload = $("#imageUpload");
        const imagePreview = $("#imagePreview");
        const imagePreviewContainer = $("#imagePreviewContainer");
        const imageRequired = $("#imageRequired");
        const imageHelpText = $("#imageHelpText");
        const fileNameSpan = $("#file-name");

        // Open form button
        $("#openFormBtn").click(() => {
            formTitleText.text("Add Gallery Image");
            editId = null;
            isEditing = false;
            $("#edit_id").val("");
            $("#imageForm")[0].reset();
            currentImageFile = null;
            currentImageData = null;
            imagePreviewContainer.hide();
            fileNameSpan.text("Choose file...");
            
            // Update UI for add mode - make image required
            imageRequired.text("*");
            imageHelpText.hide();
            
            // Clear validation classes and error messages
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");
            addImageForm.slideDown();
        });

        // Cancel form button
        $("#cancelForm").click(() => {
            addImageForm.slideUp();
            $("#imageForm")[0].reset();
            $("#edit_id").val("");
            // Clear validation classes and error messages
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");
            editId = null;
            isEditing = false;
            currentImageFile = null;
            currentImageData = null;
            imagePreviewContainer.hide();
            fileNameSpan.text("Choose file...");
        });

        // File upload handling
        imageUpload.on('change', function(e) {
            const file = e.target.files[0];
            const fileName = file ? file.name : "Choose file...";
            fileNameSpan.text(fileName);
            
            if (file) {
                currentImageFile = file;
                
                // Preview image
                const reader = new FileReader();
                reader.onload = function(e) {
                    currentImageData = e.target.result;
                    imagePreview.attr('src', currentImageData);
                    imagePreviewContainer.show();
                    
                    // Trigger validation for file input
                    $(imageUpload).trigger('change');
                }
                reader.readAsDataURL(file);
            } else {
                currentImageFile = null;
                currentImageData = null;
                imagePreviewContainer.hide();
            }
            validateInput(this);
        });

        // Render table with pagination - USING CORRECT CLASS NAMES
        function renderTable() {
            let tbody = $("#imagesTableBody");
            tbody.html("");

            const searchValue = $("#searchInput").val().toLowerCase();
            const filteredData = imagesData.filter(img =>
                img.overlay_text.toLowerCase().includes(searchValue) ||
                img.alt_text.toLowerCase().includes(searchValue)
            );

            const start = (currentPage - 1) * rowsPerPage;
            const paginatedData = filteredData.slice(start, start + rowsPerPage);

            if (paginatedData.length === 0) {
                tbody.append(`
                    <tr>
                        <td colspan="5" class="text-center py-4">
                            <i class="bi bi-inbox fs-1 d-block mb-3" style="color: #ddd;"></i>
                            <h5 style="color: #999;">No data found</h5>
                        </td>
                    </tr>
                `);
            } else {
                paginatedData.forEach(img => {
                    tbody.append(`
                        <tr>
                            <td>${img.id}</td>
                            <td>
                                <div class="preview-container">
                                    <img src="${img.image}" alt="${img.alt_text}" class="gallery-img">
                                    ${img.overlay_text ? `<div class="image-overlay">${img.overlay_text}</div>` : ''}
                                </div>
                            </td>
                            <td>${img.overlay_text || '-'}</td>
                            <td>${img.alt_text}</td>
                            <td>
                                <button class="action-btn btn-view" onclick="viewImage(${img.id})">View</button>
                                <button class="action-btn btn-edit" onclick="editImage(${img.id})">Edit</button>
                                <button class="action-btn btn-delete" onclick="deleteImage(${img.id})">Delete</button>
                            </td>
                        </tr>
                    `);
                });
            }

            renderPagination(filteredData.length);
        }

        // Render pagination controls
        function renderPagination(totalRows) {
            let totalPages = Math.ceil(totalRows / rowsPerPage);
            let pagination = $("#pagination");
            pagination.html("");

            if (totalPages === 0) {
                pagination.html('<li class="page-item disabled"><a class="page-link">No data</a></li>');
                return;
            }

            // Previous Button
            pagination.append(`
                <li class="page-item ${currentPage === 1 ? "disabled" : ""}">
                    <a class="page-link" href="#" onclick="goPage(${currentPage - 1})">Previous</a>
                </li>
            `);

            // Page Numbers
            for (let i = 1; i <= totalPages; i++) {
                pagination.append(`
                    <li class="page-item ${i === currentPage ? "active" : ""}">
                        <a class="page-link" href="#" onclick="goPage(${i})">${i}</a>
                    </li>
                `);
            }

            // Next Button
            pagination.append(`
                <li class="page-item ${currentPage === totalPages ? "disabled" : ""}">
                    <a class="page-link" href="#" onclick="goPage(${currentPage + 1})">Next</a>
                </li>
            `);
        }

        // Navigate to page
        function goPage(page) {
            const searchValue = $("#searchInput").val().toLowerCase();
            const filteredData = imagesData.filter(img =>
                img.overlay_text.toLowerCase().includes(searchValue) ||
                img.alt_text.toLowerCase().includes(searchValue)
            );
            const totalPages = Math.ceil(filteredData.length / rowsPerPage);
            if (page < 1 || page > totalPages) return;
            currentPage = page;
            renderTable();
        }

        // View image details
        function viewImage(id) {
            let img = imagesData.find(x => x.id == id);
            $("#v_id").text(img.id);
            $("#v_overlay_text").text(img.overlay_text || 'No overlay text');
            $("#v_alt_text").text(img.alt_text);
            $("#v_image").attr('src', img.image).attr('alt', img.alt_text);
            $("#v_image_url").text(img.image);
            
            // Create and show modal
            const viewModal = new bootstrap.Modal(document.getElementById('viewModal'));
            viewModal.show();
        }

        // Delete image
        function deleteImage(id) {
            if (confirm("Are you sure you want to delete this image?")) {
                window.location.href = "?delete_id=" + id;
            }
        }

        // Edit image
        function editImage(id) {
            editId = id;
            isEditing = true;
            const img = imagesData.find(x => x.id == id);
            formTitleText.text("Edit Image");
            $("#edit_id").val(id);
            
            // Set form values
            $('input[name="overlay_text"]').val(img.overlay_text || '');
            $('input[name="alt_text"]').val(img.alt_text);
            
            // Show current image
            if (img.image) {
                imagePreview.attr('src', img.image);
                imagePreviewContainer.show();
                currentImageData = img.image;
                fileNameSpan.text("Current image loaded");
            }
            
            // Update UI for edit mode - make image optional
            imageRequired.text("(Optional)");
            imageHelpText.show();
            
            // Clear validation classes and error messages
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");
            
            addImageForm.slideDown();
        }

        // Search functionality
        $("#searchInput").on("keyup", function() {
            currentPage = 1;
            renderTable();
        });

        // VALIDATION SCRIPT
        function validateInput(input) {
            var field = $(input);
            var value = field.val() ? field.val().trim() : "";
            var errorfield = $("#" + field.attr("name") + "_error");
            var validationType = field.data("validation");
            var minLength = field.data("min") || 0;
            var maxLength = field.data("max") || 9999;
            let errorMessage = "";
            var isFileInput = field.attr("type") === "file";

            if (validationType) {
                // Skip required validation for image when editing
                if (field.attr("name") === "image" && isEditing) {
                    errorfield.text("");
                    field.removeClass("is-invalid").addClass("is-valid");
                    return true;
                }
                
                if (validationType.includes("required")) {
                    if (isFileInput) {
                        // For file input, check if we're in edit mode
                        if (!isEditing && (!field[0].files || field[0].files.length === 0)) {
                            errorMessage = "This field is required.";
                        }
                    } else if (value === "" || value === "0" || value === null) {
                        errorMessage = "This field is required.";
                    }
                }

                if (value !== "" && !errorMessage && !isFileInput) {
                    if (validationType.includes("min") && value.length < minLength) {
                        errorMessage = `This field must be at least ${minLength} characters long.`;
                    }

                    if (validationType.includes("max") && value.length > maxLength) {
                        errorMessage = `This field must be at most ${maxLength} characters long.`;
                    }
                }

                if (errorMessage) {
                    errorfield.text(errorMessage);
                    field.addClass("is-invalid").removeClass("is-valid");
                    return false;
                } else {
                    errorfield.text("");
                    field.removeClass("is-invalid").addClass("is-valid");
                    return true;
                }
            }
            return true;
        }

        $("input, textarea, select").on("input change", function() {
            validateInput(this);
        });

        // Special handling for file input
        $("#imageUpload").on("change", function() {
            var field = $(this);
            var errorfield = $("#image_error");
            
            if (isEditing) {
                // When editing, file is optional
                if (this.files && this.files.length > 0) {
                    errorfield.text("");
                    field.addClass("is-valid").removeClass("is-invalid");
                } else {
                    // No file selected when editing is fine - clear any errors
                    errorfield.text("");
                    field.removeClass("is-invalid is-valid");
                }
            } else {
                // When adding new, file is required
                if (!this.files || this.files.length === 0) {
                    errorfield.text("This field is required.");
                    field.addClass("is-invalid").removeClass("is-valid");
                } else {
                    errorfield.text("");
                    field.addClass("is-valid").removeClass("is-invalid");
                }
            }
        });

        // Image form submission with validation
        $("#imageForm").on("submit", function(e) {
            let isValid = true;
            let firstInvalidField = null;

            $(this).find("input, textarea, select").each(function() {
                // Skip validation for image when editing
                if ($(this).attr("name") === "image" && isEditing) {
                    return true;
                }
                
                if (!validateInput(this)) {
                    isValid = false;
                    if (!firstInvalidField) {
                        firstInvalidField = this;
                    }
                }
            });

            // Special validation for image field when adding new
            if (!isEditing) {
                const imageField = $("#imageUpload");
                if (!imageField[0].files || imageField[0].files.length === 0) {
                    $("#image_error").text("This field is required.");
                    imageField.addClass("is-invalid").removeClass("is-valid");
                    isValid = false;
                    if (!firstInvalidField) {
                        firstInvalidField = imageField[0];
                    }
                }
            }

            if (!isValid) {
                e.preventDefault(); // Prevent form submission
                if (firstInvalidField) {
                    $(firstInvalidField).focus();
                }
                return false;
            }

            // If validation passes, allow form to submit normally
            return true;
        });

        // Initial render
        renderTable();
    </script>

</body>

</html>