<?php 
require_once __DIR__ . '/../../config/Database.php';

    class ListagemContasModel{
        
        private $pdo;

        public function __construct($pdo){
            $this->pdo = $pdo;
        }
        public function verificacao ($result){
            if (!$result){
                return 0;
            }
            return $result;
        }
        public function quantidadeContasPagar ($id_empresa){
            /* soma a quantidade de contas a pagar registradas */
            try {
                $query = $this->pdo->prepare(
                "SELECT COUNT(*)
                FROM contas 
                WHERE categoria = 0 
                AND id_empresa = :id_empresa");
                $query->bindParam(':id_empresa', $id_empresa, PDO::PARAM_INT);
                $query->execute();
                $result = $query->fetchColumn();
                return $result;
            } catch (PDOException $e) {
                throw new Exception('Erro ao buscar a quantidade de contas a pagar' . $e);
            } 
        }
        public function valorTotalContasPagar ($id_empresa){
            /* soma o VALOR total de todas a contas a Pagar  */
            try {
                $query = $this->pdo->prepare("SELECT SUM(valor) FROM contas WHERE categoria = 0 AND id_empresa = :id_empresa");
                $query->bindParam(':id_empresa', $id_empresa, PDO::PARAM_INT);
                $query->execute();
                $result = $query->fetchColumn();
                return $result;
            } catch (PDOException $e) {
                throw new Exception('Erro ao buscar o valor total de contas a pagar' . $e);
            } 
            
        }
        public function quantidadeContasReceber ($id_empresa){
            try {
                $query = $this->pdo->prepare("SELECT COUNT(*) FROM contas WHERE categoria = 1 AND id_empresa = :id_empresa");
                $query->bindParam(':id_empresa', $id_empresa, PDO::PARAM_INT);
                $query->execute();
                $result = $query->fetchColumn();
                return $result;
            } catch (PDOException $e) {
                throw new Exception('Erro ao buscar a quantidade de contas a receber' . $e);
            }     
        
        }
        public function valorTotalContasReceber ($id_empresa){
            try {
                $query = $this->pdo->prepare("SELECT SUM(valor) FROM contas WHERE categoria = 1 AND id_empresa = :id_empresa");
                $query->bindParam(':id_empresa', $id_empresa, PDO::PARAM_INT);
                $query->execute();
                $result = $query->fetchColumn();
                return $result;
            } catch (PDOException $e) {
                throw new Exception('Erro ao buscar o valor total de contas a receber' . $e);
            } 
            
        }
        public function paginação($id_empresa){
            try {
                $pagina = 10;
                $query = $this->pdo->prepare(
                "SELECT COUNT(*) as total
                FROM contas
                WHERE id_empresa = :id_empresa
                ");
                $query -> bindParam(":id_empresa", $id_empresa);
                $query -> execute();
                $stmt = $query -> fetch(PDO::FETCH_ASSOC)['total'];
                $result = ceil($stmt/$pagina);
                return $result;
            }catch (PDOException $e) {
                throw new Exception('Erro ao buscar a paginação' . $e);
            } 
            
        }
        public function listar ($id_empresa, array $filtros, $limit, $offset){
            try {
                $query = "SELECT * FROM contas WHERE id_empresa = :id_empresa";
                $params = [
                    ':id_empresa' => $id_empresa
                ];

                if (!empty($filtros['descricao'])) {
                    $query .= " AND descricao LIKE :descricao COLLATE utf8mb4_general_ci";
                    $params[':descricao'] = '%' . $filtros['descricao'] . '%';
                }

                if (!empty($filtros['categoria'])) {
                    $query .= " AND categoria = :categoria";
                    $params[':categoria'] = $filtros['categoria'];
                }

                if (!empty($filtros['tipo'])) {
                    $query .= " AND tipo = :tipo";
                    $params[':tipo'] = $filtros['tipo'];
                }

                if (!empty($filtros['data'])) {
                    $query .= " AND DATE_FORMAT(data_vencimento, '%Y-%m-%d') = :data";
                    $params[':data'] = $filtros['data'];
                }

                $query .= " ORDER BY data_vencimento ASC LIMIT :limit OFFSET :offset";

                $result = $this->pdo->prepare($query);

                foreach ($params as $row => $value) {
                    $result->bindValue($row, $value);
                }

                $result->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
                $result->bindValue(':offset', (int)$offset, PDO::PARAM_INT);

                $result->execute();
            } catch (PDOException $e) {
                throw new Exception('Erro ao buscar os filtros' . $e);
            }

            return $result->fetchAll(PDO::FETCH_ASSOC);
        }
        
}

?>