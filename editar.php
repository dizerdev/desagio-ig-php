<?php
// Verifica se o ID do registro a ser editado foi fornecido via parâmetro na URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Conexão com o banco de dados (modifique conforme necessário)
        $db = new PDO('sqlite:diegozerbini.db');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Query para obter os dados do registro com o ID fornecido
        $sql = "SELECT * FROM corretor WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $registro = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
} else {
    echo "ID não fornecido para edição.";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Registro</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Editar Registro</h1>
<div class="container">
<form method="post" action="salvar_edicao.php">
    <!-- Incluir os campos do formulário preenchidos com os dados do registro -->
    <input type="hidden" name="id" value="<?php echo $registro['id']; ?>">

    <input type="text" name="cpf" minlength="11" maxlength="11" pattern="[0-9]{11}" id="input-cpf" placeholder="Digite seu CPF" value="<?php echo $registro['cpf']; ?>" required>

    <br>

    <input type="text" name="creci" minlength="2" maxlength="6" pattern="[0-9]{6}" id="input-creci" value="<?php echo $registro['creci']; ?>" required>

    <br>

    <input type="text" name="nome" minlength="2" maxlength="50" pattern="[A-Za-zÀ-ú ]+" id="input-nome" value="<?php echo $registro['nome']; ?>" required>
    
    <br>

    <!-- Alterar o botão de enviar para "Salvar" -->
    <input type="submit" class="button" value="Salvar">
</form>
</div>
</body>
</html>