<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestión de Clientes — Servicio Automotriz Flores 🚘</title>
  <link rel="stylesheet" href="../diseño/clientesDiseño.css" />
</head>
<body>
  <!-- ENCABEZADO / NAV -->
  <header class="topbar">
    <div class="topbar__inner">
      <div class="brand">
        <div class="brand__icon">
          <img src="../imagenes/logo.jpeg" alt="Logo Servicio Automotriz Flores" style="width:100%;height:100%;object-fit:cover;border-radius:10px" />
        </div>
        <div class="brand__text">
          <strong class="brand__title">Taller Mecánico</strong>
          <small class="brand__subtitle">Servicio Automotriz Flores</small>
        </div>
      </div>

      <nav class="nav">
        <a class="nav__link" href="index.html">Inicio</a>
        <a class="nav__link" href="clientes.php">Clientes</a>
        <a class="nav__link" href="citas.php">Citas</a>
      </nav>
    </div>
  </header>

  <!-- CONTENIDO PRINCIPAL -->
  <main class="container">
    <section class="header-clientes">
      <div class="header-clientes__text">
        <h3 class="fw-bold">Gestión de Clientes</h3>
        <p class="text-muted">Administra la información de tus clientes</p>
      </div>
      <button class="btn-primary" id="btn-nuevo-cliente">+ Nuevo Cliente</button>
       <!-- Modal para "+ Nuevo Cliente" -->
       <div id="modal-nuevo-cliente" style="display:none;" aria-hidden="true">
         <div class="modal-overlay">
           <div class="modal">
             <!-- Botón cerrar opcional -->
             <button type="button" class="modal-close" aria-label="Cerrar">×</button>
             <h2 class="modal-title">Nuevo Cliente</h2>
             <form class="modal-form" method="POST" action="../controlador/guardar_cliente.php" autocomplete="off">
               <div class="form-group">
                 <label for="telefono">Teléfono</label>
                 <input type="text" id="telefono" name="telefono" required>
               </div>
               <div class="form-group">
                 <label for="email">Email</label>
                 <input type="email" id="email" name="email" required>
               </div>
               <div class="form-group">
                 <label for="vehiculo">Vehículo</label>
                 <input type="text" id="vehiculo" name="vehiculo" required>
               </div>
               <div class="form-group">
                 <label for="placa">Placa</label>
                 <input type="text" id="placa" name="placa" required>
               </div>
               <div class="form-group">
                 <label for="notas">Notas</label>
                 <textarea id="notas" name="notas" rows="3"></textarea>
               </div>
               <div class="modal-actions">
                 <button type="submit" class="modal-button primary">Guardar</button>
                 <button type="button" class="modal-button secondary" id="cancelar-modal-cliente">Cancelar</button>
               </div>
             </form>
           </div>
         </div>
       </div>
    </section>

    <section class="row-superior">
      <div class="seccion-busqueda">
        <div class="card-busqueda">
          <h6>Buscar Clientes</h6>
          <div class="buscador">
            <label>
              <input type="text" class="input-busqueda" placeholder="Buscar por nombre, teléfono o placa...">
            </label>
          </div>
        </div>
      </div>

      <div class="seccion-resumen">
        <div class="card-resumen">
          <h6>Total Clientes</h6>
          <h3>3</h3>
          <p>Registrados</p>
        </div>

        <div class="card-resumen">
          <h6>Clientes Activos</h6>
          <h3 class="activo">2</h3>
          <p>Este mes</p>
        </div>
      </div>
    </section>

    <section class="card-tabla">
      <h6>Lista de Clientes</h6>
      <p class="text-muted">Gestiona la información de todos tus clientes</p>

      <table class="table">
        <thead>
          <tr>
            <th>Cliente</th>
            <th>Contacto</th>
            <th>Vehículo</th>
            <th>Última Visita</th>
            <th>Estado</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <!-- Los registros reales se cargarán aquí dinámicamente -->
        </tbody>
      </table>
    </section>
  </main>

  <!-- PIE DE PÁGINA -->
  <footer class="footer">
    <div class="footer__grid">
      <div class="footer__brand">
        <div class="footer__logo">🔧</div>
        <strong class="footer__title">Mecánica Flores</strong>
        <p class="footer__text">Tu taller de confianza para el cuidado y mantenimiento de tu vehículo.</p>
      </div>

      <div class="footer__col">
        <h4 class="footer__col-title">Servicios</h4>
        <ul class="footer__list">
          <li>Mantenimiento</li>
          <li>Reparaciones</li>
          <li>Diagnóstico</li>
          <li>Afinaciones</li>
        </ul>
      </div>

      <div class="footer__col">
        <h4 class="footer__col-title">Horarios</h4>
        <ul class="footer__list">
          <li>Lun - Vie: 9:00 AM - 6:00 PM</li>
          <li>Sábado: 9:00 AM - 6:00 PM</li>
          <li>Domingo: Cerrado</li>
        </ul>
      </div>

      <div class="footer__col">
        <h4 class="footer__col-title">Contacto</h4>
        <ul class="footer__list">
          <li>+52 (729) 148-7884</li>
          <li>Braandonflo91@gmail.com</li>
          <li>Calle Polotitlán</li>
        </ul>
      </div>
    </div>

    <div class="footer__copy">© 2025 Mecánica Flores. Todos los derechos reservados.</div>
  </footer>
  <script src="../javascrip/clientes.js"></script>
  </body>
</html>