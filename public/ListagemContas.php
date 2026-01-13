<?php
    include_once __DIR__  . '/../app/Helpers/BuscarIdEmpresa.php';
    include_once __DIR__  . '/../app/Helpers/ImprimirDadosSeguro.php';
    include_once __DIR__ . '/../app/Controllers/ListagemContasController.php';
    include_once __DIR__ . '/../config/Database.php';
    session_start();
    // Verifica se foi efetuado o login
    if(!isset($_SESSION['username'])){
        header("Location: Login.php?error=Você precisa fazer login para acessar esta página.");
        exit;
    }
    $id_empresa = buscarIdEmpresa($_SESSION['username']); 

    $controller = new ListagemContasController($pdo);
    $dados = $controller->index($id_empresa);
    $contas = $dados['contas'];

    date_default_timezone_set('America/Sao_Paulo');

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/listagemContas.css">
    <link rel="stylesheet" href="./assets/components/mensagem.css">
    <link rel="stylesheet" href="./assets/components/header.css">
    <link rel="stylesheet" href="./assets/components/sidebar.css">
    <link rel="shortcut icon" href="./assets/images/images/financeiro.png" type="image/x-icon">
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/all.css">
    <title>Neo Gestão - Listagem Contas</title>
</head>
<body>
    <script> localStorage.setItem('activeItem', 'Financeiro');</script>
    <div class="full-content">
        <?php require './assets/components/sidebar.php';?> 
        <div id="main-content">
            <header><?php require './assets/components/header.php';?> </header> 
            <?php
            if (isset($_SESSION['message'])):
                $type = isset($_SESSION['message_type']) ? $_SESSION['message_type'] : 'info';
            ?>
            <div class="alert alert-<?= $type ?> alert-dismissible fade show alert-top-fixed" role="alert">
                <?= $_SESSION['message'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php
                unset($_SESSION['message']);
                unset($_SESSION['message_type']);
            endif;
            ?>
             
            <div class="container">
                <section class="top-area d-flex justify-content-between align-items-center">
                        <div class="titulo">
                            <h3><strong>LISTAGEM DE CONTAS</strong></h3>
                        </div>
                        <div class="adicionar gap-4">
                            <button id='openPopUpCadastroConta'  type="button" data-bs-toggle="modal" data-bs-target="#modalCadastro">+ Adicionar Conta</button>
                        </div>
                </section>
                <div class="mid-area">
                    <div class="total-contas-pagar">
                        <div class="grupo">
                            <h6>TOTAL DE CONTAS A PAGAR</h6>
                            <div class="main-total-contas-pagar">
                                <h1><label for="totalContasPagar"><?= $dados['quantidadeContasPagar']; ?></label></h1>
                                <div class="icone-total-pagar">
                                    <i class="fa-solid fa-receipt"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="valor-contas-pagar">
                        <div class="grupo">
                            <h6>VALOR CONTAS A PAGAR</h6>
                            <div class="main-valor-contas-pagar">
                                <h1><label for="valorTotalContasPagar">R$ <?= number_format($dados['valorTotalContasPagar'], 2, ',', '.'); ?></label></h1>
                                <div class="icone-valor-pagar">
                                    <i class="fa-solid fa-dollar-sign"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="total-contas-receber">
                        <div class="grupo">
                            <h6>TOTAL DE CONTAS A RECEBER</h6>
                            <div class="main-total-contas-receber">
                                <h1><label for="totalContasReceber"><?= $dados['quantidadeContasReceber'] ?></label></h1>
                                <div class="icone-total-receber">
                                    <i class="fa-solid fa-receipt"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="valor-contas-receber">
                        <div class="grupo">
                            <h6>VALOR CONTAS A RECEBER</h6>
                            <div class="main-valor-contas-receber">
                                <h1><label for="valorTotalContasReceber">R$ <?= number_format($dados['valorTotalContasReceber'], 2, ',', '.'); ?></label></h1>
                                <div class="icone-valor-receber">
                                    <i class="fa-solid fa-dollar-sign"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="filters-section mb-4">
                    <h2><i class="fas fa-filter"></i> Filtros</h2>
                    <form method="GET" action="ListagemContas.php" id="form-buscar">
                        <div class="filters mt-3">   

                            <input type="text" name="filtro_descricao" id="filtro_descricao" placeholder="Buscar por Descrição">

                            <select name="filtro_categoria" id="filtro_categoria">
                                <option aria-readonly="" value="" selected> Categoria</option>
                                <option value="0">Pagar</option>
                                <option value="1">Receber</option>
                            </select>

                            <select name="filtro_tipo" id="filtro_tipo">
                                <option aria-readonly="" value="" selected> Tipo</option>
                                <option value="1">Fornecedor</option>
                                <option value="2">Funcionário</option>
                                <option value="3">Cliente</option>
                                <option value="4">Gasto Fixo</option>
                                <option value="5">Outros</option>
                            </select>

                            <input type="date" name="filtro_data" id="filtro_data">

                            <div class="buttons">
                                <a href="ListagemContas.php"><button type="button" class="btn">Limpar</button></a>
                                <button type="submit" name="filtrar" class="btn">Buscar</button>
                            </div>

                        </div>
                    </form>
                </div>
                <?php
                if (count($contas) == 0):
                ?>
                    <div class='sem-conta'>
                        <i class="fa-solid fa-bag-shopping fa-2xl"></i>
                        <h2>Nenhuma conta cadastrada</h2>
                        <small>Adicione sua primeira conta</small>
                    </div>
                <?php
                else:
                ?>
                <div class="table-reponsive">
                    <table class="table table-striped table-hover">
                        <thead class="">
                            <tr class="text-align-center text-center">
                                <th>Descrição</th>
                                <th>Valor</th>
                                <th>Tipo</th>
                                <th>Categoria</th>
                                <th>Recorrência</th>
                                <th>Vencimento</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <?php 
                        /* if ($contas['tipo_conta']== 0) */ 
                        foreach($contas as $conta):
                        ?>
                        <tbody>
                            <tr class="text-center text-align-center">
                                <td><label for="<?= e($conta['id']) ?>"><?=e($conta['descricao'])?></label></td>
                                <td>R$ <?=e(number_format($conta['valor'], 2, ',', '.')) ?></td>

                                <td><?php if ($conta['tipo'] == 1){
                                    echo "Fornecedor";
                                }
                                else if ($conta['tipo'] == 2){
                                    echo "Funcionário";
                                }
                                else if ($conta['tipo'] == 3){
                                    echo "Cliente";
                                }
                                else if ($conta['tipo'] == 4){
                                    echo "Gasto Fixo";
                                }
                                else if ($conta['tipo'] == 5){
                                    echo "Outros";
                                }
                                else{
                                    echo "Não definido";
                                }?></td>

                                <?php if($conta['categoria'] == 0): ?>
                                    <td> <div class="pagar"><?= 'Pagar' ?></div> </td>
                                 <?php elseif ($conta['categoria'] == 1): ?>
                                    <td> <div class="receber"><?= 'Receber' ?></div> </td>

                                <?php else: ?>
                                    <td> <div class="nao-definido"><?= 'Não definido' ?></div> </td>
                                <?php endif; ?>

                                <td><?php if($conta['recorrencia'] == 0){
                                    echo "Única";
                                } else if($conta['recorrencia'] == 1){
                                    echo "Semanal";
                                } else if($conta['recorrencia'] == 2){
                                    echo "15 dias";
                                } else if($conta['recorrencia'] == 3){
                                    echo "Mensal";
                                } else if($conta['recorrencia'] == 4){
                                    echo "Anual";
                                }?></td>
                                <td><?= date('d/m/Y', strtotime($conta['data_vencimento'])) ?></td>
                                <td>
                                    <!-- botão de Editar -->
                                    <button data-bs-toggle="modal" data-bs-target="#modalEditar" 
                                    data-id="<?= $conta['id']; ?>"class="btn btn-primary btn-sm">
                                    <i class='fa-solid fa-pen-to-square first'></i></button>

                                    <!-- botão de Excluir -->
                                    <button data-bs-toggle="modal" data-bs-target="#modalExcluir"
                                    data-id="<?= $conta['id']; ?>" class="btn btn-danger btn-sm">
                                    <i class='fa-solid fa-trash second'></i></button>

                                    <!-- botão de Info -->
                                    <button data-bs-toggle="modal" data-bs-target="#modalInfo"
                                    data-id="<?= $conta['id']; ?>" class="btn btn-secondary btn-sm">
                                    <i class='fa-solid fa-info-circle third'></i></button>
                                </td>
                            </tr>
                        </tbody>
                        <?php 
                        endforeach;
                        ?>
                        <tfoot>
                            <tr class="ms-2">
                                <td colspan="12" class="">
                                    <nav aria-label="Navegação de página">
                                        <ul class="pagination d-flex justify-content-between">
                                            <li class="page-item disabled">
                                                <span class="page-link">Página:</span>
                                            </li>
                                            <div class="paginacao-info d-flex">
                                                <?php for ($i = 1; $i <= $dados['paginação']; $i++): ?>
                                                <li class="page-item <?= ($i == $paginaAtual) ? 'active' : '' ?>">
                                                    <a class="page-link" href="?pagina=<?= $i ?>"><?= $i ?></a>
                                                </li>
                                                <?php endfor; ?>
                                            </div>
                                        </ul>
                                    </nav>  
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <?php endif ?>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="modalFinanceiro/listagemContas/CRUD/updateContas.js"></script>
    <script src="modalFinanceiro/listagemContas/CRUD/deleteContas.js"></script>
    <script src="modalFinanceiro/listagemContas/CRUD/infoContas.js"></script>
    <script src="../components/sidebar.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
</body>
</html>