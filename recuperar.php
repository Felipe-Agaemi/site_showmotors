<?php

include("conexao.php");

$mensagem = "";

if(isset($_POST['verificar'])){

    $email = $_POST['email'];
    $telefone = $_POST['telefone'];

    $sql = "SELECT * FROM usuarios
            WHERE email='$email'
            AND telefone='$telefone'";

    $resultado = $conn->query($sql);

    if($resultado->num_rows > 0){

        $_SESSION['email_recuperacao'] = $email;

        header("Location: codigo.php");
        exit();

    }else{

        $mensagem = "As informações não conferem.";

    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="estilizacao.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<title>Recuperar Senha</title>
</head>

<body>

<header class="topo">
    <div class="lado-esquerdo">

        <button class="botao-menu">
            <i class="fa-solid fa-bars"></i>
        </button>

        <h1 class="titulo">Oficina Show Motors</h1>

    </div>

    <div class="usuario">

        <a class="link" href="login.php">
            Voltar
        </a>

    </div>

</header>

<div class="caixa">

<form method="POST" class="Texto">

    Email:<br>
    <input type="email" name="email" required>

    <br><br>

    Telefone:<br>
    <input type="text" name="telefone" required>

    <br><br>

    <?php
    if(!empty($mensagem)){
        echo "<p class='Texto'>$mensagem</p>";
    }
    ?>

    <button type="submit" name="verificar">
        Confirmar
    </button>

</form>

</div>

</body>
</html>