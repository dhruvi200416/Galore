<?php 
require 'c_navbar.php';

// DB CONNECTION
$con = mysqli_connect("localhost","root","","galore2026");

// LOGIN CHECK
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$user_email = $_SESSION['email'];

// ✅ GET ROLE + SCHOOL + TOTAL_PLAYERS LIMIT
$user = mysqli_fetch_assoc(mysqli_query($con,
"SELECT coordinator_role, school, total_players FROM ad_register WHERE email='$user_email'"));

$role = $user['coordinator_role'];
$school = $user['school'];
$totalPlayersLimit = $user['total_players'] ?? 0;

$msg = "";
$team = [];
$selectedPlayers = [];
$errorMsg = "";
$createdTeamName = "";
$createdEventName = "";
$teamNumber = 0;

// ================= CREATE TEAMS TABLE IF NOT EXISTS =================
$createTeamsTable = "CREATE TABLE IF NOT EXISTS `teams` (
    `id` int NOT NULL AUTO_INCREMENT,
    `team_name` varchar(100) NOT NULL,
    `event_name` varchar(100) NOT NULL,
    `event_type` varchar(50) NOT NULL,
    `game_name` varchar(100) NOT NULL,
    `school` varchar(100) NOT NULL,
    `coordinator_email` varchar(100) NOT NULL,
    `coordinator_role` varchar(100) NOT NULL,
    `player_ids` text NOT NULL,
    `player_count` int DEFAULT 0,
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `unique_team_per_event` (`coordinator_email`, `game_name`, `player_ids`(255))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci";

mysqli_query($con, $createTeamsTable);

// ================= AJAX =================
if(isset($_GET['ajax'])){

    $type = $_GET['type'] ?? '';

    // ================= FETCH GAME (ONLY coordinator_role) =================
    if($_GET['ajax'] == "games"){

        echo "<option value=''>Select Game</option>";

        if(!empty($role)){
            echo "<option value='".htmlspecialchars($role)."'>".htmlspecialchars($role)."</option>";
        } else {
            echo "<option value=''>No Game Assigned</option>";
        }

        exit();
    }

    // ================= FETCH PLAYERS =================
    if($_GET['ajax'] == "players"){

        if($type == "Outdoor"){
            $q = "SELECT id, full_name, enrollment_no, branch 
                  FROM event_register 
                  WHERE UPPER(TRIM(Sports_Outdoor)) = UPPER('$role')
                  AND school='$school'";
        }
        else if($type == "Indoor"){
            $q = "SELECT id, full_name, enrollment_no, branch 
                  FROM event_register 
                  WHERE UPPER(TRIM(Sports_Indoor)) = UPPER('$role')
                  AND school='$school'";
        }
        else{
            $q = "SELECT id, full_name, enrollment_no, branch 
                  FROM event_register 
                  WHERE UPPER(TRIM(cultur)) = UPPER('$role')
                  AND school='$school'";
        }

        $res = mysqli_query($con,$q);

        $output = '';
        $count = mysqli_num_rows($res);

        // Already selected players
        $gameName = $_GET['game'] ?? '';
        $existingPlayersQuery = "SELECT player_ids FROM teams WHERE coordinator_email='$user_email' AND game_name='$gameName'";
        $existingResult = mysqli_query($con, $existingPlayersQuery);

        $existingPlayerIds = [];
        while($row = mysqli_fetch_assoc($existingResult)){
            $ids = explode(",", $row['player_ids']);
            $existingPlayerIds = array_merge($existingPlayerIds, $ids);
        }
        $existingPlayerIds = array_unique($existingPlayerIds);

        if($count > 0){

            $output .= '<div class="players-list">';
            $output .= '<div class="select-all-container">
                            <label class="checkbox-label select-all-label">
                                <input type="checkbox" id="selectAll" onchange="toggleAllPlayers()">
                                <span>Select All Players ('.$count.')</span>
                            </label>
                        </div>';

            $output .= '<div class="players-grid">';

            while($row = mysqli_fetch_assoc($res)){

                $isDisabled = in_array($row['id'], $existingPlayerIds);
                $disabledAttr = $isDisabled ? 'disabled' : '';
                $disabledClass = $isDisabled ? 'disabled-player' : '';

                $output .= '<label class="player-checkbox-label '.$disabledClass.'">
                                <input type="checkbox" name="players[]" value="'.$row['id'].'" class="player-checkbox" '.$disabledAttr.'>
                                <div class="player-info">
                                    <strong>'.htmlspecialchars($row['full_name']).'</strong><br>
                                    <small>📚 '.htmlspecialchars($row['enrollment_no']).' | 🏫 '.htmlspecialchars($row['branch']).'</small>';

                if($isDisabled){
                    $output .= '<br><small class="text-danger">⚠️ Already in a team</small>';
                }

                $output .= '</div></label>';
            }

            $output .= '</div></div>';

        } else {
            $output = '<div class="alert alert-warning">No players found.</div>';
        }

        echo $output;
        exit();
    }
}

