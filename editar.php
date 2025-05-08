<?php

$conn = new mysqli("localhost", "root", "", "fabrica");

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

$id_funcionario = null;
$row = [];

if (isset($_GET['id_funcionario'])) {
    $id_funcionario = $_GET['id_funcionario'];
    

    $sql = "SELECT * FROM funcionarios WHERE id_funcionario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_funcionario);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Funcionário não encontrado.";
        exit();
    }
    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['nome_funcionario'], $_POST['id_departamento_fk'])) {
        $nome_funcionario = $_POST['nome_funcionario'];
        $id_departamento_fk = $_POST['id_departamento_fk'];
        
       
        $sql_update = "UPDATE funcionarios SET nome_funcionario = ?, id_departamento_fk = ? WHERE id_funcionario = ?";
        $stmt = $conn->prepare($sql_update);
        $stmt->bind_param("sii", $nome_funcionario, $id_departamento_fk, $id_funcionario);
        
        if ($stmt->execute()) {
            header("Location: tabela.php");
            exit();
        } else {
            echo "Erro ao atualizar funcionário: " . $conn->error;
        }
        $stmt->close();
    }
}

$sql_departamentos = "SELECT id_departamento, nome_departamento FROM departamento";
$result_departamentos = $conn->query($sql_departamentos);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Editar Funcionário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container mt-5">
        <h2>Editar Funcionário</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="nome_funcionario" class="form-label">Nome</label>
                <input type="text" id="nome_funcionario" name="nome_funcionario" class="form-control" value="<?php echo htmlspecialchars($row['nome_funcionario'] ?? ''); ?>" required>
            </div>

            <div class="mb-3">
                <label for="id_departamento_fk" class="form-label">Departamento</label>
                <select id="id_departamento_fk" name="id_departamento_fk" class="form-select" required>
                    <?php
                    if ($result_departamentos->num_rows > 0) {
                        while ($row_departamento = $result_departamentos->fetch_assoc()) {
                            $selected = ($row['id_departamento_fk'] ?? '') == $row_departamento['id_departamento'] ? 'selected' : '';
                            echo "<option value='" . $row_departamento['id_departamento'] . "' $selected>" . htmlspecialchars($row_departamento['nome_departamento']) . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Atualizar</button>
            <a href="tabela.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>