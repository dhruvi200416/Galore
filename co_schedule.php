<?php
session_start();
include "c_navbar.php";

// DB connection (safety)
if (!isset($con)) {
    $con = mysqli_connect("localhost","root","","galore2026");
}

// LOGIN CHECK
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// GET ROLE
$user_email = $_SESSION['email'];

$userQuery = mysqli_query($con, "
    SELECT coordinator_role 
    FROM ad_register 
    WHERE email='$user_email'
");

$userData = mysqli_fetch_assoc($userQuery);
$coordinator_role = $userData['coordinator_role'] ?? '';

// FETCH TEAMS
$teams = mysqli_query($con, "
    SELECT * FROM teams 
    WHERE event_name = '$coordinator_role'
    ORDER BY id ASC
");

$teamData = [];
while($row = mysqli_fetch_assoc($teams)){
    $teamData[] = $row;
}

// FETCH SCHEDULE
$schedule = mysqli_query($con, "SELECT * FROM schedule_events ORDER BY id ASC");

$scheduleData = [];
while($row = mysqli_fetch_assoc($schedule)){
    $scheduleData[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Schedule | Galore 2026</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
:root {
    --galore-red: #dc3545;
    --galore-dark: #7a1c25;
}

.hero {
    background: linear-gradient(135deg, #dc3545, #7a1c25);
    color: #fff;
    text-align: center;
    padding: 140px 20px 80px;
}
.hero h1 {
    font-size: 3rem;
    font-weight: 900;
}

.match-card {
    background: #fff;
    border-radius: 20px;
    padding: 30px 20px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    border-top: 6px solid var(--galore-red);
}

.team-box {
    background: #f1f5f9;
    padding: 16px 25px;
    border-radius: 12px;
    font-size: 1.6rem;
    font-weight: 700;
    color: var(--galore-red);
}

.team-selected {
    border: 3px solid green !important;
}

.btn-winner,
.selectSemi,
.selectFinal {
    background: linear-gradient(135deg, #dc3545, #7a1c25) !important;
    color: #fff !important;
    border: none !important;
}
</style>
</head>

<body>

<?php include 'c_navbar.php'; ?>

<section class="hero">
    <h1>🏏 <?= strtoupper($coordinator_role); ?> Schedule</h1>
    <p>Galore 2026 - Sports Event</p>
</section>

<section class="py-5">
<div class="container" id="mainContent">

<h3 class="text-center mb-5">Matches</h3>

<div class="row g-4">

<?php 
$matchIndex = 0;
$remainingTeams = $teamData;

while(count($remainingTeams) > 1) {

    $team1 = array_shift($remainingTeams);
    $team2 = null;

    foreach($remainingTeams as $key => $t) {
        if($t['school'] != $team1['school']) {
            $team2 = $t;
            unset($remainingTeams[$key]);
            break;
        }
    }

    if(!$team2) {
        $team2 = array_shift($remainingTeams);
    }

    $remainingTeams = array_values($remainingTeams);

    $match = isset($scheduleData[$matchIndex]) ? $scheduleData[$matchIndex] : null;
?>

<div class="col-md-5">
    <div class="match-card text-center">
        <div class="team-box mb-3">
            <?= $team1['team_name']; ?><br>
            <small><?= $team1['school']; ?></small>
        </div>

        <p>📅 <?= $match['day_title'] ?? 'TBD'; ?></p>
        <p>⏰ <?= $match['event_time'] ?? 'TBD'; ?></p>
        <p>📍 <?= $match['event_location'] ?? 'TBD'; ?></p>

        <button class="btn btn-winner"
            data-team="<?= $team1['team_name']; ?>">
            Winner
        </button>
    </div>
</div>

<div class="col-md-2 text-center d-flex align-items-center justify-content-center">
    <strong>VS</strong>
</div>

<div class="col-md-5">
    <div class="match-card text-center">
        <div class="team-box mb-3">
            <?= $team2['team_name']; ?><br>
            <small><?= $team2['school']; ?></small>
        </div>

        <p>📅 <?= $match['day_title'] ?? 'TBD'; ?></p>
        <p>⏰ <?= $match['event_time'] ?? 'TBD'; ?></p>
        <p>📍 <?= $match['event_location'] ?? 'TBD'; ?></p>

        <button class="btn btn-winner"
            data-team="<?= $team2['team_name']; ?>">
            Winner
        </button>
    </div>
</div>

<?php $matchIndex++; } ?>

</div>

<!-- SELECTED TEAMS -->
<div class="mt-5">
<h4 class="text-center">Selected Teams</h4>
<div class="row justify-content-center" id="selectedTeams"></div>
</div>

<!-- MATCH FLOW -->
<div class="mt-5" id="matchFlow" style="display:none;">
<h4 class="text-center">Final Matches</h4>

<div class="row justify-content-center text-center">
    <div class="col-md-4">
        <div class="match-card">
            <div id="teamA" class="team-box"></div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="match-card">
            <div id="teamB" class="team-box"></div>
        </div>
    </div>
</div>

<div class="row justify-content-center text-center mt-4">
    <div class="col-md-4">
        <div class="match-card">
            <div id="finalTeam" class="team-box"></div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="match-card">
            <div id="teamC" class="team-box"></div>
        </div>
    </div>
</div>

<div class="text-center mt-4">
    <h4 id="finalResult"></h4>
</div>
</div>

<!-- FINAL RESULT CARDS -->
<div class="mt-5" id="finalCards" style="display:none;">
    <h3 class="text-center mb-4">🏆 Final Result</h3>
    <div class="row justify-content-center text-center">
        <div class="col-md-4">
            <div class="match-card">
                <h5>Winner</h5>
                <div id="winnerCard" class="team-box"></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="match-card">
                <h5>Runner-Up</h5>
                <div id="runnerCard" class="team-box"></div>
            </div>
        </div>
    </div>
</div>

</div>
</section>

<script>
let selectedTeams = [];
let semiWinner = "";
let finalWinner = "";

// SELECT TOP 3 TEAMS
document.querySelectorAll('.btn-winner').forEach(btn => {
    btn.addEventListener('click', function () {

        let team = this.dataset.team;

        if(selectedTeams.includes(team)) return;

        if(selectedTeams.length >= 3){
            alert("Only 3 teams allowed!");
            return;
        }

        selectedTeams.push(team);
        this.classList.add('team-selected');

        renderSelectedTeams();

        if(selectedTeams.length === 3){
            startMatches();
        }
    });
});

function renderSelectedTeams(){
    let container = document.getElementById('selectedTeams');
    container.innerHTML = '';

    selectedTeams.forEach(t => {
        container.innerHTML += `
        <div class="col-md-3">
            <div class="match-card text-center">
                <div class="team-box">${t}</div>
            </div>
        </div>`;
    });
}

function startMatches(){
    document.getElementById('matchFlow').style.display = 'block';

    document.getElementById('teamA').innerHTML = `
        ${selectedTeams[0]}<br>
        <button class="btn btn-sm selectSemi mt-2" data-team="${selectedTeams[0]}">Select</button>
    `;

    document.getElementById('teamB').innerHTML = `
        ${selectedTeams[1]}<br>
        <button class="btn btn-sm selectSemi mt-2" data-team="${selectedTeams[1]}">Select</button>
    `;

    document.getElementById('teamC').innerHTML = selectedTeams[2];

    attachSemiEvents();
}

function attachSemiEvents(){
    document.querySelectorAll('.selectSemi').forEach(btn => {
        btn.addEventListener('click', function(){

            semiWinner = this.dataset.team;

            document.getElementById('finalTeam').innerHTML = `
                ${semiWinner}<br>
                <button class="btn btn-sm selectFinal mt-2" data-team="${semiWinner}">Select</button>
            `;

            document.getElementById('teamC').innerHTML = `
                ${selectedTeams[2]}<br>
                <button class="btn btn-sm selectFinal mt-2" data-team="${selectedTeams[2]}">Select</button>
            `;

            attachFinalEvents();
        });
    });
}

// ✅ FIXED FINAL LOGIC
function attachFinalEvents(){
    document.querySelectorAll('.selectFinal').forEach(btn => {
        btn.addEventListener('click', function(){

            finalWinner = this.dataset.team;
            let runner = (finalWinner === semiWinner) ? selectedTeams[2] : semiWinner;

            document.getElementById('finalResult').innerHTML =
                `🏆 ${finalWinner} is Winner <br> 🥈 ${runner} is Runner-up`;

            // ✅ Hide only match-related sections
            document.querySelectorAll('#mainContent > .row, #mainContent > .mt-5:not(#finalCards)')
                .forEach(el => el.style.display = 'none');

            // ✅ Show final cards
            document.getElementById('finalCards').style.display = 'block';
            document.getElementById('winnerCard').innerText = finalWinner;
            document.getElementById('runnerCard').innerText = runner;
        });
    });
}
</script>

<?php include 'footer.php'; ?>

</body>
</html>