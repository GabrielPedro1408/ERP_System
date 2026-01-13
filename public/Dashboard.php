<?php
include_once __DIR__  . '/../app/Helpers/BuscarIdEmpresa.php';
include_once __DIR__ . '/../app/Controllers/DashboardController.php';
include_once __DIR__ . '/../config/Database.php';
session_start();

/* verifica se foi efetuado o login */
if(!isset($_SESSION['username'])){
    header("Location: Login.php?error=Você precisa fazer login para acessar esta página.");
    exit;
}

$id_empresa = buscarIdEmpresa($_SESSION['username']); 

$controller = new DashboardController($pdo);
$dados = $controller->index($id_empresa);

date_default_timezone_set('America/Sao_Paulo');

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/dashboard.css">
    <link rel="stylesheet" href="./assets/components/header.css">
    <link rel="stylesheet" href="./assets/components/sidebar.css">
    <link rel="shortcut icon" href="./assets/images/financeiro.png" type="image/x-icon">
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/all.css">
    <title>Neo Gestão</title>
</head>
<body>
    <script> localStorage.setItem('activeItem', 'Dashboard');</script>
    <div class="full-content">
        <?php require __DIR__ . '/assets/components/sidebar.php'; ?>
        <div id="main-content">
            <header><?php require __DIR__ . '/assets/components/header.php'; ?> </header>
            <div class="container">

                <div class="title">
                    <h2>Bem-Vindo, <label for="nomeEmpresa"><?= $_SESSION['username']; ?></label></h2>
                    <div class="data">
                        <i class="fa-solid fa-calendar"></i>
                        <h4><?= date('d/m/Y') ?></h4>
                    </div>
                </div>

                <div class="divisao"></div>
                <div class="subtitle">
                    <h6>DASHBOARD</h6>
                </div>

                <!-- cards -->

                <div class="cards">
                    <!-- card 1 -->
                    <div class="card-1">
                        <div class="icone-1">
                            <i class="fa-solid fa-gears fa-2xl"></i>
                        </div>
                        <div class="text">
                            <h5>Quadras Funcionando:</h5>
                            <h4><label for="quadrasFuncionando"><?= $dados['buscarTotalQuadras']['total']; ?> </label></h4>
                        </div>
                        <div class="bottom-card">
                            <a href="Quadras.php">
                                <p>VER POR COMPLETO</p><i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                    <!-- card 2 -->
                    <div class="card-2">
                        <div class="icone-2">
                            <i class="fa-solid fa-calendar fa-2xl"></i>
                        </div>

                        <div class="text">
                            <h5>Horários Agendados</h5>
                            <h4><label for="agendamentosDiario"><?= $dados['buscarTotalAgendamentos']['total_agendamentos']; ?></label></h4>
                        </div>

                        <div class="bottom-card">
                            <a href="Agendamentos.php">
                                <p>VER POR COMPLETO</p><i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                    <!-- card3 -->
                    <div class="card-3">
                        <div class="icone-3">
                            <i class="fa-solid fa-cart-shopping fa-2xl"></i>
                        </div>

                        <div class="text">
                            <h5>Contas a Receber</h5>
                            <h4><label>
                                    R$<?= number_format($dados['buscarContas']['total_receber'], 2, ',', '.') ?></label>
                            </h4>
                        </div>

                        <div class="bottom-card">
                            <a href="ListagemContas.php">
                                <p>VER POR COMPLETO</p><i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                    <!-- card 4 -->
                    <div class="card-4">
                        <div class="icone-4">
                            <i class="fa-solid fa-file-invoice-dollar fa-2xl"></i>
                        </div>

                        <div class="text">
                            <h5>Contas a Pagar</h5>
                            <h4><label>R$<?= number_format($dados['buscarContas']['total_pagar'], 2, ',', '.') ?></label>
                            </h4>
                        </div>

                        <div class="bottom-card">
                            <a href="ListagemContas.php">
                                <p>VER POR COMPLETO</p><i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- gráficos -->
                <div class="graficos">
                    <div class="grafico-clientes">
                        <canvas id="grafico-clientes"></canvas>
                    </div>
                    <div class="grafico-contas-a-receber">
                        <canvas id="grafico-contas-a-receber"></canvas>
                    </div>
                </div>

                <!-- relatorios -->
                <?php if (count($dados['buscarProximosAgendamentos']) == 0): ?>
                    <div class="sem-agendamento">
                        <i class="fa-solid fa-calendar fa-xl"></i>
                        <h2>NENHUM AGENDAMENTO ENCONTRADO HOJE</h2>
                        <div class="bottom-text-sem-agendamento">
                            <a href="Agendamentos.php"><small>Cadastre um agendamento <i
                                        class="fa-solid fa-arrow-right fa-2xs"></i></small></a>
                        </div>
                    </div>
                    <?php
                else:
                    ?>
                    <div class="agenda">
                        <div class="quadras-lista">
                            <h4>PRÓXIMOS AGENDAMENTOS:</h4>
                            <div class="main-text">
                                <div class="relogio">
                                    <i class="fa-solid fa-clock fa-2xl"></i>
                                </div>

                                <?php
                                $result = $dados['buscarProximosHorarios'];
                                $limit = 4;
                                $contador = 0;
                                foreach ($result as $horario):
                                    if ($contador >= $limit) {
                                        break;
                                    }
                                    ?>
                                    <div class="horarios">
                                        <div class="lista-horarios">
                                            <h5><label>Quadra: <?= $horario['nome_quadra'] ?></label></h5>
                                            <span><label>Horário: <?= $horario['horario_agendado'] ?>h</label></span>
                                        </div>
                                    </div>
                                    <?php
                                    $contador++;
                                endforeach ?>
                            </div>

                        </div>
                        <div class="bottom-horario">
                            <a href="Agendamentos.php">
                                <span>VER POR COMPLETO</span>
                                <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                    <?php
                endif;
                ?>
            </div>
        </div>
        <script src="assets/components/sidebar.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="./assets/js/dashboard/GraficosDashboard.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const payload = <?= json_encode($dados, JSON_UNESCAPED_UNICODE); ?>;
                window.renderDashboardCharts(payload);
            });
        </script>
        
        <?php file_put_contents(__DIR__ . '/debug.log', print_r($dados, true), FILE_APPEND);?>

    </body>
</html>