<?php
include 'rules_handler.php';    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Galore 2026 – Rules & Regulations</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --galore-red: #dc3545;
            --galore-red-dark: #7a1c25;
            --cricket-color: #28a745;
            --football-color: #17a2b8;
            --carrom-color: #ffc107;
        }

        body {
            font-family: "Segoe UI", Arial, sans-serif;
            background-color: #f8f9fa;
        }

        /* ===== HERO ===== */
        .hero {
            background: linear-gradient(135deg, var(--galore-red), var(--galore-red-dark));
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
        }

        .hero p {
            font-size: 1.2rem;
            opacity: 0.95;
        }

        @media (max-width: 768px) {
            .hero {
                padding: 100px 20px 80px;
            }
            
            .hero h1 {
                font-size: 2.5rem;
            }
            
            .hero p {
                font-size: 1rem;
            }
        }

        @media (max-width: 480px) {
            .hero {
                padding: 80px 20px 70px;
            }
            
            .hero h1 {
                font-size: 1.8rem;
            }
        }

        /* ===== PAGE TITLE ===== */
        .page-title {
            text-align: center;
            margin-bottom: 30px;
        }

        .page-title h2 {
            color: var(--galore-red);
            font-weight: 800;
            font-size: 2rem;
        }

        .underline {
            width: 80px;
            height: 4px;
            background: linear-gradient(135deg, var(--galore-red), var(--galore-red-dark));
            margin: 12px auto;
            border-radius: 10px;
        }

        /* ===== RULES CARD ===== */
        .rules-card {
            background: #fff;
            border-radius: 22px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(220, 53, 69, 0.2);
            overflow: hidden;
        }

        /* ===== TABLE ===== */
        .rules-table thead tr {
            background: linear-gradient(135deg, var(--galore-red), var(--galore-red-dark));
            color: #fff;
        }

        .rules-table th {
            font-weight: 600;
            text-align: center;
            padding: 15px;
            font-size: 1rem;
        }

        .rules-table td {
            vertical-align: middle;
            padding: 15px;
        }

        .rules-table tbody tr {
            transition: background-color 0.3s ease;
            border-bottom: 1px solid #f0f0f0;
        }

        .rules-table tbody tr:hover {
            background-color: #fff5f5;
        }

        .rules-table a {
            color: var(--galore-red);
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 1rem;
        }

        .rules-table a i:first-child {
            font-size: 1.2rem;
        }

        /* Game-specific styling */
        .rule-item[data-game="cricket"] .game-badge {
            background: #28a745;
        }
        
        .rule-item[data-game="football"] .game-badge {
            background: #17a2b8;
        }
        
        .rule-item[data-game="carrom"] .game-badge {
            background: #ffc107;
            color: #333;
        }

        /* ===== DROPDOWN STYLES ===== */
        .rule-item {
            cursor: pointer;
        }

        .rule-details {
            display: none;
            background: #fef8f8;
            padding: 25px;
            border-radius: 0;
            margin: 0;
            border-top: 1px solid rgba(220, 53, 69, 0.2);
            border-bottom: 1px solid rgba(220, 53, 69, 0.2);
        }

        .rule-details.active {
            display: block;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .toggle-icon {
            transition: transform 0.3s ease;
            margin-left: auto;
        }

        /* ===== COMPACT RULES GRID ===== */
        .rules-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }

        .rule-block {
            background: white;
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            border-left: 4px solid var(--galore-red);
        }

        .rule-block:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(220, 53, 69, 0.15);
        }

        .rule-block h5 {
            color: var(--galore-red);
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
            border-bottom: 2px solid #ffe3e6;
            padding-bottom: 10px;
        }

        .rule-block h5 i {
            font-size: 1.2rem;
        }

        .rule-block p {
            margin: 8px 0;
            font-size: 0.9rem;
            line-height: 1.5;
            color: #444;
        }

        .rule-block ul {
            margin: 8px 0;
            padding-left: 20px;
            font-size: 0.9rem;
        }

        .rule-block li {
            margin: 5px 0;
            line-height: 1.4;
            color: #555;
        }

        /* Game-specific rule block styling */
        .rule-block.cricket {
            border-left-color: #28a745;
        }
        
        .rule-block.football {
            border-left-color: #17a2b8;
        }
        
        .rule-block.carrom {
            border-left-color: #ffc107;
        }

        /* No Circulars State */
        .no-circulars {
            text-align: center;
            padding: 60px 20px;
            background: #f8f9fa;
            border-radius: 20px;
            color: #6c757d;
        }

        .no-circulars i {
            font-size: 4rem;
            color: var(--galore-red);
            margin-bottom: 20px;
        }
        
        .no-circulars h4 {
            margin-bottom: 10px;
            font-size: 1.5rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .rules-table th {
                font-size: 0.85rem;
                padding: 10px;
            }
            
            .rules-table td {
                padding: 12px;
            }
            
            .rules-table a {
                font-size: 0.9rem;
                gap: 8px;
            }
            
            .rule-details {
                padding: 15px;
            }
            
            .rules-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }
            
            .rule-block {
                padding: 15px;
            }
            
            .rule-block h5 {
                font-size: 1rem;
            }
            
            .page-title h2 {
                font-size: 1.5rem;
            }
        }
        
        @media (max-width: 480px) {
            .rules-table th, .rules-table td {
                padding: 8px;
            }
            
            .rules-table a {
                font-size: 0.8rem;
            }
            
            .rule-block p, .rule-block li {
                font-size: 0.8rem;
            }
        }
    </style>
