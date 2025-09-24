document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("modalPermiso");
    const btnAdd = document.querySelector(".btn-add");
    const btnCancel = modal.querySelector(".btn-cancel");
    const btnSave = modal.querySelector(".save-step");

    const tipoSelect = document.getElementById("tipo_permiso");
    const motivoSelect = document.getElementById("motivo_permiso");

    // Abrir modal
    btnAdd.addEventListener("click", () => {
        modal.classList.add("show");
        cargarCombos();
    });

    // Cerrar modal
    btnCancel.addEventListener("click", () => {
        modal.classList.remove("show");
    });

    // Guardar permiso
    btnSave.addEventListener("click", () => {
        const data = {
            idEmpleado: document.getElementById("idEmpleado").value,
            idTipoPermiso: tipoSelect.value,
            motivo: motivoSelect.value,
            fechaInicio: document.getElementById("fecha_inicio").value,
            fechaFin: document.getElementById("fecha_fin").value,
            descripcion: document.getElementById("descripcion").value,
            usuario_reg: 1 // TODO: reemplazar con ID de sesión
        };

        fetch("../controllers/PermisoController.php?action=registrar", {
            method: "POST",
            headers: {"Content-Type": "application/json"},
            body: JSON.stringify(data)
        })
        .then(res => res.json())
        .then(res => {
            if (res.success) {
                Swal.fire("Éxito", res.message, "success");
                modal.classList.remove("show");
                document.dispatchEvent(new Event("permisoGuardado"));
            } else {
                Swal.fire("Error", res.error || "No se pudo registrar", "error");
            }
        });
    });

    // Cargar combos desde el backend
    function cargarCombos() {
        fetch("../controllers/PermisoController.php?action=tipos")
            .then(res => res.json())
            .then(data => {
                tipoSelect.innerHTML = `<option value="">Seleccione</option>` +
                    data.map(t => `<option value="${t.idTipoPermiso}">${t.descripcion}</option>`).join("");
            });

        fetch("../controllers/PermisoController.php?action=estados")
            .then(res => res.json())
            .then(data => {
                motivoSelect.innerHTML = `<option value="">Seleccione</option>` +
                    data.map(m => `<option value="${m.idEstadoPermiso}">${m.descripcion}</option>`).join("");
            });
    }
});
