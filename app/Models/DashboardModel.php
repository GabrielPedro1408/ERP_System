<?php 
require_once __DIR__ . '/../../config/Database.php';

class DashboardModel{
    private $pdo;
    
    public function __construct($pdo){
        $this->pdo = $pdo;
    }

    public function verificacao ($result){
            if (!$result){
                return 0;
            }
        }

    public function buscarTotalQuadras($id_empresa){
        try {
            $query = $this->pdo->prepare(
            "SELECT COUNT(*) AS total
            FROM quadras
            WHERE disponibilidade = 1
            AND id_empresa = :id_empresa"
            );
            $query->bindParam(':id_empresa', $id_empresa );
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
            $this->verificacao($result);
            return $result;
        } catch (PDOException $e) {
            throw new Exception('Erro ao buscar a quantidade de quadras' . $e);
        }
    }

    public function buscarTotalAgendamentos ($id_empresa){
        try {
            $query = $this->pdo->prepare(
            "SELECT COUNT(*) AS total_agendamentos
            FROM 
            agendamentos
            WHERE 
            horario_agendado >= CURRENT_TIME()
            AND
            dt = CURRENT_DATE()
            AND
            id_empresa = :id_empresa");
            $query->bindParam(':id_empresa', $id_empresa);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
            $this->verificacao($result);
            return $result;
        } catch (PDOException $e) {
            throw new Exception('Erro ao buscar a quantidade de Agendamentos' . $e);
        }
    }

    public function buscarContas($id_empresa){
         try {
            $query = $this->pdo->prepare("SELECT 
            SUM(CASE WHEN categoria = 1 THEN valor ELSE 0 END) AS  total_receber,
            SUM(CASE WHEN categoria = 0 THEN valor ELSE 0 END) AS total_pagar
            FROM contas
            WHERE id_empresa = :id_empresa
            AND data_vencimento = CURDATE()");
            $query->bindParam(':id_empresa', $id_empresa);
            $result = $query->fetch(PDO::FETCH_ASSOC);
            if(!$result){
                return [
                    'total_receber' => 0,
                    'total_pagar' => 0
                ];
            }
            return $result;
        } catch (\PDOException $e) {
            throw new Exception('Erro ao buscar a quantidade de Contas' . $e);
        }
    }

    public function buscarProximosHorarios ($id_empresa){
        try {
            $query = $this->pdo->prepare(
            "SELECT
            q.descr AS nome_quadra,
            DATE_FORMAT(a.horario_agendado, '%H:%i') AS horario_agendado
            
            FROM 
            agendamentos a

            JOIN
            quadras q ON a.id_quadra = q.id

            WHERE
            a.horario_agendado >= CURRENT_TIME()
            AND
            a.dt = CURRENT_DATE()
            AND
            a.id_empresa = :id_empresa

            ORDER BY
            a.horario_agendado
            ASC");

            $query->bindParam(':id_empresa', $id_empresa);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
            $this->verificacao($result);
            return $result;
        } catch (\Throwable $e) {
            throw new Exception('Erro ao buscar os Próximos Horários' . $e);
        }
    }

    public function buscarProximosAgendamentos ($id_empresa) {
        try {
            $query = $this->pdo->prepare(
            "SELECT *
            FROM agendamentos 
            WHERE estado_conta != '3'
            AND dt = CURRENT_DATE()
            AND horario_agendado >= CURRENT_TIME()
            AND id_empresa = :id_empresa");

            $query->bindParam(':id_empresa', $id_empresa);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            $this->verificacao($result);
            return $result;
        } catch (PDOException $e) {
            throw new Exception('Erro ao buscar proximos agendamentos' . $e);
        } 
    }
    
    public function graficoClientes ($id_empresa){
    /* essa função faz a consulta dos clientes cadastrados nos ultimos 6 meses para o gráfico */
        try {
            $query = $this->pdo->prepare(
            "SELECT 
            DATE_FORMAT(data_cadastro, '%m - %Y') AS mes_ano,
            COUNT(*) AS total_clientes

            FROM 
            clientes

            WHERE 
            data_cadastro BETWEEN DATE_SUB(NOW(), INTERVAL 6 MONTH) AND NOW()
            AND
            id_empresa = :id_empresa

            GROUP BY
            mes_ano

            ORDER BY
            mes_ano");

            $query -> bindParam(':id_empresa', $id_empresa);
            $query->execute();
            $result= $query->fetchAll(PDO::FETCH_ASSOC);
            /* precisa ser diferente a verificação pois se não o chat,js não aceita */
            if(!$result){
                return ['total_clientes' => 0];
            }
            return $result;
            
            /* passando para um vetor para poder usar no gráfico */
            $mes_ano = [];
            $total_clientes = [];

            foreach ($result as $row) {
                $mes_ano[] = $row['mes_ano'];
                $total_clientes[] = $row['total_clientes'];
            }
        }catch (PDOException $e) {
            throw new Exception('Erro ao buscar no grafico clientes' . $e);
        }
    }

    public function graficoFaturamento ($id_empresa) {
        try {
            $query = $this->pdo->prepare(
            "SELECT 
            DATE_FORMAT(dt, '%m - %Y') AS mes_ano,
            SUM(valor) AS total_faturamento
            FROM fluxo_financeiro
            WHERE tipo = 0
            AND dt BETWEEN DATE_SUB(NOW(), INTERVAL 12 MONTH) AND NOW()
            AND id_empresa = :id_empresa
            GROUP BY mes_ano
            ORDER BY mes_ano ASC"
            );
            $query->bindParam(':id_empresa', $id_empresa);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            
            $mes_ano = [];
            $total_faturamento = [];
            foreach ($result as $row) {
                $mes_ano[] = $row['mes_ano'];
                $total_faturamento[] = $row['total_faturamento'];
            }

            return [
                'mes_ano' => $mes_ano,
                'total_faturamento' => $total_faturamento
            ];
        } catch (PDOException $e) {
            throw new Exception('Erro ao buscar no grafico faturamento: ' . $e->getMessage());
        }
    }

}

?>