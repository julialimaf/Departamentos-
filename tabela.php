<?php   
$servername = "localhost";   
$username = "root";   
$password = "";   
$dbname = "fabrica";   
  
$conn = new mysqli($servername, $username, $password, $dbname);  
  
if ($conn->connect_error) {  
    die("Erro de conexão: " . $conn->connect_error);  
}  


$sql_departamentos = "SELECT id_departamento, nome_departamento FROM departamento";  
$stmt_departamentos = $conn->prepare($sql_departamentos);
$stmt_departamentos->execute();
$result_departamentos = $stmt_departamentos->get_result();  
  
$departamento_filtrado = isset($_GET['id_departamento_fk']) ? $_GET['id_departamento_fk'] : '';  


$sql_funcionarios = "  
    SELECT f.id_funcionario, f.nome_funcionario, f.email, f.cpf, d.nome_departamento  
    FROM funcionarios f  
    INNER JOIN departamento d ON f.id_departamento_fk = d.id_departamento  
";  

if ($departamento_filtrado && $departamento_filtrado !== 'todos') {  
    $sql_funcionarios .= " WHERE f.id_departamento_fk = ?";  
    $stmt_funcionarios = $conn->prepare($sql_funcionarios);
    $stmt_funcionarios->bind_param("i", $departamento_filtrado); 
} else {
    $stmt_funcionarios = $conn->prepare($sql_funcionarios);
}

$stmt_funcionarios->execute();
$result_funcionarios = $stmt_funcionarios->get_result();  
  
$conn->close();  


function ocultarCPF($cpf) {  
    return "***." . substr($cpf, 4, 3) . "***.-**";   
}  
?>
<!DOCTYPE html>
<html lang="pt-BR">  
<head>  
    <meta charset="utf-8">  
    <title>Funcionários Cadastrados</title>  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>  
</head>  
<body>
<a href="Bootstrap.php" class="btn btn-secondary btn-sm">Voltar</a>  

<div class="container mt-5">  
    <h1>Funcionários Cadastrados</h1>  
    <form method="GET" action="">  
        <label for="id_departamento_fk" class="form-label">Departamento</label>  
        <select class="form-control" id="id_departamento_fk" name="id_departamento_fk" required>  
            <option value="">Selecione um departamento</option>  
            <option value="todos" <?php echo $departamento_filtrado == 'todos' ? 'selected' : ''; ?>>Todos</option>  
            <?php  
            while ($row = $result_departamentos->fetch_assoc()) {  
                $selected = $row['id_departamento'] == $departamento_filtrado ? 'selected' : '';  
                echo "<option value='" . $row['id_departamento'] . "' $selected>" . $row['nome_departamento'] . "</option>";  
            }  
            ?>  
        </select>  
        <button type="submit" class="btn btn-primary mt-3">Filtrar</button>  
    </form>  
  
    <table class="table table-striped mt-4">  
        <thead>  
            <tr>  
                <th>Nome</th>  
                <th>Email</th>  
                <th>CPF</th>  
                <th>Departamento</th>  
                <th>Ações</th>  
            </tr>  
        </thead>  
        <tbody>  
            <?php  
            while ($row = $result_funcionarios->fetch_assoc()) {  
                echo "<tr><td>" . htmlspecialchars($row["nome_funcionario"]) . "</td><td>" . htmlspecialchars($row["email"]) . "</td><td>" . ocultarCPF($row['cpf']) . "</td><td>" . htmlspecialchars($row["nome_departamento"]) . "</td>";  
                echo "<td>  
                        <a href='editar.php?id_funcionario=" . $row['id_funcionario'] . "' class='btn btn-warning btn-sm'>Editar</a>  
                        <a href='remover.php?id_funcionario=" . $row['id_funcionario'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Tem certeza que deseja remover este funcionário?\");'>Remover</a>  
                      </td>";  
                echo "</tr>";  
            }  
            ?>  
        </tbody>  
    </table>  
    <a href="gerar_pdf.php?id_departamento_fk=<?php echo $departamento_filtrado; ?>" class="btn btn-success mt-3">Baixar PDF</a>
</div>  
</body>  
</html>