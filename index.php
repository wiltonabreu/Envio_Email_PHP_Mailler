<?php
require_once("vendor/autoload.php");



/**
 * This example shows settings to use when sending via Google's Gmail servers.
 * This uses traditional id & password authentication - look at the gmail_xoauth.phps
 * example to see how to use XOAUTH2.
 * The IMAP section shows how to save this message to the 'Sent Mail' folder using IMAP commands.
 */

//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;



//Create a new PHPMailer instance
$mail = new PHPMailer();

// Diz ao PHPMailer para usar SMTP
$mail->isSMTP();

//Ativa a depuração SMTP
//SMTP::DEBUG_OFF = off (para uso em produção)
//SMTP::DEBUG_CLIENT = mensagens do cliente
//SMTP::DEBUG_SERVER = mensagens de cliente e servidor
//$mail->SMTPDebug = SMTP::DEBUG_SERVER;
$mail->SMTPDebug = 0;

//Define o hostname do servidor de email
$mail->Host = 'mail-ssl.m9.network';
//Use `$mail->Host = gethostbyname('smtp.gmail.com');`
//se sua rede não suporta SMTP sobre IPv6,
//embora isso possa causar problemas com o TLS

//Defina o número da porta SMTP:
// - 465 para SMTP com TLS implícito, também conhecido como RFC8314 SMTPS ou
// - 587 para SMTP+STARTTLS
$mail->Port = 465;

//Definir o mecanismo de criptografia a ser usado:
// - SMTPS (TLS implícito na porta 465) ou
// - STARTTLS (TLS explícito na porta 587)
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;

//$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

//Se deve usar a autenticação SMTP
$mail->SMTPAuth = true;

//Nome de usuário a ser usado para autenticação SMTP - use endereço de e-mail completo para gmail
$mail->Username = 'conta@dominio';

//Senha a ser usada para autenticação SMTP
$mail->Password = 'senhaDeEmail';

//Definir de quem a mensagem será enviada
//Observe que com o gmail você só pode usar o endereço da sua conta (o mesmo que `Nome de usuário`)
//ou aliases predefinidos que você configurou em sua conta.
//Não use endereços enviados por usuários aqui
$mail->setFrom('conta@dominio', 'User');

//Defina um endereço de resposta alternativo
//Este é um bom lugar para colocar endereços enviados pelo usuário - Responder Para
$mail->addReplyTo('conta@dominio', 'User Remetente');

//Definir para quem a mensagem deve ser enviada
$mail->addAddress('conta@dominio', 'User Destinatario');

//Define a linha de assunto
$mail->Subject = 'PHPMailer  SMTP TESTE 4';

//Lê um corpo de mensagem HTML de um arquivo externo, converte imagens referenciadas em incorporadas,
//converte HTML em um corpo alternativo básico de texto sem formatação
$mail->msgHTML(file_get_contents('contents.html'), __DIR__);

//Substitui o corpo do texto simples por um criado manualmente
$mail->AltBody = 'This is a plain-text message body';

//Anexar um arquivo de imagem
//$mail->addAttachment('images/phpmailer_mini.png');

//envia a mensagem, verifica se há erros
if (!$mail->send()) {
    echo 'Mailer Error: ' . $mail->ErrorInfo;
    echo "<br>";
} else {
    echo 'Message Enviada com Sucesso!';
    echo "<br>";
    //Seção 2: IMAP
    //Desmarque-os para salvar sua mensagem na pasta 'E-mails enviados'.
    if (save_mail($mail)) {
        
     echo "Mensagem salva!";
     echo "<br>";
    }
}

//Seção 2: IMAP
//Os comandos IMAP requerem a extensão PHP IMAP, encontrada em: https://php.net/manual/en/imap.setup.php
//Função para chamar que usa as funções PHP imap_*() para salvar mensagens: https://php.net/manual/en/book.imap.php
//Você pode usar imap_getmailboxes($imapStream, '/imap/ssl', '*' ) para obter uma lista de pastas ou rótulos disponíveis, isso pode
//ser útil se você estiver tentando fazer isso funcionar em um servidor IMAP que não seja do Gmail.
function save_mail($mail)
{
    //Você pode alterar 'E-mail enviado' para qualquer outra pasta ou tag
    $path = '{mail03-ssl.m9.network:993/imap/ssl}INBOX.Sent';
//Diga ao seu servidor para abrir uma conexão IMAP usando o mesmo nome de usuário e senha usados ​​para SMTP
    $imapStream = imap_open($path, $mail->Username, $mail->Password);

    $result = imap_append($imapStream, $path, $mail->getSentMIMEMessage());
    imap_close($imapStream);

    return $result;
}

?>