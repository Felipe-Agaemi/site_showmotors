<?php
session_start();

// se nao ta logado nao entra pae simples
if(!isset($_SESSION['usuario'])){
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oficina Show Motors</title>
    <link rel="stylesheet" href="estilizacao.css">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<style>

.link{
    text-decoration: none;
    color: rgb(26, 26, 26);
    background-color: aliceblue;
    border-radius: 10px;
    padding-inline: 20px;
    padding-block: 3px;
    font-weight: bold;
    font-size: large;
    
}

</style>


<body>

    <header class="topo">
        <div class="lado-esquerdo">
            <button class="botao-menu">
                <i class="fa-solid fa-bars"></i>
            </button>

            <h1 class="titulo">Oficina Show Motors</h1>
        </div>

        <div class="usuario">
            <div>

            <div>

<span class="link">
    <?= htmlspecialchars($_SESSION['usuario']); ?>
</span>

<a class="link" href="logout.php">
    Sair
</a>

</div>

</div>

            <div class="foto-usuario">
                <i class="fa-solid fa-user"></i>
            </div>
        </div>
    </header>

    <main class="conteudo">

       <section>

            <div class="cabecalho-secao">
                <h2>
                    <i class="fa-regular fa-calendar"></i>
                    Agenda do Dia
                </h2>

                <div class="controle-data">
                    <button class="btn-data">
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>

                    <div class="campo-data">
                        08/06/2026
                        <i class="fa-regular fa-calendar"></i>
                    </div>

                    <button class="btn-data">
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>

                    <button class="btn-hoje">Hoje</button>
                </div>
            </div>

            <div class="grade-agenda">

                <div class="horario ocupado">
                    <div class="linha-superior">
                        <span class="hora">08:00</span>
                        <span class="status">
                            <i class="fa-regular fa-user"></i>
                            Ocupado
                        </span>
                    </div>

                    <div class="cliente">João Silva</div>
                    <div class="servico">Troca de Óleo</div>
                </div>

                <div class="horario disponivel">
                    <div class="linha-superior">
                        <span class="hora">09:00</span>
                        <span class="status">
                            <i class="fa-solid fa-check"></i>
                            Disponível
                        </span>
                    </div>
                </div>

                <div class="horario ocupado">
                    <div class="linha-superior">
                        <span class="hora">10:00</span>
                        <span class="status">
                            <i class="fa-regular fa-user"></i>
                            Ocupado
                        </span>
                    </div>

                    <div class="cliente">Maria Santos</div>
                    <div class="servico">Revisão Completa</div>
                </div>

                <div class="horario disponivel">
                    <div class="linha-superior">
                        <span class="hora">11:00</span>
                        <span class="status">
                            <i class="fa-solid fa-check"></i>
                            Disponível
                        </span>
                    </div>
                </div>

                <div class="horario disponivel">
                    <div class="linha-superior">
                        <span class="hora">13:00</span>
                        <span class="status">
                            <i class="fa-solid fa-check"></i>
                            Disponível
                        </span>
                    </div>
                </div>

                <div class="horario ocupado">
                    <div class="linha-superior">
                        <span class="hora">14:00</span>
                        <span class="status">
                            <i class="fa-regular fa-user"></i>
                            Ocupado
                        </span>
                    </div>

                    <div class="cliente">Pedro Oliveira</div>
                    <div class="servico">Alinhamento e Balanceamento</div>
                </div>

                <div class="horario disponivel">
                    <div class="linha-superior">
                        <span class="hora">15:00</span>
                        <span class="status">
                            <i class="fa-solid fa-check"></i>
                            Disponível
                        </span>
                    </div>
                </div>

                <div class="horario disponivel">
                    <div class="linha-superior">
                        <span class="hora">16:00</span>
                        <span class="status">
                            <i class="fa-solid fa-check"></i>
                            Disponível
                        </span>
                    </div>
                </div>

            </div>

        </section>

        <section class="secao-servicos">

            <div class="cabecalho-secao">
                <h2>
                    <i class="fa-solid fa-wrench"></i>
                    Serviços Disponíveis
                </h2>
            </div>

            <div class="grade-servicos">

                <div class="card-servico">
                    <div class="icone-servico">
                        <i class="fa-solid fa-oil-can"></i>
                    </div>

                    <div class="info-servico">
                        <h3>Troca de Óleo</h3>
                        <p>Troca completa de óleo e filtro do motor</p>

                        <div class="rodape-servico">
                            <span><i class="fa-regular fa-clock"></i> 30 min</span>
                            <strong>R$ 150,00</strong>
                        </div>
                    </div>
                </div>

                <div class="card-servico">
                    <div class="icone-servico">
                        <i class="fa-solid fa-gear"></i>
                    </div>

                    <div class="info-servico">
                        <h3>Revisão Completa</h3>
                        <p>Verificação de todos os sistemas do veículo</p>

                        <div class="rodape-servico">
                            <span><i class="fa-regular fa-clock"></i> 2h</span>
                            <strong>R$ 350,00</strong>
                        </div>
                    </div>
                </div>

                <div class="card-servico">
                    <div class="icone-servico">
                        <i class="fa-solid fa-gauge"></i>
                    </div>

                    <div class="info-servico">
                        <h3>Alinhamento e Balanceamento</h3>
                        <p>Alinhamento das rodas e balanceamento dos pneus</p>

                        <div class="rodape-servico">
                            <span><i class="fa-regular fa-clock"></i> 1h</span>
                            <strong>R$ 120,00</strong>
                        </div>
                    </div>
                </div>

                <div class="card-servico">
                    <div class="icone-servico">
                        <i class="fa-solid fa-car-battery"></i>
                    </div>

                    <div class="info-servico">
                        <h3>Troca de Bateria</h3>
                        <p>Instalação de bateria nova com teste elétrico</p>

                        <div class="rodape-servico">
                            <span><i class="fa-regular fa-clock"></i> 45 min</span>
                            <strong>R$ 450,00</strong>
                        </div>
                    </div>
                </div>

                <div class="card-servico">
                    <div class="icone-servico">
                        <i class="fa-solid fa-shield"></i>
                    </div>

                    <div class="info-servico">
                        <h3>Freios</h3>
                        <p>Manutenção completa do sistema de freios</p>

                        <div class="rodape-servico">
                            <span><i class="fa-regular fa-clock"></i> 1h 30min</span>
                            <strong>R$ 280,00</strong>
                        </div>
                    </div>
                </div>

                <div class="card-servico">
                    <div class="icone-servico">
                        <i class="fa-solid fa-car-side"></i>
                    </div>

                    <div class="info-servico">
                        <h3>Diagnóstico Eletrônico</h3>
                        <p>Análise completa com scanner automotivo</p>

                        <div class="rodape-servico">
                            <span><i class="fa-regular fa-clock"></i> 45 min</span>
                            <strong>R$ 100,00</strong>
                        </div>
                    </div>
                </div>

            </div>

        </section>

    </main>

</body>
</html>