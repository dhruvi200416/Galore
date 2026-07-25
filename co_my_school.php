<?php
include 'c_navbar.php';
// session_start();

// Login check
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$user_email = $_SESSION['email'];

// DB connection
$con = mysqli_connect("localhost", "root", "", "galore2026");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get coordinator details
$user_query = "SELECT coordinator_role, school FROM ad_register WHERE email = '$user_email' LIMIT 1";
$user_result = mysqli_query($con, $user_query);

if(mysqli_num_rows($user_result) == 0){
    die("Coordinator not found.");
}

$user = mysqli_fetch_assoc($user_result);
$coordinator_role = $user['coordinator_role'];
$school = $user['school'];


// ================= PAGINATION =================
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

if ($page < 1) {
    $page = 1;
}

$offset = ($page - 1) * $limit;

// COUNT TOTAL RECORDS
$count_query = "
    SELECT COUNT(*) as total 
    FROM event_register 
    WHERE school = '$school' AND Sports_Outdoor = '$coordinator_role'
";
$count_result = mysqli_query($con, $count_query);
$count_row = mysqli_fetch_assoc($count_result);
$total_records = $count_row['total'];

$total_pages = ceil($total_records / $limit);

// MAIN QUERY WITH LIMIT
$query = "
    SELECT e.id as event_id, e.enrollment_no, e.full_name as event_full_name, e.email as event_email,
           e.phone as event_phone, e.branch as event_branch, e.semester, e.school as event_school,
           e.Sports_Outdoor, e.Sports_Indoor
    FROM event_register e
    WHERE e.school = '$school' AND e.Sports_Outdoor = '$coordinator_role'
    ORDER BY e.full_name ASC
    LIMIT $limit OFFSET $offset
";

$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Sports Outdoor Events – Galore 2026</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
:root {
    --galore-red: #dc3545;
    --galore-dark: #7a1c25;
    --table-light: #ffffff;
    --table-stripe: #f1f1f1;
}

/* BODY */
body {
    font-family: "Segoe UI", Arial, sans-serif;
    background: #f8f9fa;
    margin: 0;
    padding: 0;
}

/* COORDINATOR BADGE */
.coordinator-badge {
    display: inline-block;
    color: #fff;
    font-weight: 600;
    padding: 8px 16px;
    border-radius: 25px;
    box-shadow: 0 3px 8px rgba(0,0,0,0.15);
    font-size: 0.95rem;
    margin-top: 10px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.coordinator-badge:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(0,0,0,0.25);
    cursor: default;
}

/* CARD CONTAINER */
.card-container {
    background: #fff;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.05);
}

/* TABLE CUSTOM DESIGN */
.table-custom {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    font-size: 0.95rem;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}
.table-custom th,
.table-custom td {
    padding: 15px 12px;
    text-align: center;
    vertical-align: middle;
}
.table-custom thead {
    background: var(--galore-red);
    color: #fff;
    font-weight: 600;
}
.table-custom tbody tr:nth-child(even) {
    background-color: var(--table-stripe);
}
.table-custom tbody tr:hover {
    transform: scale(1.02);
    transition: all 0.3s ease;
    cursor: pointer;
}
.table-custom td, .table-custom th {
    border-bottom: 1px solid #dee2e6;
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

/* NO RECORDS */
.no-records {
    text-align: center;
    font-weight: 500;
    color: #6c757d;
}

/* RESPONSIVE TABLE */
.table-responsive {
    overflow-x: auto;
}
</style>
</head>
<body>

<section class="hero">
    <h1>My School</h1>
    <p>View & manage your Galore participation</p>
    <p class="coordinator-badge"><?php echo htmlspecialchars($coordinator_role . " – " . $school); ?></p>
</section>

<div class="container mt-4">
    <div class="card-container">
        <div class="table-responsive">
            <table class="table-custom align-middle">
                <thead>
                    <tr>
                        <th>Event ID</th>
                        <th>Enrollment No</th>
                        <th>Event Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Branch</th>
                        <th>Semester</th>
                        <th>School</th>
                        <th>Sports Outdoor</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if(mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_assoc($result)){
                            echo "<tr>
                                <td>{$row['event_id']}</td>
                                <td>{$row['enrollment_no']}</td>
                                <td>{$row['event_full_name']}</td>
                                <td>{$row['event_email']}</td>
                                <td>{$row['event_phone']}</td>
                                <td>{$row['event_branch']}</td>
                                <td>{$row['semester']}</td>
                                <td>{$row['event_school']}</td>
                                <td>{$row['Sports_Outdoor']}</td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='10' class='no-records'>No matching events found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        <nav class="mt-4">
            <ul class="pagination justify-content-center">

                <?php if($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $page - 1; ?>">Previous</a>
                    </li>
                <?php endif; ?>

                <?php for($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?php if($i == $page) echo 'active'; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>">
                            <?php echo $i; ?>
                        </a>
                    </li>
                <?php endfor; ?>

                <?php if($page < $total_pages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $page + 1; ?>">Next</a>
                    </li>
                <?php endif; ?>

            </ul>
        </nav>

    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?php include 'footer.php'; ?>

</body>
</html>