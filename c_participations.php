<!DOCTYPE html>
<html lang="en">

<head>
    <title>Engineering Participation - Galore 2026</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- AOS CSS -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <style>
        :root {
            --galore-red: #dc3545;
            --galore-red-dark: #b02a37;
            --galore-bg: #f8f9fa;
            --galore-dark: #212529;
            --galore-gray: #6c757d;
            --galore-white: #ffffff;
            --light-red: #f8d7da;
            --light-pink: #fff5f5;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: linear-gradient(135deg, #ffffff 0%, #fff5f5 40%, #f8f9fa 100%);
            color: var(--galore-dark);
        }

        /* ===== HERO SECTION ===== */
        .hero {
            background: linear-gradient(135deg, var(--galore-red) 0%, var(--galore-red-dark) 100%);
            color: white;
            padding: 80px 0 60px;
            margin-bottom: 40px;
            position: relative;
            overflow: hidden;
            text-align: center;
        }

        .hero::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
            background-size: 40px 40px;
            opacity: 0.1;
        }

        .hero h1 {
            font-size: 2.8rem;
            font-weight: 700;
            margin-bottom: 15px;
            position: relative;
            z-index: 2;
        }

        .hero p {
            font-size: 1.2rem;
            opacity: 0.95;
            position: relative;
            z-index: 2;
        }

        /* ===== SCHOOL BADGE ===== */
        .school-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: white;
            color: var(--galore-red);
            padding: 12px 28px;
            border-radius: 50px;
            font-weight: 600;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .school-badge i {
            font-size: 1.3rem;
        }

        /* ===== STATS CARDS ===== */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            border-top: 4px solid var(--galore-red);
            text-align: center;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.12);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #fff5f5 0%, #ffe6e6 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
        }

        .stat-icon i {
            font-size: 1.8rem;
            color: var(--galore-red);
        }

        .stat-number {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--galore-dark);
            margin-bottom: 5px;
        }

        .stat-label {
            color: var(--galore-gray);
            font-size: 0.95rem;
        }

        /* ===== BRANCH CARDS ===== */
        .branch-selector {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--galore-red);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .branch-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }

        .branch-card {
            background: linear-gradient(135deg, #fff5f5 0%, #ffe6e6 100%);
            border-radius: 12px;
            padding: 20px 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            text-align: center;
        }

        .branch-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(220, 53, 69, 0.15);
            border-color: var(--galore-red);
        }

        .branch-card.active {
            background: linear-gradient(135deg, var(--galore-red) 0%, var(--galore-red-dark) 100%);
            border-color: var(--galore-red-dark);
        }

        .branch-card.active h5,
        .branch-card.active p,
        .branch-card.active i {
            color: white !important;
        }

        .branch-card i {
            font-size: 2rem;
            color: var(--galore-red);
            margin-bottom: 10px;
        }

        .branch-card h5 {
            font-weight: 700;
            margin-bottom: 5px;
            color: var(--galore-dark);
        }

        .branch-card p {
            color: var(--galore-gray);
            font-weight: 600;
            margin-bottom: 0;
        }

        /* ===== FILTER BADGES ===== */
        .filter-section {
            background: white;
            border-radius: 16px;
            padding: 20px 25px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
        }

        .filter-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }

        .filter-badge {
            padding: 8px 20px;
            border-radius: 50px;
            background: #f8f9fa;
            color: var(--galore-dark);
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .filter-badge:hover {
            background: #e9ecef;
        }

        .filter-badge.active {
            background: var(--galore-red);
            color: white;
            border-color: var(--galore-red);
        }

        /* ===== TABLE STYLES ===== */
        .table-container {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            margin-bottom: 40px;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background: linear-gradient(135deg, var(--galore-red) 0%, var(--galore-red-dark) 100%);
            color: white;
            font-weight: 600;
            padding: 15px;
            border: none;
        }

        .table td {
            padding: 15px;
            vertical-align: middle;
            border-bottom: 1px solid #e9ecef;
        }

        .table tbody tr:hover td {
            background: var(--light-pink);
        }

        /* ===== EDITABLE FIELDS ===== */
        .edit-input {
            width: 100%;
            padding: 8px 12px;
            border: 2px solid var(--galore-red);
            border-radius: 8px;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .edit-input:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.25);
        }

        .edit-select {
            width: 100%;
            padding: 8px 12px;
            border: 2px solid var(--galore-red);
            border-radius: 8px;
            font-size: 0.9rem;
            background-color: white;
        }

        .edit-select:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.25);
        }

        .editing-row {
            background-color: #fff9f9 !important;
        }

        .edit-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        /* ===== STATUS BADGES ===== */
        .status-badge {
            display: inline-block;
            padding: 6px 15px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            text-align: center;
            min-width: 100px;
        }

        .status-approved {
            background: rgba(40, 167, 69, 0.15);
            color: #28a745;
            border: 1px solid rgba(40, 167, 69, 0.3);
        }

        .status-pending {
            background: rgba(255, 193, 7, 0.15);
            color: #ffc107;
            border: 1px solid rgba(255, 193, 7, 0.3);
        }

        .status-rejected {
            background: rgba(220, 53, 69, 0.15);
            color: #dc3545;
            border: 1px solid rgba(220, 53, 69, 0.3);
        }

        /* ===== ACTION BUTTONS ===== */
        .btn-action-sm {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            margin: 0 3px;
        }

        .btn-view {
            background: rgba(0, 123, 255, 0.15);
            color: #007bff;
        }

        .btn-view:hover {
            background: #007bff;
            color: white;
            transform: scale(1.1);
        }

        .btn-edit {
            background: rgba(255, 193, 7, 0.15);
            color: #ffc107;
        }

        .btn-edit:hover {
            background: #ffc107;
            color: white;
            transform: scale(1.1);
        }

        .btn-save {
            background: linear-gradient(135deg, #28a745, #218838);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 8px 16px;
            font-size: 0.875rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(40, 167, 69, 0.3);
        }

        .btn-cancel {
            background: linear-gradient(135deg, #6c757d, #5a6268);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 8px 16px;
            font-size: 0.875rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-cancel:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(108, 117, 125, 0.3);
        }

        /* ===== MODAL STYLES ===== */
        .modal-content {
            border-radius: 16px;
            overflow: hidden;
        }

        .modal-header {
            background: linear-gradient(135deg, var(--galore-red) 0%, var(--galore-red-dark) 100%);
            color: white;
            padding: 20px;
        }

        .modal-header h5 {
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .modal-body {
            padding: 25px;
        }

        .detail-item {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
        }

        .detail-label {
            font-weight: 600;
            color: var(--galore-gray);
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        .detail-value {
            color: var(--galore-dark);
            font-weight: 500;
        }

        /* ===== EXPORT BUTTONS ===== */
        .export-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 20px;
        }

        .btn-export {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 20px;
            border-radius: 12px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            background: #f8f9fa;
            color: var(--galore-dark);
            border: 2px solid #dee2e6;
        }

        .btn-export:hover {
            background: var(--galore-red);
            color: white;
            border-color: var(--galore-red);
            transform: translateY(-3px);
        }
    </style>
</head>

<body>

    <?php include 'c_navbar.php'; ?>

    <!-- ===== HERO ===== -->
    <section class="hero">
        <div class="container">
            <h1 class="display-1 display-md-2 display-sm-3"><i class="fas fa-flask me-3"></i> Engineering School Participation</h1>
            <p class="lead lead-md lead-sm">School of Engineering & Technology • Branch-wise Student Participation Dashboard</p>
        </div>
    </section>

    <div class="container mb-5">

        <!-- ===== SCHOOL BADGE ===== -->
        <div class="d-flex justify-content-between align-items-center flex-wrap" data-aos="fade-up">
            <div class="school-badge">
                <i class="fas fa-university"></i>
                <span>School of Engineering • Coordinator: Dr. Rajesh Kumar</span>
            </div>
        </div>

        <!-- ===== BRANCH SELECTOR ===== -->
        <div class="branch-selector" data-aos="fade-up" data-aos-delay="150">
            <h3 class="section-title">
                <i class="fas fa-code-branch"></i>
                Filter by Engineering Branch
            </h3>
            <p class="text-muted mb-3">Select a branch to view student registrations</p>

            <div class="branch-grid">
                <div class="branch-card active" onclick="filterByBranch('all', this)">
                    <i class="fas fa-users"></i>
                    <h5>All Branches</h5>
                    <p>156 Students</p>
                </div>
                <div class="branch-card" onclick="filterByBranch('B.Tech', this)">
                    <i class="fas fa-laptop-code"></i>
                    <h5>B.Tech</h5>
                    <p>78 Students</p>
                </div>
                <div class="branch-card" onclick="filterByBranch('M.Tech', this)">
                    <i class="fas fa-microchip"></i>
                    <h5>M.Tech</h5>
                    <p>32 Students</p>
                </div>
                <div class="branch-card" onclick="filterByBranch('BCA', this)">
                    <i class="fas fa-database"></i>
                    <h5>BCA</h5>
                    <p>18 Students</p>
                </div>
                <div class="branch-card" onclick="filterByBranch('MCA', this)">
                    <i class="fas fa-cloud"></i>
                    <h5>MCA</h5>
                    <p>15 Students</p>
                </div>
                <div class="branch-card" onclick="filterByBranch('Diploma', this)">
                    <i class="fas fa-tools"></i>
                    <h5>Diploma</h5>
                    <p>13 Students</p>
                </div>
            </div>
        </div>

        <!-- ===== PARTICIPATION TABLE ===== -->
        <div class="table-container" data-aos="fade-up" data-aos-delay="250">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                <h3 class="section-title mb-0">
                    <i class="fas fa-clipboard-list"></i>
                    <span id="tableTitle">All Engineering Participants</span>
                </h3>
                <span class="status-badge status-approved" id="recordCount">156 Records</span>
            </div>

            <div class="table-responsive">
                <table class="table" id="participationTable">
                    <thead>
                        <tr id="tableHeader">
                            <th>ID</th>
                            <th>Student Name</th>
                            <th>Enrollment</th>
                            <th>Branch</th>
                            <th>Year</th>
                            <th>Event</th>
                            <th>Team</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <!-- Data will be loaded here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- View Details Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-id-card"></i> Student Participation Details
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="viewModalBody">
                    <!-- Content will be loaded here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-edit"></i> Edit Student Participation
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="editModalBody">
                    <!-- Content will be loaded here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" id="saveEditBtn">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

    <script>
        // Initialize AOS
        AOS.init({
            duration: 1000,
            once: true
        });

        // ==================== ENGINEERING STUDENTS DATA ====================
        let engineeringStudents = [
            // B.Tech Students
            { id: 1, name: "Rahul Sharma", enroll: "ENG24001", branch: "B.Tech", year: "3rd", event: "Cricket", team: "Warriors", status: "approved" },
            { id: 2, name: "Priya Patel", enroll: "ENG24002", branch: "B.Tech", year: "3rd", event: "Football", team: "Strikers", status: "approved" },
            { id: 3, name: "Amit Kumar", enroll: "ENG24003", branch: "B.Tech", year: "2nd", event: "Robotics", team: "Tech Titans", status: "pending" },
            { id: 4, name: "Neha Singh", enroll: "ENG24004", branch: "B.Tech", year: "4th", event: "Cultural", team: "Solo", status: "approved" },
            { id: 5, name: "Vikram Verma", enroll: "ENG24005", branch: "B.Tech", year: "3rd", event: "Cricket", team: "Warriors", status: "approved" },
            { id: 6, name: "Sneha Reddy", enroll: "ENG24006", branch: "B.Tech", year: "2nd", event: "Football", team: "Strikers", status: "pending" },
            { id: 7, name: "Arjun Nair", enroll: "ENG24007", branch: "B.Tech", year: "1st", event: "Robotics", team: "Innovators", status: "approved" },
            { id: 8, name: "Divya Menon", enroll: "ENG24008", branch: "B.Tech", year: "3rd", event: "Chess", team: "Individual", status: "rejected" },
            
            // M.Tech Students
            { id: 9, name: "Anjali Desai", enroll: "ENG24009", branch: "M.Tech", year: "1st", event: "Robotics", team: "AI Labs", status: "approved" },
            { id: 10, name: "Karthik Iyer", enroll: "ENG24010", branch: "M.Tech", year: "2nd", event: "Cricket", team: "Champions", status: "pending" },
            { id: 11, name: "Pooja Shah", enroll: "ENG24011", branch: "M.Tech", year: "1st", event: "Cultural", team: "Group", status: "approved" },
            { id: 12, name: "Rajan Gupta", enroll: "ENG24012", branch: "M.Tech", year: "2nd", event: "Football", team: "United", status: "approved" },
            
            // BCA Students
            { id: 13, name: "Meera Joshi", enroll: "ENG24013", branch: "BCA", year: "2nd", event: "Cultural", team: "Solo", status: "pending" },
            { id: 14, name: "Siddharth Rao", enroll: "ENG24014", branch: "BCA", year: "3rd", event: "Cricket", team: "Tigers", status: "approved" },
            { id: 15, name: "Kavya Sharma", enroll: "ENG24015", branch: "BCA", year: "1st", event: "Robotics", team: "CodeBreakers", status: "rejected" },
            
            // MCA Students
            { id: 16, name: "Rohit Mehta", enroll: "ENG24016", branch: "MCA", year: "2nd", event: "Football", team: "United", status: "approved" },
            { id: 17, name: "Tanvi Patel", enroll: "ENG24017", branch: "MCA", year: "1st", event: "Cultural", team: "Duet", status: "pending" },
            
            // Diploma Students
            { id: 18, name: "Sachin Yadav", enroll: "ENG24018", branch: "Diploma", year: "2nd", event: "Cricket", team: "Rookies", status: "approved" },
            { id: 19, name: "Riya Singh", enroll: "ENG24019", branch: "Diploma", year: "1st", event: "Football", team: "Kickers", status: "pending" },
            { id: 20, name: "Manoj Kumar", enroll: "ENG24020", branch: "Diploma", year: "3rd", event: "Chess", team: "Individual", status: "approved" },
            
            // More B.Tech Students
            { id: 21, name: "Chetan Bhagat", enroll: "ENG24021", branch: "B.Tech", year: "3rd", event: "Cricket", team: "Warriors", status: "approved" },
            { id: 22, name: "Nidhi Sharma", enroll: "ENG24022", branch: "B.Tech", year: "2nd", event: "Robotics", team: "Tech Titans", status: "pending" },
            { id: 23, name: "Prakash Raj", enroll: "ENG24023", branch: "B.Tech", year: "4th", event: "Football", team: "Strikers", status: "approved" },
            { id: 24, name: "Shreya Gupta", enroll: "ENG24024", branch: "B.Tech", year: "3rd", event: "Cultural", team: "Group", status: "rejected" },
            { id: 25, name: "Varun Dhawan", enroll: "ENG24025", branch: "B.Tech", year: "1st", event: "Cricket", team: "Warriors", status: "approved" }
        ];

        // Current filter state
        let currentFilters = {
            branch: 'all',
            status: 'all',
            event: 'all'
        };

        // Current editing student ID
        let currentEditId = null;

        // ==================== FILTER FUNCTIONS ====================
        
        // Filter by Branch
        function filterByBranch(branch, element) {
            document.querySelectorAll('.branch-card').forEach(card => {
                card.classList.remove('active');
            });
            element.classList.add('active');
            currentFilters.branch = branch;
            applyFilters();
        }

        // ==================== APPLY ALL FILTERS ====================
        function applyFilters() {
            let filteredData = [...engineeringStudents];
            
            if (currentFilters.branch !== 'all') {
                filteredData = filteredData.filter(s => s.branch === currentFilters.branch);
            }
            
            renderTable(filteredData);
            
            let title = currentFilters.branch === 'all' ? 'All Engineering' : currentFilters.branch;
            document.getElementById('tableTitle').textContent = `${title} Participants`;
            document.getElementById('recordCount').textContent = `${filteredData.length} Records`;
        }

        // ==================== RENDER TABLE ====================
        function renderTable(data) {
            const tbody = document.getElementById('tableBody');
            tbody.innerHTML = '';
            
            if (data.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="9" class="text-center py-5">
                            <i class="fas fa-search fa-3x mb-3" style="color: #dee2e6;"></i>
                            <h5 class="text-muted">No records found</h5>
                        </td>
                    </tr>
                `;
                return;
            }
            
            data.forEach(student => {
                const row = document.createElement('tr');
                row.id = `student-row-${student.id}`;
                row.innerHTML = `
                    <td><span class="fw-bold">ENG${student.id.toString().padStart(3, '0')}</span></td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div style="width: 35px; height: 35px; background: #fff5f5; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                                <span class="fw-bold" style="color: var(--galore-red);">${student.name.charAt(0)}${student.name.split(' ')[1]?.charAt(0) || student.name.charAt(1)}</span>
                            </div>
                            ${student.name}
                        </div>
                    </td>
                    <td>${student.enroll}</td>
                    <td><span class="badge" style="background: #e9ecef; color: var(--galore-dark); padding: 6px 12px;">${student.branch}</span></td>
                    <td>${student.year}</td>
                    <td>
                        <span class="badge" style="background: #fff5f5; color: var(--galore-red); padding: 6px 12px;">
                            ${student.event}
                        </span>
                    </td>
                    <td>${student.team}</td>
                    <td>
                        <span class="status-badge status-${student.status}">
                            ${student.status.charAt(0).toUpperCase() + student.status.slice(1)}
                        </span>
                    </td>
                    <td>
                        <button class="btn-action-sm btn-view" onclick="viewStudent(${student.id})" title="View Details">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn-action-sm btn-edit" onclick="editStudent(${student.id})" title="Edit">
                            <i class="fas fa-pencil-alt"></i>
                        </button>
                    </td>
                `;
                tbody.appendChild(row);
            });
        }

        // ==================== VIEW STUDENT DETAILS ====================
        function viewStudent(id) {
            const student = engineeringStudents.find(s => s.id === id);
            if (student) {
                const modalBody = document.getElementById('viewModalBody');
                modalBody.innerHTML = `
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="detail-item">
                                <div class="detail-label">Full Name</div>
                                <div class="detail-value">${student.name}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <div class="detail-label">Enrollment Number</div>
                                <div class="detail-value">${student.enroll}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <div class="detail-label">Branch</div>
                                <div class="detail-value">${student.branch}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <div class="detail-label">Year</div>
                                <div class="detail-value">${student.year}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <div class="detail-label">Event</div>
                                <div class="detail-value">${student.event}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <div class="detail-label">Team</div>
                                <div class="detail-value">${student.team}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <div class="detail-label">Status</div>
                                <div class="detail-value">
                                    <span class="status-badge status-${student.status}">
                                        ${student.status.charAt(0).toUpperCase() + student.status.slice(1)}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <div class="detail-label">Student ID</div>
                                <div class="detail-value">ENG${student.id.toString().padStart(3, '0')}</div>
                            </div>
                        </div>
                    </div>
                `;
                
                const viewModal = new bootstrap.Modal(document.getElementById('viewModal'));
                viewModal.show();
            }
        }

        // ==================== EDIT STUDENT ====================
        function editStudent(id) {
            const student = engineeringStudents.find(s => s.id === id);
            if (student) {
                currentEditId = id;
                
                const modalBody = document.getElementById('editModalBody');
                modalBody.innerHTML = `
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Full Name</label>
                            <input type="text" class="edit-input" id="editName" value="${student.name}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Enrollment Number</label>
                            <input type="text" class="edit-input" id="editEnroll" value="${student.enroll}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Branch</label>
                            <select class="edit-select" id="editBranch">
                                <option value="B.Tech" ${student.branch === 'B.Tech' ? 'selected' : ''}>B.Tech</option>
                                <option value="M.Tech" ${student.branch === 'M.Tech' ? 'selected' : ''}>M.Tech</option>
                                <option value="BCA" ${student.branch === 'BCA' ? 'selected' : ''}>BCA</option>
                                <option value="MCA" ${student.branch === 'MCA' ? 'selected' : ''}>MCA</option>
                                <option value="Diploma" ${student.branch === 'Diploma' ? 'selected' : ''}>Diploma</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Year</label>
                            <select class="edit-select" id="editYear">
                                <option value="1st" ${student.year === '1st' ? 'selected' : ''}>1st Year</option>
                                <option value="2nd" ${student.year === '2nd' ? 'selected' : ''}>2nd Year</option>
                                <option value="3rd" ${student.year === '3rd' ? 'selected' : ''}>3rd Year</option>
                                <option value="4th" ${student.year === '4th' ? 'selected' : ''}>4th Year</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Event</label>
                            <select class="edit-select" id="editEvent">
                                <option value="Cricket" ${student.event === 'Cricket' ? 'selected' : ''}>Cricket</option>
                                <option value="Football" ${student.event === 'Football' ? 'selected' : ''}>Football</option>
                                <option value="Robotics" ${student.event === 'Robotics' ? 'selected' : ''}>Robotics</option>
                                <option value="Cultural" ${student.event === 'Cultural' ? 'selected' : ''}>Cultural</option>
                                <option value="Chess" ${student.event === 'Chess' ? 'selected' : ''}>Chess</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Team</label>
                            <input type="text" class="edit-input" id="editTeam" value="${student.team}">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Status</label>
                            <select class="edit-select" id="editStatus">
                                <option value="approved" ${student.status === 'approved' ? 'selected' : ''}>Approved</option>
                                <option value="pending" ${student.status === 'pending' ? 'selected' : ''}>Pending</option>
                                <option value="rejected" ${student.status === 'rejected' ? 'selected' : ''}>Rejected</option>
                            </select>
                        </div>
                    </div>
                `;
                
                const editModal = new bootstrap.Modal(document.getElementById('editModal'));
                editModal.show();
                
                // Save button event listener
                document.getElementById('saveEditBtn').onclick = function() {
                    saveStudentEdit(id);
                };
            }
        }

        // ==================== SAVE STUDENT EDIT ====================
        function saveStudentEdit(id) {
            const student = engineeringStudents.find(s => s.id === id);
            if (student) {
                // Get updated values
                student.name = document.getElementById('editName').value;
                student.enroll = document.getElementById('editEnroll').value;
                student.branch = document.getElementById('editBranch').value;
                student.year = document.getElementById('editYear').value;
                student.event = document.getElementById('editEvent').value;
                student.team = document.getElementById('editTeam').value;
                student.status = document.getElementById('editStatus').value;
                
                // Close modal
                bootstrap.Modal.getInstance(document.getElementById('editModal')).hide();
                
                // Re-render table
                applyFilters();
                
                // Show success message
                alert(`Student ${student.name} updated successfully!`);
            }
        }

        // ==================== INITIAL LOAD ====================
        window.onload = function() {
            renderTable(engineeringStudents);
        };

    </script>

</body>

</html>