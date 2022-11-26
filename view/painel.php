<?php
include "../login/protect.php";

?>

<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv=”Content-Type” content=”text/html; charset=utf-8″>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel</title>
</head>
<body>
    Bem vindo, <?php echo $_SESSION['name']?>
    <p>
        <a href="../login/logout.php">Sair</a>
    </p>
</body>
</html>