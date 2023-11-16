<?php
try {
    // Conectar ao banco de dados SQLite (se o arquivo não existir, ele será criado)
    $db = new PDO('sqlite:diegozerbini.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Criar uma tabela chamada 'usuarios'
    $sql = "CREATE TABLE IF NOT EXISTS corretor (
        id INTEGER PRIMARY KEY,
        nome TEXT NOT NULL,
        cpf INTEGER NOT NULL,
        creci INTEGER NOT NULL
    )";
    $db->exec($sql);
    
    echo "Banco de dados e tabela criados com sucesso!";
    header("Location: index.php");
    exit();
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>