

// app.js — control básico del modal "+ Nueva Cita"
// Seguro si el modal no existe (otras páginas), no hace nada.
(function(){
  const $  = (s,ctx=document)=>ctx.querySelector(s);
  const $$ = (s,ctx=document)=>Array.from(ctx.querySelectorAll(s));

  function ready(fn){
    if(document.readyState !== 'loading') fn();
    else document.addEventListener('DOMContentLoaded', fn);
  }

  ready(()=>{
    const modal = $('#modal-nueva-cita');
    if(!modal) return; // No hay modal en esta página

    const openers = $$('[data-open-modal="nueva-cita"]');
    const closers = $$('[data-close-modal]');

    const openModal = ()=> modal.removeAttribute('hidden');
    const closeModal = ()=> modal.setAttribute('hidden','');

    // Abrir desde el botón "+ Nueva Cita"
    openers.forEach(btn => btn.addEventListener('click', openModal));

    // Cerrar desde cualquier elemento con data-close-modal
    closers.forEach(btn => btn.addEventListener('click', closeModal));

    // Cerrar al hacer clic fuera del diálogo (backdrop o contenedor externo)
    modal.addEventListener('click', (e)=>{
      if(e.target === modal || e.target.classList.contains('modal__backdrop')) closeModal();
    });

    // Tecla ESC para cerrar
    document.addEventListener('keydown', (e)=>{
      if(e.key === 'Escape' && !modal.hasAttribute('hidden')) closeModal();
    });

    // Exponer helpers por si otra lógica los necesita
    window.appModalCita = { open: openModal, close: closeModal };
  });
})();