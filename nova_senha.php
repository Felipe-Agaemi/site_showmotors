<?php

include("conexao.php");

$mensagem = "";

if(!isset($_SESSION['email_recuperacao'])){
    header("Location: index.php");
    exit();
}

if(isset($_POST['alterar'])){

    $senha = $_POST['senha'];
    $confirmar = $_POST['confirmarSenha'];

    if($senha != $confirmar){

        $mensagem = "As senhas não coincidem.";

    }else{

        $email = $_SESSION['email_recuperacao'];

        $sql = "UPDATE usuarios
                SET senha='$senha'
                WHERE email='$email'";

        if($conn->query($sql)){

            unset($_SESSION['email_recuperacao']);

            echo "
            <script>
                alert('Senha alterada com sucesso!');
                window.location='login.php';
            </script>";
            exit();

        }else{

            $mensagem = 'Erro ao alterar a senha.';

        }
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<title>Nova Senha</title>
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

    Nova senha:<br>
    <input type="password" name="senha" required>

    <br><br>

    Confirmar senha:<br>
    <input type="password" name="confirmarSenha" required>

    <br><br>

    <?php
    if(!empty($mensagem)){
        echo "<p class='Texto'>$mensagem</p>";
    }
    ?>

    <button type="submit" name="alterar">
        Confirmar
    </button>

</form>

</div>

</body>
</html>