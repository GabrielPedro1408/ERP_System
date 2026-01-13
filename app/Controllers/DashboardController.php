<?php 
    require_once __DIR__ . '/../Models/DashboardModel.php';
    
    class DashboardController{
        
        private $model;

        public function __construct($pdo){
            $this->model = new DashboardModel($pdo);
        }

        public function index($id_empresa){

            $graficoClientes = $this->model->graficoClientes($id_empresa);
            $graficoFaturamento = $this->model->graficoFaturamento($id_empresa);

            return [
                'buscarTotalQuadras' => $this->model->buscarTotalQuadras($id_empresa),
                'buscarTotalAgendamentos' => $this->model->buscarTotalAgendamentos($id_empresa),
                'buscarContas' => $this->model->buscarContas($id_empresa),
                'buscarProximosHorarios' => $this->model->buscarProximosHorarios($id_empresa),
                'buscarProximosAgendamentos' => $this->model->buscarProximosAgendamentos($id_empresa),

                'mes_ano' => array_column($graficoClientes, 'mes_ano'),
                'total_clientes' => array_column($graficoClientes, 'total_clientes'),

                'mes_ano_faturamento' => array_column($graficoFaturamento, 'mes_ano'),
                'total_faturamento' => array_column($graficoFaturamento, 'total_faturamento')
            ];
            
        }
    
    }
?>