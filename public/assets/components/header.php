<?php
/* $idEmpresa = buscarIdEmpresa($_SESSION['username']);
$query = $pdo->prepare(
  'SELECT razão_social
  FROM
  empresa
  WHERE
  id = :idEmpresa
  ');
$query->execute(array(
  ':idEmpresa' => $idEmpresa
));
$result = $query->fetch(PDO::FETCH_ASSOC) */
  ?>
<div id="header">
  <div id="logo">
    <a href=""><img src="/../SistemaERP-NeoGestao/public/assets/images/financeiro.png" alt="logo_empresa"></a>
    <h2 id="title-sidebar">NEO GESTÃO</h2>
  </div>
  <div id="user-info">
    <div class="sino">
      
    </div>
    <h2 id="usuario"><label
        for="empresa">Empresa<? /* isset($result['razão_social']) ? htmlspecialchars($result['razão_social']) : 'Empresa não encontrada' */ ?></label>
    </h2>
  </div>
</div>