document.addEventListener("DOMContentLoaded", function () {
  const modalEdit = document.getElementById("modalEditContrato");
  const btnClose = modalEdit.querySelector(".btn-cancel-edit");
  const btnActualizar = document.getElementById("btnActualizarContrato");

  // Cerrar modal
  btnClose.addEventListener("click", () => {
    modalEdit.style.display = "none";
  });

  // Guardar cambios
  btnActualizar.addEventListener("click", async () => {
    const data = {
      idContrato: document.getElementById("editIdContrato").value,
      fechaInicio: document.getElementById("editFechaInicio").value,
      fechaFin: document.getElementById("editFechaFin").value,
      idTipoContrato: document.getElementById("editTipoContrato").value,
      idEstadoContrato: document.getElementById("editEstadoContrato").value,
      usuarioMod: 1, // <-- reemplaza con usuario logueado
    };

    if (
      !data.idContrato ||
      !data.fechaInicio ||
      !data.fechaFin ||
      !data.idTipoContrato
    ) {
      Swal.fire("Error", "Completa todos los campos", "error");
      return;
    }

    try {
      const response = await fetch(
        "../controller/ContratoController.php?action=actualizarContrato",
        {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify(data),
        }
      );

      const result = await response.json();

      if (result.success) {
        Swal.fire("Éxito", result.message, "success");
        modalEdit.style.display = "none";
        listarContratos();
      } else {
        Swal.fire("Error", result.error || "No se pudo actualizar", "error");
      }
    } catch (err) {
      Swal.fire("Error", "Hubo un problema en el servidor", "error");
      console.error(err);
    }
  });
});

// Función para abrir modal y precargar datos
async function editarContrato(contrato) {
  const modalEdit = document.getElementById("modalEditContrato");
  modalEdit.style.display = "flex";

  // Precargar datos
  document.getElementById("editIdContrato").value = contrato.idContrato;
  document.getElementById("editFechaInicio").value = contrato.fechaInicio;
  document.getElementById("editFechaFin").value = contrato.fechaFin;

  // Cargar tipos de contrato
  const respTipo = await fetch(
    "../controller/ContratoController.php?action=obtenerTiposContrato"
  );
  const tipos = await respTipo.json();
  const selectTipo = document.getElementById("editTipoContrato");
  selectTipo.innerHTML = "";
  tipos.forEach((tipo) => {
    const selected =
      tipo.idTipoContrato == contrato.idTipoContrato ? "selected" : "";
    selectTipo.innerHTML += `<option value="${tipo.idTipoContrato}" ${selected}>${tipo.descripcion}</option>`;
  });

  // Estado
  document.getElementById("editEstadoContrato").value =
    contrato.idEstadoContrato;
}
