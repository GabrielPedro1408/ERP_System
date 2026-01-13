<?php 
require_once __DIR__ . '/../../config/Database.php';
class LoginModel{
        private $pdo;

        public function __construct($pdo){
            $this->pdo = $pdo;
        }
        public function buscarPorEmail($username){
            
            try{
                $query = $this->pdo->prepare(
                "SELECT us.id,
                us.username AS username,
                us.senha AS senha,
                emp.email AS email
                FROM usuario us
                LEFT JOIN empresa emp ON emp.id = us.id_empresa
                WHERE us.username = :username");

                $query->bindParam(':username', $username);
                $query->execute();
                $result = $query->fetch(PDO::FETCH_ASSOC);
                return $result;
            } catch (PDOException $e) {
                echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
                header("Location: login.php?error=" . urlencode("Erro ao conectar ao banco de dados."));
                exit;
            }
    }
}
?>