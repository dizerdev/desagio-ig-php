<?php
function limparFormulario() {
    echo '<script>document.getElementById("formulario").reset();</script>';
}

$dadosEnviados = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Dados do formulário
    $nome = $_POST["nome"];
    $cpf = $_POST["cpf"];
    $creci = $_POST["creci"];

    // enviando dados preenchidos no formulario para o bando de dados
    try {
        // Conectar ao banco de dados SQLite
        $db = new PDO('sqlite:diegozerbini.db');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Inserir dados na tabela 'corretor'
        $sql = "INSERT INTO corretor (nome, cpf, creci) VALUES (:nome, :cpf, :creci)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':cpf', $cpf, PDO::PARAM_INT);
        $stmt->bindParam(':creci', $creci, PDO::PARAM_INT);
        $stmt->execute();

        

    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
    limparFormulario();

    $dadosEnviados = true;

    if ($dadosEnviados) {
        $sqlSelect = "SELECT * FROM corretor ORDER BY id DESC LIMIT 1";
        $result = $db->query($sqlSelect);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de corretor</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Cadastro de Corretor</h1>

<?php
// Inicie a sessão
session_start();

// Verifique se há uma mensagem na sessão
if (isset($_SESSION['mensagem'])) {
    // Exiba a mensagem
    echo '<div style="background-color: #4CAF50; color: white; padding: 15px; margin-bottom: 15px; width: 600px">' . $_SESSION['mensagem'] . '</div>';

    // Limpe a mensagem da sessão para que não seja exibida novamente
    unset($_SESSION['mensagem']);
}
?>

<div class="container">
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

    <input type="text" name="cpf" minlength="11" maxlength="11" pattern="[0-9]{11}" id="input-cpf" placeholder="Digite seu CPF" required>

    <input type="text" name="creci" minlength="2" maxlength="6" pattern="[0-9]{6}" id="input-creci" placeholder="Digite seu Creci" required>

    <input type="text" name="nome" minlength="2" maxlength="50" pattern="[A-Za-zÀ-ú ]+" id="input-nome" placeholder="Digite seu nome" required>

    <input type="submit" class="button" value="Enviar">
</form>

<?php if ($dadosEnviados): ?>
    <h2>Cadastro realizado!</h2>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>CPF</th>
            <th>Creci</th>
            <th></th>
        </tr>

        <?php
        // Exibir o último dado em uma tabela
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['nome']}</td>";
            echo "<td>{$row['cpf']}</td>";
            echo "<td>{$row['creci']}</td>";
            echo "<td><a href='editar.php?id={$row['id']}'>Editar</a> <a href='excluir.php?id={$row['id']}' onclick='return confirm(\"Tem certeza que deseja excluir este registro?\")'>Excluir</a></td>";
            echo "</tr>";
        }
        ?>
    </table>
<?php endif; ?>
</div>
</body>
</html>