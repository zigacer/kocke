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
            
            <div class="players-row">
                <?php for($i = 1; $i <= 3; $i++): ?>
                    <div class="user-input">
                        <h3>Igralec <?php echo $i; ?> 🎰</h3>
                        <div class="field-group">
                            <label>Ime:</label>
                            <input type="text" name="user[<?php echo $i; ?>][ime]" placeholder="Vpiši ime..." required>
                        </div>
                        <div class="field-group">
                            <label>Priimek:</label>
                            <input type="text" name="user[<?php echo $i; ?>][priimek]" placeholder="Vpiši priimek..." required>
                        </div>
                        <div class="field-group">
                            <label>Naslov:</label>
                            <input type="text" name="user[<?php echo $i; ?>][naslov]" placeholder="Kraj bivanja..." required>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>

            <button type="submit" class="btn-gold">ZAČNI IGRO</button>
        </form>
    </div>
</body>
</html>