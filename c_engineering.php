<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "galore2026");

// get selected event
$event = isset($_GET['event']) ? $_GET['event'] : "";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galore 2026 | Engineering</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- ✅ SAME CSS (no change) -->
    <style>
        :root {
            --galore-red: #dc3545;
            --galore-red-dark: #b02a37;
            --galore-white: #ffffff;
        }
        body { margin: 0; font-family: 'Segoe UI', Roboto, sans-serif; background-color: #fcfcfc; padding-bottom: 50px; }
        .hero { background: linear-gradient(135deg, #dc3545, #7a1c25); color: #fff; text-align: center; padding: 160px 20px 100px; position: relative; overflow: hidden; }
        .hero::after { content: ""; position: absolute; bottom: -60px; left: 0; width: 100%; height: 120px; background: #fff; border-radius: 50% 50% 0 0; }
        .hero h1 { font-size: 3.5rem; font-weight: 900; letter-spacing: 2px; margin-bottom: 12px; }
        .hero p { font-size: 1.2rem; opacity: 0.95; }

        .event-card { background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 15px 35px rgba(220, 53, 69, 0.15); transition: transform 0.4s, box-shadow 0.4s; cursor: pointer; border-top: 5px solid var(--galore-red); height: 100%; }
        .event-card:hover { transform: translateY(-10px); box-shadow: 0 20px 40px rgba(220, 53, 69, 0.35); }
        .event-card-body { padding: 25px; text-align: center; }
        .event-card-body h4 { color: var(--galore-red); font-weight: 700; margin-bottom: 15px; }

        .event-btn { display: inline-block; margin-top: 15px; padding: 10px 24px; border-radius: 30px; background: linear-gradient(135deg, var(--galore-red-dark), var(--galore-red)); color: #fff !important; font-weight: 600; text-decoration: none; border: none; }

        .records-section { display: <?php echo ($event != "") ? "block" : "none"; ?>; background: white; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); padding: 30px; margin-top: 50px; }

        .table-title { color: var(--galore-red); font-weight: 700; margin-bottom: 25px; padding-bottom: 10px; border-bottom: 2px solid #eee; }

        table { width: 100%; border-collapse: collapse; }
        th { background: #fdf2f2; padding: 15px; text-align: left; color: var(--galore-red-dark); }
        td { padding: 15px; border-bottom: 1px solid #eee; }
    </style>
</head>

<body>

<?php include 'co_navbar.php';?>

<section class="hero">
    <h1>Engineering</h1>
    <p>The Ultimate Sports & Cultural Festival of RK University</p>
</section>

<div class="container">

<div class="row g-4 justify-content-center">

    <!-- Football -->
    <div class="col-md-4">
        <div class="event-card">
            <div class="event-card-body">
                <h4 style="margin-top: 35px;">Football</h4>
                <a href="?event=Football" class="event-btn">View Registered</a>
            </div>
        </div>
    </div>

    <!-- Cricket -->
    <div class="col-md-4">
        <div class="event-card">
            <div class="event-card-body">
                <h4 style="margin-top: 35px;">Cricket</h4>
                <a href="?event=Cricket" class="event-btn">View Registered</a>
            </div>
        </div>
    </div>

</div>

<!-- ✅ TABLE -->
<div class="records-section">
    <h2 class="table-title">
        <?php echo $event ? "$event Participants" : "Registered Students"; ?>
    </h2>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Enrollment</th>
                    <th>Phone</th>
                    <th>Branch</th>
                </tr>
            </thead>
            <tbody>

<?php
if ($event != "") {

    $query = "SELECT * FROM event_register 
              WHERE Sports_Outdoor LIKE '%$event%'";

    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['full_name']}</td>
                    <td>{$row['enrollment_no']}</td>
                    <td>{$row['phone']}</td>
                    <td><strong>{$row['branch']}</strong></td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='4'>No Data Found</td></tr>";
    }
}
?>

            </tbody>
        </table>
    </div>
</div>

</div>

<br><br>
<?php include 'footer.php'; ?>

</body>
</html>