<?php

include("conexao.php");

$mensagem = "";

if(isset($_POST['validar'])){

    $codigo = $_POST['codigo'];

    if($codigo == "61"){

        header("Location: nova_senha.php");
        exit();

    }else{

        $mensagem = "Código incorreto.";

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
<title>Confirmar Código</title>
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

    <p>
        Um código foi enviado para seu e-mail.
    </p>

    <p>
        (Para o trabalho, utilize o código 61)
    </p>

    Código:<br>

    <input type="text" name="codigo" required>

    <br><br>

    <?php
    if(!empty($mensagem)){
        echo "<p class='Texto'>$mensagem</p>";
    }
    ?>

    <button type="submit" name="validar">
        Confirmar
    </button>

</form>

</div>

</body>
</html>