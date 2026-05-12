<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <title>Kocke - Vnos igralcev</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Vnesite podatke za 3 igralce</h2>
    <form action="igra.php" method="POST">
        <input type="hidden" name="start_game" value="1">
        <?php for($i = 1; $i <= 3; $i++): ?>
            <div class="user-input">
                <h3>Igralec <?php echo $i; ?></h3>
                Ime: <input type="text" name="user[<?php echo $i; ?>][ime]" required><br><br>
                Priimek: <input type="text" name="user[<?php echo $i; ?>][priimek]" required><br><br>
                Naslov: <input type="text" name="user[<?php echo $i; ?>][naslov]" required>
            </div>
        <?php endfor; ?>
        <button type="submit">Začni 1. rundo!</button>
    </form>
</body>
</html>