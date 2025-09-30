document.addEventListener("DOMContentLoaded", () => {
    const modalEdit = document.getElementById("modal-edit");
    const btnSave = document.getElementById("btnSavePermiso");
    let currentId = null;

    // 🔹 Cerrar modal
    modalEdit.addEventListener("click", (e) => {
        if (e.target === modalEdit) modalEdit.classList.remove("show");
    });
    modalEdit.querySelector(".btn-cancel-edit").addEventListener("click", () => {
        modalEdit.classList.remove("show");
    });

    // 🔹 Cargar combos Empleados y Tipos de Permiso
    async function cargarCombosEdit() {
        try {
            // Empleados
            const empRes = await fetch("../controller/PermisoController.php?action=listarEmpleados");
            const empleados = await empRes.json();
            const selectEmp = document.getElementById("editEmpleado");
            selectEmp.innerHTML = '<option value="">Seleccione</option>';
            empleados.forEach(e => {
                const opt = document.createElement("option");
                opt.value = e.idEmpleado;
                opt.textContent = `${e.nombres} ${e.apellidos}`;
                selectEmp.appendChild(opt);
            });

            // Tipos de permiso
            const tipoRes = await fetch("../controller/PermisoController.php?action=tiposPermiso");
            const tipos = await tipoRes.json();
            const selectTipo = document.getElementById("editTipoPermiso");
            selectTipo.innerHTML = '<option value="">Seleccione</option>';
            tipos.forEach(t => {
                const opt = document.createElement("option");
                opt.value = t.idTipoPermiso;
                opt.textContent = t.tipoPermiso;
                selectTipo.appendChild(opt);
            });

        } catch (err) {
            console.error("Error cargando combos:", err);
        }
    }

    // 🔹 Detectar clic en botones editar
    document.querySelector(".employee-table tbody").addEventListener("click", async (e) => {
        const btn = e.target.closest(".btn-edit");
        if (!btn) return;

        currentId = btn.dataset.id;

        try {
            const res = await fetch(`../controller/PermisoController.php?action=obtenerPermiso&idPermiso=${currentId}`);
            let response = await res.json();

            if (!response.success) {
                Swal.fire("Error", response.error || "No se pudo obtener el permiso", "error");
                return;
            }

            const data = response.data;

            // Primero cargar combos
            await cargarCombosEdit();

            // ✅ Rellenar campos
            document.getElementById("editIdPermiso").value = data.idPermiso;
            document.getElementById("editEmpleado").value = data.idEmpleado || "";
            document.getElementById("editTipoPermiso").value = data.idTipoPermiso || "";
            document.getElementById("editFechaInicio").value = data.fechaInicio ? data.fechaInicio.split(" ")[0] : "";
            document.getElementById("editFechaFin").value = data.fechaFin ? data.fechaFin.split(" ")[0] : "";
            document.getElementById("editEstado").value = data.estado || "Pendiente";
            document.getElementById("editMotivo").value = data.motivo || "";

            // Abrir modal
            modalEdit.classList.add("show");

        } catch (err) {
            console.error("Error al obtener permiso:", err);
            Swal.fire("Error", "No se pudo conectar con el servidor", "error");
        }
    });

    // 🔹 Guardar cambios
    btnSave.addEventListener("click", async () => {
        const data = {
            idPermiso: currentId,
            idEmpleado: document.getElementById("editEmpleado").value,
            idTipoPermiso: document.getElementById("editTipoPermiso").value,
            fechaInicio: document.getElementById("editFechaInicio").value,
            fechaFin: document.getElementById("editFechaFin").value,
            estado: document.getElementById("editEstado").value,
            motivo: document.getElementById("editMotivo").value.trim()
        };

        // Validación
        if (Object.values(data).some(v => v === "")) {
            Swal.fire("Campos vacíos", "Todos los campos son obligatorios", "warning");
            return;
        }

        try {
            const res = await fetch("../controller/PermisoController.php?action=actualizarPermiso", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(data)
            });
            const result = await res.json();

            if (result.success) {
                Swal.fire("Éxito", "Permiso actualizado correctamente", "success");
                modalEdit.classList.remove("show");
                setTimeout(() => location.reload(), 1000);
            } else {
                Swal.fire("Error", result.error || "No se pudo actualizar el permiso", "error");
            }
        } catch (err) {
            console.error("Error actualizando permiso:", err);
            Swal.fire("Error", "No se pudo conectar con el servidor", "error");
        }
    });
});
