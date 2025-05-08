<?php

$conn = new mysqli("localhost", "root", "", "fabrica");

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}


if (isset($_GET['id_funcionario'])) {
    $id_funcionario = $_GET['id_funcionario'];

  
    $sql_delete = "DELETE FROM funcionarios WHERE id_funcionario = $id_funcionario";
    
    if ($conn->query($sql_delete) === TRUE) {
        header("Location: tabela.php");
        exit();
    } else {
        echo "Erro ao remover funcionário: " . $conn->error;
    }
}

$conn->close();
?>
