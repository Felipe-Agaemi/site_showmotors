<?php

session_start();
include("conexao.php");

$mensagem = "";

if(isset($_POST['entrar'])){

    $nome_usuario = trim($_POST['nome_usuario']);
    $senha = $_POST['senha'];

    $stmt = $conn->prepare("SELECT * FROM USUARIO WHERE nome_usuario = ?");
    $stmt->bind_param("s", $nome_usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if($resultado->num_rows > 0){

        $usuario = $resultado->fetch_assoc();

        if(password_verify($senha, $usuario['senha'])){

            $_SESSION['usuario'] = $usuario['nome_usuario'];

            header("Location: home.php");
            exit();

        } else {
            $mensagem = "Nome de usuário ou senha incorretos.";
        }

    } else {
        $mensagem = "Nome de usuário ou senha incorretos.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilizacao.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <title>Login</title>
</head>

<header class="topo">
        <div class="lado-esquerdo">
            <button class="botao-menu">
                <i class="fa-solid fa-bars"></i>
            </button>

            <h1 class="titulo">Oficina Show Motors</h1>

            <nav class="nav-principal">
                <a href="sobre.php">Sobre</a>
            </nav>
        </div>
    </header>

<body>

<div class="caixa">

    <form method="POST" class="texto">

        Nome de Usuário:<br>
        <input type="text" name="nome_usuario" required> <br><br>

        Senha:<br>
        <input type="password" name="senha" required><br><br>

<?php
    if(!empty($mensagem)){
        echo "<p class='Texto'>$mensagem</p>";
    }
?>

        <button type="submit" name="entrar">
            Confirmar
        </button> 

        <br><br>

Não possui conta? <br>
<a class="Texto02" href="cadastro.php">  Cadastre-se aqui</a>
    </form>

<br><br>

Perdeu a senha? <br>
<a class="Texto02" href="recuperar.php"> Recupere-a aqui </a>

</div>

</body>
</html>
