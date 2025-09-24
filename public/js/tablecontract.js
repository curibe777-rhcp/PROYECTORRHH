document.addEventListener("DOMContentLoaded", function () {
  listarContratos();
});

async function listarContratos() {
  try {
    const response = await fetch(
      "../controller/ContratoController.php?action=listarContratos"
    );
    const result = await response.json();

    const tbody = document.getElementById("tbodyContratos");
    tbody.innerHTML = "";

    if (result.success && result.data.length > 0) {
      result.data.forEach((contrato) => {
        const tr = document.createElement("tr");

        tr.innerHTML = `
                    <td>${contrato.idContrato}</td>
                    <td>${contrato.nombreEmpleado || contrato.empleado}</td>
                    <td>${contrato.fechaInicio}</td>
                    <td>${contrato.fechaFin}</td>
                    <td>${contrato.tipoContrato}</td>
                    <td>${contrato.estadoContrato}</td>
                    <td>
                        <button class="btn-edit" onclick='editarContrato(${JSON.stringify(
                          contrato
                        )})'>
                            <i class="fa fa-edit"></i>
                        </button>
                        <button class="btn-delete" onclick="cambiarEstadoContrato(${
                          contrato.idContrato
                        })">
                            <i class="fa fa-ban"></i>
                        </button>
                    </td>
                `;

        tbody.appendChild(tr);
      });
    } else {
      tbody.innerHTML = `<tr><td colspan="7">No hay contratos registrados</td></tr>`;
    }
  } catch (err) {
    console.error("Error al listar contratos:", err);
  }
}

// Cambiar estado del contrato
async function cambiarEstadoContrato(idContrato) {
  const { value: estado } = await Swal.fire({
    title: "Cambiar estado",
    input: "select",
    inputOptions: {
      1: "Activo",
      2: "Inactivo",
    },
    inputPlaceholder: "Selecciona un estado",
    showCancelButton: true,
  });

  if (!estado) return;

  try {
    const response = await fetch(
      "../controller/ContratoController.php?action=cambiarEstado",
      {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          idContrato,
          idEstadoContrato: estado,
          usuarioMod: 1,
        }),
      }
    );

    const result = await response.json();
    if (result.success) {
      Swal.fire("Éxito", result.message, "success");
      listarContratos();
    } else {
      Swal.fire("Error", result.error || "No se pudo actualizar", "error");
    }
  } catch (err) {
    Swal.fire("Error", "Hubo un problema en el servidor", "error");
    console.error(err);
  }
}

// Editar contrato → abre modal de edición
function editarContrato(contrato) {
  // Usamos la función de modaleditContrato.js
  window.editarContrato(contrato);
}
