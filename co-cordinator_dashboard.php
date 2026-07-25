<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Co-Coordinator Dashboard</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family: "Segoe UI", sans-serif;
}

body{
    background:#f5f6fa;
    display:flex;
}

/* SIDEBAR */
.sidebar{
    width:240px;
    height:100vh;
    background:#ffffff;
    padding:25px;
    box-shadow:2px 0 10px rgba(0,0,0,0.05);
}

.sidebar h2{
    color:#ff6b6b;
    margin-bottom:30px;
}

.sidebar a{
    display:block;
    padding:14px;
    margin-bottom:12px;
    text-decoration:none;
    color:#444;
    border-radius:12px;
    font-weight:500;
}

.sidebar a.active,
.sidebar a:hover{
    background:#ff6b6b;
    color:#fff;
}

/* MAIN */
.main{
    flex:1;
    padding:30px;
}

/* HEADER */
.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
}

.header h1{
    color:#ff6b6b;
}

.profile{
    background:#fff;
    padding:10px 18px;
    border-radius:25px;
    box-shadow:0 4px 10px rgba(0,0,0,0.05);
    font-weight:500;
}

/* CARDS */
.cards{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:20px;
    margin-bottom:30px;
}

.card{
    background:#ffffff;
    border-radius:20px;
    padding:25px;
    box-shadow:0 6px 15px rgba(0,0,0,0.05);
}

.card span{
    font-size:14px;
    color:#777;
}

.card h2{
    margin-top:10px;
    color:#ff6b6b;
    font-size:28px;
}

/* SECTIONS */
.section{
    background:#fff;
    padding:25px;
    border-radius:20px;
    box-shadow:0 6px 15px rgba(0,0,0,0.05);
    margin-bottom:30px;
}

.section h3{
    color:#ff6b6b;
    margin-bottom:20px;
}

/* EVENT GRID */
.event-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit, minmax(180px,1fr));
    gap:15px;
}

.event-card{
    background:#f5f6fa;
    padding:18px;
    border-radius:15px;
    text-align:center;
    font-weight:600;
    cursor:pointer;
    transition:0.3s;
}

.event-card:hover{
    background:#ff6b6b;
    color:#fff;
    transform:translateY(-3px);
}

/* TABLE */
table{
    width:100%;
    border-collapse:collapse;
}

th, td{
    padding:14px;
    text-align:left;
    border-bottom:1px solid #eee;
}

th{
    color:#555;
}

/* FORM */
.form{
    display:flex;
    gap:15px;
    flex-wrap:wrap;
}

.form input,
.form select,
.form button{
    padding:12px;
    border-radius:10px;
    border:1px solid #ddd;
}

.form button{
    background:#ff6b6b;
    color:white;
    border:none;
    cursor:pointer;
}
</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>RK University</h2>
    <a class="active">Dashboard</a>
    <a>Registrations</a>
    <a>Events</a>
    <a>Coordinators</a>
    <a>Winners</a>
    <a>Schedule</a>
    <a>Logout</a>
</div>

<!-- MAIN -->
<div class="main">

    <!-- HEADER -->
    <div class="header">
        <h1>Co-Coordinator Dashboard</h1>
        <div class="profile">Co-Coordinator | RK University</div>
    </div>

    <!-- CARDS -->
    <div class="cards">
        <div class="card">
            <span>Total Registrations</span>
            <h2>320</h2>
        </div>
        <div class="card">
            <span>Total Events</span>
            <h2>15</h2>
        </div>
        <div class="card">
            <span>Total Teams</span>
            <h2>48</h2>
        </div>
        <div class="card">
            <span>Total Participants</span>
            <h2>640</h2>
        </div>
    </div>

    <!-- SPORTS OUTDOOR -->
    <div class="section">
        <h3>Sports – Outdoor</h3>
        <div class="event-grid">
            <div class="event-card">Cricket</div>
            <div class="event-card">Volleyball</div>
            <div class="event-card">Basketball</div>
            <div class="event-card">Dodgeball</div>
        </div>
    </div>

    <!-- SPORTS INDOOR -->
    <div class="section">
        <h3>Sports – Indoor</h3>
        <div class="event-grid">
            <div class="event-card">Carrom</div>
            <div class="event-card">Duo Carrom</div>
            <div class="event-card">Chess</div>
            <div class="event-card">Table Tennis</div>
            <div class="event-card">Duo Table Tennis</div>
        </div>
    </div>

    <!-- CULTURAL -->
    <div class="section">
        <h3>Cultural Events</h3>
        <div class="event-grid">
            <div class="event-card">Drawing</div>
            <div class="event-card">Singing</div>
            <div class="event-card">Public Speaking</div>
            <div class="event-card">Rangoli</div>
            <div class="event-card">Solo Dance</div>
            <div class="event-card">Duo Dance</div>
            <div class="event-card">Group Dance</div>
        </div>
    </div>

    <!-- WINNER -->
    <div class="section">
        <h3>Winners Announcement</h3>
        <div class="form">
            <input type="text" placeholder="Winner Name">
            <select>
                <option>Select Event</option>
                <option>Cricket</option>
                <option>Chess</option>
                <option>Singing</option>
            </select>
            <select>
                <option>Select School</option>
                <option>SDS</option>
                <option>SOE</option>
                <option>SOM</option>
                <option>SOA</option>
                <option>SOH</option>
            </select>
            <select>
                <option>Position</option>
                <option>1st</option>
                <option>2nd</option>
                <option>3rd</option>
            </select>
            <button>Announce</button>
        </div>
    </div>

</div>

</body>
</html>
