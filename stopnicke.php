<?php
session_start();
if (!isset($_SESSION['sestevki'])) { header("Location: index.php"); exit(); }
$uporabniki = $_SESSION['uporabniki'];
$sestevki = $_SESSION['sestevki'];
arsort($sestevki);
?>
<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="10;url=index.php">
    <title>Casino - Stopničke</title>
    <link rel="stylesheet" href="style.css">
	<link rel="icon" type="image/x-icon" href="slike/favicon.png">
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    <style>
        .podium-container {
            height: 200px !important;
            max-width: 500px;
            margin: 40px auto !important;
        }
        .place-1 .step { height: 120px !important; }
        .place-2 .step { height: 80px !important; }
        .place-3 .step { height: 50px !important; }
        .medal { font-size: 3em !important; margin-bottom: -5px; }
        .podium-name { font-size: 1.1em !important; }
    </style>
</head>
<body class="casino-theme">
    <div class="neon-title" style="margin-top: 50px;">
        <h1>KONČNI REZULTATI</h1>
    </div>

    <div class="podium-container">
        <?php 
        $mesto = 1;
        $emoji = [1 => "🥇", 2 => "🥈", 3 => "🥉"];
        foreach ($sestevki as $id => $tocke): 
        ?>
            <div class="podium-item place-<?php echo $mesto; ?>">
                <div class="medal"><?php echo $emoji[$mesto]; ?></div>
                <div class="podium-points"><?php echo $tocke; ?> točk</div>
                <div class="podium-name"><?php echo htmlspecialchars($uporabniki[$id]['uporabnisko_ime']); ?></div>
                <div class="step"></div>
            </div>
        <?php $mesto++; endforeach; ?>
    </div>

    <div style="text-align: center; margin-top: 30px;">
        <p style="color: #f1c40f; font-size: 1.2em;">
            Nova igra se bo samodejno začela čez <span id="countdown">10</span> sekund...
        </p>
    </div>

    <script>
        window.onload = function() {
            // Funkcija za konfete (neskončno)
            (function frame() {
              confetti({ particleCount: 3, angle: 60, spread: 55, origin: { x: 0 }, zIndex: 100 });
              confetti({ particleCount: 3, angle: 120, spread: 55, origin: { x: 1 }, zIndex: 100 });
              requestAnimationFrame(frame);
            }());

            // Logika za odštevanje sekund
            let s = 10;
            const el = document.getElementById('countdown');
            const interval = setInterval(() => {
                s--;
                if (s >= 0) {
                    el.innerText = s;
                }
                if (s <= 0) {
                    clearInterval(interval);
                }
            }, 1000);
        };
    </script>
</body>
</html>