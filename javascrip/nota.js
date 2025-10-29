// ===== Calcular suma total =====
function calcularTotal() {
  const cantidades = document.querySelectorAll(".cantidad");
  const precios = document.querySelectorAll(".precio");
  const totalSpan = document.getElementById("sumaTotal");
  const totalHidden = document.getElementById("totalHidden");

  let total = 0;
  for (let i = 0; i < cantidades.length; i++) {
    const cantidad = parseFloat(cantidades[i].value) || 0;
    const precio = parseFloat(precios[i].value) || 0;
    total += cantidad * precio;
  }
  totalSpan.textContent = total.toFixed(2);
  totalHidden.value = total.toFixed(2);
}

document.querySelectorAll(".cantidad, .precio").forEach(el => {
  el.addEventListener("input", calcularTotal);
});

// ===== Botón Imprimir =====
document.getElementById("printBtn").addEventListener("click", () => {
  window.print();
});

// ===== Enviar por WhatsApp =====
document.getElementById("whatsappBtn").addEventListener("click", () => {
  const cliente = document.getElementById("cliente").value.trim();
  const telefono = document.getElementById("telefono").value.trim();
  const total = document.getElementById("totalHidden").value;

  if (!telefono) {
    alert("Por favor ingresa un número de teléfono válido.");
    return;
  }

  const mensaje = `Hola ${cliente || ''}, su orden de trabajo fue registrada correctamente en Servicio Automotriz Flores. Su total fue de: $${total}`;
  const url = `https://wa.me/52${telefono}?text=${encodeURIComponent(mensaje)}`;
  window.open(url, "_blank");
});
