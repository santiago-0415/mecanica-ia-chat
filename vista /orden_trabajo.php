<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Parte Interno de Trabajo - Servicio Automotriz Baiter</title>
  <link rel="stylesheet" href="../diseño/orden_trabajoDiseño.css">
</head>
<body>
  <div class="container">
    <form id="ordenForm" method="POST" action="../controlador/guardar_orden.php">

      <!-- ENCABEZADO -->
      <div class="header">
        <div class="header-left">
          <!-- IMÁGENES -->
          <div class="logo-circle">
            <img src="../imagenes/logo.jpeg" alt="Logo Servicio Automotriz Baiter">
          </div>
          <div class="contact-info">
            📧 Braandonflo91@gmail.com<br>
            📞 (72) 9128-7884</br>
            📞 (72) 2613-6691 
          </div>
        </div>

        <!-- Línea vertical divisoria -->
        <div class="divider"> </div>

        <div class="header-right">
          <h3>PARTE INTERNO DEL TRABAJO</h3>
          <label>Fecha: <input type="date" name="fecha" id="fecha" required></label>
          <label>Hora: <input type="time" name="hora" id="hora" required></label>
          
          <h4>DATOS DEL CLIENTE</h4>
          <label>Cliente: <input type="text" name="cliente" id="cliente" required maxlength="100"></label>
          <label>Teléfono: <input type="tel" name="telefono" id="telefono" required pattern="[0-9]{10}" maxlength="15"></label>
          <label>Dirección: <input type="text" name="direccion" id="direccion" required maxlength="200"></label>
        </div>
      </div>

      <!-- CUERPO -->
      <div class="main-content">
        <div class="left-side">
          <div class="box">
            <label for="trabajo_solicitado"><b>TRABAJO SOLICITADO:</b></label>
            <textarea name="trabajo_solicitado" id="trabajo_solicitado" maxlength="500"></textarea>
          </div>

          <div class="box">
            <label for="observaciones"><b>OBSERVACIONES:</b></label>
            <textarea name="observaciones" id="observaciones" maxlength="500"></textarea>
          </div>
        </div>

        <div class="right-side">
          <div class="box">
            <label for="trabajos_a_realizar"><b>TRABAJOS A REALIZAR:</b></label>
            <textarea name="trabajos_a_realizar" id="trabajos_a_realizar" maxlength="500"></textarea>
            <div class="vehicle-info">
              <label>Matrícula: <input type="text" name="matricula" id="matricula" maxlength="20"></label>
              <label>Marca: <input type="text" name="marca" id="marca" maxlength="50"></label>
              <label>Modelo: <input type="text" name="modelo" id="modelo" maxlength="50"></label>
              <label>Kilometraje: <input type="number" name="kilometraje" id="kilometraje" min="0" max="999999"></label>
              <label>Entrada al taller: <input type="date" name="entrada_taller" id="entrada_taller"></label>
              <label>Estado del depósito: <input type="text" name="estado_deposito" id="estado_deposito" maxlength="50"></label>
              <label>N° de Bastidor: <input type="text" name="numero_bastidor" id="numero_bastidor" maxlength="30"></label>
            </div>
          </div>
        </div>
      </div>

      <!-- TABLA -->
      <h4 class="table-title">CONCEPTO DE MATERIALES Y MANO DE OBRA</h4>
      <table id="tablaMateriales">
        <thead>
          <tr>
            <th>CONCEPTO</th>
            <th>CANTIDAD</th>
            <th>PRECIO</th>
          </tr>
        </thead>
        <tbody>
          <!-- 10 filas para materiales -->
          <tr>
            <td><input type="text" name="concepto[]" class="concepto" maxlength="100"></td>
            <td><input type="number" name="cantidad[]" class="cantidad" min="0" step="1" value="0"></td>
            <td><input type="number" name="precio[]" class="precio" min="0" step="0.01" value="0.00"></td>
          </tr>
          <tr>
            <td><input type="text" name="concepto[]" class="concepto" maxlength="100"></td>
            <td><input type="number" name="cantidad[]" class="cantidad" min="0" step="1" value="0"></td>
            <td><input type="number" name="precio[]" class="precio" min="0" step="0.01" value="0.00"></td>
          </tr>
          <tr>
            <td><input type="text" name="concepto[]" class="concepto" maxlength="100"></td>
            <td><input type="number" name="cantidad[]" class="cantidad" min="0" step="1" value="0"></td>
            <td><input type="number" name="precio[]" class="precio" min="0" step="0.01" value="0.00"></td>
          </tr>
          <tr>
            <td><input type="text" name="concepto[]" class="concepto" maxlength="100"></td>
            <td><input type="number" name="cantidad[]" class="cantidad" min="0" step="1" value="0"></td>
            <td><input type="number" name="precio[]" class="precio" min="0" step="0.01" value="0.00"></td>
          </tr>
          <tr>
            <td><input type="text" name="concepto[]" class="concepto" maxlength="100"></td>
            <td><input type="number" name="cantidad[]" class="cantidad" min="0" step="1" value="0"></td>
            <td><input type="number" name="precio[]" class="precio" min="0" step="0.01" value="0.00"></td>
          </tr>
          <tr>
            <td><input type="text" name="concepto[]" class="concepto" maxlength="100"></td>
            <td><input type="number" name="cantidad[]" class="cantidad" min="0" step="1" value="0"></td>
            <td><input type="number" name="precio[]" class="precio" min="0" step="0.01" value="0.00"></td>
          </tr>
          <tr>
            <td><input type="text" name="concepto[]" class="concepto" maxlength="100"></td>
            <td><input type="number" name="cantidad[]" class="cantidad" min="0" step="1" value="0"></td>
            <td><input type="number" name="precio[]" class="precio" min="0" step="0.01" value="0.00"></td>
          </tr>
          <tr>
            <td><input type="text" name="concepto[]" class="concepto" maxlength="100"></td>
            <td><input type="number" name="cantidad[]" class="cantidad" min="0" step="1" value="0"></td>
            <td><input type="number" name="precio[]" class="precio" min="0" step="0.01" value="0.00"></td>
          </tr>
          <tr>
            <td><input type="text" name="concepto[]" class="concepto" maxlength="100"></td>
            <td><input type="number" name="cantidad[]" class="cantidad" min="0" step="1" value="0"></td>
            <td><input type="number" name="precio[]" class="precio" min="0" step="0.01" value="0.00"></td>
          </tr>
          <tr>
            <td><input type="text" name="concepto[]" class="concepto" maxlength="100"></td>
            <td><input type="number" name="cantidad[]" class="cantidad" min="0" step="1" value="0"></td>
            <td><input type="number" name="precio[]" class="precio" min="0" step="0.01" value="0.00"></td>
          </tr>
        </tbody>
      </table>

      <div class="total">
        <label><b>SUMA TOTAL:</b> $<span id="sumaTotal">0.00</span></label>
        <input type="hidden" name="suma_total" id="totalHidden" value="0.00">
      </div>

      <!-- FIRMAS -->
      <div class="signatures">
        <div class="firma">
          <img src="../imagenes/firma.png" alt="Firma del prestador del servicio">
          ________________________<br>
          FIRMA DEL PRESTADOR DEL SERVICIO
        </div>
        <div>
          ________________________<br>
          FIRMA CLIENTE
        </div>
      </div>

      <!-- BOTONES -->
      <div class="buttons">
        <button type="submit" class="btn">💾 Guardar</button>
        <button type="button" class="btn" id="printBtn">🖨️ Imprimir</button>
        <button type="button" class="btn" id="whatsappBtn">📱 Enviar por WhatsApp</button>
        <a href="../vista/mostrar_ordenes.php" class="btn">📋 Ver Órdenes</a>
      </div>
    </form>
  </div>

  <script src="../javascrip/nota.js"></script>
</body>
</html>