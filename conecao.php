<?php
// Configurações do banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "retorno";     

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verificar conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verificar se o formulário foi enviado para atualizar um registro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $mensagem = $_POST['mensagem'];

    // Atualizar o registro
    $sql = "UPDATE contacts SET mensagem=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $mensagem, $id);

    if ($stmt->execute()) {
        echo "<p>Registro atualizado com sucesso!</p>";
    } else {
        echo "<p>Erro ao atualizar o registro: " . $stmt->error . "</p>";
    }
    $stmt->close();
}

// Ler os registros
$sql = "SELECT id, nome, email, mensagem FROM contacts";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_row()) {
        echo "<form action='' method='post'>";
        echo "<input type='hidden' name='id' value='" . $row[0] . "'>";
        echo "<p>Nome: " . $row[1] . "</p>";
        echo "<p>Email: " . $row[2] . "</p>";
        echo "<label for='mensagem_" . $row[0] . "'>Mensagem:</label><br>";
        echo "<textarea id='mensagem_" . $row[0] . "' name='mensagem' rows='4' cols='50'>" . htmlspecialchars($row[3]) . "</textarea><br>";
        echo "<input type='submit' value='Atualizar'>";
        echo "</form><hr>";
    }
} else {
    echo "<p>Nenhum registro encontrado.</p>";
}

// Fechar conexão
$conn->close();
?>
