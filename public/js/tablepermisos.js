document.addEventListener("DOMContentLoaded", () => {
    const tbody = document.querySelector(".employee-table tbody");

    async function cargarPermisos() {
        try {
            const res = await fetch("../controller/PermisoController.php?action=listarPermisos");
            const permisos = await res.json();
            tbody.innerHTML = "";

            if (!Array.isArray(permisos) || permisos.length === 0) {
                tbody.innerHTML = `<tr><td colspan="8" style="text-align:center;">No hay permisos registrados</td></tr>`;
                return;
            }

            permisos.forEach(p => {
                const tr = document.createElement("tr");
                tr.innerHTML = `
                    <td>${p.idPermiso}</td>
                    <td>${p.empleado}</td>
                    <td>${p.tipoPermiso}</td>
                    <td>${p.fechaInicio}</td>
                    <td>${p.fechaFin}</td>
                    <td>${p.estado}</td>
                    <td>${p.motivo}</td>
                    <td style="display:flex; gap:5px; justify-content:center;">
                        <button class="btn-edit" data-id="${p.idPermiso}" title="Editar">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn-delete" data-id="${p.idPermiso}" title="Eliminar">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                `;
                tbody.appendChild(tr);
            });

            // ✅ Aquí agregamos los eventos a los botones
            document.querySelectorAll(".btn-edit").forEach(btn => {
                btn.addEventListener("click", () => abrirModalEditar(btn.dataset.id));
            });

            document.querySelectorAll(".btn-delete").forEach(btn => {
                btn.addEventListener("click", () => eliminarPermiso(btn.dataset.id));
            });

        } catch (err) {
            console.error("Error al cargar permisos:", err);
            tbody.innerHTML = `<tr><td colspan="8">Error cargando permisos</td></tr>`;
        }
    }

    async function abrirModalEditar(idPermiso) {
        try {
    const res = await fetch(`../controller/PermisoController.php?action=obtenerPermiso&idPermiso=${currentId}`);
    const data = await res.json();

    if (!data || !data.idPermiso) {
        Swal.fire("Error", "El permiso no existe", "error");
        return;
    }

    // ✅ Rellenar campos del modal
    document.getElementById("editIdPermiso").value = data.idPermiso;
    document.getElementById("editEmpleado").value = data.idEmpleado || "";
    document.getElementById("editTipoPermiso").value = data.idTipoPermiso || "";
    document.getElementById("editFechaInicio").value = data.fechaInicio || "";
    document.getElementById("editFechaFin").value = data.fechaFin || "";
    document.getElementById("editEstado").value = data.estado || "Pendiente";
    document.getElementById("editMotivo").value = data.motivo || "";

    // Mostrar modal
    document.getElementById("modalEditPermiso").classList.add("show");
} catch (err) {
    console.error("Error al obtener permiso:", err);
    Swal.fire("Error", "No se pudo cargar el permiso", "error");
}
    }

    function eliminarPermiso(idPermiso) {
        Swal.fire({
            title: "¿Eliminar permiso?",
            text: "Esta acción no se puede deshacer",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sí, eliminar",
            cancelButtonText: "Cancelar"
        }).then(async (result) => {
            if (result.isConfirmed) {
                try {
                    const res = await fetch("../controller/PermisoController.php?action=eliminarPermiso", {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ idPermiso })
                    });

                    const result = await res.json();
                    if (result.success) {
                        Swal.fire("Eliminado", "El permiso fue eliminado correctamente", "success");
                        cargarPermisos();
                    } else {
                        Swal.fire("Error", result.error || "No se pudo eliminar", "error");
                    }
                } catch (err) {
                    console.error("Error al eliminar:", err);
                }
            }
        });
    }

    cargarPermisos();
});

