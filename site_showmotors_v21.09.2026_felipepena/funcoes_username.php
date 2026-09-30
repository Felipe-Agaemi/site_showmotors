<?php

function normalizar(string $texto): string
{
    $texto = mb_strtolower(trim($texto), 'UTF-8');
    $texto = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $texto);
    return preg_replace('/[^a-z0-9]/', '', $texto);
}

function usernameExiste(mysqli $conn, string $username): bool
{
    $stmt = $conn->prepare("SELECT 1 FROM usuario WHERE nome_usuario = ? LIMIT 1");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $existe = $stmt->num_rows > 0;
    $stmt->close();
    return $existe;
}

function gerarUsername(mysqli $conn, string $nomeCompleto): string
{
    $nomeDividido = preg_split('/\s+/', trim($nomeCompleto), -1, PREG_SPLIT_NO_EMPTY);
    $qtdNomes = count($nomeDividido);

    $primeiroNome = normalizar($nomeDividido[0]);
    $ultimoNome   = '';

    if ($qtdNomes < 2) {
        $nomeUser = $primeiroNome;
    } else {
        $ultimoNome = normalizar(end($nomeDividido));
        $nomeUser   = $primeiroNome . '.' . $ultimoNome;
    }

    if (!usernameExiste($conn, $nomeUser)) {
        return $nomeUser;
    }

    if ($qtdNomes > 2) {
        $inicial = normalizar($nomeDividido[1])[0] ?? '';
        if ($inicial !== '') {
            $candidato = $primeiroNome . '.' . $inicial . '.' . $ultimoNome;
            if (!usernameExiste($conn, $candidato)) {
                return $candidato;
            }
        }
    }

    for ($i = 0; $i < 10; $i++) {
        $candidato = $nomeUser . random_int(10, 99);
        if (!usernameExiste($conn, $candidato)) {
            return $candidato;
        }
    }

    $n = 2;
    while (usernameExiste($conn, $nomeUser . $n)) {
        $n++;
    }
    return $nomeUser . $n;
}