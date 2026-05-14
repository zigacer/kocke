<?php
session_start();

if (isset($_POST['start_game'])) {
    $_SESSION['uporabniki'] = $_POST['user'];
    $_SESSION['st_rund'] = (int)$_POST['st_rund'];
    $_SESSION['st_kock'] = (int)$_POST['st_kock'];
    $_SESSION['runda'] = 1;
    $_SESSION['zgodovina_metov'] = [];
    $_SESSION['sestevki'] = [1 => 0, 2 => 0, 3 => 0];
}

if (!isset($_SESSION['uporabniki'])) {
    header("Location: index.php");
    exit();
}

$st_rund = $_SESSION['st_rund'];
$st_kock = $_SESSION['st_kock'];

if (isset($_POST['next_round']) && $_SESSION['runda'] < $st_rund) {
    $_SESSION['runda']++;
}

$runda = $_SESSION['runda'];
$uporabniki = $_SESSION['uporabniki'];

// Generiranje metov za trenutno rundo
if (!isset($_SESSION['zgodovina_metov'][1][$runda])) {
    foreach ($uporabniki as $id => $u) {
        for ($k = 1; $k <= $st_kock; $k++) {
            $met = rand(1, 6);
            $_SESSION['zgodovina_metov'][$id][$runda][$k] = $met;
            $_SESSION['sestevki'][$id] += $met;
        }
    }
}

$zgodovina = $_SESSION['zgodovina_metov'];
$sestevki_trenutni = $_SESSION['sestevki'];

// Izračun točk PRED trenutno rundo (da se lahko posodobi po animaciji)
$sestevki_pred = [1 => 0, 2 => 0, 3 => 0];
foreach ($uporabniki as $id => $u) {
    for ($r = 1; $r < $runda; $r++) {
        if (isset($zgodovina[$id][$r])) {
            foreach ($zgodovina[$id][$r] as $met) {
                $sestevki_pred[$id] += $met;
            }
        }
    }
}
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
        <h1>RUNDA <?php echo $runda; ?>/<?php echo $st_rund; ?></h1>
    </div>

    <div class="igralna-povrsina">
        <?php foreach ($uporabniki as $id => $u): ?>
            <div class="kartica">
                <div class="igralec-info">
                    <h3 style="margin:0;"><?php echo htmlspecialchars($u['uporabnisko_ime']); ?></h3>
                    <p style="margin:5px 0;">Točke: 
                        <strong id="sum-<?php echo $id; ?>" data-newsum="<?php echo $sestevki_trenutni[$id]; ?>" style="color:#c0392b; font-size:1.4em;">
                            <?php echo $sestevki_pred[$id]; ?>
                        </strong>
                        <span id="loader-<?php echo $id; ?>" style="color:#f1c40f; font-size:0.9em; margin-left: 5px;">(kocke se vrtijo...)</span>
                    </p>
                </div>
                <div class="kocke">
                    <?php 
                    // Prikažemo SAMO kocke trenutne runde
                    for ($k = 1; $k <= $st_kock; $k++) {
                        $vrednost = $zgodovina[$id][$runda][$k];
                        echo '<div class="dice-container">';
                        echo '<img src="slike/dice-anim.gif" class="dice-anim" id="anim-'.$id.'-'.$k.'">';
                        echo '<img src="slike/dice'.$vrednost.'.gif" class="dice-static hidden" id="static-'.$id.'-'.$k.'">';
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div id="controls-section" style="display: none; text-align: center; margin-top: 30px;">
        <?php if ($runda < $st_rund): ?>
            <form method="POST">
                <button type="submit" name="next_round" class="btn-gold">NASLEDNJA RUNDA</button>
            </form>
        <?php else: ?>
            <button onclick="window.location.href='stopnicke.php'" class="btn-gold">POGLEJ REZULTATE</button>
        <?php endif; ?>
    </div>

    <script>
        window.onload = function() {
            setTimeout(function() {
                let numDice = <?php echo $st_kock; ?>;
                for (let id = 1; id <= 3; id++) {
                    // Ustavi animacijo in prikaži statične kocke
                    for (let k = 1; k <= numDice; k++) {
                        let anim = document.getElementById('anim-' + id + '-' + k);
                        let stat = document.getElementById('static-' + id + '-' + k);
                        if (anim) anim.style.display = 'none';
                        if (stat) stat.classList.remove('hidden');
                    }
                    // Posodobi rezultat in skrij nalagalnik
                    let sum = document.getElementById('sum-' + id);
                    let load = document.getElementById('loader-' + id);
                    if (sum) {
                        sum.innerHTML = sum.getAttribute('data-newsum');
                    }
                    if (load) load.style.display = 'none';
                }
                document.getElementById('controls-section').style.display = 'block';
            }, 2000);
        };
    </script>
</body>
</html>