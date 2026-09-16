<?php

include("conexao.php");

$mensagem = "";

if(isset($_POST['cadastrar'])){

    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $telefone = trim($_POST['telefone']);
    $senha = $_POST['senha'];
    $confirmar = $_POST['confirmarSenha'];

    //nome user
    $nomeDividido = explode(" ", $nome);
    $qtdNomes = count($nomeDividido);

    if ($qtdNomes < 2) {
        $nomeUser = $nomeDividido[0];
    } else {
        $primeiroNome = $nomeDividido[0];
        $ultimoNome = end($nomeDividido);
        $nomeUser = $primeiroNome . "." . $ultimoNome;
    }

    if($senha != $confirmar){

        $mensagem = '
            <script>
            Swal.fire({
                icon: "error",
                title: "Tente novamente",
                text: "As senhas não coincidem."
            });
            </script>';

    } else {

        // verificando se o email ja existe no banco
        $stmtVerifica = $conn->prepare("SELECT id_usuario FROM usuario WHERE email = ?");
        $stmtVerifica->bind_param("s", $email);
        $stmtVerifica->execute();
        $resultado = $stmtVerifica->get_result();

        if($resultado->num_rows > 0){

            $mensagem = '
                <script>
                Swal.fire({
                    icon: "error",
                    title: "Tente novamente",
                    text: "Este e-mail já está cadastrado."
                });
                </script>';

        } else {
        // sabor criptografia (o php passa a senha em hash pro bd guardar)
            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

            $stmtInsere = $conn->prepare(
                "INSERT INTO usuario (nome_cliente, nome_usuario, email, telefone, senha)
                 VALUES (?, ?, ?, ?, ?)"
            );
            $stmtInsere->bind_param("sssss", $nome, $nomeUser, $email, $telefone, $senhaHash);

            if($stmtInsere->execute()){

                $mensagem = "
        <script>
        Swal.fire({
            icon: 'success',
            title: 'Sucesso!',
            text: 'Cadastro realizado com sucesso!',
            confirmButtonText: 'OK'
        }).then(function(){
            window.location = 'index.php';
        });
        </script>";

            } else {
                $mensagem = '<script>
                Swal.fire({
                    icon: "error",
                    title: "Tente novamente",
                    text: "Erro ao cadastrar."
                });
                </script>';

            }

            $stmtInsere->close();
        }

        $stmtVerifica->close();
    }
}
?>
<HTML>
<HEAD>
 <TITLE>cadastro</TITLE>
<link rel="stylesheet" href="estilizacao.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        <input type="tel" name="telefone" required><br><br>

        Senha:<br>
        <input type="password" name="senha" required><br><br>

        Confirmar senha:<br>
        <input type="password" name="confirmarSenha" required><br><br>


        
      <?php
    if(!empty($mensagem)){
        echo $mensagem;
    }
?>

        <button type="submit" name="cadastrar">
            Confirmar
        </button>

    </form>

</div>
</body>
</html>