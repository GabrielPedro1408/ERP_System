<?php 
require_once __DIR__ . '/../Models/ListagemContasModel.php';

class ListagemContasController{
    private $model;

    public function __construct($pdo){
        $this->model = new ListagemContasModel($pdo);
    }

    public function index($id_empresa){
        $descricao = $_GET['filtro_descricao'] ?? '';
        $categoria = $_GET['filtro_categoria'] ?? '';
        $tipo = $_GET['filtro_tipo'] ?? '';
        $data = $_GET['filtro_data'] ?? '';

        $itensPorPagina = 10;
        $pagina = $_GET['pagina'] ?? 1;
        $offset = ($pagina -1) * $itensPorPagina;

        $filtros = [
            'descricao' => $descricao,
            'categoria' => $categoria,
            'tipo' => $tipo,
            'data' => $data
        ];
        $dados = $this->model->listar(
            $id_empresa,
            $filtros,
            $itensPorPagina,
            $offset
        );

        return [
            'quantidadeContasPagar' => $this->model->quantidadeContasPagar($id_empresa),
            'valorTotalContasPagar' => $this->model->valorTotalContasPagar($id_empresa),
            'quantidadeContasReceber' => $this->model->quantidadeContasReceber($id_empresa),
            'valorTotalContasReceber' => $this->model->valorTotalContasReceber($id_empresa),
            'paginação' => $this->model->paginação($id_empresa),
            'contas' => $dados

        ];
    }
    public function create ($id_empresa)
}

?>