// ================= TEAM CREATE =================
if(isset($_POST['create_team'])){
    $players = $_POST['players'] ?? [];
    $selected_game = $_POST['game'] ?? '';
    $selected_type = $_POST['selected_type'] ?? '';

    // Get the limit for the selected game
    $gameLimit = 0;
    $gameName = strtolower($selected_game);
    
    if($gameName == 'cricket') {
        $gameLimit = 11;
    } elseif($gameName == 'football') {
        $gameLimit = 11;
    } elseif($gameName == 'volleyball') {
        $gameLimit = 6;
    } else {
        // For other games, use the total_players from database or default
        $gameLimit = $totalPlayersLimit > 0 ? $totalPlayersLimit : 11;
    }

    if(!empty($players)){
        $playerCount = count($players);
        
        // Check if player count matches the game limit
        if($playerCount == $gameLimit) {
            // Check if any of these players are already in another team for this game
            $ids = implode(",", array_map('intval', $players));
            
            $checkExistingQuery = "SELECT player_ids FROM teams WHERE coordinator_email='$user_email' AND game_name='$selected_game'";
            $checkResult = mysqli_query($con, $checkExistingQuery);
            $existingPlayerIds = [];
            while($existingRow = mysqli_fetch_assoc($checkResult)) {
                $existingIds = explode(",", $existingRow['player_ids']);
                $existingPlayerIds = array_merge($existingPlayerIds, $existingIds);
            }
            
            $duplicatePlayers = array_intersect($players, $existingPlayerIds);
            
            if(empty($duplicatePlayers)) {
                $res = mysqli_query($con,
                "SELECT full_name, enrollment_no, branch FROM event_register WHERE id IN ($ids)");

                while($row = mysqli_fetch_assoc($res)){
                    $team[] = $row;
                }

                // Get next team number for this event
                $countQuery = "SELECT COUNT(*) as team_count FROM teams WHERE game_name = '$selected_game' AND coordinator_email = '$user_email'";
                $countResult = mysqli_query($con, $countQuery);
                $teamCount = mysqli_fetch_assoc($countResult);
                $nextTeamNumber = $teamCount['team_count'] + 1;
                $teamNumber = $nextTeamNumber;
                
                // Generate team name
                $teamName = $selected_game . " Team " . $nextTeamNumber;
                $createdTeamName = $teamName;
                $createdEventName = $selected_game;
                
                // Save team to database
                $insertQuery = "INSERT INTO teams (team_name, event_name, event_type, game_name, school, coordinator_email, coordinator_role, player_ids, player_count) 
                                VALUES ('$teamName', '$selected_game', '$selected_type', '$selected_game', '$school', '$user_email', '$role', '$ids', $playerCount)";
                
                if(mysqli_query($con, $insertQuery)) {
                    $msg = "✅ Team Created Successfully! Team: $teamName | Total Players: $playerCount (Required: $gameLimit)";
                    $selectedPlayers = $players;
                } else {
                    $msg = "⚠️ Error saving team to database!";
                }
            } else {
                $duplicateNames = [];
                $dupIds = implode(",", $duplicatePlayers);
                $dupQuery = "SELECT full_name FROM event_register WHERE id IN ($dupIds)";
                $dupResult = mysqli_query($con, $dupQuery);
                while($dup = mysqli_fetch_assoc($dupResult)) {
                    $duplicateNames[] = $dup['full_name'];
                }
                $msg = "⚠️ The following players are already in another team for $selected_game: " . implode(", ", $duplicateNames);
            }
        } else {
            $errorMsg = "⚠️ For $selected_game, you must select exactly $gameLimit players. You selected $playerCount players.";
            $msg = $errorMsg;
        }
    } else {
        $msg = "⚠️ Please select at least one player!";
    }
}

