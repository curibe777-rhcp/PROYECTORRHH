document.addEventListener("DOMContentLoaded", function () {
  const modal = document.getElementById("modalContrato");
  const btnOpen = document.getElementById("btnAddContrato");
  const btnClose = modal.querySelector(".btn-cancel");
  const btnSave = document.getElementById("btnGuardarContrato");

  // Abrir modal
  btnOpen.addEventListener("click", () => {
    modal.style.display = "flex";
    cargarSelectsContrato();
  });

  // Cerrar modal
  btnClose.addEventListener("click", () => {
    modal.style.display = "none";
  });

  // Guardar contrato
  btnSave.addEventListener("click", async () => {
    const data = {
      idEmpleado: document.getElementById("empleado").value,
      fechaInicio: document.getElementById("fechaInicio").value,
      fechaFin: document.getElementById("fechaFin").value,
      idTipoContrato: document.getElementById("tipoContrato").value,
      idEstadoContrato: document.getElementById("estadoContrato").value,
      usuarioReg: 1, // <-- aquí puedes pasar el usuario logueado
    };

    if (
      !data.idEmpleado ||
      !data.fechaInicio ||
      !data.fechaFin ||
      !data.idTipoContrato
    ) {
      Swal.fire("Error", "Completa todos los campos", "error");
      return;
    }

    try {
      const response = await fetch(
        "../controller/ContratoController.php?action=registrarContrato",
        {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify(data),
        }
      );

      const result = await response.json();

      if (result.success) {
        Swal.fire("Éxito", result.message, "success");
        modal.style.display = "none";
        document.getElementById("tbodyContratos").innerHTML = "";
        listarContratos();
      } else {
        Swal.fire("Error", result.error || "No se pudo registrar", "error");
      }
    } catch (err) {
      Swal.fire("Error", "Hubo un problema en el servidor", "error");
      console.error(err);
    }
  });

  // Cargar selects dinámicos
  async function cargarSelectsContrato() {
    // Cargar empleados
    const respEmp = await fetch(
      "../controller/EmpleadoController.php?action=listarEmpleados"
    );
    const empleados = await respEmp.json();
    const selectEmp = document.getElementById("empleado");
    selectEmp.innerHTML = '<option value="">Seleccione</option>';
    empleados.data.forEach((emp) => {
      selectEmp.innerHTML += `<option value="${emp.idEmpleado}">${emp.nombres} ${emp.apellidoPaterno}</option>`;
    });

    // Cargar tipos de contrato
    const respTipo = await fetch(
      "../controller/ContratoController.php?action=obtenerTiposContrato"
    );
    const tipos = await respTipo.json();
    const selectTipo = document.getElementById("tipoContrato");
    selectTipo.innerHTML = '<option value="">Seleccione</option>';
    tipos.forEach((tipo) => {
      selectTipo.innerHTML += `<option value="${tipo.idTipoContrato}">${tipo.descripcion}</option>`;
    });
  }
});
