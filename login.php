<?php

session_start();
include("conexao.php");

$mensagem = "";

if(isset($_POST['entrar'])){

    $email = trim($_POST['email']);
    $senha = $_POST['senha'];

    $stmt = $conn->prepare("SELECT * FROM usuario WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if($resultado->num_rows > 0){

        $usuario = $resultado->fetch_assoc();

        if(password_verify($senha, $usuario['senha'])){

            $_SESSION['usuario'] = $usuario['nome_cliente'];
            $_SESSION['email'] = $usuario['email'];

            header("Location: index.php");
            exit();

        } else {
            $mensagem = "E-mail ou senha incorretos.";
        }

    } else {
        $mensagem = "E-mail ou senha incorretos.";
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
        </div>

        <div class="usuario">
            <div>
                <a class="link" href="index.php">Voltar</a>
            </div>
        </div>
    </header>

<body>

<div class="caixa">

    <form method="POST" class="texto">

        Email:<br>
        <input type="email" name="email" required> <br><br>

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

Não possui conta? <a class="Texto02" href="cadastro.php">  Cadastre-se </a>
    </form>

<br><br>

Perdeu a senha?  <a class="Texto02" href="recuperar.php"> Clique aqui </a>

</div>

</body>
</html>