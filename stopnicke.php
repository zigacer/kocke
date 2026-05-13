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
    <title>Casino - Stopničke</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
</head>
<body class="casino-theme">
    <div class="neon-title" style="margin-top: 50px;">
        <h1>KONČNI REZULTATI</h1>
    </div>

    <div class="podium-container">
        <?php 
        $mesto = 1;
        $emoji = [1 => "🏆", 2 => "🥈", 3 => "🥉"];
        foreach ($sestevki as $id => $tocke): 
        ?>
            <div class="podium-item place-<?php echo $mesto; ?>">
                <div class="medal"><?php echo $emoji[$mesto]; ?></div>
                <div class="podium-points"><?php echo $tocke; ?> točk</div>
                <div class="podium-name"><?php echo htmlspecialchars($uporabniki[$id]['ime']); ?></div>
                <div class="step"></div>
            </div>
        <?php $mesto++; endforeach; ?>
    </div>

    <div style="text-align: center; margin-top: 50px;">
        <button onclick="window.location.href='index.php'" class="btn-gold">NOVA IGRA</button>
    </div>

    <script>
        window.onload = function() {
            var end = Date.now() + (5 * 1000);
            (function frame() {
              confetti({ particleCount: 3, angle: 60, spread: 55, origin: { x: 0 } });
              confetti({ particleCount: 3, angle: 120, spread: 55, origin: { x: 1 } });
              if (Date.now() < end) { requestAnimationFrame(frame); }
            }());
        };
    </script>
</body>
</html>