<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Galore 2026 | Results</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --galore-red: #dc3545;
            --galore-red-dark: #b02a37;
        }

        body {
            font-family: 'Segoe UI', Roboto, sans-serif;
            background-color: #fcfcfc;
        }

        .result-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            transition: 0.4s;
            border-top: 5px solid var(--galore-red);
            text-align: center;
            padding: 30px;
        }

        .result-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(220, 53, 69, 0.2);
        }

        .records-section {
            display: none;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            padding: 30px;
            margin-top: 50px;
        }

        .table-scroll-container {
            max-height: 500px;
            overflow-y: auto;
        }

        .table thead th {
            background: var(--galore-red);
            color: #fff;
            text-transform: uppercase;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .badge-winner {
            background-color: var(--galore-red);
            color: #fff;
        }

        .badge-runner {
            background-color: var(--galore-red-dark);
            color: #fff;
        }

        .badge-second {
            background-color: var(--galore-red);
            color: #fff;
        }

    </style>
</head>

<body>

<?php include 'co_navbar.php'; ?>

    <section class="hero">
        <h1>Results/Rankings</h1>
        <p>The Ultimate Sports & Cultural Festival of RK University</p>
    </section>

<div class="container">
    <div class="row g-4">

        <!-- Cricket -->
        <div class="col-md-4">
            <div class="result-card">
                <h4>Cricket</h4>
                <p>View Cricket Event Rankers</p>
                <button class="btn btn-danger" onclick="viewResults('Cricket')">View Rankers</button>
            </div>
        </div>

        <!-- Football -->
        <div class="col-md-4">
            <div class="result-card">
                <h4>Football</h4>
                <p>View Football Event Rankers</p>
                <button class="btn btn-danger" onclick="viewResults('Football')">View Rankers</button>
            </div>
        </div>

        <!-- Dance -->
        <div class="col-md-4">
            <div class="result-card">
                <h4>Dance</h4>
                <p>View Dance Event Rankers</p>
                <button class="btn btn-danger" onclick="viewResults('Dance')">View Rankers</button>
            </div>
        </div>

    </div>

    <!-- Result Table -->
    <div id="resultArea" class="records-section">
        <h2 id="tableTitle" class="mb-4" style="color: var(--galore-red); font-weight: bold;"></h2>

        <div class="table-scroll-container">
            <table class="table table-hover">
                <thead>
                    <tr id="tableHeader"></tr>
                </thead>
                <tbody id="resultRows"></tbody>
            </table>
        </div>
    </div>

</div>

<br><br>

<script>

const resultData = [
    { pos: 1, name: "Rahul Sharma", school: "SOE", event: "Cricket", rank: "Winner" },
    { pos: 2, name: "Vikram Das", school: "SOE", event: "Cricket", rank: "Runner Up" },

    { pos: 1, name: "Arjun Singh", school: "SOE", event: "Football", rank: "Winner" },
    { pos: 2, name: "Sneha Kapur", school: "SOM", event: "Football", rank: "Runner Up" },

    { pos: 1, name: "Ananya Iyer", school: "SOP", event: "Dance", rank: "Winner" },
    { pos: 2, name: "Priya Patel", school: "SOE", event: "Dance", rank: "Runner Up" },
    { pos: 3, name: "Riya Shah", school: "SOM", event: "Dance", rank: "Second Runner Up" }
];

function viewResults(eventName) {

    const area = document.getElementById('resultArea');
    const title = document.getElementById('tableTitle');
    const header = document.getElementById('tableHeader');
    const body = document.getElementById('resultRows');

    let filtered = resultData.filter(r => r.event === eventName);

    title.innerText = `${eventName} Event Rankers`;

    /* Header */
    header.innerHTML = `
        <th>Position</th>
        <th>Student Name</th>
        <th>School</th>
    `;

    /* Rows */
    body.innerHTML = "";
    filtered.sort((a, b) => a.pos - b.pos);

    filtered.forEach(res => {

        let badgeClass = '';

        if(res.pos === 1) badgeClass = 'badge-winner';
        else if(res.pos === 2) badgeClass = 'badge-runner';
        else if(res.pos === 3) badgeClass = 'badge-second';

        let row = `
            <tr>
                <td><span class="badge ${badgeClass}">${res.rank}</span></td>
                <td>${res.name}</td>
                <td>${res.school}</td>
            </tr>
        `;

        body.innerHTML += row;
    });

    area.style.display = 'block';
    area.scrollIntoView({ behavior: 'smooth' });
}

</script>

<?php include 'footer.php'; ?>

</body>
</html>
