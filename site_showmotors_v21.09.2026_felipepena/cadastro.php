<?php

include("conexao.php");

$mensagem = "";

if(isset($_POST['cadastrar'])){

    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $telefone = trim($_POST['telefone']);
    $celular = trim($_POST['celular']);
    $cpf = trim($_POST['cpf']);
    $senha = $_POST['senha'];
    $confirmar = $_POST['confirmarSenha'];

    //nome user (o servidor e a fonte da verdade; o JS so mostra uma previa)
    // preg_split com \s+ evita itens vazios quando ha espacos duplicados
    $nomeDividido = preg_split('/\s+/', $nome, -1, PREG_SPLIT_NO_EMPTY);
    $qtdNomes = count($nomeDividido);

    if ($qtdNomes === 0) {
        $nomeUser = "";
    } elseif ($qtdNomes === 1) {
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
            // garante nome de usuario unico: ana.silva, ana.silva2, ana.silva3...
            $nomeUserBase = $nomeUser;
            $contador = 1;
            $stmtUser = $conn->prepare("SELECT id_usuario FROM usuario WHERE nome_usuario = ?");
            while (true) {
                $stmtUser->bind_param("s", $nomeUser);
                $stmtUser->execute();
                $stmtUser->store_result();
                if ($stmtUser->num_rows === 0) {
                    break;
                }
                $contador++;
                $nomeUser = $nomeUserBase . $contador;
            }
            $stmtUser->close();

        // sabor criptografia (o php passa a senha em hash pro bd guardar)
            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

            $stmtInsere = $conn->prepare(
                "INSERT INTO usuario (nome_cliente, nome_usuario, email, telefone, senha)
                 VALUES (?, ?, ?, ?, ?)"
            );
            $stmtInsere->bind_param("sssss", $nome, $nomeUser, $email, $telefone, $senhaHash);

            if($stmtInsere->execute()){

                $textoSucesso = json_encode("Cadastro realizado! Seu nome de usuário é: " . $nomeUser);

                $mensagem = "
        <script>
        Swal.fire({
            icon: 'success',
            title: 'Sucesso!',
            text: $textoSucesso,
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

            <nav class="nav-principal">
                <a href="sobre.php">Sobre</a>
            </nav>
        </div>

        <div class="usuario">
            <div>
                <a class="link" href="index.php">Voltar</a>
            </div>
        </div>
    </header>

<body>

<div class="caixa">

    <form method="POST">

        <label for="nome">Nome Completo:</label>
        <input type="text" name="nome" id="nome" required>

        <label for="cpf">CPF</label>
        <input type="text" id="cpf" name="cpf">

        <label for="email">Email</label>
        <input type="email" name="email" id="email" required>

        <label for="telefone">Telefone</label>
        <input type="text" name="telefone" id="telefone" placeholder="(00)0000-0000" maxlength="14">

        <label for="celular">Celular</label>
        <input type="text" name="celular" id="celular" placeholder="(00)00000-0000" maxlength="15">

        <label for="senha">Senha</label>
        <input type="password" name="senha" id="senha" required>

        <label for="confirmarSenha">Confirmar senha</label>
        <input type="password" name="confirmarSenha" id="confirmarSenha" required>

        <?php
            if (!empty($mensagem)) {
                echo $mensagem;
            }
        ?>

        <button type="submit" name="cadastrar">
            Confirmar
        </button>

    </form>

</div>

<script>
    //variaveis
    const nomeCampo = document.getElementById('nome');
    const nomeUsuarioCampo = document.getElementById('nomeUsuario');
    const telefoneCampo = document.getElementById('telefone');
    const celularCampo = document.getElementById('celular');
    const cpfCampo = document.getElementById('cpf');

    //funcoes
    // atualiza o nome de usuario a cada mudanca no nome completo
    nomeCampo.addEventListener('input', (e) => {
        // \s+ evita itens vazios com espacos duplicados; filter(Boolean) remove sobras
        const nomeDividido = e.target.value.trim().split(/\s+/).filter(Boolean);
        const qtdNomes = nomeDividido.length;

        let nomeUser = "";

        if (qtdNomes === 1) {
            nomeUser = nomeDividido[0];
        } else if (qtdNomes > 1) {
            nomeUser = nomeDividido[0] + "." + nomeDividido[qtdNomes - 1];
        }

        nomeUsuarioCampo.value = nomeUser;
    });

    celularCampo.addEventListener('input', (e) => {
        let valor = e.target.value.replace(/\D/g, '');
        if (valor.length > 11) {
            valor = valor.slice(0, 11);
        }
        if (valor.length > 10) {
            valor = valor.replace(/^(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
        } else if (valor.length > 6) {
            valor = valor.replace(/^(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
        } else if (valor.length > 2) {
            valor = valor.replace(/^(\d{2})(\d{0,5})/, '($1) $2')
        } else if (valor.length > 0) {
            valor = valor.replace(/^(\d*)/, '($1')
        }
        e.target.value = valor
    });
    
    telefoneCampo.addEventListener('input', (e) => {
        let valor = e.target.value.replace(/\D/g, '');
        if (valor.length > 11) {
            valor = valor.slice(0, 11);
        }
        if (valor.length > 10) {
            valor = valor.replace(/^(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
        } else if (valor.length > 6) {
            valor = valor.replace(/^(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
        } else if (valor.length > 2) {
            valor = valor.replace(/^(\d{2})(\d{0,5})/, '($1) $2')
        } else if (valor.length > 0) {
            valor = valor.replace(/^(\d*)/, '($1')
        }
        e.target.value = valor
    });

    cpfCampo.addEventListener('input', (e) => {
        let valor = e.target.value.replace(/\D/g, '');

        if (valor.length > 11) {
            valor = valor.slice(0, 11);
        }

        if (valor.length > 9) {
            valor = valor.replace(/^(\d{3})(\d{3})(\d{3})(\d{0,2})/, '$1.$2.$3-$4');
        } else if (valor.length > 6) {
            valor = valor.replace(/^(\d{3})(\d{3})(\d{0,3})/, '$1.$2.$3');
        } else if (valor.length > 3) {
            valor = valor.replace(/^(\d{3})(\d{0,3})/, '$1.$2')
        }

        e.target.value = valor;

        // quando completar 11 digitos: borda vermelha + alerta se o CPF for invalido
        const cpfNum = valor.replace(/\D/g, '');
        if (cpfNum.length === 11) {
            if (cpfValido(cpfNum)) {
                cpfCampo.style.borderColor = '';
            } else {
                cpfCampo.style.borderColor = 'red';
                // so alerta uma vez por valor digitado, pra nao repetir o popup
                if (cpfAlertado !== cpfNum) {
                    cpfAlertado = cpfNum;
                    Swal.fire({
                        icon: 'error',
                        title: 'CPF inválido',
                        text: 'O CPF digitado não é válido. Verifique os números.',
                        confirmButtonText: 'OK'
                    }).then(() => cpfCampo.focus());
                }
            }
        } else {
            cpfCampo.style.borderColor = '';
            cpfAlertado = '';
        }
    });

    let cpfAlertado = '';

    // valida CPF pelos dois digitos verificadores
    function cpfValido(cpf) {
        cpf = cpf.replace(/\D/g, '');

        // precisa ter 11 digitos e nao pode ser tudo igual (111.111.111-11 etc.)
        if (cpf.length !== 11 || /^(\d)\1{10}$/.test(cpf)) return false;

        // 1o digito verificador
        let soma = 0;
        for (let i = 0; i < 9; i++) soma += parseInt(cpf[i]) * (10 - i);
        const dv1 = soma % 11 < 2 ? 0 : 11 - (soma % 11);

        // 2o digito verificador
        soma = 0;
        for (let i = 0; i < 10; i++) soma += parseInt(cpf[i]) * (11 - i);
        const dv2 = soma % 11 < 2 ? 0 : 11 - (soma % 11);

        return dv1 === parseInt(cpf[9]) && dv2 === parseInt(cpf[10]);
    }

    // impede o envio do formulario se o CPF for invalido
    document.querySelector('form').addEventListener('submit', (e) => {
        if (!cpfValido(cpfCampo.value)) {
            e.preventDefault();
            cpfCampo.style.borderColor = 'red';
            Swal.fire({
                icon: 'error',
                title: 'CPF inválido',
                text: 'Verifique o CPF digitado.'
            });
            cpfCampo.focus();
        }
    });
</script>
</body>
</html>