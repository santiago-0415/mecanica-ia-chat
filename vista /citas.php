<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
  <meta http-equiv="Pragma" content="no-cache" />
  <title>Citas — Servicio Automotriz Flores 🚘</title>
  <link rel="stylesheet" href="../diseño/citasDiseño.css?v=20251026-2" />
  <link rel="icon" href="../imagenes/logo.jpeg" />
</head>
<body>
  <!-- ======= NAV: igual que la otra página ======= -->
  <header class="topbar">
    <div class="topbar__inner">
      <div class="brand">
        <div class="brand__icon">
          <img src="../imagenes/logo.jpeg" alt="Logo Servicio Automotriz Flores" style="width:100%;height:100%;object-fit:cover;border-radius:10px" />
        </div>
        <div class="brand__text">
          <strong class="brand__title">Taller Mecanico</strong>
          <small class="brand__subtitle">Servicio Automotriz Flores</small>
        </div>
      </div>
      <nav class="nav">
        <a class="nav__link" href="index.html">Inicio</a>
        <a class="nav__link" href="clientes.php">Clientes</a>
        <a class="nav__link nav__link--active" href="citas.php">Citas</a>
      </nav>
    </div>
  </header>

  <main class="section" style="padding-top:32px">
    <!-- ======= Encabezado ======= -->
    <div class="section__header">
      <div>
        <h1 class="section__title">Sistema de Citas</h1>
        <p class="section__desc">Gestiona las citas y servicios del taller</p>
      </div>
      <div>
        <button class="btn btn--primary" type="button" data-open-modal="nueva-cita">+ Nueva Cita</button>
      </div>
    </div>

    <!-- ======= Resumen tarjetas ======= -->
    <div class="cards cards--grid-4" style="margin-top:16px">
      <article class="card">
        <h3 style="margin:0 0 .25rem">Citas Hoy</h3>
        <div style="font-size:28px;font-weight:800;color:#0b63ce"><span id="kpi-hoy">0</span></div>
        <p class="contact__muted">Programadas</p>
      </article>
      <article class="card">
        <h3 style="margin:0 0 .25rem">Pendientes</h3>
        <div style="font-size:28px;font-weight:800;color:#d29b00"><span id="kpi-pendientes">0</span></div>
        <p class="contact__muted">Por confirmar</p>
      </article>
      <article class="card">
        <h3 style="margin:0 0 .25rem">Confirmadas</h3>
        <div style="font-size:28px;font-weight:800;color:#2563eb"><span id="kpi-confirmadas">0</span></div>
        <p class="contact__muted">Listas</p>
      </article>
      <article class="card">
        <h3 style="margin:0 0 .25rem">Completadas</h3>
        <div style="font-size:28px;font-weight:800;color:#16a34a"><span id="kpi-completadas">0</span></div>
        <p class="contact__muted">Este mes</p>
      </article>
    </div>

    <!-- ======= Filtros ======= -->
    <section class="card" style="margin-top:20px">
      <h3 style="margin:0 0 .75rem">Filtros</h3>
      <label class="sr-only" for="filtro-citas">Ver</label>
      <select id="filtro-citas" style="max-width:220px">
        <option>Todas las citas</option>
        <option>Pendientes</option>
        <option>Confirmadas</option>
        <option>Completadas</option>
        <option>Canceladas</option>
      </select>
    </section>

    <!-- ======= Lista de Citas ======= -->
    <section class="card" style="margin-top:20px">
      <h3 style="margin:0 0 .25rem">Lista de Citas</h3>
      <p class="contact__muted" style="margin:0 0 1rem">Gestiona todas las citas programadas</p>
      <div class="table-wrapper">
        <table class="table">
          <thead>
            <tr>
              <th>Cliente</th>
              <th>Vehículo</th>
              <th>Fecha y Hora</th>
              <th>Servicio</th>
              <th>Estado</th>
              <th style="text-align:right">Acciones</th>
            </tr>
          </thead>
          <tbody data-citas-tbody></tbody>
        </table>
      </div>
    </section>

    <!-- ======= Modal de Nueva Cita ======= -->
    <section id="modal-nueva-cita" class="modal" hidden aria-hidden="true">
      <div class="modal__backdrop" data-close-modal></div>
      <div class="modal__dialog" role="dialog" aria-modal="true" aria-labelledby="modal-cita-title">
        <button class="modal__close" type="button" title="Cerrar" data-close-modal>×</button>
        <h2 id="modal-cita-title" class="modal__title">Programar Nueva Cita</h2>
        <p class="modal__subtitle">Ingresa los detalles de la cita y el servicio requerido</p>
        <form id="form-cita" class="modal__form" action="../php/agregar_citas.php" method="post" accept-charset="utf-8" autocomplete="off">
          <label><span>Cliente</span><input name="cliente" type="text" placeholder="Nombre completo" required /></label>
          <label><span>Teléfono</span><input name="telefono" type="tel" placeholder="+1 (555) 123-4567" /></label>
          <label><span>Vehículo</span><input name="vehiculo" type="text" placeholder="Marca Modelo Año" /></label>
          <label><span>Placa</span><input name="placa" type="text" placeholder="ABC-123" /></label>
          <label><span>Fecha</span><input name="fecha" type="date" required /></label>
          <label><span>Hora</span><input name="hora" type="time" required /></label>
          <label><span>Tipo de Servicio</span>
            <select name="servicio" required>
              <option value="">Seleccionar servicio</option>
              <option>Mantenimiento Preventivo</option>
              <option>Diagnóstico</option>
              <option>Reparación de Frenos</option>
              <option>Afinación</option>
            </select>
          </label>
          <label class="modal__full"><span>Notas / Descripción del Problema</span><textarea name="notas" rows="3" placeholder="Describe el problema o servicio requerido..."></textarea></label>
          <input type="hidden" name="estado" value="Pendiente">
          <div class="modal__actions">
            <button type="button" class="btn" data-close-modal>Cancelar</button>
            <button type="submit" class="btn btn--primary">Programar Cita</button>
          </div>
        </form>
      </div>
    </section>
  </main>

  <!-- ======= FOOTER (igual al del sitio) ======= -->
  <footer class="footer">
    <div class="footer__grid">
      <div class="footer__brand">
        <div class="footer__logo">🔧</div>
        <strong class="footer__title">Mecanica Flores</strong>
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
    <div class="footer__copy">© 2025 Mecanica Flores. Todos los derechos reservados.</div>
  </footer>

  <script src="../js/citas.js?v=20251026-3"></script>
  <script src="../javascrip/app.js"></script>
</body>
</html>