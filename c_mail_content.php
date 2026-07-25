<?php
// c_mail_content.php
function getMailContent($title, $content, $game = "General") {
    return '
    <!DOCTYPE html>
    <html>
    <head>
        <style>
            body {
                font-family: "Segoe UI", Arial, sans-serif;
                margin: 0;
                padding: 0;
                background-color: #f4f7f7;
            }
            .email-container {
                max-width: 600px;
                margin: 20px auto;
                background: #ffffff;
                border-radius: 10px;
                overflow: hidden;
                box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            }
            .header {
                background: linear-gradient(135deg, #dc3545 0%, #b02a37 100%);
                color: white;
                padding: 30px;
                text-align: center;
            }
            .header h1 {
                margin: 0;
                font-size: 24px;
            }
            .game-badge {
                display: inline-block;
                background: rgba(255,255,255,0.2);
                padding: 5px 15px;
                border-radius: 20px;
                margin-top: 10px;
                font-size: 14px;
            }
            .content {
                padding: 30px;
                color: #333;
                line-height: 1.6;
            }
            .footer {
                background: #f8f9fa;
                padding: 20px;
                text-align: center;
                font-size: 12px;
                color: #6c757d;
            }
        </style>
    </head>
    <body>
        <div class="email-container">
            <div class="header">
                <h1>📢 ' . htmlspecialchars($title) . '</h1>
                <div class="game-badge">🎮 ' . htmlspecialchars($game) . ' Announcement</div>
            </div>
            <div class="content">
                ' . nl2br(htmlspecialchars($content)) . '
            </div>
            <div class="footer">
                <p>Galore 2026 - RK University</p>
                <p>This is an automated announcement. Please do not reply.</p>
            </div>
        </div>
    </body>
    </html>';
}
?>