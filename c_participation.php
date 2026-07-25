<?php
session_start();

// ============================
// ⏱️ SESSION TIMEOUT (20 min)
// ============================
$timeout = 1200; // 20 minutes

if (isset($_SESSION['time'])) {
    if (time() - $_SESSION['time'] > $timeout) {
        session_destroy();
        header("Location: login.php?timeout=1");
        exit();
    }
}
$_SESSION['time'] = time();

// ============================
// 🔐 LOGIN CHECK
// ============================
if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit();
}

// ============================
// 🔒 ROLE CHECK (Coordinator only)
// ============================
if ($_SESSION['role'] !== 'Coordinator') {
    header("Location: login.php");
    exit();
}

// ============================
// DB CONNECTION
// ============================
$con = mysqli_connect("localhost", "root", "", "galore2026");
if (!$con) { 
    die("Connection failed: " . mysqli_connect_error()); 
}

// ============================
// GET CURRENT USER
// ============================
$email = $_SESSION['email'];
$result = mysqli_query($con, "SELECT * FROM ad_register WHERE email='$email'");
$user = mysqli_fetch_assoc($result);

// ============================
// FETCH PARTICIPANTS
// ============================
$participants = [];
$query = "SELECT enrollment_no, full_name, branch, semester, Sports_Outdoor, Sports_Indoor 
          FROM event_register 
          ORDER BY full_name ASC";

$res = mysqli_query($con, $query);

while ($row = mysqli_fetch_assoc($res)) {
    $participants[] = $row;
}

