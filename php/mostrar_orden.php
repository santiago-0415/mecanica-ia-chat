<?php
require_once __DIR__ . '/../modelo/orden.php';
$modelo = new OrdenModel();

// Eliminar orden
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    if ($modelo->eliminarOrden($id)) {
        echo "<script>alert('🗑️ Orden eliminada correctamente'); window.location='mostrar_ordenes.php';</script>";
    } else {
        echo "<script>alert('❌ Error al eliminar la orden');</script>";
    }
}

$ordenes = $modelo->obtenerOrdenes();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Órdenes Registradas - Servicio Automotriz Baiter</title>
  <link rel="stylesheet" href="./css/styles.css">
  <style>
    body {
      background: linear-gradient(to bottom right, #eaf2f8, #d6eaf8);
      font-family: 'Segoe UI', sans-serif;
      color: #222;
    }
    .container {
      max-width: 1200px;
      margin: 40px auto;
      background: #fff;
      padding: 20px 30px;
      border-radius: 16px;
      box-shadow: 0 0 15px rgba(0,0,0,0.15);
    }
    h2 {
      text-align: center;
      color: #2c3e50;
      margin-bottom: 25px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 15px;
      border-radius: 12px;
      overflow: hidden;
    }
    th, td {
      border: 1px solid #ddd;
      padding: 10px;
      text-align: center;
    }
    th {
      background-color: #3498db;
      color: #fff;
      font-weight: bold;
      font-size: 14px;
    }
    tr:nth-child(even) {
      background-color: #f8f9f9;
    }
    tr:hover {
      background-color: #f1f8ff;
    }
    .buttons {
      text-align: center;
      margin-top: 25px;
    }
    .btn {
      display: inline-block;
      padding: 10px 15px;
      border-radius: 8px;
      text-decoration: none;
      color: white;
      background-color: #3498db;
      margin: 5px;
      transition: 0.2s;
    }
    .btn:hover {
      background-color: #2176bd;
    }
    .btn-danger {
      background-color: #e74c3c;
    }
    .btn-danger:hover {
      background-color: #c0392b;
    }
    .btn-edit {
      background-color: #f1c40f;
      color: #000;
    }
    .btn-edit:hover {
      background-color: #d4ac0d;
    }
    .btn-green {
      background-color: #2ecc71;
    }
    .btn-green:hover {
      background-color: #27ae60;
    }
  </style>
</head>
<body>

<div class="container">
  <h2>📋 ÓRDENES REGISTRADAS</h2>

  <?php if (!empty($ordenes)): ?>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Fecha</th>
          <th>Hora</th>
          <th>Cliente</th>
          <th>Teléfono</th>
          <th>Marca</th>
          <th>Modelo</th>
          <th>Total</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($ordenes as $orden): ?>
          <tr>
            <td><?= htmlspecialchars($orden['id']) ?></td>
            <td><?= htmlspecialchars($orden['fecha']) ?>
            <td><?= htmlspecialchars($orden['hora']) ?></td>
            <td><?= htmlspecialchars($orden['cliente']) ?></td>
            <td><?= htmlspecialchars($orden['telefono']) ?></td>
            <td><?= htmlspecialchars($orden['marca']) ?></td>
            <td><?= htmlspecialchars($orden['modelo']) ?></td>
            <td>$<?= number_format($orden['suma_total'], 2) ?></td>
            <td>
              <a class="btn btn-edit" href="editar_orden.php?id=<?= $orden['id'] ?>">✏️ Editar</a>
              <a class="btn btn-danger" href="?eliminar=<?= $orden['id'] ?>" onclick="return confirm('¿Seguro que deseas eliminar esta orden?')">🗑️ Eliminar</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p style="text-align:center;">⚠️ No hay órdenes registradas todavía.</p>
  <?php endif; ?>

  <div class="buttons">
    <a href="orden_trabajo.php" class="btn btn-green">⬅️ Volver al Formulario</a>
    <a href="#" onclick="window.print()" class="btn">🖨️ Imprimir</a>
  </div>
</div>

</body>
</html>
