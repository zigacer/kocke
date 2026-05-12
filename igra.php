<?php
session_start();

// 1. INICIALIZACIJA
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

// 2. LOGIKA RUNDE
if (isset($_POST['next_round']) && $_SESSION['runda'] < 3) {
    $_SESSION['runda']++;
}

$runda = $_SESSION['runda'];
$uporabniki = $_SESSION['uporabniki'];

// 3. GENERIRANJE META
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
    <title>Kocke - Runda <?php echo $runda; ?></title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Zagotovimo, da imamo osnovne stile za skrivanje tukaj, če style.css ne prime */
        .hidden { display: none !important; }
        .dice-container { position: relative; width: 70px; height: 70px; display: inline-block; margin: 10px; vertical-align: top; }
        .dice-anim, .dice-static { position: absolute; top: 0; left: 0; width: 70px; height: 70px; }
    </style>
</head>
<body>

    <h1>Igra Kocke</h1>
    <div class="round-info">RUNDA: <?php echo $runda; ?> / 3</div>

    <div class="igralna-povrsina">
        <?php foreach ($uporabniki as $id => $u): ?>
            <div class="kartica">
                <h3><?php echo htmlspecialchars($u['ime'] . " " . $u['priimek']); ?></h3>
                
                <div class="kocke">
                    <?php 
                    for ($r = 1; $r <= $runda; $r++) {
                        $vrednost = $zgodovina[$id][$r];
                        echo '<div class="dice-container">';
                        
                        if ($r == $runda) {
                            // TRENUTNA RUNDA: ID-ji so ključni za JavaScript
                            echo '<img src="slike/dice-anim.gif" class="dice-anim" id="anim-'.$id.'">';
                            echo '<img src="slike/dice'.$vrednost.'.gif" class="dice-static hidden" id="static-'.$id.'">';
                        } else {
                            // PRETEKLE RUNDE: Samo statična slika
                            echo '<img src="slike/dice'.$vrednost.'.gif" class="dice-static">';
                        }
                        echo '</div>';
                    }
                    ?>
                </div>

                <p>Seštevek: 
                    <!-- Seštevek je na začetku skrit -->
                    <strong id="sum-<?php echo $id; ?>" style="display: none;">
                        <?php echo $sestevki[$id]; ?>
                    </strong>
                    <span id="loader-<?php echo $id; ?>">...</span>
                </p>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="footer-controls">
        <div id="controls-section" style="display: none;">
            <?php if ($runda < 3): ?>
                <form method="POST">
                    <button type="submit" name="next_round">Naslednja runda</button>
                </form>
            <?php else: ?>
                <div class="zmagovalec-box">
                    <?php 
                    $max_tock = max($sestevki);
                    $zmagovalni_idji = array_keys($sestevki, $max_tock);
                    $imena = [];
                    foreach ($zmagovalni_idji as $zid) { $imena[] = htmlspecialchars($uporabniki[$zid]['ime']); }
                    echo (count($imena) > 1 ? "Zmagovalci: " : "Zmagovalec: ") . implode(", ", $imena);
                    echo " ($max_tock točk)";
                    ?>
                </div>
                <p>Preusmeritev čez <span id="sekunde">10</span> s...</p>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // Funkcija se sproži, ko je celotna stran naložena
        window.onload = function() {
            console.log("Stran naložena, začenjam časovnik...");

            setTimeout(function() {
                // Za vsakega od treh igralcev
                for (let id = 1; id <= 3; id++) {
                    let anim = document.getElementById('anim-' + id);
                    let stat = document.getElementById('static-' + id);
                    let sum = document.getElementById('sum-' + id);
                    let load = document.getElementById('loader-' + id);

                    // Skrijemo animacijo in prikažemo statično kocko
                    if (anim) anim.style.display = 'none';
                    if (stat) stat.classList.remove('hidden');
                    
                    // Prikažemo številčni seštevek
                    if (sum) sum.style.display = 'inline';
                    if (load) load.style.display = 'none';
                }

                // Prikažemo gumb za naslednjo rundo ali zmagovalca
                document.getElementById('controls-section').style.display = 'block';

                // Če je zadnja runda, zaženemo odštevanje za preusmeritev
                <?php if ($runda == 3): ?>
                    startRedirectTimer();
                <?php endif; ?>

            }, 2000); // 2000ms = 2 sekundi trajanja animacije
        };

        function startRedirectTimer() {
            let s = 10;
            let interval = setInterval(function() {
                s--;
                let el = document.getElementById('sekunde');
                if (el) el.innerText = s;
                if (s <= 0) {
                    clearInterval(interval);
                    window.location.href = "index.php";
                }
            }, 1000);
        }
    </script>
</body>
</html>