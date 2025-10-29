<?php
require_once __DIR__ . '/../modelo/orden.php';
$modelo = new OrdenModel();

if (!isset($_GET['id'])) die("❌ ID no proporcionado");

$id = intval($_GET['id']);
$orden = $modelo->obtenerOrdenPorId($id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos = [
        'fecha' => $_POST['fecha'],
        'hora' => $_POST['hora'],
        'cliente' => $_POST['cliente'],
        'telefono' => $_POST['telefono'],
        'direccion' => $_POST['direccion'],
        'trabajo_solicitado' => $_POST['trabajo_solicitado'],
        'trabajos_a_realizar' => $_POST['trabajos_a_realizar'],
        'matricula' => $_POST['matricula'],
        'marca' => $_POST['marca'],
        'modelo' => $_POST['modelo'],
        'kilometraje' => $_POST['kilometraje'],
        'entrada_taller' => $_POST['entrada_taller'],
        'estado_deposito' => $_POST['estado_deposito'],
        'numero_bastidor' => $_POST['numero_bastidor'],
        'observaciones' => $_POST['observaciones'],
        'suma_total' => $_POST['suma_total']
    ];

    if ($modelo->actualizarOrden($id, $datos)) {
        echo "<script>alert('✅ Orden actualizada correctamente'); window.location='mostrar_ordenes.php';</script>";
    } else {
        echo "<script>alert('❌ Error al actualizar la orden');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Orden #<?= $orden['id'] ?></title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(to bottom right, #f0f7ff, #dfe9f3);
      margin: 0; padding: 0;
    }
    .container {
      width: 90%;
      max-width: 900px;
      background: #fff;
      margin: 40px auto;
      padding: 30px;
      border-radius: 16px;
      box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }
    h2 {
      text-align: center;
      color: #2c3e50;
      margin-bottom: 20px;
    }
    form label {
      display: block;
      margin-top: 12px;
      font-weight: 600;
    }
    input[type="text"],
    input[type="date"],
    input[type="number"],
    textarea {
      width: 100%;
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 14px;
      margin-top: 4px;
    }
    textarea { resize: vertical; height: 80px; }
    .buttons {
      text-align: center;
      margin-top: 20px;
    }
    .btn {
      display: inline-block;
      padding: 10px 15px;
      margin: 5px;
      background-color: #3498db;
      color: #fff;
      border-radius: 8px;
      text-decoration: none;
      font-weight: bold;
      transition: 0.2s;
      border: none;
      cursor: pointer;
    }
    .btn:hover { background-color: #2176bd; }
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
  <h2>✏️ Editar Orden #<?= htmlspecialchars($orden['id']) ?></h2>

  <form method="POST">
    <label>Fecha: <input type="date" name="fecha" value="<?= $orden['fecha'] ?>"></label>
    <label>Hora: <input type="time" name="hora" value="<?= $orden['hora'] ?>" required></label>
    <label>Cliente: <input type="text" name="cliente" value="<?= htmlspecialchars($orden['cliente']) ?>"></label>
    <label>Teléfono: <input type="text" name="telefono" value="<?= htmlspecialchars($orden['telefono']) ?>"></label>
    <label>Dirección: <input type="text" name="direccion" value="<?= htmlspecialchars($orden['direccion']) ?>"></label>
    <label>Trabajo Solicitado:<textarea name="trabajo_solicitado"><?= htmlspecialchars($orden['trabajo_solicitado']) ?></textarea></label>
    <label>Trabajos a Realizar:<textarea name="trabajos_a_realizar"><?= htmlspecialchars($orden['trabajos_a_realizar']) ?></textarea></label>
    <label>Matrícula: <input type="text" name="matricula" value="<?= htmlspecialchars($orden['matricula']) ?>"></label>
    <label>Marca: <input type="text" name="marca" value="<?= htmlspecialchars($orden['marca']) ?>"></label>
    <label>Modelo: <input type="text" name="modelo" value="<?= htmlspecialchars($orden['modelo']) ?>"></label>
    <label>Kilometraje: <input type="number" name="kilometraje" value="<?= htmlspecialchars($orden['kilometraje']) ?>"></label>
    <label>Entrada Taller: <input type="date" name="entrada_taller" value="<?= htmlspecialchars($orden['entrada_taller']) ?>"></label>
    <label>Estado Depósito: <input type="text" name="estado_deposito" value="<?= htmlspecialchars($orden['estado_deposito']) ?>"></label>
    <label>N° Bastidor: <input type="text" name="numero_bastidor" value="<?= htmlspecialchars($orden['numero_bastidor']) ?>"></label>
    <label>Observaciones:<textarea name="observaciones"><?= htmlspecialchars($orden['observaciones']) ?></textarea></label>
    <label>Suma Total: <input type="number" step="0.01" name="suma_total" value="<?= htmlspecialchars($orden['suma_total']) ?>"></label>

    <div class="buttons">
      <button type="submit" class="btn btn-green">💾 Guardar Cambios</button>
      <a href="mostrar_ordenes.php" class="btn">↩️ Cancelar / Volver</a>
    </div>
  </form>
</div>

</body>
</html>
