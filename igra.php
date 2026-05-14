<?php
session_start();

if (isset($_POST['start_game'])) {
    $_SESSION['uporabniki'] = $_POST['user'];
    $_SESSION['runda'] = 1;
    $_SESSION['zgodovina_metov'] = [];
    $_SESSION['sestevki'] = [1 => 0, 2 => 0, 3 => 0];
}

if (!isset($_SESSION['uporabniki'])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST['next_round']) && $_SESSION['runda'] < 3) {
    $_SESSION['runda']++;
}

$runda = $_SESSION['runda'];
$uporabniki = $_SESSION['uporabniki'];

if (!isset($_SESSION['zgodovina_metov'][1][$runda])) {
    foreach ($uporabniki as $id => $u) {
        $met = rand(1, 6);
        $_SESSION['zgodovina_metov'][$id][$runda] = $met;
        $_SESSION['sestevki'][$id] += $met;
    }
}

$zgodovina = $_SESSION['zgodovina_metov'];
$sestevki = $_SESSION['sestevki'];
?>

<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <title>Casino - Runda <?php echo $runda; ?></title>
    <link rel="stylesheet" href="style.css">
	<link rel="icon" type="image/x-icon" href="slike/favicon.png">
</head>
<body class="casino-theme">

    <div class="neon-title">
        <h1>RUNDA <?php echo $runda; ?>/3</h1>
    </div>

    <div class="igralna-povrsina">
        <?php foreach ($uporabniki as $id => $u): ?>
            <div class="kartica">
                <div class="igralec-info">
                    <h3 style="margin:0;"><?php echo htmlspecialchars($u['ime'] . " " . $u['priimek']); ?></h3>
                    <p style="margin:5px 0;">Točke: 
                        <strong id="sum-<?php echo $id; ?>" style="display: none; color:#c0392b; font-size:1.4em;">
                            <?php echo $sestevki[$id]; ?>
                        </strong>
                        <span id="loader-<?php echo $id; ?>">...</span>
                    </p>
                </div>
                <div class="kocke">
                    <?php 
                    for ($r = 1; $r <= $runda; $r++) {
                        $vrednost = $zgodovina[$id][$r];
                        echo '<div class="dice-container">';
                        if ($r == $runda) {
                            echo '<img src="slike/dice-anim.gif" class="dice-anim" id="anim-'.$id.'">';
                            echo '<img src="slike/dice'.$vrednost.'.gif" class="dice-static hidden" id="static-'.$id.'">';
                        } else {
                            echo '<img src="slike/dice'.$vrednost.'.gif" class="dice-static">';
                        }
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div id="controls-section" style="display: none; text-align: center; margin-top: 30px;">
        <?php if ($runda < 3): ?>
            <form method="POST">
                <button type="submit" name="next_round" class="btn-gold">NASLEDNJA RUNDA</button>
            </form>
        <?php else: ?>
            <button onclick="window.location.href='stopnicke.php'" class="btn-gold">POGLEJ REZULTATE 🏆</button>
        <?php endif; ?>
    </div>

    <script>
        window.onload = function() {
            setTimeout(function() {
                for (let id = 1; id <= 3; id++) {
                    let anim = document.getElementById('anim-' + id);
                    let stat = document.getElementById('static-' + id);
                    let sum = document.getElementById('sum-' + id);
                    let load = document.getElementById('loader-' + id);
                    if (anim) anim.style.display = 'none';
                    if (stat) stat.classList.remove('hidden');
                    if (sum) sum.style.display = 'inline';
                    if (load) load.style.display = 'none';
                }
                document.getElementById('controls-section').style.display = 'block';
            }, 2000);
        };
    </script>
</body>
</html>