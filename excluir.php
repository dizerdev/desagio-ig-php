<?php
session_start();
// Verifica se o ID do registro a ser excluído foi fornecido via parâmetro na URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Conexão com o banco de dados (modifique conforme necessário)
        $db = new PDO('sqlite:diegozerbini.db');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Query para excluir o registro com o ID fornecido
        $sql = "DELETE FROM corretor WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $_SESSION['mensagem'] = 'Cadastro excluído com sucesso!';
        
        // Redireciona de volta para a página principal após a exclusão
        header("Location: index.php");
        exit();
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
} else {
    echo "ID não fornecido para exclusão.";
}
?>