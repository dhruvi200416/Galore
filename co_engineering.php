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

        .hero p {
            font-size: 1.2rem;
            opacity: 0.95;
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

        .event-card-body h4 {
            color: var(--galore-red);
            font-weight: 700;
            margin-bottom: 15px;
        }

        .event-btn 
        {
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

        /* --- REGISTRATION TABLE --- */
        .records-section {
            display: none;
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            padding: 30px;
            margin-top: 50px;
            animation: slideIn 0.5s ease;
        }

        .table-title 
        {
            color: var(--galore-red);
            font-weight: 700;
            margin-bottom: 25px;
            padding-bottom: 10px;
            border-bottom: 2px solid #eee;
        }

        table { 
         width: 100%;
         border-collapse: collapse; 
        }
        th{ 
            background: #fdf2f2; 
            padding: 15px;
            text-align: left;
            color: var(--galore-red-dark); 
        }
        td { 
            padding: 15px;
             border-bottom: 1px solid #eee;
         }

    </style>
</head>
<body>
    <?php include 'co_navbar.php';?>

    <section class="hero">
        <h1>Engineering</h1>
        <p>The Ultimate Sports & Cultural Festival of RK University</p>
    </section>

    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="event-card">
                    <div class="event-card-body">
                        <h4 style="margin-top: 35px;">Chess</h4>
                        <button class="event-btn" onclick="viewRecords('Chess')">View Registered</button>
                    </div>
                </div>
            </div>
    
            <div class="col-md-4">
                <div class="event-card">
                    <div class="event-card-body">
                        <h4 style="margin-top: 35px;">Football</h4>
                        <button class="event-btn" onclick="viewRecords('Football')">View Registered</button>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="event-card">
                    <div class="event-card-body">
                        <h4 style="margin-top: 35px;">Cricket</h4>
                        <button class="event-btn" onclick="viewRecords('Cricket')">View Registered</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="recordsArea" class="records-section">
            <h2 id="tableEventTitle" class="table-title">Registered Students</h2>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Enrollment No.</th>
                            <th>Contact No.</th>
                            <th>Course </th>
                        </tr>
                    </thead>
                    <tbody id="recordRows">
                        </tbody>
                </table>
            </div>
        </div>

    </div>

        <script>
            // Sample Data
            const engineeringRecords = [
                { name: "Rahul Sharma", enroll: "ENG24101", phone: "9876543210", dept: "B.Tech" },
                { name: "Ananya Iyer", enroll: "ENG24055", phone: "8877665544", dept: "Diploma" },
                { name: "Vikram Das", enroll: "ENG24203", phone: "7766554433", dept: "MCA" },
                { name: "Sneha Kapur", enroll: "ENG24088", phone: "9900112233", dept: "BCA" },
                { name: "Arjun Singh", enroll: "ENG23045", phone: "9123456789", dept: "M.Tech" }
            ];

            function viewRecords(eventName) {
                const tableSection = document.getElementById('recordsArea');
                const tableTitle = document.getElementById('tableEventTitle');
                const tableBody = document.getElementById('recordRows');

                // Set Title
                tableTitle.innerText = `${eventName} - ${engineeringRecords.length} Registered Participants`;
                
                // Show Section
                tableSection.style.display = 'block';

                // Clear and Populate Table
                tableBody.innerHTML = "";
                engineeringRecords.forEach(student => {
                    const row = `
                        <tr>
                            <td>${student.name}</td>
                            <td>${student.enroll}</td>
                            <td>${student.phone}</td>
                            <td><strong>${student.dept}</strong></td>
                        </tr>
                    `;
                    tableBody.innerHTML += row;
                });

                // Smooth Scroll
                tableSection.scrollIntoView({ behavior: 'smooth' });
            }
        </script><br><br>

          <?php include 'footer.php'; ?>

</body>
</html>