// Get all teams for this coordinator
$allTeams = [];
$teamsQuery = "SELECT * FROM teams WHERE coordinator_email = '$user_email' ORDER BY created_at DESC";
$teamsResult = mysqli_query($con, $teamsQuery);
if($teamsResult) {
    while($row = mysqli_fetch_assoc($teamsResult)) {
        $allTeams[] = $row;
    }
}

// Get the current limit for display
$currentGameLimit = 0;
if(isset($_POST['game'])) {
    $gameName = strtolower($_POST['game']);
    if($gameName == 'cricket') $currentGameLimit = 11;
    elseif($gameName == 'football') $currentGameLimit = 11;
    elseif($gameName == 'volleyball') $currentGameLimit = 6;
    else $currentGameLimit = $totalPlayersLimit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Create Team - Co-coordinator</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<style>
    /* Reset & Background */
    body { 
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
        color: #333;
        background: #f8f9fa;
    }

    /* The Central Container */
    .box { 
        max-width: 800px; 
        margin: 0 auto 50px auto; 
        padding: 0 15px;
    }

    /* Form Card */
    .card {
        background: #fff;
        border: none;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    /* Form Elements */
    label { 
        font-weight: 600; 
        margin-top: 15px; 
        margin-bottom: 8px; 
        font-size: 0.9rem;
        color: #555;
    }
    
    .form-control, .form-select {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 10px;
        transition: all 0.3s;
    }

    .form-control:focus, .form-select:focus {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.15);
    }

    /* Action Button */
    .btn-red {
        background: #dc3545;
        border: none;
        padding: 12px;
        font-weight: 600;
        border-radius: 8px;
        margin-top: 25px;
        transition: background 0.3s;
        width: 100%;
    }

    .btn-red:hover {
        background: #b02a37;
        color: #fff;
    }
    
    .btn-red:disabled {
        background: #6c757d;
        cursor: not-allowed;
    }

    /* Players List with Checkboxes */
    .players-list {
        border: 1px solid #e1e4e8;
        border-radius: 8px;
        overflow: hidden;
        background: #fff;
    }
    
    .select-all-container {
        padding: 12px 15px;
        background: #f8f9fa;
        border-bottom: 1px solid #e1e4e8;
        font-weight: 600;
    }
    
    .select-all-label {
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
    }
    
    .select-all-label input {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }
    
    .players-grid {
        max-height: 400px;
        overflow-y: auto;
    }
    
    .player-checkbox-label {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 12px 15px;
        margin: 0;
        cursor: pointer;
        border-bottom: 1px solid #f0f0f0;
        transition: background 0.2s;
    }
    
    .player-checkbox-label:hover:not(.disabled-player) {
        background: #f8f9fa;
    }
    
    .disabled-player {
        opacity: 0.6;
        cursor: not-allowed;
        background: #f8f9fa;
    }
    
    .player-checkbox-label input {
        width: 18px;
        height: 18px;
        margin-top: 2px;
        cursor: pointer;
    }
    
    .disabled-player input {
        cursor: not-allowed;
    }
    
    .player-info {
        flex: 1;
    }
    
    .player-info strong {
        color: #dc3545;
        font-size: 1rem;
    }
    
    .player-info small {
        color: #6c757d;
        font-size: 0.8rem;
    }
    
    /* Scrollbar Styling */
    .players-grid::-webkit-scrollbar {
        width: 6px;
    }
    
    .players-grid::-webkit-scrollbar-track {
        background: #f1f1f1;
    }
    
    .players-grid::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 10px;
    }
    
    .players-grid::-webkit-scrollbar-thumb:hover {
        background: #dc3545;
    }

    /* Team Cards Styling */
    .teams-container {
        margin-top: 30px;
    }
    
    .teams-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #dc3545;
    }
    
    .teams-header h3 {
        color: #dc3545;
        font-weight: 700;
        margin: 0;
    }
    
    .teams-header .badge {
        background: #dc3545;
        padding: 5px 12px;
        border-radius: 20px;
    }
    
    .team-card-item {
        background: #fff;
        border-radius: 12px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .team-card-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(220, 53, 69, 0.15);
    }
    
    .team-header {
        background: linear-gradient(135deg, #dc3545, #b02a37);
        color: white;
        padding: 15px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }
    
    .team-name {
        font-size: 1.3rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .team-name i {
        font-size: 1.5rem;
    }
    
    .event-badge {
        background: rgba(255,255,255,0.2);
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 500;
    }
    
    .team-body {
        padding: 20px;
    }
    
    .team-info {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .info-item {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #666;
        font-size: 0.9rem;
    }
    
    .info-item i {
        color: #dc3545;
        font-size: 1.1rem;
    }
    
    .players-list-team {
        margin-top: 15px;
    }
    
    .players-list-team h6 {
        color: #dc3545;
        font-weight: 600;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .team-players-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 10px;
    }
    
    .team-player-item {
        padding: 8px 12px;
        background: #f8f9fa;
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 0.9rem;
    }
    
    .team-player-item i {
        color: #dc3545;
        font-size: 1rem;
    }
    
    .team-player-item strong {
        color: #333;
    }
    
    .team-footer {
        background: #f8f9fa;
        padding: 12px 20px;
        display: flex;
        justify-content: flex-end;
        border-top: 1px solid #f0f0f0;
        font-size: 0.85rem;
        color: #666;
    }
    
    .alert-info { 
        border-radius: 8px; 
        border: none; 
        font-weight: 500; 
        background: #d1ecf1;
        color: #0c5460;
    }
    
    .alert-success {
        background: #d4edda;
        color: #155724;
        border-radius: 8px;
    }
    
    .alert-danger {
        background: #f8d7da;
        color: #721c24;
        border-radius: 8px;
    }
    
    .limit-info {
        background: #e7f3ff;
        border-left: 4px solid #dc3545;
        padding: 10px 15px;
        border-radius: 8px;
        margin-top: 10px;
        font-size: 14px;
    }
    
    .limit-info i {
        color: #dc3545;
        margin-right: 8px;
    }
    
    .selected-count {
        font-size: 13px;
        margin-top: 8px;
        color: #666;
    }
    
    .selected-count span {
        font-weight: bold;
        color: #dc3545;
    }
    
    .empty-teams {
        text-align: center;
        padding: 40px;
        background: #f8f9fa;
        border-radius: 12px;
        color: #999;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .box {
            max-width: 100%;
        }
        
        .card {
            padding: 20px;
        }
        
        .player-checkbox-label {
            flex-direction: column;
            gap: 5px;
        }
        
        .player-checkbox-label input {
            margin-left: 0;
        }
        
        .team-players-grid {
            grid-template-columns: 1fr;
        }
        
        .team-header {
            flex-direction: column;
            text-align: center;
        }
    }
</style>
</head>

<body>

<!-- HERO -->
<section class="hero">
    <h1>Create a Team</h1>
    <p>Select players to form your team for <?php echo htmlspecialchars($role); ?></p>
</section>

<div class="box">

<div class="card shadow">
    <form method="post" id="teamForm" onsubmit="return validatePlayerCount()">
        <center>
            <h2 style="color:#b02a37; margin-bottom: 20px;">
                <i class="bi bi-people-fill"></i> Create a Team
            </h2>
        </center>
        
        <!-- GAME TYPE -->
        <label><i class="bi bi-grid"></i> Game Type</label>
        <select id="type" class="form-select" required>
            <option value="">Select Game Type</option>
            <option value="Outdoor">🏃 Outdoor</option>
            <option value="Indoor">🎯 Indoor</option>
            <option value="Cultural">🎭 Cultural</option>
        </select>

        <!-- GAME (AUTO BASED ON ROLE) -->
        <label><i class="bi bi-trophy"></i> Game</label>
        <select name="game" id="game" class="form-select" required>
            <option value="">First select game type</option>
        </select>
        
        <input type="hidden" name="selected_type" id="selected_type">

        <!-- PLAYERS with Checkboxes -->
        <label><i class="bi bi-person-arms-up"></i> Select Players</label>
        <div id="players-container">
            <div class="alert alert-info">Please select a game first to see players.</div>
        </div>
        
        <div id="limitInfo" class="limit-info" style="display: none;">
            <i class="bi bi-info-circle"></i>
            <span id="limitText"></span>
        </div>
        
        <div id="selectedCountDisplay" class="selected-count" style="display: none;">
            Selected Players: <span id="selectedCount">0</span>
        </div>

        <button type="submit" name="create_team" id="submitBtn" class="btn btn-red">
            <i class="bi bi-check-circle"></i> Create Team
        </button>
    </form>
</div>

<!-- MESSAGE -->
<?php if($msg): ?>
<div class="alert alert-<?php echo strpos($msg, '✅') !== false ? 'success' : (strpos($msg, '⚠️') !== false ? 'danger' : 'warning'); ?> mt-3">
    <i class="bi bi-<?php echo strpos($msg, '✅') !== false ? 'check-circle' : (strpos($msg, '⚠️') !== false ? 'exclamation-triangle' : 'info-circle'); ?>"></i> 
    <?php echo $msg; ?>
</div>
<?php endif; ?>

<!-- TEAMS CONTAINER - Show all created teams -->
<div class="teams-container">
    <div class="teams-header">
        <h3><i class="bi bi-trophy-fill"></i> My Teams</h3>
        <span class="badge"><?php echo count($allTeams); ?> Teams Created</span>
    </div>
    
    <?php if(!empty($allTeams)): ?>
        <?php foreach($allTeams as $index => $teamData): 
            // Get player names for this team
            $playerIds = explode(",", $teamData['player_ids']);
            $playerIdsStr = implode(",", array_map('intval', $playerIds));
            $playersQuery = "SELECT full_name, enrollment_no, branch FROM event_register WHERE id IN ($playerIdsStr)";
            $playersResult = mysqli_query($con, $playersQuery);
            $teamPlayers = [];
            while($player = mysqli_fetch_assoc($playersResult)) {
                $teamPlayers[] = $player;
            }
        ?>
        <div class="team-card-item">
            <div class="team-header">
                <div class="team-name">
                    <i class="bi bi-people-fill"></i>
                    <?php echo htmlspecialchars($teamData['team_name']); ?>
                </div>
                <div class="event-badge">
                    <i class="bi bi-calendar-event"></i> <?php echo htmlspecialchars($teamData['event_name']); ?>
                </div>
            </div>
            <div class="team-body">
                <div class="team-info">
                    <div class="info-item">
                        <i class="bi bi-trophy"></i>
                        <span>Game: <strong><?php echo htmlspecialchars($teamData['game_name']); ?></strong></span>
                    </div>
                    <div class="info-item">
                        <i class="bi bi-building"></i>
                        <span>School: <strong><?php echo htmlspecialchars($teamData['school']); ?></strong></span>
                    </div>
                    <div class="info-item">
                        <i class="bi bi-person-badge"></i>
                        <span>Players: <strong><?php echo $teamData['player_count']; ?></strong></span>
                    </div>
                    <div class="info-item">
                        <i class="bi bi-calendar"></i>
                        <span>Created: <strong><?php echo date('d M Y', strtotime($teamData['created_at'])); ?></strong></span>
                    </div>
                </div>
                
                <div class="players-list-team">
                    <h6><i class="bi bi-person-arms-up"></i> Team Members</h6>
                    <div class="team-players-grid">
                        <?php foreach($teamPlayers as $player): ?>
                        <div class="team-player-item">
                            <i class="bi bi-person-circle"></i>
                            <div>
                                <strong><?php echo htmlspecialchars($player['full_name']); ?></strong>
                                <br>
                                <small><?php echo htmlspecialchars($player['enrollment_no']); ?> | <?php echo htmlspecialchars($player['branch']); ?></small>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="team-footer">
                <i class="bi bi-clock-history"></i> Team ID: #<?php echo $teamData['id']; ?>
            </div>
        </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="empty-teams">
            <i class="bi bi-people" style="font-size: 48px; opacity: 0.3;"></i>
            <h5 class="mt-3">No Teams Created Yet</h5>
            <p class="text-muted">Create your first team by filling out the form above.</p>
        </div>
    <?php endif; ?>
</div>

</div>

<?php include 'footer.php'; ?>

<script>

// Get game limit based on game name
function getGameLimit(gameName) {
    const game = gameName.toLowerCase();
    if(game === 'cricket') return 11;
    if(game === 'football') return 11;
    if(game === 'volleyball') return 6;
    return <?php echo $totalPlayersLimit > 0 ? $totalPlayersLimit : 11; ?>;
}

// Update limit info display
function updateLimitInfo(gameName) {
    const limit = getGameLimit(gameName);
    const limitInfo = document.getElementById('limitInfo');
    const limitText = document.getElementById('limitText');
    
    if(gameName && gameName !== '') {
        limitInfo.style.display = 'block';
        limitText.innerHTML = `For ${gameName}, you must select exactly ${limit} player${limit > 1 ? 's' : ''}.`;
    } else {
        limitInfo.style.display = 'none';
    }
}

// Update selected count and validate button
function updateSelectedCount() {
    const checkboxes = document.querySelectorAll('.player-checkbox:checked:not(:disabled)');
    const selectedCount = checkboxes.length;
    const selectedCountSpan = document.getElementById('selectedCount');
    const selectedCountDisplay = document.getElementById('selectedCountDisplay');
    const submitBtn = document.getElementById('submitBtn');
    const gameSelect = document.getElementById('game');
    const gameName = gameSelect.options[gameSelect.selectedIndex]?.text || '';
    
    if(selectedCountSpan) {
        selectedCountSpan.textContent = selectedCount;
        selectedCountDisplay.style.display = 'block';
    }
    
    // Validate based on game limit
    if(gameName && gameName !== '') {
        const limit = getGameLimit(gameName);
        if(selectedCount === limit) {
            submitBtn.disabled = false;
            submitBtn.style.opacity = '1';
            submitBtn.style.cursor = 'pointer';
        } else {
            submitBtn.disabled = true;
            submitBtn.style.opacity = '0.6';
            submitBtn.style.cursor = 'not-allowed';
        }
    } else {
        submitBtn.disabled = false;
    }
}

// 🔥 LOAD GAME (BASED ON TYPE + ROLE)
document.getElementById("type").addEventListener("change", function(){
    let type = this.value;
    
    if(type === "") {
        document.getElementById("game").innerHTML = '<option value="">Select Game Type First</option>';
        document.getElementById("players-container").innerHTML = '<div class="alert alert-info">Please select a game first to see players.</div>';
        document.getElementById("limitInfo").style.display = 'none';
        document.getElementById("selectedCountDisplay").style.display = 'none';
        return;
    }

    fetch("?ajax=games&type="+type)
    .then(res => res.text())
    .then(data => {
        document.getElementById("game").innerHTML = data;
        document.getElementById("players-container").innerHTML = '<div class="alert alert-info">Please select a game to see players.</div>';
        document.getElementById("limitInfo").style.display = 'none';
        document.getElementById("selectedCountDisplay").style.display = 'none';
    });
});

// 🔥 LOAD PLAYERS WITH CHECKBOXES
document.getElementById("game").addEventListener("change", function(){
    let type = document.getElementById("type").value;
    let game = this.value;
    let gameText = this.options[this.selectedIndex]?.text || '';
    
    document.getElementById('selected_type').value = type;
    
    if(game === "") {
        document.getElementById("players-container").innerHTML = '<div class="alert alert-info">Please select a game to see players.</div>';
        document.getElementById("limitInfo").style.display = 'none';
        document.getElementById("selectedCountDisplay").style.display = 'none';
        return;
    }

    // Update limit info
    updateLimitInfo(gameText);
    
    fetch("?ajax=players&type="+type+"&game="+encodeURIComponent(game))
    .then(res => res.text())
    .then(data => {
        document.getElementById("players-container").innerHTML = data;
        updateSelectedCount();
    });
});

// Select/Deselect All Players
function toggleAllPlayers() {
    const selectAllCheckbox = document.getElementById('selectAll');
    const allCheckboxes = document.querySelectorAll('.player-checkbox:not(:disabled)');
    const gameSelect = document.getElementById('game');
    const gameName = gameSelect.options[gameSelect.selectedIndex]?.text || '';
    const limit = getGameLimit(gameName);
    
    if(selectAllCheckbox.checked) {
        if(allCheckboxes.length === limit) {
            allCheckboxes.forEach(checkbox => {
                checkbox.checked = true;
            });
        } else {
            Swal.fire({
                title: 'Cannot Select All',
                text: `This game requires exactly ${limit} players, but only ${allCheckboxes.length} players are available.`,
                icon: 'warning',
                confirmButtonColor: '#dc3545'
            });
            selectAllCheckbox.checked = false;
            return;
        }
    } else {
        allCheckboxes.forEach(checkbox => {
            checkbox.checked = false;
        });
    }
    
    updateSelectedCount();
}

// Update Select All checkbox when individual checkboxes change
function updateSelectAll() {
    const selectAllCheckbox = document.getElementById('selectAll');
    const allCheckboxes = document.querySelectorAll('.player-checkbox:not(:disabled)');
    const checkedCheckboxes = document.querySelectorAll('.player-checkbox:checked:not(:disabled)');
    const gameSelect = document.getElementById('game');
    const gameName = gameSelect.options[gameSelect.selectedIndex]?.text || '';
    const limit = getGameLimit(gameName);
    
    if(selectAllCheckbox) {
        selectAllCheckbox.checked = allCheckboxes.length === checkedCheckboxes.length && allCheckboxes.length > 0;
    }
    
    // Prevent selecting more than limit
    if(checkedCheckboxes.length > limit) {
        const lastChecked = event?.target;
        if(lastChecked && lastChecked.checked) {
            lastChecked.checked = false;
            Swal.fire({
                title: 'Limit Reached',
                text: `You can only select exactly ${limit} players for ${gameName}.`,
                icon: 'warning',
                confirmButtonColor: '#dc3545',
                timer: 2000
            });
        }
    }
    
    updateSelectedCount();
}

// Validate before form submission
function validatePlayerCount() {
    const checkboxes = document.querySelectorAll('.player-checkbox:checked:not(:disabled)');
    const selectedCount = checkboxes.length;
    const gameSelect = document.getElementById('game');
    const gameName = gameSelect.options[gameSelect.selectedIndex]?.text || '';
    const limit = getGameLimit(gameName);
    
    if(selectedCount !== limit) {
        Swal.fire({
            title: 'Invalid Team Size',
            text: `For ${gameName}, you must select exactly ${limit} players. You have selected ${selectedCount} players.`,
            icon: 'error',
            confirmButtonColor: '#dc3545'
        });
        return false;
    }
    return true;
}

// Event delegation for dynamically added checkboxes
document.addEventListener('change', function(e) {
    if(e.target && e.target.classList && e.target.classList.contains('player-checkbox')) {
        updateSelectAll();
        updateSelectedCount();
    }
});

// Initialize submit button as disabled
document.addEventListener('DOMContentLoaded', function() {
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.disabled = true;
    submitBtn.style.opacity = '0.6';
});
</script>

<!-- SweetAlert2 for better alerts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>
</html>