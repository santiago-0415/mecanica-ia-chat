document.addEventListener('DOMContentLoaded', function () {
  const modal = document.getElementById('modal-nuevo-cliente');              // contenedor del modal
  const openBtn = document.getElementById('btn-nuevo-cliente');              // botón "+ Nuevo Cliente"
  const cancelBtn = document.getElementById('cancelar-modal-cliente');       // botón "Cancelar"
  const overlay = modal ? (modal.querySelector('.modal-overlay') || document.querySelector('.modal-overlay')) : null; // fondo
  const closeBtn = modal ? modal.querySelector('.modal-close') : null;       // botón "X" (opcional)
  const firstInput = modal ? modal.querySelector('input, textarea, select') : null;

  if (!modal || !openBtn) {
    console.warn('[clientes.js] No se encontró el modal o el botón de apertura.');
    return;
  }

  const openModal = () => {
    // Mostrar modal; usar 'flex' para centrar si el contenedor del modal lo requiere
    modal.style.display = 'flex';
    modal.setAttribute('aria-hidden', 'false');
    // Bloquear scroll de la página al abrir
    document.body.style.overflow = 'hidden';
    // Foco al primer campo
    if (firstInput) {
      setTimeout(() => firstInput.focus(), 10);
    }
  };

  const closeModal = () => {
    modal.style.display = 'none';
    modal.setAttribute('aria-hidden', 'true');
    // Restaurar scroll
    document.body.style.overflow = '';
    // Devolver foco al botón que abrió
    if (openBtn) openBtn.focus();
  };

  // Abrir
  openBtn.addEventListener('click', openModal);

  // Cerrar con "Cancelar"
  if (cancelBtn) cancelBtn.addEventListener('click', closeModal);

  // Cerrar con overlay (solo si el click fue exactamente en el overlay)
  if (overlay) {
    overlay.addEventListener('click', function (e) {
      // Asegúrate que el objetivo sea el overlay, no el contenido
      if (e.target === overlay) closeModal();
    });
  }

  // Cerrar con botón "X" (si existe)
  if (closeBtn) closeBtn.addEventListener('click', closeModal);

  // Cerrar con tecla ESC
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && modal.style.display !== 'none') {
      closeModal();
    }
  });
});
