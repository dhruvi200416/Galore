<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galore 2026 | Engineering</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --galore-red: #dc3545;
            --galore-red-dark: #b02a37;
            --galore-white: #ffffff;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', Roboto, sans-serif;
            background-color: #fcfcfc;
            padding-bottom: 50px;
        }

        /* ===== HERO ===== */
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

        /* --- EVENT CARDS --- */
        .event-card {
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(220, 53, 69, 0.15);
            transition: transform 0.4s, box-shadow 0.4s;
            cursor: pointer;
            border-top: 5px solid var(--galore-red);
            height: 100%;
        }

        .event-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(220, 53, 69, 0.35);
        }

        .event-card-body {
            padding: 25px;
            text-align: center;
        }

        .event-btn {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 24px;
            border-radius: 30px;
            background: linear-gradient(135deg, var(--galore-red-dark), var(--galore-red));
            color: #fff !important;
            font-weight: 600;
            text-decoration: none;
            border: none;
        }

        /* --- REGISTRATION TABLE & SCROLLBAR --- */
        .records-section {
            display: none;
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            padding: 30px;
            margin-top: 50px;
        }

        /* Adding a fixed height and scrollbar for the table container */
        .table-scroll-container {
            max-height: 400px; /* Adjust height as needed */
            overflow-y: auto;
            border: 1px solid #eee;
            border-radius: 8px;
        }

        /* Custom Scrollbar Styling */
        .table-scroll-container::-webkit-scrollbar {
            width: 8px;
        }
        .table-scroll-container::-webkit-scrollbar-thumb {
            background: var(--galore-red);
            border-radius: 10px;
        }

        .table-title {
            color: var(--galore-red);
            font-weight: 700;
            margin-bottom: 25px;
            border-bottom: 2px solid #eee;
        }

        table { width: 100%; border-collapse: collapse; }
        th { 
            position: sticky; top: 0; /* Keeps header visible while scrolling */
            background: #fdf2f2; 
            padding: 15px;
            z-index: 10;
            color: var(--galore-red-dark); 
        }
        td { padding: 15px; border-bottom: 1px solid #eee; }
    </style>
</head>
<body>

<?php  include 'co_navbar.php';?>

    <section class="hero">
        <h1>Participation</h1>
        <p>The Ultimate Sports & Cultural Festival of RK University</p>
    </section>

    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="event-card">
                    <div class="event-card-body">
                        <h4 style="margin-top: 35px;">All Participants</h4>
                        <button class="event-btn" onclick="viewRecords('all', 'All')">View All</button>
                    </div>
                </div>
            </div>
    
            <div class="col-md-4">
                <div class="event-card">
                    <div class="event-card-body">
                        <h4 style="margin-top: 35px;">School-wise (SOE)</h4>
                        <button class="event-btn" onclick="viewRecords('school', 'SOE')">View SOE Students</button>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="event-card">
                    <div class="event-card-body">
                        <h4 style="margin-top: 35px;">Event-wise (Cricket)</h4>
                        <button class="event-btn" onclick="viewRecords('event', 'Cricket')">View Cricket</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="recordsArea" class="records-section">
            <h2 id="tableEventTitle" class="table-title">Registered Students</h2>
            <div class="table-scroll-container">
                <table class="table">
                    <thead>
                        <tr id="tableHeader">
                            </tr>
                    </thead>
                    <tbody id="recordRows"></tbody>
                </table>
            </div>
        </div>
    </div>

<script>
    const engineeringRecords = [
        { name: "Rahul Sharma", enroll: "ENG24101", phone: "9876543210", dept: "B.Tech", school: "SOE", event: "Cricket" },
        { name: "Ananya Iyer", enroll: "ENG24055", phone: "8877665544", dept: "Diploma", school: "SOP", event: "Chess" },
        { name: "Vikram Das", enroll: "ENG24203", phone: "7766554433", dept: "MCA", school: "SOE", event: "Cricket" },
        { name: "Sneha Kapur", enroll: "ENG24088", phone: "9900112233", dept: "BCA", school: "SOM", event: "Football" },
        { name: "Arjun Singh", enroll: "ENG23045", phone: "9123456789", dept: "M.Tech", school: "SOE", event: "Cricket" },
        { name: "Priya Patel", enroll: "ENG23012", phone: "9123456780", dept: "B.Tech", school: "SOE", event: "Football" }
    ];

    function viewRecords(type, filterValue) {
        const tableSection = document.getElementById('recordsArea');
        const tableTitle = document.getElementById('tableEventTitle');
        const tableHeader = document.getElementById('tableHeader');
        const tableBody = document.getElementById('recordRows');

        let filteredData = [];

        if (type === 'all') {
            filteredData = engineeringRecords;
            tableTitle.innerText = "All Registered Participants";
        } 
        else if (type === 'school') {
            filteredData = engineeringRecords.filter(r => r.school === filterValue);
            tableTitle.innerText = `School: ${filterValue} - ${filteredData.length} Students`;
        } 
        else if (type === 'event') {
            filteredData = engineeringRecords.filter(r => r.event === filterValue);
            tableTitle.innerText = `Event: ${filterValue} - ${filteredData.length} Students`;
        }

        // Dynamic Headers
        let headerHTML = `
            <th>Student Name</th>
            <th>Enrollment No.</th>
            <th>Course</th>
        `;

        if (type === 'all') {
            headerHTML += `<th>Event</th><th>School</th>`;
        } 
        else if (type === 'school') {
            headerHTML += `<th>School</th>`;   // ✅ Only School
        } 
        else if (type === 'event') {
            headerHTML += `<th>Event</th>`;   // ✅ Only Event
        }

        tableHeader.innerHTML = headerHTML;
        tableSection.style.display = 'block';
        tableBody.innerHTML = "";

        filteredData.forEach(student => {
            let row = `
                <tr>
                    <td>${student.name}</td>
                    <td>${student.enroll}</td>
                    <td><strong>${student.dept}</strong></td>
            `;

            if (type === 'all') {
                row += `<td>${student.event}</td><td>${student.school}</td>`;
            } 
            else if (type === 'school') {
                row += `<td>${student.school}</td>`;  // ✅ Show School only
            } 
            else if (type === 'event') {
                row += `<td>${student.event}</td>`;   // ✅ Show Event only
            }

            row += `</tr>`;
            tableBody.innerHTML += row;
        });

        tableSection.scrollIntoView({ behavior: 'smooth' });
    }
</script>


<br><br>
      <?php include 'footer.php'; ?>

    
</body>
</html>