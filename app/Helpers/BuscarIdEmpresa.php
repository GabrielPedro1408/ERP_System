<?php
    //Busca o id da empresa a partir do nome do session, que é o nome do usuario
    function buscarIdEmpresa($username){
        global $pdo; // Acessa a variável $pdo definida no arquivo de conexão
        $query = $pdo->prepare("SELECT id_empresa FROM usuario WHERE username = :username");
        $query->bindParam(':username', $username);
        $query->execute();
        if($query->rowCount() > 0) {
            $row = $query->fetch(PDO::FETCH_ASSOC);
            $result = $row['id_empresa'];
            return $result;
        } else {
            echo "<script>alert('Não é possével encontrar a empresa.');</script>";
        }
    }
?>