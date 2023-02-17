<?php
$mensagem = "Preencha os dados do formulário";
$nome = "";
$email = "";
$msg = "";
$cpf = "";

if(isset($_POST["nome"],$_POST["email"],$_POST["msg"],$_POST["cpf"]))
{
    try {
        $conn = new PDO("mysql:host=localhost;dbname=contatos", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch(PDOException $e) {
        echo "Ocorreu um erro inesperado. Tente novamente mais tarde!";
        exit();
      }

    $nome = filter_input(INPUT_POST,"nome",FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST,"email",FILTER_SANITIZE_EMAIL);
    $msg = filter_input(INPUT_POST,"msg",FILTER_SANITIZE_STRING);
    $cpf = filter_input(INPUT_POST,"cpf",FILTER_SANITIZE_NUMBER_INT);

    if(!$nome || !$email|| !$msg)
    {
        $mensagem = "dados invalidos";
    }
    else
    {
        $stm = $conn->prepare('INSERT INTO contatos(nome,email,msg,cpf) VALUES(:nome,:email,:msg,:cpf)');
        $stm ->bindValue('nome', $nome, PDO::PARAM_STR);
        $stm ->bindValue('email', $email, PDO::PARAM_STR);
        $stm ->bindValue('msg', $msg, PDO::PARAM_STR);
        $stm ->bindValue('cpf', $cpf, PDO::PARAM_INT);
        $stm->execute();

        $mensagem = "Mensagem Enviada com sucesso!";

    }
}

?>
<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contato</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <main>
        <form method="POST">
            <label>Nome</label>
            <input type="text" name = "nome" required/>
            <label>E-mail</label>
            <input type="email" name = "email" required/>
            <label>Cpf</label>
            <input type="text" name = "cpf" required/>
            <label>Mensagem</label>
            <textarea name = "msg"></textarea>
            <button type="submit">Enviar</button>
        </form>
        <div class = "Mensagem">
            <?=$mensagem?>
        </div>
    </main>
    </body>
</html>