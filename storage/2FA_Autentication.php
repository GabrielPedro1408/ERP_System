<?php 
/* Não logamos o usuário ainda — primeiro enviamos o código 2FA */
/* para pegar a data do código de autenticação*/
$data_autenticacao = date('Y-m-d H:i:s'); 

/* gerar um código aleatório*/
$codigo_autenticacao = mt_rand(100000, 999999);
/* para passar os valores a cima no d.b*/
$query_codigo = $pdo->prepare(
"UPDATE usuario SET 
codigo_autenticacao =:codigo_autenticacao,
data_autenticacao = :data_autenticacao
WHERE id = :id
LIMIT 1");
$result_autenticacao = $query_codigo->execute(array(
    ':codigo_autenticacao' => $codigo_autenticacao,
    ':data_autenticacao' => $data_autenticacao,
    ':id' => $dadosUsuario['id']
));

require '../lib/vendor/autoload.php';

$mail = new PHPMailer(true);
try {
    $mail->SMTPDebug = 0; /* 0 = off; use SMTP::DEBUG_SERVER para debug */
    $mail->CharSet = 'UTF-8';
    $mail->isSMTP();  /* Definir para usar SMTP */

    /* === CONFIGURE AQUI SUAS CREDENCIAIS SMTP ===
        Sugestão para desenvolvimento local: use Mailtrap (smtp.mailtrap.io)
        Para produção: configure um serviço real (Gmail com app password, SendGrid, etc.)
    */
    $mail->Host       = 'live.smtp.mailtrap.io';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'api';
    $mail->Password   = '29ed351a014fa592c0dac340ab59fbce';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    $mail->setFrom('no-reply@seusite.com', 'Seu Site');
    $mail->addAddress($dadosUsuario['email'], $dadosUsuario['username']);
    $mail->isHTML(true);
    $mail->Subject = 'Código de autenticação - Seu Site';
    $mail->Body    = "Olá " . htmlspecialchars($dadosUsuario['username']) . ",<br><br>Seu código de autenticação é <strong>{$codigo_autenticacao}</strong>.<br>Válido por 10 minutos.";
    $mail->AltBody = "Seu código de autenticação é {$codigo_autenticacao}.";

    $mail->send();

    /* Marca usuário como pendente de verificação 2FA */
    $_SESSION['pending_2fa_id'] = $dadosUsuario['id'];

    /* Redireciona para página onde o usuário inserirá o código 2FA */
    header("Location: verificacao_2fa.php");
?>
