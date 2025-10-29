<?php
// php/citas_agregar.php — Inserta una cita con MySQLi y redirige con alert()
// Requiere la conexión MySQLi centralizada
header('Content-Type: text/html; charset=utf-8');
require_once __DIR__ . '/../conexion/conexion_mysqli.php'; // deja $conectar listo

try {
  // Asegurar tabla (por si es la primera vez)
  $conectar->query("CREATE TABLE IF NOT EXISTS citas (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    cliente VARCHAR(120) NOT NULL,
    telefono VARCHAR(30),
    vehiculo VARCHAR(120),
    placa VARCHAR(32),
    fecha DATE NOT NULL,
    hora TIME NOT NULL,
    servicio VARCHAR(120),
    notas TEXT,
    estado ENUM('Pendiente','Confirmada','Completada','Cancelada') DEFAULT 'Pendiente',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_fecha_hora (fecha,hora),
    INDEX idx_estado (estado),
    INDEX idx_cliente (cliente),
    INDEX idx_placa (placa)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

  // Recoger datos del formulario (POST clásico)
  $cliente  = isset($_POST['cliente'])  ? trim($_POST['cliente'])  : '';
  $telefono = isset($_POST['telefono']) ? trim($_POST['telefono']) : null;
  $vehiculo = isset($_POST['vehiculo']) ? trim($_POST['vehiculo']) : null;
  $placa    = isset($_POST['placa'])    ? trim($_POST['placa'])    : null;
  $fecha    = isset($_POST['fecha'])    ? trim($_POST['fecha'])    : '';
  $hora     = isset($_POST['hora'])     ? trim($_POST['hora'])     : '';
  $servicio = isset($_POST['servicio']) ? trim($_POST['servicio']) : null;
  $notas    = isset($_POST['notas'])    ? trim($_POST['notas'])    : null;
  $estado   = isset($_POST['estado'])   ? trim($_POST['estado'])   : 'Pendiente';

  // Validación mínima
  if ($cliente === '' || $fecha === '' || $hora === '') {
    echo "<script>alert('Cliente, fecha y hora son obligatorios'); location.href='/mecanica/vista%20/citas.html';</script>";
    exit;
  }

  // Limitar longitudes por seguridad (opcional)
  $cliente  = mb_substr($cliente, 0, 120);
  $telefono = $telefono !== null ? mb_substr($telefono, 0, 30) : null;
  $vehiculo = $vehiculo !== null ? mb_substr($vehiculo, 0, 120) : null;
  $placa    = $placa !== null ? mb_substr($placa, 0, 32) : null;
  $servicio = $servicio !== null ? mb_substr($servicio, 0, 120) : null;

  // Insert preparado
  $stmt = $conectar->prepare(
    "INSERT INTO citas (cliente, telefono, vehiculo, placa, fecha, hora, servicio, notas, estado)
     VALUES (?,?,?,?,?,?,?,?,?)"
  );
  // 9 campos tipo string
  $stmt->bind_param('sssssssss', $cliente, $telefono, $vehiculo, $placa, $fecha, $hora, $servicio, $notas, $estado);
  $stmt->execute();

  echo "<script>alert('Cita programada correctamente'); location.href='/mecanica/vista%20/citas.html';</script>";
  exit;

} catch (Throwable $e) {
  // En producción, registra el error a archivo en lugar de mostrarlo
  $msg = addslashes($e->getMessage());
  echo "<script>alert('Error al programar la cita: {$msg}'); location.href='/mecanica/vista%20/citas.html';</script>";
  exit;
}