// ============================
// TOTAL PARTICIPANTS
// ============================
$total_participants = count($participants);
?>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Galore 2026 | Participation</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
:root { --galore-red: #dc3545; --galore-red-dark: #b02a37; --galore-white: #ffffff; }
body { margin:0; font-family: 'Segoe UI', Roboto, sans-serif; background-color:#fcfcfc; padding-bottom:50px; }
/* HERO */
.hero { background: linear-gradient(135deg,#dc3545,#7a1c25); color:#fff; text-align:center; padding:160px 20px 100px; position:relative; overflow:hidden; }
.hero::after { content:""; position:absolute; bottom:-60px; left:0; width:100%; height:120px; background:#fff; border-radius:50% 50% 0 0; }
.hero h1 { font-size:3.5rem; font-weight:900; letter-spacing:2px; margin-bottom:12px; }
/* EVENT CARDS */
.event-card { background:#fff; border-radius:16px; overflow:hidden; box-shadow:0 15px 35px rgba(220,53,69,0.15); transition:transform 0.4s, box-shadow 0.4s; cursor:pointer; border-top:5px solid var(--galore-red); height:100%; }
.event-card:hover { transform:translateY(-10px); box-shadow:0 20px 40px rgba(220,53,69,0.35); }
.event-card-body { padding:25px; text-align:center; }
.event-btn { display:inline-block; margin-top:15px; padding:10px 24px; border-radius:30px; background: linear-gradient(135deg,var(--galore-red-dark),var(--galore-red)); color:#fff!important; font-weight:600; text-decoration:none; border:none; }
/* REGISTRATION TABLE */
.records-section { display:none; background:white; border-radius:16px; box-shadow:0 10px 30px rgba(0,0,0,0.1); padding:30px; margin-top:50px; }
.table-scroll-container { max-height:400px; overflow-y:auto; border:1px solid #eee; border-radius:8px; }
.table-scroll-container::-webkit-scrollbar { width:8px; }
.table-scroll-container::-webkit-scrollbar-thumb { background:var(--galore-red); border-radius:10px; }
.table-title { color:var(--galore-red); font-weight:700; margin-bottom:25px; border-bottom:2px solid #eee; }
table { width:100%; border-collapse:collapse; }
th { position:sticky; top:0; background:#fdf2f2; padding:15px; z-index:10; color:var(--galore-red-dark); }
td { padding:15px; border-bottom:1px solid #eee; }
</style>
</head>
<body>

<?php include 'co_navbar.php'; ?>

<section class="hero">
    <h1>Participation</h1>
    <p>The Ultimate Sports & Cultural Festival of RK University</p>
</section>

<div class="container">
    <div class="row g-4">
        <div class="col-md-4">
            <div class="event-card">
                <div class="event-card-body">
                    <h4 style="margin-top: 35px;">All Participants (<?php echo $total_participants; ?>)</h4>
                    <button class="event-btn" onclick="viewRecords('all', '')">View All</button>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="event-card">
                <div class="event-card-body">
                    <h4 style="margin-top: 35px;">Sports Outdoor</h4>
                    <button class="event-btn" onclick="viewRecords('outdoor', 'Yes')">View Outdoor Participants</button>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="event-card">
                <div class="event-card-body">
                    <h4 style="margin-top: 35px;">Sports Indoor</h4>
                    <button class="event-btn" onclick="viewRecords('indoor', 'Yes')">View Indoor Participants</button>
                </div>
            </div>
        </div>
    </div>

    <div id="recordsArea" class="records-section">
        <h2 id="tableEventTitle" class="table-title">Registered Students</h2>
        <div class="table-scroll-container">
            <table class="table">
                <thead>
                    <tr id="tableHeader"></tr>
                </thead>
                <tbody id="recordRows"></tbody>
            </table>
        </div>
    </div>
</div>
<script>
const participants = <?php echo json_encode($participants); ?>;
function viewRecords(type, filterValue) {
    const tableSection = document.getElementById('recordsArea');
    const tableTitle = document.getElementById('tableEventTitle');
    const tableHeader = document.getElementById('tableHeader');
    const tableBody = document.getElementById('recordRows');

    let filteredData = [];

    if (type === 'all') {
        filteredData = participants;
        tableTitle.innerText = `All Registered Participants (${filteredData.length})`;

        tableHeader.innerHTML = `
            <th>Full Name</th>
            <th>Enrollment No.</th>
            <th>Branch</th>
            <th>Semester</th>
            <th>Sports Outdoor</th>
            <th>Sports Indoor</th>
        `;
    } 
    else if (type === 'outdoor') {
        filteredData = participants.filter(student => 
            student.Sports_Outdoor && student.Sports_Outdoor.trim() !== ""
        );

        tableTitle.innerText = `Sports Outdoor Participants (${filteredData.length})`;

        // ✅ ONLY Outdoor column
        tableHeader.innerHTML = `
            <th>Full Name</th>
            <th>Enrollment No.</th>
            <th>Branch</th>
            <th>Semester</th>
            <th>Sports Outdoor</th>
        `;
    }
    else if (type === 'indoor') {
        filteredData = participants.filter(student => 
            student.Sports_Indoor && student.Sports_Indoor.trim() !== ""
        );

        tableTitle.innerText = `Sports Indoor Participants (${filteredData.length})`;

        // ✅ ONLY Indoor column
        tableHeader.innerHTML = `
            <th>Full Name</th>
            <th>Enrollment No.</th>
            <th>Branch</th>
            <th>Semester</th>
            <th>Sports Indoor</th>
        `;
    }

    tableBody.innerHTML = "";

    filteredData.forEach(student => {
        let row = "";

        if (type === 'all') {
            row = `
                <tr>
                    <td>${student.full_name}</td>
                    <td>${student.enrollment_no}</td>
                    <td>${student.branch}</td>
                    <td>${student.semester}</td>
                    <td>${student.Sports_Outdoor}</td>
                    <td>${student.Sports_Indoor}</td>
                </tr>
            `;
        } 
        else if (type === 'outdoor') {
            row = `
                <tr>
                    <td>${student.full_name}</td>
                    <td>${student.enrollment_no}</td>
                    <td>${student.branch}</td>
                    <td>${student.semester}</td>
                    <td>${student.Sports_Outdoor}</td>
                </tr>
            `;
        } 
        else if (type === 'indoor') {
            row = `
                <tr>
                    <td>${student.full_name}</td>
                    <td>${student.enrollment_no}</td>
                    <td>${student.branch}</td>
                    <td>${student.semester}</td>
                    <td>${student.Sports_Indoor}</td>
                </tr>
            `;
        }

        tableBody.innerHTML += row;
    });

    tableSection.style.display = 'block';
    tableSection.scrollIntoView({ behavior: 'smooth' });
}</script>
<br><br>
<?php include 'footer.php'; ?>
</body>
</html>