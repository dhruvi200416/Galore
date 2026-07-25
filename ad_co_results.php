<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | RKU Galore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <!-- jQuery (no validation plugin needed now) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <style>
        :root {
            --galore-red: #dc3545;
            --galore-red-dark: #b02a37;
            --galore-red-light: #f8d7da;
            --galore-gold: #ffc107;
            --galore-silver: #6c757d;
            --galore-bronze: #cd7f32;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', Roboto, sans-serif;
            background-color: #f8f9fa;
            padding-bottom: 50px;
        }

        /* Main wrapper to account for fixed sidebar (270px width) */
        .main-wrapper {
            margin-left: 270px;
            padding: 30px 30px 0 30px;
            max-width: calc(100% - 270px);
        }

        @media (max-width: 991.98px) {
            .main-wrapper {
                margin-left: 0;
                max-width: 100%;
                padding: 20px;
            }
        }

        /* ===== HERO SECTION ===== */
        .hero {
            background: linear-gradient(135deg, #dc3545, #7a1c25);
            color: #fff;
            text-align: center;
            padding: 60px 20px 60px;
            position: relative;
            overflow: hidden;
            margin-bottom: 30px;
            border-radius: 20px;
        }

        .hero::after {
            content: "";
            position: absolute;
            bottom: -60px;
            left: 0;
            width: 100%;
            height: 120px;
            background: #f8f9fa;
            border-radius: 50% 50% 0 0;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 900;
            letter-spacing: 2px;
            margin-bottom: 12px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .hero p {
            font-size: 1.2rem;
            opacity: 0.95;
            max-width: 600px;
            margin: 0 auto;
        }

        .hero-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            padding: 8px 25px;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 600;
            margin-top: 20px;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        /* ===== RESULT CARDS ===== */
        .result-card {
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(220, 53, 69, 0.15);
            transition: transform 0.4s, box-shadow 0.4s;
            cursor: pointer;
            border-top: 5px solid var(--galore-red);
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .result-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(220, 53, 69, 0.35);
        }

        .result-card-body {
            padding: 35px;
            text-align: center;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .result-card-body h4 {
            color: var(--galore-red);
            font-weight: 700;
            margin-bottom: 15px;
            font-size: 1.8rem;
        }

        .result-card-body p {
            color: var(--galore-gray);
            margin-bottom: 20px;
        }

        .result-stats {
            display: flex;
            justify-content: space-around;
            margin: 20px 0;
            padding: 15px 0;
            border-top: 2px solid #f0f0f0;
            border-bottom: 2px solid #f0f0f0;
            background: #fafafa;
            border-radius: 8px;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--galore-red);
            line-height: 1.2;
        }

        .stat-label {
            font-size: 0.75rem;
            color: var(--galore-gray);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .result-btn {
            display: inline-block;
            margin-top: auto;
            padding: 12px 24px;
            border-radius: 30px;
            background: linear-gradient(135deg, var(--galore-red-dark), var(--galore-red));
            color: #fff !important;
            font-weight: 600;
            text-decoration: none;
            border: none;
            width: 100%;
            transition: all 0.3s ease;
            cursor: pointer;
            font-size: 1rem;
        }

        .result-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(220, 53, 69, 0.4);
        }

        .result-btn i {
            margin-right: 8px;
        }

        /* ===== ADD BUTTON ===== */
        .btn-add-result {
            background: linear-gradient(135deg, #ff4d5a, var(--galore-red));
            color: #fff;
            padding: 12px 25px;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s ease;
        }

        .btn-add-result:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(220, 53, 69, 0.45);
        }

        .btn-add-result i {
            margin-right: 8px;
        }

        /* ===== FORM ===== */
        .add-result-form-container {
            background: #ffffff;
            width: 100%;
            max-width: 800px;
            margin: 30px auto;
            padding: 40px;
            border-radius: 18px;
            border-top: 6px solid var(--galore-red);
            box-shadow: 0 20px 45px rgba(220, 53, 69, 0.18);
        }

        .form-title {
            text-align: center;
            color: var(--galore-red);
            font-size: 2rem;
            margin-bottom: 25px;
            font-weight: 800;
        }

        #resultForm {
            display: grid;
            grid-template-columns: 1fr;
            gap: 18px;
        }

        @media (min-width: 768px) {
            #resultForm {
                grid-template-columns: 1fr 1fr;
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
            padding: 12px 15px;
            border: 2px solid #ddd;
            border-radius: 10px;
            font-size: 0.95rem;
        }

        .galore-select {
            padding: 12px 15px;
            border: 2px solid #ddd;
            border-radius: 10px;
            font-size: 0.95rem;
            background-color: white;
        }

        .galore-input:focus,
        .galore-select:focus {
            outline: none;
            border-color: var(--galore-red);
            box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.15);
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
            padding: 12px 25px;
            border-radius: 12px;
            font-weight: 600;
            border: none;
            transition: 0.3s ease;
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(220, 53, 69, 0.3);
        }

        .btn-cancel {
            background: #6c757d;
            color: white;
            padding: 12px 25px;
            border-radius: 12px;
            font-weight: 600;
            border: none;
            transition: 0.3s ease;
        }

        .btn-cancel:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(108, 117, 125, 0.3);
        }

        /* ===== RECORDS SECTION ===== */
        .records-section {
            display: none;
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
            padding: 35px;
            margin: 50px 0;
            animation: slideIn 0.5s ease;
            border-top: 6px solid var(--galore-red);
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .table-title {
            color: var(--galore-red);
            font-weight: 700;
            font-size: 2rem;
            margin: 0;
            position: relative;
            padding-bottom: 10px;
        }

        .table-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 4px;
            background: var(--galore-red);
            border-radius: 2px;
        }

        .event-badge {
            background: var(--galore-red);
            color: white;
            padding: 10px 25px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1rem;
            box-shadow: 0 4px 10px rgba(220, 53, 69, 0.3);
        }

        .event-badge i {
            margin-right: 8px;
        }

        /* Table scroll container */
        .table-scroll-container {
            max-height: 500px;
            overflow-y: auto;
            border-radius: 12px;
            border: 1px solid #e9ecef;
        }

        /* Custom Scrollbar */
        .table-scroll-container::-webkit-scrollbar {
            width: 8px;
        }

        .table-scroll-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .table-scroll-container::-webkit-scrollbar-thumb {
            background: var(--galore-red);
            border-radius: 10px;
        }

        .table-scroll-container::-webkit-scrollbar-thumb:hover {
            background: var(--galore-red-dark);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        th {
            position: sticky;
            top: 0;
            background: var(--galore-red);
            color: white;
            padding: 15px;
            text-align: left;
            font-weight: 600;
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            z-index: 10;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #e9ecef;
            vertical-align: middle;
        }

        tbody tr:hover {
            background: var(--galore-red-light);
            transition: background 0.3s;
        }

        /* Rank Badges */
        .rank-badge {
            display: inline-block;
            padding: 6px 15px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            min-width: 120px;
            text-align: center;
        }

        .badge-winner {
            background: rgba(220, 53, 69, 0.15);
            color: var(--galore-red);
            border: 1px solid rgba(220, 53, 69, 0.3);
        }

        .badge-runner {
            background: rgba(108, 117, 125, 0.15);
            color: #6c757d;
            border: 1px solid rgba(108, 117, 125, 0.3);
        }

        .badge-second {
            background: rgba(255, 193, 7, 0.15);
            color: #ffc107;
            border: 1px solid rgba(255, 193, 7, 0.3);
        }

        /* School Badge */
        .school-badge {
            background: rgba(220, 53, 69, 0.1);
            color: var(--galore-red);
            padding: 6px 15px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-block;
            border: 1px solid rgba(220, 53, 69, 0.2);
        }

        /* ACTION BUTTONS */
        .action-btn {
            padding: 6px 12px;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.85rem;
            cursor: pointer;
            transition: 0.2s;
            margin-right: 5px;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            opacity: 0.9;
        }

        .btn-view {
            background: rgba(23, 162, 184, 0.1);
            color: #17a2b8;
        }

        .btn-view:hover {
            background: #17a2b8;
            color: white;
        }

        .btn-edit {
            background: rgba(255, 193, 7, 0.1);
            color: #ffc107;
        }

        .btn-edit:hover {
            background: #ffc107;
            color: white;
        }

        .btn-delete {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }

        .btn-delete:hover {
            background: #dc3545;
            color: white;
        }

        /* Filter Section */
        .filter-section {
            background: white;
            border-radius: 16px;
            padding: 25px;
            margin: 30px 0;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            align-items: center;
        }

        .filter-input {
            flex: 1;
            min-width: 250px;
            padding: 12px 18px;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            font-size: 0.95rem;
            transition: all 0.3s;
        }

        .filter-input:focus {
            outline: none;
            border-color: var(--galore-red);
            box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.1);
        }

        .filter-btn {
            padding: 12px 30px;
            background: var(--galore-red);
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 0.95rem;
        }

        .filter-btn:hover {
            background: var(--galore-red-dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
        }

        .filter-btn i {
            margin-right: 8px;
        }
    </style>
</head>

<body>
    <?php include 'ad_co_header.php'; ?>

    <!-- Main Wrapper to account for fixed sidebar -->
    <div class="main-wrapper">

        <!-- Result Cards Row -->
        <div class="row g-4 justify-content-center">
            <!-- Cricket Card -->
            <div class="col-lg-4 col-md-6">
                <div class="result-card">
                    <div class="result-card-body">
                        <h4>Cricket</h4>
                        <p>Cricket Tournament Results</p>
                        <div class="result-stats">
                            <div class="stat-item">
                                <div class="stat-number">2</div>
                                <div class="stat-label">Rankers</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number">2</div>
                                <div class="stat-label">Schools</div>
                            </div>
                        </div>
                        <button class="result-btn" onclick="viewResults('Cricket')">
                            <i class="bi bi-trophy-fill"></i> View Rankers
                        </button>
                    </div>
                </div>
            </div>

            <!-- Football Card -->
            <div class="col-lg-4 col-md-6">
                <div class="result-card">
                    <div class="result-card-body">
                        <h4>Football</h4>
                        <p>Football Tournament Results</p>
                        <div class="result-stats">
                            <div class="stat-item">
                                <div class="stat-number">2</div>
                                <div class="stat-label">Rankers</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number">2</div>
                                <div class="stat-label">Schools</div>
                            </div>
                        </div>
                        <button class="result-btn" onclick="viewResults('Football')">
                            <i class="bi bi-trophy-fill"></i> View Rankers
                        </button>
                    </div>
                </div>
            </div>

            <!-- Dance Card -->
            <div class="col-lg-4 col-md-6">
                <div class="result-card">
                    <div class="result-card-body">
                        <h4>Dance</h4>
                        <p>Dance Competition Results</p>
                        <div class="result-stats">
                            <div class="stat-item">
                                <div class="stat-number">3</div>
                                <div class="stat-label">Rankers</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number">3</div>
                                <div class="stat-label">Schools</div>
                            </div>
                        </div>
                        <button class="result-btn" onclick="viewResults('Dance')">
                            <i class="bi bi-trophy-fill"></i> View Rankers
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- RESULT FORM (Hidden by default) -->
        <div class="add-result-form-container" id="addResultForm" style="display:none;">
            <h3 class="form-title" id="resultFormTitle">Add New Result</h3>

            <form id="resultForm">
                <input type="hidden" name="result_id" id="resultId">

                <div class="galore-input-group">
                    <label class="galore-label">Position</label>
                    <select name="position" id="position" class="galore-select" data-validation="required select">
                        <option value="">Select Position</option>
                        <option value="1">1st - Winner</option>
                        <option value="2">2nd - Runner Up</option>
                        <option value="3">3rd - Second Runner Up</option>
                    </select>
                    <span id="position_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Student Name</label>
                    <input type="text" name="student_name" id="student_name" class="galore-input" placeholder="Enter student name" data-validation="required min alphabetic" data-min="3" data-max="50">
                    <span id="student_name_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">School</label>
                    <select name="school" id="school" class="galore-select" data-validation="required select">
                        <option value="">Select School</option>
                        <option value="SOE">SOE (Engineering)</option>
                        <option value="SOM">SOM (Management)</option>
                        <option value="SOP">SOP (Pharmacy)</option>
                        <option value="SOC">SOC (Commerce)</option>
                        <option value="SOS">SOS (Science)</option>
                    </select>
                    <span id="school_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Event</label>
                    <select name="event" id="event_name" class="galore-select" data-validation="required select">
                        <option value="">Select Event</option>
                        <option value="Cricket">Cricket</option>
                        <option value="Football">Football</option>
                        <option value="Dance">Dance</option>
                        <option value="Chess">Chess</option>
                        <option value="Basketball">Basketball</option>
                    </select>
                    <span id="event_error" class="error-message"></span>
                </div>

                <div class="form-buttons">
                    <button type="submit" class="btn-save">Save Result</button>
                    <button type="button" class="btn-cancel" id="cancelResultForm">Cancel</button>
                </div>
            </form>
        </div>

        <!-- Records Section -->
        <div id="recordsArea" class="records-section">
            <div class="table-header">
                <h2 id="tableTitle" class="table-title">
                    <i class="bi bi-trophy-fill me-2"></i>Results
                </h2>
                <div class="d-flex gap-3">
                    <button class="btn-add-result" id="openResultFormBtn">
                        <i class="bi bi-plus-circle"></i> Add Result
                    </button>
                    <span class="event-badge" id="eventBadge">
                        <i class="bi bi-trophy-fill me-2"></i><span id="resultCount">0</span> Results
                    </span>
                </div>
            </div>

            <!-- Filter Section inside Records -->
            <div class="filter-section mb-4">
                <input type="text" class="filter-input" id="searchInput" placeholder="Search by name, school, or event..." onkeyup="filterTable()">
                <select class="filter-input" id="eventFilter" onchange="filterTable()">
                    <option value="">All Events</option>
                    <option value="Cricket">Cricket</option>
                    <option value="Football">Football</option>
                    <option value="Dance">Dance</option>
                </select>
                <button class="filter-btn" onclick="resetFilters()">
                    <i class="bi bi-arrow-counterclockwise"></i> Reset
                </button>
            </div>

            <div class="table-scroll-container">
                <table class="table">
                    <thead id="tableHeader">
                        <!-- Headers will be dynamically generated -->
                    </thead>
                    <tbody id="resultRows">
                        <!-- Data will be populated by JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- VIEW MODAL (ONLY X BUTTON) -->
    <div class="modal fade" id="viewResultModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius:18px;border-top:6px solid var(--galore-red);">
                <div class="modal-header text-white" style="background:var(--galore-red);">
                    <h5 class="modal-title fw-bold">Result Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="resultDetails">
                    <!-- Details will be populated by JavaScript -->
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Complete result data from the original file
        let resultData = [{
                id: 1,
                pos: 1,
                name: "Rahul Sharma",
                school: "SOE",
                event: "Cricket",
                rank: "Winner"
            },
            {
                id: 2,
                pos: 2,
                name: "Vikram Das",
                school: "SOE",
                event: "Cricket",
                rank: "Runner Up"
            },
            {
                id: 3,
                pos: 1,
                name: "Arjun Singh",
                school: "SOE",
                event: "Football",
                rank: "Winner"
            },
            {
                id: 4,
                pos: 2,
                name: "Sneha Kapur",
                school: "SOM",
                event: "Football",
                rank: "Runner Up"
            },
            {
                id: 5,
                pos: 1,
                name: "Ananya Iyer",
                school: "SOP",
                event: "Dance",
                rank: "Winner"
            },
            {
                id: 6,
                pos: 2,
                name: "Priya Patel",
                school: "SOE",
                event: "Dance",
                rank: "Runner Up"
            },
            {
                id: 7,
                pos: 3,
                name: "Riya Shah",
                school: "SOM",
                event: "Dance",
                rank: "Second Runner Up"
            }
        ];

        let currentEvent = '';
        let currentRecords = [];
        let filteredRecords = [];
        let editResultId = null;

        const addResultForm = $("#addResultForm");
        const resultFormTitle = $("#resultFormTitle");

        // Open result form
        $("#openResultFormBtn").click(() => {
            resultFormTitle.text("Add New Result");
            editResultId = null;
            $("#resultForm")[0].reset();
            $("#resultId").val('');
            // Clear validation classes and error messages
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");
            addResultForm.slideDown();
        });

        // Cancel result form
        $("#cancelResultForm").click(() => {
            addResultForm.slideUp();
            $("#resultForm")[0].reset();
            $("#resultId").val('');
            editResultId = null;
            // Clear validation classes and error messages
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");
        });

        // Function to view results based on event
        function viewResults(eventName) {
            currentEvent = eventName;
            currentRecords = resultData.filter(r => r.event === eventName);
            filteredRecords = [...currentRecords];

            const tableSection = document.getElementById('recordsArea');
            const tableTitle = document.getElementById('tableTitle');
            const resultCount = document.getElementById('resultCount');
            const tableHeader = document.getElementById('tableHeader');

            // Set Title and Count
            tableTitle.innerHTML = `<i class="bi bi-trophy-fill me-2"></i>${eventName} - Results & Rankings`;
            resultCount.innerText = currentRecords.length;

            // Generate headers
            tableHeader.innerHTML = `
                <th>Position</th>
                <th>Student Name</th>
                <th>School</th>
                <th>Actions</th>
            `;

            // Show Section
            tableSection.style.display = 'block';

            // Render Table
            renderTable();

            // Smooth Scroll
            tableSection.scrollIntoView({
                behavior: 'smooth'
            });
        }

        // Render table
        function renderTable() {
            const tableBody = document.getElementById('resultRows');
            const totalRecords = filteredRecords.length;

            // Clear and Populate Table
            tableBody.innerHTML = "";

            if (filteredRecords.length === 0) {
                tableBody.innerHTML = `<tr><td colspan="4" class="text-center py-4">No records found</td></tr>`;
            } else {
                // Sort by position
                filteredRecords.sort((a, b) => a.pos - b.pos);

                filteredRecords.forEach(result => {
                    let badgeClass = '';
                    if (result.pos === 1) badgeClass = 'badge-winner';
                    else if (result.pos === 2) badgeClass = 'badge-runner';
                    else if (result.pos === 3) badgeClass = 'badge-second';

                    const row = `
                        <tr>
                            <td><span class="rank-badge ${badgeClass}">${result.rank}</span></td>
                            <td><strong>${result.name}</strong></td>
                            <td><span class="school-badge">${result.school}</span></td>
                            <td>
                                <button class="action-btn btn-view" onclick="viewResult(${result.id})"><i class="bi bi-eye"></i></button>
                                <button class="action-btn btn-edit" onclick="editResult(${result.id})"><i class="bi bi-pencil"></i></button>
                                <button class="action-btn btn-delete" onclick="deleteResult(${result.id})"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                    `;
                    tableBody.innerHTML += row;
                });
            }
        }

        // Filter table function
        function filterTable() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const eventFilter = document.getElementById('eventFilter').value;

            filteredRecords = currentRecords.filter(result => {
                const matchesSearch = result.name.toLowerCase().includes(searchTerm) ||
                    result.school.toLowerCase().includes(searchTerm);
                const matchesEvent = eventFilter === '' || result.event === eventFilter;
                return matchesSearch && matchesEvent;
            });

            renderTable();
        }

        // Reset filters
        function resetFilters() {
            document.getElementById('searchInput').value = '';
            document.getElementById('eventFilter').value = '';
            filteredRecords = [...currentRecords];
            renderTable();
        }

        // View result details
        function viewResult(id) {
            const result = resultData.find(r => r.id === id);
            const modalBody = document.getElementById('resultDetails');

            let badgeClass = '';
            if (result.pos === 1) badgeClass = 'badge-winner';
            else if (result.pos === 2) badgeClass = 'badge-runner';
            else if (result.pos === 3) badgeClass = 'badge-second';

            modalBody.innerHTML = `
                <div class="text-center mb-4">
                    <div style="width: 80px; height: 80px; background: #f8d7da; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                        <i class="bi bi-trophy-fill" style="font-size: 3rem; color: var(--galore-red);"></i>
                    </div>
                </div>
                <table class="table table-bordered">
                    <tr><th style="width: 40%">ID</th><td>#${result.id}</td></tr>
                    <tr><th>Position</th><td>${result.pos}</td></tr>
                    <tr><th>Rank</th><td><span class="rank-badge ${badgeClass}">${result.rank}</span></td></tr>
                    <tr><th>Student Name</th><td>${result.name}</td></tr>
                    <tr><th>School</th><td><span class="school-badge">${result.school}</span></td></tr>
                    <tr><th>Event</th><td>${result.event}</td></tr>
                </table>
            `;

            new bootstrap.Modal(document.getElementById('viewResultModal')).show();
        }

        // Edit result
        function editResult(id) {
            editResultId = id;
            const result = resultData.find(r => r.id === id);

            resultFormTitle.text("Edit Result");
            $("#resultId").val(result.id);
            $("#position").val(result.pos);
            $("#student_name").val(result.name);
            $("#school").val(result.school);
            $("#event_name").val(result.event);

            // Clear validation classes and error messages
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");

            addResultForm.slideDown();
        }

        // Delete result
        function deleteResult(id) {
            if (confirm('Are you sure you want to delete this result?')) {
                resultData = resultData.filter(r => r.id !== id);
                viewResults(currentEvent);
            }
        }

        // Helper function to get rank from position
        function getRankFromPosition(pos) {
            switch (parseInt(pos)) {
                case 1:
                    return "Winner";
                case 2:
                    return "Runner Up";
                case 3:
                    return "Second Runner Up";
                default:
                    return "";
            }
        }

        // VALIDATION SCRIPT
        $(document).ready(function() {
            function validateInput(input) {
                var field = $(input);
                var value = field.val() ? field.val().trim() : "";
                var errorfield = $("#" + field.attr("name") + "_error");
                var validationType = field.data("validation");
                var minLength = field.data("min") || 0;
                var maxLength = field.data("max") || 9999;
                let errorMessage = "";

                // Special handling for select elements
                if (field.is("select")) {
                    validationType = "required select";
                }

                if (validationType) {
                    if (validationType.includes("required")) {
                        if (value === "" || value === "0" || value === null) {
                            errorMessage = "This field is required.";
                        }
                    }

                    if (value !== "" && !errorMessage) {
                        if (validationType.includes("min") && value.length < minLength) {
                            errorMessage = `This field must be at least ${minLength} characters long.`;
                        }

                        if (validationType.includes("max") && value.length > maxLength) {
                            errorMessage = `This field must be at most ${maxLength} characters long.`;
                        }

                        // Add alphabetic validation
                        if (validationType.includes("alphabetic")) {
                            var alphabet_regex = /^[a-zA-Z\s]+$/;
                            if (!alphabet_regex.test(value)) {
                                errorMessage = "Please enter alphabetic characters only.";
                            }
                        }

                        if (validationType.includes("select") && (value === "" || value === "0" || value === null)) {
                            errorMessage = "Please select an option.";
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

            // Result form submission with validation
            $("#resultForm").on("submit", function(e) {
                e.preventDefault();
                let isValid = true;
                let firstInvalidField = null;

                $(this).find("input, textarea, select").each(function() {
                    if (!validateInput(this)) {
                        isValid = false;
                        if (!firstInvalidField) {
                            firstInvalidField = this;
                        }
                    }
                });

                if (!isValid) {
                    if (firstInvalidField) {
                        $(firstInvalidField).focus();
                    }
                    return false;
                }

                // Get form data
                const pos = parseInt($("#position").val());
                const rank = getRankFromPosition(pos);

                if (editResultId) {
                    // Update existing result
                    const index = resultData.findIndex(r => r.id === editResultId);
                    if (index !== -1) {
                        resultData[index] = {
                            id: editResultId,
                            pos: pos,
                            name: $("#student_name").val().trim(),
                            school: $("#school").val(),
                            event: $("#event_name").val(),
                            rank: rank
                        };
                    }
                    // alert("Result updated successfully!");
                } else {
                    // Add new result
                    const newId = resultData.length > 0 ? Math.max(...resultData.map(r => r.id)) + 1 : 1;
                    const newResult = {
                        id: newId,
                        pos: pos,
                        name: $("#student_name").val().trim(),
                        school: $("#school").val(),
                        event: $("#event_name").val(),
                        rank: rank
                    };
                    resultData.push(newResult);
                    // alert("Result added successfully!");
                }

                // Update current records based on current event
                if (currentEvent) {
                    currentRecords = resultData.filter(r => r.event === currentEvent);
                } else {
                    currentRecords = resultData;
                }

                filteredRecords = [...currentRecords];
                document.getElementById('resultCount').innerText = currentRecords.length;

                this.reset();
                $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
                $(".error-message").text("");
                addResultForm.slideUp();
                editResultId = null;
                renderTable();
            });
        });
    </script>

</body>

</html>