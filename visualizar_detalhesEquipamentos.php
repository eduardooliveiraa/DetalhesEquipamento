<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes dos Equipamentos</title>
    <link rel="stylesheet" href="visualizar_detalhes_equipamento.css">
</head>
<body>
    <h1>Detalhes dos Equipamentos</h1>

<?php
function visualizar_detalhesEquipamentos() {
  $conn = new mysqli('localhost', 'root', '', 'erpl');  
  if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
  }

  $sql = "
    SELECT 
        eq.patrimonio, 
        eq.mac, 
        eq.valor_compra, 
        mov.data AS data_movimentacao, 
        mov.motivo, 
        mov.tipo, 
        mov.contraparte, 
        mov.local
    FROM 
        mgt_equipamento AS eq
    LEFT JOIN 
        mgt_movimentacao AS mov ON eq.id = mov.equipamento
    ORDER BY 
        eq.patrimonio, mov.data
  ";

  $result = $conn->query($sql);

  if ($result === false) {
    echo "<p>Erro ao executar a consulta: " . $conn->error . "</p>";
  } else {
    if ($result->num_rows > 0) {
      echo "<table>";
      echo "<tr>
      <th>Patrimônio</th>
      <th>MAC</th>
      <th>Valor de Compra</th>
      <th>Data Movimentação</th>
      <th>Motivo</th>
      <th>Tipo</th>
      <th>Contraparte</th>
      <th>Local</th>
      </tr>";

      while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['patrimonio']) . "</td>";
        echo "<td>" . htmlspecialchars($row['mac']) . "</td>";
        echo "<td>R$ " . number_format($row['valor_compra'], 2, ',', '.') . "</td>";
        echo "<td>" . htmlspecialchars($row['data_movimentacao']) . "</td>";
        echo "<td>" . htmlspecialchars($row['motivo']) . "</td>";
        echo "<td>" . htmlspecialchars($row['tipo']) . "</td>";
        echo "<td>" . htmlspecialchars($row['contraparte']) . "</td>";
        echo "<td>" . htmlspecialchars($row['local']) . "</td>";
        echo "</tr>";
      }

      echo "</table>";
    } else {
      echo "<p>Nenhum equipamento encontrado.</p>";
    }
  }

  $conn->close();
}

Visualizar_detalhesEquipamentos();
?>

</body>
</html>