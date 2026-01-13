<!-- Para que quando for printar dados na tela, o correto é usar  a função htmlspecialchars  
Essa função protege contra XSS (Cross-Site Scripting) ao converter caracteres especiais em HTML. 
Pois se tentar salvar um script malicioso, a função htmlspecialchars irá convertê-lo em HTML, 
não executando-o. -->

<?php 
 function e($string) {
    return htmlspecialchars($string);
}
?>