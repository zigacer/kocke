<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <title>Grand Casino - Vstop</title>
    <link rel="stylesheet" href="style.css">
	<link rel="icon" type="image/x-icon" href="slike/favicon.png">
</head>
<body class="casino-theme">
    <div class="neon-title">
        <h1>GRAND CASINO</h1>
        <p>DOBRODOŠLI ZA MIZO</p>
    </div>

    <div class="login-container">
        <h2>Registracija igralcev</h2>
        <form action="igra.php" method="POST">
            <input type="hidden" name="start_game" value="1">
            
            <div style="background: rgba(255,255,255,0.1); padding: 15px; border-radius: 10px; margin-bottom: 20px; display: flex; justify-content: center; gap: 40px;">
                <div>
                    <label style="color: #f1c40f; font-weight: bold;">Število rund (1-3):</label>
                    <input type="number" name="st_rund" min="1" max="3" value="3" required style="width: 50px; padding: 5px; border-radius: 5px; border: 1px solid #d4af37;">
                </div>
                <div>
                    <label style="color: #f1c40f; font-weight: bold;">Število kock (1-3):</label>
                    <input type="number" name="st_kock" min="1" max="3" value="1" required style="width: 50px; padding: 5px; border-radius: 5px; border: 1px solid #d4af37;">
                </div>
            </div>

            <div class="players-row">
                <?php for($i = 1; $i <= 3; $i++): ?>
                    <div class="user-input">
                        <h3>Igralec <?php echo $i; ?> </h3>
                        <div class="field-group">
                            <label>Uporabniško ime:</label>
                            <input type="text" name="user[<?php echo $i; ?>][uporabnisko_ime]" placeholder="Vzdevek..." maxlength="20" required>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>

            <button type="submit" class="btn-gold">ZAČNI IGRO</button>
        </form>
    </div>
</body>
</html>