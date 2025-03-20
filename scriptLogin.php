<?php
    include 'connessione.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Script login</title>
</head>
<body>
    <?php

        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM utente WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            $_SESSION['errore'] = "Username non esistente";
            header("Location: errore_loginreg.php");
            exit();
        }

        $utente = $result->fetch_assoc();
        if (!password_verify($password, $utente['password'])) {
            $_SESSION['errore'] = "Password errata";
            header("Location: errore_loginreg.php");
            exit();
        }

        $_SESSION['username'] = $utente['username'];
        $_SESSION['nome'] = $utente['nome'];
        header("Location: benvenuto.php");
        exit();
    ?>
    
</body>
</html>