</head>

<body>

    <?php 
    // Silent include for navbar
    if (file_exists('navbar.php')) {
        include 'navbar.php';
    }
    ?>

    <!-- ===== HERO - DYNAMIC ===== -->
    <section class="hero">
        <h1>
            <?php echo safeGet($header_data, 'hero_title', 'Galore 2026'); ?>
        </h1>
        <p>
            <?php echo safeGet($header_data, 'hero_subtitle', 'Official Rules & Regulations'); ?>
        </p>
    </section>

    <!-- ===== CONTENT ===== -->
    <div class="container my-5">

        <div class="page-title">
            <h2>
                <?php echo safeGet($header_data, 'title', 'Sports Rules & Regulations'); ?>
            </h2>
            <div class="underline"></div>
        </div>

        <div class="rules-card">
            <div class="table-responsive">
                <table class="table rules-table mb-0">
                    <thead>
                        <tr>
                            <th width="20%"><i class="fa-regular fa-calendar me-2"></i> Date</th>
                            <th width="80%"><i class="fa-regular fa-file-lines me-2"></i> Game Rules</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($circulars)): ?>
                            <tr>
                                <td colspan="2" class="text-center p-5">
                                    <div class="no-circulars">
                                        <i class="fa-solid fa-file-circle-exclamation"></i>
                                        <h4>No Circulars Available</h4>
                                        <p class="text-muted">Please check back later for updated rules and circulars.</p>
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($circulars as $index => $circular): 
                                $target_id = "rules-" . (isset($circular['id']) ? $circular['id'] : $index);
                                $circular_date = isset($circular['circular_date']) ? $circular['circular_date'] : 'Date TBA';
                                $display_name = isset($circular['display_name']) ? $circular['display_name'] : 'Circular';
                                
                                // Determine game type for styling
                                $game_type = 'default';
                                $name_lower = strtolower($display_name);
                                if (strpos($name_lower, 'cricket') !== false) $game_type = 'cricket';
                                elseif (strpos($name_lower, 'football') !== false) $game_type = 'football';
                                elseif (strpos($name_lower, 'carrom') !== false) $game_type = 'carrom';
                            ?>
                                <!-- Main Rule Item -->
                                <tr class="rule-item" data-target="<?php echo $target_id; ?>" data-game="<?php echo $game_type; ?>">
                                    <td class="text-center">
                                        <span class="badge bg-danger bg-opacity-10 text-danger p-2 rounded-pill">
                                            <i class="fa-regular fa-calendar-alt me-1"></i> <?php echo htmlspecialchars($circular_date); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="javascript:void(0);" class="d-flex align-items-center">
                                            <?php echo getGameIcon($display_name); ?>
                                            <span class="fw-semibold"><?php echo htmlspecialchars($display_name); ?></span>
                                            <i class="fa-solid fa-chevron-right toggle-icon ms-auto"></i>
                                        </a>
                                    </td>
                                </tr>
                                
                                <!-- Rule Details Row -->
                                <tr>
                                    <td colspan="2" class="p-0 border-0">
                                        <div id="<?php echo $target_id; ?>" class="rule-details">
                                            <?php 
                                            $rules_data = isset($circular['rules_data']) ? $circular['rules_data'] : [];
                                            if (!empty($rules_data) && is_array($rules_data)): 
                                            ?>
                                                <div class="rules-grid">
                                                    <?php foreach ($rules_data as $rule_category): 
                                                        if (!is_array($rule_category)) continue;
                                                        $category = isset($rule_category['category']) ? $rule_category['category'] : 'Rules';
                                                        $rules = isset($rule_category['rules']) && is_array($rule_category['rules']) ? $rule_category['rules'] : [];
                                                        
                                                        // Extract category icon from category text (if contains emoji)
                                                        $category_display = $category;
                                                    ?>
                                                        <div class="rule-block <?php echo $game_type; ?>">
                                                            <h5>
                                                                <?php echo htmlspecialchars($category_display); ?>
                                                            </h5>
                                                            <?php foreach ($rules as $rule): 
                                                                if (empty($rule)) continue;
                                                                // Check if rule contains bullet points
                                                                if (strpos($rule, '<br>') !== false):
                                                                    $sub_rules = explode('<br>', $rule);
                                                            ?>
                                                                    <ul class="mb-2">
                                                                        <?php foreach ($sub_rules as $sub_rule): 
                                                                            $trimmed_rule = trim($sub_rule);
                                                                            if ($trimmed_rule != ''):
                                                                        ?>
                                                                            <li><?php echo htmlspecialchars($trimmed_rule); ?></li>
                                                                        <?php endif; ?>
                                                                        <?php endforeach; ?>
                                                                    </ul>
                                                                <?php else: ?>
                                                                    <p class="mb-2">• <?php echo htmlspecialchars($rule); ?></p>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            <?php else: ?>
                                                <p class="text-muted text-center mb-0 py-4">
                                                    <i class="fa-regular fa-folder-open me-2"></i> 
                                                    No detailed rules available for this circular.
                                                </p>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Info Section -->
        <div class="text-center mt-4">
            <p class="text-muted small">
                <i class="fa-regular fa-circle-info me-1"></i> 
                For any queries regarding rules, please contact the sports coordinator.
            </p>
        </div>
    </div>

    <?php 
    // Silent include for footer
    if (file_exists('footer.php')) {
        include 'footer.php';
    }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ruleItems = document.querySelectorAll('.rule-item');
            
            if (ruleItems.length > 0) {
                ruleItems.forEach(item => {
                    item.addEventListener('click', function(e) {
                        // Don't trigger if clicking on links inside that might have their own behavior
                        if (e.target.closest('a') && e.target.closest('a') !== this.querySelector('a')) {
                            return;
                        }
                        
                        const targetId = this.getAttribute('data-target');
                        if (targetId) {
                            const ruleDetails = document.getElementById(targetId);
                            const toggleIcon = this.querySelector('.toggle-icon');
                            
                            if (ruleDetails) {
                                // Check if this rule is already open
                                const isActive = ruleDetails.classList.contains('active');
                                
                                // Close all other open rule details
                                document.querySelectorAll('.rule-details.active').forEach(detail => {
                                    detail.classList.remove('active');
                                    const otherIcon = document.querySelector(`[data-target="${detail.id}"] .toggle-icon`);
                                    if (otherIcon) {
                                        otherIcon.className = 'fa-solid fa-chevron-right toggle-icon ms-auto';
                                    }
                                });
                                
                                // Toggle current (if it wasn't active, open it; if it was active, it's now closed)
                                if (!isActive) {
                                    ruleDetails.classList.add('active');
                                    if (toggleIcon) {
                                        toggleIcon.className = 'fa-solid fa-chevron-down toggle-icon ms-auto';
                                    }
                                } else {
                                    // Already closed by the loop above, just ensure icon is correct
                                    if (toggleIcon) {
                                        toggleIcon.className = 'fa-solid fa-chevron-right toggle-icon ms-auto';
                                    }
                                }
                            }
                        }
                    });
                });
            }
            
            // Optional: If there's a hash in URL, open that rule automatically
            if (window.location.hash) {
                const targetId = window.location.hash.substring(1);
                const targetDetail = document.getElementById(targetId);
                if (targetDetail) {
                    const parentItem = document.querySelector(`[data-target="${targetId}"]`);
                    if (parentItem) {
                        parentItem.click();
                        // Scroll to the rule details
                        setTimeout(() => {
                            targetDetail.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        }, 100);
                    }
                }
            }
        });
    </script>

</body>

</html>

<?php
// Close connection silently
if (isset($conn) && $conn) {
    @mysqli_close($conn);
}
?>