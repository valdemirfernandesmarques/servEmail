<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-mails com PHP</title>
    <link rel="stylesheet" href="formata-email.css">
</head>
<body>
    <h1>Envio automático de e-mails com PHP - Servidor do google</h1>

    <form action="enviar-email.php" method="post">
        <fieldset>
     <legend>Cadastro de Usuário</legend>
     <label class="alinha">nome</label>
     <input type="text" name="nome"> <br>

     <label class="alinha">Data de Nascimento</label>
     <input type="date" name="nascimento"> <br>

     <label class="alinha">E-mail</label>
     <input type="email" name="e-mail"> <br>

     <div class="botao">
      
       <button name="cadastrar"> Cadastrar Usuário </button>

     </div>

     </fieldset>
    </form>

   <?php
   //configuração inicial para começar usar o framework
   use PHPMailer\PHPMailer\PHPMailer;
   use PHPMailer\PHPMailer\exception;

   require "./PHPMailer/src/Exception.php";
   require "./PHPMailer/src/PHPMailer.php";
   require "./PHPMailer/src/SMTP.php";

 if(isset($_POST['cadastrar']))
 {
 $nome = $_POST['nome'];
 $email = $_POST['e-mail'];
 $nascimento = $_POST['nascimento'];

 //vamos, usando a classe PHPMailer,criar o objeto $bjEmail.
 $objEmail = new PHPMailer();

 //abaixo comandos do framework para evitamos problemas de acentuação no email.
 $objEmail->CharSet = "UTF-8";
 $objEmail->setLanguage("pt-br");    //aqui podemos escolher a linguagem da mensagem de erro do framework.

 //configuração do servidor de email
 $objEmail->Host = "smtp.gmail.com";
 $objEmail->Username = "remetente.ifsc2016@gmail.com";     //email do Administrador
 $objEmail->Password = "rdye xans iaej eney";
 $objEmail->Port = 465;     // ou 587
 $objEmail->SMTPSecure = "ssl";     // ou tls
 $objEmail->isSMTP();
 $objEmail->SMTPAuth = true;


 //configurando os dados da mensagem, para que o usuário possa ver a mensagem em HTML no corpo
 $objEmail->IsHTML(true);
 $objEmail->Subject = "Resultado do cadastro";    //mensagem que vai ser vista no email.

 //dados do e-mail do remetenteque somos nós Administradores.
 $objEmail->addReplyTo("remetente.ifsc2016@gmail.com", "Administrador");         //quando o distinatario clicar em "responder para".

 $objEmail->SetFrom("remetente.ifsc2016@gmail.com", "Administrador");    //aqui é para saber de onde está vindo o email.


 $objEmail->AddAddress($email, $nome);     ///aqui vai o endereço de E-mail de  quem vai receber a nossa mensargem 



 // nessa etapa vai ser definido o corpo da mensagem.

 $objEmail->Body = "<h1 style='color: green'>Prezadodo cliente, confira, a seguir, seus dados cadastrais em nossa aplicação web:</h1>
                 <p> Nome: $nome <br>
                     Nascimento = $nascimento <br>
                     E-mail = $email </p>";

 ///enviando arquivos em anexo á mensagem.
 $objEmail->AddAttachment("Koi.png");   //aqui podemos mandar varios anexos.
 $objEmail->AddAttachment("anexo2.doc");   //aqui podemos mandar varios anexos.

 ///agora vamos disparar o envio do email e testando a possibilidade de erros.
 if($objEmail->Send())
 {
 echo "<p> Cadastro na aplicação web Efetuado com SUCESSO! Prezado cliente,acesse sua conta de email e confira seus dados. qualquer duvida, entre em contato.</p>";
 

 }
 else
 {
 echo "<p> erro no envio do e-mail: Código do erro $objEmail->ErrorInfo </p>";
 }

 }


   ?>
   

    
</body>
</html>