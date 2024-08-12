<?php
include 'config.php';
 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $email = $_POST['email'];
 
    $sql = "INSERT INTO clientes (nome, cpf, email) VALUES ('$nome', '$cpf', '$email')";
 
    if ($conn->query($sql) === TRUE) {
        echo "Novo registro inserido com sucesso.";
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}
?>
 
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Inserir Cliente</title>
</head>
<body>
<h1>Inserir Novo Cliente</h1>
<form action="insert.php" method="post">
        Nome: <input type="text" name="nome" required><br>
        CPF: <input type="text" name="cpf" required><br>
        Email: <input type="text" name="email" required><br>
<input type="submit" value="Inserir">
</form>
</body>
</html>