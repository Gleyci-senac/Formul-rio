<?php
include 'config.php';

$message = "";

// Processa o formulário de inserção de clientes
if (isset($_POST['insert_cliente'])) {
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $email = $_POST['email'];

    $stmt = $conn->prepare("INSERT INTO clientes (nome, cpf, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nome, $cpf, $email);

    if ($stmt->execute()) {
        $message = "Novo cliente inserido com sucesso.";
    } else {
        $message = "Erro ao inserir cliente.";
    }

    $stmt->close();
}

// Processa o formulário de busca de clientes
$clientes_result = null;
if (isset($_POST['search_cliente'])) {
    $search_cliente = $_POST['search_cliente'];
    $sql = "SELECT * FROM clientes WHERE nome LIKE '%$search_cliente%' OR cpf LIKE '%$search_cliente%' OR email LIKE '%$search_cliente%'";
    $clientes_result = $conn->query($sql);
}

// Processa o formulário de exclusão de clientes
if (isset($_POST['delete_cliente'])) {
    $cliente_id = $_POST['cliente_id'];

    $sql = "DELETE FROM clientes WHERE cliente_id=$cliente_id";

    if ($conn->query($sql) === TRUE) {
        $message = "Cliente deletado com sucesso.";
    } else {
        $message = "Erro: " . $sql . "<br>" . $conn->error;
    }
}

// Processa o formulário de inserção de produtos
if (isset($_POST['insert_produto'])) {
    $nome_produto = $_POST['nome_produto'];
    $descricao = $_POST['descricao'];
    $qtd_estoque = $_POST['qtd_estoque'];
    $valor_unitario = $_POST['valor_unitario'];

    $stmt = $conn->prepare("INSERT INTO produtos (nome_produto, descrição, qtd_estoque, valor_unitario) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssii", $nome_produto, $descricao, $qtd_estoque, $valor_unitario);

    if ($stmt->execute()) {
        $message2 = "Novo produto inserido com sucesso.";
    } else {
        $message2 = "Erro ao inserir produto.";
    }

    $stmt->close();
}

// Processa o formulário de busca de produtos
$produtos_result = null;
if (isset($_POST['search_produto'])) {
    $search_produto = $_POST['search_produto'];
    $sql = "SELECT * FROM produtos WHERE produto_id LIKE '%$search_produto%' OR nome_produto LIKE '%$search_produto%'";
    $produtos_result = $conn->query($sql);
}

// Processa o formulário de exclusão de produtos
if (isset($_POST['delete_produto'])) {
    $produto_id = $_POST['produto_id'];

    $sql = "DELETE FROM produtos WHERE produto_id=$produto_id";

    if ($conn->query($sql) === TRUE) {
        $message2 = "Produto deletado com sucesso.";
    } else {
        $message2 = "Erro: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale:"> 

<title>Gerenciar Clientes e Produtos</title>
<style>
    body {
        background: linear-gradient(to left, #e97390, #e9aebb);
        display: flex;
        align-items: center;
        justify-content: flex-start; /* Altera para flex-start */
        flex-direction: column;
        height: 100vh;
        margin: 0;
        font-family: Arial, sans-serif;
        overflow-y: auto; /* Adiciona rolagem vertical */
    }
    .container {
        width: 80%;
        max-width: 1200px;
        background: transparent;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        margin-bottom: 20px;
    }
    .form-container {
        background: #f9f9f9;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        margin-bottom: 20px;
    }
    form {
        margin-bottom: 20px;
    }
    label, input {
        display: block;
        margin: 5px 0;
    }
    input[type="submit"] {
        margin-top: 10px;
        padding: 10px;
        background: #e97390;
        border: none;
        color: white;
        cursor: pointer;
        border-radius: 10px;
    }
    input[type="submit"]:hover {
        background: #e9aebb;
        color: white;
    }
    .message {
        color: green;
    }
    .error {
        color: red;
    }
    .text-color {
        color: #8d2960; /* Altere esta cor conforme necessário */
    }
    .text-gerenciar {
        color: #8d2960; /* Altere esta cor conforme necessário */
        text-align: center; /* Centraliza o texto */
        width: 100%; /* Garante que o elemento ocupe toda a largura disponível */
        margin: 0 auto; /* Centraliza o elemento horizontalmente */
        font-size: 40px;
    }
    input[type="text"], input[type="number"] {
        width: 100%;
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #ccc;
        box-sizing: border-box;
        margin-bottom: 10px;
        text-align: center;
    }
    textarea {
    width: 100%;
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #ccc;
    box-sizing: border-box;
    margin-bottom: 10px;
    text-align: center;
    resize: vertical; /* Permite redimensionar verticalmente */
}  
    
</style>
</head>

<body>
<div class="container">
    <h1 class="text-gerenciar">Gerenciar Clientes <p></p></h1>
    <div class="form-container">

        <!-- Formulário para Inserir Cliente -->
        <h1 class="text-color">Inserir Novo Cliente</h1>
            <form action="index.php" method="post">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required>
                <label for="cpf">CPF:</label>
                <input type="text" id="cpf" name="cpf" required>
                <label for="email">Email:</label>
                <input type="text" id="email" name="email" required>
                <input type="submit" name="insert_cliente" value="Inserir">
            </form>
            <!-- Exibe a mensagem -->
            <?php if (!empty($message)): ?>
                <p class="message"><?php echo $message; ?></p>
            <?php endif; ?>
        </div>

    <div class="form-container">
         <!-- Formulário para Buscar Clientes -->
         <h2 class="text-color">Buscar Cliente</h2>
        <form action="index.php" method="post">
            <input type="text" id="search_cliente" name="search_cliente" placeholder="Digite o Nome, CPF ou Email" required>
            <input type="submit" value="Buscar">
        </form>
        <!-- Resultados da Busca -->
        <?php if ($clientes_result && $clientes_result->num_rows > 0): ?>
        <div class="results">
            <h2 class="text-color">Resultados da Busca</h2>
            <button onclick="document.querySelector('.results').style.display='none'">Fechar</button>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>Email</th>
                </tr>
                <?php while($row = $clientes_result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['cliente_id']; ?></td>
                    <td><?php echo $row['nome']; ?></td>
                    <td><?php echo $row['cpf']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                </tr>
                <?php endwhile; ?>
            </table>
        </div>
        <?php elseif ($clientes_result): ?>
        <div class="results">
            <h2>Nenhum cliente encontrado</h2>
            <button onclick="document.querySelector('.results').style.display='none'">Fechar</button>
        </div>
        <?php endif; ?>
    </div>
    <div class="form-container">

        <!-- Formulário para Deletar Cliente -->
        <h2 class="text-color">Deletar Cliente</h2>
        <form action="index.php" method="post">
            <label for="cliente_id">ID do Cliente:</label>
            <input type="number" id="cliente_id" name="cliente_id" required>
            <input type="submit" name="delete_cliente" value="Deletar">
        </form>
    </div>
</div>

<div class="container">
    <h1 class="text-gerenciar">Gerenciar Produtos<p></p></h1>
    <div class="form-container">

        <!-- Formulário para Inserir Produto -->
        <h2 class="text-color">Inserir Novo Produto</h2>
            <form action="index.php" method="post">
                <label for="nome_produto">Nome do Produto:</label>
                <input type="text" id="nome_produto" name="nome_produto" required>
                <label for="descricao">Descrição:</label>
                <textarea id="descricao" name="descricao" rows="4" required></textarea>
                <label for="qtd_estoque">Quantidade em Estoque:</label>
                <input type="number" id="qtd_estoque" name="qtd_estoque" required>
                <label for="valor_unitario">Valor Unitário:</label>
                <input type="text" id="valor_unitario" name="valor_unitario" required>
                <input type="submit" name="insert_produto" value="Inserir">
            </form>
            <!-- Exibe a mensagem -->
            <?php if (!empty($message2)): ?>
                <p class="message"><?php echo $message2; ?></p>
            <?php endif; ?>
    </div>
    <div class="form-container">

        <!-- Formulário para Buscar Produto -->
        <h2 class="text-color">Buscar Produto</h2>
        <form action="index.php" method="post">
            <input type="text" id="search_produto" name="search_produto" placeholder="Digite o ID ou Nome do Produto" required>
            <input type="submit" value="Buscar">
        </form>
        <!-- Resultados da Busca -->
        <?php if ($produtos_result && $produtos_result->num_rows > 0): ?>
        <div class="results">
            <h2 class="text-color">Resultados da Busca</h2>
            <button onclick="document.querySelector('.results').style.display='none'">Fechar</button>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Quantidade em Estoque</th>
                    <th>Valor Unitário</th>
                </tr>
                <?php while($row = $produtos_result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['produto_id']; ?></td>
                    <td><?php echo $row['nome_produto']; ?></td>
                    <td><?php echo $row['descrição']; ?></td>
                    <td><?php echo $row['qtd_estoque']; ?></td>
                    <td><?php echo $row['valor_unitario']; ?></td>
                </tr>
                <?php endwhile; ?>
            </table>
        </div>
        <?php elseif ($produtos_result): ?>
        <div class="results">
            <h2>Nenhum produto encontrado</h2>
            <button class="submit" onclick="document.querySelector('.results').style.display='none'">Fechar</button>
        </div>
        <?php endif; ?>
    </div>
    <div class="form-container">

        <!-- Formulário para Deletar Produto -->
        <h2 class="text-color">Deletar Produto</h2>
        <form action="index.php" method="post">
            <label for="produto_id">ID do Produto:</label>
            <input type="number" id="produto_id" name="produto_id" required>
            <input type="submit" name="delete_produto" value="Deletar">
        </form>
    </div>
</div>
</body>
</html>
