<?php
session_start(); // Inicia a sessão

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Dados do formulário de edição
    $id = $_POST["id"];
    $nome = $_POST["nome"];
    $cpf = $_POST["cpf"];
    $creci = $_POST["creci"];

    try {
        // Conexão com o banco de dados (modifique conforme necessário)
        $db = new PDO('sqlite:diegozerbini.db');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Query para atualizar os dados no banco de dados
        $sql = "UPDATE corretor SET nome = :nome, cpf = :cpf, creci = :creci WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':cpf', $cpf, PDO::PARAM_STR);
        $stmt->bindParam(':creci', $creci, PDO::PARAM_STR);
        $stmt->execute();

        // Defina uma mensagem de sucesso na sessão
        $_SESSION['mensagem'] = 'Cadastro alterado com sucesso!';

        // Redireciona de volta para a página principal após a edição
        header("Location: index.php");
        exit();
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
} else {
    echo "Método de requisição inválido para salvar edição.";
}
?>