<?php

include("conexao.php");

$mensagem = "";

if(isset($_POST['cadastrar'])){

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $senha = $_POST['senha'];
    $confirmar = $_POST['confirmarSenha'];
    
    //nome user
    $nomeDividido = explode(" ", $nome);
    $qtdNomes = count($nomeDividido);

    if ($qtdNomes < 2) {
        $nomeUser = $nomeDividido[0];
    }
    else {
        $primeiroNome = $nomeDividido[0];
        $ultimoNome = end($nomeDividido);
        $nomeUser = $primeiroNome . "." . $ultimoNome;
    }
    
    if($senha != $confirmar){

        $mensagem = "As senhas não coincidem.";

    }else{

        $verifica = $conn->query(
            "SELECT * FROM usuario WHERE email='$email'"
        );

        if($verifica->num_rows > 0){

            $mensagem = "Este e-mail já está cadastrado.";

        }else{

            $sql = "INSERT INTO usuario
            (nome_cliente, nome_usuario, email, telefone, senha)
            VALUES
            ('$nome', '$nomeUser', '$email','$telefone','$senha')";

            if($conn->query($sql)){

                echo "
                <script>
                alert('Cadastro realizado com sucesso!');
                window.location='index.php';
                </script>";

                exit();
            }
        }
    }
}
?>
<HTML>
<HEAD>
 <TITLE>cadastro</TITLE>
<link rel="stylesheet" href="estilizacao.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
                <a class="link" href="login.php">Voltar</a>
            </div>
        </div>
    </header>

<body>

<div class="caixa">

    <form method="POST">

        Nome:<br>
        <input type="text" name="nome" required><br><br>

        Email:<br>
        <input type="email" name="email" required><br><br>

        Telefone:<br>
        <input type="text" name="telefone" required><br><br>

        Senha:<br>
        <input type="password" name="senha" required><br><br>

        Confirmar senha:<br>
        <input type="password" name="confirmarSenha" required><br><br>


        
        <?php
            if(!empty($mensagem)){
            echo "<p>$mensagem</p>";
            }
        ?>

        <button type="submit" name="cadastrar">
            Confirmar
        </button>

    </form>

</div>
</body>
</html>