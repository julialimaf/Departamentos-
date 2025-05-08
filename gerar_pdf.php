<?php
require('fpdf.php');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fabrica";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}
$conn->set_charset("utf8");

$departamento_filtrado = isset($_GET['id_departamento_fk']) ? $_GET['id_departamento_fk'] : '';

$sql_departamentos = "SELECT id_departamento, nome_departamento FROM departamento";
$result_departamentos = $conn->query($sql_departamentos);
$nome_departamento = 'Todos os Departamentos';

if ($departamento_filtrado && $departamento_filtrado !== 'todos') {
    while ($row = $result_departamentos->fetch_assoc()) {
        if ($row['id_departamento'] == $departamento_filtrado) {
            $nome_departamento = $row['nome_departamento'];
            break;
        }
    }
}
$nome_departamento = mb_convert_encoding($nome_departamento, 'ISO-8859-1', 'UTF-8');

$sql_funcionarios = "
    SELECT f.id_funcionario, f.nome_funcionario, f.email, f.cpf, d.nome_departamento
    FROM funcionarios f
    INNER JOIN departamento d ON f.id_departamento_fk = d.id_departamento
";

if ($departamento_filtrado && $departamento_filtrado !== 'todos') {
    $sql_funcionarios .= " WHERE f.id_departamento_fk = " . (int)$departamento_filtrado;
}

$result_funcionarios = $conn->query($sql_funcionarios);

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(20);
$pdf->SetRightMargin(10);
$pdf->SetAutoPageBreak(TRUE, 20);

$file = 'C:/xampp/htdocs/Departamento/logo.png.png';
if (!file_exists($file)) {
    die('Erro: A imagem não foi encontrada em ' . $file);
}

$pdf->Image($file, 10, 6, 50);
$pdf->Ln(20);

$pdf->SetFont('Arial', '', 18);
$pdf->Cell(0, 10, mb_convert_encoding('JJG', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');


$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 10, mb_convert_encoding('Informatic services inc.', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

$pdf->SetFont('Arial', '', 9);
$pdf->Cell(0, 10, mb_convert_encoding(' CNPJ:58.564.562/0094-58', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
$pdf->Ln(10);

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, mb_convert_encoding('Funcionários Cadastrados', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
$pdf->Ln(10);

$pdf->SetFont('Arial', 'I', 12);
$pdf->Cell(0, 10, 'Filtrado por Departamento: ' . $nome_departamento, 0, 1, 'C');
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(10, 10, 'ID', 1);
$pdf->Cell(50, 10, 'Nome', 1);
$pdf->Cell(60, 10, 'Email', 1);
$pdf->Cell(30, 10, 'CPF', 1);
$pdf->Cell(40, 10, 'Departamento', 1);
$pdf->Ln();

$pdf->SetFont('Arial', '', 10);
if ($result_funcionarios->num_rows > 0) {
    while ($row = $result_funcionarios->fetch_assoc()) {
        $pdf->Cell(10, 10, $row['id_funcionario'], 1);
        $pdf->Cell(50, 10, mb_convert_encoding($row['nome_funcionario'], 'ISO-8859-1', 'UTF-8'), 1);
        $pdf->Cell(60, 10, mb_convert_encoding($row['email'], 'ISO-8859-1', 'UTF-8'), 1);
        $pdf->Cell(30, 10, ocultarCPF($row['cpf']), 1);
        $pdf->Cell(40, 10, mb_convert_encoding($row['nome_departamento'], 'ISO-8859-1', 'UTF-8'), 1);
        $pdf->Ln();
    }
} else {
    $pdf->Cell(0, 10, 'Nenhum funcionario encontrado', 1, 1, 'C');
}

$total_funcionarios = $result_funcionarios->num_rows;
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'Total de empregados: ' . $total_funcionarios, 0, 1, 'C');
$pdf->Ln(5);

$conn->close();

$pdf->Output('D', 'Funcionarios.pdf');

function ocultarCPF($cpf) {
    return "***." . substr($cpf, 4, 3) . ".***-**";
}
?>