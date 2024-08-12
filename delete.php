<?php
include 'config.php';
 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cliente_id = $_POST['cliente_id'];
 
    $sql = "DELETE FROM clientes WHERE cliente_id=$cliente_id";
 
    if ($conn->query($sql) === TRUE) {
        echo "Registro deletado com sucesso.";
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
<title>Deletar Cliente</title>
</head>
<body>
<h1>Deletar Cliente</h1>
<form action="delete.php" method="post">
        ID do Cliente: <input type="number" name="cliente_id" required><br>
<input type="submit" value="Deletar">
</form>
</body>
</html>