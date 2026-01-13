<?php

    require_once __DIR__ . '/../Models/LoginModel.php';
    class LoginController{
        private $model;
        
        public function __construct($pdo){
            $this->model = new LoginModel($pdo);
        }

        public function autenticar(){
            
            if ($_SERVER['REQUEST_METHOD'] !== 'POST'){
                header("Location: ../../public/login.php");
                exit;
            }

            session_start();
            $username = $_POST['username'];
            $pass = $_POST['password'];

            if (empty ($username)|| empty($pass)){
                $_SESSION['flash_error'] = 'Preencha todos os campos';
                header("Location: ../../public/login.php");
                exit;
            }
        
            $result = $this->model->buscarPorEmail($username);
            if(!$result){
                $_SESSION['flash_error'] = 'Usuário não encontrado';
                header("Location: ../../public/login.php");
                exit;
            }
            if(password_verify($pass,$result['senha'])){
                $_SESSION['username'] = $result['username'];
                $mensagem = "Bem-vindo, " . htmlspecialchars($result['username']) . "!";
                header("Location: ../../public/Dashboard.php?sucess=" . urldecode($mensagem));
                exit;
            } else {
                //Se o usuario ou senha estiverem incorretos, redireciona com erro
                $mensagem = "Nome de usuário ou senha incorretos!";
                header("Location: ../../public/login.php?error=" . urlencode($mensagem));
                exit;
            }
        }
    }
    // criar controller e executar ação 
    $controller = new LoginController($pdo);
    $controller->autenticar();

?>